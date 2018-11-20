<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
require($_SERVER["DOCUMENT_ROOT"]."/include/product_description.php");
$GLOBALS["arLinkedProducts"]["XML_ID"] = $arResult["PROPERTIES"]["RECOMMEND"]["VALUE"];
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */ 
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */ 
/** @var string $componentPath */
/** @var CBitrixComponent $component */

//Устанавливаем нужные классы для header
$this->SetViewTarget("content__wrap");
echo "content__wrap_product";
$this->EndViewTarget("content__wrap");

$this->SetViewTarget("row_div_class");
echo "col-lg-23 col-md-23 col-sm-23";
$this->EndViewTarget("row_div_class");

$this->setFrameMode(true);
$templateLibrary = array('popup');

global $MAIN_SECTION_ID;
$MAIN_SECTION_ID = $arResult["SECTION"]["PATH"][0]["ID"];


//print_r($arResult['IBLOCK_SECTION_ID']);
$currencyList = '';
if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BASIS_PRICE' => $strMainID.'_basis_price',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'BASKET_ACTIONS' => $strMainID.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);

reset($arResult['MORE_PHOTO']);
$arFirstPhoto = current($arResult['MORE_PHOTO']);
?>
			<h1 class="title-h1 title-h1_product"><?=$strTitle?></h1>
		</div>
	</div>
    <div class="row" itemscope itemtype="http://schema.org/Product">
        <div class="col-lg-30 col-md-30 col-sm-30">
            <div class="content-product">
                <div class="content-product__tabs product-tabs tabs">
					<div class="product-tabs__header-wrap">
						<ul class="product-tabs__header-list tabs__header">
							<li data-trigger="all" class="product-tabs__header-item tabs-trigger active">Всё о товаре</li>
							<li data-trigger="stats" class="product-tabs__header-item tabs-trigger">Характеристики</li>
							<?if ($arResult['SHOW_FILES']):?>
								<li data-trigger="docs" class="product-tabs__header-item tabs-trigger">Документация</li>
							<?endif;?>
							<?if ( count($arResult["COLLECTIONS"]) > 0 ):?>
								<li data-trigger="collection" class="product-tabs__header-item tabs-trigger">Товары из одной коллекции (<?=count($arResult["COLLECTIONS"])-1?>)</li>
							<?endif;?>
							<span class="hidden" itemprop="name"><?=$strTitle?></span>
							 
							<?$APPLICATION->IncludeComponent(
								"bitrix:sale.recommended.products",
								"title",
								Array(
									"ACTION_VARIABLE" => "action",
									"TITLE" => "Добавить к заказу",
									"ADDITIONAL_PICT_PROP_1" => "FILES",
									"ADDITIONAL_PICT_PROP_10" => "MORE_PHOTO",
									"ADDITIONAL_PICT_PROP_12" => "MORE_PHOTO",
									"ADDITIONAL_PICT_PROP_8" => "",
									"ADD_PROPERTIES_TO_BASKET" => "Y",
									"BASKET_URL" => "/personal/basket.php",
									"CACHE_TIME" => "86400",
									"CACHE_TYPE" => "A",
									"CART_PROPERTIES_10" => array("",""),
									"CART_PROPERTIES_12" => array("",""),
									"CODE" => $arResult['CODE'],
									"CONVERT_CURRENCY" => "N",
									"DETAIL_URL" => "",
									"HIDE_NOT_AVAILABLE" => "N",
									"IBLOCK_ID" => "10",
									"IBLOCK_TYPE" => "1c_catalog",
									"ID" => $arResult['ID'],
									"LABEL_PROP_10" => "-",
									"LABEL_PROP_12" => "-",
									"LINE_ELEMENT_COUNT" => "3",
									"MESS_BTN_BUY" => "Купить",
									"MESS_BTN_DETAIL" => "Подробнее",
									"MESS_BTN_SUBSCRIBE" => "Подписаться",
									"MESS_NOT_AVAILABLE" => "Нет в наличии",
									"MIN_BUYES" => "1",
									"PAGE_ELEMENT_COUNT" => "100",
									"PARTIAL_PRODUCT_PROPERTIES" => "N",
									"PRICE_CODE" => array("Интернет"),
									"PRICE_VAT_INCLUDE" => "Y",
									"PRODUCT_ID_VARIABLE" => "id",
									"PRODUCT_PROPS_VARIABLE" => "prop",
									"PRODUCT_QUANTITY_VARIABLE" => "quantity",
									"PRODUCT_SUBSCRIPTION" => "N",
									"PROPERTY_CODE_10" => array(
									),
									"PROPERTY_CODE_12" => array(
									),
									"SHOW_DISCOUNT_PERCENT" => "N",
									"SHOW_IMAGE" => "Y",
									"SHOW_NAME" => "Y",
									"SHOW_OLD_PRICE" => "N",
									"SHOW_PRICE_COUNT" => "1",
									"TEMPLATE_THEME" => "blue",
									"USE_PRODUCT_QUANTITY" => "N"
								)
							);?> 
							 
							 
							<?/*
							<li data-trigger="service" class="product-tabs__header-item tabs-trigger">Услуги</li>
							
							<li data-trigger="comments" class="product-tabs__header-item tabs-trigger">Отзывы (<span class="product-tabs__counter">4</span>)</li>
							*/?>
						</ul>
					</div>
					
					
					<div data-tab="all" class="product-tabs__content tabs__content active">
						<div class="row">
							  <div class="col-lg-7 col-md-10 col-sm-10">
								<div class="content-product__image">
									<?if ( count($arResult["GIFT"]) > 0 ):?> 
										<span class="content-product__gift"><img src="<?=SITE_TEMPLATE_PATH?>/styles/images/icons/gift.png" alt="">Подарок</span>
									<?endif;?>
									<?if ( $arResult["DELIVERY_FREE"] ):?> 
										<span class="content-product__delivery"><img src="<?=SITE_TEMPLATE_PATH?>/styles/images/icons/delivery.png" alt="">Бесплатная доставка</span>
									<?endif;?>
									
									<?
									$renderImage = CFile::ResizeImageGet(
										$arResult['DETAIL_PICTURE']['ID'],
										Array("width" => 370, "height" => 360),
										BX_RESIZE_IMAGE_PROPORTIONAL,
										true
									);
									?>
								  	<?if(!empty($renderImage["src"])) {?>
										<a data-trigger="slider"  class="popup-trigger" href="<?=$arResult['DETAIL_PICTURE']['SRC']?>"><img itemprop="image" class="content-product__picture" src="<?=$renderImage["src"]?>" alt="<? echo $imgTitle; ?>" title="<? echo $imgTitle; ?>"></a>
									<? } else {?>
										<img itemprop="image" class="content-product__picture" src="/bitrix/templates/bigms/images/logo_bw.png" alt="<? echo $imgTitle; ?>" title="<? echo $imgTitle; ?>">
										<?$renderImage["src"] = '/bitrix/templates/bigms/images/logo_bw.png';?>
									<? } ?>
									
									
								
									<input type="hidden" name="CAT_PRICE_ID<?=$arResult["ID"]?>" value="<?=$arResult["CATALOG_PRICE_ID_1"]?>"/>
									<input type="hidden" name="CAT_PRICE<?=$arResult["ID"]?>" value="<?=number_format($arResult["CATALOG_PRICE_1"],0,'.',' ')?>  ₽"/>
									<input type="hidden" name="ELEM_NAME<?=$arResult["ID"]?>" value="<?=$arResult["NAME"]?>"/>
									<input type="hidden" name="DETAIL_PAGE<?=$arResult["ID"]?>" value="<?=$arResult["DETAIL_PAGE_URL"]?>"/>
									<input type="hidden" name="PICTURE<?=$arResult["ID"]?>" value="<?=$renderImage["src"]?>"/>
								</div>
								
								<?
								//код для поп ап окна купить в 1 клик
								$this->SetViewTarget("one_click");
								?>
								<div class="popup__container">
									<div class="popup__wrap">
									<span data-trigger="click" class="popup__close popup-trigger"></span>
									<form id="click_form" class="form popup__form">
									  <input type="hidden" name="PRODUCT_ID" value="<?=$arResult["ID"]?>">
									  <input type="hidden" name="PRODUCT_NAME" value="<?=$arResult["NAME"]?>">
									  <input type="hidden" name="DETAIL_PAGE_URL" value="<?=$arResult["DETAIL_PAGE_URL"]?>">
									  <input type="hidden" name="PRICE" value="<?=$arResult["CATALOG_PRICE_1"]?>">
									  <input type="hidden" name="CAT_PRICE_ID" value="<?=$arResult["CATALOG_PRICE_ID_1"]?>"/>
									  <strong class="form__title">Заказ в 1 клик</strong>
									  <div class="form__container">
										<div class="form__img-wrap">
										  <img src="<?=$renderImage["src"]?>" alt="<?=$arResult["NAME"]?>" class="form__img">
										</div>
										<div class="form__description">
										  <strong class="form__subtitle" itemprop="name"><?=$arResult["NAME"]?></strong>
										  <div class="form__inner-wrap">
											<div class="spinner spinner_cart">
											  <a role="button" href="#" class="spinner__dec">–</a>
											  <input class="spinner__input" type="text" name="COUNT" data-norma="<?=$arResult['MIN_NORMA']?>" value="<?=$arResult['MIN_NORMA']?>">
											  <a role="button" href="#" class="spinner__inc">+</a>
											</div>
											<span class="form__price"><?=number_format($arResult["CATALOG_PRICE_1"],0,'.',' ')?> ₽</span>
										  </div>
										  
										  <?
											if($arResult['IBLOCK_SECTION_ID'] == 1405 || !$arResult['PROPERTIES']['DELIVERY_TIME']['VALUE'] || $arResult['IBLOCK_SECTION_ID'] == 1385 || $arResult['IBLOCK_SECTION_ID'] == 1386) { ?>
												<span class="product-card__quantity product-card__quantity_instock">В наличии</span>
												<input type="hidden" name="STATUS<?=$arResult["ID"]?>" data-class="product-card__quantity_instock" value="В наличии"/>
											<? } elseif( $arResult['PROPERTIES']['DELIVERY_TIME']['VALUE'] ){
												?>
												<input type="hidden" name="STATUS<?=$arResult["ID"]?>" data-class="product-card__quantity_order" value="Под заказ"/>
												<span class="product-card__quantity product-card__quantity_order">Под заказ</span>
											<? } elseif($arResult["CATALOG_QUANTITY"] <= 0){
												?>
												<input type="hidden" name="STATUS<?=$arResult["ID"]?>" data-class="product-card__quantity_order" value="Под заказ"/>
												<span class="product-card__quantity product-card__quantity_order">Под заказ</span><?
											} else{
												?>
												<span class="product-card__quantity product-card__quantity_instock">В наличии</span>
												<input type="hidden" name="STATUS<?=$arResult["ID"]?>" data-class="product-card__quantity_instock" value="В наличии"/>
												<?
											}
											?>
										</div>
									  </div>
									  <div class="form__container form__container_fields">
										<div class="form__row form__row_name">
										  <input class="form__input" type="text" name="name" value="" placeholder="Как вас зовут?">
										</div>
										<div class="form__row form__row_phone">
										  <input class="form__input" type="text" name="phone" value="" placeholder="Номер телефона">
										</div>
										<input class="form__submit" type="submit" name="form_submit" value="ЗАКАЗАТЬ">
									  </div>
									</form>
								  </div>
								  </div>
								
								<?$this->EndViewTarget("one_click");?>
								
								 
								<?if( $arResult["MORE_PHOTO_COUNT"] > 1 || count($arResult["PROPERTIES"]["VIDEO"]["VALUE"]) > 0 ):?>
									<div id="thumbs" class="content-product__thumbs-wrap right-shadow">
									  <ul class="content-product__thumbs">
									  
										<?foreach($arResult["PROPERTIES"]["VIDEO"]["VALUE"] as $key => $video):?>
											<li data-trigger="youtube" data-youtube='<iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$video?>" frameborder="0" allowfullscreen></iframe>' class="content-product__thumbnail content-product__thumbnail_video popup-trigger">
												<img src="//img.youtube.com/vi/<?=$video?>/0.jpg" alt="<?=$arResult["NAME"]?>">
											</li>
										<?endforeach;?>
										<?if( $arResult["MORE_PHOTO_COUNT"] > 1 ):?>
											<?foreach($arResult["MORE_PHOTO"] as $key => $photo):?>
												<?
												$renderImage = CFile::ResizeImageGet(
													$photo['ID'], 
													Array("width" => 105, "height" => 105), 
													BX_RESIZE_IMAGE_EXACT, 
													true
												);
												$arResult["MORE_PHOTO"][$key]["SMALL"] = $renderImage["src"];
												?>
													<li data-trigger="slider" data-src="<?=$photo["SRC"]?>" class="content-product__thumbnail popup-trigger">
														<img src="<?=$renderImage["src"]?>" alt="<?=$arResult["NAME"]?>">
													</li>
											<?endforeach;?>
										<?endif;?>
									  </ul>
									</div>
									
									<?//для слайдера в футер?>
									<?$this->SetViewTarget("slider");?>
										<?/*<img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="">*/?>
											
										  <div class="owl-carousel popup-slider__container">
											<?foreach($arResult["MORE_PHOTO"] as $key => $photo):?>
												<?
												$renderImage = CFile::ResizeImageGet(
													$photo['ID'], 
													Array("width" => 500, "height" => 400), 
													BX_RESIZE_IMAGE_PROPORTIONAL, 
													true
												);
												?>
												<img src="<?=$renderImage["src"]?>" alt="<?=$arResult["NAME"]?>">
											<?endforeach;?>
										  </div>
										  <ul class="popup-nav">
											<?foreach($arResult["MORE_PHOTO"] as $key => $photo):?>
												<?
												$renderImage = CFile::ResizeImageGet(
													$photo['ID'], 
													Array("width" => 70, "height" => 70), 
													BX_RESIZE_IMAGE_EXACT, 
													true
												);
												?>
												<li class="popup-nav__item"><img src="<?=$renderImage["src"]?>" alt="<?=$arResult["NAME"]?>"></li>
											<?endforeach;?>
										  </ul>
										  
										
									<?$this->EndViewTarget("slider");?>
									
								<?else:?>
									<?//для слайдера в футер?>
									<?$this->SetViewTarget("slider");?>
										<img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="">
									<?$this->EndViewTarget("slider");?>
								<?endif;?>
								
							  </div>
							  <div class="col-lg-6 col-lg-offset-0 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-1">
								<div class="content-product__info product-info" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
								  <div class="product-info__row product-info__row_end">
										<?
											$minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);
											$boolDiscountShow = (0 < $minPrice['DISCOUNT_DIFF']);
											?>

											<?if(!empty($minPrice['VALUE'])){?>
												<?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $minPrice['DISCOUNT_VALUE'] < $minPrice['VALUE']):?>
													
														<span class="product-info__price" itemprop="price" content="<?=$minPrice['DISCOUNT_VALUE']?>"><?echo number_format($minPrice['DISCOUNT_VALUE'],0,'.',' ');?> ₽</span>
														<span class="product-info__old-price"><?echo number_format($minPrice['VALUE'],0,'.',' ');?> ₽</span>
														
												<?else:?>
													<span itemprop="price" content="<?=$minPrice['VALUE']?>" class="product-info__price <?if ( $arResult['MIN_NORMA'] > 1):?>small_price<?endif;?>"><?echo number_format($minPrice['VALUE'],0,'.',' ');?> ₽<?if ( $arResult["PROPERTIES"]["ZALOG_NA_INSTRUMENT_RUB"]["VALUE"] ):?>/сут.<?endif;?> <?if ( $arResult['MIN_NORMA'] > 1):?>за метр<?endif;?></span>
													<?if ( $arResult['MIN_NORMA'] > 1):?>
														<span class="product-info__price"><?echo number_format($minPrice['VALUE']*$arResult['MIN_NORMA'],0,'.',' ');?> ₽ </span>
													<?endif;?>
													<span class="product-info__cards"><img src="<?=SITE_TEMPLATE_PATH?>/images/cards.jpg" title="Возможна оплата банковскими картами" alt="Возможна оплата банковскими картами"></span>
													
												
												<?endif;?>
												
												<?if ( $arResult["PROPERTIES"]["ZALOG_NA_INSTRUMENT_RUB"]["VALUE"] ):?>
													<span class="product-info__zalog">Залог: <?echo number_format($arResult["PROPERTIES"]["ZALOG_NA_INSTRUMENT_RUB"]["VALUE"],0,'.',' ');?> ₽</span>
													<?unset( $arResult["DISPLAY_PROPERTIES"]["ZALOG_NA_INSTRUMENT_RUB"]);?>
												<?endif;?>
											<?}?>
											
											<meta itemprop="priceCurrency" content="RUB">
											
									</div>
								  	
									<?if ( $arResult['MIN_NORMA'] > 1):?>
										<div class="product-info__props">
											Минимальная норма отгрузки: <?=$arResult['MIN_NORMA']?> м
										</div>
									<?endif;?>
								  
								  
								  <div class="product-info__row product-info__row_icons">
									<?/*
									<div class="product-info__icon-wrap"> 
									  <span class="product-info__compare-icon"></span>
									</div>
									*/?>
									<div class="product-info__icon-wrap">
										<span class="product-info__wish-icon <?if ( in_array($arResult['ID'], $arResult["FAVORITES"])):?>active<?endif;?>" data-id="<?=$arResult['ID']?>"></span>
									</div>
									

									
									
									<?if(!empty($arResult["DISPLAY_PROPERTIES"]["CML2_ARTICLE"]["VALUE"])):?>
										<span class="product-info__id">Артикул: <?=$arResult["DISPLAY_PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span>
									<?endif;?>
								  </div>
								  <div class="product-info__row">
									<div class="product-info__spinner spinner">
									  <a role="button" href="#" class="spinner__dec">–</a>
									  <input class="spinner__input" type="text" name="COUNT<?=$arResult["ID"]?>" data-norma="<?=$arResult['MIN_NORMA']?>" value="<?=$arResult['MIN_NORMA']?>">
									  <a role="button" href="#" class="spinner__inc">+</a>
									</div>
									<div class="product-info__status">
										<?
										if($arResult['IBLOCK_SECTION_ID'] == 1405 || $arResult['IBLOCK_SECTION_ID'] == 1385 || $arResult['IBLOCK_SECTION_ID'] == 1386) { ?>
											<span class="product-card__quantity product-card__quantity_instock">В наличии</span>
											<meta itemprop="availability" href="http://schema.org/InStock" content="В наличии">
											<input type="hidden" name="STATUS<?=$arResult["ID"]?>" data-class="product-card__quantity_instock" value="В наличии"/>
										<? } elseif( $arResult['PROPERTIES']['DELIVERY_TIME']['VALUE'] && $arResult["CATALOG_QUANTITY"] <= 0){
												?>
												<meta itemprop="availability" href="http://schema.org/PreOrder" content="Под заказ">
												<input type="hidden" name="STATUS<?=$arResult["ID"]?>" data-class="product-card__quantity_order" value="Под заказ 1-3 дня"/>
												<span class="product-card__quantity product-card__quantity_order">Под заказ <?=$arResult['PROPERTIES']['DELIVERY_TIME']['VALUE']?></span>
										<? } elseif($arResult["CATALOG_QUANTITY"] <= 0){
											?>
											<meta itemprop="availability" href="http://schema.org/PreOrder" content="Под заказ">
											<input type="hidden" name="STATUS<?=$arResult["ID"]?>" data-class="product-card__quantity_order" value="Под заказ 1-3 дня"/>
											<span class="product-card__quantity product-card__quantity_order">Под заказ 1-3 дня</span><?
										} else{
											?>
											<meta itemprop="availability" href="http://schema.org/InStock" content="В наличии">
											<span class="product-card__quantity product-card__quantity_instock">В наличии</span>
											<input type="hidden" name="STATUS<?=$arResult["ID"]?>" data-class="product-card__quantity_instock" value="В наличии"/>
											<?
										}
										?>

										
									<?if ( $arResult["DISPLAY_PROPERTIES"]["STRANA_PROIZVODITEL"]["VALUE"]):?>
										<span class="product-card__country">
											<span class="product-card__flag-icon country c<?=$arResult["DISPLAY_PROPERTIES"]["STRANA_PROIZVODITEL"]["VALUE_ENUM_ID"]?>"></span>
											<?=$arResult["DISPLAY_PROPERTIES"]["STRANA_PROIZVODITEL"]["VALUE"]?>
										</span>
										<?unset( $arResult["DISPLAY_PROPERTIES"]["STRANA_PROIZVODITEL"] );?>
									
									<?endif;?>
									</div>
								  </div>
								  <div class="product-info__row product-info__row_buy active">
									<a role="button" data-trigger="cart" href="#" id="<? echo $arResult['BUY_LINK']; ?>" href="javascript:void(0)" rel="nofollow" class="product-info__buy popup-add-to-cart" onmousedown="try { rrApi.addToBasket(<?=$arResult['ID']?>) } catch(e) {}" onclick="yaCounter31721621.reachGoal('basket');" data-id="<?=$arResult['ID']?>">Купить</a>
                
								  </div>
								  
								  <div class="product-info__row product-info__row_click active">
									<a role="button" data-trigger="click" href="#" class="product-info__buy product-info__buy_one popup-trigger">Купить в 1 клик</a>
								  </div>
								  
								  <div class="product-info__row product-info__row_incart">
									<span href="#" class="button product-info__incart">Товар в корзине</span>
									<a href="" data-id="<?=$arResult["ID"]?>" class="product-info__delete">Удалить</a>
								  </div>
								  <div class="product-info__props tech-props">
									<strong class="tech-props__title">Технические характеристики</strong>
									<table class="tech-props__table">
										<?
										$i = 0;
										foreach($arResult["DISPLAY_PROPERTIES"] as $code=>$properties){
										if($code !== "RASPRODAZHA" && $code !== "DELIVERY_TIME" && $code !== "MINIMALNAYA_NORMA_OTGRUZKI_M" && $code !== "NOVINKA" && $code != "ARTICUL" && $code != "LIDER_PRODAZH" && $code != "DELIVERY" && $code != "FILES" && $code != "GARANTY" && $code != "CML2_ARTICLE" && $code != "RECOMMEND" && $code != "VIDEO"){
												
												if($i < 6){?>
									  <tr class="tech-props__row">
										<td class="tech-props__td"><?=$properties["NAME"]?></td>
										<td class="tech-props__td">
											
											<?if (is_array($properties['DISPLAY_VALUE'])){
												echo implode("&nbsp;/&nbsp;", $properties["DISPLAY_VALUE"]);
											}else{
												echo $properties['DISPLAY_VALUE'];
											}
										
 
											?>
										</td>
									  </tr>
									  <?
										}
										$i++;
									}
								}
								?>
									</table>
									<a href="#" class="tech-props__all">Все характеристики</a>
								  </div>
								</div>
							  </div>
							  <div class="col-lg-7 col-lg-offset-1 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-1">
								<div class="content-product__about product-about">
								<?/*
								  <div class="product-about__wrap">
									<img class="product-about__brand" src="styles/images/icons/ariston.png" alt="Ariston">
									<p class="product-about__text">Мы являемся официальным дистрибьютором торговой марки Ariston</p>
									<a data-trigger="slider" href="#" class="product-about__link popup-trigger">Сертификат</a>
								  </div>
								*/?> 
								  <div class="product-about__wrap">
									<strong class="product-about__title"><?=$arDescription['exchange']['title']?></strong>
									<p class="product-about__text"><?=$arDescription['exchange']['text']?></p>
								  </div>
								  <?if ( $arResult["DISPLAY_PROPERTIES"]["GARANTIYA_LET"]["VALUE"] ):?>
									  <div class="product-about__wrap">
										<strong class="product-about__title"><?=$arResult["DISPLAY_PROPERTIES"]["GARANTIYA_LET"]["VALUE"]?> <?=numberof($arResult["DISPLAY_PROPERTIES"]["GARANTIYA_LET"]["VALUE"], '', array('год', 'года', 'лет'))?> гарантии от производителя</strong>
									  </div>
								  <?endif;?>
								  <div class="product-about__wrap">
									<strong class="product-about__title"><?=$arDescription['payment']['title']?></strong>
									<?=$arDescription['payment']['text']?>
								  </div>
								  <div class="product-about__wrap">
									<strong class="product-about__title"><?=$arDescription['delivery']['title']?></strong>
									<?=$arDescription['delivery']['text']?>
								  </div>
								</div>
							  </div>
							 					
								<?//вывод подарка?>
								<?if ( count($arResult["GIFT"]) > 0 ):?> 
							  
								  <div class="col-lg-8 col-lg-offset-1 col-md-30 col-md-offset-0 col-sm-30 col-sm-offset-0">
									<div class="content-product__promo promo">
									  <div class="promo__wrap">
										<div class="promo__item"><div class="promo__img"><img src="styles/images/promo-img1.jpg" alt=""></div></div>
										<div class="promo__item">
										  <span class="content-product__gift promo__gift"><img src="styles/images/icons/gift.png" alt="">Подарок</span>
										  <div class="promo__img"><img src="styles/images/promo-img2.jpg" alt=""></div>
										</div>
									  </div>
									  <p class="promo__text">Акция! Купите этот товар и получите <a href="<?=$arResult["GIFT"]["DETAIL_PAGE_URL"]?>"><?=$arResult["GIFT"]["NAME"]?></a> в подарок!</p>
									</div>
								  </div>
								  
								<?endif;?>
							  
	                    </div>
						
							<div class="row">
							  <div class="col-lg-21">
								<div class="content-product__description product-description">
								  <strong class="content-product__title product-description__title">Описание «<?=$arResult["NAME"]?>»</strong>
								  <div class="product-description__wrap" itemprop="description">
										<p class="product-description__text">ваываыва<?=$arResult["DETAIL_TEXT"]?></p>
								  </div>
								</div>
							  </div>
							</div>	
						
						
						
						<?$APPLICATION->IncludeComponent(
						"bitrix:sale.recommended.products",
						"",
						Array(
							"ACTION_VARIABLE" => "action",
							"TITLE" => "Добавить к заказу",
							"ADDITIONAL_PICT_PROP_1" => "FILES",
							"ADDITIONAL_PICT_PROP_10" => "MORE_PHOTO",
							"ADDITIONAL_PICT_PROP_12" => "MORE_PHOTO",
							"ADDITIONAL_PICT_PROP_8" => "",
							"ADD_PROPERTIES_TO_BASKET" => "Y",
							"BASKET_URL" => "/personal/basket.php",
							"CACHE_TIME" => "86400",
							"CACHE_TYPE" => "A",
							"CART_PROPERTIES_10" => array("",""),
							"CART_PROPERTIES_12" => array("",""),
							"CODE" => $arResult['CODE'],
							"CONVERT_CURRENCY" => "N",
							"DETAIL_URL" => "",
							"HIDE_NOT_AVAILABLE" => "N",
							"IBLOCK_ID" => "10",
							"IBLOCK_TYPE" => "1c_catalog",
							"ID" => $arResult['ID'],
							"LABEL_PROP_10" => "-",
							"LABEL_PROP_12" => "-",
							"LINE_ELEMENT_COUNT" => "3",
							"MESS_BTN_BUY" => "Купить",
							"MESS_BTN_DETAIL" => "Подробнее",
							"MESS_BTN_SUBSCRIBE" => "Подписаться",
							"MESS_NOT_AVAILABLE" => "Нет в наличии",
							"MIN_BUYES" => "1",
							"PAGE_ELEMENT_COUNT" => "4",
							"PARTIAL_PRODUCT_PROPERTIES" => "N",
							"PRICE_CODE" => array("Интернет"),
							"PRICE_VAT_INCLUDE" => "Y",
							"PRODUCT_ID_VARIABLE" => "id",
							"PRODUCT_PROPS_VARIABLE" => "prop",
							"PRODUCT_QUANTITY_VARIABLE" => "quantity",
							"PRODUCT_SUBSCRIPTION" => "N",
							"PROPERTY_CODE_10" => array(
								0 => "ELEKTRICHESKAYA_MOSHCHNOST_NAPRYAZHENIE_VT_V",
								1 => "PRISOEDINITELNYY_RAZMER",
								2 => "MOSHCHNOST_ELEKTRICHESKAYA_KVT",
								5 => "VES_NETTO_BRUTTO_KG",
								7 => "SHIRINA_SM",
								8 => "GLUBINA_MM",
								9 => "VYSOTA_SM",
								10 => "MATERIAL",
								11 => "MAKSIMALNAYA_TEMPERATURA_S",
								12 => "NAPOR_M",
								13 => "PROPUSKNAYA_SPOSOBNOST_KVS_M_CHAS",
								14 => "TEMPERATURA_RABOCHEY_SREDY_S",
								15 => "TOLSHCHINA_MM",
								16 => "BREND",
								17 => "DLINA_SM",
								18 => "OBYEM_L",
								19 => "RABOCHEE_DAVLENIE_BAR",
								21 => "VNUTRENNIY_BAK",
								22 => "MOSHCHNOST_TEPLOOBMENNIKA_KVT",
								23 => "VSTROENNYY_TEN_KVT",
								24 => "PODSOEDINENIE_KONTURA_OTOPLENIYA",
								25 => "PODSOEDINENIE_KONTURA_GVS",
								26 => "PROIZVODITELNOST_M_CHAS",
								27 => "POVERKHNOST_NAGREVA_M",
								28 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_25_L_M",
								29 => "TIP_MONTAZHA",
								30 => "KAMERA_SGORANIYA",
								31 => "DIAMETR_DYMOKHODA_MM",
								32 => "PODSOEDINENIE_KONTURA_KHVS",
								33 => "MEZHOSEVOE_RASSTOYANIE_MM",
								34 => "TEPLOOTDACHA_VT",
								35 => "STATUS_NALICHIYA_NA_SKLADE",
								36 => "TSVET",
								37 => "KRANBUKSA",
								38 => "AERATOR",
								39 => "TIP",
								40 => "KARTRIDZH",
								42 => "UPRAVLENIE",
								43 => "VYSOTA_IZLIVA_SM",
								44 => "DLINA_IZLIVA_SM",
								45 => "NAZNACHENIE_",
								46 => "STRANA_PROIZVODITEL",
								47 => "MAKSIMALNYY_KOMMUTIRUEMYY_TOK_A",
								48 => "KLASS_ZASHCHITY_IP",
								49 => "TEMPERATURA_OKRUZHAYUSHCHEY_SREDY_S",
								50 => "GRUPPIROVKA_DLYA_SAYTA",
								51 => "KOLLEKTSIYA",
								52 => "OBLAST_PRIMENENIYA",
								53 => "OTVERSTIE_DLYA_MONTAZHA",
								54 => "STILISTIKA_DIZAYNA",
								55 => "OSNASHCHENIE",
								56 => "KLASS_ZASHCHITY",
								57 => "GLUBINA_VSASYVANIYA_M",
								58 => "MOSHCHNOST_VT",
								59 => "PROIVODITENOST_L_CH",
								60 => "MAKSIMALNYY_NAPOR_M",
								61 => "DLINA_KABELYA_M",
								62 => "OTAPLIVAEMAYA_PLOSHCHAD_KV_M",
								63 => "BUKHTA_M",
								64 => "KOMPLEKTATSIYA",
								65 => "MAKSIMALNOE_DAVLENIE_BAR",
								66 => "DY",
								67 => "FURNITURA",
								68 => "VYPUSK_UNITAZA",
								69 => "PROIZVODITELNOST_GORYACHEY_VODY_RI_T_25",
								70 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_35_L_M",
								71 => "DIAMETR_DYMOOTVODA_TRUB_KOAKS_RAZDELNYKH_MM",
								72 => "MAKS_RASKHOD_PRIRODNOGO_SZHIZHENNOGO_GAZA_M_CH_KG_",
								73 => "MAKS_PROIZVODITELNOST_KPD_",
								74 => "EMKOST_L",
								75 => "PODACHA_GAZA",
								76 => "VKHOD_KHOLODNOY_VODY_V_KOTEL",
								77 => "VOZVRAT_IZ_SISTEMY_OTOPLENIYA",
								78 => "TSIRKULYATOR",
								79 => "STEKLO_MM",
								80 => "KONSTRUKTSIYA_DVEREY",
								81 => "SIDENE",
								82 => "ELEKTRONNOE_UPRAVLENIE",
								83 => "GIDROMASSAZH_SPINY_KOL_VO_FORSUNOK",
								84 => "TROPICHESKIY_DUSH",
								85 => "VENTILYATSIYA",
								86 => "ZERKALO",
								87 => "RADIO",
								88 => "ZADNYAYA_STENKA",
								89 => "ISPOLNENIE_STEKOL",
								90 => "PODSVETKA",
								91 => "PROFIL",
								92 => "SMESITEL",
								93 => "DIAMETR_MM",
								94 => "NOVINKA",
								95 => "RASPRODAZHA",
								96 => "LIDER_PRODAZH",
								98 => "GARANTY",
								99 => "ARMIROVANIE",
								100 => "PRIS_DIAMETR",
								101 => "RESBA",
								102 => "VID_SOEDINENIA",
								103 => "VID_REM_FITINGA",
								104 => "MARKIROVKA",
								105 => "TIP_IZDELIYA"
							),
							"PROPERTY_CODE_12" => array(
								1 => "ELEKTRICHESKAYA_MOSHCHNOST_NAPRYAZHENIE_VT_V",
								2 => "PRISOEDINITELNYY_RAZMER",
								3 => "MOSHCHNOST_ELEKTRICHESKAYA_KVT",
								7 => "SHIRINA_SM",
								8 => "GLUBINA_MM",
								9 => "VYSOTA_SM",
								10 => "MATERIAL",
								11 => "MAKSIMALNAYA_TEMPERATURA_S",
								12 => "NAPOR_M",
								13 => "PROPUSKNAYA_SPOSOBNOST_KVS_M_CHAS",
								14 => "TEMPERATURA_RABOCHEY_SREDY_S",
								15 => "TOLSHCHINA_MM",
								16 => "ARMIROVANIE",
								17 => "DLINA_SM",
								18 => "OBYEM_L",
								19 => "RABOCHEE_DAVLENIE_BAR",
								21 => "VNUTRENNIY_BAK",
								22 => "MOSHCHNOST_TEPLOOBMENNIKA_KVT",
								23 => "VSTROENNYY_TEN_KVT",
								24 => "PODSOEDINENIE_KONTURA_OTOPLENIYA",
								25 => "PODSOEDINENIE_KONTURA_GVS",
								26 => "PROIZVODITELNOST_M_CHAS",
								27 => "POVERKHNOST_NAGREVA_M",
								28 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_25_L_M",
								29 => "TIP_MONTAZHA",
								30 => "KAMERA_SGORANIYA",
								31 => "DIAMETR_DYMOKHODA_MM",
								32 => "PODSOEDINENIE_KONTURA_KHVS",
								33 => "MEZHOSEVOE_RASSTOYANIE_MM",
								34 => "TEPLOOTDACHA_VT",
								35 => "STATUS_NALICHIYA_NA_SKLADE",
								36 => "TSVET",
								37 => "KRANBUKSA",
								38 => "AERATOR",
								39 => "TIP",
								40 => "KARTRIDZH",
								42 => "UPRAVLENIE",
								43 => "VYSOTA_IZLIVA_SM",
								44 => "DLINA_IZLIVA_SM",
								45 => "NAZNACHENIE_",
								46 => "STRANA_PROIZVODITEL",
								47 => "MAKSIMALNYY_KOMMUTIRUEMYY_TOK_A",
								48 => "KLASS_ZASHCHITY_IP",
								49 => "TEMPERATURA_OKRUZHAYUSHCHEY_SREDY_S",
								50 => "GRUPPIROVKA_DLYA_SAYTA",
								51 => "KOLLEKTSIYA",
								52 => "OBLAST_PRIMENENIYA",
								53 => "OTVERSTIE_DLYA_MONTAZHA",
								54 => "STILISTIKA_DIZAYNA",
								55 => "OSNASHCHENIE",
								56 => "KLASS_ZASHCHITY",
								57 => "GLUBINA_VSASYVANIYA_M",
								58 => "MOSHCHNOST_VT",
								59 => "PROIVODITENOST_L_CH",
								60 => "MAKSIMALNYY_NAPOR_M",
								61 => "DLINA_KABELYA_M",
								62 => "OTAPLIVAEMAYA_PLOSHCHAD_KV_M",
								63 => "BUKHTA_M",
								64 => "KOMPLEKTATSIYA",
								65 => "MAKSIMALNOE_DAVLENIE_BAR",
								66 => "DY",
								67 => "FURNITURA",
								68 => "VYPUSK_UNITAZA",
								69 => "PROIZVODITELNOST_GORYACHEY_VODY_RI_T_25",
								70 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_35_L_M",
								71 => "DIAMETR_DYMOOTVODA_TRUB_KOAKS_RAZDELNYKH_MM",
								72 => "MAKS_RASKHOD_PRIRODNOGO_SZHIZHENNOGO_GAZA_M_CH_KG_",
								73 => "MAKS_PROIZVODITELNOST_KPD_",
								74 => "EMKOST_L",
								75 => "PODACHA_GAZA",
								76 => "VKHOD_KHOLODNOY_VODY_V_KOTEL",
								77 => "VOZVRAT_IZ_SISTEMY_OTOPLENIYA",
								78 => "TSIRKULYATOR",
								79 => "STEKLO_MM",
								80 => "KONSTRUKTSIYA_DVEREY",
								81 => "SIDENE",
								82 => "ELEKTRONNOE_UPRAVLENIE",
								83 => "GIDROMASSAZH_SPINY_KOL_VO_FORSUNOK",
								84 => "TROPICHESKIY_DUSH",
								85 => "VENTILYATSIYA",
								86 => "ZERKALO",
								87 => "RADIO",
								88 => "ZADNYAYA_STENKA",
								89 => "ISPOLNENIE_STEKOL",
								90 => "PODSVETKA",
								91 => "PROFIL",
								92 => "SMESITEL",
								93 => "DIAMETR_MM",
							),
							"SHOW_DISCOUNT_PERCENT" => "N",
							"SHOW_IMAGE" => "Y",
							"SHOW_NAME" => "Y",
							"SHOW_OLD_PRICE" => "N",
							"SHOW_PRICE_COUNT" => "1",
							"TEMPLATE_THEME" => "blue",
							"USE_PRODUCT_QUANTITY" => "N"
						)
					);?>
						
							
						<?if ( count($arResult["SIMILAR_ITEMS"]) > 0 ):?>
							<?
							//выводим похожие товары
							global $similarFilter;
							$similarFilter = array(
								"=ID" => $similar_items_ids
							);
							?>
							<section class="products-similar">
								<strong class="products-similar__title content-product__title">Похожие товары в наличии</strong>
								<div id="products-similar" class="products-similar__wrap right-shadow">
									<ul class="products-similar__list">
										<?$APPLICATION->IncludeComponent("custom:catalog.section", "similar", Array(
											"COMPONENT_TEMPLATE" => ".default",
												"IBLOCK_TYPE" => "1c_catalog",
												"IBLOCK_ID" => $arParams["IBLOCK_ID"],
												"SECTION_ID" => $arResult["SECTION"]["PATH"][0]["ID"],
												"SECTION_CODE" =>"",
												"SECTION_USER_FIELDS" => array(
													0 => "",
													1 => "",
												),
												"ELEMENT_SORT_FIELD" => "sort",
												"ELEMENT_SORT_ORDER" => "asc",
												"ELEMENT_SORT_FIELD2" => "id",
												"ELEMENT_SORT_ORDER2" => "desc",
												"FILTER_NAME" => "similarFilter",
												"INCLUDE_SUBSECTIONS" => "Y",
												"SHOW_ALL_WO_SECTION" => "Y",
												"HIDE_NOT_AVAILABLE" => "N",
												"PAGE_ELEMENT_COUNT" => "20",
												"LINE_ELEMENT_COUNT" => "3",
												"PROPERTY_CODE" => array(
													0 => "NEW",
													1 => "",
												),
												"OFFERS_LIMIT" => "5",
												"TEMPLATE_THEME" => "blue",
												"PRODUCT_SUBSCRIPTION" => "N",
												"SHOW_DISCOUNT_PERCENT" => "Y",
												"SHOW_OLD_PRICE" => "Y",
												"SHOW_CLOSE_POPUP" => "N",
												"MESS_BTN_BUY" => "Купить",
												"MESS_BTN_ADD_TO_BASKET" => "В корзину",
												"MESS_BTN_SUBSCRIBE" => "Подписаться",
												"MESS_BTN_DETAIL" => "Подробнее",
												"MESS_NOT_AVAILABLE" => "Нет в наличии",
												"SECTION_URL" => "",
												"DETAIL_URL" => "",
												"SECTION_ID_VARIABLE" => "SECTION_ID",
												"AJAX_MODE" => "N",
												"AJAX_OPTION_JUMP" => "N",
												"AJAX_OPTION_STYLE" => "Y",
												"AJAX_OPTION_HISTORY" => "N",
												"AJAX_OPTION_ADDITIONAL" => "",
												"CACHE_TYPE" => "N",
												"CACHE_TIME" => "36000000",
												"CACHE_GROUPS" => "Y",
												"SET_TITLE" => "N",
												"SET_BROWSER_TITLE" => "N",
												"BROWSER_TITLE" => "-",
												"SET_META_KEYWORDS" => "N",
												"META_KEYWORDS" => "-",
												"SET_META_DESCRIPTION" => "N",
												"META_DESCRIPTION" => "-",
												"ADD_SECTIONS_CHAIN" => "N",
												"SET_STATUS_404" => "Y",
												"CACHE_FILTER" => "N",
												"ACTION_VARIABLE" => "action",
												"PRODUCT_ID_VARIABLE" => "id",
												"PRICE_CODE" => $arParams["PRICE_CODE"],
												"USE_PRICE_COUNT" => "N",
												"SHOW_PRICE_COUNT" => "1",
												"PRICE_VAT_INCLUDE" => "Y",
												"CONVERT_CURRENCY" => "N",
												"BASKET_URL" => "/basket/",
												"USE_PRODUCT_QUANTITY" => "N",
												"PRODUCT_QUANTITY_VARIABLE" => "",
												"ADD_PROPERTIES_TO_BASKET" => "Y",
												"PRODUCT_PROPS_VARIABLE" => "prop",
												"PARTIAL_PRODUCT_PROPERTIES" => "N",
												"PRODUCT_PROPERTIES" => "",
												"ADD_TO_BASKET_ACTION" => "ADD",
												"DISPLAY_COMPARE" => "Y",
												"PAGER_TEMPLATE" => ".default",
												"DISPLAY_TOP_PAGER" => "N",
												"DISPLAY_BOTTOM_PAGER" => "N",
												"PAGER_TITLE" => "Товары",
												"PAGER_SHOW_ALWAYS" => "N",
												"PAGER_DESC_NUMBERING" => "N",
												"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
												"PAGER_SHOW_ALL" => "N",
												"MESS_BTN_COMPARE" => "Сравнить",
												"ADD_PICT_PROP" => "-",
												"LABEL_PROP" => "-",
												"COMPARE_PATH" => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
											),
											false
										);?>
									</ul>
								</div>
							</section>

						<?endif;?>
						
						<?global $count_view_products;?>
						<?if ( $count_view_products > 1 ):?>
							<?
							//выводим просмотренные товары
							global $similarFilter2;
							?>
							<section class="products-similar">
								<strong class="products-similar__title content-product__title">Просмотренные товары</strong>
								<div id="products-seen" class="products-similar__wrap right-shadow">
									<ul class="products-similar__list">
										<?$APPLICATION->IncludeComponent("custom:catalog.section.lite", "similar", Array(
											"COMPONENT_TEMPLATE" => ".default",
												"IBLOCK_TYPE" => "1c_catalog",
												"IBLOCK_ID" => 10,
												"SECTION_ID" => '',
												"SECTION_CODE" =>"",
												"SECTION_USER_FIELDS" => array(
													0 => "",
													1 => "",
												),
												"ELEMENT_SORT_FIELD" => "",
												"ELEMENT_SORT_ORDER" => "",
												"ELEMENT_SORT_FIELD2" => "",
												"ELEMENT_SORT_ORDER2" => "",
												"FILTER_NAME" => "similarFilter2",
												"INCLUDE_SUBSECTIONS" => "Y",
												"SHOW_ALL_WO_SECTION" => "Y",
												"HIDE_NOT_AVAILABLE" => "N",
												"PAGE_ELEMENT_COUNT" => "20",
												"LINE_ELEMENT_COUNT" => "3",
												"PROPERTY_CODE" => array(
													0 => "NEW",
													1 => "",
												),
												"OFFERS_LIMIT" => "5",
												"TEMPLATE_THEME" => "blue",
												"PRODUCT_SUBSCRIPTION" => "N",
												"SHOW_DISCOUNT_PERCENT" => "Y",
												"SHOW_OLD_PRICE" => "Y",
												"SHOW_CLOSE_POPUP" => "N",
												"MESS_BTN_BUY" => "Купить",
												"MESS_BTN_ADD_TO_BASKET" => "В корзину",
												"MESS_BTN_SUBSCRIBE" => "Подписаться",
												"MESS_BTN_DETAIL" => "Подробнее",
												"MESS_NOT_AVAILABLE" => "Нет в наличии",
												"SECTION_URL" => "",
												"DETAIL_URL" => "",
												"SECTION_ID_VARIABLE" => "SECTION_ID",
												"AJAX_MODE" => "N",
												"AJAX_OPTION_JUMP" => "N",
												"AJAX_OPTION_STYLE" => "Y",
												"AJAX_OPTION_HISTORY" => "N",
												"AJAX_OPTION_ADDITIONAL" => "",
												"CACHE_TYPE" => "N",
												"CACHE_TIME" => "36000000",
												"CACHE_GROUPS" => "Y",
												"SET_TITLE" => "N",
												"SET_BROWSER_TITLE" => "N",
												"BROWSER_TITLE" => "-",
												"SET_META_KEYWORDS" => "N",
												"META_KEYWORDS" => "-",
												"SET_META_DESCRIPTION" => "N",
												"META_DESCRIPTION" => "-",
												"ADD_SECTIONS_CHAIN" => "N",
												"SET_STATUS_404" => "Y",
												"CACHE_FILTER" => "N",
												"ACTION_VARIABLE" => "action",
												"PRODUCT_ID_VARIABLE" => "id",
												"PRICE_CODE" => $arParams["PRICE_CODE"],
												"USE_PRICE_COUNT" => "N",
												"SHOW_PRICE_COUNT" => "1",
												"PRICE_VAT_INCLUDE" => "Y",
												"CONVERT_CURRENCY" => "N",
												"BASKET_URL" => "/basket/",
												"USE_PRODUCT_QUANTITY" => "N",
												"PRODUCT_QUANTITY_VARIABLE" => "",
												"ADD_PROPERTIES_TO_BASKET" => "Y",
												"PRODUCT_PROPS_VARIABLE" => "prop",
												"PARTIAL_PRODUCT_PROPERTIES" => "N",
												"PRODUCT_PROPERTIES" => "",
												"ADD_TO_BASKET_ACTION" => "ADD",
												"DISPLAY_COMPARE" => "Y",
												"PAGER_TEMPLATE" => ".default",
												"DISPLAY_TOP_PAGER" => "N",
												"DISPLAY_BOTTOM_PAGER" => "N",
												"PAGER_TITLE" => "Товары",
												"PAGER_SHOW_ALWAYS" => "N",
												"PAGER_DESC_NUMBERING" => "N",
												"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
												"PAGER_SHOW_ALL" => "N",
												"MESS_BTN_COMPARE" => "Сравнить",
												"ADD_PICT_PROP" => "-",
												"LABEL_PROP" => "-",
												"COMPARE_PATH" => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
											),
											false
										);?>
										<?$APPLICATION->IncludeComponent("custom:catalog.section.lite", "similar", Array(
											"COMPONENT_TEMPLATE" => ".default",
												"IBLOCK_TYPE" => "1c_catalog",
												"IBLOCK_ID" => 12,
												"SECTION_ID" => '',
												"SECTION_CODE" =>"",
												"SECTION_USER_FIELDS" => array(
													0 => "",
													1 => "",
												),
												"ELEMENT_SORT_FIELD" => "",
												"ELEMENT_SORT_ORDER" => "",
												"ELEMENT_SORT_FIELD2" => "",
												"ELEMENT_SORT_ORDER2" => "",
												"FILTER_NAME" => "similarFilter2",
												"INCLUDE_SUBSECTIONS" => "Y",
												"SHOW_ALL_WO_SECTION" => "Y",
												"HIDE_NOT_AVAILABLE" => "N",
												"PAGE_ELEMENT_COUNT" => "20",
												"LINE_ELEMENT_COUNT" => "3",
												"PROPERTY_CODE" => array(
													0 => "NEW",
													1 => "",
												),
												"OFFERS_LIMIT" => "5",
												"TEMPLATE_THEME" => "blue",
												"PRODUCT_SUBSCRIPTION" => "N",
												"SHOW_DISCOUNT_PERCENT" => "Y",
												"SHOW_OLD_PRICE" => "Y",
												"SHOW_CLOSE_POPUP" => "N",
												"MESS_BTN_BUY" => "Купить",
												"MESS_BTN_ADD_TO_BASKET" => "В корзину",
												"MESS_BTN_SUBSCRIBE" => "Подписаться",
												"MESS_BTN_DETAIL" => "Подробнее",
												"MESS_NOT_AVAILABLE" => "Нет в наличии",
												"SECTION_URL" => "",
												"DETAIL_URL" => "",
												"SECTION_ID_VARIABLE" => "SECTION_ID",
												"AJAX_MODE" => "N",
												"AJAX_OPTION_JUMP" => "N",
												"AJAX_OPTION_STYLE" => "Y",
												"AJAX_OPTION_HISTORY" => "N",
												"AJAX_OPTION_ADDITIONAL" => "",
												"CACHE_TYPE" => "N",
												"CACHE_TIME" => "36000000",
												"CACHE_GROUPS" => "Y",
												"SET_TITLE" => "N",
												"SET_BROWSER_TITLE" => "N",
												"BROWSER_TITLE" => "-",
												"SET_META_KEYWORDS" => "N",
												"META_KEYWORDS" => "-",
												"SET_META_DESCRIPTION" => "N",
												"META_DESCRIPTION" => "-",
												"ADD_SECTIONS_CHAIN" => "N",
												"SET_STATUS_404" => "Y",
												"CACHE_FILTER" => "N",
												"ACTION_VARIABLE" => "action",
												"PRODUCT_ID_VARIABLE" => "id",
												"PRICE_CODE" => $arParams["PRICE_CODE"],
												"USE_PRICE_COUNT" => "N",
												"SHOW_PRICE_COUNT" => "1",
												"PRICE_VAT_INCLUDE" => "Y",
												"CONVERT_CURRENCY" => "N",
												"BASKET_URL" => "/basket/",
												"USE_PRODUCT_QUANTITY" => "N",
												"PRODUCT_QUANTITY_VARIABLE" => "",
												"ADD_PROPERTIES_TO_BASKET" => "Y",
												"PRODUCT_PROPS_VARIABLE" => "prop",
												"PARTIAL_PRODUCT_PROPERTIES" => "N",
												"PRODUCT_PROPERTIES" => "",
												"ADD_TO_BASKET_ACTION" => "ADD",
												"DISPLAY_COMPARE" => "Y",
												"PAGER_TEMPLATE" => ".default",
												"DISPLAY_TOP_PAGER" => "N",
												"DISPLAY_BOTTOM_PAGER" => "N",
												"PAGER_TITLE" => "Товары",
												"PAGER_SHOW_ALWAYS" => "N",
												"PAGER_DESC_NUMBERING" => "N",
												"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
												"PAGER_SHOW_ALL" => "N",
												"MESS_BTN_COMPARE" => "Сравнить",
												"ADD_PICT_PROP" => "-",
												"LABEL_PROP" => "-",
												"COMPARE_PATH" => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
											),
											false
										);?>
										
									</ul>	
								</div>
							</section>

						<?endif;?>

					</div>
					<div data-tab="docs" class="product-tabs__content tabs__content">
						<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/files.php");	//вкладка "документация"?>
					</div>
					

						<div data-tab="stats" class="product-tabs__content tabs__content">
							<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/stats.php");	//вкладка "характеристики"?>
						</div>
						
					
					
					<div data-tab="service" class="product-tabs__content tabs__content">
					
					</div>
					<div data-tab="additional" class="product-tabs__content tabs__content">
						<?/*
						<div data-retailrocket-markup-block="58da82c865bf1907bc23147a" data-product-id="<?=$arResult['ID']?>"></div>
						*/?>
						<?$APPLICATION->IncludeComponent(
						"bitrix:sale.recommended.products",
						"",
						Array(
							"ACTION_VARIABLE" => "action",
							"TITLE" => "Дополнительные товары",
							"ADDITIONAL_PICT_PROP_1" => "FILES",
							"ADDITIONAL_PICT_PROP_10" => "MORE_PHOTO",
							"ADDITIONAL_PICT_PROP_12" => "MORE_PHOTO",
							"ADDITIONAL_PICT_PROP_8" => "",
							"ADD_PROPERTIES_TO_BASKET" => "Y",
							"BASKET_URL" => "/personal/basket.php",
							"CACHE_TIME" => "86400",
							"CACHE_TYPE" => "A",
							"CART_PROPERTIES_1" => array("",""),
							"CART_PROPERTIES_10" => array("",""),
							"CART_PROPERTIES_12" => array("",""),
							"CART_PROPERTIES_8" => array("",""),
							"CODE" => $arResult['CODE'],
							"CONVERT_CURRENCY" => "N",
							"DETAIL_URL" => "",
							"HIDE_NOT_AVAILABLE" => "N",
							"IBLOCK_ID" => "10",
							"IBLOCK_TYPE" => "1c_catalog",
							"ID" => $arResult['ID'],
							"LABEL_PROP_1" => "-",
							"LABEL_PROP_10" => "-",
							"LABEL_PROP_12" => "-",
							"LABEL_PROP_8" => "-",
							"LINE_ELEMENT_COUNT" => "3",
							"MESS_BTN_BUY" => "Купить",
							"MESS_BTN_DETAIL" => "Подробнее",
							"MESS_BTN_SUBSCRIBE" => "Подписаться",
							"MESS_NOT_AVAILABLE" => "Нет в наличии",
							"MIN_BUYES" => "1",
							"PAGE_ELEMENT_COUNT" => "100",
							"PARTIAL_PRODUCT_PROPERTIES" => "N",
							"PRICE_CODE" => array("Интернет"),
							"PRICE_VAT_INCLUDE" => "Y",
							"PRODUCT_ID_VARIABLE" => "id",
							"PRODUCT_PROPS_VARIABLE" => "prop",
							"PRODUCT_QUANTITY_VARIABLE" => "quantity",
							"PRODUCT_SUBSCRIPTION" => "N",
							"PROPERTY_CODE_10" => array(
								0 => "ELEKTRICHESKAYA_MOSHCHNOST_NAPRYAZHENIE_VT_V",
								1 => "PRISOEDINITELNYY_RAZMER",
								2 => "MOSHCHNOST_ELEKTRICHESKAYA_KVT",
								5 => "VES_NETTO_BRUTTO_KG",
								7 => "SHIRINA_SM",
								8 => "GLUBINA_MM",
								9 => "VYSOTA_SM",
								10 => "MATERIAL",
								11 => "MAKSIMALNAYA_TEMPERATURA_S",
								12 => "NAPOR_M",
								13 => "PROPUSKNAYA_SPOSOBNOST_KVS_M_CHAS",
								14 => "TEMPERATURA_RABOCHEY_SREDY_S",
								15 => "TOLSHCHINA_MM",
								16 => "BREND",
								17 => "DLINA_SM",
								18 => "OBYEM_L",
								19 => "RABOCHEE_DAVLENIE_BAR",
								21 => "VNUTRENNIY_BAK",
								22 => "MOSHCHNOST_TEPLOOBMENNIKA_KVT",
								23 => "VSTROENNYY_TEN_KVT",
								24 => "PODSOEDINENIE_KONTURA_OTOPLENIYA",
								25 => "PODSOEDINENIE_KONTURA_GVS",
								26 => "PROIZVODITELNOST_M_CHAS",
								27 => "POVERKHNOST_NAGREVA_M",
								28 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_25_L_M",
								29 => "TIP_MONTAZHA",
								30 => "KAMERA_SGORANIYA",
								31 => "DIAMETR_DYMOKHODA_MM",
								32 => "PODSOEDINENIE_KONTURA_KHVS",
								33 => "MEZHOSEVOE_RASSTOYANIE_MM",
								34 => "TEPLOOTDACHA_VT",
								35 => "STATUS_NALICHIYA_NA_SKLADE",
								36 => "TSVET",
								37 => "KRANBUKSA",
								38 => "AERATOR",
								39 => "TIP",
								40 => "KARTRIDZH",
								42 => "UPRAVLENIE",
								43 => "VYSOTA_IZLIVA_SM",
								44 => "DLINA_IZLIVA_SM",
								45 => "NAZNACHENIE_",
								46 => "STRANA_PROIZVODITEL",
								47 => "MAKSIMALNYY_KOMMUTIRUEMYY_TOK_A",
								48 => "KLASS_ZASHCHITY_IP",
								49 => "TEMPERATURA_OKRUZHAYUSHCHEY_SREDY_S",
								50 => "GRUPPIROVKA_DLYA_SAYTA",
								51 => "KOLLEKTSIYA",
								52 => "OBLAST_PRIMENENIYA",
								53 => "OTVERSTIE_DLYA_MONTAZHA",
								54 => "STILISTIKA_DIZAYNA",
								55 => "OSNASHCHENIE",
								56 => "KLASS_ZASHCHITY",
								57 => "GLUBINA_VSASYVANIYA_M",
								58 => "MOSHCHNOST_VT",
								59 => "PROIVODITENOST_L_CH",
								60 => "MAKSIMALNYY_NAPOR_M",
								61 => "DLINA_KABELYA_M",
								62 => "OTAPLIVAEMAYA_PLOSHCHAD_KV_M",
								63 => "BUKHTA_M",
								64 => "KOMPLEKTATSIYA",
								65 => "MAKSIMALNOE_DAVLENIE_BAR",
								66 => "DY",
								67 => "FURNITURA",
								68 => "VYPUSK_UNITAZA",
								69 => "PROIZVODITELNOST_GORYACHEY_VODY_RI_T_25",
								70 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_35_L_M",
								71 => "DIAMETR_DYMOOTVODA_TRUB_KOAKS_RAZDELNYKH_MM",
								72 => "MAKS_RASKHOD_PRIRODNOGO_SZHIZHENNOGO_GAZA_M_CH_KG_",
								73 => "MAKS_PROIZVODITELNOST_KPD_",
								74 => "EMKOST_L",
								75 => "PODACHA_GAZA",
								76 => "VKHOD_KHOLODNOY_VODY_V_KOTEL",
								77 => "VOZVRAT_IZ_SISTEMY_OTOPLENIYA",
								78 => "TSIRKULYATOR",
								79 => "STEKLO_MM",
								80 => "KONSTRUKTSIYA_DVEREY",
								81 => "SIDENE",
								82 => "ELEKTRONNOE_UPRAVLENIE",
								83 => "GIDROMASSAZH_SPINY_KOL_VO_FORSUNOK",
								84 => "TROPICHESKIY_DUSH",
								85 => "VENTILYATSIYA",
								86 => "ZERKALO",
								87 => "RADIO",
								88 => "ZADNYAYA_STENKA",
								89 => "ISPOLNENIE_STEKOL",
								90 => "PODSVETKA",
								91 => "PROFIL",
								92 => "SMESITEL",
								93 => "DIAMETR_MM",
								94 => "NOVINKA",
								95 => "RASPRODAZHA",
								96 => "LIDER_PRODAZH",
								98 => "GARANTY",
								99 => "ARMIROVANIE",
								100 => "PRIS_DIAMETR",
								101 => "RESBA",
								102 => "VID_SOEDINENIA",
								103 => "VID_REM_FITINGA",
								104 => "MARKIROVKA",
								105 => "TIP_IZDELIYA"
							),
							"PROPERTY_CODE_12" => array(
								1 => "ELEKTRICHESKAYA_MOSHCHNOST_NAPRYAZHENIE_VT_V",
								2 => "PRISOEDINITELNYY_RAZMER",
								3 => "MOSHCHNOST_ELEKTRICHESKAYA_KVT",
								7 => "SHIRINA_SM",
								8 => "GLUBINA_MM",
								9 => "VYSOTA_SM",
								10 => "MATERIAL",
								11 => "MAKSIMALNAYA_TEMPERATURA_S",
								12 => "NAPOR_M",
								13 => "PROPUSKNAYA_SPOSOBNOST_KVS_M_CHAS",
								14 => "TEMPERATURA_RABOCHEY_SREDY_S",
								15 => "TOLSHCHINA_MM",
								16 => "ARMIROVANIE",
								17 => "DLINA_SM",
								18 => "OBYEM_L",
								19 => "RABOCHEE_DAVLENIE_BAR",
								21 => "VNUTRENNIY_BAK",
								22 => "MOSHCHNOST_TEPLOOBMENNIKA_KVT",
								23 => "VSTROENNYY_TEN_KVT",
								24 => "PODSOEDINENIE_KONTURA_OTOPLENIYA",
								25 => "PODSOEDINENIE_KONTURA_GVS",
								26 => "PROIZVODITELNOST_M_CHAS",
								27 => "POVERKHNOST_NAGREVA_M",
								28 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_25_L_M",
								29 => "TIP_MONTAZHA",
								30 => "KAMERA_SGORANIYA",
								31 => "DIAMETR_DYMOKHODA_MM",
								32 => "PODSOEDINENIE_KONTURA_KHVS",
								33 => "MEZHOSEVOE_RASSTOYANIE_MM",
								34 => "TEPLOOTDACHA_VT",
								35 => "STATUS_NALICHIYA_NA_SKLADE",
								36 => "TSVET",
								37 => "KRANBUKSA",
								38 => "AERATOR",
								39 => "TIP",
								40 => "KARTRIDZH",
								42 => "UPRAVLENIE",
								43 => "VYSOTA_IZLIVA_SM",
								44 => "DLINA_IZLIVA_SM",
								45 => "NAZNACHENIE_",
								46 => "STRANA_PROIZVODITEL",
								47 => "MAKSIMALNYY_KOMMUTIRUEMYY_TOK_A",
								48 => "KLASS_ZASHCHITY_IP",
								49 => "TEMPERATURA_OKRUZHAYUSHCHEY_SREDY_S",
								50 => "GRUPPIROVKA_DLYA_SAYTA",
								51 => "KOLLEKTSIYA",
								52 => "OBLAST_PRIMENENIYA",
								53 => "OTVERSTIE_DLYA_MONTAZHA",
								54 => "STILISTIKA_DIZAYNA",
								55 => "OSNASHCHENIE",
								56 => "KLASS_ZASHCHITY",
								57 => "GLUBINA_VSASYVANIYA_M",
								58 => "MOSHCHNOST_VT",
								59 => "PROIVODITENOST_L_CH",
								60 => "MAKSIMALNYY_NAPOR_M",
								61 => "DLINA_KABELYA_M",
								62 => "OTAPLIVAEMAYA_PLOSHCHAD_KV_M",
								63 => "BUKHTA_M",
								64 => "KOMPLEKTATSIYA",
								65 => "MAKSIMALNOE_DAVLENIE_BAR",
								66 => "DY",
								67 => "FURNITURA",
								68 => "VYPUSK_UNITAZA",
								69 => "PROIZVODITELNOST_GORYACHEY_VODY_RI_T_25",
								70 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_35_L_M",
								71 => "DIAMETR_DYMOOTVODA_TRUB_KOAKS_RAZDELNYKH_MM",
								72 => "MAKS_RASKHOD_PRIRODNOGO_SZHIZHENNOGO_GAZA_M_CH_KG_",
								73 => "MAKS_PROIZVODITELNOST_KPD_",
								74 => "EMKOST_L",
								75 => "PODACHA_GAZA",
								76 => "VKHOD_KHOLODNOY_VODY_V_KOTEL",
								77 => "VOZVRAT_IZ_SISTEMY_OTOPLENIYA",
								78 => "TSIRKULYATOR",
								79 => "STEKLO_MM",
								80 => "KONSTRUKTSIYA_DVEREY",
								81 => "SIDENE",
								82 => "ELEKTRONNOE_UPRAVLENIE",
								83 => "GIDROMASSAZH_SPINY_KOL_VO_FORSUNOK",
								84 => "TROPICHESKIY_DUSH",
								85 => "VENTILYATSIYA",
								86 => "ZERKALO",
								87 => "RADIO",
								88 => "ZADNYAYA_STENKA",
								89 => "ISPOLNENIE_STEKOL",
								90 => "PODSVETKA",
								91 => "PROFIL",
								92 => "SMESITEL",
								93 => "DIAMETR_MM",
							),
							"SHOW_DISCOUNT_PERCENT" => "N",
							"SHOW_IMAGE" => "Y",
							"SHOW_NAME" => "Y",
							"SHOW_OLD_PRICE" => "N",
							"SHOW_PRICE_COUNT" => "1",
							"TEMPLATE_THEME" => "blue",
							"USE_PRODUCT_QUANTITY" => "N"
						)
					);?>
						
					</div>
					<div data-tab="collection" class="product-tabs__content tabs__content">
						<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/collection.php");	//вкладка "коллекции"?>
					</div>
				</div>
            </div>
        </div>
	</div>