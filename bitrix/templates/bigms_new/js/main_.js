var owl, gallery;

$(document).ready(function() {
 
  var scrollWidth = window.innerWidth - document.documentElement.clientWidth;

  //main slider
  var mainOwl = $('.main-slider__container');
  mainOwl.owlCarousel({
    items: 1,
    autoplayHoverPause: true,
    //dotsContainer: '.slider-nav',
    autoplay: true,

	animateOut: 'fadeOut',
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    loop: true,
  });
  $('.slider-nav__item').click(function () {
    mainOwl.trigger('to.owl.carousel', [$(this).index(), 300]);
    mainOwl.trigger('refresh.owl.carousel', []);
  });
  
  

	

	//переставляем h2 за блок в сео тексте
    if( $('.seo_text').find('h2').length > 0 ) {
		$(".seo_text h2").each(function(index, value) { 
			if ( index == 0 ){
				var h2_text = $(this).html();
				$(this).remove();
				$('.seo_text').before('<h2>' + h2_text + '</h2>');
			}
		});
    }
	
	
	$(".owl-item").each(function(index, value) { 
			
			if ( !$(this).hasClass('cloned')){
				
				
				//вставляем форму заказ монтажа в слайдер на главной странице
				if( $(this).find('.montaz_form').length > 0 ) {
					m = $(this).find('.montaz_form');
					$.ajax({
						type: "POST",
						url: '/ajax/montaz_form.php',
						success: function (data) {
							m.html( data );
						}
					});
				}
				//вставляем форму заявка на партнерство в слайдер на главной странице
				if( $(this).find('.partner_make_form').length > 0 ) {
					e = $(this).find('.partner_make_form');
					$.ajax({
						type: "POST",
						url: '/ajax/partner_form.php',
						success: function (data) {
							e.html( data );
						}
					});
				}
				
			
			}
	});
	
	
	

	
	
	

  
  
    //Обработчик формы заказа в один клик из списка товаров
	
	$('#form_click').find('input[name=phone]').inputmask({"mask": "+7(999)999-99-99"});

	
	$('#form_click').find('input[name=phone]').on('keyup', function() {
		$(this).parent().removeClass('error');
	});
	
	$('.popup_cart').on('submit', 'form', function () {
		
		validate = 1;

		
		if ( $('#form_click input[name=phone]').val().replace(/(_)/g, '').length < 16 ){
			validate = 0;
			$('#form_click input[name=phone]').parent().addClass('error');
		}
		
		
		if ( validate ){
			$.ajax({
				type: "POST",
				url: '/ajax/oneclick_order.php',
				data: $(this).serialize(),
				success: function (data) {
					
					$('[data-popup="cart"]').removeClass('js-active');
					var targetData = 'success_click';
					$('[data-popup="'+ targetData +'"]').addClass('js-active').addClass('scroll-fix');
					$('body').css('paddingRight', scrollWidth).addClass('scroll-fix');
					$('[data-popup="'+ targetData +'"]').find('.popup-trigger').addClass('js-active');
				}
			});
		}
		return false;
	});


  //city popup
  $('.form-city__link').click(function(e) {
    e.preventDefault();
    $(this).parent().find('.city-popup').toggleClass('opened');
  });

	/*
  // form radio example
  $('.form-radio__item').on('click', function() {
    var data = $(this).data('trigger');
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    if (data == "courier") {
      $('.form-radio').find('[data-content="courier"]').show();
      $('.form-radio').find('[data-content="self"]').hide();
    } else if (data == "self") {
      $('.form-radio').find('[data-content="self"]').show();
      $('.form-radio').find('[data-content="courier"]').hide();
    } else {
      $('.form-radio').find('[data-content="self"]').hide();
      $('.form-radio').find('[data-content="courier"]').hide();
    }
  });
	*/
  
  //side nav

  var screenHeight = document.documentElement.clientHeight,
      headerHeight = $('.header').innerHeight(),
      sidebarHeight = $('.sidebar').innerHeight(),
      ifToggle = $('body').hasClass('menu-fix') || false,
      menuTop = 0,
      dataClick = ($('.sidebar').data('click') == false)? false: true;
  var preventScroll = window.pageYOffset;
  if (preventScroll > headerHeight) {
    $('.sidebar').addClass('top-fixed').css('top', '0');
  }
  console.log(dataClick);
  $(window).on('scroll', function() {
    var PageScrollY = window.pageYOffset,
        scrollDiff = PageScrollY-preventScroll;
        menuTop = menuTop - scrollDiff;
        bodyHeight = $('body').innerHeight();
        console.log(bodyHeight);
    //проверяем размер меню выраженный в кол-ве экранов
    var sidebarHeightScreens = Math.floor(sidebarHeight/screenHeight),
        sidebarMarginTop = -(sidebarHeight % screenHeight),
        tempMargin = 0;
    if(PageScrollY > headerHeight) {
      $('.sidebar').addClass('top-fixed');
    } else {
      $('.sidebar').removeClass('top-fixed');
    }
    if(screenHeight < sidebarHeight) {
      if(PageScrollY > headerHeight) {
        $('.sidebar').addClass('top-fixed');
        if (menuTop > 0) {
          menuTop = 0;
        }
        if (menuTop < sidebarMarginTop || PageScrollY > bodyHeight - screenHeight  ) {
          menuTop = sidebarMarginTop;
        }

        $('.sidebar').css('top', menuTop+'px');
      } else {
        $('.sidebar').removeClass('top-fixed');
      }
    }
    preventScroll = PageScrollY;
  });

  if(document.documentElement.clientWidth > 1600 && !ifToggle) { //17px полоса прокрутки
    toggleMenu();
    mainOwl.trigger('refresh.owl.carousel', []);
  }

  function toggleMenu() {
    $('.hamburger').toggleClass('open');
    $('.side-nav').toggleClass('open');
    $('.side-nav__list').toggleClass('open');
    $('.content__wrap').toggleClass('open');
    $('.footer').toggleClass('open');
  }

  $('.side-nav__item').hover(function() {
    var eq = $('.side-nav__item').index($(this));
    $('.side-nav__icon-item').eq(eq).find('.side-nav__icon').addClass('hovered');
  }, function() {
    var eq = $('.side-nav__item').index($(this));
    $('.side-nav__icon-item').eq(eq).find('.side-nav__icon').removeClass('hovered');
  });

  //side nav sub menu
  $( "td" ).hover( function() {
    $( this ).addClass( "hover" );
  }, function() {
    $( this ).removeClass( "hover" );
  });

  //hamburger
  $('.hamburger').click(function(){
    if (document.documentElement.clientWidth > 1600 && dataClick) {
      toggleMenu();
      mainOwl.trigger('refresh.owl.carousel', []);
    }
  });

  //для демонстрации вёрстки выпадающего блока с подсказсками по поиску
  var searchInput = $('.search-form__input');
  var searchDropdown = $('.search-form__dropdown');
  searchInput.focus( function() {
    searchDropdown.show();
  });
  searchInput.blur( function() {
    searchDropdown.hide();
  });

  //status dropdown
  var _target = $('.status-bar__item_cart');
  _target.hover( function() {
    $( this ).find('.status-dropdown').stop().fadeIn(400);
  }, function() {
    $( this ).find('.status-dropdown').stop().fadeOut(400);
  });

  //popup slider
  var thumbsOwl = $('.popup-slider__container');


  //nice-select
  $('.form__select').niceSelect();

  //mCustomScrollbar
  $("#cities").mCustomScrollbar({
    axis:"y",
    theme: "cities",
    autoExpandScrollbar:true,
    advanced:{autoExpandHorizontalScroll:true},
    scrollbarPosition: "outside",
    mouseWheel: {
      enable: false
    }
  });

  $("#thumbs").mCustomScrollbar({
    axis:"x",
    theme:"bigms",
    autoExpandScrollbar:true,
    advanced:{autoExpandHorizontalScroll:true},
    scrollbarPosition: "outside",
    mouseWheel: {
      enable: false
    },
    callbacks:{
      whileScrolling:function(){
        if(this.mcs.leftPct > 0 && this.mcs.leftPct < 100) {
          $('.content-product__thumbs-wrap').addClass('left-shadow');
          $('.content-product__thumbs-wrap').addClass('right-shadow');
        } else if(this.mcs.leftPct == 0) {
          $('.content-product__thumbs-wrap').removeClass('left-shadow');
        } else if(this.mcs.leftPct == 100) {
          $('.content-product__thumbs-wrap').removeClass('right-shadow');
        }
      }
    }
  });

  $("#demanded-products").mCustomScrollbar({
    axis:"x",
    theme:"bigms",
    autoExpandScrollbar:true,
    advanced:{autoExpandHorizontalScroll:true},
    scrollbarPosition: "outside",
    mouseWheel: {
      enable: false
    },
    callbacks:{
      whileScrolling:function(){
        if(this.mcs.leftPct > 0 && this.mcs.leftPct < 100) {
          $('.demanded-products__wrap').addClass('left-shadow');
          $('.demanded-products__wrap').addClass('right-shadow');
        } else if(this.mcs.leftPct == 0) {
          $('.demanded-products__wrap').removeClass('left-shadow');
        } else if(this.mcs.leftPct == 100) {
          $('.demanded-products__wrap').removeClass('right-shadow');
        }
      }
    }
  });
  $("#demanded-products_ordered").mCustomScrollbar({
    axis:"x",
    theme:"bigms",
    autoExpandScrollbar:true,
    advanced:{autoExpandHorizontalScroll:true},
    scrollbarPosition: "outside",
    mouseWheel: {
      enable: false
    },
    callbacks:{
      whileScrolling:function(){
        if(this.mcs.leftPct > 0 && this.mcs.leftPct < 100) {
          $('.demanded-products__wrap').addClass('left-shadow');
          $('.demanded-products__wrap').addClass('right-shadow');
        } else if(this.mcs.leftPct == 0) {
          $('.demanded-products__wrap').removeClass('left-shadow');
        } else if(this.mcs.leftPct == 100) {
          $('.demanded-products__wrap').removeClass('right-shadow');
        }
      }
    }
  });

  $("#products-similar").mCustomScrollbar({
    axis:"x",
    theme:"bigms",
    autoExpandScrollbar:true,
    advanced:{autoExpandHorizontalScroll:true},
    scrollbarPosition: "outside",
    mouseWheel: {
      enable: false
    },
    callbacks:{
      whileScrolling:function(){
        if(this.mcs.leftPct > 0 && this.mcs.leftPct < 100) {
          $('.products-similar__wrap').addClass('left-shadow');
          $('.products-similar__wrap').addClass('right-shadow');
        } else if(this.mcs.leftPct == 0) {
          $('.products-similar__wrap').removeClass('left-shadow');
        } else if(this.mcs.leftPct == 100) {
          $('.products-similar__wrap').removeClass('right-shadow');
        }
      }
    }
  });

  $("#products-seen").mCustomScrollbar({
    axis:"x",
    theme:"bigms",
    autoExpandScrollbar:true,
    advanced:{autoExpandHorizontalScroll:true},
    scrollbarPosition: "outside",
    mouseWheel: {
      enable: false
    },
    callbacks:{
      whileScrolling:function(){
        if(this.mcs.leftPct > 0 && this.mcs.leftPct < 100) {
          $('.products-similar__wrap').addClass('left-shadow');
          $('.products-similar__wrap').addClass('right-shadow');
        } else if(this.mcs.leftPct == 0) {
          $('.products-similar__wrap').removeClass('left-shadow');
        } else if(this.mcs.leftPct == 100) {
          $('.products-similar__wrap').removeClass('right-shadow');
        }
      }
    }
  });



  //product card thumbs logic
  $('.content-product__thumbnail').mouseenter(function() {
    var dataSrc = $(this).data('src');
    $('.content-product__image').find('.content-product__picture').attr('src', dataSrc);
  });
  
  
	  function refresh_top_basket(){

	  }
	  
	  
    $('.sublist_producers .sublist__item').click(function(e) {
		window.location = $(this).find('a').attr('href');
	});
	
	$('[data-level="1"] > a').click(function() {
		return false;
	});
	
	$('.header__status').on('click', '.status-bar_cursor', function(e) {
		window.location = $(this).data('url');
	});
	
	//добавление в избранное товара
	$('.content-products, .content-product, .demanded-products').on('click', '.product-card__wish-icon, .product-info__wish-icon', function(e) {
		if ( $(this).hasClass('active') ){
			var action = 'delete';
		}
		else {
			var action = 'add';	
		}
		id = $(this).attr('data-id');
		$('.product-card__wish-icon[data-id=' + id + ']').toggleClass('active');
		$('.product-info__wish-icon[data-id=' + id + ']').toggleClass('active');
		

		
		$.post("/ajax/add_to_like.php", { ProductID: id, ACTION: action },
		  function(data){
			$.post("/ajax/top_basket.php", {},
			  function(data){
				$('.header__status').html( data );
				  var _target = $('.status-bar__item_cart');
				  _target.hover( function() {
					$( this ).find('.status-dropdown').stop().fadeIn(400);
				  }, function() {
					$( this ).find('.status-dropdown').stop().fadeOut(400);
				  });
			});
		});
		
	}); 
	
	//удаление избранное товара
	$('.content-products__list').on('click', '.delete_from_whishlist', function(e) {
		var action = 'delete';	
		id = $(this).attr('data-id');
		$('#whishlist_'+id).remove();
		
		$.post("/ajax/add_to_like.php", { ProductID: id, ACTION: action },
		  function(data){
			$.post("/ajax/top_basket.php", {},
			  function(data){
				$('.header__status').html( data );
				  var _target = $('.status-bar__item_cart');
				  _target.hover( function() {
					$( this ).find('.status-dropdown').stop().fadeIn(400);
				  }, function() {
					$( this ).find('.status-dropdown').stop().fadeOut(400);
				  });
			});
		});
		
	}); 
  
	$('.content-products, .products-similar, .content-products__list, .product-props, .content-product, .demanded-products').on('click', '.popup-add-to-cart', function(e) {
		id = $(this).attr('data-id');
		var ELEM_NAME = $('input[name="ELEM_NAME'+id+'"]').val();
		var CAT_PRICE = $('input[name="CAT_PRICE'+id+'"]').val();
		var PICTURE   = $('input[name="PICTURE'+id+'"]').val();
		var STATUS    = $('input[name="STATUS'+id+'"]').val();
		var STATUS_CL = $('input[name="STATUS'+id+'"]').attr('data-class');
		var COUNT     = $('input[name="COUNT'+id+'"]').val();
			
		$('.popup_cart').find('.form__subtitle').text( ELEM_NAME );
		$('.popup_cart').find('.form__price').text( CAT_PRICE );
		$('.popup_cart').find('.form__img').attr( 'src', PICTURE );
		$('.popup_cart').find('.product-card__quantity').removeClass('product-card__quantity_order').removeClass('product-card__quantity_instock').addClass( STATUS_CL ).text( STATUS );
		$('.popup_cart').find('input[name="PRODUCT_ID"]').val( id );
		$('.popup_cart').find('input[name="PRICE"]').val( '' );
		
		$.post("/ajax/add_to_cart.php", { ProductID: id, QUANTITY: COUNT },
		  function(data){
			$.post("/ajax/top_basket.php", {},
			  function(data){
				$('.header__status').html( data );
				  var _target = $('.status-bar__item_cart');
				  _target.hover( function() {
					$( this ).find('.status-dropdown').stop().fadeIn(400);
				  }, function() {
					$( this ).find('.status-dropdown').stop().fadeOut(400);
				  });
			});
		});
		popupOpen($(this));
		e.preventDefault();
		
		
	   
	});

  //popup
  $('.popup-trigger').click(function(e) {

    e.preventDefault();
    if( $(this).data('trigger') == 'slider' && !$(this).hasClass('js-active') ) {
	
	  if ( $(this).data('id') ){
		

		var slideIndex = $('#office'+ $(this).data('id') +' .content-contacts__gallery-item').index($(this));
        thumbsOwl.trigger('to.owl.carousel', [slideIndex-1, 300]);
		
									
		
	  }
	  else {

	    var slideIndex = $('.content-product__thumbnail').index($(this));
		thumbsOwl.trigger('to.owl.carousel', [slideIndex, 300]);
	  }
	

    }
	
	//заказ обратного звонка
	if( $(this).data('trigger') == 'callback' && !$(this).hasClass('js-active') ) {
	
		$.ajax({
            type: "POST",
            url: '/ajax/feedback_form.php',
            success: function (data) {
				$('#callback').html( data );
            }
        });
		
    }
	
	//рассчитать смету
	if( $(this).data('trigger') == 'estimate' && !$(this).hasClass('js-active') ) {
	
		$.ajax({
            type: "POST",
            url: '/ajax/smeta_form.php',
            success: function (data) {
				$('#estimate').html( data );
            }
        });
		
    }
	
	if($(this).data('trigger') == 'youtube') {
		if ( !$(this).hasClass('js-active') ){
			$('#youtube').html( $(this).data('youtube') );
		}
		else {
			$('#youtube').html( '' );
		}
    }
	
    if($(this).hasClass('js-active')) {
		$(this).removeClass('js-active');
		popupClose($(this));
		
    } else {
		popupOpen($(this));
		
    }
  });
  
  
			$('.content-products').on("click", '.pagination__more', function() {
				$('.preloader').show();
				$('.content-products__pagination').hide();
				loading = false;
				if ( !loading ) {
					loading = true;
					$.get( $(this).attr('href'), {is_ajax: 'y'}, function(data){
						$('.preloader').remove();
						$('.content-products__pagination').before(data).remove();
						//$('.preloader').hide();
						//$('.content-products__pagination').show();
						loading = false;
					});
				}
				
				return false;
			});
  
  
    $('.popup-trigger-self').click(function(e) {

		var targetData = $(this).data('close');
		$('[data-popup="'+ targetData +'"]').removeClass('js-active');
		$('body').css('paddingRight', '0' ).removeClass('scroll-fix');
		if($(this).hasClass('js-active')) {
			$(this).removeClass('js-active');
			popupClose($(this));
		} else {
			popupOpen($(this));
		}

	});
  

  $(document).mouseup(function (e){
	
    //popup closing
    var popup = $('.popup');
	$('#youtube').html( '' );
      popupWrap = popup.find('.popup__wrap');
    if (!popupWrap.is(e.target) && popupWrap.has(e.target).length === 0) {
      popup.removeClass('js-active');
      $('body').css('paddingRight', '0').removeClass('scroll-fix');
    }
    //order cities closing
    var citiesWrap = $('.city-popup');
    if (!citiesWrap.is(e.target) && citiesWrap.has(e.target).length === 0) {
      citiesWrap.removeClass('opened');
    }

  });
  function popupOpen(target) {
    var targetData = target.data('trigger');
    $('[data-popup="'+ targetData +'"]').addClass('js-active').addClass('scroll-fix');
    $('body').css('paddingRight', scrollWidth).addClass('scroll-fix');
    $('[data-popup="'+ targetData +'"]').find('.popup-trigger').addClass('js-active');
  }
  function popupClose(target) {
	
	var targetData = target.data('trigger');
	
	if ( targetData == 'success_click' ){		//если это окно о создании заказа в 1 клик из корзины то перенаправляем на главную страницу
		if ( $('[data-popup="success_click"]').hasClass('follow_main') ){
			window.location = '/';	
		}
	}
  
    
    $('[data-popup="'+ targetData +'"]').removeClass('js-active');
    $('body').css('paddingRight', '0' ).removeClass('scroll-fix');
  }

  //subcat
  $('.subcat__more').click(function() {
    $(this).parent().find('.subcat__list').toggleClass('open');
    if($(this).hasClass('open')) {
      $(this).removeClass('open').removeClass('static');
      $(this).html('+');
    } else {
      $(this).addClass('open').addClass('static');
      $(this).html('Свернуть');
    }
  });
  //catalog categories more
  $('.content-categories__more').click(function(e) {
    e.preventDefault();
    $(this).parent().find('.content-categories__inner-list').toggleClass('opened');
    $(this).toggleClass('active');
    if ($(this).hasClass('active')) {
      $(this).text('Свернуть');
    } else {
      $(this).text('Смотреть');
    }
  });

  //ordered tabs
  $('.link-filter__link').click(function(e) {
    e.preventDefault();
    var data = $(this).parent().data('trigger'),
        target = $('.demanded-products').find('[data-list="'+ data +'"]');
    $(this).parent().siblings().removeClass('active');
    $(this).parent().addClass('active');
    target.siblings().removeClass('active');
    target.addClass('active');
  });

  //content-adv
  $('.content-adv__button_detail').click(function(e) {
    e.preventDefault();
    $(this).toggleClass('open');
    if($('.content-adv__dropdown').hasClass('open')) {
      $('.content-adv__dropdown').stop().slideUp(500);
      $('.content-adv__dropdown').toggleClass('open');
    } else {
      $('.content-adv__dropdown').stop().slideDown(500);
      $('.content-adv__dropdown').toggleClass('open');
    }
  });

  $('.content-adv__close').click(function() {
    $(this).parent().removeClass('open');
  });

  //spinner
  $('.spinner__inc').click(function(e) {
    e.preventDefault();
    var target = $(this).parent().find('.spinner__input');
    value = target.val();
    target.val(++value);
  });
  $('.spinner__dec').click(function(e) {
    e.preventDefault();
    var target = $(this).parent().find('.spinner__input');
    value = target.val();
    if (value > 1) {
      target.val(--value);
    }
  });
  $('.spinner__input').change(function() {
    console.log('123');
    if(this.value < 1) {
      this.value = 1;
    }
  });
  //filter dropdown
  $('.filter-form__title').click(function(e) {
    e.stopPropagation();
    $(this).parent().toggleClass('opened');
    $(this).parent().find('.filter-form__content').toggleClass('opened');
  });

  // view change
  $('.toggle-view__item').click(function() {
    $('[data-view]').removeClass('active');
    $(this).addClass('active');
    var data = $(this).data('view');
    $('.content-products').find('[data-view="'+ data +'"]').addClass('active');
  });


  
  
  //filter more button
  $('.filter-form__more').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).toggleClass('opened');
    $(this).parent().find('.filter-form__content-wrap').toggleClass('opened');
    if($(this).hasClass('opened')) {
      $(this).html('Скрыть');
    } else {
      $(this).html('Показать еще');
    }
  });
  //tabs
  $('.tabs-trigger').click(function() {
    var dataTab = $(this).data('trigger'),
        target = $('.tabs').find('[data-tab="'+ dataTab +'"]');
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    target.siblings().removeClass('active');
    target.addClass('active');
  });
  $('.tech-props__all').click(function(e) {
    e.preventDefault();
    $('.tabs-trigger').removeClass('active');
    $('.tabs-trigger[data-trigger="stats"]').addClass('active');
    $('[data-tab="stats"]').siblings().removeClass('active');
    $('[data-tab="stats"]').addClass('active');
    $('body, html').animate({"scrollTop":0}, 0);
  });
  $('.order-add__more').click(function() {
    $('.tabs-trigger').removeClass('active');
    $('.tabs-trigger[data-trigger="additional"]').addClass('active');
    $('[data-tab="additional"]').siblings().removeClass('active');
    $('[data-tab="additional"]').addClass('active');
    $('body, html').animate({"scrollTop":0}, 0);
  });

  //input file
  $('[type="file"]').on('focus', function() {
    $(this).prop('value', null);
  });
  $('[type="file"]').on('change', function() {
    var value = $(this).val();
    $(this).parent().find('.input-file__text').text(value);
  });

  //cart estimate dropdown
  $('.cart-estimate__more').on('click', function(e) {
    e.preventDefault();
    $('.cart-estimate').addClass('bordered');
    $(this).addClass('hidden');
    $('.cart-estimate__content').addClass('opened');
  });
  $('.cart-estimate__close').on('click', function(e) {
    e.preventDefault();
    $('.cart-estimate').removeClass('bordered');
    $(this).parent().removeClass('opened');
    $('.cart-estimate__more').removeClass('hidden');
  });
  
	$('.producers-filter__item').on('click', function(e) {

		var bukva = $(this).attr('data-name');
		$('.producers-filter__item').removeClass('active');
		$(this).addClass('active');
		
		if ( bukva == '0' ){
			$('.producers-row').show();
		}
		else{
			$('.producers-row').hide();
			$('div[data-header="'+bukva+'"]').show();
		}
		
		return false;
	});
  


});

