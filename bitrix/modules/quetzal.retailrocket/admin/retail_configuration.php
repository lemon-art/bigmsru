<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php');

// Получим права доступа текущего пользователя на модуль
$POST_RIGHT = $APPLICATION->GetGroupRight('quetzal.retailrocket');
// Если нет прав - отправим к форме авторизации с сообщением об ошибке
if ($POST_RIGHT == 'D') {
	$APPLICATION->AuthForm(GetMessage('RR_QTZ_ACCESS_DENIED'));
}
// Подключим языковой файл
IncludeModuleLangFile(__FILE__);

// Здесь будет вся серверная обработка и подготовка данных
// Установим заголовок страницы
$APPLICATION->SetTitle(GetMessage('RR_QTZ_CONFIGURATION_TITLE'));

$apiRetail = new RetailRocketClass;
$strErrorLink = '';
$strError = '';
// Массив данных
$arParams = array();
$arParams['EMAIL'] = COption::GetOptionString('quetzal.retailrocket', 'retail_email', false, false);
$arParams['PASS'] = COption::GetOptionString('quetzal.retailrocket', 'retail_pass', false, false);
$arParams['ID'] = COption::GetOptionString('quetzal.retailrocket', 'retail_partner_id', false, false);
$arParams['SESSION'] = $apiRetail->retailSession($arParams['EMAIL'], $arParams['PASS']);
$arParams['BUTTON'] = COption::GetOptionString('quetzal.retailrocket', 'retail_button_params', false, false);
$arParams['JQUERY'] = COption::GetOptionString('quetzal.retailrocket', 'retail_set_jq', false, false);
if ($arParams['JQUERY'] == '') {
	$arParams['JQUERY'] = 'N';
	COption::SetOptionString('quetzal.retailrocket', 'retail_set_jq', 'N');
}

// Если пользователь не вводил настройки,
// то получаем информацию с сервера, сравниваем с сохраненными настройками, и если они не совпали
// значит меняем значения переменных на те что пришли с сервера
if (empty($_POST)) {
	// Если удалось получить сессию, то получим ссылки на YML и на корзину
	if ($arParams['SESSION']['ERROR'] == 0) {
		$arParams['LINK'] = $apiRetail->retailLink($arParams['ID'], $arParams['SESSION']['VALUE']);
		if ($arParams['LINK']['ERROR'] == 0) {
			$moduleYmlLink = COption::GetOptionString('quetzal.retailrocket', 'retail_yml_link', false, false);
			if ($arParams['LINK']['YML'] != $moduleYmlLink) {
				COption::RemoveOption('quetzal.retailrocket', 'retail_yml_link');
				COption::SetOptionString('quetzal.retailrocket', 'retail_yml_link', $arParams['LINK']['YML']);
			}

			$moduleBasketLink = COption::GetOptionString('quetzal.retailrocket', 'retail_basket_link', false, false);
			if ($arParams['LINK']['BASKET'] != $moduleBasketLink) {
				COption::RemoveOption('quetzal.retailrocket', 'retail_basket_link');
				COption::SetOptionString('quetzal.retailrocket', 'retail_basket_link', $arParams['LINK']['BASKET']);
			}
		}
	}

} else {

	if ($_POST['pass']) {
		// Проверяем подходит ли новый пароль, если да то меняем значение, если нет то оставляем значение, выводим сообщение об ошибке
		$arParams['SESSION'] = $apiRetail->retailSession($arParams['EMAIL'], $_POST['pass']);
		if (($arParams['SESSION']['ERROR'] == 0) && (strlen($arParams['SESSION']['VALUE']) > 0)) {
			COption::RemoveOption('quetzal.retailrocket', 'retail_pass');
			COption::SetOptionString('quetzal.retailrocket', 'retail_pass', $_POST['pass']);
			$arParams['PASS'] = COption::GetOptionString('quetzal.retailrocket', 'retail_pass', false, false);
			$arParams['SESSION'] = $apiRetail->retailSession($arParams['EMAIL'], $arParams['PASS']);
			$strError = '0';
		} else {
			$strError = '1';
			$arParams['SESSION'] = $apiRetail->retailSession($arParams['EMAIL'], $arParams['PASS']);
		}
	}

	if (($_POST['jquery_y'] === 'Y') && ($arParams['JQUERY'] === 'N')) {
		RegisterModuleDependences('main', 'OnPageStart', 'quetzal.retailrocket', 'RetailRocketClass', 'addJQueryCode',
			10);
		// Устанавливаем флаг, что мы подключали код JQ
		COption::RemoveOption('quetzal.retailrocket', 'retail_set_jq');
		COption::SetOptionString('quetzal.retailrocket', 'retail_set_jq', 'Y');
		$arParams['JQUERY'] = COption::GetOptionString('quetzal.retailrocket', 'retail_set_jq', false, false);
	} elseif ((!($_POST['jquery_n'])) && ($arParams['JQUERY'] === 'Y')) {
		UnRegisterModuleDependences('main', 'OnPageStart', 'quetzal.retailrocket', 'RetailRocketClass',
			'addJQueryCode');
		// Устанавливаем флаг, что мы отключали код JQ
		COption::RemoveOption('quetzal.retailrocket', 'retail_set_jq');
		COption::SetOptionString('quetzal.retailrocket', 'retail_set_jq', 'N');
		$arParams['JQUERY'] = COption::GetOptionString('quetzal.retailrocket', 'retail_set_jq', false, false);
	}

	if ($_POST['params']) {
		COption::RemoveOption('quetzal.retailrocket', 'retail_button_params');
		UnRegisterModuleDependences('main', 'OnPageStart', 'quetzal.retailrocket', 'RetailRocketClass',
			'addBasketButton');

		COption::SetOptionString('quetzal.retailrocket', 'retail_button_params', $_POST['params']);
		RegisterModuleDependences('main', 'OnPageStart', 'quetzal.retailrocket', 'RetailRocketClass', 'addBasketButton',
			110);

		$arParams['BUTTON'] = COption::GetOptionString('quetzal.retailrocket', 'retail_button_params', false, false);
	}

	if (($_POST['yml']) || ($_POST['basket'])) {
		$queryPut = $apiRetail->retailPutLink($arParams['ID'], $arParams['SESSION']['VALUE'], $_POST['yml'],
			$_POST['basket']);

		if ($queryPut) {
			$arParams['LINK'] = $apiRetail->retailLink($arParams['ID'], $arParams['SESSION']['VALUE']);
			if ($arParams['LINK']['YML'] == $_POST['yml']) {
				COption::RemoveOption('quetzal.retailrocket', 'retail_yml_link');
				COption::SetOptionString('quetzal.retailrocket', 'retail_yml_link', $arParams['LINK']['YML']);
			} else {
				$strErrorLink = '1';
			}

			if ($arParams['LINK']['BASKET'] == $_POST['basket']) {
				COption::RemoveOption('quetzal.retailrocket', 'retail_basket_link');
				COption::SetOptionString('quetzal.retailrocket', 'retail_basket_link', $arParams['LINK']['BASKET']);
			} else {
				$strErrorLink = $strErrorLink . '2';
			}
		}
	}
}

