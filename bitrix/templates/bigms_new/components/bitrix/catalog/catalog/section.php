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


//Устанавливаем нужные классы для header
$this->SetViewTarget("content__wrap");
echo "content__wrap_catalog";
$this->EndViewTarget("content__wrap");

$this->SetViewTarget("row_div_class");
echo "col-lg-22 col-lg-offset-1 col-md-22 col-md-offset-1 col-sm-22 col-sm-offset-1 content__container content__container_catalog";
$this->EndViewTarget("row_div_class");



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

//открываем файл с массивом соответствия адресов страниц
$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt");
$arUrlData = unserialize( $data );

//если фильтр
if ( $_REQUEST["SECTION_CODE"] ){
	$arResult["VARIABLES"]["SECTION_CODE"] = $_REQUEST["SECTION_CODE"];
}

if ( $arResult["VARIABLES"]["SECTION_CODE"] == 'truby_i_fitingi' ){
	$arResult["VARIABLES"]["SECTION_CODE"] = 'truby';
}

$currentUrl = $APPLICATION->GetCurPageParam();
$curPage = $APPLICATION->GetCurPage(false);


			if ( $arUrlData[$curPage] && !substr_count($curPage, 'price') ){
				//если есть короткое соответсвие то переходим на него
				header("HTTPS/1.1 301 Moved Permanently"); 
				header("Location: ".$arUrlData[$curPage]); 
				exit(); 
			}

			$arFilter = Array('IBLOCK_ID' => $arParams['IBLOCK_ID'],'CODE' => $arResult["VARIABLES"]["SECTION_CODE"], 'GLOBAL_ACTIVE'=>'Y'); 
			$db_list = CIBlockSection::GetList(Array(), $arFilter, false, Array("UF_CUSTOM_URL")); 
			if($uf_value = $db_list->GetNext()): 
				$custom_url = $uf_value["UF_CUSTOM_URL"];
			endif;
			
			if ( $arUrlData[$custom_url] ){
				$custom_url = $arUrlData[$custom_url];
			}

			if($custom_url != ""){
				header("HTTPS/1.1 301 Moved Permanently"); 
				header("Location: ".$custom_url); 
				exit(); 
			}


// есть ли фильтр

