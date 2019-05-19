<?

use Bitrix\Sale;
use Bitrix\Sale\Location;
use Bitrix\Sale\Location\Admin\TypeHelper;



/*AddEventHandler("sale", "OnOrderSave", "OnOrderSaveHandler");
function OnOrderSaveHandler($ID, $arFields, $arOrder, $isNew){*/


require_once($_SERVER['DOCUMENT_ROOT'].'/local/classes/Bigms/Helpers/DeliveryHelper.php');

AddEventHandler("iblock", "OnBeforeIBlockSectionUpdate", Array("MyClass", "OnBeforeIBlockSectionUpdateHandler"));
class MyClass
{
	function OnBeforeIBlockSectionUpdateHandler(&$arFields)	{
		if ($arFields['MODIFIED_BY'] === 93 && $arFields['ACTIVE'] == 'N'){
			//return false;
		}
//		define( "LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt" );
//		AddMessage2Log(print_r($arFields, true));
		$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/log_section.txt', 'a+');
		fwrite($fp, date("d.m.y H:i:s"));
		fwrite($fp, print_r($arFields, true));
		fclose($fp);
	}
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterIBlockElementUpdateHandler");
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "OnAfterIBlockElementUpdateHandler");

function OnAfterIBlockElementUpdateHandler(&$arFields){
	
	//обновление информации о ЧПУ коротких ссылок
	if ( $arFields["IBLOCK_ID"] == 19 ) {
		if ( substr_count($arFields["NAME"], 'filter') ){
			$db_props = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], array("sort" => "asc"), Array("CODE"=>"URL"));
			if($ar_props = $db_props->Fetch()){ 		//если заполнено свойство короткого url
			
				if ( $ar_props["VALUE"] ){
					$shortUrl  = $ar_props["VALUE"]; 		//желаемый адрес
					$longUrl   = $arFields["NAME"];			//исходный адрес фильтра чпу
					$filterUrl =  GetFilterUrl($longUrl);	//адрес фильтра в формате get строки
					
					//открываем файл с массивом соответствия адресов страниц
					$fileSeoUrl = $_SERVER["DOCUMENT_ROOT"]."/tools/files/seo_url.txt";
					$data = file_get_contents( $fileSeoUrl );
					$arUrlData = unserialize( $data );
					
					//проверяем на дубли записей по значению
					$arUrlInFiles = array_keys( $arUrlData, $shortUrl);
					if ( count( $arUrlInFiles ) > 1 ){
						foreach( $arUrlInFiles as $keyIndex  ){
							unset( $arUrlData[$keyIndex] );
						}
					}
					
					$arUrlData[$longUrl] = $shortUrl;
					
					$fd = fopen($fileSeoUrl, 'w') or die("не удалось создать файл");
					fwrite($fd, serialize($arUrlData) );
					fclose($fd);
					
					//вносим изменения в urlrewrite
					$fileUrlReWrite = $_SERVER["DOCUMENT_ROOT"]."/urlrewrite.php";
					require( $fileUrlReWrite ); //подключаем массив
					
					$found = false; //индикатор если зайпись на такую страницу
					foreach ( $arUrlRewrite as $key => $arUrl ){
						if ( $arUrl["PATH"] == $filterUrl || $arUrl["CONDITION"] == "#^".$shortUrl."#" ){
							if ( $found ){
								unset($arUrlRewrite[$key]);
							}
							else {
								$arUrlRewrite[$key]["CONDITION"] = "#^".$shortUrl."#";
								$arUrlRewrite[$key]["PATH"] = $filterUrl;
								$found = true;
							}
						}
					}

					if ( !$found ){ 					//если не найдено записи добавляем ее в начало массива
						$arUrlRewriteNew = Array(
							"CONDITION" => "#^".$shortUrl."#",
							"PATH" => $filterUrl
						);
						array_unshift($arUrlRewrite, $arUrlRewriteNew);
					}
					
					file_put_contents($fileUrlReWrite, "<?$"."arUrlRewrite = ".var_export($arUrlRewrite,true).";?>");
				}

			}
		}
	}
	if ( $arFields["IBLOCK_ID"] == 10 ) {
	
		$db_props = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], array("sort" => "asc"), Array("CODE"=>"BREND_OLD"));
		if($ar_props = $db_props->Fetch()){ 
			
			$arSetProps = Array( "BREND" => $ar_props['VALUE_XML_ID']);
			CIBlockElement::SetPropertyValuesEx($arFields["ID"], false, $arSetProps);
		}		
	
	}
}


