<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/custom/catalog.smart.filter/class.php");

//$smart = new CBitrixCatalogSmartFilter;
CModule::IncludeModule("iblock");

$url = '/catalog/bytovaya/vanny/filter/material-is-97b8d062-e971-11e3-84be-00215e52d78a/apply/';





$smartParts = explode("/", $url);
$result = array();
$SECTION_CODE = $smartParts[3];
//находим раздел
$arFilter = Array('IBLOCK_ID'=>Array(10, 12), 'CODE'=>$SECTION_CODE );
$db_list = CIBlockSection::GetList(Array(), $arFilter, true, Array("ID", "IBLOCK_ID"));
if ($ar_result = $db_list->GetNext()){
	$IBLOCK_ID = $ar_result["IBLOCK_ID"]; //определили какой инфоблок
	$SECTION_ID = $ar_result["IBLOCK_ID"]; //определили какой инфоблок
}


	$arNewUrl = Array(); //в этот массив собираем все параметры по фильтру
	$arNewUrl[] = "SECTION_CODE=".$SECTION_CODE;

foreach ($smartParts as $smartPart){
	//echo $smartPart . "<br>";
	$smartPart = preg_split("/-(is|or)-/", $smartPart, -1, PREG_SPLIT_DELIM_CAPTURE);
	if ( count($smartPart) > 1 ){
		$itemName = "";
		$itemID = "";
		$arPropEnum = Array();

		
		foreach ($smartPart as $i => $smartElement){
			if ( $i == 0 ){
				$itemName = $smartElement; //название свойства
				
				//определяем ID свойства
				$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("CODE"=>$smartElement, "IBLOCK_ID"=>$IBLOCK_ID));
				if ($prop_fields = $properties->GetNext()){
					$itemID = $prop_fields["ID"]; //ID свойства
					echo $prop_fields["PROPERTY_TYPE"];
				}
				
				if ( $prop_fields["PROPERTY_TYPE"] == 'L' ){
					//получаем значения свойства
					$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_ID, "CODE"=>$smartElement));
					while($enum_fields = $property_enums->GetNext()){
						
						
						
						//получаем ключ 
						$key = $enum_fields["ID"];
						$htmlKey = htmlspecialcharsbx($key);
						$keyCrc = abs(crc32($htmlKey));

						$arPropEnum[$enum_fields["XML_ID"]] = $keyCrc;
					}
				}
				

			}
			else {
				
				if ( $smartElement !== 'is' && $smartElement !== 'or' ){
				
					if ( $arPropEnum[$smartElement] ){
						$arNewUrl[] = "arrFilter_".$itemID."_".$arPropEnum[$smartElement]."=Y";
					}
					else {
						//получаем ключ 
						$key = $smartElement;
						$htmlKey = htmlspecialcharsbx($key);
						$keyCrc = abs(crc32($htmlKey));
						$arNewUrl[] = "arrFilter_".$itemID."_".$keyCrc."=Y";
					}
				}
				
			}
			
			
		
		}
	}
}
$arNewUrl[] = "set_filter=y";
$filterUrl = "/".$smartParts[1]."/".$smartParts[2]."/?". implode("&", $arNewUrl);
echo $filterUrl;
?>

