<?php
// @codingStandardsIgnoreStart
use CRoistatUtils as Utils;

$CURRENCY = COption::GetOptionString('sale', 'default_currency', '');
$APPLICATION->RestartBuffer();

$arRes = array();
$arRes['statuses'] = array();
$arRes['orders'] = array();

$arStatusesIDs = array();
$rsStatus = CSaleStatus::GetList(array(), array('LID' => 'ru'));
while ($arStatus = $rsStatus->GetNext()) {
    if (in_array($arStatus['ID'], $arStatusesIDs)) {
        continue;
    }
    $arStatusesIDs[] = $arStatus['ID'];
    $arRes['statuses'][] = array(
        'id'   => $arStatus['ID'],
        'name' => $arStatus['NAME']
    );
}

$arFilter = array(
    '>DATE_UPDATE' => ConvertTimeStamp($_REQUEST['date']),
);


$arOrderBasket = array();
$arProductID = array();

$rsOrder = CSaleOrder::GetList(array('ID' => 'DESC'), $arFilter);
while ($arOrder = $rsOrder->GetNext()) {
    $arJSOrder = array(
        'id' => $arOrder['ID'],
        'date_create' => MakeTimeStamp($arOrder['DATE_INSERT'], 'DD.MM.YYYY HH:MI:SS'),
        'date_update' => MakeTimeStamp($arOrder['DATE_UPDATE'], 'DD.MM.YYYY HH:MI:SS'),
        'status' => $arOrder['STATUS_ID'],
        'price' => round($arOrder['PRICE']),
        'client_id' => $arOrder['USER_ID'],
        'fields' => array(
            'SITE_ID' => $arOrder['LID'],
        ),
    );

    $dbBasket = CSaleBasket::GetList(
        array('NAME' => 'ASC'),
        array('ORDER_ID' => $arOrder['ID']),
        false,
        false,
        array('ID', 'QUANTITY', 'PRODUCT_ID')
    );
    while ($arBasket = $dbBasket->GetNext()) {
        $arOrderBasket[$arOrder['ID']][$arBasket['PRODUCT_ID']] = $arBasket['QUANTITY'];
		//economy memory
        if (!in_array($arBasket['PRODUCT_ID'], $arProductID))
            $arProductID[] = $arBasket['PRODUCT_ID'];
    }


    $db_props = CSaleOrderPropsValue::GetList(
        array(),
        array('ORDER_ID' => $arOrder['ID']),
        false,
        false,
        array('ID', 'CODE', 'VALUE', 'ORDER_PROPS_ID', 'PROP_TYPE', 'PROP_IS_PAYER')
    );

    while ($arProps = $db_props->Fetch()) {
        if ($arProps['CODE'] == 'ROISTAT_VISIT') {
            $arJSOrder['visit'] = $arProps['VALUE'];
        } elseif (strtolower($arProps['CODE']) == 'cost') {
            $arJSOrder['cost'] = $arProps['VALUE'];
        } else {
            $arCurOrderPropsTmp = CSaleOrderProps::GetRealValue(
                $arProps['ORDER_PROPS_ID'],
                $arProps['CODE'],
                $arProps['PROP_TYPE'],
                $arProps['VALUE'],
                LANGUAGE_ID
            );
            foreach ($arCurOrderPropsTmp as $key => $value) {
                $arJSOrder['fields'][$key] = $value;
            }
        }
    }
    $arRes['orders'][] = $arJSOrder;
}

/**
 * @param string $productId
 * @param string $quantity
 * @return int
 */
function getOrderCost($productId, $quantity)
{
	static $productsCost;
	global $arProductID;

	if ($productsCost === null) 
	{
		$productsCost = array();
		$dbProducts = CCatalogProduct::GetList(array(), array('ID' => $arProductID));
		while ($arProduct = $dbProducts->Fetch()) 
		{
			$productsCost[$arProduct['ID']] = $arProduct['PURCHASING_PRICE'];
		}
	}
	
	if (array_key_exists($productId, $productsCost) && $productsCost[$productId] !== null)
	{
		return $productsCost[$productId] * $quantity;
	}
	else
	{
		return 0;
	}
}

foreach ($arRes['orders'] as $key => $orderData) {
    if (array_key_exists('cost', $arRes['orders'][$key]) && $arRes['orders'][$key]['cost'] !== '') {
        continue;
    }

    $orderCost = 0;
    foreach ($arOrderBasket[$orderData['id']] as $productId => $quantity) {
        $orderCost = $orderCost + getOrderCost($productId, $quantity);
    }
    $arRes['orders'][$key]['cost'] = $orderCost;
}

$utils = new Utils;
$response = $arRes;

if (SITE_CHARSET !== 'UTF-8') {
    $response = $utils->convertToUTF8(SITE_CHARSET, $response);
}
if ($response === null || $response === false) {
    $response = array('status' => 'error', 'message' => 'Failed to encode non-UTF8 data.');
}

echo $utils->jsonResponse($response);
// @codingStandardsIgnoreEnd