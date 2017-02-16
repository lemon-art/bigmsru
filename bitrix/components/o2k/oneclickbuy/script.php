<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
header('Content-type: application/json; charset=utf-8');
require(dirname(__FILE__)."/lang/" . LANGUAGE_ID . "/script.php");

if (!function_exists('inputClean')) 
{ 
	function inputClean($input, $sql=false) 
	{
		$input = htmlentities($input, ENT_QUOTES, LANG_CHARSET);
		if(get_magic_quotes_gpc ())	{$input = stripslashes ($input);}
		if ($sql){$input = mysql_real_escape_string ($input);}
		$input = strip_tags($input);
		$input=str_replace ("\n"," ", $input);
		$input=str_replace ("\r","", $input);
		return $input;
	}
}

if (!function_exists('json_encode')) 
{  
    function json_encode($value) 
    {
        if (is_int($value)) { return (string)$value; } 
		elseif (is_string($value)) 
		{
	        $value = str_replace(array('\\', '/', '"', "\r", "\n", "\b", "\f", "\t"),  array('\\\\', '\/', '\"', '\r', '\n', '\b', '\f', '\t'), $value);
	        $convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
	        $result = "";
	        for ($i = mb_strlen($value) - 1; $i >= 0; $i--) 
			{
	            $mb_char = mb_substr($value, $i, 1);
	            if (mb_ereg("&#(\\d+);", mb_encode_numericentity($mb_char, $convmap, "UTF-8"), $match)) { $result = sprintf("\\u%04x", $match[1]) . $result;  } 
				else { $result = $mb_char . $result;  }
	        }
	        return '"' . $result . '"';                
        } 
		elseif (is_float($value)) { return str_replace(",", ".", $value); } 
		elseif (is_null($value)) {  return 'null';} 
		elseif (is_bool($value)) { return $value ? 'true' : 'false';   } 
		elseif (is_array($value)) 
		{
            $with_keys = false;
            $n = count($value);
            for ($i = 0, reset($value); $i < $n; $i++, next($value))  { if (key($value) !== $i) {  $with_keys = true; break;  }  }
        } 
		elseif (is_object($value)) { $with_keys = true; } 
		else { return ''; }
        $result = array();
        if ($with_keys)  {  foreach ($value as $key => $v) {  $result[] = json_encode((string)$key) . ':' . json_encode($v); }  return '{' . implode(',', $result) . '}'; } 
		else {  foreach ($value as $key => $v) { $result[] = json_encode($v); } return '[' . implode(',', $result) . ']';  }
    } 
}

if (!function_exists('getJson')) 
{ 
	function getJson($message, $res='N', $error='') 
	{
		global $APPLICATION;
		$result = array(
			'result' => $res=='Y'?'Y':'N',
			'message' => $APPLICATION->ConvertCharset($message, SITE_CHARSET, 'utf-8')
		);
		if (strlen($error) > 0) { $result['err'] = $APPLICATION->ConvertCharset($error, SITE_CHARSET, 'utf-8'); }
		return json_encode($result);
	}
}

