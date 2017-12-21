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
	foreach($arBasketItems as $k=>$v)
	{
		$count = $count + $v["QUANTITY"];
		$arResult["ITEM"][$k] = $v;
		$arResult["ITEM"][$k]["SUM"] = $v["QUANTITY"]*$v["PRICE"];
		// Получаем фото товара
		$res = CIBlockElement::GetByID($v["PRODUCT_ID"]);
		if($ar_res = $res->GetNext()){
			$arFile = CFile::GetFileArray($ar_res["DETAIL_PICTURE"]);
			/* echo "<pre>";
			print_r($arFile);
			echo "</pre>"; */
			$arResult["ITEM"][$k]["DETAIL_PICTURE"] = $arFile["SRC"];
		}
		if(empty($arResult["ITEM"][$k]["DETAIL_PICTURE"])){
			$arResult["ITEM"][$k]["DETAIL_PICTURE"] = $this->GetFolder().'/images/no_photo.png';
		}
	}
	
	$arResult["SUMM_NEW"] = ceil($count);
	$arResult["NUM_PRODUCTS"] = $arResult["SUMM_NEW"];
}
?>


<?
/* global $USER;
if ($USER->IsAdmin()) {?>
	<pre><?print_r($arResult)?></pre>
<?
} */
?>