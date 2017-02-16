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
if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? array($arParams['COMMON_ADD_TO_BASKET_ACTION']) : array());
}
else
{
	$basketAction = (isset($arParams['DETAIL_ADD_TO_BASKET_ACTION']) ? $arParams['DETAIL_ADD_TO_BASKET_ACTION'] : array());
}
?>

<?
if($arParams["USE_COMPARE"]=="Y")
{
	?><?$APPLICATION->IncludeComponent(
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
	);?><?
}
?>

<?
if($arParams["IBLOCK_ID"] == 10 || $arParams["IBLOCK_ID"] == 12){
	$template = "catalog";
}
else{
	$template = "arenda";
}

global $arLinkedProducts;
?>

<?$ElementID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.element",
	$template,
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
		"META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
		"SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"CHECK_SECTION_ID_VARIABLE" => (isset($arParams["DETAIL_CHECK_SECTION_ID_VARIABLE"]) ? $arParams["DETAIL_CHECK_SECTION_ID_VARIABLE"] : ''),
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
		//"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
		"USE_PRODUCT_QUANTITY" => "Y",
		"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
		"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
		"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
		"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
		"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],

		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],

		"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
		"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
		'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
		'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],

		'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
		'LABEL_PROP' => $arParams['LABEL_PROP'],
		'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
		'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
		'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
		'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
		'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
		'SHOW_MAX_QUANTITY' => $arParams['DETAIL_SHOW_MAX_QUANTITY'],
		'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
		'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
		'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
		'MESS_BTN_COMPARE' => $arParams['MESS_BTN_COMPARE'],
		'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
		'USE_VOTE_RATING' => $arParams['DETAIL_USE_VOTE_RATING'],
		'VOTE_DISPLAY_AS_RATING' => (isset($arParams['DETAIL_VOTE_DISPLAY_AS_RATING']) ? $arParams['DETAIL_VOTE_DISPLAY_AS_RATING'] : ''),
		'USE_COMMENTS' => $arParams['DETAIL_USE_COMMENTS'],
		'BLOG_USE' => (isset($arParams['DETAIL_BLOG_USE']) ? $arParams['DETAIL_BLOG_USE'] : ''),
		'BLOG_URL' => (isset($arParams['DETAIL_BLOG_URL']) ? $arParams['DETAIL_BLOG_URL'] : ''),
		'BLOG_EMAIL_NOTIFY' => (isset($arParams['DETAIL_BLOG_EMAIL_NOTIFY']) ? $arParams['DETAIL_BLOG_EMAIL_NOTIFY'] : ''),
		'VK_USE' => (isset($arParams['DETAIL_VK_USE']) ? $arParams['DETAIL_VK_USE'] : ''),
		'VK_API_ID' => (isset($arParams['DETAIL_VK_API_ID']) ? $arParams['DETAIL_VK_API_ID'] : 'API_ID'),
		'FB_USE' => (isset($arParams['DETAIL_FB_USE']) ? $arParams['DETAIL_FB_USE'] : ''),
		'FB_APP_ID' => (isset($arParams['DETAIL_FB_APP_ID']) ? $arParams['DETAIL_FB_APP_ID'] : ''),
		'BRAND_USE' => (isset($arParams['DETAIL_BRAND_USE']) ? $arParams['DETAIL_BRAND_USE'] : 'N'),
		'BRAND_PROP_CODE' => (isset($arParams['DETAIL_BRAND_PROP_CODE']) ? $arParams['DETAIL_BRAND_PROP_CODE'] : ''),
		'DISPLAY_NAME' => (isset($arParams['DETAIL_DISPLAY_NAME']) ? $arParams['DETAIL_DISPLAY_NAME'] : ''),
		'ADD_DETAIL_TO_SLIDER' => (isset($arParams['DETAIL_ADD_DETAIL_TO_SLIDER']) ? $arParams['DETAIL_ADD_DETAIL_TO_SLIDER'] : ''),
		'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
		"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
		"DISPLAY_PREVIEW_TEXT_MODE" => (isset($arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE']) ? $arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] : ''),
		"DETAIL_PICTURE_MODE" => (isset($arParams['DETAIL_DETAIL_PICTURE_MODE']) ? $arParams['DETAIL_DETAIL_PICTURE_MODE'] : ''),
		'ADD_TO_BASKET_ACTION' => $basketAction,
		'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
		'DISPLAY_COMPARE' => (isset($arParams['USE_COMPARE']) ? $arParams['USE_COMPARE'] : ''),
		'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
		'SHOW_BASIS_PRICE' => (isset($arParams['DETAIL_SHOW_BASIS_PRICE']) ? $arParams['DETAIL_SHOW_BASIS_PRICE'] : 'Y')
	),
	$component
);?>


