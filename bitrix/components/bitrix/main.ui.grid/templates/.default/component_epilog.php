<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

CUtil::initJSCore(array('window', 'ajax'));

$APPLICATION->addHeadScript('/bitrix/js/main/utils.js');
$APPLICATION->addHeadScript('/bitrix/js/main/popup_menu.js');
$APPLICATION->addHeadScript('/bitrix/js/main/dd.js');

$APPLICATION->setAdditionalCSS('/bitrix/themes/.default/pubstyles.css');

if ($arParams['FLEXIBLE_LAYOUT'])
{
	$bodyClass = $APPLICATION->getPageProperty('BodyClass', false);
	$APPLICATION->setPageProperty('BodyClass', trim(sprintf('%s %s', $bodyClass, 'flexible-layout')));
}
