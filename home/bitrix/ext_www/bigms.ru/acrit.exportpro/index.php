<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$documentRoot = \Bitrix\Main\Application::getDocumentRoot();
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$filePath = $request->get('path');
if( stripos( $request->get('path'), "xml" ) !== false ){
    if( stripos( $documentRoot.$request->get('path'), "?" ) !== false ){
        $arRequest = explode( "?", $request->get('path') );
        $filePath = $arRequest[0];
    }
}

$document = false;
if( file_exists( $documentRoot.$filePath ) ){
    $document = $documentRoot.$filePath;
}
elseif( file_exists( $documentRoot."/upload/acrit.exportpro/".$filePath ) ){
    $document = $documentRoot."/upload/acrit.exportpro/".$filePath;
}
elseif( file_exists( $documentRoot."/upload/".$filePath ) ){
    $document = $documentRoot."/upload/".$filePath;
}


$inputEncoding = $request->get('encoding');

if( $document ){
    $APPLICATION->RestartBuffer();
    if( stripos( $filePath, "xml" ) !== false ){
        header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Cache-Control: post-check=0,pre-check=0");
        header("Pragma: no-cache");
        //header("Content-Type: text/xml");
        header('Content-Type: application/xml; charset='.$inputEncoding);
        //header("Cache-Control: max-age=0");
        //echo file_get_contents($documentRoot.'/upload/acrit.exportpro/'.$filePath);
        echo file_get_contents( $document );    
    }
    elseif( stripos( $filePath, "zip" ) !== false ){
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Length: ".filesize($file));
        header("Content-Disposition: attachment; filename=\"".basename($file)."\"");
        readfile($file);
        exit;
    }
    else{
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filePath); 
        
        echo file_get_contents( $document );    
    }
    die();
}

//$urlRewriter = new CUrlRewriter;
//echo '<pre>', print_r($urlRewriter->GetList() ,true), '</pre>';
//$urlRewriter->Add(array(
//    'CONDITION' => '#^/acrit.exportpro/(.*)#',
//    'PATH' => '/acrit.exportpro/index.php',
//    'RULE' => 'path=$1',
//));
//echo '<pre>', print_r($urlRewriter->GetList() ,true), '</pre>';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");