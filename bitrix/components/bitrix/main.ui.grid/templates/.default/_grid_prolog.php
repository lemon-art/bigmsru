<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$pGridId = $arParams['GRID_ID'];

$arResult['COLS_RESIZE_META']['minColumn'] = 50;

$arResult['BX_isGridAjax']       = false;
$arResult['BX_isGridAjaxColumn'] = false;
$arResult['BX_isGridAjaxPage']   = false;

$prepareGridBodyCellValue = function($row, $header)
{
	$id = $header['id'];
	$value = $header['type'] == 'checkbox' && in_array($row['data'][$id], array('Y', 'N'))
		? getMessage($row['data'][$id] == 'Y' ? 'interface_grid_yes' : 'interface_grid_no')
		: ($row['columns'][$id] != '' ? $row['columns'][$id] : $row['data'][$id]);

	return $value != '' ? $value : '&nbsp;';
};

if ($_SERVER['HTTP_X_AJAX_GRID_UID'] == $arParams['GRID_AJAX_UID'] && $_SERVER['HTTP_X_AJAX_GRID_REQ'])
{
	try
	{
		$gridAjaxReq = \Bitrix\Main\Web\Json::decode($_SERVER['HTTP_X_AJAX_GRID_REQ']);
	}
	catch (Exception $e)
	{
	}

	if (!empty($gridAjaxReq))
	{
		if (!empty($gridAjaxReq['action']) && in_array($gridAjaxReq['action'], array('showcolumn', 'showpage')))
			$arResult['BX_isGridAjax'] = true;
	}
}

if ($arResult['BX_isGridAjax'])
{
	if ($gridAjaxReq['action'] == 'showcolumn')
	{
		$arResult['BX_isGridAjaxColumn'] = true;

		$targetColumn = false;
		if (!empty($gridAjaxReq['column']))
		{
			foreach ($arParams['HEADERS'] as $header)
			{
				if ($gridAjaxReq['column'] == $header['id'])
				{
					$targetColumn = $header['id'];
					break;
				}
			}
		}

		if ($targetColumn)
		{
			define('PUBLIC_AJAX_MODE', true);

			$result = array(
				'data' => array(),
				'edit' => array()
			);

			foreach ($arParams['ROWS'] as $arRow)
			{
				$data_id = $arRow['id'] != '' ? $arRow['id'] : $arRow['data']['ID'];
				$result['data'][$data_id] = array(
					$targetColumn => $prepareGridBodyCellValue($arRow, $arResult['HEADERS_ALL'][$targetColumn])
				);
			}

			foreach ($arResult['DATA_FOR_EDIT'] as $data_id => $data)
			{
				$result['edit'][$data_id] = array_key_exists($targetColumn, $data)
					? array($targetColumn => $data[$targetColumn])
					: array();
			}

			if (!empty($arResult['AGGREGATE'][$targetColumn]))
			{
				$result['data']['bxaggr'] = array($targetColumn => '');
				foreach ($arResult['AGGREGATE'][$targetColumn] as $item)
					$result['data']['bxaggr'][$targetColumn] .= $item.'<br>';
			}

			$APPLICATION->restartBuffer();

			header('Content-Type: application/x-javascript; charset=UTF-8');
			echo \Bitrix\Main\Web\Json::encode($result);

			require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php';
			die;
		}
	}
	elseif ($gridAjaxReq['action'] == 'showpage')
	{
		$arResult['BX_isGridAjaxPage'] = true;

		if (!empty($gridAjaxReq['columns']) && is_array($gridAjaxReq['columns']))
		{
			$columns = array_intersect_key($gridAjaxReq['columns'], $arResult['HEADERS_ALL']);
			if (count($columns) == count($gridAjaxReq['columns']))
			{
				$headers = $arResult['HEADERS_ALL'];

				$arResult['HEADERS'] = array();
				$arResult['HEADERS_ALL'] = array();

				foreach ($columns as $id => $show)
				{
					$arResult['HEADERS_ALL'][$id] = $headers[$id];

					if ($show)
						$arResult['HEADERS'][$id] = $headers[$id];
				}
			}
		}
	}
}


$prepareGridClass = function() use ($arParams)
{
	$classes = array();

	if ($arParams['TABLE_BORDERS'])
		$classes[] = 'bx-utable-border';

	if ($arParams['COMPACT_TABLE'])
		$classes[] = 'bx-utable-compact';

	return join(' ', $classes);
};

$getGridHeadCellWidth = function($header) use ($arResult)
{
	$columns = $arResult['COLS_RESIZE_META']['columns'];
	$id      = $header['id'];

	return isset($columns[$id]) && is_scalar($columns[$id]) ? (int) $columns[$id] : 0;
};

