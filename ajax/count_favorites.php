<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
\Bitrix\Main\Loader::includeModule ('sale');

$rsBasket = CSaleBasket::GetList(
    array('ID' => 'ASC'),
    array( 'FUSER_ID' => CSaleBasket::GetBasketUserID(),  'LID' => SITE_ID, 'ORDER_ID' => 'NULL', 'SUBSCRIBE' => 'N' ),
    false,
    false,
    array('ID', 'PRODUCT_ID', 'DELAY')
);
$count = 0;
while($arBasket = $rsBasket->GetNext()){
    if( $arBasket['DELAY'] == 'Y' ){
        $count++;
    }
}

echo $count;