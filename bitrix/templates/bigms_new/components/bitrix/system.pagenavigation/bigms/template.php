<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$arResult["NavQueryString"] = str_replace('&amp;is_ajax=y', '', $arResult["NavQueryString"]);
$arResult["NavQueryString"] = str_replace('is_ajax=y', '', $arResult["NavQueryString"]);
$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
//$navQuery = explode( '&', $arResult["NavQueryString"]);


?>

    <div class="content-products__pagination pagination">
        <div class="pagination__wrap">
			<ul class="pagination__list">
<?if($arResult["bDescPageNumbering"] === true):?>

	<?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<?if($arResult["bSavePage"]):?>
			<li class="pagination__item bx-pag-prev"><a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
			<li class="pagination__item"><a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span>1</span></a></li>
		<?else:?>
			<li class=""><a class="pagination__link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span>1</span></a></li>
		<?endif?>
	<?else:?>
			<li class="pagination__item bx-active"><span>1</span></li>
	<?endif?>

	<?
	$arResult["nStartPage"]--;
	while($arResult["nStartPage"] >= $arResult["nEndPage"]+1):
	?>
		<?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<li class="pagination__item bx-active"><span><?=$NavRecordGroupPrint?></span></li>
		<?else:?>
			<li class=""><a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><span><?=$NavRecordGroupPrint?></span></a></li>
		<?endif?>

		<?$arResult["nStartPage"]--?>
	<?endwhile?>

	<?if ($arResult["NavPageNomer"] > 1):?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class=""><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><span><?=$arResult["NavPageCount"]?></span></a></li>
		<?endif?>
			<li class="bx-pag-next"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><span><?echo GetMessage("round_nav_forward")?></span></a></li>
	<?else:?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class="bx-active"><span><?=$arResult["NavPageCount"]?></span></li>
		<?endif?>
			<li class="bx-pag-next"><span><?echo GetMessage("round_nav_forward")?></span></li>
	<?endif?>

<?else:?>

	<?if ($arResult["NavPageNomer"] > 1):?>
		<?if($arResult["bSavePage"]):?>
			<li class="pagination__item"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><span>1</span></a></li>
		<?else:?>
			<li class="pagination__item"><a class="pagination__link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span>1</span></a></li>
		<?endif?>
	<?else:?>
			<li class="pagination__item"><a class="pagination__link active" href="<?=$arResult["sUrlPath"]?>">1</a></li>
	<?endif?>

	<?
	
	$arResult["nStartPage"]++;
	while($arResult["nStartPage"] <= $arResult["nEndPage"]-1):
	?>
		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<li class="pagination__item"><a class="pagination__link active" href=""><?=$arResult["nStartPage"]?></a></li>
		<?else:?>
			<?if ( $arResult["nStartPage"] == $arResult["nEndPage"]-1 && ($arResult["nStartPage"] < $arResult["NavPageCount"] - 1) ):?>
				<li class="pagination__item"><a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><img src="/images/nav-right.png"></a></li>
			<?elseif ( ($arResult["nStartPage"] > 3) && ($arResult["nStartPage"] == $arResult["nEndPage"]-3)):?>
				<li class="pagination__item"><a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><img src="/images/nav-left.png"></a></li>
			<?else:?>
				<li class="pagination__item"><a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a></li>
			<?endif;?>
		<?endif?>
		<?$arResult["nStartPage"]++?>
	<?endwhile?>

	<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class="pagination__item"><a class="pagination__link 1" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><span><?=$arResult["NavPageCount"]?></span></a></li>
		<?endif?>
		<?else:?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class="pagination__item"><a class="pagination__link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a></li>
		<?endif?>
			<li class="pagination__item"><span><?echo GetMessage("round_nav_forward")?></span></li>
	<?endif?>
<?endif?>
</div>
					<div class="pagination__wrap">
						<?if ( $arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
							<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageNomer"]+1?>" class="pagination__more">Показать еще 18 товаров</a>
						<?endif;?>
					</div>
					<?if ($arResult["bShowAll"]):?>
						<div class="pagination__wrap">
							<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1" class="pagination__all">Показать все</a>
						</div>
					<?endif;?>
					


	</div>
			<div class="preloader"><img src="/images/762.gif"></div>

