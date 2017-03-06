<?php
//обработка csv файлов на предмет наличия и заполнения свойств
error_reporting(E_ALL | E_NOTICE | E_STRICT);
ini_set("error_reporting", E_ALL|E_STRICT);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/csv_data.php");
		
CModule::IncludeModule("iblock");

if ( $_GET["IBLOCK_ID"]){
	$IBLOCK_ID = $_GET["IBLOCK_ID"];
}
else {
	$IBLOCK_ID = 12;
}

$scvDir = $_SERVER["DOCUMENT_ROOT"]."/tools/csv/"; 		//папка где храним загруженные csv файлы
						

if (!empty($_FILES['userfile']['name'])){
	
	$uploadfile = $scvDir.basename($_FILES['userfile']['name']);

	// Копируем файл из каталога для временного хранения файлов:
	if (copy($_FILES['userfile']['tmp_name'], $uploadfile))
	{
	   $message = "<h3>Файл успешно загружен на сервер</h3>";
	}
	else
	{
	   $message = "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
	}
}

//получаем структурированный список разделов инфоблока
$arSections = getSectionList(
 Array(
    'IBLOCK_ID' => $IBLOCK_ID
 ),
 Array(
    'NAME',
    'ID',
	'DEPTH_LEVEL'
 )
);

$csvFiles = scandir($scvDir); 							//сканируем папку

?>


<style>
.prop_list {
	list-style: none;
}

.prop_list li{
	float: left;
	width: 30%;
}

TABLE {
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
    width: 90%; /* Ширина таблицы */
   }
   TH, TD {
    border: 1px solid black; /* Параметры рамки */
    text-align: left; /* Выравнивание по центру */
    padding: 4px; /* Поля вокруг текста */
   }

.buttons {  
    text-align: center;
    margin: 30px;
}

.conteiner {
	margin: 20px;
	padding: 20px;
	border: 1px #15188a solid;
	height: 90%;
}

#upload_div {
	display: none;
}

.product_list {
	display: none;
}
</style>

