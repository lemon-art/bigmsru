<?php
use Bitrix\Main,
	Bitrix\Main\Application,
	Bitrix\Catalog\CatalogViewedProductTable,
	Bitrix\Main\Localization\Loc as Loc,
	Bitrix\Main\SystemException;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

CBitrixComponent::includeComponentClass("bitrix:sale.bestsellers");

class CatalogBigdataProductsComponent extends CSaleBestsellersComponent
{
	protected $rcmParams;
	protected $ajaxItemsIds;
	protected $recommendationIdToProduct = array();

	/**
	 * Prepare Component Params
	 *
	 * @param array $params
	 * @return array
	 */
	public function onPrepareComponentParams($params)
	{
		global $APPLICATION;

		if (!isset($params['RCM_CUR_BASE_PAGE']))
		{
			$params['RCM_CUR_BASE_PAGE'] = $APPLICATION->GetCurPage();
		}

		// uniq identifier for the component on the page
		if (!isset($params['UNIQ_COMPONENT_ID']))
		{
			$params['UNIQ_COMPONENT_ID'] = 'bigdata_recommended_products_'.$this->randString();
		}

		// remember src params for further ajax query
		$this->arResult['_ORIGINAL_PARAMS'] = $params;

		// bestselling
		$params['FILTER'] = array('PAYED');
		$params['PERIOD'] = 30;

		return parent::onPrepareComponentParams($params);
	}

	/**
	 * set prices for all items
	 * @return array currency list
	 */
	protected function setItemsPrices()
	{
		parent::setItemsPrices();

		// rewrite urls
		foreach ($this->items as &$item)
		{	// ajax mode only - get from signed parameters
			$item["~BUY_URL"] = $this->getPageParam(
				$this->arParams['RCM_CUR_BASE_PAGE'], $this->arParams["ACTION_VARIABLE"] . "=BUY&" . $this->arParams["PRODUCT_ID_VARIABLE"] . "=" . $item["ID"], array($this->arParams["PRODUCT_ID_VARIABLE"], $this->arParams["ACTION_VARIABLE"])
			);
			$item["~ADD_URL"] = $this->getPageParam(
				$this->arParams['RCM_CUR_BASE_PAGE'], $this->arParams["ACTION_VARIABLE"] . "=ADD2BASKET&" . $this->arParams["PRODUCT_ID_VARIABLE"] . "=" . $item["ID"], array($this->arParams["PRODUCT_ID_VARIABLE"], $this->arParams["ACTION_VARIABLE"])
			);
			$item["~COMPARE_URL"] = $this->getPageParam(
				$this->arParams['RCM_CUR_BASE_PAGE'], "action=ADD_TO_COMPARE_LIST&id=" . $item["ID"], array("action", "id")
			);
			$item["~SUBSCRIBE_URL"] = $this->getPageParam(
				$this->arParams['RCM_CUR_BASE_PAGE'], $this->arParams["ACTION_VARIABLE"] . "=SUBSCRIBE_PRODUCT&" . $this->arParams["PRODUCT_ID_VARIABLE"] . "=" . $item["ID"], array($this->arParams["PRODUCT_ID_VARIABLE"], $this->arParams["ACTION_VARIABLE"])
			);

			$item["BUY_URL"] = htmlspecialcharsbx($item["~BUY_URL"]);
			$item["ADD_URL"] = htmlspecialcharsbx($item["~ADD_URL"]);
			$item["COMPARE_URL"] = htmlspecialcharsbx($item["~COMPARE_URL"]);
			$item["SUBSCRIBE_URL"] = htmlspecialcharsbx($item["~SUBSCRIBE_URL"]);
		}
	}

