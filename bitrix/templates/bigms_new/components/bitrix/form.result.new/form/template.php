<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$this->setFrameMode(true);?>

<strong class="form__title callback-form__title">Заполните форму, и наш менеджер свяжется с вами</strong>



<?if ($arResult["isFormNote"] != "Y")
{
?>
<?=$arResult["FORM_HEADER"]?>


          <div class="form__row form__row_name <?if (count($arResult['arrVALUES'])>0 && $arResult['arrVALUES']['form_text_1'] == ''):?>error<?endif?>">
            <input class="form__input" type="text" name="form_text_1" placeholder="Как вас зовут?" value="<?if ( $arResult['arrVALUES']['form_text_1']):?><?=$arResult['arrVALUES']['form_text_1']?><?endif;?>">
          </div>
          <div class="form__row form__row_phone <?if (count($arResult['arrVALUES'])>0 && $arResult['arrVALUES']['form_text_2'] == ''):?>error<?endif?>">
            <input class="form__input" type="text" name="form_text_2" placeholder="Номер телефона" value="<?if ( $arResult['arrVALUES']['form_text_2']):?><?=$arResult['arrVALUES']['form_text_2']?><?endif;?>">
          </div>
          <p class="form__text">Перезвоним в течении рабочего дня<br>с 9:00 до 18:00</p>
		  <p class="form__text">
				<label>
					<input type="checkbox" name="agree_politic" <?if ( $arResult['arrVALUES']['agree_politic'] == 'on' ):?>checked<?endif;?>>
					Я согласен с <a href="/politika-konfidentsialnosti/" target="_blank">политикой конфиденциальности</a>
				</label>
		  </p>
		  <input class="form__submit" type="submit" <?if ( $arResult['arrVALUES']['agree_politic'] !== 'on' ):?>disabled<?endif;?> name="web_form_submit" value="ЖДУ ЗВОНКА">

	

	


<?=$arResult["FORM_FOOTER"]?>
<?
} //endif (isFormNote)
?>

<script type="text/javascript">
	$(function() {
		$('form[name="SIMPLE_FORM_1"]').submit(function() {
			if ($(this).find('input[name="form_text_1"]').val() !== '' && $(this).find('input[name="form_text_2"]').val() !== '') {
				yaCounter31721621.reachGoal('feedback-submit');
			}
		});
		
		$('form[name="SIMPLE_FORM_1"]').find('input[name="agree_politic"]').change(function() {

			if ( $(this).prop("checked")){
				$('form[name="SIMPLE_FORM_1"]').find('.form__submit').prop('disabled',false);
			}
			else {
				$('form[name="SIMPLE_FORM_1"]').find('.form__submit').prop('disabled',true);
			}
			
		});
		
		if( !$('form[name="SIMPLE_FORM_1"]').length > 0 ) {
			$('[data-popup="callback"]').removeClass('js-active');
			var targetData = 'success';
			$('[data-popup="'+ targetData +'"]').addClass('js-active').addClass('scroll-fix');
			$('body').css('paddingRight', scrollWidth).addClass('scroll-fix');
			$('[data-popup="'+ targetData +'"]').find('.popup-trigger').addClass('js-active');
		}
		
		$('.field input[name="form_text_8"]').parent().parent().hide(0);
		$('.field input[name="form_text_8"]').val("http://bigms.ru"+location.pathname);
	});
</script>