<div class="conteiner">
	<h1>Загрузка свойств</h1>

	<?=$message?>
	
	<form name="" id="props" method="post" action="" enctype = 'multipart/form-data'>


		<label>
			Выберите инфоблок: 
			<select name="IBLOCK_ID" id="iblock">
				<option value="12" <?if ($IBLOCK_ID == 12 ):?>selected<?endif;?>>Бытовая сантехника</option>
				<option value="10" <?if ($IBLOCK_ID == 10 ):?>selected<?endif;?>>Инженерная сантехника</option>
			</select>
			
		</label>
		<br><br>
		<label>
			Выберите раздел: 
			<select name="SECTION_ID" id="">
				<?foreach ( $arSections as $arSection):?>
					<option value="<?=$arSection["ID"]?>" <?if ( $SECTION_ID == $arSection["ID"]):?>selected<?endif;?>>
						<?for ($i=1; $i < $arSection["DEPTH_LEVEL"]; $i++):?>..<?endfor;?>
						<?=$arSection["NAME"]?>
					</option>
				<?endforeach;?>
			</select>
			
		</label>
		<br><br>
		<label>
			Выберите файл для обработки: 
			
			<select name="csvFile" id="">

				 
				<?foreach ($csvFiles as $file):?>
				
					<?if(preg_match('/\.(csv)/', $file)):?>
						<option value="<?=$file?>" <?if ( $_POST['csvFile'] == $file):?> selected <?endif;?> ><?=$file?></option>
					<?endif;?>
					
				<?endforeach;?>
				
			
			</select>
			<input type="submit" id="readFile" value="Считать файл" />
		</label>
		<br><br>
		<a href="" id="uploadFiles">загрузить новый файл</a>
		<div id="upload_div">
			<input name="userfile" type="file" />
			<input type="submit" value="Загрузить" />
		</div>
		
		<?
		if ( $_POST['csvFile'] ){
			//дабы не грузить сервер считываем файл csv, переводим его в массив и сохраняем по частям в временные файлы. Затем с помощью аякса обрабатываем эти файлы
			
			$arData = Array(); 	// здесь формируется новый массив
			$row = 1;
			$num = 0; 			//число строк в текущей итеррации
			$count = 0; 		//общий счетчик строк
			$file_k = 0; 		//счетчик префикса временного файла
			
			//удаление временных файлов
			exec("rm -rf ".$_SERVER["DOCUMENT_ROOT"]."/tools/temp/*");
			//rmdir( $_SERVER["DOCUMENT_ROOT"]."/tools/temp/");
			
			
			if (($handle = fopen($_SERVER["DOCUMENT_ROOT"]."/tools/csv/".$_POST['csvFile'], "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 5000, ";")) !== FALSE) {
					
					$row++;
					$arData[] = $data;
					$num++;
					$count++;
					
					if ( $num > 99 ){
						//создаем временный файл в temp и записываем туда массив
						$fd = fopen($_SERVER["DOCUMENT_ROOT"]."/tools/temp/csv_".$file_k.".txt", 'w') or die("не удалось создать файл");
						fwrite($fd, serialize($arData) );
						fclose($fd);
						$arData = Array(); //обнуляем массив
						$file_k++; //счетчик файлов
						$num = 0;
						
					}
				}
				fclose($handle);
				
				//записываем остатки
				if ( count($arData) > 0 ){
					//создаем временный файл в temp и записываем туда массив
					$fd = fopen($_SERVER["DOCUMENT_ROOT"]."/tools/temp/csv_".$file_k.".txt", 'w') or die("не удалось создать файл");
					fwrite($fd, serialize($arData) );
					fclose($fd);
					$arData = Array(); //обнуляем массив
					$file_k++; //счетчик файлов
					$num = 0;
				
				}
				
				
				
						//создаем временный файл для хранения совпадений
						$fd = fopen($_SERVER["DOCUMENT_ROOT"]."/tools/temp/result.txt", 'w') or die("не удалось создать файл");
						fwrite($fd, '' );
						fclose($fd);
			}
		
		




		
		?>
		<br><br>
		Файл: <?=$_POST['csvFile']?><br>
		В файле товаров: <b><?=$count?></b>
		<input type="hidden" id="file_k" value="<?=$file_k?>">

		
		
		<div id="itog">

		</div>

		<div id="itog2">

		</div>
		
		<div style="clear: both;"></div>
		<div class="buttons">
			<input type="submit" id="submitButton" value="Начать обработку">
			<img src="images/preloader.gif" id="preloader" style="display: none;">
			<input type="submit" id="submitButtonEdit" value="Заполнить свойства" style="display: none;">
		</div>
		
		<?
		}
		?>
	</form>



</div>



<script type="text/javascript" src="/bitrix/templates/bigms/js/jquery-1.11.1.min.js?148731963895790"></script>
<script>

	$('input#submitButton').click( function() { //кнопка начать обработку
		
		n = 0;
		$("#itog").empty();
		$("#itog2").empty();
		sendPost (0);
		$('input#submitButton').hide();
		$('#preloader').show();
		$('input#readFile').hide();
		$('#uploadFiles').hide();
		$('#upload_div').hide();
		return false;
	});
	
	$('input#resetButton').click( function() {
		
		$('.check').removeAttr('checked');	
		return false;
	});
	
	$('#product_list').click( function() {
		
		$('.product_list').toggle();	
		return false;
	});
	
	$('#uploadFiles').click( function() {
		
		$('#upload_div').toggle();	
		return false;
	});
	
	$('input#submitButtonEdit').click( function() { //кнопка заполнить свойства

		n = 0;
		$("#itog2").empty();
		$('#preloader').show();
		$('input#submitButtonEdit').hide();
			$.post("/tools/set_prop_ajax.php",
				   {'data': $('form#props').serialize()},
				   function(result){ 
						//alert(result);
						$("#itog2").empty();
						$( "#itog2" ).append( result );
						$('#preloader').hide();
				  }
			);
		return false;
	});
	
	
	//отправляет запросы по шагам для поиска совпадений в массиве выработнном из файлы xml
	function sendPost (n){
			$.post("/tools/load_props_ajax.php",
				   {'n': n, 'data': $('form#props').serialize()},
				   function(result){ 
						//alert(result);
						$("#itog").empty();
						$( "#itog" ).append( result );
						n++
						if ( n < $('#file_k').val() ){
							sendPost (n)
						}
						else {
						
							$('#preloader').hide();	
							$('#submitButtonEdit').show();	
							$('input#readFile').show();
							$('#uploadFiles').show();
							
						}
				  }
			);
	}
	
	$('#iblock').on('change', function() {
		window.location.href = '?IBLOCK_ID='+this.value;
	})
</script>


<?
function getSectionList($filter, $select)
{
   $dbSection = CIBlockSection::GetList(
      Array(
               'LEFT_MARGIN' => 'ASC',
      ),
      array_merge( 
          Array(
             'ACTIVE' => 'Y',
             'GLOBAL_ACTIVE' => 'Y'
          ),
          is_array($filter) ? $filter : Array()
      ),
      false,
      array_merge(
          Array(
             'ID',
             'IBLOCK_SECTION_ID'
          ),
         is_array($select) ? $select : Array()
      )
   );
	$arSections = Array();
	
   while( $arSection = $dbSection-> GetNext(true, false) ){

	   $arSections[] = $arSection;
       //$SID = $arSection['ID'];
       //$PSID = (int) $arSection['IBLOCK_SECTION_ID'];

       //$arLincs[$PSID]['CHILDS'][$SID] = $arSection;

       //$arLincs[$SID] = &$arLincs[$PSID]['CHILDS'][$SID];
   }

   return $arSections;
}
?>

