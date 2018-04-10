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

<div class="filter">

	<div class="filter__header">
        <strong class="filter__title">Фильтры</strong>
        <a href="#" id="del_filter" name="del_filter" class="filter__clear reset-filter">Очистить</a>
    </div>

	
	<?
	$text = '';
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
				$text .= '
					<li class="filter-result__item">
                      <span class="filter-result__name">'.$item["NAME"].'</span>';
				foreach ($checkedItems as $checkItem) {
					$text .= '<span class="filter-result__value">'.$checkItem["VALUE"].'<span class="filter-result__delete" data-param="'.$checkItem['PARAM'].'" data-url="'.$checkItem['URL_ID'].'" data-id="'.$checkItem["CONTROL_ID"].'"></span></span>';
				}
				$text .= '</li>';
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
				$text .= '<li class="filter-result__item">
							<span class="filter-result__name">'.$item["NAME"].'</span>
							';
				foreach ($checkedItems as $checkItem) {
					$text .= '<span class="filter-result__value">'.$checkItem["VALUE"].'<span class="filter-result__delete" data-param="'.$checkItem['PARAM'].'" data-url="'.$checkItem['URL_ID'].'" data-id="'.$checkItem["CONTROL_ID"].'"></span></span>';
				}
				$text .= '</li>';

				
			}
		} elseif ($item['PROPERTY_TYPE'] == 'N') {
			if ((isset($item['VALUES']['MIN']['HTML_VALUE']) && $item['VALUES']['MIN']['HTML_VALUE'])
            || (isset($item['VALUES']['MAX']['HTML_VALUE']) && $item['VALUES']['MAX']['HTML_VALUE'])) {
				if (isset($item['VALUES']['MIN']['HTML_VALUE']) && $item['VALUES']['MIN']['HTML_VALUE'] != '') {
					$minValue = number_format($item['VALUES']['MIN']['HTML_VALUE'], 0, '.', ' ');
					$show = true;
				} else {
					$minValue = number_format($item['VALUES']['MIN']['VALUE'], 0, '.', ' ');
				}

				if ($item['VALUES']['MAX']['HTML_VALUE'] != '') {
					$maxValue = number_format($item['VALUES']['MAX']['HTML_VALUE'], 0, '.', ' ');
					$show = true;
				} else {
					$maxValue = number_format($item['VALUES']['MAX']['VALUE'], 0, '.', ' ');
				}

				if ($show == true) {
					$text .= '<li class="filter-result__item">
							<span class="filter-result__name">'.$item["NAME"].'</span>
							';
					$text .= '<span class="filter-result__value">'.$minValue.' - '.$maxValue.'<span class="filter-result__delete range" data-param="'.$item['CODE'].'" data-max-id="'.$item['VALUES']['MAX']['CONTROL_ID'].'" data-min-id="'.$item['VALUES']['MIN']['CONTROL_ID'].'"></span></span>';
					$text .= '</li>';
	
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
					$text .= '<li class="filter-result__item">
							<span class="filter-result__name">'.$item["NAME"].'</span>
							';
					foreach ($checkedItems as $checkItem) {
						$text .= '<span class="filter-result__value">' . $checkItem["VALUE"] . '<span class="filter-result__delete" data-param="'.$checkItem['PARAM'].'" data-url="'.$checkItem['URL_ID'].'" data-id="'.$checkItem["CONTROL_ID"].'"></span></span>';
					}
					$text .= '</li>';

			}
		} elseif ($item['ID'] == 1) {
			$show = false;

			if ($item['VALUES']['MIN']['HTML_VALUE'] != '') {
				$minValue = number_format($item['VALUES']['MIN']['HTML_VALUE'], 0, '.', ' ');
				$show = true;
			} else {
				$minValue = number_format($item['VALUES']['MIN']['VALUE'], 0, '.', ' ');
			}

			if ($item['VALUES']['MAX']['HTML_VALUE'] != '') {
				$maxValue = number_format($item['VALUES']['MAX']['HTML_VALUE'], 0, '.', ' ');
				$show = true;
			} else {
				$maxValue = number_format($item['VALUES']['MAX']['VALUE'], 0, '.', ' ');
			}

			if ($show == true) {
					$text .= '<li class="filter-result__item">
							<span class="filter-result__name">Цена:</span>
							<span class="filter-result__value">'.$minValue.' - '.$maxValue.' руб.<span class="filter-result__delete price" data-param="price" data-max_price="'.$item["VALUES"]["MAX"]["VALUE"].'" data-min_price="'.$item["VALUES"]["MIN"]["VALUE"].'"></span></span>
					</li>';
			
			}
		}

	}
	?>

		<?if ( $text !== '' ):?>
		    <div class="filter-result">
				<strong class="filter-result__title">Вы выбрали:</strong>
				<ul class="filter-result__list">
					<?=$text?>
				</ul>
			</div>
		<?endif;?>
		
		<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>#downtofilter" method="get" class="smartfilter filter-form">
			<?foreach($arResult["HIDDEN"] as $arItem):?>
			<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
			<?endforeach;?>


			<? // Бренды
			foreach($arResult["ITEMS"] as $key=>$arItem){
				if($arItem["NAME"] == "Бренд"){
				?>
					<?if(count($arItem["VALUES"]) > 1):?>
					<div class="bx_filter_parameters_box filter-form__section <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>opened<?endif?>" >
						<span class="bx_filter_container_modef"></span>
						<strong class="filter-form__title"><?=$arItem["NAME"]?></strong>
							<?/*
							<?if ($arItem['HINT']):?>
								<div class="info-block">
									<div class="info-block-tooltip">
										<?=$arItem['HINT']?>
									</div>
								</div>
							<?endif;?>
							*/?>
							
						<div class="filter-form__content <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>opened<?endif?>">
								<?$n = 0;?>
								<?foreach($arItem["VALUES"] as $val => $ar):?>
										<?if($ar["VALUE"] != ""):?>
												
												<div class="n-filter-block__item">

														<input
															type="checkbox"
															value="<? echo $ar["HTML_VALUE"] ?>"
															name="<? echo $ar["CONTROL_NAME"] ?>"
															id="<? echo $ar["CONTROL_ID"] ?>"
															<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
															onclick="smartFilter.click(this)"
															class="filter-form__checkbox bx_filter_input_checkbox"
														/>
														<span class="checkbox-custom"></span>
													<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="filter-form__name bx_filter_param_label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">

															<span class="bx_filter_param_text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
															if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
															endif;?></span>

													</label>
												</div>
										<?endif;?>
								<?endforeach;?>
										
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
					<div class="filter-form__section bx_filter_parameters_box opened">
						<span class="bx_filter_container_modef"></span>
						<strong class="filter-form__title">Цена, ₽</strong>
						<div class="filter-form__content opened">
						  <div class="filter-form__wrap">
							<div class="filter-form__input-wrap filter-form__input-wrap_from">
								<input
											class="filter-form__input from_price"
											type="text"
											name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
											id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
											value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
											size="5"
											onkeyup="smartFilter.keyup(this)"
								/>
							</div>
							<div class="filter-form__input-wrap filter-form__input-wrap_to">
										<input
											class="filter-form__input to_price"
											type="text"
											name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
											id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
											value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
											size="5"
											onkeyup="smartFilter.keyup(this)"
										/>
							</div>
						  </div>
						  <div id="drag_track_<?=$key?>" class="filter-form__range"></div>
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
						
							  var Slider<?=$key?> = $('#drag_track_<?=$key?>').slider({
								range: true,
								min: <?=$arJsParams["minPrice"]?>,
								max: <?=$arJsParams["maxPrice"]?>,
								values: [ <?if ($arJsParams["curMinPrice"]){echo $arJsParams["curMinPrice"];}else{echo $arJsParams["minPrice"];}?>, <?if ($arJsParams["curMaxPrice"]){echo $arJsParams["curMaxPrice"];}else{echo $arJsParams["maxPrice"];}?> ],
								slide: function( event, ui ) {
								  $('#<?=$arJsParams["minInputId"]?>').val(ui.values[0]);
								  $('#<?=$arJsParams["maxInputId"]?>').val(ui.values[1]);
								},
								create: function( event, ui ) {
								  $('#<?=$arJsParams["minInputId"]?>').attr('placeholder', '<?=round($arJsParams["minPrice"])?>');
								  $('#<?=$arJsParams["maxInputId"]?>').attr('placeholder', '<?=round($arJsParams["maxPrice"])?>');
								},
								change: function( event, ui ) {
									
									if ( ui.values[0] == $('#<?=$arJsParams["minInputId"]?>').attr('placeholder') ){
										$('#<?=$arJsParams["minInputId"]?>').val('').keyup();
									}
									else {
										$('#<?=$arJsParams["minInputId"]?>').val(ui.values[0]).keyup();
									}
									

									if ( ui.values[1] == $('#<?=$arJsParams["maxInputId"]?>').attr('placeholder') ){
										$('#<?=$arJsParams["maxInputId"]?>').val('');
									}
									else {
										$('#<?=$arJsParams["maxInputId"]?>').val(ui.values[1]).keyup();
									}
								}
							  });
							  
							  $('#<?=$arJsParams["minInputId"]?>').on('change', function() {
								Slider<?=$key?>.slider( "option", "values", [ $(this).val(), $('#<?=$arJsParams["maxInputId"]?>').val() ] );
							  });
							  $('#<?=$arJsParams["maxInputId"]?>').on('change', function() {
								Slider<?=$key?>.slider( "option", "values", [ $('#<?=$arJsParams["minInputId"]?>').val(), $(this).val() ] );
							  });
						
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
						<div class="filter-form__section bx_filter_parameters_box <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>opened<?endif?>">
							<span class="bx_filter_container_modef"></span>
							<strong class="filter-form__title"><?=$arItem["NAME"]?></strong>


							<div class="filter-form__content <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>opened<?endif?>">
								
								<?
								foreach ($arItem["VALUES"] as $key => $sortkey) {
									$values[$key]  = $sortkey['VALUE'];
								}
								array_multisort($values, SORT_ASC, $arItem['VALUES']);
								unset($values);
								
								
								
								$arCur = current($arItem["VALUES"]);
								switch ($arItem["DISPLAY_TYPE"])
								{
									case "A"://NUMBERS_WITH_SLIDER
										?>
										<div class="filter-form__wrap">
											<div class="filter-form__input-wrap filter-form__input-wrap_from">
											<input
														class="filter-form__input from_price"
														type="text"
														name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
														id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
														value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
														size="5"
														onkeyup="smartFilter.keyup(this)"
											/>
											</div>
											<div class="filter-form__input-wrap filter-form__input-wrap_to">
														<input
															class="filter-form__input to_price"
															type="text"
															name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
															id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
															value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
															size="5"
															onkeyup="smartFilter.keyup(this)"
														/>
											</div>
										  </div>
										  <div id="drag_track_<?=$key?>" class="filter-form__range"></div>
										
										
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
											
												  var Slider<?=$key?> = $('#drag_track_<?=$key?>').slider({
													range: true,
													min: <?=$arJsParams["minPrice"]?>,
													max: <?=$arJsParams["maxPrice"]?>,
													values: [ <?if ($arJsParams["curMinPrice"]){echo $arJsParams["curMinPrice"];}else{echo $arJsParams["minPrice"];}?>, <?if ($arJsParams["curMaxPrice"]){echo $arJsParams["curMaxPrice"];}else{echo $arJsParams["maxPrice"];}?> ],
													slide: function( event, ui ) {
													  $('#<?=$arJsParams["minInputId"]?>').val(ui.values[0]);
													  $('#<?=$arJsParams["maxInputId"]?>').val(ui.values[1]);
													},
													create: function( event, ui ) {
													  $('#<?=$arJsParams["minInputId"]?>').attr('placeholder', '<?=round($arJsParams["minPrice"])?>');
													  $('#<?=$arJsParams["maxInputId"]?>').attr('placeholder', '<?=round($arJsParams["maxPrice"])?>');
													},
													change: function( event, ui ) {
														
														if ( ui.values[0] == $('#<?=$arJsParams["minInputId"]?>').attr('placeholder') ){
															$('#<?=$arJsParams["minInputId"]?>').val('').keyup();
														}
														else {
															$('#<?=$arJsParams["minInputId"]?>').val(ui.values[0]).keyup();
														}
														

														if ( ui.values[1] == $('#<?=$arJsParams["maxInputId"]?>').attr('placeholder') ){
															$('#<?=$arJsParams["maxInputId"]?>').val('');
														}
														else {
															$('#<?=$arJsParams["maxInputId"]?>').val(ui.values[1]).keyup();
														}
													}
												  });
												  
												  $('#<?=$arJsParams["minInputId"]?>').on('change', function() {
													Slider<?=$key?>.slider( "option", "values", [ $(this).val(), $('#<?=$arJsParams["maxInputId"]?>').val() ] );
												  });
												  $('#<?=$arJsParams["maxInputId"]?>').on('change', function() {
													Slider<?=$key?>.slider( "option", "values", [ $('#<?=$arJsParams["minInputId"]?>').val(), $(this).val() ] );
												  });
											
												window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
											});
										</script>
										<?
										break;
									case "B"://NUMBERS
										?>
											<div class="filter-form__wrap">
												<div class="filter-form__input-wrap filter-form__input-wrap_from">
												<input
															class="filter-form__input from_price"
															type="text"
															name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
															id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
															value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
															size="5"
															onkeyup="smartFilter.keyup(this)"
												/>
												</div>
												<div class="filter-form__input-wrap filter-form__input-wrap_to">
															<input
																class="filter-form__input to_price"
																type="text"
																name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
																id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
																value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
																size="5"
																onkeyup="smartFilter.keyup(this)"
															/>
												</div>
											</div>
										  <div id="drag_track_<?=$key?>" class="filter-form__range"></div>
										
										
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
											
												  var Slider<?=$key?> = $('#drag_track_<?=$key?>').slider({
													range: true,
													min: <?=$arJsParams["minPrice"]?>,
													max: <?=$arJsParams["maxPrice"]?>,
													values: [ <?if ($arJsParams["curMinPrice"]){echo $arJsParams["curMinPrice"];}else{echo $arJsParams["minPrice"];}?>, <?if ($arJsParams["curMaxPrice"]){echo $arJsParams["curMaxPrice"];}else{echo $arJsParams["maxPrice"];}?> ],
													slide: function( event, ui ) {
													  $('#<?=$arJsParams["minInputId"]?>').val(ui.values[0]);
													  $('#<?=$arJsParams["maxInputId"]?>').val(ui.values[1]);
													},
													create: function( event, ui ) {
													  $('#<?=$arJsParams["minInputId"]?>').attr('placeholder', '<?=round($arJsParams["minPrice"])?>');
													  $('#<?=$arJsParams["maxInputId"]?>').attr('placeholder', '<?=round($arJsParams["maxPrice"])?>');
													},
													change: function( event, ui ) {
														
														if ( ui.values[0] == $('#<?=$arJsParams["minInputId"]?>').attr('placeholder') ){
															$('#<?=$arJsParams["minInputId"]?>').val('').keyup();
														}
														else {
															$('#<?=$arJsParams["minInputId"]?>').val(ui.values[0]).keyup();
														}
														

														if ( ui.values[1] == $('#<?=$arJsParams["maxInputId"]?>').attr('placeholder') ){
															$('#<?=$arJsParams["maxInputId"]?>').val('');
														}
														else {
															$('#<?=$arJsParams["maxInputId"]?>').val(ui.values[1]).keyup();
														}
													}
												  });
												  
												  $('#<?=$arJsParams["minInputId"]?>').on('change', function() {
													Slider<?=$key?>.slider( "option", "values", [ $(this).val(), $('#<?=$arJsParams["maxInputId"]?>').val() ] );
												  });
												  $('#<?=$arJsParams["maxInputId"]?>').on('change', function() {
													Slider<?=$key?>.slider( "option", "values", [ $('#<?=$arJsParams["minInputId"]?>').val(), $(this).val() ] );
												  });
											
												window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
											});
										</script>
										<?
										break;
									case "G"://CHECKBOXES_WITH_PICTURES
										?>
										<?foreach ($arItem["VALUES"] as $val => $ar):?>
											<input
												style="display: none"
												class="filter-form__checkbox"
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
												class="filter-form__checkbox"
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
										<?$n = 0;?>
										<?foreach($arItem["VALUES"] as $val => $ar):?>

											<?/*
											<?//if ( $n++ > 11 ):?>
												<div class="filter-form__content-wrap">
											<?//endif;?>
											*/?>
												<div class="n-filter-block__item">
												
													
													<input
														type="checkbox"
														class="filter-form__checkbox"
														value="<? echo $ar["HTML_VALUE"] ?>"
														name="<? echo $ar["CONTROL_NAME"] ?>"
														id="<? echo $ar["CONTROL_ID"] ?>"
														<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
														onclick="smartFilter.click(this)"
													/>
													<span class="checkbox-custom"></span>
													<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="filter-form__name <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">

															<?=$ar["VALUE"];?><?
															if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
															endif;?>

													</label> 
													
												</div>
										<?endforeach;?>
										<?/*
										<?if ( $n > 11 ):?>
											</div>
											<a href="#" class="filter-form__more">Показать еще</a>
										<?endif;?>
										*/?>
								<?
								}
								?>
							</div>
						</div>
					<?}?>
				<?
				}
				?>
			


			<div class="bx_filter_button_box active border_no filter-form__range" id="width_range" >
				<div class="bx_filter_block">
					<div class="bx_filter_parameters_box_container">
						<!-- 4.3.5-->
						<?$arParams["POPUP_POSITION"] = 'left';?>
						<div class="bx_filter_popup_result filter-form__range-popup <?=$arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
							<span id="modef_num"><?=intval($arResult["ELEMENT_COUNT"])?> товаров</span>
							<a href="<?echo $arResult["FILTER_URL"]?>">Показать</a>
						</div>
					</div>
				</div>
			</div>
			<input class="bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
		</form>
</div>


<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', 'vertical', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>

<?}?>
