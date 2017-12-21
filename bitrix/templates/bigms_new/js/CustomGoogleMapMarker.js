function CustomMarker(latlng, map, args) {
	this.latlng = latlng;
	this.args = args;
	this.setMap(map);
}

CustomMarker.prototype = new google.maps.OverlayView();

CustomMarker.prototype.draw = function() {

	var self = this;

	var div = this.div;

	if (!div) {

		div = this.div = document.createElement('div');
		div.className = 'bigms-marker';
		div.innerHTML = '<svg class="bigms-marker__svg" style="fill:'+ this.args.color +'">'+
											'<use xlink:href="#icon-marker"></use>'+
										'</svg>';
		div.style.position = 'absolute';
		div.style.cursor = 'pointer';
		div.style.width = '47px';
		div.style.height = '64px';
		div.style.zIndex = '1';

		if (typeof(self.args.marker_id) !== 'undefined') {
			div.dataset.marker_id = self.args.marker_id;
		}

		google.maps.event.addDomListener(div, "click", function(event) {3
			$('.bigms-marker__svg').removeClass('active');
			$(this).find('.bigms-marker__svg').addClass('active');
			google.maps.event.trigger(self, "click");
		});

		var panes = this.getPanes();
		panes.overlayImage.appendChild(div);
	}

	var point = this.getProjection().fromLatLngToDivPixel(this.latlng);

	if (point) {
		div.style.left = (point.x - 25) + 'px';
		div.style.top = (point.y - 55) + 'px';
	}
};

CustomMarker.prototype.remove = function() {
	if (this.div) {
		this.div.parentNode.removeChild(this.div);
		this.div = null;
	}
};

CustomMarker.prototype.getPosition = function() {
	return this.latlng;
};
