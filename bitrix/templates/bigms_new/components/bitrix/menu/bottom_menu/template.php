<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<?if (!empty($arResult)):?>
<ul class="footer-nav">

<?
$i = 0;
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	
	<?if ( $i++ > 3 ):?>
		</ul>
        <ul class="footer-nav">
		<?$i = 0;?>
	<?endif;?>

	<?if($arItem["SELECTED"]):?>
		<li class="footer-nav__item"><a href="<?=$arItem["LINK"]?>" class="footer-nav__link"><?=$arItem["TEXT"]?></a></li>
	<?else:?>
		<li class="footer-nav__item"><a href="<?=$arItem["LINK"]?>" class="footer-nav__link"><?=$arItem["TEXT"]?></a></li>
	<?endif?>
	
<?endforeach?>

</ul> 
<?endif?> 