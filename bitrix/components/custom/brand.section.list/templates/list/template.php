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

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'LIST' => array(
		'CONT' => 'bx_sitemap',
		'TITLE' => 'bx_sitemap_title',
		'LIST' => 'bx_sitemap_ul',
	),
	'LINE' => array(
		'CONT' => 'bx_catalog_line',
		'TITLE' => 'bx_catalog_line_category_title',
		'LIST' => 'bx_catalog_line_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/line-empty.png'
	),
	'TEXT' => array(
		'CONT' => 'bx_catalog_text',
		'TITLE' => 'bx_catalog_text_category_title',
		'LIST' => 'bx_catalog_text_ul'
	),
	'TILE' => array(
		'CONT' => 'bx_catalog_tile',
		'TITLE' => 'bx_catalog_tile_category_title',
		'LIST' => 'bx_catalog_tile_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?><?

if (0 < $arResult["SECTIONS_COUNT"])
{
?>
<?
//открываем файл с массивом соответствия адресов страниц
$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt");
$arUrlData = unserialize( $data );

$count = 0;
?>
		<li class="producers-row__item producers-item">
			<div class="producers-item__header">
				<a href="/proizvoditeli/<?=$arParams["BRAND_NAME"]?>/" class="producers-item__name"><?=$arParams["BRAND_NAME"]?></a>

				<span class="product-card__country producers-item__country">
				<span class="product-card__flag-icon country c<?=$arResult["COUNTRY_ID"]?>"></span>
					<?=$arResult["COUNTRY_NAME"]?>
				</span>
				
			</div>
			<div class="producers-item__content">
				<div class="producers-item__img-wrap">
					<?if ( $arParams["UF_FILE"] ):?>
						<?$file = CFile::ResizeImageGet($arParams["UF_FILE"], array('width'=>148, 'height'=>61), BX_RESIZE_IMAGE_EXACT, true);?>
						<a href="/proizvoditeli/<?=$arParams["BRAND_NAME"]?>/"><img src="<?=$file['src']?>" alt="" class="producers-item__image"></a>
					<?endif;?>
				</div>
				<div class="producers-item__categories">
					<?foreach ($arResult['SECTIONS'] as &$arSection):?>
						
						<?if ( $count++ < 5 ):?>
							<?if ( $arSection["IBLOCK_ID"]  == 10 ):?>
								<?$arSection["IBLOCK_CODE"] = 'inzhenernaya';?>
							<?endif;?>
							
							<?$arSection['SECTION_PAGE_URL'] = "/catalog/".$arSection["IBLOCK_CODE"]."/".$arSection["CODE"].'/filter/brend-is-'.$arParams['BRAND_XML'].'/apply/';?>
							<?
								if ( $arUrlData[$arSection['SECTION_PAGE_URL']] ){
									$arSection['SECTION_PAGE_URL'] = $arUrlData[$arSection['SECTION_PAGE_URL']]; //если есть короткий url то берем его
								}
							?>
							<a href="<? echo $arSection['SECTION_PAGE_URL']; ?>" class="producers-item__link"><? echo $arSection['NAME']; ?></a>
						
						<?else:?>
							<a href="/proizvoditeli/<?=$arParams["BRAND_NAME"]?>/" class="button producers-item__more">Еще</a>
							<?break;?>
						<?endif;?>
					
					<?endforeach;?>

				</div>
			</div>
		</li>

<?
}
?>