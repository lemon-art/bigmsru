<?php
define("NO_KEEP_STATISTIC", true);// Не собираем стату по действиям AJAX
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");

if($_REQUEST["type"] == "i"){
	$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list", 
		"sections", 
		Array(
			"COMPONENT_TEMPLATE" => "sections",
			"IBLOCK_TYPE" => "1c_catalog",
			"IBLOCK_ID" => "10",
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"COUNT_ELEMENTS" => "N",
			"TOP_DEPTH" => "2",
			"SECTION_FIELDS" => array(0 => "", 1 => ""),
			"SECTION_USER_FIELDS" => array(0 => "UF_ICON",1 => "UF_PICTURE",2 => "UF_CUSTOM_URL", 3 => "UF_ACTIVE"),
			"VIEW_MODE" => "LINE",
			"SHOW_PARENT_NAME" => "Y",
			"SECTION_URL" => "",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_GROUPS" => "Y",
			"ADD_SECTIONS_CHAIN" => "Y",
		),
		false
	);
}elseif($_REQUEST["type"] == "b"){
	$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"sections", 
		Array(
			"COMPONENT_TEMPLATE" => "sections",
			"IBLOCK_TYPE" => "1c_catalog",
			"IBLOCK_ID" => "12",
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"COUNT_ELEMENTS" => "N",
			"TOP_DEPTH" => "2",
			"SECTION_FIELDS" => array(0=>"",1=>"",),
			"SECTION_USER_FIELDS" => array(0=>"UF_ICON",1 => "UF_PICTURE",2 => "UF_CUSTOM_URL", 3 => "UF_ACTIVE"),
			"VIEW_MODE" => "LINE",
			"SHOW_PARENT_NAME" => "Y",
			"SECTION_URL" => "",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_GROUPS" => "Y",
			"ELEMENT_SORT_FIELD" => "sort",
			"ELEMENT_SORT_ORDER" => "asc",
			"ADD_SECTIONS_CHAIN" => "Y"
		)
	);

}









?>