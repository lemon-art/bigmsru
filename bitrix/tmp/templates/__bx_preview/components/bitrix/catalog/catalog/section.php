<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);

function getNumEnding($number, $endingArray)
{
    $number = $number % 100;
    if ($number>=11 && $number<=19)
    {
        $ending=$endingArray[2];
    } else  {
        $i = $number % 10;
        switch ($i) {
            case (1): $ending = $endingArray[0]; break;
            case (2): case (3): case (4): $ending = $endingArray[1]; break;
            default: $ending=$endingArray[2]; }
    }
    return $ending;
}

if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
?>

<?
// Узнаем ID текущего раздела
$arFilter = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], 'CODE'=>$arResult["VARIABLES"]["SECTION_CODE"]);
$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true);
$ar_result = $db_list->GetNext();

// Узнаем количество товаров к текущем разделе
$arFilterEl = Array(
	"IBLOCK_ID"=>$arParams["IBLOCK_ID"], 
	"SECTION_ID"=>$ar_result["ID"], 
	"ACTIVE"=>"Y"
);
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilterEl, Array("SECTION_ID"));
$ar_fields = $res->GetNext();
$count = $ar_fields["CNT"];

// Получаем минимальную цену
$res = CIBlockElement::GetList(
    Array("CATALOG_PRICE_1"=>"ASC"),
    Array('SECTION_ID'=>$ar_result["ID"], 'INCLUDE_SUBSECTIONS' => 'Y'),
    false,
    false,
    Array("IBLOCK_ID", "ID", "NAME", "CATALOG_PRICE_1")
);
$ob = $res->Fetch();
$min_price=explode('.',$ob['CATALOG_PRICE_1']);
$min_price=number_format($min_price[0], 0, '', ' ');

// Смотрим, есть ли доп.поле "Показывать фильтр"
$show_section_filter = false;
$res = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'CODE' => $arResult['VARIABLES']['SECTION_CODE']), false, array("UF_SHOW_FILTER"));
$section = $res->Fetch();
if($res->SelectedRowsCount() == 1) {
	if($section['UF_SHOW_FILTER'] == 1) $show_section_filter = true;				
}

// есть ли фильтр
$currentUrl = $APPLICATION->GetCurPageParam();
$seoUrls = array();
if (substr_count($currentUrl, 'filter') > 0 && substr_count($currentUrl, 'apply') > 0) {
    // значит это страница с фильтром
    $url = array();
    $rs = CIBlockElement::GetList(
        array("SORT" => "ASC", "ID" => "ASC"),
        array("NAME" => $APPLICATION->GetCurPage(false), "IBLOCK_CODE" => "kaycom_ONEPLACESEO", 'ACTIVE'=>'Y'),
        false,
        false,//array("nTopCount" => 1),
        array("ID", "PROPERTY_URL_BLOCK_BIND")
    );

	$addNoindex = true;
	while ($el = $rs->GetNext()) {
		$addNoindex = false;
		
		if ( is_null($el['PROPERTY_URL_BLOCK_BIND_VALUE'])){
			continue;
		}
		
		$arSelect = Array('ID', 'IBLOCK_ID', 'NAME');
		$arFilter = Array('IBLOCK_ID'=>20, 'ID'=>$el['PROPERTY_URL_BLOCK_BIND_VALUE'], 'ACTIVE'=>'Y');
		$name = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect)->Fetch()['NAME'];
		$bindProp = CIBlockElement::GetProperty(20, $el['PROPERTY_URL_BLOCK_BIND_VALUE'], array("sort" => "asc"), Array("CODE"=>"URLS"));
		while($bind = $bindProp->GetNext()) {
			$seoUrls[$name][TruncateText($bind['DESCRIPTION'], 24)] = $bind['VALUE'];
		}
		
	}
	
	//
	
	
	if ($addNoindex){
		$APPLICATION->AddViewContent("noindex", '<meta name="robots" content="noindex"/><meta name="googlebot" content="noindex"/>' . "\n");
	}
    /*if ($el = $el->GetNext()) {
        $el['PROPERTY_URL_BLOCK_BIND_VALUE'];
        $bindProp = CIBlockElement::GetProperty(20, $el['PROPERTY_URL_BLOCK_BIND_VALUE'], array("sort" => "asc"), Array("CODE"=>"URLS"));
        while($bind = $bindProp->GetNext()) {
            $urls[$bind['DESCRIPTION']] = $bind['VALUE'];
			echo '<pre style="display: none;">'.print_r($bind, true).'</pre>';
        }
    } else {
        $APPLICATION->AddViewContent("noindex", '<meta name="robots" content="noindex"/>' . "\n");
    }*/
}

