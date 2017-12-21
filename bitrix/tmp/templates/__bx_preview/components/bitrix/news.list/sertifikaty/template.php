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

<div class="sertifikaty_list">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		
		<?
		$renderImage = CFile::ResizeImageGet(
			$arItem['PREVIEW_PICTURE']['ID'], 
			Array("width" => 190, "height" => 200), 
			BX_RESIZE_IMAGE_PROPORTIONAL_ALT, 
			true
		);
		?>	
		<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<a class="fancybox" rel="sertifikaty" href="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" style="background-image: url(<?=$renderImage["src"]?>);"></a>
			<div class="title"><?=$arItem["NAME"]?></div>
		</div>
	<?endforeach;?>
	<div class="clear"></div>
</div>
	
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>