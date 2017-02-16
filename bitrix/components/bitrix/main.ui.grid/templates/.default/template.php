<?php

use \Bitrix\Main\Text;
use \Bitrix\Main\Page;
use \Bitrix\Main\Grid;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

include '_grid_prolog.php';
?>

<div class="main-grid <?=!$arParams["ALLOW_HORIZONTAL_SCROLL"] ? "main-grid-full" : "" ?>" id="<?=$pGridId ?>" data-ajaxid="<?=$arParams["AJAX_ID"]?>">
	<form name="form_<?=$pGridId ?>" action="<?=POST_FORM_ACTION_URI; ?>" method="POST">
	<?=bitrix_sessid_post() ?>

	<div class="main-grid-wrapper<?=!$arParams["ALLOW_HORIZONTAL_SCROLL"] ? "main-grid-full" : "" ?>">
		<div class="<?=$arParams["ALLOW_HORIZONTAL_SCROLL"] ? "main-grid-fade" : "" ?>">
			<div class="main-grid-container <?=$prepareGridClass(); ?>">
				<table class="main-grid-table" id="<?=$pGridId ?>_table" style="<?=$prepareGridTableWidth()?>">
					<? if (!$arResult['BX_isGridAjax']): ?>
						<thead class="main-grid-header" data-relative="<?=$pGridId ?>">
							<tr class="main-grid-row-head">
								<? if ($arParams["SHOW_ROW_CHECKBOXES"]): ?>
									<th class="main-grid-cell-head main-grid-cell-static main-grid-cell-checkbox">
									<? if ($arParams["SHOW_CHECK_ALL_CHECKBOXES"]): ?>
										<span class="main-grid-cell-head-container">
											<span class="main-grid-checkbox-container main-grid-head-checkbox-container">
												<input class="main-grid-checkbox main-grid-row-checkbox main-grid-check-all" id="<?=$pGridId ?>_check_all" type="checkbox" title="<?=getMessage('interface_grid_check_all') ?>"<? if (!$arResult['ALLOW_EDIT']): ?> disabled<? endif ?>>
												<label class="main-grid-checkbox" for="<?=$pGridId ?>_check_all"></label>
											</span>
										</span>
									<? endif; ?>
									</th>

									<? if ($arParams["SHOW_GRID_SETTINGS_MENU"] || $arParams["SHOW_ROW_ACTIONS_MENU"]) : ?>
										<th class="main-grid-cell-head main-grid-cell-static main-grid-cell-action">
											<? if ($arParams["SHOW_GRID_SETTINGS_MENU"]) : ?>
												<span class="main-grid-interface-settings-icon"
														  onclick="bxGrid_<?=$pGridId ?>.menu.ShowMenu(this, bxGrid_<?=$pGridId ?>.settingsMenu, false, false); return false; "></span>
											<? endif; ?>
										</th>
									<? endif; ?>

								<? endif ?>
								<? foreach ($arResult['COLUMNS'] as $id => $header) : ?>
									<? $isHidden = !array_key_exists($id, $arResult['COLUMNS']); ?>
									<th
										class="main-grid-cell-head <?=$header["class"]?> <?=$arParams["ALLOW_COLUMNS_SORT"] ? " main-grid-draggable" : ""?>"
										data-name="<?=$id?>"
										data-sort-url="<?=$header["sort_url"]?>"
										data-sort-by="<?=$header["sort"]?>"
										data-sort-order="<?=$header["next_sort_order"]?>"
										<? if($header["width"] <> ''): ?>style="width: <?=$header["width"]?>px"<? endif ?>>
										<span class="main-grid-cell-head-container">
											<span class="main-grid-head-title"><?=($header["showname"] ? $header["name"] : "&nbsp;"); ?></span>
											<? if ($arParams["ALLOW_COLUMNS_RESIZE"] && $header["resizeable"] !== false) : ?>
												<span class="main-grid-resize-button" onclick="event.stopPropagation(); " title=""></span>
											<? endif; ?>
											<? if ($header["sort"] && $arParams["ALLOW_SORT"]) : ?>
												<span class="main-grid-control-sort main-grid-control-sort-<?=$header["sort_state"] ? $header["sort_state"] : "hover-".$header["order"]?>"></span>
											<? endif; ?>
										</span>
									</th>
								<? endforeach ?>
								<th class="main-grid-cell-head main-grid-cell-static main-grid-special-empty"></th>
							</tr>
						</thead>
					<? endif ?>
					<tbody>
						<? if (empty($arParams['ROWS'])): ?>
							<tr class="main-grid-row main-grid-row-empty">
								<td class="main-grid-cell main-grid-cell-center" colspan="<?=count($arParams['COLUMNS']) ?>"><?=getMessage('interface_grid_no_data') ?></td>
							</tr>
						<? else: ?>
							<? foreach($arParams['ROWS'] as $arRow): ?>
								<?$rowClasses = isset($arRow['columnClasses']) && is_array($arRow['columnClasses'])
									? $arRow['columnClasses'] : array();
								?>
								<? if (!empty($arRow["custom"])) : ?>
									<tr class="main-grid-row main-grid-row-body main-grid-row-custom">
										<td colspan="<?=count($arResult["COLUMNS"]) + 2?>" class="main-grid-cell main-grid-cell-center">
											<div class="main-grid-cell-content"><?=$arRow["custom"]?></div>
										</td>
									</tr>
								<? else : ?>
									<? $data_id = $arRow["id"]; ?>
									<? $actions = \Bitrix\Main\Web\Json::encode($arRow["actions"]); ?>
									<? $actions = \Bitrix\Main\Text\Converter::getHtmlConverter()->encode($actions); ?>
									<tr class="main-grid-row main-grid-row-body"
										data-id="<?=$data_id ?>">
										<? if ($arParams["SHOW_ROW_CHECKBOXES"]): ?>
											<td class="main-grid-cell main-grid-cell-checkbox">
											<span class="main-grid-checkbox-container">
													<input type="checkbox" class="main-grid-row-checkbox main-grid-checkbox" name="ID[]" value="<?=$data_id ?>"
														<? if ($arRow['editable'] !== false): ?>
															title="<?=getMessage('interface_grid_check') ?>" id="checkbox_<?=$pGridId ?>_<?=$data_id ?>"
														<? endif ?>
														<? if (!$arResult['ALLOW_EDIT'] || $arRow['editable'] === false): ?>
															data-disabled="1" disabled
														<? endif ?>>
													<label class="main-grid-checkbox" for="checkbox_<?=$pGridId ?>_<?=$data_id ?>"></label>
												</span>
											</td>
										<? endif ?>
										<? if ($arParams["SHOW_ROW_ACTIONS_MENU"] || $arParams["SHOW_GRID_SETTINGS_MENU"]) : ?>
											<td class="main-grid-cell main-grid-cell-action">
												<? if (!empty($arRow["actions"]) && $arParams["SHOW_ROW_ACTIONS_MENU"]) : ?>
													<span class="main-grid-action-container">
														<a href="#" class="main-grid-row-action-button" data-actions="<?=$actions?>"></a>
													</span>
												<? endif ?>
											</td>
										<? endif; ?>

										<? foreach ($arResult['COLUMNS'] as $id => $header): ?>
											<?
												if (is_array($arRow["editable"]) && !empty($arRow["editable"]))
												{
													$header["editable"] = $arRow["editable"];
												}
												else
												{
													$header["editable"]["VALUE"] = $arRow["columns"][$header["id"]];
												}

												$className = "main-grid-cell";
												if($header['align'])
												{
													$className .= " main-grid-cell-{$header['align']}";
												}
												if(isset($rowClasses[$id]))
												{
													$className .= " {$rowClasses[$id]}";
												}
											?>
											<td class="<?=$className?>"
												data-edit="<?=\Bitrix\Main\Text\Converter::getHtmlConverter()->encode(\Bitrix\Main\Web\Json::encode($header["editable"]))?>">
												<span class="main-grid-cell-content">
												<?
													if($header["type"] == "checkbox" && ($arRow["columns"][$header["id"]] == 'Y' || $arRow["columns"][$header["id"]] == 'N'))
													{
														echo ($arRow["columns"][$header["id"]] == 'Y'? GetMessage("interface_grid_yes"):GetMessage("interface_grid_no"));
													}
													else
													{
														echo $arRow["columns"][$header["id"]];
													}
												?>
												</span>
											</td>
										<? endforeach ?>
										<td class="main-grid-cell"></td>
									</tr>
								<? endif; ?>
							<? endforeach ?>
							<? if (!empty($arResult['AGGREGATE'])): ?>
								<tr class="main-grid-row-foot main-grid-aggr-row" id="datarow_<?=$pGridId ?>_bxaggr">
									<? if ($arResult['ALLOW_GROUP_ACTIONS']): ?><td class="main-grid-cell-foot"></td><? endif ?>
									<? if ($arParams['ALLOW_ROW_ACTIONS']): ?><td class="main-grid-cell-foot"></td><? endif ?>
									<? foreach ($arResult['COLUMNS'] as $id => $header): ?>
										<? $isHidden = !array_key_exists($id, $arResult['COLUMNS']); ?>
										<td class="main-grid-cell-foot <? if ($header['align']) echo 'main-grid-cell-', $header['align']; ?>"
											<? if ($isHidden): ?>style="display: none; "<? endif ?>>
											<span class="main-grid-cell-content main-grid-cell-text-line">
												<? if (!$isHidden && !empty($arResult['AGGREGATE'][$id])): ?>
													<? foreach ($arResult['AGGREGATE'][$id] as $item): ?>
														<?=$item; ?><br>
													<? endforeach ?>
												<? else: ?>
													&nbsp;
												<? endif ?>
											</span>
										</td>
									<? endforeach ?>
									<td class="main-grid-cell-foot"></td>
								</tr>
							<? endif ?>
						<? endif ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="main-grid-bottom-panels" id="<?=$pGridId ?>_bottom_panels">
		<div class="main-grid-nav-panel">
			<div class="main-grid-more" id="<?=$pGridId ?>_nav_more">
				<a href="<?=$arResult["NEXT_PAGE_URL"]?>" class="main-grid-more-btn" <? if (!$arResult["SHOW_MORE_BUTTON"] || !$arParams["SHOW_MORE_BUTTON"] || !count($arResult["ROWS"])): ?>style="display: none; "<? endif ?>>
					<span class="main-grid-more-text"><?=getMessage('interface_grid_nav_more') ?></span>
					<span class="main-grid-more-load-text"><?=getMessage('interface_grid_load') ?></span>
					<span class="main-grid-more-icon"></span>
				</a>
			</div>

			<? if ($arParams["SHOW_NAVIGATION_PANEL"]) : ?>
			<div class="main-grid-panel-wrap">
				<table class="main-grid-panel-table">
					<tr>
						<? if ($arParams["SHOW_ROW_CHECKBOXES"] && $arParams["SHOW_CHECK_ALL_CHECKBOXES"]) : ?>
							<td class="main-grid-panel-cell main-grid-cell-checkbox">
								<span class="main-grid-checkbox-container main-grid-panel-checkbox-container">
									<input class="main-grid-checkbox main-grid-row-checkbox main-grid-check-all" id="<?=$pGridId ?>_panel_check_all" type="checkbox" title="<?=getMessage('interface_grid_check_all') ?>"<? if (!$arResult['ALLOW_EDIT']): ?> disabled<? endif ?>>
									<label class="main-grid-checkbox" for="<?=$pGridId ?>_panel_check_all"></label>
								</span>
							</td>
						<? endif ?>
						<? if ($arParams["SHOW_SELECTED_COUNTER"]) : ?>
						<td class="main-grid-panel-cell main-grid-panel-counter main-grid-cell-left">
							<div class="main-grid-panel-content">
								<span class="main-grid-panel-content-title"><?=getMessage('interface_grid_checked') ?></span>&nbsp;<?
								?><span class="main-grid-panel-content-text"><?
								?><span class="main-grid-counter-selected">0</span><?
									?>&nbsp;/&nbsp;<?
									?><span class="main-grid-counter-displayed"><?=count($arResult["ROWS"])?></span>
								</span>
							</div>
						</td>
						<? endif; ?>
						<? if ($arParams["SHOW_TOTAL_COUNTER"] && (!empty($arResult["TOTAL_ROWS_COUNT"]) || !empty($arParams["TOTAL_ROWS_COUNT_HTML"]))) : ?>
						<td class="main-grid-panel-total main-grid-panel-cell main-grid-cell-left">
							<div class="main-grid-panel-content">
								<? if (empty($arParams["TOTAL_ROWS_COUNT_HTML"])) : ?>
									<span class="main-grid-panel-content-title"><?=GetMessage("interface_grid_total")?>:</span><?
									?>&nbsp;<span class="main-grid-panel-content-text"><?=count($arResult["ROWS"]) ? $arResult["TOTAL_ROWS_COUNT"] : 0?></span>
								<? else : ?>
									<?=Text\HtmlConverter::getHtmlConverter()->decode($arParams["TOTAL_ROWS_COUNT_HTML"])?>
								<? endif; ?>
							</div>
						</td>
						<? endif; ?>
						<td class="main-grid-panel-cell main-grid-panel-cell-pagination main-grid-cell-left">
							<? if ($arParams["SHOW_PAGINATION"] && count($arResult["ROWS"])) : ?>
								<?=Bitrix\Main\Text\Converter::getHtmlConverter()->decode($arResult["NAV_STRING"]);?>
							<? endif; ?>
						</td>
						<td class="main-grid-panel-cell main-grid-panel-limit main-grid-cell-right">
							<? if ($arParams["SHOW_PAGESIZE"] && is_array($arParams["PAGE_SIZES"]) && count($arParams["PAGE_SIZES"]) > 0) : ?>
								<? $pageSize = $arResult['OPTIONS']['views'][$arResult['OPTIONS']['current_view']]['page_size'] ?: 20; ?>
								<span class="main-grid-panel-content">
									<span class="main-grid-panel-content-title"><?=getMessage('interface_grid_page_size') ?></span>

									<div class="main-dropdown main-grid-popup-control main-grid-panel-select-pagesize"
										 id="<?=$arParams["GRID_ID"]?>_grid_page_size"
										 data-value="<?=$pageSize;?>"
										 data-items="<?=$arResult["PAGE_SIZES_JSON"]?>">
										<?=$pageSize; ?>
									</div>

								</span>
							<? endif; ?>
						</td>
					</tr>
				</table>
			</div>
			<? endif; ?>
		</div>

		<? if ($arParams["SHOW_ACTION_PANEL"] && isset($arParams["ACTION_PANEL"]) && !empty($arParams["ACTION_PANEL"]) && is_array($arParams["ACTION_PANEL"]["GROUPS"])) : ?>
		<div class="main-grid-action-panel">
			<div class="main-grid-control-panel-wrap">
				<table class="main-grid-control-panel-table">
					<tr class="main-grid-control-panel-row">
						<? foreach ($arParams["ACTION_PANEL"]["GROUPS"] as $groupKey => $group) : ?>
							<td class="main-grid-control-panel-cell<?=$group["CLASS"] ? " ".$group["CLASS"] : "" ?>">
								<? foreach ($group["ITEMS"] as $itemKey => $item) : ?>
									<? if ($item["TYPE"] === "CHECKBOX") : ?><?
										?><span class="main-grid-panel-control-container<?=$item["DISABLED"] ? " main-grid-disable" : "";?>" id="<?=$item["ID"]?>">
											<span class="main-grid-checkbox-container main-grid-control-panel-checkbox-container">
												<input
													class="main-grid-panel-checkbox main-grid-checkbox main-grid-panel-control"
													id="<?=$item["ID"]?>_control"
													name="<?=$item["NAME"]?>"
													type="checkbox"
													value="<?=$item["VALUE"]?>"
													title="<?=$item["TITLE"]?>"
													data-onchange="<?=\Bitrix\Main\Text\Converter::getHtmlConverter()->encode(\Bitrix\Main\Web\Json::encode($item["ONCHANGE"]))?>"
													<?=$item["CHECKED"] ? " checked" : ""?>>
												<label class="main-grid-checkbox" for="<?=$item["ID"]?>_control"></label>
											</span>
											<span class="main-grid-control-panel-content-title">
												<label for="<?=$item["ID"]?>_control" title="<?=$item["TITLE"]?>"><?=$item["LABEL"]?></label>
											</span>
										</span><?
									?><? endif; ?>
									<? if ($item["TYPE"] === "DROPDOWN") : ?><?
										?><span class="main-grid-panel-control-container<?=$item["DISABLED"] ? " main-grid-disable" : "";?>" id="<?=$item["ID"]?>">
											<span class="main-dropdown main-grid-panel-control"
												  id="<?=$item["ID"]?>_control"
												  name="<?=$item["NAME"]?>"
												  data-value="<?=$item["ITEMS"][0]["VALUE"]?>"
												  data-items="<?=\Bitrix\Main\Text\Converter::getHtmlConverter()->encode(\Bitrix\Main\Web\Json::encode($item["ITEMS"]))?>">
												<?=$item["ITEMS"][0]["NAME"]?>
											</span>
										</span>
										<?
									?><? endif; ?>
									<? if ($item["TYPE"] === "TEXT") : ?><?
									?><span class="main-grid-panel-control-container<?=$item["DISABLED"] ? " main-grid-disable" : "";?>" id="<?=$item["ID"]?>">
											<? if ($item["LABEL"]) : ?>
												<label for="<?=$item["ID"]?>_control"><?=$item["LABEL"]?></label>
											<? endif; ?>
												<input
													type="text"
													class="main-grid-control-panel-input-text main-grid-panel-control"
													name="<?=$item["NAME"]?>"
													id="<?=$item["ID"]?>_control"
													placeholder="<?=$item["PLACEHOLDER"]?>"
													value="<?=$item["VALUE"]?>">
										</span><?
									?><? endif; ?>
									<? if ($item["TYPE"] === "BUTTON") : ?><?
									?><span class="main-grid-panel-control-container<?=$item["DISABLED"] ? " main-grid-disable" : "";?>" id="<?=$item["ID"]?>">
											<button
												class="main-grid-buttons <?=$item["CLASS"]?>"
												id="<?=$item["ID"]?>_control"
												data-onchange="<?=\Bitrix\Main\Text\Converter::getHtmlConverter()->encode(\Bitrix\Main\Web\Json::encode($item["ONCHANGE"]))?>">
												<?=$item["TEXT"]?>
											</button>
										</span><?
									?><? endif; ?>
									<? if ($item["TYPE"] === "LINK") : ?>
										<span
											class="main-grid-panel-control-container<?=$item["DISABLED"] ? " main-grid-disable" : "";?>"
											id="<?=$item["ID"]?>"
											data-onchange="<?=\Bitrix\Main\Text\Converter::getHtmlConverter()->encode(\Bitrix\Main\Web\Json::encode($item["ONCHANGE"]))?>">
											<a href="<?=$item["HREF"]?>" class="main-grid-link<?=$item["CLASS"] ? " ".$item["CLASS"] : ""?>" id="<?=$item["ID"]?>_control"><?=$item["TEXT"]?></a>
										</span>
									<? endif; ?>
								<? endforeach; ?>
							</td>
						<? endforeach; ?>
					</tr>
				</table>
			</div>
		</div>
		<? endif; ?>
	</div>

	</form>

