<?//header("Content-Security-Policy: default-src 'self' *.bigms.ru bigms.ru; script-src 'self' 'unsafe-inline' 'unsafe-eval' *.bigms.ru bigms.ru *.mail.ru mail.ru *.imgsmail.ru imgsmail.ru *.google.ru google.ru *.google-analytics.com google-analytics.com *.vk.com vk.com *.facebook.net facebook.net *.yandex.ru yandex.ru yandex.st *.yandex.st https://dl.metabar.ru dl.metabar.ru *.googleapis.com *.gstatic.com gstatic.com *.googlesyndication.com *.doubleclick.net *.google.com google.com *.twitter.com twitter.com https://*.googleapis.com https://*.gstatic.com https://gstatic.com https://*.googlesyndication.com https://api-maps.yandex.ru https://*.google.com https://*.google-analytics.com https://google-analytics.com https://*.yandex.ru; frame-src 'self' *.bigms.ru bigms.ru *.mail.ru mail.ru https://*.google.com *.twitter.com twitter.com https://*.twitter.com *.facebook.com facebook.com *.vk.com vk.com https://*.facebook.com https://vk.com *.yandex.ru yandex.ru yandex.st *.yandex.st https://dl.metabar.ru dl.metabar.ru *.googleapis.com *.gstatic.com gstatic.com *.googlesyndication.com *.doubleclick.net youtube.ru youtube.com *.youtube.ru *.youtube.com https://youtube.ru https://youtube.com https://*.youtube.ru https://*.youtube.com apis.google.com https://*.googleapis.com https://*.gstatic.com https://gstatic.com https://*.googlesyndication.com https://*.doubleclick.net https://apis.google.com; connect-src 'self' *.bigms.ru bigms.ru mc.yandex.ru https://translate.googleapis.com https://pipe.skype.com *.google-analytics.com google-analytics.com https://*.google-analytics.com https://google-analytics.com https://*.yandex.ru; style-src 'self' 'unsafe-inline' 'unsafe-eval *.bigms.ru bigms.ru *.googleapis.com *.gstatic.com *.yandex.ru https://*.googleapis.com https://*.gstatic.com https://*.yandex.ru data:; font-src 'self' *.bigms.ru bigms.ru *.googleapis.com *.gstatic.com *.yandex.ru https://*.googleapis.com https://*.gstatic.com https://*.yandex.ru data:;img-src 'self' *.bigms.ru bigms.ru *.vk.me vk.me *.yastatic.net yastatic.net *.cackle.me cackle.me *.addthis.com addthis.com *.vk.com vk.com *.google.ru google.ru *.yandex.ru yandex.ru yandex.st https://dl.metabar.ru dl.metabar.ru *.googlesyndication.com *.doubleclick.net *.googleapis.com *.gstatic.com https://*.yandex.ru https://*.googlesyndication.com https://*.doubleclick.net https://*.googleapis.com https://*.gstatic.com data: *.google-analytics.com google-analytics.com https://*.google-analytics.com https://google-analytics.com; object-src 'self' *.gstatic.com *.googlevideo.com googlevideo.com *.youtube.com youtube.com an.yandex.ru https://*.gstatic.com https://an.yandex.ru; report-uri ".$_SERVER["DOCUMENT_ROOT"].".csp_log.php");?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$page = $APPLICATION->GetCurPage(true);
if(CSite::InDir(SITE_DIR.'catalog/')){$isCatalog = true;}
if(CSite::InDir(SITE_DIR.'arenda/')){$isArenda = true;}
if(CSite::InDir(SITE_DIR.'about/')){$isAbout = true;}
if(CSite::InDir(SITE_DIR.'about/sertifikaty/')){$isSertifikaty = true;}
if(CSite::InDir(SITE_DIR.'articles/')){$isArticles = true;}
if(CSite::InDir(SITE_DIR.'personal/zakladki/')){$isZakladki = true;}
if(CSite::InDir(SITE_DIR.'proizvoditeli/')){$isProizvoditeli = true;}
if(CSite::InDir(SITE_DIR.'news/')){$isNews = true;}

