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
$this->setFrameMode(true);
echo '<script type="text/javascript">console.log(' . json_encode($arParams) . ');</script>';
echo '<script type="text/javascript">console.log(' . json_encode($arResult) . ');</script>';
?>


<?
$arElements = $APPLICATION->IncludeComponent(
	"bitrix:search.page",
	"catalog",
	Array(
		"RESTART" => $arParams["RESTART"],
		"NO_WORD_LOGIC" => $arParams["NO_WORD_LOGIC"],
		"USE_LANGUAGE_GUESS" => $arParams["USE_LANGUAGE_GUESS"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
		"arrFILTER" => array("iblock_".$arParams["IBLOCK_TYPE"]),
		"arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"], 2),
		"USE_TITLE_RANK" => "N",
		"DEFAULT_SORT" => "rank",
		"FILTER_NAME" => "",
		"SHOW_WHERE" => "N",
		"arrWHERE" => array(),
		"SHOW_WHEN" => "N",
		"PAGE_RESULT_COUNT" => 5000,
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "N",
	),
	$component,
	array('HIDE_ICONS' => 'Y')
);
?>

<?
/***********************************/
// Отбираем разделы, в которых найдены товары
$arSelect = array("IBLOCK_SECTION_ID");
$arFilter = array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE"=>"Y", "ID"=>$arElements);
$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$temp = $ob->GetFields();
	$arSectionTrue[] = $temp["IBLOCK_SECTION_ID"];
	$count_sections[] = $temp["IBLOCK_SECTION_ID"];
	
	$nav = CIBlockSection::GetNavChain($arParams['IBLOCK_ID'], $temp["IBLOCK_SECTION_ID"], array("ID"));
	while($arSectionPath = $nav->GetNext()){				
		$arSectionTrue[] = $arSectionPath["ID"];
	}
}
$arSectionTrue= array_map("unserialize", array_unique( array_map("serialize", $arSectionTrue) ));
?>

<?
$rs_Section = CIBlockSection::GetList(
	array('NAME' => 'asc'),
	array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ID"=>$arSectionTrue),
	false,
	array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL')
);
$ar_SectionList = array();
$ar_DepthLavel = array();
while($ar_Section = $rs_Section->GetNext(true, false))
{
	$ar_SectionList[$ar_Section['ID']] = $ar_Section;
	$ar_DepthLavel[] = $ar_Section['DEPTH_LEVEL'];
}

$ar_DepthLavelResult = array_unique($ar_DepthLavel);
rsort($ar_DepthLavelResult);

$i_MaxDepthLevel = $ar_DepthLavelResult[0];

for( $i = $i_MaxDepthLevel; $i > 1; $i-- )
{
	foreach ( $ar_SectionList as $i_SectionID => $ar_Value )
	{
		if( $ar_Value['DEPTH_LEVEL'] == $i )
		{
			$ar_SectionList[$ar_Value['IBLOCK_SECTION_ID']]['SUB_SECTION'][] = $ar_Value;
			unset( $ar_SectionList[$i_SectionID] );
		}
	} 
}
?>

<?
function __recursivRenderMenu($ar_Items)
{
	foreach ($ar_Items as $ar_Value)
	{
		if( count($ar_Value['SUB_SECTION']) > 0  )
		{
			echo '<ul>';
				echo '<li class="item">';
					echo '<a href="'.$_SERVER['REQUEST_URI'].'&section_id='.$ar_Value['ID'].'"><span>';
					echo $ar_Value['NAME'];
					echo '</a></span>';
					echo '<ul>';
						# рекурсивный вызов функции
						echo __recursivRenderMenu($ar_Value['SUB_SECTION']);
					echo '</ul>';
				echo '</li>';
			echo '</ul>';                
		}    
		else
		{
			echo '<li class="item"><a href="'.$_SERVER['REQUEST_URI'].'&section_id='.$ar_Value['ID'].'"><span>'.$ar_Value['NAME'].'</span></a></li>';
		}    
	}    
}
/***********************************/
?>

<?
// Считаем количество товаров
$i = 0;
foreach($arElements as $el){
	if(is_numeric($el)){
		$i++;
	}
}
?>

<h1><?$APPLICATION->ShowTitle(false)?></h1>

<div class="search_text">По запросу <span>«<?=$_GET["q"]?>»</span> найдено <span><?=$i?> товаров</span> в <?=count(array_unique($count_sections))?> категории.</div>