AddEventHandler("sale", "OnBeforeOrderUpdate", "OnBeforeOrderUpdateHandler");
function OnBeforeOrderUpdateHandler($ID, $arFields){

	if($arFields["STATUS_ID"] == "F"){
		/*if(!$isNew)
			return;*/

		CModule::IncludeModule("sale");
		CModule::IncludeModule("iblock");

		$first_elem = array_shift($arFields["BASKET_ITEMS"]);
		$res = CIBlockElement::GetByID($first_elem["PRODUCT_ID"]); 
		if($ar_res = $res->GetNext()){  
			$im = isset($ar_res["PREVIEW_PICTURE"]) ? $ar_res["PREVIEW_PICTURE"] :$ar_res["DETAIL_PICTURE"];
			$file = CFile::ResizeImageGet($im, array('width'=>100, 'height'=>100), BX_RESIZE_IMAGE_PROPORTIONAL, true);                
			$im = $file['src'];
		} 
		
		if(count($arFields["BASKET_ITEMS"]) == 0)
			$count = count($arFields["BASKET_ITEMS"]) + 1;
		else
			$count = count($arFields["BASKET_ITEMS"]);
		
		function plural_form($number, $after) {
			$cases = array (2, 0, 1, 1, 1, 2);
			return $after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
		}
		$text_tov = plural_form(count($arFields["BASKET_ITEMS"]), array('товар', 'товара', 'товаров' ));
		
		
		$orderList .= '<tr>
			  <td colspan="3" style="background: #fff; vertical-align: center; padding: 6px 20px; border-right: 1px solid #f2f7fd; text-align: center;">
				<img src="'.$_SERVER["HTTP_ORIGIN"].$im.'" alt="'.$first_elem["NAME"].'" />
			  </td>
			  <td colspan="7" style="background: #fbfdfe; vertical-align: top; padding: 40px 20px 20px 40px;">
				<a href="'.$_SERVER["HTTP_ORIGIN"].$first_elem["DETAIL_PAGE_URL"].'" style="font-family: Arial, sans serif; font-size: 16px; color: #006db8; display: block; line-height: 22px;">'.$first_elem["NAME"].'</a>
				<p style="font-family: Arial, sans serif; font-size: 16px; font-weight: bold;">'.($first_elem["PRICE"] * $first_elem["QUANTITY"]).' руб.</p>
			  </td>
			</tr>
			<tr>
			  <td colspan="10">
				<br>';
		if(count($arFields["BASKET_ITEMS"]) > 0){
			   $orderList .=  '<p href="#" style="font-family: Arial, sans serif; font-size: 14px; color: #636568; text-decoration: none;">И еще '.count($arFields["BASKET_ITEMS"]).' '.$text_tov.'</p>';
		}

		$orderList .= '<br>
				<br>
				<p style="font-family: Arial, sans serif; font-size: 16px; line-height:27px;">Расскажите, остались ли вы довольны уровнем сервиса?
				Если сервис не был на высоком уровне – разберемся, чтобы не повторять
				в будущем ошибок, а если все прошло хорошо – менеджер получит
				небольшой бонус.
				<br><br>
				Оцените впечатления от покупки по 10-ти бальной шкале, кликнув
				по соответствующей звездочке: </p>
				<br>

			  </td>
			</tr>';
		
		$starList .= '<td><a href="http://www.bigms.ru/reports/'.$arFields["ID"].'/1/"><img src="http://www.bigms.ru/upload/star/1.png" /></a></td>
			  <td><a href="http://www.bigms.ru/reports/'.$arFields["ID"].'/2/"><img src="http://www.bigms.ru/upload/star/2.png" /></a></td>
			  <td><a href="http://www.bigms.ru/reports/'.$arFields["ID"].'/3/"><img src="http://www.bigms.ru/upload/star/3.png" /></a></td>
			  <td><a href="http://www.bigms.ru/reports/'.$arFields["ID"].'/4/"><img src="http://www.bigms.ru/upload/star/4.png" /></a></td>
			  <td><a href="http://www.bigms.ru/reports/'.$arFields["ID"].'/5/"><img src="http://www.bigms.ru/upload/star/5.png" /></a></td>
			  <td><a href="http://www.bigms.ru/reports/'.$arFields["ID"].'/6/"><img src="http://www.bigms.ru/upload/star/6.png" /></a></td>
			  <td><a href="https://market.yandex.ru/shop/281223/reviews/add?hid&retpath=https%3A%2F%2Fmarket.yandex.ru%2Fshop%2F281223%2Freviews&track=rev_mc_write"><img src="http://www.bigms.ru/upload/star/7.png" /></a></td>
			  <td><a href="https://market.yandex.ru/shop/281223/reviews/add?hid&retpath=https%3A%2F%2Fmarket.yandex.ru%2Fshop%2F281223%2Freviews&track=rev_mc_write"><img src="http://www.bigms.ru/upload/star/8.png" /></a></td>
			  <td><a href="https://market.yandex.ru/shop/281223/reviews/add?hid&retpath=https%3A%2F%2Fmarket.yandex.ru%2Fshop%2F281223%2Freviews&track=rev_mc_write"><img src="http://www.bigms.ru/upload/star/9.png" /></a></td>
			  <td><a href="https://market.yandex.ru/shop/281223/reviews/add?hid&retpath=https%3A%2F%2Fmarket.yandex.ru%2Fshop%2F281223%2Freviews&track=rev_mc_write"><img src="http://www.bigms.ru/upload/star/10.png" /></a></td>';
		
		$arEventFields = array(
			"NAME"  => (isset($arFields["ORDER_PROP"][1]) ? $arFields["ORDER_PROP"][1] : $arFields["PROFILE_NAME"]),
			"EMAIL"  => $arFields["USER_EMAIL"],
			"ORDER_LIST" => $orderList,
			"STAR_LIST" => $starList

		);
		CEvent::Send("SEND_REQ_ORDER", "s1", $arEventFields);
	
	}
}

