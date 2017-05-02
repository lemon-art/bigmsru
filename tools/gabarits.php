<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$arFilter = Array(
 "IBLOCK_ID"=>12, 
 "SECTION_ID" => 1281,
 "INCLUDE_SUBSECTIONS" => "Y",
	"!PROPERTY_DLINA_SM" => false,
	"!PROPERTY_SHIRINA_SM" => false,
	"!PROPERTY_GLUBINA_MM" => false
 );
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, Array("NAME", "ID", "PROPERTY_DLINA_SM", "PROPERTY_SHIRINA_SM", "PROPERTY_GLUBINA_MM", "PROPERTY_GABARITS"));
while($ar_fields = $res->GetNext())
{
	$arSetProps = Array();
	if ( $ar_fields["PROPERTY_DLINA_SM_VALUE"] && $ar_fields["PROPERTY_SHIRINA_SM_VALUE"] && $ar_fields["PROPERTY_GLUBINA_MM_VALUE"] ){
		$gab = $ar_fields["PROPERTY_DLINA_SM_VALUE"] . "х" . $ar_fields["PROPERTY_SHIRINA_SM_VALUE"]. "х" . $ar_fields["PROPERTY_GLUBINA_MM_VALUE"];
		$arSetProps["GABARITS"] = $gab;
		CIBlockElement::SetPropertyValuesEx($ar_fields["ID"], false, $arSetProps);
	}
 echo "<pre>";
 print_r( $ar_fields );
 echo "</pre>";
}

?>