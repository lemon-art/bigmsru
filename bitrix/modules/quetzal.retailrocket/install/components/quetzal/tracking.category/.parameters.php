<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
        "PARAMETRS" => array(
            "NAME" => GetMessage("RR_QTZ_GROUPS_PARAMETRS_TYPE"),
        ),
    ),

    "PARAMETERS" => array(
        "CATEGORY_PAGE_PARAM" => array(
            "PARENT" => "PARAMETRS",
            "NAME" => GetMessage("RR_QTZ_CATEGORY_PAGE_PARAM"),
            "TYPE" => "STRING",
            "DEFAULT" => '={$_REQUEST["SECTION_ID"]}',
        ),
	),
);

?>