<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!$arResult["SAVE_IN_FILE"]): ?>
<? echo '<?xml version="1.0" encoding="' . LANG_CHARSET . '"?>'; ?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="<?= $arResult["DATE"] ?>">
        <shop>
            <name><?= $arResult["SITE"] ?></name>
            <company><?= $arResult["COMPANY"] ?></company>
            <url><? if ($arParams ["HTTPS_CHECK"] == "Y"): ?><?= "https://" . $_SERVER["SERVER_NAME"] ?><? else: ?><?= "http://" . $_SERVER["SERVER_NAME"] ?><? endif ?></url>

            <currencies>
                <? if (!empty($arResult["CURRENCIES"])): ?>
                    <? foreach ($arResult["CURRENCIES"] as $k => $cur): ?>
                        <? if (!empty($cur) && $cur != 'RUR'): ?><currency id="<?= $cur ?>"<? if ($cur == 'RUB'): ?> rate="1"<? else: ?> rate="<?= $arResult["WF_AMOUNTS"][$cur] ?>"<? endif; ?>/><? endif; ?>
                    <? endforeach; ?>
                <? else: ?>
                    <currency id="<?= $arParams["CURRENCY"] ?>" rate="1"/>
                <? endif; ?>
            </currencies>

            <categories>
                <? foreach ($arResult["CATEGORIES"] as $id => $arCategory): ?>
                    <category id="<?= $id ?>"<?
                    if ($arCategory["PARENT"])
                        echo ' parentId="' . $arCategory['PARENT'] . '"';
                    ?>><?= $arCategory["NAME"] ?></category>
                          <? endforeach; ?>
            </categories>
            <? if ($arParams["LOCAL_DELIVERY_COST"] != "" and empty($arResult["DELIVERY_OPTION_SHOP"])): ?>
                <local_delivery_cost><?= $arParams["LOCAL_DELIVERY_COST"] ?></local_delivery_cost>
            <? endif ?>
            <? if (!empty($arResult["DELIVERY_OPTION_SHOP"])): ?>
                <delivery-options>
                    <? foreach ($arResult["DELIVERY_OPTION_SHOP"] as $delK => $delV): ?>
                        <option cost="<?= $delV[0] ?>" days="<?= $delV[1] ?>"<? if ($delV[2] != ""): ?> order-before="<?= $delV[2] ?>"<? endif ?>/>
                    <? endforeach ?>
                </delivery-options>
            <? endif ?>
            <? if (!empty($arResult["CPA_SHOP"])): ?>
                <cpa><?= $arResult["CPA_SHOP"] ?></cpa>
            <? endif ?>
            <? if ($arParams["ADULT_ALL"] == "Y"): ?>
                <adult>true</adult>
            <? endif ?>
            <offers>
                <? foreach ($arResult["OFFER"] as $arOffer): ?>
                    <offer id="<?= $arOffer["ID"] ?>" type="vendor.model" available="<?= $arOffer["AVAIBLE"] ?>" <? if (!empty($arOffer["GROUP_ID"])): ?>group_id="<?= $arOffer["GROUP_ID"] ?>"<? endif; ?><? if (!empty($arOffer["BID"])): ?> bid="<?= $arOffer["BID"] ?>"<? endif ?><? if (!empty($arOffer["CBID"])): ?> cbid="<?= $arOffer["CBID"] ?>"<? endif ?><? if (!empty($arOffer["FEE"])): ?> fee="<?= $arOffer["FEE"] ?>"<? endif ?>>
                        <url><?= $arOffer["URL"] ?></url>
                        <price><?= $arOffer["PRICE"] ?></price>
                        <? if (!empty($arOffer["OLD_PRICE"])): ?>
                            <oldprice><?= $arOffer["OLD_PRICE"] ?></oldprice>
                        <? endif ?>
                        <currencyId>
                            <? if (!empty($arOffer["CURRENCY"])): ?>
                                <?= $arOffer["CURRENCY"] ?>
                            <? else: ?>
                                <?= $arParams["CURRENCY"] ?>
                            <? endif; ?>
                        </currencyId>

                        <categoryId><?= $arOffer["CATEGORY"] ?></categoryId>

                        <? if ($arParams['MARKET_CATEGORY_CHECK'] == "Y"): ?>
                            <market_category><?= $arOffer["MARKET_CATEGORY"] ?></market_category>
                        <? endif; ?>

                        <? if (!empty($arOffer["PICTURE"])): ?>
                            <picture><?= $arOffer["PICTURE"] ?></picture>
                        <? endif; ?>

                        <? foreach ($arOffer["MORE_PHOTO"] as $pic): ?>
                            <picture><?= $pic ?></picture>
                        <? endforeach; ?>

                        <? if ($arOffer["STORE_OFFER"] == "true"): ?><store>true</store><? endif ?>
                        <? if ($arOffer["STORE_OFFER"] == "false"): ?><store>false</store><? endif ?>
                        <? if ($arOffer["STORE_PICKUP"] == "true"): ?><pickup>true</pickup><? endif ?>
                        <? if ($arOffer["STORE_PICKUP"] == "false"): ?><pickup>false</pickup><? endif ?>
                        <? if ($arOffer["STORE_DELIVERY"] == "true"): ?><delivery>true</delivery><? endif ?>
                        <? if ($arOffer["STORE_DELIVERY"] == "false"): ?><delivery>false</delivery><? endif ?>
                        <? if (is_numeric($arOffer["LOCAL_DELIVERY_COST_OFFER"]) and empty($arOffer["DELIVERY_OPTIONS_EX"])): ?><local_delivery_cost><?= $arOffer["LOCAL_DELIVERY_COST_OFFER"] ?></local_delivery_cost><? endif ?>
                        <? if (!empty($arOffer["DELIVERY_OPTIONS_EX"]) and count($arOffer["DELIVERY_OPTIONS_EX"]) > 0): ?>
                            <delivery-options>
                                <? foreach ($arOffer["DELIVERY_OPTIONS_EX"] as $optK => $opt): ?>
                                    <? if ($opt[0] != ""): ?>
                                        <option cost="<?= $opt[0]; ?>" days="<?= $opt[1] ?>"<? if ($opt[2] != ""): ?> order-before="<?= $opt[2] ?>"<? endif ?>/>
                                    <? endif ?>
                                <? endforeach ?>
                            </delivery-options>
                        <? endif ?>
                        <? if (!empty($arOffer["OUTLETS"]) and count($arOffer["OUTLETS"]) > 0): ?>
                            <outlets>
                                <? foreach ($arOffer["OUTLETS"] as $outK => $out): ?>
                                    <outlet id="<?= $out[0] ?>" instock="<?= $out[1] ?>"<? if ($out[2] != ""): ?> booking="<?= $out[2] ?>"<? endif ?>/>
                                <? endforeach; ?>
                            </outlets>
                        <? endif; ?>
                        <vendor>
                            <? if (!empty($arOffer["DEVELOPER"])): ?>
                                <?= $arOffer["DEVELOPER"] ?>
                            <? else: ?>
                                <?= $arOffer["DISPLAY_PROPERTIES"][$arParams["DEVELOPER"]]["DISPLAY_VALUE"] ?>
                            <? endif; ?>
                        </vendor>

                        <? if ($arOffer["DISPLAY_PROPERTIES"][$arParams["VENDOR_CODE"]]["DISPLAY_VALUE"]): ?>
                            <vendorCode>
                                <?= $arOffer["DISPLAY_PROPERTIES"][$arParams["VENDOR_CODE"]]["DISPLAY_VALUE"] ?>
                            </vendorCode>
                        <? endif; ?>
                        <? if (!empty($arOffer["PREFIX_PROP"])): ?>
                            <typePrefix><?= $arOffer["PREFIX_PROP"] ?></typePrefix>
                        <? endif; ?>
                        <? if (!empty($arOffer["DISPLAY_PROPERTIES"][$arParams["MODEL"]]["DISPLAY_VALUE"]) && !empty($arOffer["DISPLAY_PROPERTIES"][$arParams["SERIES"]]["DISPLAY_VALUE"])): ?>
                            <model><?= $arOffer["DISPLAY_PROPERTIES"][$arParams["SERIES"]]["DISPLAY_VALUE"] ?> <?= $arOffer["DISPLAY_PROPERTIES"][$arParams["MODEL"]]["DISPLAY_VALUE"] ?></model>

                        <? elseif (!empty($arOffer["DISPLAY_PROPERTIES"][$arParams["MODEL"]]["DISPLAY_VALUE"])): ?>
                            <model><?= $arOffer["DISPLAY_PROPERTIES"][$arParams["MODEL"]]["DISPLAY_VALUE"] ?></model>	
                        <? else: ?>
                            <model><?= $arOffer["MODEL"] ?></model>
                        <? endif; ?>

                        <? if (!empty($arOffer["DESCRIPTION"]) or ! empty($arOffer["DOP_PROPS"])): ?>
                            <description><? if (!empty($arOffer["DOP_PROPS"])): ?><?= $arOffer["DOP_PROPS"] ?>. <? endif ?><?= $arOffer["DESCRIPTION"] ?></description>
                        <? endif; ?>

                        <? if ($arOffer["SALES_NOTES"]): ?><sales_notes><?= $arOffer["SALES_NOTES"] ?></sales_notes><? endif ?>

                        <? if ($arOffer["DISPLAY_PROPERTIES"][$arParams["MANUFACTURER_WARRANTY"]]["DISPLAY_VALUE"]): ?>
                            <manufacturer_warranty>
                                <?= $arOffer["DISPLAY_PROPERTIES"][$arParams["MANUFACTURER_WARRANTY"]]["DISPLAY_VALUE"] ?>
                            </manufacturer_warranty>
                        <? endif; ?>

                        <? if (!empty($arOffer["DISPLAY_PROPERTIES"][$arParams["COUNTRY"]]["DISPLAY_VALUE"])): ?>
                            <country_of_origin>
                                <?= $arOffer["DISPLAY_PROPERTIES"][$arParams["COUNTRY"]]["DISPLAY_VALUE"] ?>
                            </country_of_origin>
                        <? elseif (!empty($arOffer["COUNTRY"])): ?>
                            <country_of_origin>
                                <?= $arOffer["COUNTRY"] ?>
                            </country_of_origin>
                        <? endif; ?>
                        <? if ($arOffer["ADULT"] == "true"): ?><adult>true</adult><? endif ?>
                        <? if (is_numeric($arOffer["AGE_CATEGORY"])): ?>
                            <age unit="<?= $arParams["AGE_CATEGORY_UNIT"] ?>"><?= $arOffer["AGE_CATEGORY"] ?></age>
                        <? endif ?>

                        <? if (is_numeric($arOffer["CPA_OFFERS"])): ?>
                            <cpa><?= $arOffer["CPA_OFFERS"] ?></cpa>
                        <? endif ?>
                        <? if (!empty($arOffer["RECOMMENDATION"])): ?>
                            <rec><?= $arOffer["RECOMMENDATION"] ?></rec>
                        <? endif ?>
                        <? if ($arOffer["EXPIRY"]): ?>
                            <expiry><?= $arOffer["EXPIRY"] ?></expiry>
                        <? endif ?>
                        <? if ($arOffer["WEIGHT"]): ?>
                            <weight><?= $arOffer["WEIGHT"] ?></weight>
                        <? endif ?>
                        <? if ($arOffer["DIMENSIONS"]): ?>
                            <dimensions><?= $arOffer["DIMENSIONS"] ?></dimensions>
                        <? endif ?>

                        <? foreach ($arParams as $k => $v): ?>
                            <? if (is_array($arOffer['LIST_PROPERTIES'])): ?>
                                <? foreach ($arOffer["LIST_PROPERTIES"] as $key => $val): ?>
                                    <? if ($key == $k && !in_array($key, $arResult["FOR_DELETE"])): ?>
                                        <? if (!empty($arOffer["DISPLAY_PROPERTIES"][$v]["DISPLAY_VALUE"])): ?>
                                            <?
                                            $dispName = &$arOffer["DISPLAY_PROPERTIES"][$v]['DISPLAY_NAME'];
                                            if (in_array($k, $arResult["CLOTHES_PARAMS"]))
                                            {
                                                $dispName = GetMessage($k);
                                            }
                                            ?>
                                            <param name="<?= $arOffer["DISPLAY_PROPERTIES"][$v]["DISPLAY_NAME"] ?>" <? if (!empty($arOffer["UNIT"][$k])): ?> unit="<?= $arOffer["UNIT"][$k] ?>"<? endif; ?>>
                                            <?= $arOffer["DISPLAY_PROPERTIES"][$v]["DISPLAY_VALUE"] ?>
                                            </param>
                                        <? endif ?>
                                    <? endif ?>
                                <? endforeach ?>
                            <? endif ?>
                        <? endforeach ?>

                        <? foreach ($arParams["PARAMS"] as $k => $v): ?>
                            <? foreach ($arOffer["LIST_PROPERTIES"]["PARAMS"] as $key => $val): ?>
                                <? if ($key == $v && !in_array($key, $arResult["FOR_DELETE"])): ?>
                                    <? if (!empty($arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$v]["DISPLAY_VALUE"])): ?>
                                        <param name="<?= $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$v]["DISPLAY_NAME"] ?>"<? if (!empty($arOffer["UNIT"][$v])): ?> unit="<?= $arOffer["UNIT"][$v] ?>"<? endif; ?>><?= $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$v]["DISPLAY_VALUE"] ?></param>
                                    <? endif ?>
                                <? endif ?>
                            <? endforeach ?>
                        <? endforeach ?>

                        <? if (is_array($arOffer['DISPLAY_CHARACTERISTICS'])): ?>
                            <? foreach ($arOffer["DISPLAY_CHARACTERISTICS"] as $code => $value): ?>
                                <? if (!empty($value["DISPLAY_VALUE"])): ?>
                                    <param name="<?= $value["DISPLAY_NAME"] ?>"><?= $value["DISPLAY_VALUE"] ?></param>
                                <? endif ?>
                            <? endforeach ?>
                        <? endif ?>

                    </offer>
                <? endforeach ?>
            </offers>
        </shop>
    </yml_catalog>
    <?
