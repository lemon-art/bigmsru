<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->AddChainItem("Ошибка 404", "");
$APPLICATION->SetTitle("К сожалению, такой страницы не существует");


?>

<script type="text/javascript">
var url = document.location.pathname + document.location.search;
var url_referrer = document.referrer;
var yaParams = {error404: {page: url, from: url_referrer}};
</script>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>