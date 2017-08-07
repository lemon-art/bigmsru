<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$this->setFrameMode(true);?>

<div class="slider-callback">

	<strong class="form__title slider-callback__title">Получите доступ к специальным ценам для партнеров</strong>
                          
	<?if ($arResult["isFormNote"] != "Y")
	{
	?>
	<?=$arResult["FORM_HEADER"]?>

			  <div class="form__row form__row_name <?if (count($arResult['arrVALUES'])>0 && $arResult['arrVALUES']['form_text_15'] == ''):?>error<?endif?>">
				<input class="form__input slider-callback__input" type="text" name="form_text_15" placeholder="Как вас зовут?" value="<?if ( $arResult['arrVALUES']['form_text_15']):?><?=$arResult['arrVALUES']['form_text_15']?><?endif;?>">
			  </div>
			  <div class="form__row form__row_phone <?if (count($arResult['arrVALUES'])>0 && $arResult['arrVALUES']['form_text_16'] == ''):?>error<?endif?>">
				<input class="form__input slider-callback__input" type="text" name="form_text_16" placeholder="Номер телефона" value="<?if ( $arResult['arrVALUES']['form_text_16']):?><?=$arResult['arrVALUES']['form_text_16']?><?endif;?>">
			  </div>
			  <div class="form__row form__row_email  <?if (count($arResult['arrVALUES'])>0 && $arResult['arrVALUES']['form_email_17'] == ''):?>error<?endif?>">
                <input class="form__input slider-callback__input" type="text" name="form_email_17" placeholder="E-mail" value="<?if ( $arResult['arrVALUES']['form_email_17']):?><?=$arResult['arrVALUES']['form_email_17']?><?endif;?>">
              </div>
              <div class="form__row">
                 <select class="form__select" name="form_text_18">
                    <option selected disabled value="0">Тип партнерства</option>
                    <option value="монтажная организация">монтажная организация</option>
                    <option value="дизайнер">дизайнер</option>
                    <option value="строительная компания">строительная компания</option>
					<option value="частный монтажник">частный монтажник</option>
                </select>
              </div>
              <div class="form__row">
                 <select class="form__select" name="form_text_19">
                    <option selected disabled value="0">Предполагаемый объем в месяц</option>
                    <option value="до 100 т.р.">до 100 т.р.</option>
                    <option value="100–300 т.р.">100–300 т.р.</option>
					<option value="300+ т.р.">300+ т.р.</option>
                 </select>
              </div>
			  <input class="form__submit" type="submit" name="web_form_submit" value="Стать партнером">
			  

	<?=$arResult["FORM_FOOTER"]?>
	<?
	} //endif (isFormNote)
	else {
	?>
		<strong class="popup__title form__title">Обращение принято</strong>
		<p class="popup__text">Наш менеджер свяжется с вами по телефону в течение рабочего дня.</p>
		<p class="popup__text">Спасибо за обращение!</p>
	<?}?>
</div>

<script type="text/javascript">
	$(function() {
	

		$('form[name="SIMPLE_FORM_6"]').submit(function() {
			if ($(this).find('input[name="form_text_15"]').val() !== '' && $(this).find('input[name="form_text_16"]').val() !== '') {
				yaCounter31721621.reachGoal('feedback-submit');
			}
		});
		$('[name="form_text_15"]').on('keyup', function() {
			if ( $(this).val().length > 2 ){
				$(this).parent('div').removeClass('error');
			}
		});
		$('[name="form_text_16"]').on('keyup', function() {
			$(this).parent('div').removeClass('error');
		});
		$('input[name="form_text_16"]').inputmask({"mask": "+7(999)999-99-99"});

		$('.field input[name="form_text_8"]').parent().parent().hide(0);
		$('.field input[name="form_text_8"]').val("http://bigms.ru"+location.pathname);
	});
</script>