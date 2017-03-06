<?
//возвращает полный адрес строки фильтра по короткой строке
//echo "123-".$_POST["shortUrl"];
if ( $_POST["shortUrl"] ){

	//открываем файл с массивом соответствия адресов страниц
	$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt");
	$arUrlData = unserialize( $data );
	$filterUrl = array_search($_POST["shortUrl"], $arUrlData);
	
	echo $filterUrl;
}
?>