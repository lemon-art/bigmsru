<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

foreach ($arResult['ITEMS'] as $key => $item) {
    $res = CIBlockSection::GetByID($item['IBLOCK_SECTION_ID']);
    if($ar_res = $res->GetNext()) {
        $arResult['ITEMS'][$key]['SECTION_CODE'] = $ar_res['CODE'];
        $arResult['ITEMS'][$key]['SECTION_NAME'] = $ar_res['NAME'];
    }
}

$sections = CIBlockSection::getList(array(), array('IBLOCK_ID' => 3));
while ($section = $sections->GetNext()) {
    $arResult['SECTIONS'][$section['CODE']] = $section['NAME'];
}
?>