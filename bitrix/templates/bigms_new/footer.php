	
	
	</main>

	
	<footer class="footer <?if ( $isOrderMake ):?>footer_order<?endif;?>">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-30 col-md-30 col-sm-30">
            <div class="row">
              <div class="col-lg-15 col-md-15 col-sm-15 footer__wrap">
                <?$APPLICATION->IncludeComponent(
					"bitrix:menu", 
					"bottom_menu", 
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
                <div class="footer-callback">
					<?$APPLICATION->IncludeComponent(
							"bitrix:main.include", 
							".default", 
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => "/include/f_phone.php",
								"EDIT_TEMPLATE" => "standard.php"
							),
							false
					);?>
  
                  <a href="#" class="footer-callback__trigger popup-trigger" data-trigger="callback">Обратный звонок</a>
                </div>
              </div>
              <div class="col-lg-15 col-md-15 col-sm-15 footer__wrap footer__wrap_right">
                <div class="footer-widget">
                  <!-- сюда вставлять yandex market виджет вместо картинки -->
					<a href="https://market.yandex.ru/shop/281223/reviews" target="_blank">
						<img src="<?=SITE_TEMPLATE_PATH?>/styles/images/yandex_market.png" alt="" class="footer-widget__img">
					</a>
				</div>
                <div class="footer-info">
                  <strong class="footer-info__title">
					<?$APPLICATION->IncludeComponent(
							"bitrix:main.include", 
							".default", 
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => "/include/f_sitename.php",
								"EDIT_TEMPLATE" => "standard.php"
							),
							false
					);?>
				  </strong>
                  <p class="footer-info__text">
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
				  </p>
                  <p class="footer-info__text">
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
				  
				  </p>
                  <div class="footer-info__soclist soclist">
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
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
	
	
	<!-- форма обратного звонка -->
    <div data-popup="callback" class="popup">
      <div class="popup__container">
        <div class="popup__wrap">
			<span data-trigger="callback" class="popup__close popup-trigger js-active"></span>
		    <span id="callback"></span>   
        </div>
      </div>
    </div>
    <!-- /форма обратного звонка -->

    <!-- форма входа на сайт -->
    <div data-popup="login" class="popup popup_login">
      <div class="popup__wrap" id="modal-login">
        <span data-trigger="login" class="popup__close popup-trigger"></span>
			<strong class="form__title callback-form__title">Вход в личный кабинет</strong>
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
    <!-- /форма входа на сайт -->

    <!-- форма регистрации -->
    <div data-popup="register" class="popup popup_register">
      <div class="popup__container">
        <div class="popup__wrap" id="modal-register">
        <span data-trigger="register" class="popup__close popup-trigger"></span>
		<strong class="form__title callback-form__title">Регистрация</strong>
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
    </div>
    <!-- /форма регистрации -->

    <!-- форма восстановить пароль -->
    <div data-popup="remember" class="popup popup_remember">
      <div class="popup__container" id="modal-forgot-password">
        <div class="popup__wrap">
        <span data-trigger="remember" class="popup__close popup-trigger"></span>
		<strong class="form__title">Вспомнить пароль</strong>
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
    </div>
    <!-- /форма восстановить пароль -->

    <!-- форма пароль отправлен -->
    <div data-popup="sent" class="popup popup_sent">
      <div class="popup__container">
        <div class="popup__wrap">
          <strong class="popup__title form__title">Данные отправлены</strong>
          <p class="popup__text">Мы отправили информацию по восстановлению пароля на ваш е-мейл</p>
          <span data-trigger="sent" class="button popup-trigger">Закрыть</span>
        </div>
      </div>
    </div>
    <!-- /форма пароль отправлен -->
	
	<!-- форма в корзину -->
    <div data-popup="cart" class="popup popup_cart">
      <div class="popup__container">
        <div class="popup__wrap">
        <span data-trigger="cart" class="popup__close popup-trigger"></span>
        <form id="cart_form" class="form form_cart popup__form">
          <strong class="form__title">Товар добавлен в корзину</strong>
          <div class="form__container">
            <div class="form__img-wrap">
              <img src="" alt="" class="form__img">
            </div>
            <div class="form__description">
              <strong class="form__subtitle"></strong>
              <div class="form__inner-wrap">
				<?/*
                <div class="spinner spinner_cart">
                  <a role="button" href="#" class="spinner__dec">–</a>
                  <input class="spinner__input" type="text" name="" value="1">
                  <a role="button" href="#" class="spinner__inc">+</a>
                </div>
				*/?>
                <span class="form__price"></span>
              </div>
              <span class="product-card__quantity"></span>
            </div>
          </div>
          <div class="form__container form__container_submit">
            <div class="form__inner-wrap form__inner-wrap_between">
              <a data-trigger="cart" href="#" class="form__link popup-trigger">Продолжить покупки</a>
              <input data-trigger="sent" onclick="location.href='/basket/'" class="form__submit popup-trigger" type="submit" name="form_submit" value="ОФОРМИТЬ ЗАКАЗ">
            </div>
          </div>
        </form>
		<?/*
        <form id="form_click" class="form form_click">
          <strong class="form__title form__title_click">Заказать в 1 клик</strong>
          <p class="form__text">Можно не заполнять никаких форм, просто оставить телефон и консультант решит все вопросы по оформлению заказа</p>
          <div class="form__inner-wrap form__inner-wrap_between">
            <div class="form__row form__row_phone">
              <input class="form__input" type="text" name="phone" value="" placeholder="Номер телефона">
            </div>
            <input class="form__submit" type="submit" name="form_submit" value="ЖДУ ЗВОНКА">
          </div>
        </form>
		*/?>
      </div>
      </div>
    </div>
    <!-- /форма в корзину -->
	
	 <!-- форма пароль отправлен -->

    <div data-popup="success" class="popup popup_success">
      <div class="popup__container">
        <div class="popup__wrap">
        <span data-trigger="success" class="popup__close popup-trigger"></span>
        <strong class="popup__title form__title">Заявка на обратный звонок отправлена</strong>
        <p class="popup__text">Наш менеджер свяжется с вами по телефону +7(903) 726-85-16 в течение рабочего дня.</p>
        <p class="popup__text">Спасибо за обращение!</p>
        <span data-trigger="success" class="button popup-trigger">Закрыть</span>
      </div>
      </div>
    </div>
    <!-- /форма пароль отправлен -->

    <!-- форма регистрации -->
    <div data-popup="estimate" class="popup popup_estimate">
      <div class="popup__container">
        <div class="popup__wrap">
        <span data-trigger="estimate" class="popup__close popup-trigger"></span>
        <form id="register_form" class="form form_register popup__form">
          <strong data-trigger="estimate" class="form__title callback-form__title popup-trigger">Рассчитать смету</strong>
          <div class="form__row validated">
            <label class="form__label">Как вас зовут</label>
            <input class="form__input" type="text" name="name" value="Сергей" placeholder="">
          </div>
          <div class="form__row">
            <label class="form__label">Ваш номер телефона</label>
            <input class="form__input" type="text" name="phone" value="" placeholder="">
          </div>
          <div class="form__row">
            <label class="form__label">Ваш e-mail</label>
            <input class="form__input" type="text" name="email">
          </div>
          <div class="form__row">
            <label class="form__label">Адрес e-mail</label>
            <input class="form__input" type="text" name="email">
          </div>
          <div class="form__row">
            <label class="form__label">Выбрать файлы</label>
            <div class="form__file input-file">
              <svg class="input-file__button">
                <use xlink:href="#icon-upload"></use>
              </svg>
              <p class="input-file__text form__input">Файл не выбран</p>
              <input class="input-file__input" type="file">
            </div>
          </div>
          <input class="form__submit" type="submit" name="form_submit" value="Отправить на рассчет">

        </form>
      </div>
      </div>
    </div>
    <!-- /форма регистрации -->
	
	<?if( $isContacts ):?>	
		
		    <!-- youtube popup -->
			<div data-popup="youtube" class="popup popup_youtube">
			  <div class="popup__container">
				<div class="popup__wrap">
					<a role="button" data-trigger="youtube" class="popup__close popup-trigger"></a>
					<span id="youtube"></span>
				</div>
			  </div>
			</div>
	
	<?endif;?>

	<!-- slider gallery popup -->
    <div data-popup="slider" class="popup popup_youtube">
      <div class="popup__container">
        <div class="popup__wrap">
        <span data-trigger="slider" class="popup__close popup-trigger"></span>
        <div class="popup-slider">
			<span id="slider">
			</span>
        </div>
      </div>
      </div>
    </div>
	
	
</body>
</html>