$prepareGridTableWidth = function($property = 'width') use ($arParams, $arResult, $getGridHeadCellWidth)
{
	$minWidth = $arResult['COLS_RESIZE_META']['minColumn'];
	$width    = 0;

	foreach ($arResult['HEADERS'] as $id => $header)
	{
		$cwidth = $getGridHeadCellWidth($header);
		if ($cwidth < $minWidth)
			return '';

		$width += $cwidth;
	}

	if (!empty($arParams['ROWS']))
	{
		if ($arResult['ALLOW_EDIT_ALL'])
			$width += $minWidth;
		if ($arParams['ROW_ACTIONS'])
			$width += $minWidth;
	}

	return $width > 0 ? sprintf('%s: %upx; ', $property, $width) : '';
};

$prepareGridHeadCellWidth = function($header) use ($arResult, $getGridHeadCellWidth)
{
//	$minWidth = $arResult['COLS_RESIZE_META']['minColumn'];
	$width    = $getGridHeadCellWidth($header);
	$minWidth = 65;

	return $width >= $minWidth ? sprintf('width: %upx; ', $width) : '';
};

$prepareGridHeadCellMenu = function($header) use ($pGridId)
{
	global $USER;

	$menu = array();

	if ($header['sort'])
	{
		$menu[] = array(
			'TEXT'      => getMessage('interface_grid_sort_asc'),
			'ONCLICK'   => 'bxGrid_'.$pGridId.".Sort('".CUtil::addslashes($header['sort_url'])."', '".$header['sort']."', 'desc')",
			'ICONCLASS' => 'grid-sort-asc'
		);
		$menu[] = array(
			'TEXT'      => getMessage('interface_grid_sort_desc'),
			'ONCLICK'   => 'bxGrid_'.$pGridId.".Sort('".CUtil::addslashes($header['sort_url'])."', '".$header['sort']."', 'asc')",
			'ICONCLASS' => 'grid-sort-desc'
		);
	}

	$menu[] = array(
		'TEXT'     => getMessage('interface_grid_hide_col'),
		'ONCLICK'  => 'bxGrid_'.$pGridId.".ToggleColumn('".CUtil::jsEscape($header['id'])."', false)",
		'DISABLED' => $USER->isAuthorized() ? 'false' : 'true'
	);

	return $menu;
};

$prepareGridHeadCellClass = function($header) use ($arResult)
{
	static $lastHeaderId;

	if ($lastHeaderId === null)
	{
		$lastHeaderId = false;
		foreach ($arResult['HEADERS_ALL'] as $id => $dummy)
		{
			if (array_key_exists($id, $arResult['HEADERS']))
				$lastHeaderId = $id;
		}
	}

	$classes = array();

	if ($header['sort_state'])
		$classes[] = 'bx-utable-cell-sortable';

	if ($header['id'] == $lastHeaderId)
		$classes[] = 'bx-utable-cell-last';

	//if ($header['align'])
	//	$classes[] = sprintf('bx-utable-cell-%s', $header['align']);

	return join(' ', $classes);
};

$prepareGridHeadContainerClass = function($header)
{
	$classes = array();

	if ($header['sort'])
	{
		if ($header['sort_state'])
		{
			$classes[] = sprintf('bx-utable-cell-sortable-%s', $header['sort_state'] == 'asc' ? 'up' : 'down');
			$classes[] = sprintf('bx-utable-cell-sortable');
		}
		else
		{
			$classes[] = sprintf('bx-utable-cell-sortable-%s', $header['order'] == 'asc' ? 'up' : 'down');
		}
	}

	return join(' ', $classes);
};

$prepareGridHeadCellTitle = function($header)
{
	$parts = array();

	if ($header['sort'])
	{
		$parts[] = getMessage('interface_grid_sort');
		$parts[] = $header['name'];

		if ($header['sort_state'])
			$parts[] = getMessage($header['sort_state'] == 'asc' ? 'interface_grid_sort_up' : 'interface_grid_sort_down');
	}

	return join(' ', $parts);
};

$prepareGridBodyRowActions = function($row, &$default)
{
	$actions = array();

	if (is_array($row['actions']))
	{
		$actions = $row['actions'];

		foreach ($row['actions'] as $action)
		{
			if ($action['DEFAULT'])
			{
				$default = array(
					'onclick' => $action['ONCLICK'],
					'title'   => getMessage('interface_grid_dblclick').$action['TEXT']
				);
				break;
			}
		}
	}

	return $actions;
};
