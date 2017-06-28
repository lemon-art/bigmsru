<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$out = array();

$this->SetViewTarget("content__wrap");
echo "content__wrap_contacts";
$this->EndViewTarget("content__wrap");

$this->SetViewTarget("row_div_class");
echo "col-lg-22 col-lg-offset-1 col-md-22 col-md-offset-1 col-sm-22 col-sm-offset-1 content__container content__container_catalog";
$this->EndViewTarget("row_div_class");
?>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>


            <div class="content-contacts">
              <div class="content-contacts__tabs product-tabs tabs">
                <div class="product-tabs__header-wrap">
                  <ul class="product-tabs__header-list tabs__header">
					<?foreach ( $arResult["SECTIONS"] as $arSection ):?>
						<li data-section="<?=$arSection["ID"]?>" class="product-tabs__header-item product-tabs__header-item_<?=$arSection["CODE"]?> map-trigger"><?=$arSection["NAME"]?></li>
					<?endforeach;?>
				   <li data-section="0" class="product-tabs__header-item map-trigger active">Все</li>
                    <li class="product-tabs__header-item requisites-trigger">Реквизиты</li>
                  </ul>
                </div>
              </div>
			  <div class="content-contacts__content">
                <div class="content-contacts__map-wrap">
                  <div id="map" class="content-contacts__map"></div>
                </div>
				<? foreach( $arResult['ITEMS'] as $iOfficeInd => $aOffice ): ?>
					<div class="content-contacts__container" id="office<?=$aOffice["ID"]?>">
						<?/*
						  <div id="contacts_gallery" class="content-contacts__gallery">
							<ul class="content-contacts__gallery">
							  <li data-trigger="slider" class="content-contacts__gallery-item popup-trigger"><img src="styles/images/gallery_item.jpg" width="138" height="106" alt=""></li>
							  <li data-trigger="slider" class="content-contacts__gallery-item popup-trigger"><img src="styles/images/gallery_item.jpg" width="138" height="106" alt=""></li>
							  <li data-trigger="slider" class="content-contacts__gallery-item popup-trigger"><img src="styles/images/gallery_item.jpg" width="138" height="106" alt=""></li>
							  <li data-trigger="slider" class="content-contacts__gallery-item popup-trigger"><img src="styles/images/gallery_item.jpg" width="138" height="106" alt=""></li>
							  <li data-trigger="slider" class="content-contacts__gallery-item popup-trigger"><img src="styles/images/gallery_item.jpg" width="138" height="106" alt=""></li>
							</ul>
						  </div>
						 */?>
					  <div class="content-contacts__description contacts-description">
						<span class="contacts-description__close"></span>
						<strong class="contacts-description__title"><?=$aOffice["NAME"]?></strong>
						<div class="contacts-description__row">
						  <span class="contacts-description__subtitle">Адрес:</span>
						  <span class="contacts-description__text"><?=$aOffice["PROPERTY_12"]?></span>
						</div>
						<div class="contacts-description__row">
						  <span class="contacts-description__subtitle">Время работы:</span>
						  <span class="contacts-description__text"><?=$aOffice["PROPERTY_29"]?></span>
						</div>
						<div class="contacts-description__row">
						  <span class="contacts-description__subtitle">Телефон</span>
						  <span class="contacts-description__text"><?=$aOffice["PROPERTY_13"][0]?></span>
						</div>
						<?/*<a data-trigger="youtube" href="#" class="contacts-description__video popup-trigger">Видео проезда</a>*/?>
					  </div>
					</div>
				<?endforeach;?>
					<div class="content-contacts__requisites">
					  <strong class="contacts-description__title">Общество с ограниченной ответственностью<br><span>«Большой Мастер»</span></strong>
					  <div class="contacts-description__row">
						<span class="contacts-description__subtitle">Юр. адрес:</span>
						<span class="contacts-description__text">111024, г. Москва, 2-я ул. Энтузиастов д. 5, корп.1, этаж. 2, комн. 9</span>
					  </div>
					  <div class="contacts-description__row">
						<span class="contacts-description__subtitle">ИНН:</span>
						<span class="contacts-description__text">7720605468</span>
					  </div>
					  <div class="contacts-description__row">
						<span class="contacts-description__subtitle">КПП:</span>
						<span class="contacts-description__text">772001001</span>
					  </div>
					  <div class="contacts-description__row">
						<span class="contacts-description__subtitle">ОГРН:</span>
						<span class="contacts-description__text">1087746107063</span>
					  </div>
					  <div class="contacts-description__row">
						<span class="contacts-description__subtitle">ОКПО:</span>
						<span class="contacts-description__text">84727931</span>
					  </div>
					  <div class="contacts-description__row">
						<strong class="contacts-description__title">Ген. Директор Шинкевич А. Н.</strong>
					  </div>
					</div>
			   </div>
			</div>
	<input type="hidden" id="MAP_SECTION" value="0">

<script type="text/javascript">
    ymaps.ready(init);
    var myMap;
	var myCollection;

    function init(){  

        myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 10
        });
		
		section = $('#MAP_SECTION').val();

		<? foreach( $arResult['ITEMS'] as $iOfficeInd => $aOffice ): ?>
			
			if ( section == '0' || section == '<?=$aOffice["IBLOCK_SECTION_ID"]?>' ){
			
				myPlacemark<?=$aOffice["ID"]?> = new ymaps.Placemark([<?=$aOffice["PROPERTY_15"]?>], {});
				myPlacemark<?=$aOffice["ID"]?>.options.set('preset', <?=$aOffice["ID"]?>);
				myPlacemark<?=$aOffice["ID"]?>.options.set('coordinate', <?=$aOffice["PROPERTY_15"]?>);
				
				myPlacemark<?=$aOffice["ID"]?>.events.add('click', function(e) {
					var id = myPlacemark<?=$aOffice["ID"]?>.options.get('preset');
					$('.content-contacts__map-wrap').width('65%');
					$('.content-contacts__container').removeClass('active');
					$('#office'+id).addClass('active');
					
					myMap.setCenter( [<?=$aOffice["PROPERTY_15"]?>], 13, {
						checkZoomRange	: true,
						duration 		: 300,
						callback 		: function() {
						  
						}
					});
					
					return false;
				});

				myMap.geoObjects.add(myPlacemark<?=$aOffice["ID"]?>);
			}

		<? endforeach; ?> 
		
    }
	
	  $('.contacts-description__close').click(function() {
		$('.content-contacts__container').removeClass('active');
		$('.content-contacts__map-wrap').width('100%');
		myMap.setCenter( [55.76, 37.64], 10, {
					checkZoomRange	: true,
					duration 		: 300,
					callback 		: function() {
					  
					}
		});

	  });
	  
	  
	    $('.map-trigger').click(function() {
			$('.content-contacts__container').removeClass('active');
			$('.content-contacts__map-wrap').width('100%');
			$(this).parent().find('.map-trigger').removeClass('active');
			$(this).addClass('active');
			$('#MAP_SECTION').val( $(this).data('section') );
			myMap.destroy();
			init();
		});
		
		  $('.requisites-trigger').click(function() {
			if($(this).hasClass('active')) {
			  $(this).toggleClass('active');
			  $('.content-contacts__requisites').removeClass('active');
			  $('.content-contacts__map-wrap').width('100%');
			} else {
			  $(this).toggleClass('active');
			  $('.content-contacts__map-wrap').width('65%');
			  $('.content-contacts__container').removeClass('active');
			  $('.content-contacts__requisites').addClass('active');
			}
		  });	
</script>	
	
