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

//		//открываем файл с массивом соответствия адресов страниц
//		$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt");
//		$arUrlData = unserialize( $data );
//
//$uf_arresult = CIBlockSection::GetList(Array('SORT' => 'ASC'), Array('IBLOCK_ID' => $idIBlock, 'ACTIVE' => 'Y'), false, array('UF_TITLE', 'UF_TEXT', 'UF_ACTIVE', 'UF_CUSTOM_URL'));
//while ($uf_value = $uf_arresult->GetNext()) {
//	$key = array_search($uf_value['SECTION_PAGE_URL'], $arLink);
//	if(($uf_value['UF_ACTIVE'] == 3 || $uf_value['UF_ACTIVE'] == 4) && $uf_value['UF_CUSTOM_URL'] != '' && $key !== false){
//		$arResult[$key]['LINK'] = $uf_value['UF_CUSTOM_URL'];
//
//	}
//
//	if ( $arUrlData[$arResult[$key]['LINK']] ){
//		$arResult[$key]['LINK'] =  $arUrlData[$arResult[$key]['LINK']]; //заменяем ссылку
//	}
////	if ( !is_null($uf_value['UF_CUSTOM_URL']) && $key !== false ){
////		$arResult[$key]['LINK'] = $uf_value['UF_CUSTOM_URL'];
////	}
//}
//foreach($arResult as $kk=>$arItem){
//	if ( $arItem["DEPTH_LEVEL"] == 1 ){
//		$uf_arresult = CIBlockSection::GetList(Array('SORT' => 'ASC'), Array('IBLOCK_ID' => $idIBlockStruct, "NAME" => $arItem["TEXT"],'ACTIVE' => 'Y'), false, array('ID', 'IBLOCK_ID', 'UF_*'));
//		if ($uf_value = $uf_arresult->GetNext()) {
//			$arResult[$kk]['ICON'] =  $uf_value['UF_ICON'];
//		}
//	}
//}
//
