<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Специальные предложения товаров по сниженным ценам");
$APPLICATION->SetPageProperty("keywords", "акция, товары по акции");
$APPLICATION->SetPageProperty("title", "Инженерная сантехника по акции");
$APPLICATION->SetTitle("Товары по акции");

$GLOBALS['arrFilterSaleActions'] = array("PROPERTY_RASPRODAZHA_VALUE"=>"Да");
$GLOBALS['catalog_id'] = 10;
$GLOBALS['catalog_url'] = "inzhenernaya";
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