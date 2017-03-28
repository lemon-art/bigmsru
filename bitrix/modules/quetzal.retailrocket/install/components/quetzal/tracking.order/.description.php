<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?$arComponentDescription = array(
	"NAME" => GetMessage("RR_QTZ_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("RR_QTZ_COMPONENT_DESCRIPTION"),
	"ICON" => "",
	"PATH" => array(
		"ID" => "retailrocket",
		"NAME" => GetMessage("RR_QTZ_NAME_FOLDER"),
		"CHILD" => array(
			"ID" => "tracking",
			"NAME" => GetMessage("RR_QTZ_FOLDER_COMPONENT_NAME"),
		),
	),
);?>