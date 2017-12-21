$(document).ready(function () {

var click = '';
// Табы и карусели на главной
function run_tabs_flexslider(selecters, kol, is_karusel) {
    var tabContainers = $(selecters + ' .tab_content'); // получаем массив контейнеров
    tabContainers.hide().filter(':first').show(); // прячем все, кроме первого
    // далее обрабатывается клик по вкладке
    $(selecters + ' ul.tabNavigation a').click(function () {
        tabContainers.hide(); // прячем все табы
        tabContainers.filter(this.hash).show(); // показываем содержимое текущего
        $(selecters + ' ul.tabNavigation a').removeClass('selected'); // у всех убираем класс 'selected'
        $(this).addClass('selected'); // текушей вкладке добавляем класс 'selected'

        if (is_karusel == 1) {
            $($(this).attr('href')).flexslider({
                animation: "slide",
                animationLoop: false,
                itemWidth: 235,
                itemMargin: 0,
                minItems: kol,
                maxItems: kol,
                controlNav: false,
                move: 1,
                prevText: "",
                nextText: "",
                start: function (slider) {
                    $('body').removeClass('loading');
                }
            });
        }

        if (location.pathname != "/" && click == 1) {
            elementClick = $(this).attr("href");
            destination = $(elementClick).offset().top;
            $('html').animate({scrollTop: destination}, 300);
        }
        click = 1
        return false;
    }).filter(':first').click();
}
var carusel_brend = $(".carusel_brend");
$.ajax({
	url: '/ajax/brands.php',
	type: 'POST',
	cache: false,
	dataType: 'html',
	processData: false, // �� ������������ ����� (Don't process the files)
	contentType: false, // ��� jQuery ������ ������� ��� ��� ��������� ������
	success: function( respond, textStatus, jqXHR ){
		carusel_brend.html(respond);
		run_tabs_flexslider(".carusel_brend", 6, 1);
	},
	error: function( jqXHR, textStatus, errorThrown ){
	}
});

var tab_tab1_cat1 = $(".tab_tab1_cat1");
$.ajax({
	url: '/ajax/catalog_main.php?type=i',
	type: 'POST',
	cache: false,
	dataType: 'html',
	processData: false, // �� ������������ ����� (Don't process the files)
	contentType: false, // ��� jQuery ������ ������� ��� ��� ��������� ������
	success: function( respond, textStatus, jqXHR ){
		tab_tab1_cat1.html(respond);
	},
	error: function( jqXHR, textStatus, errorThrown ){
	}
});

var tab_tab2_cat2 = $(".tab_tab2_cat2");
$.ajax({
	url: '/ajax/catalog_main.php?type=b',
	type: 'POST',
	cache: false,
	dataType: 'html',
	processData: false, // �� ������������ ����� (Don't process the files)
	contentType: false, // ��� jQuery ������ ������� ��� ��� ��������� ������
	success: function( respond, textStatus, jqXHR ){
	
		tab_tab2_cat2.html(respond);
	},
	error: function( jqXHR, textStatus, errorThrown ){
	}
});
});