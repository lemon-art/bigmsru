<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");
use Bitrix\Main\Loader;
Loader::includeModule('search');

$arParams = array(
    "COMPONENT_TEMPLATE" => "catalog",
    "IBLOCK_TYPE" => "1c_catalog",
    "IBLOCK_ID" => Array(10, 12),
    "HIDE_NOT_AVAILABLE" => "N",
    "TEMPLATE_THEME" => "blue",
    "COMMON_SHOW_CLOSE_POPUP" => "Y",
    "SHOW_DISCOUNT_PERCENT" => "Y",
    "SHOW_OLD_PRICE" => "Y",
    "DETAIL_SHOW_MAX_QUANTITY" => "N",
    "MESS_BTN_BUY" => "Купить",
    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
    "MESS_BTN_COMPARE" => "Сравнение",
    "MESS_BTN_DETAIL" => "Подробнее",
    "MESS_NOT_AVAILABLE" => "Нет в наличии",
    "DETAIL_USE_VOTE_RATING" => "Y",
    "DETAIL_USE_COMMENTS" => "Y",
    "DETAIL_BRAND_USE" => "N",
    "SEF_MODE" => "Y",
    "AJAX_MODE" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_ADDITIONAL" => "",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "36000000",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "Y",
    "SET_STATUS_404" => "Y",
    "SET_TITLE" => "Y",
    "ADD_SECTIONS_CHAIN" => "Y",
    "ADD_ELEMENT_CHAIN" => "N",
    "USE_ELEMENT_COUNTER" => "Y",
    "USE_SALE_BESTSELLERS" => "N",
    "USE_FILTER" => "Y",
    "FILTER_VIEW_MODE" => "VERTICAL",
    "USE_REVIEW" => "Y",
    "ACTION_VARIABLE" => "action",
    "PRODUCT_ID_VARIABLE" => "id",
    "USE_COMPARE" => "Y",
    "PRICE_CODE" => array(
        0 => "Интернет",
    ),
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => "1",
    "PRICE_VAT_INCLUDE" => "Y",
    "PRICE_VAT_SHOW_VALUE" => "N",
    "CONVERT_CURRENCY" => "N",
    "BASKET_URL" => "/basket/",
    "USE_PRODUCT_QUANTITY" => "N",
    "PRODUCT_QUANTITY_VARIABLE" => "",
    "ADD_PROPERTIES_TO_BASKET" => "Y",
    "PRODUCT_PROPS_VARIABLE" => "prop",
    "PARTIAL_PRODUCT_PROPERTIES" => "N",
    "PRODUCT_PROPERTIES" => array(
    ),
    "USE_COMMON_SETTINGS_BASKET_POPUP" => "N",
    "COMMON_ADD_TO_BASKET_ACTION" => "",
    "TOP_ADD_TO_BASKET_ACTION" => "ADD",
    "SECTION_ADD_TO_BASKET_ACTION" => "ADD",
    "DETAIL_ADD_TO_BASKET_ACTION" => array(
        0 => "BUY",
        1 => "ADD",
    ),
    "SHOW_TOP_ELEMENTS" => "N",
    "TOP_ELEMENT_COUNT" => "9",
    "TOP_LINE_ELEMENT_COUNT" => "3",
    "TOP_ELEMENT_SORT_FIELD" => "sort",
    "TOP_ELEMENT_SORT_ORDER" => "asc",
    "TOP_ELEMENT_SORT_FIELD2" => "id",
    "TOP_ELEMENT_SORT_ORDER2" => "desc",
    "TOP_PROPERTY_CODE" => array(
        0 => "",
        1 => "",
    ),
    "SECTION_COUNT_ELEMENTS" => "N",
    "SECTION_TOP_DEPTH" => "4",
    "SECTIONS_VIEW_MODE" => "LIST",
    "SECTIONS_SHOW_PARENT_NAME" => "Y",
    "PAGE_ELEMENT_COUNT" => "52",
    "LINE_ELEMENT_COUNT" => "4",
    /*"ELEMENT_SORT_FIELD" => "CATALOG_QUANTITY",
    "ELEMENT_SORT_ORDER" => "desc",
    "ELEMENT_SORT_FIELD2" => "id",
    "ELEMENT_SORT_ORDER2" => "desc",*/
    "LIST_PROPERTY_CODE" => array(
        0 => "ELEKTRICHESKAYA_MOSHCHNOST_NAPRYAZHENIE_VT_V",
        1 => "PRISOEDINITELNYY_RAZMER",
        2 => "MOSHCHNOST_ELEKTRICHESKAYA_KVT",
        3 => "GARANTIYA_LET",
        4 => "CML2_ARTICLE",
        5 => "VES_NETTO_BRUTTO_KG",
        6 => "CML2_MANUFACTURER",
        7 => "SHIRINA_SM",
        8 => "GLUBINA_MM",
        9 => "VYSOTA_SM",
        10 => "MATERIAL",
        11 => "MAKSIMALNAYA_TEMPERATURA_S",
        12 => "NAPOR_M",
        13 => "PROPUSKNAYA_SPOSOBNOST_KVS_M_CHAS",
        14 => "TEMPERATURA_RABOCHEY_SREDY_S",
        15 => "TOLSHCHINA_MM",
        16 => "BREND",
        17 => "DLINA_SM",
        18 => "OBYEM_L",
        19 => "RABOCHEE_DAVLENIE_BAR",
        20 => "GABARITNYE_RAZMERY_MM",
        21 => "VNUTRENNIY_BAK",
        22 => "MOSHCHNOST_TEPLOOBMENNIKA_KVT",
        23 => "VSTROENNYY_TEN_KVT",
        24 => "PODSOEDINENIE_KONTURA_OTOPLENIYA",
        25 => "PODSOEDINENIE_KONTURA_GVS",
        26 => "PROIZVODITELNOST_M_CHAS",
        27 => "POVERKHNOST_NAGREVA_M",
        28 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_25_L_M",
        29 => "TIP_MONTAZHA",
        30 => "KAMERA_SGORANIYA",
        31 => "DIAMETR_DYMOKHODA_MM",
        32 => "PODSOEDINENIE_KONTURA_KHVS",
        33 => "MEZHOSEVOE_RASSTOYANIE_MM",
        34 => "TEPLOOTDACHA_VT",
        35 => "STATUS_NALICHIYA_NA_SKLADE",
        36 => "TSVET",
        37 => "KRANBUKSA",
        38 => "AERATOR",
        39 => "TIP",
        40 => "KARTRIDZH",
        41 => "ARTIKUL",
        42 => "UPRAVLENIE",
        43 => "VYSOTA_IZLIVA_SM",
        44 => "DLINA_IZLIVA_SM",
        45 => "NAZNACHENIE_",
        46 => "STRANA_PROIZVODITEL",
        47 => "MAKSIMALNYY_KOMMUTIRUEMYY_TOK_A",
        48 => "KLASS_ZASHCHITY_IP",
        49 => "TEMPERATURA_OKRUZHAYUSHCHEY_SREDY_S",
        50 => "GRUPPIROVKA_DLYA_SAYTA",
        51 => "KOLLEKTSIYA",
        52 => "OBLAST_PRIMENENIYA",
        53 => "OTVERSTIE_DLYA_MONTAZHA",
        54 => "STILISTIKA_DIZAYNA",
        55 => "OSNASHCHENIE",
        56 => "KLASS_ZASHCHITY",
        57 => "GLUBINA_VSASYVANIYA_M",
        58 => "MOSHCHNOST_VT",
        59 => "PROIVODITENOST_L_CH",
        60 => "MAKSIMALNYY_NAPOR_M",
        61 => "DLINA_KABELYA_M",
        62 => "OTAPLIVAEMAYA_PLOSHCHAD_KV_M",
        63 => "BUKHTA_M",
        64 => "KOMPLEKTATSIYA",
        65 => "MAKSIMALNOE_DAVLENIE_BAR",
        66 => "DY",
        67 => "FURNITURA",
        68 => "VYPUSK_UNITAZA",
        69 => "PROIZVODITELNOST_GORYACHEY_VODY_RI_T_25",
        70 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_35_L_M",
        71 => "DIAMETR_DYMOOTVODA_TRUB_KOAKS_RAZDELNYKH_MM",
        72 => "MAKS_RASKHOD_PRIRODNOGO_SZHIZHENNOGO_GAZA_M_CH_KG_",
        73 => "MAKS_PROIZVODITELNOST_KPD_",
        74 => "EMKOST_L",
        75 => "PODACHA_GAZA",
        76 => "VKHOD_KHOLODNOY_VODY_V_KOTEL",
        77 => "VOZVRAT_IZ_SISTEMY_OTOPLENIYA",
        78 => "TSIRKULYATOR",
        79 => "STEKLO_MM",
        80 => "KONSTRUKTSIYA_DVEREY",
        81 => "SIDENE",
        82 => "ELEKTRONNOE_UPRAVLENIE",
        83 => "GIDROMASSAZH_SPINY_KOL_VO_FORSUNOK",
        84 => "TROPICHESKIY_DUSH",
        85 => "VENTILYATSIYA",
        86 => "ZERKALO",
        87 => "RADIO",
        88 => "ZADNYAYA_STENKA",
        89 => "ISPOLNENIE_STEKOL",
        90 => "PODSVETKA",
        91 => "PROFIL",
        92 => "SMESITEL",
        93 => "DIAMETR_MM",
        94 => "NOVINKA",
        95 => "RASPRODAZHA",
        96 => "LIDER_PRODAZH",
        97 => "DELIVERY",
        98 => "GARANTY",
        99 => "ARMIROVANIE",
    ),
    "INCLUDE_SUBSECTIONS" => "Y",
    "LIST_META_KEYWORDS" => "-",
    "LIST_META_DESCRIPTION" => "-",
    "LIST_BROWSER_TITLE" => "-",
    "DETAIL_PROPERTY_CODE" => array(
        0 => "ELEKTRICHESKAYA_MOSHCHNOST_NAPRYAZHENIE_VT_V",
        1 => "PRISOEDINITELNYY_RAZMER",
        2 => "MOSHCHNOST_ELEKTRICHESKAYA_KVT",
        3 => "GARANTIYA_LET",
        4 => "CML2_ARTICLE",
        5 => "VES_NETTO_BRUTTO_KG",
        6 => "CML2_MANUFACTURER",
        7 => "SHIRINA_SM",
        8 => "GLUBINA_MM",
        9 => "VYSOTA_SM",
        10 => "MATERIAL",
        11 => "MAKSIMALNAYA_TEMPERATURA_S",
        12 => "NAPOR_M",
        13 => "PROPUSKNAYA_SPOSOBNOST_KVS_M_CHAS",
        14 => "TEMPERATURA_RABOCHEY_SREDY_S",
        15 => "TOLSHCHINA_MM",
        16 => "BREND",
        17 => "DLINA_SM",
        18 => "OBYEM_L",
        19 => "RABOCHEE_DAVLENIE_BAR",
        20 => "GABARITNYE_RAZMERY_MM",
        21 => "VNUTRENNIY_BAK",
        22 => "MOSHCHNOST_TEPLOOBMENNIKA_KVT",
        23 => "VSTROENNYY_TEN_KVT",
        24 => "PODSOEDINENIE_KONTURA_OTOPLENIYA",
        25 => "PODSOEDINENIE_KONTURA_GVS",
        26 => "PROIZVODITELNOST_M_CHAS",
        27 => "POVERKHNOST_NAGREVA_M",
        28 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_25_L_M",
        29 => "TIP_MONTAZHA",
        30 => "KAMERA_SGORANIYA",
        31 => "DIAMETR_DYMOKHODA_MM",
        32 => "PODSOEDINENIE_KONTURA_KHVS",
        33 => "MEZHOSEVOE_RASSTOYANIE_MM",
        34 => "TEPLOOTDACHA_VT",
        35 => "STATUS_NALICHIYA_NA_SKLADE",
        36 => "TSVET",
        37 => "KRANBUKSA",
        38 => "AERATOR",
        39 => "TIP",
        40 => "KARTRIDZH",
        41 => "ARTIKUL",
        42 => "UPRAVLENIE",
        43 => "VYSOTA_IZLIVA_SM",
        44 => "DLINA_IZLIVA_SM",
        45 => "NAZNACHENIE_",
        46 => "STRANA_PROIZVODITEL",
        47 => "MAKSIMALNYY_KOMMUTIRUEMYY_TOK_A",
        48 => "KLASS_ZASHCHITY_IP",
        49 => "TEMPERATURA_OKRUZHAYUSHCHEY_SREDY_S",
        50 => "GRUPPIROVKA_DLYA_SAYTA",
        51 => "KOLLEKTSIYA",
        52 => "OBLAST_PRIMENENIYA",
        53 => "OTVERSTIE_DLYA_MONTAZHA",
        54 => "STILISTIKA_DIZAYNA",
        55 => "OSNASHCHENIE",
        56 => "KLASS_ZASHCHITY",
        57 => "GLUBINA_VSASYVANIYA_M",
        58 => "MOSHCHNOST_VT",
        59 => "PROIVODITENOST_L_CH",
        60 => "MAKSIMALNYY_NAPOR_M",
        61 => "DLINA_KABELYA_M",
        62 => "OTAPLIVAEMAYA_PLOSHCHAD_KV_M",
        63 => "BUKHTA_M",
        64 => "KOMPLEKTATSIYA",
        65 => "MAKSIMALNOE_DAVLENIE_BAR",
        66 => "DY",
        67 => "FURNITURA",
        68 => "VYPUSK_UNITAZA",
        69 => "PROIZVODITELNOST_GORYACHEY_VODY_RI_T_25",
        70 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_35_L_M",
        71 => "DIAMETR_DYMOOTVODA_TRUB_KOAKS_RAZDELNYKH_MM",
        72 => "MAKS_RASKHOD_PRIRODNOGO_SZHIZHENNOGO_GAZA_M_CH_KG_",
        73 => "MAKS_PROIZVODITELNOST_KPD_",
        74 => "EMKOST_L",
        75 => "PODACHA_GAZA",
        76 => "VKHOD_KHOLODNOY_VODY_V_KOTEL",
        77 => "VOZVRAT_IZ_SISTEMY_OTOPLENIYA",
        78 => "TSIRKULYATOR",
        79 => "STEKLO_MM",
        80 => "KONSTRUKTSIYA_DVEREY",
        81 => "SIDENE",
        82 => "ELEKTRONNOE_UPRAVLENIE",
        83 => "GIDROMASSAZH_SPINY_KOL_VO_FORSUNOK",
        84 => "TROPICHESKIY_DUSH",
        85 => "VENTILYATSIYA",
        86 => "ZERKALO",
        87 => "RADIO",
        88 => "ZADNYAYA_STENKA",
        89 => "ISPOLNENIE_STEKOL",
        90 => "PODSVETKA",
        91 => "PROFIL",
        92 => "SMESITEL",
        93 => "DIAMETR_MM",
        94 => "NOVINKA",
        95 => "RASPRODAZHA",
        96 => "LIDER_PRODAZH",
        97 => "DELIVERY",
        98 => "GARANTY",
        99 => "ARMIROVANIE",
    ),
    "DETAIL_META_KEYWORDS" => "-",
    "DETAIL_META_DESCRIPTION" => "-",
    "DETAIL_BROWSER_TITLE" => "-",
    "DETAIL_SET_CANONICAL_URL" => "Y",
    "SECTION_ID_VARIABLE" => "SECTION_ID",
    "DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
    "SHOW_DEACTIVATED" => "N",
    "DETAIL_DISPLAY_NAME" => "N",
    "DETAIL_DETAIL_PICTURE_MODE" => "IMG",
    "DETAIL_ADD_DETAIL_TO_SLIDER" => "Y",
    "DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
    "LINK_IBLOCK_TYPE" => "",
    "LINK_IBLOCK_ID" => "",
    "LINK_PROPERTY_SID" => "",
    "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
    "USE_ALSO_BUY" => "N",
    "USE_STORE" => "N",
    "USE_BIG_DATA" => "N",
    "BIG_DATA_RCM_TYPE" => "bestsell",
    "PAGER_TEMPLATE" => "bigms",
    "DISPLAY_TOP_PAGER" => "N",
    "DISPLAY_BOTTOM_PAGER" => "Y",
    "PAGER_TITLE" => "Товары",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "ADD_PICT_PROP" => "MORE_PHOTO",
    "LABEL_PROP" => "-",
    "TOP_VIEW_MODE" => "SECTION",
    "DETAIL_VOTE_DISPLAY_AS_RATING" => "rating",
    "DETAIL_BLOG_USE" => "Y",
    "DETAIL_BLOG_URL" => "catalog_comments",
    "DETAIL_BLOG_EMAIL_NOTIFY" => "Y",
    "DETAIL_VK_USE" => "N",
    "DETAIL_FB_USE" => "N",
    "SEF_FOLDER" => "/catalog/",
    "FILTER_NAME" => "arrFilter",
    "FILTER_FIELD_CODE" => array(
        0 => "DETAIL_PICTURE",
        1 => "",
    ),
    "FILTER_PROPERTY_CODE" => array(
        0 => "ELEKTRICHESKAYA_MOSHCHNOST_NAPRYAZHENIE_VT_V",
        1 => "PRISOEDINITELNYY_RAZMER",
        2 => "MOSHCHNOST_ELEKTRICHESKAYA_KVT",
        3 => "GARANTIYA_LET",
        4 => "CML2_ARTICLE",
        5 => "VES_NETTO_BRUTTO_KG",
        6 => "CML2_MANUFACTURER",
        7 => "SHIRINA_SM",
        8 => "GLUBINA_MM",
        9 => "VYSOTA_SM",
        10 => "MATERIAL",
        11 => "MAKSIMALNAYA_TEMPERATURA_S",
        12 => "NAPOR_M",
        13 => "PROPUSKNAYA_SPOSOBNOST_KVS_M_CHAS",
        14 => "TEMPERATURA_RABOCHEY_SREDY_S",
        15 => "TOLSHCHINA_MM",
        16 => "BREND",
        17 => "DLINA_SM",
        18 => "OBYEM_L",
        19 => "RABOCHEE_DAVLENIE_BAR",
        20 => "GABARITNYE_RAZMERY_MM",
        21 => "VNUTRENNIY_BAK",
        22 => "MOSHCHNOST_TEPLOOBMENNIKA_KVT",
        23 => "VSTROENNYY_TEN_KVT",
        24 => "PODSOEDINENIE_KONTURA_OTOPLENIYA",
        25 => "PODSOEDINENIE_KONTURA_GVS",
        26 => "PROIZVODITELNOST_M_CHAS",
        27 => "POVERKHNOST_NAGREVA_M",
        28 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_25_L_M",
        29 => "TIP_MONTAZHA",
        30 => "KAMERA_SGORANIYA",
        31 => "DIAMETR_DYMOKHODA_MM",
        32 => "PODSOEDINENIE_KONTURA_KHVS",
        33 => "MEZHOSEVOE_RASSTOYANIE_MM",
        34 => "TEPLOOTDACHA_VT",
        35 => "TSVET",
        36 => "KRANBUKSA",
        37 => "AERATOR",
        38 => "TIP",
        39 => "KARTRIDZH",
        40 => "ARTIKUL",
        41 => "UPRAVLENIE",
        42 => "VYSOTA_IZLIVA_SM",
        43 => "DLINA_IZLIVA_SM",
        44 => "NAZNACHENIE_",
        45 => "STRANA_PROIZVODITEL",
        46 => "MAKSIMALNYY_KOMMUTIRUEMYY_TOK_A",
        47 => "KLASS_ZASHCHITY_IP",
        48 => "TEMPERATURA_OKRUZHAYUSHCHEY_SREDY_S",
        49 => "GRUPPIROVKA_DLYA_SAYTA",
        50 => "KOLLEKTSIYA",
        51 => "OBLAST_PRIMENENIYA",
        52 => "OTVERSTIE_DLYA_MONTAZHA",
        53 => "STILISTIKA_DIZAYNA",
        54 => "OSNASHCHENIE",
        55 => "KLASS_ZASHCHITY",
        56 => "GLUBINA_VSASYVANIYA_M",
        57 => "MOSHCHNOST_VT",
        58 => "PROIVODITENOST_L_CH",
        59 => "MAKSIMALNYY_NAPOR_M",
        60 => "DLINA_KABELYA_M",
        61 => "OTAPLIVAEMAYA_PLOSHCHAD_KV_M",
        62 => "BUKHTA_M",
        63 => "KOMPLEKTATSIYA",
        64 => "MAKSIMALNOE_DAVLENIE_BAR",
        65 => "DY",
        66 => "FURNITURA",
        67 => "VYPUSK_UNITAZA",
        68 => "PROIZVODITELNOST_GORYACHEY_VODY_RI_T_25",
        69 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_35_L_M",
        70 => "DIAMETR_DYMOOTVODA_TRUB_KOAKS_RAZDELNYKH_MM",
        71 => "MAKS_RASKHOD_PRIRODNOGO_SZHIZHENNOGO_GAZA_M_CH_KG_",
        72 => "MAKS_PROIZVODITELNOST_KPD_",
        73 => "EMKOST_L",
        74 => "PODACHA_GAZA",
        75 => "VKHOD_KHOLODNOY_VODY_V_KOTEL",
        76 => "VOZVRAT_IZ_SISTEMY_OTOPLENIYA",
        77 => "TSIRKULYATOR",
        78 => "STEKLO_MM",
        79 => "KONSTRUKTSIYA_DVEREY",
        80 => "SIDENE",
        81 => "ELEKTRONNOE_UPRAVLENIE",
        82 => "GIDROMASSAZH_SPINY_KOL_VO_FORSUNOK",
        83 => "TROPICHESKIY_DUSH",
        84 => "VENTILYATSIYA",
        85 => "ZERKALO",
        86 => "RADIO",
        87 => "ZADNYAYA_STENKA",
        88 => "ISPOLNENIE_STEKOL",
        89 => "PODSVETKA",
        90 => "PROFIL",
        91 => "SMESITEL",
        92 => "DIAMETR_MM",
        93 => "NOVINKA",
        94 => "RASPRODAZHA",
        95 => "LIDER_PRODAZH",
        96 => "DELIVERY",
        97 => "GARANTY",
        98 => "ARMIROVANIE",
    ),
    "FILTER_PRICE_CODE" => array(
        0 => "Интернет",
    ),
    "MESSAGES_PER_PAGE" => "10",
    "USE_CAPTCHA" => "Y",
    "REVIEW_AJAX_POST" => "Y",
    "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
    "FORUM_ID" => "1",
    "URL_TEMPLATES_READ" => "",
    "SHOW_LINK_TO_FORUM" => "N",
    "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
    "COMPARE_FIELD_CODE" => array(
        0 => "DETAIL_PICTURE",
        1 => "",
    ),
    "COMPARE_PROPERTY_CODE" => array(
        0 => "ELEKTRICHESKAYA_MOSHCHNOST_NAPRYAZHENIE_VT_V",
        1 => "PRISOEDINITELNYY_RAZMER",
        2 => "MOSHCHNOST_ELEKTRICHESKAYA_KVT",
        3 => "GARANTIYA_LET",
        4 => "CML2_ARTICLE",
        5 => "VES_NETTO_BRUTTO_KG",
        6 => "CML2_MANUFACTURER",
        7 => "SHIRINA_SM",
        8 => "GLUBINA_MM",
        9 => "VYSOTA_SM",
        10 => "MATERIAL",
        11 => "MAKSIMALNAYA_TEMPERATURA_S",
        12 => "NAPOR_M",
        13 => "PROPUSKNAYA_SPOSOBNOST_KVS_M_CHAS",
        14 => "TEMPERATURA_RABOCHEY_SREDY_S",
        15 => "TOLSHCHINA_MM",
        16 => "BREND",
        17 => "DLINA_SM",
        18 => "OBYEM_L",
        19 => "RABOCHEE_DAVLENIE_BAR",
        20 => "GABARITNYE_RAZMERY_MM",
        21 => "VNUTRENNIY_BAK",
        22 => "MOSHCHNOST_TEPLOOBMENNIKA_KVT",
        23 => "VSTROENNYY_TEN_KVT",
        24 => "PODSOEDINENIE_KONTURA_OTOPLENIYA",
        25 => "PODSOEDINENIE_KONTURA_GVS",
        26 => "PROIZVODITELNOST_M_CHAS",
        27 => "POVERKHNOST_NAGREVA_M",
        28 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_25_L_M",
        29 => "TIP_MONTAZHA",
        30 => "KAMERA_SGORANIYA",
        31 => "DIAMETR_DYMOKHODA_MM",
        32 => "PODSOEDINENIE_KONTURA_KHVS",
        33 => "MEZHOSEVOE_RASSTOYANIE_MM",
        34 => "TEPLOOTDACHA_VT",
        35 => "STATUS_NALICHIYA_NA_SKLADE",
        36 => "TSVET",
        37 => "KRANBUKSA",
        38 => "AERATOR",
        39 => "TIP",
        40 => "KARTRIDZH",
        41 => "ARTIKUL",
        42 => "UPRAVLENIE",
        43 => "VYSOTA_IZLIVA_SM",
        44 => "DLINA_IZLIVA_SM",
        45 => "NAZNACHENIE_",
        46 => "STRANA_PROIZVODITEL",
        47 => "MAKSIMALNYY_KOMMUTIRUEMYY_TOK_A",
        48 => "KLASS_ZASHCHITY_IP",
        49 => "TEMPERATURA_OKRUZHAYUSHCHEY_SREDY_S",
        50 => "GRUPPIROVKA_DLYA_SAYTA",
        51 => "KOLLEKTSIYA",
        52 => "OBLAST_PRIMENENIYA",
        53 => "OTVERSTIE_DLYA_MONTAZHA",
        54 => "STILISTIKA_DIZAYNA",
        55 => "OSNASHCHENIE",
        56 => "KLASS_ZASHCHITY",
        57 => "GLUBINA_VSASYVANIYA_M",
        58 => "MOSHCHNOST_VT",
        59 => "PROIVODITENOST_L_CH",
        60 => "MAKSIMALNYY_NAPOR_M",
        61 => "DLINA_KABELYA_M",
        62 => "OTAPLIVAEMAYA_PLOSHCHAD_KV_M",
        63 => "BUKHTA_M",
        64 => "KOMPLEKTATSIYA",
        65 => "MAKSIMALNOE_DAVLENIE_BAR",
        66 => "DY",
        67 => "FURNITURA",
        68 => "VYPUSK_UNITAZA",
        69 => "PROIZVODITELNOST_GORYACHEY_VODY_RI_T_25",
        70 => "PROIZVODITELNOST_GORYACHEY_VODY_PRI_T_35_L_M",
        71 => "DIAMETR_DYMOOTVODA_TRUB_KOAKS_RAZDELNYKH_MM",
        72 => "MAKS_RASKHOD_PRIRODNOGO_SZHIZHENNOGO_GAZA_M_CH_KG_",
        73 => "MAKS_PROIZVODITELNOST_KPD_",
        74 => "EMKOST_L",
        75 => "PODACHA_GAZA",
        76 => "VKHOD_KHOLODNOY_VODY_V_KOTEL",
        77 => "VOZVRAT_IZ_SISTEMY_OTOPLENIYA",
        78 => "TSIRKULYATOR",
        79 => "STEKLO_MM",
        80 => "KONSTRUKTSIYA_DVEREY",
        81 => "SIDENE",
        82 => "ELEKTRONNOE_UPRAVLENIE",
        83 => "GIDROMASSAZH_SPINY_KOL_VO_FORSUNOK",
        84 => "TROPICHESKIY_DUSH",
        85 => "VENTILYATSIYA",
        86 => "ZERKALO",
        87 => "RADIO",
        88 => "ZADNYAYA_STENKA",
        89 => "ISPOLNENIE_STEKOL",
        90 => "PODSVETKA",
        91 => "PROFIL",
        92 => "SMESITEL",
        93 => "DIAMETR_MM",
        94 => "NOVINKA",
        95 => "RASPRODAZHA",
        96 => "LIDER_PRODAZH",
        97 => "GARANTY",
        98 => "ARMIROVANIE",
    ),
    "COMPARE_ELEMENT_SORT_FIELD" => "CATALOG_PRICE_1",
    "COMPARE_ELEMENT_SORT_ORDER" => "asc",
    "DISPLAY_ELEMENT_SELECT_BOX" => "Y",
    "ELEMENT_SORT_FIELD_BOX" => "name",
    "ELEMENT_SORT_ORDER_BOX" => "asc",
    "ELEMENT_SORT_FIELD_BOX2" => "id",
    "ELEMENT_SORT_ORDER_BOX2" => "desc",
    "COMPARE_POSITION_FIXED" => "Y",
    "COMPARE_POSITION" => "top left",
    "DETAIL_SHOW_BASIS_PRICE" => "Y",
    "USE_MAIN_ELEMENT_SECTION" => "Y",
    "SET_LAST_MODIFIED" => "N",
    "PAGER_Продажные_LINK_ENABLE" => "N",
    "SHOW_404" => "Y",
    "MESSAGE_404" => "",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "FILE_404" => "",
    "SECTION_BACKGROUND_IMAGE" => "-",
    "DETAIL_BACKGROUND_IMAGE" => "-",
    "USE_GIFTS_DETAIL" => "Y",
    "USE_GIFTS_SECTION" => "Y",
    "USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
    "GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "3",
    "GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
    "GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
    "GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
    "GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "3",
    "GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
    "GIFTS_SECTION_LIST_BLOCK_TITLE" => "Подарки к товарам этого раздела",
    "GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "Подарок",
    "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
    "GIFTS_SHOW_OLD_PRICE" => "Y",
    "GIFTS_SHOW_NAME" => "Y",
    "GIFTS_SHOW_IMAGE" => "Y",
    "GIFTS_MESS_BTN_BUY" => "Выбрать",
    "GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "3",
    "GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
    "GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
    "DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
    "SEF_URL_TEMPLATES" => array(
        "sections" => "",
        "section" => "#SECTION_CODE#/",
        "element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
        "compare" => "compare/",
        "smart_filter" => "#SECTION_CODE#/filter/#SMART_FILTER_PATH#/apply/",
    )
);

