<?  
    IncludeModuleLangFile(__FILE__);
	
    $menu_name = GetMessage("RR_QTZ_MENU_NAME");
    $menu_title = GetMessage("RR_QTZ_MENU_TITLE");
	
	$aMenu = array(
        "parent_menu" => "global_menu_services",
        "sort"        => 100,                    
        "url"         => "retail_configuration.php",
        "text"        => $menu_name,       
        "title"       => $menu_title,
        "icon"        => "form_menu_icon",
        "page_icon"   => "form_page_icon",
        "items_id"    => "menu_webforms",
        "items"       => array(),
    );
    
    return $aMenu;
?>