<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");
use Bitrix\Sale;

global $USER;

if ( !$USER->IsAuthorized() ){
	$user = new CUser;
	$login = $prefix.time();
	$pass = rand(1000000,10000000).'_fG';
	
	$arFields = Array(
		"NAME"              => $_POST['name'],
		"EMAIL"             => $login . '@noemail.gav',
		"PERSONAL_PHONE"	=> $_POST['phone'],
		"LOGIN"             => $login,
		"ACTIVE"            => "Y",
		"PASSWORD"          => $pass,
		"CONFIRM_PASSWORD"  => $pass,
	);

	// add Guest ID
	$U_ID = $user->Add($arFields);
	$newuser = $U_ID;		
}
else {
	$newuser = $USER->GetID();	
}




$arFields = array(
   "LID" => "s1",
   "PERSON_TYPE_ID" => 1,
   "PAYED" => "N",
   "CANCELED" => "N",
   "STATUS_ID" => "N",
   "PRICE" => $_POST['PRICE'] * $_POST['COUNT'],
   "QUANTITY" => $_POST['COUNT'],
   "CURRENCY" => "RUB",
   "USER_ID" => $newuser,
   "USER_DESCRIPTION" => ""
);


$ORDER_ID = CSaleOrder::Add($arFields);

if (0 < $ORDER_ID)
   {
   
		//добавляем имя и телефон
		
		$arFields = array(
		   "ORDER_ID" => $ORDER_ID,
		   "ORDER_PROPS_ID" => 1,
		   "NAME" => "Имя",
		   "CODE" => "NAME",
		   "VALUE" => $_POST['name']
		);
		CSaleOrderPropsValue::Add($arFields);
		
		$arFields = array(
		   "ORDER_ID" => $ORDER_ID,
		   "ORDER_PROPS_ID" => 3,
		   "NAME" => "Телефон",
		   "CODE" => "PHONE",
		   "VALUE" => $_POST['phone']
		);
		CSaleOrderPropsValue::Add($arFields);
   
   /*
		global $DB;
		$strSql = "insert into b_sale_basket (FUSER_ID, ORDER_ID, PRODUCT_ID, QUANTITY, NAME, PRICE, DATE_UPDATE) VALUES( ".
			  "'".IntVal($newuser)."', ".
			  "'".$ORDER_ID."', ".
			  "'".$_POST['PRODUCT_ID']."', ".
			  "'".$_POST['COUNT']."',".
			  "'".$_POST['PRODUCT_NAME']."', ".
			  "'".$_POST['PRICE']."', ".
			  "'".$DB->GetNowFunction()."'".
			  ") ";
		$DB->Query($strSql);
    

		$arFields = array(
          "PRODUCT_ID" => $_POST['PRODUCT_ID'],
          "PRODUCT_PRICE_ID" => $_POST['CAT_PRICE_ID'],
          "PRICE" => $_POST['PRICE'],
          "CURRENCY" => 'RUB',
          "QUANTITY" => $_POST['COUNT'],
          "LID" => 's1',
          "DELAY" => "N",
          "CAN_BUY" => "Y",
          "NAME" => $_POST['PRODUCT_NAME'],
          "MODULE" => "express_order",
          "NOTES" => "",
          "DETAIL_PAGE_URL" => $_POST['DETAIL_PAGE_URL'],
          "FUSER_ID" => CSaleBasket::GetBasketUserID(),
          "ORDER_ID" => $ORDER_ID
        );
        CSaleBasket::Add($arFields);	
		
		echo "<pre>";
		print_r( $arFields );
		echo "</pre>";
		*/

		$arFields = Array();

		$dbBasketItems = CSaleBasket::GetList(
		   array(),
		   array( 
		   "FUSER_ID" => CSaleBasket::GetBasketUserID(),
		   "LID" => SITE_ID,
		   "ORDER_ID" => "NULL",
		   "DELAY" => "N"
		   ), 
			  false,
			  false,
		   array("ID", "DELAY")
		);
		while ($arBasketItems = $dbBasketItems->Fetch())
		{
		   $tmpBasketIDs[] = $arBasketItems["ID"];
		   $arFields["DELAY"] = "Y";
		   // откладываем товары
		   CSaleBasket::Update($arBasketItems["ID"], $arFields);
		   
		   
		   
		}
		
	
		Add2BasketByProductID( $_POST["PRODUCT_ID"], $_POST["COUNT"] );
		
		if ( CSaleBasket::OrderBasket($ORDER_ID) ){
		
			foreach($tmpBasketIDs as $tmpBasketID) {
			   $arFields["DELAY"] = "N";
			   // возвращаем товары к заказу
			   CSaleBasket::Update($tmpBasketID, $arFields);
			}
		}
		
   } 
   else {
		echo 'no';
   }


?>