if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
    $basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
}
else
{
    $basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
}

$arParams = array(
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    /*"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
    "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],*/
    "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
    "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
    "SECTION_URL" => $arParams["SECTION_URL"],
    "DETAIL_URL" => $arParams["DETAIL_URL"],
    "BASKET_URL" => $arParams["BASKET_URL"],
    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    'DISPLAY_COMPARE' => (isset($arParams['USE_COMPARE']) ? $arParams['USE_COMPARE'] : ''),
    "PRICE_CODE" => $arParams["PRICE_CODE"],
    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
    "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
    "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
    "CURRENCY_ID" => $arParams["CURRENCY_ID"],
    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
    "FILTER_NAME" => "searchFilter",
    "SECTION_ID" => "",
    "SECTION_CODE" => "",
    "SECTION_USER_FIELDS" => array(),
    "INCLUDE_SUBSECTIONS" => "Y",
    "SHOW_ALL_WO_SECTION" => "Y",
    "META_KEYWORDS" => "",
    "META_DESCRIPTION" => "",
    "BROWSER_TITLE" => "",
    "ADD_SECTIONS_CHAIN" => "N",
    "SET_TITLE" => "N",
    "SET_STATUS_404" => "N",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "N",

    "RESTART" => "Y",
    "NO_WORD_LOGIC" => "Y",
    "USE_LANGUAGE_GUESS" => "Y",
    "CHECK_DATES" => "Y",

    'LABEL_PROP' => $arParams['LABEL_PROP'],
    'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

    'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
    'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
    'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
    'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
    'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
    'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

    'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
    'ADD_TO_BASKET_ACTION' => $basketAction,
    'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
    'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
);

