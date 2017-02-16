<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arLink = Array();
foreach ($arResult as $key => $arItem){
	$arLink[$key] = $arItem['LINK'];
}

$idIBlock = 0;
if ($arParams['ROOT_MENU_TYPE'] == 'catalogs1'){
	$idIBlock = 10;
}
if ($arParams['ROOT_MENU_TYPE'] == 'catalogs2'){
	$idIBlock = 12;
}
$uf_arresult = CIBlockSection::GetList(Array('SORT' => 'ASC'), Array('IBLOCK_ID' => $idIBlock, 'ACTIVE' => 'Y'), false, array('UF_TITLE', 'UF_TEXT', 'UF_ACTIVE', 'UF_CUSTOM_URL'));
while ($uf_value = $uf_arresult->GetNext()) {
	$key = array_search($uf_value['SECTION_PAGE_URL'], $arLink);
	if(($uf_value['UF_ACTIVE'] == 3 || $uf_value['UF_ACTIVE'] == 4) && $uf_value['UF_CUSTOM_URL'] != '' && $key !== false){
		$arResult[$key]['LINK'] = $uf_value['UF_CUSTOM_URL'];
	}
//	if ( !is_null($uf_value['UF_CUSTOM_URL']) && $key !== false ){
//		$arResult[$key]['LINK'] = $uf_value['UF_CUSTOM_URL'];
//	}
}