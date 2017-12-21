$(document).ready(function () {
//умный фильтр
    $('.filter_list .close-white').click(function(e) {
        e.preventDefault();
        if ($('.filter_list li').length == 1) {
            filterReset();
            return false;
        }
        if ($(this).hasClass('price') || $(this).hasClass('range')) {
            var newLink = deleteFilterForRange($(this).data('param'));
            location.href = newLink;
        } else {
            var newLink = deleteFilterUrl($(this).data('param') ,$(this).data('url'));
            newLink += newLink + '#downtofilter';
            location.href = newLink;
        }
    });
    /* flexslider
     ---------------------------*/
    // Слайдер на Главной
    $('.flexslider_main').flexslider({
        animation: "slide",
        prevText: "",
        nextText: "",
        controlNav: false,
        start: function (slider) {
            $('body').removeClass('loading');
        }
    });

    //ненужного выделения родителя при клике
    $('.flex-control-thumbs li img, .slides img, .flexslider_carousel .slides img').bind('mousedown.resetClick', function (e) {
        e.preventDefault();
    });

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

    $(".flexslider_run").flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 250,
        itemMargin: 0,
        minItems: 5,
        maxItems: 5,
        controlNav: false,
        move: 1,
        prevText: "",
        nextText: "",
        start: function (slider) {
            $('body').removeClass('loading');
        }
    });

    /* fancybox
     ---------------------------*/
    $(".modalbox").fancybox({
        openEffect: 'none',
        closeEffect: 'none',
        scrolling: 'no',
        fitToView: false,
        padding: [25, 25, 25, 25],
        wrapCSS: 'not_radius',
        minWidth: 230,
        helpers: {
            overlay: {
                locked: false
            }
        }
    });
    $(".modalbox_map").fancybox({
        openEffect: 'none',
        closeEffect: 'none',
        scrolling: 'no',
        fitToView: false,
        padding: [0, 0, 0, 0],
        wrapCSS: 'not_radius',
        minWidth: 230,
        helpers: {
            overlay: {
                locked: false
            }
        }
    });
    $(".fancybox").fancybox({
        openEffect: 'none',
        closeEffect: 'none',
        scrolling: 'no',
        padding: [0, 0, 0, 0],
        minWidth: 230,
        helpers: {
            overlay: {
                locked: false
            }
        }
    });


    /* Разбиваем меню на колонки
     ---------------------------*/
    if ($(window).width() < 1024) {
        set_column(2);
    }
    else {
        set_column(3);
    }


    // Показываем первые 2 раздела каталога на главной странице
    // Ховеры
    $('.catalogs_block .catalogs').hover(function () {
        $(this).find('.pop_menu').eq(0).stop().fadeToggle(0);
        // фон
        $('.fade').fadeToggle(0);

    }, function () {
        $(this).find('.pop_menu').eq(0).stop().fadeToggle(0);
        // фон
        $('.fade').fadeToggle(0);
    });

    if (location.pathname == "/" || location.pathname == "/index.php") {
        $('.catalog_link .catalogs_block').css('display', 'block');
    }
    else {
        $('.catalog_link').mouseover(function () {
            $('.catalogs_block').stop().slideToggle(0);
        })
        $('.catalog_link').mouseout(function () {
            $('.catalogs_block').stop().slideToggle(0);
        });
    }

    // раскрываем список подразделов по клику
    var h_container, h_pop_menu;
    $(".pop_menu > li.parent span, .pop_menu > div > li.parent span").click(function () {
        $(this).parent().find('ul').slideToggle(300,
            function () {
                if ($(this).parent().hasClass("open")) {
                    $(this).parent().removeClass('open');
                }
                else {
                    $(this).parent().addClass('open');
                }

                h_container = $(".container").innerHeight();
                h_pop_menu = $(".pop_menu").innerHeight();
                if (h_container < h_pop_menu) {
                    $(".container").stop().animate({height: h_pop_menu + "px"}, 100);
                }
            }
        );
        return false;
    })


    /* Поле поиска
     ---------------------------*/
    setHeighWtidth();
    $(window).resize(setHeighWtidth);

   /* get_current_iblock($(".radio_block input[type='radio']:checked"));
    $(".radio_block input[type='radio']").change(function () {
        get_current_iblock($(this));
    });*/


    /* Загрузка страниц "второе меню"
     ---------------------------*/
    $('.nav_searcg_block nav ul li').on('click', function (e) {
        e.preventDefault();
        var link = $(this).data('link');
        window.location.href = link;
    });


    /* AJAX загрузка разделов каталога на главной странице
     ---------------------------*/
   /*$.ajax({
        url: "/include/main_catalog_section_list1.php",
        cache: false,
        success: function (html) {
            $(".sections_block_main .tab.tab1.cat1").html(html);
        }
    });
    $.ajax({
        url: "/include/main_catalog_section_list2.php",
        cache: false,
        success: function (html) {
            $(".sections_block_main .tab.tab2.cat2").html(html);
        }
    });*/

	/*var client = new XMLHttpRequest();
	client.open("GET", "http://www.bigms.ru/include/main_catalog_section_list1.php")
	client.onreadystatechange = function() { $(".sections_block_main .tab.tab1.cat1").html(client.responseText); }
	client.send();

	var client2 = new XMLHttpRequest();
	client2.open("GET", "http://www.bigms.ru/include/main_catalog_section_list2.php")
	client2.onreadystatechange = function() { $(".sections_block_main .tab.tab2.cat2").html(client.responseText); }
	client2.send();*/







    /* Стилизация элементов формы
     ---------------------------*/
    setTimeout(function () {
        $('.select:not(".no_style")').styler();
    }, 100)

    $(".selectesem .item").on("click", function () {
        $(this).addClass("active").siblings().removeClass("active");
    });


    /* Каталог, сортировка
     ---------------------------*/
    $(".sort_filter a").click(function () {
        if ($(this).hasClass("desc")) {
            $(this).removeClass("desc").addClass("asc");
        }
        else {
            $(this).removeClass("asc").addClass("desc");
        }
        if (!$(this).is(".current")) {
            $(this).addClass("current").siblings().removeClass("current");
        }
    });
    $(".sort_display a:not(.current)").click(function () {
        $(this).addClass("current").siblings().removeClass("current");
    });

    setTimeout(function () {
        if (!$(".sort_filter a.current")) {
            $(".sort_filter a:first").addClass('current');
        }
    }, 1000);


    // Перенес c гита

    // 4.2.3
    /*{
        //Удаляет продукт из избранного

        function deleteFavoriteProduct(product_id) {

            $.ajax({
                method: "post",
                url: "/include/delay_del.php",
                data: "id=" + product_id + "&del=1"
            });

        }

        function deleteCompareProduct(product_id) {

            $.ajax({
                method: "get",
                url: "/catalog/inzhenernaya/compare/",
                data: "ID=" + product_id + "&action=DELETE_FROM_COMPARE_RESULT"
            });

        }

        function addCompareList(product_id) {

            $.ajax({
                method: "get",
                url: "/catalog/inzhenernaya/compare/",
                data: "id=" + product_id + "&action=ADD_TO_COMPARE_LIST&ajax_action=Y"
            });

        }
    }// 4.2.3



     // 4.2.3
     {

        $('.catalog_block').on('click', 'a.compare_button', function(){
            $(this).addClass('active');
            addCompareList($(this).attr("data-id"));
            $(this).replaceWith("<p class='compare_button active' data-id='" + $(this).attr("data-id") + "' bxid='" + $(this).attr("id") + "' data-text='Убрать из сравнения'></p>");
            setTimeout(function() {
                $(".fancybox-close").trigger('click');
                $("a.popup-window-close-icon.popup-window-titlebar-close-icon").trigger('click');
            }, 3000);
        });
     }// 4.2.3



    $('.catalog_block a.share_button').click(function () {
        $(this).addClass('active');
        $(this).removeAttr('onclick');
        $(this).replaceWith("<p class='share_button active' data-text='В избранном'></p>");
    });


    // 4.2.3
    {

        $('.catalog_detail, .catalog_list').on('click', 'a.compare_button', function(){
            $(this).addClass('active');
            addCompareList($(this).attr("data-id"));
            $(this).replaceWith("<p class='compare_button active' title='Убрать из сравнения' data-id='" + $(this).attr("data-id") + "' bxid='" + $(this).attr("id") + "'><span>В сравнении</span></p>");
            setTimeout(function() {
                $(".fancybox-close").trigger('click');
                $("a.popup-window-close-icon.popup-window-titlebar-close-icon").trigger('click');
            }, 3000);
        });
    }// 4.2.3


    $('.catalog_detail a.share_button, .catalog_list a.share_button').click(function () {
        $(this).addClass('active');
        $(this).removeAttr('onclick');
        $(this).replaceWith("<p class='share_button active'><span>В избранном</span></p>");
    });




    // 4.2.3
    {

        $('.catalog_block').on('click', 'p.compare_button.active', function(){
            $(this).replaceWith('<a data-text="В сравнение" href="javascript:void(0)" data-id="' + $(this).attr("data-id") + '" class="bx_bt_button_type_2 bx_medium compare_button" id="' + $(this).attr("bxid") + '"></a>');
            deleteCompareProduct($(this).attr("data-id"));
        });

        $('.catalog_detail, .catalog_list').on('click', 'p.compare_button.active', function(){
            $(this).replaceWith('<a title="В сравнение" href="javascript:void(0)" data-id="' + $(this).attr("data-id") + '" class="bx_bt_button_type_2 bx_medium compare_button" id="' + $(this).attr("bxid") + '"><span>В сравнение</span></a>');
            deleteCompareProduct($(this).attr("data-id"));
        });
    }// 4.2.3
    */

    $(document).on('click', 'a.compare_button, a.buy_button', function(){
        $('#favor').fadeOut();
    });

    $(document).on('click', 'a.share_button', function(){
        setTimeout(function() {
            $(".b-popup__wrap .b-popup__wrap .popup__close, .b-popup__wrap .b-popup-add-cart__img .popup__close").trigger('click');
        }, 1);
    });

    $('.catalog_block').on('click', 'a.share_button', function(){
        $(this).addClass('active');
        add2delay_noClick($(this).attr("data-id"),$("input[name=CAT_PRICE_ID" + $(this).attr("data-id")).val(),$("input[name=CAT_PRICE" + $(this).attr("data-id")).val(), $("input[name=ELEM_NAME" + $(this).attr("data-id")).val(), $("input[name=DETAIL_PAGE" + $(this).attr("data-id")).val());
        $(this).replaceWith("<p class='share_button active' data-id='" + $(this).attr("data-id") + "' bxid='" + $(this).attr("id") + "' bxclick='" + $(this).attr("onclick") + "' data-text='Убрать из избранного'></p>");

        var name = $("input[name=ELEM_NAME" + $(this).attr("data-id")).val();
        var detailPage = $("input[name=DETAIL_PAGE" + $(this).attr("data-id")).val();
        var price = $("input[name=CAT_PRICE" + $(this).attr("data-id")).val();
        var picture = $("input[name=PICTURE" + $(this).attr("data-id")).val();
        var sharePopup = $('#favor');

        $('#favor .b-popup__img.b-popup-favourites__img img').remove();
        $('#favor .b-popup__img.b-popup-favourites__img').append('<img src="' + picture + '" alt=""/>');
        $('#ok_name').text(name);
        $('#ok_price').text(price + ' руб.');

        $(sharePopup).fadeIn();
        showCountFavoritesInPopup();

        $('#favor .popup__close').click(function() {
            closePopup();
        });

        setTimeout(function() {
            closePopup();
        }, 30000);

        function closePopup() {
            $(sharePopup).fadeOut();
        }
    });

    $('.catalog_table').on('click', 'a.share_button', function(){
        $(this).addClass('active');
        add2delay_noClick($(this).attr("data-id"),$("input[name=CAT_PRICE_ID" + $(this).attr("data-id")).val(),$("input[name=CAT_PRICE" + $(this).attr("data-id")).val(), $("input[name=ELEM_NAME" + $(this).attr("data-id")).val(), $("input[name=DETAIL_PAGE" + $(this).attr("data-id")).val());

        var name = $("input[name=ELEM_NAME" + $(this).attr("data-id")).val();
        var detailPage = $("input[name=DETAIL_PAGE" + $(this).attr("data-id")).val();
        var price = $("input[name=CAT_PRICE" + $(this).attr("data-id")).val();
        var picture = $("input[name=PICTURE" + $(this).attr("data-id")).val();
        var sharePopup = $('#favor');

        $('#favor .b-popup__img.b-popup-favourites__img img').remove();
        $('#favor .b-popup__img.b-popup-favourites__img').append('<img src="' + picture + '" alt=""/>');
        $('#ok_name').text(name);
        $('#ok_price').text(price + ' руб.');

        $(sharePopup).fadeIn();
        showCountFavoritesInPopup();

        $('#favor .popup__close').click(function() {
            closePopup();
        });

        setTimeout(function() {
            closePopup();
        }, 30000);

        function closePopup() {
            $(sharePopup).fadeOut();
        }
    });

    $('.catalog_detail').on('click', 'a.share_button', function(){
        $(this).addClass('active');
        add2delay_noClick($(this).attr("data-id"),$("input[name=CAT_PRICE_ID" + $(this).attr("data-id")).val(),$("input[name=CAT_PRICE" + $(this).attr("data-id")).val(), $("input[name=ELEM_NAME" + $(this).attr("data-id")).val(), $("input[name=DETAIL_PAGE" + $(this).attr("data-id")).val());

        var name = $("input[name=ELEM_NAME" + $(this).attr("data-id")).val();
        var detailPage = $("input[name=DETAIL_PAGE" + $(this).attr("data-id")).val();
        var price = $("input[name=CAT_PRICE" + $(this).attr("data-id")).val();
        var picture = $("input[name=PICTURE" + $(this).attr("data-id")).val();
        var sharePopup = $('#favor');

        $('#favor .b-popup__img.b-popup-favourites__img img').remove();
        $('#favor .b-popup__img.b-popup-favourites__img').append('<img src="' + picture + '" alt=""/>');
        $('#ok_name').text(name);
        $('#ok_price').text(price + ' руб.');

        $(sharePopup).fadeIn();
        showCountFavoritesInPopup();

        $('#favor .popup__close').click(function() {
            closePopup();
        });

        setTimeout(function() {
            closePopup();
        }, 30000);

        function closePopup() {
            $(sharePopup).fadeOut();
        }
    });

    $('.catalog_list, .catalog_detail').on('click', 'a.share_button', function(){
        $(this).addClass('active');
        add2delay_noClick($(this).attr("data-id"),$("input[name=CAT_PRICE_ID" + $(this).attr("data-id")).val(),$("input[name=CAT_PRICE" + $(this).attr("data-id")).val(), $("input[name=ELEM_NAME" + $(this).attr("data-id")).val(), $("input[name=DETAIL_PAGE" + $(this).attr("data-id")).val());
        $(this).replaceWith("<p title='Убрать из избранного' class='share_button active' data-id='" + $(this).attr("data-id") + "' bxid='" + $(this).attr("id") + "' bxclick='" + $(this).attr("onclick") + "'><span>В избранном</span></p>");
        setTimeout(function() {
            $(".fancybox-close").trigger('click');
            $("a.popup-window-close-icon.popup-window-titlebar-close-icon").trigger('click');
        }, 3000);
    });

   setTimeout(function () {
        var items = $('.share_button.active');
        $(items).each(function() {
            $(this).attr('data-text', 'Убрать из избранного');
        });

        var items = $('.compare_button.active');
        $(items).each(function() {
            $(this).attr('data-text', 'Убрать из сравнения');
        });
    });

   $('.catalog_block').on('click', 'a.compare_button', function(){
        $(this).addClass('active');
		var str = document.location.href;
		if(str.indexOf('bytovaya') + 1) {
			var section = 'bytovaya';
		}else if(str.indexOf('inzhenernaya') + 1){
			var section = 'inzhenernaya';
		}

        addCompareList($(this).attr("data-id"), section);
        $(this).replaceWith("<p class='compare_button active' data-id='" + $(this).attr("data-id") + "' bxid='" + $(this).attr("id") + "' data-text='Убрать из сравнения'></p>");
        setTimeout(function() {
            $(".fancybox-close").trigger('click');
            $("a.popup-window-close-icon.popup-window-titlebar-close-icon").trigger('click');
        }, 3000);
    });


    /*$('.catalog_block').on('click', 'a.share_button', function(){
        $(this).addClass('active');
        add2delay($(this).attr("data-id"),$("input[name=CAT_PRICE_ID" + $(this).attr("data-id")).val(),$("input[name=CAT_PRICE" + $(this).attr("data-id")).val(), $("input[name=ELEM_NAME" + $(this).attr("data-id")).val(), $("input[name=DETAIL_PAGE" + $(this).attr("data-id")).val());
        $(this).replaceWith("<p class='share_button active' data-id='" + $(this).attr("data-id") + "' bxid='" + $(this).attr("id") + "' bxclick='" + $(this).attr("onclick") + "' data-text='Убрать из избранного'></p>");
        setTimeout(function() {
            $(".fancybox-close").trigger('click');
            $("a.popup-window-close-icon.popup-window-titlebar-close-icon").trigger('click');
        }, 3000);
    });*/

    $('.catalog_detail, .catalog_list').on('click', 'a.compare_button', function(){
        $(this).addClass('active');

		var str = document.location.href;
		if(str.indexOf('bytovaya') + 1) {
			var section = 'bytovaya';
		}else if(str.indexOf('inzhenernaya') + 1){
			var section = 'inzhenernaya';
		}

        addCompareList($(this).attr("data-id"), section);
        $(this).replaceWith("<p class='compare_button active' title='Убрать из сравнения' data-id='" + $(this).attr("data-id") + "' bxid='" + $(this).attr("id") + "'><span>В сравнении</span></p>");
        setTimeout(function() {
            $(".fancybox-close").trigger('click');
            $("a.popup-window-close-icon.popup-window-titlebar-close-icon").trigger('click');
        }, 3000);
    });

    /*$('.catalog_list, .catalog_detail').on('click', 'a.share_button', function(){
        $(this).addClass('active');
        add2delay($(this).attr("data-id"),$("input[name=CAT_PRICE_ID" + $(this).attr("data-id")).val(),$("input[name=CAT_PRICE" + $(this).attr("data-id")).val(), $("input[name=ELEM_NAME" + $(this).attr("data-id")).val(), $("input[name=DETAIL_PAGE" + $(this).attr("data-id")).val());
        $(this).replaceWith("<p title='Убрать из избранного' class='share_button active' data-id='" + $(this).attr("data-id") + "' bxid='" + $(this).attr("id") + "' bxclick='" + $(this).attr("onclick") + "'><span>В избранном</span></p>");
        setTimeout(function() {
            $(".fancybox-close").trigger('click');
            $("a.popup-window-close-icon.popup-window-titlebar-close-icon").trigger('click');
        }, 3000);
    });*/

    $('.catalog_block').on('click', 'p.compare_button.active', function(){

		var prod_id = $(this).parent().parent(".bx_catalog_item_controls").find(".buy_one_button").attr("data-id");

		var str = document.location.href;
		if(str.indexOf('bytovaya') + 1) {
			var section = 'bytovaya';
		}else if(str.indexOf('inzhenernaya') + 1){
			var section = 'inzhenernaya';
		}

        $(this).replaceWith('<a data-text="В сравнение" href="javascript:void(0)" data-id="' + prod_id + '" class="bx_bt_button_type_2 bx_medium compare_button" id="' + $(this).attr("bxid") + '"></a>');

        deleteCompareProduct(prod_id, section);
    });

    $('.catalog_block').on('click', 'p.share_button.active', function(){
		var prod_id = $(this).parent().parent(".bx_catalog_item_controls").find(".buy_one_button").attr("data-id");

		console.log(prod_id);

        $(this).replaceWith('<a data-text="В избранное" href="javascript:void(0)" data-id="' + prod_id + '" class="share_button"></a>');
        deleteFavoriteProduct(prod_id);
    });

	$('.catalog_table').on('click', 'p.compare_button.active', function(){

		var prod_id = $(this).parent().parent().parent(".item").find(".buy_one_button_table").attr("data-id");
		console.log(prod_id);
		var str = document.location.href;
		if(str.indexOf('bytovaya') + 1) {
			var section = 'bytovaya';
		}else if(str.indexOf('inzhenernaya') + 1){
			var section = 'inzhenernaya';
		}

        $(this).replaceWith('<a data-text="В сравнение" href="javascript:void(0)" data-id="' + prod_id + '" class="bx_bt_button_type_2 bx_medium compare_button" id="' + $(this).attr("bxid") + '"><span>В сравнение</span></a>');



        deleteCompareProduct(prod_id, section);
    });

    $('.catalog_table').on('click', 'p.share_button.active', function(){
		var prod_id = $(this).parent().parent().parent(".item").find(".buy_one_button_table").attr("data-id");
	console.log(prod_id);
        $(this).replaceWith('<a data-text="В избранное" href="javascript:void(0)" data-id="' + prod_id + '" class="share_button"><span>В избранное</span></a>');
        deleteFavoriteProduct(prod_id);
    });

    $('.catalog_detail').on('click', 'p.compare_button.active', function(){

		var prod_id = $(this).parent().parent().parent().parent(".catalog_detail").find(".buy_one_button").attr("data-id");

		var str = document.location.href;
		if(str.indexOf('bytovaya') + 1) {
			var section = 'bytovaya';
		}else if(str.indexOf('inzhenernaya') + 1){
			var section = 'inzhenernaya';
		}

        $(this).replaceWith('<a title="В сравнение" href="javascript:void(0)" data-id="' + prod_id + '" class="bx_bt_button_type_2 bx_medium compare_button" id="' + $(this).attr("bxid") + '"><span>В сравнение</span></a>');
        deleteCompareProduct(prod_id, section);
    });

    $('.catalog_detail').on('click', 'p.share_button.active', function(){

		var prod_id = $(this).parent().parent().parent().parent(".catalog_detail").find(".buy_one_button").attr("data-id");

		console.log(prod_id);


        $(this).replaceWith('<a title="В избранное"  href="javascript:void(0)" data-id="' + prod_id + '" class="share_button"><span>В избранное</span></a>');
        deleteFavoriteProduct(prod_id);
    });

    function deleteFavoriteProduct(product_id) {

        $.ajax({
            method: "post",
            url: "/include/delay_del.php",
            data: "id=" + product_id + "&del=1"
        });

    }

    function deleteCompareProduct(product_id, section) {
        if (section === undefined){
            $.ajax({
                method: "get",
                url: "/catalog/bytovaya/compare/",
                data: "ID=" + product_id + "&action=DELETE_FROM_COMPARE_RESULT"
            });
            $.ajax({
                method: "get",
                url: "/catalog/inzhenernaya/compare/",
                data: "ID=" + product_id + "&action=DELETE_FROM_COMPARE_RESULT"
            });
        } else {
            $.ajax({
                method: "get",
                url: "/catalog/"+section+"/compare/",
                data: "ID=" + product_id + "&action=DELETE_FROM_COMPARE_RESULT"
            });
        }


    }

    function addCompareList(product_id, section) {

        $.ajax({
            method: "get",
            url: "/catalog/"+section+"/compare/",
            data: "id=" + product_id + "&action=ADD_TO_COMPARE_LIST&ajax_action=Y"
        });

    }

    function showCountFavoritesInPopup(){
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/ajax/count_favorites.php', true);
        xhr.send();
        xhr.onreadystatechange = function(){
            if (xhr.status == 200) {
                var countItems = parseInt(xhr.responseText, 10);
                document.getElementById('count_items_in_popup').innerHTML = 'В избранном <span>'+countItems+'</span> '+declOfNum(countItems)+'';
            }
        }
    }


    /* Каталог (в сравнение, в закладки) делаем не кликабельным
     ---------------------------*/
    // $('.catalog_block a.compare_button').click(function () {
    //     $(this).addClass('active');
    //     $(this).removeAttr('onclick');
    //     $(this).replaceWith("<p class='compare_button active' data-text='В сравнении'></p>");
    // });
    // $('.catalog_block a.share_button').click(function () {
    //     $(this).addClass('active');
    //     $(this).removeAttr('onclick');
    //     $(this).replaceWith("<p class='share_button active' data-text='В закладках'></p>");
    // });

    // $('.catalog_detail a.compare_button, .catalog_list a.compare_button').click(function () {
    //     $(this).addClass('active');
    //     $(this).removeAttr('onclick');
    //     $(this).replaceWith("<p class='compare_button active'><span>В сравнении</span></p>");
    // });
    // $('.catalog_detail a.share_button, .catalog_list a.share_button').click(function () {
    //     $(this).addClass('active');
    //     $(this).removeAttr('onclick');
    //     $(this).replaceWith("<p class='share_button active'><span>В избранном</span></p>");
    // });


    /* $('a.compare_button.active').click(function(e){
     e.preventDefault();
     $(this).replaceWith("<p class='compare_button active'><span>В сравнении</span></p>");
     });
     $('a.share_button.active').click(function(e){
     e.preventDefault();
     });

     $('a.compare_button.active').each(function(){
     $(this).removeAttr('onclick');
     $(this).replaceWith("<p class='compare_button active' data-text='В сравнении'></p>");
     });
     $('a.share_button.active').each(function(){
     $(this).removeAttr('onclick');
     $(this).replaceWith("<p class='share_button active'><span>В избранном</span></p>");
     }); */


    //кнопка "Удалить список"
    $('.table_compare .del_all a').click(function(e) {
        e.preventDefault;
        var delHref = $('.table_compare .del_all a').attr('href');

        $.ajax({
            type: "GET",
            url: delHref,
            success: function (html) {
                console.log('success');
                var href = $('#rel_link').data('link');
                document.location.href = href;
            }
        });

        return false;
    });


    /* Табы
     ---------------------------*/
    // Каталог
    run_tabs_flexslider(".carusel_catalog", 5, 1);
    // Бренды
    run_tabs_flexslider(".carusel_brend", 6, 1);
    // Простой таб
    run_tabs_flexslider(".catalog_detail .tabs_block", 6, 0);
    $(".catalog_detail .info_block .tabNavigation .link1 a").click(function () {
        /* elementClick = $(".catalog_detail .tabs_block .title_block li").eq(3).find("a").attr("href");
         destination = $(elementClick).offset().top;
         $('html').animate({scrollTop: destination }, 100); */
        $('body').animate({scrollTop: $(".catalog_detail .tabs_block .title_block li").offset().top}, 1000);
        $(".catalog_detail .tabs_block .title_block li").eq(3).find("a").click();

        return false;
    });
    $(".catalog_detail .info_block .tabNavigation .link2 a").click(function () {
        $('body').animate({scrollTop: $(".catalog_detail .tabs_block .title_block li").offset().top}, 1000);
        $(".catalog_detail .tabs_block .title_block li").eq(2).find("a").click();
        return false;
    });
    $(".catalog_detail .info_block .tabNavigation .link3 a").click(function () {
        $('body').animate({scrollTop: $(".catalog_detail .tabs_block .title_block li").offset().top}, 1000);
        $(".catalog_detail .tabs_block .title_block li").eq(4).find("a").click();
        return false;
    });
    // в карточке аренды
    $(".catalog_detail .info_block .tabNavigation .link33 a").click(function () {
        $(".catalog_detail .tabs_block .title_block li").eq(3).find("a").click();
        return false;
    });

    $(".catalog_detail .tabs_block .title_block li").eq(2).find("a").click(function () {
        $(".flexslider_map").flexslider({
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
    });

    // Все предложения (Карусель) показываем нужную ссылку
    var class_link;
    $(".tabNavigation li a").click(function () {
        class_link = $(this).attr("data-tab");
        $(".carusel_block.tabs.carusel_catalog .link").css("display", "none");
        $(".carusel_block.tabs.carusel_catalog ." + class_link).css("display", "table-cell");
    });


    /* Личные данные
     ---------------------------*/
    if ($('[name="UF_TYPE"]:checked').val() == 2) {
        $(".ur_lico").show();
    }
    else {
        $(".ur_lico input").removeAttr("required");
    }

    $('[name="UF_TYPE"]').change(function () {
        if ($(this).val() == 2 && $(this).is(':checked')) {
            $(".ur_lico").slideDown(300);
            $(".ur_lico input").attr("required", "required");
        }
        else {
            $(".ur_lico").slideUp(300);
            $(".ur_lico input").removeAttr("required");
        }
    });


    /* Удаление из закладок
     ---------------------------*/
    $('.delay_list').on('click', '.del', function () {
        var $this = $(this);
        var id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "/include/delay_del.php",
            data: "id=" + id + "&del=1",
            success: function (html) {
                //$(this).parent().parent().remove();
                $($this).parent().parent().hide(300)
                $("#ok_del .text").text('Товар удален из избранного');
                $(".ok_link_del").trigger('click');
            }
        });

        return false;
    });

    $('.delay_list').on('click', '.del_all', function () {
        $.ajax({
            type: "POST",
            url: "/include/delay_del.php",
            data: "del=all",
            success: function (html) {
                $('.delay_list').html("<p class='asterisk' style='padding:30px;'>Список пуст</p>");
                $("#ok_del .text").text('Товары удалены из избранного');
                $(".ok_link_del").trigger('click');
            }
        });
    });

    $('#ok').on('click', '.next_button', function () {
        $(".fancybox-close").trigger('click');
    });


    /* Каталог, фильтр, Открытие длока с доп. параметрами
     ---------------------------*/
    $(".toggle_dop_property").click(function () {
        $(".toggle_dop_property_block").slideToggle(300);
    });


    /* На главной по клику показываем все блоки
     ---------------------------*/
    $(document).on('click', '.sections_block_main .link_str', function () {
        $(this).prev().find(".hidden_deth0").fadeToggle(300);
        $(this).fadeOut(100);
        return false;
    });

    $(".sections_block_main .all").click(function () {
        $(this).parent().parent().find(".hidden").fadeToggle(300);
        $(this).fadeOut(100);
        return false;
    });


    /* Скролл блоков на странице "Сравнение"
     ---------------------------*/
    $(".right_scroll_1").scroll(function () {
        $(".right_scroll_2").scrollLeft($(".right_scroll_1").scrollLeft());
    });

    /* Одинкаовая высота строк "Сравнение"
     ---------------------------*/
    var h_tr, h_tr2;
    var tr = 0;
    $(".left_no_scroll tr").each(function () {
        h_tr = $(this).height();
        h_tr2 = $(".right_scroll_2 tr").eq(tr).height();


        if (h_tr > h_tr2) {
            $(".right_scroll_2 tr").eq(tr).css('height', h_tr + 'px');
        }
        if (h_tr2 > h_tr) {
            $(this).css('height', h_tr2 + 'px');
        }

        tr++;
    });


    /* Корзина / Оформление заказа
     ---------------------------*/
    $('.content').on('click', '#order_form_content .header', function () {
        $(this).next().slideToggle(300, function () {
            if ($(this).is(":visible")) {
                $(this).prev().addClass("active");
            }
            else {
                $(this).prev().removeClass("active");
            }

            $("#basket_items_list .click_buy").show();
        });
    });

    /* Корзина / Оформление заказа (ФОН)
     ---------------------------*/
    $('.content').on('click', '.order_right .btns_block .btn_open', function () {
        $(".layer, .btns_block").detach();

        $("#order_form_content .header").click();
        $(".bx_order_make .bx_ordercart_order_pay_center, .block_border.comm_block").show(200);

        submitForm();

        return false;
    });


    // Ховеры при наведении на корзину ФОН
    $('.header .basket_block').hover(function () {
        if ($(this).find(".header_cart_detail .item").length) {
            $(".carusel_block .flexslider .flex-prev, .carusel_block .flexslider .flex-next, .buy_with_this .flexslider .flex-prev, .buy_with_this .flexslider .flex-next, .carusel_block .title_block").css("z-index", "99");

            /* 		$(".header .header_cart_detail").stop().fadeToggle(0);
             $('.fade').stop().fadeToggle(0); */
            $(".header .header_cart_detail, .fade").show();
        }
    }, function () {
        $(".carusel_block .flexslider .flex-prev, .carusel_block .flexslider .flex-next, .buy_with_this .flexslider .flex-prev, .buy_with_this .flexslider .flex-next, .carusel_block .title_block").css("z-index", "999");

        /* 		$(".header .header_cart_detail").stop().fadeToggle(0);
         $('.fade').stop().fadeToggle(0); */
        $(this).removeClass("always_show");
        $(".header .header_cart_detail, .fade").hide();
    });


    // Выравнивание по высоте блоков в карточке товара
    var h_block = $(".catalog_detail .img").height();
    $(".catalog_detail .info_block, .catalog_detail > .properties_block").css("height", h_block + "px")


    // Карточка товара, клик на больщой фото
    $(".catalog_detail .vlign .click_first_photo").click(function (event) {
        event.preventDefault();
        $(".catalog_detail .more_photo img").eq(0).click();
    });

    function number_format(number, decimals, dec_point, thousands_sep) {	// Format a number with grouped thousands
        //
        // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
        // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +	 bugfix by: Michael White (http://crestidg.com)

        var i, j, kw, kd, km;

        // input sanitation & defaults
        if (isNaN(decimals = Math.abs(decimals))) {
            decimals = 2;
        }
        if (dec_point == undefined) {
            dec_point = ",";
        }
        if (thousands_sep == undefined) {
            thousands_sep = ".";
        }

        i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

        if ((j = i.length) > 3) {
            j = j % 3;
        } else {
            j = 0;
        }

        km = (j ? i.substr(0, j) + thousands_sep : "");
        kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
        //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
        kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


        return km + kw + kd;
    }

    //карточка товара (увеличение/уменьшение кол-ва товара)
    var priceForOne = $('.info_block .item_buttons.vam .item_current_price').attr('content');

    $('.info_block .item_buttons_counter_block .bx_bt_button_type_2.bx_small.bx_fwb').click(function () {
        var num = $('.tac.transparent_input').val();
        var totalPrice = number_format((priceForOne * num), 2, '.', ' ');
        var id = $('.info_block .item_buttons.vam').data('id');

        $('.info_block .item_buttons.vam .item_current_price').html(totalPrice + ' <span itemprop="priceCurrency" content="RUB"> руб.</span>');

        //$('#bx_cart_block1 .item.' + id + ' .sum').html('<span>' + totalPrice + '</span>  руб.');
        //$('#bx_cart_block1 .item.' + id + ' .sum').data('sum', priceForOne * num);
        //$('#bx_cart_block1 .item.' + id + ' .kol').html(num + ' шт.');
        //$('#bx_cart_block1 .item.' + id + ' .kol').data('kol', num);
        //
        //var allNum = 0;
        //var allSum = 0;
        //var kols = $('.kol');
        //var sums = $('.sum');
        //kols.each(function() {
        //   allNum = allNum + parseInt($(this).data('kol'));
        //});
        //sums.each(function() {
        //    allSum = allSum + parseInt($(this).data('sum'));
        //});
        //$('.header_cart_value').html(allNum + ' товар, ' + number_format(allSum, 2, '.', ' ') + ' руб.');

    });

    //фиксация блока с товарами на странице сравнения
    if ($('.bx_compare.bx_blue .left_no_scroll').length > 0) {
        var breakPoint = $('.bx_compare.bx_blue .left_no_scroll').eq(1).offset().top - $('.bx_compare.bx_blue .left_no_scroll').height() - 50;
        $(window).scroll(function() {
            var currentPosition = $(window).scrollTop();
            if (currentPosition >= breakPoint) {
                var temp = $('.bx_compare.bx_blue .left_no_scroll').height();
                $('.fix').addClass('fixed');
                $('.not_fixed').css('padding-top', temp + 'px');
            } else {
                if ($('.fix').hasClass('fixed')) {
                    $('.fix').removeClass('fixed');
                }
                $('.not_fixed').css('padding-top', '0px');
            }
        });
    }

    // "Читать далее"
    $(".more a").click(function (e) {
        e.preventDefault();

        var text = $(this).attr("title");

        $(this).parent().prev().slideToggle(333, function () {
            if ($(this).is(':visible')) {
                $(this).next().find("a").text("Скрыть");
            }
            else {
                $(this).next().find("a").text(text);
            }
        });
    });


    // Удаление товара из корзины в шапке
    $(document).on("click", ".header_cart_detail .item .del span", function () {
        var deletebasketid = $(this).data('id');
        $this = $(this);
        $.ajax({
            type: "POST",
            url: "/ajax/basket_del.php",
            data: "ajaxdeleteid=" + deletebasketid,
            success: function (html) {
                $this.closest(".basket_block").addClass("always_show");
                $(".header .basket_block").empty().html(html);
                $(".header .header_cart_detail, .fade").hide();
                //check_items_basket();
                return false;
            }
        });

    });


    // Результат в фильтре (всплывающий)
    $(".bx_filter_input_checkbox input:checkbox").change(function () {
        var current_coord = 0;
        var filter_parrent = $(this).closest(".bx_filter_parameters_box");
        var modef_block = filter_parrent.find(".bx_filter_container_modef");

        var this_coord = $(this).offset().top;
        var filter_parrent_coord = filter_parrent.offset().top;

        var current_coord = this_coord - filter_parrent_coord;
        modef_block.addClass('absolute').css({top: current_coord});
        console.log(current_coord);
    });

    //Вкладки статьи/новости на главной
    $('#tab-news').click(function () {
        $('#tabs-news').show();
        //$('#all-news').show();
        $('#tabs-articles').hide();
        //$('#all-articles').hide();
        $('#tab-articles').removeClass('active_tab');
        $('#tab-news').addClass('active_tab');
    });

    $('#tab-articles').click(function () {
        $('#tabs-news').hide();
        //$('#all-news').hide();
        $('#tabs-articles').show();
        //$('#all-articles').show();
        $('#tab-articles').addClass('active_tab');
        $('#tab-news').removeClass('active_tab');
    });

    $('.reset-filter').click(function() {
        filterReset();
    });

    $('a.reset-form').click(function() {
        filterReset();
    });
});