// Получим значения статусов
$arParams['STATUS'] = $apiRetail->retailStatus($arParams['ID'], $arParams['SESSION']['VALUE']);

// Получим список виджетов и их статусы
$arParams['WIDGET'] = $apiRetail->retailWidget($arParams['ID'], $arParams['SESSION']['VALUE']);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php'); // второй общий пролог

// Здесь будет вывод страницы
echo '<div style="width:580px; padding: 10px; font-size: 12px; background-color: #ffffff; color: #555555;">';
echo '<div style="padding: 5px; border-bottom: 2px solid #555555;">';
echo '<img src="http://retailrocket.ru/Content/Img/promo/logo.png" alt="RetailRocket"/>';
echo '<h2 style="font-weight: 800;">' . GetMessage("RR_QTZ_CONFIGURATION_TITLE") . '</h2>';
echo '</div>';

echo '<div style="padding: 5px; border-bottom: 2px solid #555555;">';
echo '<h2>' . GetMessage("RR_QTZ_CONFIGURATION_STAT_TEXT") . '</h2>';
if (strlen($arParams["STATUS"]["YML_ERROR"]) > 0) {
	echo '<p style="font-size: 14px; color: red;">' . GetMessage("RR_QTZ_CONFIGURATION_YML_ERROR_TEXT") . '</p>';
}
if ($arParams["STATUS"]["TRACKING_CODE"]) {
	echo '<p style="font-size: 14px; color: #468847;">' . GetMessage("RR_QTZ_CONFIGURATION_STAT_TREKING_COD") . '</p>';
}

if ($arParams["STATUS"]["ORDER_CODE"]) {
	echo '<p style="font-size: 14px; color: #468847;">' . GetMessage("RR_QTZ_CONFIGURATION_STAT_ORDER") . '</p>';
} else {
	echo '<p style="font-size: 14px; color: #F89406;">' . GetMessage("RR_QTZ_CONFIGURATION_STAT_ORDER_N") . '</p>';
}

if ($arParams["STATUS"]["ELEM_SECT_CODE"]) {
	echo '<p style="font-size: 14px; color: #468847;">' . GetMessage("RR_QTZ_CONFIGURATION_STAT_VIEW") . '</p>';
} else {
	echo '<p style="font-size: 14px; color: #F89406;">' . GetMessage("RR_QTZ_CONFIGURATION_STAT_VIEW_N") . '</p>';
}

