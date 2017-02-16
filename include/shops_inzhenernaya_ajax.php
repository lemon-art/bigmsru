<?
// подключение служебной части пролога  
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?> 
<div class="map_shop_list">

	<div class="title">адреса магазинов</div>

	<?if (CModule::IncludeModule("iblock")) {
		$arFilter = Array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "SECTION_ID"=>27);
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "CODE", "DETAIL_PAGE_URL", "PROPERTY_ADRESS", "PROPERTY_PHONE", "PROPERTY_MAP", "PROPERTY_REZHIM");
		$res = CIBlockElement::GetList(Array("NAME"=>"ASC"), $arFilter, false, array("nPageSize"=>10), $arSelect);
		while($ar_fields = $res->GetNext())
		{
			$arFilds[] = $ar_fields;
		}
	}
	?>

	<script type="text/javascript">
	ymaps.ready(init);

	function init () {
		//Создание экземпляра карты и его привязка к контейнеру с заданным id ("map")
		var myMap = new ymaps.Map("map", {
			center: [54.83, 37.11],
			zoom: 5,
			behaviors: ['default', 'scrollZoom'],
			controls: ['mapTools']
		});
		
		<?
		foreach($arFilds as $k=>$filds){
			?>
			myPlacemark<?=$k;?> = new ymaps.Placemark([<?=$filds["PROPERTY_MAP_VALUE"]?>], {
				// Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства.
				balloonContentHeader: "<div class='balun_header'><?=$filds["NAME"]?></div>",
				balloonContentBody: "<div class='balun_text'><?=$filds["PROPERTY_ADRESS_VALUE"]?></div>"
				//balloonContentFooter: "Подвал",
				//hintContent: "Хинт метки"
			});
			myMap.geoObjects.add(myPlacemark<?=$k;?>);
			<?
		}
		?>
			
		var result = ymaps.geoQuery(myMap.geoObjects).applyBoundsToMap(myMap, {
			checkZoomRange: true
		});
	}
	<?
	foreach($arFilds as $k=>$filds){
	?>
		ymaps.ready(init<?=$k?>);

		function init<?=$k?> () {
			//Создание экземпляра карты и его привязка к контейнеру с заданным id ("map")
			var myMap = new ymaps.Map("map<?=$k?>", {
				center: [<?=$filds["PROPERTY_MAP_VALUE"]?>],
				zoom: 16,
				behaviors: ['default', 'scrollZoom'],
				controls: ['mapTools']
			});

			myPlacemark<?=$k;?> = new ymaps.Placemark([<?=$filds["PROPERTY_MAP_VALUE"]?>], {
				balloonContentHeader: "<div class='balun_header'><?=$filds["NAME"]?></div>",
				balloonContentBody: "<div class='balun_text'><?=$filds["PROPERTY_ADRESS_VALUE"]?></div>"
			});
			myMap.geoObjects.add(myPlacemark<?=$k;?>);

			
		}
	<?
	}
	?>
	
	function open_current_map(val){
		$('.not_radius .map').hide();
		$(val).show();
	}
	
	</script>

	<div id="map" class="map map_change"></div>
	
	<?
	foreach($arFilds as $k=>$filds){
		echo '<div id="map'.$k.'" class="map map_change hidden"></div>';
	}
	?>

	<?
	foreach($arFilds as $k=>$filds){
		?>
		<div class="item">
			<div class="links">
				<a href="<?=$filds["DETAIL_PAGE_URL"]?>"><?=$filds["NAME"]?></a>,
				<!-- <a href="#" class="balloon_open" onclick="myPlacemark<?=$k;?>.balloon.open();">показать на карте</a> -->
				<!-- <a href="#" class="balloon_open" onclick="open_one_shop<?=$k;?>()">показать на карте</a> -->
				<a href="#" class="balloon_open" onclick="open_current_map('#map<?=$k?>');">показать на карте</a>
				
			</div>
			<div class="row">
				<div class="adress_reshim">
					<?if(!empty($filds["PROPERTY_ADRESS_VALUE"])){?><div>Адрес: <?=$filds["PROPERTY_ADRESS_VALUE"]?></div><?}?>
					<?if(!empty($filds["PROPERTY_REZHIM_VALUE"])){?><div>Время работы: <?=$filds["PROPERTY_REZHIM_VALUE"]?></div><?}?>
				</div>
				<div class="phone">
					<?
					foreach($filds["PROPERTY_PHONE_VALUE"] as $phone){
						echo $phone.'<br />';
					}
					?>
				</div>
			</div>
		</div>
		<?
	}
	?>
</div>