	/**
	 * Add offers for each catalog product.
	 * @return void
	 */
	protected function setItemsOffers()
	{
		parent::setItemsOffers();

		foreach ($this->items as &$item)
		{
			if (!empty($item['OFFERS']) && is_array($item['OFFERS']))
			{
				foreach ($item['OFFERS'] as &$offer)
				{
					$offer["~BUY_URL"] = $this->getPageParam(
						$this->arParams['RCM_CUR_BASE_PAGE'], $this->arParams["ACTION_VARIABLE"] . "=BUY&" . $this->arParams["PRODUCT_ID_VARIABLE"] . "=" . $offer["ID"], array($this->arParams["PRODUCT_ID_VARIABLE"], $this->arParams["ACTION_VARIABLE"])
					);

					$offer["~ADD_URL"] = $this->getPageParam(
						$this->arParams['RCM_CUR_BASE_PAGE'], $this->arParams["ACTION_VARIABLE"] . "=ADD2BASKET&" . $this->arParams["PRODUCT_ID_VARIABLE"] . "=" . $offer["ID"], array($this->arParams["PRODUCT_ID_VARIABLE"], $this->arParams["ACTION_VARIABLE"])
					);

					$offer["~COMPARE_URL"] = $this->getPageParam(
						$this->arParams['RCM_CUR_BASE_PAGE'], "action=ADD_TO_COMPARE_LIST&id=" . $offer["ID"], array($this->arParams["PRODUCT_ID_VARIABLE"], $this->arParams["ACTION_VARIABLE"])
					);

					$offer["~SUBSCRIBE_URL"] = $this->getPageParam(
						$this->arParams['RCM_CUR_BASE_PAGE'], $this->arParams["ACTION_VARIABLE"] . "=SUBSCRIBE_PRODUCT&id=" . $offer["ID"], array($this->arParams["PRODUCT_ID_VARIABLE"], $this->arParams["ACTION_VARIABLE"])
					);

					$offer["BUY_URL"] = htmlspecialcharsbx($offer["~BUY_URL"]);
					$offer["ADD_URL"] = htmlspecialcharsbx($offer["~ADD_URL"]);
					$offer["COMPARE_URL"] = htmlspecialcharsbx($offer["~COMPARE_URL"]);
					$offer["SUBSCRIBE_URL"] = htmlspecialcharsbx($offer["~SUBSCRIBE_URL"]);
				}
			}
		}
	}

	protected function getPageParam($sUrlPath, $strParam="", $arParamKill=array(), $get_index_page=null)
	{
		$strNavQueryString = DeleteParam($arParamKill);
		if($strNavQueryString <> "" && $strParam <> "")
			$strNavQueryString = "&".$strNavQueryString;
		if($strNavQueryString == "" && $strParam == "")
			return $sUrlPath;
		else
			return $sUrlPath."?".$strParam.$strNavQueryString;
	}

	protected function getProductIds()
	{
		$ids = array();

		// try cloud
		if (!empty($this->ajaxItemsIds))
		{
			$recommendationId = Main\Context::getCurrent()->getRequest()->get('RID');
			$ids = $this->ajaxItemsIds;
			$ids = $this->filterByParams($ids);
			$ids = $this->filterByAvailability($ids);

			foreach ($ids as $id)
			{
				$this->recommendationIdToProduct[$id] = $recommendationId;
			}
		}

		// try bestsellers
		if (count($ids) < $this->arParams['PAGE_ELEMENT_COUNT'])
		{
			// increase element count
			$this->arParams['PAGE_ELEMENT_COUNT'] = $this->arParams['PAGE_ELEMENT_COUNT']*10;
			$bestsellers = parent::getProductIds();
			$this->arParams['PAGE_ELEMENT_COUNT'] = $this->arParams['PAGE_ELEMENT_COUNT']/10;

			if (!empty($bestsellers))
			{
				$recommendationId = 'bestsellers';
				$bestsellers = Main\Analytics\Catalog::getProductIdsByOfferIds($bestsellers);
				$bestsellers = $this->filterByParams($bestsellers);
				$bestsellers = $this->filterByAvailability($bestsellers);

				foreach ($bestsellers as $id)
				{
					if (!isset($this->recommendationIdToProduct[$id]))
					{
						$this->recommendationIdToProduct[$id] = $recommendationId;
					}
				}

				$ids = array_unique(array_merge($ids, $bestsellers));
			}
		}

		// try top viewed
		if (count($ids) < $this->arParams['PAGE_ELEMENT_COUNT'])
		{
			$recommendationId = 'mostviewed';
			$duplicate = array();
			$mostviewed = array();

			$result = CatalogViewedProductTable::getList(array(
				'select' => array(
					'ELEMENT_ID',
					new Main\Entity\ExpressionField('SUM_HITS', 'SUM(%s)', 'VIEW_COUNT')
				),
				'filter' => array('=SITE_ID' => $this->getSiteId(), '>ELEMENT_ID' => 0),
				'order' => array('SUM_HITS' => 'DESC'),
				'limit' => $this->arParams['PAGE_ELEMENT_COUNT']*10
			));

			while ($row = $result->fetch())
			{
				if (!isset($duplicate[$row['ELEMENT_ID']]))
					$mostviewed[] = $row['ELEMENT_ID'];
				$duplicate[$row['ELEMENT_ID']] = true;
			}
			unset($row, $result, $duplicate);

			$mostviewed = $this->filterByParams($mostviewed);
			$mostviewed = $this->filterByAvailability($mostviewed);

			foreach ($mostviewed as $id)
			{
				if (!isset($this->recommendationIdToProduct[$id]))
				{
					$this->recommendationIdToProduct[$id] = $recommendationId;
				}
			}

			$ids = array_unique(array_merge($ids, $mostviewed));
		}

		// limit
		$ids = array_slice($ids, 0, $this->arParams['PAGE_ELEMENT_COUNT']);

		return $ids;
	}

