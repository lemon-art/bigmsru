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
if(CSite::InDir(SITE_DIR.'personal/order/make/')){$isOrderMake = true;}
if(CSite::InDir(SITE_DIR.'proizvoditeli/')){$isProizvoditeli = true;}
if(CSite::InDir(SITE_DIR.'news/')){$isNews = true;}
if(CSite::InDir(SITE_DIR.'basket/')){$isBasket = true;}
if(CSite::InDir(SITE_DIR.'kontakty/')){$isContacts = true;}

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
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    
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
	<meta name="viewport" content="width=1280">
	<meta name="cmsmagazine" content="f1de57f03b55d6b2cebaf643bdee6d72" />
    <meta property="og:title" content='<?$APPLICATION->ShowTitle()?>' />
    <meta property="og:description" content="<?=$APPLICATION->ShowProperty("description")?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?='https://'.SITE_SERVER_NAME.$APPLICATION->GetCurPage(false)?>" />
    <meta property="og:image" content="https://www.bigms.ru/bitrix/templates/bigms/images/big-logo.png">
	
	<?if($page == "/index.php" || $page == "/kontakty/index.php" || $page == "/proizvoditeli/index.php"):?>
		<?if(!isset($_REQUEST["_escaped_fragment_"])):?>
			<meta name="fragment" content="!">
		<?endif;?>
	<?endif;?>
	
	

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	
	
	<!--script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-1.11.1.min.js"></script-->

	
	
	<?
	/*global $USER;
	if (!$USER->IsAdmin()):
	?>
		<script src="//api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
	
	<?else:*/?>
		<script src="<?=SITE_TEMPLATE_PATH?>/js/yandex_api.js?load=package.full&lang=ru-RU" type="text/javascript"></script>
	<?//endif;?>
	
	

	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/styles/plugins/normalize.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/styles/plugins/grid30.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/styles/plugins/owl.carousel.min.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/styles/plugins/nice-select/nice-select.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/styles/main.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/styles/plugins/mCustomScrollbar/jquery.mCustomScrollbar.min.css");?>

	<?if ( $isSertifikaty ):?>
		<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/styles/jquery.fancybox.css");?>
	<?endif;?>

	<?=$APPLICATION->ShowProperty("PAGER_NAV_PREV")?>
	<?=$APPLICATION->ShowProperty("PAGER_NAV_NEXT")?>
	

	<?$APPLICATION->AddHeadScript("https://code.jquery.com/ui/1.12.1/jquery-ui.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/init-svg.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/owl.carousel.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.nice-select.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.mCustomScrollbar.concat.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.scroolly.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/main.js");?>
	<?if($isCatalog):?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/filter.js");?>
	<?endif;?>
	<?if ( $isSertifikaty ):?>
		<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.fancybox.pack.js");?>
	<?endif;?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.inputmask.bundle.min.js");?>

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

	<?if ( $isOrderMake ):?>
		<header class="header header_order">
		  <div class="container-fluid">
			<div class="header__wrap">
			  <div class="row">
				<div class="col-lg-10 col-md-10 col-sm-10">
				  <a class="header__logo" href="/"><img src="<?=SITE_TEMPLATE_PATH?>/styles/images/logo.png" alt="Большой мастер"></a>
				</div>
				<div class="col-lg-10 col-md-10 col-sm-10">
					<?$APPLICATION->IncludeComponent(
								"bitrix:main.include", 
								".default", 
								array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => "/include/phone.php",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
					);?>
					<a href="#" class="header__callback-link popup-trigger" data-trigger="callback">Обратный звонок</a>
				</div>
				<div class="col-lg-10 col-lg-offset-0 col-md-10 col-md-offset-0 col-sm-10 col-sm-offset-0">
				  <ul class="header__auth auth">
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
							<li class="auth__action"><a class="auth__link auth__link_dotted popup-trigger" href="#" data-trigger="login">Вход</a></li>
							<li class="auth__action"><a class="auth__link auth__link_dotted popup-trigger" href="#" data-trigger="register">Регистрация</a></li>
						<?
						}
						?>						
					</ul>
				</div>
			  </div>
			</div>
		  </div>
		</header>
		
	<?else:?>

		<header class="header">
		  <div class="container-fluid">
			<div class="header__wrap header__wrap_top">
			  <div class="row">
				<div class="col-lg-9 col-md-10 col-sm-10">
							<?$APPLICATION->IncludeComponent(
								"bitrix:main.include", 
								".default", 
								array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => "/include/phone.php",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);?>
				  <a href="#" class="header__callback-link popup-trigger" data-trigger="callback">Обратный звонок</a>
				</div>
				<div class="col-lg-12 col-md-11 col-sm-14">
				  <nav class="header__menu">
					<?$APPLICATION->IncludeComponent(
						"bitrix:menu", 
						"top_menu", 
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
				</div>
				<div class="col-lg-9 col-lg-offset-0 col-md-9 col-md-offset-0 col-sm-5 col-sm-offset-1">
				  <ul class="header__auth auth">
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
							<li class="auth__action"><a class="auth__link auth__link_dotted popup-trigger" href="#" data-trigger="login">Вход</a></li>
							<li class="auth__action"><a class="auth__link auth__link_dotted popup-trigger" href="#" data-trigger="register">Регистрация</a></li>
						<?
						}
						?>
					</ul>
				</div>
			  </div>
			</div>
			<div class="header__wrap header__wrap_bottom">
			  <div class="row">
				<div class="col-lg-9 col-md-10 col-sm-10">
					<a class="header__logo" href="/"><img src="<?=SITE_TEMPLATE_PATH?>/styles/images/logo.png" alt="Большой мастер"></a>
				</div>
				
				
				<div class="col-lg-12 col-md-11 col-sm-12">
				
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
				<div class="col-lg-9 col-lg-offset-0 col-md-9 col-md-offset-0 col-sm-7 col-sm-offset-1">
				  <ul class=" header__status status-bar">

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

				  </ul>
				</div>
			  </div>
			</div>
		  </div>
		</header>
		
	<?endif;?>

	<main class="content <?if($isCatalog):?>content_catalog<?endif;?> <?if ( $isOrderMake ):?>content_order<?endif;?>">

	
	<aside class="sidebar">
        <nav class="sidebar__nav side-nav">
          <ul class="side-nav__icon-list">
            <li class="side-nav__icon-item side-nav__icon-item_trigger">
              <span class="side-nav__icon sidebar__burger">
                <div class="hamburger">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
              </span>
            </li>
            <?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"catalogs_icon", 
								array(
									"ROOT_MENU_TYPE" => "catalogs2",
									"MENU_CACHE_TYPE" => "Y",
									"MENU_CACHE_TIME" => "36000000",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(),
									"MAX_LEVEL" => "1",
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
				    <?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"catalogs_icon", 
								array(
									"ROOT_MENU_TYPE" => "catalogs1",
									"MENU_CACHE_TYPE" => "Y",
									"MENU_CACHE_TIME" => "36000000",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(),
									"MAX_LEVEL" => "1",
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
            <li class="side-nav__icon-item side-nav__icon-item_service icon_service">
              <a href="#">
                <span class="side-nav__icon-img side-nav__icon-img_service"></span>
              </a>
            </li>
            <li class="side-nav__icon-item side-nav__icon-item_producers icon_producers">
              <a href="#">
                <span class="side-nav__icon-img side-nav__icon-img_producers"></span>
              </a>
            </li>
          </ul>
          <ul class="side-nav__list">
            <li class="side-nav__item">
              <a href="" class="side-nav__link">Каталог товаров</a>
            </li>

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

            <li data-level="1"  class="side-nav__item side-nav__item_colored side-nav__item_service">
              <a href="" class="side-nav__link side-nav__link_colored">
                <div class="side-nav__icon-wrap">
                  <span class="side-nav__icon icon_service"></span>
                </div>
                <span class="side-nav__name">Услуги</span>
              </a>
            </li>
            <li data-level="1" class="side-nav__item side-nav__item_colored side-nav__item_producers">
              <a href="" class="side-nav__link side-nav__link_colored">
                <div class="side-nav__icon-wrap">
                  <span class="side-nav__icon icon_producers"></span>
                </div>
                <span class="side-nav__name">Производители</span>
              </a>
              <ul data-level="2" class="side-nav__sublist sublist sublist_producers">
                <li class="sublist__item sublist__item_title">Популярные производители</li>
                <li class="sublist__item" data-hover="Показать товары">
                  <a href="/proizvoditeli/REHAU/">
                    <span class="sublist__img-wrap">
                      <img class="sublist__logo" src="<?=SITE_TEMPLATE_PATH?>/styles/images/producer_rehau.jpg" alt="">
                    </span>
                  </a>
                </li>
				<li class="sublist__item" data-hover="Показать товары">
                  <a href="/proizvoditeli/VALTEC/">
                    <span class="sublist__img-wrap">
                      <img class="sublist__logo" src="<?=SITE_TEMPLATE_PATH?>/styles/images/producer_valtec.jpg" alt="">
                    </span>
                  </a>
                </li>
				<li class="sublist__item" data-hover="Показать товары">
                  <a href="/proizvoditeli/OVENTROP/"><span class="sublist__img-wrap"><img class="sublist__logo" src="<?=SITE_TEMPLATE_PATH?>/styles/images/producer_oventrop.jpg" alt=""></span></a>
                </li>
                <li class="sublist__item" data-hover="Показать товары">
                  <a href="/proizvoditeli/UPONOR/">
                    <span class="sublist__img-wrap">
                      <img class="sublist__logo" src="<?=SITE_TEMPLATE_PATH?>/styles/images/producer_uponor.jpg" alt="">
                    </span>
                  </a>
                </li>

				<li class="sublist__item" data-hover="Показать товары">
                  <a href="/proizvoditeli/EUROSTER/"><span class="sublist__img-wrap"><img class="sublist__logo" src="<?=SITE_TEMPLATE_PATH?>/styles/images/producer_euroster.jpg" alt=""></span></a>
                </li>
                <li class="sublist__item" data-hover="Показать товары">
                  <a href="/proizvoditeli/Tech%20Controllers/"><span class="sublist__img-wrap">
				  <img class="sublist__logo" src="<?=SITE_TEMPLATE_PATH?>/styles/images/tech.jpg" alt=""></span></a>
                </li>
                <li class="sublist__item" data-hover="Показать товары">
                  <a href="/proizvoditeli/UNITECH/"><span class="sublist__img-wrap">
				  <img class="sublist__logo" src="<?=SITE_TEMPLATE_PATH?>/styles/images/uniteh.jpg" alt=""></span></a>
                </li>

                <li class="sublist__item" data-hover="Показать товары">
                  <a href="/proizvoditeli/GROHE/"><span class="sublist__img-wrap"><img class="sublist__logo" src="<?=SITE_TEMPLATE_PATH?>/styles/images/producer_grohe.jpg" alt=""></span></a>
                </li>

                <li class="sublist__item sublist__item_all" data-hover="Показать товары">
                  <a href="/proizvoditeli/" class="sublist__link sublist__link_all">Показать всех производителей</a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
      </aside>
	
	<div class="content__wrap <?if ( $isOrderMake ):?>content__wrap_about<?endif;?> <?$APPLICATION->ShowViewContent("content__wrap")?>">
		<?if( !$isBasket ):?><div class="container-fluid"><?endif;?>
			<?if ( $isAbout ):?>
				<div class="col-lg-30 col-md-30 col-sm-30 content__container content__container_about">
					<div class="content-about">
						<div class="content-about__header">
							<h1 class="title-h1 content-about__title"><?$APPLICATION->ShowTitle(false)?></h1>
						</div>
			<?elseif( $isContacts ):?>			
				<div class="content__container content__container_contacts">
				  <div class="container-fluid">
					<div class="row">
					  <div class="col-lg-23 col-md-23 col-sm-23">
							<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breads", Array(
								"START_FROM" => "0",
									"PATH" => "",
									"SITE_ID" => "-",
								),
								false
							);?>
						<h1 class="title-h1"><?$APPLICATION->ShowTitle(false)?></h1>
					  </div>
					</div>		
						
			<?elseif( $isOrderMake ):?>	



						
						

			<?elseif( $page != "/index.php" && !$isBasket ):?>

				<div class="row">
					<div class="<?$APPLICATION->ShowViewContent("row_div_class")?>">
            
							<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breads", Array(
								"START_FROM" => "0",
									"PATH" => "",
									"SITE_ID" => "-",
								),
								false
							);?>


					<?if(!$isCatalog && !$isArenda && !$isProizvoditeli):?>
						<h1 class="title-h1"><?$APPLICATION->ShowTitle(false)?></h1>

					<?endif;?>
		<?endif;?>