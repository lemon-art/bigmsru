<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="product-card product-props__card">
									<div class="product-card__content">
									  <div class="product-card__img-wrap">
										<?if ( count($arResult["GIFT"]) > 0 ):?> 
											<span class="product-card__gift"><img src="<?=SITE_TEMPLATE_PATH?>/styles/images/icons/gift.png" alt="">Подарок</span>
										<?endif;?>
										<?if ( $arResult["DELIVERY_FREE"] ):?> 
											<span class="product-card__delivery">Доставка бесплатно</span>
										<?endif;?>
										
									
										<?$file = CFile::ResizeImageGet($arResult['DETAIL_PICTURE']['ID'], array('height'=>250, 'width'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
										<?if($file['src']) {?>
											<img itemprop="image" class="product-card__img" itemprop="image" src="<? echo $file['src'] ?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>">
										<? } else {?>
											<img itemprop="image" style="height: 205px;" class="product-card__img" itemprop="image" src="/bitrix/templates/bigms/images/logo_bw.png" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>">
										<? } ?>
									  </div>
									  <div class="product-card__info">
										<a href="#" class="product-card__name"><?=$arResult["NAME"]?></a>
										<div class="product-card__row product-card__row_between">
										<?if ( $arResult["DISPLAY_PROPERTIES"]["STRANA_PROIZVODITEL"]["VALUE"]):?>
											<span class="product-card__country">
												<span class="product-card__flag-icon country c<?=$arResult["DISPLAY_PROPERTIES"]["STRANA_PROIZVODITEL"]["VALUE_ENUM_ID"]?>"></span>
												<?=$arResult["DISPLAY_PROPERTIES"]["STRANA_PROIZVODITEL"]["VALUE"]?>
											</span>
											<?unset( $arResult["DISPLAY_PROPERTIES"]["STRANA_PROIZVODITEL"] );?>
										<?endif;?>
											<?
											if($arResult['IBLOCK_SECTION_ID'] == 1405 || $arResult['IBLOCK_SECTION_ID'] == 1385 || $arResult['IBLOCK_SECTION_ID'] == 1386) { ?>
												<span class="product-card__quantity product-card__quantity_instock">В наличии</span>
											<? } elseif($arResult["CATALOG_QUANTITY"] <= 0){
												?><span class="product-card__quantity product-card__quantity_order">Под заказ 1-3 дня</span><?
											} else{
												?><span class="product-card__quantity product-card__quantity_instock">В наличии</span><?
											}
											?>
										</div>
										<?$keyProp = 0;?>
										<?foreach ( $arResult["PROP_LIST"] as $propCode ):?>
											<?if ( $keyProp < 3 ):?>
												<?$properties = $arResult["DISPLAY_PROPERTIES"][$propCode];?>
												<?if ( $properties["VALUE"] ):?>
													<span class="product-card__text">
														<?=$properties["NAME"]?>: 
														<?
														if(!empty($properties["DISPLAY_VALUE"])){
															//echo strip_tags($properties["DISPLAY_VALUE"], "");
															echo $properties["DISPLAY_VALUE"];
														}
														else{
															echo $properties["VALUE"];
														}
														?>
													</span>
													<?$keyProp++;?>
												<?endif;?>
											<?endif;?>
										<?endforeach;?>

										<div class="product-card__row product-card__row_start">
											<?if(!empty($minPrice['VALUE'])){?>
												<?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $minPrice['DISCOUNT_VALUE'] < $minPrice['VALUE']):?>
													
														<span class="product-card__price"><?echo number_format($minPrice['DISCOUNT_VALUE'],0,'.',' ');?> ₽</span>
														<span class="product-card__old-price"><?echo number_format($minPrice['VALUE'],0,'.',' ');?> ₽</span>
												<?else:?>
													<span class="product-card__price"><?echo number_format($minPrice['VALUE'],0,'.',' ');?> ₽</span>
												<?endif;?>
											<?}?>
										</div>
										  <div class="product-card__icons">
											
											  <span class="product-card__wish-icon <?if ( in_array($arResult['ID'], $arResult["FAVORITES"])):?>active<?endif;?>" data-id="<?=$arResult['ID']?>"></span>
											<?/*
											  <span class="product-card__compare-icon"></span>
											*/?>
											</div>
									  </div>
									</div>
									<a href="#" data-trigger="cart" class="button button_product popup-add-to-cart" data-id="<?=$arResult["ID"]?>">В корзину</a>
								  </div>