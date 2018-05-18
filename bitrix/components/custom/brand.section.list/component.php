<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

use Bitrix\Main\Loader,
	Bitrix\Main,
	Bitrix\Iblock;

/*************************************************************************
	Processing of received parameters
*************************************************************************/
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);
$arParams["SECTION_ID"] = intval($arParams["SECTION_ID"]);
$arParams["SECTION_CODE"] = trim($arParams["SECTION_CODE"]);
$arParams["BRAND_NAME"] = trim($arParams["BRAND_NAME"]);
$arParams["BRAND_XML"] = trim($arParams["BRAND_XML"]);

$arParams["SECTION_URL"]=trim($arParams["SECTION_URL"]);

$arParams["TOP_DEPTH"] = intval($arParams["TOP_DEPTH"]);
if($arParams["TOP_DEPTH"] <= 0)
	$arParams["TOP_DEPTH"] = 2;
$arParams["COUNT_ELEMENTS"] = $arParams["COUNT_ELEMENTS"]!="N";
$arParams["ADD_SECTIONS_CHAIN"] = $arParams["ADD_SECTIONS_CHAIN"]!="N"; //Turn on by default

//////////////upd////////////////////////////////

$arResult["SECTIONS"] = array();
$arResult["BRAND_NAME"] = $arParams["BRAND_NAME"];

$curPage = $APPLICATION->GetCurPage(false);
$APPLICATION->AddHeadString('<link href="http://'.$_SERVER["SERVER_NAME"].$curPage.'" rel="canonical" />',true);

///////////////////////////////////////////////////


