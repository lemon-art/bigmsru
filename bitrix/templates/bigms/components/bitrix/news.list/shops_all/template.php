<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$out = array();
?>

    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ob_start();
        ?>
        <div class="item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <div class="vl">
                <div class="title"><?= $arItem["NAME"] ?></div>

                <? if (!empty($arItem["PROPERTIES"]["ADRESS"]["VALUE"])) { ?>
                    <div class="adress">Адрес: <?= $arItem["PROPERTIES"]["ADRESS"]["VALUE"] ?></div><? } ?>
                <? if (!empty($arItem["PROPERTIES"]["REZHIM"]["VALUE"])) { ?>
                    <div class="reshim">Время работы: <?= $arItem["PROPERTIES"]["REZHIM"]["VALUE"] ?></div><? } ?>

                <div class="phone">
                    <? foreach ($arItem["PROPERTIES"]["PHONE"]["VALUE"] as $k => $phone) {
                        if ($k == 0) {
                            echo 'Телефон: ' . $phone;
                        } else {
                            echo ', ' . $phone;
                        }
                    } ?>
                </div>
            </div>

            <? if (!empty($arItem["PROPERTIES"]["VIDEO"]["VALUE"])) { ?>
                <a class="fancybox video_link" href="#video<?= $arItem["ID"] ?>"><span>Видео проезда</span></a>
                <div id="video<?= $arItem["ID"] ?>"
                     class="hidden "><?= $arItem["PROPERTIES"]["VIDEO"]["~VALUE"] ?></div>
            <? } else { ?>
                <div style="margin-bottom: 46px;"></div>
            <? } ?>

            <? if (!empty($arItem["PROPERTIES"]["HOW_TO_GET_SLIDER"]["VALUE"])) { ?>

                <a id="how_to_get" class="fancybox how_to_get" rel="<?= $kk ?>"
                   href="<?= CFile::getPath($arItem["PROPERTIES"]["HOW_TO_GET_SLIDER"]["VALUE"][0]); ?>"><span>Как пройти</span>
                    <script>
                        $(document).ready(function () {
                            $("#how_to_get").click(function () {
                                $.fancybox.open([

                                    <? foreach($arItem["PROPERTIES"]["HOW_TO_GET_SLIDER"]["VALUE"] as $kk => $how_to) {?>
                                    {
                                        href: "<?=CFile::getPath($how_to)?>",
                                    },

                                    <? }  ?>

                                ], {
                                    nextEffect: 'fade',
                                    prevEffect: 'fade'
                                });
                                return false;
                            });
                        }); // ready
                    </script>
                </a>

            <? } ?>

            <script type="text/javascript">
                ymaps.ready(init<?=$arItem["ID"]?>);

                function init<?=$arItem["ID"]?> () {
                    var myMap = new ymaps.Map("map<?=$arItem["ID"]?>", {
                        center: [<?=$arItem["PROPERTIES"]["MAP"]["VALUE"]?>],
                        zoom: 16,
                        behaviors: ['default', 'scrollZoom'],
                        controls: ['mapTools']
                    });

                    myPlacemark = new ymaps.Placemark([<?=$arItem["PROPERTIES"]["MAP"]["VALUE"]?>], {
                        // Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства.
                        balloonContentHeader: "<div class='balun_header'><?=$arItem["NAME"]?></div>",
                        balloonContentBody: "<div class='balun_text'><?=$arItem["PROPERTIES"]["ADRESS"]["VALUE"]?></div>"
                        //balloonContentFooter: "Подвал",
                        //hintContent: "Хинт метки"
                    });
                    myMap.geoObjects.add(myPlacemark);
                }
            </script>




            <?
            if (!empty($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) {
                if (count($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) > 4) {
                    ?>
                    <div class="flexslider_map">
                        <ul class="slides">
                            <? foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $k => $photo) {
                                $arFile = CFile::GetFileArray($photo);
                                $file = CFile::ResizeImageGet($photo, array('width' => 125, 'height' => 95), BX_RESIZE_IMAGE_EXACT, true);
                                ?>
                                <li>
                                    <a class="fancybox" rel="map<?= $arItem["ID"] ?>" href="<?= $arFile["SRC"] ?>"
                                       title="<?= $arItem["NAME"] ?>">
                                        <img src="<?= $file["src"] ?>" alt="<?= $arItem["NAME"] ?>"
                                             title="<?= $arItem["NAME"] ?>"/>
                                    </a>
                                </li>
                                <?
                            } ?>
                        </ul>
                    </div>
                    <?
                } else {
                    ?>
                    <ul>
                        <? foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $k => $photo) {
                            $arFile = CFile::GetFileArray($photo);
                            $file = CFile::ResizeImageGet($photo, array('width' => 125, 'height' => 95), BX_RESIZE_IMAGE_EXACT, true);
                            ?>
                            <li>
                                <a class="fancybox" rel="map<?= $arItem["ID"] ?>" href="<?= $arFile["SRC"] ?>"
                                   title="<?= $arItem["NAME"] ?>">
                                    <img src="<?= $file["src"] ?>" alt="<?= $arItem["NAME"] ?>"
                                         title="<?= $arItem["NAME"] ?>"/>
                                </a>
                            </li>
                            <?
                        } ?>
                        <li class="clear"></li>
                    </ul>
                    <?
                }
            }
            ?>
            <div id="map<?= $arItem["ID"] ?>" class="map"></div>

        </div>
        <?
        $out[$arItem['IBLOCK_SECTION_ID']][] = ob_get_contents();
        ob_end_clean();
        ?>
    <? endforeach; ?>
<?ksort($out);?>
<?foreach($out as $key => $val):?>
    <?if ($key == 27):?>
        <div class="cat1">
    <?endif;?>
    <?if ($key == 28):?>
        <div class="cat2 hidden">
    <?endif;?>
    <?if ($key == 1440):?>
        <div class="cat3 hidden">
    <?endif;?>
        <?foreach($val as $val1):?>
            <div class="shop_list">
                    <?=$val1?>
                <div class="clear"></div>
            </div>
        <?endforeach;?>
    </div>
<?endforeach;?>
<?// echo '<pre>' . print_r($out, true) . '</pre>';?>