<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;
use Bitrix\Iblock;


foreach ( $arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'] as $key => $photo){

		$renderImage = CFile::ResizeImageGet(
			$photo['ID'],
			Array("width" => 500, "height" => 450),
			BX_RESIZE_IMAGE_EXACT,
			true
		);
		$arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'][$key]['src'] = $renderImage['src'];
}
?>