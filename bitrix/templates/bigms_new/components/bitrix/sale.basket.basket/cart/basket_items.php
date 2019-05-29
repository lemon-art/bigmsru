<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Sale\DiscountCouponsManager;

if (!empty($arResult["ERROR_MESSAGE"]))
	ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

$i = 0;
//считаем товары
$countPropduct = 0;
foreach ($arResult["GRID"]["ROWS"] as $arItem){
	if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"){
		$countPropduct += $arItem["QUANTITY"];
	}
} 

unlink($_SERVER["DOCUMENT_ROOT"]."/local/tmp/bigms_basket_".CSaleBasket::GetBasketUserID().".xlsx");
if ($countPropduct > 0):
?>
    <div class="content-cart__header">
        <a href="" onclick="history.back();return false;" class="content-cart__back">Вернуться к покупкам</a>
        <p class="content-cart__status">Вы добавили <span class="content-cart__value" id="all_count"><?=$countPropduct?></span> <span id="all_count_text"><?=numberof($countPropduct, 'товар', array('', 'а', 'ов'))?></span> на сумму <span class="content-cart__value" id="top_total_price"><?=$arResult["allSum_FORMATED"]?></span></p>
		<a href="" data-id="<?=CSaleBasket::GetBasketUserID()?>" class="exel_download"></a>
	</div>
	
	
	<div class="content-cart__list cart-list">
		<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
		<table class="cart-list__table" id="basket_items">
            <thead class="cart-list__header">
				<tr class="cart-list__header-row">
					<th class="cart-list__header-col"></th>
                  	<th class="cart-list__header-col" id="col_NAME"></th>
                  	<th class="cart-list__header-col cart-list__header-col_quantity">Количество</th>
                  	<th class="cart-list__header-col cart-list__header-col_sprice">Стандартная цена</th>
                  	<th class="cart-list__header-col cart-list__header-col_yprice">Ваша цена</th>
                  	<th class="cart-list__header-col cart-list__header-col_price">Стоимость</th>
                  	<th class="cart-list__header-col cart-list__header-col_price"></th>
					
					
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
						$arHeader["name"] = (isset($arHeader["name"]) ? (string)$arHeader["name"] : '');
						if ($arHeader["name"] == '')
							$arHeader["name"] = GetMessage("SALE_".$arHeader["id"]);
						$arHeaders[] = $arHeader["id"];

						// remember which values should be shown not in the separate columns, but inside other columns
						if (in_array($arHeader["id"], array("TYPE")))
						{
							$bPriceType = true;
							continue;
						}
						elseif ($arHeader["id"] == "PROPS")
						{
							$bPropsColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELAY")
						{
							$bDelayColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELETE")
						{
							$bDeleteColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "WEIGHT")
						{
							$bWeightColumn = true;
						}

						?>
					<?
					endforeach;

					?>
					
					
				</tr>
			</thead>

			<tbody class="cart-list__body">
				<?
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
				?>
					<tr id="<?=$arItem["ID"]?>" class="cart-list__row">
						<?
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

							if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in the columns in this template
								continue;

							if ($arHeader["id"] == "NAME"):
							?>
								<td class="itemphoto cart-list__col cart-list__col_img"> 
										<?
										if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0 ):
											$url = $arItem["PREVIEW_PICTURE_SRC"];
										elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0 ):
											$url = $arItem["DETAIL_PICTURE_SRC"];
										else:
											$url = "/bitrix/templates/bigms/images/logo_bw.png";
										endif;
										?>
										<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><img src="<?=$url?>" width="79"></a>
									
								</td>
								<td class="item cart-list__col cart-list__col_name">
									<a class="cart-list__name" href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><?=$arItem["NAME"]?></a>
									<?if ( $arItem['STATUS_NAL'] ):?>
										<span class="product-card__quantity product-card__quantity_instock cart-list__status">В наличии</span>
									<?else:?>
										<span class="product-card__quantity product-card__quantity_order cart-list__status">Под заказ 1-3 дня</span>
									<?endif;?>
								</td>
							<?
							elseif ($arHeader["id"] == "QUANTITY"):
							?>
								<td class="cart-list__col cart-list__col_quantity">
									
									<div class="spinner spinner_add">
										
										<?
										$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
										$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
										$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
										$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
										?>
										
										<?
										if (!isset($arItem["MEASURE_RATIO"]))
										{
											$arItem["MEASURE_RATIO"] = 1;
										}
										if (
											floatval($arItem["MEASURE_RATIO"]) != 0
										):
										?>

													<a href="javascript:void(0);" class="spinner__dec_cart" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);">-</a>
													<input
														type="text"
														size="3"
														class="spinner__input_cart"
														id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														size="2"
														maxlength="18"
														data-norma="<?=$arItem["MEASURE_RATIO"]?>"
														min="0"
														<?=$max?>
														step="<?=$ratio?>"
														style="max-width: 50px"
														value="<?=$arItem["QUANTITY"]?>"
														onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)"
													>
													<a href="javascript:void(0);" class="spinner__inc_cart" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);">+</a>

										<?
										endif;
										?>
										
									</div>
									<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
								</td>
							<?
							elseif ($arHeader["id"] == "PRICE"):
							?>
								<td class="cart-list__col cart-list__col_sprice">
										<div class="current_price" id="current_price_<?=$arItem["ID"]?>">
											<?=number_format($arItem["PRICE"],0,'.',' ')?> ₽
										</div>
										<div class="old_price" id="old_price_<?=$arItem["ID"]?>">
											<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
												<?=$arItem["FULL_PRICE_FORMATED"]?>
											<?endif;?>
										</div>

									<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
										<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
										<div class="type_price_value"><?=$arItem["NOTES"]?></div>
									<?endif;?>
								</td>
							<?
							elseif ($arHeader["id"] == "DISCOUNT"):
							?>
								<td class="cart-list__col cart-list__col_yprice">
									<?if ( !$arItem["DISCOUNT_PRICE"] ):?>
										<div id="discount_value_<?=$arItem["ID"]?>"><?=number_format($arItem["PRICE"],0,'.',' ')?> ₽</div>
									<?else:?>
										<div id="discount_value_<?=$arItem["ID"]?>"><?=$arItem["DISCOUNT_PRICE"]?></div>
									<?endif;?>
								</td>
							<?
							elseif ($arHeader["id"] == "WEIGHT"):
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<?=$arItem["WEIGHT_FORMATED"]?>
								</td>
							<?
							else:
							?>
								<td class="custom cart-list__col cart-list__col_price">
									
									<?
									if ($arHeader["id"] == "SUM"):
									?>
										<div id="sum_<?=$arItem["ID"]?>">
									<?
									endif;

									echo $arItem[$arHeader["id"]];

									if ($arHeader["id"] == "SUM"):
									?>
										</div>
									<?
									endif;
									?>
								</td>
							<?
							endif;
						endforeach;

						if ($bDelayColumn || $bDeleteColumn):
						?>
							<td class="cart-list__col control cart-list__col_delete">
								<?
								if ($bDeleteColumn):
								?>
									<a class="del" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><?//=GetMessage("SALE_DELETE")?></a>
								<?
								endif;
								if ($bDelayColumn):
								?>
									<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><?=GetMessage("SALE_DELAY")?></a>
								<?
								endif;
								?>
							</td>
						<?
						endif;
						?>
						<td class="cart-list__col cart-list__col_delete">
							<a role="button" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>" class="cart-list__delete del"></a>
						</td>
					</tr>
					<?
					$i++;
					
					endif;
				endforeach;
				?>
			</tbody>
		</table>
		<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
		<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
		<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
		<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
		<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
		<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
		<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
		<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
		<input type="hidden" name="BasketOrder" value="BasketOrder" />
	</form>
