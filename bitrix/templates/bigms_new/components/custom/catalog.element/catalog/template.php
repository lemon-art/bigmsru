<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
    <div class="row">
        <div class="col-lg-30 col-md-30 col-sm-30">
            <div class="content-product">
                <div class="content-product__tabs product-tabs tabs">
					<div class="product-tabs__header-wrap">
						<ul class="product-tabs__header-list tabs__header">
							<li data-trigger="all" class="product-tabs__header-item tabs-trigger active">Всё о товаре</li>
							<li data-trigger="stats" class="product-tabs__header-item tabs-trigger">Характеристики</li>
							<?/*
							<li data-trigger="service" class="product-tabs__header-item tabs-trigger">Услуги</li>
							<li data-trigger="additional" class="product-tabs__header-item tabs-trigger">Дополнительные товары</li>
							<li data-trigger="collection" class="product-tabs__header-item tabs-trigger">Товары из одной коллекции</li>
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
										<a data-trigger="slider" data-id="<?=$arResult['ID']?>" class="popup-trigger" href="<?=$arResult['DETAIL_PICTURE']['SRC']?>"><img itemprop="image" class="content-product__picture" src="<?=$renderImage["src"]?>" alt="<? echo $imgTitle; ?>" title="<? echo $imgTitle; ?>"></a>
									<? } else {?>
										<img itemprop="image" class="content-product__picture" src="/bitrix/templates/bigms/images/logo_bw.png" alt="<? echo $imgTitle; ?>" title="<? echo $imgTitle; ?>">
										<?$renderImage["src"] = '/bitrix/templates/bigms/images/logo_bw.png';?>
									<? } ?>
									
									<div id="slider<?=$arResult['ID']?>" style="display: none;">
										<div class="owl-carousel popup-slider__container">
											<img src="/bitrix/templates/bigms/images/logo_bw.png" alt="">
 									    </div>
									</div>
								
									<input type="hidden" name="CAT_PRICE_ID<?=$arResult["ID"]?>" value="<?=$arResult["CATALOG_PRICE_ID_1"]?>"/>
									<input type="hidden" name="CAT_PRICE<?=$arResult["ID"]?>" value="<?=number_format($arResult["CATALOG_PRICE_1"],0,'.',' ')?>  ₽"/>
									<input type="hidden" name="ELEM_NAME<?=$arResult["ID"]?>" value="<?=$arResult["NAME"]?>"/>
									<input type="hidden" name="DETAIL_PAGE<?=$arResult["ID"]?>" value="<?=$arResult["DETAIL_PAGE_URL"]?>"/>
									<input type="hidden" name="PICTURE<?=$arResult["ID"]?>" value="<?=$renderImage["src"]?>"/>
								</div>
								<?/* 
								<?if( $arResult["MORE_PHOTO_COUNT"] > 1):?>
									<div id="thumbs" class="content-product__thumbs-wrap right-shadow">
									  <ul class="content-product__thumbs">
										<li data-trigger="youtube" data-src="styles/images/product-img.jpg" class="content-product__thumbnail content-product__thumbnail_video popup-trigger"><img src="styles/images/thumb_1.jpg" alt=""></li>
										<li data-trigger="slider" data-src="styles/images/thumb_2.jpg" class="content-product__thumbnail popup-trigger"><img src="styles/images/thumb_2.jpg" alt=""></li>
										<li data-trigger="slider" data-src="styles/images/thumb_3.jpg" class="content-product__thumbnail popup-trigger"><img src="styles/images/thumb_3.jpg" alt=""></li>
										<li data-trigger="slider" data-src="styles/images/thumb_5.jpg" class="content-product__thumbnail popup-trigger"><img src="styles/images/thumb_5.jpg" alt=""></li>
										<li data-trigger="slider" data-src="styles/images/thumb_1.jpg" class="content-product__thumbnail popup-trigger"><img src="styles/images/thumb_1.jpg" alt=""></li>
										<li data-trigger="slider" data-src="styles/images/thumb_2.jpg" class="content-product__thumbnail popup-trigger"><img src="styles/images/thumb_2.jpg" alt=""></li>
										<li data-trigger="slider" data-src="styles/images/thumb_3.jpg" class="content-product__thumbnail popup-trigger"><img src="styles/images/thumb_3.jpg" alt=""></li>
										<li data-trigger="slider" data-src="styles/images/thumb_5.jpg" class="content-product__thumbnail popup-trigger"><img src="styles/images/thumb_5.jpg" alt=""></li>
									  </ul>
									</div>
								<?endif;?>
								*/?>
							  </div>
							  <div class="col-lg-6 col-lg-offset-0 col-md-9 col-md-offset-1 col-sm-9 col-sm-offset-1">
								<div class="content-product__info product-info">
								  <div class="product-info__row product-info__row_end">
										<?
											$minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);
											$boolDiscountShow = (0 < $minPrice['DISCOUNT_DIFF']);
											?>

											<?if(!empty($minPrice['VALUE'])){?>
												<?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $minPrice['DISCOUNT_VALUE'] < $minPrice['VALUE']):?>
													
														<span class="product-info__price"><?echo number_format($minPrice['DISCOUNT_VALUE'],0,'.',' ');?> ₽</span>
														<span class="product-info__old-price"><?echo number_format($minPrice['VALUE'],0,'.',' ');?> ₽</span>
												<?else:?>
													<span class="product-info__price"><?echo number_format($minPrice['VALUE'],0,'.',' ');?> ₽</span>
												<?endif;?>
											<?}?>
								  

								  </div>
								  <div class="product-info__row product-info__row_icons">
									<?/*
									<div class="product-info__icon-wrap">
									  <span class="product-info__compare-icon"></span>
									</div>
									<div class="product-info__icon-wrap">
									  <span class="product-info__wish-icon active"></span>
									</div>
									*/?>
									<?if(!empty($arResult["DISPLAY_PROPERTIES"]["CML2_ARTICLE"]["VALUE"])):?>
										<span class="product-info__id">Артикул: <?=$arResult["DISPLAY_PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span>
									<?endif;?>
								  </div>
								  <div class="product-info__row">
									<div class="product-info__spinner spinner">
									  <a role="button" href="#" class="spinner__dec">–</a>
									  <input class="spinner__input" type="text" name="COUNT<?=$arResult["ID"]?>" value="1">
									  <a role="button" href="#" class="spinner__inc">+</a>
									</div>
									<div class="product-info__status">
										<?
										if($arResult['IBLOCK_SECTION_ID'] == 1405 || $arResult['IBLOCK_SECTION_ID'] == 1385 || $arResult['IBLOCK_SECTION_ID'] == 1386) { ?>
											<span class="product-card__quantity product-card__quantity_instock">В наличии</span>
											<input type="hidden" name="STATUS<?=$arResult["ID"]?>" data-class="product-card__quantity_instock" value="В наличии"/>
										<? } elseif($arResult["CATALOG_QUANTITY"] <= 0){
											?>
											<input type="hidden" name="STATUS<?=$arResult["ID"]?>" data-class="product-card__quantity_order" value="Под заказ 1-3 дня"/>
											<span class="product-card__quantity product-card__quantity_order">Под заказ 1-3 дня</span><?
										} else{
											?>
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
								  <?/*
								  <div class="product-info__row product-info__row_click active">
									<a role="button" data-trigger="click" href="#" class="product-info__buy product-info__buy_one popup-trigger">Купить в 1 клик</a>
								  </div>
								  */?>
								  <div class="product-info__row product-info__row_incart">
									<span href="#" class="button product-info__incart">Товар в корзине</span>
									<a href="" class="product-info__delete">Удалить</a>
								  </div>
								  <div class="product-info__props tech-props">
									<strong class="tech-props__title">Технические характеристики</strong>
									<table class="tech-props__table">
										<?
										$i = 0;
										foreach($arResult["DISPLAY_PROPERTIES"] as $code=>$properties){
										if($code !== "RASPRODAZHA" && $code !== "NOVINKA" && $code != "ARTICUL" && $code != "LIDER_PRODAZH" && $code != "DELIVERY" && $code != "FILES" && $code != "GARANTY" && $code != "CML2_ARTICLE" && $code != "RECOMMEND"){
												
												if($i < 6){?>
									  <tr class="tech-props__row">
										<td class="tech-props__td"><?=$properties["NAME"]?></td>
										<td class="tech-props__td">
											<?
											if(!empty($properties["DISPLAY_VALUE"])){
												//echo strip_tags($properties["DISPLAY_VALUE"], "");
												echo $properties["DISPLAY_VALUE"];
											}
											else{
												echo $properties["VALUE"];
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
									<strong class="product-about__title">60 дней на обмен</strong>
									<p class="product-about__text">Вы можете обменять или вернуть товар в течение 2 месяцев со дня покупки</p>
								  </div>
								  <div class="product-about__wrap">
									<strong class="product-about__title">12 месяцев гарантии</strong>
									<p class="product-about__text">При обнаружении дефекта мы сами обратимся в сервис-центр, обслуживающий продукцию торговой марки (бренд), и поможем решить проблему.</p>
								  </div>
								  <div class="product-about__wrap">
									<strong class="product-about__title">Способы оплаты</strong>
									<ul class="product-about__list">
									  <li class="product-about__list-item">наличные</li>
									  <li class="product-about__list-item">банковские карты</li>
									  <li class="product-about__list-item">банковский перевод</li>
									  <li class="product-about__list-item">Сбербанк Онлайн</li>
									  <li class="product-about__list-item">Альфа клик</li>
									  <li class="product-about__list-item">ВТБ24-Онлайн</li>
									</ul>
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
						<?if ( $arResult["DETAIL_TEXT"] ):?>
							<div class="row">
							  <div class="col-lg-21">
								<div class="content-product__description product-description">
								  <strong class="content-product__title product-description__title">Описание «<?=$arResult["NAME"]?>»</strong>
								  <div class="product-description__wrap">
										<p class="product-description__text"><?=$arResult["DETAIL_TEXT"]?></p>
								  </div>
								</div>
							  </div>
							</div>	
						<?endif;?>
							
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
										<?$APPLICATION->IncludeComponent("custom:catalog.section", "similar", Array(
											"COMPONENT_TEMPLATE" => ".default",
												"IBLOCK_TYPE" => "1c_catalog",
												"IBLOCK_ID" => 10,
												"SECTION_ID" => '',
												"SECTION_CODE" =>"",
												"SECTION_USER_FIELDS" => array(
													0 => "",
													1 => "",
												),
												"ELEMENT_SORT_FIELD" => "sort",
												"ELEMENT_SORT_ORDER" => "asc",
												"ELEMENT_SORT_FIELD2" => "id",
												"ELEMENT_SORT_ORDER2" => "desc",
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
										
										<?$APPLICATION->IncludeComponent("custom:catalog.section", "similar", Array(
											"COMPONENT_TEMPLATE" => ".default",
												"IBLOCK_TYPE" => "1c_catalog",
												"IBLOCK_ID" => 12,
												"SECTION_ID" => '',
												"SECTION_CODE" =>"",
												"SECTION_USER_FIELDS" => array(
													0 => "",
													1 => "",
												),
												"ELEMENT_SORT_FIELD" => "sort",
												"ELEMENT_SORT_ORDER" => "asc",
												"ELEMENT_SORT_FIELD2" => "id",
												"ELEMENT_SORT_ORDER2" => "desc",
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
					<div data-tab="stats" class="product-tabs__content tabs__content">
						<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/stats.php");	//вкладка "характеристики"?>
					</div>
					<div data-tab="service" class="product-tabs__content tabs__content">
					
					</div>
					<div data-tab="additional" class="product-tabs__content tabs__content">
					
					</div>
					<div data-tab="collection" class="product-tabs__content tabs__content">
					
					</div>
				</div>
            </div>
        </div>
	</div>