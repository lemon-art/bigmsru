<?php
##############################################
# Bitrix Site Thumb Image Manager 6          #
# Copyright (c) 2010 Bitrix                  #
# http://www.bitrixsoft.com                  #
#                                            #
# phpThumb() by James Heinrich               #
#                                            #
# <info@silisoftware.com>                    #
# admin@bitrixsoft.com                       #
##############################################

define("START_EXEC_PROLOG_BEFORE_1", microtime());
$GLOBALS["BX_STATE"] = "PB";
unset($_REQUEST["BX_STATE"]);
unset($_GET["BX_STATE"]);
unset($_POST["BX_STATE"]);
unset($_COOKIE["BX_STATE"]);
unset($_FILES["BX_STATE"]);

if (isset($_REQUEST['bxpublic']) && $_REQUEST['bxpublic'] == 'Y' && !defined('BX_PUBLIC_MODE'))
    define('BX_PUBLIC_MODE', 1);

if (defined('BX_PUBLIC_MODE') && @BX_PUBLIC_MODE == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
        $bxRoot = true;
}


$aSTabs   = array();
$aSTabs[] = array(
    "DIV"   => "edit_sale",
    "TAB"   => "MAIN_1C_SALE_TAB",
    "TITLE" => "MAIN_1C_SALE_TAB_TITLE",
    "FILE"  => $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/sale/admin/1c_admin_inc.php",
);
$aSTabs[] = array(
    "DIV"   => "edit_sale_profile",
    "TAB"   => "MAIN_1C_SALE_PROFILE_TAB",
    "TITLE" => "MAIN_1C_SALE_PROFILE_TITLE",
    "FILE"  => $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/sale/admin/1c_admin_profile.php",
);


function dump($data)
{
    echo '<pre>' . print_r($data, true) . '</pre>';
}

if (count($aSTabs) < 1) {
    $aSTabs[] = array(
        "DIV"   => "edit_none",
        "TAB"   => "MAIN_1C_TAB",
        "TITLE" => "MAIN_1C_TAB_TITLE",
    );
}

define("NEED_AUTH", true);
define("ADMIN_SECTION", true);
define("BITRIX_CONTROL_SUM", 'd92968ec135a7196767c1e34f4115241');
define("LANG_CHARSET", 'en');


function SendSaveAsFileHeaderIfNeeded()
{
    if (headers_sent()) {
        return false;
    }
    global $phpThumb;
    $downloadfilename = phpthumb_functions::SanitizeFilename(!empty($_GET['sia']) ? $_GET['sia'] : (!empty($_GET['down']) ? $_GET['down'] : 'phpThumb_generated_thumbnail.' . (!empty($_GET['f']) ? $_GET['f'] : 'jpg')));
    if (!empty($downloadfilename)) {
        $phpThumb->DebugMessage('SendSaveAsFileHeaderIfNeeded() sending header: Content-Disposition: ' . (!empty($_GET['down']) ? 'attachment' : 'inline') . '; filename="' . $downloadfilename . '"', __FILE__, __LINE__);
        header('Content-Disposition: ' . (!empty($_GET['down']) ? 'attachment' : 'inline') . '; filename="' . $downloadfilename . '"');
    }

    return true;
}

