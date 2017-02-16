<?php
define("NO_KEEP_STATISTIC", true);// Не собираем стату по действиям AJAX
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");

?>
<div class="title_block">
	<ul class="tabNavigation">
		<li><a data-name="cat1" class="" href="#brend_cat1">Производители</a></li>
		<li><a data-name="cat2" class="hidden" href="#brend_cat2"></a></li>
	</ul>
	
	<div class="selectesem">
		<div class="item item-brand-1 active" data-val="cat1" onclick="catalog_active_ss(this.getAttribute('data-val'), 'brend', 'item-brand-1')">Инженерная сантехника</div>
		<div class="item item-brand-2" data-val="cat2" onclick="catalog_active_ss(this.getAttribute('data-val'), 'brend', 'item-brand-2')">Бытовая сантехника</div>
	</div>		
	
	
	<a data-name="cat1" href="/proizvoditeli/inzhenernaya/" class="link tab1"><span>все предложения</span></a>
	<a data-name="cat2" href="/proizvoditeli/bytovaya/" class="link hidden tab2"><span>все предложения</span></a>
	
</div>				
	
	<div class="flexslider tab_content" id="brend_cat1">
		<ul class="carusel slides">
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
			while($arRes = $rsData->Fetch()){
				$arSelect = Array("ID", "NAME", "PROPERTY_BREND");
				$arFilter2 = Array("IBLOCK_ID"=>10, "ACTIVE"=>"Y", "PROPERTY_BREND"=>$arRes["UF_XML_ID"]);
				$res = CIBlockElement::GetList(array(), $arFilter2, false, array("nPageSize"=>1), $arSelect);
				while($ar_fields = $res->GetNext())
				{
				?>
					<?
					$file = CFile::ResizeImageGet($arRes["UF_FILE"], array('width'=>148, 'height'=>61), BX_RESIZE_IMAGE_EXACT, true);
					$name = mb_strtolower(str_replace(" ", "_", $arRes['UF_NAME']));
					?>

					<li class="item">
						<a class="logo" href="/proizvoditeli/inzhenernaya/<?=$name?>/" style="background-image:url(<?=$file["src"]?>);"></a>
						<div class="title"><?echo $arRes["UF_NAME"]?></div>
					</li>
				<?
				}
			}
			////////////////////////////////////////////////
			?>
		</ul>
	</div>
	<div class="flexslider tab_content" id="brend_cat2">
		<ul class="carusel slides">
			<?
			////////////////////////////////////////////////
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
			while($arRes = $rsData->Fetch()){
				$arSelect = Array("ID", "NAME", "PROPERTY_BREND");
				$arFilter2 = Array("IBLOCK_ID"=>12, "ACTIVE"=>"Y", "PROPERTY_BREND"=>$arRes["UF_XML_ID"]);
				$res = CIBlockElement::GetList(array(), $arFilter2, false, array("nPageSize"=>1), $arSelect);
				while($ar_fields = $res->GetNext())
				{
				?>
					<?
					$file = CFile::ResizeImageGet($arRes["UF_FILE"], array('width'=>148, 'height'=>61), BX_RESIZE_IMAGE_EXACT, true);
					$name = mb_strtolower(str_replace(" ", "_", $arRes['UF_NAME']));
					?>

					<li class="item">
						<a class="logo" href="/proizvoditeli/bytovaya/<?=$name?>/" style="background-image:url(<?=$file["src"]?>);"></a>
						<div class="title"><?echo $arRes["UF_NAME"]?></div>
					</li>
				<?
				}
			}
			////////////////////////////////////////////////
			?>
		</ul>
	</div>