	protected function filterByParams($ids)
	{
		if (empty($ids))
		{
			return array();
		}

		$ids = array_values(array_unique($ids));

		// remove duplicate of current item
		if (!empty($this->arParams['ID']) && in_array($this->arParams['ID'], $ids))
		{
			$key = array_search($this->arParams['ID'], $ids);
			if ($key !== false)
			{
				unset($ids[$key]);
				$ids = array_values($ids);
			}
		}

		if ($this->arParams['SHOW_FROM_SECTION'] != 'Y')
		{
			return $ids;
		}

		// filtering by section
		$sectionSearch = $this->arParams["SECTION_ID"] > 0 || $this->arParams["SECTION_CODE"] !== '';

		if ($sectionSearch)
			$sectionId = ($this->arParams["SECTION_ID"] > 0) ? $this->arParams["SECTION_ID"] : $this->getSectionIdByCode($this->arParams["SECTION_CODE"]);
		else
			$sectionId = $this->getSectionIdByElement($this->arParams["SECTION_ELEMENT_ID"], $this->arParams["SECTION_ELEMENT_CODE"]);

		$map = $this->executeParametersFilter(
			$ids,
			$this->arParams['IBLOCK_ID'],
			$sectionId,
			$this->arParams['SECTION_ELEMENT_ID'],
			$this->arParams['PAGE_ELEMENT_COUNT'],
			$this->arParams['DEPTH']
		);

		return $map;
	}

	protected function filterByAvailability($ids)
	{
		if (!empty($ids) && $this->arParams['HIDE_NOT_AVAILABLE'] == 'Y')
		{
			$filter = (count($ids) > 1000 ? array('ID' => $ids) : array('@ID' => $ids));
			$ids = array_fill_keys($ids, true);
			$productIterator = CCatalogProduct::GetList(
				array(),
				$filter,
				false,
				false,
				array('ID', 'QUANTITY', 'QUANTITY_TRACE', 'CAN_BUY_ZERO')
			);
			while ($product = $productIterator->Fetch())
			{
				if (isset($ids[$product['ID']]) && !CCatalogProduct::isAvailable($product))
					unset($ids[$product['ID']]);
			}
			unset($product, $productIterator, $filter);
			$ids = array_keys($ids);
		}

		return $ids;
	}

