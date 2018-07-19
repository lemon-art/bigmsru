<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Быстрый расчет сметы");
?>

		<p class="content-text">Наши специалисты имеют огромный профессиональный и опыт и готовы помочь и проконсультировать вас.</p>
		<section class="promo-adv">
			<h2 class="promo-adv__title">Как быстро получить расчет сметы на сантехнику</h2>
			<ul class="promo-adv__list">
				<li class="promo-adv__item">Заполните форму на сайте,<br>или отправить данные нам для анализа <br>и пересчета нам на email.</li>
				<li class="promo-adv__item">
					Мы проверим вашу смету и поможем <b>сэкономить</b> <br>на комплектующих:<br>
					- пересчитаем количество товара;<br>
					- предложим альтернативные цены;<br>
					- детализируем укрупненные позиции;<br>
					- исключим лишнее;<br>
					- добавим необходимое;<br>
				</li>
				<li class="promo-adv__item">Наши специалисты <b>в течении рабочего</b> для произведут анализ и расчет и как результат вы <b>сэкономьте до 30%</b> на сантехнике за счет исправления ошибок в смете.</li>
			</ul>
		</section>
		<section class="text-block">
		
			<h2>Заполните форму</h2>
		
			<?$APPLICATION->IncludeComponent(
				"bitrix:form.result.new",
				"estimate",
				Array(
					"WEB_FORM_ID" => "4",
					"IGNORE_CUSTOM_TEMPLATE" => "N",
					"USE_EXTENDED_ERRORS" => "N",
					"SEF_MODE" => "N",
					"VARIABLE_ALIASES" => array("WEB_FORM_ID"=>"","RESULT_ID"=>"",),
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"LIST_URL" => "",
					"EDIT_URL" => "",
					"SUCCESS_URL" => "",
					"CHAIN_ITEM_TEXT" => "",
					"CHAIN_ITEM_LINK" => "",
					"AJAX_MODE" => "Y",
					"AJAX_OPTION_SHADOW" => "N",
					"AJAX_OPTION_JUMP" => "Y",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N"
				)
			);?>

		</section>
		<section class="text-block">
			
			<p class="content-text">Данная услуга для вас абсолютно бесплатна.</p>
		</section>
		<br><br>
		
		
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>