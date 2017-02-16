<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");

CSaleBasket::Delete($_POST["ajaxdeleteid"]);

$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "in_header", Array(
		"PATH_TO_BASKET" => SITE_DIR."/basket/",
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",
		"SHOW_PERSONAL_LINK" => "N",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_TOTAL_PRICE" => "Y",
		"SHOW_PRODUCTS" => "N",
		"POSITION_FIXED" => "N",
	),
	false
); 



/* if (CSaleBasket::Delete($_POST["ajaxdeleteid"])) {
	$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "in_header", Array(
			"PATH_TO_BASKET" => SITE_DIR."/basket/",
			"PATH_TO_PERSONAL" => SITE_DIR."personal/",
			"SHOW_PERSONAL_LINK" => "N",
			"SHOW_NUM_PRODUCTS" => "Y",
			"SHOW_TOTAL_PRICE" => "Y",
			"SHOW_PRODUCTS" => "N",
			"POSITION_FIXED" => "N",
		),
		false
	);
} */
    
?>
  