	/**
	 * @see \Bitrix\Catalog\CatalogViewedProductTable::getProductSkuMap
	 *
	 * @param      $productIds
	 * @param      $iblockId
	 * @param      $sectionId
	 * @param      $excludeProductId
	 * @param      $limit
	 * @param int  $depth
	 * @param null $siteId
	 *
	 * @return array
	 */
	protected function executeParametersFilter($productIds, $iblockId, $sectionId, $excludeProductId, $limit, $depth = 0, $siteId = null)
	{
		$map = array();

		$iblockId = (int)$iblockId;
		$sectionId = (int)$sectionId;
		$excludeProductId = (int)$excludeProductId;
		$limit = (int)$limit;
		$depth = (int)$depth;
		if ($depth < 0)
			return $map;

		if (empty($siteId))
		{
			$context = Application::getInstance()->getContext();
			$siteId = $context->getSite();
		}
		if (empty($siteId))
			return $map;

		$con = Application::getConnection();

		$subSections = array();
		//TODO: change sql to api
		if ($depth > 0)
		{
			$strSql = "SELECT BSprS.ID AS ID
						FROM b_iblock_section BSprS
							INNER JOIN b_iblock_section BS1
							ON (
								BSprS.IBLOCK_ID = BS1.IBLOCK_ID
								AND BSprS.LEFT_MARGIN <= BS1.LEFT_MARGIN
								AND BSprS.RIGHT_MARGIN >= BS1.RIGHT_MARGIN
							)
						WHERE BS1.ID = ".$sectionId." AND BSprS.DEPTH_LEVEL = " .$depth;

			$result = $con->query($strSql, null);
			while ($item = $result->fetch())
				$subSections[] = $item['ID'];
		}
		if (!empty($subSections))
			$subSections[] = 0;

		if (empty($subSections) && $sectionId <= 0)
		{
			$strSql = "SELECT ID
					FROM b_iblock_element BE
					WHERE BE.ID IN (".join(', ', array_map("intval", $productIds)).")
						AND BE.ID <> ".$excludeProductId."
						AND BE.IBLOCK_ID = ".$iblockId."
						AND (BE.WF_STATUS_ID = 1 AND BE.WF_PARENT_ELEMENT_ID IS NULL)";
		}
		else
		{
			$strSql = "SELECT ID
					FROM b_iblock_element BE
						INNER JOIN (
							SELECT DISTINCT BSE.IBLOCK_ELEMENT_ID
							FROM b_iblock_section_element BSE
								INNER JOIN b_iblock_section BSubS ON BSE.IBLOCK_SECTION_ID = BSubS.ID
								INNER JOIN b_iblock_section BS ON (BSubS.IBLOCK_ID = BS.IBLOCK_ID
									AND BSubS.LEFT_MARGIN >= BS.LEFT_MARGIN
									AND BSubS.RIGHT_MARGIN <= BS.RIGHT_MARGIN)
							WHERE ".(!empty($subSections) ? "BS.ID IN (".implode(', ', $subSections).") OR " : "").
								"BS.ID = ".$sectionId."
						) BES ON BES.IBLOCK_ELEMENT_ID = BE.ID

					WHERE BE.ID IN (".join(', ', array_map("intval", $productIds)).")
						AND BE.ID <> ".$excludeProductId."
						AND BE.IBLOCK_ID = ".$iblockId."
						AND (BE.WF_STATUS_ID = 1 AND BE.WF_PARENT_ELEMENT_ID IS NULL)";
		}
		$result = $con->query($strSql, null, 0, $limit);

		$map = array();

		while($item = $result->fetch())
			$map[] = $item['ID'];

		return $map;
	}

	/**
	 * Extract data from cache. No action by default.
	 * @return bool
	 */
	protected function extractDataFromCache()
	{
		if($this->arParams['CACHE_TYPE'] == 'N')
			return false;

		return !($this->startResultCache(false, $this->getAdditionalCacheId(), '/'.$this->getSiteId().'/bitrix/catalog.bigdata.products/common'));
	}

	protected function getAdditionalCacheId()
	{
		$rcmParams = $this->rcmParams;

		// cut productid from non-product recommendations
		if ($rcmParams['op'] == 'sim_domain_items' || $rcmParams['op'] == 'recommend')
		{
			unset($this->arParams['ID'], $this->arParams['~ID']);
		}

		// cut userid from non-personal recommendations
		if ($rcmParams['op'] == 'sim_domain_items' || $rcmParams['op'] == 'simitems')
		{
			unset($rcmParams['uid']);
		}

		return $rcmParams;
	}

