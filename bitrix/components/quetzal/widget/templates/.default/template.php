<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

if ($arResult['WIDGET_DATA']['PRODUCT_PARAM']) {
	$idValue = $arResult['WIDGET_DATA']['PRODUCT_PARAM'];
}
if ($arResult['WIDGET_DATA']['SECTION_PARAM']) {
	$idValue = $arResult['WIDGET_DATA']['SECTION_PARAM'];
}
if ($arResult['WIDGET_DATA']['PRODUCTS_LIST_PARAM']) {
	$idValue = $arResult['WIDGET_DATA']['PRODUCTS_LIST_PARAM'];
}
?>
<div class="rr-widget"
     <? if ($arResult["WIDGET_PARAMS"]["TYPE"]): ?>data-rr-widget-type="<?= $arResult["WIDGET_PARAMS"]["TYPE"] ?>"<? endif; ?>
     <? if ($arResult["WIDGET_DATA"]["PRODUCT_PARAM"]): ?>data-rr-widget-product-id="<?= $idValue ?>"<? endif; ?>
     <? if ($arResult["WIDGET_DATA"]["SECTION_PARAM"]): ?>data-rr-widget-category-id="<?= $idValue ?>"<? endif; ?>
     <? if ($arResult["WIDGET_DATA"]["PRODUCTS_LIST_PARAM"]): ?>data-rr-widget-products-id="<?= $idValue ?>"<? endif; ?>
     <? if ($arResult["WIDGET_PARAMS"]["TYPE"] === "main-page"): ?>data-rr-widget-category-id="0"<? endif; ?>
     data-rr-widget-id="<?= $arResult["WIDGET_PARAMS"]["ID"] ?>"
     data-rr-widget-width="100%">
</div>
    
