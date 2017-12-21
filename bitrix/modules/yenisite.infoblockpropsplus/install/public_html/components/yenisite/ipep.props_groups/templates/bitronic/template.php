<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
} ?>
<?if(method_exists($this, 'setFrameMode')) $this->setFrameMode(true);?>
<div class="yeni_ipep_props_groups">
    <table class="scheme-<?=$arParams['COLOR_SCHEME']?>">
		<tbody>
		<? foreach ($arResult['GROUPS'] as $groupID => $arGroup): ?>
			<? if ($groupID > 0): ?>
				<tr>
					<td colspan="2">
						<h2><?= $arGroup['NAME'] ?></h2>
					</td>
				</tr>
			<? endif ?>
			<? foreach ($arGroup['PROPS'] as $pid): ?>
				<? $arProperty = $arResult['DISPLAY_PROPERTIES'][$pid] ?>
				<tr class="prop_line">
					<td>
						<?= $arProperty["NAME"] ?>
						<? if (!empty($arResult['PROPS_COMMENTS'][$pid])): ?>
							<div title="<?= $arResult['PROPS_COMMENTS'][$pid] ?>" class="yeni_ipep_prop_with_comment_box"></div>
						<? endif ?>
					</td>
					<td>
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
			<? endforeach ?>
		<? endforeach ?>
		</tbody>
	</table>
</div>
