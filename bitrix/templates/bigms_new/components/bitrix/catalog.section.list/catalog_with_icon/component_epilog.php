<?
		//открываем файл с массивом соответствия адресов страниц
		$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt");
		$arUrlData = unserialize( $data );

		$curPage = $APPLICATION->GetCurPage(false);
		
		if ( !array_search($curPage, $arUrlData) &&  substr_count($curPage, 'apply') == 0 && !$_GET["set_filter"]){
			$APPLICATION->AddViewContent('seotext', $arResult["SECTION"]["DESCRIPTION"]);
		}
		
