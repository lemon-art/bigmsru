<?
IncludeModuleLangFile(__FILE__);
Class quetzal_retailrocket extends CModule
{
	var $MODULE_ID = "quetzal.retailrocket";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	function quetzal_retailrocket()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->PARTNER_NAME = GetMessage("RR_QTZ_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("RR_QTZ_PARTNER_URI");

        $this->MODULE_NAME = GetMessage("RR_QTZ_MODULE_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("RR_QTZ_MODULE_DESCRIPTION");
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx("/bitrix/components/quetzal/tracking.category");
		DeleteDirFilesEx("/bitrix/components/quetzal/tracking.order");
		DeleteDirFilesEx("/bitrix/components/quetzal/tracking.product");
		DeleteDirFilesEx("/bitrix/components/quetzal/widget");
        DeleteDirFilesEx("/bitrix/js/quetzal.retailrocket/");
		DeleteDirFilesEx("/bitrix/admin/retail_configuration.php");
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION, $step;
 		$step = IntVal($step);
		if($step < 2){
            $APPLICATION->IncludeAdminFile(GetMessage("RR_QTZ_MODULE_MESSAGE_INSTAL"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/quetzal.retailrocket/install/step1.php");
        }
        else {
            $APPLICATION->IncludeAdminFile(GetMessage("RR_QTZ_MODULE_MESSAGE_INSTAL"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/quetzal.retailrocket/install/step2.php");
        }    
        
	}

	function DoUninstall()
	{
        global $DOCUMENT_ROOT, $APPLICATION;
		$this->UnInstallFiles();
        $APPLICATION->IncludeAdminFile(GetMessage("RR_QTZ_MODULE_MESSAGE_UNINSTAL"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/quetzal.retailrocket/install/unstep.php");
	}
}
?>