//проверяем есть ли подарок к заказу и добавляем его
AddEventHandler("sale", "OnBasketAdd", "AddPresentToBasket");
function  AddPresentToBasket($ID,$arFields)     {
            
			if ( $_SESSION["GIFT"][$arFields['PRODUCT_ID']] ){

			/*
            $dbFindInBasket=CSaleBasket::GetList(array("NAME" => "ASC","ID" => "ASC"),
				Array(
				"PRODUCT_ID"=>$_SESSION["GIFT"][$arFields['PRODUCT_ID']],
				"FUSER_ID" => CSaleBasket::GetBasketUserID(),
				"LID" => SITE_ID,
				"ORDER_ID" => "NULL")
				);
			*/
                   //if(!$dbFindInBasket->Fetch()) 
                   //  {
						$dbPresent=CIBlockElement::GetByID( $_SESSION["GIFT"][$arFields['PRODUCT_ID']] );
						if ($present=$dbPresent->Fetch())
                              {
                                $arFieldsPresent = array(
                                 "PRODUCT_ID" => $_SESSION["GIFT"][$arFields['PRODUCT_ID']],
                                 "PRODUCT_PRICE_ID" => 0,
                                 "PRICE" => 0.00,
                                 "CURRENCY" => 'RUB',
                                 "WEIGHT" => 0,
                                 "QUANTITY" => 1,
                                 "LID" => SITE_ID,
                                 "DELAY" => "N",
                                 "CAN_BUY" => "Y",
                                 "NAME" => $present["NAME"],
                                 "MODULE" => "catalog",
                                 "NOTES" => "Товар в подарок",
								 "DISCOUNT_COUPON" => $arFields['PRODUCT_ID'] //сохраняем тут id товара к которму прилагается подарок
                                );
                              CSaleBasket::Add($arFieldsPresent);
                                 
                              }
                    // }
                  
                  }
				  
}



