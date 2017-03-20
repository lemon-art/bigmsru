<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Коллекции");?>




<?
CModule::IncludeModule("iblock");
$colFile = $_SERVER["DOCUMENT_ROOT"]."/tools/files/collections.txt"; 

if ( $_GET["IBLOCK_ID"]){
	$IBLOCK_ID = $_GET["IBLOCK_ID"];
}
else {
	$IBLOCK_ID = 12;
}

//считываем файл с массивом коллекций
$data = file_get_contents( $colFile );
$arResult = unserialize( $data );

if ( $_GET["COLLECTION_ID"]){
	$COLLECTION_ID = $_GET["COLLECTION_ID"];
}

if ( $_GET["DEL_COLLECTION_ID"]){
	$DEL_COLLECTION_ID = $_GET["DEL_COLLECTION_ID"];
	//удаляем коллекцию
	unset($arResult[$DEL_COLLECTION_ID]);
	//переформируем массив
	$arNewResult = Array();
	foreach( $arResult as $atItem){
		$arNewResult[] = $atItem;
	}
	
	//сохраняем файл коллекций
	$fd = fopen($colFile, 'w') or die("не удалось создать файл");
	fwrite($fd, serialize( $arResult ) );
	fclose($fd);
	
	echo "<script>window.location.href = '/tools/collections.php';</script>";
}




		
foreach ( $prop as $key=>$val){
	$arProp[] = $key;
}

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
?>


<style>
.prop_list {
	list-style: none;
}

.prop_list li{
	float: left;
	width: 33%;
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

.row{
	margin: 0px;
}
label {
    margin-bottom: 10px; 
    font-weight: 400;
    font-size: 12px;
}

label span{
    width: 150px;
    display: block;
    float: left;
}

label input[type=input], label select{
    width: 320px;

}

h1 {
	text-align: center;
}
</style>

<div class="conteiner row">


	<div class="col-md-6">
	<h2>Список коллеций</h2>
		<?foreach( $arResult as $keyCollection => $arCollection):?>
			<a href="?IBLOCK_ID=<?=$arCollection["IBLOCK_ID"]?>&COLLECTION_ID=<?=$keyCollection?>"><?=$arCollection["NAME"]?></a>  
			<a href="?DEL_COLLECTION_ID=<?=$keyCollection?>" class="delete"><span data-id="<?=$keyCollection?>" class="glyphicon glyphicon-remove"></span></a><br>
		<?endforeach;?>
		<hr>
		<a href="?IBLOCK_ID=12">Добавить коллекцию</a>
	</div>
	<div class="col-md-6">
		<?if ( $COLLECTION_ID ):?>
			<h2>Редактировать коллекцию</h2>
		<?else:?>
			<h2>Создать коллекцию</h2>
		<?endif;?>
		<form name="" id="props" method="post" action="">
			<?if ( $COLLECTION_ID ):?>
				<input name="COLLECTION_ID" value="<?=$COLLECTION_ID?>" type="hidden"> 
			<?endif;?>
			
			<label>
				<span>Название коллекции: </span>
				<input name="NAME" value="<?if ( $COLLECTION_ID ):?><?=$arResult[$COLLECTION_ID]["NAME"]?><?endif;?>" type="input"> 
			</label>
			<br>
			<label>
				<span>Выберите инфоблок: </span>
				<select name="IBLOCK_ID" id="iblock">
					<option value="12" <?if ($IBLOCK_ID == 12 ):?>selected<?endif;?>>Бытовая сантехника</option>
					<option value="10" <?if ($IBLOCK_ID == 10 ):?>selected<?endif;?>>Инженерная сантехника</option>
				</select>
				
			</label>
			<br>
			<label>
				<span>Выберите раздел: </span>
				<select name="SECTION_ID" id="">
					<?foreach ( $arSections as $arSection):?>
						<option value="<?=$arSection["ID"]?>" <?if ( $COLLECTION_ID && $arResult[$COLLECTION_ID]["SECTION_ID"] == $arSection["ID"]):?>selected<?endif;?>>
							<?for ($i=1; $i < $arSection["DEPTH_LEVEL"]; $i++):?>..<?endfor;?>
							<?=$arSection["NAME"]?>
						</option>
					<?endforeach;?>
				</select>
				
			</label>
			<br>
			<label>
				<span>Выберите свойства: </span>
			</label>
			<ul class="prop_list">
				<?


				$properties = CIBlockProperty::GetList(Array("name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID));
				while ($prop_fields = $properties->GetNext()):?>
					<?if ( $prop_fields["SORT"] > 550 || $prop_fields["CODE"] == 'BREND'):?>
						<li>
							<label>
								<input type="checkbox" class="check" name="prop[<?=$prop_fields["ID"]?>]" <?if ( in_array($prop_fields["ID"], $arResult[$COLLECTION_ID]["PROPS"]) ):?>checked<?endif;?>>  <?=$prop_fields["NAME"]?>
							<label>
						</li>
					<?endif;?>


				<?endwhile;?>
			</ul>
			<div style="clear: both;"></div>
			<div class="buttons">
				<?if ( $COLLECTION_ID ):?>
					<input type="submit" id="submitButton" value="Сохранить коллекцию">
				<?else:?>
					<input type="submit" id="submitButton" value="Добавить коллекцию">
				<?endif;?>
				
				<input type="button" id="resetButton" value="Сбросить свойства">
			</div>
		</form>


		<div id="itog">

		</div>
	</div>
</div>



<script type="text/javascript" src="/bitrix/templates/bigms/js/jquery-1.11.1.min.js?148731963895790"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> 
<script>

	$('input#submitButton').click( function() {
		
		n = 1;
		$("#itog").empty();
		sendPost ($('form#props').serialize(), n);
		
		
		
		return false;
	});
	
	$('.delete').click( function() {
		
		var result = confirm("Действительно удаляем?");
		if (result ==true){
			window.location.href = this.href;
		}
		
		return false;
	});
	
	$('input#resetButton').click( function() {
		
		$('.check').removeAttr('checked');	
		return false;
	});
	
	function sendPost (data, n){
			$.post("/tools/ajax/collections.php",
				   {'data': $('form#props').serialize()},
				   function(result){ 
						window.location.href = '';
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

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>