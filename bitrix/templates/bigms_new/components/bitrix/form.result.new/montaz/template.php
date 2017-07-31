<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$this->setFrameMode(true);?>

<div class="slider-callback">

	<strong class="form__title slider-callback__title">Свяжитесь с ответственным менеджером по телефону:</strong>
	<a href="tel:89636986513" class="slider-callback__phone">8 (963) 698-65-13</a>
    <p class="form__text">или заполните форму обратной связи.</p>


	<?if ($arResult["isFormNote"] != "Y")
	{
	?>
	<?=$arResult["FORM_HEADER"]?>

			  <div class="form__row form__row_name <?if (count($arResult['arrVALUES'])>0 && $arResult['arrVALUES']['form_text_13'] == ''):?>error<?endif?>">
				<input class="form__input slider-callback__input" type="text" name="form_text_13" placeholder="Как вас зовут?" value="<?if ( $arResult['arrVALUES']['form_text_13']):?><?=$arResult['arrVALUES']['form_text_13']?><?endif;?>">
			  </div>
			  <div class="form__row form__row_phone <?if (count($arResult['arrVALUES'])>0 && $arResult['arrVALUES']['form_text_14'] == ''):?>error<?endif?>">
				<input class="form__input slider-callback__input" type="text" name="form_text_14" placeholder="Номер телефона" value="<?if ( $arResult['arrVALUES']['form_text_14']):?><?=$arResult['arrVALUES']['form_text_14']?><?endif;?>">
			  </div>
		
			  <input class="form__submit" type="submit" name="web_form_submit" value="Получить консультации бесплатно">
			  <p class="form__text">Мы не занимаемся спамом и не передаем ваши данные третьим лицам.</p>

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
		$('form[name="SIMPLE_FORM_5"]').submit(function() {
			if ($(this).find('input[name="form_text_13"]').val() !== '' && $(this).find('input[name="form_text_14"]').val() !== '') {
				yaCounter31721621.reachGoal('feedback-submit');
			}
		});
		$('[name="form_text_13"]').on('keyup', function() {
			if ( $(this).val().length > 2 ){
				$(this).parent('div').removeClass('error');
			}
		});
		$('[name="form_text_14"]').on('keyup', function() {
			$(this).parent('div').removeClass('error');
		});
		$('input[name="form_text_14"]').inputmask({"mask": "+7(999)999-99-99"});

		
		$('.field input[name="form_text_8"]').parent().parent().hide(0);
		$('.field input[name="form_text_8"]').val("http://bigms.ru"+location.pathname);
	});
</script>