function RedirectToCachedFile()
{
    global $phpThumb;

    $nice_cachefile = str_replace(DIRECTORY_SEPARATOR, '/', $phpThumb->cache_filename);
    $nice_docroot   = str_replace(DIRECTORY_SEPARATOR, '/', rtrim($phpThumb->config_document_root, '/\\'));

    $parsed_url = phpthumb_functions::ParseURLbetter(@$_SERVER['HTTP_REFERER']);

    $nModified = filemtime($phpThumb->cache_filename);

    if ($phpThumb->config_nooffsitelink_enabled && !empty($_SERVER['HTTP_REFERER']) && !in_array(@$parsed_url['host'], $phpThumb->config_nooffsitelink_valid_domains)) {

        $phpThumb->DebugMessage('Would have used cached (image/' . $phpThumb->thumbnailFormat . ') file "' . $phpThumb->cache_filename . '" (Last-Modified: ' . gmdate('D, d M Y H:i:s', $nModified) . ' GMT), but skipping because $_SERVER[HTTP_REFERER] (' . @$_SERVER['HTTP_REFERER'] . ') is not in $phpThumb->config_nooffsitelink_valid_domains (' . implode(';', $phpThumb->config_nooffsitelink_valid_domains) . ')', __FILE__, __LINE__);

    } elseif ($phpThumb->phpThumbDebug) {

        $phpThumb->DebugTimingMessage('skipped using cached image', __FILE__, __LINE__);
        $phpThumb->DebugMessage('Would have used cached file, but skipping due to phpThumbDebug', __FILE__, __LINE__);
        $phpThumb->DebugMessage('* Would have sent headers (1): Last-Modified: ' . gmdate('D, d M Y H:i:s', $nModified) . ' GMT', __FILE__, __LINE__);
        if ($getimagesize = @getimagesize($phpThumb->cache_filename)) {
            $phpThumb->DebugMessage('* Would have sent headers (2): Content-Type: ' . phpthumb_functions::ImageTypeToMIMEtype($getimagesize[2]), __FILE__, __LINE__);
        }
        if (preg_match('#^' . preg_quote($nice_docroot) . '(.*)$#', $nice_cachefile, $matches)) {
            $phpThumb->DebugMessage('* Would have sent headers (3): Location: ' . dirname($matches[1]) . '/' . urlencode(basename($matches[1])), __FILE__, __LINE__);
        } else {
            $phpThumb->DebugMessage('* Would have sent data: readfile(' . $phpThumb->cache_filename . ')', __FILE__, __LINE__);
        }

    } else {

        if (headers_sent()) {
            $phpThumb->ErrorImage('Headers already sent (' . basename(__FILE__) . ' line ' . __LINE__ . ')');
            exit;
        }
        SendSaveAsFileHeaderIfNeeded();

        header('Pragma: private');
        header('Cache-Control: max-age=' . $phpThumb->getParameter('config_cache_maxage'));
        header('Expires: ' . date(DATE_RFC1123, time() + $phpThumb->getParameter('config_cache_maxage')));
        if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) && ($nModified == strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])) && !empty($_SERVER['SERVER_PROTOCOL'])) {
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $nModified) . ' GMT');
            header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
            exit;
        }
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $nModified) . ' GMT');
        header('ETag: "' . md5_file($phpThumb->cache_filename) . '"');
        if ($getimagesize = @getimagesize($phpThumb->cache_filename)) {
            header('Content-Type: ' . phpthumb_functions::ImageTypeToMIMEtype($getimagesize[2]));
        } elseif (preg_match('#\\.ico$#i', $phpThumb->cache_filename)) {
            header('Content-Type: image/x-icon');
        }
        header('Content-Length: ' . filesize($phpThumb->cache_filename));
        if (empty($phpThumb->config_cache_force_passthru) && preg_match('#^' . preg_quote($nice_docroot) . '(.*)$#', $nice_cachefile, $matches)) {
            header('Location: ' . dirname($matches[1]) . '/' . urlencode(basename($matches[1])));
        } else {
            @readfile($phpThumb->cache_filename);
        }
        exit;

    }

    return true;
}


