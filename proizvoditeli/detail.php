<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

CModule::IncludeModule("highloadblock");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$hlblock_id = 2;
///////////////////////////////////////////////

$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$entity_data_class = $entity->getDataClass();
$entity_table_name = $hlblock['TABLE_NAME'];
				
if ( $_GET["ELEMENT_CODE"] ){

	$arFilter = array('UF_NAME' => $_GET["ELEMENT_CODE"] ); //задаете фильтр по вашим полям

	$sTableID = 'tbl_'.$entity_table_name;
	$rsData = $entity_data_class::getList(array(
		"select" => array('UF_XML_ID', 'UF_NAME', 'UF_FILE', 'UF_DESCRIPTION'), //выбираем поля
		"filter" => $arFilter,
		"order" => array("UF_NAME"=>"ASC")
	));
	$rsData = new CDBResult($rsData, $sTableID);
	if ( $arRes = $rsData->Fetch() ){

		$APPLICATION->SetTitle("Бытовая сантехника ".$arRes["UF_NAME"]);
		$APPLICATION->SetPageProperty("title", 'Бытовая сантехника '.$arRes["UF_NAME"] . ' - каталог, цены в магазине "Большой Мастер" в Москве');
		$APPLICATION->SetPageProperty("description", 'Бытовая сантехника от официального поставщика бренда '.$arRes["UF_NAME"] . ' с гарантией качества. Доставка в любой регион России!');
		$APPLICATION->AddChainItem( $arRes["UF_NAME"] );
	}
}
if (  $arRes["UF_FILE"] ){
	$file = CFile::ResizeImageGet($arRes["UF_FILE"], array('width'=>148, 'height'=>61), BX_RESIZE_IMAGE_EXACT, true);
}					

?>

			<h1 class="title-h1"><?=$arRes["UF_NAME"]?></h1>
              <div class="content-producer">
                <div class="content-producer__description">

                  <?if ( $arRes["UF_DESCRIPTION"] ):?>
						<?if ( $file['src'] ):?>
							<img class="content-producer__logo" src="<?=$file['src']?>" alt="<?=$arRes["UF_NAME"]?>">
						<?endif;?>
						<p class="content-producer__text">
							<?=$arRes["UF_DESCRIPTION"]?>
						</p>
					<?endif;?>
                </div>
				<?$APPLICATION->IncludeComponent(
					"custom:brand.section.list",
					"",
					Array(
						"ADD_SECTIONS_CHAIN" => "N",
						"BRAND_NAME" => $arRes["UF_NAME"],
						"BRAND_XML" => $arRes["UF_XML_ID"],
						"CACHE_GROUPS" => "Y",
						"CACHE_TIME" => "36000000",
						"CACHE_TYPE" => "A",
						"COUNT_ELEMENTS" => "N",
						"IBLOCK_ID" => 10,
						"IBLOCK_TYPE" => "catalog",
						"SECTION_CODE" => "",
						"SECTION_FIELDS" => array("", ""),
						"SECTION_ID" => "",
						"SECTION_URL" => "",
						"SECTION_USER_FIELDS" => array("", ""),
						"SHOW_PARENT_NAME" => "Y",
						"TOP_DEPTH" => "2",
						"VIEW_MODE" => "LINE"
					)
				);?>
				
              
              </div>
			  
			  
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>			  