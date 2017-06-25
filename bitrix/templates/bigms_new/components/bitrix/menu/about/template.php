<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<?if (!empty($arResult)):?>
<ul class="about-nav__list">

<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<li class="about-nav__item"><a href="<?=$arItem["LINK"]?>" class="about-nav__link active"><?=$arItem["TEXT"]?></a></li>
	<?else:?>
		<li class="about-nav__item"><a href="<?=$arItem["LINK"]?>" class="about-nav__link"><?=$arItem["TEXT"]?></a></li>
	<?endif?>
	
<?endforeach?>

</ul>
<?endif?>