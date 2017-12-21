<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

						<section class="product-props">
							<strong class="product-props__title">Описание «<?=$arResult["NAME"]?>»</strong>
							<div class="row">
								<div class="col-lg-10 col-md-13 col-sm-18">
									<? if (CModule::IncludeModule('yenisite.infoblockpropsplus')): ?> 
										
										<?
											//очищаем не нуждные для вывода свойства
											$arNoShowProp = Array("NOVINKA", "ARTICUL", "DELIVERY_TIME","LIDER_PRODAZH", "DELIVERY", "FILES", "GARANTY", "CML2_ARTICLE", "RECOMMEND", "VIDEO");
											$arProperty = $arResult['DISPLAY_PROPERTIES'];
											foreach ( $arNoShowProp as $val){
												unset($arProperty[$val]);
											}
											$arResult['DISPLAY_PROPERTIES'] = $arProperty;
										?>
										
										<? $APPLICATION->IncludeComponent('yenisite:ipep.props_groups', 
											'', 
											array(
											'DISPLAY_PROPERTIES' => $arResult['DISPLAY_PROPERTIES'], 
											'IBLOCK_ID' => $arParams['IBLOCK_ID'],
											'SECTION_ID' => $arResult["SECTION"]["PATH"][0]["ID"],
											'SHORT_VIEW_GROUP' => Array(1,5)
											)); ?> 
									
									<?else:?>
								
										<table class="text">
											<?
											foreach($arResult["DISPLAY_PROPERTIES"] as $code=>$properties){
												if($code !== "RASPRODAZHA" && $code !== "DELIVERY_TIME" && $code !== "NOVINKA" && $code != "ARTICUL" && $code != "LIDER_PRODAZH" && $code != "DELIVERY" && $code != "FILES" && $code != "GARANTY" && $code != "CML2_ARTICLE" && $code != "RECOMMEND" && $code != "VIDEO"){
													?>
													<tr>
														<td><?=$properties["NAME"]?></td>
														<td>
															<?
															if(!empty($properties["DISPLAY_VALUE"])){
																echo strip_tags($properties["DISPLAY_VALUE"], "");
															}
															else{
																echo $properties["VALUE"];
															}
															?>
														</td>
													</tr>
													<?
												}
											}
											?>
										</table>
										<div class="file_block">
											<?
											if(!empty($arResult["PROPERTIES"]["FILES"]["VALUE"])){
												foreach($arResult["PROPERTIES"]["FILES"]["VALUE"] as $id_file){
													$arFile = CFile::GetFileArray($id_file);
													if(!empty($arFile["DESCRIPTION"])){
														echo '<a href="'.$arFile["SRC"].'">'.$arFile["DESCRIPTION"].'</a>';
													}
													else{
														echo '<a href="'.$arFile["SRC"].'">'.$arFile["FILE_NAME"].'</a>';
													}
												}
											}
											?>
										</div>
										<div class="clear"></div>
									<?endif;?>
								</div>
								<div class="col-lg-5 col-lg-offset-6 col-md-6 col-md-offset-6 col-sm-7 col-sm-offset-5">
									<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/right_card.php");?>
								</div>
							</div>
						</section>