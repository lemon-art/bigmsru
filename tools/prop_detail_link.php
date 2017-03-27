<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Настройка перелинковки свойств");

CModule::IncludeModule("iblock");

if ( $_GET["IBLOCK_ID"]){
	$IBLOCK_ID = $_GET["IBLOCK_ID"];
}
else {
	$IBLOCK_ID = 12;
}



if ( count( $_POST['prop'] ) > 0){

	$arData = $_POST['prop'];
	//сохраняем настройки
	$fd = fopen($_SERVER["DOCUMENT_ROOT"]."/tools/files/prop_link_".$IBLOCK_ID.".txt", 'w') or die("не удалось создать файл");
	fwrite($fd, serialize($arData) );
	fclose($fd);
}






//считываем ранее введенные в фильтр данные
$data = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/tools/files/prop_link_".$_GET["IBLOCK_ID"].".txt");
$prop = unserialize( $data );
$arProp = Array();
foreach ( $prop as $key=>$val){
	$arProp[] = $key;
}





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
</style>

<div class="conteiner">


	<form name="" id="props" method="post" action="">


		<label>
			Выберите инфоблок: 
			<select name="IBLOCK_ID" id="iblock">
				<option value="12" <?if ($IBLOCK_ID == 12 ):?>selected<?endif;?>>Бытовая сантехника</option>
				<option value="10" <?if ($IBLOCK_ID == 10 ):?>selected<?endif;?>>Инженерная сантехника</option>
			</select>
			
		</label>
		
		

		<ul class="prop_list">
	<?


	$properties = CIBlockProperty::GetList(Array("name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID));
	while ($prop_fields = $properties->GetNext()):?>
		<?if ( $prop_fields["SORT"] > 550 || $prop_fields["CODE"] == 'BREND'):?>
			<li>
				<label>
					<input type="checkbox" class="check" name="prop[<?=$prop_fields["ID"]?>]" <?if ( in_array($prop_fields["ID"], $arProp) ):?>checked<?endif;?>>  <?=$prop_fields["NAME"]?>
				<label>
			</li>
		<?endif;?>


	<?endwhile;?>
		</ul>
		<div style="clear: both;"></div>
		<div class="buttons">
			<input type="submit" id="submitButton" value="Сохранить">
			<input type="button" id="resetButton" value="Сбросить">
		</div>
	</form>


	<div id="itog">

	</div>
</div>



<script type="text/javascript" src="/bitrix/templates/bigms/js/jquery-1.11.1.min.js?148731963895790"></script>
<script>

	
	
	$('input#resetButton').click( function() {
		
		$('.check').removeAttr('checked');	
		return false;
	});
	
		
	$('#iblock').on('change', function() {
		window.location.href = '?IBLOCK_ID='+this.value;
	})
</script>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
