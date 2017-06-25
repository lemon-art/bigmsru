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


	<?
	if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
		ShowMessage($arResult['ERROR_MESSAGE']);
	?>
	<? if ($arResult["FORM_TYPE"] == "login"): ?>
		<form id="login_form" class="form popup__form" action="<?= $arResult["AUTH_URL"] ?>">

			
			<?if ($arResult["BACKURL"] <> ''): ?>
				<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
			<?endif ?>

			<?foreach ($arResult["POST"] as $key => $value): ?>
				<input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
			<?endforeach ?>
			<?if ($arResult["STORE_PASSWORD"] == "Y"): ?>
				<input type="hidden" name="USER_REMEMBER" value="Y">
			<?endif ?>
			<input type="hidden" name="AUTH_FORM" value="Y"/>
			<input type="hidden" name="TYPE" value="AUTH"/>

			
			<div class="form__row">
				<label class="form__label">Логин</label>
				<input class="form__input" type="text" name="USER_LOGIN" maxlength="50" value="<?= $arResult["USER_LOGIN"] ?>" placeholder="">
			</div>
			<div class="form__row">
				<label class="form__label">Пароль</label>
				<input class="form__input" type="password" name="USER_PASSWORD" maxlength="50">
			</div>
			
				<?if ($arResult["CAPTCHA_CODE"]): ?>
					<div class="form__row">

						<label class="form__label"><?echo GetMessage("AUTH_CAPTCHA_PROMT") ?></label>
						<div>
							<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"] ?>"/>
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"] ?>"
							     width="180" height="40" alt="CAPTCHA"/><br/>
							<input type="text" name="captcha_word" maxlength="50" value="" class="form__input"/></div>
					</div>
				<?endif ?>

				<div class="form__row form__row_forget">
					<a data-trigger="remember" data-close="login" href="#" class="form__link popup-trigger-self">Вспомнить пароль</a>
				</div>
				
				<input class="form__submit" name="Login" type="submit" name="form_submit" value="ВОЙТИ">
				
				<div class="form__row">
					<a href="#" data-trigger="register" class="form__link form__link_register popup-trigger-self">Зарегистрироваться</a>
				</div>
				

			

		</form>
		
	<?
	elseif ($arResult["FORM_TYPE"] == "otp"):
	?>
		<form name="system_auth_form<?= $arResult["RND"] ?>" method="post" target="_top"
		      action="<?= $arResult["AUTH_URL"] ?>">
			<?if ($arResult["BACKURL"] <> ''):?>
				<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
			<?endif?>
			<input type="hidden" name="AUTH_FORM" value="Y"/>
			<input type="hidden" name="TYPE" value="OTP"/>
			<table width="95%">
				<tr>
					<td colspan="2">
						<?echo GetMessage("auth_form_comp_otp")?><br/>
						<input type="text" name="USER_OTP" maxlength="50" value="" size="17" autocomplete="off"/></td>
				</tr>
				<?if ($arResult["CAPTCHA_CODE"]):?>
					<tr>
						<td colspan="2">
							<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:<br/>
							<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>"/>
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>"
							     width="180" height="40" alt="CAPTCHA"/><br/><br/>
							<input type="text" name="captcha_word" maxlength="50" value=""/></td>
					</tr>
				<?endif?>
				<?if ($arResult["REMEMBER_OTP"] == "Y"):?>
					<tr>
						<td valign="top"><input type="checkbox" id="OTP_REMEMBER_frm" name="OTP_REMEMBER" value="Y"/>
						</td>
						<td width="100%"><label for="OTP_REMEMBER_frm"
						                        title="<?echo GetMessage("auth_form_comp_otp_remember_title")?>"><?echo GetMessage("auth_form_comp_otp_remember")?></label>
						</td>
					</tr>
				<?endif?>
				<tr>
					<td colspan="2"><input type="submit" name="Login" value="<?= GetMessage("AUTH_LOGIN_BUTTON") ?>"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<noindex><a href="<?= $arResult["AUTH_LOGIN_URL"] ?>"
						            rel="nofollow"><?echo GetMessage("auth_form_comp_auth")?></a></noindex>
						<br/></td>
				</tr>
			</table>
		</form>
	<?
	else:
	?>
		<form action="<?= $arResult["AUTH_URL"] ?>">
			<table width="95%">
				<tr>
					<td align="center">
						<?= $arResult["USER_NAME"] ?><br/>
						[<?= $arResult["USER_LOGIN"] ?>]<br/>
						<a href="<?= $arResult["PROFILE_URL"] ?>"
						   title="<?= GetMessage("AUTH_PROFILE") ?>"><?= GetMessage("AUTH_PROFILE") ?></a><br/>
					</td>
				</tr>
				<tr>
					<td align="center">
						<? foreach ($arResult["GET"] as $key => $value):?>
							<input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
						<? endforeach?>
						<input type="hidden" name="logout" value="yes"/>
						<input type="submit" name="logout_butt" value="<?= GetMessage("AUTH_LOGOUT_BUTTON") ?>"/>
					</td>
				</tr>
			</table>
		</form>
	<? endif ?>

