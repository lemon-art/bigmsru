<?

CModule::IncludeModule("highloadblock");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

class CWebflyHighLoadBlock {

    private $hlBlockID = 0;
    private $hlHandler = null;
    public $errors = array();

    /**
     * Constructs an object
     * @param int $hlblockid hlblock id
     * @version 0.5
     */
    function __construct($hlblockid = 0) {
        if ($hlblockid > 0)
        {
            $this->setHLBlockId($hlblockid);
        }
    }

    /**
     * Sets HL block for CRUD
     * @param int $hlblockid as name suggests
     */
    public function setHLBlockId($hlblockid) {
        $this->hlBlockID = $hlblockid;
        $hlblock = HL\HighloadBlockTable::getById($hlblockid)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $this->hlHandler = $entity->getDataClass();
    }

    /**
     * Main method to add data
     * @param array $fields data fields
     * @return boolean
     */
    function addRow($fields) {
        if (empty($fields))
        {
            $this->errors[] = "Can't add empty row!";
            return false;
        }
        else
        {
            $hlHandler = $this->hlHandler;
            $res = $hlHandler::add($fields);
            return $res->getId();
        }
    }

    /**
     * Modify
     * @param int $elemId elem id
     * @param array $data
     * @return array
     */
    function elemModify($elemId, $data) {
        $hlHandler = $this->hlHandler;
        $res = $hlHandler::update($elemId, $data);
        return $res;
    }

    /**
     * Delete
     * @param int $elemId element id
     */
    function elemDelete($elemId) {
        if (!empty($elemId))
        {
            $hlHandler = $this->hlHandler;
            $hlHandler::Delete($elemId);
        }
    }

    /**
     * Gets element
     * @param array $order
     * @param array $filter
     * @return array
     */
    function getQuery($select = array("*"), $filter = array(), $order = array("ID" => "ASC"), $group = array(), $limit = 0, $offset = 0, $runtime = array()) {
        $hlHandler = $this->hlHandler;
        $getList = new Entity\Query($hlHandler);
        $getList->setSelect($select);
        $getList->setOrder($order);
        if (!empty($filter))
            $getList->setFilter($filter);
        if (!empty($group))
            $getList->setGroup($group);
        if (!empty($limit))
            $getList->setLimit($limit);
        if (!empty($offset))
            $getList->setOffset($offset);
        if (!empty($runtime))
            $getList->registerRuntimeField($runtime);
        $result = $getList->exec();
        $result = new CDBResult($result);
        $arRes = array();
        while ($row = $result->Fetch()) {
            $arRes[] = $row;
        }
        return $arRes;
    }

    /**
     * Gets all data in one fetch query
     * @param array $select fields to select
     * @param array $filter fields to filter
     * @param array $order as name suggests
     */
    function getData($select = array("*"), $filter = array(), $order = array("ID" => "ASC"), $limit = 0, $offset = 0) {
        $hlHandler = $this->hlHandler;
        $arData = array(
          "select" => $select,
          "order" => $order,
          "filter" => $filter
        );
        if ($limit > 0)
            $arData["limit"] = $limit;
        if ($offset > 0)
            $arData["offset"] = $offset;
        $rsData = $hlHandler::getList($arData);
        return $rsData->fetchAll();
    }

    /**
     * Gets one row
     * @param type $select
     * @param type $filter
     * @param type $order
     */
    function getRow($select = array("*"), $filter = array(), $order = array("ID" => "ASC")) {
        $hlHandler = $this->hlHandler;
        $arData = array(
          "select" => $select,
          "order" => $order,
          "filter" => $filter,
        );
        return $hlHandler::getRow($arData);
    }

    /**
     * Runs count expression with filter statement
     * @param array $filter as name suggests
     * @return type
     */
    function getCount($select, $filter = array()) {
        $hlHandler = $this->hlHandler;
        $select[] = "CNT";
        $rsData = $hlHandler::getList(array(
              "select" => $select,
              "order" => array(),
              "filter" => $filter,
              "runtime" => array(new Entity\ExpressionField('CNT', 'COUNT(*)'))
        ));
        return $rsData->fetchAll();
    }

    /**
     * Gets hlblock id
     * @return int hlblock id
     */
    function getHLBlockID() {
        return $this->hlBlockID;
    }

    /**
     * Gets hl handler
     * @return object
     */
    function getHLHandler() {
        return $this->hlHandler;
    }