$(function () {
    //Обработчик формы авторизации
    $('#modal-login').on('submit', 'form', function () {

        var form_action = $(this).attr('action');
        var form_backurl = $(this).find('input[name="backurl"]').val();

        $.ajax({
            type: "POST",
            url: '/include/auth.php',
            data: $(this).serialize(),
            timeout: 3000,
            error: function (request, error) {
                if (error == "timeout") {
                    alert('timeout');
                }
                else {
                    alert('Error! Please try again!');
                }
            },
            success: function (data) {
                $('#modal-login .modal-content').html(data);

                $('#modal-login form').attr('action', form_action);
                $('#modal-login input[name=backurl]').val(form_backurl);
            }
        });

        return false;
    });

    //Обработчик формы регистрации
    $('#modal-register').on('submit', 'form', function () {

        var form_action = $(this).attr('action');
        var form_backurl = $(this).find('input[name="backurl"]').val();

        $.ajax({
            type: "POST",
            url: '/include/auth.php',
            data: $(this).serialize(),
            timeout: 3000,
            error: function (request, error) {
                if (error == "timeout") {
                    alert('timeout');
                }
                else {
                    alert('Error! Please try again!');
                }
            },
            success: function (data) {
                $('#modal-register .modal-content').html(data);
                $('#modal-register form').attr('action', form_action);
                $('#modal-register input[name=backurl]').val(form_backurl);
            }
        });

        return false;
    });

    //Обработчик формы восстановления пароля
    $('#modal-forgot-password').on('submit', 'form', function () {

        var form_action = $(this).attr('action');
        var form_backurl = $(this).find('input[name="backurl"]').val();

        $.ajax({
            type: "POST",
            url: '/include/auth.php',
            data: $(this).serialize(),
            timeout: 3000,
            error: function (request, error) {
                if (error == "timeout") {
                    alert('timeout');
                }
                else {
                    alert('Error! Please try again!');
                }
            },
            success: function (data) {
                $('#modal-forgot-password .modal-content').html(data);
                $('#modal-forgot-password form').attr('action', form_action);
                $('#modal-forgot-password input[name=backurl]').val(form_backurl);
            }
        });

        return false;
    });

    $('.buy_button').click(function() {
        $(this).text("В корзине");
        $(this).css("background", "#006db8");
    });

});


