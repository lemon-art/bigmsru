<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>

<?=ShowError($arResult["strProfileError"]);?>

<div class="change_profile">
	<?
	if ($arResult['DATA_SAVED'] == 'Y')
		echo '<div class="saved">'.ShowNote(GetMessage('PROFILE_DATA_SAVED'))."</div>";
	?>

	<form method="post" class="form_personal" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
		<input type="hidden" name="LOGIN" value=<?=$arResult["arUser"]["LOGIN"]?> />
		<input type="hidden" name="EMAIL" value=<?=$arResult["arUser"]["EMAIL"]?> />
		

		<div class="form__row form__row_legal">
            <label for="company_name" class="form__label"><?=GetMessage('NAME')?></label>
            <input type="text" class="form__input" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
        </div>
		
		<div class="form__row form__row_legal">
            <label for="company_name" class="form__label"><?=GetMessage('LAST_NAME')?></label>
            <input type="text" class="form__input" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
        </div>
		
		<div class="form__row form__row_legal">
            <label for="company_name" class="form__label"><?=GetMessage('SECOND_NAME')?></label>
            <input type="text" class="form__input" name="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
        </div>
		
		<div class="form__row form__row_legal">
            <label for="company_name" class="form__label"><?=GetMessage('EMAIL')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="asterisk">*</span><?endif?></label>
            <input type="text" class="form__input" name="EMAIL" maxlength="50" value="<?=$arResult["arUser"]["EMAIL"]?>" required="required"/>
        </div>	

		<div class="form__row form__row_legal">
            <label for="company_name" class="form__label"><?=GetMessage('USER_CITY')?></label>
            <input type="text" class="form__input" name="PERSONAL_CITY" maxlength="50" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>"/>
        </div>	
		
		<div class="form__row form__row_legal">
            <label for="company_name" class="form__label"><?=GetMessage('USER_STREET')?></label>
            <input type="text" class="form__input" name="PERSONAL_STREET" maxlength="50" value="<?=$arResult["arUser"]["PERSONAL_STREET"]?>"/>
        </div>	
		
		<div class="form__row form__row_legal">
            <label for="company_name" class="form__label"><?=GetMessage('USER_PHONE')?></label>
            <input type="text" class="form__input" name="PERSONAL_PHONE" maxlength="50" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>"/>
        </div>	
					
		<div class="form__row form__row_legal">
            <label for="company_name" class="form__label"><?=GetMessage('NEW_PASSWORD_REQ')?></label>
            <input type="password" class="form__input" name="NEW_PASSWORD" maxlength="50" autocomplete="off" />
        </div>	
		
		<div class="form__row form__row_legal">
            <label for="company_name" class="form__label"><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
            <input type="password" class="form__input" name="NEW_PASSWORD_CONFIRM" maxlength="50" autocomplete="off" />
        </div>
		


		<div class="req"><span class="asterisk">*</span> - обязательные для заполнения</div>

		<input name="save" value="<?=GetMessage("MAIN_SAVE")?>" class="form__submit" type="submit">
	</form>
	<br><br><br>
</div>