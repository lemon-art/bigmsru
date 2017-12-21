<style type="text/css">
	.column-name {
		width: 50%;  
	}
	.column-value {
		width: 50%;
	}
</style>
<?
global $USER;
if (!$USER->IsAdmin())
	return;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

IncludeModuleLangFile(__FILE__);
const moduldeID = 'yenisite.infoblockpropsplus';

CModule::IncludeModule(moduldeID);

if (Loader::includeModule('iblock'))
{

}

$rsIblockList = CIBlock::GetList(array("IBLOCK_TYPE" => "ASC"),array("ACTIVE" => 'Y'),false);

$arIblockList = array();
while ($arIblock = $rsIblockList->Fetch()){
	$arIblockList[] = $arIblock;
}

$aTabs = array(
	array("DIV" => "edit1", "TAB" => GetMessage("MAIN_TAB_SET"), "ICON" => "form_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_SET")),
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);

if ($REQUEST_METHOD=="POST" && strlen($_REQUEST['save'].$_REQUEST['apply'].$RestoreDefaults) > 0 && check_bitrix_sessid())
{
	global $CACHE_MANAGER;
	$CACHE_MANAGER->ClearByTag(\CYenisiteInfoblockpropsplus::cacheID);

	if (strlen($RestoreDefaults)>0)
	{
		COption::RemoveOption(moduldeID);
	}
	else
	{
		$arFlip_select = array_flip($_REQUEST['select_iblock']);
		$arSave_select = serialize($arFlip_select);
		COption::SetOptionString(moduldeID, 'group_from_parent_sections', $_REQUEST['group_from_parent_sections'], GetMessage('IPEP_GROUP_FROM_PARENT_SECTIONS'));
		COption::SetOptionString(moduldeID, 'select_iblock',$arSave_select, GetMessage('IPEP_NOT_WORK_FOR'));
	}
	
	if (strlen($Update) > 0 && strlen($_REQUEST["back_url_settings"]) > 0)
	{
		LocalRedirect($_REQUEST["back_url_settings"]);
	}
	else
	{
		LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode($mid)."&lang=".urlencode(LANGUAGE_ID)."&back_url_settings=".urlencode($_REQUEST["back_url_settings"])."&".$tabControl->ActiveTabParam());
	}


}


$arSaved_select = COption::GetOptionString(moduldeID, 'select_iblock', '');
$arSelect_iblock = unserialize($arSaved_select);
$group_from_parent_sections = COption::GetOptionString(moduldeID, 'group_from_parent_sections', 'N');
$tabControl->Begin();
	$tabControl->BeginNextTab();?>
		<form method="POST" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&amp;lang=<?=LANGUAGE_ID?>">
			<?=bitrix_sessid_post();?>
			
			<tr>
				<td class="column-name"><?=GetMessage('IPEP_MAX_INPUT_VARS')?></td>
				<td class="column-value" ><?if (($m = ini_get('max_input_vars')) && $m < 10000){echo GetMessage('IPEP_MAX_INPUT_VARS_N'); echo $m;}else{echo GetMessage('IPEP_MAX_INPUT_VARS_Y');}?></td>
			</tr>
			<tr>
				<td class="column-name"><?=GetMessage('IPEP_GROUP_FROM_PARENT_SECTIONS')?><span class="required"><sup><?echo '1'?></sup></span>: </td>
				<td class="column-value" ><input type="checkbox" name="group_from_parent_sections" value="Y"<?if($group_from_parent_sections=="Y")echo" checked";?> /></td>
			</tr>
			<tr>
				<td class="column-name"><?=GetMessage('IPEP_NOT_WORK_FOR')?></td>
				<td class="column-value" ><select multiple="multiple" name="select_iblock[]" size="10"><option value="-1" <?if(isset($arSelect_iblock['-1'])):?>selected = "selected"<?endif?>><?=Loc::getMessage('IPEP_NOT_SELECT')?></option><?foreach($arIblockList as $arIblock):?><option <?if (isset($arSelect_iblock[$arIblock['ID']])):?>selected = "selected"<?endif?> value="<?=$arIblock['ID']?>"><?=$arIblock['IBLOCK_TYPE_ID'].' / '.$arIblock['NAME']?></option><?endforeach?></select></td>
			</tr>
			<tr>
				<td class="column-name"><?=GetMessage('API_TEXT')?></td>
				<td class="column-value" ></td>
			</tr>
			
			<?$tabControl->Buttons(array());?>
		</form>
<?$tabControl->End();?>

<?echo BeginNote();?>
<span class="required"><sup><?echo '1'?></sup></span><?=GetMessage('IPEP_GROUP_FROM_PARENT_SECTIONS_TIP')?><br>
<?echo EndNote();?>