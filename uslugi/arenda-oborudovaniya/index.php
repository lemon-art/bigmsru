<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Аренда оборудования. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "Аренда оборудования - Большой мастер");
$APPLICATION->SetTitle("Аренда оборудования");

echo '<div class="left_text">';
?>

Text here....

<?
echo '</div>';

$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/right_uslugi_menu.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);

echo '<div class="clear"></div>';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>