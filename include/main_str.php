<div class="slider_block">
	<div class="flexslider_main">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"slider",
			Array(
				"COMPONENT_TEMPLATE" => ".default",
				"IBLOCK_TYPE" => "content",
				"IBLOCK_ID" => "6",
				"NEWS_COUNT" => "20",
				"SORT_BY1" => "SORT",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "ID",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "",
				"FIELD_CODE" => array(0=>"",1=>"",),
				"PROPERTY_CODE" => array(0=>"",1=>"",),
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_STATUS_404" => "Y",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"INCLUDE_SUBSECTIONS" => "N",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"PAGER_TEMPLATE" => "modern",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Новости",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N"
			)
		);?>
	</div>
	<div class="clear"></div>
</div>

<?$GLOBALS['arrFilterSale'] = array("PROPERTY_RASPRODAZHA_VALUE"=>"Да");?>
<?$GLOBALS['arrFilterNew'] = array("PROPERTY_NOVINKA_VALUE"=>"Да");?>

<!-- <div class="carusel_block tabs main_carusel_block">
	<div class="title_block">
		<div class="title_tab">Новинки</div>
		<div class="select_block">
			<div class="selectesem">
				<div data-val="first_cat1" class="item active">Инженерная сантехника</div>
				<div data-val="first_cat2" class="item">Бытовая сантехника</div>
			</div>			
		</div>
		
		<a href="/catalog/inzhenernaya/new/" class="link tab2"><span>все предложения</span></a>
		<a href="/catalog/bytovaya/new/" class="link hidden tab4"><span>все предложения</span></a>
	</div>
	
	<div class="flexslider tab_content_main" id="first_cat1">
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
				"FILTER_NAME" => "arrFilterNew",
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
				"SHOW_CLOSE_POPUP" => "Y",
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
				"CACHE_TYPE" => "A",
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
				"PRICE_CODE" => array(
					0 => "Интернет",
				),
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
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"MESS_BTN_COMPARE" => "В сравнение",
				"ADD_PICT_PROP" => "-",
				"LABEL_PROP" => "-",
				"COMPARE_PATH" => "/catalog/inzhenernaya/compare/",
			),
			false
		);?>
	</div>
	<div class="flexslider tab_content_main" id="first_cat2">
		<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "carusel", Array(
			"COMPONENT_TEMPLATE" => ".default",
				"IBLOCK_TYPE" => "1c_catalog",
				"IBLOCK_ID" => "12",
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
				"FILTER_NAME" => "arrFilterNew",
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
				"SHOW_CLOSE_POPUP" => "Y",
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
				"CACHE_TYPE" => "A",
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
				"PRICE_CODE" => array(
					0 => "Интернет",
				),
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
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"MESS_BTN_COMPARE" => "В сравнение",
				"ADD_PICT_PROP" => "-",
				"LABEL_PROP" => "-",
				"COMPARE_PATH" => "/catalog/bytovaya/compare/",
			),
			false
		);?>
	</div>		
</div> -->

<!-- <div class="carusel_block tabs main_carusel_block second_carusel_block">
	<div class="title_block">
		<div class="title_tab">Специальные предложения</div>
		<div class="select_block">
			<div class="selectesem">
				<div data-val="second_cat1" class="item active">Инженерная сантехника</div>
				<div data-val="second_cat2" class="item">Бытовая сантехника</div>
			</div>			
		</div>
		
		<a href="/catalog/inzhenernaya/actions/" class="link tab1"><span>все предложения</span></a>
		<a href="/catalog/bytovaya/actions/" class="link hidden tab3"><span>все предложения</span></a>
	</div>	
	
	<div class="flexslider tab_content_main" id="second_cat1">
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
				"FILTER_NAME" => "arrFilterSale",
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
				"SHOW_CLOSE_POPUP" => "Y",
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
				"CACHE_TYPE" => "A",
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
				"PRICE_CODE" => array(
					0 => "Интернет",
				),
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
				"MESS_BTN_COMPARE" => "В сравнение",
				"ADD_PICT_PROP" => "-",
				"LABEL_PROP" => "-",
				"COMPARE_PATH" => "/catalog/inzhenernaya/compare/",
			),
			false
		);?>
	</div>	
	<div class="flexslider tab_content_main" id="second_cat2">
		<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "carusel", Array(
			"COMPONENT_TEMPLATE" => ".default",
				"IBLOCK_TYPE" => "1c_catalog",
				"IBLOCK_ID" => "12",
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
				"FILTER_NAME" => "arrFilterSale",
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
				"SHOW_CLOSE_POPUP" => "Y",
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
				"CACHE_TYPE" => "A",
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
				"PRICE_CODE" => array(
					0 => "Интернет",
				),
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
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"MESS_BTN_COMPARE" => "В сравнение",
				"ADD_PICT_PROP" => "-",
				"LABEL_PROP" => "-",
				"COMPARE_PATH" => "/catalog/bytovaya/compare/",
			),
			false
		);?>
	</div>
