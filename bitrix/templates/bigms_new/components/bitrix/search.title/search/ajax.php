<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (empty($arResult["CATEGORIES"]))
	return;
?>
<div class="bx_searche ">
<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
	<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
		<?//echo $arCategory["TITLE"]?>
		<?if($category_id === "all"):?>
			<a href="<?echo $arItem["URL"]?>" class="search-dropdown__item search-dropdown__item_result">Все результаты</a>
		<?elseif(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
			$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];?>
							
			<div class="bx_item_block search-dropdown__item">
				
				<div class="search-dropdown__preview">	
					<?if (is_array($arElement["PICTURE"])):?>
						<img src="<?=$arElement["PICTURE"]["SRC"]?>" alt="" class="search-dropdown__img">
					<?endif;?>
				</div>
				<a href="<?echo $arItem["URL"]?>" class="search-dropdown__name"><?echo $arItem["NAME"]?></a>
                	<?
					foreach($arElement["PRICES"] as $code=>$arPrice)
					{
						if ($arPrice["MIN_PRICE"] != "Y")
							continue;

						if($arPrice["CAN_ACCESS"])
						{
							if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
								<span class="search-dropdown__price"><span class="search-dropdown__price-value"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span> </span>
							<?else:?>
								<span class="search-dropdown__price"><span class="search-dropdown__price-value"><?=$arPrice["PRINT_VALUE"]?></span> </span>
							<?endif;
						}
						if ($arPrice["MIN_PRICE"] == "Y")
							break;
					}
					?>
				
			</div>
		<?else:?>
			
		<?endif;?>
	<?endforeach;?>
<?endforeach;?>
</div>