<div class="catalog">
	
	<?
	if (!empty($arElements) && is_array($arElements))
	{
		global $searchFilter;
		$searchFilter = array(
			"=ID" => $arElements,
		);
		?>

		<div class="lf_block">
			<?
			// Выводим разделы
			echo '<ul class="list">';
			__recursivRenderMenu($ar_SectionList);
			echo '</ul>';		
			?>

			<?/* $APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter", 
				"catalog", 
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $_GET["section_id"],
					"SECTION_CODE" => "",
					"SHOW_ALL_WO_SECTION" => "N",
					"FILTER_NAME" => "searchFilter",
					"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
					"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
					"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
					"DISPLAY_ELEMENT_COUNT" => "N",
					"SEF_MODE" => "Y",
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SAVE_IN_SESSION" => "N",
					"INSTANT_RELOAD" => "Y",
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
					"XML_EXPORT" => "N",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "-",
					"POPUP_POSITION" => "left",
					"SECTION_CODE_PATH" => "",
					"SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],
					"CURRENCY_ID" => $arParams["CURRENCY_ID"]
				),
				false
			); */?>
		</div>

		<div class="rt_block">
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
					$show=$arParams["PAGE_ELEMENT_COUNT"];
					if (array_key_exists("show", $_REQUEST))
					{
						if ( intVal($_REQUEST["show"]) && in_array(intVal($_REQUEST["show"]), array(4, 8, 12, 16, 20)) ) {$show=intVal($_REQUEST["show"]); $_SESSION["show"] = $show;}
						elseif ($_SESSION["show"]) {$show=intVal($_SESSION["show"]);}
					}
					//$sort=$arAvailableSort[$sort][0];
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
						<a href="<?=$APPLICATION->GetCurPageParam('display=block', array('display', 'mode'))?>" class="block <?=$display == 'block' ? 'current' : '';?>"><i></i><span><?//=GetMessage("SECT_DISPLAY_LIST")?></span></a>
						<a href="<?=$APPLICATION->GetCurPageParam('display=table', array('display', 'mode'))?>" class="table <?=$display == 'table' ? 'current' : '';?>"><i></i><span><?//=GetMessage("SECT_DISPLAY_TABLE")?></span></a>
					</div>
				<!--/noindex-->
				<div class="clear"></div>
			</div>
					
		
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				$template,
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					//"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
					//"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
					"ELEMENT_SORT_FIELD" => $sort,
					"ELEMENT_SORT_ORDER" => $sort_order,
					"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
					"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
					//"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
					"PAGE_ELEMENT_COUNT" => $show,
					"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
					"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
					"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
					"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
					"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
					"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
					"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
					"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
					"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
					"OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
					"SECTION_URL" => $arParams["SECTION_URL"],
					"DETAIL_URL" => $arParams["DETAIL_URL"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
					"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
					"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
					"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
					"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
					"CURRENCY_ID" => $arParams["CURRENCY_ID"],
					"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
					"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
					"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
					"PAGER_TITLE" => $arParams["PAGER_TITLE"],
					"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
					"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
					"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
					"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
					"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
					"FILTER_NAME" => "searchFilter",
					//"SECTION_ID" => "",
					"SECTION_ID" => $_GET["section_id"],
					"SECTION_CODE" => "",
					"SECTION_USER_FIELDS" => array(),
					"INCLUDE_SUBSECTIONS" => "Y",
					"SHOW_ALL_WO_SECTION" => "Y",
					"META_KEYWORDS" => "",
					"META_DESCRIPTION" => "",
					"BROWSER_TITLE" => "",
					"ADD_SECTIONS_CHAIN" => "N",
					"SET_TITLE" => "N",
					"SET_STATUS_404" => "N",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "N",

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

					'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
					//'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
					'ADD_TO_BASKET_ACTION' => $basketAction,
					'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : ''),
					'COMPARE_PATH' => $arParams['COMPARE_PATH']
				),
				$arResult["THEME_COMPONENT"],
				array('HIDE_ICONS' => 'Y')
			);?>
		
		</div>
		<div class="clear"></div>
	<?
	}
	else
	{
		echo '<p class="padding">'.GetMessage("CT_BCSE_NOT_FOUND").'</p>';
	}
	?>
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