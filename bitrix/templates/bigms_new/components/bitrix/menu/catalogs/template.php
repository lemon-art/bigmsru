<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>



	<?
	$previousLevel = 0;
	foreach($arResult as $kk=>$arItem):?>

		<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
			<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
		<?endif?>

		<?if ($arItem["IS_PARENT"] ):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li data-level="<?=$arItem["DEPTH_LEVEL"]?>" class="side-nav__item side-nav__item_<?=$arItem["ICON"]?> <?if ($arItem["SELECTED"]):?>active<?endif?>">
					
					<a href="<?=$arItem["LINK"]?>" class="side-nav__link">
						<div class="side-nav__icon-wrap">
						  <span class="side-nav__icon icon_<?=$arItem["ICON"]?>"></span>
						</div>
						<span class="side-nav__name"><?=$arItem["TEXT"]?></span>
					</a>
					<ul data-level="<?=$arItem["DEPTH_LEVEL"]+1?>" class="side-nav__sublist sublist">
						<li data-level="<?=$arItem["DEPTH_LEVEL"]+1?>" class="sublist__item"><a href="<?=$arItem["LINK"]?>" class="sublist__link sublist__link_all">Все товары раздела</a></li>
				<?else:?>
				<li data-level="<?=$arItem["DEPTH_LEVEL"]?>" class="sublist__item" <?if ($arItem["SELECTED"]):?>active<?endif?>">
					<a class="sublist__link underground" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
					<ul data-level="3" class="side-nav__sublist sublist">
						
						<li data-level="3" class="sublist__item"><a href="<?=$arItem["LINK"]?>" class="sublist__link sublist__link_all">Все товары раздела</a></li>
						
			<?endif?>

		<?else:?>

			<?if ($arItem["PERMISSION"] > "D"):?>

				<?if ($arItem["DEPTH_LEVEL"] == 1):?>
					<li data-level="<?=$arItem["DEPTH_LEVEL"]?>" class="side-nav__item">
						<a href="<?=$arItem["LINK"]?>" class="side-nav__link">
							<div class="side-nav__icon-wrap">
							  <span class="side-nav__icon icon_santech"></span>
							</div>
							<span class="side-nav__name"><?=$arItem["TEXT"]?></span>
						</a>
					</li>
				<?else:?>
					<li data-level="<?=$arItem["DEPTH_LEVEL"]?>" class="sublist__item"><a class="sublist__link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
				<?endif?>

			<?else:?>

				<?if ($arItem["DEPTH_LEVEL"] == 1):?>
					<li data-level="<?=$arItem["DEPTH_LEVEL"]?>" class="side-nav__item">
						<a href="<?=$arItem["LINK"]?>" class="side-nav__link">
							<div class="side-nav__icon-wrap">
							  <span class="side-nav__icon icon_santech"></span>
							</div>
							<span class="side-nav__name"><?=$arItem["TEXT"]?></span>
						</a>
					</li>
				<?else:?>
					<li><a class="sublist__link" href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
				<?endif?>

			<?endif?>

		<?endif?>

		<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

	<?endforeach?>

	<?if ($previousLevel > 1)://close last item tags?>
		<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
	<?endif?>

