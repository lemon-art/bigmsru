<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule("iblock");
$arLink = Array();
foreach ($arResult as $key => $arItem){
	$arLink[$key] = $arItem['LINK'];
}

$idIBlock = 0;
if ($arParams['ROOT_MENU_TYPE'] == 'catalogs1'){
	$idIBlock = 10;
	$idIBlockStruct = 17;
}
if ($arParams['ROOT_MENU_TYPE'] == 'catalogs2'){
	$idIBlock = 12;
	$idIBlockStruct = 16;
}


foreach($arResult as $kk=>$arItem){
	if ( $arItem["DEPTH_LEVEL"] == 1 ){
		$uf_arresult = CIBlockSection::GetList(Array('SORT' => 'ASC'), Array('IBLOCK_ID' => $idIBlockStruct, "NAME" => $arItem["TEXT"],'ACTIVE' => 'Y'), false, array('ID', 'IBLOCK_ID', 'UF_*'));
		if ($uf_value = $uf_arresult->GetNext()) {
			$arResult[$kk]['ICON'] =  $uf_value['UF_ICON'];
		}
	}
}
?>
