<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

	

<?if (!empty($arResult['ITEMS'])):?>

	<?global $countDopElements;?>
	<?$countDopElements = count( $arResult['ITEMS'] );?>

	<li data-trigger="additional" class="product-tabs__header-item tabs-trigger">Дополнительные товары (<?=count( $arResult['ITEMS'] );?>)</li>
							

<?endif;?>