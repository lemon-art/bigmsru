<?
$module_id = "roistat.integration";
$CAT_RIGHT = $APPLICATION->GetGroupRight($module_id);
if ($CAT_RIGHT >= "R") :

    IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/options.php");
    IncludeModuleLangFile(__FILE__);

    include_once($GLOBALS["DOCUMENT_ROOT"] . "/bitrix/modules/roistat.integration/include.php");

    if ($REQUEST_METHOD == "GET" && strlen($RestoreDefaults) > 0 && $CAT_RIGHT == "W" && check_bitrix_sessid()) {
        COption::RemoveOption("roistat.integration");
        $z = CGroup::GetList($v1 = "id", $v2 = "asc", array("ACTIVE" => "Y", "ADMIN" => "N"));
        while ($zr = $z->Fetch())
            $APPLICATION->DelGroupRight($module_id, array($zr["ID"]));
        COption::RemoveOption($module_id);

        LocalRedirect($APPLICATION->GetCurPage() . "?lang=" . LANG . "&mid=" . urlencode($mid));
    }

    if ($REQUEST_METHOD == "POST" && strlen($Update) > 0 && $CAT_RIGHT == "W" && check_bitrix_sessid()) {
        COption::SetOptionString($module_id, 'PROJECT_ID', $_REQUEST["ROISTAT_PROJECT_ID"]);
        COption::SetOptionString($module_id, 'LOGIN', $_REQUEST["ROISTAT_LOGIN"]);
        COption::SetOptionString($module_id, 'PASSWORD', $_REQUEST["ROISTAT_PASSWORD"]);
    }

    $aTabs = array(
        array("DIV" => "edit1", "TAB" => GetMessage("ROISTAT_TAB_NAME"), "ICON" => "default", "TITLE" => GetMessage("ROISTAT_TAB_TITLE")),
        array("DIV" => "edit2", "TAB" => GetMessage("MAIN_TAB_RIGHTS"), "ICON" => "default", "TITLE" => GetMessage("MAIN_TAB_TITLE_RIGHTS")),
    );
    $tabControl = new CAdminTabControl("tabControl", $aTabs);

    $tabControl->Begin();
    ?>
    <form method="POST"
          action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= htmlspecialcharsbx($mid) ?>&lang=<? echo LANGUAGE_ID ?>"
          name="ara">
        <? echo bitrix_sessid_post();

        $tabControl->BeginNextTab();

        ?>
        <tr>
            <td valign="top" width="50%">
                <?= GetMessage('ROISTAT_PROJECT_ID_LABEL') ?>
            </td>
            <td valign="top" width="50%">
                <input name="ROISTAT_PROJECT_ID" value="<?= COption::GetOptionString($module_id, 'PROJECT_ID') ?>">
            </td>
        </tr>
        <tr>
            <td valign="top" width="50%">
                <?= GetMessage('ROISTAT_LOGIN_LABEL') ?>
            </td>
            <td valign="top" width="50%">
                <input name="ROISTAT_LOGIN" value="<?= COption::GetOptionString($module_id, 'LOGIN') ?>">
            </td>
        </tr>
        <tr>
            <td valign="top" width="50%">
                <?= GetMessage('ROISTAT_PASSWORD_LABEL') ?>
            </td>
            <td valign="top" width="50%">
                <input name="ROISTAT_PASSWORD" value="<?= COption::GetOptionString($module_id, 'PASSWORD') ?>">
            </td>
        </tr>
        <?
        $tabControl->BeginNextTab();

        require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/admin/group_rights.php");

        $tabControl->Buttons();?>
        <script type="text/javascript">
            function RestoreDefaults() {
                if (confirm('<? echo GetMessageJS("MAIN_HINT_RESTORE_DEFAULTS_WARNING"); ?>'))
                    window.location = "<?echo $APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?echo LANGUAGE_ID; ?>&mid=<?echo urlencode($mid)?>&<?=bitrix_sessid_get()?>";
            }
        </script>
        <input type="submit" <? if ($CAT_RIGHT < "W") echo "disabled" ?> name="Update"
               value="<? echo GetMessage("MAIN_SAVE") ?>">
        <input type="hidden" name="Update" value="Y">
        <input type="reset" name="reset" value="<? echo GetMessage("MAIN_RESET") ?>">
        <input type="button" <? if ($CAT_RIGHT < "W") echo "disabled" ?>
               title="<? echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS") ?>" OnClick="RestoreDefaults();"
               value="<? echo GetMessage("MAIN_RESTORE_DEFAULTS") ?>">
        <? $tabControl->End(); ?>
    </form>
<? endif; ?>