<?// подключение служебной части пролога  
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?> 
  
<?if (CModule::IncludeModule("sale")) { 
    $fUserID = CSaleBasket::GetBasketUserID(True); 
    $fUserID = IntVal($fUserID); 
	$arFields = array(  
      "PRODUCT_ID" => $_REQUEST['p_id'],  
      "PRODUCT_PRICE_ID" => $_REQUEST['pp_id'],  
      "PRICE" => $_REQUEST['p'],  
      "CURRENCY" => "UAH",  
      "WEIGHT" => 0,  
      "QUANTITY" => 1,  
      "LID" => 's1',  
      "DELAY" => "Y",  
      "CAN_BUY" => "Y",  
      "NAME" => $_REQUEST['name'], 
       "MODULE" => "sale", 
       "NOTES" => "",  
      "DETAIL_PAGE_URL" => $_REQUEST['dpu'],  
      "FUSER_ID" => $fUserID     
);     
 
CSaleBasket::Add($arFields);  
}?>  
 
<?// подключение служебной части эпилога  
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>