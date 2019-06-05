<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?$APPLICATION->IncludeComponent(
					"bitrix:main.register",
					"modal",
					Array(
						"SHOW_FIELDS" => array("EMAIL","NAME","LAST_NAME","WORK_COMPANY"),
						"REQUIRED_FIELDS" => array("EMAIL","NAME","LAST_NAME"),
						"AUTH" => "Y",
						"USE_BACKURL" => "N",
						"SUCCESS_PAGE" => "",
						"SET_TITLE" => "N",
						"USER_PROPERTY" => array("UF_TYPE","UF_INN"),
						"USER_PROPERTY_NAME" => "",
						"COMPONENT_TEMPLATE" => "modal"
					)
			);?>