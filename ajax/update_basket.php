<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");

$productID = $_POST["ProductID"];
$norma = $_POST["QUANTITY"];

$dbBasketItems = CSaleBasket::GetList(
        array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
        array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "PRODUCT_ID" => $productID,
                "ORDER_ID" => "NULL"
            ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE", 
              "PRODUCT_ID", "QUANTITY", "DELAY", 
              "CAN_BUY", "PRICE", "WEIGHT")
    );
if ($arItems = $dbBasketItems->Fetch())
{
	
	$QUANTITY = $arItems['QUANTITY'] - $norma;
	$arFields = array(
	   "QUANTITY" => $QUANTITY
	);
	CSaleBasket::Update($arItems['ID'], $arFields);
}

