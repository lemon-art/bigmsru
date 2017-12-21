<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

$arCodeType = array(
	'PRODUCT'  => GetMessage('RR_QTZ_PRODUCT'),
	'SECTION'  => GetMessage('RR_QTZ_SECTION'),
	'INDEX'    => GetMessage('RR_QTZ_INDEX'),
	'PERSONAL' => GetMessage('RR_QTZ_PERSONAL'),
	'CART'     => GetMessage('RR_QTZ_CART'),
	'SEARCH'   => GetMessage('RR_QTZ_SEARCH'),
	'NOITEMS'  => GetMessage('RR_QTZ_NOITEMS'),
);

$arComponentParameters = array(
	'GROUPS'     => array(
		'TOP'       => array(
			'NAME' => GetMessage('RR_QTZ_GROUPS_SELECT_TYPE'),
			'SORT' => 100,
		),
		'PARAMETRS' => array(
			'NAME' => GetMessage('RR_QTZ_GROUPS_PARAMETRS_TYPE'),
			'SORT' => 200,
		),
	),
	'PARAMETERS' => array(
		'WIDGET_TYPE'        => array(
			'PARENT'  => 'TOP',
			'NAME'    => GetMessage('RR_QTZ_WIDGET_TYPE'),
			'TYPE'    => 'LIST',
			'REFRESH' => 'Y',
			'VALUES'  => $arCodeType,
		),
		'CARD_PRODUCT_PARAM' => array(
			'PARENT'  => 'PARAMETRS',
			'NAME'    => GetMessage('RR_QTZ_CARD_PRODUCT_PARAM'),
			'TYPE'    => 'STRING',
			'DEFAULT' => '={$_REQUEST["ELEMENT_ID"]}',
		)
	),
);

if ($arCurrentValues['WIDGET_TYPE'] == 'SECTION') {
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_METOD']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_PARAM']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCTS_PARAM_LIST']);
	$arComponentParameters['PARAMETERS']['CARD_SECTION_PARAM'] = array(
		'PARENT'  => 'PARAMETRS',
		'NAME'    => GetMessage('RR_QTZ_CARD_SECTION_PARAM'),
		'TYPE'    => 'STRING',
		'DEFAULT' => '={$_REQUEST["SECTION_ID"]}',
	);
}

if ($arCurrentValues['WIDGET_TYPE'] == 'INDEX') {
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_METOD']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_PARAM']);
	unset($arComponentParameters['PARAMETERS']['CARD_SECTION_PARAM']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCTS_PARAM_LIST']);
}

if ($arCurrentValues['WIDGET_TYPE'] == 'PERSONAL') {
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_METOD']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_PARAM']);
	unset($arComponentParameters['PARAMETERS']['CARD_SECTION_PARAM']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCTS_PARAM_LIST']);
}

if ($arCurrentValues['WIDGET_TYPE'] == 'CART') {
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_METOD']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_PARAM']);
	unset($arComponentParameters['PARAMETERS']['CARD_SECTION_PARAM']);
}

if ($arCurrentValues['WIDGET_TYPE'] == 'SEARCH') {
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_METOD']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_PARAM']);
	unset($arComponentParameters['PARAMETERS']['CARD_SECTION_PARAM']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCTS_PARAM_LIST']);
}

if ($arCurrentValues['WIDGET_TYPE'] == 'NOITEMS') {
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_METOD']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCT_PARAM']);
	unset($arComponentParameters['PARAMETERS']['CARD_SECTION_PARAM']);
	unset($arComponentParameters['PARAMETERS']['CARD_PRODUCTS_PARAM_LIST']);
	$arComponentParameters['PARAMETERS']['CARD_PRODUCT_PARAM'] = array(
		'PARENT'  => 'PARAMETRS',
		'NAME'    => GetMessage('RR_QTZ_CARD_PRODUCT_PARAM'),
		'TYPE'    => 'STRING',
		'DEFAULT' => '={$_REQUEST["ELEMENT_ID"]}',
	);
}
?>