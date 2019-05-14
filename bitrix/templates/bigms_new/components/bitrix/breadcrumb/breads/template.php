<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';



$strReturn .= '<ul class="breadcrumbs content__breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">';

$brItem = [];

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	$nextRef = ($index < $itemSize-2 && $arResult[$index+1]["LINK"] <> ""? ' itemref="bx_breadcrumb_'.($index+1).'"' : '');
	$child = ($index > 0? ' itemprop="child"' : '');
	$arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');

	//ищем повторяющиеся крошки
	$drow = true;
	foreach($brItem as $item) {
		if ($item == $title) {
			$drow = false;
		}
	}
	array_push($brItem, $title);


	if ($drow == true) {
		
			$strReturn .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumbs__item"><a itemscope itemtype="http://schema.org/Thing" itemprop="item"class="breadcrumbs__link" href="'.$arResult[$index]["LINK"].'"><span itemprop="name">'.$title.'<span></a> <meta itemprop="position" content="'.($index+1).'" /></li>';
		
	}
}

$strReturn .= '</ul>';

return $strReturn;
