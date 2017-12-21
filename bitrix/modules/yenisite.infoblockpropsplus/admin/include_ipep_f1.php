<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
IncludeModuleLangFile(__FILE__);
CModule::IncludeModule("iblock");
CModule::IncludeModule("yenisite.infoblockpropsplus");

global $USER;
if(!$USER->IsAdmin())
	return;

?>

                    
<?
echo GetMessage("TITLE");
echo GetMessage("IPEP_MAX_INPUT_VARS");
if (($m = ini_get('max_input_vars')) && $m < 10000){echo GetMessage('IPEP_MAX_INPUT_VARS_N'); echo $m;}else{echo GetMessage('IPEP_MAX_INPUT_VARS_Y');}
echo GetMessage("TEXT");
?>


<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>