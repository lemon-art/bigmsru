<?php
//файл для загрузки свойств

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
parse_str($_POST["data"]);

		//считываем временный файл совпадений
		$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/temp/result.txt");
		$arResult = unserialize( $data );
		$arPropNotUse = Array();
		//echo "<pre>";
		//print_r( $arResult );
		//echo "</pre>"; 
		
		if ( count ($arResult) > 0 ){
		
			echo "<h2>Заполнены следующие свойства:</h2>";
			
			//определяем все свойства которые будут участвовать в процессе заполнения
			$arProps = Array();				//массив соотвествия свойств инфоблока и данных из файла csv
			$arEnumValues = Array(); 		//массив вариантов значений свойств типа "список"
			foreach( $arResult[0]['DATA'] as $key => $arProp){
				if ( $key > 3 ) {
					$prop = explode(": ",  $arProp);
				
					$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID, "NAME" => $prop[0]));
					if ($prop_fields = $properties->GetNext()){
						$arProps[$key] = $prop_fields["ID"];
						
						echo $prop[0]."<br>";
						
						//обрабатываем свойства у которых тип "список"
						if ( $prop_fields["PROPERTY_TYPE"] == 'L' ){
							
							$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ID, "CODE"=>$prop_fields["CODE"]));
							while($enum_fields = $property_enums->GetNext()){
								$arEnumValues[$prop_fields["ID"]][$enum_fields["ID"]] = $enum_fields["VALUE"];
							}
						}
					}
					else {
						$arPropNotUse[] = $prop[0];
					}
				}
				

			}
			
			echo "<br><h2>Не найдены свойства:</h2><br>";
			foreach( $arPropNotUse as $prop){
				echo $prop."<br>";
			}
			
		//echo "<pre>";
		//print_r( $arProps );
		//echo "</pre>";
			
			
			
			
			foreach( $arResult as $arItem){
				$arData = Array();
				foreach( $arItem['DATA'] as $keyData => $valData){
					if ( $keyData > 3 ) {
						$prop = explode(": ",  $valData);
						$arData[$keyData] = $prop[1];
					}
				}
			
				$arSetProps = Array();
				foreach ( $arProps as $key => $prop ){
					if ( is_array( $arEnumValues[$arProps[$key]] )){ 				
						if ( $value = array_search($arData[$key], $arEnumValues[$arProps[$key]] )){ 	//если свойство типа список

						}
						else {		//если нет такого варианта то добавляем его
							$ibpenum = new CIBlockPropertyEnum;
							if($PropID = $ibpenum->Add(Array('PROPERTY_ID'=>$arProps[$key], 'VALUE'=>$arData[$key])))
								$value = $PropID;
						}
						
					}
					else {

						$value = $arData[$key];
					}
					$arSetProps[$prop] = $value;
				}
				
				//echo "<pre>";
				//print_r( $arSetProps );
				//echo "</pre>";
				
				//обновление элемента
				//$el = new CIBlockElement;
				//$arLoadProductArray = Array(
				//  "PROPERTY_VALUES"=> $arSetProps,
				//  );
				
				CIBlockElement::SetPropertyValuesEx($arItem["PRODUCT_ID"], false, $arSetProps);
				
				
				//$PRODUCT_ID = $arItem["PRODUCT_ID"]; 
				//echo $PRODUCT_ID;
				//$res = $el->Update($PRODUCT_ID, $arLoadProductArray);
			}
			
		}
		else{
			$error = "Не найдено совпадений";
		}
		
		

?>