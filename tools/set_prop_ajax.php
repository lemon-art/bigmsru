<?php
//файл для загрузки свойств

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/tools/color.php");
CModule::IncludeModule("highloadblock");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
$hlblock_id = 2;
///////////////////////////////////////////////


$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch(); 
$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$entity_data_class = $entity->getDataClass();
$entity_table_name = $hlblock['TABLE_NAME'];

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
		
			
			
			/*
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
			*/
			
			//echo "<pre>";
			//print_r( $arProps );
			//echo "</pre>";
			
			
			$arPropPlus = Array();
			$arPropMinus = Array();
			
			foreach( $arResult as $arItem){ 						//перебираем массив с совпадениями
				$arData = Array();
				$arPropName = Array();
				$arSetProps = Array();
				foreach( $arItem['DATA'] as $keyData => $valData){ 	//перебираем свойства
					if ( $keyData > 3 ) { 							//первые 2 пропускаем так как там название и ссылка
						$value = '';
						$prop[1] = '';
						$prop = explode(":",  $valData);			//получаем название и значение свойства
						$prop[1] = trim($prop[1]);
						
							//ищем свойство
							$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID, "NAME" => $prop[0]));
							if ($prop_fields = $properties->GetNext()){
								//$arProps[$key] = $prop_fields["ID"];
								
								$arPropPlus[$prop[0]] = 1; 				//записываем в массив найденных свойств
								
								
								
								if ( $prop[1] ) {
									//обрабатываем свойства у которых тип "список"
									if ( $prop_fields["PROPERTY_TYPE"] == 'L' ){
										$value = '';
										$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ID, "CODE"=>$prop_fields["CODE"]));
										while($enum_fields = $property_enums->GetNext()){
											if ( $enum_fields["VALUE"] == $prop[1] ){
												$value = $enum_fields["ID"];
											}
											//$arEnumValues[$prop_fields["ID"]][$enum_fields["ID"]] = $enum_fields["VALUE"];
										}
										if ( !$value ) {						//если значение не найдено, то добавляем его
											$ibpenum = new CIBlockPropertyEnum;
											if($PropID = $ibpenum->Add(Array('PROPERTY_ID'=>$prop_fields["ID"], 'VALUE'=>$prop[1]))){
												$value = $PropID;
											}
										} 
									} 
									elseif ( $prop_fields["CODE"] == 'BREND' ){
										$arFilter = array('UF_NAME' => $prop[1]); //задаете фильтр по вашим полям

										$sTableID = 'tbl_'.$entity_table_name;
										$rsData = $entity_data_class::getList(array(
											"select" => array('UF_XML_ID', 'UF_NAME'), //выбираем поля
											"filter" => $arFilter,
											"order" => array("UF_NAME"=>"ASC")
										));
										$rsData = new CDBResult($rsData, $sTableID);
										if ( $arRes = $rsData->Fetch() ){
											$value = $arRes["UF_XML_ID"];
										}
										
									}
									else {
									
										if ( $prop_fields['MULTIPLE'] == 'Y' ){	//множественное свойство
											$arMultiProps = explode(';', $prop[1]);
											$value = Array();
											foreach ( $arMultiProps as $arMultiProp ){
												$value[] = trim($arMultiProp);
											}
										}
										else {
											$value = $prop[1];
										}
									}
								
									if ( $value ){
										$arSetProps[$prop_fields["ID"]] = $value;
									}
								}
								else {
									$arSetProps[$prop_fields["ID"]] = '';
								}
								
							}
							else {
								$arPropMinus[$prop[0]] = 1; 				//записываем в массив ненайденных свойств
							}

					
					
					
					}
				}
			
				
				CIBlockElement::SetPropertyValuesEx($arItem["PRODUCT_ID"], false, $arSetProps);
				
				

			}
			
			CheckColor();
			
			echo "<h2>Заполнены свойства:</h2>";
			echo "<ul>";
			foreach ( $arPropPlus as $kName => $kVal){
				echo "<li>".$kName."</li>";
			}
			echo "</ul>";
			
			echo "<h2>Не найдены свойства:</h2>";
			echo "<ul>";
			foreach ( $arPropMinus as $kName => $kVal){
				if ( $kName ) {
					echo "<li>".$kName."</li>";
				}
			}
			echo "</ul>";
		}
		else{
			$error = "Не найдено совпадений";
		}
		
		

?>