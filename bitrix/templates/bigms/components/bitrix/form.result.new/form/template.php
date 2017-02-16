<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$this->setFrameMode(true);?>

<?
if ($arResult["isFormTitle"])
{
?>
	<div class="title"><?=$arResult["FORM_TITLE"]?></div>
<?
} //endif ;
?>

<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?=$arResult["FORM_NOTE"]?>

<?if ($arResult["isFormNote"] != "Y")
{
?>
<?=$arResult["FORM_HEADER"]?>


<?
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
?>
	<?
/***********************************************************************************
					form header
***********************************************************************************/
	if ($arResult["isFormImage"] == "Y")
	{
	?>
	<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
	<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
	<?
	} //endif
	?>

	<p><?=$arResult["FORM_DESCRIPTION"]?></p>
		
	<?
} // endif
	?>
<?
/***********************************************************************************
						form questions
***********************************************************************************/
?>
	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
	?>
		<div class="field">
			<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
				<span class="error-fld" title="<?=$arResult["FORM_ERRORS"][$FIELD_SID]?>"></span>
			<?endif;?>
			<div class="label"><?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>:</div>
			<div>
				<?=$arQuestion["HTML_CODE"]?>
			</div>
		</div>
		
	<?
		}
	} //endwhile
	?>
	
<?
if($arResult["isUseCaptcha"] == "Y")
{
?>
		<div>
			<b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b>
		</div>
		<div>
			<div><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></div>
		</div>		
		<div class="field">
			<div class="label"><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>:</div>
			<div>
				<input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
			</div>
		</div>
<?
} // isUseCaptcha
?>
		<div class="field"><input type="text" size="0" value="" name="form_text__1" /></div>
	
		<div class="">
			<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
		</div>


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
		
		$('.field input[name="form_text_8"]').parent().parent().hide(0);
		$('.field input[name="form_text_8"]').val("http://bigms.ru"+location.pathname);
	});
</script>