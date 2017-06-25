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

	<?ShowMessage($arParams["~AUTH_RESULT"]);?>
	<form id="remember_form" method="post" class="form form_remember popup__form" action="<?= $arResult["AUTH_URL"] ?>">
		<?if (strlen($arResult["BACKURL"]) > 0):?>
			<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
		<?endif;?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">

	

		<p class="popup__text"><?= GetMessage("AUTH_FORGOT_PASSWORD_1") ?></p>
        <div class="form__row">
            <label class="form__label">Адрес e-mail</label>
            <input class="form__input" type="text" name="USER_EMAIL" maxlength="255">
        </div>
		
        <input data-trigger="sent" name="send_account_info" class="form__submit" type="submit" value="ВЫСЛАТЬ">
        <div class="form__row">
			<a data-trigger="login" data-close="remember" href="#" class="form__link popup-trigger-self">Авторизация</a>
        </div>

				
	</form>
