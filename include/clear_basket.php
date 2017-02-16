<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');

$do = addslashes(htmlspecialchars($_POST['do']));


if($do == 1){
	CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
}


?>