<?
if(!check_bitrix_sessid()) return;
IncludeModuleLangFile(__FILE__);
// Удаляем обработчики событий
UnRegisterModuleDependences("main", "OnPageStart", "quetzal.retailrocket","RetailRocketClass", "addTrackingCode");

UnRegisterModuleDependences("main", "OnPageStart", "quetzal.retailrocket","RetailRocketClass", "addBasketButton");

// Если устанавливался код библиотеки JQuery, удаляем его
$jQuerySet = COption::GetOptionString("quetzal.retailrocket", "retail_set_jq", false, false);
if($jQuerySet == "Y"){
    UnRegisterModuleDependences("main", "OnPageStart", "quetzal.retailrocket","RetailRocketClass", "addJQueryCode");
}

// Удаляем параметры
COption::RemoveOption("quetzal.retailrocket", "retail_email");
COption::RemoveOption("quetzal.retailrocket", "retail_pass");
COption::RemoveOption("quetzal.retailrocket", "retail_partner_id");
COption::RemoveOption("quetzal.retailrocket", "retail_button_params");
COption::RemoveOption("quetzal.retailrocket", "retail_set_jq");
COption::RemoveOption("quetzal.retailrocket", "retail_yml_link");
COption::RemoveOption("quetzal.retailrocket", "retail_basket_link");

// Удаляем регистрационную запись, а также все настройки модуля из базы данных.
UnRegisterModule("quetzal.retailrocket");

echo CAdminMessage::ShowNote(GetMessage("RR_QTZ_UNSTEP_DEL"));
echo "<p><a href='".$APPLICATION->GetCurPage()."'>".GetMessage("RR_QTZ_UNSTEP_END")."</a></p>";
?>