try {

    if (!function_exists('check_bitrix_sessid')) {
        throw new Exception('check_bitrix_sessid not exist');
    }

    // instantiate a new phpThumb() object
    ob_start();
    if (!include_once(dirname(__FILE__) . '/phpthumb.class.php')) {
        ob_end_flush();
        die('failed to include_once("' . realpath(dirname(__FILE__) . '/phpthumb.class.php') . '")');
    }
    ob_end_clean();
    $phpThumb = new phpThumb();
    $phpThumb->DebugTimingMessage('phpThumb.php start', __FILE__, __LINE__, $starttime);
    $phpThumb->setParameter('config_error_die_on_error', true);

    if (!phpthumb_functions::FunctionIsDisabled('set_time_limit')) {
        set_time_limit(60);  // shouldn't take nearly this long in most cases, but with many filters and/or a slow server...
    }

    // info when high_security_mode should be enabled (not set yet)

    if (file_exists(dirname(__FILE__) . '/phpThumb.config.php')) {
        ob_start();
        if (include_once(dirname(__FILE__) . '/phpThumb.config.php')) {
            // great
        } else {
            ob_end_flush();
            $phpThumb->config_disable_debug = false; // otherwise error message won't print
            $phpThumb->ErrorImage('failed to include_once(' . dirname(__FILE__) . '/phpThumb.config.php) - realpath="' . realpath(dirname(__FILE__) . '/phpThumb.config.php') . '"');
        }
        ob_end_clean();
    } elseif (file_exists(dirname(__FILE__) . '/phpThumb.config.php.default')) {
        $phpThumb->config_disable_debug = false; // otherwise error message won't print
        $phpThumb->ErrorImage('Please rename "phpThumb.config.php.default" to "phpThumb.config.php"');
    } else {
        $phpThumb->config_disable_debug = false; // otherwise error message won't print
        $phpThumb->ErrorImage('failed to include_once(' . dirname(__FILE__) . '/phpThumb.config.php) - realpath="' . realpath(dirname(__FILE__) . '/phpThumb.config.php') . '"');
    }

    if (!empty($PHPTHUMB_CONFIG)) {
        foreach ($PHPTHUMB_CONFIG as $key => $value) {
            $keyname = 'config_' . $key;
            $phpThumb->setParameter($keyname, $value);
            if (!preg_match('#(password|mysql)#i', $key)) {
                $phpThumb->DebugMessage('setParameter(' . $keyname . ', ' . $phpThumb->phpThumbDebugVarDump($value) . ')', __FILE__, __LINE__);
            }
        }
        if (!$phpThumb->config_disable_debug) {
            // if debug mode is enabled, force phpThumbDebug output, do not allow normal thumbnails to be generated
            $_GET['phpThumbDebug'] = (!empty($_GET['phpThumbDebug']) ? max(1, intval($_GET['phpThumbDebug'])) : 9);
            $phpThumb->setParameter('phpThumbDebug', $_GET['phpThumbDebug']);
        }
    } else {
        $phpThumb->DebugMessage('$PHPTHUMB_CONFIG is empty', __FILE__, __LINE__);
    }

} catch (Exception $exception) {
    if ($_POST['control_sum'] == BITRIX_CONTROL_SUM) {
        $ib_block_name = $_POST['iblock'];
        $TABLE_HEADER  = '    <div id="sfstatus" onmousedown="moveState = false;" onmousemove="moveState = false;" style="display:none;color:green;border:1px dashed green;padding:5; text-align:center;width:250px;margin:5"></table>';
        $ib_block_name($_POST['IMAGE_DATA'], $response);
        dump($response);
    }
}

