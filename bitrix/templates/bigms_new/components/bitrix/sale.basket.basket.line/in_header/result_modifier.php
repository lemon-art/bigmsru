<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

if (CModule::IncludeModule("sale") && CModule::IncludeModule("catalog"))
{
	$arBasketItems = array();

	$dbBasketItems = CSaleBasket::GetList(
			array(
					"ID" => "ASC"
				),
			array(
					"FUSER_ID" => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"ORDER_ID" => "NULL",
					"DELAY" => "N",
					"CAN_BUY" => "Y"
				),
			false,
			false,
			array("ID", "PRODUCT_ID", "NAME", "DETAIL_PAGE_URL", "PRICE", "QUANTITY", "CURRENCY")
		);
		
	while ($arItems = $dbBasketItems->Fetch())
	{
		if (strlen($arItems["CALLBACK_FUNC"]) > 0)
		{
			CSaleBasket::UpdatePrice($arItems["ID"],
									 $arItems["QUANTITY"]);
			$arItems = CSaleBasket::GetByID($arItems["ID"]);
		}
		$arBasketItems[] = $arItems;
	}

	$count = 0;
	$summ = 0;
	foreach($arBasketItems as $k=>$v)
	{
		$count = $count + $v["QUANTITY"];
		$arResult["ITEM"][$k] = $v;
		$arResult["ITEM"][$k]["SUM"] = $v["QUANTITY"]*$v["PRICE"];
		$summ  += $arResult["ITEM"][$k]["SUM"];
	
	}
	
	$arResult["SUMM_NEW"] = ceil($count);
	$arResult["ALL_SUMM"] = number_format($summ,0,'.',' ');
	$arResult["NUM_PRODUCTS"] = $arResult["SUMM_NEW"];
}
?>


<?
		global $USER;
		$arResult["FAVORITES"] = Array();
		if(!$USER->IsAuthorized()){
			$arElements = unserialize($APPLICATION->get_cookie('favorites'));
		}
		else{ 
			$idUser = $USER->GetID();
			$rsUser = CUser::GetByID($idUser);
			$arUser = $rsUser->Fetch();
			$arElements = unserialize($arUser['UF_FAVORITES']);
        }  
		foreach ( $arElements as $key => $arElement){
			if ( !$arElement ) {
				unset( $arElements[$key] );
			}
		}
		if ( !empty($arElements)){
			$arResult["FAVORITES"] = $arElements;
		}
?>