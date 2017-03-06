<?
		//открываем файл с массивом соответствия адресов страниц
		$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt");
		$arUrlData = unserialize( $data );

		$curPage = $APPLICATION->GetCurPage(false);

		if ( !array_search($curPage, $arUrlData) ){
			$APPLICATION->AddViewContent('seotext', $arResult["SECTION"]["DESCRIPTION"]);
		}