<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Закладки");

$APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.list",
	"simple",
	array(
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => 12,
		"NAME" => "CATALOG_COMPARE_LIST",
		"DETAIL_URL" => '/catalog/bytovaya/#SECTION_CODE#/#ELEMENT_CODE#/',
		"COMPARE_URL" => '/catalog/bytovaya/compare/',
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		'POSITION_FIXED' => "Y",
		'POSITION' => "top left",
	),
	$component,
	array("HIDE_ICONS" => "Y")
);

$APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.list",
	"simple",
	array(
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => 10,
		"NAME" => "CATALOG_COMPARE_LIST",
		"DETAIL_URL" => '/catalog/inzhenernaya/#SECTION_CODE#/#ELEMENT_CODE#/',
		"COMPARE_URL" => '/catalog/inzhenernaya/compare/',
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		'POSITION_FIXED' => "Y",
		'POSITION' => "top left",
	),
	$component,
	array("HIDE_ICONS" => "Y")
);


echo '<div class="delay_wrap">
<div class="left_text">';

// Отмечаем товары, добавленные в отложенные
$rsBasket = CSaleBasket::GetList(	array( "NAME" => "ASC", "ID" => "ASC"   ),
									array(  "FUSER_ID" => CSaleBasket::GetBasketUserID(),  "LID" => SITE_ID, "ORDER_ID" => "NULL", "SUBSCRIBE" => "N" ),
									false, false, array("ID", "PRODUCT_ID", "QUANTITY", "DELAY") ); 
while( $arBasket = $rsBasket->GetNext() )
{
	if( $arBasket["DELAY"] == "Y" ){ $delay_items[] = $arBasket["PRODUCT_ID"];}
}

