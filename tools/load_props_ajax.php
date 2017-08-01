<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");

parse_str($_POST["n"]);
parse_str($_POST["data"]);




		
		//$n = 0;
		//считываем временный файл совпадений
		$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/temp/result.txt");
		$arResult = unserialize( $data );
		
		//считываем текуший файл для обработки
		$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/temp/csv_".$n.".txt");
		$arData = unserialize( $data );
		
		$count = $n*100+count( $arData );
		
		foreach ( $arData as $arItem ){
		
			//получаем артикул
			$articul = explode(":",  $arItem[3]);
			$seach = true;
			if ( $arItem["1"] ) {
				if ( $articul[1] ) {			//если есть артикул
				
					if ( $search_type == 2 ){			//искать только по артикулу
						$arFilter = array(
							"IBLOCK_ID"  => $IBLOCK_ID,
							"SECTION_ID" => $SECTION_ID,
							"INCLUDE_SUBSECTIONS" => "Y",
							"PROPERTY_CML2_ARTICLE" => $articul[1]
						);
					}
					elseif ( $search_type == 0 ) {							//искать по артикулу и части названия
						$arFilter = array(
							"IBLOCK_ID"  => $IBLOCK_ID,
							"SECTION_ID" => $SECTION_ID,
							"INCLUDE_SUBSECTIONS" => "Y",
							array(
								"LOGIC" => "OR",
								array( "%NAME" => $arItem["1"] ),
								array("PROPERTY_CML2_ARTICLE" => $articul[1]),
							),
						);
					}
					else {
						$arFilter = array(
							"IBLOCK_ID"  => $IBLOCK_ID,
							"SECTION_ID" => $SECTION_ID,
							"INCLUDE_SUBSECTIONS" => "Y",
							array(
								"LOGIC" => "OR",
								array( "NAME" => $arItem["1"] ),
								array("PROPERTY_CML2_ARTICLE" => $articul[1]),
							),
						);
					}
				}
				else {
					if ( $search_type == 2 ){
						$seach = false;		//пропускаем елемент
					}
					elseif ( $search_type == 0 ) {					//поскольку артикула нет ищем только по имени
						$arFilter = array(
							"IBLOCK_ID"  => $IBLOCK_ID,
							"SECTION_ID" => $SECTION_ID,
							"INCLUDE_SUBSECTIONS" => "Y",
							"%NAME" => $arItem["1"]
						);
					}
					else {
						$arFilter = array(
							"IBLOCK_ID"  => $IBLOCK_ID,
							"SECTION_ID" => $SECTION_ID,
							"INCLUDE_SUBSECTIONS" => "Y",
							"NAME" => $arItem["1"]
						);
					}
				}
				
				if ( $seach ){
					$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), Array("ID", "NAME", "PROPERTY_CML2_ARTICLE"));
					while($ar_fields = $res->GetNext()){
						$arResult[] = Array (
							"PRODUCT_ID" => $ar_fields["ID"],
							"DATA" => $arItem,
							"ELEMENT" => $ar_fields
						);

					}
				}
			}
			
			
		}
		
					//сохраняем во временный файл совпадения
					$fd = fopen($_SERVER["DOCUMENT_ROOT"]."/tools/temp/result.txt", 'w') or die("не удалось создать файл");
					fwrite($fd, serialize( $arResult ) );
					fclose($fd);
		
?>


Обработано строк: <?=$count?><br>
<?if ( count($arResult[0]) > 0 ):?>
	Найдено совпадений: <?=count($arResult)?><br>
	<a href="#" id="product_list">Показать найденные товары:</a>
	<div class="product_list" >
		<?
		//считываем временный файл совпадений
		$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/temp/result.txt");
		$arResult = unserialize( $data );
		?>
		
		
		<h3>Найденные товары</h3>
		<p>Верхняя строка: название и артикул в файле</p>
		<p><b>Нижняя строка</b>: название и артикул на сайте</p>
		<table>
			<tr>
				
				<td>Название</td>
				<td>Артикул</td>
			</tr>
			<?foreach ( $arResult as $key => $arItem):?>
				<tr>
					
					<td>
						<?=$arItem["DATA"]["1"]?><br>
						<b><?=$arItem["ELEMENT"]["NAME"]?></b>
					</td>
					<td>
						<?=$arItem["DATA"]["3"]?><br>
						<b><?=$arItem["ELEMENT"]["PROPERTY_CML2_ARTICLE_VALUE"]?></b>
					</td>
				</tr>
			<?endforeach;?>
		</table>
	</div>
	
	<script> 
		$('#product_list').click( function() {
		
			$('.product_list').toggle();	
			return false;
		});
	</script>
<?else:?>	
	Совпадений не найдено
<?endif;?>