function setHeighWtidth() {
    var w_block = $('.nav_searcg_block').innerWidth();
    var w_catalog_link = $('.catalog_link').innerWidth();
    var set_w = w_block - w_catalog_link;

    var old_w = $(".search_block").width();

    $(".search_block .bx_input_text").focus(function () {
        $('.search_block .bx_field').animate({width: (set_w - 70) + "px"}, 800);
        $(".bx_search_container .bx_field .bx_input_text").animate({width: "68%", marginRight: "32%"}, 800);
        $(".radio_block").animate({width: "28%"}, 800);

    });

    $(".container").click(function () {
        $('.search_block .bx_field').stop().animate({width: (old_w - 70) + "px"}, 350);
        $(".bx_search_container .bx_field .bx_input_text").stop().animate({width: "100%", marginRight: "0"}, 350);
        $(".radio_block").stop().animate({width: "0"}, 350)
    });

    $(".pop_menu").css({'width': set_w, "left": w_catalog_link});
}

function set_column(column_ch) {
    $('.pop_menu').each(function () {
        var lngth = $(this).find('.depth1').length;
        var chislo = Math.ceil(lngth / column_ch);

        var i = chislo;
        while (lngth > i) {
            $(this).find('.depth1').eq(i - 1).addClass("columnbreak");
            i += chislo;
        }
    });

    setTimeout(function () {
        $('.pop_menu').columnize({
            columns: column_ch,
            manualBreaks: true
        });
    }, 500);
}

