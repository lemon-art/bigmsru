<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личные данные");


?>
<div class="content-about__content">
	<div class="row">
		<div class="col-lg-24 col-md-24 col-sm-25 content-about__main content-delivery">
		
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.profile", 
				"change_profile", 
				array(
					"SET_TITLE" => "N",
					"COMPONENT_TEMPLATE" => "change_profile",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"USER_PROPERTY" => array(
						0 => "UF_TYPE",
						1 => "UF_INN",
						2 => "UF_OGRN",
						3 => "UF_KPP",
						4 => "UF_OKPO",
						5 => "UF_OKATO",
						6 => "UF_BIK",
						7 => "UF_RCH",
						8 => "UF_BANK",
						9 => "UF_KCH",
					),
					"SEND_INFO" => "N",
					"CHECK_RIGHTS" => "N",
					"USER_PROPERTY_NAME" => ""
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

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>