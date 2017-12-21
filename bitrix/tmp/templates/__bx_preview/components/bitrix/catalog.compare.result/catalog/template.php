<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$isAjax = ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["ajax_action"]) && $_POST["ajax_action"] == "Y");

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css',
    'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
);
?>

<?
// Удаляем все из списка
if ($_REQUEST["action"] == "DELETE_FROM_COMPARE_LIST" && $_REQUEST["id"] == 0) {
    unset($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]);
}
?>

<div class="bx_compare <? echo $templateData['TEMPLATE_CLASS']; ?>" id="bx_catalog_compare_block">

    <?
    if ($isAjax) {
        $APPLICATION->RestartBuffer();
    }
    ?>

    <div class="compare_result">

        <div class="table_compare">
            <div class="fix">
                <div class="left_no_scroll">
                    <div class="links_block">
                        <div class="del_all"><a
                                href="<?= $APPLICATION->GetCurPage(); ?>?action=DELETE_FROM_COMPARE_LIST&id=0"><span>Удалить список</span></a>
                        </div>
                        <a class="sortbutton<? echo(!$arResult["DIFFERENT"] ? ' current' : ''); ?>"
                           href="<? echo $arResult['COMPARE_URL_TEMPLATE'] . 'DIFFERENT=N'; ?>"
                           rel="nofollow"><?= GetMessage("CATALOG_ALL_CHARACTERISTICS") ?></a>
                        <a class="sortbutton<? echo($arResult["DIFFERENT"] ? ' current' : ''); ?>"
                           href="<? echo $arResult['COMPARE_URL_TEMPLATE'] . 'DIFFERENT=Y'; ?>"
                           rel="nofollow"><?= GetMessage("CATALOG_ONLY_DIFFERENT") ?></a>
                    </div>
                </div>

                <?
                if (!empty($arResult["SHOW_FIELDS"])) {
                    ?>
                    <div class="right_scroll right_scroll_1">
                        <table class="catalog_list compare_list compare_list_items">
                            <tr>
                                <?
                                foreach ($arResult["ITEMS"] as &$arElement) {
                                    ?>
                                    <td>
                                        <div class="item td">
                                            <a onclick="CatalogCompareObj.MakeAjaxAction('<?= CUtil::JSEscape($arElement['~DELETE_URL']) ?>');"
                                               href="javascript:void(0)"
                                               class="del"><?//=GetMessage("CATALOG_REMOVE_PRODUCT")
                                                ?></a>

                                            <?
                                            if (empty($arElement["FIELDS"]["DETAIL_PICTURE"]["SRC"])) {
                                                $arElement["FIELDS"]["DETAIL_PICTURE"]["SRC"] = $this->GetFolder() . '/no_photo.png';
                                            }
                                            ?>

                                            <a title="<?= $arElement["NAME"] ?>"
                                               style="background-image: url('<?= $arElement["FIELDS"]["DETAIL_PICTURE"]["SRC"] ?>')"
                                               class="img" href="<?= $arElement["DETAIL_PAGE_URL"] ?>"></a>

                                            <div class="title">
                                                <a title="<?= $arElement["NAME"] ?>"
                                                   href="<?= $arElement["DETAIL_PAGE_URL"] ?>"><?= $arElement["NAME"] ?></a>
                                            </div>

                                            <div class="price_block">
                                                <? if (!empty($arElement['MIN_PRICE']['DISCOUNT_VALUE'])) {
                                                    ?>
                                                    <div class="bx_price" id="bx_3966226736_14_price">
                                                        <? echo number_format($arElement['MIN_PRICE']['DISCOUNT_VALUE'], 0, '', ' '); ?>
                                                        <span> руб.</span>
                                                    </div>
                                                <?
                                                } ?>
                                            </div>

                                            <? if ($arElement['CATALOG_QUANTITY'] == 0) {
                                                ?>
                                                <div class="bx_catalog_item_controls_blockone">
                                                    <span class="bx_notavailable">Нет в наличии</span>
                                                </div>
                                            <?
                                            } else {
                                                ?>
                                                <div class="bx_catalog_item_controls">
                                                    <noindex><a class="bx_bt_button bx_small buy_button"
                                                                href="<?= $arElement["BUY_URL"] ?>" rel="nofollow"
                                                                onclick="yaCounter31721621.reachGoal('basket');"><?= GetMessage("CATALOG_COMPARE_BUY"); ?></a>
                                                    </noindex>
                                                </div>
                                            <?
                                            } ?>

                                        </div>
                                    </td>
                                    <?
                                }
                                unset($arElement);
                                ?>
                            </tr>
                        </table>
                    </div>
                    <?
                }
                ?>
            </div>
            <div class="clear"></div>

            <div class="not_fixed">
                <div class="left_no_scroll">
                    <table>
                        <?
                        if (!empty($arResult["SHOW_PROPERTIES"])) {
                            foreach ($arResult["SHOW_PROPERTIES"] as $code => $arProperty) {
                                $showRow = true;
                                if ($arResult['DIFFERENT']) {
                                    $arCompare = array();
                                    foreach ($arResult["ITEMS"] as &$arElement) {
                                        $arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
                                        if (is_array($arPropertyValue)) {
                                            sort($arPropertyValue);
                                            $arPropertyValue = implode(" / ", $arPropertyValue);
                                        }
                                        $arCompare[] = $arPropertyValue;
                                    }
                                    unset($arElement);
                                    $showRow = (count(array_unique($arCompare)) > 1);
                                }

                                if ($showRow) {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="td"><?= $arProperty["NAME"] ?></div>
                                        </td>
                                    </tr>
                                    <?
                                    unset($arElement);
                                }
                            }
                        }
                        ?>
                    </table>
                </div>


                <div class="right_scroll right_scroll_2">
                    <table class="compare_list">
                        <?
                        if (!empty($arResult["SHOW_PROPERTIES"])) {
                            foreach ($arResult["SHOW_PROPERTIES"] as $code => $arProperty) {
                                $showRow = true;
                                if ($arResult['DIFFERENT']) {
                                    $arCompare = array();
                                    foreach ($arResult["ITEMS"] as &$arElement) {
                                        $arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
                                        if (is_array($arPropertyValue)) {
                                            sort($arPropertyValue);
                                            $arPropertyValue = implode(" / ", $arPropertyValue);
                                        }
                                        $arCompare[] = $arPropertyValue;
                                    }
                                    unset($arElement);
                                    $showRow = (count(array_unique($arCompare)) > 1);
                                }

                                if ($showRow) {
                                    ?>
                                    <tr>
                                        <? foreach ($arResult["ITEMS"] as &$arElement) {
                                            ?>
                                            <td>
                                                <div class="td">
                                                    <?= strip_tags((is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]) ? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]) : $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])) ?>
                                                </div>
                                            </td>
                                            <?
                                        }
                                        unset($arElement);
                                        ?>
                                    </tr>
                                    <?
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?
    if ($isAjax) {
        die();
    }
    ?>

</div>

<script type="text/javascript">
    var CatalogCompareObj = new BX.Iblock.Catalog.CompareClass("bx_catalog_compare_block");
</script>