AddEventHandler("sale", "OnBeforeBasketDelete", "DeletePresentFromBasket");
//проверяем есть ли подарок к удаляемому из корзины товару и убираем его из корзины
function DeletePresentFromBasket($ID) {

		$arFields=CSaleBasket::GetByID($ID);
		if ( $arFields['PRODUCT_ID'] ){

			$dbFindInBasket=CSaleBasket::GetList(array("NAME" => "ASC","ID" => "ASC"),
					Array(
					"DISCOUNT_COUPON"=>$arFields['PRODUCT_ID'],
					"FUSER_ID" => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"ORDER_ID" => "NULL")
					);
			if($arFindInBasket=$dbFindInBasket->Fetch()) 
				CSaleBasket::Delete($arFindInBasket['ID']);
		}

     
}


function custom_mail($to, $subject, $message, $addh = "", $addp = "")
{
    

	require_once __DIR__ . '/mail/class.phpmailer.php';

    try {

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        // $mail->IsHTML(true);

    // telling the class to use SMTP
        $mail->IsSMTP();
    // SMTP server
        $mail->Host = "smtp.mail.ru";

    // set the SMTP port for the GMAIL
        //$mail->Port = 25;
		$mail->Port = 465;

        $mail->SMTPAuth   = true;
		
		$mail->SMTPSecure   = 'ssl';

    // SMTP account username
		$mail->Username = "bms@bigms.ru";

    // SMTP account password
        $mail->Password = "QweZxc159";

		$mail->SMTPDebug = 1;

		$mail->SetFrom('bms@bigms.ru');
        $mail->AddAddress($to);
        $mail->Body = $message;
        $mail->Subject = $subject;
		
		//$mail->AddBCC('nevkaa@yandex.ru');


    //$addh = $mail->HeaderLine('To', $mail->EncodeHeader($mail->SecureHeader($to))).$addh;
    //$addh = $mail->HeaderLine('Subject',
    //$mail->EncodeHeader($mail->SecureHeader($subject))).$addh;
    //$mail->Header = $addh."\n";
    //$mail->AddCustomHeader($addh);


        $arr = explode("\n", $addh);

        if (is_array($arr)){
            foreach ($arr as $key => $value) {
                $arrr = explode(":", $value);
                $addh = $mail->HeaderLine($arrr[0], $arrr[1]);

                if($arrr[0] == 'Content-Type') $mail->ContentType = $arrr[1];
            }
        }


    //Debug
        
        $file = fopen(__DIR__.'/log.txt', 'a+');
        $string = 'To: '.print_r($to, true).PHP_EOL;
        $string .= 'Subject: '.print_r($subject, true).PHP_EOL;
        //$string .= 'Message: '.print_r($message, true).PHP_EOL;
        $string .= 'Additional headers: '.print_r($addh, true).PHP_EOL;
        $string .= 'Additional props: '.print_r($addp, true).PHP_EOL;
        //
        fwrite($file, $string);
        fclose($file);
        

        $status = $mail->Send();

    } catch (phpmailerException $e) {
        echo $e->errorMessage();
		
		$file = fopen(__DIR__.'/log.txt', 'a+');
        $string = $e->errorMessage().PHP_EOL;
        fwrite($file, $string);
        fclose($file);
		
    } catch (Exception $e) {
        echo $e->getMessage();
		$file = fopen(__DIR__.'/log.txt', 'a+');
        $string = $e->errorMessage().PHP_EOL;
        fwrite($file, $string);
        fclose($file);
    }

    return $status;
	
}


