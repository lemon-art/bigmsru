<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Услуги");
$APPLICATION->SetPageProperty("description", "Услуги. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "Услуги - Большой мастер");
?>

<?
echo '
<div class="uslugi_list">
	<div class="item">';
		$APPLICATION->IncludeComponent(
			"bitrix:main.include", 
			".default", 
			array(
				"AREA_FILE_SHOW" => "file",
				"PATH" => "/include/usluga1.php",
				"EDIT_TEMPLATE" => "standard.php"
			),
			false
		);
echo '</div>
	<div class="item">';
		$APPLICATION->IncludeComponent(
			"bitrix:main.include", 
			".default", 
			array(
				"AREA_FILE_SHOW" => "file",
				"PATH" => "/include/usluga2.php",
				"EDIT_TEMPLATE" => "standard.php"
			),
			false
		);
echo '</div>
	<div class="item">';
		$APPLICATION->IncludeComponent(
			"bitrix:main.include", 
			".default", 
			array(
				"AREA_FILE_SHOW" => "file",
				"PATH" => "/include/usluga3.php",
				"EDIT_TEMPLATE" => "standard.php"
			),
			false
		);
echo '</div>
	<div class="clear"></div>
</div>';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>