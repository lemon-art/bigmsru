$(document).ready(function () {


var kontakt_a_i = $(".kontakt_a_i");
$.ajax({
	url: '/ajax/catalog_main_header.php?type=i',
	type: 'POST',
	cache: false,
	dataType: 'html',
	processData: false, // �� ������������ ����� (Don't process the files)
	contentType: false, // ��� jQuery ������ ������� ��� ��� ��������� ������
	success: function( respond, textStatus, jqXHR ){
		kontakt_a_i.html(respond);
		
		//catalog_active_open_map_ss($(".selectesem").find(".active").data("val"));
		$(".cat1 .flexslider_map").flexslider({
			animation: "slide",
			animationLoop: false,
			itemWidth: 117,
			itemMargin: 8,
			minItems: 4,
			maxItems: 4,
			controlNav: false,
			move: 1,
			prevText: "",
			nextText: "",
			start: function (slider) {
				$('body').removeClass('loading');
			}
		});
		
	},
	error: function( jqXHR, textStatus, errorThrown ){
	}
});
  
var kontakt_a_b = $(".kontakt_a_b");
var flexslider_mapcat2 = $(".cat2 .flexslider_map");
$.ajax({
	url: '/ajax/catalog_main_header.php?type=b',
	type: 'POST',
	cache: false,
	dataType: 'html',
	processData: false, // �� ������������ ����� (Don't process the files)
	contentType: false, // ��� jQuery ������ ������� ��� ��� ��������� ������
	success: function( respond, textStatus, jqXHR ){
		kontakt_a_b.html(respond);
		catalog_active_open_map_ss($(".selectesem").find(".active").data("val"));
		/*$(".cat2 .flexslider_map").flexslider({
			animation: "slide",
			animationLoop: false,
			itemWidth: 117,
			itemMargin: 8,
			minItems: 4,
			maxItems: 4,
			controlNav: false,
			move: 1,
			prevText: "",
			nextText: "",
			start: function (slider) {
				$('body').removeClass('loading');
			}
		});*/
	},
	error: function( jqXHR, textStatus, errorThrown ){
	}
});
var kontakt_a_r = $(".kontakt_a_r");
var flexslider_mapcat3 = $(".cat3 .flexslider_map");
$.ajax({
	url: '/ajax/catalog_main_header.php?type=r',
	type: 'POST',
	cache: false,
	dataType: 'html',
	processData: false, // �� ������������ ����� (Don't process the files)
	contentType: false, // ��� jQuery ������ ������� ��� ��� ��������� ������
	success: function( respond, textStatus, jqXHR ){
		
		kontakt_a_r.html(respond);
		catalog_active_open_map_ss($(".selectesem").find(".active").data("val"));

	},
	error: function( jqXHR, textStatus, errorThrown ){
	}
});

function catalog_active_open_map_ss(val) {
    $('.cat1, .cat2,.cat3').fadeOut(0);
    $('.' + val).fadeIn(350);

    $('.' + val + " .flexslider_map").flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 117,
        itemMargin: 8,
        minItems: 4,
        maxItems: 4,
        controlNav: false,
        move: 1,
        prevText: "",
        nextText: "",
        start: function (slider) {
            $('body').removeClass('loading');
        }
    });
}
});