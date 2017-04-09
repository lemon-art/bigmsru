<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");



function xml2ary(&$string) {
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parse_into_struct($parser, $string, $vals, $index);
    xml_parser_free($parser);

    $mnary=array();
    $ary=&$mnary;
    foreach ($vals as $r) {
        $t=$r['tag'];
        if ($r['type']=='open') {
            if (isset($ary[$t])) {
                if (isset($ary[$t][0])) $ary[$t][]=array(); else $ary[$t]=array($ary[$t], array());
                $cv=&$ary[$t][count($ary[$t])-1];
            } else $cv=&$ary[$t];
            if (isset($r['attributes'])) {foreach ($r['attributes'] as $k=>$v) $cv['_a'][$k]=$v;}
            $cv['_c']=array();
            $cv['_c']['_p']=&$ary;
            $ary=&$cv['_c'];

        } elseif ($r['type']=='complete') {
            if (isset($ary[$t])) { // same as open
                if (isset($ary[$t][0])) $ary[$t][]=array(); else $ary[$t]=array($ary[$t], array());
                $cv=&$ary[$t][count($ary[$t])-1];
            } else $cv=&$ary[$t];
            if (isset($r['attributes'])) {foreach ($r['attributes'] as $k=>$v) $cv['_a'][$k]=$v;}
            $cv['_v']=(isset($r['value']) ? $r['value'] : '');

        } elseif ($r['type']=='close') {
            $ary=&$ary['_p'];
        }
    }

    _del_p($mnary);
    return $mnary;
}

// _Internal: Remove recursion in result array
function _del_p(&$ary) {
    foreach ($ary as $k=>$v) {
        if ($k==='_p') unset($ary[$k]);
        elseif (is_array($ary[$k])) _del_p($ary[$k]);
    }
}

function GetYandexMarketID( $name ) {
    
	$url='https://api.partner.market.yandex.ru/v2/models.xml?query=' . $name . '&regionId=2&oauth_token=AQAAAAAXaBxvAAQulO0P11bAzUGXsE6tIvZNi-I&oauth_client_id=f5be47d769fd4f2ca8fb1a258725c479';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = xml2ary(curl_exec($ch));
	curl_close($ch);

	$id = $data['response']['_c']['models']['_c']['model']['_a']['id'];
	return $id;
	
}

function SendCacklePost( $data ) {
    

	$url = "http://cackle.me/api/3.0/review/productym.json";  
	  
	  
	$ch = curl_init();  
	  
	curl_setopt($ch, CURLOPT_URL, $url);  
	  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	// указываем, что у нас POST запрос  
	curl_setopt($ch, CURLOPT_POST, 1);  
	// добавляем переменные  
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'id=52079&siteApiKey=d4MduhU6Kn7B4NrfCmvZgyewj7F0ViT8GtWHeDIzwkxq1lHpBgk934ZcKseXVcWK&accountApiKey=tOwRQTK8wQMVMDBATqtNOplDzUs54ci0SKCyqR25cFmMH3ZLtHOMQ6zg6CNKE2Ba&products='.$data);  
	  
	$output = curl_exec($ch);  
	  
	curl_close($ch);
	
}



$arElements = Array();

$arFilter = Array(
 "IBLOCK_ID"=>12, 
 "SECTION_ID" => 1308,
 "IBLOCK_ID" => 12,
 "INCLUDE_SUBSECTIONS" => "Y" 
);
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, Array("*", "PROPERTY_CML2_ARTICLE"));
while($ar_fields = $res->GetNext())
{
	
	$name = urlencode($ar_fields["NAME"]);
	$id = GetYandexMarketID( $name );
	if ( !$id ){
		$name = $ar_fields["PROPERTY_CML2_ARTICLE_VALUE"];
		$id = GetYandexMarketID( $name );
	}
	
	if ( $id ){
	
		$arElements[] = Array(
			"prodId" => $ar_fields["ID"],
			"ymId"   => $id,
			"chan"   => $ar_fields["DETAIL_PAGE_URL"],
			"url"    => "http://www.bigms.ru" . $ar_fields["DETAIL_PAGE_URL"],
			"name"   => $ar_fields["NAME"]
		);
	}
	
 
}

SendCacklePost( json_encode( $arElements, JSON_UNESCAPED_UNICODE ) );



  
  


?>

