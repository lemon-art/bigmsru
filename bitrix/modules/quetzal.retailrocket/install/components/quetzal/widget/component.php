<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

if (CModule::IncludeModule('quetzal.retailrocket')) {

	// Для виджета рекомендаций на странице корзины, необходимо собрать ID товаров
	if ($arParams['WIDGET_TYPE'] == 'CART') {
		CModule::IncludeModule('sale');

		$cardProductId = '';
		$arProductId = array();

		$dbBasket = CSaleBasket::GetList(
			array('NAME' => 'ASC', 'ID' => 'ASC'),
			array(
				'FUSER_ID' => CSaleBasket::GetBasketUserID(),
				'LID'      => SITE_ID,
				'ORDER_ID' => 'NULL'
			),
			false,
			false,
			array('PRODUCT_ID')
		);
		while ($basket = $dbBasket->Fetch()) {
			$arProductId[] = $basket['PRODUCT_ID'];
		}

		$cardProductId = implode(',', $arProductId);
	}

	// Итоговый массив
	$arResult = array(
		'WIDGET_DATA'   => array(
			'WIDGET_TYPE'         => $arParams['WIDGET_TYPE'],
			'PRODUCT_PARAM'       => $arParams['CARD_PRODUCT_PARAM'],
			'SECTION_PARAM'       => $arParams['CARD_SECTION_PARAM'],
			'PRODUCTS_LIST_PARAM' => $cardProductId
		),
		'WIDGET_PARAMS' => array(),
		'CACHE_TIME'    => $arParams['CACHE_TIME'],
	);

	$apiRetail = new RetailRocketClass;

	// Список параметров для работы с API
	$strEmail = COption::GetOptionString('quetzal.retailrocket', 'retail_email', false, false);
	$strPass = COption::GetOptionString('quetzal.retailrocket', 'retail_pass', false, false);
	$strPartnerId = COption::GetOptionString('quetzal.retailrocket', 'retail_partner_id', false, false);
	$strError = '0';
	$arWidget = array();

	// Получаем новую сессию
	$arSession = $apiRetail->retailSession($strEmail, $strPass);

	// Получаем список виджетов
	$arWidget = $apiRetail->retailWidget($strPartnerId, $arSession['VALUE']);

	// Результат сохраняем в массив
	if ($arWidget['ERROR'] > 0) {
		$strError = '1';
	} else {
		$i = 0;
		while ($arWidget['LIST'][$i]) {
			$type = $arWidget['LIST'][$i]['TYPE'];
			if (($arParams['WIDGET_TYPE'] === 'PRODUCT') and ($type == 0)) {
				$arResult['WIDGET_PARAMS']['ID'] = $arWidget['LIST'][$i]['ID'];
			}
			if (($arParams['WIDGET_TYPE'] === 'SECTION') and ($type == 3)) {
				$arResult['WIDGET_PARAMS']['ID'] = $arWidget['LIST'][$i]['ID'];
			}
			if (($arParams['WIDGET_TYPE'] === 'PERSONAL') and ($type == 1)) {
				$arResult['WIDGET_PARAMS']['ID'] = $arWidget['LIST'][$i]['ID'];
				$arResult['WIDGET_PARAMS']['TYPE'] = 'personal';
			}
			if (($arParams['WIDGET_TYPE'] === 'INDEX') and ($type == 4)) {
				$arResult['WIDGET_PARAMS']['ID'] = $arWidget['LIST'][$i]['ID'];
				$arResult['WIDGET_PARAMS']['TYPE'] = 'main-page';
			}
			if (($arParams['WIDGET_TYPE'] === 'CART') and ($type == 5)) {
				$arResult['WIDGET_PARAMS']['ID'] = $arWidget['LIST'][$i]['ID'];
				$arResult['WIDGET_PARAMS']['TYPE'] = 'cart';
			}
			if (($arParams['WIDGET_TYPE'] === 'SEARCH') and ($type == 6)) {
				$arResult['WIDGET_PARAMS']['ID'] = $arWidget['LIST'][$i]['ID'];
				$arResult['WIDGET_PARAMS']['TYPE'] = 'search';
			}
			if (($arParams['WIDGET_TYPE'] === 'NOITEMS') and ($type == 7)) {
				$arResult['WIDGET_PARAMS']['ID'] = $arWidget['LIST'][$i]['ID'];
				$arResult['WIDGET_PARAMS']['TYPE'] = 'forNotAvailableItem';
			}
			$i++;
		}
	}

	$this->IncludeComponentTemplate();
}
?>