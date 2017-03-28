<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}
	$sectionIdVal = $arResult['CATEGORY_PAGE_PARAM'];
	print "
		<script type='text/javascript'>
			rrApiOnReady.push(function() {
				try { rrApi.categoryView($sectionIdVal); } catch(e) {}
			})
		</script>
	";
?>
