<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/urlrewrite.php");
CModule::IncludeModule("iblock");


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

?>

<pre>
<?print_r( 	print_r( $arUrlRewrite) );?>
</pre>