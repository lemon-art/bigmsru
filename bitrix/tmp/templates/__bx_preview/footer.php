<?if($page != "/index.php"){?>						<?if(!$isCatalog && !$isArenda && !$isProizvoditeli):?></div><?endif;?>
						
						<?if(!$isSertifikaty && !$isArticles && !$isNews && $page != "/about/index.php" && !$isZakladki && $page != "/search/index.php"){?>
							</div>
						<?}?>
					</div>
				<?}?>
			</div>
			<div class="clear"></div>
		</div><!-- .container -->
	</div><!-- .wrapper -->

	<footer class="footer">
		<div class="center">
			<div class="left">
				<div class="copy">
					<div class="big">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include", 
							".default", 
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => "/include/f_copy.php",
								"EDIT_TEMPLATE" => "standard.php"
							),
							false
						);?>
					</div>
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", 
						".default", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => "/include/f_copy_text.php",
							"EDIT_TEMPLATE" => "standard.php"
						),
						false
					);?>
				</div>
				<div class="o2k">
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include", 
						".default", 
						array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => "/include/o2k.php",
							"EDIT_TEMPLATE" => "standard.php"
						),
						false
					);?>
				</div>
			</div>
			
			<div class="right">
				<nav class="bottom">
					<?$APPLICATION->IncludeComponent(
						"bitrix:menu", 
						"menu", 
						Array(
							"ROOT_MENU_TYPE" => "bottom",
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

				<div>
					<a href="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=2508/*https://market.yandex.ru/shop/281223/reviews"><img src="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=2507/*http://grade.market.yandex.ru/?id=281223&action=image&size=2" border="0" width="150" height="101" alt="Читайте отзывы покупателей и оценивайте качество магазина на Яндекс.Маркете" /></a>					
					<div class="shops shops_inzhenernaya inline <?if($isBytovaya){echo 'hidden';}?>">
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
					<div class="shops shops_bytovaya inline <?if($isInzhenernaya){echo 'hidden';}?>">
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
					<div class="inline soc">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include", 
							".default", 
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => "/include/soc.php",
								"EDIT_TEMPLATE" => "standard.php"
							),
							false
						);?>
					</div>
					<div class="grafic inline">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include", 
							".default", 
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => "/include/grafic.php",
								"EDIT_TEMPLATE" => "standard.php"
							),
							false
						);?>
					</div>
				</div>
			</div>
			
			<div class="clear"></div>
		</div>
	</footer><!-- .footer -->

	<!-- Модальные окна -->
	<div id="zvonok" class="hidden">
		<div class="modal-content">
			<?$APPLICATION->IncludeComponent(
				"bitrix:form.result.new",
				"form",
				Array(
					"WEB_FORM_ID" => "1",
					"IGNORE_CUSTOM_TEMPLATE" => "N",
					"USE_EXTENDED_ERRORS" => "N",
					"SEF_MODE" => "N",
					"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"","RESULT_ID"=>"",),
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"LIST_URL" => "",
					"EDIT_URL" => "",
					"SUCCESS_URL" => "",
					"CHAIN_ITEM_TEXT" => "",
					"CHAIN_ITEM_LINK" => "",
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_SHADOW" => "N",
					"AJAX_OPTION_JUMP" => "Y",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N"
				)
			);?>
		</div>
	</div>
	
	<div id="feedback" class="hidden">
		<div class="modal-content">
			<?$APPLICATION->IncludeComponent(
				"bitrix:form.result.new",
				"form",
				Array(
					"WEB_FORM_ID" => "2",
					"IGNORE_CUSTOM_TEMPLATE" => "N",
					"USE_EXTENDED_ERRORS" => "N",
					"SEF_MODE" => "N",
					"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"","RESULT_ID"=>"",),
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"LIST_URL" => "",
					"EDIT_URL" => "",
					"SUCCESS_URL" => "",
					"CHAIN_ITEM_TEXT" => "",
					"CHAIN_ITEM_LINK" => "",
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_SHADOW" => "N",
					"AJAX_OPTION_JUMP" => "Y",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N"
				)
			);?>
		</div>
	</div>
	
	<div id="is_error" class="hidden">
		<div class="modal-content">
			<?$APPLICATION->IncludeComponent(
				"bitrix:form.result.new",
				"form",
				Array(
					"WEB_FORM_ID" => "3",
					"IGNORE_CUSTOM_TEMPLATE" => "N",
					"USE_EXTENDED_ERRORS" => "N",
					"SEF_MODE" => "N",
					"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"","RESULT_ID"=>"",),
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"LIST_URL" => "",
					"EDIT_URL" => "",
					"SUCCESS_URL" => "",
					"CHAIN_ITEM_TEXT" => "",
					"CHAIN_ITEM_LINK" => "",
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_SHADOW" => "N",
					"AJAX_OPTION_JUMP" => "Y",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N"
				)
			);?>
		</div>
	</div>
	
	
