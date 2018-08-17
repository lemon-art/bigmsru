<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>



<script>
function init() {
    var myMap = new ymaps.Map('YMapsID', {
        center: [55.751574, 37.573856],
        zoom: 9,
        type: 'yandex#map',
        behaviors: ['scrollZoom', 'drag']
    }),
    search = new ymaps.control.SearchControl({
        useMapBounds: true,
        noCentering: true,
        noPlacemark: true
    }),
    calculator = new DeliveryCalculator(myMap);

    myMap.controls.add(search, { right: 5, top: 5 });
	myMap.controls.add('zoomControl', { left: 5, top: 5 }).add('typeSelector').add('mapTools', { left: 35, top: -50 });
	
    search.events.add('resultselect', function (e) {
        var results = search.getResultsArray(),
            selected = e.get('resultIndex'),
            point = results[selected].geometry.getCoordinates();
		var myPolygon = new ymaps.geometry.Polygon([[[55.611144,37.491672],[55.581012,37.572181],[55.576052,37.596728],[55.575274,37.688567],[55.59122,37.729079],[55.640671,37.820918],[55.657075,37.839286],[55.687343,37.831046],[55.707702,37.835509],[55.712572,37.838084],[55.731077,37.841002],[55.743862,37.841861],[55.777158,37.843234],[55.814099,37.839114],[55.882762,37.726504],[55.89212,37.706077],[55.895303,37.673633],[55.910155,37.588489],[55.908323,37.544028],[55.907262,37.537505],[55.887297,37.483603],[55.881604,37.445838],[55.87649,37.427642],[55.870989,37.412021],[55.83275,37.395884],[55.789927,37.371852],[55.76574,37.36859],[55.713638,37.38507],[55.701522,37.398631],[55.662048,37.432792],[55.638558,37.458884]]]);
		myPolygon.options.setParent(myMap.options);
		myPolygon.setMap(myMap);
		if(myPolygon.contains(point)) {
			calculator.setStartPointVnutri(point);
		}
		else { calculator.setStartPoint(point); }
    });
}

function DeliveryCalculator(map) {
    this._map = map;
    this._start = null;
  	this._finish = new ymaps.Polygon([[[55.882453,37.726268],[55.829798,37.828943],[55.81387,37.839307],[55.776965,37.843213],[55.76914,37.843599],[55.76715,37.843459],[55.755311,37.842912],[55.743971,37.842462],[55.74139,37.842462],[55.729773,37.840841],[55.718659,37.83949],[55.711842,37.837612],[55.707838,37.835531],[55.686682,37.831336],[55.656874,37.839876],[55.640379,37.820188],[55.617568,37.78268],[55.591371,37.729669],[55.575349,37.688267],[55.572562,37.650265],[55.573428,37.635481],[55.574477,37.61927],[55.575735,37.596535],[55.580792,37.572288],[55.580433,37.573951],[55.611022,37.491532],[55.615649,37.486135],[55.625624,37.474495],[55.631391,37.467703],[55.638783,37.459056],[55.656307,37.437952],[55.662309,37.431869],[55.668779,37.426118],[55.682621,37.416301],[55.701565,37.398492],[55.713535,37.385381],[55.723509,37.380371],[55.764978,37.368783],[55.770155,37.369041],[55.789806,37.372517],[55.808849,37.387924],[55.815522,37.389866],[55.821097,37.391293],[55.825213,37.392773],[55.830515,37.394436],[55.832786,37.395166],[55.83278,37.39331],[55.834024,37.395369],[55.849635,37.392194],[55.851759,37.393234],[55.858633,37.397022],[55.865276,37.402386],[55.873396,37.417331],[55.876755,37.42791],[55.881888,37.444851],[55.887472,37.482777],[55.908124,37.543781],[55.911056,37.570046],[55.911149,37.581182],[55.910028,37.588767],[55.895786,37.663247],[55.895496,37.673203],[55.891982,37.707107]]], { hintContent: "<?=GetMessage("HINT_CONTENT")?>"}, { fillColor: '#00FF0088',strokeWidth: 1,opacity:0});
	this._template = $('#sidebarTemplate').template('sidebarTemplate');
	this._min = 10000000000000;
	this._route = null;
	this._route2 = null;
	this._finish.events.add('click', this._onStartPointChangeVnutri, this);
    map.events.add('click', this._onStartPointChange, this);
	map.geoObjects.add(this._finish);

}

var ptp = DeliveryCalculator.prototype;

ptp._onStartPointChange = function (e) {
   this.setStartPoint(e.get('coordPosition'));
};

