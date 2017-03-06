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

$brandXmlId = $arRes["UF_XML_ID"];	
$brandName = $arRes["UF_NAME"];


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

		<?$APPLICATION->IncludeComponent(
			"custom:brand.section.list",
			"",
			Array(
				"ADD_SECTIONS_CHAIN" => "N",
				"BRAND_NAME" => $brandName,
				"BRAND_XML" => $brandXmlId,
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"COUNT_ELEMENTS" => "N",
				"IBLOCK_ID" => 10,
				"IBLOCK_TYPE" => "catalog",
				"SECTION_CODE" => "",
				"SECTION_FIELDS" => array("", ""),
				"SECTION_ID" => "",
				"SECTION_URL" => "",
				"SECTION_USER_FIELDS" => array("", ""),
				"SHOW_PARENT_NAME" => "Y",
				"TOP_DEPTH" => "2",
				"VIEW_MODE" => "LINE"
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