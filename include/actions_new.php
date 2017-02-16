<div class="catalog">
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.compare.list",
		"simple",
		array(
			"IBLOCK_TYPE" => "1c_catalog",
			"IBLOCK_ID" => $GLOBALS['catalog_id'],
			"NAME" => "CATALOG_COMPARE_LIST",
			"DETAIL_URL" => '/catalog/'.$GLOBALS['catalog_url'].'/#SECTION_CODE#/#ELEMENT_CODE#/',
			"COMPARE_URL" => '/catalog/'.$GLOBALS['catalog_url'].'/compare/',
			"ACTION_VARIABLE" => "action",
			"PRODUCT_ID_VARIABLE" => "id",
			'POSITION_FIXED' => "Y",
			'POSITION' => "top left",
		),
		$component,
		array("HIDE_ICONS" => "Y")
	);?>
	

	<div class="sort_header">
		<!--noindex-->
			<?
			$arParams["ELEMENT_SORT_FIELD"] = 'CATALOG_PRICE_1';
			$arParams["ELEMENT_SORT_ORDER"] = 'ASC';
			$arParams["DEFAULT_LIST_TEMPLATE"] = "block";
			$arMess["SECT_SORT_SORT"] = "Цена";
			$arMess["SECT_SORT_POPULARITY"] = "Популярность";
			$arMess["SECT_SORT_NAME"] = "Название";
			$arMess["SECT_SORT_CATALOG_PRICE_1"] = "Цена";
			$arMess["SECT_SORT_QUANTITY"] = "Наличие";
			$arMess["SECT_SORT_NOVINKA"] = "новинка";
			$arMess["SECT_SORT_RASPRODAZHA"] = "акция";
			$arMess["SECT_SORT_PROPERTY_NOVINKA_VALUE"] = "новинка";
			$arMess["SECT_SORT_PROPERTY_RASPRODAZHA_VALUE"] = "акция";
			
			
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
					//$priceSort => array($priceSort, "desc"),
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
						<span><?=$arMess['SECT_SORT_'.$key]?></span>
						<i></i>
					</a>
				<?
				}
				?>
			</div>			

			<?
			$show = 20;
			if (array_key_exists("show", $_REQUEST))
			{
				if ( intVal($_REQUEST["show"]) && in_array(intVal($_REQUEST["show"]), array(4, 8, 12, 16, 20)) ) {$show=intVal($_REQUEST["show"]); $_SESSION["show"] = $show;}
				elseif ($_SESSION["show"]) {$show=intVal($_SESSION["show"]);}
			}
			?>
			<div class="number_list">
				<div class="title">Показать по:</div>
				
				<select class="select" name="str" onchange="redirect_str(this.value);">
					<?for( $i = 4; $i <= 20; $i+=4 ){?>
						<option value="<?=$APPLICATION->GetCurPageParam('show='.$i, array("show"))?>" <?if($i == $show){echo 'selected="selected"';}?>><?=$i?></option>
					<?}?>
				</select>
			</div>
			
			<div class="sort_display">
				<div class="title">Вид:</div>
				<a href="<?=$APPLICATION->GetCurPageParam('display=block', array('display', 'mode'))?>" class="block <?=$display == 'block' ? 'current' : '';?>"><i></i><span></span></a>
				<a href="<?=$APPLICATION->GetCurPageParam('display=table', array('display', 'mode'))?>" class="table <?=$display == 'table' ? 'current' : '';?>"><i></i><span></span></a>
			</div>
		<!--/noindex-->
		<div class="clear"></div>
	</div>

	
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		$template,
		Array(
			"COMPONENT_TEMPLATE" => ".default",
			"IBLOCK_TYPE" => "1c_catalog",
			"IBLOCK_ID" => $GLOBALS['catalog_id'],
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"SECTION_USER_FIELDS" => array("",""),
			"ELEMENT_SORT_FIELD" => $sort,
			"ELEMENT_SORT_ORDER" => $sort_order,
			"ELEMENT_SORT_FIELD2" => "id",
			"ELEMENT_SORT_ORDER2" => "desc",
			"FILTER_NAME" => "arrFilterSaleActions",
			"INCLUDE_SUBSECTIONS" => "Y",
			"SHOW_ALL_WO_SECTION" => "Y",
			"HIDE_NOT_AVAILABLE" => "N",
			"PAGE_ELEMENT_COUNT" => $show,
			"LINE_ELEMENT_COUNT" => "4",
			"PROPERTY_CODE" => array("NOVINKA","LIDER_PRODAZH","RASPRODAZHA",""),
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
			"SET_META_KEYWORDS" => "Y",
			"META_KEYWORDS" => "-",
			"SET_META_DESCRIPTION" => "Y",
			"META_DESCRIPTION" => "-",
			"SET_LAST_MODIFIED" => "N",
			"USE_MAIN_ELEMENT_SECTION" => "N",
			"ADD_SECTIONS_CHAIN" => "Y",
			"CACHE_FILTER" => "N",
			"ACTION_VARIABLE" => "action",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRICE_CODE" => array("Интернет"),
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
			"PRODUCT_PROPERTIES" => array(),
			"ADD_TO_BASKET_ACTION" => "ADD",
			"PAGER_TEMPLATE" => "bigms",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Товары",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"SET_STATUS_404" => "Y",
			"SHOW_404" => "N",
			"MESSAGE_404" => "",
			"ADD_PICT_PROP" => "-",
			"LABEL_PROP" => "-",
			"SEF_RULE" => "",
			"SECTION_CODE_PATH" => "",
			"DISPLAY_COMPARE" => "Y",
			"USE_MAIN_ELEMENT_SECTION" => "Y",
			"COMPARE_PATH" => "/catalog/".$GLOBALS['catalog_url']."/compare/",
			"VARIABLE_ALIASES" => Array(),
			"VARIABLE_ALIASES" => Array(
			)
		)
	);?>
</div>
<div class="clear"></div>
<br /><br />
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