<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "О компании. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "О компании - Большой мастер");
$APPLICATION->SetTitle("О компании");

?>

				<div class="content-about__content">
                  <div class="row">
                    <div class="col-lg-20 col-md-20 col-sm-20 content-about__main content-guarantee">
						<p class="content-delivery__text">Наша компания уже много лет работает на рынке инженерных систем, и за эти годы смогла наладить индивидуальные партнерские отношение с проверенными поставщиками продукции и брендовыми производителями, благодаря чему мы можем гарантировать отличную цену изделий, при неизменно высоком качестве. «Большой Мастер» – это эталон взаимовыгодного сотрудничества, и каждый покупатель может рассчитывать на качественный сервис, своевременную обработку заказа и выполнение наших обязательств в полном объеме.</p>
						<br><br><br><br><br><br><br><br>
					</div>
                    <div class="col-lg-6 col-lg-offset-4 col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-4 content-about__nav about-nav">
                      <?$APPLICATION->IncludeComponent(
								"bitrix:menu",
								"about",
								array(
									"ROOT_MENU_TYPE" => "left",
									"MENU_CACHE_TYPE" => "Y",
									"MENU_CACHE_TIME" => "36000000",
									"MENU_CACHE_USE_GROUPS" => "N",
									"MENU_CACHE_GET_VARS" => array(),
									"MAX_LEVEL" => "1",
									"CHILD_MENU_TYPE" => "left",
									"USE_EXT" => "N",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N",
									"COMPONENT_TEMPLATE" => "menu"
								),
								false,
								array(
									"ACTIVE_COMPONENT" => "Y"
								)
						);?>
                    </div>
                  </div>
                </div>






<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>