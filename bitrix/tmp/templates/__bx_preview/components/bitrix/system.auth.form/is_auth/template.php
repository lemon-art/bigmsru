<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//if(method_exists($this, 'setFrameMode')) $this->setFrameMode(TRUE);
?>
<div class="is_login">
	<?
	if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
		ShowMessage($arResult['ERROR_MESSAGE']);
	?>
	
	<form action="<?= $arResult["AUTH_URL"] ?>">

		<div class="">
			<a href="<?= $arResult["PROFILE_URL"] ?>" title="<?= GetMessage("AUTH_PROFILE") ?>"><?=$arResult["USER_NAME"]?><?//=$arResult["USER_LOGIN"]?></a> 
			/<input type="submit" name="logout_butt" value="<?= GetMessage("AUTH_LOGOUT_BUTTON") ?>" class="logout_butt" />
			<? foreach ($arResult["GET"] as $key => $value):?>
				<input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
			<? endforeach?>
			<input type="hidden" name="logout" value="yes"/>
		</div>

	</form>
</div>
