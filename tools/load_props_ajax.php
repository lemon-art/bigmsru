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
			$articul = explode(": ",  $arItem[3]);
			
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
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), Array("ID"));
			while($ar_fields = $res->GetNext()){
				$arResult[] = Array (
					"PRODUCT_ID" => $ar_fields["ID"],
					"DATA" => $arItem
				);

			}
			
			
		}
		
					//сохраняем во временный файл совпадения
					$fd = fopen($_SERVER["DOCUMENT_ROOT"]."/tools/temp/result.txt", 'w') or die("не удалось создать файл");
					fwrite($fd, serialize( $arResult ) );
					fclose($fd);
		
?>


Обработано элементов: <?=$count?><br>
<?if ( count($arResult[0]) > 0 ):?>
	Найдено совпадений: <?=count($arResult)?><br>
	<a href="#" id="product_list">Показать найденные товары:</a>
	<div class="product_list" >
		<?
		//считываем временный файл совпадений
		$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/temp/result.txt");
		$arResult = unserialize( $data );
		?>
		<table>
			<tr>
				
				<td>Название</td>
				<td>Артикул</td>
			</tr>
			<?foreach ( $arResult as $key => $arItem):?>
				<tr>
					
					<td><?=$arItem["DATA"]["1"]?></td>
					<td><?=$arItem["DATA"]["3"]?></td>
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