</div> -->

<?/*
<div class="carusel_block tabs carusel_catalog">
	<div class="title_block">
		<ul class="tabNavigation">
			<li><a data-name="cat1" data-tab="tab1" class="" href="#first_cat1">Новинки</a></li>
			<li><a data-name="cat1" data-tab="tab2" class="" href="#second_cat1">Специальные предложения</a></li>
			<li><a data-name="cat2" data-tab="tab3" class="hidden" href="#first_cat2">Новинки</a></li>
			<li><a data-name="cat2" data-tab="tab4" class="hidden" href="#second_cat2">Специальные предложения</a></li>
		</ul>
		
		<div class="select_block">
			<select class="select" name="tabs" onchange="catalog_active(this.value, 'first');">
				<option value="cat1">Инженерная сантехника</option>
				<option value="cat2">Бытовая сантехника</option>
			</select>			
		</div>
		
		<a href="/catalog/inzhenernaya/actions/" class="link tab1"><span>все предложения</span></a>
		<a href="/catalog/inzhenernaya/new/" class="link hidden tab2"><span>все предложения</span></a>
		<a href="/catalog/bytovaya/actions/" class="link hidden tab3"><span>все предложения</span></a>
		<a href="/catalog/bytovaya/new/" class="link hidden tab4"><span>все предложения</span></a>
	</div>
	
	<?$APPLICATION->IncludeComponent(
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
	);?>
	
	<?$APPLICATION->IncludeComponent(
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
	);?>
	
	<div class="flexslider tab_content" id="first_cat1">
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
				"FILTER_NAME" => "arrFilterNew",
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
				"SHOW_CLOSE_POPUP" => "Y",
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
				"CACHE_TYPE" => "A",
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
				"PRICE_CODE" => array(
					0 => "Интернет",
				),
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
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"MESS_BTN_COMPARE" => "В сравнение",
				"ADD_PICT_PROP" => "-",
				"LABEL_PROP" => "-",
				"COMPARE_PATH" => "/catalog/inzhenernaya/compare/",
			),
			false
		);?>
	</div>
	<div class="flexslider tab_content" id="second_cat1">
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
				"FILTER_NAME" => "arrFilterSale",
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
				"SHOW_CLOSE_POPUP" => "Y",
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
				"CACHE_TYPE" => "A",
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
				"PRICE_CODE" => array(
					0 => "Интернет",
				),
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
				"MESS_BTN_COMPARE" => "В сравнение",
				"ADD_PICT_PROP" => "-",
				"LABEL_PROP" => "-",
				"COMPARE_PATH" => "/catalog/inzhenernaya/compare/",
			),
			false
		);?>
	</div>
	
	<div class="flexslider tab_content" id="first_cat2">
		<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "carusel", Array(
			"COMPONENT_TEMPLATE" => ".default",
				"IBLOCK_TYPE" => "1c_catalog",
				"IBLOCK_ID" => "12",
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
				"FILTER_NAME" => "arrFilterNew",
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
				"SHOW_CLOSE_POPUP" => "Y",
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
				"CACHE_TYPE" => "A",
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
				"PRICE_CODE" => array(
					0 => "Интернет",
				),
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
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"MESS_BTN_COMPARE" => "В сравнение",
				"ADD_PICT_PROP" => "-",
				"LABEL_PROP" => "-",
				"COMPARE_PATH" => "/catalog/bytovaya/compare/",
			),
			false
		);?>
	</div>
	<div class="flexslider tab_content" id="second_cat2">
		<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "carusel", Array(
			"COMPONENT_TEMPLATE" => ".default",
				"IBLOCK_TYPE" => "1c_catalog",
				"IBLOCK_ID" => "12",
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
				"FILTER_NAME" => "arrFilterSale",
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
				"SHOW_CLOSE_POPUP" => "Y",
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
				"CACHE_TYPE" => "A",
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
				"PRICE_CODE" => array(
					0 => "Интернет",
				),
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
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"MESS_BTN_COMPARE" => "В сравнение",
				"ADD_PICT_PROP" => "-",
				"LABEL_PROP" => "-",
				"COMPARE_PATH" => "/catalog/bytovaya/compare/",
			),
			false
		);?>
	</div>
</div>
*/?>


