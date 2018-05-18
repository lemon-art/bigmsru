<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);

if ( $arResult['SECTIONS'][0]["IBLOCK_ID"] == 10 ){
	$blockText = "Инженерная сантехника ";
}
else {
	$blockText = "Бытовая сантехника ";
}

$APPLICATION->SetTitle($blockText . $arResult['BRAND_NAME']);
$APPLICATION->SetPageProperty("title", $blockText . $arResult['BRAND_NAME'] . ' - каталог, цены в магазине "Большой Мастер" в Москве');
$APPLICATION->SetPageProperty("description", $blockText . 'от официального поставщика бренда '.$arResult['BRAND_NAME'] . ' с гарантией качества. Доставка в любой регион России!');
$APPLICATION->AddChainItem( $arResult['BRAND_NAME'] );
?>

<?if (0 < $arResult["SECTIONS_COUNT"]):?>



<?
//открываем файл с массивом соответствия адресов страниц
$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt");
$arUrlData = unserialize( $data );
?>

<ul class="content-producer__products brand-products">
	<?foreach ($arResult['SECTIONS'] as &$arSection):?>

		<?if ( $arSection["IBLOCK_ID"]  == 10 ):?>
			<?$arSection["IBLOCK_CODE"] = 'inzhenernaya';?>
		<?endif;?>
		<?if ( !$arSection['PDF'] ):?>
			<?$arSection['SECTION_PAGE_URL'] = "/catalog/".$arSection["IBLOCK_CODE"]."/".$arSection["CODE"].'/filter/brend-is-'.$arParams['BRAND_XML'].'/apply/';?>
		<?endif;?>
		<?
//			if ( $arUrlData[$arSection['SECTION_PAGE_URL']] ){
//				$arSection['SECTION_PAGE_URL'] = $arUrlData[$arSection['SECTION_PAGE_URL']]; //если есть короткий url то берем его
//			}
		?>
		
		<li class="brand-products__item">
            <div class="brand-products__img-wrap">
                <a <?if ( $arSection['PDF'] ):?>target="_blank"<?endif;?> href="<? echo $arSection['SECTION_PAGE_URL']; ?>"><img class="brand-products__img" src="<? echo $arSection['PICTURE']; ?>" alt="<? echo $arSection['NAME']; ?> <?=$arResult['BRAND_NAME']?>"></a>
            </div>
            <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>" <?if ( $arSection['PDF'] ):?>target="_blank"<?endif;?> class="brand-products__name"><? echo $arSection['NAME']; ?> <?if ( !$arSection['PDF'] ):?> <?=$arResult['BRAND_NAME']?><?endif;?></a>
        </li>
	
	<?endforeach;?>

</ul>


<?endif;?>