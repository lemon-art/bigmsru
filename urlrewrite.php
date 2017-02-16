<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/catalog/inzhenernaya-santekhnika/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/catalog/inzhenernaya-santekhnika/index.php",
	),
	array(
		"CONDITION" => "#^/proizvoditeli/inzhenernaya/#",
		"RULE" => "",
		"PATH" => "/proizvoditeli/inzhenernaya/index.php",
	),
	array(
		"CONDITION" => "#^/reports/([0-9]+)/([0-9]+)/#",
		"RULE" => "ORDER_ID=\$1&S=\$2",
		"ID" => "",
		"PATH" => "/reports/index.php",
	),
	array(
		"CONDITION" => "#^/articles/([^/]+?)/\\??(.*)#",
		"RULE" => "ELEMENT_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/articles/index.php",
	),
	array(
		"CONDITION" => "#^/bitrix/services/ymarket/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/bitrix/services/ymarket/index.php",
	),
	array(
		"CONDITION" => "#^/proizvoditeli/bytovaya/#",
		"RULE" => "",
		"PATH" => "/proizvoditeli/bytovaya/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/inzhenernaya/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/catalog/inzhenernaya/index.php",
	),
	array(
		"CONDITION" => "#^/news/([^/]+?)/\\??(.*)#",
		"RULE" => "ELEMENT_CODE=\$1&\$2",
		"ID" => "",
		"PATH" => "/news/index.php",
	),
	array(
		"CONDITION" => "#^/acrit.exportpro/(.*)#",
		"RULE" => "path=\$1",
		"ID" => "",
		"PATH" => "/acrit.exportpro/index.php",
	),
	array(
		"CONDITION" => "#^/personal/zakladki/#",
		"RULE" => "",
		"ID" => "bitrix:catalog.section",
		"PATH" => "/personal/zakladki/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/bytovaya/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/catalog/bytovaya/index.php",
	),
	array(
		"CONDITION" => "#^/personal/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/personal/order/index.php",
	),
	array(
		"CONDITION" => "#^/arenda/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/arenda/index.php",
	),
);

?>