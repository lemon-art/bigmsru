<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->createFrame()->begin("");?>

<div class="modal-content">
	<div class="title"><?=GetMessage('FORM_HEADER_CAPTION')?></div>
	<div class="block_form">
		<form method="post" id="one_click_buy_form" action="<?=$arResult['SCRIPT_PATH']?>/script.php">
			<?foreach($arParams['PROPERTIES'] as $field):?>	
				<div class="field">
					<?
						if ($USER->IsAuthorized())
						{ 
							if ($field=='EMAIL') $value = $USER->GetEmail(); 
							elseif ($field=='FIO') $value = $USER->GetFullName(); 
							elseif ($field=='PHONE') $value = $arResult['USER_PHONE']; 
						} 
					?>
					<div class="label">
						<?=GetMessage('CAPTION_'.$field)?>
						<?if (in_array($field, $arParams['REQUIRED'])):?><span class="starrequired">*</span><?endif;?>
					</div>
					<?if ($field=="COMMENT"){?>
						<div><textarea name="ONE_CLICK_BUY[<?=$field?>]" id="one_click_buy_id_<?=$field?>"></textarea></div>
					<?
					}
					else{?>
						<div><input type="text" name="ONE_CLICK_BUY[<?=$field?>]" value="<?=$value?>" id="one_click_buy_id_<?=$field?>" required="required" /></div>
					<?}?>
				</div>
			<?endforeach;?>
			<?if ($arParams['USE_SKU']=="Y"):?>
				<input type="hidden" name="IBLOCK_ID" value="<?=$arParams['IBLOCK_ID']?>" />
				<input type="hidden" name="USE_SKU" value="Y" />
				<input type="hidden" name="SKU_CODES" value="<?=$arResult['SKU_PROPERTIES_STRING']?>" />
				<label><?=GetMessage('CAPTION_SKU_SELECT')?></label>
				<select name="ELEMENT_ID"><?foreach($arResult['OFFERS'] as $id => $offer_data):?><option value="<?=$id?>"><?=$offer_data?></option><?endforeach;?></select>
			<?endif;?>
			
			<button class="button checkout" type="submit" id="one_click_buy_form_button" name="one_click_buy_form_button" value="<?=GetMessage('ORDER_BUTTON_CAPTION')?>"><span><?=GetMessage("ORDER_BUTTON_CAPTION")?></span></button>
			
			<? if ($arParams['USE_SKU']!="Y"):?><input type="hidden" name="ELEMENT_ID" value="<?=$arParams['ELEMENT_ID']?>" /><?endif;?>
			<? if ($arParams['BUY_ALL_BASKET']=="Y"):?><input type="hidden" name="BUY_TYPE" value="ALL" /><?endif;?>
			<? if (intVal($arParams['ELEMENT_QUANTITY'])):?><input type="hidden" name="ELEMENT_QUANTITY" value="<?=intVal($arParams['ELEMENT_QUANTITY']);?>" /><?endif;?>
			<input type="hidden" name="CURRENCY" value="<?=$arParams['DEFAULT_CURRENCY']?>" />
			<input type="hidden" name="PROPERTIES" value='<?=serialize($arParams['PROPERTIES'])?>' />
			<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arParams['DEFAULT_PAYMENT']?>" />
			<input type="hidden" name="DELIVERY_ID" value="<?=$arParams['DEFAULT_DELIVERY']?>" />
			<input type="hidden" name="PERSON_TYPE_ID" value="<?=$arParams['DEFAULT_PERSON_TYPE']?>" />
			<?=bitrix_sessid_post()?>	
		</form>
	</div>
</div>


<script>
	$(document).ready(function(){
			//$('#one_click_buy_id_PHONE').mask("+7 999-999-99-99");
		var bSubmitFormOneClickBuy = true;
		$("#one_click_buy_form").submit(function(){
			//console.time('test');
			if (bSubmitFormOneClickBuy){
				bSubmitFormOneClickBuy = false;
			} else {
				return false;
			}
			yaCounter31721621.reachGoal('basket-oneclickbuy-submit');
			$.ajax({
				type: "POST",
				url: '/bitrix/components/o2k/oneclickbuy/script.php',
				data: $(this).serialize(),
				timeout: 10000,
				error: function(request,error) {
					bSubmitFormOneClickBuy = true;
					if (error == "timeout") {
						//console.timeEnd('test');
						alert('timeout');
						//console.log(request);
					}
					else {
						alert('Error! Please try again!'+error);
					}
				},
				success: function(data) {
					bSubmitFormOneClickBuy = true;
					if(data.result = "Y"){
						$(".block_form").html('<div class="one_click_buy_result_success">Спасибо за заказ!</div>');
						//setTimeout(function() {window.location.reload();}, 2000);
						$(".wrapper").load(location.href+" .wrapper");
					}
					console.log(data);
					//$(".block_form").html(data.result + '<br >' + data.message);
				}
			});
			
			return false;
		});
	});
</script>