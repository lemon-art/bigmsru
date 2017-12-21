<?php
$module_id = 'asd.currencyrate';
$POST_RIGHT = $APPLICATION->GetGroupRight('main');

if (!function_exists('htmlspecialcharsbx')) {
	function htmlspecialcharsbx($string, $flags=ENT_COMPAT) {
		return htmlspecialchars($string, $flags, (defined('BX_UTF')? 'UTF-8' : 'ISO-8859-1'));
	}
}

if ($POST_RIGHT >= 'R'):
	IncludeModuleLangFile($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/options.php');
	IncludeModuleLangFile(__FILE__);

	$arAllOptions = array(
		array('percent', GetMessage('OPT_PERCENT').':', array('text', 7), GetMessage('OPT_PERCENT_HINT'))
	);

	$tabControl = new CAdmintabControl('tabControl', array(
		array('DIV' => 'edit1', 'TAB' => GetMessage('MAIN_TAB_SET'), 'ICON' => ''),
//		array('DIV' => 'edit2', 'TAB' => GetMessage('MAIN_TAB_RIGHTS'), 'ICON' => '', 'TITLE' => GetMessage('MAIN_TAB_TITLE_RIGHTS'))
	));

	if (ToUpper($REQUEST_METHOD) == 'POST' &&
		strlen($Update.$Apply.$RestoreDefaults)>0 &&
		($POST_RIGHT=='W' || $POST_RIGHT=='X') &&
		check_bitrix_sessid())
	{
		$bRedirect = true;

		if (strlen($RestoreDefaults)>0) {
			COption::RemoveOption($module_id);
			$z = CGroup::GetList($v1='id',$v2='asc', array('ACTIVE' => 'Y', 'ADMIN' => 'N'));
			while ($zr = $z->Fetch()) {
				$APPLICATION->DelGroupRight($module_id, array($zr['ID']));
			}
		}
		else {
			foreach ($arAllOptions as $arOption) {
				$name = $arOption[0];
				if ($arOption[2][0]=='text-list') {
					$val = '';
					for ($j=0; $j<count($$name); $j++)
						if (strlen(trim(${$name}[$j])) > 0)
							$val .= ($val <> ''? ',':'').trim(${$name}[$j]);
				}
				elseif ($arOption[2][0]=='selectbox' || $arOption[2][0]=='selectboxtree') {
					$val = '';
					for ($j=0; $j<count($$name); $j++)
						if (strlen(trim(${$name}[$j])) > 0)
							$val .= ($val <> ''? ',':'').trim(${$name}[$j]);
				}
				else {
					$val = $$name;
				}

				if ($arOption[2][0] == 'checkbox' && $val<>'Y') {
					$val = 'N';
				}
				COption::SetOptionString($module_id, $name, $val);
			}
		}

		$Update = $Update.$Apply;

		/*ob_start();
		require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/admin/group_rights.php');
		ob_end_clean();*/

		if ($bRedirect) {
			if (strlen($Update)>0 && strlen($_REQUEST['back_url_settings'])>0) {
				LocalRedirect($_REQUEST['back_url_settings']);
			}
			else {
				LocalRedirect($APPLICATION->GetCurPage().'?mid='.urlencode($mid).'&lang='.urlencode(LANGUAGE_ID).'&back_url_settings='.urlencode($_REQUEST['back_url_settings']).'&'.$tabControl->ActiveTabParam());
			}
		}
	}

	?><form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=urlencode($mid)?>&amp;lang=<?=LANGUAGE_ID?>"><?
	$tabControl->Begin();
	$tabControl->BeginNextTab();
	foreach($arAllOptions as $Option):
		$type = $Option[2];
		$hint = $Option[3];
		$val = COption::GetOptionString($module_id, $Option[0]);
		?><tr>
		<td valign="top" width="30%"><?
			if (strlen($hint)) {
				ShowJSHint($hint);
				echo '&nbsp;';
			}
			if ($type[0]=='checkbox') {
				echo '<label for="'.htmlspecialcharsbx($Option[0]).'">'.$Option[1].'</label>';
			} else {
				echo $Option[1];
			}
		?></td><td valign="middle" width="70%"><?
		if ($type[0] == 'text'):
			?><input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialcharsbx($val)?>" name="<?echo htmlspecialcharsbx($Option[0])?>" /><?
		endif;
		?></td></tr><?

	endforeach;

	//$tabControl->BeginNextTab();
	//require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/admin/group_rights.php');

	$tabControl->Buttons();

	?><input <?if ($POST_RIGHT < 'W') echo 'disabled="disabled"' ?> type="submit" name="Update" value="<?=GetMessage('MAIN_SAVE')?>" title="<?=GetMessage('MAIN_OPT_SAVE_TITLE')?>" />
	<input <?if ($POST_RIGHT < 'W') echo 'disabled="disabled"' ?> type="submit" name="Apply" value="<?=GetMessage('MAIN_OPT_APPLY')?>" title="<?=GetMessage('MAIN_OPT_APPLY_TITLE')?>" /><?

	if (strlen($_REQUEST["back_url_settings"]) > 0):
		?><input <?if ($POST_RIGHT < 'W') echo 'disabled="disabled"' ?> type="button" name="Cancel" value="<?=GetMessage('MAIN_OPT_CANCEL')?>" title="<?=GetMessage('MAIN_OPT_CANCEL_TITLE')?>" onclick="window.location='<?echo htmlspecialcharsbx(CUtil::addslashes($_REQUEST['back_url_settings']))?>'" />
		<input type="hidden" name="back_url_settings" value="<?=htmlspecialcharsbx($_REQUEST["back_url_settings"])?>" /><?
	endif;

	?><input <?if ($POST_RIGHT < 'W') echo 'disabled="disabled"' ?> type="submit" name="RestoreDefaults" title="<?echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>" onclick="confirm('<?echo AddSlashes(GetMessage('MAIN_HINT_RESTORE_DEFAULTS_WARNING'))?>')" value="<?echo GetMessage('MAIN_RESTORE_DEFAULTS')?>" />
	<?=bitrix_sessid_post();
	$tabControl->End();

	?></form><?

endif;