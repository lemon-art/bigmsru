<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"GROUPS" => array(
	    "MKAD_SETTINGS" => array(
		    "NAME" => GetMessage("MKAD_SETTINGS_PHR")
		),
		"PARAMS" => array(
		    "NAME" => GetMessage("PARAMS_PHR")
		),
		"DOP_PARAMS" => array(
		    "NAME" => GetMessage("DOP_PARAMS")
		),
	),
	"PARAMETERS" => array(
		"COST_BY_KM" => array(
			"PARENT" => "MKAD_SETTINGS",
			"NAME" => GetMessage("COST_BY_KM"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "30",
			"REFRESH" => "Y",
		),
		"ADDITIONAL_TARIF" => array(
			"PARENT" => "MKAD_SETTINGS",
			"NAME" => GetMessage("ADDITIONAL_TARIF"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "250",
			"REFRESH" => "Y",
		),
		"SUMMA_ZAKAZ_TARIF" => array(
			"PARENT" => "MKAD_SETTINGS",
			"NAME" => GetMessage("SUMMA_ZAKAZ_TARIF"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "2000",
			"REFRESH" => "Y",
		),
		"MAX_DISTANCE" => array(
			"PARENT" => "MKAD_SETTINGS",
			"NAME" => GetMessage("MAX_DISTANCE"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "50",
			"REFRESH" => "Y",
		),
		"COST_FREE_DELIVERY" => array(
			"PARENT" => "PARAMS",
			"NAME" => GetMessage("COST_FREE_DELIVERY"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "2000",
			"REFRESH" => "Y",
		),
		"COST_DELIVERY_MKAD" => array(
			"PARENT" => "PARAMS",
			"NAME" => GetMessage("COST_DELIVERY_MKAD"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "300",
			"REFRESH" => "Y",
		),
		"BLIZ_VREMYA_DOSTAVKI" => array(
			"PARENT" => "DOP_PARAMS",
			"NAME" => GetMessage("BLIZ_VREMYA_DOSTAVKI"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "",
			"REFRESH" => "Y",
		),
	),
);
?>