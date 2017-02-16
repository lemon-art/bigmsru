<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "О компании. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "О компании - Большой мастер");
$APPLICATION->SetTitle("О компании");


echo '<div class="padding">';

$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/right_menu_about.php",
		"EDIT_TEMPLATE" => "standard.php",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);
?>

<div class="left_text_about">Наша компания уже много лет работает на рынке инженерных систем, и за эти годы смогла наладить индивидуальные партнерские отношение с проверенными поставщиками продукции и брендовыми производителями, благодаря чему мы можем гарантировать отличную цену изделий, при неизменно высоком качестве. «Большой Мастер» – это эталон взаимовыгодного сотрудничества, и каждый покупатель может рассчитывать на качественный сервис, своевременную обработку заказа и выполнение наших обязательств в полном объеме.</div>

<?
echo '
</div>
<div class="about_infogr">
	<div class="item">
		<div class="img" style="background-image:url('.SITE_TEMPLATE_PATH.'/images/aboit_info1.png);"></div>
		<div class="title">';
			$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/aboit_info1.php",
		"EDIT_TEMPLATE" => "standard.php",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);
echo '	</div>
	</div>
	<div class="item">
		<div class="img" style="background-image:url('.SITE_TEMPLATE_PATH.'/images/aboit_info2.png);"></div>
		<div class="title">';
			$APPLICATION->IncludeComponent(
				"bitrix:main.include", 
				".default", 
				array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => "/include/aboit_info2.php",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);
echo '	</div>
	</div>
	<div class="item">
		<div class="img" style="background-image:url('.SITE_TEMPLATE_PATH.'/images/aboit_info3.png);"></div>
		<div class="title">';
			$APPLICATION->IncludeComponent(
				"bitrix:main.include", 
				".default", 
				array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => "/include/aboit_info3.php",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);
echo '	</div>
	</div>
	<div class="item">
		<div class="img" style="background-image:url('.SITE_TEMPLATE_PATH.'/images/aboit_info4.png);"></div>
		<div class="title">';
			$APPLICATION->IncludeComponent(
				"bitrix:main.include", 
				".default", 
				array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => "/include/aboit_info4.php",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);
echo '	</div>
	</div>
	<div class="item">
		<div class="img" style="background-image:url('.SITE_TEMPLATE_PATH.'/images/aboit_info5.png);"></div>
		<div class="title">';
			$APPLICATION->IncludeComponent(
				"bitrix:main.include", 
				".default", 
				array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => "/include/aboit_info5.php",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);
echo '	</div>
	</div>
	<div class="clear"></div>
</div>
';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>