<!--modal-login-->
<div id="login" class="hidden">
	<div id="modal-login">
		<div class="title">Вход в личный кабинет</div>
		<div class="modal-content">
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.auth.form",
				"modal",
				Array(
					"REGISTER_URL" => "",
					"FORGOT_PASSWORD_URL" => "",
					"PROFILE_URL" => "/personal/profile/",
					"SHOW_ERRORS" => "Y"
				)
			);?>
		</div>
	</div>
</div>
<!--//modal-login-->

<!--modal-register-->
<div id="register" class="hidden">
	<div id="modal-register">
		<div class="title">Регистрация</div>
		<div class="modal-content">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.register",
				"modal",
				Array(
					"SHOW_FIELDS" => array("EMAIL","NAME","LAST_NAME","WORK_COMPANY"),
					"REQUIRED_FIELDS" => array("EMAIL","NAME","LAST_NAME"),
					"AUTH" => "Y",
					"USE_BACKURL" => "N",
					"SUCCESS_PAGE" => "",
					"SET_TITLE" => "N",
					"USER_PROPERTY" => array("UF_TYPE","UF_INN"),
					"USER_PROPERTY_NAME" => "",
					"COMPONENT_TEMPLATE" => "modal"
				)
			);?>
		</div>
	</div>
</div>
<!--//modal-register-->

<!--modal-forgot-password-->
<div id="password" class="hidden">
	<div id="modal-forgot-password">
		<div class="title">вспомнить пароль</div>
		<div class="modal-content">
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.auth.forgotpasswd",
				"modal",
				Array(
					"COMPONENT_TEMPLATE" => "modal"
				)
			);?>
		</div>
	</div>
</div>
<!--//modal-forgot-password-->


<?$APPLICATION->IncludeComponent(
	"mlife:mlife.bistroclick", 
	"bigms", 
	array(
		"COMPONENT_TEMPLATE" => "bigms",
		"IBLOCK_TYPE" => "1c_catalog",
		//"IBLOCK_ID" => "10",
		"CURRENCY_ID" => "RUB",
		"CURRENCY_SECOND" => "RUB",
		"PRICE_CODE" => array(
			0 => "1",
		),
		"KEY" => "3j5h34kj5h34kj5h3k4j5h17",
		"FIELD_SHOW" => array(
			0 => "name",
			1 => "phone",
		),
		"FIELD_REQ" => array(
			0 => "phone",
		),
		"FIELD_DELIVERY" => array(
		),
		"FIELD_PAYSYSTEM" => array(
		),
		"CREATE_ORDER" => "Y",
		"PERSON_TYPE" => "1",
		"CHECK_USER" => "N",
		"CREATE_USER" => "CUR",
		"USER_PREFIX" => "user_",
		"USER_GROUP" => array(
			0 => "3",
			1 => "4",
		),
		"PERSON_FIELD_NAME" => "1",
		"PERSON_FIELD_EMAIL" => "2",
		"PERSON_FIELD_PHONE" => "3",
		"NOTICE_ADMIN" => "N",
		"MESS_OK" => "Ваш заказ принят, наш менеджер свяжется с вами в ближайшее время",
		"SHOW_KAPCHA" => "0",
		"JQUERY" => "N",
		"FANCY" => "N"
	),
	false
);?>
<a class="ok_link modalbox hidden" href="#ok"></a>
<div  class="hidden"><!--id="ok"-->
	<div class="title">Отложенные товары</div>
	<div class="text">Товар добавлен в избранное</div>
	<div class="popup-window-buttons">
		<span class="catalog_list next_button" style="margin-bottom: 0px; border-bottom: 0px none transparent;"><span class="bx_medium bx_bt_button">продолжить выбор товаров</span></span>
		<span class="catalog_list cart_button" style="margin-bottom: 0px; border-bottom: 0px none transparent;"><span style="margin-right: 10px;" class="bx_medium bx_bt_button"><a href="/personal/zakladki/">Перейти в избранное</a></span></span>
	</div>
