<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/urlrewrite.php");
use Bitrix\Main,    
    Bitrix\Main\Localization\Loc as Loc,    
    Bitrix\Main\Loader,    
    Bitrix\Main\Config\Option,    
    Bitrix\Sale\Delivery,    
    Bitrix\Sale\PaySystem,    
    Bitrix\Sale,    
    Bitrix\Sale\Order,    
    Bitrix\Sale\DiscountCouponsManager,    
    Bitrix\Main\Context;
    
if (!Loader::IncludeModule('sale'))
    die();

Loader::IncludeModule('intaro.retailcrm');

$ORDER_ID = 2009;


RCrmActions::orderAgent();



// RetailCrmHistory::customerHistory();
//      RetailCrmHistory::orderHistory();
echo '444';

/*
	//открываем файл с массивом соответствия адресов страниц
	$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt");
	$arUrlData = unserialize( $data );
	$arUrlRewriteNew = Array();
	
	foreach ( $arUrlData as $long => $short){
		

		$arUrlRewriteNew = Array(
			"CONDITION" => "#^".$short."#",
			"PATH" => GetFilterUrl($long)
		);
		
		array_unshift($arUrlRewrite, $arUrlRewriteNew);
	}
	
	file_put_contents($_SERVER["DOCUMENT_ROOT"]."/urlrewrite.php", "<?$"."arUrlRewrite = ".var_export($arUrlRewrite,true).";?>");
*/
?>

<pre>
<?//print_r( 	print_r( $arUrlRewrite) );?>
</pre>