<?
CModule::IncludeModule("catalog");

$arProducts = Array();
foreach ($arResult["GRID"]["ROWS"] as $keyItem => $arItem){
	if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"){
		$arProducts[] = $arItem["PRODUCT_ID"];
		$res = CIBlockElement::GetByID( $arItem["PRODUCT_ID"] );
		if($ar_res = $res->GetNext()){
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