	protected function getServiceRequestParamsByType($type)
	{
		$a = array(
			'uid' => $_COOKIE['BX_USER_ID'],
			'aid' => \Bitrix\Main\Analytics\Counter::getAccountId(),
			'count' => max($this->arParams['PAGE_ELEMENT_COUNT']*2, 30)
		);

		// random choices
		if ($type == 'any_similar')
		{
			$possible = array('similar_sell', 'similar_view', 'similar');
			$type = $possible[array_rand($possible)];
		}
		elseif ($type == 'any_personal')
		{
			$possible = array('bestsell', 'personal');
			$type = $possible[array_rand($possible)];
		}
		elseif ($type == 'any')
		{
			$possible = array('similar_sell', 'similar_view', 'similar', 'bestsell', 'personal');
			$type = $possible[array_rand($possible)];
		}

		// configure
		if ($type == 'bestsell')
		{
			$a['op'] = 'sim_domain_items';
			$a['type'] = 'order';
			$a['domain'] = Bitrix\Main\Context::getCurrent()->getServer()->getHttpHost();
		}
		elseif ($type == 'personal')
		{
			$a['op'] = 'recommend';
		}
		elseif ($type == 'similar_sell')
		{
			$a['op'] = 'simitems';
			$a['eid'] = $this->arParams['ID'];
			$a['type'] = 'order';
		}
		elseif ($type == 'similar_view')
		{
			$a['op'] = 'simitems';
			$a['eid'] = $this->arParams['ID'];
			$a['type'] = 'view';
		}
		elseif ($type == 'similar')
		{
			$a['op'] = 'simitems';
			$a['eid'] = $this->arParams['ID'];
		}
		else
		{
			// unkonwn type, personal by default
			$a['op'] = 'recommend';
		}

		// get iblocks
		$iblocks = array();

		if (!empty($this->arParams['IBLOCK_ID']))
		{
			$iblocks = array($this->arParams['IBLOCK_ID']);
		}
		else
		{
			$iblockList = array();
			/* catalog */
			$iblockIterator = \Bitrix\Catalog\CatalogIblockTable::getList(array(
				'select' => array('IBLOCK_ID', 'PRODUCT_IBLOCK_ID')
			));
			while ($iblock = $iblockIterator->fetch())
			{
				$iblock['IBLOCK_ID'] = (int)$iblock['IBLOCK_ID'];
				$iblock['PRODUCT_IBLOCK_ID'] = (int)$iblock['PRODUCT_IBLOCK_ID'];
				$iblockList[$iblock['IBLOCK_ID']] = $iblock['IBLOCK_ID'];
				if ($iblock['PRODUCT_IBLOCK_ID'] > 0)
					$iblockList[$iblock['PRODUCT_IBLOCK_ID']] = $iblock['PRODUCT_IBLOCK_ID'];
			}

			/* iblock */
			$iblockIterator = \Bitrix\Iblock\IblockSiteTable::getList(array(
				'select' => array('IBLOCK_ID'),
				'filter' => array('@IBLOCK_ID' => $iblockList, '=SITE_ID' => $this->getSiteId())
			));
			while ($iblock = $iblockIterator->fetch())
			{
				$iblocks[] = $iblock['IBLOCK_ID'];
			}
		}

		$a['ib'] = join('.', $iblocks);

		return $a;
	}

