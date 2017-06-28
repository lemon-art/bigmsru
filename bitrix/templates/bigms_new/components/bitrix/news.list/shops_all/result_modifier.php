<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
  $arSections = Array();
  $arFilter = Array('IBLOCK_ID'=>$arResult["ID"], 'GLOBAL_ACTIVE'=>'Y');
  $db_list = CIBlockSection::GetList(Array('sort'=>'asc'), $arFilter, true, Array("ID", "NAME", "CODE"));
  while($ar_result = $db_list->GetNext()) {
	$arSections[] = Array(
		"ID" => $ar_result['ID'],
		"NAME" => $ar_result['NAME'],
		"CODE" => $ar_result['CODE']
	);
  }
  $arResult["SECTIONS"] = $arSections;


foreach($arResult["ITEMS"] as $k=>$arItem){
	$arSelect = Array("ID", "NAME", "PROPERTY_MANUFACTURER", "SECTION_ID", "IBLOCK_SECTION_ID");
	$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE"=>"Y", "PROPERTY_MANUFACTURER"=>$arItem["ID"], "INCLUDE_SUBSECTIONS"=>"Y", "SECTION_ID"=>$arParams['SECTION']);
	$res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize"=>1), $arSelect);
	while($ar_fields = $res->GetNext())
	{
		//$nav = CIBlockSection::GetNavChain(false, $ar_fields["IBLOCK_SECTION_ID"]);
		//while($ar_nav = $nav->GetNext())
		//{
		// if($ar_nav["ID"] == $arParams['SECTION']){
		$arResult["ITEMS"][$k]["USE"] = "Y";
		// }
		/* echo ' $arParams[SECTION] '. $arParams['SECTION'].'<br />';
		echo ' $ar_nav[ID] '. $ar_nav['ID'].'<br />';
		echo '<hr />'; */

		//}
	}
}

/* echo '<pre>';
print_r($arResult["ITEMS"]);
echo '</pre>'; */
?>