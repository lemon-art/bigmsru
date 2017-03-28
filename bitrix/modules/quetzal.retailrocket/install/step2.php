<?php
if(!check_bitrix_sessid()) return;
IncludeModuleLangFile(__FILE__);

// ������ ���� ��������� ������. �������� ������ ���������� �� ������ ��������� ������������� ������.
$strError = "0";// ���������� ������� ������ ��� ������

$strEmail = '';
$srtPass = '';
$strPart_id = '';

// ��������� email
if($_POST["email"]){
    COption::SetOptionString("quetzal.retailrocket", "retail_email", $_POST["email"]);
    $strEmail = $_POST["email"];
}
else {
    $strError = "1";
}

// ��������� ������
if($_POST["pass"]){
    COption::SetOptionString("quetzal.retailrocket", "retail_pass", $_POST["pass"]);
    $strPass = $_POST["pass"];
}
else {
    $strError = $strError."2";
}

// ��������� ���� �� � ������������ ��������� �������, �������� �������� ������ � ����������� Id

if ((strlen($strEmail)>0)and(strlen($strPass)>0)){

	$strQueryText = QueryGetData(
		'api.retailrocket.ru',
		80,
		'/api/1.0/auth/',
		sprintf(
			'email=%s&password=%s',
			urlencode($strEmail),
			urlencode($strPass)
		),
		$error_number,
		$error_text,
		'POST'
	);
    $queryResult = json_decode($strQueryText);
    $strPart_id = $queryResult->PartnerId;
    $strSession = $queryResult->Session;
    if (strlen($strPart_id)<=0) {
        // ���� ������ ������ �� ������, ������ ������ �������� ���, ������� ����� �������.
		$strQueryText = QueryGetData(
			'api.retailrocket.ru',
			80,
			'/api/1.0/partner/',
			sprintf(
				'email=%s&password=%s',
				urlencode($strEmail),
				urlencode($strPass)
			),
			$error_number,
			$error_text,
			'POST'
		);
        $queryResult = json_decode($strQueryText);
        $strMessage = $queryResult->Message;
        if (strlen($strMessage)<=0) {
            // ���� ����� ������ ��� ������, �� ��������� ����������� Id
            $queryResult = json_decode($strQueryText);
            $strPart_id = $queryResult->Id;
            if($strPart_id){
                COption::SetOptionString("quetzal.retailrocket", "retail_partner_id", $strPart_id);
            }
        }
        else {
            // ���� ������ ������ �����, �� ��������� �� ������ �� ���
            if ($strMessage === "Partner with such email is already registered") {
                $strError = "4";
            }
            else{
                // ���� ������ ������ �� ������, �� ��������� ��� ������
                $strError = "3";
            }
        }
    }
    else {
        // ���� ������ ������ ������, �� ��������� ����������� Id
        COption::SetOptionString("quetzal.retailrocket", "retail_partner_id", $strPart_id);
        $strQueryText = QueryGetData(
            "api.retailrocket.ru",
            80,
            "/api/1.0/partner/$strPart_id/",
            "session=$strSession",
            $error_number,
            $error_text
        );
        $queryResult = json_decode($strQueryText);
        $strYmlLink = $queryResult->YmlUrl;
        $strBasketlLink = $queryResult->BasketUrl;
        COption::SetOptionString("quetzal.retailrocket", "retail_yml_link", $strYmlLink);
        COption::SetOptionString("quetzal.retailrocket", "retail_basket_link", $strBasketlLink);
    }

}

