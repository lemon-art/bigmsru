<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$this->setFrameMode(true);?>


         



<?if ($arResult["isFormNote"] != "Y")
{
?>


	<div class="estimate_form">
		<?=$arResult["FORM_HEADER"]?>	
	  <div class="form__row <?if (count($arResult['arrVALUES'])>0 && $arResult['arrVALUES']['form_text_9'] == ''):?>error<?endif?>">
            <label class="form__label">Как Вас зовут</label>
            <input class="form__input" type="text" name="form_text_9" value="<?if ( $arResult['arrVALUES']['form_text_9']):?><?=$arResult['arrVALUES']['form_text_9']?><?endif;?>" placeholder="Введите имя">
          </div>
			
		  <div class="form__row <?if (count($arResult['arrVALUES'])>0 && $arResult['arrVALUES']['form_text_10'] == ''):?>error<?endif?>">
            <label class="form__label">Ваш номер телефона</label>
            <input class="form__input" type="text" name="form_text_10" value="<?if ( $arResult['arrVALUES']['form_text_10']):?><?=$arResult['arrVALUES']['form_text_10']?><?endif;?>" placeholder="+7 999-99-99-999">
          </div>
		  
	 <div class="form__row <?if (count($arResult['arrVALUES'])>0 && $arResult['arrVALUES']['form_text_11'] == ''):?>error<?endif?>">
            <label class="form__label">Ваш e-mail</label>
            <input class="form__input" type="text" name="form_email_11" value="<?if ( $arResult['arrVALUES']['form_text_11']):?><?=$arResult['arrVALUES']['form_text_11']?><?endif;?>" placeholder="simple@mail.ru">
          </div>
	  
	   <div class="form__row">
		 <label class="form__label">Комментарий</label>
		 <textarea rows="5" class="form__input" name="form_textarea_20" placeholder="Позиции из сметы"><?=$arResult['arrVALUES']['form_textarea_20']?></textarea>
	   </div>		
         
		  <div class="form__row">
            <label class="form__label">Выбрать файлы</label>
            <div class="form__file input-file">
              <svg class="input-file__button">
                <use xlink:href="#icon-upload"></use>
              </svg>
              <p class="input-file__text form__input">Загрузите файл со сметой</p>
              <input class="input-file__input" type="file" name="form_file_12">
            </div>
          </div>

		
		  <input class="form__submit" type="submit" name="web_form_submit" value="Отправить на расчёт">

	

	


	<?=$arResult["FORM_FOOTER"]?>
	
</div>

<?
} //endif (isFormNote)
?>

<script type="text/javascript">
	$(function() {
		$('form[name="SIMPLE_FORM_4"]').submit(function() {
			if ($(this).find('input[name="form_text_9"]').val() !== '' && $(this).find('input[name="form_text_10"]').val() !== '') {
				yaCounter31721621.reachGoal('smeta-submit');
			}
		});
		
		  $('input[name="form_text_10"]').inputmask({"mask": "+7(999)999-99-99"});
		  
		  //input file
		  $('[type="file"]').on('focus', function() {
			$(this).prop('value', null);
		  });
		  $('[type="file"]').on('change', function() {
			var value = $(this).val();
			$(this).parent().find('.input-file__text').text(value);
		  });
		
		if( !$('form[name="SIMPLE_FORM_4"]').length > 0 ) {
			$('[data-popup="estimate"]').removeClass('js-active');
			var targetData = 'success_estimate';
			$('[data-popup="'+ targetData +'"]').addClass('js-active').addClass('scroll-fix');
			$('body').css('paddingRight', scrollWidth).addClass('scroll-fix');
			$('[data-popup="'+ targetData +'"]').find('.popup-trigger').addClass('js-active');
		}
		
		$('.field input[name="form_text_8"]').parent().parent().hide(0);
		$('.field input[name="form_text_8"]').val("http://bigms.ru"+location.pathname);
	});
</script>