$title = '';
if ($ar_result['DEPTH_LEVEL'] == 3) {

    // вытягиваем имя родителя
    $arFilter = Array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'ID' => $ar_result["IBLOCK_SECTION_ID"]);
    $db_list_parent = CIBlockSection::GetList(Array($by => $order), $arFilter, true);
    $ar_result_parent = $db_list_parent->GetNext();
    $title = $ar_result_parent['NAME'] . ' ' . $ar_result['NAME'];

    ?>
    <h1><?= $title; ?></h1>
    <?php
} else {
    ?>
    <h1><? $APPLICATION->ShowTitle(false) ?></h1>
    <?php
}
?>

<div class="catalog">
	<div class="lf_block">
	
		<?
		if ($arParams['USE_FILTER'] == 'Y')
		{
			$arFilter = array(
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"ACTIVE" => "Y",
				"GLOBAL_ACTIVE" => "Y",
			);
			if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
			{
				$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
			}
			elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
			{
				$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
			}

			$obCache = new CPHPCache();
			if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
			{
				$arCurSection = $obCache->GetVars();
			}
			elseif ($obCache->StartDataCache())
			{
				$arCurSection = array();
				if (Loader::includeModule("iblock"))
				{
					$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

					if(defined("BX_COMP_MANAGED_CACHE"))
					{
						global $CACHE_MANAGER;
						$CACHE_MANAGER->StartTagCache("/iblock/catalog");

						if ($arCurSection = $dbRes->Fetch())
						{
							$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
						}
						$CACHE_MANAGER->EndTagCache();
					}
					else
					{
						if(!$arCurSection = $dbRes->Fetch())
							$arCurSection = array();
					}
				}
				$obCache->EndDataCache($arCurSection);
			}
			if (!isset($arCurSection))
			{
				$arCurSection = array();
			}
			?>
			<? $APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"catalog",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $arCurSection['ID'],
					"DISPLAY_ELEMENT_COUNT" => "N",
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					//"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TYPE" => "N",
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SAVE_IN_SESSION" => "N",
					"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
					"XML_EXPORT" => "Y",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
					"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					'SEF_MODE' => $arParams['SEF_MODE'],
					'SEF_RULE' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['smart_filter'],
					'SMART_FILTER_PATH' => $arResult['VARIABLES']['SMART_FILTER_PATH']
				),
				$component,
				array('HIDE_ICONS' => 'Y')
			); ?>
		<?
		}
		?>
	</div>

	<div class="rt_block">
	
		<?
			
		
		/*if($count > 0 || $show_section_filter == true){
		
		
		global $USER;
			if ($USER->IsAdmin()){
				//echo($count);
				//echo(111111111111);
			}
		
		
		
		
		
		?>

			<?if(true //$arResult["VARIABLES"]["SECTION_ID"] == 29 || $arResult["VARIABLES"]["SECTION_ID"] == 30 || $arResult["VARIABLES"]["SECTION_CODE"] == "inzhenernaya" || $arResult["VARIABLES"]["SECTION_CODE"] == "bytovaya"
			)
			{
				// Устанавливаем заголовок страницы
				$res = CIBlockSection::GetByID($arResult["VARIABLES"]["SECTION_ID"]);
				if($ar_res = $res->GetNext()){
					$APPLICATION->SetTitle($ar_res['NAME']);
				}
				
	
				
				
				?>
			
				<div class="sections_block">
					<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.section.list",
						"sections_all",
						array(
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
							"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
							"SECTION_USER_FIELDS" => array(	// Свойства разделов
								0 => "UF_ICON",
								1 => "UF_SHOWSUBCAT",
                                2 => ""
							),
							"SHOW_ALL" => "1",
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
							"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
							"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
							"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
							"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
							"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
							"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
						),
						$component,
						array("HIDE_ICONS" => "Y")
					);?>
				</div>
			<?}?>
		<?
		}else{*/
		
		
			
			$arFilter = Array('IBLOCK_ID' => $arParams['IBLOCK_ID'],'CODE' => $arResult["VARIABLES"]["SECTION_CODE"], 'GLOBAL_ACTIVE'=>'Y'); 
			$db_list = CIBlockSection::GetList(Array(), $arFilter, false, Array("UF_CUSTOM_URL")); 
			if($uf_value = $db_list->GetNext()): 
				$custom_url = $uf_value["UF_CUSTOM_URL"];
			endif;
			if($custom_url != ""){
				header("HTTP/1.1 301 Moved Permanently"); 
				header("Location: http://www.bigms.ru".$custom_url); 
				exit(); 
			}

		
		?>
	
			<div class="catalog_with_icon">
				<?$APPLICATION->SetTitle($ar_result['NAME']);?>

				<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.section.list",
					"catalog_with_icon",
					array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
						"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                        "SECTION_USER_FIELDS" => array(    // Свойства разделов
                                    0 => "UF_SHOWSUBCAT",
                                    1 => "UF_PICTURE",
                                    2 => "UF_CUSTOM_URL",
                                    3 => "UF_ACTIVE"
                                ),
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
						"TOP_DEPTH" => 1,
						"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
						"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
						"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
						"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
						"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
					),
					$component,
					array("HIDE_ICONS" => "Y")
				);?>
			</div>

		<?//}?>
		
		<?if($count > 0){?>
			<div class="hidden">
				<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.section.list",
					"catalog",
					array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
						"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
						"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
						"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
						"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
						"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
						"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
						"ADD_SECTIONS_CHAIN" => "N"
					),
					$component,
					array("HIDE_ICONS" => "Y")
				);?>
			</div>
		<?}?>
	

		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.compare.list",
			"simple",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"NAME" => $arParams["COMPARE_NAME"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
				"COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				'POSITION_FIXED' => isset($arParams['COMPARE_POSITION_FIXED']) ? $arParams['COMPARE_POSITION_FIXED'] : '',
				'POSITION' => isset($arParams['COMPARE_POSITION']) ? $arParams['COMPARE_POSITION'] : ''
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?>
		

		<?
		if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
		{
			$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
		}
		else
		{
			$basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
		}
		$intSectionID = 0;
		?>
		
		<? //из catalog.smart.filter/catalog ?>
        <?$APPLICATION->ShowViewContent('smart_filter_block');?>
		
		<div class="sort_header">
			<!--noindex-->
				<?
				if (array_key_exists("display", $_REQUEST) || (array_key_exists("display", $_SESSION)) || $arParams["DEFAULT_LIST_TEMPLATE"])
				{
					if ($_REQUEST["display"]&&((trim($_REQUEST["display"])=="block")||(trim($_REQUEST["display"])=="table"))) 
					{$display=trim($_REQUEST["display"]);  $_SESSION["display"]=trim($_REQUEST["display"]);}
					elseif ($_SESSION["display"]&&(($_SESSION["display"]=="block")||($_SESSION["display"]=="table"))) 
					{$display=$_SESSION["display"];}
					else {$display=$arParams["DEFAULT_LIST_TEMPLATE"];}
				} 
				else { 
					$display = "block"; 
				}
				$template = "catalog_".$display;
				?>
				
				<div class="sort_filter">
					<div class="sort_plice">
						<a class="button_middle CATALOG_PRICE_1 <?if($_REQUEST["sort"] == "CATALOG_PRICE_1" && $_REQUEST["order"] == "asc"){echo 'current';}?>" href="<?=$APPLICATION->GetCurPageParam('sort=CATALOG_PRICE_1&order=asc', array('sort', 'order', 'mode'))?>" rel="nofollow">
							<span>сначала дешевые</span>
						</a>
						<a class="button_middle CATALOG_PRICE_1 <?if($_REQUEST["sort"] == "CATALOG_PRICE_1" && $_REQUEST["order"] == "desc"){echo 'current';}?>" href="<?=$APPLICATION->GetCurPageParam('sort=CATALOG_PRICE_1&order=desc', array('sort', 'order', 'mode'))?>" rel="nofollow">
							<span>сначала  дорогие</span>
						</a>
					</div>
					
					<?	
					$basePrice = CCatalogGroup::GetBaseGroup();
					$priceSort = "CATALOG_PRICE_".$basePrice["ID"];
					$arAvailableSort = array(
						"POPULARITY" => array("SHOW_COUNTER", "desc"),
						"PROPERTY_NOVINKA_VALUE" => array("PROPERTY_NOVINKA_VALUE", "desc"),
						"PROPERTY_RASPRODAZHA_VALUE" => array("PROPERTY_RASPRODAZHA_VALUE", "desc"),
					);
					
					if ((array_key_exists("sort", $_REQUEST) && array_key_exists(ToUpper($_REQUEST["sort"]), $arAvailableSort)) || (array_key_exists("sort", $_SESSION) && array_key_exists(ToUpper($_SESSION["sort"]), $arAvailableSort)) || $arParams["ELEMENT_SORT_FIELD"])
					{
						if ($_REQUEST["sort"]) {$sort=ToUpper($_REQUEST["sort"]);  $_SESSION["sort"]=ToUpper($_REQUEST["sort"]);}
						elseif ($_SESSION["sort"]) {$sort=ToUpper($_SESSION["sort"]);}
						else {$sort=ToUpper($arParams["ELEMENT_SORT_FIELD"]);}
					}
					
					
					if ((array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ) || (array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ) || $arParams["ELEMENT_SORT_ORDER"])
					{
						if ($_REQUEST["order"]) {$sort_order=$_REQUEST["order"]; $_SESSION["order"]=$_REQUEST["order"];}
						elseif ($_SESSION["order"]) {$sort_order=$_SESSION["order"];}
						else {$sort_order=ToLower($arParams["ELEMENT_SORT_ORDER"]);}
					}

					
					foreach ($arAvailableSort as $key => $val)
					{
						if($key == 'SORT'){
							$newSort = $sort_order == 'desc' ? 'asc' : 'desc';
						}
						else{
							$newSort = $sort_order == 'desc' ? 'asc' : 'desc';
						}?>
						<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order', 'mode'))?>" class="button_middle <?=$sort == $key ? 'current' : ''?> <?=ToLower($sort_order)?> <?=$key?>" rel="nofollow">
							<span><?=GetMessage('SECT_SORT_'.$key)?></span>
							<i></i>
						</a>
					<?
					}
					?>
				</div>

				<?

				//чтобы не сохранял сортировку
				unset($_SESSION['sort']);
				unset($_SESSION['order']);

				?>

				<?
				$show=$arParams["PAGE_ELEMENT_COUNT"];
				if (array_key_exists("show", $_REQUEST))
				{
					if ( intVal($_REQUEST["show"]) && in_array(intVal($_REQUEST["show"]), array(20, 40, 60, 80, 100)) ) {$show=intVal($_REQUEST["show"]); $_SESSION["show"] = $show;}
					elseif ($_SESSION["show"]) {$show=intVal($_SESSION["show"]);}
				}
				?>
				<div class="number_list">
					<div class="title">Показать по:</div>
					
					<select class="select" name="str" onchange="redirect_str(this.value);">
						<?for( $i = 20; $i <= 100; $i+=20 ){?>
							<option value="<?=$APPLICATION->GetCurPageParam('show='.$i, array("show"))?>" <?if($i == $show){echo 'selected="selected"';}?>><?=$i?></option>
						<?}?>
					</select>
				</div>
				
				<div class="sort_display">
					<div class="title">Вид:</div>
					<a href="<?=$APPLICATION->GetCurPageParam('display=block', array('display', 'mode'))?>" class="block <?=$display == 'block' ? 'current' : '';?>"><i></i></a>
					<a href="<?=$APPLICATION->GetCurPageParam('display=table', array('display', 'mode'))?>" class="table <?=$display == 'table' ? 'current' : '';?>"><i></i></a>
				</div>
			<!--/noindex-->
			<div class="clear"></div>
		</div>


		<?php if(isset($_COOKIE['test'])){
			//die($component);
		}
		
		/*global $USER;
		if ($USER->IsAdmin()){

			$name_com = "custom";
			

		}else{
			$name_com = "custom";
		}*/
		 
		?>

		<?$intSectionID = $APPLICATION->IncludeComponent(
			"custom:catalog.section",
			$template,
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				//"ELEMENT_SORT_FIELD" => "CATALOG_QUANTITY",
				"ELEMENT_SORT_FIELD" => $sort,
				"ELEMENT_SORT_ORDER" => $sort_order,
				"ELEMENT_SORT_FIELD2" => "CATALOG_AVAILABLE",
				//"ELEMENT_SORT_FIELD" => "CATALOG_QUANTITY",
				//"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
				"ELEMENT_SORT_ORDER2" => $sort_order,
				"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
				"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
				"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
				"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
				"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
				"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_FILTER" => $arParams["CACHE_FILTER"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"SET_TITLE" => $arParams["SET_TITLE"],
				"SET_STATUS_404" => $arParams["SET_STATUS_404"],
				"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
				"PAGE_ELEMENT_COUNT" => $show,
				"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"USE_PRODUCT_QUANTITY" => "Y",
				"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
				"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
				"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

				"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
				"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
				"PAGER_TITLE" => $arParams["PAGER_TITLE"],
				"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
				"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
				"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
				"PAGER_DESC_NUMBERING_CACHE_TIME" => 0,
				"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

				"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
				"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
				"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
				"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
				"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
				"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
				"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
				"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

				'LABEL_PROP' => $arParams['LABEL_PROP'],
				'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
				'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

				'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
				'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
				'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
				'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
				'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
				'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
				'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
				'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
				'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
				'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

				'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
				"ADD_SECTIONS_CHAIN" => ($show_section_filter == true) ? "Y" : "N",
				'ADD_TO_BASKET_ACTION' => $basketAction,
				'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
				'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
				"USE_MAIN_ELEMENT_SECTION" => "Y"
			),
			//$component
			null
		);?>
		<div class="number_list bottom">
			<div class="title">Показать по:</div>
			
			<select class="select" name="str" onchange="redirect_str(this.value);">
				<?for( $i = 20; $i <= 100; $i+=20 ){?>
					<option value="<?=$APPLICATION->GetCurPageParam('show='.$i, array("show"))?>" <?if($i == $show){echo 'selected="selected"';}?>><?=$i?></option>
				<?}?>
			</select>
		</div>	

        <?php
        $APPLICATION->ShowViewContent('seotext');
        ?>
        <? if (count($seoUrls)>0) : ?>
        <div class="url_block">
			<?foreach($seoUrls as $name => $urls):?>
				<?=$name?>
				<ul>
					<?foreach($urls as $text => $url):?>
						<li><a href="<?=$url?>"><?=$text?></a></li>
					<?endforeach;?>
				</ul>
			<?endforeach;?>
        </div>
        <? endif; ?>
		
	</div>

	<div class="clear"></div>

</div>


<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/is_delay_compare.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);?>


