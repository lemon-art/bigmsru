<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("sale");


if (is_array( $_REQUEST )){
	writeToLog( $_REQUEST );
	$dealID = $_REQUEST["data"]["FIELDS"]["ID"];
	$orderID = GetOrderIDByDealID($dealID);			//получаем номер заказа
	$roistat = GetRoistatByOrderID($orderID);		//получаем значение поля roistat
	//$dealID = GetB24DealIDByOrderID(1374);
	SetDealRoistat($dealID, $roistat);				//записываем roistat в сделку

} 
 
 
function writeToLog($data, $title = '') {
 $log = "\n------------------------\n";
 $log .= date("Y.m.d G:i:s") . "\n";
 $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
 $log .= print_r($data, 1);
 $log .= "\n------------------------\n";
 file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/tools/b24hook.log', $log, FILE_APPEND);
 return true;
} 


//получаем поле roistat из заказа
function GetRoistatByOrderID($orderID){

	$roistat = 0;
	$db_props = CSaleOrderPropsValue::GetOrderProps($orderID);
	while ($arProps = $db_props->Fetch()){
		if ( $arProps["CODE"] == "ROISTAT_VISIT"){
			$roistat = $arProps["VALUE"];
		}
	}

	return $roistat;
}



//получаем номер заказа по номеру сделки в битрикс24 
function GetOrderIDByDealID($dealID){
	$queryUrl = 'https://bigms.bitrix24.ru/rest/24/jqm5shkvwiaki7su/crm.deal.list.json';
 
	$queryData = http_build_query(
		array(
		'filter' => array(
			"ID" => $dealID
		),
		'select' => array(
			"TITLE"
		)
	));

	
	 $curl = curl_init();
	 curl_setopt_array($curl, array(
	 CURLOPT_SSL_VERIFYPEER => 0,
	 CURLOPT_POST => 1,
	 CURLOPT_HEADER => 0,
	 CURLOPT_RETURNTRANSFER => 1,
	 CURLOPT_URL => $queryUrl,
	 CURLOPT_POSTFIELDS => $queryData,
	 ));

	 $result = curl_exec($curl);
	 curl_close($curl);

	 $result = json_decode($result, 1);
	 
	if ( $result["result"][0]["TITLE"] ){
		$arOrder = explode('#', $result["result"][0]["TITLE"]);
		return $arOrder[1];
	}
 
}

//получаем номер сделки в битрикс24 по номеру заказа
function GetB24DealIDByOrderID($orderID){
	$queryUrl = 'https://bigms.bitrix24.ru/rest/24/jqm5shkvwiaki7su/crm.deal.list.json';
 
	$queryData = http_build_query(
		array(
		'filter' => array(
			"%TITLE" => $orderID
		),
		'select' => array(
			"ID"
		)
	));

	
	 $curl = curl_init();
	 curl_setopt_array($curl, array(
	 CURLOPT_SSL_VERIFYPEER => 0,
	 CURLOPT_POST => 1,
	 CURLOPT_HEADER => 0,
	 CURLOPT_RETURNTRANSFER => 1,
	 CURLOPT_URL => $queryUrl,
	 CURLOPT_POSTFIELDS => $queryData,
	 ));

	 $result = curl_exec($curl);
	 curl_close($curl);

	 $result = json_decode($result, 1);
	 
	if ( $result["result"][0]["ID"] ){
		$dealID = $result["result"][0]["ID"];
		return $dealID;
	}
 
}

//устанавливаем roistat в сделку
function SetDealRoistat($dealID, $roistat){

	$queryUrl = 'https://bigms.bitrix24.ru/rest/24/jqm5shkvwiaki7su/crm.deal.update.json';
 
	$queryData = http_build_query(
		array(
		'id' => $dealID,
		'fields' => array(
			"UF_CRM_1488878206" => $roistat
		)
	));

	
	 $curl = curl_init();
	 curl_setopt_array($curl, array(
	 CURLOPT_SSL_VERIFYPEER => 0,
	 CURLOPT_POST => 1,
	 CURLOPT_HEADER => 0,
	 CURLOPT_RETURNTRANSFER => 1,
	 CURLOPT_URL => $queryUrl,
	 CURLOPT_POSTFIELDS => $queryData,
	 ));

	 $result = curl_exec($curl);
	 curl_close($curl);

	 
 
}




?>

