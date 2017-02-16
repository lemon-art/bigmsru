<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$newGridId = $pGridId."_table";

$prepareFilterSettingsFieldParams = function($field)
{
	if (!is_array($field['params']))
		$field['params'] = array();

	switch ($field['type'])
	{
		case '':
		case 'text':
			if ($field['params']['size'] == '')
				$field['params']['size'] = '30';
			break;
		case 'date':
			if ($field['params']['size'] == '')
				$field['params']['size'] = '10';
			break;
		case 'number':
			if ($field['params']['size'] == '')
				$field['params']['size'] = '8';
			break;
	}

	$params = '';
	foreach ($field['params'] as $p => $v)
		$params .= sprintf(' %s="$v"', $p, $v);

	return $params;
};

?>

<div style="display: none; ">

	<div id="view_settings_<?=$newGridId ?>">
		<table width="100%">
			<tr class="section">
				<td colspan="2"><?=getMessage('interface_grid_view_sect') ?></td>
			</tr>
			<tr>
				<td align="right" width="50%"><?=getMessage('interface_grid_view_name') ?></td>
				<td><input type="text" name="view_name" value="" size="40" maxlength="255"></td>
			</tr>
			<tr class="section">
				<td colspan="2"><?=getMessage('interface_grid_view_cols') ?></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<table>
						<tr>
							<td style="background-image: none; " nowrap>
								<div style="margin-bottom: 5px; "><?=getMessage('interface_grid_view_av_cols') ?></div>
								<select style="min-width: 150px; " name="view_all_cols" multiple size="12"
									ondblclick="this.form.add_btn.onclick(); "
									onchange="this.form.add_btn.disabled = (this.selectedIndex == -1); ">
								</select>
							</td>
							<td style="background-image: none; ">
								<div style="margin-bottom: 5px; ">
									<input type="button" name="add_btn" style="width: 30px; " value="&gt;"
										title="<?=getMessage('interface_grid_view_add_col') ?>"
										onclick="jsSelectUtils.addSelectedOptions(this.form.view_all_cols, this.form.view_cols, false); jsSelectUtils.deleteSelectedOptions(this.form.view_all_cols); ">
								</div>
								<div style="margin-bottom: 5px; ">
									<input type="button" name="del_btn" style="width: 30px; " value="&lt;"
										title="<?=getMessage('interface_grid_view_del_col') ?>"
										onclick="jsSelectUtils.addSelectedOptions(this.form.view_cols, this.form.view_all_cols, false, true); jsSelectUtils.deleteSelectedOptions(this.form.view_cols); ">
								</div>
							</td>
							<td style="background-image: none; " nowrap>
								<div style="margin-bottom: 5px; "><?=getMessage('interface_grid_view_sel_col') ?></div>
								<select style="min-width: 150px; " name="view_cols" multiple size="12"
									ondblclick="this.form.del_btn.onclick(); "
									onchange="this.form.del_btn.disabled = this.form.up_btn.disabled = this.form.down_btn.disabled = this.form.rename_btn.disabled = (this.selectedIndex == -1); ">
								</select>
							</td>
							<td style="background-image:none">
								<div style="margin-bottom: 5px; ">
									<input class="bx-grid-btn" type="button" name="up_btn" style="width: 100px; "
										value="<?=getMessage('interface_grid_view_up') ?>"
										title="<?=getMessage('interface_grid_view_up_title') ?>"
										onclick="jsSelectUtils.moveOptionsUp(this.form.view_cols); ">
								</div>
								<div style="margin-bottom: 5px; ">
									<input class="bx-grid-btn" type="button" name="down_btn" style="width: 100px; "
										value="<?=getMessage('interface_grid_view_down') ?>"
										title="<?=getMessage('interface_grid_view_down_title') ?>"
										onclick="jsSelectUtils.moveOptionsDown(this.form.view_cols); ">
								</div>
								<div style="margin-bottom: 5px; ">
									<input class="bx-grid-btn" type="button" name="rename_btn" style="width: 100px; "
										value="<?=getMessage('interface_grid_name_btn') ?>"
										title="<?=getMessage('interface_grid_name_btn_title') ?>"
										onclick="bxGrid_<?=$arParams["GRID_ID"]?>.RenameColumn(); ">
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<label>
						<input type="checkbox" name="reset_columns_sizes">
						<?=getMessage('interface_grid_reset_columns') ?>
					</label>
				</td>
			</tr>
			<tr class="section">
				<td colspan="2"><?=getMessage('interface_grid_view_sort_sect') ?></td>
			</tr>
			<tr>
				<td align="right"><?=getMessage('interface_grid_view_sort_name') ?></td>
				<td>
					<select name="view_sort_by">
						<option value=""><?=getMessage('interface_grid_default') ?></option>
						<? foreach($arParams['HEADERS'] as $header): ?>
							<? if ($header['sort'] != ''): ?>
								<option value="<?=$header['sort'] ?>"><?=$header['name'] ?></option>
							<? endif ?>
						<? endforeach ?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="right"><?=getMessage('interface_grid_view_sort_order') ?></td>
				<td>
					<select name="view_sort_order">
						<option value=""><?=getMessage('interface_grid_default') ?></option>
						<option value="asc"><?=getMessage('interface_grid_view_sort_asc') ?></option>
						<option value="desc"><?=getMessage('interface_grid_view_sort_desc') ?></option>
					</select>
				</td>
			</tr>
			<tr class="section">
				<td colspan="2"><?=getMessage('interface_grid_view_nav_sect') ?></td>
			</tr>
			<tr>
				<td align="right" width="50%"><?=getMessage('interface_grid_view_nav_name') ?></td>
				<td>
					<select name="view_page_size">
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
					</select>
				</td>
			</tr>
			<tr class="section">
				<td colspan="2"><?=getMessage('interface_grid_saved_filter') ?></td>
			</tr>
			<tr>
				<td align="right"><?=getMessage('interface_grid_saved_filter_apply') ?></td>
				<td>
					<select name="view_filters"></select>
				</td>
			</tr>
			<? if ($arResult['IS_ADMIN']): ?>
				<tr class="section">
					<td colspan="2"><?=getMessage('interface_grid_common') ?></td>
				</tr>
				<tr>
					<td colspan="2">
						<label>
							<input type="checkbox" name="set_default_settings"
								onclick="document['settings_<?=$newGridId ?>'].delete_users_settings.disabled = !this.checked; ">
							<?=getMessage('interface_grid_common_default') ?>
						</label>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<label>
							<input type="checkbox" name="delete_users_settings" disabled>
							<?=getMessage('interface_grid_common_default_apply') ?>
						</label>
					</td>
				</tr>
			<? endif ?>
		</table>
	</div>

	<div id="rename_column_<?=$newGridId ?>">
		<table width="100%">
			<tr>
				<td align="right" width="50%"><?=getMessage('interface_grid_name_def') ?></td>
				<td><input type="text" name="col_name_def" value="" size="35" disabled="disabled"></td>
			</tr>
			<tr>
				<td align="right" width="50%"><?=getMessage('interface_grid_name_new') ?></td>
				<td><input type="text" name="col_name" value="" size="35"></td>
			</tr>
		</table>
	</div>

	<div id="views_list_<?=$newGridId ?>">
		<div style="float: left; width: 80%; ">
			<select name="views_list" size="17" style="width: 100%; height: 250px; " ondblclick="this.form.views_edit.onclick(); ">
				<? foreach ($arResult['OPTIONS']['views'] as $view_id => $view): ?>
					<option value="<?=htmlspecialcharsbx($view_id) ?>"<? if ($view_id == $arResult['OPTIONS']['current_view']): ?> selected<?endif?>>
						<?=htmlspecialcharsbx($view['name'] != '' ? $view['name'] : getMessage('interface_grid_view_noname')) ?>
					</option>
				<?endforeach?>
			</select>
		</div>
		<div style="width: 20%; float: left; ">
			<div style="margin-left: 5px; ">
			<div style="margin-bottom: 5px; ">
				<input type="button" name="views_add" style="width: 100%; "
					value="<?=getMessage('interface_grid_view_add') ?>"
					title="<?=getMessage('interface_grid_view_add_title') ?>"
					onclick="bxGrid_<?=$newGridId ?>.AddView(); ">
			</div>
			<div style="margin-bottom: 5px; ">
				<input type="button" name="views_edit" style="width: 100%; "
					value="<?=getMessage('interface_grid_view_edit') ?>"
					title="<?=getMessage('interface_grid_view_edit_title') ?>"
					onclick="if (this.form.views_list.value) bxGrid_<?=$newGridId ?>.EditView(this.form.views_list.value); ">
			</div>
			<div style="margin-bottom: 5px; ">
				<input type="button" name="views_delete" style="width: 100%; "
					value="<?=getMessage('interface_grid_view_del') ?>"
					title="<?=getMessage('interface_grid_view_del_title') ?>"
					onclick="if(this.form.views_list.value) bxGrid_<?=$newGridId ?>.DeleteView(this.form.views_list.value); ">
				</div>
			</div>
		</div>
	</div>

	<? if (!empty($arParams['FILTER'])): ?>
		<div id="filter_settings_<?=$newGridId ?>">
			<table width="100%">
				<tr class="section">
					<td colspan="2"><?=getMessage('interface_grid_filter_name') ?></td>
				</tr>
				<tr>
					<td align="right" width="40%"><?=getMessage('interface_grid_filter_name1') ?></td>
					<td><input type="text" name="filter_name" value="" size="40" maxlength="255"></td>
				</tr>
				<tr class="section">
					<td colspan="2"><?=getMessage('interface_grid_filter_fields') ?></td>
				</tr>
				<? foreach ($arParams['FILTER'] as $field): ?>
					<? if ($field['enable_settings'] === false) continue; ?>
					<tr>
						<td align="right"><?=$field['name'] ?>:</td>
						<td>
							<? $params = $prepareFilterSettingsFieldParams($field); ?>
							<? if ($field['type'] == 'custom'): ?>
								<?=$field['value'] ?>
							<? elseif ($field['type'] == 'checkbox'): ?>
								<input type="hidden" name="<?=$field['id'] ?>" value="N">
								<input type="checkbox" name="<?=$field['id'] ?>" value="Y"<?=$params ?>>
							<? elseif ($field['type'] == 'list'): ?>
								<select name="<?=$field['id'] ?><? if (isset($field['params']['multiple'])): ?>[]<? endif ?>"<?=$params ?>>
									<? if (is_array($field['items'])): ?>
										<? if (isset($field['params']['multiple'])): ?>
											<option value=""><?=getMessage('interface_grid_no_no_no_1') ?></option>
										<? endif ?>
										<? foreach ($field['items'] as $k => $v): ?>
											<option value="<?=htmlspecialcharsbx($k) ?>"><?=htmlspecialcharsbx($v) ?></option>
										<? endforeach ?>
									<? endif ?>
								</select>
							<? elseif ($field['type'] == 'date'): ?>
								<? $APPLICATION->includeComponent(
									'bitrix:main.calendar.interval', '',
									array(
										'FORM_NAME'        => 'flt_settings_'.$newGridId,
										'SELECT_NAME'      => $field['id'].'_datesel',
										'SELECT_VALUE'     => '',
										'INPUT_NAME_DAYS'  => $field['id'].'_days',
										'INPUT_VALUE_DAYS' => '',
										'INPUT_NAME_FROM'  => $field['id'].'_from',
										'INPUT_VALUE_FROM' => '',
										'INPUT_NAME_TO'    => $field['id'].'_to',
										'INPUT_VALUE_TO'   => '',
										'INPUT_PARAMS'     => $params,
									),
									$component, array('HIDE_ICONS' => true)
								); ?>
							<? elseif ($field['type'] == 'quick'): ?>
								<input type="text" name="<?=$field['id'] ?>" value=""<?=$params ?>>
								<? if (is_array($field['items'])): ?>
									<select name="<?=$field['id'] ?>_list">
										<? foreach ($field['items'] as $k => $v): ?>
											<option value="<?=htmlspecialcharsbx($k) ?>"><?=htmlspecialcharsbx($v) ?></option>
										<? endforeach ?>
									</select>
								<? endif ?>
							<? elseif ($field['type'] == 'number'): ?>
								<input type="text" name="<?=$field['id'] ?>_from" value=""<?=$params ?>> ...
								<input type="text" name="<?=$field['id'] ?>_to" value=""<?=$params ?>>
							<? else: ?>
								<input type="text" name="<?=$field['id'] ?>" value=""<?=$params ?>>
							<? endif ?>
						</td>
					</tr>
				<? endforeach ?>
			</table>
		</div>
		<div id="filters_list_<?=$newGridId ?>">
			<div style="float: left; width: 80%; ">
				<select name="filters_list" size="17" style="width: 100%; height: 250px; "
					ondblclick="if (this.value) this.form.filters_edit.onclick(); ">
					<? foreach ($arResult['OPTIONS']['filters'] as $filter_id => $filter): ?>
						<option value="<?=htmlspecialcharsbx($filter_id) ?>">
							<?=htmlspecialcharsbx($filter['name'] != '' ? $filter['name'] : getMessage('interface_grid_view_noname')) ?>
						</option>
					<? endforeach ?>
				</select>
			</div>
			<div style="float: left; width: 20%; ">
				<div style="margin-left: 5px; ">
					<div style="margin-bottom: 5px; ">
						<input type="button" name="filters_add" style="width: 100%; "
							value="<?=getMessage('interface_grid_view_add') ?>"
							title="<?=getMessage('interface_grid_filter_add_title') ?>"
							onclick="bxGrid_<?=$newGridId ?>.AddFilter(); ">
					</div>
					<div style="margin-bottom: 5px; ">
						<input type="button" name="filters_edit" style="width: 100%; "
							value="<?=getMessage('interface_grid_view_edit') ?>"
							title="<?=getMessage('interface_grid_filter_edit_title') ?>"
							onclick="if (this.form.filters_list.value) bxGrid_<?=$newGridId ?>.EditFilter(this.form.filters_list.value); ">
					</div>
					<div style="margin-bottom: 5px; ">
						<input type="button" name="filters_delete" style="width: 100%; "
							value="<?=getMessage('interface_grid_view_del') ?>"
							title="<?=getMessage('interface_grid_filter_del_title') ?>"
							onclick="if (this.form.filters_list.value) bxGrid_<?=$newGridId ?>.DeleteFilter(this.form.filters_list.value); ">
					</div>
				</div>
			</div>
		</div>
	<? endif ?>

</div>