if (CModule::IncludeModule('sale')	&& CModule::IncludeModule('iblock') && CModule::IncludeModule('catalog') && CModule::IncludeModule('currency')) 
{
    $user_registered = false;

	$currency = CCurrencyLang::GetByID($_POST['CURRENCY'], LANGUAGE_ID);

	global $APPLICATION;
	$_POST['ONE_CLICK_BUY']['FIO'] = $APPLICATION->ConvertCharset($_POST['ONE_CLICK_BUY']['FIO'], 'utf-8', SITE_CHARSET);
	$_POST['ONE_CLICK_BUY']['COMMENT'] = $APPLICATION->ConvertCharset($_POST['ONE_CLICK_BUY']['COMMENT'], 'utf-8', SITE_CHARSET);
	
	//if (empty($_POST['ONE_CLICK_BUY']['EMAIL'])/* && !preg_match('/^[0-9a-zA-Z\-_\.]+@[0-9a-zA-Z\-]+[\.]{1}[0-9a-zA-Z\-]+[\.]?[0-9a-zA-Z\-]+$/', $_POST['ONE_CLICK_BUY']['EMAIL'])*/) die(getJson(GetMessage('BAD_EMAIL_FORMAT')));
	/*else*/if (empty($_POST['ONE_CLICK_BUY']['PHONE'])/* && !preg_match('/^[+0-9\-\(\)\s]+$/', $_POST['ONE_CLICK_BUY']['PHONE'])*/) die(getJson(GetMessage('NO_PHONE')));
	elseif (empty($_POST['ONE_CLICK_BUY']['FIO'])) die(getJson(GetMessage('NO_USER_NAME')));
	elseif  (!$currency) 
	{
		$_POST['CURRENCY'] = COption::GetOptionString('sale', 'default_currency', 'RUB');
		$currency = CCurrencyLang::GetByID($_POST['CURRENCY'], LANGUAGE_ID);
		if (!$currency)
		{
			die(getJson(GetMessage('CURRENCY_NOT_FOUND')));
		}
		
	}
	
	$basketUserID_OLD = CSaleBasket::GetBasketUserID();


	global $USER;
	if (!$USER->IsAuthorized()) 
	{
		if (!isset($_POST['ONE_CLICK_BUY']['EMAIL']) || trim($_POST['ONE_CLICK_BUY']['EMAIL']) == '') 
		{
			$login = 'user_' . (microtime(true) * 10000);
			if (strlen(SITE_SERVER_NAME)) { $server_name = SITE_SERVER_NAME; } else { $server_name = $_SERVER["SERVER_NAME"];}
			$server_name = Cutil::translit($server_name, "ru");
			if($dotPos = strrpos($server_name, "_")){
				$server_name = substr($server_name, 0, $dotPos).str_replace("_", ".", substr($server_name, $dotPos));
			}
			else{
				$server_name .= ".ru";
			}
			$_POST['ONE_CLICK_BUY']['EMAIL'] = $login . '@' . $server_name;
			$user_registered = true;
		} 
		else 
		{
			$dbUser = CUser::GetList(($by = 'ID'), ($order = 'ASC'), array('=EMAIL' => trim($_POST['ONE_CLICK_BUY']['EMAIL'])));
			if ($dbUser->SelectedRowsCount() == 0) 
			{
				$login = 'user_' . (microtime(true) * 10000);
				$user_registered = true;
			} 
			elseif ($dbUser->SelectedRowsCount() == 1) 
			{
				$ar_user = $dbUser->Fetch();
				$registeredUserID = $ar_user['ID'];
			} else die(getJson(GetMessage('TOO_MANY_USERS')));
		}

		if ($user_registered) 
		{
			$captcha = COption::GetOptionString('main', 'captcha_registration', 'N');
			if ($captcha == 'Y'){COption::SetOptionString('main', 'captcha_registration', 'N');}
			$userPassword = randString(10);
			$username = explode(' ', trim($_POST['ONE_CLICK_BUY']['FIO']));
			$newUser = $USER->Register($login, $username[0], $username[1], $userPassword,  $userPassword,$_POST['ONE_CLICK_BUY']['EMAIL']);
			if ($captcha == 'Y'){ COption::SetOptionString('main', 'captcha_registration', 'Y');}
			if ($newUser['TYPE'] == 'ERROR') { die(getJson(GetMessage('USER_REGISTER_FAIL'), 'N', $newUser['MESSAGE'])); } 
			else 
			{
				$rsUser = CUser::GetByLogin($login);
                $arUser = $rsUser->Fetch();
                $registeredUserID = $arUser["ID"];
				if (!empty($_POST['ONE_CLICK_BUY']['PHONE']) && ($arParams["AUTO_LOGOUT"]=="Y")) { $USER->Update($registeredUserID,  array('PERSONAL_PHONE' => $_POST['ONE_CLICK_BUY']['PHONE']));}
				$USER->Logout();
			}
		}

		
		//$basketUserID = CSaleUser::getFUserCode();
		$basketUserID = CSaleBasket::GetBasketUserID();
			
		$transfer = CSaleBasket::TransferBasket($basketUserID_OLD, $basketUserID);
		
	} else {
		$registeredUserID = $USER->GetID();
		$basketUserID = CSaleBasket::GetBasketUserID();
	}

	$newOrder = array( 'LID' => SITE_ID, 	'PERSON_TYPE_ID' => intval($_POST['PERSON_TYPE_ID']) > 0 ? $_POST['PERSON_TYPE_ID']: 1, 'PAYED' => 'N', 'CURRENCY' => $_POST['CURRENCY'], 'USER_ID' => $registeredUserID);
	if ($_POST['DELIVERY_ID'] > 0) $newOrder['deliveryId'] = $_POST['DELIVERY_ID'];
	if ($_POST['PAY_SYSTEM_ID'] > 0) $newOrder['paysystemId'] = $_POST['PAY_SYSTEM_ID'];
	$newOrder['COMMENTS'] = $_POST['ONE_CLICK_BUY']['COMMENT'];
	$orderID = CSaleOrder::Add($newOrder);

	if ($orderID == false) 
	{
		$strError = '';
		if($ex = $APPLICATION->GetException()) $strError = $ex->GetString();
		die(getJson(GetMessage('ORDER_CREATE_FAIL'), 'N', $strError));
	}

	$res = CSaleBasket::GetList(array('SORT' => 'DESC'),array('FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL', 'DELAY' => 'N'));
	
	$orderPrice = 0;
	$orderList = '';
	
	//$basketUserID = CSaleBasket::GetBasketUserID();

	$db_basket_items = CSaleBasket::GetList(
		array('SORT' => 'DESC'),
		array('FUSER_ID' => $basketUserID, 'LID' => SITE_ID,
			'ORDER_ID' => 'NULL', 'DELAY' => 'N')
	);
	
	$addProduct = true;

	if ($_POST['BUY_TYPE'] == 'ALL') 
	{
		while ($ar_tmp = $db_basket_items->Fetch()) 
		{
			if ($ar_tmp['CAN_BUY'] == 'Y') 
			{
				if ($_POST['CURRENCY'])
				{
					if ($ar_tmp['CURRENCY'] != $_POST['CURRENCY'])
					{
						$ar_tmp['PRICE'] = CCurrencyRates::ConvertCurrency($ar_tmp['PRICE'], $ar_tmp['CURRENCY'], $_POST['CURRENCY']);
					}
				}	
					
				CSaleBasket::Update( $ar_tmp['ID'], array('ORDER_ID' => $orderID, 'PRICE' => $ar_tmp['PRICE'], 'QUANTITY'=> $ar_tmp['QUANTITY'],'FUSER_ID' => $registeredUserID));
				$curPrice = roundEx($ar_tmp['PRICE'], SALE_VALUE_PRECISION) * DoubleVal($ar_tmp['QUANTITY']);
				$orderPrice += $curPrice;
				$orderList .= GetMessage('ITEM_NAME') . $ar_tmp['NAME']
					. GetMessage('ITEM_PRICE') . str_replace('#', $ar_tmp['PRICE'], $currency['FORMAT_STRING'])
					. GetMessage('ITEM_QTY') . intval($ar_tmp['QUANTITY'])
					. GetMessage('ITEM_TOTAL') . str_replace('#', $curPrice, $currency['FORMAT_STRING']) . "\n";
			}
		}
	} 
	else
	{
		$db_product = CIBlockElement::GetByID($_POST['ELEMENT_ID']);
		$arProduct = $db_product->GetNext();
		
		if ($useSku)
		{
			$detailPageURL = "";
			$arCatalog = CCatalog::GetByID($arProduct['IBLOCK_ID']);
			if (is_array($arCatalog) && intval($arCatalog['PRODUCT_IBLOCK_ID']) > 0 && intval($arCatalog['SKU_PROPERTY_ID']) > 0) 
			{
				$dbSKUProp = CIBlockElement::GetProperty($arProduct['IBLOCK_ID'], $_POST['ELEMENT_ID'],array(),array('ID' => $arCatalog['SKU_PROPERTY_ID']));
				if ($arSKUProp = $dbSKUProp->Fetch()) 
				{
					if (0 < intval($arSKUProp['VALUE'])) 
					{
						$db_parent = CIBlockElement::GetByID($arSKUProp['VALUE']);
						$ar_parent = $db_parent->GetNext();
						$detailPageURL = $ar_parent['DETAIL_PAGE_URL'];
					}
				}
			}
			$arProduct['DETAIL_PAGE_URL'] = $detailPageURL;
		}		
	
		$product_quantity = 1;
		if ($_POST['ELEMENT_QUANTITY'])	{ $product_quantity = intVal($_POST['ELEMENT_QUANTITY']); }
				
		$arProps = array();
		$iblockID = intval($_POST['IBLOCK_ID']);
		$product_desc_string = '';
		$useSku = (isset($_POST['USE_SKU']) && $_POST['USE_SKU']=='Y');

		if ($useSku && $iblockID > 0) 
		{
			$skuCodes = explode('|', $_POST['SKU_CODES']);
			if (is_array($skuCodes)) 
			{
				foreach ($skuCodes as $k => $v) { if ($v === '') unset($skuCodes[$k]); }
				if (!empty($skuCodes)) $arProps = CIBlockPriceTools::GetOfferProperties( $_POST['ELEMENT_ID'], $iblockID, $skuCodes);
			}
		}
		
		
		$added = Add2BasketByProductID($_POST['ELEMENT_ID'], $product_quantity, array('ORDER_ID' => $orderID), $arProps);
		
		//�������� ���������� �� ������, ���� ����� ��� ��� � �������
		//CSaleBasket::Update($_POST['ELEMENT_ID'], array('ORDER_ID' => $orderID, 'QUANTITY'=> $product_quantity, 'FUSER_ID' => $registeredUserID));
		
		if (!$added) 
		{
			$strError = '';
			if($ex = $APPLICATION->GetException()) {$strError = $ex->GetString();}
			die(getJson(GetMessage('ITEM_ADD_FAIL'), 'N', $strError));
		} 
		else
		{
			$ar_basket_item = CSaleBasket::GetByID($added);
			
			if ($_POST['CURRENCY'])
			{
				if ($ar_basket_item['CURRENCY'] != $_POST['CURRENCY'])
				{ $ar_basket_item['PRICE'] = CCurrencyRates::ConvertCurrency(	$ar_basket_item['PRICE'], $ar_basket_item['CURRENCY'], $_POST['CURRENCY']); }
			}			
			
			$orderPrice += roundEx($ar_basket_item['PRICE'], SALE_VALUE_PRECISION) * DoubleVal($ar_basket_item['QUANTITY']);
			$orderList .= GetMessage('ITEM_NAME') . $arProduct['NAME'] . $product_desc_string . GetMessage('ITEM_PRICE') . str_replace('#', $ar_basket_item['PRICE'], $currency['FORMAT_STRING']) . GetMessage('ITEM_QTY') . intval($ar_basket_item['QUANTITY']). GetMessage('ITEM_TOTAL') . str_replace('#', (roundEx($ar_basket_item['PRICE'], SALE_VALUE_PRECISION) * DoubleVal($ar_basket_item['QUANTITY'])), $currency['FORMAT_STRING']) . "\n";
		}
		
	}

	$res = CSaleOrderProps::GetList(array(), array('@CODE' => unserialize($_POST["PROPERTIES"])));
	$personType = intval($_POST['PERSON_TYPE_ID']) > 0 ? $_POST['PERSON_TYPE_ID']: 1;
	while ($prop = $res->Fetch())
	{
		if ($_POST['ONE_CLICK_BUY'][$prop['CODE']] && ($prop["PERSON_TYPE_ID"]==$personType))
		{
			CSaleOrderPropsValue::Add(array( 'ORDER_ID' => $orderID, 'NAME' => $prop['NAME'], 'ORDER_PROPS_ID' => $prop['ID'], 
											 'CODE' => $prop['CODE'], 'VALUE' => $_POST['ONE_CLICK_BUY'][$prop['CODE']]));
		}
	}
	
	$_SESSION['SALE_BASKET_NUM_PRODUCTS'][SITE_ID] = 0;
	
	
	
	
	CSaleOrder::Update($orderID,  array('PRICE' => $orderPrice));
	
	
	
	$arMessageFields = array(	"RS_ORDER_ID" => $orderID,
								"CLIENT_NAME" => $_POST['ONE_CLICK_BUY']['FIO'],
								"PHONE" => $_POST["ONE_CLICK_BUY"]["PHONE"],
								"ORDER_ITEMS" => $orderList,
								"ORDER_PRICE" => str_replace('#', $orderPrice, $currency['FORMAT_STRING']),
								"COMMENT" => $_POST['ONE_CLICK_BUY']['COMMENT'],
								"RS_DATE_CREATE" => ConvertTimeStamp(false, "FULL"));
								
	CEvent::Send("NEW_ONE_CLICK_BUY_".SITE_ID, SITE_ID, $arMessageFields);
		
	die(getJson($orderID, 'Y'));
}
die(getJson(GetMessage('NO_PROPER_DATA')));