$(function () {

	$('[name="REGISTER[LOGIN]"]').on('keyup change', function() {
		if ( $(this).val().length > 2 ){
			$(this).parent('div').addClass('validated');
		}
	});

	$('[name="REGISTER[PASSWORD]"]').on('keyup change', function() {
		if ( $(this).val().length > 5 ){
			$(this).parent('div').addClass('validated');
		}
	});
	
	$('[name="REGISTER[CONFIRM_PASSWORD]"]').on('keyup change', function() {
		if ( $(this).val().length > 5 ){
			if ( $(this).val() == $('[name="REGISTER[PASSWORD]"]').val()){
				$(this).parent('div').addClass('validated');
				$(this).parent('.error').removeClass('error');
			}
			else {
				$(this).parent('div').addClass('error');
			}
		}
	});
	
	$('[name="REGISTER[EMAIL]"]').on('change', function() {
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		    var address = $(this).val();
		    if(reg.test(address) == false) {
				$(this).parent('div').addClass('error');
				$(this).parent('.error').removeClass('validated');
		    }
			else {
				$(this).parent('div').addClass('validated');
				$(this).parent('.error').removeClass('error');
			}
	});
	
	$('[name="REGISTER[NAME]"], [name="REGISTER[LAST_NAME]"]').on('keyup change', function() {
		if ( $(this).val().length > 2 ){
			$(this).parent('div').addClass('validated');
		}
	});
	

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
            success: function (data) {
                $('#modal-register .modal-content').html(data);
                $('#modal-register form').attr('action', form_action);
                $('#modal-register input[name=backurl]').val(form_backurl);
				
				$('[name="REGISTER[LOGIN]"]').on('keyup change', function() {
					if ( $(this).val().length > 2 ){
						$(this).parent('div').addClass('validated');
					}
				});

				$('[name="REGISTER[PASSWORD]"]').on('keyup change', function() {
					if ( $(this).val().length > 5 ){
						$(this).parent('div').addClass('validated');
					}
				});
				
				$('[name="REGISTER[CONFIRM_PASSWORD]"]').on('keyup change', function() {
					if ( $(this).val().length > 5 ){
						if ( $(this).val() == $('[name="REGISTER[PASSWORD]"]').val()){
							$(this).parent('div').addClass('validated');
							$(this).parent('.error').removeClass('error');
						}
						else {
							$(this).parent('div').addClass('error');
						}
					}
				});
				
				$('[name="REGISTER[EMAIL]"]').on('change', function() {
						var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
						var address = $(this).val();
						if(reg.test(address) == false) {
							$(this).parent('div').addClass('error');
							$(this).parent('.error').removeClass('validated');
						}
						else {
							$(this).parent('div').addClass('validated');
							$(this).parent('.error').removeClass('error');
						}
				});
				
				$('[name="REGISTER[NAME]"], [name="REGISTER[LAST_NAME]"]').on('keyup change', function() {
					if ( $(this).val().length > 2 ){
						$(this).parent('div').addClass('validated');
					}
				});
				
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
            success: function (data) {
				if( data.indexOf('notetext') > 0 ){
					$('[data-popup="remember"]').removeClass('js-active');
					    var targetData = 'sent';
						$('[data-popup="'+ targetData +'"]').addClass('js-active').addClass('scroll-fix');
						$('body').css('paddingRight', scrollWidth).addClass('scroll-fix');
						$('[data-popup="'+ targetData +'"]').find('.popup-trigger').addClass('js-active');
				}
				else {
					$('#modal-forgot-password .modal-content').html(data);
					$('#modal-forgot-password form').attr('action', form_action);
					$('#modal-forgot-password input[name=backurl]').val(form_backurl);
				}
            }
        });

        return false;
    });
	

});