    /**
     * Gets table name
     * @return string
     */
    function getTableName() {
        $hlHandler = $this->hlHandler;
        return $hlHandler::getTableName();
    }

    /**
     * Gets HL Blocks list
     * @param type $select
     * @param type $filter
     * @return type
     */
    function getHLBlocksList($select = array("ID", "NAME"), $filter = array()) {
        $hlList = HL\HighloadBlockTable::getList(array("select" => $select, "filter" => $filter))->fetchAll();
        return $hlList;
    }

}

CModule::IncludeModule("catalog");
if (!function_exists("xml_creator"))
{

    function xml_creator($text, $bHSC = true, $bDblQuote = false) {
        $bDblQuote = (true == $bDblQuote ? true : false);

        if ($bHSC)
        {
            $text = htmlspecialcharsBx($text);
            if ($bDblQuote)
                $text = str_replace('&quot;', '"', $text);
        }
        $text = preg_replace("/[\x1-\x8\xB-\xC\xE-\x1F]/", "", $text);
        $text = str_replace("'", "&apos;", $text);
        return $text;
    }

}

function getBaseCurrency() {
    if (CModule::IncludeModule('currency'))
    {
        $res = CCurrency::GetList(($by = "name"), ($order = "asc"), "RU");
        while ($arRes = $res->Fetch()) {
            if ($arRes["AMOUNT"] == 1)
                return $arRes["CURRENCY"];
        }
    }
}

$baseCur = getBaseCurrency();
if (!CModule::IncludeModule('currency'))
    $baseCur = $arParams["CURRENCY"];
$arCur = array();
$arCur[0] = $baseCur;

foreach ($arResult["CURRENCIES"] as $cur)
{
    $cur = trim($cur);
    if ($cur == 'RUR')
    {
        $cur = 'RUB';
    }

    if (!in_array($cur, $arCur))
        $arCur[] = $cur;

    if (CModule::IncludeModule('currency'))
    {
        /* Take curr curency START */
        $arFilter = array(
          "CURRENCY" => $cur,
        );
        $by = "date";
        $order = "asc";

        $db_rate = CCurrencyRates::GetList($by, $order, $arFilter);
        while ($ar_rate = $db_rate->Fetch()) {
            if ($ar_rate["RATE_CNT"] != "1")
                $resCurrency[$ar_rate["CURRENCY"]] = round($ar_rate["RATE_CNT"] / $ar_rate["RATE"], 4);
            else
                $resCurrency[$ar_rate["CURRENCY"]] = $ar_rate["RATE"];
        }
        if ($resCurrency == NULL)
        {
            $curTo = CCurrency::GetByID($cur);
            if ($curTo and $resCurrency)
            {
                if (!in_array($curTo, $resCurrency))
                {
                    if ($curTo["AMOUNT_CNT"] != "1")
                        $resCurrency[$curTo["CURRENCY"]] = round($curTo["AMOUNT_CNT"] / $curTo["AMOUNT"], 4);
                    else
                        $resCurrency[$curTo["CURRENCY"]] = $curTo["AMOUNT"];
                }
            }
        }
        /* Take curr curency END */
    }
}

