<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

function CheckColor(){


$IBLOCK_ID = 12;
$arProp = Array();

$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("CODE"=>"TSVET", "IBLOCK_ID"=>$IBLOCK_ID));
if ($prop_fields = $properties->GetNext())
{
  $PROPERTY_ID = $prop_fields["ID"];
}



$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ID, "CODE"=>"TSVET"));
while($enum_fields = $property_enums->GetNext())
{
  $arProp[$enum_fields["ID"]] = $enum_fields["VALUE"];
}

//ищем дубли
$arItogProperty = Array();
foreach ( $arProp as $keyProp => $valProp ){
	$arItogProperty[$valProp][] = $keyProp;
}


/*
//убираем дубли
foreach ( $arItogProperty as $valProp => $keyProp ){
		
		if ( count ($keyProp) > 1 ){
			echo $valProp . "<br>"; 
			$idProp = $keyProp[0];
			
			//ищем элементы с таким свойством
			$arSelect = Array("ID", "NAME");
			$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_TSVET" => $keyProp);
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
			$arElements = Array();
			while($ob = $res->GetNextElement())	{
				$arFields = $ob->GetFields();
				$arElements[] = $arFields["ID"]; //массив с элементами в которые надо внести изменения по свойствам
				echo $arFields["NAME"] . "<br>";
			}
			
			
			$arSetProps = Array(
				"TSVET" => $keyProp[0]
			);
			
			//установили свойства
			foreach ( $arElements as $arElement ){
				CIBlockElement::SetPropertyValuesEx($arElement, false, $arSetProps);
			}
			
			//удаляем вариант свойства который не нужен
			foreach ( $keyProp as $idProp ){
				if ( $idProp !== $keyProp[0])
					CIBlockPropertyEnum::Delete( $idProp );
			}
			
		
		}
}
*/

foreach ( $arItogProperty as $valProp => $keyProp ){
	$arPropValue = explode(', ', $valProp);
	if ( count ( $arPropValue ) > 1 ){ 		//двойное значение свойства
		
		
		echo $valProp . " - ";
		
		//ищем элементы с таким свойством
		$arSelect = Array("ID", "NAME");
		$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_TSVET" => $keyProp);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
		$arElements = Array();
		while($ob = $res->GetNextElement())	{
			$arFields = $ob->GetFields();
			$arElements[] = $arFields["ID"]; //массив с элементами в которые надо внести изменения по свойствам
		}
		
		//определяет свойства для замены
		$arNewProp = Array();
		foreach ( $arPropValue as $valPropValuy ){
			if ( $arItogProperty[$valPropValuy][0] ){
				$arNewProp[] = $arItogProperty[$valPropValuy][0];
			}
			else {
				$ibpenum = new CIBlockPropertyEnum;
				if($PropID = $ibpenum->Add(Array('PROPERTY_ID'=>$PROPERTY_ID, 'VALUE'=>$valPropValuy))){
					$arItogProperty[$valPropValuy][0] = $PropID;
					$arNewProp[] = $PropID;
				}
			}
		}
		$arSetProps = Array(
			"TSVET" => $arNewProp
		);
		
		//установили свойства
		foreach ( $arElements as $arElement ){
			CIBlockElement::SetPropertyValuesEx($arElement, false, $arSetProps);
		}
		
		//удаляем вариант свойства который не нужен
		foreach ( $keyProp as $idProp ){
			CIBlockPropertyEnum::Delete( $idProp );
		}


	}

}

}

?>