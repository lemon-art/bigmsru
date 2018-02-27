<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$db_ptype = CSalePaySystem::GetList(
	$arOrder = Array("SORT"=>"ASC", "PSA_NAME"=>"ASC"), 
	Array("LID"=>SITE_ID, "CURRENCY"=>"RUB", "ACTIVE"=>"Y", "PERSON_TYPE_ID"=>$_POST["PERSON_TYPE"])
);
$bFirst = True;
$arPayments = Array();
while ($ptype = $db_ptype->Fetch()){
	$arPayments[] = $ptype;
}
// при доставке через ТК или почтой убрать вариант оплаты наличные курьеру
if ($_POST['DELIVERY_ID'] == 3 || $_POST['DELIVERY_ID'] == 4) {
    foreach ($arPayments as $key => $paySystem) {
        //echo'<pre>'; var_dump($paySystem); echo'</pre>';
        if ($paySystem['ID'] == 1) {
            unset($arPayments[$key]);
        }
    }
}

// при выборе доставки курьером нужно чтобы было 2 способа оплаты: наличными курьеру и сбербанконлайн
//var_dump($arPayments);
if ($_POST['DELIVERY_ID'] == 2 && $_POST['PERSON_TYPE'] == 1) {
    foreach ($arPayments as $key => $paySystem) {
        if ($paySystem['ID'] != 1 && $paySystem['ID'] != 6) {
            unset($arPayments[$key]);
        }
    }
}
?>

					<div data-step="4" class="form__container form__container_wide">
                          <strong class="form__title">Выберите способ оплаты</strong>
						  <input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPayments[0]["ID"]?>" id='PAYMENT_ID'>
                          <div class="form-radio">
                            <ul class="form-radio__list">
							
								<?foreach ( $arPayments as $key => $arPayment):?>
								
									  <li class="form-radio__item <?if ( $key == 0 ):?>active<?endif;?>" data-id="<?=$arPayment["ID"]?>">
										<div class="form-radio__img-wrap form-radio__img-wrap_cash">
										  <svg class="form-radio__img">
											<use xlink:href="#icon-payment-<?=$arPayment["ID"]?>"></use>
										  </svg>
										</div>
										<span class="form-radio__name"><?=$arPayment["NAME"]?></span>
									  </li>
					
								<?endforeach;?>

                            </ul>
                          </div>
                          <p class="form__text form__text_payment">
                            Ссылку на оплату вышлем после подтверждения заказа
                          </p>
                          <strong class="form__title form__title_comment">Комментарий к заказу</strong>
                          <textarea class="form__input form__textarea" name="ORDER_DESCRIPTION" rows="4" placeholder="Опишите нюансы доставки"></textarea>
                          <input class="button button_yel form__submit" type="submit" name="order_submit" value="ОФОРМИТЬ ЗАКАЗ">
                        </div>