global $arrFilter;
$arrFilter = Array('IBLOCK_ID' => Array(12, 10));
?>
<?

		if(mb_strtolower($_REQUEST["q"]) == "gustavsberg"){
			$_REQUEST["q"] = "gustavs";
		}
	

		if(!IsModuleInstalled("search"))
		{
			ShowError(GetMessage("CC_BST_MODULE_NOT_INSTALLED"));
			return;
		}

		$arParams = array(
			"NUM_CATEGORIES" => "1",
			"TOP_COUNT" => "5000",
			"CHECK_DATES" => "Y",
			"SHOW_OTHERS" => "N",
			"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
			"CATEGORY_0" => array(
				0 => "iblock_1c_catalog",
			),
			"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
			"SHOW_INPUT" => "Y",
			"INPUT_ID" => "title-search-input10",
			"CONTAINER_ID" => "search",
			"PRICE_CODE" => array(
				0 => "Интернет",
			),
			"SHOW_PREVIEW" => "Y",
			"PREVIEW_WIDTH" => "75",
			"PREVIEW_HEIGHT" => "75",
			"CONVERT_CURRENCY" => "Y",
			"COMPONENT_TEMPLATE" => "search",
			"ORDER" => "date",
			"USE_LANGUAGE_GUESS" => "Y",
			"PRICE_VAT_INCLUDE" => "Y",
			"PREVIEW_TRUNCATE_LEN" => "",
			"CURRENCY_ID" => "RUB",
			"CATEGORY_0_iblock_1c_catalog" => array(
				0 => "all",//10
			),
		);
		if(!isset($arParams["PAGE"]) || strlen($arParams["PAGE"])<=0)
			$arParams["PAGE"] = "#SITE_DIR#search/index.php";

		$arResult["CATEGORIES"] = array();

		$query = ltrim($_REQUEST["q"]);

		CUtil::decodeURIComponent($query);

		$arResult["alt_query"] = "";
		if($arParams["USE_LANGUAGE_GUESS"] !== "N")
		{
			$arLang = CSearchLanguage::GuessLanguage($query);
			if(is_array($arLang) && $arLang["from"] != $arLang["to"])
				$arResult["alt_query"] = CSearchLanguage::ConvertKeyboardLayout($query, $arLang["from"], $arLang["to"]);
		}

		$arResult["query"] = $query;
		$arResult["phrase"] = stemming_split($query, LANGUAGE_ID);

		$arParams["NUM_CATEGORIES"] = intval($arParams["NUM_CATEGORIES"]);
		if($arParams["NUM_CATEGORIES"] <= 0)
			$arParams["NUM_CATEGORIES"] = 1;

		$arParams["TOP_COUNT"] = intval($arParams["TOP_COUNT"]);
		if($arParams["TOP_COUNT"] <= 0)
			$arParams["TOP_COUNT"] = 5;

		$arOthersFilter = array("LOGIC"=>"OR");

		for($i = 0; $i < $arParams["NUM_CATEGORIES"]; $i++)
		{
			$category_title = trim($arParams["CATEGORY_".$i."_TITLE"]);
			if(empty($category_title))
			{
				if(is_array($arParams["CATEGORY_".$i]))
					$category_title = implode(", ", $arParams["CATEGORY_".$i]);
				else
					$category_title = trim($arParams["CATEGORY_".$i]);
			}
			if(empty($category_title))
				continue;

			$arResult["CATEGORIES"][$i] = array(
				"TITLE" => htmlspecialcharsbx($category_title),
				"ITEMS" => array()
			);

			$exFILTER = array(
				0 => CSearchParameters::ConvertParamsToFilter($arParams, "CATEGORY_".$i),
			);
			$exFILTER[0]["LOGIC"] = "OR";

			if($arParams["CHECK_DATES"] === "Y")
				$exFILTER["CHECK_DATES"] = "Y";

			$arOthersFilter[] = $exFILTER;

			$j = 0;
			$obTitle = new CSearchTitle;
			$obTitle->setMinWordLength($_REQUEST["l"]);
			if($obTitle->Search(
				$arResult["alt_query"]? $arResult["alt_query"]: $arResult["query"]
				,$arParams["TOP_COUNT"]
				,$exFILTER
				,false
				,$arParams["ORDER"]
			))
			{
				while($ar = $obTitle->Fetch())
				{
					$j++;
					if($j < $arParams["TOP_COUNT"])
					{
						$arElements_1[] = $ar["ITEM_ID"];
					}
				}
			}
		}

		
		
		
		
	//if(!isset($arElements)){
		/*$arElements = Array();
		$q = $_REQUEST['q'];
		$obSearch = new CSearch;
		$obSearch->SetOptions(array(//мы добавили еще этот параметр, чтобы не ругался на форматирование запроса
			'ERROR_ON_EMPTY_STEM' => false,
		));
		$obSearch->Search(array(
			'QUERY' => $q,
			'SITE_ID' => 's1',
			'MODULE_ID' => 'iblock',
			//'PARAM2' => 10
		));
		if (!$obSearch->selectedRowsCount()) {//и делаем резапрос, если не найдено с морфологией...
			$obSearch->Search(array(
				'QUERY' => $q,
				'SITE_ID' => 's1',
				'MODULE_ID' => 'iblock',
				//'PARAM2' => 10
			), array(), array('STEMMING' => false));//... уже с отключенной морфологией
		}
		while ($row = $obSearch->fetch()) {
			if ($row['PARAM2'] == 10 || $row['PARAM2'] == 12){
				$arElements[] = $row['ITEM_ID'];
			}

		}*/
		
		
		$arElements_2 = $APPLICATION->IncludeComponent(
		   "bitrix:search.page",
		   "catalog",
		   Array(
			   "TAGS_SORT" => "NAME",
				"TAGS_PAGE_ELEMENTS" => "150",
				"TAGS_PERIOD" => "30",
				"TAGS_INHERIT" => "Y",
				"FONT_MAX" => "50",
				"FONT_MIN" => "10",
				"COLOR_NEW" => "000000",
				"COLOR_OLD" => "C8C8C8",
				"PERIOD_NEW_TAGS" => "",
				"SHOW_CHAIN" => "Y",
				"COLOR_TYPE" => "Y",
				"WIDTH" => "100%",
				"USE_SUGGEST" => "Y",
				"SHOW_RATING" => "Y",
				"PATH_TO_USER_PROFILE" => "",
				"AJAX_MODE" => "N",
				"RESTART" => "Y",
				"NO_WORD_LOGIC" => "N",
				"USE_LANGUAGE_GUESS" => "Y",
				"CHECK_DATES" => "Y",
				"USE_TITLE_RANK" => "Y",
				"DEFAULT_SORT" => "rank",
				"FILTER_NAME" => "arrFilter",
				"arrFILTER" => array(0 => "iblock_1c_catalog"),
				"SHOW_WHERE" => "Y",
				"arrWHERE" => array(),
				"SHOW_WHEN" => "Y",
				"PAGE_RESULT_COUNT" => "5000",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"DISPLAY_TOP_PAGER" => "Y",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Результаты поиска",
				"PAGER_SHOW_ALWAYS" => "Y",
				"PAGER_TEMPLATE" => "",
				"AJAX_OPTION_SHADOW" => "Y",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => ""
			
		   ),
		   false,
		   array('HIDE_ICONS' => 'Y')
		);
		
		if(isset($arElements_1) && isset($arElements_2)){
			$arElements_test = array_merge($arElements_2, $arElements_1);
			$arElements = array_unique($arElements_test);
		}elseif(isset($arElements_2) && !isset($arElements_1)){
			$arElements = $arElements_2;
		}elseif(!isset($arElements_2) && isset($arElements_1)){
			$arElements = $arElements_1;
		}
		
		
		/*global $USER;
		if ($USER->IsAdmin()){

			echo("<pre>");
			print_r($arElements);
			echo("</pre>");
			echo("<pre>");
			print_r(111111111111111111111111111111111111);
			echo("</pre>");
			echo("<pre>");
			print_r($arElements_2);
			echo("</pre>");
		}*/
		
		
	//}
	

	
	
	