// ���� ����� ������ �� �������� ���������, � �� �������� ����������� Id,
if($strError === "0"){
    RegisterModule("quetzal.retailrocket"); // ������������ ������

    // ���� ����, �� ��������� ���������� JQuery
    if($_POST["jquery"] == "Y"){
        RegisterModuleDependences("main", "OnPageStart", "quetzal.retailrocket", "RetailRocketClass", "addJQueryCode", 10);
        // ������������� ����, ��� �� ���������� ��� JQ
        COption::SetOptionString("quetzal.retailrocket", "retail_set_jq", "Y");
    }

    // ������������� ������� ��� Retail Rocket
    RegisterModuleDependences("main", "OnPageStart", "quetzal.retailrocket", "RetailRocketClass", "addTrackingCode", 100);

    // ���� ������� ��������� ������, �� ������������� ��� ����������� ������� ��� ������ ���������� � �������
    if($_POST["params"]){
        COption::SetOptionString("quetzal.retailrocket", "retail_button_params", $_POST["params"]); // ��������� ������ ���������� ������
        RegisterModuleDependences("main", "OnPageStart", "quetzal.retailrocket", "RetailRocketClass", "addBasketButton", 110);
    }

    // �������� ����� � �����
    CopyDirFiles(
        $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/quetzal.retailrocket/install/components/",
        $_SERVER["DOCUMENT_ROOT"]."/bitrix/components",
        true, true
    );

    CopyDirFiles(
        $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/quetzal.retailrocket/install/admin/",
        $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin",
        true, true
    );

    CopyDirFiles(
        $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/quetzal.retailrocket/install/js/",
        $_SERVER["DOCUMENT_ROOT"]."/bitrix/js/",
        true, true
    );

    echo CAdminMessage::ShowNote(GetMessage("RR_QTZ_STEP_END_PREVIEW_TEXT"));
    echo GetMessage("RR_QTZ_STEP_END_ACCOUNT");
    echo "<p><a href='".$APPLICATION->GetCurPage()."'>".GetMessage("RR_QTZ_STEP_END_INPUT_END")."</a></p>";
}
else {
    echo CAdminMessage::ShowNote(GetMessage("RR_QTZ_STEP_SECOND"));
    echo '<div style="width:580px; padding: 10px; font-size: 12px; background-color: #ffffff; color: #555555;">';
        echo '<div style="padding: 5px; border-bottom: 2px solid #555555">';
            echo '<h2 style="font-weight: 800; margin: 0px; font-size: 40px;"><img style="padding: 0px 20px 0px 0px;" src="http://retailrocket.ru/Content/Img/promo/logo.png" alt="RetailRocket"/>';
            echo GetMessage("RR_QTZ_STEP_SECOND_PREVIEW_TEXT").'</h2>';
        echo '</div>';

        switch($strError){
            case 1:
                echo GetMessage("RR_QTZ_STEP_SECOND_ERROR_1");
                break;
            case 2:
                echo GetMessage("RR_QTZ_STEP_SECOND_ERROR_2");
                break;
            case 3:
                echo GetMessage("RR_QTZ_STEP_SECOND_ERROR_3");
                break;
            case 4:
                echo GetMessage("RR_QTZ_STEP_SECOND_ERROR_4");
                break;
            case 12:
                echo GetMessage("RR_QTZ_STEP_SECOND_ERROR_1");
                echo GetMessage("RR_QTZ_STEP_SECOND_ERROR_2");
                break;
        }
        echo '<form name="step_1" method="post" action="'.$APPLICATION->GetCurPage().'">';
            echo bitrix_sessid_post();
            echo '<table width="580px" cellspacing="0" cellpadding="0" border="0">';
                echo '<tr>'; // ������ �����
                    echo '<td style="width: 365px; font-size: 24px; padding: 5px;"></td>';
                    echo '<td>';
                        echo '<input type="hidden" name="lang" value="'.LANG.'">';
                        echo '<input type="hidden" name="id" value="quetzal.retailrocket">';
                        echo '<input type="hidden" name="install" value="Y">';
                        echo '<input type="hidden" name="step" value="1"/>';
                        echo '<input type="submit" name="submit" value="'.GetMessage("RR_QTZ_STEP_SECOND_INPUT_BACK_STEP").'" />';
                    echo '</td>';
                echo '</tr>';
            echo '</table>';
        echo '</form>';
    echo '</div>';
}
