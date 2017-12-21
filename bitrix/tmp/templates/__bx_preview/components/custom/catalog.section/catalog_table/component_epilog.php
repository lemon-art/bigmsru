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

if ($arResult["NAV_RESULT"]->NavPageNomer>1) {
	$val = $APPLICATION->GetCurPageParam("", array_keys($_GET), false).($arResult["NAV_RESULT"]->NavPageNomer>1?'?PAGEN_'.$arResult["NAV_RESULT"]->NavNum.'='.($arResult["NAV_RESULT"]->NavPageNomer-1):'');
	$APPLICATION->AddHeadString('<link rel="prev" href="http://'.$_SERVER["SERVER_NAME"].$val.'"/>', true);
}

if ($arResult["NAV_RESULT"]->NavPageNomer < $arResult["NAV_RESULT"]->NavPageCount) {
	$val = $APPLICATION->GetCurPageParam("", array_keys($_GET), false).'?PAGEN_'.$arResult["NAV_RESULT"]->NavNum.'='.($arResult["NAV_RESULT"]->NavPageNomer+1);
	$APPLICATION->AddHeadString('<link rel="next" href="http://'.$_SERVER["SERVER_NAME"].$val.'"/>', true);
}
?>