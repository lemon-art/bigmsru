<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if ( $arResult["ORDER_ID"] ):?>
      <div class="content__wrap content__wrap_cart">
        <div class="content__container content__container_ordered">
          <div class="content-ordered">
            <h1 class="title-h1 content-ordered__title">Ваш заказ <span class="title-h1_marked">№ <?=$arResult["ORDER_ID"]?></span> оформлен.</h1>
            <p class="content-ordered__text">В ближайшее время наш менеджер свяжется с вами<br>для уточнения деталей оплаты и доставки.</p>
            
            
			
			
<?
			if (!empty($arResult["PAY_SYSTEM"]))
			{
				?>
				<p class="content-ordered__text">
							<?echo GetMessage("STOF_ORDER_PAY_ACTION1")?> <?= $arResult["PAY_SYSTEM"]["NAME"] ?>
				</p>
				
				
				

					<?
					if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
					{
						?>
								<?
								if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
								{
									?>
									<script language="JavaScript">
										window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER_ID"]))?>');
									</script>
									<?= str_replace("#LINK#", $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER_ID"])), GetMessage("STOF_ORDER_PAY_WIN")) ?>
									<?
								}
								else
								{ 
								
									if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
									{
										try
										{
											include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
										}
										catch(\Bitrix\Main\SystemException $e)
										{
											if($e->getCode() == CSalePaySystemAction::GET_PARAM_VALUE)
												$message = GetMessage("SOA_TEMPL_ORDER_PS_ERROR");
											else
												$message = $e->getMessage();

											echo '<span style="color:red;">'.$message.'</span>';
										}
									}
								}
								?>
						<?
					}
					?>
				<?
			}
			?>
			
			<p class="content-ordered__text">Спасибо, что выбрали нас.</p>
			
			<a href="/" class="content-cart__back content-ordered__back">Вернуться на главную</a>
			
			
			<script type="text/javascript">
			 window.onload = function() {
			  yaCounter31721621.reachGoal('TARGET_ORDER_JS');
			 }
			</script>
			
			
<?else:?>
	
<div class="content__container content__container_order">
	<div class="content-order">
		<a href="/basket/" class="content-cart__back content-order__back">Вернуться в корзину</a>
		<h1 class="title-h1"><?$APPLICATION->ShowTitle(false)?></h1>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-20 col-md-20 col-sm-20">
			

			
			
			
				<form method="post" action="<?= htmlspecialcharsbx($arParams["PATH_TO_ORDER"]) ?>" name="order_form" class="content-order__form form form_order">
				
					<?=bitrix_sessid_post()?>
					<div class="form__tabs order-tabs">
						<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step1.php");?>
					
						<div class="content-order__wrap disabled">
							<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step2.php");?>
						</div>
						<div class="content-order__wrap disabled" id="step3">
							<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step3.php");?>
						</div>	
						<div class="content-order__wrap disabled" id="step4">
							<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step4.php");?>
						</div>
						
					</div>

					<input type='hidden' value='<?=$templateFolder?>/' id='step3_file'>
					<input type="hidden" name="DELIVERY_ID" value="" id='DELIVERY_ID'>
					
					

					<input type="hidden" id="ORDER_PRICE" name="ORDER_PRICE" value="<?= $arResult["ORDER_PRICE"] ?>">
					<input type="hidden" name="ORDER_WEIGHT" value="<?= $arResult["ORDER_WEIGHT"] ?>">
					<input type="hidden" name="SKIP_FIRST_STEP" value="<?= $arResult["SKIP_FIRST_STEP"] ?>">
					<input type="hidden" name="SKIP_SECOND_STEP" value="<?= $arResult["SKIP_SECOND_STEP"] ?>">
					<input type="hidden" name="SKIP_THIRD_STEP" value="<?= $arResult["SKIP_THIRD_STEP"] ?>">
					<input type="hidden" name="SKIP_FORTH_STEP" value="<?= $arResult["SKIP_FORTH_STEP"] ?>">



					<input type="hidden" name="BACK" value="">
					<input type="hidden" name="CurrentStep" value="7">


					<input type="hidden" name="PROFILE_ID" value="<?= $arResult["PROFILE_ID"] ?>">
					<input type="hidden" name="DELIVERY_LOCATION" value="<?= $arResult["DELIVERY_LOCATION"] ?>">
					<input type="hidden" name="ORDER_PROP_5" value="<?= $arResult["DELIVERY_LOCATION"] ?>">
					<input type="hidden" name="ORDER_PROP_15" value="<?= $arResult["DELIVERY_LOCATION"] ?>">
					
					<input type="hidden" name="TAX_EXEMPT" value="<?= $arResult["TAX_EXEMPT"] ?>">
					<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="<?= $arResult["PAY_CURRENT_ACCOUNT"] ?>">





					</form>
			
<?endif;?>


