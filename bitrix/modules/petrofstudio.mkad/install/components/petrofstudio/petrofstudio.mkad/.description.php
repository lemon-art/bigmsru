<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<?
$arComponentDescription = array(
	"NAME" => GetMessage("DESC_MKAD_NAME"),
	"DESCRIPTION" => GetMessage("DESC_MKAD_TEXT"),
	"ICON" => "",
	"COMPLEX" => "N",
	"PATH" => array(
		"ID" => "petrofstudio",
		"SORT" => 10000,
		"NAME" => GetMessage("DESC_MKAD_TEXT_RAZD1"),
		"CHILD" => array(
			"ID" => "mkad",
			"NAME" => GetMessage("DESC_MKAD_TEXT_RAZD2"),
			"SORT" => 10,
		)
	),
);
?>