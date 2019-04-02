<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<div class="news-detail">
	
	<h3><?=$arResult['PROPERTY_12']?></h3>
	<hr>
	<div class="shop_table">
		<div class="office_data">
		
			<div class="item">
				<span>Телефон:</span>  <?=$arResult['PROPERTY_13'][0]?> <img src="/images/watsup.png"> <img src="/images/viber.png"> 
			</div>
			
			<?if ( $arResult['PROPERTY_13'][1] ):?>
				<?$email = str_replace('E-mail: ', '', $arResult['PROPERTY_13'][1]);?>
				<div class="item">
					<span>E-mail:</span>  <a href="mailto:<?=$email?>"><?=$email?></a>
				</div>
			<?endif;?>
		
			<div class="item">
				<span>Часы работы:</span>  <?=$arResult['~PROPERTY_29']?>
			</div>
			
			<?if ( $arResult['PROPERTY_14'] ):?>
				<div class="item">
					<span>Видео проезда:</span>  <a data-trigger="youtube" data-youtube='<?=$arResult["PROPERTY_14"]?>' href="#" class="contacts-description__video popup-trigger">смотреть</a>
				</div>
			<?endif;?>
			

			<?if ( $arResult["PROPERTY_622"] ):?>
				<div class="item">
					<span>Схема проезда на общественном транспорте:</span>  <a data-trigger="youtube" data-youtube='<img width="900" src="<?=CFile::GetPath($arResult["PROPERTY_622"]);?>">' href="#" class="contacts-description__video popup-trigger">Открыть</a>
				</div>
			<?endif;?>
								
			<?if ( $arResult["PROPERTY_623"] ):?>
				<div class="item">
					<span>Схема проезда на машине:</span>  <a data-trigger="youtube" data-youtube='<img width="900" src="<?=CFile::GetPath($arResult["PROPERTY_623"]);?>">' href="#" class="contacts-description__video popup-trigger">Открыть</a>
				</div>
			<?endif;?>

			
		</div>
		<div class="office_img owl-carousel owl-theme" id="main_slider">
			<?foreach ( $arResult['DISPLAY_PROPERTIES']['MORE_PHOTO']['FILE_VALUE'] as $photo):?>
				<div class="item">
					<img src="<?=$photo["src"]?>">
				</div>
			<?endforeach;?>
		</div>
	</div>
	
	<hr>
	<div class="shop_text">
		<?=$arResult["PREVIEW_TEXT"]?>
	</div>
	</hr>
	<div class="shop_map">
		<div id="map" class="content-contacts__map"></div>
	</div>

</div>

<script type="text/javascript">


		var sync1 = $("#main_slider");
	
		sync1.owlCarousel({
		    items : 1,
		    slideSpeed : 2000,
		    nav: true,
		    autoplay: true,
		    dots: true,
			 navText: ["<img src='<?=SITE_TEMPLATE_PATH?>/styles/images/icons/arrow-left.png'>", "<img src='<?=SITE_TEMPLATE_PATH?>/styles/images/icons/arrow-right.png'>"],
		    loop: true,
		});

ymaps.ready(init);
    var myMap;
	

    function init(){  
	
		var myCollection = new ymaps.GeoObjectCollection();
        myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 10,
			controls: ['zoomControl']
        }, {suppressMapOpenBlock: true});

		MyIconContentLayout27 = ymaps.templateLayoutFactory.createClass(
				'<div class="bigms-marker"><svg style="width: 47px; height: 60px; fill:#ffa200;" class="bigms-marker__svg">'+
											'<use xlink:href="#icon-marker"></use>'+
										'</svg></div>'
				);
				
		MyIconContentLayout28 = ymaps.templateLayoutFactory.createClass(
				'<div class="bigms-marker"><svg style="width: 47px; height: 60px; fill:#1c6bc4;" class="bigms-marker__svg">'+
											'<use xlink:href="#icon-marker"></use>'+
										'</svg></div>'
				);

		MyIconContentLayout1440 = ymaps.templateLayoutFactory.createClass(
				'<div class="bigms-marker"><svg style="width: 47px; height: 60px; fill:#59ce42;" class="bigms-marker__svg">'+
											'<use xlink:href="#icon-marker"></use>'+
										'</svg></div>'
				);	
				
				
				lastCoord = [<?=$arResult["PROPERTY_15"]?>];
				myCollection.add(new ymaps.Placemark([<?=$arResult["PROPERTY_15"]?>]));
			
				myPlacemark<?=$arResult["ID"]?> = new ymaps.Placemark([<?=$arResult["PROPERTY_15"]?>],{}, {
					iconLayout: 'default#imageWithContent',
					iconImageHref: '', // картинка иконки
					iconImageSize: [47, 64], // размер иконки
					iconImageOffset: [-34, -80], // позиция иконки
					iconContentOffset: [15, 15],
					iconContentLayout: MyIconContentLayout<?=$arResult["IBLOCK_SECTION_ID"]?>
				});
				

				myPlacemark<?=$arResult["ID"]?>.options.set('preset', <?=$arResult["ID"]?>);
				myPlacemark<?=$arResult["ID"]?>.options.set('coordinate', <?=$arResult["PROPERTY_15"]?>);
				myMap.geoObjects.add(myPlacemark<?=$arResult["ID"]?>);
				myMap.setCenter( lastCoord, 13 );
		}
		
	init();
	


</script>
