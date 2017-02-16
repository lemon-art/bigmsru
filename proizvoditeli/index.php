<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Производители. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "Производители - Большой мастер");
$APPLICATION->SetTitle("Производители");
?>

	<h1><?$APPLICATION->ShowTitle(false)?></h1>

	<div class="tabs brends_all_block">
		<div class="title_block">
			<div class="select_block">
				<?/*
			<select class="select" name="tabs" onchange="run_tabs(this.value);">
				<option value="brend_cat1">Инженерная сантехника</option>
				<option value="brend_cat2">Бытовая сантехника</option>
			</select>
			*/?>
				<div class="selectesem">
					<div onclick="run_tabs_ss(this.getAttribute('data-val'))" data-val="brend_cat1" class="item active">Инженерная сантехника</div>
					<div onclick="run_tabs_ss(this.getAttribute('data-val'))" data-val="brend_cat2" class="item">Бытовая сантехника</div>
				</div>
			</div>
		</div>


		<div class="tab_content" id="brend_cat1">
			<ul>
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
					"order" => array()
				));
				$rsData = new CDBResult($rsData, $sTableID);
				$arIds = array();
				$arAllBrand = array();
				while($arRes = $rsData->Fetch()){
					$arIds[] = $arRes['UF_XML_ID'];
					$arAllBrand[$arRes['UF_XML_ID']] = $arRes;
				}

				$arBrand1 = array();
				$arBrand2 = array();
				$arSelect = Array("ID", "NAME", "PROPERTY_BREND");
				$arFilter2 = Array("IBLOCK_ID"=>10, "ACTIVE"=>"Y", "PROPERTY_BREND"=>$arIds);
				$res = CIBlockElement::GetList(array(), $arFilter2, array('PROPERTY_BREND'), false, $arSelect);
				while($ar_fields = $res->GetNext()) {
					if ($arAllBrand[$ar_fields['PROPERTY_BREND_VALUE']]['UF_FILE']){
						$arBrand1[] = $arAllBrand[$ar_fields['PROPERTY_BREND_VALUE']];
					} else {
						$arBrand2[] = $arAllBrand[$ar_fields['PROPERTY_BREND_VALUE']];
					}
				}

				$arBrand = array_merge($arBrand1, $arBrand2);
				foreach ($arBrand as $brand){
					$file = CFile::ResizeImageGet($brand["UF_FILE"], array('width'=>148, 'height'=>61), BX_RESIZE_IMAGE_EXACT, true);
					?>
					<li class="item">
						<a class="logo" href="/proizvoditeli/inzhenernaya/<?=$brand["UF_NAME"]?>" style="background-image:url(<?=$file["src"]?>);"></a>
						<div class="title"><a href="/proizvoditeli/inzhenernaya/<?=$brand["UF_NAME"]?>"><?echo $brand["UF_NAME"]?></a></div>
					</li>
					<?
				}
				?>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="tab_content hidden" id="brend_cat2">
			<ul>
				<script>
					$(document).ready(function () {
						$.ajax({
							type: "POST",
							url: "/proizvoditeli/ajax_index.php",
							data: "",
							success: function(data){
								$('#brend_cat2 ul').html(data);
							}
						});
					});
				</script>
			</ul>
			<div class="clear"></div>
		</div>
	</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>