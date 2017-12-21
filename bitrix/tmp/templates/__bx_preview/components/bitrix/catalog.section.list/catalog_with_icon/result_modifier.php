<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arFile = CFile::GetFileArray($arResult['SECTION']['PICTURE']);
$arResult['SECTION']['PICTURE_SRC'] = $arFile['SRC'];


$uf_arresult = CIBlockSection::GetList(Array('SORT' => 'ASC'), Array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['SECTION']['ID']), false, array('UF_TITLE', 'UF_TEXT'));
if ($uf_value = $uf_arresult->GetNext()) {
	$arResult['SECTION']['UF_TITLE'] = $uf_value['UF_TITLE'];
	$arResult['SECTION']['UF_TEXT'] = $uf_value['UF_TEXT'];
}

/**
 * Расстановка "мягких" переносов в словах.
 * Браузеры, которые показывают их: IE 6.0.x, Opera 7.54u2
 * В Firefox 1.0.4, Opera 7.11 не работает.
 * Поддерживается текст для русского (UTF-8) и английского языков (ANSI).
 *
 * @link     [url]http://shy.dklab.ru/newest/[/url]
 * @author   Nasibullin Rinat <rin at starlink ru>
 * @charset  ANSI
 * @version  2.0.2
 */
function hyphen_words($text)
{
	#буква (letter)
	$l = '(?:\xd0[\x90-\xbf\x81]|\xd1[\x80-\x8f\x91]  #А-я (все)
           | [a-zA-Z]
           )';

	#гласная (vowel)
	$v = '(?:\xd0[\xb0\xb5\xb8\xbe]|\xd1[\x83\x8b\x8d\x8e\x8f\x91]  #аеиоуыэюяё (гласные)
           | \xd0[\x90\x95\x98\x9e\xa3\xab\xad\xae\xaf\x81]         #АЕИОУЫЭЮЯЁ (гласные)
           | (?i:[aeiouy])
           )';

	#согласная (consonant)
	$c = '(?:\xd0[\xb1-\xb4\xb6\xb7\xba-\xbd\xbf]|\xd1[\x80\x81\x82\x84-\x89]  #бвгджзклмнпрстфхцчшщ (согласные)
           | \xd0[\x91-\x94\x96\x97\x9a-\x9d\x9f-\xa2\xa4-\xa9]                #БВГДЖЗКЛМНПРСТФХЦЧШЩ (согласные)
           | (?i:sh|ch|qu|[bcdfghjklmnpqrstvwxz])
           )';

	#специальные
	$x = '(?:\xd0[\x99\xaa\xac\xb9]|\xd1[\x8a\x8c])';   #ЙЪЬйъь (специальные)

	/*
	#алгоpитм П.Хpистова в модификации Дымченко и Ваpсанофьева
	$rules = array(
		# $1       $2
		"/($x)     ($l$l)/sx",
		"/($v)     ($v$l)/sx",
		"/($v$c)   ($c$v)/sx",
		"/($c$v)   ($c$v)/sx",
		"/($v$c)   ($c$c$v)/sx",
		"/($v$c$c) ($c$c$v)/sx"
	);
	*/

	#improved rules by D. Koteroff
	$rules = array(
		# $1       $2
		"/($x)     ($l$l)/sx",
		"/($v$c$c) ($c$c$v)/sx",
		"/($v$c$c) ($c$v)/sx",
		"/($v$c)   ($c$c$v)/sx",
		"/($c$v)   ($c$v)/sx",
		"/($v$c)   ($c$v)/sx",
		"/($c$v)   ($v$l)/sx",
	);

	#\xc2\xad = &shy;
	return preg_replace($rules, "$1\xc2\xad$2", $text);
}

foreach ($arResult['SECTIONS'] as &$arSection) {
	$arSection['NAME'] = hyphen_words($arSection['NAME']);
	if(($arSection['UF_ACTIVE'] == 3 || $arSection['UF_ACTIVE'] == 4) && $arSection['UF_CUSTOM_URL'] != ''){
		$arSection['SECTION_PAGE_URL'] = $arSection['UF_CUSTOM_URL'];
	}
}
unset($arSection);