//}


/***********************************/
$countElements = 0;
// Отбираем разделы, в которых найдены товары
$arSelect = array("IBLOCK_SECTION_ID");
$arFilter = array("IBLOCK_ID"=>Array(10, 12), "ACTIVE"=>"Y", "ID"=>$arElements);
$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $temp = $ob->GetFields();
    $arSectionTrue[] = $temp["IBLOCK_SECTION_ID"];
    $count_sections[] = $temp["IBLOCK_SECTION_ID"];

    $nav = CIBlockSection::GetNavChain($arParams['IBLOCK_ID'], $temp["IBLOCK_SECTION_ID"], array("ID"));
    while($arSectionPath = $nav->GetNext()){
        $arSectionTrue[] = $arSectionPath["ID"];
    }
    if (isset($_GET['section_id']) && $_GET['section_id'] == $temp["IBLOCK_SECTION_ID"]){
        $countElements++;
    }
}
$arSectionTrue= array_map("unserialize", array_unique( array_map("serialize", $arSectionTrue) ));
?>

<?
$rs_Section = CIBlockSection::GetList(
    array('NAME' => 'asc'),
    array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ID"=>$arSectionTrue, "ACTIVE" => "Y"),
    false,
    array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL')
);
$ar_SectionList = array();
$ar_DepthLavel = array();
while($ar_Section = $rs_Section->GetNext(true, false))
{
    $ar_SectionList[$ar_Section['ID']] = $ar_Section;
    $ar_DepthLavel[] = $ar_Section['DEPTH_LEVEL'];
}

