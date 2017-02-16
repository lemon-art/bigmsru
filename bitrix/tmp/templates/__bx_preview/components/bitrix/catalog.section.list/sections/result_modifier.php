<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['SECTIONS'] as &$arSection) {
	if(($arSection['UF_ACTIVE'] == 3 || $arSection['UF_ACTIVE'] == 4) && $arSection['UF_CUSTOM_URL'] != ''){
		$arSection['SECTION_PAGE_URL'] = $arSection['UF_CUSTOM_URL'];
	}
}
unset($arSection);