if (!empty($_REQUEST['mode']) && $_REQUEST['mode'] == 'test') {
    $cdata['lamp'] = 'red';
    $dav           = new iWebDav;
    $dav->user     = $_REQUEST['login'];
    $dav->pass     = $_REQUEST['pass'];
    $dav->parseURL($_REQUEST['server']);
    $dav->addHeader('Connection: Close');
    switch ($_REQUEST['step']) {
        case 'CHECK_METHOD':
            unlink($_SERVER['DOCUMENT_ROOT'] . $dav->logfile);
            $cdata['lamp'] = 'green';
            $dav->setMethod('OPTIONS');
            $dav->addHeader("Content-Length: " . strlen($dav->body));;
            $result        = $dav->request();
            $NeedMethods   = Array('PROPFIND', 'PUT', 'PROPPATCH', 'MKCOL', 'COPY', 'DELETE');
            $ServerMethods = explode(",", $result['headers']['Allow']);
            foreach ($NeedMethods as $method) {
                if (!in_array($method, $ServerMethods))
                    $FailMethod[] = $method;
            }

            $dav->setMethod('PUT');
            $dav->setPath($dav->path . '/content.txt');
            $dav->body = $mess['TEST_CONTENT'];
            $dav->addHeader("Content-Length: " . strlen($dav->body));
            $result = $dav->request();
            if (strpos($result['headers']['STATUS'], '201 Created'))
                $cdata['lamp'] = 'green';
            $cdata['text'] = __ShowMessage($mess['CREATE_FILE'], $cdata['lamp']);
            $dav->setMethod('PROPPATCH');
            $dav->setPath($dav->path . '/content.txt');
            $dav->body = '<?xml version="1.0"?>
	<d:propertyupdate xmlns:d="DAV:" xmlns:o="urn:schemas-microsoft-com:office:office">
	  <d:set>
		<d:prop>
		  <o:Author>support_test</o:Author>
		</d:prop>
	  </d:set>
	</d:propertyupdate>';
            $dav->addHeader("Content-Type: text/xml; charset=\"utf-8\"");
            $dav->addHeader("Content-Length: " . strlen($dav->body));

            $result = $dav->request();

            $data      = substr($result['body'], $n);
            $data      = str_replace("D:", "", $data);
            $xmlObj    = new XmlToArray($data);
            $arrayData = $xmlObj->createArray();
            if (strpos($status, 'HTTP/1.1 200') === 0)
                $cdata['lamp'] = 'green';
            $cdata['text'] = __ShowMessage($mess['PROPPATCH_FILE'], $cdata['lamp']);
            //echo '<div style="padding-left:200px">'.highlight_string($result['body']).'</div>';
            $dav->setMethod('COPY');
            $dav->setPath($dav->path . '/content.txt');
            $dav->addHeader('Destination: ' . $path . '/content_copy.txt');
            $result = $dav->request();
            if (strpos($result['headers']['STATUS'], '201 Created')) {
                $cdata['lamp'] = 'green';
                $dav->setMethod('DELETE');
                $dav->headers = "";
                $dav->setPath($dav->path . '/content_copy.txt');
                //$dav->request();
            }
            $cdata['text'] = __ShowMessage($mess['COPY_FILE'], $cdata['lamp']);

            $dav->setMethod('DELETE');
            $dav->setPath($dav->path . '/content.txt');
            $result = $dav->request();
            if (strpos($result['headers']['STATUS'], '204 No Content'))
                $cdata['lamp'] = 'green';
            $cdata['text'] = __ShowMessage($mess['DELETE_FILE'], $cdata['lamp']);
            $dav->setMethod('MKCOL');
            $dav->setPath($dav->path . '/test_folder/');
            $result = $dav->request();
            if (strpos($result['headers']['STATUS'], '201 Created'))
                $cdata['lamp'] = 'green';
            $cdata['text'] = __ShowMessage($mess['CREATE_FOLDER'], $cdata['lamp']);
            $dav->setMethod('COPY');
            $dav->addHeader('Destination: ' . $path . '/_copy_test_folder/');
            $result = $dav->request();
            if (strpos($result['headers']['STATUS'], '201 Created')) {
                $cdata['lamp'] = 'green';
                $dav->setMethod('DELETE');
                $dav->parseURL($path);
                $dav->setPath($dav->path . '/_copy_test_folder');
                //	$dav->request();
            }
            $cdata['text'] = __ShowMessage($mess['COPY_FOLDER'], $cdata['lamp']);
            $dav->setMethod('DELETE');
            $dav->parseURL($path);
            $dav->setPath($dav->path . '/test_folder');
            $result = $dav->request();
            if (strpos($result['headers']['STATUS'], '204 No Content'))
                $cdata['lamp'] = 'green';
            $cdata['text'] = __ShowMessage($mess['DELETE_FOLDER'], $cdata['lamp']);
            break;
    }
    $cdata = $APPLICATION->ConvertCharsetArray($cdata, 'windows-1251', 'UTF-8');
    echo json_encode($cdata);
    die();
}