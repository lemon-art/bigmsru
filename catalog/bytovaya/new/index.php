<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Новые поступления бытовой сантехники");
$APPLICATION->SetPageProperty("keywords", "бытовая сантехника");
$APPLICATION->SetPageProperty("title", "Новые предложения бытовой сантехники");
$APPLICATION->SetTitle("Новинки");

$GLOBALS['arrFilterSaleActions'] = array("PROPERTY_NOVINKA_VALUE"=>"Да");
$GLOBALS['catalog_id'] = 12;
$GLOBALS['catalog_url'] = "bytovaya";
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/actions_new.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>