<?if($arParams["IBLOCK_ID"] == 10 || $arParams["IBLOCK_ID"] == 12){?>


	<?

	//Поиск рекомендованных товаров делать здесь!
	//id - ElementID
    
	$rec_ar = array();
	$rec = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $ElementID, array("sort" => "asc"), array("CODE" => "RECOMMEND"));
	while ($ob = $rec->GetNext()) {
    //print_r($ob);
        $rec_ar = explode(',',$ob['VALUE']);
    }

    if (count($rec_ar)) {
        //$items = CIBlockElement::GetList(array("SORT"=>"ASC"), array("XML_ID"=>$rec_ar), false, array()); 
        
        /*while($arItem = $items->GetNext()){
            array_push($rec_ar1, $arItem["ID"]);
        } 
        */
        global $recFilter;
        $recFilter = array(
            "XML_ID" => $rec_ar
        );
    }

	$count_rec_ar = count($rec_ar);
	
	if (count($rec_ar) && $rec_ar[0] != ''): ?>
					
				<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "reccommend_products", Array(
					"COMPONENT_TEMPLATE" => ".default",
						"IBLOCK_TYPE" => "1c_catalog",
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SECTION_ID" => "",
						"SECTION_CODE" => "",
						"SECTION_USER_FIELDS" => array(
							0 => "",
							1 => "",
						),
						"ELEMENT_SORT_FIELD" => "sort",
						"ELEMENT_SORT_ORDER" => "asc",
						"ELEMENT_SORT_FIELD2" => "id",
						"ELEMENT_SORT_ORDER2" => "desc",
						"FILTER_NAME" => "recFilter",
						"INCLUDE_SUBSECTIONS" => "Y",
						"SHOW_ALL_WO_SECTION" => "Y",
						"HIDE_NOT_AVAILABLE" => "N",
						"PAGE_ELEMENT_COUNT" => "20",
						"LINE_ELEMENT_COUNT" => "3",
						"PROPERTY_CODE" => array(
							0 => "NEW",
							1 => "",
						),
						"OFFERS_LIMIT" => "5",
						"TEMPLATE_THEME" => "blue",
						"PRODUCT_SUBSCRIPTION" => "N",
						"SHOW_DISCOUNT_PERCENT" => "N",
						"SHOW_OLD_PRICE" => "N",
						"SHOW_CLOSE_POPUP" => "N",
						"MESS_BTN_BUY" => "Купить",
						"MESS_BTN_ADD_TO_BASKET" => "В корзину",
						"MESS_BTN_SUBSCRIBE" => "Подписаться",
						"MESS_BTN_DETAIL" => "Подробнее",
						"MESS_NOT_AVAILABLE" => "Нет в наличии",
						"SECTION_URL" => "",
						"DETAIL_URL" => "",
						"SECTION_ID_VARIABLE" => "SECTION_ID",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"CACHE_TYPE" => "N",
						"CACHE_TIME" => "36000000",
						"CACHE_GROUPS" => "Y",
						"SET_TITLE" => "N",
						"SET_BROWSER_TITLE" => "N",
						"BROWSER_TITLE" => "-",
						"SET_META_KEYWORDS" => "N",
						"META_KEYWORDS" => "-",
						"SET_META_DESCRIPTION" => "N",
						"META_DESCRIPTION" => "-",
						"ADD_SECTIONS_CHAIN" => "N",
						"SET_STATUS_404" => "Y",
						"CACHE_FILTER" => "N",
						"ACTION_VARIABLE" => "action",
						"PRODUCT_ID_VARIABLE" => "id",
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"USE_PRICE_COUNT" => "N",
						"SHOW_PRICE_COUNT" => "1",
						"PRICE_VAT_INCLUDE" => "Y",
						"CONVERT_CURRENCY" => "N",
						"BASKET_URL" => "/basket/",
						"USE_PRODUCT_QUANTITY" => "N",
						"PRODUCT_QUANTITY_VARIABLE" => "",
						"ADD_PROPERTIES_TO_BASKET" => "Y",
						"PRODUCT_PROPS_VARIABLE" => "prop",
						"PARTIAL_PRODUCT_PROPERTIES" => "N",
						"PRODUCT_PROPERTIES" => "",
						"ADD_TO_BASKET_ACTION" => "ADD",
						"DISPLAY_COMPARE" => "Y",
						"PAGER_TEMPLATE" => ".default",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"PAGER_TITLE" => "Товары",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"MESS_BTN_COMPARE" => "Сравнить",
						"ADD_PICT_PROP" => "-",
						"LABEL_PROP" => "-",
						"COMPARE_PATH" => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
					),
					false
				);?>
			
	<? endif; ?>
	
   
	<?
	$similar_items_price = array();
	$arrSortAlown = array('price'=> 'catalog_PRICE_1' , 'name'=> 'NAME');

	$res = CIBlockElement::GetList(
		array("catalog_PRICE_1" => 'ASC'),
		Array(
			"IBLOCK_ID"=>$arParams["IBLOCK_ID"], 
			"ACTIVE"=>"Y", 
			"SECTION_CODE" => $arResult['VARIABLES']['SECTION_CODE'],
		),
		false, 
		array("nPageSize" => "7","nElementID" => $ElementID), 
		array("IBLOCK_ID", "ID", "NAME","DETAIL_PAGE_URL", "CATALOG_GROUP_1")
	);
	$count = 0;
	$similar_items_ids = array();
	while($ob = $res->GetNext()){		
		if($ob['ID'] != $ElementID) {
			$similar_items_ids[] = $ob['ID'];
			//$similar_items_price[$count]['RANK'] = $ob['RANK'];
			//$similar_items_price[$count]['ID'] = $ob['ID'];
			//$similar_items_price[$count]['IBLOCK_ID'] = $ob['IBLOCK_ID'];
			//$similar_items_price[$count]['NAME'] = $ob['NAME'];
			//$similar_items_price[$count]['PRICE'] = $ob['CATALOG_PRICE_1'];
			$count++;
		}
	}
	
	global $similarFilter;
	$similarFilter = array(
		"=ID" => $similar_items_ids
	);

	$count_similar = count($similar_items_ids);
	?>
	
	<?if($count_similar > 0):?>	
		<div class="buy_with_this clearfix">
			<div class="title_block"><div data-kol="<? echo $count_similar; ?>">Близкие по цене товары</div></div>	
			<?if($count_similar > 0 && $count_similar <= 4):?>
				<div class="catalog_block not_carusel">
			<?else:?>
				<div class="flexslider flexslider_run">
			<?endif?>			
				<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "carusel", Array(
					"COMPONENT_TEMPLATE" => ".default",
						"IBLOCK_TYPE" => "1c_catalog",
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SECTION_ID" => "",
						"SECTION_CODE" => "",
						"SECTION_USER_FIELDS" => array(
							0 => "",
							1 => "",
						),
						"ELEMENT_SORT_FIELD" => "sort",
						"ELEMENT_SORT_ORDER" => "asc",
						"ELEMENT_SORT_FIELD2" => "id",
						"ELEMENT_SORT_ORDER2" => "desc",
						"FILTER_NAME" => "similarFilter",
						"INCLUDE_SUBSECTIONS" => "Y",
						"SHOW_ALL_WO_SECTION" => "Y",
						"HIDE_NOT_AVAILABLE" => "N",
						"PAGE_ELEMENT_COUNT" => "20",
						"LINE_ELEMENT_COUNT" => "3",
						"PROPERTY_CODE" => array(
							0 => "NEW",
							1 => "",
						),
						"OFFERS_LIMIT" => "5",
						"TEMPLATE_THEME" => "blue",
						"PRODUCT_SUBSCRIPTION" => "N",
						"SHOW_DISCOUNT_PERCENT" => "N",
						"SHOW_OLD_PRICE" => "N",
						"SHOW_CLOSE_POPUP" => "N",
						"MESS_BTN_BUY" => "Купить",
						"MESS_BTN_ADD_TO_BASKET" => "В корзину",
						"MESS_BTN_SUBSCRIBE" => "Подписаться",
						"MESS_BTN_DETAIL" => "Подробнее",
						"MESS_NOT_AVAILABLE" => "Нет в наличии",
						"SECTION_URL" => "",
						"DETAIL_URL" => "",
						"SECTION_ID_VARIABLE" => "SECTION_ID",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"CACHE_TYPE" => "N",
						"CACHE_TIME" => "36000000",
						"CACHE_GROUPS" => "Y",
						"SET_TITLE" => "N",
						"SET_BROWSER_TITLE" => "N",
						"BROWSER_TITLE" => "-",
						"SET_META_KEYWORDS" => "N",
						"META_KEYWORDS" => "-",
						"SET_META_DESCRIPTION" => "N",
						"META_DESCRIPTION" => "-",
						"ADD_SECTIONS_CHAIN" => "N",
						"SET_STATUS_404" => "Y",
						"CACHE_FILTER" => "N",
						"ACTION_VARIABLE" => "action",
						"PRODUCT_ID_VARIABLE" => "id",
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"USE_PRICE_COUNT" => "N",
						"SHOW_PRICE_COUNT" => "1",
						"PRICE_VAT_INCLUDE" => "Y",
						"CONVERT_CURRENCY" => "N",
						"BASKET_URL" => "/basket/",
						"USE_PRODUCT_QUANTITY" => "N",
						"PRODUCT_QUANTITY_VARIABLE" => "",
						"ADD_PROPERTIES_TO_BASKET" => "Y",
						"PRODUCT_PROPS_VARIABLE" => "prop",
						"PARTIAL_PRODUCT_PROPERTIES" => "N",
						"PRODUCT_PROPERTIES" => "",
						"ADD_TO_BASKET_ACTION" => "ADD",
						"DISPLAY_COMPARE" => "Y",
						"PAGER_TEMPLATE" => ".default",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"PAGER_TITLE" => "Товары",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"MESS_BTN_COMPARE" => "Сравнить",
						"ADD_PICT_PROP" => "-",
						"LABEL_PROP" => "-",
						"COMPARE_PATH" => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
					),
					false
				);?>
			<?if($count_similar > 0 && $count_similar <= 4):?>
				</div>
			<?else:?>
				</div>
				<div class="bottom"></div>
			<?endif?>
		</div>		
	<?endif?>	
	
	
	
	<?/*
	session_start();
	if(!in_array($ElementID, $_SESSION['view_product'])){
		$_SESSION['view_product'][] = $ElementID;
	}
	krsort($_SESSION['view_product']);



	global $recommendFilter;
	$recommendFilter = array(
		"=ID" => $_SESSION['view_product'],
		"!ID" => $ElementID,
	);
	
	$kol = count($_SESSION['view_product'])-1;
	?>
	
	
	<?if($kol > 0){?>
		<div class="buy_with_this clearfix">
			<div class="title_block">
				<div data-kol="<? echo $kol; ?>">Вы недавно смотрели</div>
			</div>
	
			<?
			if($kol > 0 && $kol <= 4)
			{
				?>
				<div class="catalog_block not_carusel">
				<?
			}
			else if($kol >= 5){
				?>
					<div class="flexslider flexslider_run">
				<?
			}
			?>
			
				<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "carusel", Array(
					"COMPONENT_TEMPLATE" => ".default",
						"IBLOCK_TYPE" => "1c_catalog",
						"IBLOCK_ID" => "10",
						"SECTION_ID" => "",
						"SECTION_CODE" => "",
						"SECTION_USER_FIELDS" => array(
							0 => "",
							1 => "",
						),
						"ELEMENT_SORT_FIELD" => "sort",
						"ELEMENT_SORT_ORDER" => "asc",
						"ELEMENT_SORT_FIELD2" => "id",
						"ELEMENT_SORT_ORDER2" => "desc",
						"FILTER_NAME" => "recommendFilter",
						"INCLUDE_SUBSECTIONS" => "Y",
						"SHOW_ALL_WO_SECTION" => "Y",
						"HIDE_NOT_AVAILABLE" => "N",
						"PAGE_ELEMENT_COUNT" => "20",
						"LINE_ELEMENT_COUNT" => "3",
						"PROPERTY_CODE" => array(
							0 => "NEW",
							1 => "",
						),
						"OFFERS_LIMIT" => "5",
						"TEMPLATE_THEME" => "blue",
						"PRODUCT_SUBSCRIPTION" => "N",
						"SHOW_DISCOUNT_PERCENT" => "N",
						"SHOW_OLD_PRICE" => "N",
						"SHOW_CLOSE_POPUP" => "N",
						"MESS_BTN_BUY" => "Купить",
						"MESS_BTN_ADD_TO_BASKET" => "В корзину",
						"MESS_BTN_SUBSCRIBE" => "Подписаться",
						"MESS_BTN_DETAIL" => "Подробнее",
						"MESS_NOT_AVAILABLE" => "Нет в наличии",
						"SECTION_URL" => "",
						"DETAIL_URL" => "",
						"SECTION_ID_VARIABLE" => "SECTION_ID",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"CACHE_TYPE" => "N",
						"CACHE_TIME" => "36000000",
						"CACHE_GROUPS" => "Y",
						"SET_TITLE" => "N",
						"SET_BROWSER_TITLE" => "N",
						"BROWSER_TITLE" => "-",
						"SET_META_KEYWORDS" => "N",
						"META_KEYWORDS" => "-",
						"SET_META_DESCRIPTION" => "N",
						"META_DESCRIPTION" => "-",
						"ADD_SECTIONS_CHAIN" => "N",
						"SET_STATUS_404" => "Y",
						"CACHE_FILTER" => "N",
						"ACTION_VARIABLE" => "action",
						"PRODUCT_ID_VARIABLE" => "id",
						"PRICE_CODE" => $arParams["PRICE_CODE"],
						"USE_PRICE_COUNT" => "N",
						"SHOW_PRICE_COUNT" => "1",
						"PRICE_VAT_INCLUDE" => "Y",
						"CONVERT_CURRENCY" => "N",
						"BASKET_URL" => "/basket/",
						"USE_PRODUCT_QUANTITY" => "N",
						"PRODUCT_QUANTITY_VARIABLE" => "",
						"ADD_PROPERTIES_TO_BASKET" => "Y",
						"PRODUCT_PROPS_VARIABLE" => "prop",
						"PARTIAL_PRODUCT_PROPERTIES" => "N",
						"PRODUCT_PROPERTIES" => "",
						"ADD_TO_BASKET_ACTION" => "ADD",
						"DISPLAY_COMPARE" => "Y",
						"PAGER_TEMPLATE" => ".default",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"PAGER_TITLE" => "Товары",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"MESS_BTN_COMPARE" => "Сравнить",
						"ADD_PICT_PROP" => "-",
						"LABEL_PROP" => "-",
						"COMPARE_PATH" => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
					),
					false
				);?>
				
			<?
			if($kol > 0 && $kol < 4)
			{
				?>
				</div>
				<?
			}
			else if($kol >= 5){
				?>
					</div>
					<div class="bottom"></div>
				
				<?
			}
			?>
		</div>
	<?}*/?>
<?}?>

<?
$GLOBALS["CATALOG_CURRENT_ELEMENT_ID"] = $ElementID;
unset($basketAction);
if ($ElementID > 0)
{
	if($arParams["USE_STORE"] == "Y" && ModuleManager::isModuleInstalled("catalog"))
	{
		?><?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", ".default", array(
			"ELEMENT_ID" => $ElementID,
			"STORE_PATH" => $arParams['STORE_PATH'],
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000",
			"MAIN_TITLE" => $arParams['MAIN_TITLE'],
			"USE_MIN_AMOUNT" =>  $arParams['USE_MIN_AMOUNT'],
			"MIN_AMOUNT" => $arParams['MIN_AMOUNT'],
			"STORES" => $arParams['STORES'],
			"SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
			"SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
			"USER_FIELDS" => $arParams['USER_FIELDS'],
			"FIELDS" => $arParams['FIELDS']
		),
			$component,
			array("HIDE_ICONS" => "Y")
		);?><?
	}
}
?>

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