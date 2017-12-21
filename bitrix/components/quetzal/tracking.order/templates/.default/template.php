<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

	if($arResult['ORDER_ID']){
		$transactionIdVal = $arResult['ORDER_ID'];
		print "
			<script type='text/javascript'>
				rrApiOnReady.push(function() {
					try {
						rrApi.order({
							transaction: $transactionIdVal,
							items: [
		";
		$i=0; while ($arResult['ITEMS'][$i]){
			$productIdVal = $arResult['ITEMS'][$i]['PROD_ID'];
			$qntIdVal = $arResult['ITEMS'][$i]['QNT'];
			$priceIdVal = $arResult['ITEMS'][$i]['PRICE'];
			print "{ id: $productIdVal, qnt: $qntIdVal,  price: $priceIdVal},";
			$i++;
		}
		print "
							]
						});
					} catch(e) {}
				})
			</script>
		";
	}
?>
