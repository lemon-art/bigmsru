<?
CModule::IncludeModule("catalog");

$arProducts = Array();
foreach ($arResult["GRID"]["ROWS"] as $keyItem => $arItem){
	if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"){
		$arProducts[] = $arItem["PRODUCT_ID"];
		$res = CIBlockElement::GetByID( $arItem["PRODUCT_ID"] );
		if($ar_res = $res->GetNext()){
		
			$db_props = CIBlockElement::GetProperty($ar_res['IBLOCK_ID'], $ar_res['ID'], array("sort" => "asc"), Array("CODE"=>"MINIMALNAYA_NORMA_OTGRUZKI_M"));
			if($ar_props = $db_props->Fetch())
				if ( $ar_props["VALUE"] )
					$norma = IntVal($ar_props["VALUE"]);
				else
					$norma = 1;
				
			$arResult["GRID"]["ROWS"][$keyItem]["MEASURE_RATIO"] = $norma;
			
			$arCatRes = CCatalogProduct::GetByID( $arItem["PRODUCT_ID"] );
		
			if($ar_res['IBLOCK_SECTION_ID'] == 1405 || $ar_res['IBLOCK_SECTION_ID'] == 1385 || $ar_res['IBLOCK_SECTION_ID'] == 1386) { 
				$arResult["GRID"]["ROWS"][$keyItem]["STATUS_NAL"] = 1;
			} elseif($arCatRes["QUANTITY"] <= 0){
				$arResult["GRID"]["ROWS"][$keyItem]["STATUS_NAL"] = 0;
			} else{
				$arResult["GRID"]["ROWS"][$keyItem]["STATUS_NAL"] = 1;
			}
		}
	}
} 

?>
