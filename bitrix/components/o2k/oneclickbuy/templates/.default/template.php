<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="ocb-form" id="ocb-form-wrap">
	<div class="title"><?=GetMessage('FORM_HEADER_CAPTION')?></div>
	<a class="jqmClose close"></a>
	<form method="post" id="ocb-form" action="<?=$arResult['SCRIPT_PATH']?>/script.php"><div id="ocb-params">
		<input type="hidden" name="buyMode" value="<?=$arParams['BUY_MODE']?>" />
		<? if (!$arParams['USE_SKU']):?><input type="hidden" name="itemId" value="<?=$arParams['ELEMENT_ID']?>" /><?endif;?>
		<?if (strlen($arParams['DUB'])>0):?><input type="hidden" name="dubLetter" value="<?=$arParams['DUB']?>" /><?endif;?>
		<input type="hidden" name="paysystemId" value="<?=$arParams['DEFAULT_PAYMENT']?>" />
		<input type="hidden" name="deliveryId" value="<?=$arParams['DEFAULT_DELIVERY']?>" />
		<input type="hidden" name="personTypeId" value="<?=$arParams['DEFAULT_PERSON_TYPE']?>" />
		<input type="hidden" name="priceId" value="<?=$arParams['PRICE_ID']?>" />
		<input type="hidden" name="currencyCode" value="<?=$arParams['DEFAULT_CURRENCY']?>" />
		<?=bitrix_sessid_post()?>
<?	foreach($arParams['PROPERTIES'] as $field) 
	{
		if ($USER->IsAuthorized()) 
		{
			if ($field=='EMAIL')	$value = $USER->GetEmail();
			elseif ($field=='USER_NAME')	$value = $USER->GetFullName();
			else   $value = $arResult['USER_PHONE'];
		}
?>
		
		
		<div class="ocb-form-field">
			<label><?=GetMessage('CAPTION_'.$field)?>
	<?	if (in_array($field, $arParams['REQUIRED'])):?><span class="starrequired">*</span><?endif;?>
			</label>
			<?if ($field=="COMMENT"):?>
				<textarea name="new_order[<?=$field?>]" id="ocb-id-<?=$field?>"></textarea>
			<?else:?>
				<input type="text" name="new_order[<?=$field?>]" value="<?=$value?>" id="ocb-id-<?=$field?>" />
			<?endif;?>
			<div id="ocb-id-<?=$field?>-error" class="ocb-error-msg"><?=GetMessage('ERROR_' . $field)?></div>
			<? if($field=='PHONE' || $field=='EMAIL') {?>
			<div id="ocb-id-<?=$field?>-format-error" class="ocb-error-msg"><?=GetMessage('FORMAT_ERROR_' . $field)?></div>
			<? }?>
		</div>
<?	}


	if ($arParams['USE_SKU']) {?>
		<div class="ocb-form-field">
			<input type="hidden" name="useSku" value="Y" />
			<input type="hidden" name="skuCodes" value="<?=$arResult['SKU_PROPERTIES_STRING']?>" />
			<input type="hidden" name="iblockId" value="<?=$arParams['IBLOCK_ID']?>" />
			<label><?=GetMessage('CAPTION_SKU_SELECT')?></label>
			<select name="itemId">
	<?	foreach($arResult['OFFERS'] as $id => $offer_data) {?>
				<option value="<?=$id?>"><?=$offer_data?></option>
	<?	}?>
			</select>
		</div>
<?	}?>
<div class="ocb-modules-button">
		<button class="button" type="submit" id="ocb-form-button" name="ocb_form_button" value="<?=GetMessage('ORDER_BUTTON_CAPTION')?>">
			<span><?=GetMessage("ORDER_BUTTON_CAPTION")?></span>
		</button>
		<div class="promt">
			<span class="starrequired">*</span> - <?=GetMessage("IBLOCK_FORM_IMPORTANT");?>
		</div>
</div>

		<div class="ocb-form-loader"></div>
	</div></form>
	<div class="ocb-form-result" id="ocb-form-result">
		<div class="ocb-result-icon-success"><?=GetMessage('ORDER_SUCCESS')?></div>
		<div class="ocb-result-icon-fail"><?=GetMessage('ORDER_ERROR')?></div>
		<div class="ocb-result-text"><?=GetMessage('ORDER_SUCCESS_TEXT')?></div>
	</div>
</div>

<script>
	$('#ocb-form').validate({  rules: 
	{
		<?if (in_array("PHONE", $arParams['REQUIRED'])):?>"new_order[PHONE]": {required : true},	<?endif;?>
		<?if (in_array("USER_NAME", $arParams['REQUIRED'])):?>"new_order[USER_NAME]": {required : true},	<?endif;?>
	} 
	});
	$('.popup').jqmAddClose('.jqmClose');
	$('#ocb-id-PHONE').mask("+7 999-999-99-99");
</script>