// Для обмена с 1С
global $CML2_CURRENCY;
$CML2_CURRENCY['643'] = 'RUB';
$CML2_CURRENCY['руб'] = 'RUB'; 
$CML2_CURRENCY['руб.'] = 'RUB'; 
$CML2_CURRENCY['Рубль'] = 'RUB'; 


// Скрытое поле от Спам-ботов ВЕБ-ФОРМЫ
AddEventHandler('form', 'onBeforeResultAdd', 'my_onBeforeResultAdd');
function my_onBeforeResultAdd($WEB_FORM_ID, $arFields, $arrVALUES)
{
	global $APPLICATION;
	$arFormID = array(1, 2, 3);
	
	if (in_array($WEB_FORM_ID, $arFormID)) {
		
		// Если заполнено скрытое поле
		if(!empty($arrVALUES['form_text__1'])){
			return $APPLICATION->ThrowException('Заполнено скрытое поле (спам-бот)');
		}
	}
}

AddEventHandler('main', 'OnEpilog', '_Check404Error',1);
function _Check404Error()
{
   if (defined("ERROR_404") && ERROR_404=="Y")
   {
      global $APPLICATION;
      $APPLICATION->RestartBuffer();
	   include $_SERVER['DOCUMENT_ROOT']."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php";
      require ($_SERVER["DOCUMENT_ROOT"]."/404.php");
	   include $_SERVER['DOCUMENT_ROOT']."/bitrix/templates/".SITE_TEMPLATE_ID."/footer.php"; 
   }
}


AddEventHandler("iblock", "OnBeforeIBlockElementUpdate","SaveMySection");
function SaveMySection(&$arFields)
{
    if (@$_REQUEST['mode']=='import')//импорт  из 1с?
    {
        $db_old_groups = CIBlockElement::GetElementGroups($arFields['ID'], true);
        while($ar_group = $db_old_groups->Fetch())
        {
            if(!in_array($ar_group['ID'],$arFields['IBLOCK_SECTION']))
            $arFields['IBLOCK_SECTION'][]=$ar_group['ID'];
        }
		unset($arFields['ACTION']);
    }
}

//Импорт товаров из 1С (обработка свойств)
//AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("EXT1C", "ATTRIBUTES2PROP"));
//AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("EXT1C", "ATTRIBUTES2PROP"));
/* AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("EXT1C", "ATTRIBUTES2PROP"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("EXT1C", "ATTRIBUTES2PROP"));
class EXT1C
{
    function ATTRIBUTES2PROP(&$arFields)
    {
		if ((@$_REQUEST['type']=='catalog') && (@$_REQUEST['mode']=='import'))//выгрузка из 1С?
        {
			//echo "Работает";
			//echo '<pre>';
			//print_r($arFields);
			//echo '</pre>';
			//die();

			$el = new CIBlockElement;
			$arLoadProductArray = Array(
				"IBLOCK_SECTION_ID" => $arFields["IBLOCK_SECTION"][0]
			);
			$PRODUCT_ID = $arFields["ID"];
			$res = $el->Update($PRODUCT_ID, $arLoadProductArray);
        }
    }
} */

/* function getNumEnding($number, $endingArray)
{
    $number = $number % 100;
    if ($number>=11 && $number<=19)
    {
        $ending=$endingArray[2];
    } else  {
        $i = $number % 10;
        switch ($i) {
            case (1): $ending = $endingArray[0]; break;
            case (2): case (3): case (4): $ending = $endingArray[1]; break;
            default: $ending=$endingArray[2]; }
    }
    return $ending;
} */

