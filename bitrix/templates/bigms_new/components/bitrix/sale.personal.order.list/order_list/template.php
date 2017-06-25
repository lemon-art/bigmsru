<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult['ERRORS']['FATAL'])):?>

	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?=ShowError($error)?>
	<?endforeach?>

<?else:?>

	<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

		<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?endif?>


	<?if(!empty($arResult['ORDERS'])):?>
		<div class="bx_my_order">
			<table class="bx_my_order_table">
				<tr>
					<td>Мои заказы</td>
					<td>Статус заказа</td>
					<td>Количество</td>
					<td>Стоимость</td>
				</tr>
			
				<?foreach($arResult["ORDERS"] as $key => $order):?>
					<tr>
						<td>
							<a href="<?=$order["ORDER"]["URL_TO_DETAIL"]?>"><?=GetMessage('SPOL_ORDER')?> <?=GetMessage('SPOL_NUM_SIGN')?><?=$order["ORDER"]["ACCOUNT_NUMBER"]?></a>
							<?//if(strlen($order["ORDER"]["DATE_INSERT_FORMATED"])):?>
								<?//=GetMessage('SPOL_FROM')?> <?//=$order["ORDER"]["DATE_INSERT_FORMATED"];?>
							<?//endif?>
						</td>
						
						<td>
							<div class="bx_my_order_status <?=$arResult["INFO"]["STATUS"][$order["ORDER"]["STATUS_ID"]]['COLOR']?><?/*yellow*/ /*red*/ /*green*/ /*gray*/?>"><?=$arResult["INFO"]["STATUS"][$order["ORDER"]["STATUS_ID"]]["NAME"]?></div>
						</td>
						
						<td class="kol"><?=count($order["BASKET_ITEMS"])?></td>

						<td class="sum">
							<?echo number_format($order["ORDER"]["PRICE"],0,'',' ');?><span> руб</span>
						</td>
					</tr>
				<?endforeach?>
			</table>
		</div>

		<?if(strlen($arResult['NAV_STRING'])):?>
			<?=$arResult['NAV_STRING']?>
		<?endif?>

	<?else:?>
		<?=GetMessage('SPOL_NO_ORDERS')?>
	<?endif?>

<?endif?>