$seoUrls = array();
if ((substr_count($currentUrl, 'filter') > 0 && substr_count($currentUrl, 'apply') > 0) || $_REQUEST['set_filter']) {
    // значит это страница с фильтром
	
	$nameUrl = array_search($APPLICATION->GetCurPage(false), $arUrlData);
	if ( !$nameUrl ){
		$nameUrl = $APPLICATION->GetCurPage(false);
	}
	
    $url = array();
    $rs = CIBlockElement::GetList(
        array("SORT" => "ASC", "ID" => "ASC"),
        array("NAME" => $nameUrl, "IBLOCK_CODE" => "kaycom_ONEPLACESEO", 'ACTIVE'=>'Y'),
        false,
        false,//array("nTopCount" => 1),
        array("ID", "PROPERTY_URL_BLOCK_BIND", "DETAIL_TEXT")
    );

	$addNoindex = true;
	while ($el = $rs->GetNext()) {
		$addNoindex = false;
		
		if ( is_null($el['PROPERTY_URL_BLOCK_BIND_VALUE'])){
			continue;
		}
		
		
		
		$SEO_TEXT = $el['DETAIL_TEXT'];

		
		
		$arSelect = Array('ID', 'IBLOCK_ID', 'NAME');
		$arFilter = Array('IBLOCK_ID'=>20, 'ID'=>$el['PROPERTY_URL_BLOCK_BIND_VALUE'], 'ACTIVE'=>'Y');
		$name = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect)->Fetch()['NAME'];
		$bindProp = CIBlockElement::GetProperty(20, $el['PROPERTY_URL_BLOCK_BIND_VALUE'], array("sort" => "asc"), Array("CODE"=>"URLS"));
		while($bind = $bindProp->GetNext()) {
			$url = str_replace("https://www.bigms.ru", "", $bind['VALUE']);
			if ( $arUrlData[$url] && !substr_count($url, 'price')){
				$url = $arUrlData[$url];
			}
			$seoUrls[$name][TruncateText($bind['DESCRIPTION'], 24)] = $url;
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




// Узнаем ID текущего раздела
$arFilter = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], 'CODE'=>$arResult["VARIABLES"]["SECTION_CODE"]);
$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true, Array('IBLOCK_ID', 'ID', 'NAME', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID', 'ELEMENT_CNT'));
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
    Array('SECTION_ID'=>$ar_result["ID"], 'INCLUDE_SUBSECTIONS' => 'Y', '!CATALOG_PRICE_1' => false),
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



$title = '';
if ($ar_result['DEPTH_LEVEL'] == 4 && !array_search($APPLICATION->GetCurPage(false), $arUrlData)) {

	\Bitrix\Iblock\Component\Tools::process404(
			trim($arParams["MESSAGE_404"]) ?: GetMessage("CATALOG_ELEMENT_NOT_FOUND")
			,true
			,$arParams["SET_STATUS_404"] === "Y"
			,$arParams["SHOW_404"] === "Y"
			,$arParams["FILE_404"]
		);
	
    /*
	//вытягиваем имя родителя
    $arFilter = Array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'ID' => $ar_result["IBLOCK_SECTION_ID"]);
    $db_list_parent = CIBlockSection::GetList(Array($by => $order), $arFilter, true, Array("NAME"));
    $ar_result_parent = $db_list_parent->GetNext();
    $title = $ar_result_parent['NAME'] . ' ' . $ar_result['NAME'];

    ?>
    <h1><?= $title; ?></h1>
    <?*/
	
} else {
    ?>
    <h1 class="title-h1"><? $APPLICATION->ShowTitle(false) ?></h1>
    <?php
}
?>


				<?$APPLICATION->SetTitle($ar_result['NAME']);?>

				<?
				$APPLICATION->IncludeComponent(
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
				
				<!--noindex-->
				<?

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
					<?$this->SetViewTarget("right_area");?>
					<? $APPLICATION->IncludeComponent(
							"custom:catalog.smart.filter",
							"catalog",
							array(
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"SECTION_ID" => $arCurSection['ID'],
								"DISPLAY_ELEMENT_COUNT" => "N",
								"FILTER_NAME" => $arParams["FILTER_NAME"],
								"PRICE_CODE" => $arParams["PRICE_CODE"],
								//"CACHE_TYPE" => $arParams["CACHE_TYPE"],
								"CACHE_TYPE" => "Y",
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
						<?$this->EndViewTarget("right_area");?>
				
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
				
					if ( $arParams["IBLOCK_ID"] == 12 ){
						$display = "block"; 
					}
					else {
						$display = "block"; 
					}
				}
				$template = "catalog_".$display;
				?>
				
				<?
				$show=$arParams["PAGE_ELEMENT_COUNT"];
				if (array_key_exists("show", $_REQUEST))
				{
					if ( intVal($_REQUEST["show"]) && in_array(intVal($_REQUEST["show"]), array(20, 40, 60, 80, 100)) ) {$show=intVal($_REQUEST["show"]); $_SESSION["show"] = $show;}
					elseif ($_SESSION["show"]) {$show=intVal($_SESSION["show"]);}
				}
				?>

				
		<section class="content-products">
			    <div class="content-products__header">
                  <ul class="sort">
                    <li class="sort__item sort__item_title">Сортировка:</li>
                    <li class="sort__item">
						<?if($_REQUEST["sort"] == "CATALOG_PRICE_1" && $_REQUEST["order"] == "asc"):?>
							от дешевых
						<?else:?>
							<a class="sort__link" href="<?=$APPLICATION->GetCurPageParam('sort=CATALOG_PRICE_1&order=asc', array('sort', 'order', 'mode'))?>" rel="nofollow">от дешевых</a>
						<?endif;?>
					</li>
                    <li class="sort__item">
						<?if($_REQUEST["sort"] == "CATALOG_PRICE_1" && $_REQUEST["order"] == "desc"):?>
							от дорогих
						<?else:?>
							<a class="sort__link" href="<?=$APPLICATION->GetCurPageParam('sort=CATALOG_PRICE_1&order=desc', array('sort', 'order', 'mode'))?>" rel="nofollow">от дорогих</a>
						<?endif;?>
					</li>
					<li class="sort__item">
						<?if($_REQUEST["sort"] == "POPULARITY" && $_REQUEST["order"] == "asc"):?>
							по популярности
						<?else:?>
							<a class="sort__link" href="<?=$APPLICATION->GetCurPageParam('sort=POPULARITY&order=asc', array('sort', 'order', 'mode'))?>" rel="nofollow">по популярности</a>
						<?endif;?>
					</li>
                  </ul>
                  <ul class="toggle-view">
                    <li class="toggle-view__item <?=$display == 'table' ? 'active' : '';?>" data-view="list">
						<a href="<?=$APPLICATION->GetCurPageParam('display=table', array('display', 'mode'))?>">
						  <svg class="toggle-view__icon-img">
							<use xlink:href="#icon-list"></use>
						  </svg>
						</a>
                    </li>
                    <li class="toggle-view__item <?=$display == 'block' ? 'active' : '';?>" data-view="tile">
						<a href="<?=$APPLICATION->GetCurPageParam('display=block', array('display', 'mode'))?>">
						  <svg class="toggle-view__icon-img">
							<use xlink:href="#icon-tile"></use>
						  </svg>
						</a>
                    </li>
                  </ul>
                </div>
				
				
				<?	
					$basePrice = CCatalogGroup::GetBaseGroup();
					$priceSort = "CATALOG_PRICE_".$basePrice["ID"];
					$arAvailableSort = array(
						"POPULARITY" => array("SHOW_COUNTER", "desc"),
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
					?>

				<?

				//чтобы не сохранял сортировку
				unset($_SESSION['sort']);
				unset($_SESSION['order']);

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
		</section>
		<section class="content-promo">
            <div class="container-fluid">
				<?if($_REQUEST["PAGEN_1"] == "" && (in_array("filter", explode("/", $APPLICATION->GetCurPage())) != 1)):?>
					<section class="content-promo">
						<div class="container-fluid">
							<div class="seo_text">
								<?$APPLICATION->ShowViewContent('seotext');?>
							</div>
						</div>
					</section>
				<?elseif($SEO_TEXT):?>
					<section class="content-promo">
						<div class="container-fluid">
							<div class="seo_text">
								<?=$SEO_TEXT?>
							</div>
						</div>
					</section>
				<?endif;?>
				
				<? if (count($seoUrls)>0) : ?>
					<div class="row">
						<div class="col-lg-30 col-md-30 col-sm-30">
							<div class="labels">
								<strong class="labels__title">Метки</strong>
									<?foreach($seoUrls as $name => $urls):?>
										<ul class="labels__list">
											<li class="labels__item labels__item_title"><?=$name?>:</li>
											<?foreach($urls as $text => $url):?>
												<li class="labels__item"><a href="<?=$url?>"><?=$text?></a></li>
											<?endforeach;?>
										</ul>
									<?endforeach;?>
							</div>
						</div>
					</div>
				<? endif; ?>
			
			</div>
		</section>
		
		</div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 content__filter">
            <?$APPLICATION->ShowViewContent("right_area")?>
		</div>		
					
	


		
		
	






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

$APPLICATION->AddHeadString('<link href="https://'.$canonical.'" rel="canonical" />',true);
?>


