function ChangeGenerate(val)
{
	if(val)
		document.getElementById("sof_choose_login").style.display='none';
	else
		document.getElementById("sof_choose_login").style.display='block';

	try{document.order_reg_form.NEW_LOGIN.focus();}catch(e){}
}


 $(document).ready(function() {
        $('input.phone').inputmask({"mask": "+7(999)999-99-99"});
		
		
		


	
		$('.content-order').on('click', '.self-delivery__link', function(e) {
	
			target = $(this); 
			var scrollWidth = window.innerWidth - document.documentElement.clientWidth;
			var targetData = target.data('trigger');
			var targetMapX = target.data('mapx');
			var targetMapY = target.data('mapy');
			

			setOffice( targetMapX, targetMapY );
		
			
			$('[data-popup="'+ targetData +'"]').addClass('js-active').addClass('scroll-fix');
			$('body').css('paddingRight', scrollWidth).addClass('scroll-fix');
			$('[data-popup="'+ targetData +'"]').find('.popup-trigger').addClass('js-active');
			
			
			
			
			
			return false;
		
		}); 
		
		
		
		




	

		
		
		//order tabs
		$('.order-tabs__nav-item').click(function() {
			var data = $(this).data('tab');
			var target = $('.order-tabs').find('[data-content="'+ data +'"]');
			$(this).siblings().removeClass('active');
			$(this).addClass('active');
			target.siblings().removeClass('active');
			target.addClass('active');
			$('input[name="PERSON_TYPE"]').val( $(this).attr('data-person'));
			$('div[data-step="3"').parent().addClass('disabled');
			$('div[data-step="4"').parent().addClass('disabled');
			checkStep1();
		});

		$('[data-step="1"]').find('.form__input').on('keyup', function() {
			
			if ( $(this).hasClass( "email" ) ){
			
				var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				var address = $(this).val();
				if(reg.test(address) == false) {
					if ( $(this).parent('div').hasClass( "validated" ) ){ 
						$(this).parent('div').addClass('error');
						$(this).parent('.error').removeClass('validated');
					}
				}
				else {
					$(this).parent('div').addClass('validated');
					$(this).parent('.error').removeClass('error');
					checkStep1();
				}
			
			}
			else {
				if ( $(this).val().replace(/(_)/g, '').length >= parseInt( $(this).attr('data-min') )){
					$(this).parent('div').addClass('validated');
					$(this).parent('.error').removeClass('error'); 
					checkStep1();
				}
				else {
					if ( $(this).parent('div').hasClass( "validated" ) ){ 
						$(this).parent('div').addClass('error');
						$(this).parent('.error').removeClass('validated');
					}	
				}
			}
			checkStep1();
		});
		
		$('[data-step="1"]').find('.form__input').on('change', function() {
			
			if ( $(this).hasClass( "email" ) ){
			
				var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				var address = $(this).val();
				if(reg.test(address) == false) {
					$(this).parent('div').addClass('error');
					$(this).parent('.error').removeClass('validated');
				}
				else {
					$(this).parent('div').addClass('validated');
					$(this).parent('.error').removeClass('error');
					checkStep1();
				}
			
			}
			else {
				if ( $(this).val().replace(/(_)/g, '').length >= parseInt( $(this).attr('data-min') )){
					$(this).parent('div').addClass('validated');
					$(this).parent('.error').removeClass('error'); 
					checkStep1();
				}
				else {
					$(this).parent('div').addClass('error');
					$(this).parent('.error').removeClass('validated');
				}
			}
			checkStep1();
		});
		
		
		function checkStep1 (){
			var type = $('.order-tabs__nav').find('.active').attr('data-tab');
			activate = 1;
			$('div[data-content="'+type+'"').find('.div_form').each(function() {
				if ( !$(this).hasClass( "validated" ) ){
					activate = 0;
				}		
			}); 

			if ( activate ){
				$('div[data-step="2"').parent().removeClass('disabled');
			}
			else {
				$('div[data-step="2"').parent().addClass('disabled');
			}
		}
		
		function checkAdress (){
			
			activate = 1;
			var full_adr = '';
			$('[data-content="dev2"]').find('.div_form').each(function() {
				if ( !$(this).hasClass( "validated" ) ){
					activate = 0;
				}
				else{
					if ( full_adr !== '')
						var razd = ', ';
					else 
						var razd = '';
					full_adr = full_adr + razd + $(this).find('input').val();
				}
			}); 

			if ( activate ){
			
				type = $('[name="PERSON_TYPE"]').val();
				if ( type == '1' ){
					$('#FULL_ADRESS').attr('name', 'ORDER_PROP_6').val( full_adr );
				}
				else {
					$('#FULL_ADRESS').attr('name', 'ORDER_PROP_16').val( full_adr );
				}
				activateStep4();
			}
			else {
				
			}
		}
		
		
		$('.city-popup__item').on('click', function() {
			$('div[data-step="3"').parent().addClass('disabled');
			$('div[data-step="4"').parent().addClass('disabled');
			var DELIVERY_LOCATION = $(this).attr('data-city');
			$('.form-city__link').attr('data-city', DELIVERY_LOCATION).text( $(this).text() );
			$('.form-city__popup').toggleClass('opened');
			$('input[name="DELIVERY_LOCATION"]').val( DELIVERY_LOCATION );
			
			$.ajax({
				type: "POST",
				url: "/ajax/order_delivery.php",
				data: 'DELIVERY_LOCATION='+DELIVERY_LOCATION+'&templateFolder='+$('#step3_file').val(),
				success: function (data) {
					$('#step3').html( data );
					$('div[data-step="3"').parent().removeClass('disabled');	
					
					
					$('[data-step="3"]').find('.form-radio__item').on('click', function() {
						$('div[data-step="4"').parent().addClass('disabled');
						var data = $(this).data('trigger');
						var DELIVERY_ID = $(this).data('id');
						$('#DELIVERY_ID').val( DELIVERY_ID );
						$(this).siblings().removeClass('active');
						$(this).addClass('active');
						$('.dev').hide();

						// При доставке авто показываем такое же поле адреса как и при доставке курьером.
						if(DELIVERY_ID == '3' || DELIVERY_ID == '4' || DELIVERY_ID == '8'){
                            $('.dev[data-content="dev2"]').show();
						}
						$('.dev[data-content="'+data+'"]').show();

						if ( DELIVERY_ID == '3' || DELIVERY_ID == '4'){
							//activateStep4();
						}

						if ( DELIVERY_ID == '2' || DELIVERY_ID == '3' || DELIVERY_ID == '4' || DELIVERY_ID == '8'){
							checkAdress();
							$('[data-content="dev2"]').find('.form__input').on('keyup', function() {


									if ( $(this).val().replace(/(_)/g, '').length >= parseInt( $(this).attr('data-min') )){
										$(this).parent('div').addClass('validated');
										$(this).parent('.error').removeClass('error');
									}
									else {
										if ( $(this).parent('div').hasClass( "validated" ) ){
											$(this).parent('div').addClass('error');
											$(this).parent('.error').removeClass('validated');
										}
									}

								checkAdress();
							});

							$('[data-content="dev2"]').find('.form__input').on('change', function() {

									if ( $(this).val().replace(/(_)/g, '').length >= parseInt( $(this).attr('data-min') )){
										$(this).parent('div').addClass('validated');
										$(this).parent('.error').removeClass('error');
									}
									else {
										$(this).parent('div').addClass('error');
										$(this).parent('.error').removeClass('validated');
									}

								checkAdress();
							});
						}
						
					});
					  
					$('.self-delivery__button').on('click', function() {
						
						$('.delivery-result').show();
						var data = $(this).data('store');
						$('.delivery-result__wrap.store').hide();
						$('#store'+data).show();
						
						type = $('[name="PERSON_TYPE"]').val();
						var sclad = $(this).parent().parent().find('p.self-delivery__text').text();
						if ( type == '1' ){
							$('#SKLAD').attr('name', 'ORDER_PROP_17').val( sclad );
						}
						else {
							$('#SKLAD').attr('name', 'ORDER_PROP_18').val( sclad );
						}
						
						activateStep4();
						return false;
						
					});
					  
				}
			});
			
			
			return false;
		});	
		
		
		function activateStep4(){
			
			var DELIVERY_ID = $('#DELIVERY_ID').val();
			$('input[name="DELIVERY_ID"]').val( DELIVERY_ID );

			$.ajax({
					type: "POST",
					url: "/ajax/order_paysistem.php",
					data: 'DELIVERY_ID='+DELIVERY_ID+'&templateFolder='+$('#step3_file').val()+'&PERSON_TYPE='+$('[name="PERSON_TYPE"]').val(),
					success: function (data) {
						
						$('#step4').html( data );
						$('div[data-step="4"').parent().removeClass('disabled');
						
						$('[data-step="4"]').find('.form-radio__item').on('click', function() {
							$(this).siblings().removeClass('active');
							$(this).addClass('active');
							var PAYMENT_ID = $(this).data('id');
							$('#PAYMENT_ID').val( PAYMENT_ID );
							
						  });
					
					}
			});
		}
		
		$('.city-search').on('keyup', function() {
			var city = $(this).val().toUpperCase();
			$('.city-popup__item').find('a').each(function() {
                if ( $(this).text().toUpperCase().substr(0, city.length) !== city ){
                    $(this).hide();
                } else {
                    $(this).show();
                }
			});
			return false;
		});

		$('.content-order__form').on('submit', function(e){
			var orderError = false;

			var personTypeId = $('input[name="PERSON_TYPE"]').val();

			if(personTypeId == '1'){
                var orderName = $('#order_name');
                if(orderName.length > 0){
                    if(orderName.val() === ''){
                        orderName.css('border', '2px solid red');
                        orderError = true;
                    }else{
                        orderName.css('border', '');
                    }
                }

                var orderEmail = $('input[name="ORDER_PROP_2"]');
                if(orderEmail.length > 0) {
                    if (orderEmail.val() === '') {
                        orderEmail.css('border', '2px solid red');
                        orderError = true;
                    } else {
                        orderEmail.css('border', '');
                    }
                }

                var orderPhone = $('input[name="ORDER_PROP_3"]');
                if(orderPhone.length > 0) {
                    if(orderPhone.val() === ''){
                        orderPhone.css('border', '2px solid red');
                        orderError = true;
                    }else{
                        orderPhone.css('border', '');
                    }
                }
			}else{
                var inputs = [
                	'input[name="ORDER_PROP_10"]',
					'input[name="ORDER_PROP_8"]',
					'input[name="ORDER_PROP_11"]',
					'input[name="ORDER_PROP_12"]',
					'input[name="ORDER_PROP_13"]',
					'#bank',
					'#bik',
					'#corporate_account',
					'#payment_account'
				];

                inputs.forEach(function(e, i){
                    var field = $(e);
                    if(field.length > 0) {
                        if(field.val() === ''){
                            field.css('border', '2px solid red');
                            orderError = true;
                        }else{
                            field.css('border', '');
                        }
                    }
                });

			}



            var orderCity = $('a.form-city__link');
            if(orderCity.length > 0) {
                if(orderCity.text() === "выберите город"){
                    orderCity.closest('.form__container.form-city').find('.form__title').css('color', 'red');
                    orderError = true;
                }else{
                    orderCity.closest('.form__container.form-city').find('.form__title').css('color', '');
                }
			}


            var orderDelivery = $('#DELIVERY_ID');
            if(orderDelivery.length > 0) {
                if(orderDelivery.val() === ''){
                    $('#step3').find('.form__title').css('color', 'red');
                    orderError = true;
                }else{
                    $('#step3').find('.form__title').css('color', '');
                }
			}


            var orderAddress = $('#street');
            if(orderAddress.length > 0){
                if(orderAddress.val() === ''){
                    orderAddress.css('border', '2px solid red');
                    orderError = true;
                }else{
                    orderAddress.css('border', '');
                }
			}


            var orderPay = $('#PAYMENT_ID');
            if(orderPay.length > 0){
                if(orderPay.val() === ''){
                    $('#step4').find('.form__title').eq(0).css('color', 'red');
                    orderError = true;
                }else{
                    $('#step4').find('.form__title').eq(0).css('color', '');
                }
			}

			if(orderError){
                e.preventDefault();
                return false;
			}

		});
		
});