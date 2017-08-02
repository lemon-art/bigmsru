<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");

		
		//считываем файл с массивом коллекций
		$colFile = $_SERVER["DOCUMENT_ROOT"]."/tools/files/collections.txt"; 
		$data = file_get_contents( $colFile );
		$arResult = unserialize( $data );

		
		//обрабатываем данные из формы
		parse_str($_POST["data"]);
		$arProp = Array();
		foreach ($prop as $key=>$val){
			$arProp[] = $key;
		}
		
		if ( !$COLLECTION_ID ){ //если не задана коллекция значит новая 
			$COLLECTION_ID = count($arResult) + 1;
		}  

		$newCol = Array(
			"NAME" => $NAME,
			"IBLOCK_ID" => $IBLOCK_ID,
			"SECTION_ID" => $SECTION_ID,
			"PROPS" => $arProp
		);
		
		$arResult[$COLLECTION_ID] = $newCol;
		
		//сохраняем файл коллекций
		$fd = fopen($colFile, 'w') or die("не удалось создать файл");
		fwrite($fd, serialize( $arResult ) );
		fclose($fd);

?>

<pre>

<?print_r( $arResult );?>

</pre>