<div class="sections_block block sections_block_main">
	<div class="title_block">
		<div class="title">Каталог продукции</div>
		
		<?/*
		<div class="select_block">
			<select class="select no_style" name="tabs" onchange="catalog_active_open(this.value);">
				<option value="cat1">Инженерная сантехника</option>
				<option value="cat2">Бытовая сантехника</option>
			</select>
		</div>
		*/?>
		
		<div class="selectesem">
			<div class="item active" data-val="cat1" onclick="catalog_active_open_ss(this.getAttribute('data-val'))">Инженерная сантехника</div>
			<div class="item" data-val="cat2" onclick="catalog_active_open_ss(this.getAttribute('data-val'))">Бытовая сантехника</div>
			<!-- <div data-val="first_cat1" class="item active">Инженерная сантехника</div>
			<div data-val="first_cat2" class="item">Бытовая сантехника</div> -->
		</div>
		
		<div class="clear"></div>
	</div>

	<div>
		<div class="tab tab1 cat1">
		<?/*$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"sections", 
	Array(
		"COMPONENT_TEMPLATE" => "sections",
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => "10",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "N",
		"TOP_DEPTH" => "2",
		"SECTION_FIELDS" => array(0 => "", 1 => ""),
		"SECTION_USER_FIELDS" => array(0 => "UF_ICON",1 => "UF_PICTURE",2 => "UF_CUSTOM_URL", 3 => "UF_ACTIVE"),
		"VIEW_MODE" => "LINE",
		"SHOW_PARENT_NAME" => "Y",
		"SECTION_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
	),
	false
);*/?>
		
		</div>
		<div class="tab tab2 cat2 hidden">
		<?/*$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"sections", 
	Array(
		"COMPONENT_TEMPLATE" => "sections",
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => "12",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "N",
		"TOP_DEPTH" => "2",
		"SECTION_FIELDS" => array(0=>"",1=>"",),
		"SECTION_USER_FIELDS" => array(0=>"UF_ICON",1 => "UF_PICTURE",2 => "UF_CUSTOM_URL", 3 => "UF_ACTIVE"),
		"VIEW_MODE" => "LINE",
		"SHOW_PARENT_NAME" => "Y",
		"SECTION_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ADD_SECTIONS_CHAIN" => "Y"
	)
);*/?>
		
		</div>
	</div>
</div>


