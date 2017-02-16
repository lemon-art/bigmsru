<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<ul class="pop_menu">

	<?
	$previousLevel = 0;
	foreach($arResult as $kk=>$arItem):?>

		<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
			<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
		<?endif?>

		<?if ($arItem["IS_PARENT"]):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li class="parent depth<?=$arItem["DEPTH_LEVEL"]?> <?if ($arItem["SELECTED"]):?>active<?endif?>">
					<span></span>
					<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
					<ul>
			<?else:?>
				<li class="parent depth<?=$arItem["DEPTH_LEVEL"]?> <?if ($arItem["SELECTED"]):?>active<?endif?>">
					<span></span>
					<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
					<ul>
			<?endif?>

		<?else:?>

			<?if ($arItem["PERMISSION"] > "D"):?>

				<?if ($arItem["DEPTH_LEVEL"] == 1):?>
					<li class="<?if ($arItem["SELECTED"]):?>active<?else:?>root-item<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
				<?else:?>
					<li class="depth<?=$arItem["DEPTH_LEVEL"]?> <?if ($arItem["SELECTED"]):?>active<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
				<?endif?>

			<?else:?>

				<?if ($arItem["DEPTH_LEVEL"] == 1):?>
					<li class="<?if ($arItem["SELECTED"]):?>active<?else:?>root-item<?endif?>"><a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
				<?else:?>
					<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
				<?endif?>

			<?endif?>

		<?endif?>

		<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

	<?endforeach?>

	<?if ($previousLevel > 1)://close last item tags?>
		<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
	<?endif?>

<ul>