</div>


<? if ($USER->isAuthorized() && !$arResult['BX_isGridAjax']) include '_grid_settings.php'; ?>
<? if (!$arResult['IS_AJAX'] || !$arResult['IS_INTERNAL']) :
	$variables = array(
		'mess' => array(
			'calend_title'        => getMessage('interface_grid_date'),
			'for_all_confirm'     => getMessage('interface_grid_del_confirm'),
			'settingsTitle'       => getMessage('interface_grid_settings_title'),
			'settingsSave'        => getMessage('interface_grid_settings_save'),
			'viewsTitle'          => getMessage('interface_grid_views_title'),
			'viewsApply'          => getMessage('interface_grid_views_apply'),
			'viewsApplyTitle'     => getMessage('interface_grid_views_apply_title'),
			'viewsNoName'         => getMessage('interface_grid_view_noname'),
			'viewsNewView'        => getMessage('interface_grid_views_new'),
			'viewsDelete'         => getMessage('interface_grid_del_view'),
			'viewsFilter'         => getMessage('interface_grid_filter_sel'),
			'filtersTitle'        => getMessage('interface_grid_filter_saved'),
			'filtersApply'        => getMessage('interface_grid_apply'),
			'filtersApplyTitle'   => getMessage('interface_grid_filter_apply_title'),
			'filtersNew'          => getMessage('interface_grid_filter_new'),
			'filtersDelete'       => getMessage('interface_grid_filter_del'),
			'filterSettingsTitle' => getMessage('interface_grid_filter_title'),
			'filterHide'          => getMessage('interface_grid_to_head_1'),
			'filterShow'          => getMessage('interface_grid_from_head_1'),
			'filterApplyTitle'    => getMessage('interface_grid_filter_apply'),
			'renameTitle'         => getMessage('interface_grid_name_title'),
		),
		'ajax' => array(
			'AJAX_ID'            => $arParams['AJAX_ID'],
			'GRID_AJAX_UID'      => $arParams['GRID_AJAX_UID'],
			'AJAX_OPTION_SHADOW' => $arParams['AJAX_OPTION_SHADOW'] == 'Y',
		),
		'settingWndSize'       => CUtil::getPopupSize('InterfaceGridSettingWnd'),
		'viewsWndSize'         => CUtil::getPopupSize('InterfaceGridViewsWnd', array('height' => 350, 'width' => 500)),
		'filtersWndSize'       => CUtil::getPopupSize('InterfaceGridFiltersWnd', array('height' => 350, 'width' => 500)),
		'filterSettingWndSize' => CUtil::getPopupSize('InterfaceGridFilterSettingWnd'),
		'renameWndSize'        => CUtil::getPopupSize('InterfaceGridRenameWnd', array('height' => 150, 'width' => 500)),
		'calendar_image'       => $this->getFolder().'/images/calendar.gif',
		'server_time'          => time() + date('Z') + CTimeZone::getOffset(),
		'component_path'       => $component->getRelativePath(),
		'template_path'        => $this->getFolder(),
		'sessid'               => bitrix_sessid(),
		'current_url'          => array($arResult['CURRENT_URL']),
		'user_authorized'      => $USER->isAuthorized(),
	);

	$visibleCols = array();
	foreach ($arResult['COLUMNS_ALL'] as $id => $header)
		$visibleCols[$id] = array_key_exists($id, $arResult['COLUMNS']);

	unset($arParams["ROWS"]);
	unset($arParams["COLUMNS"]);
	?>

	<script type="text/javascript">

		var settingsDialog<?=$pGridId ?>;
		var viewsDialog<?=$pGridId ?>;
		var filtersDialog<?=$pGridId ?>;
		var filterSettingsDialog<?=$pGridId ?>;

		jsDD.Enable();

		if (!window.orig_BX_scrollToNode)
			window.orig_BX_scrollToNode = BX.scrollToNode;

		if (!window['bxGrid_<?=$pGridId ?>'])
			bxGrid_<?=$pGridId ?> = new BxUniversalGrid('<?=$pGridId ?>');
		BX.Main.gridManager.push(
			'<?=$pGridId ?>',
			new BX.Main.grid(
				'<?=$pGridId ?>',
				'<?=\Bitrix\Main\Web\Json::encode(
					array(
						"ALLOW_COLUMNS_SORT" => $arParams["ALLOW_COLUMNS_SORT"],
						"ALLOW_ROWS_SORT" => $arParams["ALLOW_ROWS_SORT"],
						"ALLOW_COLUMNS_RESIZE" => $arParams["ALLOW_COLUMNS_RESIZE"],
						"SHOW_ROW_CHECKBOXES" => $arParams["SHOW_ROW_CHECKBOXES"],
						"ALLOW_HORIZONTAL_SCROLL" => $arParams["ALLOW_HORIZONTAL_SCROLL"],
						"ALLOW_PIN_HEADER" => $arParams["ALLOW_PIN_HEADER"],
						"SHOW_ACTION_PANEL" => $arParams["SHOW_ACTION_PANEL"],
						"PRESERVE_HISTORY" => $arParams["PRESERVE_HISTORY"],
						"BACKEND_URL" => $arResult["BACKEND_URL"]
					)
				)?>',
				'<?=\Bitrix\Main\Web\Json::encode($arResult["OPTIONS"])?>',
				'<?=\Bitrix\Main\Web\Json::encode($arResult["OPTIONS_ACTIONS"])?>',
				'<?=$arResult["OPTIONS_HANDLER_URL"]?>',
				'<?=\Bitrix\Main\Web\Json::encode($arResult["PANEL_ACTIONS"])?>',
				'<?=\Bitrix\Main\Web\Json::encode($arResult["PANEL_TYPES"])?>',
				'<?=\Bitrix\Main\Web\Json::encode($arResult["EDITOR_TYPES"])?>'
			),
			bxGrid_<?=$pGridId ?>
		);

		<? if (!$arResult['BX_isGridAjax']): ?>

		bxGrid_<?=$pGridId ?>.oVisibleCols = <?=CUtil::phpToJsObject($visibleCols) ?>;
		bxGrid_<?=$pGridId ?>.oColsMeta    = <?=CUtil::phpToJsObject($arResult['COLS_EDIT_META_ALL']) ?>;
		bxGrid_<?=$pGridId ?>.resizeMeta   = <?=CUtil::phpToJsObject($arResult['COLS_RESIZE_META']) ?>;
		<? if (!empty($arResult['DATA_FOR_EDIT'])): ?>
		bxGrid_<?=$pGridId ?>.oEditData = <?=CUtil::phpToJsObject($arResult['DATA_FOR_EDIT']) ?>;
		<? endif ?>
		bxGrid_<?=$pGridId ?>.oColsNames = <?=CUtil::phpToJsObject(htmlspecialcharsback($arResult['COLS_NAMES'])) ?>;
		bxGrid_<?=$pGridId ?>.oOptions   = <?=CUtil::phpToJsObject($arResult['OPTIONS']) ?>;
		bxGrid_<?=$pGridId ?>.hasActions = <?=($arResult['HAS_ACTIONS'] ? 'true' : 'false') ?>;
		bxGrid_<?=$pGridId ?>.vars       = <?=CUtil::phpToJsObject($variables) ?>;
		bxGrid_<?=$pGridId ?>.menu       = new PopupMenu('bxMenu_<?=$pGridId ?>', 1010);
		bxGrid_<?=$pGridId ?>.headerMenu = [
			{
				'UID': 'menu_<?=$pGridId ?>_columns_item',
				'TEXT': '<?=CUtil::jsEscape(getMessage('interface_grid_columns')) ?>',
				'TITLE': '<?=CUtil::jsEscape(getMessage('interface_grid_columns_title')) ?>',
				'MENU': [
					<? $k = 0; ?>
					<? foreach ($arResult['COLUMNS_ALL'] as $id => $header) : ?>
					<? if ($k++ > 0) echo ','; ?>
					{
						'UID': 'menu_<?=$pGridId ?>_columns_item_<?=CUtil::jsEscape($id); ?>',
						'TEXT': '<?=CUtil::jsEscape(htmlspecialcharsbx($header['name'])) ?>',
						'TITLE': '<?=CUtil::jsEscape(getMessage('interface_grid_columns_showhide')) ?>',
						<? if (array_key_exists($id, $arResult['COLUMNS'])): ?>'ICONCLASS': 'checked',<? endif ?>
						'ONCLICK': 'bxGrid_<?=$pGridId ?>.CheckColumn(\'<?=CUtil::jsEscape($id) ?>\', this)',
						'AUTOHIDE': false
					}
					<? endforeach ?>
				],
				'DISABLED': <?=($USER->isAuthorized() ? 'false' : 'true') ?>
			}
		];
		bxGrid_<?=$pGridId ?>.settingsMenu = [
			{
				'DEFAULT': true,
				'TEXT': '<?=CUtil::jsEscape(getMessage('interface_grid_views_setup')) ?>',
				'TITLE': '<?=CUtil::jsEscape(getMessage('interface_grid_views_setup_title')) ?>',
				'ICONCLASS': 'grid-settings',
				'ONCLICK': 'bxGrid_<?=$pGridId ?>.EditCurrentView()',
				'DISABLED': <?=($USER->isAuthorized() ? 'false' : 'true') ?>
			},
			bxGrid_<?=$pGridId ?>.headerMenu[0],
			{ 'SEPARATOR': true },
			<? foreach ($arResult['OPTIONS']['views'] as $view_id => $view): ?>
			{
				'TEXT': '<?=CUtil::jsEscape($view['name'] != '' ? htmlspecialcharsbx($view['name']) : getMessage('interface_grid_view_noname')) ?>',
				'TITLE': '<?=CUtil::jsEscape(getMessage('interface_grid_view_title')) ?>',
				<? if ($view_id == $arResult['OPTIONS']['current_view']): ?>
				'ICONCLASS': 'checked',
				<? endif ?>
				'ONCLICK': 'bxGrid_<?=$pGridId ?>.SetView(\'<?=$view_id ?>\')',
				'DISABLED': <?=($USER->isAuthorized() ? 'false' : 'true') ?>
			},
			<? endforeach ?>
			{ 'SEPARATOR': true },
			{
				'TEXT': '<?=CUtil::jsEscape(getMessage('interface_grid_views')) ?>',
				'TITLE': '<?=CUtil::jsEscape(getMessage('interface_grid_views_mnu_title')) ?>',
				'ICONCLASS': 'grid-views',
				'ONCLICK':'bxGrid_<?=$pGridId ?>.ShowViews()',
				'DISABLED': <?=($USER->IsAuthorized() ? 'false' : 'true'); ?>
			}
		];

		BX.ready(function() {
			bxGrid_<?=$pGridId ?>.InitTable();
		});

		<? if (!empty($arParams['FILTER'])): ?>

		bxGrid_<?=$pGridId ?>.oFilterRows = <?=CUtil::phpToJsObject($arResult['FILTER_ROWS']) ?>;
		bxGrid_<?=$pGridId ?>.filterMenu = [
			{
				'TEXT': '<?=CUtil::jsEscape(getMessage('interface_grid_flt_rows')) ?>',
				'TITLE': '<?=CUtil::jsEscape(getMessage('interface_grid_flt_rows_title')) ?>',
				'MENU': [
					<? foreach ($arParams['FILTER'] as $field): ?>
					{
						'ID': 'flt_<?=$pGridId ?>_<?=$field['id'] ?>',
						'TEXT': '<?=CUtil::jsEscape($field['name']) ?>',
						<? if ($arResult['FILTER_ROWS'][$field['id']]): ?>
						'ICONCLASS':'checked',
						<? endif ?>
						'ONCLICK': 'bxGrid_<?=$pGridId ?>.SwitchFilterRow(\'<?=CUtil::jsEscape($field['id']) ?>\', this)',
						'AUTOHIDE': false
					},
					<? endforeach ?>
					{ 'SEPARATOR': true },
					{
						'TEXT': '<?=CUtil::jsEscape(getMessage('interface_grid_flt_show_all')) ?>',
						'ONCLICK': 'bxGrid_<?=$pGridId ?>.SwitchFilterRows(true)'
					},
					{
						'TEXT': '<?=CUtil::jsEscape(getMessage('interface_grid_flt_hide_all')) ?>',
						'ONCLICK': 'bxGrid_<?=$pGridId ?>.SwitchFilterRows(false)'
					}
				]
			},
			<? if (!empty($arResult['OPTIONS']['filters']) && is_array($arResult['OPTIONS']['filters'])): ?>
			{ 'SEPARATOR': true },
			<? foreach ($arResult['OPTIONS']['filters'] as $filter_id => $filter): ?>
			{
				'ID': 'mnu_<?=$pGridId ?>_<?=$filter_id ?>',
				'TEXT': '<?=CUtil::jsEscape(htmlspecialcharsbx($filter['name'])) ?>',
				'TITLE': '<?=CUtil::jsEscape(getMessage('interface_grid_filter_apply')) ?>',
				'ONCLICK':'bxGrid_<?=$pGridId ?>.ApplyFilter(\'<?=CUtil::jsEscape($filter_id) ?>\')'
			},
			<? endforeach ?>
			<? endif ?>
			{ 'SEPARATOR': true },
			{
				'TEXT': '<?=CUtil::jsEscape(getMessage('interface_grid_filters')) ?>',
				'TITLE': '<?=CUtil::jsEscape(getMessage('interface_grid_filters_title')) ?>',
				'ICONCLASS': 'grid-filters',
				'ONCLICK': 'bxGrid_<?=$pGridId ?>.ShowFilters()',
				'DISABLED': <?=($USER->isAuthorized()? 'false' : 'true') ?>
			},
			{
				'TEXT': '<?=CUtil::jsEscape(getMessage('interface_grid_filters_save')) ?>',
				'TITLE': '<?=CUtil::jsEscape(getMessage('interface_grid_filters_save_title')) ?>',
				'ONCLICK': 'bxGrid_<?=$pGridId ?>.AddFilterAs()',
				'DISABLED': <?=($USER->isAuthorized() && !empty($arResult['FILTER']) ? 'false' : 'true') ?>
			}
		];

		BX.ready(function() {
			bxGrid_<?=$pGridId ?>.InitFilter();
		});

		<? endif ?>

		phpVars.messLoading = '<?=getMessageJS('interface_grid_loading') ?>';

		<? elseif ($arResult['BX_isGridAjaxPage']): ?>

		var newEditData = <?=CUtil::phpToJsObject($arResult['DATA_FOR_EDIT']) ?>;
		for (var i in newEditData)
			bxGrid_<?=$pGridId ?>.oEditData[i] = newEditData[i];

		bxGrid_<?=$pGridId ?>.vars.current_url.push('<?=CUtil::jsEscape($arResult['CURRENT_URL']) ?>');

		<? endif ?>

	</script>

<? endif; ?>