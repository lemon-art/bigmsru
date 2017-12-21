<?
if(!check_bitrix_sessid()) return;
IncludeModuleLangFile(__FILE__);

// Первый этап установки модуля. Сбор данных пользователя.

    echo CAdminMessage::ShowNote(GetMessage("RR_QTZ_STEP_FIRST"));
    echo '<div style="width:580px; padding: 10px; font-size: 12px; background-color: #ffffff; color: #555555;">';
        echo '<div style="padding: 5px; border-bottom: 2px solid #555555">';
            echo '<img src="http://retailrocket.ru/Content/Img/promo/logo.png" alt="RetailRocket"/>';
            //echo '<h2 style="font-weight: 800;">'.GetMessage("RR_QTZ_STEP_FIRST_PREVIEW_TEXT").'</h2>';
        echo '</div>';
        echo '<div style="font-style: italic;">';
            echo GetMessage("RR_QTZ_STEP_FIRST_TEXT");
        echo '<div>';
        echo '<form name="step_1" method="post" action="'.$APPLICATION->GetCurPage().'">';
            echo bitrix_sessid_post();

            echo '<table style="font-style: normal; padding: 0px 0px 20px 0px; border-bottom: 1px solid #555555; font-weight: bold;" width="580px" cellspacing="0" cellpadding="0" border="0">';
                echo '<tr>'; // Поле для ввода email
                    echo '<td style="width:150px;padding: 5px; ">';
                        echo GetMessage("RR_QTZ_STEP_FIRST_INPUT_EMAIL");
                    echo '</td>';
                    echo '<td style="padding: 5px; ">';
                        echo '<input type="email" name="email" value=""></input>';
                    echo '</td>';
                echo '</tr>';
                echo '<tr>'; // Поле для ввода пароля
                    echo '<td style="width:150px; padding: 5px; ">';
                        echo GetMessage("RR_QTZ_STEP_FIRST_INPUT_PASS");
                    echo '</td>';
                    echo '<td style="padding: 5px; ">';
                        echo '<input type="password" name="pass" value=""></input>';
                    echo '</td>';
                echo '</tr>';
            echo '</table>';

            echo GetMessage("RR_QTZ_STEP_FIRST_BUTTON_PARAM_TEXT");

            echo '<table style="padding: 0px 0px 20px 0px; border-bottom: 1px solid #555555;" width="580px" cellspacing="0" cellpadding="0" border="0">';
                echo '<tr>'; // Параметры кнопок добавления в корзину
                    echo '<td style="width:300px; padding: 5px; vertical-align:top; font-weight: bold; font-style: normal;">';
                        echo GetMessage("RR_QTZ_STEP_FIRST_BUTTON_PARAM");
                    echo '</td>';
                    echo '<td style="padding: 5px; font-style: normal;">';
                        echo '<textarea rows="5" cols="50" name="params">a.js_buy_btn;data-id</textarea>';
                    echo '</td>';
                echo '</tr>';
            echo '</table>';

            echo GetMessage("RR_QTZ_STEP_FIRST_INPUT_JQ_TEXT");

            echo '<table style="padding: 0px 0px 20px 0px; border-bottom: 1px solid #555555;" width="580px" cellspacing="0" cellpadding="0" border="0">';
                echo '<tr>'; // Подключение JQuery
                    echo '<td style="width:300px; padding: 5px; font-weight: bold; font-style: normal;">';
                        echo GetMessage("RR_QTZ_STEP_FIRST_INPUT_JQ");
                    echo '</td>';
                    echo '<td style="padding: 5px; font-style: normal;">';
                        echo '<input type="checkbox" name="jquery" value="Y"></input>';
                    echo '</td>';
                echo '</tr>';
            echo '</table>';

            echo '<table style="padding: 20px 0px 20px 0px;" width="580px" cellspacing="0" cellpadding="0" border="0">';
                echo '<tr>'; // Кнопка далее
                    echo '<td style="width: 85%; padding: 5px; font-style: normal;"></td>';
                    echo '<td>';
                        echo '<input type="hidden" name="lang" value="'.LANG.'">';
                        echo '<input type="hidden" name="id" value="quetzal.retailrocket">';
                        echo '<input type="hidden" name="install" value="Y">';
                        echo '<input type="hidden" name="step" value="2"/>';
                        echo '<input type="submit" name="submit" value="'.GetMessage("RR_QTZ_STEP_FIRST_INPUT_NEXT_STEP").'" />';
                    echo '</td>';
                echo '</tr>';

            echo '</table>';
        echo '</form>';
    echo '</div>';