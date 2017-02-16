<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личные данные");

echo '<div class="left_text">';
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:main.profile", 
	"change_profile", 
	array(
		"SET_TITLE" => "N",
		"COMPONENT_TEMPLATE" => "change_profile",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"USER_PROPERTY" => array(
			0 => "UF_TYPE",
			1 => "UF_INN",
			2 => "UF_OGRN",
			3 => "UF_KPP",
			4 => "UF_OKPO",
			5 => "UF_OKATO",
			6 => "UF_BIK",
			7 => "UF_RCH",
			8 => "UF_BANK",
			9 => "UF_KCH",
		),
		"SEND_INFO" => "N",
		"CHECK_RIGHTS" => "N",
		"USER_PROPERTY_NAME" => ""
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
		"PATH" => "/include/personal_menu.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);

echo '<div class="clear"></div>';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>