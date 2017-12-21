<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global CMain $APPLICATION */
/** @var array $arResult */
/** @var CBitrixComponent $this */
$ajaxMode = isset($templateData['BLOG']['BLOG_FROM_AJAX']) && $templateData['BLOG']['BLOG_FROM_AJAX'];
if (!$ajaxMode)
{
	CJSCore::Init(array('window', 'ajax'));
}

if (isset($templateData['BLOG_USE']) && $templateData['BLOG_USE'] == 'Y')
{
	if ($ajaxMode)
	{
		$arBlogCommentParams = array(
			'SEO_USER' => 'N',
			'ID' => $arResult['BLOG_DATA']['BLOG_POST_ID'],
			'BLOG_URL' => $arResult['BLOG_DATA']['BLOG_URL'],
			'PATH_TO_SMILE' => $arParams['PATH_TO_SMILE'],
			'COMMENTS_COUNT' => $arParams['COMMENTS_COUNT'],
			"DATE_TIME_FORMAT" => $DB->DateFormatToPhp(FORMAT_DATETIME),
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"AJAX_POST" => $arParams["AJAX_POST"],
			"AJAX_MODE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"SIMPLE_COMMENT" => "Y",
			"SHOW_SPAM" => $arParams["SHOW_SPAM"],
			"NOT_USE_COMMENT_TITLE" => "Y",
			"SHOW_RATING" => $arParams["SHOW_RATING"],
			"RATING_TYPE" => $arParams["RATING_TYPE"],
			"PATH_TO_POST" => $arResult["URL_TO_COMMENT"],
			"IBLOCK_ID" => $templateData['BLOG']['AJAX_PARAMS']['IBLOCK_ID'],
			"ELEMENT_ID" => $templateData['BLOG']['AJAX_PARAMS']['ELEMENT_ID'],
			"NO_URL_IN_COMMENTS" => "L"
		);
		$APPLICATION->IncludeComponent(
			'bitrix:blog.post.comment',
			'adapt',
			$arBlogCommentParams,
			$this,
			array('HIDE_ICONS' => 'Y')
		);
		return;
	}
	else
	{
		$_SESSION['IBLOCK_CATALOG_COMMENTS_PARAMS_'.$templateData['BLOG']['AJAX_PARAMS']["IBLOCK_ID"].'_'.$templateData['BLOG']['AJAX_PARAMS']["ELEMENT_ID"]] = $templateData['BLOG']['AJAX_PARAMS'];
		//$APPLICATION->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/style.css');
		$APPLICATION->SetAdditionalCSS('/bitrix/templates/bigms/components/bitrix/blog/.default/style.css');
		$APPLICATION->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/themes/green/style.css');
		if ($templateData['BLOG']['AJAX_PARAMS']['SHOW_RATING'] == 'Y')
			\Bitrix\Main\Page\Asset::getInstance()->addJs('/bitrix/js/main/rating.js');
	}
}

if (!$ajaxMode)
{
	if (isset($templateData['FB_USE']) && $templateData['FB_USE'] == "Y")
	{
		if (isset($arParams["FB_USER_ADMIN_ID"]) && strlen($arParams["FB_USER_ADMIN_ID"]) > 0)
		{
			$APPLICATION->AddHeadString('<meta property="fb:admins" content="'.$arParams["FB_USER_ADMIN_ID"].'"/>');
		}
		if (isset($arParams["FB_APP_ID"]) && $arParams["FB_APP_ID"] != '')
		{
			$APPLICATION->AddHeadString('<meta property="fb:app_id" content="'.$arParams["FB_APP_ID"].'"/>');
		}
	}

	if (isset($templateData['VK_USE']) && $templateData['VK_USE'] == "Y")
	{
		$APPLICATION->AddAdditionalJS('<script src="http://userapi.com/js/api/openapi.js" type="text/javascript" charset="windows-1251"></script>');
	}

	if (isset($templateData['TEMPLATE_THEME']))
	{
		$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
	}
}
?>

