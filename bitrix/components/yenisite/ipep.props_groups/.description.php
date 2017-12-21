<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("ROMZA_IPEPPG_NAME"),
	"DESCRIPTION" => GetMessage("ROMZA_IPEPPG_DESC"),
	"ICON" => "/images/menu_ext.gif",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "romza",
		"NAME" => GetMessage("ROMZA_COMPONENTS"),
		"CHILD" => array(
			"ID" => "catalog_rz",
			"NAME" => GetMessage("T_IBLOCK_DESC_CATALOG"),
			"SORT" => 30
		)
	)
);
?>