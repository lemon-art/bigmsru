<?
IncludeModuleLangFile(__FILE__);
Class yenisite_infoblockpropsplus extends CModule
{
	const MODULE_ID = 'yenisite.infoblockpropsplus';
	var $MODULE_ID = 'yenisite.infoblockpropsplus';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__) . '/version.php');
		$this->MODULE_VERSION = $arModuleVersion['VERSION'];
		$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		$this->MODULE_NAME = GetMessage('yenisite.infoblockpropsplus_MODULE_NAME');
		$this->MODULE_DESCRIPTION = GetMessage('yenisite.infoblockpropsplus_MODULE_DESC');

		$this->PARTNER_NAME = GetMessage('yenisite.infoblockpropsplus_PARTNER_NAME');
		$this->PARTNER_URI = GetMessage('yenisite.infoblockpropsplus_PARTNER_URI');
	}

	function InstallDB($arParams = array())
	{
		global $DB;

		CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/public_html/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/', true, true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/' . self::MODULE_ID . '/install/bitrix/admin', $_SERVER["DOCUMENT_ROOT"].'/bitrix/admin', true, true);
		$DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/db/' . strtolower($DB->type) . '/install.sql');
		RegisterModuleDependences('main', 'OnEpilog', self::MODULE_ID, 'CYenisiteInfoblockpropsplus', 'OnEpilog');
		RegisterModuleDependences('iblock', 'OnIBlockDelete', self::MODULE_ID, 'CYenisiteInfoblockpropsplus', 'OnIBlockDelete');
		RegisterModuleDependences('iblock', 'OnIBlockPropertyDelete', self::MODULE_ID, 'CYenisiteInfoblockpropsplus', 'OnIBlockPropertyDelete');
		
		RegisterModule(self::MODULE_ID);
		LocalRedirect('/bitrix/admin/include_ipep_f1.php?lang=ru');

		return true;
	}

	function UnInstallDB($arParams = array())
	{
		DeleteDirFilesEx('/bitrix/js/' . self::MODULE_ID);
		DeleteDirFilesEx('/bitrix/components/yenisite/ipep.props_groups/');
//		$DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT']. '/bitrix/modules/' . self::MODULE_ID . '/install/db/'.strtolower($DB->type).'/uninstall.sql');
		UnRegisterModuleDependences('main', 'OnEpilog', self::MODULE_ID, 'CYenisiteInfoblockpropsplus', 'OnEpilog');
		UnRegisterModuleDependences('iblock', 'OnIBlockDelete', self::MODULE_ID, 'CYenisiteInfoblockpropsplus', 'OnIBlockDelete');
		UnRegisterModuleDependences('iblock', 'OnIBlockPropertyDelete', self::MODULE_ID, 'CYenisiteInfoblockpropsplus', 'OnIBlockPropertyDelete');

		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
		$this->InstallDB();
	}

	function DoUninstall()
	{
		global $APPLICATION;
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallDB();
	}
}

?>
