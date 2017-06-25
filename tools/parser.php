<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/tools/class/simple_html_dom.php");

$siteName = 'http://aquasant.ru';

$arPages = Array();
$arPages[] = '/catalog/unitazy/?arrFilterCatalog_1211_3094337084=Y&arrFilterCatalog_1211_2003519797=Y&set_filter=Показать';
$arPages[] = '/catalog/unitazy/?arrFilterCatalog_1211_3094337084=Y&arrFilterCatalog_1211_2003519797=Y&set_filter=Показать&PAGEN_4=2';

$arProductPages = Array();
foreach ($arPages as $arPage){
	$arProductPages = array_merge($arProductPages, GetProductUrls( $siteName . $arPage ));
}

$arResult = Array();
$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/tools/parser_result/aquasant.csv', 'w');
foreach ($arProductPages as $arPage){
	fwrite($fp, GetParserProperty( $siteName . $arPage ) . PHP_EOL);
}
fclose($fp);




function GetProductUrls( $url ){	//парсит список элементов
	
	$arElementUrls = Array();
	$html = file_get_html($url);
	$href = $html->find('a.item_title');
	foreach($href as $element){
		$arElementUrls[] = $element->href;
	}
	$html->clear(); // подчищаем за собой
	unset($html);
	
	return $arElementUrls;

}

function GetParserProperty( $url ){	//парчит свойства элемента



$html = file_get_html($url);

$arElement = Array();

$idElement = strip_tags($html->find('.item-code', 0));
$arElement[] = $idElement;
$nameElement = strip_tags($html->find('h1', 0));
$arElement[] = $nameElement;
$arElement[] = 'http://aquasant.ru';

$arLi = $html->find('div#all_properties li');

foreach($arLi as $element){
	$propValue = strip_tags($element->find('span', 0));
	$propValue = preg_replace('|[\s]+|s', '', $propValue);
	$propName  = strip_tags($element->find('span', 1));
	$propName  = str_replace(' (см)', ', см', $propName);
	$arElement[] = $propName . $propValue;

}

	$html->clear(); // подчищаем за собой
	unset($html);
	$str = implode(';', $arElement).";";
	return $str;
}
?>