if (!empty($delay_items) && is_array($delay_items))
{
	global $delayFilter;
	$delayFilter = array(
		"=ID" => $delay_items,
	);
	
	
	echo '
		<div class="catalog_list catalog_block delay_list">
			<div class="del_all"><a href="#"><span>Удалить закладки</span></a></div>
		';
		?>

		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"delay",
			Array(
				"IBLOCK_TYPE" => "1c_catalog",
				"IBLOCK_ID" => "10",
				"ELEMENT_SORT_FIELD" => "CATALOG_PRICE_1",
				"ELEMENT_SORT_ORDER" => "asc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"PAGE_ELEMENT_COUNT" => "100",
				"LINE_ELEMENT_COUNT" => "4",
				"LIST_PROPERTY_CODE" => array(0=>"SALE",1=>"NEW",2=>"MANUFACTURER",3=>"",),
				"OFFERS_LIMIT" => "5",
				"SECTION_URL" => "",
				"DETAIL_URL" => "",
				"BASKET_URL" => "/basket/",
				"ACTION_VARIABLE" => "action",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRODUCT_QUANTITY_VARIABLE" => "",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"PRICE_CODE" => array("Интернет"),
				"USE_PRICE_COUNT" => "N",
				"SHOW_PRICE_COUNT" => "1",
				"PRICE_VAT_INCLUDE" => "Y",
				"PRODUCT_PROPERTIES" => array(),
				"USE_PRODUCT_QUANTITY" => "N",
				"ADD_PROPERTIES_TO_BASKET" => "Y",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"CONVERT_CURRENCY" => "N",
				"HIDE_NOT_AVAILABLE" => "N",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "bigms",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"ADD_PICT_PROP" => "-",
				"FILTER_NAME" => "delayFilter",
				"SECTION_ID" => "",
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array("",""),
				"INCLUDE_SUBSECTIONS" => "A",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"LABEL_PROP" => "-",
				"SHOW_DISCOUNT_PERCENT" => "Y",
				"SHOW_OLD_PRICE" => "Y",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_COMPARE" => "Сравнение",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"TEMPLATE_THEME" => "blue",
				"COMPONENT_TEMPLATE" => "delay",
				"SHOW_ALL_WO_SECTION" => "Y",
				"PROPERTY_CODE" => array("",""),
				"PRODUCT_SUBSCRIPTION" => "N",
				"SHOW_CLOSE_POPUP" => "N",
				"MESS_BTN_SUBSCRIBE" => "Подписаться",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"BROWSER_TITLE" => "-",
				"SET_META_KEYWORDS" => "N",
				"META_KEYWORDS" => "-",
				"SET_META_DESCRIPTION" => "N",
				"META_DESCRIPTION" => "-",
				"ADD_SECTIONS_CHAIN" => "N",
				"SET_STATUS_404" => "N",
				"ADD_TO_BASKET_ACTION" => "ADD",
				"DISPLAY_COMPARE" => "Y",
				"PAGER_SHOW_ALL" => "N",
				"SEF_MODE" => "N",
				"SET_LAST_MODIFIED" => "N",
				"USE_MAIN_ELEMENT_SECTION" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"SEF_RULE" => "",
				"SECTION_CODE_PATH" => "",
				"COMPARE_PATH" => "/catalog/inzhenernaya/compare/",
			),
		$arResult["THEME_COMPONENT"],
		Array(
			'HIDE_ICONS' => 'Y'
		)
		);?>
		<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"delay",
		Array(
			"IBLOCK_TYPE" => "1c_catalog",
			"IBLOCK_ID" => "12",
			"ELEMENT_SORT_FIELD" => "CATALOG_PRICE_1",
			"ELEMENT_SORT_ORDER" => "asc",
			"ELEMENT_SORT_FIELD2" => "id",
			"ELEMENT_SORT_ORDER2" => "desc",
			"PAGE_ELEMENT_COUNT" => "100",
			"LINE_ELEMENT_COUNT" => "4",
			"LIST_PROPERTY_CODE" => array(0=>"SALE",1=>"NEW",2=>"MANUFACTURER",3=>"",),
			"OFFERS_LIMIT" => "5",
			"SECTION_URL" => "",
			"DETAIL_URL" => "",
			"BASKET_URL" => "/basket/",
			"ACTION_VARIABLE" => "action",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRODUCT_QUANTITY_VARIABLE" => "",
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"PRICE_CODE" => array("Интернет"),
			"USE_PRICE_COUNT" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"PRICE_VAT_INCLUDE" => "Y",
			"PRODUCT_PROPERTIES" => array(),
			"USE_PRODUCT_QUANTITY" => "N",
			"ADD_PROPERTIES_TO_BASKET" => "Y",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"CONVERT_CURRENCY" => "N",
			"HIDE_NOT_AVAILABLE" => "N",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Товары",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => "bigms",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"ADD_PICT_PROP" => "-",
			"FILTER_NAME" => "delayFilter",
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"SECTION_USER_FIELDS" => array("",""),
			"INCLUDE_SUBSECTIONS" => "A",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"LABEL_PROP" => "-",
			"SHOW_DISCOUNT_PERCENT" => "Y",
			"SHOW_OLD_PRICE" => "Y",
			"MESS_BTN_BUY" => "Купить",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",
			"MESS_BTN_COMPARE" => "Сравнение",
			"MESS_BTN_DETAIL" => "Подробнее",
			"MESS_NOT_AVAILABLE" => "Нет в наличии",
			"TEMPLATE_THEME" => "blue",
			"COMPONENT_TEMPLATE" => "delay",
			"SHOW_ALL_WO_SECTION" => "Y",
			"PROPERTY_CODE" => array("",""),
			"PRODUCT_SUBSCRIPTION" => "N",
			"SHOW_CLOSE_POPUP" => "N",
			"MESS_BTN_SUBSCRIBE" => "Подписаться",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"SET_TITLE" => "N",
			"SET_BROWSER_TITLE" => "N",
			"BROWSER_TITLE" => "-",
			"SET_META_KEYWORDS" => "N",
			"META_KEYWORDS" => "-",
			"SET_META_DESCRIPTION" => "N",
			"META_DESCRIPTION" => "-",
			"ADD_SECTIONS_CHAIN" => "N",
			"SET_STATUS_404" => "N",
			"ADD_TO_BASKET_ACTION" => "ADD",
			"DISPLAY_COMPARE" => "Y",
			"PAGER_SHOW_ALL" => "N",
			"SEF_MODE" => "N",
			"SET_LAST_MODIFIED" => "N",
			"USE_MAIN_ELEMENT_SECTION" => "N",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"SHOW_404" => "N",
			"MESSAGE_404" => "",
			"COMPARE_PATH" => "/catalog/inzhenernaya/compare/",
			"VARIABLE_ALIASES" => Array(),
			"VARIABLE_ALIASES" => Array(
			)
		),
	$arResult["THEME_COMPONENT"],
	Array(
		'HIDE_ICONS' => 'Y'
	)
	);?>
<?
}
echo '	<div class="clear"></div>
		</div>
	</div>';

	$APPLICATION->IncludeComponent(
		"bitrix:main.include", 
		".default", 
		array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => "/include/personal_menu.php",
			"EDIT_TEMPLATE" => "standard.php"
		),
		false
	);

echo '<div class="clear"></div>
</div>';

$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/is_delay_compare.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>