</div>


<div class="b-popup__wrap" id="favor" style="display: none;">
	<span class="popup__close"></span>
	<div class="b-popup__img b-popup-favourites__img">
		<img src="/bitrix/templates/bigms/images/popup_img.jpg" alt=""/>
	</div>
	<div class="b-popup__item">
		<div class="b-popup__title b-popup-favourites__title">
			ТОВАР Добавлен в избранное
		</div>
		<div class="b-popup__text b-popup-favourites__text" id="ok_name" style="width: 500px;">
			Смеситель для ванны BORNEO Comfort Testa 121.333.001
		</div>
		<div id="count_items_in_popup" class="b-popup__descr b-popup-favourites__descr"></div>
	</div>
	<div class="b-popup__price b-popup-favourites__price" id="ok_price">
		1 175 руб.
	</div>
	<span class="b-popup__btn b-popup-favourites__btn" >
		<a href="/personal/zakladki/" style="color: #fff; text-decoration: none; ">
			ПЕРЕЙТИ в избранное
		</a>
	</span>
</div>

<a class="ok_link_del modalbox hidden" href="#ok_del"></a>
<div id="ok_del" class="hidden">
	<div class="title">Отложенные товары</div>
	<div class="text"></div>
	<div class="popup-window-buttons">
		<span class="catalog_list cart_button" style="margin-bottom: 0px; border-bottom: 0px none transparent;"><span style="margin-right: 10px;" class="bx_medium bx_bt_button"><a href="/personal/zakladki/">Перейти в закладки</a></span></span>
	</div>
</div>

<?if(CModule::IncludeModule("sale") && $page == "/index.php"){?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include", 
		".default", 
		array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => "/include/is_delay_compare.php",
			"EDIT_TEMPLATE" => "standard.php"
		),
		false
	);?>
<?}?>

<div class="fade"></div>

<div class="fixed_block">
	<a class="icon modalbox icon_msg" href="#feedback"><span>Написать нам</span></a>
	<a class="icon modalbox icon_tel" href="#zvonok" onclick="yaCounter31721621.reachGoal('feedback-button');"><span>Заказать звонок</span></a>
	<a class="icon modalbox icon_err" href="#is_error"><span>Нашли ошибку?</span></a>
</div>

<?if (!$USER->IsAdmin()):?>
	<script>
		$('.bx_field input')
			.blur(function() {
				$(this).closest('.search_title').removeClass('focus');
			})
			.focus(function() {
				$(this).closest('.search_title').addClass('focus');
			});
	</script>
