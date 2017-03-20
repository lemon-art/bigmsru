<?
define('NO_KEEP_STATISTIC', true);
include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
header('Content-Type: application/json');

if (!CModule::IncludeModule('yenisite.infoblockpropsplus')) {
	echo CUtil::PhpToJSObject(array('IS_ERROR' => 'Y', 'ERROR_CODE' => 'NO_MODULE'));
	return;
}

if($_REQUEST['action']=='getinitarray')
{
	$initArray = CYenisiteInfoblockpropsplus::GetInitArray(array('IBLOCK_ID' => intval($_REQUEST['iblock_id'])));
	if (!defined('BX_UTF'))
		$initArray = $GLOBALS['APPLICATION']->ConvertCharsetArray($initArray, 'WINDOWS-1251', 'UTF-8');
	echo json_encode($initArray);
}
else
	echo json_encode(CYenisiteInfoblockpropsplus::ProcessAjax($_REQUEST));
