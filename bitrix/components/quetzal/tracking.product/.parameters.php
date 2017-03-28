<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
        "PARAMETRS" => array(
            "NAME" => GetMessage("RR_QTZ_GROUPS_PARAMETRS_TYPE"),
        ),
    ),

    "PARAMETERS" => array(
        "CARD_PRODUCT_PARAM" => array(
            "PARENT" => "PARAMETRS",
            "NAME" => GetMessage("RR_QTZ_CARD_PRODUCT_PARAM"),
            "TYPE" => "STRING",
            "DEFAULT" => '={$_REQUEST["ELEMENT_ID"]}',
        ),
	),
);
?>