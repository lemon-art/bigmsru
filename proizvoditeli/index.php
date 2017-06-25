<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Производители. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "Производители - Большой мастер");
$APPLICATION->SetTitle("Производители");

//Устанавливаем нужные классы для header
/*
$this->SetViewTarget("content__wrap");
echo "content__wrap_producers";
$this->EndViewTarget("content__wrap");

$this->SetViewTarget("row_div_class");
echo "col-lg-30 col-md-30 col-sm-30 content__container content__container_producers";
$this->EndViewTarget("row_div_class");
*/
$arNames = Array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"); 


?>

	<h1><?$APPLICATION->ShowTitle(false)?></h1>
			
			
			<div class="content-producers">
				<div class="content-producers__filter producers-filter">
                  <ul class="producers-filter__list">
                    <li class="producers-filter__item" data-name="0">Все</li>
                    <li class="producers-filter__item" data-name="0-9">0-9</li>
                    <?foreach ( $arNames as $bName ):?>
						<li class="producers-filter__item" data-name="<?=$bName?>"><?=$bName?></li>
					<?endforeach;?>
                    <li class="producers-filter__item" data-name="А-Я">А-Я</li>
                  </ul>
                </div>
	
				<?
				////////////////////////////////////////////////
				CModule::IncludeModule("highloadblock");

				use Bitrix\Highloadblock as HL;
				use Bitrix\Main\Entity;

				$hlblock_id = 2;
				///////////////////////////////////////////////

				$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
				$entity = HL\HighloadBlockTable::compileEntity($hlblock);

				$entity_data_class = $entity->getDataClass();
				$entity_table_name = $hlblock['TABLE_NAME'];

				$arFilter = array(); //задаете фильтр по вашим полям

				$sTableID = 'tbl_'.$entity_table_name;
				$rsData = $entity_data_class::getList(array(
					"select" => array('UF_XML_ID', 'UF_NAME', 'UF_FILE'), //выбираем поля
					"filter" => $arFilter,
					"order" => array("UF_NAME")
				));
				$rsData = new CDBResult($rsData, $sTableID);
				$arIds = array();
				$arAllBrand = array();
				while($arRes = $rsData->Fetch()){
					$arIds[] = $arRes['UF_XML_ID'];
					$arAllBrand[$arRes['UF_XML_ID']] = $arRes;
				}

				$arBrandsNames = Array();
				foreach ( $arAllBrand as $arBrand ){
					
					preg_match_all( '/[а-яё]/ui', $arBrand["UF_NAME"], $matches);
					if ( count($matches[0]) > 0 ){
						$arBrandsNames['rus'][] = $arBrand;
					}
					else {
						$arBrandsNames[mb_substr($arBrand["UF_NAME"], 0, 1)][] = $arBrand;
					}
					
				}
				?>
				
				<?foreach ( $arNames as $bName ):?>
				
					<?if ( count( $arBrandsNames[$bName] ) > 0 ):?>
						<div class="content-producers__row producers-row" data-header="<?=$bName?>">
							<ul class="producers-row__list">
								
								<?foreach ( $arBrandsNames[$bName] as $arBrand ):?>
									
									
										<?$APPLICATION->IncludeComponent(
											"custom:brand.section.list",
											"list",
											Array(
												"ADD_SECTIONS_CHAIN" => "N",
												"BRAND_NAME" => $arBrand["UF_NAME"],
												"BRAND_XML" => $arBrand["UF_XML_ID"],
												"UF_FILE" => $arBrand["UF_FILE"],
												"CACHE_GROUPS" => "Y",
												"CACHE_TIME" => "36000000",
												"CACHE_TYPE" => "A",
												"COUNT_ELEMENTS" => "N",
												"IBLOCK_ID" => 12,
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
										

									  
								
								<?endforeach;?>
								
							</ul>
						</div>		

					<?endif;?>
					
				<?endforeach;?>
				
						<div class="content-producers__row producers-row" data-header="А-Я">
							<ul class="producers-row__list">
								
								<?foreach ( $arBrandsNames['rus'] as $arBrand ):?>
									

									
										<?$APPLICATION->IncludeComponent(
											"custom:brand.section.list",
											"list",
											Array(
												"ADD_SECTIONS_CHAIN" => "N",
												"BRAND_NAME" => $arBrand["UF_NAME"],
												"BRAND_XML" => $arBrand["UF_XML_ID"],
												"UF_FILE" => $arBrand["UF_FILE"],
												"CACHE_GROUPS" => "Y",
												"CACHE_TIME" => "36000000",
												"CACHE_TYPE" => "A",
												"COUNT_ELEMENTS" => "N",
												"IBLOCK_ID" => Array(10, 12),
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
										

									 
								
								<?endforeach;?>
								
							</ul>
						</div>	
	

			</div>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>