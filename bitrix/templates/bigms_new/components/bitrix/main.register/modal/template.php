<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

/**
 * Bitrix vars
 *
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 * @var array $arLangMessages
 * @var array $templateData
 *
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $parentTemplateFolder
 * @var string $templateName
 * @var string $componentPath
 *
 * @var CDatabase $DB
 * @var CUser $USER
 * @var CMain $APPLICATION
 */
//if(method_exists($this, 'setFrameMode')) $this->setFrameMode(TRUE);
?>

          



	<? if ($USER->IsAuthorized()): ?>
		<div class="p"><? ShowNote(GetMessage("MAIN_REGISTER_AUTH")) ?></div>
	<? else: ?>
		<?
		if (count($arResult["ERRORS"]) > 0):?>
		<?
		/*
			foreach ($arResult["ERRORS"] as $key => $error)
				if (intval($key) == 0 && $key !== 0)
					$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".strip_tags(GetMessage("REGISTER_FIELD_".$key))."&quot;", $error);

			//ShowError(implode("<br />", $arResult["ERRORS"]));
		*/
		elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && strlen($_REQUEST['register_submit_button'])):
		?>
			<div class="p"><? ShowNote(GetMessage("REGISTER_EMAIL_WILL_BE_SENT"))?></div>
			<?$noShowForm = true;?>
			<?$arResult["VALUES"] = array();?>
		<? endif ?>
		<?if ( !$noShowForm ):?>
			<form id="register_form" method="POST" class="form form_register popup__form" action="<?= POST_FORM_ACTION_URI ?>" >
				<?if ($arResult["BACKURL"] <> ''):?>
					<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
				<?endif;?>
				<input type="hidden" name="TYPE" value="REGISTRATION"/>
				<input type="hidden" name="register_submit_button" value="Y"/>
				<input type="text" class="api-mf-antibot" value="" name="ANTIBOT[NAME]">
		
					<? foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>

							


							<div class="form__row <?if ( $arResult["ERRORS"][$FIELD] ):?>error<?elseif( $arResult["VALUES"][$FIELD] ):?>validated<?endif;?>">
								<?if ($FIELD != "WORK_COMPANY"){?>
									<label class="form__label"><?= GetMessage("REGISTER_FIELD_".$FIELD) ?><? if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?><span	class="asterisk">*</span><? endif ?></label>
								<?}?>
								<?
									switch ($FIELD)
									{
										case "PASSWORD":
											?><input size="30" type="password" class="form__input" name="REGISTER[<?= $FIELD ?>]"
													 value="<?= $arResult["VALUES"][$FIELD] ?>" autocomplete="off"
													 class="bx-auth-input"/>
											<?
											break;
										case "CONFIRM_PASSWORD":
											?><input size="30" type="password" class="form__input" name="REGISTER[<?= $FIELD ?>]"
													 value="<?= $arResult["VALUES"][$FIELD] ?>" autocomplete="off" /><?
											break;

										case "PERSONAL_GENDER":
											?><select name="REGISTER[<?= $FIELD ?>]">
											<option value=""><?= GetMessage("USER_DONT_KNOW") ?></option>
											<option
												value="M"<?= $arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : "" ?>><?= GetMessage("USER_MALE") ?></option>
											<option
												value="F"<?= $arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : "" ?>><?= GetMessage("USER_FEMALE") ?></option>
											</select><?
											break;

										case "PERSONAL_COUNTRY":
										case "WORK_COUNTRY":
											?><select name="REGISTER[<?= $FIELD ?>]"><?
											foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
											{
												?>
												<option value="<?= $value ?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?= $arResult["COUNTRIES"]["reference"][$key] ?></option>
											<?
											}
											?></select><?
											break;

										case "PERSONAL_PHOTO":
										case "WORK_LOGO":
											?><input size="30" type="file" name="REGISTER_FILES_<?= $FIELD ?>" /><?
											break;

										case "PERSONAL_NOTES":
										case "WORK_NOTES":
											?><textarea cols="30" rows="5"
														name="REGISTER[<?= $FIELD ?>]"><?= $arResult["VALUES"][$FIELD] ?></textarea><?
											break;
										default:
											if ($FIELD != "WORK_COMPANY"){
												if ($FIELD == "PERSONAL_BIRTHDAY"):?>
													<small><?= $arResult["DATE_FORMAT"] ?></small><br/>
												<?endif;?>
												
												<input size="30" type="text" class="form__input" name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>" />
												<?
												if ($FIELD == "PERSONAL_BIRTHDAY"){
													$APPLICATION->IncludeComponent(
														'bitrix:main.calendar',
														'',
														array(
															'SHOW_INPUT' => 'N',
															'FORM_NAME'  => 'regform',
															'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
															'SHOW_TIME'  => 'N'
														),
														null,
														array("HIDE_ICONS" => "Y")
													);
												}
											}
									}?>
							</div>

					<? endforeach ?>
					
					
						<div class="form__row form__row_checkbox">
							<input type="hidden" value="" name="UF_TYPE">
							<input id="cb_pro" type="checkbox" id="type2" class="checkbox form__checkbox" name="UF_TYPE" value="2">
							<label for="cb_pro" class="form__label">Я - профессионал</label>
						</div>
					
						
							

					<?/* if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
						<div class="field">
							<div class="label"><?= strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB") ?></div>
						</div>
						<? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
							<div class="field">
								<div class="label"><?= $arUserField["EDIT_FORM_LABEL"] ?>:<? if ($arUserField["MANDATORY"] == "Y"): ?><span	class="asterisk">*</span><? endif; ?></div>
								<div>
									<? $APPLICATION->IncludeComponent(
										"bitrix:system.field.edit",
										$arUserField["USER_TYPE"]["USER_TYPE_ID"],
										array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS" => "Y")); ?></div>
							</div>
						<? endforeach; ?>
					<? endif; */?>

					<?
					if ($arResult["USE_CAPTCHA"] == "Y"):?>
						<div class="form__row form__row_captcha">
								<input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
								<img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
									 width="180" height="40" class="form__captcha" alt="CAPTCHA"/>
								<label class="form__label">Введите слово с картинки<span class="asterisk">*</span></label>
								<input class="form__input" type="text" maxlength="50" name="captcha_word">
						</div>
					<?endif;?>
					
					
					<div class="form__row form__row_checkbox">
							<input type="checkbox" id="agree_politic" class="checkbox form__checkbox" name="agree_politic">
							<label for="agree_politic" class="form__label"><span>Я согласен с <a href="/politika-konfidentsialnosti/" target="_blank">политикой конфиденциальности</a></span></label>
					</div>

					<p class="form__text">
						<label>
							<input type="checkbox" name="agree_politic" <?if ( $arResult['arrVALUES']['agree_politic'] == 'on' ):?>checked<?endif;?>>
							Я согласен с <a href="/politika-konfidentsialnosti/" target="_blank">политикой конфиденциальности</a>
						</label>
				  </p>
					
					<input class="form__submit" name="register_submit_button" type="submit" name="form_submit" value="ЗАРЕГИСТРИРОВАТЬСЯ">
					

			</form>
		<? endif ?>	
	<? endif ?>
