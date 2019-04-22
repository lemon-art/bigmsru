<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
// Подключаем класс для работы с excel
require_once($_SERVER["DOCUMENT_ROOT"]."/tools/PHPExcel-1.8/Classes/PHPExcel.php");
CModule::IncludeModule("sale");
CModule::IncludeModule("currency");
CModule::IncludeModule("catalog");
$fuserId = CSaleBasket::GetBasketUserID();
unlink($_SERVER["DOCUMENT_ROOT"]."/local/tmp/bigms_basket_".$fuserId.".xlsx");
$arBasketItems = array();

$dbBasketItems = CSaleBasket::GetList(
        array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
        array(
                "FUSER_ID" => $fuserId,
				"DELAY" => "N",
                "ORDER_ID" => $_POST['order']
            ),
        false,
        false,
		array(
             "ID", "NAME", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY",
             "PRICE", "WEIGHT", "DETAIL_PAGE_URL", "NOTES", "CURRENCY", "VAT_RATE", "CATALOG_XML_ID",
             "PRODUCT_XML_ID", "SUBSCRIBE", "DISCOUNT_PRICE", "PRODUCT_PROVIDER_CLASS", "TYPE", "SET_PARENT_ID"            
           )
    );
while ($arItems = $dbBasketItems->Fetch())
{
    $arBasketItems[] = $arItems;
}


 

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("BIGMS.RU")
							 ->setLastModifiedBy("BIGMS.RU")
							 ->setTitle("Прайс-лист Большой Мастер")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("Корзина пользователя")
							 ->setKeywords("office 2007 openxml ")
							 ->setCategory("ыыыыы");


$objPHPExcel->setActiveSheetIndex(0);
$active_sheet = $objPHPExcel->getActiveSheet();


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Корзина с сайта Bigms.ru');
$active_sheet->mergeCells('A1:E1');
$active_sheet->getStyle('A1')->getFill()->setFillType(
    PHPExcel_Style_Fill::FILL_SOLID);
$active_sheet->getStyle('A1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$active_sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');	
$active_sheet->mergeCells('A1:E1');

$active_sheet->getColumnDimension('A')->setWidth(7);
$active_sheet->getColumnDimension('B')->setWidth(80);
$active_sheet->getColumnDimension('C')->setWidth(20);
$active_sheet->getColumnDimension('D')->setWidth(20);							 
$active_sheet->getColumnDimension('E')->setWidth(20);

$active_sheet->getStyle('C2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$active_sheet->getStyle('D2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$active_sheet->getStyle('E2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							 
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2', '№')
            ->setCellValue('B2', 'Товар')
			->setCellValue('C2', 'Код товара')
			->setCellValue('D2', 'Артикул')
            ->setCellValue('E2', 'Цена (шт.)')
            ->setCellValue('F2', 'Количество')
            ->setCellValue('G2', 'Стоимость');

$allSumm = 0;
	
foreach ( $arBasketItems as $key => $arItem ){

	
	
	$allSumm += $arItem['PRICE']*$arItem['QUANTITY'];
	$price = CurrencyFormat($arItem['PRICE'], "RUB");
	$full_price = CurrencyFormat($arItem['PRICE']*$arItem['QUANTITY'], "RUB");
	$index = (string)($key + 3);
	$num = (string)($key + 1);
	
	
	
		$count = 0;
		$arFilter = Array(
			"IBLOCK_ID"=> 10, 
			"ID"	=> $arItem['PRODUCT_ID']
		);
		$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID", "PROPERTY_CML2_ARTICLE", "PROPERTY_CML2_TRAITS"));
		while( $ar_fields = $res->GetNext()) {
		
			$prodArticle = $ar_fields['PROPERTY_CML2_ARTICLE_VALUE'];
			$count++;
			
			if ( $count == 3 ) {
				$prodCode = $ar_fields['PROPERTY_CML2_TRAITS_VALUE'];
				
			}
		
		}
	
	
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$index, $num )	
            ->setCellValue('B'.$index, $arItem['NAME'])
			->setCellValue('C'.$index, $prodCode)
			->setCellValue('D'.$index, $prodArticle)
            ->setCellValue('E'.$index, $price)
            ->setCellValue('F'.$index, $arItem['QUANTITY'])
            ->setCellValue('G'.$index, $full_price);  
			
	$active_sheet->getStyle('C'.$index)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$active_sheet->getStyle('D'.$index)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$active_sheet->getStyle('E'.$index)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$active_sheet->getStyle('F'.$index)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$active_sheet->getStyle('G'.$index)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}

$index = (string)($key + 5);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F'.$index, 'Итого:')
            ->setCellValue('G'.$index, CurrencyFormat($allSumm, "RUB")); 

$active_sheet->getStyle('F'.$index)->getAlignment()->setHorizontal(
	PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$active_sheet->getStyle('G'.$index)->getAlignment()->setHorizontal(
	PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
$active_sheet->getStyle('F'.$index)->getFill()->setFillType(
    PHPExcel_Style_Fill::FILL_SOLID);
$active_sheet->getStyle('G'.$index)->getFill()->setFillType(
    PHPExcel_Style_Fill::FILL_SOLID);	
$active_sheet->getStyle('F'.$index)->getFill()->getStartColor()->setRGB('EEEEEE');
$active_sheet->getStyle('G'.$index)->getFill()->getStartColor()->setRGB('EEEEEE');
			
$objPHPExcel->getActiveSheet()->setTitle('Прайс-лист');



// Redirect output to a client’s web browser (Excel2007)
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="01simple.xlsx"');
//header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
//header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
//header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
//header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"]."/local/tmp/bigms_basket_".$fuserId.".xlsx");
exit;

?>