<div class="carusel_block tabs carusel_brend">
	<div class="title_block">
		<ul class="tabNavigation">
			<li><a data-name="cat1" class="" href="#brend_cat1">производители</a></li>
			<!-- <li><a data-name="cat2" class="hidden" href="#brend_cat2">производители</a></li> -->
		</ul>
		
		<?/*<div class="select_block">
			<select class="select no_style" name="tabs" onchange="catalog_active(this.value, 'brend');">
				<option value="cat1">Инженерная сантехника</option>
				<option value="cat2">Бытовая сантехника</option>
			</select>
		</div>*/?>
		
		
		<div class="selectesem">
			<!--div class="item active" data-val="cat1" onclick="catalog_active_ss(this.getAttribute('data-val'), 'brend')">Инженерная сантехника</div>
			<div class="item" data-val="cat2" onclick="catalog_active_ss(this.getAttribute('data-val'), 'brend')">Бытовая сантехника</div-->
			<div class="item item-brand-1 active" data-val="cat1" onclick="catalog_active_ss(this.getAttribute('data-val'), 'brend', 'item-brand-1')">Инженерная сантехника</div>
			<div class="item item-brand-2" data-val="cat2" onclick="catalog_active_ss(this.getAttribute('data-val'), 'brend', 'item-brand-2')">Бытовая сантехника</div>
		</div>		
		
		
		<a data-name="cat1" href="/proizvoditeli/inzhenernaya/" class="link tab1"><span>все предложения</span></a>
		<a data-name="cat2" href="/proizvoditeli/bytovaya/" class="link hidden tab2"><span>все предложения</span></a>
		
	</div>				
	
	<div class="flexslider tab_content" id="brend_cat1">
		<ul class="carusel slides">
			<?/*
			////////////////////////////////////////////////
			CModule::IncludeModule("highloadblock");
			
			use Bitrix\Highloadblock as HL;
			use Bitrix\Main\Entity;
			
			$hlblock_id = 2;
			///////////////////////////////////////////////

			$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch(); 
			$entity = HL\HighloadBlockTable::compileEntity($hlblock);
			
			$entity_data_class = $entity->getDataClass();
			$entity_table_name = $hlblock['TABLE_NAME'];
			
			$arFilter = array(); //задаете фильтр по вашим полям
			
			$sTableID = 'tbl_'.$entity_table_name;
			$rsData = $entity_data_class::getList(array(
				"select" => array('UF_XML_ID', 'UF_NAME', 'UF_FILE'), //выбираем поля
				"filter" => $arFilter,
				"order" => array()
			));
			$rsData = new CDBResult($rsData, $sTableID);
			while($arRes = $rsData->Fetch()){
				$arSelect = Array("ID", "NAME", "PROPERTY_BREND");
				$arFilter2 = Array("IBLOCK_ID"=>10, "ACTIVE"=>"Y", "PROPERTY_BREND"=>$arRes["UF_XML_ID"]);
				$res = CIBlockElement::GetList(array(), $arFilter2, false, array("nPageSize"=>1), $arSelect);
				while($ar_fields = $res->GetNext())
				{
				?>
					<?
					$file = CFile::ResizeImageGet($arRes["UF_FILE"], array('width'=>148, 'height'=>61), BX_RESIZE_IMAGE_EXACT, true);
					$name = mb_strtolower(str_replace(" ", "_", $arRes['UF_NAME']));
					?>

					<li class="item">
						<a class="logo" href="/proizvoditeli/inzhenernaya/<?=$name?>/" style="background-image:url(<?=$file["src"]?>);"></a>
						<div class="title"><?echo $arRes["UF_NAME"]?></div>
					</li>
				<?
				}
			}*/
			////////////////////////////////////////////////
			?>
		</ul>
	</div>
	<div class="flexslider tab_content" id="brend_cat2">
		<ul class="carusel slides">
			<?/*
			////////////////////////////////////////////////
			$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch(); 
			$entity = HL\HighloadBlockTable::compileEntity($hlblock);
			
			$entity_data_class = $entity->getDataClass();
			$entity_table_name = $hlblock['TABLE_NAME'];
			
			$arFilter = array(); //задаете фильтр по вашим полям
			
			$sTableID = 'tbl_'.$entity_table_name;
			$rsData = $entity_data_class::getList(array(
				"select" => array('UF_XML_ID', 'UF_NAME', 'UF_FILE'), //выбираем поля
				"filter" => $arFilter,
				"order" => array()
			));
			$rsData = new CDBResult($rsData, $sTableID);
			while($arRes = $rsData->Fetch()){
				$arSelect = Array("ID", "NAME", "PROPERTY_BREND");
				$arFilter2 = Array("IBLOCK_ID"=>12, "ACTIVE"=>"Y", "PROPERTY_BREND"=>$arRes["UF_XML_ID"]);
				$res = CIBlockElement::GetList(array(), $arFilter2, false, array("nPageSize"=>1), $arSelect);
				while($ar_fields = $res->GetNext())
				{
				?>
					<?
					$file = CFile::ResizeImageGet($arRes["UF_FILE"], array('width'=>148, 'height'=>61), BX_RESIZE_IMAGE_EXACT, true);
					$name = mb_strtolower(str_replace(" ", "_", $arRes['UF_NAME']));
					?>

					<li class="item">
						<a class="logo" href="/proizvoditeli/bytovaya/<?=$name?>/" style="background-image:url(<?=$file["src"]?>);"></a>
						<div class="title"><?echo $arRes["UF_NAME"]?></div>
					</li>
				<?
				}
			}*/
			////////////////////////////////////////////////
			?>
		</ul>
	</div>
</div>





<div class="main_text_block">
	<div class="block text_block">
		<div class="title_block">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include", 
				".default", 
				array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => "/include/main_text_block_title.php",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);?>
		</div>
		<div class="text">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include", 
				".default", 
				array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => "/include/main_text_block_text.php",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);?>
			
			<a href="/about/" class="link">узнать больше</a>
		</div>
	</div>

	<div class="block articl_block">
		<div class="title_block">
			<div class="inline finger active_tab" id="tab-articles">статьи</div>
			<div class="inline finger" id="tab-news">новости</div>
			<a href="/articles/" class="all inline" id="all-articles">все статьи</a>
            <a href="/news/" class="all inline" id="all-news" >все новости</a>
		</div>
        <div id="tabs-articles">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"articles_main",
			Array(
				"COMPONENT_TEMPLATE" => ".default",
				"IBLOCK_TYPE" => "content",
				"IBLOCK_ID" => "3",
				"NEWS_COUNT" => "3",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "",
				"FIELD_CODE" => array("",""),
				"PROPERTY_CODE" => array("",""),
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_STATUS_404" => "Y",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"INCLUDE_SUBSECTIONS" => "N",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"PAGER_TEMPLATE" => ".default",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "Новости",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N"
			)
		);?>
        </div>
        <div id="tabs-news" style="display: none;">
            <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"articles_main", 
	array(
		"COMPONENT_TEMPLATE" => "articles_main",
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "18",
		"NEWS_COUNT" => "3",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_STATUS_404" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"SET_LAST_MODIFIED" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>
        </div>
	</div>
	<div class="clear"></div>
</div>

