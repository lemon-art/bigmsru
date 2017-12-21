<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->IncludeLangFile('template.php');
$cartId = $arParams['cartId'];
?>

<div class="header_cart">
	<a href="/basket/" class="title">Корзина</a>
	
	<?if($arResult['NUM_PRODUCTS'] > 0):?>
		<a class="header_cart_value" href="/basket/"><?=$arResult['NUM_PRODUCTS']?> товар, <?=$arResult['TOTAL_PRICE']?></a>	
		<div class="header_cart_detail hidden">
			<?foreach($arResult["ITEM"] as $k=>$item):?>
				<div class="item <?= $item['PRODUCT_ID'] ?>">
					<div class="img"><div style="background-image: url('<?=$item["DETAIL_PICTURE"]?>')"></div></div>
					<div class="name"><a href="<?=$item["DETAIL_PAGE_URL"]?>"><?=$item["NAME"]?></a></div>
					<div class="kol" data-kol="<?=ceil($item["QUANTITY"]);?>"><?=ceil($item["QUANTITY"]);?> шт.</div>
					<div class="sum" data-sum="<?=$item["SUM"]?>"><span><?=number_format($item["SUM"],2,'.',' ');?></span> руб.</div>
					<div class="del"><span data-id="<?=$item["ID"]?>"></span></div>				
				</div>
			<?endforeach?>
			
			<div class="itogo">Итого: <div class="cumma"><?=$arResult['TOTAL_PRICE']?></div></div>
			<div class="buttons">
				<a href="/basket/" class="btn"><span>оформить заказ</span></a>
			</div>
		</div>
	<?endif?>
</div>