$arResult["CURRENCIES"] = $arCur;
$arResult["WF_AMOUNTS"] = $resCurrency;
$HLblock = new CWebflyHighLoadBlock(2);
foreach ($arResult["OFFER"] as $num => &$arOffer)
{
    /* po dopolnitelnye svedeniya */
    foreach ($arParams["PARAMS"] as $k => $v)
    {
        /* ���� ������ �������� - ���������� */
        if ($v == "EMPTY" or $v == "" or $v == "0")
            continue;

        $code = $v;
        $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID"], $arOffer["ID"], array("sort" => "asc"), Array("CODE" => $code))->GetNext();

        $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code] = CIBlockFormatProperties::GetDisplayValue($arResult["OFFER"], $props, "ym_out");

        $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_VALUE"] = $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["VALUE_ENUM"] ?
            $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["VALUE_ENUM"] :
            strip_tags($arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_VALUE"]);

        $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_VALUE"] = xml_creator($arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_VALUE"], true);
        $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_NAME"] = $props["NAME"];
        $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_DESCRIPTION"] = $props["DESCRIPTION"];

        unset($props);

        /* esli torgovoe predlozhenie i svojstvo zapolneno, to beretsya svojstvo torgovogo predlozheniya, po umolchaniyu - beretsya svojstvo tovara */
        if ($arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_VALUE"] != "")
        {
            $arOffer["LIST_PROPERTIES"]["PARAMS"][$v] = $v;
        }
        elseif (!empty($arOffer["GROUP_ID"]))
        {
            $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID_CATALOG"], $arOffer["GROUP_ID"], array("sort" => "asc"), Array("CODE" => $code))->GetNext();

            $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code] = CIBlockFormatProperties::GetDisplayValue($arResult["OFFER"], $props, "ym_out");
            $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_VALUE"] = $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["VALUE_ENUM"] ? $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["VALUE_ENUM"] : strip_tags($arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_VALUE"]);

            $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_VALUE"] = xml_creator($arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_VALUE"], true);
            $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_NAME"] = $props["NAME"];
            $arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_DESCRIPTION"] = $props["DESCRIPTION"];
            if ($arOffer["DISPLAY_PROPERTIES_OPTIONAL"][$code]["DISPLAY_VALUE"] != "")
            {
                $arOffer["LIST_PROPERTIES"]["PARAMS"][$v] = $v;
            }
            unset($props);
        }
    }

    $i = 0;
    $f = 0;


    foreach ($arParams as $k => $v)
    {
        /* esli pustoe znachenie svojstva */
        if ($v == "NONE")
            $f = 1;

        /* znacheniya unit - perekhod na sleduyushchij shag */
        if (strpos($k, "_UNIT"))
        {
            $s = explode("_UNIT", $k);
            $arOffer['UNIT'][$s[0]] = $v;
            continue;
        }

        if (strpos($k, "~") !== false)
            continue;

        if ($v == "")
            continue;

        /* esli svojstva Proizvoditel, Strana proizvoditel, Kod proizvoditelya, Garantiya proizvoditelya */
        if ($k == "DEVELOPER" || $k == "COUNTRY" || $k == "VENDOR_CODE" || $k == "MANUFACTURER_WARRANTY")
            $i = 1;

        /* esli svojstva Dopolnitelnye svedeniya, Svojstva znacheniya kotoryh dolzhny byt dostupny v shablone dlya sozdaniya uslovij */
        if ($k == "PARAMS" || $k == "COND_PARAMS")
            $i = 0;

        /* esli svojstvo ne vybrano - perekhod na sleduyushchij shag */
        if ($v == "EMPTY")
            continue;

        /* na sleduyushchij shag, esli ne svojstva Proizvoditel, Strana proizvoditel, Kod proizvoditelya, Garantiya proizvoditelya */
        if ($i == 0)
            continue;

        $code = $v;
        if (is_array($code))
            continue;

        //vse usloviya s manufacturer_warranty poyavilis potomu chto my dobavili dlya nego vozmozhnost vpisyvaniya
        if ($k == "MANUFACTURER_WARRANTY")
        {
            $isExistProp = CIBlockProperty::GetList(Array("sort" => "asc", "name" => "asc"), Array("CODE" => $code))->Fetch();
        }

        if ($k != "MANUFACTURER_WARRANTY" or ( $k == "MANUFACTURER_WARRANTY" and $isExistProp))//vozmozhnost vpisyvaniya
        {
            $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID"], $arOffer["ID"], array("sort" => "asc"), Array("CODE" => $code))->GetNext();

            $arOffer["DISPLAY_PROPERTIES"][$code] = CIBlockFormatProperties::GetDisplayValue($arResult["OFFER"], $props, "ym_out");

            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] = $arOffer["DISPLAY_PROPERTIES"][$code]["VALUE_ENUM"] ?
                $arOffer["DISPLAY_PROPERTIES"][$code]["VALUE_ENUM"] :
                strip_tags($arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]);
            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] = xml_creator($arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"], true);
            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_NAME"] = $props["NAME"];
            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_DESCRIPTION"] = $props["DESCRIPTION"];
        }

        if ($k == "MANUFACTURER_WARRANTY" and ! $isExistProp)//vozmozhnost vpisyvaniya
        {
            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] = xml_creator($arParams["MANUFACTURER_WARRANTY"], true);
        }
        unset($props);
        unset($isExistProp);

        if (!empty($arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]))
        {
            $arOffer["LIST_PROPERTIES"][$k][] = $k;
        }

        $x = 0;
        if (is_array($arOffer['LIST_PROPERTIES']))
            foreach ($arOffer["LIST_PROPERTIES"] as $k_prop => $v_prop)
            {
                if ($k == $k_prop)
                    $x++;
            }

        if ($x == 0 && !empty($arOffer["GROUP_ID"]))
        {
            $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID_CATALOG"], $arOffer["GROUP_ID"], array("sort" => "asc"), Array("CODE" => $code))->GetNext();

            $arOffer["DISPLAY_PROPERTIES"][$code] = CIBlockFormatProperties::GetDisplayValue($arResult["OFFER"], $props, "ym_out");
            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] = $arOffer["DISPLAY_PROPERTIES"][$code]["VALUE_ENUM"] ? $arOffer["DISPLAY_PROPERTIES"][$code]["VALUE_ENUM"] : strip_tags($arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]);
            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] = xml_creator($arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"], true);
            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_NAME"] = $props["NAME"];
            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_DESCRIPTION"] = $props["DESCRIPTION"];

            if ($arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] != "" and $arOffer["LIST_PROPERTIES"][$k])
                $arOffer["LIST_PROPERTIES"][$k] = $k;
            unset($props);
        }

        if (!$f && empty($arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]) && $k == "GENDER")
        {
            $arOffer["LIST_PROPERTIES"][$k][] = $code;
            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_NAME"] = GetMessage("NAME_GENDER");
            $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] = $code;
        }
    }

    /* Svojstva, znacheniya kotoryh dolzhny byt dostupny v shablone dlya sozdaniya uslovij */
    foreach ($arParams['COND_PARAMS'] as $k => $code)
    {
        $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID"], $arOffer["ID"], array("sort" => "asc"), Array("CODE" => $code))->GetNext();

        $arOffer["CONDITION_PROPERTIES"][$code] = CIBlockFormatProperties::GetDisplayValue($arResult["OFFER"], $props, "ym_out");
        $arOffer["CONDITION_PROPERTIES"][$code]["DISPLAY_VALUE"] = $arOffer["CONDITION_PROPERTIES"][$code]["VALUE_ENUM"] ? $arOffer["CONDITION_PROPERTIES"][$code]["VALUE_ENUM"] : strip_tags($arOffer["CONDITION_PROPERTIES"][$code]["DISPLAY_VALUE"]);

        $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"] = xml_creator($arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"], true);
        $arOffer["CONDITION_PROPERTIES"][$code]["DISPLAY_NAME"] = $props["NAME"];
        $arOffer["CONDITION_PROPERTIES"][$code]["DISPLAY_DESCRIPTION"] = $props["DESCRIPTION"];
        if ($code == "BREND" and $arOffer["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE")
        {
            $brendID = $HLblock->getRow(array("ID"), array("UF_XML_ID" => $arOffer[$paramK][$productProp]["VALUE"]), array());
            $arOffer["CONDITION_PROPERTIES"][$code]["BRAND_ID"] = $brendID["ID"];
            unset($brendID);
        }
        unset($props);

        if ($arOffer["CONDITION_PROPERTIES"][$code]["DISPLAY_VALUE"] == '' && !empty($arOffer["GROUP_ID"]))
        {
            $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID_CATALOG"], $arOffer["GROUP_ID"], array("sort" => "asc"), Array("CODE" => $code))->GetNext();

            $arOffer["CONDITION_PROPERTIES"][$code] = CIBlockFormatProperties::GetDisplayValue($arResult["OFFER"], $props, "ym_out");
            $arOffer["CONDITION_PROPERTIES"][$code]["DISPLAY_VALUE"] = $arOffer["CONDITION_PROPERTIES"][$code]["VALUE_ENUM"] ? $arOffer["CONDITION_PROPERTIES"][$code]["VALUE_ENUM"] : strip_tags($arOffer["CONDITION_PROPERTIES"][$code]["DISPLAY_VALUE"]);
            $arOffer["CONDITION_PROPERTIES"][$code]["DISPLAY_NAME"] = $props["NAME"];
            $arOffer["CONDITION_PROPERTIES"][$code]["DISPLAY_DESCRIPTION"] = $props["DESCRIPTION"];
            if ($code == "BREND")
            {
                $brendID = $HLblock->getRow(array("ID"), array("UF_XML_ID" => $arOffer[$paramK][$productProp]["VALUE"]), array());
                $arOffer["CONDITION_PROPERTIES"][$code]["BRAND_ID"] = $brendID["ID"];
                unset($brendID);
            }
            unset($props);
        }
    }

    /* vygruzhat rekvezity */
    foreach ($arParams['MULTI_STRING_PROP'] as $k => $code)
    {
        $dbProp = CIBlockElement::GetProperty($arOffer["IBLOCK_ID"], $arOffer["ID"], array("sort" => "asc"), Array("CODE" => $code));

        while ($arProp = $dbProp->GetNext()) {
            $cod = $code . '_' . $arProp['PROPERTY_VALUE_ID'];

            $arOffer["DISPLAY_CHARACTERISTICS"][$cod] = CIBlockFormatProperties::GetDisplayValue($arResult["OFFER"], $arProp, "ym_out");

            $arOffer["DISPLAY_CHARACTERISTICS"][$cod]["DISPLAY_VALUE"] = $arOffer["DISPLAY_CHARACTERISTICS"][$cod]["VALUE_ENUM"] ?
                $arOffer["DISPLAY_CHARACTERISTICS"][$cod]["VALUE_ENUM"] :
                strip_tags($arOffer["DISPLAY_CHARACTERISTICS"][$cod]["DISPLAY_VALUE"]);

            $arOffer["DISPLAY_CHARACTERISTICS"][$cod]["DISPLAY_VALUE"] = xml_creator($arOffer["DISPLAY_CHARACTERISTICS"][$cod]["DISPLAY_VALUE"], true);
            $arOffer["DISPLAY_CHARACTERISTICS"][$cod]["DISPLAY_NAME"] = $arProp['NAME'];
            unset($arProp);
        }
        unset($dbProp);
    }

    if ($arParams ["SALES_NOTES"] != "0")
    {
        $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID"], $arOffer["ID"], array("sort" => "asc"), Array("CODE" => $arParams["SALES_NOTES"]))->GetNext();
        if (($props["VALUE"] == "" or empty($props["VALUE"])) and ! empty($arOffer["GROUP_ID"]))
        {
            $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID_CATALOG"], $arOffer["GROUP_ID"], array("sort" => "asc"), Array("CODE" => $arParams["SALES_NOTES"]))->GetNext();
        }
        $arOffer["SALES_NOTES"] = CIBlockFormatProperties::GetDisplayValue($arOffer, $props, "ym_out");
        $arOffer["SALES_NOTES"] = $arOffer["SALES_NOTES"]["VALUE_ENUM"] ? xml_creator($arOffer["SALES_NOTES"]["VALUE_ENUM"], true) : xml_creator($arOffer["SALES_NOTES"]["DISPLAY_VALUE"], true);
        $arOffer["SALES_NOTES"] = strip_tags($arOffer["SALES_NOTES"]);
        unset($props);
    }
    if (!empty($arParams ["SALES_NOTES_TEXT"]))
    {
        $arParams["SALES_NOTES_TEXT"] = trim($arParams["SALES_NOTES_TEXT"]);
        $arOffer["SALES_NOTES"] = xml_creator($arParams["SALES_NOTES_TEXT"], true);
        $arOffer["SALES_NOTES"] = strip_tags($arOffer["SALES_NOTES"]);
    }

    //Товары данных брендов В наличии
    if (in_array($arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"], $arParams["BRANDS_AVAILABLE"]))
    {
        if ($arOffer["AVAIBLE"] == "false")
        {
            $arResult["OFFER"][$num]["AVAIBLE"] = "true";
            $arOffer["AVAIBLE"] = "true";
        }
    }

    //Доставка Завтра для товаров в наличии и для выбранных Брендов
    if ($arOffer["AVAIBLE"] == "true" or ( in_array($arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"], $arParams["BRANDS_TOMORROW"]) and $arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"]))
    {
        //если для товара заданы параметры доставки, то переопределяем сроки доставки
        if ($arOffer["DELIVERY_OPTIONS_EX"])
        {
            if (!empty($arOffer["DELIVERY_OPTIONS_EX"]) and count($arOffer["DELIVERY_OPTIONS_EX"]) > 0)
            {
                foreach ($arOffer["DELIVERY_OPTIONS_EX"] as $optK => $opt)
                {
                    $arResult["OFFER"][$num]["DELIVERY_OPTIONS_EX"][$optK][1] = "1";
                }
            }
        }
        else//иначе берем данные из общей доставки с заменой сроков
        {
            $arResult["OFFER"][$num]["DELIVERY_OPTIONS_EX"][0] = array(0 => $arResult["DELIVERY_OPTION_SHOP"][0][0], 1 => "1");
            if ($arResult["DELIVERY_OPTION_SHOP"][0][2] != "")
                $arResult["OFFER"][$num]["DELIVERY_OPTIONS_EX"][0][2] = $arResult["DELIVERY_OPTION_SHOP"][0][2];
        }
    }
    if ($arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"])
    {
        //Бренды с бесплатной доставкой
        if (in_array($arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"], $arParams["BRANDS_FREE"]))
        {
            //если для товара заданы параметры доставки, то переопределяем стоимость доставки
            if ($arOffer["DELIVERY_OPTIONS_EX"])
            {
                if (!empty($arOffer["DELIVERY_OPTIONS_EX"]) and count($arOffer["DELIVERY_OPTIONS_EX"]) > 0)
                {
                    foreach ($arOffer["DELIVERY_OPTIONS_EX"] as $optK => $opt)
                    {
                        $arResult["OFFER"][$num]["DELIVERY_OPTIONS_EX"][$optK][0] = "0";
                    }
                }
            }
            else//иначе берем данные из общей доставки с заменой стоимости
            {
                $arResult["OFFER"][$num]["DELIVERY_OPTIONS_EX"][0] = array(0 => "0", 1 => $arResult["DELIVERY_OPTION_SHOP"][0][1]);
                if ($arResult["DELIVERY_OPTION_SHOP"][0][2] != "")
                    $arResult["OFFER"][$num]["DELIVERY_OPTIONS_EX"][0][2] = $arResult["DELIVERY_OPTION_SHOP"][0][2];
            }
        }
        //Бренды с доставкой за 300
        if (in_array($arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"], $arParams["BRANDS_300"]))
        {
            //если для товара заданы параметры доставки, то переопределяем стоимость доставки
            if ($arOffer["DELIVERY_OPTIONS_EX"])
            {
                if (!empty($arOffer["DELIVERY_OPTIONS_EX"]) and count($arOffer["DELIVERY_OPTIONS_EX"]) > 0)
                {
                    foreach ($arOffer["DELIVERY_OPTIONS_EX"] as $optK => $opt)
                    {
                        $arResult["OFFER"][$num]["DELIVERY_OPTIONS_EX"][$optK][0] = "300";
                    }
                }
            }
            else//иначе берем данные из общей доставки с заменой стоимости
            {
                $arResult["OFFER"][$num]["DELIVERY_OPTIONS_EX"][0] = array(0 => "300", 1 => $arResult["DELIVERY_OPTION_SHOP"][0][1]);
                if ($arResult["DELIVERY_OPTION_SHOP"][0][2] != "")
                    $arResult["OFFER"][$num]["DELIVERY_OPTIONS_EX"][0][2] = $arResult["DELIVERY_OPTION_SHOP"][0][2];
            }
        }
    }
}
$arResult["FOR_DELETE"] = array(
  "PROP_ALGORITHM_VALUE", "NAME_PROP", "DEVELOPER", "MODEL", "VENDOR_CODE", "COUNTRY", "MANUFACTURER_WARRANTY", "SALES_NOTES",
  "SALES_NOTES_TEXT", "BIG_CATALOG_PROP", "UTM_SOURCE", "UTM_MEDIUM", "UTM_CAMPAIGN", "UTM_TERM", "LOCAL_DELIVERY_COST_OFFER", "STORE_OFFER",
  "STORE_PICKUP", "PREFIX_PROP", "AGE_CATEGORY", "DELIVERY_OPTIONS_EX", "BID", "CBID", "CPA_OFFERS", "EXPIRY", "WEIGHT", "DIMENSIONS");

$arResult["CLOTHES_PARAMS"] = array(
  "SIZE",
  "COLOR",
  "GENDER",
  "AGE",
  "MATERIAL",
  "GROWTH",
  "CHEST",
  "NECK_GIRTH",
  "WAIST",
  "GIRTH_AT_BREAST",
  "CUP",
  "SIZE_UNDERWEAR",
);
?>