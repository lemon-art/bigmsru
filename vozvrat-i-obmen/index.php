<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Возврат и обмен. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "Возврат и обмен - Большой мастер");
$APPLICATION->SetTitle("Возврат и обмен");

header("HTTP/1.1 301 Moved Permanently");
header("Location: /about/vozvrat-i-obmen/");
exit();

?>

