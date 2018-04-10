<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

		//открываем файл с массивом соответствия адресов страниц
		$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt");
		$arUrlData = unserialize( $data );
		
		

foreach ($arResult['SECTIONS'] as &$arSection) {
	if(($arSection['UF_ACTIVE'] == 3 || $arSection['UF_ACTIVE'] == 4) && $arSection['UF_CUSTOM_URL'] != ''){
		$arSection['SECTION_PAGE_URL'] = $arSection['UF_CUSTOM_URL'];
	}
	if ( $arUrlData[$arSection['SECTION_PAGE_URL']] ){
//		$arSection['SECTION_PAGE_URL'] =  $arUrlData[$arSection['SECTION_PAGE_URL']]; //заменяем ссылку
	}
}  
unset($arSection);