<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

						<section class="product-props">
							<strong class="product-props__title">Документация «<?=$arResult["NAME"]?>»</strong>
							<div class="row">
								<div class="col-lg-10 col-md-13 col-sm-18">
									
									<pre>
										<?print_r( $arResult['PROPERTIES']['FILES'] );?>
									</pre>
									
								</div>
								<div class="col-lg-5 col-lg-offset-6 col-md-6 col-md-offset-6 col-sm-7 col-sm-offset-5">
									<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/right_card.php");?>
								</div>
							</div>
						</section>