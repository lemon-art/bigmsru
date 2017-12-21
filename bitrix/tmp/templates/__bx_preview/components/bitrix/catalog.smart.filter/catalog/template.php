<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);
?>
			<?/*
global $USER;
if ($USER->IsAdmin()){

	echo("<pre>");
	print_r($arResult["ITEMS"]);
	echo("</pre>");

}*/
?>

<?if(count($arResult["ITEMS"]) > 0){?>

<div class="bx_filter <?=$templateData["TEMPLATE_CLASS"]?>">
	<div class="bx_filter_section">

		<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>#downtofilter" method="get" class="smartfilter">
			<?foreach($arResult["HIDDEN"] as $arItem):?>
			<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
			<?endforeach;?>


			<? // Бренды
			echo '<script type="text/javascript">console.log(' . json_encode($arResult) . ');</script>';
			foreach($arResult["ITEMS"] as $key=>$arItem)
			{
				if($arItem["NAME"] == "Бренд"){
				?>
					<?if(count($arItem["VALUES"]) > 1):?>
					<div class="bx_filter_parameters_box padding_in <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>active<?endif?>" >
						<span class="bx_filter_container_modef"></span>
						<div class="bx_filter_parameters_box_title"><?=$arItem["NAME"]?>
							<?if ($arItem['HINT']):?>
								<div class="info-block">
									<div class="info-block-tooltip">
										<?=$arItem['HINT']?>
									</div>
								</div>
							<?endif;?>
						</div>
						<div class="bx_filter_block">
							<div class="bx_filter_parameters_box_container">
								<?foreach($arItem["VALUES"] as $val => $ar):?>
										<?if($ar["VALUE"] != ""):?>
											<span class="bx_filter_input_checkbox">
												<input
													type="checkbox"
													value="<? echo $ar["HTML_VALUE"] ?>"
													name="<? echo $ar["CONTROL_NAME"] ?>"
													id="<? echo $ar["CONTROL_ID"] ?>"
													<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
													onclick="smartFilter.click(this)"
												/>

												<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">

														<span class="bx_filter_param_text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
														if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
															?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
														endif;?></span>

												</label>
											</span>
										<?endif;?>
								<?endforeach;?>
							</div>
						</div>
					</div>
					<?endif?>
				<?
				}
			}
			?>


			<?
			//prices
			foreach($arResult["ITEMS"] as $key=>$arItem)
			{
				$key = $arItem["ENCODED_ID"];
				if(isset($arItem["PRICE"])){
					if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
						continue;
					?>
					<div class="bx_filter_parameters_box active padding_in">
						<span class="bx_filter_container_modef"></span>
						<div class="bx_filter_parameters_box_title" onclick="smartFilter.hideFilterProps(this)"><?=GetMessage("CT_BCSF_PRICE_TITLE")?>:</div>
						<div class="bx_filter_block price_ot_do">
							<div class="bx_filter_parameters_box_container">

								<div class="bx_filter_parameters_box_container_block">

									<div class="bx_filter_input_container">
										<div class="ot_do">От</div>
										<input
											class="min-price"
											type="text"
											name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
											id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
											value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
											size="5"
											onkeyup="smartFilter.keyup(this)"
										/>
									</div>
								</div>

								<div class="bx_filter_parameters_box_container_block">

									<div class="bx_filter_input_container">
										<div class="ot_do">до</div>
										<input
											class="max-price"
											type="text"
											name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
											id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
											value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
											size="5"
											onkeyup="smartFilter.keyup(this)"
										/>
									</div>
								</div>
								<!-- <div class="ot_do">р.</div> -->
								<div style="clear: both;"></div>

								<div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
									<?
									$price1 = $arItem["VALUES"]["MIN"]["VALUE"];
									$price2 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/4);
									$price3 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/2);
									$price4 = $arItem["VALUES"]["MIN"]["VALUE"] + round((($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])*3)/4);
									$price5 = $arItem["VALUES"]["MAX"]["VALUE"];
									?>
									<div class="bx_ui_slider_part p1"><span><?=$price1?></span></div>
									<div class="bx_ui_slider_part p2"><span><?=$price2?></span></div>
									<div class="bx_ui_slider_part p3"><span><?=$price3?></span></div>
									<div class="bx_ui_slider_part p4"><span><?=$price4?></span></div>
									<div class="bx_ui_slider_part p5"><span><?=$price5?></span></div>

									<div class="bx_ui_slider_pricebar_VD" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
									<div class="bx_ui_slider_pricebar_VN" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
									<div class="bx_ui_slider_pricebar_V"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
									<div class="bx_ui_slider_range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
										<a class="bx_ui_slider_handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
										<a class="bx_ui_slider_handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
									</div>
								</div>
								<div style="opacity: 0;height: 1px;"></div>
							</div>
						</div>
					</div>


					<?
					$precision = 2;
					if (Bitrix\Main\Loader::includeModule("currency"))
					{
						$res = CCurrencyLang::GetFormatDescription($arItem["VALUES"]["MIN"]["CURRENCY"]);
						$precision = $res['DECIMALS'];
					}
					$arJsParams = array(
						"leftSlider" => 'left_slider_'.$key,
						"rightSlider" => 'right_slider_'.$key,
						"tracker" => "drag_tracker_".$key,
						"trackerWrap" => "drag_track_".$key,
						"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
						"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
						"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
						"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
						"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
						"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
						"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
						"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
						"precision" => $precision,
						"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
						"colorAvailableActive" => 'colorAvailableActive_'.$key,
						"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
					);
					?>
					<script type="text/javascript">
						BX.ready(function(){
							window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
						});
					</script>

				<?
				}
			}?>


			<?/* // триггер Дополнительные параметры
			<div class="bx_filter_parameters_box active">
				<div class="toggle_dop_property"><span><?=GetMessage("CT_BCSF_DOP")?></span></div>
			</div>
			*/?>


			<div class="bx_filter_parameters_box no_pad" <?if(!empty($_GET["arrFilter_P1_MIN"]) || isset($_GET["searchFilter_P1_MIN"])){echo 'style="display: block !important;"';}?>>
				<?
				//not prices
				foreach($arResult["ITEMS"] as $key=>$arItem)
				{
					if(
						empty($arItem["VALUES"])
						|| isset($arItem["PRICE"])
					)
						continue;

					if (
						$arItem["DISPLAY_TYPE"] == "A"
						&& (
							$arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
						)
					)
						continue;

                    if (
						(isset($arItem["VALUES"]["MAX"])
						&& !isset($arItem["VALUES"]["MAX"]["VALUE"]))
                        || (isset($arItem["VALUES"]["MIN"])
						&& !isset($arItem["VALUES"]["MIN"]["VALUE"]))

					)
						continue;
					?>

					<?
					if($arItem["NAME"] != "Бренд"){
					?>
						<div class="bx_filter_parameters_box <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>active<?endif?>">
							<div class="clickable" onclick="smartFilter.hideFilterProps(this)">
								<span class="bx_filter_container_modef"></span>
								<div class="bx_filter_parameters_box_title"><?=$arItem["NAME"]?>
									<? if ($arItem['HINT'] != ''): ?>
										<div class="info-block">
											<div class="info-block-tooltip"><?= $arItem['HINT'] ?></div>
										</div>
									<? endif; ?>
								</div>
							</div>
							<div class="bx_filter_block">
								<div class="bx_filter_parameters_box_container">
								<?
								$arCur = current($arItem["VALUES"]);
								switch ($arItem["DISPLAY_TYPE"])
								{
									case "A"://NUMBERS_WITH_SLIDER
										?>
										<div class="bx_filter_parameters_box_container_block">
											<div class="bx_filter_input_container">
												<div class="ot_do">От</div>
												<input
													class="min-price"
													type="text"
													name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
													id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
													value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
													size="5"
													onkeyup="smartFilter.keyup(this)"
												/>
											</div>
										</div>
										<div class="bx_filter_parameters_box_container_block">
											<div class="bx_filter_input_container">
												<div class="ot_do">до</div>
												<input
													class="max-price"
													type="text"
													name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
													id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
													value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
													size="5"
													onkeyup="smartFilter.keyup(this)"
												/>
											</div>
										</div>
										<div style="clear: both;"></div>

										<div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
											<?
											$value1 = $arItem["VALUES"]["MIN"]["VALUE"];
											$value2 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/4);
											$value3 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/2);
											$value4 = $arItem["VALUES"]["MIN"]["VALUE"] + round((($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])*3)/4);
											$value5 = $arItem["VALUES"]["MAX"]["VALUE"];
											?>
											<div class="bx_ui_slider_part p1"><span><?=$value1?></span></div>
											<div class="bx_ui_slider_part p2"><span><?=$value2?></span></div>
											<div class="bx_ui_slider_part p3"><span><?=$value3?></span></div>
											<div class="bx_ui_slider_part p4"><span><?=$value4?></span></div>
											<div class="bx_ui_slider_part p5"><span><?=$value5?></span></div>

											<div class="bx_ui_slider_pricebar_VD" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
											<div class="bx_ui_slider_pricebar_VN" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
											<div class="bx_ui_slider_pricebar_V"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
											<div class="bx_ui_slider_range" 	id="drag_tracker_<?=$key?>"  style="left: 0;right: 0;">
												<a class="bx_ui_slider_handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
												<a class="bx_ui_slider_handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
											</div>
										</div>
										<div style="height:1px;"></div>
										<?
										$arJsParams = array(
											"leftSlider" => 'left_slider_'.$key,
											"rightSlider" => 'right_slider_'.$key,
											"tracker" => "drag_tracker_".$key,
											"trackerWrap" => "drag_track_".$key,
											"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
											"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
											"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
											"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
											"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
											"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
											"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
											"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
											"precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
											"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
											"colorAvailableActive" => 'colorAvailableActive_'.$key,
											"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
										);
										?>
										<script type="text/javascript">
											BX.ready(function(){
												window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
											});
										</script>
										<?
										break;
									case "B"://NUMBERS
										?>
										<div class="bx_filter_parameters_box_container_block"><div class="bx_filter_input_container">
											<div class="ot_do">От</div>
											<input
												class="min-price"
												type="text"
												name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
												/>
										</div></div>
										<div class="bx_filter_parameters_box_container_block"><div class="bx_filter_input_container">
											<div class="ot_do">до</div>
											<input
												class="max-price"
												type="text"
												name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
												/>
										</div></div>
										<?
										break;
									case "G"://CHECKBOXES_WITH_PICTURES
										?>
										<?foreach ($arItem["VALUES"] as $val => $ar):?>
											<input
												style="display: none"
												type="checkbox"
												name="<?=$ar["CONTROL_NAME"]?>"
												id="<?=$ar["CONTROL_ID"]?>"
												value="<?=$ar["HTML_VALUE"]?>"
												<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
											/>
											<?
											$class = "";
											if ($ar["CHECKED"])
												$class.= " active";
											if ($ar["DISABLED"])
												$class.= " disabled";
											?>
											<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label dib<?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');">
												<span class="bx_filter_param_btn bx_color_sl">
													<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
													<span class="bx_filter_btn_color_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
													<?endif?>
												</span>
											</label>
										<?endforeach?>
										<?
										break;
									case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
										?>
										<?foreach ($arItem["VALUES"] as $val => $ar):?>
											<input
												style="display: none"
												type="checkbox"
												name="<?=$ar["CONTROL_NAME"]?>"
												id="<?=$ar["CONTROL_ID"]?>"
												value="<?=$ar["HTML_VALUE"]?>"
												<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
											/>
											<?
											$class = "";
											if ($ar["CHECKED"])
												$class.= " active";
											if ($ar["DISABLED"])
												$class.= " disabled";
											?>
											<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');">
												<span class="bx_filter_param_btn bx_color_sl">
													<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
														<span class="bx_filter_btn_color_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
													<?endif?>
												</span>
												<span class="bx_filter_param_text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
												if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
													?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
												endif;?></span>
											</label>
										<?endforeach?>
										<?
										break;
									case "P"://DROPDOWN
										$checkedItemExist = false;
										?>
										<div class="bx_filter_select_container">
											<div class="bx_filter_select_block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
												<div class="bx_filter_select_text" data-role="currentOption">
													<?
													foreach ($arItem["VALUES"] as $val => $ar)
													{
														if ($ar["CHECKED"])
														{
															echo $ar["VALUE"];
															$checkedItemExist = true;
														}
													}
													if (!$checkedItemExist)
													{
														echo GetMessage("CT_BCSF_FILTER_ALL");
													}
													?>
												</div>
												<div class="bx_filter_select_arrow"></div>
												<input
													style="display: none"
													type="radio"
													name="<?=$arCur["CONTROL_NAME_ALT"]?>"
													id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
													value=""
												/>
												<?foreach ($arItem["VALUES"] as $val => $ar):?>
													<input
														style="display: none"
														type="radio"
														name="<?=$ar["CONTROL_NAME_ALT"]?>"
														id="<?=$ar["CONTROL_ID"]?>"
														value="<? echo $ar["HTML_VALUE_ALT"] ?>"
														<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
													/>
												<?endforeach?>
												<div class="bx_filter_select_popup" data-role="dropdownContent" style="display: none;">
													<ul>
														<li>
															<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx_filter_param_label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
																<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
															</label>
														</li>
													<?
													foreach ($arItem["VALUES"] as $val => $ar):
														$class = "";
														if ($ar["CHECKED"])
															$class.= " selected";
														if ($ar["DISABLED"])
															$class.= " disabled";
													?>
														<li>
															<label for="<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=$class?>" data-role="label_<?=$ar["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')"><?=$ar["VALUE"]?></label>
														</li>
													<?endforeach?>
													</ul>
												</div>
											</div>
										</div>
										<?
										break;
									case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
										?>
										<div class="bx_filter_select_container">
											<div class="bx_filter_select_block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
												<div class="bx_filter_select_text" data-role="currentOption">
													<?
													$checkedItemExist = false;
													foreach ($arItem["VALUES"] as $val => $ar):
														if ($ar["CHECKED"])
														{
														?>
															<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																<span class="bx_filter_btn_color_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
															<?endif?>
															<span class="bx_filter_param_text">
																<?=$ar["VALUE"]?>
															</span>
														<?
															$checkedItemExist = true;
														}
													endforeach;
													if (!$checkedItemExist)
													{
														?><span class="bx_filter_btn_color_icon all"></span> <?
														echo GetMessage("CT_BCSF_FILTER_ALL");
													}
													?>
												</div>
												<div class="bx_filter_select_arrow"></div>
												<input
													style="display: none"
													type="radio"
													name="<?=$arCur["CONTROL_NAME_ALT"]?>"
													id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
													value=""
												/>
												<?foreach ($arItem["VALUES"] as $val => $ar):?>
													<input
														style="display: none"
														type="radio"
														name="<?=$ar["CONTROL_NAME_ALT"]?>"
														id="<?=$ar["CONTROL_ID"]?>"
														value="<?=$ar["HTML_VALUE_ALT"]?>"
														<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
													/>
												<?endforeach?>
												<div class="bx_filter_select_popup" data-role="dropdownContent" style="display: none">
													<ul>
														<li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
															<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx_filter_param_label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
																<span class="bx_filter_btn_color_icon all"></span>
																<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
															</label>
														</li>
													<?
													foreach ($arItem["VALUES"] as $val => $ar):
														$class = "";
														if ($ar["CHECKED"])
															$class.= " selected";
														if ($ar["DISABLED"])
															$class.= " disabled";
													?>
														<li>
															<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=$class?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
																<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																	<span class="bx_filter_btn_color_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																<?endif?>
																<span class="bx_filter_param_text">
																	<?=$ar["VALUE"]?>
																</span>
															</label>
														</li>
													<?endforeach?>
													</ul>
												</div>
											</div>
										</div>
										<?
										break;
									case "K"://RADIO_BUTTONS
										?>
										<label class="bx_filter_param_label" for="<? echo "all_".$arCur["CONTROL_ID"] ?>">
											<span class="bx_filter_input_checkbox">
												<input
													type="radio"
													value=""
													name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
													id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
													onclick="smartFilter.click(this)"
												/>
												<span class="bx_filter_param_text"><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
											</span>
										</label>
										<?foreach($arItem["VALUES"] as $val => $ar):?>
											<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label" for="<? echo $ar["CONTROL_ID"] ?>">
												<span class="bx_filter_input_checkbox <? echo $ar["DISABLED"] ? 'disabled': '' ?>">
													<input
														type="radio"
														value="<? echo $ar["HTML_VALUE_ALT"] ?>"
														name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
														id="<? echo $ar["CONTROL_ID"] ?>"
														<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
														onclick="smartFilter.click(this)"
													/>
													<span class="bx_filter_param_text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
													if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
														?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
													endif;?></span>
												</span>
											</label>
										<?endforeach;?>
										<?
										break;
									case "U"://CALENDAR
										?>
										<div class="bx_filter_parameters_box_container_block"><div class="bx_filter_input_container bx_filter_calendar_container">
											<?$APPLICATION->IncludeComponent(
												'bitrix:main.calendar',
												'',
												array(
													'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
													'SHOW_INPUT' => 'Y',
													'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
													'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
													'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
													'SHOW_TIME' => 'N',
													'HIDE_TIMEBAR' => 'Y',
												),
												null,
												array('HIDE_ICONS' => 'Y')
											);?>
										</div></div>
										<div class="bx_filter_parameters_box_container_block"><div class="bx_filter_input_container bx_filter_calendar_container">
											<?$APPLICATION->IncludeComponent(
												'bitrix:main.calendar',
												'',
												array(
													'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
													'SHOW_INPUT' => 'Y',
													'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
													'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
													'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
													'SHOW_TIME' => 'N',
													'HIDE_TIMEBAR' => 'Y',
												),
												null,
												array('HIDE_ICONS' => 'Y')
											);?>
										</div></div>
										<div class="bx_filter_parameters_box_container_block"><div class="bx_filter_input_container">
											Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, a, sint nobis autem nisi nihil dolorem error illo fuga delectus minima tempore. Quidem, aperiam, eius voluptas delectus aspernatur ipsam dignissimos!
										</div></div>
										<?
										break;
									default://CHECKBOXES
										?>
										<?foreach($arItem["VALUES"] as $val => $ar):?>

												<span class="bx_filter_input_checkbox">
													<input
														type="checkbox"
														value="<? echo $ar["HTML_VALUE"] ?>"
														name="<? echo $ar["CONTROL_NAME"] ?>"
														id="<? echo $ar["CONTROL_ID"] ?>"
														<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
														onclick="smartFilter.click(this)"
													/>

													<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">

															<span class="bx_filter_param_text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
															if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
															endif;?></span>

													</label>
												</span>
										<?endforeach;?>
								<?
								}
								?>
								</div>
								<div class="clb"></div>
							</div>
						</div>
					<?}?>
				<?
				}
				?>
			</div>

			<div class="clb"></div>
			<div class="bx_filter_button_box active border_no">
				<div class="bx_filter_block">
					<div class="bx_filter_parameters_box_container">
						<input class="bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
						<!-- Задача 4.3.5-->
						<!-- <input type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" /> -->
						<a href="javascript:void(0)" id="del_filter" name="del_filter" class="reset-form"><i class="icon-blue-close"></i><span><?=GetMessage("CT_BCSF_DEL_FILTER")?></span></a>
						<!-- 4.3.5-->
						<?$arParams["POPUP_POSITION"] = 'right';?>
						<div class="bx_filter_popup_result <?=$arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
							<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
							<span class="arrow"></span>
							<a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div style="clear: both;"></div>
	</div>
