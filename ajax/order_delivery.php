<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
CModule::IncludeModule("sale");
$templateFolder = $_POST['templateFolder'];
require($_SERVER["DOCUMENT_ROOT"].$templateFolder.'step3.php');
?>