/*************************************************************************
			Work with cache
*************************************************************************/
if($this->startResultCache(false, ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())))
{
	if(!Loader::includeModule("iblock"))
	{
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	$arFilter = array(
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
		"IBLOCK_ID" => 10,
		"CNT_ACTIVE" => "Y",
	);


	$arSelect = array();
	if(array_key_exists("SECTION_FIELDS", $arParams) && !empty($arParams["SECTION_FIELDS"]) && is_array($arParams["SECTION_FIELDS"]))
	{
		foreach($arParams["SECTION_FIELDS"] as &$field)
		{
			if (!empty($field) && is_string($field))
				$arSelect[] = $field;
		}
		if (isset($field))
			unset($field);
	}

	if(!empty($arSelect))
	{
		$arSelect[] = "ID";
		$arSelect[] = "NAME";
		$arSelect[] = "LEFT_MARGIN";
		$arSelect[] = "RIGHT_MARGIN";
		$arSelect[] = "DEPTH_LEVEL";
		$arSelect[] = "IBLOCK_ID";
		$arSelect[] = "IBLOCK_SECTION_ID";
		$arSelect[] = "LIST_PAGE_URL";
		$arSelect[] = "SECTION_PAGE_URL";
	}
	$boolPicture = empty($arSelect) || in_array('PICTURE', $arSelect);

	if(isset($arParams['SECTION_USER_FIELDS']) && !empty($arParams["SECTION_USER_FIELDS"]) && is_array($arParams["SECTION_USER_FIELDS"]))
	{
		foreach($arParams["SECTION_USER_FIELDS"] as &$field)
		{
			if(is_string($field) && preg_match("/^UF_/", $field))
				$arSelect[] = $field;
		}
		if (isset($field))
			unset($field);
	}

	$arResult["SECTION"] = false;
	$intSectionDepth = 0;
	if($arParams["SECTION_ID"]>0)
	{
		$arFilter["ID"] = $arParams["SECTION_ID"];
		$rsSections = CIBlockSection::GetList(array(), $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect);
		$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
		$arResult["SECTION"] = $rsSections->GetNext();
	}
	elseif('' != $arParams["SECTION_CODE"])
	{
		$arFilter["=CODE"] = $arParams["SECTION_CODE"];
		$rsSections = CIBlockSection::GetList(array(), $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect);
		$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
		$arResult["SECTION"] = $rsSections->GetNext();
	}

	if(is_array($arResult["SECTION"]))
	{
		unset($arFilter["ID"]);
		unset($arFilter["=CODE"]);
		$arFilter["LEFT_MARGIN"]=$arResult["SECTION"]["LEFT_MARGIN"]+1;
		$arFilter["RIGHT_MARGIN"]=$arResult["SECTION"]["RIGHT_MARGIN"];
		$arFilter["<="."DEPTH_LEVEL"]=$arResult["SECTION"]["DEPTH_LEVEL"] + $arParams["TOP_DEPTH"];

		$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arResult["SECTION"]["IBLOCK_ID"], $arResult["SECTION"]["ID"]);
		$arResult["SECTION"]["IPROPERTY_VALUES"] = $ipropValues->getValues();

		$arResult["SECTION"]["PATH"] = array();
		$rsPath = CIBlockSection::GetNavChain($arResult["SECTION"]["IBLOCK_ID"], $arResult["SECTION"]["ID"]);
		$rsPath->SetUrlTemplates("", $arParams["SECTION_URL"]);
		while($arPath = $rsPath->GetNext())
		{
			$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], $arPath["ID"]);
			$arPath["IPROPERTY_VALUES"] = $ipropValues->getValues();
			$arResult["SECTION"]["PATH"][]=$arPath;
		}
	}
	else
	{
		$arResult["SECTION"] = array("ID"=>0, "DEPTH_LEVEL"=>0);
		$arFilter["<="."DEPTH_LEVEL"] = $arParams["TOP_DEPTH"];
	}
	$intSectionDepth = $arResult["SECTION"]['DEPTH_LEVEL'];
	
	$arFilter["PROPERTY"] = Array('BREND'=>$arParams["BRAND_XML"] );
	$arFilter["<="."DEPTH_LEVEL"] = 1;
	

	//ORDER BY
	$arSort = array(
		"left_margin"=>"asc",
	);
	//EXECUTE
	//для второго инфоблока
	$arFilter2 = $arFilter;
	$arFilter2["IBLOCK_ID"] = 12;
	
	$rsSections = CIBlockSection::GetList($arSort, $arFilter, $arParams["COUNT_ELEMENTS"], $arSelect);
	$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
	while($arSection = $rsSections->GetNext())
	{
		$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arSection["IBLOCK_ID"], $arSection["ID"]);
		$arSection["IPROPERTY_VALUES"] = $ipropValues->getValues();
		
		$arSection['RELATIVE_DEPTH_LEVEL'] = $arSection['DEPTH_LEVEL'] - $intSectionDepth;

		//получаем картинку элемента раздела по бренду
		$arFilterElement = Array(
			"IBLOCK_ID"=>$arSection["IBLOCK_ID"], 
			"SECTION_ID" => $arSection["ID"], 
			"ACTIVE"=>"Y", 
			"INCLUDE_SUBSECTIONS" => "Y",
			"!DETAIL_PICTURE" => false, 
			"PROPERTY_BREND" => $arParams["BRAND_XML"]
		);
		
		$res = CIBlockElement::GetList(Array(), $arFilterElement, false, Array("nTopCount"=>1), Array("DETAIL_PICTURE"));
		if($arElement = $res->GetNext()){
			$file = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], array('width'=>140, 'height'=>75), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
			$arSection['PICTURE'] = $file['src'];

		}
		////

		$arResult["SECTIONS"][]=$arSection;
	}
	
	

	
	
	$rsSections = CIBlockSection::GetList($arSort, $arFilter2, $arParams["COUNT_ELEMENTS"], $arSelect);
	$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
	while($arSection = $rsSections->GetNext())
	{
		$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arSection["IBLOCK_ID"], $arSection["ID"]);
		$arSection["IPROPERTY_VALUES"] = $ipropValues->getValues();

		
		$arSection['RELATIVE_DEPTH_LEVEL'] = $arSection['DEPTH_LEVEL'] - $intSectionDepth;

		//получаем картинку элемента раздела по бренду
		$arFilterElement = Array(
			"IBLOCK_ID"=>$arSection["IBLOCK_ID"], 
			"SECTION_ID" => $arSection["ID"], 
			"ACTIVE"=>"Y", 
			"INCLUDE_SUBSECTIONS" => "Y",
			"!DETAIL_PICTURE" => false, 
			"PROPERTY_BREND" => $arParams["BRAND_XML"],
		);
		
		$res = CIBlockElement::GetList(Array(), $arFilterElement, false, Array("nTopCount"=>1), Array("DETAIL_PICTURE"));
		if($arElement = $res->GetNext()){
			$file = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], array('width'=>140, 'height'=>75), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
			$arSection['PICTURE'] = $file['src'];
		}
		
		//получаем страну производителя
		$arFilterElement = Array(
			"IBLOCK_ID"=>$arSection["IBLOCK_ID"], 
			"SECTION_ID" => $arSection["ID"], 
			"ACTIVE"=>"Y", 
			"INCLUDE_SUBSECTIONS" => "Y",
			"PROPERTY_BREND" => $arParams["BRAND_XML"],
			"!PROPERTY_STRANA_PROIZVODITEL" => false
		);
		
		$res = CIBlockElement::GetList(Array(), $arFilterElement, false, Array("nTopCount"=>1), Array("PROPERTY_STRANA_PROIZVODITEL"));
		if($arElement = $res->GetNext()){
			$arResult["COUNTRY_NAME"] = $arElement["PROPERTY_STRANA_PROIZVODITEL_VALUE"];
			$arResult["COUNTRY_ID"] = $arElement["PROPERTY_STRANA_PROIZVODITEL_ENUM_ID"];
			$arResult["IBLOCK_ID"] = $arSection["IBLOCK_ID"];
		}
		////
		


		$arResult["SECTIONS"][]=$arSection;
	}
	
	
		//добавляем pdf документацию
		$arFilterElement = Array(
			"IBLOCK_ID"=>24, 
			"ACTIVE"=>"Y", 
			"PROPERTY_brend" => $arParams["BRAND_XML"],
			"!PROPERTY_show_brend" => false
		);
		
		$res = CIBlockElement::GetList(Array(), $arFilterElement, false, false, Array("NAME", "PROPERTY_file"));
		while($arElement = $res->GetNext()){
		
			echo "<pre>";
			print_r( $arElement );
			echo "</pre>";
			
			$arSection = Array(
				"NAME" => $arElement["NAME"],
				"PDF" => "Y",
				"SECTION_PAGE_URL" => CFile::GetPath($arElement["PROPERTY_FILE_VALUE"]),
				"PICTURE" => "/images/pdficon_bf.png"
			);
		}

		$arResult["SECTIONS"][]=$arSection;
	
	


	$arResult["SECTIONS_COUNT"] = count($arResult["SECTIONS"]);



	$this->setResultCacheKeys(array(
		"SECTIONS_COUNT",
		"SECTION",
	));

	$this->includeComponentTemplate();
}



?>