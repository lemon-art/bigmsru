<?
use \Bitrix\Main\Application;

define("STOP_STATISTICS", true);
define('NO_AGENT_CHECK', true);
define("DisableEventsCheck", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;

if (CModule::IncludeModule("sale"))
{
	$context = Application::getInstance()->getContext();
	$request = $context->getRequest();

	$item = Bitrix\Sale\PaySystem\Manager::searchByRequest($request);
	$service = new Bitrix\Sale\PaySystem\Service($item);
	$result = $service->processRequest($request);
}

$APPLICATION->FinalActions();
die();