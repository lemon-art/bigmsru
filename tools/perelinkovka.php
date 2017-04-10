<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Перелинковка в карточках товаров");

CModule::IncludeModule("iblock");

if ( $_GET["IBLOCK_ID"]){
	$IBLOCK_ID = $_GET["IBLOCK_ID"];
}
else {
	$IBLOCK_ID = 12;
}

if ( $_GET["SECTION_ID"] ){

	//открываем файл с массивом 
	$listFile = $_SERVER["DOCUMENT_ROOT"]."/tools/files/perelinkovka_prop_".$IBLOCK_ID.".txt";
	$data = file_get_contents($listFile);
	$arPropData = unserialize( $data );

	//обрабатываем данные с заполненной формы
	$arProp = Array();
	if ( is_array( $_POST['prop'] )){
		if ( is_array($arPropData[$_GET["SECTION_ID"]])){
			unset( $arPropData[$_GET["SECTION_ID"]] ); 
		}
		foreach ( $_POST['prop'] as $key=>$val){
			$arPropData[$_GET["SECTION_ID"]][] = $key;
		}
		//сохраняем изменения
		$fd = fopen($listFile, 'w') or die("не удалось создать файл");
		fwrite($fd, serialize($arPropData) );
		fclose($fd);

	}
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
	width: 30%;
	font-size: 10px;
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

.fordtreeview ul{
  display:none;
  margin: 15px -16px;
  list-style:none;
}

.fordtreeview ul.expanded{
  display:block;
}

.fordtreeview ul li{
  left:5px;
  margin-right:10px; 
  color: #333;
  
}

.fordtreeview > li:first-child{
  display:block !important;
}

.fordtreeview li,
.fordtreeview a{
  color: #333; 
  text-decoration:none; 
  cursor:pointer;
}

.fordtreeview i.glyphicon{
  margin-right:5px;
}

.subactivated,
.fordtreeview > li:not(:first-child):hover{
  background-color: #f5f5f5;
}

.props {
	display: none;
}
</style>

<div class="conteiner">





	<div class="col-md-4">
		<label>
			Выберите инфоблок: 
			<select name="IBLOCK_ID" id="iblock">
				<option value="12" <?if ($IBLOCK_ID == 12 ):?>selected<?endif;?>>Бытовая сантехника</option>
				<option value="10" <?if ($IBLOCK_ID == 10 ):?>selected<?endif;?>>Инженерная сантехника</option>
			</select>
			
		</label>
		
	
		<ul class="fordtreeview list-group">
			<li class="list-group-item"><input type="text" class="form-control menufilter" placeholder="Быстрый поиск"/></li>
			<?foreach ( $arSections as $key => $arSection):?>
				<?
				if ( $arSections[$key+1]["DEPTH_LEVEL"] ){
					$nextLevel = $arSections[$key+1]["DEPTH_LEVEL"];
				}
				else {
					$nextLevel = 0;
				}
				?>
				<li class="list-group-item <?if ( $_GET["SECTION_ID"] == $arSection["ID"]):?>active<?endif;?>">
					<?if ($nextLevel > $arSection["DEPTH_LEVEL"] ):?>
						<span class="hasSub"><i class="glyphicon glyphicon-folder-close"></i><?=$arSection["NAME"]?> <a href="?IBLOCK_ID=<?=$IBLOCK_ID?>&SECTION_ID=<?=$arSection["ID"]?>"><i class="glyphicon glyphicon-edit"></i></a></span>
						
						<ul class="list-group">
					<?else:?>
						<i class="glyphicon glyphicon-file"></i><?=$arSection["NAME"]?> <a href="?IBLOCK_ID=<?=$IBLOCK_ID?>&SECTION_ID=<?=$arSection["ID"]?>"><i class="glyphicon glyphicon-edit"></i></a>
					<?endif;?>
					
					<?if ($nextLevel < $arSection["DEPTH_LEVEL"] ):?>
						<?for ( $i = 0; $i < ($arSection["DEPTH_LEVEL"] - $nextLevel); $i++):?>
							</ul>
						<?endfor;?>
					<?endif;?>
				</li>
			<?endforeach;?>	
		</ul>
	</div>
	
	
	<div class="col-md-8">
		<?if ( $_GET["SECTION_ID"] ):?>
			<?$res = CIBlockSection::GetByID($_GET["SECTION_ID"]);
			if($arSection = $res->GetNext()):?>
			
				<?
				$arPropValue = Array();
				$arPropName = Array();
				$properties = CIBlockProperty::GetList(Array("name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID));
				while ($prop_fields = $properties->GetNext()){
					$arPropValue[] = $prop_fields;
					$arPropName[$prop_fields["CODE"]] = $prop_fields["NAME"];
				}
				?>
			
			<h2><?=$arSection["NAME"]?></h2>
			
			<?if (is_array( $arPropData[$_GET["SECTION_ID"]] )):?>
				<b>Установленные свойства:</b><br>
				<?foreach ( $arPropData[$_GET["SECTION_ID"]] as $idProp):?>
					<?=$arPropName[$idProp]?><br>
				<?endforeach;?>
				
				

			<?endif;?>
			
			<a href="#" id="show_props">Добавить/редактировать свойства для перелинковки</a>
		
			<div class="props">
				<form action='?IBLOCK_ID=<?=$IBLOCK_ID?>&SECTION_ID=<?=$arSection["ID"]?>' method="post">
					<ul class="prop_list">
						<?foreach ( $arPropValue as $prop_fields):?>


							<?if ( $prop_fields["SORT"] > 5 || $prop_fields["CODE"] == 'BREND'):?>
								<li>
									<label>
										<input type="checkbox" class="check" name="prop[<?=$prop_fields["CODE"]?>]" <?if ( in_array($prop_fields["CODE"], $arPropData[$_GET["SECTION_ID"]]) ):?>checked<?endif;?>>  <?=$prop_fields["NAME"]?>
									<label>
								</li>
							<?endif;?>


						<?endforeach;?>
					</ul>
					<div style="clear: both;"></div>
					<div class="buttons">
						<input type="submit" id="submitButton" value="Сохранить">
						<input type="button" id="resetButton" value="Сбросить">
					</div>
				</form>
			
			</div>
		
			<?endif;?>
		<?endif;?>
	</div>


	<div id="itog">

	</div>
</div>



<script type="text/javascript" src="/bitrix/templates/bigms/js/jquery-1.11.1.min.js?148731963895790"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/bootstrap.min.js"></script>
	<script src="<?=SITE_TEMPLATE_PATH?>/js/bootstrap-treeview.js"></script>
<script>

$(document).ready(function () {

	if($(this).find('li.list-group-item').hasClass('active')){

		$(this).find('li.list-group-item.active').parents('ul').addClass('expanded');
		
	}

	$('.hasSub').click(function () {
    $(this).parent().toggleClass('subactivated');
		$(this).parent().children('ul:first').toggle();
    
    if($(this).find('i').hasClass('glyphicon-folder-open')){
      $(this).find('i.glyphicon-folder-open').removeClass('glyphicon-folder-open').addClass('glyphicon-folder-close');
    }else{
      $(this).find('i.glyphicon-folder-close').removeClass('glyphicon-folder-close').addClass('glyphicon-folder-open');
    }
	}); 
  
  $(".menufilter").keyup(function () {
     //$(this).addClass('hidden');
  
    var searchTerm = $(".menufilter").val();
    var listItem = $('.fordtreeview').children('li');
  
    var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
    
      //extends :contains to be case insensitive
  $.extend($.expr[':'], {
  'containsi': function(elem, i, match, array)
  {
    return (elem.textContent || elem.innerText || '').toLowerCase()
    .indexOf((match[3] || "").toLowerCase()) >= 0;
  }
});
    
    $(".fordtreeview li").not(":containsi('" + searchSplit + "')").each(function(e)   {
      $(this).hide()
    });
    
    $(".fordtreeview li:containsi('" + searchSplit + "')").each(function(e) {
      $(this).show();
    });
  });  
});

	$('#show_props').click( function() {
		
		$('.props').toggle();
		return false;
	});
	
	$('input#resetButton').click( function() {
		
		$('.check').removeAttr('checked');	
		return false;
	});
	
	function sendPost (data, n){
			$.post("/tools/ajax_prop.php",
				   {'data': $('form#props').serialize(), 'n': n},
				   function(result){ 
						//alert(result);
						$( "#itog" ).append( result );
						n++
						if ( n < 2){
							sendPost (data, n)
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
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
