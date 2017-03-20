<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

/* ======= RESERVED FOR IBLOCK/SECTION SELECTION ==========
 * ========================================================
$arTypesEx = Array("all"=> GetMessage("CP_BMS_ALL"));
$db_iblock_type = CIBlockType::GetList(Array("SORT"=>"ASC"));
while($arRes = $db_iblock_type->Fetch())
	if($arIBType = CIBlockType::GetByIDLang($arRes["ID"], LANG))
		$arTypesEx[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arIBType["NAME"];



$arIBlocks = Array("all"=> GetMessage("CP_BMS_ALL"));
if(in_array("all", $arCurrentValues["IBLOCK_TYPE"])) $arCurrentValues["IBLOCK_TYPE"] = array();


$db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"], "TYPE" => $arCurrentValues["IBLOCK_TYPE"]));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];


if(in_array("all", $arCurrentValues["IBLOCK_ID"])) $arCurrentValues["IBLOCK_ID"] = array();
$db_list = CIBlockSection::GetList(Array("IBLOCK_ID"=>"asc"), Array('IBLOCK_ID'=>$arCurrentValues["IBLOCK_ID"]), false);
while($ar_result = $db_list->Fetch()){
    $ibl = CIBlock::GetByID($ar_result[IBLOCK_ID])->Fetch();
	$arSection[$ar_result["ID"]] = "[".$ar_result["ID"]."] "."[{$ibl[NAME]}] ".$ar_result["NAME"];
}
 * ====== END OF RESERVED BLOCK =======
 */

$depth_level = array(
	"1" => GetMessage("CP_BMS_DEPTH_LEVEL_1"),
	"2" => GetMessage("CP_BMS_DEPTH_LEVEL_2"),
	"3" => GetMessage("CP_BMS_DEPTH_LEVEL_3"),
	"4" => GetMessage("CP_BMS_DEPTH_LEVEL_4")
);


$arComponentParameters = array(
	"PARAMETERS" => array(
        "COLOR_SCHEME" => Array(
            "PARENT" => "",
            "NAME" => GetMessage("YS_BS_COLOR"),
            "TYPE" => "LIST",
            "VALUES" => array("red" => GetMessage("YS_BS_COLOR_RED"), "green" => GetMessage("YS_BS_COLOR_GREEN"), "ice" => GetMessage("YS_BS_COLOR_BLUE"), "metal" => GetMessage("YS_BS_COLOR_METAL"), "pink" => GetMessage("YS_BS_COLOR_PINK"), "yellow" => GetMessage("YS_BS_COLOR_YELLOW")),
            "ADDITIONAL_VALUES" => "Y",
        ),
		"DISPLAY_PROPERTIES" => Array(
			"PARENT" => "BASE",
			"NAME"=>GetMessage("DISPLAY_PROPERTIES"),
			"TYPE"=>"STRING",
			"DEFAULT"=>'={$arResult["DISPLAY_PROPERTIES"]}',
		),
		"IBLOCK_ID" => Array(
			"PARENT" => "BASE",
			"NAME"=>GetMessage("IBLOCK_ID_PARAM"),
			"TYPE"=>"STRING",
			"DEFAULT"=>'={$arParams["IBLOCK_ID"]}',
		),
		"SHOW_PROPERTY_VALUE_DESCRIPTION" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SHOW_PROPERTY_VALUE_DESCRIPTION"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y"
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
	),
);
?>
