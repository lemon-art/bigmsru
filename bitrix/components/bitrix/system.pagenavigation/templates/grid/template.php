<?
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$currentPageNumber = $arResult["nStartPage"];
$nextPageNumber = ($arResult["NavPageNomer"] + 1);
$prevPageNumber = ($arResult["NavPageNomer"] - 1);
?>

<div class="main-ui-pagination">
	<div class="main-ui-pagination-pages">
		<div class="main-ui-pagination-label"><?=Loc::getMessage("MAIN_UI_PAGINATION__PAGES")?>:</div>
		<div class="main-ui-pagination-pages-list">
			<? while ($currentPageNumber >= $arResult["nStartPage"] && $currentPageNumber <= $arResult["nEndPage"]) : ?>
				<? if ($currentPageNumber === (int)$arResult["NavPageNomer"]) : ?>
					<span class="main-ui-pagination-page main-ui-pagination-active"><?=$currentPageNumber?></span>
				<? else : ?>
					<? $url = implode("", array($arResult["sUrlPathParams"], "PAGEN_", $arResult["NavNum"], "=", $currentPageNumber)); ?>
					<a href="<?=$url?>" class="main-ui-pagination-page"><?=$currentPageNumber?></a>
				<? endif; ?>
				<? $currentPageNumber++; ?>
			<? endwhile; ?>
		</div>
	</div>
	<? if ((int)$arResult["nStartPage"] !== (int)$arResult["nEndPage"]) : ?>
		<div class="main-ui-pagination-arrows">
			<? if ($prevPageNumber >= $arResult["nStartPage"]) : ?>
				<? $url = implode("", array($arResult["sUrlPathParams"], "PAGEN_", $arResult["NavNum"], "=", $prevPageNumber)); ?>
				<a href="<?=$url?>" class="main-ui-pagination-arrow main-ui-pagination-prev"><?=Loc::getMessage("MAIN_UI_PAGINATION__PREV")?></a>
			<? else : ?>
				<span class="main-ui-pagination-arrow main-ui-pagination-prev"><?=Loc::getMessage("MAIN_UI_PAGINATION__PREV")?></span>
			<? endif; ?>

			<? if ($nextPageNumber <= $arResult["nEndPage"]) : ?>
				<? $url = implode("", array($arResult["sUrlPathParams"], "PAGEN_", $arResult["NavNum"], "=", $nextPageNumber)); ?>
				<a href="<?=$url?>" class="main-ui-pagination-arrow main-ui-pagination-next"><?=Loc::getMessage("MAIN_UI_PAGINATION__NEXT")?></a>
			<? else : ?>
				<span class="main-ui-pagination-arrow main-ui-pagination-next"><?=Loc::getMessage("MAIN_UI_PAGINATION__NEXT")?></span>
			<? endif; ?>
		</div>
	<? endif; ?>
</div>
