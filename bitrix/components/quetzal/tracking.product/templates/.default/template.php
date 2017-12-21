<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

$productIdVal = $arResult['CARD_PRODUCT_PARAM'];
print "
	<script type='text/javascript'>
		rrApiOnReady.push(function () {
			try { rrApi.view($productIdVal); } catch (e) {}
		})
	</script>
";
?>
