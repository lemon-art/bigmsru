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
<div class="articles_list">

	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>

		<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="img">
				<?
				if(!empty($arItem["PREVIEW_PICTURE"]["SRC"])){
					$renderImage = CFile::ResizeImageGet(
						$arItem['PREVIEW_PICTURE']['ID'], 
						Array("width" => 232, "height" => 158), 
						BX_RESIZE_IMAGE_EXACT, 
						true
					);
					?><img src="<?=$renderImage["src"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" /><?
				}
				?>
			</a>

			<div class="text_block">
				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="title"><?echo $arItem["NAME"]?></a>
				<div><?echo $arItem["PREVIEW_TEXT"];?></div>
			</div>
			
			<div style="clear:both"></div>
		</div>
	<?endforeach;?>
	
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
	
</div>