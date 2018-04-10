<?
IncludeModuleLangFile(__FILE__);

if ('D' < $APPLICATION->GetGroupRight("roistat.integration")) {
    return $aMenu;
}
return false;
?>
