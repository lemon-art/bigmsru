<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (CModule::IncludeModule('iblock') && CModule::IncludeModule('catalog'))
{
	//if ((intval($arParams['IBLOCK_ID']) == 0) || (intval($arParams['PRICE_ID']) == 0))  return;
	if (intval($arParams['CACHE_TIME']) < 0) { $arParams['CACHE_TIME'] = 36000;}
	if (!$arParams['SEF_FOLDER']) { $arParams['SEF_FOLDER'] = '/catalog/';}
	if (!strlen($arParams['DEFAULT_CURRENCY']) == 3) { $arParams['DEFAULT_CURRENCY'] = COption::GetOptionString('sale', 'default_currency', 'RUB');}
	if (empty($arParams['PROPERTIES'])) { $arParams['PROPERTIES'] = array('USER_NAME', 'PHONE', 'EMAIL');}
	if (empty($arParams['REQUIRED'])) { $arParams['REQUIRED'] = array('USER_NAME', 'PHONE');}

	$arParams['ELEMENT_ID'] = intval($arParams['ELEMENT_ID']);
	$arParams['PAGE_URI'] = $APPLICATION->GetCurPage();

	if ($this->StartResultCache()) 
	{
		$arResult['ERRORS'] = array();

		if ($arParams['ELEMENT_ID'] < 1) 
		{	
			$elementUrl = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'DETAIL_PAGE_URL');
			$replace_str = strpos($elementUrl, '#SITE_DIR#') !== false ? '#SITE_DIR#' . $arParams['SEF_FOLDER'] : $arParams['SEF_FOLDER'];
			$elementUrl = str_replace($replace_str, '', $elementUrl);
			$arUrlTemplates = array('sections' => '','section' => '#SECTION_CODE#/','element' => $elementUrl,'compare' => 'compare/');

			if (strpos($elementUrl, '#ELEMENT_CODE#') !== false	|| strpos($elementUrl, '#CODE#') !== false)
			{
				$arVariables = array();
				$page = CComponentEngine::ParseComponentPath($arParams['SEF_FOLDER'], $arUrlTemplates, $arVariables);
				if ((isset($arVariables['ELEMENT_CODE']) && !empty($arVariables['ELEMENT_CODE']))|| (isset($arVariables['CODE']) && !empty($arVariables['CODE']))) 
				{
					if (isset($arVariables['ELEMENT_CODE'])) {$code = $arVariables['ELEMENT_CODE'];} else {$code = $arVariables['CODE'];}
				
					$res = CIBlockElement::GetList(	array('SORT' => 'ASC'),	array('ACTIVE' => 'Y','IBLOCK_ID' => $arParams['IBLOCK_ID'],'=CODE' => $code));
					if ($res->SelectedRowsCount() == 1) 
					{
						$arItem = $res->Fetch();
						$arParams['ELEMENT_ID'] = $arItem['ID'];
						$arParams['ELEMENT_NAME'] = $arItem['NAME'];
					} else {$this->AbortResultCache();	return;}
				} else {$this->AbortResultCache();	return;	}
			} 
			elseif (strpos($elementUrl, '#ELEMENT_ID#') !== false	|| strpos($elementUrl, '#ID#') !== false) 
			{
				$arVariables = array();
				$page = CComponentEngine::ParseComponentPath($arParams['SEF_FOLDER'], $arUrlTemplates, $arVariables);
				if (isset($arVariables['ELEMENT_ID']) && $arVariables['ELEMENT_ID'] > 0)
				{ $arParams['ELEMENT_ID'] = (int) $arVariables['ELEMENT_ID'];} 
				elseif (isset($arVariables['ID']) && $arVariables['ID'] > 0) 
				{$arParams['ELEMENT_ID'] = (int) $arVariables['ID'];} 
				else { $this->AbortResultCache();	return;	}
			} 
			else 
			{ 
				$this->AbortResultCache();	//return;	
			}
		}

		if (empty($arResult['ERRORS'])) 
		{
			if ($USER->IsAuthorized()) 
			{
				if (!isset($_SESSION['ONECLICKBUY_USER_PHONE'])) 
				{
					global $USER;
					$dbUser = $USER->GetByID($USER->GetID());
					$arUser = $dbUser->Fetch();
					$_SESSION['ONECLICKBUY_USER_PHONE'] = $arUser['PERSONAL_PHONE'];
				}
				$arResult['USER_PHONE'] = $_SESSION['ONECLICKBUY_USER_PHONE'];
			} else {$arResult['USER_PHONE'] = '';}
			
			if ($arParams['USE_SKU']!="Y" && $arParams['USE_QUANTITY']=="Y") 
			{
				$arProduct = CCatalogProduct::GetById($arParams['ELEMENT_ID']);
				if ($arProduct['QUANTITY'] < 1) 
				{
					$this->AbortResultCache(); //return;
				}
			}

			if ($arParams['USE_SKU']=="Y" && $arParams['ELEMENT_ID'] > 0 && $arParams['SKU_PROPERTIES_CODES']) 
			{
				if (!$arParams['ELEMENT_NAME']) 
				{
					$res = CIBlockElement::GetByID($arParams['ELEMENT_ID']);
					if ($arItem = $res->GetNext()) { $arParams['ELEMENT_NAME'] = $arItem['NAME']; }	
				}

				$arResult['SKU_PROPERTIES_STRING'] = implode('|', $arParams['SKU_PROPERTIES_CODES']);
				$arPrice = CCatalogGroup::GetById($arParams['PRICE_ID']);
				$arPrices = CIBlockPriceTools::GetCatalogPrices($arParams['IBLOCK_ID'], array($arPrice['NAME']));
				
				if (intval($arParams['SKU_COUNT'])>0) { $count = intval($arParams['SKU_COUNT']);} else { $count=false;}
				$arOffers = CIBlockPriceTools::GetOffersArray($arParams['IBLOCK_ID'],	$arParams['ELEMENT_ID'], array('ID' => 'DESC'), array(), $arParams['SKU_PROPERTIES_CODES'], $count,	$arPrices,	false);
				
				foreach($arOffers as $arOffer)
				{
					if ($arParams['USE_QUANTITY']!="Y" || $arOffer['CATALOG_QUANTITY'] > 0)
					{ 
						$offer = $arParams['ELEMENT_NAME'] . '(';
						foreach ($arParams['SKU_PROPERTIES_CODES'] as $property) 
						{
							if (array_key_exists($property, $arOffer['PROPERTIES'])) 
							{
								$propertyData = $arOffer['PROPERTIES'][$property];
								switch($propertyData['PROPERTY_TYPE']) 
								{
									case 'L':
										if (!empty($propertyData['VALUE']))
											$offer .= $propertyData['NAME'] . ': ' . $propertyData['VALUE'] . ', ';
										break;
									case 'G':
										break;
									default:
										break;
								}
							}
						}
						$arResult['OFFERS'][$arOffer['ID']] = substr($offer, 0, strlen($offer)-2) . ')';; 
					}
				}
				if (!count($arResult['OFFERS'])) 
				{ 
					$this->AbortResultCache();	//return;	
				}
			}
			$arResult['SCRIPT_PATH'] = substr(str_replace('\\', '/', dirname(__FILE__)), strlen(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'])));
		}
		$this->IncludeComponentTemplate();
	}
}
?>