	/**
	 * Check action variable.
	 *
	 * @param array $params			Component params.
	 * @return string
	 */
	protected function prepareActionVariable($params)
	{
		$actionVariable = (isset($params['ACTION_VARIABLE']) ? trim($params['ACTION_VARIABLE']) : '');
		if ($actionVariable === '' || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $actionVariable))
			$actionVariable = 'action_cbdp';
		return $actionVariable;
	}

	/**
	 * Get additional data for cache
	 *
	 * @return array
	 */
	protected function getAdditionalRefereneces()
	{
		return array();
	}

	/**
	 * Start Component
	 */
	public function executeComponent()
	{
		global $APPLICATION;

		$context = Main\Context::getCurrent();

		// mark usage
		$lastUsage = Main\Config\Option::get('main', 'rcm_component_usage', 0);

		if ($lastUsage == 0 || (time() - $lastUsage) > 3600)
		{
			Main\Config\Option::set('main', 'rcm_component_usage', time());
		}

		// execute
		try
		{
			$this->checkModules();
		}
		catch (SystemException $e)
		{
			ShowError($e->getMessage());
			return;
		}

		$this->processRequest();

		// define what to do and check cache
		$this->rcmParams = $this->getServiceRequestParamsByType($this->arParams['RCM_TYPE']);
		$showByIds = ($context->getServer()->getRequestMethod() == 'POST' && $context->getRequest()->getPost('rcm') == 'yes');

		if (!$showByIds)
		{
			// check if ids are already in cache
			try
			{
				if (!$this->extractDataFromCache())
				{
					// echo js for requesting items from recommendation service
					$this->arResult['REQUEST_ITEMS'] = true;
					$this->arResult['RCM_PARAMS'] = $this->rcmParams;
					$this->arResult['RCM_TEMPLATE'] = $this->getTemplateName();

					// abort cache, we will write it on next request with the same parameters
					$this->abortDataCache();

					// clear cache for ajax call
					if (Main\Context::getCurrent()->getRequest()->get('clear_cache') == 'Y')
					{
						$this->clearResultCache($this->getAdditionalCacheId(), '/'.$this->getSiteId().'/bitrix/catalog.bigdata.products/common');
					}

					$this->includeComponentTemplate();

					$this->setResultCacheKeys(array());
				}

				// show cache and die
				return null;
			}
			catch (SystemException $e)
			{
				$this->abortDataCache();

				if ($this->isAjax())
				{
					$APPLICATION->restartBuffer();
					echo CUtil::PhpToJSObject(array('STATUS' => 'ERROR', 'MESSAGE' => $e->getMessage()));
					die();
				}

				ShowError($e->getMessage());
			}
		}

		if ($showByIds)
		{
			// we have an ajax query to get items html
			// and there was no cache
			$ajaxItemIds = $context->getRequest()->get('AJAX_ITEMS');

			if (!empty($ajaxItemIds) && is_array($ajaxItemIds))
			{
				$this->ajaxItemsIds = $ajaxItemIds;
			}
			else
			{
				// show something
				$this->ajaxItemsIds = null;
				// last viewed will be shown
			}

			// draw products with collected ids
			$this->prepareData();
			$this->formatResult();
		}

		if (!$this->extractDataFromCache())
		{
			// output js before template to be caught in cache
			if (!empty($this->arResult['ITEMS']))
			{
				echo $this->getInjectedJs($this->arResult['ITEMS'], $this->arParams['UNIQ_COMPONENT_ID']);
			}

			$this->setResultCacheKeys(array());
			$this->includeComponentTemplate();
		}
	}

	protected function getInjectedJs($items, $uniqId)
	{
		$jsItems = array();

		foreach ($items as $item)
		{
			$jsItems[] = array(
				"productId" => $item['ID'],
				"productUrl" => $item['DETAIL_PAGE_URL'],
				"recommendationId" => $this->recommendationIdToProduct[$item['ID']]
			);
		}
		
		global $APPLICATION;

		$jsCookiePrefix = CUtil::JSEscape(COption::GetOptionString("main", "cookie_name", "BITRIX_SM"));
		$jsCookieDomain = CUtil::JSEscape($APPLICATION->GetCookieDomain());
		$jsServerTime = time();

		$jsUniqId = CUtil::JSEscape($uniqId."_items");
		$jsonItems = CUtil::PhpToJSObject($jsItems);

		// static data for JCCatalogBigdataProducts (SendToBasket)
		$jsToBasket = "";
		foreach ($items as $item)
		{
			$jsToBasket .= "JCCatalogBigdataProducts.productsByRecommendation[{$item['ID']}] = \"{$this->recommendationIdToProduct[$item['ID']]}\";\n";
		}

		return "<script type=\"text/javascript\">
			BX.cookie_prefix = '{$jsCookiePrefix}';
			BX.cookie_domain = '{$jsCookieDomain}';
			BX.current_server_time = '{$jsServerTime}';

			if (!JCCatalogBigdataProducts.productsByRecommendation)
			{
				JCCatalogBigdataProducts.productsByRecommendation = [];
			}

			{$jsToBasket}

			BX.ready(function(){
				bx_rcm_adaptive_recommendation_event_attaching({$jsonItems}, '{$jsUniqId}');
			});
		</script>";
	}
}