$ar_DepthLavelResult = array_unique($ar_DepthLavel);
rsort($ar_DepthLavelResult);

$i_MaxDepthLevel = $ar_DepthLavelResult[0];

for( $i = $i_MaxDepthLevel; $i > 1; $i-- )
{
    foreach ( $ar_SectionList as $i_SectionID => $ar_Value )
    {
        if( $ar_Value['DEPTH_LEVEL'] == $i )
        {
            $ar_SectionList[$ar_Value['IBLOCK_SECTION_ID']]['SUB_SECTION'][] = $ar_Value;
            unset( $ar_SectionList[$i_SectionID] );
        }
    }
}
?>

<?
//function __recursivRenderMenu($ar_Items) {
//    foreach ($ar_Items as $ar_Value) {
//        if ( count($ar_Value['SUB_SECTION']) > 0 ) {
//            $active = '';
//            if ($_GET['section_id'] == $ar_Value['ID'] && strlen($_GET['section_id']) > 0) {
//                $active = 'style="background: tomato;"';
//            }
//            echo '<ul>';
//            echo '<li class="item"'.$active.'>';
//            echo '<a href="'.$_SERVER['REQUEST_URI'].'&section_id='.$ar_Value['ID'].'"><span>';
//            echo $ar_Value['NAME'];
//            echo '</a></span>';
//            echo '<ul>';
//            # рекурсивный вызов функции
//            echo __recursivRenderMenu($ar_Value['SUB_SECTION']);
//            echo '</ul>';
//            echo '</li>';
//            echo '</ul>';
//        } else {
//            $active = '';
//            if ($_GET['section_id'] == $ar_Value['ID'] && strlen($_GET['section_id']) > 0){
//                $active = 'style="background: tomato;"';
//            }
//            echo '<li class="item" '.$active.'><a href="'.$_SERVER['REQUEST_URI'].'&section_id='.$ar_Value['ID'].'"><span>'.$ar_Value['NAME'].'</span></a></li>';
//        }
//    }
//}
$curSectionName = false;
function __recursivRenderMenu($ar_Items) {
    global $curSectionName;
    $res = '';
    foreach ($ar_Items as $ar_Value) {
        if ( count($ar_Value['SUB_SECTION']) > 0 ) {
            $active = '';
            if ($_GET['section_id'] == $ar_Value['ID'] && strlen($_GET['section_id']) > 0) {
                $active = 'style="color: #e75938;"';
                $curSectionName = $ar_Value['NAME'];
            }
            $res .= '<ul>';
            $res .= '<li class="item">';
            $res .= '<a href="'.$_SERVER['REQUEST_URI'].'&section_id='.$ar_Value['ID'].'" '.$active.'><span>';
            $res .= $ar_Value['NAME'];
            $res .= '</a></span>';
            $res .= '<ul>';
            # рекурсивный вызов функции
            $res .= __recursivRenderMenu($ar_Value['SUB_SECTION']);
            $res .= '</ul>';
            $res .= '</li>';
            $res .= '</ul>';
        } else {
            $active = '';
            if ($_GET['section_id'] == $ar_Value['ID'] && strlen($_GET['section_id']) > 0){
                $active = 'style="color: #e75938;"';
                $curSectionName = $ar_Value['NAME'];
            }
            $res .= '<li class="item"><a href="'.$_SERVER['REQUEST_URI'].'&section_id='.$ar_Value['ID'].'" '.$active.'><span>'.$ar_Value['NAME'].'</span></a></li>';
        }
    }
    return $res;
}
/***********************************/
?>

