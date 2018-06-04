<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");


?>

<div class="content-about__content">
	<div class="row">
		<div class="col-lg-24 col-md-24 col-sm-25 content-about__main content-delivery">


			<?$APPLICATION->IncludeComponent(
				"bitrix:sale.personal.order", 
				"order_list", 
				array(
					"SEF_MODE" => "Y",
					"SEF_FOLDER" => "/personal/order/",
					"ORDERS_PER_PAGE" => "10",
					"PATH_TO_PAYMENT" => "/personal/order/payment/",
					"PATH_TO_BASKET" => "/basket/",
					"SET_TITLE" => "Y",
					"SAVE_IN_SESSION" => "Y",
					"NAV_TEMPLATE" => "bigms",
					"SHOW_ACCOUNT_NUMBER" => "Y",
					"COMPONENT_TEMPLATE" => "order_list",
					"PROP_1" => array(
					),
					"PROP_2" => array(
					),
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "3600",
					"CACHE_GROUPS" => "Y",
					"CUSTOM_SELECT_PROPS" => array(
					),
					"HISTORIC_STATUSES" => array(
						"Y"
					),
					//"STATUS_COLOR_N" => "gray",
					//"STATUS_COLOR_O" => "gray",
					//"STATUS_COLOR_F" => "gray",
					"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
					"SEF_URL_TEMPLATES" => array(
						"list" => "index.php",
						"detail" => "detail/#ID#/",
						"cancel" => "cancel/#ID#/",
					)
				),
				false
			);?>
	</div>
				
		<div class="col-lg-6 col-md-6 col-sm-5 content-about__nav about-nav">
		<?

		$APPLICATION->IncludeComponent(
			"bitrix:main.include", 
			".default", 
			array(
				"AREA_FILE_SHOW" => "file",
				"PATH" => "/include/personal_menu.php",
				"EDIT_TEMPLATE" => "standard.php"
			),
			false
		);


		?>
		</div>
	</div>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>