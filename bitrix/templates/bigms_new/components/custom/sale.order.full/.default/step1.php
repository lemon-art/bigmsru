<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

	
	
    <ul class="order-tabs__nav">
		<li data-tab="natural" data-person="1" class="order-tabs__nav-item active">Физическое лицо</li>
        <li data-tab="legal" data-person="2" class="order-tabs__nav-item">Юридическое лицо</li>
    </ul>
	<input type="hidden" name="PERSON_TYPE" value="1">
	
					<div data-content="natural" class="order-tabs__content content-order__wrap active">
                        <div data-step="1" class="form__container">
                          <div class="form__wrap">
                            <label class="form__label" for="order_name">Имя</label>
                            <div class="form__row form__row_name div_form <?if ( $arResult["USER_NAME"] ):?>validated<?endif;?>">
                              <input id="order_name" data-min="3" class="form__input" type="text" name="ORDER_PROP_1" value="<?if ( $arResult["USER_NAME"] ):?><?=$arResult["USER_NAME"]?><?endif;?>" placeholder="">
                            </div>
                          </div>
                          <div class="form__wrap">
                            <label class="form__label" for="order_name">Адрес E-mail</label>
                            <div class="form__row form__row_email div_form <?if ( $arResult["USER_EMAIL"] ):?>validated<?endif;?>">
                              <input id="order_email" class="form__input email" type="text" name="ORDER_PROP_2" value="<?if ( $arResult["USER_EMAIL"] ):?><?=$arResult["USER_EMAIL"]?><?endif;?>" placeholder="">
                            </div>
                          </div>
                          <div class="form__wrap">
                            <label class="form__label" for="order_name">Телефон</label>
                            <div class="form__row form__row_phone div_form">
                              <input id="order_email" data-min="16" class="form__input phone" type="text" name="ORDER_PROP_3" value="" placeholder="">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div data-content="legal" class="order-tabs__content content-order__wrap order-tabs__content_legal">
                        <div data-step="1" class="form__container">
                          <div class="form__row form__row_legal div_form <?if ( $arResult["USER_NAME"] ):?>validated<?endif;?>">
                            <label for="company_name" class="form__label">Название компании</label>
                            <input id="company_name" data-min="3" class="form__input" type="text" name="ORDER_PROP_10" value="<?if ( $arResult["USER_NAME"] ):?><?=$arResult["USER_NAME"]?><?endif;?>">
                          </div>
						  <div class="form__row form__row_legal div_form <?if ( $arResult["USER_EMAIL"] ):?>validated<?endif;?>">
                            <label for="company_name" class="form__label">E-mail компании</label>
                            <input id="company_name" class="form__input email" type="text" name="ORDER_PROP_8" value="<?if ( $arResult["USER_EMAIL"] ):?><?=$arResult["USER_EMAIL"]?><?endif;?>">
                          </div>
                          <div class="form__row form__row_legal form__row_cols">
                            <div class="form__col">
                              <div class="form__row div_form">
                                <label for="inn" class="form__label">ИНН</label>
                                <input id="inn" data-min="10" class="form__input" type="text" name="ORDER_PROP_11" value="">
                              </div>
                            </div>
                            <div class="form__col">
                              <div class="form__row div_form">
                                <label for="kpp" class="form__label">КПП</label>
                                <input id="kpp" data-min="6" class="form__input" type="text" name="ORDER_PROP_12" value="">
                              </div>
                            </div>
                          </div>
                          <div class="form__row form__row_legal div_form">
                            <label for="address" class="form__label">Юридический адрес</label>
                            <input id="address" data-min="5" class="form__input" type="text" name="ORDER_PROP_13" value="">
                          </div>
                          <div class="form__row form__row_legal form__row_cols">
                            <div class="form__col">
                              <div class="form__row div_form">
                                <label for="bank" class="form__label">Наименование банка</label>
                                <input id="bank" data-min="5" class="form__input" type="text" name="bank" value="">
                              </div>
                            </div>
                            <div class="form__col">
                              <div class="form__row div_form">
                                <label for="bik" class="form__label">БИК</label>
                                <input id="bik" data-min="5" class="form__input" type="text" name="bik" value="">
                              </div>
                            </div>
                          </div>
                          <div class="form__row form__row_legal form__row_cols">
                            <div class="form__col">
                              <div class="form__row div_form">
                                <label for="corporate_account" class="form__label">К / С</label>
                                <input id="corporate_account" data-min="5" class="form__input" type="text" name="bank" value="">
                              </div>
                            </div>
                            <div class="form__col">
                              <div class="form__row div_form">
                                <label for="payment_account" class="form__label">Р / С</label>
                                <input id="payment_account" data-min="5" class="form__input" type="text" name="bik" value="">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>			