$(document).ready(function () {


var kontakt_a_i = $(".kontakt_a_i");
$.ajax({
	url: '/ajax/dostavka_shops.php',
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