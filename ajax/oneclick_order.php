<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");
use Bitrix\Sale;

//если не заполнено имя на случай заказа из списка товаров


if ( !$_POST['COUNT'] ) {
	$_POST['COUNT'] = 1;
}

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
	
	if ( !$_POST['name'] ){
		$_POST['name'] = $USER->GetFullName();
	}
}

if ( !$_POST['name'] ){
	$_POST['name'] = 'user_section_' . $prefix.time();
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
   
  		$arFields = Array();

		if ( $_POST['TYPE'] !== 'cart' ){
		
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
			   array("ID", "DELAY", "PRODUCT_ID")
			);
			while ($arBasketItems = $dbBasketItems->Fetch())
			{
				if ( $_POST['TYPE'] == 'list' && (int)$_POST["PRODUCT_ID"] == $arBasketItems["PRODUCT_ID"]){
					
				}
				else{
				   $tmpBasketIDs[] = $arBasketItems["ID"];
				   $arFields["DELAY"] = "Y";
				   // откладываем товары
				   CSaleBasket::Update($arBasketItems["ID"], $arFields);
				}
			   
			   
			   
			}
			
			if ( $_POST['TYPE'] !== 'list'){	//если заказ происходит из списка товаров, то данный товар уже лежит в корзине и его добавлять не надо
				Add2BasketByProductID( $_POST["PRODUCT_ID"], $_POST["COUNT"] );
			}
		}
		
		if ( CSaleBasket::OrderBasket($ORDER_ID) ){
		
			if ( $_POST['TYPE'] !== 'cart' ){
				foreach($tmpBasketIDs as $tmpBasketID) {
				   $arFields["DELAY"] = "N";
				   // возвращаем товары к заказу
				   CSaleBasket::Update($tmpBasketID, $arFields);
				}
			}
		}
		
   } 
   else {
		echo 'no';
   }


?>
