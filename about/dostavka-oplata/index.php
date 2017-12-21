<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Доставка и оплата");
?><div class="content-about__content">
	<div class="row">
		<div class="col-lg-24 col-md-24 col-sm-25 content-about__main content-delivery">
			<div class="content-delivery__row">
 <strong class="content-delivery__title">Во избежание недоразумений</strong>
				<p class="content-delivery__text">
					В сети магазинов «Большой мастер» работает собственный отдел доставки.<br>
					Вы получите свой заказ вовремя! Мы доставим товар до вашего подъезда (подъем на этаж заранее оговаривается с менеджером).
				</p>
			</div>
			<div class="content-delivery__row">
 <strong class="content-delivery__subtitle">Доставка инженерной сантехники по Москве в пределах МКАД</strong>
				<p class="content-delivery__text">
					До 15 000 рублей – 500 руб.<br>
					при сумме заказа свыше 15 000 руб. (в пределах МКАД) – БЕСПЛАТНО*
				</p>
				<p class="content-delivery__notice">
					*Доставку крупногабаритных грузов (длиной более 2 метров и весом свыше 300 кг) необходимо согласовывать с менеджером интернет-магазина.
				</p>
			</div>
			<div class="content-delivery__row">
 <strong class="content-delivery__subtitle">Доставка инженерной сантехники за пределы МКАД</strong>
				<p class="content-delivery__text">
					До 15 000 рублей – 500 руб. + 40 руб./1 км.<br>
					Свыше 15 000 рублей – 40 руб./1 км.
				</p>
			</div>
			<div class="content-delivery__row">
 <strong class="content-delivery__subtitle">Условия курьерской доставки бытовой сантехники</strong>
				<p class="content-delivery__text">
					В таблице указана стоимость доставки товара на один адрес в пределах МКАД.<br>
					Доставка за пределы МКАД: +40 руб. за 1 км. Расчет итоговой стоимости доставки<br>
					производится по одному самому крупному из общего заказа товару.
				</p>
				<table class="content-delivery__table delivery-table">
				<thead>
				<tr>
					<th>
						1 категория1000 ₽
					</th>
					<th>
						2 категория700 ₽
					</th>
					<th>
						3 категория500 ₽
					</th>
					<th>
						4 категория<br>
						Бесплатная доставка
					</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>
						душевые уголки,<br>
						боксы, кабины,<br>
						двери, перегородки;<br>
						ванны;<br>
						мебель для ванной<br>
						комнаты.
					</td>
					<td>
						раковины;<br>
						унитазы;<br>
						биде;<br>
						шторки на ванну;<br>
						системы инсталляции;<br>
						душевые системы.
					</td>
					<td>
						смесители;<br>
						душевая программа (кроме душевых панелей);<br>
						сифоны;<br>
						аксессуары;<br>
						душевые стойки;<br>
						полотенцесушители.
					</td>
					<td>
						смесители для душа, ванны, умывальники,<br>
						душевые системы, и стойки TIMO;<br>
						водяные полотенцесушители ДВИН;<br>
						водяные полотенцесушители TERMINUS;<br>
						электрические полотенцесушители ENERGY.
					</td>
				</tr>
				</tbody>
				</table>
			</div>
			<div class="content-delivery__row">
 <strong class="content-delivery__title">Доставка в другие регионы</strong>
				<p class="content-delivery__text">
					Доставка в другие регионы осуществляется силами выбранной покупателем транспортной компании после полной оплаты товара. Доставка до терминала в Москве производится согласно приведенным выше тарифам. На некоторые марки проходят акции*, где доставка будет бесплатной вне зависимости от суммы заказа.
				</p>
				<p class="content-delivery__notice">
					*Актуальную информацию по акциям уточняйте у консультанта по телефону или на сайте.
				</p>
			</div>
			<div class="content-delivery__row">
 <strong class="content-delivery__subtitle">Самовывоз</strong>
				<p class="content-delivery__text">
					Оставьте заявку на самовывоз по телефону или на сайте. Менеджер назначит удобное время визита в магазин.
				</p>
			</div>
			<div class="content-delivery__row">
 <strong class="content-delivery__subtitle">Яндекс.Доставка</strong>
				<p class="content-delivery__text">
					Сеть магазинов профессиональной сантехники «Большой мастер» подключена к сервису Яндекс.Доставка. Это очень удобно: оформляйте заказ в интернет-магазине и оплачивайте при получении
				</p>
			</div>
			<div class="content-delivery__row">
 <strong class="content-delivery__subtitle">Способы оплаты</strong>
				<p class="content-delivery__text">
					Товар можно оплатить несколькими способами.
				</p>
				<ul class="content-delivery__list">
					<li class="content-delivery__item">Наличными или пластиковой картой в магазине.</li>
					<li class="content-delivery__item">Наличными при доставке (для продукции, которая есть на складе, не под заказ и не по предоплате).</li>
					<li class="content-delivery__item">Банковским переводом (по выставленному счету).</li>
					<li class="content-delivery__item">Через Яндекс Кассу. Заказ оплачивается после его подтверждения менеджером и получения клиентом письма с ссылкой на оплату.</li>
				</ul>
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
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>