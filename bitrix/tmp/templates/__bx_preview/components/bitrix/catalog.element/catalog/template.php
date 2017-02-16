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
$this->setFrameMode(true);
$templateLibrary = array('popup');
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

<div itemscope itemtype="http://schema.org/Product" class="catalog_detail <? echo $templateData['TEMPLATE_CLASS']; ?>" id="<? echo $arItemIDs['ID']; ?>">

<div class="title_block">
	<h1 itemprop="name"><span itemprop="description"><?=$strTitle?></span></h1>
	
	<div class="links_block">
		<?if(!empty($arResult["DISPLAY_PROPERTIES"]["CML2_ARTICLE"]["VALUE"])){?>
			<div class="articul">Артикул: <?=$arResult["DISPLAY_PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></div>
		<?}?>
		
		<div class="vote_block">
			<?$APPLICATION->IncludeComponent(
				"bitrix:iblock.vote",
				"catalog_stars",
				array(
					"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
					"IBLOCK_ID" => $arParams['IBLOCK_ID'],
					"ELEMENT_ID" => $arResult['ID'],
					"ELEMENT_CODE" => "",
					"MAX_VOTE" => "5",
					"VOTE_NAMES" => array("1", "2", "3", "4", "5"),
					"SET_STATUS_404" => "N",
					"DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
					"CACHE_TYPE" => $arParams['CACHE_TYPE'],
					"CACHE_TIME" => $arParams['CACHE_TIME']
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?>
		</div>
	</div>
</div>
	
<div class="img" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
	<div class="vlign" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">

		<?
		$renderImage = CFile::ResizeImageGet(
			$arResult['DETAIL_PICTURE']['ID'],
			Array("width" => 370, "height" => 360),
			BX_RESIZE_IMAGE_EXACT,
			true
		);
		?>
	
		<?if($arResult["MORE_PHOTO_COUNT"] > 1){?>
			<a itemprop="image" href="#" class="click_first_photo">
				<img  id="<? echo $arItemIDs['PICT']; ?>" src="<?=$renderImage["src"]?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>" class="big" />
			</a>		
		<?}
		else{?>
			<a itemprop="image" href="<? echo $arFirstPhoto['SRC']; ?>" class="fancybox">
				<img  id="<? echo $arItemIDs['PICT']; ?>" src="<?=$renderImage["src"]?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>" class="big" />
			</a>
		<?}?>
		
		<?
		if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
		{
			if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
			{
				if (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF'])
				{
		?>
			<div class="bx_stick_disc right bottom" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>"><? echo -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%</div>
		<?
				}
			}
			else
			{
		?>
			<div class="bx_stick_disc right bottom" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>" style="display: none;"></div>
		<?
			}
		}
		if ($arResult['LABEL'])
		{
		?>
			<div class="bx_stick average left top" id="<? echo $arItemIDs['STICKER_ID'] ?>" title="<? echo $arResult['LABEL_VALUE']; ?>"><? echo $arResult['LABEL_VALUE']; ?></div>
		<?
		}

		//Уменьшаем картинку для баннера
		$renderImage = CFile::ResizeImageGet($arFirstPhoto['ID'], array('width'=>80, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
		$PICT['ID'] = $arFirstPhoto['ID'];
		$PICT['SRC'] = $renderImage['src'];
		$PICT['WIDTH'] = $renderImage['width'];
		$PICT['HEIGHT'] = $renderImage['height'];
		?>

		<div class="do_block">
			<a data-id="<?=$arResult["ID"]?>" href="javascript:void(0);" title="Добавить в избранное"  class="bx_big bx_bt_button_type_2 compare_button" id="<? echo $arItemIDs['COMPARE_LINK']; ?>" onclick="yaCounter31721621.reachGoal('add_to_compare'); return true;"><span><?=GetMessage("CT_BCE_CATALOG_COMPARE_IN"); ?></span></a>
			<a class="share_button" data-id="<?=$arResult["ID"]?>" href="javascript:void(0)" title="Добавить в сравнение"  onclick="yaCounter31721621.reachGoal('add_to_bookmarks');"><span><?=GetMessage('CT_BCS_TPL_MESS_BTN_SHARE')?></span></a>
			<!-- /*add2delay('<?=$arResult["ID"]?>','<?=$arResult["CATALOG_PRICE_ID_1"]?>','<?=$arResult["CATALOG_PRICE_1"]?>','<?=addslashes($arResult["NAME"]);?>','<?=$arResult["DETAIL_PAGE_URL"]?>');*/ -->
			<input type="hidden" name="CAT_PRICE_ID<?=$arResult["ID"]?>" value="<?=$arResult["CATALOG_PRICE_ID_1"]?>"/>
			<input type="hidden" name="CAT_PRICE<?=$arResult["ID"]?>" value="<?=$arResult["CATALOG_PRICE_1"]?>"/>
			<input type="hidden" name="DETAIL_PAGE<?=$arResult["ID"]?>" value="<?=$arResult["DETAIL_PAGE_URL"]?>"/>
			<input type="hidden" name="ELEM_NAME<?=$arResult["ID"]?>" value="<?=$arResult["NAME"]?>"/>
			<input type="hidden" name="PICTURE<?=$arResult["ID"]?>" value="<?=$renderImage["src"]?>"/>
		</div>
		
		
		<?if($arResult["MORE_PHOTO_COUNT"] > 1){?>
			<div class="more_photo">
				<?foreach($arResult["MORE_PHOTO"] as $photo){?>
					<?
					$renderImage = CFile::ResizeImageGet(
						$photo['ID'], 
						Array("width" => 105, "height" => 105), 
						BX_RESIZE_IMAGE_EXACT, 
						true
					);
					?>
				
					<a href="<?=$photo["SRC"]?>" class="fancybox" rel="gallery"><img src="<?=$renderImage["src"]?>" alt="" /></a>
				<?}?>
				<div class="clear"></div>
			</div>
		<?}?>
	</div>
	
	<div class="labels">
		<?
		if($arResult["PROPERTIES"]["RASPRODAZHA"]["VALUE"] == "Да"){
			echo '<div class="label sale">SALE</div>';
		}
		if($arResult["PROPERTIES"]["NOVINKA"]["VALUE"] == "Да"){
			echo '<div class="label new">NEW</div>';
		}
		?>
	</div>

</div>


<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="info_block">
	<div class="wrp">
		<?
		if(!empty($arResult["PROPERTIES"]["ARTICUL"]["VALUE"])){
			?><div class="artucul">Код: <?=$arResult["PROPERTIES"]["ARTICUL"]["VALUE"]?></div><?
		}
		?>

		<?
		if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
		{
			$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
		}
		else
		{
			$canBuy = $arResult['CAN_BUY'];
		}
		
		$buyBtnMessage = ($arParams['MESS_BTN_BUY'] != '' ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
		$addToBasketBtnMessage = ($arParams['MESS_BTN_ADD_TO_BASKET'] != '' ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCE_CATALOG_ADD'));
		$notAvailableMessage = ($arParams['MESS_NOT_AVAILABLE'] != '' ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
		$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
		$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
		
		if($arResult["CATALOG_QUANTITY"] <= 0){
			$addToBasketBtnMessage = GetMessage('CT_BCE_CATALOG_ZAG');
		}
		?>

		<span class="item_section_name_gray"><? echo GetMessage('CATALOG_QUANTITY'); ?>:</span>
		<div class="item_buttons vam" data-id="<?= $arResult['ID'] ?>">
			<span class="item_buttons_counter_block">
				<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb down" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>
				<input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" class="tac transparent_input" value="<? echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
						? 1
						: $arResult['CATALOG_MEASURE_RATIO']
					); ?>">
				<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb up" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
			</span>
			
			<div class="item_price">
				<?
				$minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);
				$boolDiscountShow = (0 < $minPrice['DISCOUNT_DIFF']);
				?>
				
				<?if(!empty($minPrice['VALUE'])){?>
					<div itemprop="price" content="<?echo number_format($minPrice['VALUE'],0,'.','');?>" class="item_current_price" id="<? echo $arItemIDs['PRICE']; ?>"><?echo number_format($minPrice['VALUE'],2,'.',' ');?> <span itemprop="priceCurrency" content="RUB"> руб.</span></div>
				<?}?>
			</div>
			
			<div class="availability_block">
				<?
                if($arResult['IBLOCK_SECTION_ID'] == 1405 || $arResult['IBLOCK_SECTION_ID'] == 1385 || $arResult['IBLOCK_SECTION_ID'] == 1386) { ?>
                    <div class="availability">Есть в наличии</div>
                <? } elseif($arResult["CATALOG_QUANTITY"] <= 0){
					?><div class="availability no">Заказ 1-3 дня</div><?
				} else{
					?><div class="availability">Есть в наличии</div><?
				}
				?>
			</div>
			
			<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
			
			<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
			<?
				if ($showAddBtn)
				{
					// yaCounter31721621.reachGoal('basket');
				?>
					<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart buy_button" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>" onclick="yaCounter31721621.reachGoal('basket'); return true;"><span></span><? echo $addToBasketBtnMessage; ?></a>
				<?
				}
				?>
				
				<div class="byclick">
					<a href="#" data-id="<?=$arResult["ID"]?>" data-iblock="<?=$arParams["IBLOCK_ID"]?>" class="buy_one_button" onclick="yaCounter31721621.reachGoal('catalog-oneclickbuy-button'); return true;">купить в 1 клик</a>
				</div>
			</span>
		</div>
		<?
		unset($showAddBtn, $showBuyBtn);
		?>
		
		<div>
			<ul class="tabNavigation" style="width: 200px;">
				<?if($arResult["CATALOG_QUANTITY"] > 0 && $arParams["IBLOCK_ID"] == 12){?>
					<li class="link1">
						<span class="lign"></span>
						<div class="lign"><a class="" href="#tab_content1">Возможна доставка <br />в день заказа</a></div>
					</li>
				<?}
				else if ($arParams["IBLOCK_ID"] == 10){?>
					<li class="link1"><span></span>
						<a class="" href="#tab_content1">Доставка от 500 руб.</a>
					</li>
				<?}?>
				<li class="link2"><span></span><a class="" href="#tab_content2">Самовывоз (фото магазина)<!-- <?if($arParams["IBLOCK_ID"] == 12){echo '1 магазин';}else{echo '4 магазина';}?> --></a></li>
				<li class="link3"><span></span><a class="" href="#tab_content3">Гарантия качества</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="properties_block">
	<div class="title"><span>технические характеристики</span></div>
	<table class="text">
		<?
		$i = 0;
		foreach($arResult["DISPLAY_PROPERTIES"] as $code=>$properties){
		if($code !== "RASPRODAZHA" && $code !== "NOVINKA" && $code != "ARTICUL" && $code != "LIDER_PRODAZH" && $code != "DELIVERY" && $code != "FILES" && $code != "GARANTY" && $code != "CML2_ARTICLE" && $code != "RECOMMEND"){
				
				if($i < 6){
					?>
					<tr>
						<td><?=$properties["NAME"]?></td>
						<td>
							<?
							if(!empty($properties["DISPLAY_VALUE"])){
								echo strip_tags($properties["DISPLAY_VALUE"], "");
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
</div>

<div class="clear"></div>


<div class="tabs_block">
	<div class="title_block">
		<ul class="tabNavigation">
			<li><a class="" href="#tab_content1"><h3>технические характеристики</h3></a></li>
			<li><a class="" href="#tab_content2"><h3>отзывы</h3></a></li>
			<noindex><li><a class="" href="#tab_content3"><h3>магазины</h3></a></li>
			<li><a class="" href="#tab_content4"><h3>доставка</h3></a></li>
			<li><a class="" href="#tab_content5"><h3>Гарантия и сервис</h3></a></li></noindex>
		</ul>
	</div>
	
	<div class="properties tab_content properties_block" id="tab_content1">
		<table class="text">
			<?
			foreach($arResult["DISPLAY_PROPERTIES"] as $code=>$properties){
				/*global $USER;
				if ($USER->IsAdmin()){
					echo("<pre>");
					print_r($code);
					echo("</pre>");
				}*/
				if($code !== "RASPRODAZHA" && $code !== "NOVINKA" && $code != "ARTICUL" && $code != "LIDER_PRODAZH" && $code != "DELIVERY" && $code != "FILES" && $code != "GARANTY" && $code != "CML2_ARTICLE" && $code != "RECOMMEND"){
					?>
					<tr>
						<td><?=$properties["NAME"]?></td>
						<td>
							<?
							if(!empty($properties["DISPLAY_VALUE"])){
								echo strip_tags($properties["DISPLAY_VALUE"], "");
							}
							else{
								echo $properties["VALUE"];
							}
							?>
						</td>
					</tr>
					<?
				}
			}
			?>
		</table>
		<div class="file_block">
			<?
			if(!empty($arResult["PROPERTIES"]["FILES"]["VALUE"])){
				foreach($arResult["PROPERTIES"]["FILES"]["VALUE"] as $id_file){
					$arFile = CFile::GetFileArray($id_file);
					if(!empty($arFile["DESCRIPTION"])){
						echo '<a href="'.$arFile["SRC"].'">'.$arFile["DESCRIPTION"].'</a>';
					}
					else{
						echo '<a href="'.$arFile["SRC"].'">'.$arFile["FILE_NAME"].'</a>';
					}
				}
			}
			?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="properties tab_content comments" id="tab_content2">
		<div class="bx_lb">
			<div class="tac ovh"></div>
			<div class="tab-section-container">
				<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.comments",
					"catalog",
					array(
						"ELEMENT_ID" => $arResult['ID'],
						"ELEMENT_CODE" => "",
						"IBLOCK_ID" => $arParams['IBLOCK_ID'],
						"SHOW_DEACTIVATED" => $arParams['SHOW_DEACTIVATED'],
						"URL_TO_COMMENT" => "",
						"WIDTH" => "",
						"COMMENTS_COUNT" => "5",
						"BLOG_USE" => $arParams['BLOG_USE'],
						"FB_USE" => $arParams['FB_USE'],
						"FB_APP_ID" => $arParams['FB_APP_ID'],
						"VK_USE" => $arParams['VK_USE'],
						"VK_API_ID" => $arParams['VK_API_ID'],
						"CACHE_TYPE" => $arParams['CACHE_TYPE'],
						"CACHE_TIME" => $arParams['CACHE_TIME'],
						'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
						"BLOG_TITLE" => "",
						"BLOG_URL" => $arParams['BLOG_URL'],
						"PATH_TO_SMILE" => "",
						"EMAIL_NOTIFY" => $arParams['BLOG_EMAIL_NOTIFY'],
						"AJAX_POST" => "Y",
						"SHOW_SPAM" => "Y",
						"SHOW_RATING" => "Y",
						"RATING_TYPE" => "standart_text",
						"FB_TITLE" => "",
						"FB_USER_ADMIN_ID" => "",
						"FB_COLORSCHEME" => "light",
						"FB_ORDER_BY" => "reverse_time",
						"VK_TITLE" => "",
						"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME']
					),
					$component,
					array("HIDE_ICONS" => "Y")
				);?>
			</div>
		</div>
	</div>
	<noindex><div class="properties tab_content shops" id="tab_content3">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list", 
			"shops", 
			array(
				"COMPONENT_TEMPLATE" => "shops",
				"IBLOCK_TYPE" => "content",
				"IBLOCK_ID" => "5",
				"NEWS_COUNT" => "20",
				"SORT_BY1" => "SORT",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "ID",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "",
				"FIELD_CODE" => array(
					0 => "",
					1 => "",
				),
				"PROPERTY_CODE" => array(
					0 => "ADRESS",
					1 => "PHONE",
					2 => "VIDEO",
					3 => "MAP",
					4 => "MORE_PHOTO",
				),
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_STATUS_404" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"PARENT_SECTION" => $arResult["SECTION_SHOP"],
				"PARENT_SECTION_CODE" => "",
				"INCLUDE_SUBSECTIONS" => "Y",
				"DISPLAY_DATE" => "N",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "N",
				"DISPLAY_PREVIEW_TEXT" => "N",
				"PAGER_TEMPLATE" => "bigms",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "Новости",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N"
			),
			false
		);?>
	</div>
	<div class="properties tab_content delivery" id="tab_content4">
		<noindex>
		<?=$arResult["DISPLAY_PROPERTIES"]["DELIVERY"]["DISPLAY_VALUE"]?>
		</noindex>
	</div>
	<div class="properties tab_content garanty" id="tab_content5">
		<?=$arResult["DISPLAY_PROPERTIES"]["GARANTY"]["DISPLAY_VALUE"]?>
	</div></noindex>
</div>


<?
unset($minPrice);
?>

			
		

		<div class="bx_md">
			<div class="item_info_section">
			<?
			if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
			{
				if ($arResult['OFFER_GROUP'])
				{
					foreach ($arResult['OFFER_GROUP_VALUES'] as $offerID)
					{
			?>
				<span id="<? echo $arItemIDs['OFFER_GROUP'].$offerID; ?>" style="display: none;">
			<?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
				".default",
				array(
					"IBLOCK_ID" => $arResult["OFFERS_IBLOCK"],
					"ELEMENT_ID" => $offerID,
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME'],
					"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
					"CURRENCY_ID" => $arParams["CURRENCY_ID"]
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?><?
			?>
				</span>
			<?
					}
				}
			}
			else
			{
				if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP'])
				{
			?><?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
				".default",
				array(
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_ID" => $arResult["ID"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME'],
					"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
					"CURRENCY_ID" => $arParams["CURRENCY_ID"]
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?><?
				}
			}
			?>
			</div>
		</div>
		

	<div class="clear"></div>
</div><?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
			$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd>';
				}
			}
		}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
	{
?>
<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
		{
			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
			{
?>
	<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
<?
				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
					unset($arResult['PRODUCT_PROPERTIES'][$propID]);
			}
		}
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if (!$emptyProductProperties)
		{
?>
	<table>
<?
			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
			{
?>
	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
	<td>
<?
				if(
					'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
					&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
				)
				{
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
					}
				}
				else
				{
					?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
					}
					?></select><?
				}
?>
	</td></tr>
<?
			}
?>
	</table>
<?
		}
?>
</div>
<?
	}
	if ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['VALUE'])
	{
		$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
		$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
	}
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $PICT, //$arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'BASIS_PRICE' => $arResult['MIN_BASIS_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y'),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
	unset($emptyProductProperties);
	$arJSParams['IBLOCK_ID'] = $arResult['IBLOCK_ID'];
}
?>


<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	ECONOMY_INFO_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO'); ?>',
	BASIS_PRICE_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_BASIS_PRICE') ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE'); ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>