ptp._onStartPointChangeVnutri = function (e) {
   this.setStartPointVnutri(e.get('coordPosition'));
};

ptp.setStartPointVnutri = function (position) {
	if(this._route) {
        this._map.geoObjects.remove(this._route);
		this._min = 10000000000000;
    }
	if(this._start) {
        this._start.geometry.setCoordinates(position);
    }
    else {
		this._start = new ymaps.Placemark(position, { iconContent: '<?=GetMessage("HINT")?>' }, { draggable: true });
        this._start.events.add('dragend', this._onStartPointChange, this);
        this._map.geoObjects.add(this._start);
    }
	var results = [],
	total = {
			id: 'mo',
			name: 'moskow',
			duration: 0,
			distance: 0,
			value: 0,
			value2: 250,
			value3: <?=$arParams['COST_DELIVERY_MKAD']?>
	};
	$('#sidebar3').html($.tmpl(this._template, {
			results: total
	}, {
			formatter: ymaps.formatter
	}));
};

ptp.setStartPoint = function (position) {


    if(this._start) {
        this._start.geometry.setCoordinates(position);
    }
    else {
        this._start = new ymaps.Placemark(position, { iconContent: '<?=GetMessage("HINT")?>' }, { draggable: true });
        this._start.events.add('dragend', this._onStartPointChange, this);
        this._map.geoObjects.add(this._start);
    }
	this.getDirections();
};

ptp.getDirections = function () {
    var self = this,
        start = this._start.geometry.getCoordinates(),
		finish = this._finish.geometry.getClosest(start).position;
		
		var myGeocoder = ymaps.geocode(start, {kind: 'house'});
		myGeocoder.then(
            function (res) {
                var street = res.geoObjects.get(0);
                var name = street.properties.get('name');
                $('#street1').val(name).change();
				$('#street').val('').change();
            }
        );
		
    
	if(this._route) {
        this._map.geoObjects.remove(this._route);
		this._min = 10000000000000;
    }
	
	
	var coord=this._finish.geometry.getCoordinates()[0].join(';');
	var coord_ar = coord.split(";");
	

	
	for (var i = 0; i < coord_ar.length; i++) {
		ymaps.route([coord_ar[i],start])
                .then(function (router) {
				var distance = Math.round(router.getLength());
				if(distance<self._min) {
					if(self._route) {
						self._map.geoObjects.remove(self._route);
					}
					self._route = router.getPaths();
					self._route.options.set({ strokeWidth: 2, strokeColor: '#ff0000', opacity: 1 });
					var distance = router.getLength();
					if(distance<=<?=($arParams['MAX_DISTANCE']*1000)?>) {
						self._map.geoObjects.add(self._route);
					}
					self._min = Math.round(router.getLength());
					//////////////////// вычисляем тариф ///////////////////////
					var ret_val=0;
					var ret_val2=0;
					var ret_val3=0;
					var dost_val=0;
					if(distance==0) {
						ret_val=0;
						ret_val2=250;
						ret_val3=<?=$arParams['COST_DELIVERY_MKAD']?>;
					}
					else if (distance>0 && distance<<?=($arParams['MAX_DISTANCE']*1000)?>) {
						ret_val = <?=$arParams['ADDITIONAL_TARIF']?> + parseInt((Math.round(distance/1000))*<?=$arParams['COST_BY_KM']?>);
						ret_val2= parseInt((Math.round(distance/1000))*<?=$arParams['COST_BY_KM']?>);
						ret_val3 = 0;
					}
					else if (distance>=<?=($arParams['MAX_DISTANCE']*1000)?>) {
						ret_val=0;
						ret_val2=0;
						ret_val3=1;
						dost_val=1;
					}
					/////////////////// конец вычисления тарифа ////////////////
					var results = [],
					total = {
						id: 'mo',
						name: 'mo',
						duration: 0,
						distance: Math.round(router.getLength() / 1000),
						value: ret_val,
						value2: ret_val2,
						value3: ret_val3,
						nodost: dost_val
					};
					
					
					
					$('#sidebar3').html($.tmpl(self._template, {
							results: total
					}, {
							formatter: ymaps.formatter
					}));
					
					$('#DELIVERY_PRICE').val( total.value );

					
				}
		});
	}
	
	
	
};

ptp.calculate = function (len) {
    var DELIVERY_TARIF = 20,
        MINIMUM_COST = 500;

    return Math.max(len * DELIVERY_TARIF, MINIMUM_COST);
};

ymaps.ready(init);
</script>
<?
$this->IncludeComponentTemplate();
?>