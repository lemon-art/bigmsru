<?// подключение служебной части пролога  
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?> 

<?
if (CModule::IncludeModule("sale")) { 
	$id = addslashes(htmlspecialchars($_POST['id']));
	$del = addslashes(htmlspecialchars($_POST['del']));
	
	$arBasketItems = array();

	$dbBasketItems = CSaleBasket::GetList(
		array(
				"NAME" => "ASC",
				"ID" => "ASC"
			),
		array(
				"FUSER_ID" => CSaleBasket::GetBasketUserID(),
				"LID" => SITE_ID,
				"ORDER_ID" => "NULL",
				//"PRODUCT_ID" => $id
			),
		false,
		false,
		array(
			  "ID",  
			  "PRODUCT_ID",
			  "DELAY", 
			  "CAN_BUY"
			 )
	);
	
	while ($arItems = $dbBasketItems->Fetch())
	{
		if (strlen($arItems["CALLBACK_FUNC"]) > 0)
		{
			CSaleBasket::UpdatePrice($arItems["ID"], 
									 $arItems["CALLBACK_FUNC"], 
									 $arItems["MODULE"], 
									 $arItems["PRODUCT_ID"], 
									 $arItems["QUANTITY"]);
			$arItems = CSaleBasket::GetByID($arItems["ID"]);
		}
		
		if($arItems['DELAY'] == 'Y'){
			$arBasketItems[$arItems["PRODUCT_ID"]] = $arItems;
		}
	}
	
	/*
	echo "<pre>";
	print_r($arBasketItems);
	echo "</pre>";
	*/
	
	if($del == 1){
		if (CSaleBasket::Delete($arBasketItems[$id]["ID"])){
			echo "Ok";
		}
	}
	else if($del == "all"){
		foreach($arBasketItems as $k=>$delay){
			if (CSaleBasket::Delete($delay["ID"])){
				echo "Ok";
			}
		}
	}
}?>  
 
<?// подключение служебной части эпилога  
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>