if ($arParams["STATUS"]["ADD_BASKET_CODE"]) {
	echo '<p style="font-size: 14px; color: #468847;">' . GetMessage("RR_QTZ_CONFIGURATION_STAT_BASKET_COD") . '</p>';
} else {
	echo '<p style="font-size: 14px; color: #F89406;">' . GetMessage("RR_QTZ_CONFIGURATION_STAT_BASKET_COD_N") . '</p>';
}

echo '</div>';

echo '<div style="padding: 5px 5px 10px 5px; border-bottom: 2px solid #555555;">';
echo '<h2>' . GetMessage("RR_QTZ_WIDGET_TEXT") . '</h2>';
echo '<table style="text-align: left;" width="580px" cellspacing="0" cellpadding="0" border="0">';
echo '<tr><th>' . GetMessage("RR_QTZ_WIDGET_NAME") . '</th><th>' . GetMessage("RR_QTZ_WIDGET_STATUS") . '</th><th></th></tr>';
if ($arParams["WIDGET"]["ERROR"] == 0) {
	$i = 0;
	while ($arParams["WIDGET"]["LIST"][$i]) {
		echo '<tr>';
		echo '<td>' . $arParams["WIDGET"]["LIST"][$i]["NAME"] . '</td>';
		echo '<td>';
		if ($arParams["WIDGET"]["LIST"][$i]["ACTIVE"]) {
			echo '<span>' . GetMessage("RR_QTZ_WIDGET_STATUS_Y") . '</span>';
		} else {
			echo '<span>' . GetMessage("RR_QTZ_WIDGET_STATUS_N") . '</span>';
		}
		echo '</td>';
		echo '<td>';
		if ($arParams["WIDGET"]["LIST"][$i]["SHOWN"]) {
			echo '<span style="color: #468847;">' . GetMessage("RR_QTZ_WIDGET_ACTIVE_Y") . '</span>';
		} else {
			echo '<span style="color: #F89406;">' . GetMessage("RR_QTZ_WIDGET_ACTIVE_N") . '</span>';
		}
		echo '</td>';
		echo '</tr>';
		$i++;
	}
} else {
	echo '<h3 style="color: #F89406;">' . GetMessage("RR_QTZ_WIDGET_ERROR") . '</h3>';
}
echo '</table>';
echo '<p>' . GetMessage("RR_QTZ_WIDGET_MESSAGE") . '</p>';
echo '</div>';

if (($_POST["pass"]) && ($strError === "1")) {
	echo '<div style="padding: 5px; border-bottom: 2px solid #555555">';
	echo '<p style="color: red; font-size: 14px;">' . GetMessage("RR_QTZ_CONFIGURATION_AUTH_NEW_PASS_N") . '</p>';
	echo '</div>';
}
echo '<form name="step_1" method="post" action="' . $APPLICATION->GetCurPage() . '">';
//echo bitrix_sessid_post();
echo '<h2>' . GetMessage("RR_QTZ_CONFIGURATION_AUTH_DATA") . '</h2>';
echo '<table style="font-style: normal; padding: 0px 0px 20px 0px; border-bottom: 1px solid #555555; font-weight: bold;" width="580px" cellspacing="0" cellpadding="0" border="0">';
echo '<tr>'; // Поле для ввода email
echo '<td style="width:150px; padding: 5px;">';
echo GetMessage("RR_QTZ_CONFIGURATION_AUTH_DATA_EMAIL");
echo '</td>';
echo '<td style="padding: 5px; ">';
echo '<input type="email" name="email" disabled="disabled" value="' . $arParams["EMAIL"] . '"/>';
echo '</td>';
echo '</tr>';
echo '<tr>'; // Поле для ввода пароля
echo '<td style="width:150px; padding: 5px; ">';
echo GetMessage("RR_QTZ_CONFIGURATION_AUTH_DATA_PASS");
echo '</td>';
echo '<td style="padding: 5px; ">';
echo '<input type="password" name="pass" value=""/>';
echo '</td></tr></table>';

