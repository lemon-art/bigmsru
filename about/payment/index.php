<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Способы оплаты");
?>

<div class="content-about__content">
    <div class="row">
        <div class="col-lg-20 col-md-20 col-sm-20 content-about__main">
			<div class="content-delivery__row">
				<strong class="content-delivery__subtitle">1. Наличный расчет</strong>
				<p class="content-delivery__text">Оплатить наличными можно курьеру при получении товара по Москве и Московской области, либо при самовывозе в магазинах "Большой Мастер"</p>
			</div>

			<div class="content-delivery__row">
				<strong class="content-delivery__subtitle">2. Безналичный расчет</strong>
				<p class="content-delivery__text"> Оплатить товар по безналичному расчету можно юридическим и физическим лицам, зарегистрированным на территории РФ. Счет выставляется на электронную почту по подтверждения заказа.<br></p>
			</div>
			
			<div class="content-delivery__row">
				<strong class="content-delivery__subtitle">3. Банковской картой на сайте</strong>
				<p class="content-delivery__text">Оплата производится в личном кабинете после подтверждения заказа менеджером. Все операции по вашей карте осуществляются при полном соблюдении требований компаний VISA International и Masterсard Worldwide.&nbsp;<br>
 Оплата происходит через АО «Тинькофф Банк».</p>
			</div>
			
			<div class="content-delivery__row">
				<strong class="content-delivery__subtitle">4. Банковской картой при самовывозе</strong>
				<p class="content-delivery__text">Банковской картой можно также оплатить в пунктах самовывоза заказа.</p>
			</div>
			
			<div class="content-delivery__row">
				<img src="/about/payment/pain.jpg" alt="В магазине Большой Мастер можно оплатить Банковской картой">
			</div>

	</div>
<div class="col-lg-6 col-lg-offset-4 col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-4 content-about__nav about-nav">
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
			
			
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>