<?
// Считаем количество товаров
$i = 0;
foreach($arElements as $el){
    if(is_numeric($el)){
        $i++;
    }
}
$sectionsMenu = __recursivRenderMenu($ar_SectionList);
?>

    <!--h1><?$APPLICATION->ShowTitle(false)?></h1-->

	<?global $USER;
	if ($USER->IsAdmin()):
	?>
		<script>
			function getXMLDocument(url)  
			{  
				var xml;  
				if(window.XMLHttpRequest)  
				{  
					xml=new window.XMLHttpRequest();  
					xml.open("GET", url, false);  
					xml.send("");  
					return xml.responseXML;  
				}  
				else  
					if(window.ActiveXObject)  
					{  
						xml=new ActiveXObject("Microsoft.XMLDOM");  
						xml.async=false;  
						xml.load(url);  
						return xml;  
					}  
					else  
					{  
						console.log("Загрузка XML не поддерживается браузером");  
						return null;  
					}  
			}  
			
			var original_q = '<?=$GLOBALS["REQUEST"]["QUERY"]?>';
			var xml_response = getXMLDocument('http://speller.yandex.net/services/spellservice/checkText?text='+'<?=$GLOBALS["REQUEST"]["QUERY"]?>');
			var s=xml_response.getElementsByTagName("error");  

			var result_query = "";
			var count = 0;
			if(s)
			for(var i1 = 0; i1 < s.length; i1++)  
			{
				if(s[i1].getElementsByTagName("s").length > 0){
					//result_query += s[i1].getElementsByTagName("s")[0].firstChild.data+" ";
					if(count > 0){
						result_query = result_query.replace(new RegExp(s[i1].getElementsByTagName("word")[0].firstChild.data,'g'), s[i1].getElementsByTagName("s")[0].firstChild.data);
					}else{
						result_query = original_q.replace(new RegExp(s[i1].getElementsByTagName("word")[0].firstChild.data,'g'), s[i1].getElementsByTagName("s")[0].firstChild.data);
					}
					count++;
				}else{
					result_query = result_query.replace(new RegExp(s[i1].getElementsByTagName("word")[0].firstChild.data,'g'), s[i1].getElementsByTagName("word")[0].firstChild.data);
					//result_query += s[i1].getElementsByTagName("word")[0].firstChild.data+" ";
				}
				
				
			}
			if(count > 0){
				if(result_query != ""){
					$(".another_request").html(result_query);
					$(".another_request").attr('href', '/search/?q='+result_query);
					$(".div_another_request").show();
				}
			}
			
			console.log(result_query);
			/*var s=xml_response.getElementsByTagName("s");  
			var result_query = "";
			if(s){  
				for(var i1 = 0; i1 < s.length; i1++)  
				{  
					s_res = xml_response.getElementsByTagName('s')[i1].firstChild.data
					
					result_query += s_res+" ";
				}
			}
			console.log(result_query);*/
		</script>
		
		<div class="div_another_request" style='display:none;font-size:0.750em;position: absolute;left: 365px;top: 50px;'>Возможно вы имели ввиду - <a style="text-decoration: none;color: #006db8;font-weight: bold;" href="" class="another_request"></a></div>
		<br>
		
	<?endif;?>
	
	
    <?if ($curSectionName):?>
        <div class="search_text">По запросу <span>«<?if($GLOBALS["REQUEST"]["QUERY"] != ""){echo($GLOBALS["REQUEST"]["QUERY"]);}else{echo($_GET["q"]);}?>»</span> найдено <span><?=$countElements?> товаров</span> в разделе <?=$curSectionName?></div>
    <?else:?>
        <div class="search_text">По запросу <span>«<?if($GLOBALS["REQUEST"]["QUERY"] != ""){echo($GLOBALS["REQUEST"]["QUERY"]);}else{echo($_GET["q"]);}?>»</span> найдено <span><?=$i?> товаров</span> в <?=count(array_unique($count_sections))?> категории.</div>
    <?endif;?>

    <div class="catalog">

        <?
        if (!empty($arElements) && is_array($arElements))
        {
            ?>

            <div class="lf_block">
                <ul class="list">
                    <?=$sectionsMenu;?>
                </ul>
            </div>

            <div class="rt_block">
                <?
                if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
                {
                    $basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
                }
                else
                {
                    $basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
                }
                $intSectionID = 0;
                ?>


                <div class="sort_header">
                    <!--noindex-->
                    <?
                    if (array_key_exists("display", $_REQUEST) || (array_key_exists("display", $_SESSION)) || $arParams["DEFAULT_LIST_TEMPLATE"])
                    {
                        if ($_REQUEST["display"]&&((trim($_REQUEST["display"])=="block")||(trim($_REQUEST["display"])=="table")))
                        {$display=trim($_REQUEST["display"]);  $_SESSION["display"]=trim($_REQUEST["display"]);}
                        elseif ($_SESSION["display"]&&(($_SESSION["display"]=="block")||($_SESSION["display"]=="table")))
                        {$display=$_SESSION["display"];}
                        else {$display=$arParams["DEFAULT_LIST_TEMPLATE"];}
                    }
                    else {
                        $display = "block";
                    }
                    $template = "catalog_".$display;
                    ?>

                    <div class="sort_filter">
                        <div class="sort_plice">
                            <a class="button_middle CATALOG_PRICE_1 <?if($_REQUEST["sort"] == "CATALOG_PRICE_1" && $_REQUEST["order"] == "asc"){echo 'current';}?>" href="<?=$APPLICATION->GetCurPageParam('sort=CATALOG_PRICE_1&order=asc', array('sort', 'order', 'mode'))?>" rel="nofollow">
                                <span>сначала дешевые</span>
                            </a>
                            <a class="button_middle CATALOG_PRICE_1 <?if($_REQUEST["sort"] == "CATALOG_PRICE_1" && $_REQUEST["order"] == "desc"){echo 'current';}?>" href="<?=$APPLICATION->GetCurPageParam('sort=CATALOG_PRICE_1&order=desc', array('sort', 'order', 'mode'))?>" rel="nofollow">
                                <span>сначала  дорогие</span>
                            </a>
                        </div>

                        <?
                        $basePrice = CCatalogGroup::GetBaseGroup();
                        $priceSort = "CATALOG_PRICE_".$basePrice["ID"];
                        $arAvailableSort = array(
                            "POPULARITY" => array("SHOW_COUNTER", "desc"),
                            "PROPERTY_NOVINKA_VALUE" => array("PROPERTY_NOVINKA_VALUE", "desc"),
                            "PROPERTY_RASPRODAZHA_VALUE" => array("PROPERTY_RASPRODAZHA_VALUE", "desc"),
                        );

                        if ((array_key_exists("sort", $_REQUEST) && array_key_exists(ToUpper($_REQUEST["sort"]), $arAvailableSort)) || (array_key_exists("sort", $_SESSION) && array_key_exists(ToUpper($_SESSION["sort"]), $arAvailableSort)) || $arParams["ELEMENT_SORT_FIELD"])
                        {
                            if ($_REQUEST["sort"]) {$sort=ToUpper($_REQUEST["sort"]);  $_SESSION["sort"]=ToUpper($_REQUEST["sort"]);}
                            elseif ($_SESSION["sort"]) {$sort=ToUpper($_SESSION["sort"]);}/*
                            else {$sort=ToUpper($arParams["ELEMENT_SORT_FIELD"]);}*/
                        }


                        if ((array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ) || (array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ) || $arParams["ELEMENT_SORT_ORDER"])
                        {
                            if ($_REQUEST["order"]) {$sort_order=$_REQUEST["order"]; $_SESSION["order"]=$_REQUEST["order"];}
                            elseif ($_SESSION["order"]) {$sort_order=$_SESSION["order"];}
                            else {$sort_order=ToLower($arParams["ELEMENT_SORT_ORDER"]);}
                        }


                        foreach ($arAvailableSort as $key => $val)
                        {
                            if($key == 'SORT'){
                                $newSort = $sort_order == 'desc' ? 'asc' : 'desc';
                            }
                            else{
                                $newSort = $sort_order == 'desc' ? 'asc' : 'desc';
                            }?>
                            <a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order', 'mode'))?>" class="button_middle <?=$sort == $key ? 'current' : ''?> <?=ToLower($sort_order)?> <?=$key?>" rel="nofollow">
                                <span><?=GetMessage('SECT_SORT_'.$key)?></span>
                                <i></i>
                            </a>
                            <?
                        }
                        ?>
                    </div>

                    <?
                    $show=20;
                    if (array_key_exists("show", $_REQUEST))
                    {
                        if ( intVal($_REQUEST["show"]) && in_array(intVal($_REQUEST["show"]), array(4, 8, 12, 16, 20, 40, 60, 80, 100)) ) {
                            $show=intVal($_REQUEST["show"]);
                            $_SESSION["show"] = $show;
                        }
                        elseif ($_SESSION["show"]) {
                            $show=intVal($_SESSION["show"]);
                        }
                    }
                    //$sort=$arAvailableSort[$sort][0];
                    ?>
                    <div class="number_list">
                        <div class="title">Показать по:</div>
                        <select class="select" name="str" onchange="redirect_str(this.value);">
                            <?for( $i = 20; $i <= 100; $i+=20 ){?>
                                <option value="<?=$APPLICATION->GetCurPageParam('show='.$i, array("show"))?>" <?if($i == $show){echo 'selected="selected"';}?>><?=$i?></option>
                            <?}?>
                        </select>
                    </div>

                    <div class="sort_display">
                        <div class="title">Вид:</div>
                        <a href="<?=$APPLICATION->GetCurPageParam('display=block', array('display', 'mode'))?>" class="block <?=$display == 'block' ? 'current' : '';?>"><i></i><span><?//=GetMessage("SECT_DISPLAY_LIST")?></span></a>
                        <a href="<?=$APPLICATION->GetCurPageParam('display=table', array('display', 'mode'))?>" class="table <?=$display == 'table' ? 'current' : '';?>"><i></i><span><?//=GetMessage("SECT_DISPLAY_TABLE")?></span></a>
                    </div>
                    <!--/noindex-->
                    <div class="clear"></div>
                </div>
                <?
                global $searchFilter;
                $searchFilter = array(
                    "ID" => $arElements,
                    //">CATALOG_PRICE_1" => 0 //отображать товары у которых есть цена!
                );
                ?>

                <?
				
				
					
	/*global $USER;
	if ($USER->IsAdmin()){
	
		echo("<pre>");
		print_r($_REQUEST["section_id"]);
		echo("</pre>");
	}
			*/	
				
				$APPLICATION->IncludeComponent(
                    "ibrush:catalog.section",
                    $template,
                    Array(
                        "PRODUCT_SUBSCRIPTION" => "N",
                        "SHOW_DISCOUNT_PERCENT" => "N",
                        "SHOW_OLD_PRICE" => "N",
                        "SHOW_CLOSE_POPUP" => "Y",
                        "AJAX_MODE" => "Y",
                        "SEF_MODE" => "N",
                        "IBLOCK_ID" => array(10, 12),
                        "SECTION_ID" => $_REQUEST["section_id"],
                        "SECTION_CODE" => "",
                        "SECTION_USER_FIELDS" => array(),
                        "ELEMENT_SORT_FIELD" => $sort,
                        "ELEMENT_SORT_ORDER" => $sort_order,
                        /*"ELEMENT_SORT_FIELD2" => "name",
                        "ELEMENT_SORT_ORDER2" => "asc",*/
                        "FILTER_NAME" => "searchFilter",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "SHOW_ALL_WO_SECTION" => "Y",
                        "SECTION_URL" => "",
                        "DETAIL_URL" => "",
                        "BASKET_URL" => "/personal/basket.php",
                        "ACTION_VARIABLE" => "action",
                        "PRODUCT_ID_VARIABLE" => "id",
                        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                        "ADD_PROPERTIES_TO_BASKET" => "Y",
                        "PRODUCT_PROPS_VARIABLE" => "prop",
                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                        "ADD_SECTIONS_CHAIN" => "Y",
                        "DISPLAY_COMPARE" => "N",
                        "SET_TITLE" => "Y",
                        "SET_BROWSER_TITLE" => "Y",
                        "BROWSER_TITLE" => "-",
                        "SET_META_KEYWORDS" => "Y",
                        "META_KEYWORDS" => "",
                        "SET_META_DESCRIPTION" => "Y",
                        "META_DESCRIPTION" => "",
                        "SET_LAST_MODIFIED" => "Y",
                        "USE_MAIN_ELEMENT_SECTION" => "Y",
                        "SET_STATUS_404" => "N",
                        "PAGE_ELEMENT_COUNT" => $show,
                        "LINE_ELEMENT_COUNT" => "3",
                        "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
                        "OFFERS_FIELD_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
                        "OFFERS_PROPERTY_CODE" => array(),
                        "OFFERS_SORT_FIELD" => "sort",
                        "OFFERS_SORT_ORDER" => "asc",
                        "OFFERS_SORT_FIELD2" => "active_from",
                        "OFFERS_SORT_ORDER2" => "desc",
                        "OFFERS_LIMIT" => "5",
                        "BACKGROUND_IMAGE" => "-",
                        "PRICE_CODE" => array(),
                        "USE_PRICE_COUNT" => "Y",
                        "SHOW_PRICE_COUNT" => "1",
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PRODUCT_PROPERTIES" => array(),
                        "USE_PRODUCT_QUANTITY" => "Y",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_FILTER" => "Y",
                        "CACHE_GROUPS" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "PAGER_TITLE" => "Товары",
                        "PAGER_SHOW_ALWAYS" => "Y",
                       /* "PAGER_TEMPLATE" => "",*/
                        "PAGER_DESC_NUMBERING" => "Y",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "Y",
                        "HIDE_NOT_AVAILABLE" => "N",
                        "OFFERS_CART_PROPERTIES" => array(),
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "CONVERT_CURRENCY" => "Y",
                        "CURRENCY_ID" => "RUB",
                        "ADD_TO_BASKET_ACTION" => "ADD",
                        "PAGER_BASE_LINK_ENABLE" => "Y",
                        "SET_STATUS_404" => "Y",
                        "SHOW_404" => "Y",
                        "MESSAGE_404" => "",
                        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                        "PAGER_BASE_LINK" => "",
                        "PAGER_PARAMS_NAME" => "arrPager",
                        "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
                        'COMPARE_PATH' => '/catalog/#CAT#/compare/',
                        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                        /*"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],*/
                        "OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
                        /*"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],*/
                        /*"OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],*/
                        "SECTION_URL" => $arParams["SECTION_URL"],
                        "DETAIL_URL" => $arParams["DETAIL_URL"],
                        "BASKET_URL" => $arParams["BASKET_URL"],
                        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                        "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                        "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                        //"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
                        "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                        "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                        "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                        "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                        "HIDE_NOT_AVAILABLE" => "N",
                        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                        "PAGER_TEMPLATE" => "bigms",
                        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                        /*"FILTER_NAME" => "searchFilter",*/
                        //"SECTION_ID" => $_GET["section_id"],
                        "SECTION_CODE" => "",
                        "SECTION_USER_FIELDS" => array(),
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "SHOW_ALL_WO_SECTION" => "Y",
                        "META_KEYWORDS" => "",
                        "META_DESCRIPTION" => "",
                        "BROWSER_TITLE" => "",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "SET_TITLE" => "N",
                        "SET_STATUS_404" => "N",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "N",

                       /* 'LABEL_PROP' => $arParams['LABEL_PROP'],
                        'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                        'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

                        'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                        'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                        'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                        'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
                        'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
                        'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
                        'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
                        'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

                        'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],*/
                        'ADD_TO_BASKET_ACTION' => $basketAction,
                        'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : '')
                    )
                );
				/*}else{
				
				
				
					$APPLICATION->IncludeComponent(
						"bitrix:catalog.section",
						"",
						Array(
							"TEMPLATE_THEME" => "blue",
							"PRODUCT_DISPLAY_MODE" => "N",
							"ADD_PICT_PROP" => "MORE_PHOTO",
							"LABEL_PROP" => "NEW_BOOK",
							"OFFER_ADD_PICT_PROP" => "FILE",
							"OFFER_TREE_PROPS" => array("-"),
							"PRODUCT_SUBSCRIPTION" => "N",
							"SHOW_DISCOUNT_PERCENT" => "N",
							"SHOW_OLD_PRICE" => "N",
							"SHOW_CLOSE_POPUP" => "Y",
							"MESS_BTN_BUY" => "Купить",
							"MESS_BTN_ADD_TO_BASKET" => "В корзину",
							"MESS_BTN_SUBSCRIBE" => "Подписаться",
							"MESS_BTN_DETAIL" => "Подробнее",
							"MESS_NOT_AVAILABLE" => "Нет в наличии",
							"AJAX_MODE" => "Y",
							"SEF_MODE" => "N",
							"IBLOCK_ID" => array(10, 12),
							"SECTION_ID" => $_REQUEST["section_id"],
							"SECTION_CODE" => "",
							"SECTION_USER_FIELDS" => array(),
							"ELEMENT_SORT_FIELD" => "sort",
							"ELEMENT_SORT_ORDER" => "asc",
							"ELEMENT_SORT_FIELD2" => "name",
							"ELEMENT_SORT_ORDER2" => "asc",
							"FILTER_NAME" => "searchFilter",
							"INCLUDE_SUBSECTIONS" => "Y",
							"SHOW_ALL_WO_SECTION" => "Y",
							"SECTION_URL" => "",
							"DETAIL_URL" => "",
							"BASKET_URL" => "/personal/basket.php",
							"ACTION_VARIABLE" => "action",
							"PRODUCT_ID_VARIABLE" => "id",
							"PRODUCT_QUANTITY_VARIABLE" => "quantity",
							"ADD_PROPERTIES_TO_BASKET" => "Y",
							"PRODUCT_PROPS_VARIABLE" => "prop",
							"PARTIAL_PRODUCT_PROPERTIES" => "N",
							"SECTION_ID_VARIABLE" => "SECTION_ID",
							"ADD_SECTIONS_CHAIN" => "Y",
							"DISPLAY_COMPARE" => "N",
							"SET_TITLE" => "Y",
							"SET_BROWSER_TITLE" => "Y",
							"BROWSER_TITLE" => "-",
							"SET_META_KEYWORDS" => "Y",
							"META_KEYWORDS" => "",
							"SET_META_DESCRIPTION" => "Y",
							"META_DESCRIPTION" => "",
							"SET_LAST_MODIFIED" => "Y",
							"USE_MAIN_ELEMENT_SECTION" => "Y",
							"SET_STATUS_404" => "N",
							"PAGE_ELEMENT_COUNT" => "300",
							"LINE_ELEMENT_COUNT" => "3",
							"PROPERTY_CODE" => array(),
							"OFFERS_FIELD_CODE" => array(),
							"OFFERS_PROPERTY_CODE" => array(),
							"OFFERS_SORT_FIELD" => "sort",
							"OFFERS_SORT_ORDER" => "asc",
							"OFFERS_SORT_FIELD2" => "active_from",
							"OFFERS_SORT_ORDER2" => "desc",
							"OFFERS_LIMIT" => "500",
							"BACKGROUND_IMAGE" => "-",
							"PRICE_CODE" => array(),
							"USE_PRICE_COUNT" => "Y",
							"SHOW_PRICE_COUNT" => "1",
							"PRICE_VAT_INCLUDE" => "Y",
							"PRODUCT_PROPERTIES" => array(),
							"USE_PRODUCT_QUANTITY" => "N",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "36000000",
							"CACHE_FILTER" => "Y",
							"CACHE_GROUPS" => "Y",
							"DISPLAY_TOP_PAGER" => "N",
							"DISPLAY_BOTTOM_PAGER" => "Y",
							"PAGER_TITLE" => "Товары",
							"PAGER_SHOW_ALWAYS" => "Y",
							"PAGER_TEMPLATE" => "",
							"PAGER_DESC_NUMBERING" => "N",
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
							"PAGER_SHOW_ALL" => "N",
							"HIDE_NOT_AVAILABLE" => "N",
							"OFFERS_CART_PROPERTIES" => array(),
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "N",
							"AJAX_OPTION_HISTORY" => "N",
							"CONVERT_CURRENCY" => "Y",
							"CURRENCY_ID" => "RUB",
							"ADD_TO_BASKET_ACTION" => "ADD",
							"PAGER_BASE_LINK_ENABLE" => "Y",
							"SET_STATUS_404" => "Y",
							"SHOW_404" => "Y",
							"MESSAGE_404" => "",
							"DISABLE_INIT_JS_IN_COMPONENT" => "N",
							"PAGER_BASE_LINK" => "",
							"PAGER_PARAMS_NAME" => "arrPager"
						)
					);
				
				
				
				
				
				}
				*/
				
				
				
				
				
				?>

            </div>
            <div class="clear"></div>
            <?
        }
        else
        {
            echo '<p class="padding">'.GetMessage("CT_BCSE_NOT_FOUND").'</p>';
        }
        ?>
    </div>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.compare.list",
    "simple",
    array(
        "IBLOCK_TYPE" => '1c_catalog',
        "IBLOCK_ID" => 12,
        "NAME" => 'CATALOG_COMPARE_LIST',
        "DETAIL_URL" => '/catalog/bytovaya/#SECTION_CODE#/#ELEMENT_CODE#/',
        "COMPARE_URL" => '/catalog/bytovaya/compare/',
        "ACTION_VARIABLE" => 'action',
        "PRODUCT_ID_VARIABLE" => 'id',
        'POSITION_FIXED' => 'Y',
        'POSITION' => 'top left'
    ),
    false,
    array("HIDE_ICONS" => "Y")
);?>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.compare.list",
    "simple",
    array(
        "IBLOCK_TYPE" => '1c_catalog',
        "IBLOCK_ID" => 10,
        "NAME" => 'CATALOG_COMPARE_LIST',
        "DETAIL_URL" => '/catalog/bytovaya/#SECTION_CODE#/#ELEMENT_CODE#/',
        "COMPARE_URL" => '/catalog/bytovaya/compare/',
        "ACTION_VARIABLE" => 'action',
        "PRODUCT_ID_VARIABLE" => 'id',
        'POSITION_FIXED' => 'Y',
        'POSITION' => 'top left'
    ),
    false,
    array("HIDE_ICONS" => "Y")
);?>
<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => "/include/is_delay_compare.php",
        "EDIT_TEMPLATE" => "standard.php"
    ),
    false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
