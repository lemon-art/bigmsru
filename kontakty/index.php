<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>
<style>
.switch_block {
display: -webkit-box;
display: -moz-box;
display: -webkit-flex;
display: -ms-flexbox;
display: flex;
}
.switch_block .title {
min-width: 200px;
}
.selectesem .item {
min-width: 215px;
}
</style>
<div class="contacts-shops">
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
</div>
<div class="kontakty_text">
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		".default",
		array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => "/include/kontakty_text.php",
			"EDIT_TEMPLATE" => "standard.php"
		),
		false
	);?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>