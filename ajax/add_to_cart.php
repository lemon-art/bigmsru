<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>


<?
if ($_POST["QUANTITY"]) {
	echo (int)$_POST["QUANTITY"];
}
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");

Add2BasketByProductID( $_POST["ProductID"], $_POST["QUANTITY"] );