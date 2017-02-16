<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

/*
$aMenuLinksExt=$APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
	"IS_SEF" => "Y",
	"SEF_BASE_URL" => "/catalog/bytovaya/",
	"SECTION_PAGE_URL" => "#SECTION_CODE#/",
	"DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#",
	"IBLOCK_TYPE" => "1c_catalog",
	"IBLOCK_ID" => "12",
	"DEPTH_LEVEL" => "4",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000"
	),
	false
);
*/

$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
	"IS_SEF" => "Y",
	"SEF_BASE_URL" => "/",
	"SECTION_PAGE_URL" => "#SECTION_CODE#",
	"DETAIL_PAGE_URL" => "#SECTION_CODE#",
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "16",
	"DEPTH_LEVEL" => "4",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000"
),
	false
);

foreach ($aMenuLinksExt as $k => $v) {
	if (!empty($v[1])) {
		$v[1] = str_replace('%2F', '/', $v[1]);
		//print_r($v[1]);
		$aMenuLinksExt[$k][1] = str_replace('//', '/', $v[1]);
	}
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>