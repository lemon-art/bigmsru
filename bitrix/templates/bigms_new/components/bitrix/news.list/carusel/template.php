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
?>

<ul class="carusel slides">

	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		
		<?
		if($arItem["USE"] == "Y"){
			$file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]["ID"], array('width'=>148, 'height'=>61), BX_RESIZE_IMAGE_EXACT, true);?>		
			
			<li class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<a class="logo" href="<?=$arItem["DETAIL_PAGE_URL"]?>" style="background-image:url(<?=$file["src"]?>);"></a>
				<div class="title"><?echo $arItem["NAME"]?></div>
			</li>
		<?
		}
		?>
	<?endforeach;?>
	
</ul>