<?
global $APPLICATION;

$canonical = $_SERVER["SERVER_NAME"].''.$APPLICATION->GetCurPageParam("", array_keys($_GET), false);

if(isset($_GET['PAGEN_1'])) {
    $APPLICATION->SetPageProperty('title', $ar_result['NAME']. ' - страница '.$_GET['PAGEN_1']);
    $APPLICATION->SetPageProperty('description', $ar_result['NAME']. ' - страница '.$_GET['PAGEN_1']);
    $APPLICATION->SetPageProperty('keywords', $ar_result['NAME']. ' - страница '.$_GET['PAGEN_1']);
} elseif ($ar_result['DEPTH_LEVEL'] == 3) {
    $APPLICATION->SetPageProperty('title', $title.' - купить по выгодной цене в Москве');
    $APPLICATION->SetPageProperty('description', $title.' - '. $ar_result['ELEMENT_CNT'] .' '. getNumEnding($ar_result['ELEMENT_CNT'], Array('товар', 'товара', 'товаров')). ' от '.$min_price.' рублей. Быстрая доставка по Москве, опытный консультант в интернет-магазине.');
    $APPLICATION->SetPageProperty('keywords', $title. ' купить, '. $title. 'цена, '. $title. 'фото, '. $title. 'в Москве, '. $title. 'стоимость');
} else {
    $APPLICATION->SetPageProperty('title', $ar_result['NAME'].' - купить по выгодной цене в Москве');
    $APPLICATION->SetPageProperty('description', $ar_result['NAME'].' - '. $ar_result['ELEMENT_CNT'] .' '. getNumEnding($ar_result['ELEMENT_CNT'], Array('товар', 'товара', 'товаров')). ' от '.$min_price.' рублей. Быстрая доставка по Москве, опытный консультант в интернет-магазине.');
    $APPLICATION->SetPageProperty('keywords', $ar_result['NAME']. ' купить, '. $ar_result['NAME']. ' цена, '. $ar_result['NAME']. ' фото, '. $ar_result['NAME']. ' в Москве, '. $ar_result['NAME']. ' стоимость');
}

$APPLICATION->AddHeadString('<link href="http://'.$canonical.'" rel="canonical" />',true);
?>