</div>
				<div class="content-cart__result cart-result">
                  <div class="cart-result__wrap">
					<?/*
                    <form id="form_one_click" class="cart-result__form form form_cart">
						<input type="hidden" name="TYPE" value="cart">
						<label class="form__label">Заказать в 1 клик:</label>
						<div class="form__row form__row_phone">
							<input class="form__input slider-callback__input" type="text" name="phone" value="" placeholder="">
						</div>
						<input class="form__submit" type="submit" name="one_click_submit" value="Жду звонка">
                    </form>
					*/?>
					
                  </div>
                  <div class="cart-result__wrap cart-result__wrap_flexend">
                    <?/*<span class="cart-result__discount">Скидка: <span class="cart-result__value">9000 ₽</span></span>*/?>
                    <span class="cart-result__price">Итого: <span class="cart-result__value" id="allSum_FORMATED"><?=$arResult["allSum_FORMATED"]?></span></span>


				   <a role="button" href="#" href="javascript:void();" onclick="checkOut();" return false;" id="ORDER_CONFIRM_BUTTON" class="button button_yel cart-result__submit">Оформить заказ</a>
                  </div>
                </div>
	
				<div class="content-cart__tabs tabs">
                    <div class="product-tabs__header-wrap">
                      <ul class="product-tabs__header-list product-tabs__header-list_cart tabs__header">
                        <li data-trigger="delivery" class="product-tabs__header-item tabs-trigger active">О доставке</li>
                        <li data-trigger="payment" class="product-tabs__header-item tabs-trigger">Об оплате</li>
                      </ul>
                    </div>
                    <div data-tab="delivery" class="tabs__content product-tabs__content cart-delivery active">
                      <div class="row">
					  
						<?$APPLICATION->IncludeComponent(
								"bitrix:main.include", 
								".default", 
								array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => "/include/cart_delivery.php",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
						);?>
					  
                        
                      </div>
                    </div>
                    <div data-tab="payment" class="cart-payment product-tabs__content tabs__content">
                      <strong class="cart-payment__title">Способы оплаты товара</strong>
                      <div class="row">
                        <div class="col-lg-15 col-md-15 col-sm-15">
							<?$APPLICATION->IncludeComponent(
								"bitrix:main.include", 
								".default", 
								array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => "/include/cart_payment.php",
									"EDIT_TEMPLATE" => "standard.php"
								),
								false
							);?>

                        </div>
                      </div>
                    </div>
                </div>
