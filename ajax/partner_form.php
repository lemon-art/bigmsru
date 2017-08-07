<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>


<?$APPLICATION->IncludeComponent(
				"bitrix:form.result.new",
				"partner",
				Array(
					"WEB_FORM_ID" => "6",
					"IGNORE_CUSTOM_TEMPLATE" => "N",
					"USE_EXTENDED_ERRORS" => "N",
					"SEF_MODE" => "N",
					"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"","RESULT_ID"=>"",),
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"LIST_URL" => "",
					"EDIT_URL" => "",
					"SUCCESS_URL" => "",
					"CHAIN_ITEM_TEXT" => "",
					"CHAIN_ITEM_LINK" => "",
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_SHADOW" => "N",
					"AJAX_OPTION_JUMP" => "Y",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N"
				)
			);?>