var owl, gallery;

$(document).ready(function() {

  var scrollWidth = window.innerWidth - document.documentElement.clientWidth;

  //main slider
  var mainOwl = $('.main-slider__container');
  mainOwl.owlCarousel({
    items: 1,
    autoplayHoverPause: true,
    dotsContainer: '.slider-nav',
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    loop: true,
  });
  $('.slider-nav__item').click(function () {
    mainOwl.trigger('to.owl.carousel', [$(this).index(), 300]);
    mainOwl.trigger('refresh.owl.carousel', []);
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
  thumbsOwl.owlCarousel({
    loop: false,
    items: 1,
    thumbs: true,
    thumbImage: true,
    thumbContainerClass: 'popup-nav',
    thumbItemClass: 'popup-nav__item'
  });
  $('.popup-nav__item').click(function () {
    thumbsOwl.trigger('to.owl.carousel', [$(this).index(), 300]);
    thumbsOwl.trigger('refresh.owl.carousel', []);
  });

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
		alert('1');
	  }
	  
	  
    $('.sublist_producers .sublist__item').click(function(e) {
		window.location = $(this).find('a').attr('href');
	});
	
	$('[data-level="1"] > a').click(function() {
		return false;
	});
  
	$('.popup-add-to-cart').click(function(e) {
	
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
    if($(this).data('trigger') == 'slider') {
	
	  if ( $(this).data('id') ){
		$('#slider').html( $('#slider'+$(this).data('id') ).html() );
	  }
	
      var slideIndex = $('.content-product__thumbnail').index($(this));
      thumbsOwl.trigger('to.owl.carousel', [slideIndex-1, 300]);
    }
	
	if($(this).data('trigger') == 'youtube') {
		$('#youtube').html( $(this).data('youtube') );
    }
	
	
	
    if($(this).hasClass('js-active')) {
		$(this).removeClass('js-active');
		popupClose($(this));
    } else {
		popupOpen($(this));
    }
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

  //product incart toggle
  $('.product-info__buy').click(function(e) {
    e.preventDefault();
    $('.product-info__row_buy').toggleClass('active');
    $('.product-info__row_click').toggleClass('active');
    $('.product-info__row_incart').toggleClass('active');
  });
  $('.product-info__delete').click(function(e) {
    e.preventDefault();
    $('.product-info__row_buy').toggleClass('active');
    $('.product-info__row_click').toggleClass('active');
    $('.product-info__row_incart').toggleClass('active');
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
