<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;
if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}
if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
	?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
	</script>
<?
	}
	
}
	
//global $USER;
//if($USER->IsAdmin()){

if ($arResult["NAV_RESULT"]->NavPageNomer>1) {
	$val = $APPLICATION->GetCurPageParam("", array_keys($_GET), false).($arResult["NAV_RESULT"]->NavPageNomer>1?'?PAGEN_'.$arResult["NAV_RESULT"]->NavNum.'='.($arResult["NAV_RESULT"]->NavPageNomer-1):'');
	$APPLICATION->AddHeadString('<link rel="prev" href="http://'.$_SERVER["SERVER_NAME"].$val.'"/>', true);
}

if ($arResult["NAV_RESULT"]->NavPageNomer < $arResult["NAV_RESULT"]->NavPageCount) {
	$val = $APPLICATION->GetCurPageParam("", array_keys($_GET), false).'?PAGEN_'.$arResult["NAV_RESULT"]->NavNum.'='.($arResult["NAV_RESULT"]->NavPageNomer+1);
	$APPLICATION->AddHeadString('<link rel="next" href="http://'.$_SERVER["SERVER_NAME"].$val.'"/>', true);
}

//}



/*function getNumEnding($number, $endingArray)
{
    $number = $number % 100;
    if ($number>=11 && $number<=19)
    {
        $ending=$endingArray[2];
    } else  {
        $i = $number % 10;
        switch ($i) {
            case (1): $ending = $endingArray[0]; break;
            case (2): case (3): case (4): $ending = $endingArray[1]; break;
            default: $ending=$endingArray[2]; }
    }
    return $ending;
}

$iblock_id = $arResult['PATH'][0]['IBLOCK_ID'];
$section_id = $arResult['ID'];
$items_num = '';
$minimal_price = $templateData['MINIMAL_PRICE'];
$sect = CIBlockSection::GetList(
    Array("sort"=>"asc", 'name'=>'asc'),
    Array(
        'IBLOCK_ID'=>$iblock_id,
        'ID'=>$arResult['ID'], // используется ID, а не SECTION_ID, т.к. с помощью ID выводится общее количество элементов, в т.ч и во вложенных подразделах
        'GLOBAL_ACTIVE'=>"Y",
        'CNT_ACTIVE'=>true // данный параметр позволяет получить количество только активных элементов
    ),
    true,
    array('NAME')
);
while($el = $sect->Fetch()):
    $count += $el["ELEMENT_CNT"];
endwhile;
$items_num = $count;

//$iTemplates = new \Bitrix\Iblock\InheritedProperty\SectionTemplates($iblock_id, $section_id);
if(isset($_GET['PAGEN_1'])) {
    $APPLICATION->SetPageProperty('title', $arResult['NAME']. ' - страница '.$_GET['PAGEN_1']);
    $APPLICATION->SetPageProperty('description', $arResult['NAME']. ' - страница '.$_GET['PAGEN_1']);
    $APPLICATION->SetPageProperty('keywords', $arResult['NAME']. ' - страница '.$_GET['PAGEN_1']);
} else {
    $APPLICATION->SetPageProperty('title', $arResult['NAME'].'в Москве - цена, фото');
    $APPLICATION->AddHeadString('<meta name="description" content="'. $arResult['NAME'].' - '. $items_num.' '.getNumEnding($items_num, Array('товар', 'товара', 'товаров')). ' от '.$minimal_price.' рублей. Быстрая доставка по Москве, опытный консультант в интернет-магазине."/>');
    $APPLICATION->SetPageProperty('keywords', $arResult['NAME']. ' купить, '. $arResult['NAME']. 'цена, '. $arResult['NAME']. 'фото, '. $arResult['NAME']. 'в Москве, '. $arResult['NAME']. 'стоимость');
}

if($_SERVER['REQUEST_URI'] == '/catalog/inzhenernaya/acv/') {
    $APPLICATION->SetPageProperty('title', 'Бойлеры комбинированного нагрева ACV в Москве - цена, фото');
    $APPLICATION->SetPageProperty('description', 'Бойлеры комбинированного нагрева ACV - '. $items_num.' '.getNumEnding($items_num, Array('товар', 'товара', 'товаров')). ' от '.$minimal_price.' рублей. Быстрая доставка по Москве, опытный консультант в интернет-магазине.');
    $APPLICATION->SetPageProperty('keywords', 'Бойлеры комбинированного нагрева ACV купить, Бойлеры комбинированного нагрева ACV цена, Бойлеры комбинированного нагрева ACV фото, Бойлеры комбинированного нагрева ACV в Москве, Бойлеры комбинированного нагрева ACV стоимость');
}
?>