<?endif;?>
<?//if (!$USER->IsAdmin()):?>
	<style>
		.sub-menu {
			opacity: 0;
			visibility: hidden;
			position: absolute;
			left: -10px;
			top: 100%;
			background: #cbdef6;
			padding: 10px 15px;
			z-index: 999;
			min-width: 200px;
		}
		.sub-menu li {
			display: block;
			margin: 0;
			height: 20px !important;
			margin-bottom: 10px;
		}
		.sub-menu li:last-child {
			margin-bottom: 0;
		}
		.sub-menu li a {
			font-size: 11px !important;
			font-weight: normal;
		}
		nav.top ul li.has-sub {
			position: relative;
			padding-right: 30px;
		}
		nav.top ul li.has-sub a {
			position: relative;
			z-index: 1;
		}
		nav.top ul li.has-sub:after {
			content: '';
			position: absolute;
			top: 22px;
			right: 15px;
			border-top: 3px solid #075991;
			border-left: 4px solid transparent;
			border-right: 4px solid transparent;
		}
		nav.top ul li.has-sub:hover:before {
			content: '';
			position: absolute;
			top: 0;
			left: -10px;
			background: #cbdef6;
			width: 100%;
			height: 100%;
			z-index: 0;
		}
		nav.top ul li.has-sub:hover .sub-menu {
			opacity: 1;
			visibility: visible
		}

		.nav_searcg_block {
			background: #075991;
			border: 0;
		}
		.nav_searcg_block .search_block {
			background: #075991;
			min-width: 75%;
			height: 51px;
			top: -1px;
			padding: 2px 0 2px 12px;
		}
		.bx_search_container .bx_field {
			background: #075991;
			height: 48px;
			width: 95% !important;
		}
		.bx_search_container .bx_field .bx_input_text {
			background: #fff;
			border: 2px solid transparent !important;
			width: 100% !important;
			-webkit-transition: all .5s ease;
			-moz-transition: all .5s ease;
			-ms-transition: all .5s ease;
			-o-transition: all .5s ease;
			transition: all .5s ease;
		}
		.bx_search_container .bx_input_submit {
			position: absolute;
			top: 10px;
			right: 12px;
			bottom: 0;
			width: 55px;
			height: 30px;
			background: url(/bitrix/templates/bigms/images/search_lupe.png) no-repeat 50% 50% #ff6d4b;
			font-size: 0;
			text-align: right;
			text-transform: inherit;
			-webkit-transition: all .5s ease;
			-moz-transition: all .5s ease;
			-ms-transition: all .5s ease;
			-o-transition: all .5s ease;
			transition: all .5s ease;
		}
		.radio_block {
			display: none;
		}
		.bx_search_container .bx_field .bx_input_text:focus {
			border: 2px solid #ff6d4b !important;
			border-radius: 4px;
		}
		.search_title.focus .bx_search_container .bx_input_submit {
			font-size: 12px;
			background: url(/bitrix/templates/bigms/images/search_lupe.png) no-repeat 20% 50% #ff6d4b;
			width: 100px;
			padding-right: 20px;
			border-radius: 0 2px 2px 0;
			-webkit-transition: all .5s ease;
			-moz-transition: all .5s ease;
			-ms-transition: all .5s ease;
			-o-transition: all .5s ease;
			transition: all .5s ease;
		}
	</style>
<?//endif;?>
<?if ($APPLICATION->GetCurPage(true) == '/kontakty/index.php'):?>
<style>

	.switch_block {
		margin-bottom: 30px;
		margin-top: 0;
		background: #006db8;
		height: 80px;
	}
	.selectesem .item {
		background: #006db8;
		color: #fff;
		font-weight: normal;
		text-decoration: none;
		padding: 30px 30px 10px;
		height: 40px;
		-webkit-transition: all .4s ease;
		-moz-transition: all .4s ease;
		-ms-transition: all .4s ease;
		-o-transition: all .4s ease;
		transition: all .4s ease;
	}
	.selectesem .item:hover {
		background: #167ac6;
	}
	.selectesem .item.active {
		color: #fff;
		background: #00487a;
		position: relative;
	}
	.selectesem .item.active:before {
		content: '';
		position: absolute;
		top: 100%;
		left: 50%;
		margin-left: -6px;
		border-top: 12px solid #00487a;
		border-left: 12px solid transparent;
		border-right: 12px solid transparent;
	}
	.selectesem .item.active,
	.selectesem .item.active:hover {
		color: #fff;
		background: #00487a;
		text-decoration: none;
	}
	.selectesem .item.active:hover {
		background: #004d7a;
	}
	.switch_block .title {
		padding: 15px 25px 15px 50px;
		color: rgba(255, 255, 255, .48);
		font-weight: normal;
	}
	.selectesem {
		display: -webkit-box;
		display: -moz-box;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
	}
</style>
<?endif;?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.maskedinput.js");?>
<!-- fancybox -->
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.fancybox.pack.js");?>
<!-- flexslider -->
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.flexslider-min.js");?>
<!-- columnizer -->
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.columnizer.js");?>
<!-- formstyler -->
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.formstyler.min.js");?>

<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-ui.min.js");?>

<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/main.js");?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter31721621 = new Ya.Metrika({
                    id:31721621,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
					params:window.yaParams||{ }
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/31721621" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>