<nav class="right_menu">
	<?$APPLICATION->IncludeComponent("bitrix:menu", "simple", Array(
		"COMPONENT_TEMPLATE" => ".default",
			"ROOT_MENU_TYPE" => "personal",
			"MENU_CACHE_TYPE" => "N",
			"MENU_CACHE_TIME" => "3600",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_CACHE_GET_VARS" => array(
				0 => "",
			),
			"MAX_LEVEL" => "1",
			"CHILD_MENU_TYPE" => "",
			"USE_EXT" => "Y",
			"DELAY" => "N",
			"ALLOW_MULTI_SELECT" => "N",
		),
		false
	);?>
</nav>