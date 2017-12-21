<?
IncludeModuleLangFile(__FILE__);

if (class_exists("roistat_integration")) return;

Class roistat_integration extends CModule
{
    var $MODULE_ID = "roistat.integration";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = "Y";

    function roistat_integration()
    {
        $arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path . "/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        } else {
            $this->MODULE_VERSION = ROISTAT_VERSION;
            $this->MODULE_VERSION_DATE = ROISTAT_VERSION_DATE;
        }

        $this->MODULE_NAME = GetMessage("ROISTAT_MODULE_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("ROISTAT_MODULE_DESCRIPTION");
        $this->MODULE_CSS = "/bitrix/modules/roistat.integration/styles.css";

        $this->PARTNER_NAME = "roistat";
        $this->PARTNER_URI = "http://roistat.com";
    }

    function InstallDB($arParams = array())
    {
        global $DB, $DBType, $APPLICATION;
        $this->errors = false;

        if (CModule::IncludeModule("sale")) {

            $rsPersonType = CSalePersonType::GetList();
            while ($arPersonType = $rsPersonType->GetNext()) {
                $rsProp = CSaleOrderProps::GetList(array(), array("PERSON_TYPE_ID" => $arPersonType["ID"], "CODE" => "ROISTAT_VISIT"));
                if ($arProp = $rsProp->GetNext())
                    continue;

                $rsPropsGroup = CSaleOrderPropsGroup::GetList(array("SORT" => "ASC"), array("PERSON_TYPE_ID" => $arPersonType["ID"]));
                if ($asPropsGroup = $rsPropsGroup->GetNext()) {
                    $arFields = array(
                        "PERSON_TYPE_ID" => $arPersonType["ID"],
                        "NAME" => GetMessage('ROISTAT_PROPERTY_NAME'),
                        "TYPE" => "TEXT",
                        "REQUIED" => "N",
                        "DEFAULT_VALUE" => "",
                        "SORT" => "0",
                        "USER_PROPS" => "N",
                        "IS_LOCATION" => "N",
                        "PROPS_GROUP_ID" => $asPropsGroup["ID"],
                        "DESCRIPTION" => GetMessage('ROISTAT_PROPERTY_DESCRIPTION'),
                        "IS_EMAIL" => "N",
                        "IS_PROFILE_NAME" => "N",
                        "IS_PAYER" => "N",
                        "IS_LOCATION4TAX" => "N",
                        "CODE" => "ROISTAT_VISIT",
                        "IS_FILTERED" => "Y",
                        "IS_ZIP" => "N",
                        "UTIL" => "Y",
                    );
                    $newPropID = CSaleOrderProps::Add($arFields);
                    if ($newPropID <= 0) {
                        $this->errors[] = GetMessage('ROISTAT_ERROR_ADD_PROPERTY');
                    }
                }
            }
        } else $this->errors[] = GetMessage('ROISTAT_ERROR_SALE_MODULE_NOT_INSTALLED');


        if ($this->errors !== false) {
            $APPLICATION->ThrowException(implode("<br>", $this->errors));
            return false;
        } else {

            RegisterModule("roistat.integration");
            RegisterModuleDependences("main", "OnEndBufferContent", "roistat.integration", "CRoistat", "OnEndBufferContentHandler");
            RegisterModuleDependences("sale", "OnOrderAdd", "roistat.integration", "CRoistat", "OnOrderAddHandler");
            RegisterModuleDependences("sale", "OnOrderNewSendEmail", "roistat.integration", "CRoistat", "OnOrderNewSendEmailHandler");
        }

        return true;
    }

    function UnInstallDB($arParams = array())
    {
        global $DB, $DBType, $APPLICATION;
        $this->errors = false;

        UnRegisterModuleDependences("sale", "OnOrderNewSendEmail", "roistat.integration", "CRoistat", "OnOrderNewSendEmailHandler");
        UnRegisterModuleDependences("sale", "OnOrderAdd", "roistat.integration", "CRoistat", "OnOrderAddHandler");
        UnRegisterModuleDependences("main", "OnEpilog", "roistat.integration", "CRoistat", "OnEpilogHandler");
        UnRegisterModule("roistat.integration");

        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles($arParams = array())
    {
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/roistat.integration/install/admin", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin", true);
        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/roistat.integration/install/admin", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin");
        return true;
    }

    function DoInstall()
    {
        global $DB, $DOCUMENT_ROOT, $APPLICATION, $step;
        $RIGHT = $APPLICATION->GetGroupRight("roistat.integration");
        if ($RIGHT == "W") {
            $step = IntVal($step);
            if ($step < 2) {
                $APPLICATION->IncludeAdminFile(GetMessage("ROISTAT_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/roistat.integration/install/step1.php");
            } elseif ($step == 2) {
                if ($this->InstallDB()) {
                    $this->InstallEvents();
                    $this->InstallFiles();
                }
                $GLOBALS["errors"] = $this->errors;
                $APPLICATION->IncludeAdminFile(GetMessage("ROISTAT_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/roistat.integration/install/step2.php");
            }
        }
    }

    function DoUninstall()
    {
        global $DB, $DOCUMENT_ROOT, $APPLICATION, $step;
        $RIGHT = $APPLICATION->GetGroupRight("roistat.integration");
        if ($RIGHT == "W") {
            $step = IntVal($step);
            if ($step < 2) {
                $APPLICATION->IncludeAdminFile(GetMessage("ROISTAT_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/roistat.integration/install/unstep1.php");
            } elseif ($step == 2) {
                $this->UnInstallDB(array(
                    "savedata" => $_REQUEST["savedata"],
                ));
                $this->UnInstallFiles();
                $GLOBALS["errors"] = $this->errors;
                $APPLICATION->IncludeAdminFile(GetMessage("ROISTAT_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/roistat.integration/install/unstep2.php");
            }
        }
    }

    function GetModuleRightList()
    {
        $arr = array(
            "reference_id" => array("D", "R", "W"),
            "reference" => array(
                "[D] " . GetMessage("ROISTAT_DENIED"),
                "[R] " . GetMessage("ROISTAT_READ"),
                "[W] " . GetMessage("ROISTAT_WRITE"))
        );
        return $arr;
    }
}

?>