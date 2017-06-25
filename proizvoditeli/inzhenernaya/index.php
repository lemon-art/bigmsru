<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");




$url = str_replace("/proizvoditeli/inzhenernaya/", "", addslashes(htmlspecialchars($_SERVER["REDIRECT_URL"])));
$ar_url = explode("/", $url);
$url_name = str_replace("_", " ", $ar_url[0]);


header("HTTP/1.1 301 Moved Permanently");
header("Location: /proizvoditeli/" . $url_name . "/");
exit();

?>