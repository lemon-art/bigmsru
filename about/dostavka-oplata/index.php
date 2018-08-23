<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Доставка и оплата");
?>


<div class="content-about__content">
	<div class="row">
		<div class="col-lg-24 col-md-24 col-sm-25 content-about__main content-delivery">
			
			<div class="content-delivery__row center">
				<strong class="content-delivery__title">Доставка по Москве и Московской области</strong>
			</div>
			
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 content-delivery__block">
					<strong class="content-delivery__subtitle">Бесплатно<br><br><br></strong>
					<p class="content-delivery__text">Самовывоз из <a href="/kontakty/">магазинов</a> в Москве</p>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 content-delivery__block">
					<strong class="content-delivery__subtitle">350 руб.<br><br><br></strong>
					<p class="content-delivery__text">Доставка по Москве в пределах МКАД + Бутово</p>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 content-delivery__block">
					<strong class="content-delivery__subtitle">350 руб.<br>+30 руб/км<br>от МКАД</strong>
					<p class="content-delivery__text">Доставка по Московской области</p>
					<a href="#" class="header__callback-link popup-trigger" data-trigger="calc_dostavka">Расчитать стоимость</a>
				</div>
			</div>
			
			<div class="content-delivery__row center">
				<a href="" id="show_dev_info" class="more_info">Подробнее</a>
			</div>	
				<div class="content-delivery__row hidden_row">
					<ul class="content-guarantee__list">
						<li class="content-guarantee__item">Доставка осуществляется в течение дня – с 9:00 до 18:00. Доставка в другое время осуществляется по договоренности с менеджером.</li>
						<li class="content-guarantee__item">Доставка в точное время не предусмотрена.</li>
						<li class="content-guarantee__item">Доставка осуществляется до подъезда.</li>
						<li class="content-guarantee__item">В стоимость доставки не включен подъем товара.</li>
						<li class="content-guarantee__item">Доставка является платной услугой. При возврате товара стоимость доставки не возвращается.</li>
						<li class="content-guarantee__item">При обмене товара транспортные расходы по его доставке до склада магазина оплачиваются отдельно.</li>
						<li class="content-guarantee__item">После доставки товара необходимо проверить его комплектность и внешний вид до подписания документов.</li>
					</ul>
					
					<div class="content-delivery__row center">
						<a href="" id="hide_dev_info" class="more_info">Скрыть</a>
					</div>	
				</div>
			
			
			<br><br>
			
			<div class="content-delivery__row center">
				<strong class="content-delivery__title">Доставка по России</strong>
			</div>
			
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 content-delivery__block_half">
					<strong class="content-delivery__title">Почта России<br><br></strong>
					<strong class="content-delivery__subtitle">500 руб.</strong>
					<p class="content-delivery__text">посылка до 6кг.</p>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 content-delivery__block_half">
					<strong class="content-delivery__title">Транспортная компания<br><br></strong>
					<strong class="content-delivery__subtitle">350 руб. доставка до ТК<br>+ тариф ТК до места</strong>
					<p class="content-delivery__text">Тариф ТК до места оплачивается представителю ТК во время получения посылки.</p>
				</div>
			</div>
			
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-5 content-about__nav about-nav">
				 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"about",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"COMPONENT_TEMPLATE" => "menu",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(),
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_TYPE" => "Y",
		"MENU_CACHE_USE_GROUPS" => "N",
		"ROOT_MENU_TYPE" => "left",
		"USE_EXT" => "N"
	),
false,
Array(
	'ACTIVE_COMPONENT' => 'Y'
)
);?>
			</div>
		</div>

	</div>

 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>