<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
} ?>
 


<?
//$arResult['MORE_GROUPS'][count($arResult['MORE_GROUPS'])] = $arResult['MORE_GROUPS'][0];
//unset( $arResult['MORE_GROUPS'][0] );

//if ( count($arResult['GROUPS']) < 1){
	$arResult['NO_GROUP'] = $arResult['MORE_GROUPS'][0];
	unset( $arResult['MORE_GROUPS'][0] );
	$arResult['GROUPS'] = array_merge($arResult['GROUPS'], $arResult['MORE_GROUPS']);
	unset( $arResult['MORE_GROUPS'] );
	
//}

?>


<?if(method_exists($this, 'setFrameMode')) $this->setFrameMode(true);?>

		<?if ( count( $arResult['NO_GROUP']['PROPS'] ) > 0 ):?>
			<div class="product-props__item tech-props">
                <table class="product-props__table tech-props__table">
				
				<? foreach ($arResult['NO_GROUP']['PROPS'] as $pid): ?>
				<? $arProperty = $arResult['DISPLAY_PROPERTIES'][$pid] ?>
				<?if ( $arProperty["CODE"] !== 'DELIVERY' ):?>
					<tr class="tech-props__row">
						<td class="tech-props__td">
							<?= $arProperty["NAME"] ?>
							<? if (!empty($arResult['PROPS_COMMENTS'][$pid])): ?>
								<div title="<?=$arResult['PROPS_COMMENTS'][$pid] ?>" class="yeni_ipep_prop_with_comment_box"></div>
							<? endif ?>
						</td>
						<td class="tech-props__td">
							<?

							if ($arProperty['PROPERTY_TYPE'] == 'L'):
								if (is_array($arProperty['DISPLAY_VALUE'])){
									echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
								}else{
									echo $arProperty['DISPLAY_VALUE'];
								}
							else:

								if ($arProperty['MULTIPLE']=='Y' && $arProperty['PROPERTY_TYPE'] != 'F'):
								/*  foreach ($arProperty["DISPLAY_VALUE"] as &$p) {
										if (substr_count($p, "a href") > 0) {
											$p = strip_tags($p);
										}
									} */
									
									if (is_array($arProperty["DISPLAY_VALUE"])){
										echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
									}else{
										echo $arProperty["DISPLAY_VALUE"];
									}
									
								elseif ($pid && $pid == "MANUAL"):
								
									?>
									<a href="<?= $arProperty["VALUE"] ?>"><?= GetMessage("CATALOG_DOWNLOAD") ?></a>
									<? 
									
								elseif ($arProperty['PROPERTY_TYPE'] == 'F'):
									if ($arProperty['MULTIPLE'] == 'Y'){
										if (is_array($arProperty['DISPLAY_VALUE'])){
											foreach ($arProperty['DISPLAY_VALUE'] as $n => $value):
												echo $n > 0 ? ', ' : '';
												echo str_replace('</a>', ' ' . $arProperty['DESCRIPTION'][$n] . '</a>', $value);
											endforeach; 
										}else{
											echo str_replace('</a>', ' ' . $arProperty['DESCRIPTION'][0] . '</a>', $arProperty['DISPLAY_VALUE']);
										}
									}else{
										echo str_replace('</a>', ' ' . $arProperty['DESCRIPTION'] . '</a>', $arProperty['DISPLAY_VALUE']);
									}
								else:
									//if (substr_count($arProperty["DISPLAY_VALUE"], "a href") > 0) {
									//	$arProperty["DISPLAY_VALUE"] = strip_tags($arProperty["DISPLAY_VALUE"]);
									//}
									echo $arProperty["DISPLAY_VALUE"];
									if ($arParams['SHOW_PROPERTY_VALUE_DESCRIPTION'] != 'N') {
										echo ' ', $arProperty['DESCRIPTION'];
									}
								endif;
							endif;
							?>
						</td>
					</tr>
				<?endif;?>
			<? endforeach ?>
			    </table>
			</div>
				
		<?endif;?>


		<? foreach ($arResult['GROUPS'] as $groupID => $arGroup): ?>
			<div class="product-props__item tech-props">
                <strong class="product-props__subtitle"><?= $arGroup['NAME'] ?></strong>
                <table class="product-props__table tech-props__table">

			
			<? foreach ($arGroup['PROPS'] as $pid): ?>
				<? $arProperty = $arResult['DISPLAY_PROPERTIES'][$pid] ?>
				<?if ( $arProperty["CODE"] !== 'DELIVERY' ):?>
					<tr class="tech-props__row">
						<td class="tech-props__td">
							<?= $arProperty["NAME"] ?>
							<? if (!empty($arResult['PROPS_COMMENTS'][$pid])): ?>
								<div title="<?=$arResult['PROPS_COMMENTS'][$pid] ?>" class="yeni_ipep_prop_with_comment_box"></div>
							<? endif ?>
						</td>
						<td class="tech-props__td">
							<?

							if ($arProperty['PROPERTY_TYPE'] == 'L'):
								if (is_array($arProperty['DISPLAY_VALUE'])){
									echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
								}else{
									echo $arProperty['DISPLAY_VALUE'];
								}
							else:

								if ($arProperty['MULTIPLE']=='Y' && $arProperty['PROPERTY_TYPE'] != 'F'):
								/*  foreach ($arProperty["DISPLAY_VALUE"] as &$p) {
										if (substr_count($p, "a href") > 0) {
											$p = strip_tags($p);
										}
									} */
									
									if (is_array($arProperty["DISPLAY_VALUE"])){
										echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
									}else{
										echo $arProperty["DISPLAY_VALUE"];
									}
									
								elseif ($pid && $pid == "MANUAL"):
								
									?>
									<a href="<?= $arProperty["VALUE"] ?>"><?= GetMessage("CATALOG_DOWNLOAD") ?></a>
									<? 
									
								elseif ($arProperty['PROPERTY_TYPE'] == 'F'):
									if ($arProperty['MULTIPLE'] == 'Y'){
										if (is_array($arProperty['DISPLAY_VALUE'])){
											foreach ($arProperty['DISPLAY_VALUE'] as $n => $value):
												echo $n > 0 ? ', ' : '';
												echo str_replace('</a>', ' ' . $arProperty['DESCRIPTION'][$n] . '</a>', $value);
											endforeach; 
										}else{
											echo str_replace('</a>', ' ' . $arProperty['DESCRIPTION'][0] . '</a>', $arProperty['DISPLAY_VALUE']);
										}
									}else{
										echo str_replace('</a>', ' ' . $arProperty['DESCRIPTION'] . '</a>', $arProperty['DISPLAY_VALUE']);
									}
								else:
									//if (substr_count($arProperty["DISPLAY_VALUE"], "a href") > 0) {
									//	$arProperty["DISPLAY_VALUE"] = strip_tags($arProperty["DISPLAY_VALUE"]);
									//}
									echo $arProperty["DISPLAY_VALUE"];
									if ($arParams['SHOW_PROPERTY_VALUE_DESCRIPTION'] != 'N') {
										echo ' ', $arProperty['DESCRIPTION'];
									}
								endif;
							endif;
							?>
						</td>
					</tr>
				<?endif;?>
			<? endforeach ?>
			    </table>
			</div>
		<? endforeach ?>

			<? foreach ($arResult['MORE_GROUPS'] as $groupID => $arGroup): ?>
				
				<div class="product-props__item tech-props">
					<strong class="product-props__subtitle"><?= $arGroup['NAME'] ?></strong>
					<table class="product-props__table tech-props__table">
				
				<? foreach ($arGroup['PROPS'] as $pid): ?>
					<? $arProperty = $arResult['DISPLAY_PROPERTIES'][$pid]; ?>
					<?if ( $arProperty["CODE"] !== 'DELIVERY' ):?>
						<tr class="tech-props__row">
							<td class="tech-props__td">
								<?= $arProperty["NAME"] ?>
								<? if (!empty($arResult['PROPS_COMMENTS'][$pid])): ?>
									<div title="<?= $arResult['PROPS_COMMENTS'][$pid] ?>" class="yeni_ipep_prop_with_comment_box"></div>
								<? endif ?>
							</td>
							<td class="tech-props__td">
								<?

								if ($arProperty['PROPERTY_TYPE'] == 'L'):
									if (is_array($arProperty['DISPLAY_VALUE'])){
										echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
									}else{
										echo $arProperty['DISPLAY_VALUE'];
									}
								else:

									if ($arProperty['MULTIPLE']=='Y' && $arProperty['PROPERTY_TYPE'] != 'F'):
									/*  foreach ($arProperty["DISPLAY_VALUE"] as &$p) {
											if (substr_count($p, "a href") > 0) {
												$p = strip_tags($p);
											}
										} */
										
										if (is_array($arProperty["DISPLAY_VALUE"])){
											echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
										}else{
											echo $arProperty["DISPLAY_VALUE"];
										}
										
									elseif ($pid && $pid == "MANUAL"):
									
										?>
										<a href="<?= $arProperty["VALUE"] ?>"><?= GetMessage("CATALOG_DOWNLOAD") ?></a>
										<? 
										
									elseif ($arProperty['PROPERTY_TYPE'] == 'F'):
										if ($arProperty['MULTIPLE'] == 'Y'){
											if (is_array($arProperty['DISPLAY_VALUE'])){
												foreach ($arProperty['DISPLAY_VALUE'] as $n => $value):
													echo $n > 0 ? ', ' : '';
													echo str_replace('</a>', ' ' . $arProperty['DESCRIPTION'][$n] . '</a>', $value);
												endforeach; 
											}else{
												echo str_replace('</a>', ' ' . $arProperty['DESCRIPTION'][0] . '</a>', $arProperty['DISPLAY_VALUE']);
											}
										}else{
											echo str_replace('</a>', ' ' . $arProperty['DESCRIPTION'] . '</a>', $arProperty['DISPLAY_VALUE']);
										}
									else:
										if (substr_count($arProperty["DISPLAY_VALUE"], "a href") > 0) {
											$arProperty["DISPLAY_VALUE"] = strip_tags($arProperty["DISPLAY_VALUE"]);
										}
										echo $arProperty["DISPLAY_VALUE"];
										if ($arParams['SHOW_PROPERTY_VALUE_DESCRIPTION'] != 'N') {
											echo ' ', $arProperty['DESCRIPTION'];
										}
									endif;
								endif;
								?>
							</td>
						</tr>
					<?endif;?>
				<? endforeach ?>
					</table>
				</div>
			<? endforeach ?>
			<?/*
			<? if ( count($arResult['MORE_GROUPS']) > 0):?>
					<tr class="short_groups">
						<td colspan="2">
							<a href="#" id="show_more_groups">Все характеристики</a>
						</td>
					</tr>
					<tr class="more_groups">
						<td colspan="2">
							<a href="#tab_content1" id="hide_more_groups">Основные характеристики</a>
						</td>
					</tr>
			<?endif;?>
			*/?>

	