</div>

<?$this->SetViewTarget('smart_filter_block');?>
	<?

	//извини за говнокод((
	//другого решения не нашел(не js же плашку скрывать)
	//слава Битриксу!

	$toPrint = [];

	echo '<!--test';
	print_r($arResult['ITEMS']);
	echo "-->";

	foreach ($arResult['ITEMS'] as $item) {
		if (($item['PROPERTY_TYPE'] == 'L') && (count($item['VALUES']) > 0)) {
			$checkedItems = [];

			foreach($item['VALUES'] as $key=>$value) {
				if ($value['CHECKED'] == 1) {
					$checkedItems[$key]['VALUE'] = $value['VALUE'];
					$checkedItems[$key]['CONTROL_ID'] = $value['CONTROL_ID'];
					$checkedItems[$key]['URL_ID'] = $value['URL_ID'];
					$checkedItems[$key]['PARAM'] = $item['CODE'];
				}
			}

			if (count($checkedItems) > 0) {
				$text = '<div class="filter__col">
							<span class="filter__text">'.$item["NAME"].'</span>
							<ul class="filter_list">';
				foreach ($checkedItems as $checkItem) {
					$text .= '<li><span>'.$checkItem["VALUE"].'</span><a href="#"><i class="close-white" data-param="'.$checkItem['PARAM'].'" data-url="'.$checkItem['URL_ID'].'" data-id="'.$checkItem["CONTROL_ID"].'"></i></a></li>';
				}

				$text .='</ul>
							</div>';
				array_push($toPrint, $text);
			}
		} elseif ($item['PROPERTY_TYPE'] == 'S') {
			$checkedItems = [];

			foreach($item['VALUES'] as $key=>$value) {
				if ($value['CHECKED'] == 1) {
					$checkedItems[$key]['VALUE'] = $value['VALUE'];
					$checkedItems[$key]['CONTROL_ID'] = $value['CONTROL_ID'];
					$checkedItems[$key]['URL_ID'] = $value['URL_ID'];
					$checkedItems[$key]['PARAM'] = $item['CODE'];
				}
			}

			if (count($checkedItems) > 0) {
				$text = '<div class="filter__col">
							<span class="filter__text">'.$item["NAME"].'</span>
							<ul class="filter_list">';
				foreach ($checkedItems as $checkItem) {
					$text .= '<li><span>'.$checkItem["VALUE"].'</span><a href="#"><i class="close-white" data-param="'.$checkItem['PARAM'].'" data-url="'.$checkItem['URL_ID'].'" data-id="'.$checkItem["CONTROL_ID"].'"></i></a></li>';
				}

				$text .='</ul>
							</div>';
				array_push($toPrint, $text);
			}
		} elseif ($item['PROPERTY_TYPE'] == 'N') {
			if ((isset($item['VALUES']['MIN']['HTML_VALUE']) && $item['VALUES']['MIN']['HTML_VALUE'])
            || (isset($item['VALUES']['MAX']['HTML_VALUE']) && $item['VALUES']['MAX']['HTML_VALUE'])) {
				if (isset($item['VALUES']['MIN']['HTML_VALUE']) && $item['VALUES']['MIN']['HTML_VALUE'] != '') {
					$minValue = number_format($item['VALUES']['MIN']['HTML_VALUE'], 2, '.', ' ');
					$show = true;
				} else {
					$minValue = number_format($item['VALUES']['MIN']['VALUE'], 2, '.', ' ');
				}

				if ($item['VALUES']['MAX']['HTML_VALUE'] != '') {
					$maxValue = number_format($item['VALUES']['MAX']['HTML_VALUE'], 2, '.', ' ');
					$show = true;
				} else {
					$maxValue = number_format($item['VALUES']['MAX']['VALUE'], 2, '.', ' ');
				}

				if ($show == true) {
					$text =    '<div class="filter__col">
									<span class="filter__text">'.$item["NAME"].'</span>
									<ul class="filter_list">
										<li><span>'.$minValue.' - '.$maxValue.'</span><a href="#"><i class="close-white range" data-param="'.$item['CODE'].'" data-max-id="'.$item['VALUES']['MAX']['CONTROL_ID'].'" data-min-id="'.$item['VALUES']['MIN']['CONTROL_ID'].'"></i></a></li>
									</ul>
								</div>';
					array_push($toPrint, $text);
				}
			}
		} elseif (($item['PROPERTY_TYPE'] == 'L') && (count($item['VALUES']) > 0)) {
			$checkedItems = [];

			foreach ($item['VALUES'] as $key => $value) {
				if ($value['CHECKED'] == 1) {
					$checkedItems[$key]['VALUE'] = $value['VALUE'];
					$checkedItems[$key]['CONTROL_ID'] = $value['CONTROL_ID'];
				}
			}

			if (count($checkedItems) > 0) {
				$text = '<div class="filter__col">
							<span class="filter__text">' . $item["NAME"] . '</span>
							<ul class="filter_list">';
				foreach ($checkedItems as $checkItem) {
					$text .= '<li><span>' . $checkItem["VALUE"] . '</span><a href="#"><i class="close-white" data-id="' . $checkItem["CONTROL_ID"] . '"></i></a></li>';
				}

				$text .= '</ul>
							</div>';
				array_push($toPrint, $text);
			}
		} elseif ($item['ID'] == 1) {
			$show = false;

			if ($item['VALUES']['MIN']['HTML_VALUE'] != '') {
				$minValue = number_format($item['VALUES']['MIN']['HTML_VALUE'], 2, '.', ' ');
				$show = true;
			} else {
				$minValue = number_format($item['VALUES']['MIN']['VALUE'], 2, '.', ' ');
			}

			if ($item['VALUES']['MAX']['HTML_VALUE'] != '') {
				$maxValue = number_format($item['VALUES']['MAX']['HTML_VALUE'], 2, '.', ' ');
				$show = true;
			} else {
				$maxValue = number_format($item['VALUES']['MAX']['VALUE'], 2, '.', ' ');
			}

			if ($show == true) {
				$text = '<div class="filter__col">
								<span class="filter__text">Цена:</span>
								<ul class="filter_list">
										<li><span>'.$minValue.' - '.$maxValue.' руб.</span><a href="#"><i class="close-white price" data-param="price" data-max_price="'.$item["VALUES"]["MAX"]["VALUE"].'" data-min_price="'.$item["VALUES"]["MIN"]["VALUE"].'"></i></a></li>
								</ul>
							</div>';
				array_push($toPrint, $text);
			}
		}

	}

	?>
	<? if (count($toPrint) > 0): ?>
		<div class="filter" id="downtofilter">
		<span class="filter__title">ПОКАЗЫВАТЬ:</span>
		<a href="#" class="reset-filter"><span>Сбросить фильтры</span><i class="close-white all"></i></a>
		<div class="filter__results">
			<div class="filter__row">
				<?

				foreach ($toPrint as  $text) {
					echo $text;
				}

				?>
			</div>
		</div>
	</div>
	<? endif; ?>
<?$this->EndViewTarget();?>

<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', 'vertical');
</script>

<?}?>
