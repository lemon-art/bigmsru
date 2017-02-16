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
$resCurrency = array();
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
            if (!in_array($curTo, $resCurrency))
            {
                if ($curTo["AMOUNT_CNT"] != "1")
                    $resCurrency[$curTo["CURRENCY"]] = round($curTo["AMOUNT_CNT"] / $curTo["AMOUNT"], 4);
                else
                    $resCurrency[$curTo["CURRENCY"]] = $curTo["AMOUNT"];
            }
        }
        /* Take curr curency END */
    }
}

$arResult["CURRENCIES"] = $arCur;
$arResult["WF_AMOUNTS"] = $resCurrency;

$additionalProps = array("CONDITION_PROPERTIES" => "COND_PARAMS", "DISPLAY_PROPERTIES" => "PARAMS", "SALES_NOTES", "SALES_NOTES" => "SALES_NOTES_TEXT", "COUNTRY", "DEVELOPER", "MANUFACTURER_WARRANTY", "VENDOR_CODE", "MARKET_CATEGORY_PROP");
$HLblock = new CWebflyHighLoadBlock(2);
foreach ($arResult["OFFER"] as $keyMain => &$arOffer)
{
    foreach ($additionalProps as $paramK => $paramCode)
    {
        if (!empty($arParams[$paramCode]))
        {
            /* svojstva, znacheniya kotoryh dolzhny byt dostupny v shablone dlya sozdaniya uslovij, i parametry */
            if ($paramCode == "COND_PARAMS" or $paramCode == "PARAMS")
            {
                foreach ($arParams[$paramCode] as $key => $productProp)
                {
                    if (empty($productProp))
                        continue;
                    if ($productProp == "EMPTY")
                        continue;

                    if (!empty($productProp))
                    {
                        $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID"], $arOffer["ID"], array("sort" => "asc"), Array("CODE" => $productProp))->GetNext();
                        if (($props["VALUE"] == "" or empty($props["VALUE"])) and ! empty($arOffer["GROUP_ID"]))
                        {
                            $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID_CATALOG"], $arOffer["GROUP_ID"], array("sort" => "asc"), Array("CODE" => $productProp))->GetNext();
                        }
                        $arOffer[$paramK][$productProp] = CIBlockFormatProperties::GetDisplayValue($arOffer, $props, "ym_out");

                        $arOffer[$paramK][$productProp]["DISPLAY_VALUE"] = $arOffer[$paramK][$productProp]["VALUE_ENUM"] ? strip_tags($arOffer[$paramK][$productProp]["VALUE_ENUM"]) : strip_tags($arOffer[$paramK][$productProp]["DISPLAY_VALUE"]);

                        if (empty($arOffer[$paramK][$productProp]["DISPLAY_VALUE"]))
                        {
                            $arOffer[$paramK][$productProp]["DISPLAY_VALUE"] = strip_tags($arOffer[$paramK][$productProp]["VALUE"]);
                        }

                        $arOffer[$paramK][$productProp]["DISPLAY_VALUE"] = xml_creator($arOffer[$paramK][$productProp]["DISPLAY_VALUE"], true);
                        $arOffer[$paramK][$productProp]["DISPLAY_NAME"] = $props["NAME"];
                        $arOffer[$paramK][$productProp]["DISPLAY_DESCRIPTION"] = $props["DESCRIPTION"];
                        if ($productProp == "BREND" and $arOffer[$paramK][$productProp]["DISPLAY_VALUE"])
                        {
                            $brendID = $HLblock->getRow(array("ID"), array("UF_XML_ID" => $arOffer[$paramK][$productProp]["VALUE"]), array());
                            $arOffer[$paramK][$productProp]["BRAND_ID"] = $brendID["ID"];
                            unset($brendID);
                        }
                        unset($props);
                        unset($valueID);
                    }
                }
            }
            /* vse ostalnye dopolnitelnye svojstva */
            else
            {
                /* �� SALES_NOTES_TEXT */
                if ($paramCode != "SALES_NOTES_TEXT")
                {
                    $isExistProp = CIBlockProperty::GetList(Array("sort" => "asc", "name" => "asc"), Array("CODE" => $arParams[$paramCode]))->Fetch();
                    if ($isExistProp)
                    {
                        $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID"], $arOffer["ID"], array("sort" => "asc"), Array("CODE" => $arParams[$paramCode]))->GetNext();
                        if (($props["VALUE"] == "" or empty($props["VALUE"])) and ! empty($arOffer["GROUP_ID"]))
                        {
                            $props = CIBlockElement::GetProperty($arOffer["IBLOCK_ID_CATALOG"], $arOffer["GROUP_ID"], array("sort" => "asc"), Array("CODE" => $arParams[$paramCode]))->GetNext();
                        }
                        $dispProp = CIBlockFormatProperties::GetDisplayValue($arOffer, $props);
                        $arOffer[$paramCode] = $dispProp["VALUE_ENUM"] ? xml_creator($dispProp["VALUE_ENUM"], true) : xml_creator($dispProp["DISPLAY_VALUE"], true);
                        if (substr_count($arOffer[$paramCode], "a href") > 0)
                            $arOffer[$paramCode] = htmlspecialcharsBack($arOffer[$paramCode]);

                        $arOffer[$paramCode] = strip_tags($arOffer[$paramCode]);
                    }
                    else
                    {
                        $arOffer[$paramCode] = xml_creator($arParams[$paramCode], true);
                    }
                    unset($isExistProp);
                    unset($props);
                    unset($dispProp);
                }
                /* SALES_NOTES_TEXT */
                else
                {
                    $arParams[$paramCode] = trim($arParams[$paramCode]);
                    $arOffer[$paramK] = xml_creator($arParams[$paramCode], true);
                    $arOffer[$paramK] = strip_tags($arOffer[$paramK]);
                }
            }
        }
    }
    //Товары данных брендов В наличии
    if (in_array($arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"], $arParams["BRANDS_AVAILABLE"]))
    {
        if ($arOffer["AVAIBLE"] == "false")
        {
            $arResult["OFFER"][$keyMain]["AVAIBLE"] = "true";
            $arOffer["AVAIBLE"] = "true";
        }
    }

    //Доставка Завтра для товаров в наличии и для выбранных Брендов
    if ($arOffer["AVAIBLE"] == "true" or ( in_array($arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"], $arParams["BRANDS_TOMORROW"]) and $arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"]))
    {
        if (empty($arOffer["DELIVERY_OPTIONS_EX"]) and count($arOffer["DELIVERY_OPTIONS_EX"]) == 0)
        {
            $arResult["OFFER"][$keyMain]["DELIVERY_OPTIONS_EX"][0] = array(0 => $arResult["DELIVERY_OPTION_SHOP"][0][0], 1 => "1");
            if ($arResult["DELIVERY_OPTION_SHOP"][0][2] != "")
                $arResult["OFFER"][$keyMain]["DELIVERY_OPTIONS_EX"][0][2] = $arResult["DELIVERY_OPTION_SHOP"][0][2];
        }
    }
    if ($arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"])
    {
        //Бренды с бесплатной доставкой
        if (in_array($arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"], $arParams["BRANDS_FREE"]))
        {
            if (empty($arOffer["DELIVERY_OPTIONS_EX"]) and count($arOffer["DELIVERY_OPTIONS_EX"]) == 0)
            {
                $arResult["OFFER"][$keyMain]["DELIVERY_OPTIONS_EX"][0] = array(0 => "0", 1 => $arResult["DELIVERY_OPTION_SHOP"][0][1]);
                if ($arResult["DELIVERY_OPTION_SHOP"][0][2] != "")
                    $arResult["OFFER"][$keyMain]["DELIVERY_OPTIONS_EX"][0][2] = $arResult["DELIVERY_OPTION_SHOP"][0][2];
            }
        }

        //Бренды с доставкой за 300
        if (in_array($arOffer["CONDITION_PROPERTIES"]["BREND"]["BRAND_ID"], $arParams["BRANDS_300"]))
        {
            if (empty($arOffer["DELIVERY_OPTIONS_EX"]) and count($arOffer["DELIVERY_OPTIONS_EX"]) == 0)
            {
                $arResult["OFFER"][$keyMain]["DELIVERY_OPTIONS_EX"][0] = array(0 => "300", 1 => $arResult["DELIVERY_OPTION_SHOP"][0][1]);
                if ($arResult["DELIVERY_OPTION_SHOP"][0][2] != "")
                    $arResult["OFFER"][$keyMain]["DELIVERY_OPTIONS_EX"][0][2] = $arResult["DELIVERY_OPTION_SHOP"][0][2];
            }
        }
    }
}
?>