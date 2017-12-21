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

    <div class="owl-carousel main-slider__container">


		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
				<?=$arItem["PREVIEW_TEXT"];?>
					
		

		<?endforeach;?>

	</div>
<?/*
	<ul class="slider-nav">
		<?foreach($arResult["ITEMS"] as $key => $arItem):?>
			<li class="slider-nav__item <?if ( $key == 0 ):?>active<?endif;?>">
				<span class="slider-nav__text-wrap"><?=$arItem["NAME"]?></span>
			</li>
		<?endforeach;?>
    </ul>
*/?>