function GetFilterUrl($url){

	$smartParts = explode("/", $url);
	$result = array();
	$SECTION_CODE = $smartParts[3];
	//находим раздел
	$arFilter = Array('IBLOCK_ID'=>Array(10, 12), 'CODE'=>$SECTION_CODE );
	$db_list = CIBlockSection::GetList(Array(), $arFilter, true, Array("ID", "IBLOCK_ID"));
	if ($ar_result = $db_list->GetNext()){
		$IBLOCK_ID = $ar_result["IBLOCK_ID"]; //определили какой инфоблок
		$SECTION_ID = $ar_result["IBLOCK_ID"]; //определили какой инфоблок
	}


		$arNewUrl = Array(); //в этот массив собираем все параметры по фильтру
		$arNewUrl[] = "SECTION_CODE=".$SECTION_CODE;

	foreach ($smartParts as $smartPart){
		//echo $smartPart . "<br>";
		$smartPart = preg_split("/-(from|to|is|or)-/", $smartPart, -1, PREG_SPLIT_DELIM_CAPTURE);
		if ( count($smartPart) > 1 ){
			$itemName = "";
			$itemID = "";
			$arPropEnum = Array();

	
			foreach ($smartPart as $i => $smartElement){
				if ( $i == 0 ){
					$itemName = $smartElement; //название свойства
					
					//определяем ID свойства
					$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("CODE"=>$smartElement, "IBLOCK_ID"=>$IBLOCK_ID));
					if ($prop_fields = $properties->GetNext()){
						$itemID = $prop_fields["ID"]; //ID свойства
						//echo $prop_fields["ID"];
					}
					
					if ( $prop_fields["PROPERTY_TYPE"] == 'L' ){
						//получаем значения свойства
						$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID"=>$IBLOCK_ID, "CODE"=>$smartElement));
						while($enum_fields = $property_enums->GetNext()){
							
							
							
							//echo "<br>";
							//echo $enum_fields["XML_ID"];
							
							//получаем ключ 
							$key = $enum_fields["ID"];
							$htmlKey = htmlspecialcharsbx($key);
							$keyCrc = abs(crc32($htmlKey));

							$arPropEnum[$enum_fields["XML_ID"]] = $keyCrc;
						}
					}
					

				}
				else {
					
					if ($smartElement === "from"){
						$arNewUrl[] = "arrFilter_".$itemID."_MIN=".$smartPart[$i+1];
					}
					elseif ($smartElement === "to"){
						$arNewUrl[] = "arrFilter_".$itemID."_MAX=".$smartPart[$i+1];
					}
					elseif ( $smartElement === 'is' || $smartElement === 'or' ){
					
												
						if ( $arPropEnum[$smartPart[$i+1]] ){
							//если тип свойства список 
							$arNewUrl[] = "arrFilter_".$itemID."_".$arPropEnum[$smartPart[$i+1]]."=Y";
						}
						else {
							//получаем ключ 
							$key = $smartPart[$i+1];
							$htmlKey = htmlspecialcharsbx($key);
							$keyCrc = abs(crc32($htmlKey));
							$arNewUrl[] = "arrFilter_".$itemID."_".$keyCrc."=Y";
						}
					}
					
				}
				
				
			
			}
		}
	}
	$arNewUrl[] = "set_filter=y";
	$filterUrl = "/".$smartParts[1]."/".$smartParts[2]."/?". implode("&", $arNewUrl);
	return $filterUrl;
}

function GenerateYandexXML()
{
	// генерируем яндекс выгрузку
	CModule::IncludeModule("webfly.ymarket");
	wfYmarketAgent();
	return "GenerateYandexXML();";
}

function GenerateSitemap()
{
   // генерируем карту сайта sitemap.xml_error_string
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
	
   return "GenerateSitemap();";
}


function numberof($numberof, $value, $suffix)
{
    // не будем склонять отрицательные числа
    $numberof = abs($numberof);
    $keys = array(2, 0, 1, 1, 1, 2);
    $mod = $numberof % 100;
    $suffix_key = $mod > 4 && $mod < 20 ? 2 : $keys[min($mod%10, 5)];
    
    return $value . $suffix[$suffix_key];
}


?>