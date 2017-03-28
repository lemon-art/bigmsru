<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
        "PARAMETRS" => array(
            "NAME" => GetMessage("RR_QTZ_GROUPS_PARAMETRS_TYPE"),
        ),
    ),
    
    "PARAMETERS" => array(
        "ORDER_PARAM_TRANSACTION" => array(
            "PARENT" => "PARAMETRS",
            "NAME" => GetMessage("RR_QTZ_ORDER_PARAM_TRANSACTION"),
            "TYPE" => "STRING",
            "DEFAULT" => '={$_REQUEST["ORDER_ID"]}',
        ),
	),
);
?>