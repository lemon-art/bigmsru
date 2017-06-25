<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Гарантия и возврат. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "Гарантия и возврат - Большой мастер");
$APPLICATION->SetTitle("Гарантия и возврат");


?>

				<div class="content-about__content">
                  <div class="row">
                    <div class="col-lg-20 col-md-20 col-sm-20 content-about__main content-guarantee">
                      <div class="content-guarantee__row">
                        <strong class="content-guarantee__title">Во избежание недоразумений</strong>
                        <ul class="content-guarantee__list">
                          <li class="content-guarantee__item">В момент получения товара от курьера или на складе магазина убедитесь в отсутствии дефектов и полноте комплектации заказа.</li>
                          <li class="content-guarantee__item">При обнаружении недостатков, не подписывайте акт приема-передачи, а свяжитесь с менеджером для прояснения ситуации и согласования дальнейших взаимных действий.</li>
                        </ul>
                        <p class="content-guarantee__notice">В случае принятия товара покупателем, претензии по внешнему виду и комплектации не принимаются – магазин несет ответственность за внешний вид товара до момента его передачи покупателю (см. ст. 458 и 459 ГК РФ).</p>
                      </div>
                      <div class="content-guarantee__row">
                        <strong class="content-guarantee__title">Условия возврата товара</strong>
                        <p class="content-guarantee__text">Купленный товар можно вернуть в срок до двух месяцев при соблюдении следующих условий:</p>
                        <ul class="content-guarantee__list">
                          <li class="content-guarantee__item">товар не был в употреблении, его потребительские свойства полностью сохранены;</li>
                          <li class="content-guarantee__item">на руках у покупателя сохранилась упаковка, пломбы, ярлыки, товарный или кассовый чек и вся сопроводительная документация;</li>
                          <li class="content-guarantee__item">товар технически исправен, не имеет вмятин, трещин, царапин, сколов и других механических повреждений.</li>
                        </ul>
                        <p class="content-guarantee__text">При выявлении скрытых производственных дефектов мы обменяем товар на аналогичный исправный или вернем вам деньги. Возврату подлежит уплаченная покупателем сумма в размере стоимости возвращаемого товара за вычетом расходов на его доставку.</p>
                      </div>
                      <div class="content-guarantee__row">
                        <strong class="content-guarantee__title">Условия возврата товара</strong>
                        <p class="content-guarantee__text">Мы сами решаем гарантийные вопросы, освобождаем клиентов от общения с сервис-центрами. Если купленное изделие вышло из строя до завершения срока гарантии в результате производственного брака, мы сами свяжемся с авторизованным сервисным центром и приложим все усилия, чтобы решить возникшую проблему.</p>
                      </div>
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