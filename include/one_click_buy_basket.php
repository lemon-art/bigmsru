<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?$APPLICATION->IncludeComponent("o2k:oneclickbuy", "shop", array(
	"USE_QUANTITY" => "N",
	"PROPERTIES" => array( 0 => "FIO", 1 => "PHONE", 2 => "COMMENT"),
	"REQUIRED" => array( 0 => "PHONE"),
	"DEFAULT_PERSON_TYPE" => "1",
	"DEFAULT_DELIVERY" => "0",
	"DEFAULT_PAYMENT" => "0",
	"DEFAULT_CURRENCY" => "RUB",
	"PRICE_ID" => "1",
	"USE_SKU" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000",
	"SEF_FOLDER" => SITE_DIR."catalog/",
	"BUY_ALL_BASKET" => "Y",
	),
	false
);?>