<?else:?>

<div class="content__container content__container_cart">
          <div class="cart-empty">
            <div class="cart-empty__content">
              <strong class="cart-empty__title">В корзине нет товара</strong>
              <strong class="cart-empty__subtitle">Для добавления в корзину - перейдите в <a href="/catalog/" class="cart-empty__link">каталог</a></strong>
              <a href="#" onclick="history.back();return false;" class="content-cart__back cart-empty__back">Вернуться к покупкам</a>
            </div>
          </div>
          <div class="cart-estimate">
            <div class="cart-estimate__wrap">
              <strong class="cart-estimate__title">Сэкономьте до 30% на сантехнике за счет исправления  ошибок в смете</strong>
              <a href="#" class="cart-estimate__more">Узнать подробности</a>
              <div class="cart-estimate__content">
                <span class="cart-estimate__close"></span>
                <strong class="cart-estimate__text">Мы отлично знаем, как составляются сметы и какие в них бывают ошибки. Оперативно проверим вашу смету и поможем сэкономить на комплектующих:</strong>
                <ul class="cart-estimate__list">
                  <li class="cart-estimate__item">пересчитаем количество товара;</li>
                  <li class="cart-estimate__item">предложим альтернативные цены;</li>
                  <li class="cart-estimate__item">детализируем укрупненные позиции;</li>
                  <li class="cart-estimate__item">исключим лишнее;</li>
                  <li class="cart-estimate__item">добавим необходимое.</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="estimate-form">
            <form id="estimate_form" class="estimate-form__form form form_estimate">
              <div class="form__row">
                <input class="form__input" type="text" name="name" value="" placeholder="Как вас зовут?">
              </div>
              <div class="form__row form__row_phone">
                <input class="form__input" type="text" name="phone" value="" placeholder="Номер телефона">
              </div>
              <div class="form__row form__row_email">
                <input class="form__input" type="text" name="email" placeholder="E-mail">
                <span class="form__note">Отправим на e-mail наше предложение по смете</span>
              </div>
              <div class="form__row">
                <div class="form__file input-file">
                  <svg class="input-file__button">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-upload"></use>
                  </svg>
                  <p class="input-file__text form__input">Выбрать файлы</p>
                  <input class="input-file__input" type="file">
                </div>
              </div>
              <input class="estimate-form__submit form__submit" type="submit" name="form_submit" value="Отправить на рассчет">
            </form>
          </div>
        </div>	
	

<?
endif;
?>