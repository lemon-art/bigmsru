<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->createFrame()->begin("");?>

<?
$cartStyle = 'bx_cart_block';
$cartId = $cartStyle.$component->getNextNumber();
$arParams['cartId'] = $cartId;

if ($arParams['SHOW_PRODUCTS'] == 'Y')
	$cartStyle .= ' bx_cart_sidebar';

if ($arParams['POSITION_FIXED'] == 'Y')
{
	$cartStyle .= " bx_cart_fixed {$arParams['POSITION_HORIZONTAL']} {$arParams['POSITION_VERTICAL']}";
	if ($arParams['SHOW_PRODUCTS'] == 'Y')
		$cartStyle .= ' close';
}
?>

<?/*
<script>
	var <?=$cartId?> = new BitrixSmallCart;
</script>
*/?>
				
                <li data-url="/catalog/wishlist/" class="status-bar__item status-bar__item_wish <?if( !empty($arResult['FAVORITES'])):?>status-bar_cursor status-bar__item_active<?endif;?>">
					<?if( !empty($arResult['FAVORITES'])):?>
						<a href="/catalog/wishlist/" rel="nofollow">
					<?endif;?>
						<span class="status-bar__number"><?=count( $arResult["FAVORITES"] )?></span>
						<div class="status-bar__dropdown status-dropdown"></div>
					<?if( !empty($arResult['FAVORITES'])):?>
						</a>
					<?endif;?>	
                </li>
				<?/*
                <li class="status-bar__item status-bar__item_compare">
                  <span class="status-bar__number">0</span>
                  <div class="status-bar__dropdown status-dropdown"></div>
                </li>
				*/?>
                <li class="status-bar__item status-bar__item_cart <?if($arResult['NUM_PRODUCTS'] > 0):?>status-bar__item_active<?endif;?>">
					<span class="status-bar__number" id="top_basket_number"><?=$arResult['NUM_PRODUCTS']?></span>
					<?if($arResult['NUM_PRODUCTS'] > 0):?>
					  <div class="status-bar__dropdown status-dropdown">
						<p class="status-dropdown__goods" id="top_basket_number_text"><span class="status-dropdown__number"><?=$arResult['NUM_PRODUCTS']?></span> <?=numberof($arResult['NUM_PRODUCTS'], 'товар', array('', 'а', 'ов'))?></p>
						<p class="status-dropdown__sum" id="top_basket_summ">на сумму <span class="status-dropdown__price"><?=$arResult["ALL_SUMM"]?></span> &#8381</p>
						<a href="/personal/order/make/" rel="nofollow" class="button status-dropdown__button">ОФОРМИТЬ ЗАКАЗ</a>
						<a href="/basket/" rel="nofollow" class="button status-dropdown__button">Перейти в корзину</a>
					  </div>
					<?endif;?>
                </li>