// пагинация в каталоге, по сколько элементовы вводиться на странице
function redirect_str(val) {
    return location.href = val;
}


// Добавить товар в отложенные
function add2delay(p_id, pp_id, p, name, dpu) {
    $.ajax({
        type: "POST",
        url: "/include/delay.php",
        data: "p_id=" + p_id + "&pp_id=" + pp_id + "&p=" + p + "&name=" + name + "&dpu=" + dpu,
        success: function (html) {
            $(".ok_link").trigger('click');
        }
    });
};

function add2delay_noClick(p_id, pp_id, p, name, dpu)
{
    $.ajax({
        type: "POST",
        url: "/include/delay.php",
        data: "p_id=" + p_id + "&pp_id=" + pp_id + "&p=" + p + "&name=" + name + "&dpu=" + dpu,
        success: function(html){
            // $(".ok_link").trigger('click');
        }
    });
};



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

// Новинки и спецпредложения на главной
$(".main_carusel_block").each(function (i) {
    $(this).find(".tab_content_main:not(:first)").hide();
});

$("#first_cat1.tab_content_main, #second_cat1.tab_content_main").flexslider({
    animation: "slide",
    animationLoop: false,
    itemWidth: 235,
    itemMargin: 0,
    minItems: 5,
    maxItems: 5,
    controlNav: false,
    move: 1,
    prevText: "",
    nextText: "",
    start: function (slider) {
        $('body').removeClass('loading');
    }
});

