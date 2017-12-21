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
<div class="bx-system-auth-forgotpasswd">
	<?ShowMessage($arParams["~AUTH_RESULT"]);?>

	<form name="bform" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">
		<?if (strlen($arResult["BACKURL"]) > 0):?>
			<input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
		<?endif;?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">

		<div class="text"><?= GetMessage("AUTH_FORGOT_PASSWORD_1") ?></div>

		<div class="bx-system-auth-table">
			<!--
			<div class="field">
				<div class="label"><?= GetMessage("AUTH_LOGIN") ?></div>
				<div>
					<input type="text" name="USER_LOGIN" maxlength="50"  value="<?= $arResult["LAST_LOGIN"] ?>"/>
				</div>
			</div>
			<div class="field">
				<div class="label"><?= GetMessage("AUTH_OR") ?></div>
			</div>
			-->
			<div class="field">
				<div class="label"><?= GetMessage("AUTH_EMAIL") ?></div>
				<div>
					<input type="text" name="USER_EMAIL" maxlength="255"/>
				</div>
			</div>

			<div class="field">
				<button type="submit" name="send_account_info" value="<?= GetMessage("AUTH_SEND") ?>"><?= GetMessage("AUTH_SEND") ?></button>
			</div>
		</div>

		<div class="auth_to_modal"><a class="login_modal modalbox" href="#login"><span><?= GetMessage("AUTH_AUTH") ?></span></a></div>
	</form>
</div>