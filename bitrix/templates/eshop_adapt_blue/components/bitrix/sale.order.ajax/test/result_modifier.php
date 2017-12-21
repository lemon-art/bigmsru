<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>


<?
$test = 1;

if($arResult["USER_VALS"]["DELIVERY_ID"] == 1 && $test==1){
	$arResult["DELIVERY"][1]["PRICE"] = 8000;
	$arResult["DELIVERY"][1]["PRICE_FORMATED"] = "8 000 руб.";
	$arResult["DELIVERY_PRICE"] = 8000;
	$arResult["DELIVERY_PRICE_FORMATED"] = "8 000 руб.";
	
	$arResult["ORDER_TOTAL_PRICE_FORMATED"] = "9 299 руб.";
}
?>


<pre><?print_r($arResult)?></pre>