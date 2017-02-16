<?php


/*if(isset($_COOKIE['test'])){
	echo "<pre>";
	var_dump($arResult);
}*/


if ($arResult["NavPageNomer"]>1) {
   /* $val = $APPLICATION->GetCurPageParam("", array_keys($_GET), false);
    $APPLICATION->SetPageProperty("canonical", $val);*/
 
    
    $val = $APPLICATION->GetCurPageParam("", array_keys($_GET), false).($arResult["NavPageNomer"]>1?'?PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]-1):'');
    //$APPLICATION->SetPageProperty("meta-prev", $val);
    $APPLICATION->AddHeadString('<link rel="prev" href="http://'.$_SERVER["SERVER_NAME"].$val.'"/>', true);
}

if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
    
    $val = $APPLICATION->GetCurPageParam("", array_keys($_GET), false).'?PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1);
    //$APPLICATION->SetPageProperty("meta-next", $val);
    $APPLICATION->AddHeadString('<link rel="next" href="http://'.$_SERVER["SERVER_NAME"].$val.'"/>', true);
}