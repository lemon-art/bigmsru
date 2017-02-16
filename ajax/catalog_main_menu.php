<?php
define("NO_KEEP_STATISTIC", true);// Не собираем стату по действиям AJAX
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");

if($_REQUEST["type"] == "i"){?>
	<a href="/catalog/inzhenernaya/" class="catalogs_link"><span>Инженерная сантехника</span></a>
	<?$APPLICATION->IncludeComponent(
		"bitrix:menu",
		"catalogs",
		array(
			"ROOT_MENU_TYPE" => "catalogs1",
			"MENU_CACHE_TYPE" => "Y",
			"MENU_CACHE_TIME" => "36000000",
			"MENU_CACHE_USE_GROUPS" => "N",
			"MENU_CACHE_GET_VARS" => array(),
			"MAX_LEVEL" => "2",
			"CHILD_MENU_TYPE" => "left",
			"USE_EXT" => "Y",
			"DELAY" => "N",
			"ALLOW_MULTI_SELECT" => "N",
			"COMPONENT_TEMPLATE" => "menu"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y"
		)
	);
}elseif($_REQUEST["type"] == "b"){?>
	<a href="/catalog/bytovaya/" class="catalogs_link"><span>Бытовая сантехника</span></a>
	<?$APPLICATION->IncludeComponent(
		"bitrix:menu", 
		"catalogs", 
		array(
			"ROOT_MENU_TYPE" => "catalogs2",
			"MENU_CACHE_TYPE" => "Y",
			"MENU_CACHE_TIME" => "36000000",
			"MENU_CACHE_USE_GROUPS" => "N",
			"MENU_CACHE_GET_VARS" => array(),
			"MAX_LEVEL" => "2",
			"CHILD_MENU_TYPE" => "left",
			"USE_EXT" => "Y",
			"DELAY" => "N",
			"ALLOW_MULTI_SELECT" => "N",
			"COMPONENT_TEMPLATE" => "menu"
		),
		false,
		array(
			"ACTIVE_COMPONENT" => "Y"
		)
	);
}
?>