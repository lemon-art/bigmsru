<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$cp = $this->__component;
if (is_object($cp))
{
	CModule::IncludeModule('iblock');

	if(empty($arResult['ERRORS']['FATAL']))
	{

		$hasDiscount = false;
		$hasProps = false;
		$productSum = 0;
		$basketRefs = array();

		$noPict = array(
			'SRC' => $this->GetFolder().'/images/no_photo.png'
		);

		if(is_readable($nPictFile = $_SERVER['DOCUMENT_ROOT'].$noPict['SRC']))
		{
			$noPictSize = getimagesize($nPictFile);
			$noPict['WIDTH'] = $noPictSize[0];
			$noPict['HEIGHT'] = $noPictSize[1];
		}

		$arProducts = Array();
		foreach($arResult["BASKET"] as $k => &$prod)
		{
			if(floatval($prod['DISCOUNT_PRICE']))
				$hasDiscount = true;

			$arProducts[] = $prod['PRODUCT_ID'];
			
			
			// move iblock props (if any) to basket props to have some kind of consistency
			if(isset($prod['IBLOCK_ID']))
			{
				$iblock = $prod['IBLOCK_ID'];
				if(isset($prod['PARENT']))
					$parentIblock = $prod['PARENT']['IBLOCK_ID'];

				foreach($arParams['CUSTOM_SELECT_PROPS'] as $prop)
				{
					$key = $prop.'_VALUE';
					if(isset($prod[$key]))
					{
						// in the different iblocks we can have different properties under the same code
						if(isset($arResult['PROPERTY_DESCRIPTION'][$iblock][$prop]))
							$realProp = $arResult['PROPERTY_DESCRIPTION'][$iblock][$prop];
						elseif(isset($arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop]))
							$realProp = $arResult['PROPERTY_DESCRIPTION'][$parentIblock][$prop];
						
						if(!empty($realProp))
							$prod['PROPS'][] = array(
								'NAME' => $realProp['NAME'], 
								'VALUE' => htmlspecialcharsEx($prod[$key])
							);
					}
				}
			}

			// if we have props, show "properties" column
			if(!empty($prod['PROPS']))
				$hasProps = true;

			$productSum += $prod['PRICE'] * $prod['QUANTITY'];

			$basketRefs[$prod['PRODUCT_ID']][] =& $arResult["BASKET"][$k];

			if(!isset($prod['PICTURE']))
				$prod['PICTURE'] = $noPict;
		}

		$arProdInfo = Array();
		$count = 0;
		$arFilter = Array(
			"IBLOCK_ID"=> 10, 
			"ID"	=> $arProducts
		);
		$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID", "PROPERTY_CML2_ARTICLE", "PROPERTY_CML2_TRAITS"));
		while( $ar_fields = $res->GetNext()) {
		
			$arProdInfo[ $ar_fields['ID'] ]['ARTICLE'] = $ar_fields['PROPERTY_CML2_ARTICLE_VALUE'];
			$count++;
			
			if ( $count == 3 ) {
				$arProdInfo[ $ar_fields['ID'] ]['CODE'] = $ar_fields['PROPERTY_CML2_TRAITS_VALUE'];
				
			}
			if ( $count == 4 ) {
				$count = 0;
			}
		
		}
		
		$arResult['PROD_INFO'] = $arProdInfo;
		
		
		$arResult['HAS_DISCOUNT'] = $hasDiscount;
		$arResult['HAS_PROPS'] = $hasProps;

		$arResult['PRODUCT_SUM_FORMATTED'] = SaleFormatCurrency($productSum, $arResult['CURRENCY']);

		if($img = intval($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE_ID']))
		{

			$pict = CFile::ResizeImageGet($img, array(
				'width' => 150,
				'height' => 90
			), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);

			if(strlen($pict['src']))
				$pict = array_change_key_case($pict, CASE_UPPER);

			$arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'] = $pict;
		}

	}
}
?>