$(".main_carusel_block .selectesem .item").click(function () {
    var carusel_id = $(this).data("val");
    console.log(carusel_id);
    $(this).closest(".title_block").find(".link").addClass("hidden").eq($(this).index()).removeClass("hidden");
    $(this).closest(".main_carusel_block").find(".tab_content_main").hide();
    $("#" + carusel_id).show();
    $("#" + carusel_id).flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 235,
        itemMargin: 0,
        minItems: 5,
        maxItems: 5,
        controlNav: false,
        move: 1,
        prevText: "",
        nextText: "",
        start: function (slider) {
            $('body').removeClass('loading');
        }
    });
});


    $('#del_filter').click(function() {
        $('.bx_filter_section input[checked=checked]').trigger('click');
        $('.bx_filter_section input').removeAttr('value');
        $('.filter').fadeOut();
        filterReset();
    });

   /* function deleteFilterUrl() {

    	var param = param === undefined ? '' : param
    	var item = item === undefined ? '' : item;

        var linkArray = location.pathname.split('/');
        var link = '';
        param = param.toLowerCase();
        if (!isNumeric(item)) {
            item = item.replace(/\s/ig, '+');
        }
        item = encodeURI(item);
        for (var i = 0; i < linkArray.length; i++) {
            if (linkArray[i].indexOf(param) != -1 && linkArray[i].indexOf(item) != -1) {
                linkArray[i] = linkArray[i].replace(item, '');
                linkArray[i] = linkArray[i].replace(/--or-/,'-').replace(/-or-$/,'');
            }
            if (linkArray[i] != '') {
                link = link + '/' + linkArray[i];
            }
        }
        return link + '/';
    }*/

	function deleteFilterUrl(param, item) {

		var param2 = param === undefined ? '' : param
    	var item2 = item === undefined ? '' : item;

		var linkArray = location.pathname.split('/');
		var link = '';
		param2 = param2.toLowerCase();
		if (!isNumeric(item2)) {
			item2 = item2.replace(/\s/ig, '+');
		}
		item2 = encodeURI(item2);
		for (var i = 0; i < linkArray.length; i++) {
			if (linkArray[i].indexOf(param2) != -1 && linkArray[i].indexOf(item2) != -1) {
				linkArray[i] = linkArray[i].replace(item2, '');
				linkArray[i] = linkArray[i].replace(/--or-/,'-').replace(/-or-$/,'');
			}
			if (linkArray[i] != '') {
				link = link + '/' + linkArray[i];
			}
		}
		return link + '/';
	}


    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

    /*function deleteFilterForRange() {

    	var param = param === undefined ? '' : param;

        //console.log(this);
        var linkArray = location.pathname.split('/');
        var link = '';
        param = param.toLowerCase();
        for (var i = 0; i < linkArray.length; i++) {
            if (linkArray[i].indexOf(param) == -1 && linkArray[i] != '') {
                link = link + '/' + linkArray[i];
            }
        }
        return link + '/';
    }*/

	function deleteFilterForRange(param) {

		var param2 = param === undefined ? '' : param;

		var linkArray = location.pathname.split('/');
		var link = '';
		param2 = param2.toLowerCase();
		for (var i = 0; i < linkArray.length; i++) {
			if (linkArray[i].indexOf(param2) == -1 && linkArray[i] != '') {
				link = link + '/' + linkArray[i];
			}
		}
		return link + '/';
	}

    function filterReset() {
        var linkArray = location.pathname.split('/');

        var link = '';
        for (var i = 0; i < linkArray.length; i++) {
            if (linkArray[i] == 'filter') {
                link = link + '/';
                break;
            }
            if (linkArray[i] != '') {
                link = link + '/' + linkArray[i];
            }
        }
        if (link[link.length - 1] !== '/'){
            link += '/';
        }
        location.href = link;
    }


