<?php
class RetailRocketClass{

	public function addTrackingCode()
		{
			if (!defined('ADMIN_SECTION')) {
				global $APPLICATION;
				$partnerId = COption::GetOptionString("quetzal.retailrocket", "retail_partner_id");
				$APPLICATION->AddHeadString("\n<!-- BEGIN RetailRocket CODE -->
				<script type='text/javascript'>
					var rrPartnerId = '$partnerId';
					var rrApi = {};
					var rrApiOnReady = rrApiOnReady || [];
					rrApi.addToBasket = rrApi.order = rrApi.categoryView = rrApi.view =
						rrApi.recomMouseDown = rrApi.recomAddToCart = function() {};
					(function(d) {
						var ref = d.getElementsByTagName('script')[0];
						var apiJs, apiJsId = 'rrApi-jssdk';
						if (d.getElementById(apiJsId)) return;
						apiJs = d.createElement('script');
						apiJs.id = apiJsId;
						apiJs.async = true;
						apiJs.src = '//cdn.retailrocket.ru/content/javascript/api.js';
						ref.parentNode.insertBefore(apiJs, ref);
					}(document));
				</script>
				<!-- END RetailRocket CODE -->\n");
			}
		}

	public function addBasketButton()
		{
			if (!defined('ADMIN_SECTION')) {
				global $APPLICATION;
				$strParams = COption::GetOptionString("quetzal.retailrocket", "retail_button_params");
				if($strParams){
					$intFlag = 0; // Флаг показывает дошли ли мы до параметра ID
					$strSeporator = chr(59);
					$strBeginString = chr(10);
					$strEndString = chr(13);
					$intStrLeng = strlen($strParams);
					$arResultParams = array();
					$strParamsButton = "";
					$strParamsId = "";
					for($i=0; $i<=$intStrLeng; $i++){
						if(($strParams[$i] === $strSeporator)and($intFlag == 0)){
							$intFlag = 1;
							$i++;
						}
						if($strParams[$i] === $strEndString){
							$intFlag = 0;
							$i++;
							$arResultParams[] = array("BUT" =>$strParamsButton, "ID"=>$strParamsId);
							$strParamsButton = "";
							$strParamsId = "";
						}
						elseif($i == $intStrLeng){
							$arResultParams[] = array("BUT" =>$strParamsButton, "ID"=>$strParamsId);
						}

						if($intFlag == 0){
							if(!($strParams[$i] === $strBeginString)){
								$strParamsButton = $strParamsButton.$strParams[$i];
							}
						}
						else {
							$strParamsId = $strParamsId.$strParams[$i];
						}
					}

					$i = 0;
					$APPLICATION->AddHeadString("\n<!-- BEGIN RetailRocket BASKET BUTTON CODE -->
							<script type='text/javascript'>
								$(document).ready(function(){");

					while($arResultParams[$i]){
						$strParamsButton = $arResultParams[$i]['BUT'];
						$strParamsId = $arResultParams[$i]['ID'];
						$APPLICATION->AddHeadString("
									$('body').on('mousedown', '$strParamsButton', function() {
										var atr = $(this).attr('$strParamsId');
										try{rrApi.addToBasket(atr)} catch(e){}
									});
									");
						$i++;
					}

					$APPLICATION->AddHeadString("
								});
							</script>
							<!-- END RetailRocket BASKET BUTTON CODE -->\n");
				}

			}

		}

	public function addJQueryCode()
		{
			if (!defined('ADMIN_SECTION')) {
				global $APPLICATION;
				$APPLICATION->AddHeadString('<script type="text/javascript" src="/bitrix/js/quetzal.retailrocket/jquery-1.9.1.min.js"></script>');
			}
		}

	// ---- Функции для сохранения/получения настроек модуля

	// Функция получения сессии
	// Входные параметры: email и pass
	// Результат, массив результат запроса
	public function retailSession($email, $pass){
		$strQueryText = QueryGetData(
			'api.retailrocket.ru',
			80,
			'/api/1.0/auth/',
			sprintf(
				'email=%s&password=%s',
				urlencode($email),
				urlencode($pass)
			),
			$error_number,
			$error_text,
			'POST'
		);
		if(strlen($strQueryText)<=0){
			$arSession["ERROR"] = 1;
		}
		else {
			$arSession["ERROR"] = 0;
			$queryResult = json_decode($strQueryText);
			$arSession["VALUE"] = $queryResult->Session;
		}
		return $arSession;
	}

	// Функция получения параметров по сессии
	// Входные параметры: id и session
	// Выходные параметры: массив результат запроса
	public function retailLink($id, $session){
		$strQueryText = QueryGetData("api.retailrocket.ru", 80, "/api/1.0/partner/$id/", "session=$session", $error_number, $error_text);
		if(strlen($strQueryText)<=0){
			$arLink["ERROR"] = 1;
		}
		else {
			$arLink["ERROR"] = 0;
			$queryResult = json_decode($strQueryText);
			$arLink["YML"] = $queryResult->YmlUrl;
			$arLink["BASKET"] = $queryResult->BasketUrl;
		}
		return $arLink;
	}

	// Функция получения статусов
	// Входные параметры: id и session
	// Выходные параметры: массив результат запрос
	public function retailStatus($id, $session){
		$strQueryText = QueryGetData("api.retailrocket.ru", 80, "/api/1.0/partner/$id/statuses", "session=$session", $error_number, $error_text, "GET");
		if(strlen($strQueryText)<=0){
			$arStatus["ERROR"] = 1;
		}
		else {
			$arStatus["ERROR"] = 0;
			$queryResult = json_decode($strQueryText);
			$arStatus["TRACKING_CODE"] = $queryResult->IsIntegrationOk;
			$arStatus["ORDER_CODE"] = $queryResult->WasOrderEvent;
			$arStatus["ELEM_SECT_CODE"] = $queryResult->WasViewEvent;
			$arStatus["ADD_BASKET_CODE"] = $queryResult->WasAddToBasketEventDate;
			$arStatus["YML_DATA"] = $queryResult->YmlDownloadDate;
			$ymlStatus = $queryResult->YmlDownloadErrorMessage;
			$arStatus["YML_ERROR"] = iconv("UTF-8", SITE_CHARSET, $ymlStatus);
		}
		return $arStatus;
	}

	// Функция получения списка виджетов и их статусов
	// Входные параметры: id и session
	// Выходные параметры: массив результат запрос
	public function retailWidget($id, $session){
		$arWidget = array();
		$strQueryText = QueryGetData("api.retailrocket.ru", 80, "/api/1.0/partner/$id/widgets", "session=$session", $error_number, $error_text, "GET");

		if (strlen($strQueryText)<=0) {
			$arWidget["ERROR"] = 1;
		}
		else {
			$arWidget["ERROR"] = 0;
			$queryResult = json_decode($strQueryText);
			$strError = $queryResult->Message;

			if(strlen($strError)>0){
				$arWidget["ERROR"] = 2;
			}
			else {
				$i=0; $j=0;
				while($queryResult[$i]){
					$type = $queryResult[$i]->Type;
					switch($type){
						case 0:
							$arWidget["LIST"][$j]["NAME"] = GetMessage("RR_QTZ_WIDGET_NAME_PROD");
							$arWidget["LIST"][$j]["ID"] = $queryResult[$i]->Id;
							$arWidget["LIST"][$j]["TYPE"] = $queryResult[$i]->Type;
							$arWidget["LIST"][$j]["ACTIVE"] = $queryResult[$i]->IsActive;
							$arWidget["LIST"][$j]["SHOWN"] = $queryResult[$i]->IsRecentlyShown;
							$j++;

							break;
						case 1:
							$arWidget["LIST"][$j]["NAME"] = GetMessage("RR_QTZ_WIDGET_NAME_PERS");
							$arWidget["LIST"][$j]["ID"] = $queryResult[$i]->Id;
							$arWidget["LIST"][$j]["TYPE"] = $queryResult[$i]->Type;
							$arWidget["LIST"][$j]["ACTIVE"] = $queryResult[$i]->IsActive;
							$arWidget["LIST"][$j]["SHOWN"] = $queryResult[$i]->IsRecentlyShown;
							$j++;
							break;
						case 3:
							$arWidget["LIST"][$j]["NAME"] = GetMessage("RR_QTZ_WIDGET_NAME_SECTION");
							$arWidget["LIST"][$j]["ID"] = $queryResult[$i]->Id;
							$arWidget["LIST"][$j]["TYPE"] = $queryResult[$i]->Type;
							$arWidget["LIST"][$j]["ACTIVE"] = $queryResult[$i]->IsActive;
							$arWidget["LIST"][$j]["SHOWN"] = $queryResult[$i]->IsRecentlyShown;
							$j++;
							break;
						case 4:
							$arWidget["LIST"][$j]["NAME"] = GetMessage("RR_QTZ_WIDGET_NAME_INDEX");
							$arWidget["LIST"][$j]["ID"] = $queryResult[$i]->Id;
							$arWidget["LIST"][$j]["TYPE"] = $queryResult[$i]->Type;
							$arWidget["LIST"][$j]["ACTIVE"] = $queryResult[$i]->IsActive;
							$arWidget["LIST"][$j]["SHOWN"] = $queryResult[$i]->IsRecentlyShown;
							$j++;
							break;
						case 5:
							$arWidget["LIST"][$j]["NAME"] = GetMessage("RR_QTZ_WIDGET_NAME_CARS");
							$arWidget["LIST"][$j]["ID"] = $queryResult[$i]->Id;
							$arWidget["LIST"][$j]["TYPE"] = $queryResult[$i]->Type;
							$arWidget["LIST"][$j]["ACTIVE"] = $queryResult[$i]->IsActive;
							$arWidget["LIST"][$j]["SHOWN"] = $queryResult[$i]->IsRecentlyShown;
							$j++;
							break;
						case 6:
							$arWidget["LIST"][$j]["NAME"] = GetMessage("RR_QTZ_WIDGET_NAME_SEARCH");
							$arWidget["LIST"][$j]["ID"] = $queryResult[$i]->Id;
							$arWidget["LIST"][$j]["TYPE"] = $queryResult[$i]->Type;
							$arWidget["LIST"][$j]["ACTIVE"] = $queryResult[$i]->IsActive;
							$arWidget["LIST"][$j]["SHOWN"] = $queryResult[$i]->IsRecentlyShown;
							$j++;
							break;
						case 7:
							$arWidget["LIST"][$j]["NAME"] = GetMessage("RR_QTZ_WIDGET_NAME_NOITEM");
							$arWidget["LIST"][$j]["ID"] = $queryResult[$i]->Id;
							$arWidget["LIST"][$j]["TYPE"] = $queryResult[$i]->Type;
							$arWidget["LIST"][$j]["ACTIVE"] = $queryResult[$i]->IsActive;
							$arWidget["LIST"][$j]["SHOWN"] = $queryResult[$i]->IsRecentlyShown;
							$j++;
							break;
					}
					$i++;
				}
			}
		}
		return $arWidget;
	}

	// Функция передает параметры ссылки на YML и Корзину
	// Входные параметры: id, session, YML, basket
	// Выходные параметры: массив результат запрос
	public function retailPutLink($id, $session, $yml, $basket){
		$ob = new CHTTP();
		$http_timeout = (intval($http_timeout) > 0) ? $http_timeout : 120;
		$ob->http_timeout = $http_timeout;
		$ob->Query(
			"PUT", //method
			"api.retailrocket.ru", //site
			"80", //port
			"/api/1.0/partner/$id/?session=$session&", //path
			"ymlUrl=$yml&basketUrl=$basket", // query
			"", // proto
			"N", // content type
			false
		);

		$resultPut["ERROR_N"] = $ob->errno;
		$resultPut["ERROR_M"] = $ob->errstr;
		$resultPut["RESULT"] = $ob->result;

		return $resultPut;
	}

	// ---- Конец блока с функциями
}
