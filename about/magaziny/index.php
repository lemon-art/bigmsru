<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Магазины. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "Магазины - Большой мастер");
$APPLICATION->SetTitle("Магазины");
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/shops_about.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>