else:
    if (!function_exists("itemsCycle"))
    {

        function itemsCycle(&$savedXML, $arResult, $arParams) {
            foreach ($arResult["OFFER"] as $arOffer):
                $savedXML .= '<offer id="' . $arOffer["ID"] . '" type="vendor.model" available="' . $arOffer["AVAIBLE"] . '"';
                if (!empty($arOffer["GROUP_ID"]))
                    $savedXML .= ' group_id="' . $arOffer["GROUP_ID"] . '"';
                if (!empty($arOffer["BID"]))
                    $savedXML .= ' bid="' . $arOffer["BID"] . '"';
                if (!empty($arOffer["CBID"]))
                    $savedXML .= ' cbid="' . $arOffer["CBID"] . '"';
                if (!empty($arOffer["FEE"]))
                    $savedXML .= ' fee="' . $arOffer["FEE"] . '"';
                $savedXML .= '>';
                $savedXML .= '<url>' . $arOffer["URL"] . '</url>';
                $savedXML .= '<price>' . $arOffer["PRICE"] . '</price>';
                if (!empty($arOffer["OLD_PRICE"])):
                    $savedXML .= '<oldprice>' . $arOffer["OLD_PRICE"] . '</oldprice>';
                endif;
                $savedXML .= '<currencyId>';
                if (!empty($arOffer["CURRENCY"])):
                    $savedXML .= $arOffer["CURRENCY"];
                else:
                    $savedXML .= $arParams["CURRENCY"];
                endif;
                $savedXML .= '</currencyId>';
                $savedXML .= '<categoryId>' . $arOffer["CATEGORY"] . '</categoryId>';

                if ($arParams['MARKET_CATEGORY_CHECK'] == "Y"):
                    $savedXML .= '<market_category>' . $arOffer["MARKET_CATEGORY"] . '</market_category>';
                endif;

                if (!empty($arOffer["PICTURE"])):
                    $savedXML .= '<picture>' . $arOffer["PICTURE"] . '</picture>';
                endif;

                foreach ($arOffer["MORE_PHOTO"] as $pic):
                    $savedXML .= '<picture>' . $pic . '</picture>';
                endforeach;

                if ($arOffer["STORE_OFFER"] == "true"):
                    $savedXML .= '<store>true</store>';
                endif;
                if ($arOffer["STORE_OFFER"] == "false"):
                    $savedXML .= '<store>false</store>';
                endif;
                if ($arOffer["STORE_PICKUP"] == "true"):
                    $savedXML .= '<pickup>true</pickup>';
                endif;
                if ($arOffer["STORE_PICKUP"] == "false"):
                    $savedXML .= '<pickup>false</pickup>';
                endif;
                if ($arOffer["STORE_DELIVERY"] == "true"):
                    $savedXML .= '<delivery>true</delivery>';
                endif;
                if ($arOffer["STORE_DELIVERY"] == "false"):
                    $savedXML .= '<delivery>false</delivery>';
                endif;
                if (is_numeric($arOffer["LOCAL_DELIVERY_COST_OFFER"]) and empty($arOffer["DELIVERY_OPTIONS_EX"])):
                    $savedXML .= '<local_delivery_cost>' . $arOffer["LOCAL_DELIVERY_COST_OFFER"] . '</local_delivery_cost>';
                endif;
                if (!empty($arOffer["DELIVERY_OPTIONS_EX"]) and count($arOffer["DELIVERY_OPTIONS_EX"]) > 0):
                    $savedXML .= '<delivery-options>';
                    foreach ($arOffer["DELIVERY_OPTIONS_EX"] as $optK => $opt):
                        if ($opt[0] != ""):
                            $savedXML .= '<option cost="' . $opt[0] . '" days="' . $opt[1] . '"' . ($opt[2] != '' ? ' order-before="' . $opt[2] . '"' : '') . '/>';
                        endif;
                    endforeach;
                    $savedXML .= '</delivery-options>';
                endif;
                if (!empty($arOffer["OUTLETS"]) and count($arOffer["OUTLETS"]) > 0):
                    $savedXML .= '<outlets>';
                    foreach ($arOffer["OUTLETS"] as $outK => $out):
                        $savedXML .= '<outlet id="' . $out[0] . '" instock="' . $out[1] . '"' . ($out[2] != '' ? ' booking="' . $out[2] . '"' : '') . '/>';
                    endforeach;
                    $savedXML .= '</outlets>';
                endif;
                $savedXML .= '<vendor>';
                if (!empty($arOffer["DEVELOPER"])):
                    $savedXML .= $arOffer["DEVELOPER"];
                else:
                    $savedXML .= $arOffer["DISPLAY_PROPERTIES"][$arParams["DEVELOPER"]]["DISPLAY_VALUE"];
                endif;
                $savedXML .= '</vendor>';

                if ($arOffer["DISPLAY_PROPERTIES"][$arParams["VENDOR_CODE"]]["DISPLAY_VALUE"]):
                    $savedXML .= '<vendorCode>' . $arOffer["DISPLAY_PROPERTIES"][$arParams["VENDOR_CODE"]]["DISPLAY_VALUE"] . '</vendorCode>';
                endif;
                if (!empty($arOffer["PREFIX_PROP"])):
                    $savedXML .= '<typePrefix>' . $arOffer["PREFIX_PROP"] . '</typePrefix>';
                endif;
                if (!empty($arOffer["DISPLAY_PROPERTIES"][$arParams["MODEL"]]["DISPLAY_VALUE"]) && !empty($arOffer["DISPLAY_PROPERTIES"][$arParams["SERIES"]]["DISPLAY_VALUE"])):
                    $savedXML .= '<model>' . $arOffer["DISPLAY_PROPERTIES"][$arParams["SERIES"]]["DISPLAY_VALUE"] . $arOffer["DISPLAY_PROPERTIES"][$arParams["MODEL"]]["DISPLAY_VALUE"] . '</model>';

                elseif (!empty($arOffer["DISPLAY_PROPERTIES"][$arParams["MODEL"]]["DISPLAY_VALUE"])):
                    $savedXML .= '<model>' . $arOffer["DISPLAY_PROPERTIES"][$arParams["MODEL"]]["DISPLAY_VALUE"] . '</model>';
                else:
                    $savedXML .= '<model>' . $arOffer["MODEL"] . '</model>';
                endif;

                if (!empty($arOffer["DESCRIPTION"]) or ! empty($arOffer["DOP_PROPS"])):
                    if (!empty($arOffer["DOP_PROPS"])):
                        $savedXML .= '<description>' . $arOffer["DOP_PROPS"] . ". " . $arOffer["DESCRIPTION"] . '</description>';
                    else:
                        $savedXML .= '<description>' . $arOffer["DESCRIPTION"] . '</description>';
                    endif;
                endif;

                if ($arOffer["SALES_NOTES"]):
                    $savedXML .= '<sales_notes>' . $arOffer["SALES_NOTES"] . '</sales_notes>';
                endif;

                if ($arOffer["DISPLAY_PROPERTIES"][$arParams["MANUFACTURER_WARRANTY"]]["DISPLAY_VALUE"]):
                    $savedXML .= '<manufacturer_warranty>' . $arOffer["DISPLAY_PROPERTIES"][$arParams["MANUFACTURER_WARRANTY"]]["DISPLAY_VALUE"] . '</manufacturer_warranty>';
                endif;

                if (!empty($arOffer["DISPLAY_PROPERTIES"][$arParams["COUNTRY"]]["DISPLAY_VALUE"])):
                    $savedXML .= '<country_of_origin>' . $arOffer["DISPLAY_PROPERTIES"][$arParams["COUNTRY"]]["DISPLAY_VALUE"] . '</country_of_origin>';
                elseif (!empty($arOffer["COUNTRY"])):
                    $savedXML .= '<country_of_origin>' . $arOffer["COUNTRY"] . '</country_of_origin>';
                endif;
                if ($arOffer["ADULT"] == "true"):
                    $savedXML .= '<adult>true</adult>';
                endif;
                if (is_numeric($arOffer["AGE_CATEGORY"])):
                    $savedXML .= '<age unit="' . $arParams["AGE_CATEGORY_UNIT"] . '">' . $arOffer["AGE_CATEGORY"] . '</age>';
                endif;

                if (is_numeric($arOffer["CPA_OFFERS"])):
                    $savedXML .= '<cpa>' . $arOffer["CPA_OFFERS"] . '</cpa>';
                endif;
                if (!empty($arOffer["RECOMMENDATION"])):
                    $savedXML .= '<rec>' . $arOffer["RECOMMENDATION"] . '</rec>';
                endif;
                if ($arOffer["EXPIRY"]):
                    $savedXML .= '<expiry>' . $arOffer["EXPIRY"] . '</expiry>';
                endif;
                if ($arOffer["WEIGHT"]):
                    $savedXML .= '<weight>' . $arOffer["WEIGHT"] . '</weight>';
                endif;
                if ($arOffer["DIMENSIONS"]):
                    $savedXML .= '<dimensions>' . $arOffer["DIMENSIONS"] . '</dimensions>';
                endif;
                foreach ($arParams as $k => $v):
                    if (is_array($arOffer['LIST_PROPERTIES'])):
                        foreach ($arOffer["LIST_PROPERTIES"] as $key => $val):
                            if ($key == $k && !in_array($key, $arResult["FOR_DELETE"])):
                                if (!empty($arOffer["DISPLAY_PROPERTIES"][$v]["DISPLAY_VALUE"])):
                                    $dispName = &$arOffer["DISPLAY_PROPERTIES"][$v]['DISPLAY_NAME'];
                                    if (in_array($k, $arResult["CLOTHES_PARAMS"]))
                                    {
                                        $dispName = GetMessage($k);
                                    }
                                    $savedXML .= '<param name="' . $arOffer["DISPLAY_PROPERTIES"][$v]["DISPLAY_NAME"] . '"';
                                    if (!empty($arOffer["UNIT"][$k]))
                                    {
                                        $savedXML .= ' unit="' . $arOffer["UNIT"][$k] . '"';
                                    };
                                    $savedXML .= '>';
                                    $savedXML .= $arOffer["DISPLAY_PROPERTIES"][$v]["DISPLAY_VALUE"];
                                    $savedXML .= '</param>';
                                endif;
                            endif;
                        endforeach;
                    endif;
                endforeach;

                foreach ($arParams["PARAMS"] as $k => $v):
                    foreach ($arOffer["LIST_PROPERTIES"]["PARAMS"] as $key => $val):
                        if ($key == $v && !in_array($key, $arResult["FOR_DELETE"])):
                            if (!empty($arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$v]["DISPLAY_VALUE"])):
                                $savedXML .= '<param name="' . $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$v]["DISPLAY_NAME"] . '"';
                                if (!empty($arOffer["UNIT"][$v]))
                                    $savedXML .= ' unit="' . $arOffer["UNIT"][$v] . '"';
                                $savedXML .= '>';
                                $savedXML .= $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$v]["DISPLAY_VALUE"];
                                $savedXML .= '</param>';
                            endif;
                        endif;
                    endforeach;
                endforeach;

                if (is_array($arOffer['DISPLAY_CHARACTERISTICS'])):
                    foreach ($arOffer["DISPLAY_CHARACTERISTICS"] as $code => $value):
                        if (!empty($value["DISPLAY_VALUE"])):
                            $savedXML .= '<param name="' . $value["DISPLAY_NAME"] . '">' . $value["DISPLAY_VALUE"] . '</param>';
                        endif;
                    endforeach;
                endif;

                $savedXML .= '</offer>';
            endforeach;
        }

    }
    if (!function_exists("xmlHeader"))
    {

        function xmlHeader(&$savedXML, $arResult, $arParams) {
            $savedXML = '<?xml version="1.0" encoding="' . LANG_CHARSET . '"?>';
            $savedXML .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
            $savedXML .= '<yml_catalog date="' . $arResult["DATE"] . '">';
            $savedXML .= '<shop>';
            $savedXML .= '<name>' . $arResult["SITE"] . '</name>';
            $savedXML .= '<company>' . $arResult["COMPANY"] . '</company>';
            $savedXML .= '<url>';
            if ($arParams ["HTTPS_CHECK"] == "Y"):
                $savedXML .= "https://" . $_SERVER["SERVER_NAME"];
            else:
                $savedXML .= "http://" . $_SERVER["SERVER_NAME"];
            endif;
            $savedXML .= '</url>';
            $savedXML .= '<currencies>';
            if (!empty($arResult["CURRENCIES"])):
                foreach ($arResult["CURRENCIES"] as $k => $cur):
                    if (!empty($cur) && $cur != 'RUR'):
                        $savedXML .= '<currency id="' . $cur . '"' . (($cur == 'RUB') ? ' rate="1"' : ' rate="' . $arResult["WF_AMOUNTS"][$cur] . '"') . '/>';
                    endif;
                endforeach;
            else:
                $savedXML .= '<currency id="' . $arParams["CURRENCY"] . '" rate="1"/>';
            endif;
            $savedXML .= '</currencies>';

            $savedXML .= '<categories>';
            foreach ($arResult["CATEGORIES"] as $arCategory):
                $savedXML .= '<category id="' . $arCategory["ID"] . '"';
                if ($arCategory["PARENT"])
                    $savedXML .= ' parentId="' . $arCategory['PARENT'] . '"';
                $savedXML .= '>' . $arCategory["NAME"] . '</category>';
            endforeach;
            $savedXML .= '</categories>';

            if ($arParams["LOCAL_DELIVERY_COST"] != "" and empty($arResult["DELIVERY_OPTION_SHOP"])):
                $savedXML .= '<local_delivery_cost>' . $arParams["LOCAL_DELIVERY_COST"] . '</local_delivery_cost>';
            endif;
            if (!empty($arResult["DELIVERY_OPTION_SHOP"])):
                $savedXML .= '<delivery-options>';
                foreach ($arResult["DELIVERY_OPTION_SHOP"] as $delK => $delV):
                    $savedXML .= '<option cost="' . $delV[0] . '" days="' . $delV[1] . '"' . ($delV[2] != '' ? ' order-before="' . $delV[2] . '"' : '') . '/>';
                endforeach;
                $savedXML .= '</delivery-options>';
            endif;
            if (!empty($arResult["CPA_SHOP"])):
                $savedXML .= '<cpa>' . $arResult["CPA_SHOP"] . '</cpa>';
            endif;
            if ($arParams["ADULT_ALL"] == "Y"):
                $savedXML .= '<adult>true</adult>';
            endif;
            $savedXML .= '<offers>';
        }

    }
    $wf_page = $APPLICATION->GetCurDir();
    $permanent_file = $_SERVER["DOCUMENT_ROOT"] . $wf_page . '/saved_file.xml';
    $temp_file = $_SERVER["DOCUMENT_ROOT"] . $wf_page . '/saved_file_temp.xml';
    $arParams["BIG_CATALOG_PROP"] = trim($arParams["BIG_CATALOG_PROP"]);
    if (!empty($arParams["BIG_CATALOG_PROP"]) and $_SESSION["WFYM_FINISH"] != "Yes")
    {
        if ((($arResult["WF_CURR"] - $arParams["BIG_CATALOG_PROP"]) < $arResult["WF_FULL"]))
        {
            if ($arResult["WF_CURR"] < $arResult["WF_FULL"])
            {
                if ($arResult["WF_NUM"] == 1)
                {
                    xmlHeader($savedXML, $arResult, $arParams);
                    itemsCycle($savedXML, $arResult, $arParams);
                    file_put_contents("saved_file_temp.xml", $savedXML, LOCK_EX);
                }
                else
                {
                    itemsCycle($savedXML, $arResult, $arParams);
                    file_put_contents("saved_file_temp.xml", $savedXML, FILE_APPEND | LOCK_EX);
                }
                $arResult["WF_NUM"] ++;
                if ($arResult["WF_NUM"] == 21)
                {
                    $savedXML = '</offers>
</shop>
    </yml_catalog>';
                    file_put_contents("saved_file_temp.xml", $savedXML, FILE_APPEND | LOCK_EX);
                    echo GetMessage("LOAD_FAIL");
                    $_SESSION["WFYM_FINISH"] = "Yes";
                    if (file_exists($temp_file))
                    {
                        if (file_exists($permanent_file))
                            unlink($permanent_file);
                        rename($temp_file, $permanent_file);
                    }
                }
                else
                {
                    $url = $APPLICATION->GetCurPageParam("WF_PAGE={$arResult["WF_NUM"]}", array("WF_PAGE"));
                    LocalRedirect($url);
                }
            }
            else
            {
                if ($arResult["WF_NUM"] == 1)
                {
                    xmlHeader($savedXML, $arResult, $arParams);
                    itemsCycle($savedXML, $arResult, $arParams);
                    $savedXML .= '</offers>
      </shop>
    </yml_catalog>';
                    file_put_contents("saved_file_temp.xml", $savedXML, LOCK_EX);
                    echo GetMessage("FILE_SAVED_TO", array("#URL#" => $APPLICATION->GetCurDir() . "saved_file.xml"));
                    $_SESSION["WFYM_FINISH"] = "Yes";
                    if (file_exists($temp_file))
                    {
                        if (file_exists($permanent_file))
                            unlink($permanent_file);
                        rename($temp_file, $permanent_file);
                    }
                }
                else
                {
                    itemsCycle($savedXML, $arResult, $arParams);
                    $savedXML .= '</offers>
      </shop>
    </yml_catalog>';
                    file_put_contents("saved_file_temp.xml", $savedXML, FILE_APPEND | LOCK_EX);
                    echo GetMessage("FILE_SAVED_TO", array("#URL#" => $wf_page . "saved_file.xml"));
                    $_SESSION["WFYM_FINISH"] = "Yes";
                    if (file_exists($temp_file))
                    {
                        if (file_exists($permanent_file))
                            unlink($permanent_file);
                        rename($temp_file, $permanent_file);
                    }
                }
            }
        }
    }
    else
    {
        xmlHeader($savedXML, $arResult, $arParams);
        itemsCycle($savedXML, $arResult, $arParams);
        $savedXML .= '</offers>
      </shop>
    </yml_catalog>';
        file_put_contents("saved_file.xml", $savedXML, LOCK_EX);
        echo GetMessage("FILE_SAVED_TO", array("#URL#" => $APPLICATION->GetCurDir() . "saved_file.xml"));
    }
endif;

