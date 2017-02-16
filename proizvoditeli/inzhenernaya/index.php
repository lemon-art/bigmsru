<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


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


///////////////////////////////////////////////


$url = str_replace("/proizvoditeli/inzhenernaya/", "", addslashes(htmlspecialchars($_SERVER["REDIRECT_URL"])));
$ar_url = explode("/", $url);
$url_name = str_replace("_", " ", $ar_url[0]);


$arFilter = array('UF_NAME' => $url_name); //задаете фильтр по вашим полям

$sTableID = 'tbl_'.$entity_table_name;
$rsData = $entity_data_class::getList(array(
	"select" => array('UF_XML_ID', 'UF_NAME'), //выбираем поля
	"filter" => $arFilter,
	"order" => array("UF_NAME"=>"ASC")
));
$rsData = new CDBResult($rsData, $sTableID);
$arRes = $rsData->Fetch();	




global $arrFilterBrend;
if(!empty($url_name)){
	$arrFilterBrend = array(
		//"PROPERTY_BREND" => $_REQUEST["id"],
		"PROPERTY_BREND" => $arRes["UF_XML_ID"],
	);
}
else{
	$arrFilterBrend = array(
		"!PROPERTY_BREND" => false,
	);
}




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


$arFilter = array('UF_XML_ID' => $arRes["UF_XML_ID"]); //задаете фильтр по вашим полям

$sTableID = 'tbl_'.$entity_table_name;
$rsData = $entity_data_class::getList(array(
	"select" => array('UF_XML_ID', 'UF_NAME'), //выбираем поля
	"filter" => $arFilter,
	"order" => array("UF_NAME"=>"ASC")
));
$rsData = new CDBResult($rsData, $sTableID);
$arRes = $rsData->Fetch();			


$APPLICATION->SetTitle("Инженерная сантехника ".$arRes["UF_NAME"]);
?>

<h1><?$APPLICATION->ShowTitle(false)?></h1>

<div class="catalog">
	<div class="lf_block">
		<ul class="list">
			
			<?
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
				"order" => array("UF_NAME"=>"ASC")
			));
			$rsData = new CDBResult($rsData, $sTableID);
			while($arRes = $rsData->Fetch()){				
				$arSelect = Array("ID", "NAME", "PROPERTY_BREND");
				$arFilter2 = Array("IBLOCK_ID"=>10, "ACTIVE"=>"Y", "PROPERTY_BREND"=>$arRes["UF_XML_ID"]);
				$res = CIBlockElement::GetList(array(), $arFilter2, false, array("nPageSize"=>1), $arSelect);
				while($ar_fields = $res->GetNext())
				{
					//echo '<li class="item"><a href="/proizvoditeli/inzhenernaya/?name='.$arRes['UF_NAME'].'">'.$arRes['UF_NAME'].'</a></li>';
					$name = mb_strtolower(str_replace(" ", "_", $arRes['UF_NAME']));
					echo '<li class="item"><a href="/proizvoditeli/inzhenernaya/'.$name.'/">'.$arRes['UF_NAME'].'</a></li>';
				}
			}
			////////////////////////////////////////////////
			?>

		</ul>
	</div>
	
	<div class="rt_block">

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
					<div class="title">Сортировать:</div>
					<?	
					$basePrice = CCatalogGroup::GetBaseGroup();
					$priceSort = "CATALOG_PRICE_".$basePrice["ID"];
					$arAvailableSort = array(
						$priceSort => array($priceSort, "desc"),
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
					
					$arParams["ELEMENT_SORT_ORDER"] = 'asc';
					
					if ((array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ) || (array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ) || $arParams["ELEMENT_SORT_ORDER"])
					{
						if ($_REQUEST["order"]) {$sort_order=$_REQUEST["order"]; $_SESSION["order"]=$_REQUEST["order"];}
						elseif ($_SESSION["order"]) {$sort_order=$_SESSION["order"];}
						else {$sort_order=ToLower($arParams["ELEMENT_SORT_ORDER"]);}
					}

					$arMess["SECT_SORT_SORT"] = "Цена";
					$arMess["SECT_SORT_POPULARITY"] = "Популярность";
					$arMess["SECT_SORT_NAME"] = "Название";
					$arMess["SECT_SORT_CATALOG_PRICE_1"] = "Цена";
					$arMess["SECT_SORT_QUANTITY"] = "Наличие";
					$arMess["SECT_SORT_NOVINKA"] = "новинка";
					$arMess["SECT_SORT_RASPRODAZHA"] = "акция";
					$arMess["SECT_SORT_PROPERTY_NOVINKA_VALUE"] = "новинка";
					$arMess["SECT_SORT_PROPERTY_RASPRODAZHA_VALUE"] = "акция";
					
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
				$show = 12;
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
				"IBLOCK_ID" => "10",
				"SECTION_ID" => "",
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array("UF_ICON",""),
				"ELEMENT_SORT_FIELD" => $sort,
				"ELEMENT_SORT_ORDER" => $sort_order,
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"USE_FILTER" => "Y",
				"FILTER_NAME" => "arrFilterBrend",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "Y",
				"HIDE_NOT_AVAILABLE" => "N",
				//"PAGE_ELEMENT_COUNT" => "12",
				"PAGE_ELEMENT_COUNT" => $show,
				"LINE_ELEMENT_COUNT" => "4",
				"PROPERTY_CODE" => array("NOVINKA","LIDER","RASPRODAZHA",""),
				"OFFERS_LIMIT" => "5",
				"TEMPLATE_THEME" => "blue",
				"PRODUCT_SUBSCRIPTION" => "N",
				"SHOW_DISCOUNT_PERCENT" => "Y",
				"SHOW_OLD_PRICE" => "Y",
				"SHOW_CLOSE_POPUP" => "Y",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_SUBSCRIBE" => "Подписаться",
				"MESS_BTN_DETAIL" => "Подробнее",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"SECTION_URL" => "",
				"DETAIL_URL" => "",
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"SEF_MODE" => "N",
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
				"SET_LAST_MODIFIED" => "N",
				"USE_MAIN_ELEMENT_SECTION" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
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
				"SECTION_CODE_PATH" => ""
			)
		);?>
		
	</div>
	<div class="clear"></div>
</div>

<?
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