<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$IBLOCK_ID = 19;
$arFilter = array(
				"IBLOCK_ID" => $IBLOCK_ID,
				//"PROPERTY_URL" => false,
				//"ID" => '17997'
			);
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array("ID", "PROPERTY_H1", "NAME"));
			while($ar_fields = $res->GetNext()){
				echo $ar_fields["NAME"]."<br>";
				$newUrl = Cutil::translit($ar_fields["PROPERTY_H1_VALUE"], "ru");
				$smartParts = explode("/", $ar_fields["NAME"]);
				$filterUrl = "/".$smartParts[1]."/".$smartParts[2]."/". $newUrl . "/";
				$arSetProps = Array("URL" => $filterUrl);
				CIBlockElement::SetPropertyValuesEx($ar_fields["ID"], false, $arSetProps);
				
				$el = new CIBlockElement;
				$arLoadProductArray = Array(
					"NAME" => $ar_fields["NAME"]
				);
				$resNew = $el->Update($ar_fields["ID"], $arLoadProductArray);
				
			}
			
?>