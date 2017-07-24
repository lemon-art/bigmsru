<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");


print_r( $_POST );

		//ищем позиция корзины по id товара
		$dbBasketItems = CSaleBasket::GetList(
		   array(),
		   array( 
		   "FUSER_ID" => CSaleBasket::GetBasketUserID(),
		   "LID" => SITE_ID,
		   "ORDER_ID" => "NULL",
		   "PRODUCT_ID" => $_POST["PRODUCT_ID"],
		   "DELAY" => "N"
		   ), 
			  false,
			  false,
		   array("ID")
		);
		if ($arBasketItems = $dbBasketItems->Fetch()){
			CSaleBasket::Delete( $arBasketItems["ID"] );
		}
    
?>
  
