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

?><div class="catalog_with_icon"><?

if (0 < $arResult["SECTIONS_COUNT"])
{
?>
<?
//открываем файл с массивом соответствия адресов страниц
$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt");
$arUrlData = unserialize( $data );
?>

<ul class="list">
	<?foreach ($arResult['SECTIONS'] as &$arSection):?>

		<?if ( $arSection["IBLOCK_ID"]  == 10 ):?>
			<?$arSection["IBLOCK_CODE"] = 'inzhenernaya';?>
		<?endif;?>
		
		<?$arSection['SECTION_PAGE_URL'] = "/catalog/".$arSection["IBLOCK_CODE"]."/".$arSection["CODE"].'/filter/brend-is-'.$arParams['BRAND_XML'].'/apply/';?>
		<?
			if ( $arUrlData[$arSection['SECTION_PAGE_URL']] ){
				$arSection['SECTION_PAGE_URL'] = $arUrlData[$arSection['SECTION_PAGE_URL']]; //если есть короткий url то берем его
			}
		?>
		<li class="item ">
			<a href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
				<div class="icon" style="background-image:url('<? echo $arSection['PICTURE']; ?>');"></div>
				<span><? echo $arSection['NAME']; ?> <?=$arResult['BRAND_NAME']?></span>
			</a>
			<div class="icon" style="background-image:url(/upload/iblock/a07/a07728551a10137406610025005ebdd6.jpg);"></div>
		</li>
	
	<?endforeach;?>

</ul>


<?
}
?></div>