<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Проектирование системы отопления. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "Проектирование системы отопления - Большой мастер");
$APPLICATION->SetTitle("Проектирование системы отопления");

echo '<div class="left_text">';
?>
<div class="spec_page">
<h4> <b>&nbsp;МЫ ПРЕДЛАГАЕМ:</b> </h4>
<ul>
	<li>Консультацию по готовому проекту.</li>
	<li>
	Анализ с обоснованием готового проекта.</li>
	<li>
	Анализ выбранного оборудования в проекте.</li>
	<li>
	Подготовку смет согласно проекта или плана Вашего дома.</li>
</ul>
<h4><br>
 </h4>
<h4><b>&nbsp;Для чего нужно проектирование?</b></h4>
 &nbsp;Грамотное и тщательное составление полного пакета проектной документации по всем вышеперечисленным этапам обеспечивает качественное и своевременное выполнение дальнейших работ по установке необходимого оборудования и строительства надежных систем отопления, канализации и водоснабжения.<br>
 <br>
 &nbsp;Такой ответственный этап, как проектирование инженерных систем, следует доверить только профессионалам. Стремясь сэкономить на специалистах, Вы рискуете понести больше расходов, чем если бы Вы обратились за качественными услугами. Проектирование — один из наиболее важных и сложных процессов, который необходимо осуществлять строго по определенным этапам.<br>
 <br>
 &nbsp;Нужен проект инженерных систем в Вашем доме — тогда обращайтесь в нашу компанию, и Вам будут предоставлены услуги опытных специалистов, которые выполнят необходимые работы на высоком уровне и в кратчайшие сроки.<br>
 <br>
 &nbsp;Все наши консультации и работы связанные с формированием Вашей системы отопления абсолютно бесплатны!!! В-первую очередь мы заинтересованы в качестве и надежности Вашей системы инженерных сооружений!<br>
 <br>
 &nbsp;Более того, при приобретении продукции у нас по предлагаемым нами сметам ДОПОЛНИТЕЛЬНЫЕ СКИДКИ!!! <br>
</div>
 <?
echo '</div>';

$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	".default",
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/right_uslugi_menu.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);

echo '<div class="clear"></div>';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
