<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

if (empty($arParams['IBLOCK_ID']) || empty($arParams['DISPLAY_PROPERTIES']) || !CModule::IncludeModule('yenisite.infoblockpropsplus')) {
	return;
}

$arColorSchemes = array('red', 'green', 'ice', 'metal', 'pink', 'yellow');
$bitronic_color_scheme = COption::GetOptionString('yenisite.market', 'color_scheme');
if ($arParams['COLOR_SCHEME'] && in_array($arParams['COLOR_SCHEME'], $arColorSchemes, true)) {

} elseif ($arParams['COLOR_SCHEME'] === "blue") {
    $arParams['COLOR_SCHEME'] = 'ice';
} elseif (in_array($bitronic_color_scheme, $arColorSchemes)) {
    $arParams['COLOR_SCHEME'] = $bitronic_color_scheme;
} else {
    $arParams['COLOR_SCHEME'] = 'red';
}

// $arParams['SECTION_ID'] > 0 - get groups for concrete section
// $arParams['SECTION_ID'] = 0 - get only common groups
// $arParams['SECTION_ID'] < 0 - get all group
if (empty($arParams['SECTION_ID']))
	$arParams['SECTION_ID'] = -1;
$arResult['PROPS_WITHOUT_GROUP'] = array();

foreach ($arParams['DISPLAY_PROPERTIES'] as $k => $arProp) {
	$arResult['PROPS_WITHOUT_GROUP'][$arProp['ID']] = $arProp['ID'];
	$arResult["DISPLAY_PROPERTIES"][$arProp['ID']] = & $arParams["DISPLAY_PROPERTIES"][$k];
}

$arInitArray = CYenisiteInfoblockpropsplus::GetInitArray(array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_ID' => intval($arParams['SECTION_ID'])));

$arResult['PROPS_COMMENTS'] = $arInitArray['PROPS_COMMENTS'];

$arResult['GROUPS'][0] = array('NAME' => GetMessage('IPEP_NO_GROUP'), 'PROPS' => &$arResult['PROPS_WITHOUT_GROUP']);
foreach ($arInitArray['PROPS_TO_GROUPS'] as $i) {
	foreach ($i as $k) {
		$arResult['GROUPS'][$k['GROUP_ID']]['NAME'] = $k['GROUP_NAME'];
		if (!empty($k['PROPERTY_ID']) && isset($arResult['PROPS_WITHOUT_GROUP'][$k['PROPERTY_ID']])) {
			$arResult['GROUPS'][$k['GROUP_ID']]['PROPS'][] = $k['PROPERTY_ID'];
			unset($arResult['PROPS_WITHOUT_GROUP'][$k['PROPERTY_ID']]);
		}
	}
}

foreach ($arResult['GROUPS'] as $k => $v) {
	if (count($v['PROPS']) == 0) {
		unset($arResult['GROUPS'][$k]);
	}
}

unset($arInitArray);

$this->IncludeComponentTemplate();