if ($arParams["BUTTON"]) {
	echo '<h2>' . GetMessage("RR_QTZ_CONFIGURATION_BUTTON_HEAD") . '</h2>';
	echo '<p>' . GetMessage("RR_QTZ_CONFIGURATION_BUTTON_PARAM_TEXT_Y") . '</p>';
	echo '<table style="padding: 0px 0px 20px 0px; border-bottom: 1px solid #555555;" width="580px" cellspacing="0" cellpadding="0" border="0">';
	echo '<tr>'; // Параметры кнопок добавления в корзину
	echo '<td style="width:300px; padding: 5px; vertical-align:top; font-weight: bold; font-style: normal;">';
	echo GetMessage("RR_QTZ_CONFIGURATION_BUTTON_PARAM");
	echo '</td>';
	echo '<td style="padding: 5px; font-style: normal;">';
	echo '<textarea rows="5" cols="50" name="params">' . $arParams["BUTTON"] . '</textarea>';
	echo '</td></tr></table>';
} else {
	echo '<p>' . GetMessage("RR_QTZ_CONFIGURATION_BUTTON_PARAM_TEXT_N") . '</p>';
	echo '<table style="padding: 0px 0px 20px 0px; border-bottom: 1px solid #555555;" width="580px" cellspacing="0" cellpadding="0" border="0">';
	echo '<tr>'; // Параметры кнопок добавления в корзину
	echo '<td style="width:300px; padding: 5px; vertical-align:top; font-weight: bold; font-style: normal;">';
	echo GetMessage("RR_QTZ_CONFIGURATION_BUTTON_PARAM");
	echo '</td>';
	echo '<td style="padding: 5px; font-style: normal;">';
	echo '<textarea rows="5" cols="50" name="params">' . $arParams["BUTTON"] . '</textarea>';
	echo '</td> </tr> </table>';
}

echo '<h2>' . GetMessage("RR_QTZ_CONFIGURATION_LINK_TEXT") . '</h2>';

if (strlen($arParams["STATUS"]["YML_DATA"]) > 0) {
	echo '<span style="color: #F89406;">' . GetMessage("RR_QTZ_CONFIGURATION_YML_DATA") . $arParams["STATUS"]["YML_DATA"] . '</span><br/>';
}
if (strlen($arParams["STATUS"]["YML_ERROR"]) > 0) {
	echo '<span style="color: red;">' . GetMessage("RR_QTZ_CONFIGURATION_YML_ERROR") . ': ' . $arParams["STATUS"]["YML_ERROR"] . '</span><br/>';
}

if ($strErrorLink === "1") {
	echo '<span style="color: red;">' . GetMessage("RR_QTZ_CONFIGURATION_YML_PUT_YML_ERROR") . '</span><br/>';
}
if ($strErrorLink === "2") {
	echo '<span style="color: red;">' . GetMessage("RR_QTZ_CONFIGURATION_YML_PUT_BASKET_ERROR") . '</span><br/>';
}
if ($strErrorLink === "12") {
	echo '<span style="color: red;">' . GetMessage("RR_QTZ_CONFIGURATION_YML_PUT_ERROR") . '</span><br/>';
}

echo '<table style="padding: 0px 0px 20px 0px; border-bottom: 1px solid #555555;" width="580px" cellspacing="0" cellpadding="0" border="0">';
echo '<tr>'; // Ссылка на корзину
echo '<td style="width:300px; padding: 5px; font-weight: bold; font-style: normal; vertical-align: top;">';
echo GetMessage("RR_QTZ_CONFIGURATION_LINK_BASKET");
echo '</td>';
echo '<td style="padding: 5px; font-style: normal;">';
echo '<input type="text" name="basket" value="' . $arParams["LINK"]["BASKET"] . '"/>';
echo '</td>';
echo '</tr>';
echo '<tr>'; // Ссылка на файл выгрузки товаров в формате YML
echo '<td style="width:300px; padding: 5px; font-weight: bold; font-style: normal; vertical-align: top;">';
echo GetMessage("RR_QTZ_CONFIGURATION_LINK_YML");
echo '</td>';
echo '<td style="padding: 5px; font-style: normal;">';
echo '<input type="text" name="yml" value="' . $arParams["LINK"]["YML"] . '"/>';
echo '</td></tr></table>';

echo GetMessage("RR_QTZ_CONFIGURATION_INPUT_JQ_TEXT_N");
echo '<table style="padding: 0px 0px 20px 0px; border-bottom: 1px solid #555555;" width="580px" cellspacing="0" cellpadding="0" border="0">';
echo '<tr>'; // Подключение JQuery
echo '<td style="width:300px; padding: 5px; font-weight: bold; font-style: normal;">';
echo GetMessage("RR_QTZ_CONFIGURATION_INPUT_JQ_N");
echo '</td>';
echo '<td style="padding: 5px; font-style: normal;">';
if ($arParams["JQUERY"] === 'Y') {
	echo '<input type="checkbox" name="jquery_n" checked="checked" value="Y"/>';
} else {
	echo '<input type="checkbox" name="jquery_y" value="Y"/>';
}
echo '</td></tr></table>';

echo '<table style="padding: 20px 0px 20px 0px;" width="580px" cellspacing="0" cellpadding="0" border="0">';
echo '<tr>'; // Кнопка сохранить
echo '<td style="width: 85%; padding: 5px; font-style: normal;"></td>';
echo '<td>';
echo '<input type="submit" name="submit" value="' . GetMessage("RR_QTZ_CONFIGURATION_INPUT_SAVE_CHANGES") . '" />';
echo '</td></tr></table></form></div>';

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php');
?>