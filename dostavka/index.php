<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Доставка. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "Доставка - Большой мастер");
$APPLICATION->SetTitle("Доставка");

echo '<div class="left_text">';
?>


<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/dostavka_text.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);?>


<?
echo '</div>';

$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/right_menu.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);

echo '<div class="clear"></div>';

echo '<br /><br /><br />';
?>
<div class="kontakt_a_i"></div>
<?

//global $USER;
//if ($USER->IsAdmin()){
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/main_dost.js");
//}
?>
<?/*
$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/shops.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);*/?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>