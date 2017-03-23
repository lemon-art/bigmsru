<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/tools/class/sitemap.php");
CModule::IncludeModule("iblock");

$map = new CSitemap;

$siteName = 'http://www.bigms.ru';

$count = 0;

	//открываем файл с настройками
	$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/sitemap_settings.txt");
	$arSetting = unserialize( $data );
	$arPrior = explode(PHP_EOL, trim($arSetting[priority]));
	$arPriority = Array();
	foreach ( $arPrior as $val ){
		$arPriority[] = trim($val);
	}
	


	$arUrls = $map -> GetTree($_SERVER["DOCUMENT_ROOT"]."/", 10); //получаем страницы из структуры сайта
	$arUrls[] = '/catalog/';
	$arUrls[] = '/catalog/bytovaya/';
	$arUrls[] = '/catalog/inzhenernaya/';
	


	foreach ($arUrls as $arUrl){
		$url = $siteName.$arUrl;
		if ( $map -> CheckPage( $url ) ){						//проверяем страницу
			$lastUpdate = $map -> GetLastUpdate( $url );		//получаем дату изменения
			$changefreq = $arSetting[changefreq][0];
			if ( in_array( $url, $arPriority ) ){
				$priority = 1;
			}
			else {
				$priority = 0.5;
			}
			$xml_data = $map -> sitemap_url_gen($url, $lastUpdate, $changefreq, $priority);
			$parm = $map -> sitemap_file_save($xml_data, $parm);
			$count++;
		}
	}

	//$url = $_SERVER['PHP_SELF'].'?step=2';        
	//header("Location: $url");


	$arUrls = $map ->GetBrandsUrl();

	foreach ($arUrls as $arUrl){
		$url = $siteName.$arUrl;
		//if ( $map -> CheckPage( $url ) ){	//проверяем страницу
			//$lastUpdate = $map -> GetLastUpdate( $url );		//получаем дату изменения
			$lastUpdate = '';
			$changefreq = $arSetting[changefreq][1];
			if ( in_array( $url, $arPriority ) ){
				$priority = 1;
			}
			else {
				$priority = 0.5;
			}
			$xml_data = $map -> sitemap_url_gen($url, $lastUpdate, $changefreq, $priority);
			$parm = $map -> sitemap_file_save($xml_data, $parm);
			$count++;
		//}
	}


	//разделы
	$arSectionUrls = Array();

	$arUrls = $map -> GetSectionsUrl( 12 );
	
	
	foreach ($arUrls as $arUrl){
		$url = $siteName.$arUrl['URL'];
		$lastUpdate = $arUrl['DATE'];						//получаем дату изменения
		$changefreq = $arSetting[changefreq][2];
		if ( in_array( $url, $arPriority ) ){
			$priority = 1;
		}
		else {
			$priority = 0.5;
		}
		$xml_data = $map -> sitemap_url_gen($url, $lastUpdate, $changefreq, $priority);
		$parm = $map -> sitemap_file_save($xml_data, $parm);
		$count++;
		$arSectionUrls[] = $arUrl['URL'];
	}
	
	$arUrls = $map -> GetSectionsUrl( 10 );

	
	foreach ($arUrls as $arUrl){
		$url = $siteName.$arUrl['URL'];
		$lastUpdate = $arUrl['DATE']; 						//получаем дату изменения
		$changefreq = $arSetting[changefreq][2];
		if ( in_array( $url, $arPriority ) ){
			$priority = 1;
		}
		else {
			$priority = 0.5;
		}
		$xml_data = $map -> sitemap_url_gen($url, $lastUpdate, $changefreq, $priority);
		$parm = $map -> sitemap_file_save($xml_data, $parm);
		$count++;
		$arSectionUrls[] = $arUrl['URL'];
	}
	

	
	//элементы
	$arUrls = $map -> GetElementsUrl( 12 );
	
	foreach ($arUrls as $arUrl){
		$url = $siteName.$arUrl['URL'];
		$lastUpdate = $arUrl['DATE'];						//получаем дату изменения
		$changefreq = $arSetting[changefreq][3];
			if ( in_array( $url, $arPriority ) ){
				$priority = 1;
			}
			else {
				$priority = 0.5;
			}
		$xml_data = $map -> sitemap_url_gen($url, $lastUpdate, $changefreq, $priority);
		$parm = $map -> sitemap_file_save($xml_data, $parm);
		$count++;
	}
	
	$arUrls = $map -> GetElementsUrl( 10 );
	
	foreach ($arUrls as $arUrl){
		$url = $siteName.$arUrl['URL'];
		$lastUpdate = $arUrl['DATE'];						//получаем дату изменения
		$changefreq = $arSetting[changefreq][3];
		$xml_data = $map -> sitemap_url_gen($url, $lastUpdate, $changefreq, $priority);
		$parm = $map -> sitemap_file_save($xml_data, $parm);
		$count++;
	}
	
	
	$arUrls = $map -> GetFilterUrl( $arSectionUrls );
	foreach ($arUrls as $arUrl){
		$url = $siteName.$arUrl['URL'];
		$lastUpdate = $arUrl['DATE'];
		$changefreq = $arSetting[changefreq][2];
			if ( in_array( $url, $arPriority ) ){
				$priority = 1;
			}
			else {
				$priority = 0.5;
			}
		$xml_data = $map -> sitemap_url_gen($url, $lastUpdate, $changefreq, $priority);
		$parm = $map -> sitemap_file_save($xml_data, $parm);
		$count++;
	}
	
	$parm['end'] = 1;
	$xml_data = '';
	$parm = $map -> sitemap_file_save($xml_data, $parm);

	$arData = Array(
		'date'	 => date("d.m.Y G:i"),
		'count'  => $count
	);
	
	//сохраняем логи
	$fd = fopen($_SERVER["DOCUMENT_ROOT"]."/tools/logs/sitemap.txt", 'w') or die("не удалось создать файл");
	fwrite($fd, serialize($arData) );
	fclose($fd);
	
	
?>