/////////////////////////////////////////////////////////


// Табы
function run_tabs(val) {
    //alert(val)
    $(".tab_content").hide(0);
    $("#" + val).show(0);
}
function run_tabs_ss(val) {
    $(".tab_content").hide(0);
    $("#" + val).show(0);
}

// карусель на главной
function catalog_active(val, prefix) {
    $(".carusel_block.tabs ul.tabNavigation a, .carusel_block.tabs a.link").addClass("hidden");
    $("[data-name='" + val + "']").removeClass("hidden");
    $('div.tabs ul.tabNavigation a[href="#' + prefix + '_' + val + '"]').click();
}
function catalog_active_ss(val, prefix) {
    $(".carusel_block.tabs a.link").addClass("hidden");
    $("[data-name='" + val + "']").removeClass("hidden");
    $('div.tabs ul.tabNavigation a[href="#' + prefix + '_' + val + '"]').click();
}
// Переключение между каталогами, на главной
function catalog_active_open(val) {
    $('.sections_block .tab').fadeOut(0);
    $('.sections_block .' + val).fadeIn(350);
}
function catalog_active_open_ss(value) {
    $('.sections_block .tab').fadeOut(0);
    $('.sections_block .' + value).fadeIn(350);
}
// Переключение между каталогами, на главной
function catalog_active_open_map(val) {
    $('.cat1, .cat2, .cat3').fadeOut(0);
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

function afterFormReload() {
    setTimeout(function () {
        $('.select').styler();
    }, 100)

    var DELIVERY_PRICE = $("#DELIVERY_PRICE").text();
    DELIVERY_PRICE = DELIVERY_PRICE.replace(/руб./g, "");

    var ORDER_TOTAL_PRICE = $("#ORDER_TOTAL_PRICE").text();
    ORDER_TOTAL_PRICE = ORDER_TOTAL_PRICE.replace(/руб./g, "");

    if (DELIVERY_PRICE.length == 0) {
        $("#allSum_DELIVERY").parent().css('display', 'none');
    }
    else {
        $("#allSum_DELIVERY").parent().css('display', 'table-row');
        $("#allSum_DELIVERY").html(DELIVERY_PRICE + "<span>руб.</span>");
    }

    $("#allSum_FORMATED").html(ORDER_TOTAL_PRICE + "<span>руб.</span>");

    // открытие вкладок в оформлении заказа
    $(".bx_order_make .bx_ordercart_order_pay_center, .block_border").show(0);

    // Открываем все блоки оформления заказа
    $(".layer, .btns_block").detach();
    $('.content #order_form_content .header').addClass("active");
    $(".bx_order_make .bx_ordercart_order_pay_center, .block_border.comm_block").show();
}

// Очистить всю корзину
function clearBasket(val) {
    $.ajax({
        type: "POST",
        url: "/include/clear_basket.php",
        data: "do=" + val,
        success: function (html) {
            window.location.reload()
        }
    });
}

// Выбор склада при оформлении заказа
function setChangeStore(val) {
    var desc = val.options[val.selectedIndex].getAttribute('data');
    $(".store_desc").hide(0);
    $('.' + desc).show(100);

    var value = val.options[val.selectedIndex].getAttribute('value');
    if (value.length > 1) {
        $("#ORDER_PROP_17").val(value);
        $("#ORDER_PROP_18").val(value);
    }
}

// Получаем правильный каталог для поиска
function get_current_iblock(val) {
    var val_change = $(val).val();

    if (val_change == "search_title_1") {
        $('.search_title_1').removeClass("hidden");
        $('.search_title_2').addClass("hidden");
        if ($('.search_title_2 .bx_input_text').val() != '') {
            $('.search_title_1 .bx_input_text').val($('.search_title_2 .bx_input_text').val());
        }
    }
    if (val_change == "search_title_2") {
        $('.search_title_2').removeClass("hidden");
        $('.search_title_1').addClass("hidden");
        if ($('.search_title_1 .bx_input_text').val() != '') {
            $('.search_title_2 .bx_input_text').val($('.search_title_1 .bx_input_text').val());
        }
    }
}

function format_number(number) {
    var result1 = 0;
    var i1 = 0;
    var i2 = 0;
    var result1str = '';
    var result1fin = '';
    var i = 0;
    var str = '';
    result1 = Math.round(number);
    result1str = result1 + '';
    i1 = result1str.length % 3;
    i2 = result1str.length - i1;
    if (i1 > 0)
        result1fin = result1str.substring(0, i1);
    i = i1;
    while (i < result1str.length)
    {
        result1fin = result1fin + ' ' + result1str.substring(i, i + 3);
        i = i + 3;
    }
    if (result1fin.substring(0, 1) == ' ')
        result1fin = result1fin.substring(1, result1fin.length);
    str = result1fin;
    return str;
}

//Функция для склонения слова "Товар" на баннере
function declOfNum(number){
	titles=['товар','товара','товаров'];

    cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}
