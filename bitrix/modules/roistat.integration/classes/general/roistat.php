<?php
IncludeModuleLangFile(__FILE__);

class CRoistat
{
    function OnEndBufferContentHandler(&$content)
    {
        if (defined('ADMIN_SECTION'))
            return;
        $PROJECT_ID = COption::GetOptionString('roistat.integration', 'PROJECT_ID');
        if (strlen($PROJECT_ID) > 0) {
            $escapedProjectId = CUtil::JSEscape($PROJECT_ID);
            $js =
<<<JAVASCRIPT
    <script>
    (function(w, d, s, h, id) {
        w.roistatProjectId = id; w.roistatHost = h;
        var p = d.location.protocol == "https:" ? "https://" : "http://";
        var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init";
        var js = d.createElement(s); js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
    })(window, document, 'script', 'cloud.roistat.com', '{$escapedProjectId}');
    </script>
JAVASCRIPT;
			$content = preg_replace("/<head>/", "<head>{$js}", $content, 1);
        }
    }

    function __AddRoistatOrderProperty($ORDER_ID)
    {
        if (defined('ADMIN_SECTION'))
            return;
        if (!$arOrder = CSaleOrder::GetByID($ORDER_ID))
            return false;

        $rsProp = CSaleOrderProps::GetList(array(), array("PERSON_TYPE_ID" => $arOrder["PERSON_TYPE_ID"], "CODE" => "ROISTAT_VISIT"));
        if (!$arProp = $rsProp->GetNext())
            return;

        $arPropFields = array(
            "ORDER_ID" => $ORDER_ID,
            "ORDER_PROPS_ID" => $arProp["ID"],
            "NAME" => GetMessage('ROISTAT_PROPERTY_NAME'),
            "CODE" => "ROISTAT_VISIT",
            "VALUE" => array_key_exists('visit', $_REQUEST) ? $_REQUEST['visit'] : $_COOKIE["roistat_visit"]
 );


        $rsPropValue = CSaleOrderPropsValue::GetList(array(), array("ORDER_ID" => $ORDER_ID, "ORDER_PROPS_ID" => $arProp["ID"]));
        if ($arPropValue = $rsPropValue->GetNext())
            CSaleOrderPropsValue::Update($arPropValue["ID"], $arPropFields); else
            CSaleOrderPropsValue::Add($arPropFields);
    }

    function OnOrderAddHandler($ID, $arFields)
    {
        CRoistat::__AddRoistatOrderProperty($ID);
    }

    function OnOrderNewSendEmailHandler($ID, &$eventName, &$arFields)
    {
        CRoistat::__AddRoistatOrderProperty($ID);
        return true;
    }
}
