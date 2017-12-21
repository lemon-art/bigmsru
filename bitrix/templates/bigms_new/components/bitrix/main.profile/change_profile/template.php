<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>

<?=ShowError($arResult["strProfileError"]);?>

<div class="change_profile">
	<?
	if ($arResult['DATA_SAVED'] == 'Y')
		echo '<div class="saved">'.ShowNote(GetMessage('PROFILE_DATA_SAVED'))."</div>";
	?>

	<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
		<input type="hidden" name="LOGIN" value=<?=$arResult["arUser"]["LOGIN"]?> />
		<input type="hidden" name="EMAIL" value=<?=$arResult["arUser"]["EMAIL"]?> />
		
		<div class="uf_type">
			<div class="field">
				<input type="hidden" value="" name="UF_TYPE">
				<input type="radio" id="type1" name="UF_TYPE" <?if($arResult["USER_PROPERTIES"]["DATA"]["UF_TYPE"]["VALUE"] == 1){echo 'checked="checked"';}?> value="1">
				<label for="type1">Физическое лицо</label>
				<input type="radio" id="type2" name="UF_TYPE" <?if($arResult["USER_PROPERTIES"]["DATA"]["UF_TYPE"]["VALUE"] == 2){echo 'checked="checked"';}?>value="2">
				<label for="type2">Юридическое лицо</label>
			</div>
		</div>

		
		<div class="left">
			<div class="field">
				<div class="label"><?=GetMessage('NAME')?></div>
				<div><input type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" /></div>
			</div>
		
			<div class="field">
				<div class="label"><?=GetMessage('LAST_NAME')?></div>
				<div><input type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" /></div>
			</div>

			<div class="field">
				<div class="label"><?=GetMessage('SECOND_NAME')?></div>
				<div><input type="text" name="SECOND_NAME" maxlength="50"  value="<?=$arResult["arUser"]["SECOND_NAME"]?>" /></div>
			</div>
			
			<div class="field">
				<div class="label"><?=GetMessage('EMAIL')?><?if($arResult["EMAIL_REQUIRED"]):?><span class="asterisk">*</span><?endif?></div>
				<div><input type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" required="required" /></div>
			</div>
			
			<div class="field">
				<div class="label"><?=GetMessage('NEW_PASSWORD_REQ')?></div>
				<div><input type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" /></div>
			</div>

			<div class="field">
				<div class="label"><?=GetMessage('NEW_PASSWORD_CONFIRM')?></div>
				<div><input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off"/></div>
			</div>
		</div>
		
		<div class="right">
			<div class="field">
				<div class="field"><?=GetMessage('USER_ZIP')?><span class="asterisk">*</span></div>
				<div><input type="text" name="WORK_ZIP" maxlength="255" value="<?=$arResult["arUser"]["WORK_ZIP"]?>" required="required" /></div>
			</div>
			<div class="field">
				<div class="label"><?=GetMessage('USER_STATE')?></div>
				<div><input type="text" name="PERSONAL_STATE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_STATE"]?>" /></div>
			</div>
			<div class="field">
				<div class="label"><?=GetMessage('USER_CITY')?><span class="asterisk">*</span></div>
				<div><input type="text" name="PERSONAL_CITY" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>" required="required" /></div>
			</div>
			<div class="field">
				<div class="label"><?=GetMessage("USER_STREET")?><span class="asterisk">*</span></div>
				<div><input type="text" name="PERSONAL_STREET" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_STREET"]?>" required="required" /></div>
			</div>
			<div class="field">
				<div class="label"><?=GetMessage('USER_PHONE')?><span class="asterisk">*</span></div>
				<div><input type="text" name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" required="required" /></div>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<div class="ur_lico hidden">
			<h4>Реквизиты компании</h4>

			<div class="left">
				<div class="field">
					<div class="label"><?=GetMessage('USER_COMPANY')?><span class="asterisk">*</span></div>
					<div><input type="text" name="WORK_COMPANY" maxlength="255" value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" required="required" /></div>
				</div>
				<div class="field">
					<div class="label">ИНН<span class="asterisk">*</span></div>
					<div><input type="text" class="fields string" value="<?=$arResult["USER_PROPERTIES"]["DATA"]["UF_INN"]["VALUE"];?>" size="60" name="UF_INN" required="required" /></div>
				</div>
				<div class="field">
					<div class="label">ОГРН<span class="asterisk">*</span></div>
					<div><input type="text" class="fields string" size="60" value="<?=$arResult["USER_PROPERTIES"]["DATA"]["UF_OGRN"]["VALUE"];?>" name="UF_OGRN"required="required" /></div>
				</div>
				<div class="field">
					<div class="label">КПП<span class="asterisk">*</span></div>
					<div><input type="text" class="fields string" size="60" value="<?=$arResult["USER_PROPERTIES"]["DATA"]["UF_KPP"]["VALUE"];?>" name="UF_KPP"required="required" /></div>
				</div>
				<div class="field">
					<div class="label">ОКПО<span class="asterisk">*</span></div>
					<div><input type="text" class="fields string" size="60" value="<?=$arResult["USER_PROPERTIES"]["DATA"]["UF_OKPO"]["VALUE"];?>" name="UF_OKPO" required="required" /></div>
				</div>
				<div class="field">
					<div class="label">ОКАТО<span class="asterisk">*</span></div>
					<div><input type="text" class="fields string" size="60" value="<?=$arResult["USER_PROPERTIES"]["DATA"]["UF_OKATO"]["VALUE"];?>" name="UF_OKATO" required="required" /></div>
				</div>
			</div>
			
			<div class="right">
				<div class="field">
					<div class="label">БИК<span class="asterisk">*</span></div>
					<div><input type="text" class="fields string" size="60" value="<?=$arResult["USER_PROPERTIES"]["DATA"]["UF_BIK"]["VALUE"];?>" name="UF_BIK" required="required" /></div>
				</div>
				<div class="field">
					<div class="label">Расчётный счёт<span class="asterisk">*</span></div>
					<div><input type="text" class="fields string" size="60" value="<?=$arResult["USER_PROPERTIES"]["DATA"]["UF_RCH"]["VALUE"];?>" name="UF_RCH" required="required" /></div>
				</div>
				<div class="field">
					<div class="label">Название банка<span class="asterisk">*</span></div>
					<div><input type="text" class="fields string" size="60" value="<?=$arResult["USER_PROPERTIES"]["DATA"]["UF_BANK"]["VALUE"];?>" name="UF_BANK" required="required" /></div>
				</div>
				<div class="field">
					<div class="label">Корр. счёт<span class="asterisk">*</span></div>
					<div><input type="text" class="fields string" size="60" value="<?=$arResult["USER_PROPERTIES"]["DATA"]["UF_KCH"]["VALUE"];?>" name="UF_KCH" required="required" /></div>
				</div>
				<div class="field">
					<div class="label">Юридический адрес<span class="asterisk">*</span></div>
					<div><input type="text" name="WORK_STREET" maxlength="255" value="<?=$arResult["arUser"]["WORK_STREET"]?>" required="required" /></div>
				</div>
			</div>
			
			<div class="clear"></div>
		</div>

		<div class="req"><span class="asterisk">*</span> - обязательные для заполнения</div>

		<input name="save" value="<?=GetMessage("MAIN_SAVE")?>" class="bx_bt_button bx_big shadow" type="submit">
	</form>
</div>