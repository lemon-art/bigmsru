<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
    $arResult["ORDER_ID"] = $arParams["ORDER_PARAM_TRANSACTION"];
    if (CModule::IncludeModule("sale") && $arResult["ORDER_ID"]>0){
        $arBasketItems = array();

        $dbBasketItems = CSaleBasket::GetList(
                array(
                        "NAME" => "ASC",
                        "ID" => "ASC"
                    ),
                array(
                        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                        "LID" => SITE_ID,
                        "ORDER_ID" => $arResult["ORDER_ID"],
                    ),
                false,
                false,
                array("ID", "CALLBACK_FUNC", "MODULE",
                      "PRODUCT_ID", "QUANTITY", "DELAY",
                      "CAN_BUY", "PRICE", "WEIGHT")
            );
        while ($arItems = $dbBasketItems->Fetch())
        {
            $arResult["ITEMS"][] = array(
                "PROD_ID" => $arItems["PRODUCT_ID"],
                "QNT" => $arItems["QUANTITY"],
                "PRICE" =>  $arItems["PRICE"],
            );
        }
    }


    $this->IncludeComponentTemplate();
?>