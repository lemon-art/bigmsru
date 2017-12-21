<?php
@define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("currency");
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("roistat.integration");

$LOGIN = COption::GetOptionString("roistat.integration", 'LOGIN', '');
$PASSWORD = COption::GetOptionString("roistat.integration", 'PASSWORD', '');

if (strlen($LOGIN . $PASSWORD) == 0) {
    die('SET PASSWORD FIRST');
}
if ($_REQUEST["token"] != md5($LOGIN . $PASSWORD)) {
    die('INCORRECT TOKEN');
}

if ($_REQUEST["action"] === 'export') {
    require_once(__DIR__ . '/action_export.php');
} elseif ($_REQUEST["action"] === 'lead') {
    require_once(__DIR__ . '/action_lead.php');
} elseif ($_REQUEST["action"] === 'export_clients') {
    require_once(__DIR__ . '/action_export_clients.php');
}