if(CSite::InDir(SITE_DIR.'catalog/inzhenernaya')){$isInzhenernaya = true;}
if(CSite::InDir(SITE_DIR.'catalog/bytovaya/')){$isBytovaya = true;}
?>
<?
$last_symbol_url = substr($APPLICATION->GetCurPage(false), -1);
if(isset($_REQUEST) && isset($_GET) && $last_symbol_url != "/"){
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: http://www.bigms.ru".$APPLICATION->GetCurPage()."/"); 
	exit(); 
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php
	$APPLICATION->ShowViewContent('noindex');
	?>
	<?$APPLICATION->ShowHead();?>
	<title><?$APPLICATION->ShowTitle()?></title>
	
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon-194x194.png" sizes="194x194">
	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">
	
	<meta charset="utf-8" />
	<meta name="cmsmagazine" content="f1de57f03b55d6b2cebaf643bdee6d72" />
    <meta property="og:title" content='<?$APPLICATION->ShowTitle()?>' />
    <meta property="og:description" content="<?=$APPLICATION->ShowProperty("description")?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?='http://'.SITE_SERVER_NAME.$APPLICATION->GetCurPage(false)?>" />
    <meta property="og:image" content="http://www.bigms.ru/bitrix/templates/bigms/images/big-logo.png">
	
	<?if($page == "/index.php" || $page == "/kontakty/index.php" || $page == "/proizvoditeli/index.php"):?>
		<?if(!isset($_REQUEST["_escaped_fragment_"])):?>
			<meta name="fragment" content="!">
		<?endif;?>
	<?endif;?>
	
	

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	
	
	<!--script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-1.11.1.min.js"></script-->
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-1.11.1.min.js");?>
	
	
	<?
	/*global $USER;
	if (!$USER->IsAdmin()):
	?>
		<script src="//api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
	
	<?else:*/?>
		<script src="<?=SITE_TEMPLATE_PATH?>/js/yandex_api.js?load=package.full&lang=ru-RU" type="text/javascript"></script>
	<?//endif;?>
	
	
	

	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/style.css");?>

	<!-- fancybox -->
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.fancybox.css");?>
	<!-- formstyler -->
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.formstyler.css");?>
	<!-- flexslider -->
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/flexslider.css");?>

	<?=$APPLICATION->ShowProperty("PAGER_NAV_PREV")?>
	<?=$APPLICATION->ShowProperty("PAGER_NAV_NEXT")?>

	
</head>

<body>


<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TNC5LN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TNC5LN');</script>
<!-- End Google Tag Manager -->
<?if ($APPLICATION->ShowPanel()) : ?>
	<div id="bitrix-panel">
		<?php $APPLICATION->ShowPanel(); ?>
	</div>
<?endif ?>

<div class="wrapper">
	<div class="top_block">
		<div class="center">
			<nav class="top">
				<?$APPLICATION->IncludeComponent(
					"bitrix:menu", 
					"menu", 
					Array(
						"ROOT_MENU_TYPE" => "top",
						"MENU_CACHE_TYPE" => "Y",
						"MENU_CACHE_TIME" => "36000000",
						"MENU_CACHE_USE_GROUPS" => "N",
						"MENU_CACHE_GET_VARS" => "",
						"MAX_LEVEL" => "1",
						"CHILD_MENU_TYPE" => "left",
						"USE_EXT" => "Y",
						"DELAY" => "N",
						"ALLOW_MULTI_SELECT" => "N",
					),
					false,
					array(
						"ACTIVE_COMPONENT" => "Y"
					)
				);?>
			</nav>
			
			<div class="right">
				<div class="zvonok_block"><a class="zvonok modalbox btn" href="#zvonok" onclick="yaCounter31721621.reachGoal('feedback-button');"><span>Обратный звонок</span></a></div>
				<div class="login">
					<?
					global $USER;
					if ($USER->IsAuthorized()) {
					?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:system.auth.form",
							"is_auth", 
							Array(
								"REGISTER_URL" => "",
								"FORGOT_PASSWORD_URL" => "",
								"PROFILE_URL" => "/personal/profile/",
								"SHOW_ERRORS" => "Y"
							)
						);?>
					<?
					}
					else{
					?>
						<a class="login_modal modalbox" href="#login"><span>Вход</span></a> /                 
						<a class="register_modal modalbox" href="#register"><span>Регистрация</span></a>
					<?
					}
					?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div> <!-- END .top_block -->

	<header class="header">
		<div class="center">
			<div class="left">
				<a class="logo" href="/"></a>
				<div class="text_block">
					<a href="/">
						<div class="slogan">
							<?$APPLICATION->IncludeComponent(
								"bitrix:main.include", 
								".default", 
								array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => "/include/slogan.php",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);?>
						</div>
						<div class="desc">
							<?$APPLICATION->IncludeComponent(
								"bitrix:main.include", 
								".default", 
								array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => "/include/desc.php",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);?>
						</div>
					</a>
				</div>
			</div>
			
			<div class="right">
                <div class="shops work-time">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/grafic_header.php",
                            "EDIT_TEMPLATE" => "standard.php"
                        ),
                        false
                    );?>
                </div>
				<?//if($isInzhenernaya){?>
					<!--
					<a href="/catalog/inzhenernaya/actions/" class="btn btn_actions"><span>распродажа</span></a>
					<div class="shop_work_time">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include", 
							".default", 
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => "/include/shops_work_time_inzhenernaya.php",
								"EDIT_TEMPLATE" => "standard.php"
							),
							false
						);?>
					</div>
					-->
				<?//}?>
				
				<?//if($isBytovaya){?>
					<!--
					<a href="/catalog/bytovaya/actions/" class="btn btn_actions"><span>распродажа</span></a>
					<div class="shop_work_time">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include", 
							".default", 
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => "/include/shops_work_time_bytovaya.php",
								"EDIT_TEMPLATE" => "standard.php"
							),
							false
						);?>
					</div>
					-->
				<?//}?>
			
				<div class="shops shops_inzhenernaya <?if($isBytovaya){echo 'hidden';}?>">
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", 
						".default", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => "/include/shops_inzhenernaya.php",
							"EDIT_TEMPLATE" => "standard.php"
						),
						false
					);?>
				</div>
				<div class="shops shops_bytovaya <?if($isInzhenernaya){echo 'hidden';}?>">
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", 
						".default", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => "/include/shops_bytovaya.php",
							"EDIT_TEMPLATE" => "standard.php"
						),
						false
					);?>
				</div>
				<div class="basket_block">
					<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "in_header", Array(
							"PATH_TO_BASKET" => SITE_DIR."/basket/",
							"PATH_TO_PERSONAL" => SITE_DIR."personal/",
							"SHOW_PERSONAL_LINK" => "N",
							"SHOW_NUM_PRODUCTS" => "Y",
							"SHOW_TOTAL_PRICE" => "Y",
							"SHOW_PRODUCTS" => "N",
							"POSITION_FIXED" => "N",
						),
						false
					);?>
				</div>
			</div>
			<div class="clear"></div>	

			<div class="nav_searcg_block">
				<div class="catalog_link">
					<!-- <a href="/catalog/">Каталог продукции</a> -->
					<span>Каталог продукции</span>

					<div class="catalogs_block">
						<div class="catalogs catalogs1 catalogs1_header">
							<a href="/catalog/inzhenernaya/" class="catalogs_link"><span>Инженерная сантехника</span></a>
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu",
								"catalogs",
								array(
									"ROOT_MENU_TYPE" => "catalogs1",
									"MENU_CACHE_TYPE" => "Y",
									"MENU_CACHE_TIME" => "36000000",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(),
									"MAX_LEVEL" => "2",
									"CHILD_MENU_TYPE" => "left",
									"USE_EXT" => "Y",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N",
									"COMPONENT_TEMPLATE" => "menu"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
							);?>
						</div>
						<div class="catalogs catalogs2 catalogs2_header">
							<a href="/catalog/bytovaya/" class="catalogs_link"><span>Бытовая сантехника</span></a>
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"catalogs", 
								array(
									"ROOT_MENU_TYPE" => "catalogs2",
									"MENU_CACHE_TYPE" => "Y",
									"MENU_CACHE_TIME" => "36000000",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(),
									"MAX_LEVEL" => "2",
									"CHILD_MENU_TYPE" => "left",
									"USE_EXT" => "Y",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N",
									"COMPONENT_TEMPLATE" => "menu"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
							);?>
						</div>
					</div>
				</div>
				<?//if (!$USER->IsAdmin()):?>
				<nav>
					<?$APPLICATION->IncludeComponent("bitrix:menu", "menu_not_href", Array(
						"ROOT_MENU_TYPE" => "top_2",	// Тип меню для первого уровня
							"MENU_CACHE_TYPE" => "Y",	// Тип кеширования
							"MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
							"MENU_CACHE_USE_GROUPS" => "N",	// Учитывать права доступа
							"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
							"MAX_LEVEL" => "4",	// Уровень вложенности меню
							"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
							"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
							"DELAY" => "N",	// Откладывать выполнение шаблона меню
							"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
							"COMPONENT_TEMPLATE" => "menu"
						),
						false,
						array(
						"ACTIVE_COMPONENT" => "Y"
						)
					);?>
				</nav>
				<?//endif;?>
				<div class="search_block">
					<div class="search_title search_title_1">
							<?
							$APPLICATION->IncludeComponent(
								"bitrix:search.title",
								"search",
								array(
									"NUM_CATEGORIES" => "1",
									"TOP_COUNT" => "5",
									"CHECK_DATES" => "Y",
									"SHOW_OTHERS" => "N",
									"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
									"CATEGORY_0" => array(
										0 => "iblock_1c_catalog",
									),
									"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
									"SHOW_INPUT" => "Y",
									"INPUT_ID" => "title-search-input10",
									"CONTAINER_ID" => "search",
									"PRICE_CODE" => array(
										0 => "Интернет",
									),
									"SHOW_PREVIEW" => "Y",
									"PREVIEW_WIDTH" => "75",
									"PREVIEW_HEIGHT" => "75",
									"CONVERT_CURRENCY" => "Y",
									"COMPONENT_TEMPLATE" => "search",
									"ORDER" => "date",
									"USE_LANGUAGE_GUESS" => "Y",
									"PRICE_VAT_INCLUDE" => "Y",
									"PREVIEW_TRUNCATE_LEN" => "",
									"CURRENCY_ID" => "RUB",
									"CATEGORY_0_iblock_1c_catalog" => array(
										0 => "all",//10
									),
								),
								false
							);?>
						
					</div>
					<?
					$page_piece = explode("/", $page);
					$curr_catalog = "inzhenernaya";
					foreach($page_piece as $piece){
						if($piece == "bytovaya"){
							$curr_catalog = "bytovaya";
						}
					}
					?>
					
					<div class="radio_block">
						<input type="radio" name="iblock" value="search_title_1" <?if($curr_catalog == "inzhenernaya"){echo 'checked="checked"';}?> id="iblock1" /> 
						<label for="iblock1">Инженерная</label>
						<input type="radio" name="iblock" value="search_title_2" <?if($curr_catalog == "bytovaya"){echo 'checked="checked"';}?> id="iblock2" /> 
						<label for="iblock2">Бытовая</label>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</header><!-- .header-->

	<div class="container">

		<div class="center">

			<?if($page != "/index.php"){?>
				<div>
				<div class="content">
					<div class="breadcrumb_block">
						<?/*global $USER;
						if ($USER->IsAdmin()):?>
						<?
						print_r($APPLICATION->GetProperty("is_catalog_intro"));?>
						
						<?else:*/?>
							<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breads", Array(
								"START_FROM" => "0",
									"PATH" => "",
									"SITE_ID" => "-",
								),
								false
							);?>
						<?//endif;?>
					</div>

					<?if(!$isCatalog && !$isArenda && !$isProizvoditeli):?>
						<h1><?$APPLICATION->ShowTitle(false)?></h1>
						<?if($page == "/kontakty/index.php"){?>
							<div class="switch_block">
								<div class="title">
									Наши магазины в Москве:
								</div>
								<div class="select_block">
									<div class="selectesem">
										<div onclick="catalog_active_open_map_ss(this.getAttribute('data-val'))" data-val="cat1" class="item active" style="font-size: 15px; font-weight: bold">
											Инженерная сантехника (4)
										</div>
										<div onclick="catalog_active_open_map_ss(this.getAttribute('data-val'))" data-val="cat2" class="item" style="font-size: 15px; font-weight: bold">
											Бытовая сантехника (1)
										</div>
										<div onclick="catalog_active_open_map_ss(this.getAttribute('data-val'))" data-val="cat3" class="item" style="font-size: 15px; font-weight: bold">
											Хозяйственные магазины (3)
										</div>
									</div>
								</div>
							</div>
							<div class="padding">
						<?}?>
					<?endif;?>
			<?}
			/*else{?>
			
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include", 
					".default", 
					array(
						"AREA_FILE_SHOW" => "file",
						"PATH" => "/include/main_str.php",
						"EDIT_TEMPLATE" => "standard.php"
					),
					false
				);?>
			
			<?}*/?>