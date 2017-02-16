/* jshint ignore:start */
function BxUniversalGrid(table_id)
{
	"use strict";

	this.oColsMeta = {};
	this.oColsNames = {};
	this.customNames = {};
	this.columnsSizes = {};
	this.oEditData = {};
	this.oSaveData = {};
	this.oOptions = {};
	this.oVisibleCols = {};
	this.vars = {};
	this.menu = null;
	this.settingsMenu = [];
	this.filterMenu = [];
	this.checkBoxCount = 0;
	this.bColsChanged = false;
	this.bViewsChanged = false;
	this.oFilterRows = {};
	this.activeRow = null;
	this.hasActions = false;
	this.editMode = false;
	this.resizeMeta = {};
	this.table_id = table_id + '_table';
	this.grid_id = table_id;

	var _this = this;
	var Grid = null;
	var last_row = false;

	this.InitTable = function()
	{
		Grid = BX.Main.gridManager.getById(_this.grid_id).instance;
		this.checkBoxCount = 0;

		var table = Grid.getTable();

		if (!table || table.rows.length < 1 || table.rows[0].cells.length < 1)
		{
			return;
		}

		var cells = table.rows[0].cells;

		for (var i = 0; i < cells.length; i++)
		{
			if (BX.hasClass(cells[i], 'main-grid-cell-action') || BX.hasClass(cells[i], 'main-grid-cell-checkbox'))
			{
				cells[i].__fixed = true;
				continue;
			}

			var inode = BX.findChildByClassName(cells[i], 'main-grid-cell-head-container', false);
			BX.addClass(inode, 'main-grid-cell-head-dragable');
			BX.removeClass(cells[i], 'main-grid-cell-sortable');
		}

		this.initResizeMeta();
		this.toogleFader();
		BX.bind(window, 'resize', BX.delegate(this.toogleFader, this));
		BX.bind(table.parentNode, 'scroll', this.toogleFader);

		if (Grid.getParam('ALLOW_COLUMNS_RESIZE'))
		{
			for (var i = 0; i < cells.length; i++)
			{
				if (cells[i].__fixed)
				{
					continue;
				}

				var rhook = BX.findChildByClassName(cells[i], 'main-grid-resize-button');
				if (rhook)
				{
					rhook.onbxdragstart = _this.resizeColumnStart;
					rhook.onbxdragstop = _this.resizeColumnStop;
					rhook.onbxdrag = _this.resizeColumn;

					jsDD.registerObject(rhook);
				}
			}

			var registerPinnedTableButtons = function() {
				var table = Grid.getPinHeader().getFixedTable();
				var buttons = BX.findChild(table, {class: 'main-grid-resize-button'}, true, true);

				buttons.forEach(function(current) {
					current.onbxdragstart = _this.resizeColumnStart;
					current.onbxdragstop = _this.resizeColumnStop;
					current.onbxdrag = _this.resizeColumn;
					jsDD.registerObject(current);
				});
			};

			BX.addCustomEvent(window, 'Grid::headerPinned', registerPinnedTableButtons);
			BX.addCustomEvent(window, 'Grid::updated', registerPinnedTableButtons);
		}
	};

	//noinspection JSUnusedGlobalSymbols
	this.CheckColumn = function(name, menuItem)
	{
		var columns;
		var colMenu = this.menu.GetMenuByItemId(menuItem.id);
		var bShow = !(colMenu.GetItemInfo(menuItem).ICON == 'checked');
		colMenu.SetItemIcon(menuItem, (bShow? 'checked':''));


		if (name)
		{
			columns = Grid.getUserOptions().getCurrentOptions().columns.split(',');

			if (BX.type.isArray(columns) && BX.type.isNotEmptyString(name))
			{
				if (columns.some(function(current) { return current === name; }))
				{
					columns = columns.filter(function(current) {
						return current !== name;
					});

					BX.removeClass('menu_'+Grid.getContainerId()+'_columns_item_', 'checked');
				}
				else
				{
					columns.unshift(name);

					BX.addClass('menu_'+Grid.getContainerId()+'_columns_item_', 'checked');
				}
			}

			Grid.tableFade();

			Grid.getUserOptions().setColumns(columns, function() {
				Grid.reloadTable();
				BX.onCustomEvent(Grid.getContainer(), 'Grid::columnsChanged', [Grid]);
			});
		}


	};

	this.reinitColumnSize = function(column, temp)
	{
		var colId = this.GetColumnId(column);

		if (colId !== false)
		{
			var table  = BX(this.table_id);
			var twidth = table.offsetWidth;

			var cell = table.rows[0].cells[colId];
			var node = BX.findChildByClassName(cell, 'main-grid-cell-head-container', false);

			node.style.height = '';
			BX.removeClass(node, 'main-grid-cell-head-dragable');

			cell.style.width = '';
			cell.style.width = cell.offsetWidth+'px';

			BX.addClass(node, 'main-grid-cell-head-dragable');
			node.style.height = table.rows[0].cells[0].clientHeight+'px';

			if (temp)
			{
				cell.setAttribute('data-resize', 1);
			}
		}
	};

	this.initResizeMeta = function()
	{
		var table = Grid.getTable();
		var cells = table.rows[0].cells;

		this.resizeMeta.fixed = 0;
		this.resizeMeta.minPx = table.offsetWidth;

		var sizesChanged = false;
		for (var i = 0; i < cells.length; i++)
		{
			var width = BX.width(cells[i]);

			if (cells[i].__fixed)
			{
				this.resizeMeta.fixed += width;
				continue;
			}

			if (width > 0)
			{
				var name = cells[i].getAttribute('data-name');

				if (this.resizeMeta.columns[name] != width)
				{
					sizesChanged = true;
				}

				this.resizeMeta.columns[name] = width;
			}
		}

		if (sizesChanged)
		{
			this.resizeMeta.expand = 1;
		}
	};

	this.reinitResizeMeta = function()
	{
		var table = BX(_this.table_id);
		var cells = table.rows[0].cells;

		for (var i = 0; i < cells.length; i++)
		{
			if (cells[i].__fixed)
			{
				continue;
			}

			if (cells[i].offsetWidth > 0)
			{
				var name = cells[i].getAttribute('data-name');

				_this.resizeMeta.columns[name] = cells[i].offsetWidth;
			}
		}

		var twidth = table.offsetWidth;
		var pwidth = table.parentNode.clientWidth;

		_this.resizeMeta.minPx  = twidth;
		_this.resizeMeta.expand = twidth < pwidth ? (twidth / pwidth) : 1;

		_this.saveColumnsSizes();
	};

	this.toogleFader = function()
	{
		var Grid = BX.Main.gridManager.getById(_this.grid_id).instance;
		var table = Grid.getTable();
		var parent = Grid.getScrollContainer();

		if (table.offsetWidth > parent.clientWidth)
		{
			if (parent.scrollLeft > 0)
			{
				BX.addClass(parent.parentNode, 'main-grid-fade-left');
			}
			else
			{
				BX.removeClass(parent.parentNode, 'main-grid-fade-left');
			}

			if (table.offsetWidth > parent.scrollLeft+parent.clientWidth)
			{
				BX.addClass(parent.parentNode, 'main-grid-fade-right');
			}
			else
			{
				BX.removeClass(parent.parentNode, 'main-grid-fade-right');
			}
		}
		else
		{
			BX.removeClass(parent.parentNode, 'main-grid-fade-left');
			BX.removeClass(parent.parentNode, 'main-grid-fade-right');
		}
	};

	this.OnRowContext = function(e) {
		if (!_this.menu) {
			return;
		}

		if (!e) {
			e = window.event;
		}
		if (!phpVars.opt_context_ctrl && e.ctrlKey || phpVars.opt_context_ctrl && !e.ctrlKey) {
			return;
		}

		var targetElement;
		if (e.target) {
			targetElement = e.target;
		}
		else if (e.srcElement) {
			targetElement = e.srcElement;
		}

		//column context menu
		var el = targetElement;
		while (el && !(el.tagName && el.tagName.match(/(th|td)/i) && el.oncontextmenu)) {
			el = BX.findParent(el, {tagName: /(th|td)/i});
		}

		var col_menu = null;
		if (el && el.oncontextmenu) {
			col_menu = el.oncontextmenu();
			col_menu[col_menu.length] = {'SEPARATOR': true};
		}

		//row context menu
		el = targetElement;
		while (el && !(el.tagName && el.tagName.toUpperCase() === 'TR' && el.oncontextmenu)) {
			el = jsUtils.FindParentObject(el, "tr");
		}

		var menu = _this.menu;
		menu.PopupHide();

		_this.activeRow = el;
		if (_this.activeRow && !BX.hasClass(el, 'main-grid-row-head'))
		{
			_this.activeRow.className += ' active';
		}

		menu.OnClose = function()
		{
			if(_this.activeRow)
			{
				_this.activeRow.className = _this.activeRow.className.replace(/\s*active/i, '');
				_this.activeRow = null;
			}
		};

		//combined menu
		var menuItems = BX.util.array_merge(col_menu, el.oncontextmenu());
		if(menuItems.length == 0)
		{
			return;
		}

		menu.SetItems(menuItems);
		menu.BuildItems();

		var arScroll = jsUtils.GetWindowScrollPos();
		var x = e.clientX + arScroll.scrollLeft;
		var y = e.clientY + arScroll.scrollTop;
		var pos = {};
		pos.left = pos.right = x;
		pos.top = pos.bottom = y;

		menu.PopupShow(pos);

		e.returnValue = false;
		if(e.preventDefault)
		{
			e.preventDefault();
		}
	};

	this.ShowActionMenu = function(el, index)
	{
		_this.menu.PopupHide();

		_this.activeRow = jsUtils.FindParentObject(el, 'tr');
		if(_this.activeRow)
		{
			_this.activeRow.className += ' active';
		}

		var row = BX('datarow_'+this.table_id+'_'+index);
		var actionItems = BX.data(row, 'actions');

		if (row && actionItems)
		{
			var items = JSON.parse(actionItems);
			if (items && items.length > 0)
			{
				_this.menu.ShowMenu(el, items, false, false,
					function()
					{
						if(_this.activeRow)
						{
							_this.activeRow.className = _this.activeRow.className.replace(/\s*active/i, '');
							_this.activeRow = null;
						}
					}
				);
			}
		}

	};

	this.SelectRow = function(checkbox, e)
	{
		e = e ? e : window.event;

		var row = BX.findParent(checkbox, { className: 'main-grid-row' });
		var span = document.getElementById(this.table_id+'_selected_span');
		var selCount = parseInt(span.innerHTML);

		var rows = [row];

		if (e && e.shiftKey && last_row && last_row !== row)
		{
			var tbl = document.getElementById(this.table_id);

			for (var i = Math.min(last_row.rowIndex, row.rowIndex)+1; i < Math.max(last_row.rowIndex, row.rowIndex); i++)
			{
				rows.push(tbl.rows[i]);
			}

			if (BX.findChildByClassName(last_row.cells[0], 'main-grid-checkbox').checked)
			{
				rows.push(last_row);
			}
		}

		for (var i in rows)
		{
			var row_checkbox = BX.findChildByClassName(rows[i].cells[0], 'main-grid-checkbox');
			if (row_checkbox && (checkbox === row_checkbox || row_checkbox.checked !== checkbox.checked))
			{
				row_checkbox.checked = checkbox.checked;
				if (checkbox.checked)
				{
					BX.addClass(rows[i], 'main-grid-row-checked');
					selCount++;
				}
				else
				{
					BX.removeClass(rows[i], 'main-grid-row-checked');
					selCount--;
				}
			}
		}

		span.innerHTML = selCount.toString();

		var checkAll = BX(this.table_id+'_check_all');
		checkAll.checked = this.checkBoxCount > 0 && selCount === this.checkBoxCount;

		last_row = row;
	};

	this.SelectAllRows = function(checkbox) {};

	this.EnableActions = function()
	{
		var form = document.forms['form_'+this.table_id];
		if (!form) return;

		var bEnabled     = this.IsActionEnabled();
		var bEnabledEdit = this.IsActionEnabled('edit');

		var editButton   = BX('edit_button_'+this.table_id);
		var deleteButton = BX('delete_button_'+this.table_id);

		if (form.apply)
		{
			form.apply.disabled = !bEnabled;
			BX[bEnabled ? 'removeClass' : 'addClass'](form.apply, 'webform-button-disable');
		}
		if (editButton)
			BX[bEnabledEdit ? 'removeClass' : 'addClass'](editButton, 'main-grid-control-panel-action-icon-disable');
		if (deleteButton)
			BX[bEnabled ? 'removeClass' : 'addClass'](deleteButton, 'main-grid-control-panel-action-icon-disable');
	};

	/**
	 * @return {boolean}
	 */
	this.IsActionEnabled = function(action)
	{
		var form = document.forms['form_'+this.table_id];
		if(!form) return;

		var bChecked = false;
		var span = document.getElementById(this.table_id+'_selected_span');
		if(span && parseInt(span.innerHTML)>0)
			bChecked = true;

		var elAll = form['action_all_rows_'+this.table_id];
		if(action == 'edit')
			return !(elAll && elAll.checked) && bChecked;
		else
			return (elAll && elAll.checked) || bChecked;
	};

	this.SwitchActionButtons = function(bShow)
	{
		var buttons = BX('bx_grid_'+this.table_id+'_action_buttons');

		var div = buttons;
		while(div = jsUtils.FindNextSibling(div, 'div'))
			div.style.display = (bShow ? 'none' : '');

		buttons.style.display = bShow ? '' : 'none';
	};

	this.ActionEdit = function()
	{
		if(this.IsActionEnabled('edit'))
		{
			var form = document.forms['form_'+this.table_id];
			if(!form)
				return;

			this.editMode = true;

			//show form buttons
			this.SwitchActionButtons(true);

			//go through rows and show inputs
			var ids = form['ID[]'];
			if(!ids.length)
				ids = new Array(ids);

			for(var i=0; i<ids.length; i++)
			{
				var el = ids[i];
				if(el.checked)
				{
					var tr = jsUtils.FindParentObject(el, "tr");
					BX.denyEvent(tr, 'dblclick');

					//go through columns
					var td = jsUtils.FindParentObject(el, "td");
					td = jsUtils.FindNextSibling(td, "td");
					if(BX.hasClass(td, 'main-grid-cell-action'))
						td = jsUtils.FindNextSibling(td, "td");

					var row_id = el.value;
					this.oSaveData[row_id] = {};
					for(var col_id in this.oVisibleCols)
					{
						if(this.oVisibleCols[col_id] == true && this.oColsMeta[col_id].editable == true && this.oEditData[row_id][col_id] !== false)
						{
							this.oSaveData[row_id][col_id] = td.innerHTML;
							td.innerHTML = '';

							//insert controls
							var data = this.oEditData[row_id][col_id];
							var name = 'FIELDS['+row_id+']['+col_id+']';
							var span = BX.create('SPAN', {'props': {'className': 'main-grid-cell-content'}});
							switch(this.oColsMeta[col_id].type)
							{
								case 'checkbox':
									span.appendChild(BX.create('INPUT', {'props': {
										'type': 'hidden',
										'name': name,
										'value': 'N'
									}}));
									span.appendChild(BX.create('INPUT', {'props': {
										'className': 'main-grid-cell-content-edit',
										'type': 'checkbox',
										'name': name,
										'value': 'Y',
										'checked': data == 'Y',
										'defaultChecked': data == 'Y'
									}}));
									break;
								case 'list':
									var options = [];
									for (var list_val in this.oColsMeta[col_id].items)
									{
										options[options.length] = BX.create('OPTION', {
											'props': {
												'value': list_val,
												'selected': list_val == data
											},
											'text': this.oColsMeta[col_id].items[list_val]
										});
									}

									span.appendChild(BX.create('SELECT', {
										'props': {
											'className': 'main-grid-cell-content-edit',
											'name': name
										},
										'children': options
									}));
									break;
								case 'date':
									var params = {
										'props': {
											'className': 'main-grid-cell-content-edit',
											'type': 'text',
											'name': name,
											'value': data,
											'size': this.oColsMeta[col_id].size ? this.oColsMeta[col_id].size : 20
										},
										'style': {'paddingRight': '20px'}
									};
									if (this.oColsMeta[col_id].size)
										params.props.size = this.oColsMeta[col_id].size;
									else
										params.style.width = '100%';

									span.appendChild(BX.create('INPUT', params));
									span.appendChild(BX.create('A', {
										'props': {
											'href':'javascript:void(0);',
											'title': this.vars.mess.calend_title
										},
										'style': {
											'border': 'none',
											'position': 'relative',
											'right': '22px'
										},
										'children': [
											BX.create('IMG', {'props': {
												'className': 'calendar-icon',
												'src': this.vars.calendar_image,
												'alt': this.vars.mess.calend_title,
												'onclick': (function(field) {
													return function() {
														BX.calendar({
															'node': this,
															'field': field,
															'bTime': true,
															'currentTime': _this.vars.server_time
														});
													};
												})(name),
												'onmouseover': function() {
													BX.addClass(this, 'calendar-icon-hover');
												},
												'onmouseout': function() {
													BX.removeClass(this, 'calendar-icon-hover');
												}
											}})
										]
									}));
									BX.addClass(span, 'main-grid-cell-text-line');
									break;
								case 'textarea':
									var params = {
										'props': {
											'className': 'main-grid-cell-content-edit',
											'name': name
										},
										'text': data
									};

									if (this.oColsMeta[col_id].cols)
										params.props.cols = this.oColsMeta[col_id].cols;
									else
										params.style = {'width': '100%'};

									if (this.oColsMeta[col_id].rows)
										params.props.rows = this.oColsMeta[col_id].rows;

									if (this.oColsMeta[col_id].maxlength)
										params.props.maxLength = this.oColsMeta[col_id].maxlength;

									span.appendChild(BX.create('TEXTAREA', params));
									break;
								case 'file':
									span.appendChild(BX.create('INPUT', {'props': {
										'className': 'main-grid-cell-content-edit',
										'type': 'file',
										'name': name
									}}));
									break;
								default:
									var params = {'props': {
										'className': 'main-grid-cell-content-edit',
										'type': 'text',
										'name': name,
										'value': data
									}};

									if (this.oColsMeta[col_id].size)
										params.props.size = this.oColsMeta[col_id].size;
									else
										params.style = {'width': '100%'};

									if (this.oColsMeta[col_id].maxlength)
										params.props.maxLength = this.oColsMeta[col_id].maxlength;

									span.appendChild(BX.create('INPUT', params));
									break;
							}

							td.appendChild(span);
						}
						td = jsUtils.FindNextSibling(td, "td");
					}
				}
				el.disabled = true;
			}

			BX(this.table_id+'_check_all').disabled = true;

			form.elements['action_button_'+this.table_id].value = 'edit';
		}
	};

	this.ActionCancel = function()
	{
		var form = document.forms['form_'+this.table_id];
		if(!form)
			return;

		this.editMode = false;

		//hide form buttons
		this.SwitchActionButtons(false);

		//go through rows and restore values
		var ids = form['ID[]'];
		if(!ids.length)
			ids = new Array(ids);

		for(var i=0; i<ids.length; i++)
		{
			var el = ids[i];
			if(el.checked)
			{
				var tr = jsUtils.FindParentObject(el, "tr");
				BX.allowEvent(tr, 'dblclick');

				//go through columns
				var td = jsUtils.FindParentObject(el, "td");
				td = jsUtils.FindNextSibling(td, "td");
				if(BX.hasClass(td, 'main-grid-cell-action'))
					td = jsUtils.FindNextSibling(td, "td");

				var row_id = el.value;
				for(var col_id in this.oVisibleCols)
				{
					if(typeof this.oSaveData[row_id][col_id] != 'undefined')
						td.innerHTML = this.oSaveData[row_id][col_id];

					td = jsUtils.FindNextSibling(td, "td");
				}
			}
		}

		this.toggleCheckboxes();

		form.elements['action_button_'+this.table_id].value = '';
	};

	this.ActionDelete = function()
	{
		var form = document.forms['form_'+this.table_id];
		if(!form)
			return;

		form.elements['action_button_'+this.table_id].value = 'delete';

		BX.submit(form);
	};

	this.ForAllClick = function(el)
	{
		if(el.checked && !confirm(this.vars.mess.for_all_confirm))
		{
			el.checked=false;
			return;
		}

		//go through rows
		var ids = el.form['ID[]'];
		if(ids)
		{
			if(!ids.length)
				ids = new Array(ids);
			for(var i=0; i<ids.length; i++)
			{
				if (ids[i].getAttribute('data-disabled'))
					continue;
				ids[i].disabled = el.checked;
			}
		}

		BX(this.table_id+'_check_all').disabled = el.checked;

		this.editMode = el.checked;

		this.EnableActions();
	};

	this.Sort = function(url, by, sort_state, def_order, args)
	{
		var order;
		if(sort_state == '')
		{
			var e = null, bControl = false;
			if(args.length > 0)
				e = args[0];
			if(!e)
				e = window.event;
			if(e)
				bControl = e.ctrlKey;
			order = (bControl? (def_order == 'acs'? 'desc':'asc') : def_order);
		}
		else if(sort_state == 'asc')
			order = 'desc';
		else
			order = 'asc';

		url += order;

		BX.ajax.get('/bitrix/components'+_this.vars.component_path+'/settings.ajax.php?GRID_ID='+_this.table_id+'&action=savesort&by='+by+'&order='+order+'&sessid='+_this.vars.sessid, function(){
			_this.Reload(url);
		});
	};

	/**
	 * @return {boolean}
	 */
	this.GetColumnId = function(column)
	{
		var colId = false;
		var tbl = BX(this.table_id);
		for (var i = 0; i < tbl.rows[0].cells.length; i++)
		{
			if (tbl.rows[0].cells[i].getAttribute('data-name') == column)
			{
				colId = i;
				break;
			}
		}

		return colId;
	};


	this.animation = function(node, props, duration, callback)
	{
		_this.animation.stop(node);

		var iteration = function()
		{
			node.__animation.step++;

			var animation = node.__animation;
			for (var i in animation.props)
			{
				var params = animation.props[i];
				node.style[i] = params.from*1 + (params.to-params.from) * animation.step / animation.steps + params.unit;
			}

			if (animation.step >= animation.steps)
				_this.animation.stop(node);
		};

		node.__animation = {
			'props': props,
			'steps': Math.round(duration/10),
			'step': 0,
			'callback': callback
		};

		node.__animation.interval = setInterval(iteration, duration/node.__animation.steps);
	};

	this.animation.stop = function(node)
	{
		if (node.__animation && node.__animation.interval)
		{
			node.__animation.interval = clearInterval(node.__animation.interval);
			if (node.__animation.callback)
				node.__animation.callback();
		}
	};

	this.toogleColumnCells = function(cid, show, fix)
	{
		var table = BX(_this.table_id);

		for (var i = 0; i < table.rows.length; i++)
		{
			var cells = table.rows[i].cells;
			if (cells[cid])
			{
				cells[cid].style.display = show ? '' : 'none';

				var content = BX.findChildByClassName(cells[cid], 'main-grid-cell-content', false);
				if (content && content.style)
					content.style.width = fix ? content.clientWidth+'px' : ''; // @TODO: clientWidth includes paddings
			}
		}
	};


	this.toggleCheckboxes = function()
	{
		var table = BX(this.table_id);

		for (var i = 1; i < table.rows.length; i++)
		{
			if (BX.hasClass(table.rows[i], 'main-grid-data-row'))
			{
				var checkbox = BX.findChildByClassName(table.rows[i].cells[0], 'main-grid-checkbox');
				var data_id = checkbox.value;

				var editable = false;

				if (this.hasActions)
				{
					if (!checkbox.getAttribute('data-disabled'))
						editable = true;
				}
				else if (typeof this.oEditData[data_id] != 'undefined')
				{
					for (var j in this.oVisibleCols)
					{
						if (this.oVisibleCols[j] && this.oColsMeta[j].editable && this.oEditData[data_id][j] !== false)
							editable = true;
					}
				}

				if (editable)
				{
					if (checkbox.getAttribute('data-disabled'))
						this.checkBoxCount++;
					checkbox.disabled = this.editMode;
					checkbox.removeAttribute('data-disabled');
				}
				else
				{
					if (!checkbox.getAttribute('data-disabled'))
						this.checkBoxCount--;
					checkbox.disabled = true;
					checkbox.setAttribute('data-disabled', 1);
				}
			}
		}

		if (this.checkBoxCount == 0)
		{
			BX(this.table_id+'_check_all').disabled = true;
			if (!this.editMode)
			{
				for (var i = 1; i < table.rows.length; i++)
				{
					if (BX.hasClass(table.rows[i], 'main-grid-data-row'))
					{
						var checkbox = BX.findChildByClassName(table.rows[i].cells[0], 'main-grid-checkbox');

						if (checkbox.checked)
						{
							checkbox.checked = false;
							this.SelectRow(checkbox);
						}
					}
				}
				BX(this.table_id+'_action_bar_fade').style.display = '';
			}
		}
		else
		{
			if (!this.editMode)
				BX(this.table_id+'_check_all').disabled = false;
			BX(this.table_id+'_action_bar_fade').style.display = 'none';
		}
	};

	this.SaveColumns = function(columns, callback)
	{
		var sCols = '';
		if(columns)
		{
			sCols = columns
		}
		else
		{
			if(!_this.bColsChanged)
				return;

			for(var id in _this.oVisibleCols)
				if(_this.oVisibleCols[id])
					sCols += (sCols!=''? ',':'')+id;
		}

		_this.oOptions.views[_this.oOptions.current_view].columns = sCols; // @TODO: sync

		if (_this.vars.user_authorized)
		{
			BX.ajax.get(
				'/bitrix/components'+_this.vars.component_path+'/settings.ajax.php',
				{
					GRID_ID: _this.table_id,
					action: 'showcolumns',
					columns: sCols,
					sessid: _this.vars.sessid
				},
				callback
			);
		}
	};

	this.saveColumnsSizes = function()
	{
		Grid.getUserOptions().setColumnSizes(_this.resizeMeta.columns, _this.resizeMeta.expand);
	};

	this.Reload = function(url)
	{
		var Grid = BX.Main.gridManager.getById(_this.grid_id).instance;
		var container = Grid.getScrollContainer();
		var request;

		jsDD.Disable();

		if(!url)
		{
			url = this.vars.current_url[this.vars.current_url.length-1];
		}

		if(this.vars.ajax.AJAX_ID != '')
		{
			request = BX.ajax.insertToNode(url+(url.indexOf('?') == -1? '?':'&')+'bxajaxid='+this.vars.ajax.AJAX_ID, 'comp_'+this.vars.ajax.AJAX_ID);
			request.onprogress = function()
			{
				_this.scrollContainerLeft = container.scrollLeft;
			};

			request.onload = function()
			{
				Grid.getScrollContainer().scrollLeft = _this.scrollContainerLeft;
				Grid.reloadTable();
			};
		}
		else
		{
			window.location = url;
		}
	};

	this.SetView = function(view_id)
	{
		var filter_id = _this.oOptions.views[view_id].saved_filter;
		var func = (filter_id && _this.oOptions.filters[filter_id]?
			function(){_this.ApplyFilter(filter_id)} :
			function(){_this.Reload()});

		BX.ajax.get('/bitrix/components'+_this.vars.component_path+'/settings.ajax.php?GRID_ID='+_this.table_id+'&action=setview&view_id='+view_id+'&sessid='+_this.vars.sessid, func);
	};

	this.EditCurrentView = function()
	{
		this.ShowSettings(this.oOptions.views[this.oOptions.current_view],
			function()
			{
				_this.SaveSettings(_this.oOptions.current_view, true);
			}
		);
	};

	this.AddView = function()
	{
		var view_id = 'view_'+Math.round(Math.random()*1000000);

		var view = {};
		for(var i in this.oOptions.views[this.oOptions.current_view])
			view[i] = this.oOptions.views[this.oOptions.current_view][i];
		view.name = this.vars.mess.viewsNewView;

		this.ShowSettings(view,
			function()
			{
				var data = _this.SaveSettings(view_id);

				_this.oOptions.views[view_id] = {
					'name':data.name,
					'columns':data.columns,
					'sort_by':data.sort_by,
					'sort_order':data.sort_order,
					'page_size':data.page_size,
					'saved_filter':data.saved_filter,
					'custom_names': data.custom_names,
					'columns_sizes': data.columns_sizes
				};
				_this.bViewsChanged = true;

				var form = document['views_'+_this.table_id];
				form.views_list.options[form.views_list.length] = new Option((data.name != ''? data.name:_this.vars.mess.viewsNoName), view_id, true, true);
			}
		);
	};

	this.EditView = function(view_id)
	{
		this.ShowSettings(this.oOptions.views[view_id],
			function()
			{
				var data = _this.SaveSettings(view_id);

				_this.oOptions.views[view_id] = {
					'name':data.name,
					'columns':data.columns,
					'sort_by':data.sort_by,
					'sort_order':data.sort_order,
					'page_size':data.page_size,
					'saved_filter':data.saved_filter,
					'custom_names': data.custom_names,
					'columns_sizes': data.columns_sizes
				};
				_this.bViewsChanged = true;

				var form = document['views_'+_this.table_id];
				form.views_list.options[form.views_list.selectedIndex].text = (data.name != ''? data.name:_this.vars.mess.viewsNoName);
			}
		);
	};

	this.DeleteView = function(view_id)
	{
		if(!confirm(this.vars.mess.viewsDelete))
			return;

		var form = document['views_'+this.table_id];
		var index = form.views_list.selectedIndex;
		form.views_list.remove(index);
		form.views_list.selectedIndex = (index < form.views_list.length? index : form.views_list.length-1);

		this.bViewsChanged = true;

		BX.ajax.get('/bitrix/components'+this.vars.component_path+'/settings.ajax.php?GRID_ID='+this.table_id+'&action=delview&view_id='+view_id+'&sessid='+_this.vars.sessid);
	};

	this.ShowSettings = function(view, action)
	{
		var bCreated = false;
		if(!window['settingsDialog'+this.table_id])
		{
			window['settingsDialog'+this.table_id] = new BX.CDialog({
				'content':'<form name="settings_'+this.table_id+'"></form>',
				'title': this.vars.mess.settingsTitle,
				'width': this.vars.settingWndSize.width,
				'height': this.vars.settingWndSize.height,
				'resize_id': 'InterfaceGridSettingWnd'
			});
			bCreated = true;
		}

		window['settingsDialog'+this.table_id].ClearButtons();
		window['settingsDialog'+this.table_id].SetButtons([
			{
				'title': this.vars.mess.settingsSave,
				'action': function(){
					action();
					this.parentWindow.Close();
				}
			},
			BX.CDialog.prototype.btnCancel
		]);
		window['settingsDialog'+this.table_id].Show();

		var form = document['settings_'+this.table_id];

		if(bCreated)
			form.appendChild(BX('view_settings_'+this.table_id));

		this.customNames = (view.custom_names? view.custom_names : {});
		this.columnsSizes = view.columns_sizes ? view.columns_sizes : {};

		//name
		form.view_name.focus();
		form.view_name.value = view.name;

		//get visible columns
		var aVisCols = [];
		if(view.columns != '')
		{
			aVisCols = view.columns.split(',');
		}
		else
		{
			for (var i in this.oVisibleCols)
			{
				if (this.oVisibleCols[i])
					aVisCols[aVisCols.length] = i;
			}
		}

		var oVisCols = {}, n;
		for(i=0, n=aVisCols.length; i<n; i++)
			oVisCols[aVisCols[i]] = true;

		//invisible cols
		jsSelectUtils.deleteAllOptions(form.view_all_cols);
		for(i in this.oColsNames)
		{
			if(!oVisCols[i])
			{
				var colName = this.customNames[i] ? (this.customNames[i]+' ('+this.oColsNames[i]+')') : this.oColsNames[i];
				form.view_all_cols.options[form.view_all_cols.length] = new Option(colName, i, false, false);
			}
		}

		//visible cols
		jsSelectUtils.deleteAllOptions(form.view_cols);
		for(i in oVisCols)
		{
			colName = this.customNames[i] ? (this.customNames[i]+' ('+this.oColsNames[i]+')') : this.oColsNames[i];
			form.view_cols.options[form.view_cols.length] = new Option(colName, i, false, false);
		}

		form.reset_columns_sizes.checked = false;

		//sorting
		jsSelectUtils.selectOption(form.view_sort_by, view.sort_by);
		jsSelectUtils.selectOption(form.view_sort_order, view.sort_order);

		//page size
		jsSelectUtils.selectOption(form.view_page_size, view.page_size);

		//saved filter
		jsSelectUtils.deleteAllOptions(form.view_filters);
		form.view_filters.options[0] = new Option(this.vars.mess.viewsFilter, '');
		for(i in this.oOptions.filters)
			form.view_filters.options[form.view_filters.length] = new Option(this.oOptions.filters[i].name, i, (i == view.saved_filter), (i == view.saved_filter));

		//common options
		if(form.set_default_settings)
		{
			form.set_default_settings.checked = false;
			form.delete_users_settings.checked = false;
			form.delete_users_settings.disabled = true;
		}

		//init controls
		form.up_btn.disabled = form.down_btn.disabled = form.rename_btn.disabled = form.add_btn.disabled = form.del_btn.disabled = true;
	};

	this.RenameColumn = function()
	{
		var bCreated = false;
		if(!window['renameDialog'+this.table_id])
		{
			window['renameDialog'+this.table_id] = new BX.CDialog({
				'content':'<form name="rename_'+this.table_id+'"></form>',
				'title': this.vars.mess.renameTitle,
				'width': this.vars.renameWndSize.width,
				'height': this.vars.renameWndSize.height,
				'resize_id': 'InterfaceGridRenameWnd',
				'buttons': [
					{
						'title': this.vars.mess.settingsSave,
						'action': function()
						{
							var selectedCol = settingsForm.view_cols.value;
							var value = form.col_name.value;

							if(value.length > 0)
							{
								_this.customNames[selectedCol] = value;
								value = value+' ('+_this.oColsNames[selectedCol]+')';
							}
							else
							{
								value = _this.oColsNames[selectedCol];
								delete _this.customNames[selectedCol];
							}
							settingsForm.view_cols.options[settingsForm.view_cols.selectedIndex].text = value;

							this.parentWindow.Close();
						}
					},
					BX.CDialog.prototype.btnCancel
				]
			});
			bCreated = true;
		}

		window['renameDialog'+this.table_id].Show();

		var form = document['rename_'+this.table_id];
		var settingsForm = document['settings_'+this.table_id];

		if(bCreated)
			form.appendChild(BX('rename_column_'+this.table_id));

		var selectedCol = settingsForm.view_cols.value;

		form.col_name.focus();
		form.col_name_def.value = this.oColsNames[selectedCol];
		form.col_name.value = (this.customNames[selectedCol]? this.customNames[selectedCol] : this.oColsNames[selectedCol]);
	};

	this.SaveSettings = function(view_id, doReload)
	{
		var form = document['settings_'+this.table_id];

		var sCols = '';
		var n = form.view_cols.length;
		for(var i=0; i<n; i++)
			sCols += (sCols!=''? ',':'')+form.view_cols[i].value;

		var data = {
			'GRID_ID': this.grid_id,
			'view_id': view_id,
			'action': Grid.getUserOptions().getAction('GRID_SAVE_SETTINGS'),
			'sessid': this.vars.sessid,
			'name': form.view_name.value,
			'columns': sCols,
			'sort_by': form.view_sort_by.value,
			'sort_order': form.view_sort_order.value,
			'page_size': form.view_page_size.value,
			'saved_filter': form.view_filters.value,
			'custom_names': this.customNames,
			'columns_sizes': !form.reset_columns_sizes.checked ? this.columnsSizes : {}
		};

		if(form.set_default_settings)
		{
			data.set_default_settings = (form.set_default_settings.checked? 'Y':'N');
			data.delete_users_settings = (form.delete_users_settings.checked? 'Y':'N');
		}

		var handler = null;
		if(doReload === true)
		{
			handler = function()
			{
				if(data.saved_filter && _this.oOptions.filters[data.saved_filter])
				{
					_this.ApplyFilter(data.saved_filter);
				}
				else
				{
					Grid.reloadTable();
				}
			};
		}

		BX.ajax.post('/bitrix/components'+_this.vars.component_path+'/settings.ajax.php', data, handler);

		return data;
	};

	this.ReloadViews = function()
	{
		if(_this.bViewsChanged)
			_this.Reload();
	};

	this.ShowViews = function()
	{
		this.bViewsChanged = false;
		var bCreated = false;
		if(!window['viewsDialog'+this.table_id])
		{
			var applyBtn = new BX.CWindowButton({
				'title': this.vars.mess.viewsApply,
				'hint': this.vars.mess.viewsApplyTitle,
				'action': function(){
					var form = document['views_'+_this.table_id];
					if(form.views_list.selectedIndex != -1)
						_this.SetView(form.views_list.value);

					window['bxGrid_'+_this.table_id].bViewsChanged = false;
					this.parentWindow.Close();
				}
			});

			window['viewsDialog'+this.table_id] = new BX.CDialog({
				'content':'<form name="views_'+this.table_id+'"></form>',
				'title': this.vars.mess.viewsTitle,
				'buttons': [applyBtn, BX.CDialog.prototype.btnClose],
				'width': this.vars.viewsWndSize.width,
				'height': this.vars.viewsWndSize.height,
				'resize_id': 'InterfaceGridViewsWnd'
			});

			BX.addCustomEvent(window['viewsDialog'+this.table_id], 'onWindowUnRegister', this.ReloadViews);

			bCreated = true;
		}

		window['viewsDialog'+this.table_id].Show();

		var form = document['views_'+this.table_id];

		if(bCreated)
			form.appendChild(BX('views_list_'+this.table_id));
	};

	/* DD handlers */

	this.DragStart = function()
	{
		_this.onDragStart(this);

		var Grid = BX.Main.gridManager.getById(_this.grid_id).instance;
		var container = Grid.getContainer();
		var table = Grid.getTable();
		var cells = Grid.getRows().getHeadChild()[0].getCells();
		var cellPosition = BX.pos(this);
		var containerPosition = BX.pos(container);
		var cellLeft = cellPosition.left - containerPosition.left;
		var node = BX.findChildByClassName(this, 'main-grid-cell-head-container', false);

		this.__cursor = BX.create('div', {props: {className: Grid.settings.get('classCursor')}});
		container.appendChild(this.__cursor);

		node.style.width = this.clientWidth+'px';
		node.style.height = this.clientHeight+'px';



		this.__dragNode = document.createElement('DIV');
		this.__dragNode.className = 'main-grid-cell-head-drag';
		this.__dragNode.appendChild(node);

		BX.style(this.__dragNode, 'left', cellLeft + 'px');
		table.parentNode.insertBefore(this.__dragNode, table);

		this.style.height = cellPosition.height+'px';
		this.innerHTML = '<span class="main-grid-cell-head-container" style="z-index: 25; "></span>';
		BX.addClass(this, 'main-grid-cell-head-drag-dest');

		this.__dragDest = this.cellIndex;
		this.__dragX = cellLeft-jsDD.start_x;

		this.__dragCells = [];
		for (var i = 0; i < cells.length; i++)
		{
			if (cells[i].__fixed) continue;

			var ipos = BX.pos(cells[i]);

			if (!ipos.width) continue;

			var inode = BX.findChildByClassName(cells[i], 'main-grid-cell-head-container', false);

			BX.addClass(cells[i], 'main-grid-cell-head-ondrag');
			this.__cursor.style.left = (ipos.left-containerPosition.left)+'px';

			if (i == this.cellIndex)
			{
				inode.style.height   = (ipos.height-2)+'px';
				this.__dragCells.ref = this.__dragCells.length;
			}

			this.__dragCells.push({ index: i, node: inode, offset: ipos.left-containerPosition.left, width: ipos.width, move: 0 });
		}

		if (this.__dragCells.length > 1 && this.__dragCells.ref == this.__dragCells.length-1)
		{
			var index = this.__dragCells[this.__dragCells.length-2].index;
			BX.addClass(cells[index], 'main-grid-cell-last');
		}
	};

	this.Drag = function(x)
	{
		var self = this;
		var Grid = BX.Main.gridManager.getById(_this.grid_id).instance;
		var container = Grid.getContainer();
		var dragX = (x+this.__dragX);
		var containerPosition = BX.pos(container);
		var dragDestNode, destNode, offset;

		this.__dragNode.style.left = (dragX + 'px');

		for (var i = this.__dragCells.length-1; i >= 0; i--)
		{
			if ((x-containerPosition.left) > this.__dragCells[i].offset)
			{
				this.__dest = this.__dragCells[i].index;
				break;
			}
		}

		dragDestNode = this.__dragCells.filter(function(current) {
			return current.index == self.__dragDest;
		})[0];

		destNode = this.__dragCells.filter(function(current) {
			return current.index == self.__dest;
		})[0];

		offset = destNode.offset;

		if (this.__dest > this.__dragDest)
		{
			offset = (destNode.offset + destNode.width);
		}

		dragDestNode.node.style.left = offset+'px';
		this.__cursor.style.left = offset+'px';
	};

	this.DragStop = function()
	{
		_this.onDragStop(this);

		var self = this;
		var Grid = BX.Main.gridManager.getById(_this.grid_id).instance;
		var rows = Grid.getRows().getList();
		var cells, dragCell, destCell, name, columns;

		var node = BX.findChildByClassName(this.__dragNode, Grid.settings.get('classCellHeadContainer'), false);
		this.innerHTML = '';
		this.appendChild(node);
		this.style.height = '';

		BX.removeClass(this, 'main-grid-cell-head-drag-dest');
		BX.remove(this.__cursor);
		BX.remove(this.__dragNode);

		rows.map(function(currentRow) {
			cells = currentRow.getCells();
			dragCell = cells[self.__dragDest];
			destCell = cells[self.__dest];

			if (currentRow.isHeadChild() || currentRow.isBodyChild() || currentRow.isFootChild())
			{
				if (self.__dest < self.__dragDest)
				{
					currentRow.getNode().insertBefore(dragCell, destCell);
				}

				if (self.__dest > self.__dragDest)
				{
					if (BX.type.isDomNode(destCell.nextElementSibling))
					{
						currentRow.getNode().insertBefore(dragCell, destCell.nextElementSibling);
					}
					else
					{
						currentRow.getNode().appendChild(dragCell);
					}
				}

				for (var i = 0; i < cells.length; i++)
				{
					var inode = BX.findChildByClassName(cells[i], Grid.settings.get('classCellHeadContainer'), false);
					if (inode && inode.style)
					{
						inode.style.width = '';
						inode.style.left  = '';
					}

					BX.removeClass(cells[i], Grid.settings.get('classCellHeadOndrag'));
				}
			}
		});

		if (this.__dest !== this.__dragDest)
		{
			cells = Grid.getRows().getHeadChild()[0].getCells();
			columns = _this.oVisibleCols;
			_this.oVisibleCols = {};

			[].forEach.call(cells, function(current) {
				name = BX.data(current, 'name');
				if (name)
				{
					_this.oVisibleCols[name] = columns[name];
				}
			});

			_this.bColsChanged = true;
			_this.SaveColumns();
		}
	};

	this.resizeColumnStart = function()
	{
		var cell = BX.findParent(this, { className: 'main-grid-cell-head' });
		_this.onDragStart(cell);

		this.__resizeCell = cell.cellIndex;
	};

	this.resizeColumn = function(x)
	{
		var table = BX(_this.table_id);
		var fixedTable = Grid.getPinHeader().getFixedTable();
		var cell = table.rows[0].cells[this.__resizeCell];
		var fixedCell;

		var tpos = BX.pos(table);
		var cpos = BX.pos(cell);

		x -= cpos.left;
		if (x < _this.resizeMeta.minColumn) x = _this.resizeMeta.minColumn;

		cell.style.width = x+'px';

		if (BX.type.isDomNode(fixedTable) && BX.type.isDomNode(fixedTable.rows[0]))
		{
			fixedCell = fixedTable.rows[0].cells[this.__resizeCell];
			fixedCell.style.width = x+'px';
		}
		_this.toogleFader();
	};

	this.resizeColumnStop = function()
	{
		var table = BX(_this.table_id);
		var cells = table.rows[0].cells;

		_this.reinitResizeMeta();
		_this.toogleFader();

		_this.onDragStop(cells[this.__resizeCell]);
	};

	this.onDragStart = function(el)
	{
		if (el.getAttribute('onclick'))
		{
			el.setAttribute('data-onclick', el.getAttribute('onclick'));
			el.removeAttribute('onclick');
		}
	};

	this.onDragStop = function(el)
	{
		if (el.getAttribute('data-onclick'))
		{
			setTimeout(function() {
				el.setAttribute('onclick', el.getAttribute('data-onclick'));
				el.removeAttribute('data-onclick');
			}, 10);
		}
	};

	/* Filter */

	this.InitFilter = function()
	{
		var row = BX('flt_header_'+this.table_id);
		if(row)
			jsUtils.addEvent(row, "contextmenu", this.OnRowContext);
	};

	this.SwitchFilterRow = function(row_id, menuItem)
	{
		if(menuItem)
		{
			var colMenu = this.menu.GetMenuByItemId(menuItem.id);
			colMenu.SetItemIcon(menuItem, (this.oFilterRows[row_id]? '':'checked'));
		}
		else
		{
			var mnu = this.filterMenu[0].MENU;
			for(var i=0; i<mnu.length; i++)
			{
				if(mnu[i].ID == 'flt_'+this.table_id+'_'+row_id)
				{
					mnu[i].ICONCLASS = (this.oFilterRows[row_id]? '':'checked');
					break;
				}
			}
		}

		var row = BX('flt_row_'+this.table_id+'_'+row_id);
		row.style.display = (this.oFilterRows[row_id]? 'none':'');
		this.oFilterRows[row_id] = (this.oFilterRows[row_id]? false:true);

		var a = BX('a_minmax_'+this.table_id);
		if(a && a.className.indexOf('bx-filter-max') != -1)
			this.SwitchFilter(a);

		this.SaveFilterRows();
	};

	this.SwitchFilterRows = function(on)
	{
		this.menu.PopupHide();

		var i=0;
		for(var id in this.oFilterRows)
		{
			i++;
			if(i == 1 && on == false)
				continue;
			this.oFilterRows[id] = on;
			var row = BX('flt_row_'+this.table_id+'_'+id);
			row.style.display = (on? '':'none');
		}

		var mnu = this.filterMenu[0].MENU;
		for(i=0; i<mnu.length; i++)
		{
			if(i == 0 && on == false)
				continue;
			if(mnu[i].SEPARATOR == true)
				break;
			mnu[i].ICONCLASS = (on? 'checked':'');
		}

		var a = BX('a_minmax_'+this.table_id);
		if(a && a.className.indexOf('bx-filter-max') != -1)
			this.SwitchFilter(a);

		this.SaveFilterRows();
	};

	this.SaveFilterRows = function()
	{
		var sRows = '';
		for(var id in this.oFilterRows)
			if(this.oFilterRows[id])
				sRows += (sRows!=''? ',':'')+id;

		BX.ajax.get('/bitrix/components'+this.vars.component_path+'/settings.ajax.php?GRID_ID='+this.table_id+'&action=filterrows&rows='+sRows+'&sessid='+this.vars.sessid);
	};

	this.SwitchFilter = function(a)
	{
		var on = (a.className.indexOf('bx-filter-min') != -1);
		a.className = (on? 'bx-filter-btn bx-filter-max' : 'bx-filter-btn bx-filter-min');
		a.title = (on? this.vars.mess.filterShow : this.vars.mess.filterHide);

		var row = BX('flt_content_'+this.table_id);
		row.style.display = (on? 'none':'');

		BX.ajax.get('/bitrix/components'+this.vars.component_path+'/settings.ajax.php?GRID_ID='+this.table_id+'&action=filterswitch&show='+(on? 'N':'Y')+'&sessid='+this.vars.sessid);
	};

	this.ClearFilter = function(form)
	{
		for(var i=0, n=form.elements.length; i<n; i++)
		{
			var el = form.elements[i];
			switch(el.type.toLowerCase())
			{
				case 'text':
				case 'textarea':
					el.value = '';
					break;
				case 'select-one':
					el.selectedIndex = 0;
					break;
				case 'select-multiple':
					for(var j=0, l=el.options.length; j<l; j++)
						el.options[j].selected = false;
					break;
				case 'checkbox':
					el.checked = false;
					break;
				default:
					break;
			}
			if(el.onchange)
				el.onchange();
		}

		BX.onCustomEvent(form, "onGridClearFilter", []);

		form.clear_filter.value = "Y";

		BX.submit(form);
	};

	this.ShowFilters = function()
	{
		var bCreated = false;
		if(!window['filtersDialog'+this.table_id])
		{
			var applyBtn = new BX.CWindowButton({
				'title': this.vars.mess.filtersApply,
				'hint': this.vars.mess.filtersApplyTitle,
				'action': function(){
					var form = document['filters_'+_this.table_id];
					if(form.filters_list.value)
						_this.ApplyFilter(form.filters_list.value);
					this.parentWindow.Close();
				}
			});

			window['filtersDialog'+this.table_id] = new BX.CDialog({
				'content':'<form name="filters_'+this.table_id+'"></form>',
				'title': this.vars.mess.filtersTitle,
				'buttons': [applyBtn, BX.CDialog.prototype.btnClose],
				'width': this.vars.filtersWndSize.width,
				'height': this.vars.filtersWndSize.height,
				'resize_id': 'InterfaceGridFiltersWnd'
			});

			bCreated = true;
		}

		window['filtersDialog'+this.table_id].Show();

		var form = document['filters_'+this.table_id];
		if(bCreated)
			form.appendChild(BX('filters_list_'+this.table_id));
	};

	this.AddFilter = function(fields)
	{
		if(!fields)
			fields = {};
		var filter_id = 'filter_'+Math.round(Math.random()*1000000);
		var filter = {'name':this.vars.mess.filtersNew, 'fields':fields};

		this.ShowFilterSettings(filter,
			function()
			{
				var data = _this.SaveFilter(filter_id);

				_this.oOptions.filters[filter_id] = {
					'name':data.name,
					'fields':data.fields
				};

				var form = document['filters_'+_this.table_id];
				form.filters_list.options[form.filters_list.length] = new Option((data.name != ''? data.name:_this.vars.mess.viewsNoName), filter_id, true, true);

				if(_this.filterMenu.length == 4) //no saved filters
					_this.filterMenu = BX.util.insertIntoArray(_this.filterMenu, 1, {'SEPARATOR':true});
				var mnuItem = {'ID': 'mnu_'+_this.table_id+'_'+filter_id, 'TEXT': BX.util.htmlspecialchars(data.name), 'TITLE': _this.vars.mess.ApplyTitle, 'ONCLICK':'bxGrid_'+_this.table_id+'.ApplyFilter(\''+filter_id+'\')'};
				_this.filterMenu = BX.util.insertIntoArray(_this.filterMenu, 2, mnuItem);
			}
		);
	};

	this.AddFilterAs = function()
	{
		var form = document.forms['filter_'+this.table_id];
		var fields = this.GetFilterFields(form);
		this.ShowFilters();
		this.AddFilter(fields);
	};

	this.EditFilter = function(filter_id)
	{
		this.ShowFilterSettings(this.oOptions.filters[filter_id],
			function()
			{
				var data = _this.SaveFilter(filter_id);

				_this.oOptions.filters[filter_id] = {
					'name':data.name,
					'fields':data.fields
				};

				var form = document['filters_'+_this.table_id];
				form.filters_list.options[form.filters_list.selectedIndex].text = (data.name != ''? data.name:_this.vars.mess.viewsNoName);

				for(var i=0, n=_this.filterMenu.length; i<n; i++)
				{
					if(_this.filterMenu[i].ID && _this.filterMenu[i].ID == 'mnu_'+_this.table_id+'_'+filter_id)
					{
						_this.filterMenu[i].TEXT = BX.util.htmlspecialchars(data.name);
						break;
					}
				}
			}
		);
	};

	this.DeleteFilter = function(filter_id)
	{
		if(!confirm(this.vars.mess.filtersDelete))
			return;

		var form = document['filters_'+this.table_id];
		var index = form.filters_list.selectedIndex;
		form.filters_list.remove(index);
		form.filters_list.selectedIndex = (index < form.filters_list.length? index : form.filters_list.length-1);

		for(var i=0, n=this.filterMenu.length; i<n; i++)
		{
			if(_this.filterMenu[i].ID && _this.filterMenu[i].ID == 'mnu_'+_this.table_id+'_'+filter_id)
			{
				this.filterMenu = BX.util.deleteFromArray(this.filterMenu, i);
				if(this.filterMenu.length == 5)
					this.filterMenu = BX.util.deleteFromArray(this.filterMenu, 1);
				break;
			}
		}

		delete this.oOptions.filters[filter_id];

		BX.ajax.get('/bitrix/components'+this.vars.component_path+'/settings.ajax.php?GRID_ID='+this.table_id+'&action=delfilter&filter_id='+filter_id+'&sessid='+_this.vars.sessid);
	};

	this.ShowFilterSettings = function(filter, action)
	{
		var bCreated = false;
		if(!window['filterSettingsDialog'+this.table_id])
		{
			window['filterSettingsDialog'+this.table_id] = new BX.CDialog({
				'content':'<form name="flt_settings_'+this.table_id+'"></form>',
				'title': this.vars.mess.filterSettingsTitle,
				'width': this.vars.filterSettingWndSize.width,
				'height': this.vars.filterSettingWndSize.height,
				'resize_id': 'InterfaceGridFilterSettingWnd'
			});
			bCreated = true;
		}

		window['filterSettingsDialog'+this.table_id].ClearButtons();
		window['filterSettingsDialog'+this.table_id].SetButtons([
			{
				'title': this.vars.mess.settingsSave,
				'action': function(){
					action();
					this.parentWindow.Close();
				}
			},
			BX.CDialog.prototype.btnCancel
		]);
		window['filterSettingsDialog'+this.table_id].Show();

		var form = document['flt_settings_'+this.table_id];

		if(bCreated)
			form.appendChild(BX('filter_settings_'+this.table_id));

		form.filter_name.focus();
		form.filter_name.value = filter.name;

		this.SetFilterFields(form, filter.fields);
	};

	this.SetFilterFields = function(form, fields)
	{
		for(var i=0, n = form.elements.length; i<n; i++)
		{
			var el = form.elements[i];

			if(el.name == 'filter_name')
				continue;

			var val = fields[el.name] || '';

			switch(el.type.toLowerCase())
			{
				case 'select-one':
				case 'text':
				case 'textarea':
					el.value = val;
					break;
				case 'radio':
				case 'checkbox':
					el.checked = (el.value == val);
					break;
				case 'select-multiple':
					var name = el.name.substr(0, el.name.length - 2);
					var bWasSelected = false;
					for(var j=0, l = el.options.length; j<l; j++)
					{
						var sel = (fields[name]? fields[name]['sel'+el.options[j].value] : null);
						el.options[j].selected = (el.options[j].value == sel);
						if(el.options[j].value == sel)
							bWasSelected = true;
					}
					if(!bWasSelected && el.options.length > 0 && el.options[0].value == '')
						el.options[0].selected = true;
					break;
				default:
					break;
			}
			if(el.onchange)
				el.onchange();
		}
	};

	this.GetFilterFields = function(form)
	{
		var fields = {};
		for(var i=0, n = form.elements.length; i<n; i++)
		{
			var el = form.elements[i];

			if(el.name == 'filter_name')
				continue;

			switch(el.type.toLowerCase())
			{
				case 'select-one':
				case 'text':
				case 'textarea':
					fields[el.name] = el.value;
					break;
				case 'radio':
				case 'checkbox':
					if(el.checked)
						fields[el.name] = el.value;
					break;
				case 'select-multiple':
					var name = el.name.substr(0, el.name.length - 2);
					fields[name] = {};
					for(var j=0, l = el.options.length; j<l; j++)
						if(el.options[j].selected)
							fields[name]['sel'+el.options[j].value] = el.options[j].value;
					break;
				default:
					break;
			}
		}
		return fields;
	};

	this.SaveFilter = function(filter_id)
	{
		var form = document['flt_settings_'+this.table_id];
		var data = {
			'GRID_ID': this.table_id,
			'filter_id': filter_id,
			'action': 'savefilter',
			'sessid': this.vars.sessid,
			'name': form.filter_name.value,
			'fields': this.GetFilterFields(form)
		};

		BX.ajax.post('/bitrix/components'+_this.vars.component_path+'/settings.ajax.php', data);

		return data;
	};

	this.ApplyFilter = function(filter_id)
	{
		var form = document.forms['filter_'+this.table_id];
		this.SetFilterFields(form, this.oOptions.filters[filter_id].fields);

		BX.submit(form);
	};

	this.OnDateChange = function(sel)
	{
		var bShowFrom=false, bShowTo=false, bShowHellip=false, bShowDays=false, bShowBr=false;

		if(sel.value == 'interval')
			bShowBr = bShowFrom = bShowTo = bShowHellip = true;
		else if(sel.value == 'before')
			bShowTo = true;
		else if(sel.value == 'after' || sel.value == 'exact')
			bShowFrom = true;
		else if(sel.value == 'days')
			bShowDays = true;

		BX.findNextSibling(sel, {'tag':'span', 'class':'bx-filter-from'}).style.display = (bShowFrom? '':'none');
		BX.findNextSibling(sel, {'tag':'span', 'class':'bx-filter-to'}).style.display = (bShowTo? '':'none');
		BX.findNextSibling(sel, {'tag':'span', 'class':'bx-filter-hellip'}).style.display = (bShowHellip? '':'none');
		BX.findNextSibling(sel, {'tag':'span', 'class':'bx-filter-days'}).style.display = (bShowDays? '':'none');
		var span = BX.findNextSibling(sel, {'tag':'span', 'class':'bx-filter-br'});
		if(span)
			span.style.display = (bShowBr? '':'none');
	};

	this.loadColumn = function(column)
	{
		var table = BX(this.table_id);
		var colId = this.GetColumnId(column);
		var colHead = table.rows[0].cells[colId];

		colHead.removeAttribute('data-empty');
		if (colHead.getAttribute('data-resize'))
			jsDD.Disable();

		var results = [];
		var callback = function(json)
		{
			results.push(json);

			for (var i in json.edit)
			{
				if (typeof json.edit[i][column] != 'undefined')
				{
					if (typeof _this.oEditData[i] == 'undefined')
						_this.oEditData[i] = {};
					_this.oEditData[i][column] = json.edit[i][column];
				}
			}

			if (results.length < _this.vars.current_url.length)
				return;

			for (var i in results)
			{
				for (var j in results[i].data)
				{
					var cell = BX('datarow_'+_this.table_id+'_'+j).cells[colId];
					BX.findChildByClassName(cell, 'main-grid-cell-content').innerHTML = results[i].data[j][column];
				}
			}

			if (colHead.getAttribute('data-resize'))
			{
				colHead.removeAttribute('data-resize');

				var twidth    = table.offsetWidth;
				var widthFrom = colHead.offsetWidth;

				_this.animation.stop(colHead);

				if (colHead.offsetWidth > 0)
				{
					_this.reinitColumnSize(column);

					var widthTo = colHead.offsetWidth;
					colHead.style.width = widthFrom+'px';

					_this.toogleColumnCells(colId, true, true);

					var cellProps = {'width': {'from': widthFrom, 'to': widthTo, 'unit': 'px'}};
					_this.animation(colHead, cellProps, 100, function()
					{
						_this.toogleColumnCells(colId, true, false);

						_this.reinitResizeMeta();
						_this.toogleFader();
					});
				}

				jsDD.Enable();
			}

			_this.toggleCheckboxes();
		};

		for (var i in this.vars.current_url)
		{
			BX.ajax({
				url: this.vars.current_url[i],
				method: 'GET',
				dataType: 'json',
				headers: [
					{
						name: 'X-Ajax-Grid-UID',
						value: this.vars.ajax.GRID_AJAX_UID
					},
					{
						name: 'X-Ajax-Grid-Req',
						value: JSON.stringify({
							action: 'showcolumn',
							column: column
						})
					}
				],
				onsuccess: callback,
				onfailure: function() {
					colHead.setAttribute('data-empty', 1);
					jsDD.Enable();
				}
			});
		}
	};


	this.getData = function(url, callback)
	{
		BX.ajax({
			url: url + (url.indexOf('?') !== -1 ? '&' : '?') + 'bxajaxid=' + this.vars.ajax.AJAX_ID,
			method: 'GET',
			dataType: 'html',
			headers: [
				{
					name: 'X-Ajax-Grid-UID',
					value: this.vars.ajax.GRID_AJAX_UID
				},
				{
					name: 'X-Ajax-Grid-Req',
					value: JSON.stringify({
						action: 'showpage',
						columns: this.oVisibleCols
					})
				}
			],
			processData: true,
			scriptsRunFirst: true,
			onsuccess: function(data)
			{
				callback(data);
			}
		});
	};

}
/* jshint ignore:end */


(function() {
	"use strict";

	BX.namespace('BX.Main');

	var GridSettings,
		GridRows,
		GridRow,
		GridElement,
		GridObserver,
		GridPagination,
		GridRowsSortable,
		GridColsSortable,
		GridUpdater,
		GridUtils,
		GridUserOptions,
		GridBaseClass,
		GridData,
		GridFader,
		GridPageSize,
		GridActionPanel,
		GridInlineEditor,
		GridPinHeader,
		GridPinPanel;

	/**
	 * @returns {GridSettings}
	 * @constructor
	 */
	GridSettings = function()
	{
		var GridSettings;
		this.settings = {};
		this.defaultSettings = {
			classContainer: 'main-grid',
			classWrapper: 'main-grid-wrapper',
			classTable: 'main-grid-table',
			classScrollContainer: 'main-grid-container',
			classFadeContainer: 'main-grid-fade',
			classFadeContainerRight: 'main-grid-fade-right',
			classFadeContainerLeft: 'main-grid-fade-left',
			classNavPanel: 'main-grid-nav-panel',
			classActionPanel: 'main-grid-action-panel',
			classCursor: 'main-grid-cursor',
			classMoreButton: 'main-grid-more-btn',
			classRow: 'main-grid-row',
			classHeadRow: 'main-grid-row-head',
			classBodyRow: 'main-grid-row-body',
			classFootRow: 'main-grid-row-foot',
			classDataRows: 'main-grid-row-data',
			classCellHeadContainer: 'main-grid-cell-head-container',
			classCellHeadOndrag: 'main-grid-cell-head-ondrag',
			classEmptyRows: 'main-grid-row-empty',
			classCheckAllCheckboxes: 'main-grid-check-all',
			classCheckedRow: 'main-grid-row-checked',
			classRowCheckbox: 'main-grid-row-checkbox',
			classPagination: 'main-grid-panel-cell-pagination',
			classActionCol: 'main-grid-cell-action',
			classCounterDisplayed: 'main-grid-counter-displayed',
			classCounterSelected: 'main-grid-counter-selected',
			classCounterTotal: 'main-grid-panel-total',
			classTableFade: 'main-grid-table-fade',
			classDragActive: 'main-grid-on-row-drag',
			classResizeButton: 'main-grid-resize-button',
			classOnDrag: 'main-grid-ondrag',
			classHeaderSortable: 'main-grid-col-sortable',
			classCellStatic: 'main-grid-cell-static',
			classHeadCell: 'main-grid-cell-head',
			classPageSize: 'main-grid-panel-select-pagesize',
			classGroupEditButton: 'main-grid-control-panel-action-edit',
			classGroupDeleteButton: 'main-grid-control-panel-action-remove',
			classGroupActionsDisabled: 'main-grid-control-panel-action-icon-disable',
			classPanelButton: 'main-grid-buttons',
			classPanelApplyButton: 'main-grid-control-panel-apply-button',
			classPanelCheckbox: 'main-grid-panel-checkbox',
			classEditor: 'main-grid-editor',
			classEditorContainer: 'main-grid-editor-container',
			classEditorText: 'main-grid-editor-text',
			classEditorDate: 'main-grid-editor-date',
			classEditorNumber: 'main-grid-editor-number',
			classEditorRange: 'main-grid-editor-range',
			classEditorCheckbox: 'main-grid-editor-checkbox',
			classEditorTextarea: 'main-grid-editor-textarea',
			classCellContainer: 'main-grid-cell-content',
			classEditorOutput: 'main-grid-editor-output',
			classLoad: 'load',
			classRowActionButton: 'main-grid-row-action-button',
			classDropdown: 'main-dropdown',
			classPanelControl: 'main-grid-panel-control',
			classPanelControlContainer: 'main-grid-panel-control-container',
			classDisable: 'main-grid-disable',
			dataActionsKey: 'actions',
			updateActionMore: 'more',
			classShow: 'show',
			updateActionPagination: 'pagination',
			updateActionSort: 'sort',
			ajaxIdDataProp: 'ajaxid',
			pageSizeId: 'grid_page_size',
			sortableRows: true,
			sortableColumns: true,
			animationDuration: 300
		};
		this.prepare();
	};


	GridSettings.prototype = {
		prepare: function()
		{
			this.settings = this.defaultSettings;
		},

		getDefault: function()
		{
			return this.defaultSettings;
		},

		get: function(name)
		{
			var result;

			try {
				result = (this.getDefault())[name];
			} catch (err) {
				result = null;
			}

			return result;
		},

		getList: function()
		{
			return this.getDefault();
		}
	};

	/**
	 * @constructor
	 */
	GridObserver = {
		handlers: [],
		add: function(node, event, handler, context)
		{
			if (!this.get({node: node, event: event, handler: handler}).length)
			{
				this.handlers.push({
					node: node,
					event: event,
					handler: handler,
					context: context
				});

				BX.bind(
					node,
					event,
					context ? BX.delegate(handler, context) : handler
				);
			}
		},

		get: function(filter)
		{
			var result = this.handlers;
			var keys;

			if (BX.type.isPlainObject(filter) && (BX.type.isArray(this.handlers) && this.handlers.length))
			{
				keys = Object.keys(filter);

				result = this.handlers.filter(function(current) {
					return keys.filter(function(filterKey) {
							return current[filterKey] === filter[filterKey];
						}).length === keys.length;
				});
			}

			return result;
		}
	};



	GridInlineEditor = function(parent, types)
	{
		this.parent = null;
		this.types = null;
		this.init(parent, types);
	};

	GridInlineEditor.prototype = {
		init: function(parent, types)
		{
			this.parent = parent;

			try {
				this.types = JSON.parse(types);
			} catch (err) {
				this.types = null;
			}
		},

		createContainer: function()
		{
			return BX.create('div', {
				props: {
					className: this.parent.settings.get('classEditorContainer')
				}
			});
		},

		createTextarea: function(editObject, height)
		{
			var textarea = BX.create('textarea', {
				props: {
					className: [
						this.parent.settings.get('classEditor'),
						this.parent.settings.get('classEditorTextarea')
					].join(' ')
				},
				attrs: {
					name: editObject.NAME,
					style: 'height:' + height + 'px'
				},
				html: editObject.VALUE
			});

			return textarea;
		},

		createInput: function(editObject)
		{
			var className = this.parent.settings.get('classEditorText');
			var attrs =
			{
				value: (editObject.VALUE !== undefined && editObject.VALUE !== null) ? editObject.VALUE : '',
				name: (editObject.NAME !== undefined && editObject.NAME !== null) ? editObject.NAME : ''
			};

			if (editObject.TYPE === this.types.CHECKBOX)
			{
				className = [className, this.parent.settings.get('classEditorCheckbox')].join(' ');
				attrs.type = 'checkbox';
			}

			if (editObject.TYPE === this.types.DATE)
			{
				className = [className, this.parent.settings.get('classEditorDate')].join(' ');
			}

			if (editObject.TYPE === this.types.NUMBER)
			{
				className = [className, this.parent.settings.get('classEditorNumber')].join(' ');
				attrs.type = 'number';
			}

			if (editObject.TYPE === this.types.RANGE)
			{
				className = [className, this.parent.settings.get('classEditorRange')].join(' ');
				attrs.type = 'range';

				if (BX.type.isPlainObject(editObject.DATA))
				{
					attrs.min = editObject.DATA.MIN || '0';
					attrs.max = editObject.DATA.MAX || 99999;
					attrs.step = editObject.DATA.STEP || '';
				}
			}

			className = [this.parent.settings.get('classEditor'), className].join(' ');

			return BX.create('input', {
				props: {
					className: className,
					id: editObject.NAME + '_control'
				},
				attrs: attrs
			});
		},

		createOutput: function(editObject)
		{
			return BX.create('output', {
				props: {
					className: this.parent.settings.get('classEditorOutput') || ''
				},
				attrs: {
					for: editObject.NAME + '_control'
				},
				text: editObject.VALUE || ''
			});
		},

		getDropdownValueItemByValue: function(items, value)
		{
			var result = items.filter(function(current) {
				return current.VALUE === value;
			});

			return result.length > 0 ? result[0] : null;
		},

		createDropdown: function(editObject)
		{
			var valueItem = this.getDropdownValueItemByValue(
				editObject.DATA.ITEMS,
				editObject.VALUE
			);

			return BX.create('div', {
				props: {
					className: [
						this.parent.settings.get('classEditor'),
						'main-dropdown main-grid-editor-dropdown'
					].join(' '),
					id: editObject.NAME + '_control'
				},
				attrs: {
					name: editObject.NAME,
					'data-items': JSON.stringify(editObject.DATA.ITEMS),
					'data-value': valueItem.VALUE
				},
				html: valueItem.NAME
			});

		},

		validateEditObject: function(editObject)
		{
			return (
				BX.type.isPlainObject(editObject) &&
				('TYPE' in editObject) &&
				('NAME' in editObject) &&
				('VALUE' in editObject)
			);
		},

		initCalendar: function(event)
		{
			BX.calendar({node: event.target, field: event.target});
		},

		bindOnRangeChange: function(control, output)
		{
			function bubble(control, output)
			{
				BX.html(output, control.value);

				var value = parseFloat(control.value);
				var max = parseFloat(control.getAttribute('max'));
				var min = parseFloat(control.getAttribute('min'));
				var thumbWidth = 16;
				var range = (max - min);
				var position = (((value - min) / range) * 100);
				var positionOffset = (Math.round(thumbWidth * position / 100) - (thumbWidth / 2));

				output.style.left = position + '%';
				output.style.marginLeft = -positionOffset + 'px';
			}

			setTimeout(function() {
				bubble(control, output);
			}, 0);

			BX.bind(control, 'input', function() {
				bubble(control, output);
			});
		},

		getEditor: function(editObject, height)
		{
			var control, span;
			var container = this.createContainer();

			if (this.validateEditObject(editObject))
			{
				switch (editObject.TYPE) {
					case this.types.TEXT : {
						control = this.createInput(editObject);
						break;
					}

					case this.types.DATE : {
						control = this.createInput(editObject);
						BX.bind(control, 'click', this.initCalendar);
						break;
					}

					case this.types.NUMBER : {
						control = this.createInput(editObject);
						break;
					}

					case this.types.RANGE : {
						control = this.createInput(editObject);
						span = this.createOutput(editObject);
						this.bindOnRangeChange(control, span);
						break;
					}

					case this.types.CHECKBOX : {
						control = this.createInput(editObject);
						break;
					}

					case this.types.TEXTAREA : {
						control = this.createTextarea(editObject, height);
						break;
					}

					case this.types.DROPDOWN : {
						control = this.createDropdown(editObject);
						break;
					}

					default : {
						break;
					}
				}
			}

			if (BX.type.isDomNode(span))
			{
				container.appendChild(span);
			}

			if (BX.type.isDomNode(control))
			{
				container.appendChild(control);
			}

			return container;
		}
	};


	/**
	 * @param node
	 * @returns {GridRow}
	 * @constructor
	 */
	GridRow = function(parent, node)
	{
		this.node = null;
		this.checkbox = null;
		this.sort = null;
		this.actions = null;
		this.settings = null;
		this.index = null;
		this.actionsButton = null;
		this.parent = null;
		this.init(parent, node);
	};

	GridRow.prototype = {
		init: function(parent, node)
		{
			if (BX.type.isDomNode(node))
			{
				this.node = node;
				this.parent = parent;
				this.settings = new GridSettings();
				this.actions = this.getActions();
				this.checkbox = this.getCheckbox();
				this.index = this.getIndex();
			}
		},

		editGetValues: function()
		{
			var self = this;
			var cells = this.getCells();
			var values = {};
			var value;

			[].forEach.call(cells, function(current) {
				value = self.getCellEditorValue(current);

				if (value)
				{
					values[value.NAME] = value.VALUE !== undefined ? value.VALUE : "";
				}
			});

			return values;
		},

		getCellEditorValue: function(cell)
		{
			var editor = BX.findChild(cell, {class: this.parent.settings.get('classEditor')}, true, false);
			var result = null;

			if (BX.type.isDomNode(editor))
			{
				if (editor.value)
				{
					result = {
						'NAME': editor.getAttribute('name'),
						'VALUE': editor.value
					};
				}
				else
				{
					result = {
						'NAME': editor.getAttribute('name'),
						'VALUE': BX.data(editor, 'data-value')
					};
				}
			}

			return result;
		},

		isEdit: function()
		{
			return BX.hasClass(this.getNode(), 'main-grid-row-edit');
		},

		getContentContainer: function(cell)
		{
			return BX.findChild(cell, {className: this.parent.settings.get('classCellContainer')});
		},

		getContent: function(cell)
		{
			var container = this.getContentContainer(cell);
			var content;

			if (BX.type.isDomNode(container))
			{
				content = BX.html(container);
			}

			return content;
		},

		getEditorContainer: function(cell)
		{
			return BX.findChild(cell, {className: this.parent.settings.get('classEditorContainer')});
		},

		editCancel: function()
		{
			var cells = this.getCells();
			var self = this;
			var editorContainer;

			[].forEach.call(cells, function(current) {
				editorContainer = self.getEditorContainer(current);

				if (BX.type.isDomNode(editorContainer))
				{
					BX.remove(self.getEditorContainer(current));
					BX.show(self.getContentContainer(current));
				}
			});

			BX.removeClass(this.getNode(), 'main-grid-row-edit');
		},

		edit: function()
		{
			var cells = this.getCells();
			var self = this;
			var editObject, editor, height, contentContainer;

			[].forEach.call(cells, function(current) {
				try {
					editObject = JSON.parse(BX.data(current, 'edit'));
				} catch (err) {
					editObject = null;
				}

				if (self.parent.getEditor().validateEditObject(editObject))
				{
					contentContainer = self.getContentContainer(current);
					height = BX.height(contentContainer);
					editor = self.parent.getEditor().getEditor(editObject, height);

					if (!self.getEditorContainer(current) && BX.type.isDomNode(editor))
					{
						current.appendChild(editor);
						BX.hide(contentContainer);
					}
				}
			});

			BX.addClass(this.getNode(), 'main-grid-row-edit');
		},

		setDraggable: function(value)
		{
			this.getNode().draggable = value ? 'true' : 'false';
		},

		getNode: function()
		{
			return this.node;
		},

		getIndex: function()
		{
			return this.getNode().rowIndex;
		},

		getId: function()
		{
			return parseFloat(BX.data(this.getNode(), 'id'));
		},

		getObserver: function()
		{
			return GridObserver;
		},

		getCheckbox: function()
		{
			return this.checkbox || BX.findChild(
					this.getNode(),
					{class: this.settings.get('classRowCheckbox')},
					true,
					false
				);
		},

		getActionsMenu: function()
		{
			var buttonRect = this.getActionsButton().getBoundingClientRect();

			this.actionsMenu = this.actionsMenu || BX.PopupMenu.create(
					'main-grid-actions-menu-' + this.getIndex(),
					this.getActionsButton(),
					this.getMenuItems(),
					{
						'autoHide': true,
						'offsetTop': -((buttonRect.height / 2) + 26),
						'offsetLeft': 30,
						'angle': {
							'position': 'left',
							'offset': ((buttonRect.height / 2) - 8)
						},
						'events': {
							'onPopupClose': BX.delegate(this._onCloseMenu, this)
						}
					}
				);

			return this.actionsMenu;
		},

		_onCloseMenu: function()
		{

		},

		actionsMenuIsShown: function()
		{
			return this.getActionsMenu().popupWindow.isShown();
		},

		showActionsMenu: function()
		{
			BX.PopupMenu.destroy('main-grid-actions-menu-' + this.getIndex());
			this.actionsMenu = null;

			this.getActionsMenu().popupWindow.adjustPosition(BX.pos(this.getActionsButton()));
			this.getActionsMenu().popupWindow.show();
		},

		closeActionsMenu: function()
		{
			this.getActionsMenu().popupWindow.close();
		},

		prepareMenuItems: function(items, parentKey)
		{
			var self = this;
			var isNeedIcons;
			this.parentKey = this.parentKey || 0;

			isNeedIcons = items.some(function(current) {
				return BX.type.isNotEmptyString(current.className) && current.className !== 'menu';
			});


			return items.map(function(item, key) {
				if (BX.type.isArray(item.menu))
				{
					item.menu = self.prepareMenuItems(item.menu, key);
					item.menu = JSON.stringify(item.menu);
					item.onclick = 'BX.Main.submenu.init(this, \'main_grid_submenu_'+self.parentKey+'_'+key+'\', '+self.parentKey+', '+item.menu+')';
					item.className = [(item.className || ''), 'menu'].join(' ');
					self.parentKey += 1;
				}

				if (isNeedIcons)
				{
					item.className = item.className ? [item.className, 'icon'].join(' ') : 'none';
				}
				else
				{
					item.className = [(item.className || ''), 'menu-popup-no-icon'].join(' ');
				}

				return item;
			});
		},

		getMenuItems: function()
		{
			var actions = this.getActions() || [];
			return this.prepareMenuItems(actions);
		},

		getActions: function()
		{
			try {
				this.actions = this.actions || JSON.parse(
						BX.data(this.getActionsButton(), this.settings.get('dataActionsKey'))
					);
			} catch (err) {
				this.actions = null;
			}

			return this.actions;
		},

		getActionsButton: function()
		{
			this.actionsButton = this.actionsButton || BX.findChild(this.getNode(), {
					class: this.settings.get('classRowActionButton')
				}, true, false);

			return this.actionsButton;
		},

		getParentNode: function()
		{
			var result;

			try {
				result = (this.getNode()).parentNode;
			} catch (err) {
				result = null;
			}

			return result;
		},

		getParentNodeName: function()
		{
			var result;

			try {
				result = (this.getParentNode()).nodeName;
			} catch (err) {
				result = null;
			}

			return result;
		},

		select: function()
		{
			if (!this.isEdit())
			{
				BX.addClass(this.getNode(), this.settings.get('classCheckedRow'));
				if (this.getCheckbox())
				{
					this.getCheckbox().checked = true;
				}
			}
		},

		unselect: function()
		{
			if (!this.isEdit())
			{
				BX.removeClass(this.getNode(), this.settings.get('classCheckedRow'));
				if (this.getCheckbox())
				{
					this.getCheckbox().checked = false;
				}
			}
		},

		getCells: function()
		{
			return this.getNode().cells;
		},

		isSelected: function()
		{
			return (
				(this.getCheckbox() && (this.getCheckbox()).checked) ||
				(BX.hasClass(this.getNode(), this.settings.get('classCheckedRow')))
			);
		},

		isHeadChild: function()
		{
			return (
				this.getParentNodeName() === 'THEAD' &&
				BX.hasClass(this.getNode(), this.settings.get('classHeadRow'))
			);
		},

		isBodyChild: function()
		{
			return (
				this.getParentNodeName() === 'TBODY' &&
				BX.hasClass(this.getNode(), this.settings.get('classBodyRow'))
			);
		},

		isFootChild: function()
		{
			return (
				this.getParentNodeName() === 'TFOOT' &&
				BX.hasClass(this.getNode(), this.settings.get('classFootRow'))
			);
		}
	};


	/**
	 * @param parent
	 * @returns {GridRows}
	 * @constructor
	 */
	GridRows = function(parent)
	{
		var GridRows;
		this.parent = null;
		this.rows = null;
		this.headChild = null;
		this.bodyChild = null;
		this.footChild = null;
		this.init(parent);
	};

	GridRows.prototype = {
		init: function(parent)
		{
			this.parent = parent;
		},

		getFootLastChild: function()
		{
			return this.getLast(this.getFootChild());
		},

		getFootFirstChild: function()
		{
			return this.getFirst(this.getFootChild());
		},

		getBodyLastChild: function()
		{
			return this.getLast(this.getBodyChild());
		},

		getBodyFirstChild: function()
		{
			return this.getFirst(this.getBodyChild());
		},

		getHeadLastChild: function()
		{
			return this.getLast(this.getHeadChild());
		},

		getHeadFirstChild: function()
		{
			return this.getFirst(this.getHeadChild());
		},

		getEditSelectedValues: function()
		{
			var selectedRows = this.getSelected();
			var values = {};

			selectedRows.forEach(
				function(current)
				{
					values[current.getId()] = current.editGetValues();
				}
			);

			return values;
		},

		getSelectedIds: function()
		{
			return this.getSelected().map(function(current) {
				return current.getId();
			});
		},

		editSelected: function()
		{
			this.getSelected().forEach(function(current) {
				current.edit();
			});

			BX.onCustomEvent(window, 'Grid::thereEditedRows', []);
		},

		editSelectedCancel: function()
		{
			this.getSelected().forEach(function(current) {
				current.editCancel();
			});

			BX.onCustomEvent(window, 'Grid::noEditedRows', []);
		},

		isSelected: function()
		{
			return this.getBodyChild().some(function(current) {
				return current.isSelected();
			});
		},

		isAllSelected: function()
		{
			return !this.getBodyChild().some(function(current) {
				return !current.isSelected();
			});
		},

		getParent: function()
		{
			return this.parent;
		},

		getCountSelected: function()
		{
			var result;

			try {
				result = this.getSelected().length;
			} catch(err) {
				result = 0;
			}

			return result;
		},

		getCountDisplayed: function()
		{
			var result;

			try {
				result = this.getBodyChild().length;
			} catch(err) {
				result = 0;
			}

			return result;
		},

		addRows: function(rows)
		{
			var body = BX.findChild(
				this.getParent().getTable(),
				{tag: 'TBODY'},
				true,
				false
			);

			rows.forEach(function(current) {
				body.appendChild(current);
			});
		},

		getRows: function()
		{
			var result;
			var self = this;

			if (!this.rows)
			{
				result = BX.findChild(this.getParent().getTable(), {tag: 'tr'}, true, true);
				this.rows = [].map.call(result, function(current) {
					return new GridRow(self.parent, current);
				});
			}

			return this.rows;
		},

		getSelected: function()
		{
			return this.getBodyChild().filter(function(current) {
				return current.isSelected();
			});
		},

		normalizeNode: function(node)
		{
			return BX.findParent(node, {class: this.getParent().settings.get('classBodyRow')}, true, false);
		},

		getById: function(id)
		{
			var rows = this.getBodyChild();

			var row = rows.filter(function(current) {
				return current.getId() === parseFloat(id);
			});

			return row.length === 1 ? row[0] : null;
		},

		get: function(node)
		{
			var result = null;
			var filter;

			if (BX.type.isDomNode(node))
			{
				node = this.normalizeNode(node);

				filter = this.getRows().filter(function(current) {
					return node === current.getNode();
				});

				if (filter.length)
				{
					result = filter[0];
				}
			}

			return result;
		},

		/** @static @method getLast */
		getLast: function(array)
		{
			var result;

			try {
				result = array[array.length-1];
			} catch (err) {
				result = null;
			}

			return result;
		},

		/** @static @method getFirst */
		getFirst: function(array)
		{
			var result;

			try {
				result = array[0];
			} catch (err) {
				result = null;
			}

			return result;
		},

		getHeadChild: function()
		{
			this.headChild = this.headChild || this.getRows().filter(function(current) {
					return current.isHeadChild();
				});

			return this.headChild;
		},

		getBodyChild: function()
		{
			this.bodyChild = this.bodyChild || this.getRows().filter(function(current) {
					return current.isBodyChild();
				});

			return this.bodyChild;
		},

		getFootChild: function()
		{
			this.footChild = this.footChild || this.getRows().filter(function(current) {
					return current.isFootChild();
				});

			return this.footChild;
		},

		selectAll: function()
		{
			this.getRows().map(function(current) {
				current.select();
			});
		},

		unselectAll: function()
		{
			this.getRows().map(function(current) {
				current.unselect();
			});
		},

		getByIndex: function(rowIndex)
		{
			var filter = this.getBodyChild().filter(function(item) {
				return item.getNode().rowIndex === rowIndex;
			});

			return filter.length ? filter[0] : null;
		},

		getSourceRows: function()
		{
			return BX.findChild(this.getParent().getTable(), {tag: 'tr'}, true, true);
		},

		getSourceBodyChild: function()
		{
			return this.getSourceRows().filter(function(current) {
				return GridUtils.closestParent(current).nodeName === 'TBODY';
			});
		},

		getSourceHeadChild: function()
		{
			return this.getSourceRows().filter(function(current) {
				return GridUtils.closestParent(current).nodeName === 'THEAD';
			});
		},

		getSourceFootChild: function()
		{
			return this.getSourceRows().filter(function(current) {
				return GridUtils.closestParent(current).nodeName === 'TFOOT';
			});
		}
	};


	/**
	 * @param node
	 * @param parent
	 * @returns {GridElement}
	 * @constructor
	 */
	GridElement = function(node, parent)
	{
		this.node = null;
		this.href = null;
		this.parent = null;
		this.init(node, parent);
	};

	GridElement.prototype = {
		init: function(node, parent)
		{
			this.node = node;
			this.parent = parent;
			this.resetOnclickAttr();
		},

		getParent: function()
		{
			return this.parent;
		},

		load: function()
		{
			BX.addClass(this.getNode(), this.getParent().settings.get('classLoad'));
		},

		unload: function()
		{
			BX.removeClass(this.getNode(), this.getParent().settings.get('classLoad'));
		},

		isLoad: function()
		{
			return BX.hasClass(this.getNode(), this.getParent().settings.get('classLoad'));
		},

		resetOnclickAttr: function()
		{
			if (BX.type.isDomNode(this.getNode()))
			{
				this.getNode().onclick = null;
			}
		},

		getObserver: function()
		{
			return GridObserver;
		},

		getNode: function()
		{
			return this.node;
		},

		getLink: function()
		{
			var result;

			try {
				result = this.getNode().href;
			} catch (err) {
				result = null;
			}

			return result;
		}
	};


	/**
	 * @param parent
	 * @returns {GridPagination}
	 * @constructor
	 */
	GridPagination = function(parent)
	{
		this.parent = null;
		this.container = null;
		this.links = null;
		this.init(parent);
	};

	GridPagination.prototype = {
		init: function(parent)
		{
			this.parent = parent;
		},

		getParent: function()
		{
			return this.parent;
		},

		getContainer: function()
		{
			this.container = this.container || BX.findChild(
					this.getParent().getContainer(),
					{class: this.getParent().settings.get('classPagination')},
					true,
					false
				);

			return this.container;
		},

		getLinks: function()
		{
			var self = this;
			var result = BX.findChild(
				this.getContainer(),
				{tag: 'a'},
				true,
				true
			);
			this.links = [];

			if (result)
			{
				this.links = result.map(function(current) {
					return new GridElement(current, self.getParent());
				});
			}

			return this.links;
		},

		getLink: function(node)
		{
			var result = null;
			var filter;

			if (BX.type.isDomNode(node))
			{
				filter = this.getLinks().filter(function(current) {
					return node === current.getNode();
				});

				if (filter.length)
				{
					result = filter[0];
				}
			}

			return result;
		}
	};


	/**
	 * Works with userOptions
	 * @param {BX.Main.grid} parent
	 * @param userOptions
	 * @param userOptionsActions
	 * @param url
	 * @constructor
	 */
	GridUserOptions = function(parent, userOptions, userOptionsActions, url)
	{
		this.options = null;
		this.actions = null;
		this.parent = null;
		this.url = null;
		this.init(parent, userOptions, userOptionsActions, url);
	};

	GridUserOptions.prototype = {
		init: function(parent, userOptions, userOptionsActions, url)
		{
			this.url = url;
			this.parent = parent;

			try {
				this.options = JSON.parse(userOptions);
			} catch(err) {
				console.warn('GridUserOptions.init: Failed parse user options json string');
			}

			try {
				this.actions = JSON.parse(userOptionsActions);
			} catch(err) {
				console.warn('GridUserOptions.init: Failed parse user options actions json string');
			}
		},

		getCurrentViewName: function()
		{
			var options = this.getOptions();

			return 'current_view' in options ? options.current_view : null;
		},

		getViewsList: function()
		{
			var options = this.getOptions();

			return 'views' in options ? options.views : {};
		},

		getCurrentOptions: function()
		{
			var name = this.getCurrentViewName();
			var views = this.getViewsList();
			var result = null;

			if (name in views)
			{
				result = views[name];
			}

			return result;
		},

		getUrl: function(action)
		{
			return BX.util.add_url_param(this.url, {
				GRID_ID: this.parent.getContainerId(),
				bxajaxid: this.parent.getAjaxId(),
				action: action
			});
		},

		getOptions: function()
		{
			return this.options || {};
		},

		getActions: function()
		{
			return this.actions;
		},

		getAction: function(name)
		{
			var action = null;

			try {
				action = this.getActions()[name];
			} catch (err) {
				action = null;
			}

			return action;
		},

		update: function(newOptions)
		{
			this.options = newOptions;
		},

		setColumns: function(columns, callback)
		{
			var options = this.getCurrentOptions();

			if (BX.type.isPlainObject(options))
			{
				options.columns = columns.join(',');

				this.save(this.getAction('GRID_SET_COLUMNS'), {columns: options.columns}, callback);
			}

			return this;
		},

		setColumnSizes: function(sizes, expand)
		{
			this.save(this.getAction('GRID_SET_COLUMN_SIZES'), {sizes: sizes, expand: expand});
		},

		setSort: function(by, order, callback)
		{
			if (by && order)
			{
				this.save(this.getAction('GRID_SET_SORT'), {by: by, order: order}, callback);
			}

			return this;
		},

		setPageSize: function(pageSize, callback)
		{
			if (BX.type.isNumber(parseInt(pageSize)))
			{
				this.save(this.getAction('GRID_SET_PAGE_SIZE'), {pageSize: pageSize}, callback);
			}
		},

		save: function(action, data, callback)
		{
			var self = this;
			BX.ajax.post(
				this.getUrl(action),
				data,
				function(res)
				{
					try {
						res = JSON.parse(res);
						if (!res.error)
						{
							self.update(res);
							if (BX.type.isFunction(callback))
							{
								callback(res);
							}

							BX.onCustomEvent(self.parent.getContainer(), 'Grid::optionsChanged', [self.parent]);
						}
					} catch (err) {}
				}
			);
		}
	};



	GridFader = function(parent)
	{
		this.parent = null;
		this.table = null;
		this.container = null;
		this.init(parent);
	};

	GridFader.prototype = {
		init: function(parent)
		{
			this.parent = parent;
			this.table = this.parent.getTable();
			this.container = this.parent.getFadeContainer();
			this.toggle();
		},

		toggle: function()
		{
			if (this.table.offsetWidth > this.container.clientWidth)
			{
				if (this.container.scrollLeft > 0)
				{
					BX.addClass(
						this.container.parentNode,
						this.parent.settings.get('classFadeContainerLeft')
					);
				}
				else
				{
					BX.removeClass(
						this.container.parentNode,
						this.parent.settings.get('classFadeContainerLeft')
					);
				}

				if (this.table.offsetWidth > (this.container.scrollLeft + this.container.clientWidth))
				{
					BX.addClass(
						this.container.parentNode,
						this.parent.settings.get('classFadeContainerRight')
					);
				}
				else
				{
					BX.removeClass(
						this.container.parentNode,
						this.parent.settings.get('classFadeContainerRight')
					);
				}
			}
			else
			{
				BX.removeClass(
					this.container.parentNode,
					this.parent.settings.get('classFadeContainerLeft')
				);
				BX.removeClass(
					this.container.parentNode,
					this.parent.settings.get('classFadeContainerRight')
				);
			}
		}
	};



	/**
	 * Sorts grid columns
	 * @param {BX.Main.grid} parent
	 * @constructor
	 */
	GridColsSortable = function(parent)
	{
		this.parent = null;
		this.dragItem = null;
		this.targetItem = null;
		this.rowsList = null;
		this.colsList = null;
		this.dragRect = null;
		this.offset = null;
		this.startDragOffset = null;
		this.dragColumn = null;
		this.targetColumn = null;
		this.isDrag = null;
		this.init(parent);
	};

	GridColsSortable.prototype = {
		init: function(parent)
		{
			var fixedTable, rows;
			var self = this;

			this.parent = parent;
			this.colsList = this.getColsList();
			this.rowsList = this.parent.getRows().getSourceRows();

			if (this.isPinned && this.parent.getParam('ALLOW_PIN_HEADER'))
			{
				fixedTable = this.parent.getPinHeader().getFixedTable();
				rows = BX.findChild(fixedTable, {tag: 'tr'}, true, true);

				(rows || []).forEach(function(current) {
					self.rowsList.push(current);
				});
			}

			this.registerObjects();

			if (!this.inited)
			{
				this.inited = true;
				BX.addCustomEvent('Grid::headerPinned', BX.delegate(this._onPin, this));
				BX.addCustomEvent('Grid::headerUnpinned', BX.delegate(this._onUnpin, this));
			}
		},

		_onPin: function()
		{
			this.isPinned = true;
			this.reinit();
		},

		_onUnpin: function()
		{
			this.isPinned = false;
			this.reinit();
		},

		reinit: function()
		{
			this.unregisterObjects();
			this.reset();
			this.init(this.parent);
		},

		reset: function()
		{
			this.dragItem = null;
			this.targetItem = null;
			this.rowsList = null;
			this.colsList = null;
			this.dragRect = null;
			this.offset = null;
			this.startDragOffset = null;
			this.dragColumn = null;
			this.targetColumn = null;
			this.isDrag = null;
		},

		isActive: function()
		{
			return this.isDrag;
		},

		registerObjects: function(objects)
		{
			var self = this;

			[].forEach.call((objects || this.colsList), function(current) {
				current.onbxdragstart = BX.delegate(self._onDragStart, self);
				current.onbxdrag = BX.delegate(self._onDrag, self);
				current.onbxdragstop = BX.delegate(self._onDragEnd, self);
				jsDD.registerObject(current);
				jsDD.registerDest(current);
			});
		},

		unregisterObjects: function()
		{
			[].forEach.call(this.colsList, function(current) {
				jsDD.unregisterObject(current);
				jsDD.unregisterDest(current);
			});
		},

		getColsList: function()
		{
			var self = this;
			var list = [];
			var table;

			if (this.isPinned && this.parent.getParam('ALLOW_PIN_HEADER'))
			{
				table = this.parent.getPinHeader().getFixedTable();
				list = BX.findChild(table, {tag: 'th'}, true, true);
			}
			else
			{
				list = this.parent.getRows().getHeadFirstChild().getCells();
			}

			list = [].filter.call(list, function(current) {
				return !self.isStatic(current);
			});

			return list;
		},

		isStatic: function(item)
		{
			return BX.hasClass(item, this.parent.settings.get('classCellStatic'));
		},

		getDragOffset: function()
		{
			return (jsDD.x - this.startDragOffset - this.dragRect.left);
		},

		getColumn: function(item)
		{
			var column = GridUtils.getColumn(this.parent.getTable(), item);

			if (column.indexOf(item) === -1)
			{
				column.push(item);
			}

			return column;
		},

		_onDragStart: function()
		{
			this.isDrag = true;

			this.dragItem = jsDD.current_node;
			this.dragRect = this.dragItem.getBoundingClientRect();
			this.offset = this.dragRect.width;
			this.startDragOffset = jsDD.start_x - this.dragRect.left;
			this.dragColumn = this.getColumn(this.dragItem);
			this.dragIndex = GridUtils.getIndex(this.colsList, this.dragItem);
		},

		_onDrag: function()
		{
			var currentRect, currentMiddle;
			var self = this;

			this.dragOffset = this.getDragOffset();
			this.targetItem = this.targetItem || this.dragItem;
			this.targetColumn = this.targetColumn || this.dragColumn;

			GridUtils.styleForEach(this.dragColumn, {
				transition: '0ms',
				transform: 'translate3d('+this.dragOffset+'px, 0px, 0px)'
			});

			[].forEach.call(this.colsList, function(current, index) {
				if (current)
				{
					currentRect = current.getBoundingClientRect();
					currentMiddle = currentRect.left + (currentRect.width / 2) + BX.scrollLeft(window);

					if ((index > self.dragIndex && jsDD.x > currentMiddle) &&
						(current.style.transform !== 'translate3d('+(-self.offset)+'px, 0px, 0px)'))
					{
						self.targetColumn = self.getColumn(current);
						GridUtils.styleForEach(self.targetColumn, {
							'transition': '300ms',
							'transform': 'translate3d('+(-self.offset)+'px, 0px, 0px)'
						});
					}

					if ((index < self.dragIndex && jsDD.x < currentMiddle) &&
						(current.style.transform !== 'translate3d('+(self.offset)+'px, 0px, 0px)'))
					{
						self.targetColumn = self.getColumn(current);
						GridUtils.styleForEach(self.targetColumn, {
							'transition': '300ms',
							'transform': 'translate3d('+(self.offset)+'px, 0px, 0px)'
						});
					}

					if ((index > self.dragIndex && jsDD.x < currentMiddle &&
						current.style.transform !== '' &&
						current.style.transform !== 'translate3d(0px, 0px, 0px)') ||
						current.style.transform !== '' &&
						(index < self.dragIndex && jsDD.x > currentMiddle &&
						current.style.transform !== 'translate3d(0px, 0px, 0px)'))
					{
						self.targetColumn = self.getColumn(current);
						GridUtils.styleForEach(self.targetColumn, {
							'transition': '300ms',
							'transform': 'translate3d(0px, 0px, 0px)'
						});
					}
				}
			});
		},

		_onDragEnd: function()
		{
			var self = this;
			var columns = [];

			[].forEach.call(this.dragColumn, function(current, index) {
				GridUtils.collectionSort(current, self.targetColumn[index]);
			});

			[].forEach.call(this.rowsList, function(current) {
				GridUtils.styleForEach(current.cells, {
					transition: '',
					transform: ''
				});
			});

			this.reinit();

			[].forEach.call(this.colsList, function(current) {
				columns.push(BX.data(current, 'name'));
			});

			this.parent.getUserOptions().setColumns(columns);
			BX.onCustomEvent(this.parent.getContainer(), 'Grid::columnMoved', [this.parent]);
		}
	};


	/**
	 * Sorts grid rows and columns
	 * @param {BX.Main.grid} parent
	 * @constructor
	 */
	GridRowsSortable = function(parent)
	{
		this.parent = null;
		this.list = null;
		this.setDefaultProps();
		this.init(parent);
	};

	GridRowsSortable.prototype = {
		init: function(parent)
		{
			this.parent = parent;
			this.list = this.getList();
			this.prepareListItems();
			jsDD.Enable();

			if (!this.inited)
			{
				this.inited = true;
				BX.addCustomEvent('Grid::thereEditedRows', BX.delegate(this.disable, this));
				BX.addCustomEvent('Grid::noEditedRows', BX.delegate(this.enable, this));
			}
		},

		disable: function()
		{
			this.unregisterObjects();
		},

		enable: function()
		{
			this.reinit();
		},

		reinit: function()
		{
			this.unregisterObjects();
			this.setDefaultProps();
			this.init(this.parent);
		},

		getList: function()
		{
			return this.parent.getRows().getSourceBodyChild();
		},

		unregisterObjects: function()
		{
			this.list = this.list.map(function(current) {
				jsDD.unregisterObject(current);
				jsDD.unregisterDest(current);
				return current;
			});
		},

		prepareListItems: function()
		{
			var self = this;
			console.time('prepare');
			this.list = this.list.map(function(current) {
				current.onbxdragstart = BX.delegate(self._onDragStart, self);
				current.onbxdrag = BX.delegate(self._onDrag, self);
				current.onbxdragstop = BX.delegate(self._onDragEnd, self);
				jsDD.registerObject(current);
				jsDD.registerDest(current);
				return current;
			});
			console.timeEnd('prepare');
		},

		getIndex: function(item)
		{
			return GridUtils.getIndex(this.list, item);
		},

		_onDragStart: function()
		{
			this.dragItem = jsDD.current_node;
			this.dragIndex = this.getIndex(this.dragItem);
			this.dragRect = this.dragItem.getBoundingClientRect();
			this.offset = this.dragRect.height;
			this.dragStartOffset = (jsDD.start_y - (this.dragRect.top + BX.scrollTop(window)));

			GridUtils.styleForEach(this.list, {'transition': +this.parent.settings.get('animationDuration') + 'ms'});
			BX.bind(document, 'mousemove', BX.delegate(this._onMouseMove, this));
			BX.addClass(this.parent.getContainer(), this.parent.settings.get('classOnDrag'));
			BX.addClass(this.dragItem, this.parent.settings.get('classDragActive'));
		},

		_onMouseMove: function(event)
		{
			this.realX = event.clientX;
			this.realY = event.clientY;
		},

		_onDrag: function()
		{
			var self = this;
			var currentRect, currentMiddle;

			this.dragOffset = (this.realY - this.dragRect.top - this.dragStartOffset);
			this.sortOffset = self.realY + BX.scrollTop(window);

			GridUtils.styleForEach([this.dragItem], {
				'transition': '0ms',
				'transform': 'translate3d(0px, '+this.dragOffset+'px, 0px)'
			});

			this.list.forEach(function(current, index) {
				if (current)
				{
					currentRect = current.getBoundingClientRect();
					currentMiddle = currentRect.top + BX.scrollTop(window) + (currentRect.height / 2);

					if (index > self.dragIndex && self.sortOffset > currentMiddle &&
						current.style.transform !== 'translate3d(0px, '+(-self.offset)+'px, 0px)' &&
						current.style.transform !== '')
					{
						self.targetItem = current;
						BX.style(current, 'transform', 'translate3d(0px, '+(-self.offset)+'px, 0px)');
					}

					if (index < self.dragIndex && self.sortOffset < currentMiddle &&
						current.style.transform !== 'translate3d(0px, '+(self.offset)+'px, 0px)' &&
						current.style.transform !== '')
					{
						self.targetItem = current;
						BX.style(current, 'transform', 'translate3d(0px, '+(self.offset)+'px, 0px)');
					}

					if (((index < self.dragIndex && self.sortOffset > currentMiddle) ||
						(index > self.dragIndex && self.sortOffset < currentMiddle)) &&
						current.style.transform !== 'translate3d(0px, 0px, 0px)')
					{
						if (current.style.transform !== '')
						{
							self.targetItem = current;
						}

						BX.style(current, 'transform', 'translate3d(0px, 0px, 0px)');
					}
				}
			});
		},

		_onDragOver: function() {},

		_onDragLeave: function() {},

		_onDragEnd: function()
		{
			BX.unbind(document, 'mousemove', BX.delegate(this._onMouseMove, this));
			BX.removeClass(this.parent.getContainer(), this.parent.settings.get('classOnDrag'));
			BX.removeClass(this.dragItem, this.parent.settings.get('classDragActive'));

			GridUtils.styleForEach(this.list, {'transition': '', 'transform': ''});
			GridUtils.collectionSort(this.dragItem, this.targetItem);

			this.list = this.getList();
			this.setDefaultProps();
			BX.onCustomEvent(this.parent.getContainer(), 'Grid::rowMoved', [this.parent]);
		},

		setDefaultProps: function()
		{
			this.dragItem = null;
			this.targetItem = null;
			this.dragRect = null;
			this.dragIndex = null;
			this.offset = null;
			this.sortOffset = null;
			this.realX = null;
			this.realY = null;
			this.dragStartOffset = null;
			this.sortOffset = null;
		}
	};


	/**
	 * Utils
	 * @type {{ajaxUrl: GridUtils.ajaxUrl, arrayMove: GridUtils.arrayMove, getIndex: GridUtils.getIndex, getNext:
	 *     GridUtils.getNext, getPrev: GridUtils.getPrev, closestParent: GridUtils.closestParent, closestChilds:
	 *     GridUtils.closestChilds, collectionSort: GridUtils.collectionSort, styleForEach: GridUtils.styleForEach}}
	 */
	GridUtils = {
		/**
		 * Prepares url for ajax request
		 * @param {string} url
		 * @param {string} ajaxId Bitrix ajax id
		 * @returns {string} Prepares ajax url with ajax id
		 */
		ajaxUrl: function(url, ajaxId)
		{
			return this.addUrlParams(url, {'bxajaxid': ajaxId});
		},

		addUrlParams: function(url, params)
		{
			return BX.util.add_url_param(url, params);
		},

		/**
		 * Moves array item currentIndex to newIndex
		 * @param {array} array
		 * @param {int} currentIndex
		 * @param {int} newIndex
		 * @returns {*}
		 */
		arrayMove: function(array, currentIndex, newIndex)
		{
			if (newIndex >= array.length)
			{
				var k = newIndex - array.length;
				while ((k--) + 1)
				{
					array.push(undefined);
				}
			}
			array.splice(newIndex, 0, array.splice(currentIndex, 1)[0]);

			return array;
		},

		/**
		 * Gets item index in array or HTMLCollection
		 * @param {array|HTMLCollection} collection
		 * @param {*} item
		 * @returns {number}
		 */
		getIndex: function(collection, item)
		{
			return [].indexOf.call((collection || []), item);
		},

		/**
		 * Gets nextElementSibling
		 * @param {Element} currentItem
		 * @returns {Element|null}
		 */
		getNext: function(currentItem)
		{
			if (currentItem) { return currentItem.nextElementSibling || null; }
		},

		/**
		 * Gets previousElementSibling
		 * @param {Element} currentItem
		 * @returns {Element|null}
		 */
		getPrev: function(currentItem)
		{
			if (currentItem) { return currentItem.previousElementSibling || null; }
		},

		/**
		 * Gets closest parent element of node
		 * @param {Node} item
		 * @param {string} className
		 * @returns {*|null|Node}
		 */
		closestParent: function(item, className)
		{
			if (item)
			{
				if (!className)
				{
					return item.parentNode || null;
				}
				else
				{
					return BX.findParent(
						item,
						{class: className}
					);
				}
			}
		},

		/**
		 * Gets closest childs of node
		 * @param item
		 * @returns {Array|null}
		 */
		closestChilds: function(item)
		{
			if (item) { return item.children || null; }
		},

		/**
		 * Sorts collection
		 * @param current
		 * @param target
		 */
		collectionSort: function(current, target)
		{
			var root, collection, collectionLength, currentIndex, targetIndex;

			if (current && target && current !== target && current.parentNode === target.parentNode)
			{
				root = this.closestParent(target);
				collection = this.closestChilds(root);
				collectionLength = collection.length;
				currentIndex = this.getIndex(collection, current);
				targetIndex = this.getIndex(collection, target);

				if (collectionLength === targetIndex) {
					root.appendChild(target);
				}

				if (currentIndex > targetIndex) {
					root.insertBefore(current, target);
				}

				if (currentIndex < targetIndex && collectionLength !== targetIndex)
				{
					root.insertBefore(current, this.getNext(target));
				}
			}

		},

		/**
		 * Gets table collumn
		 * @param table
		 * @param cell
		 * @returns {Array}
		 */
		getColumn: function(table, cell)
		{
			var currentIndex = this.getIndex(
				this.closestChilds(this.closestParent(cell)),
				cell
			);
			var column = [];

			[].forEach.call(table.rows, function(current) {
				column.push(current.cells[currentIndex]);
			});

			return column;
		},

		/**
		 * Sets style properties and values for each item in collection
		 * @param {array|HTMLCollection} collection
		 * @param {object} properties
		 */
		styleForEach: function(collection, properties)
		{
			properties = BX.type.isPlainObject(properties) ? properties : null;
			var keys = Object.keys(properties);

			[].forEach.call((collection || []), function(current) {
				keys.forEach(function(propKey) {
					BX.style(current, propKey, properties[propKey]);
				});
			});
		}
	};


	/**
	 * Base class
	 * @param {BX.Main.grid} parent
	 * @constructor
	 */
	GridBaseClass = function(parent)
	{
		this.parent = parent;
	};

	GridBaseClass.prototype = {
		getParent: function()
		{
			return this.parent;
		}
	};


	/**
	 * Works with requests and server response
	 * @param {BX.Main.grid} parent
	 * @constructor
	 */
	GridData = function(parent)
	{
		GridData.superclass.constructor.apply(this, [parent]);
		this.reset();
	};

	BX.extend(GridData, GridBaseClass);
	{
		GridData.prototype = Object.create(GridBaseClass.prototype, {});

		GridData.prototype.reset = function()
		{
			this.response = null;
			this.xhr = null;
			this.headRows = null;
			this.bodyRows = null;
			this.footRows = null;
			this.moreButton = null;
			this.pagination = null;
			this.counterDisplayed = null;
			this.counterSelected = null;
			this.counterTotal = null;
			this.limit = null;
			this.actionPanel = null;
		};

		GridData.prototype.request = function(url, method, data, action, then, error)
		{
			if(!BX.type.isString(url))
			{
				url = "";
			}
			if(!BX.type.isNotEmptyString(method))
			{
				method = "GET";
			}

			if(!BX.type.isPlainObject(data))
			{
				data = {};
			}

			var eventArgs =
			{
				gridId: this.parent.getId(),
				url: url,
				method: method,
				data: data
			};

			BX.onCustomEvent(
				window,
				"Grid::beforeRequest",
				[this, eventArgs]
			);

			url = eventArgs.url;
			if(!BX.type.isNotEmptyString(url))
			{
				url = window.location.pathname + window.location.search
			}
			url = GridUtils.addUrlParams(url, { sessid: BX.bitrix_sessid(), internal: 'true' });

			method = eventArgs.method;
			data = eventArgs.data;

			this.reset();

			var self = this;

			setTimeout(function() {
				var xhr = BX.ajax({
					url: GridUtils.ajaxUrl(url, self.getParent().getAjaxId()),
					data: data,
					method: method,
					dataType: 'html',
					headers: [
						{name: 'X-Ajax-Grid-UID', value: self.getParent().getAjaxId()},
						{name: 'X-Ajax-Grid-Req', value: JSON.stringify({action: action || 'showpage'})}
					],
					processData: false,
					scriptsRunFirst: false,
					onsuccess: function(response) {
						self.response = BX.create('div', {html: response});
						self.xhr = xhr;

						if (BX.type.isFunction(then))
						{
							BX.delegate(then, self)(response, xhr);
						}
					},
					onerror: function(err) {
						self.error = error;
						self.xhr = xhr;

						if (BX.type.isFunction(error))
						{
							BX.delegate(error, self)(xhr, err);
						}
					}
				});
			}, 0);

		};

		GridData.prototype.getResponse = function()
		{
			return this.response;
		};

		GridData.prototype.getHeadRows = function()
		{
			this.headRows = this.headRows || BX.findChild(
					this.getResponse(),
					{class: this.getParent().settings.get('classHeadRow')},
					true,
					true
				);

			return this.headRows;
		};

		GridData.prototype.getBodyRows = function()
		{
			this.bodyRows = this.bodyRows || BX.findChild(
					this.getResponse(),
					{class: this.getParent().settings.get('classBodyRow')},
					true,
					true
				);

			return this.bodyRows;
		};

		GridData.prototype.getFootRows = function()
		{
			this.footRows = this.footRows || BX.findChild(
					this.getResponse(),
					{class: this.getParent().settings.get('classFootRow')},
					true,
					true
				);

			return this.footRows;
		};

		GridData.prototype.getMoreButton = function()
		{
			this.moreButton = this.moreButton || BX.findChild(
					this.getResponse(),
					{class: this.getParent().settings.get('classMoreButton')},
					true,
					false
				);

			return this.moreButton;
		};

		GridData.prototype.getPagination = function()
		{
			if (!this.pagination)
			{
				this.pagination = BX.findChild(
					this.getResponse(),
					{class: this.getParent().settings.get('classPagination')},
					true,
					false
				);

				if (BX.type.isDomNode(this.pagination))
				{
					this.pagination = BX.firstChild(this.pagination);
				}
			}

			return this.pagination;
		};

		GridData.prototype.getCounterDisplayed = function()
		{
			this.counterDisplayed = this.counterDisplayed || BX.findChild(
					this.getResponse(),
					{class: this.getParent().settings.get('classCounterDisplayed')},
					true,
					false
				);

			return this.counterDisplayed;
		};

		GridData.prototype.getCounterSelected = function()
		{
			this.counterSelected = this.counterSelected || BX.findChild(
					this.getResponse(),
					{class: this.getParent().settings.get('classCounterSelected')},
					true,
					false
				);

			return this.counterSelected;
		};

		GridData.prototype.getCounterTotal = function()
		{
			this.counterTotal = this.counterTotal || BX.findChild(
					this.getResponse(),
					{class: this.getParent().settings.get('classCounterTotal')},
					true,
					false
				);

			return this.counterTotal;
		};

		GridData.prototype.getLimit = function()
		{
			this.limit = this.limit || BX.findChild(
					this.getResponse(),
					{class: this.getParent().settings.get('classPageSize')},
					true,
					false
				);

			return this.limit;
		};

		GridData.prototype.getActionPanel = function()
		{
			this.actionPanel = this.actionPanel || BX.findChild(
					this.getResponse(),
					{class: this.getParent().settings.get('classActionPanel')},
					true,
					false
				);

			return this.actionPanel;
		};
	}


	/**
	 * Updates grid
	 * @param parent
	 * @constructor
	 */
	GridUpdater = function(parent)
	{
		GridUpdater.superclass.constructor.apply(this, [parent]);
		this.reset();
	};

	BX.extend(GridUpdater, GridBaseClass);
	{
		GridUpdater.prototype = Object.create(GridBaseClass.prototype, {});

		GridUpdater.prototype.reset = function()
		{
			this.head = null;
			this.body = null;
			this.foot = null;
			this.moreButton = null;
			this.pagination = null;
			this.counterDisplayed = null;
			this.counterSelected = null;
			this.counterTotal = null;
			this.limit = null;
			this.actionPanel = null;
		};

		GridUpdater.prototype.updateHeadRows = function(rows)
		{
			var headers;

			if (BX.type.isArray(rows) && rows.length)
			{
				headers = this.getParent().getHeaders();

				headers.forEach(function(header) {
					header = BX.cleanNode(header);
					rows.forEach(function(row) {
						if (BX.type.isDomNode(row))
						{
							header.appendChild(BX.clone(row));
						}
					});
				});
			}
		};

		GridUpdater.prototype.appendHeadRows = function(rows)
		{
			var headers;

			if (BX.type.isArray(rows) && rows.length)
			{
				headers = this.getParent().getHeaders();

				headers.forEach(function(header) {
					rows.forEach(function(row) {
						if (BX.type.isDomNode(row))
						{
							header.appendChild(BX.clone(row));
						}
					});
				});
			}
		};

		GridUpdater.prototype.prependHeadRows = function(rows)
		{
			var headers;

			if (BX.type.isArray(rows) && rows.length)
			{
				headers = this.getParent().getHeaders();

				headers.forEach(function(header) {
					header = BX.cleanNode(header);
					rows.forEach(function(row) {
						if (BX.type.isDomNode(row))
						{
							header.prepend(BX.clone(row));
						}
					});
				});
			}
		};

		GridUpdater.prototype.updateBodyRows = function(rows)
		{
			var body;

			if (BX.type.isArray(rows))
			{
				body = BX.cleanNode(this.getParent().getBody());
				rows.forEach(function(current) {
					if (BX.type.isDomNode(current))
					{
						body.appendChild(current);
					}
				});
			}
		};

		GridUpdater.prototype.appendBodyRows = function(rows)
		{
			var body;

			if (BX.type.isArray(rows))
			{
				body = this.getParent().getBody();
				rows.forEach(function(current) {
					if (BX.type.isDomNode(current))
					{
						body.appendChild(current);
					}
				});
			}
		};

		GridUpdater.prototype.prependHeadRows = function(rows)
		{
			var body;

			if (BX.type.isArray(rows))
			{
				body = this.getParent().getHead();
				rows.forEach(function(current) {
					if (BX.type.isDomNode(current))
					{
						BX.prepend(body, current);
					}
				});
			}
		};

		GridUpdater.prototype.updateFootRows = function(rows)
		{
			var foot;

			if (BX.type.isArray(rows))
			{
				foot = BX.cleanNode(this.getParent().getFoot());
				rows.forEach(function(current) {
					if (BX.type.isDomNode(current))
					{
						foot.appendChild(current);
					}
				});
			}
		};

		GridUpdater.prototype.updatePagination = function(pagination)
		{
			var paginationCell;

			if (BX.type.isDomNode(pagination))
			{
				paginationCell = BX.cleanNode(this.getParent().getPagination().getContainer());
				paginationCell.appendChild(pagination);
			}
		};

		GridUpdater.prototype.updateMoreButton = function(button)
		{
			var buttonParent = GridUtils.closestParent(this.getParent().getMoreButton().getNode());

			if (BX.type.isDomNode(button))
			{
				if (BX.isNodeHidden(buttonParent))
				{
					BX.show(buttonParent);
				}

				buttonParent = BX.cleanNode(buttonParent);
				buttonParent.appendChild(button);
			}
			else
			{
				BX.hide(buttonParent);
			}
		};
	}



	GridPageSize = function(parent)
	{
		this.parent = null;
		this.init(parent);
	};

	GridPageSize.prototype = {
		init: function(parent)
		{
			this.parent = parent;
			BX.addCustomEvent('Dropdown::change', BX.delegate(this.onChange, this));
		},

		onChange: function(id, event, item, dataValue, value)
		{
			var self = this;

			if (id === this.parent.getContainerId() + '_' + this.parent.settings.get('pageSizeId'))
			{
				if (value > 0)
				{
					this.parent.tableFade();
					this.parent.getUserOptions().setPageSize(value, function() {
						self.parent.reloadTable();
						BX.onCustomEvent(self.parent.getContainer(), 'Grid::pageSizeChanged', [self.parent]);
					});
				}
			}
		}
	};



	GridActionPanel = function(parent, actions, types)
	{
		this.parent = null;
		this.rel = {};
		this.actions = null;
		this.types = null;
		this.lastActivated = [];
		this.init(parent, actions, types);
	};

	GridActionPanel.prototype = {
		init: function(parent, actions, types)
		{
			this.parent = parent;

			try {
				this.actions = JSON.parse(actions);
				this.types = JSON.parse(types);
			} catch(err) {}

			this.bindOnChange();
		},

		getPanel: function()
		{
			return BX.findChild(this.parent.getContainer(), {class: this.parent.settings.get('classActionPanel')}, true, false);
		},

		getApplyButton: function()
		{
			return BX.findChild(this.getPanel(), {class: this.parent.settings.get('classPanelApplyButton')}, true, false);
		},

		bindOnChange: function()
		{
			var self = this;
			var panel = this.getPanel();

			BX.addCustomEvent(window, 'Dropdown::change', function(id, event, item, dataItem, value) {
				if (self.isPanelControl(BX(id)))
				{
					self._dropdownChange(id, event, item, dataItem, value);
				}
			});

			BX.addCustomEvent(window, 'Dropdown::load', function(id, event, item, dataItem, value) {
				if (self.isPanelControl(BX(id)))
				{
					self._dropdownChange(id, event, item, dataItem, value);
				}
			});

			BX.bind(panel, 'change', BX.delegate(this._checkboxChange, this));
			BX.bind(panel, 'click', BX.delegate(this._clickOnButton, this));
		},

		isPanelControl: function(node)
		{
			return BX.hasClass(node, this.parent.settings.get('classPanelControl'));
		},

		getTextInputs: function()
		{
			return BX.findChild(this.getPanel(), {type: 'text'}, true, true);
		},

		getDropdowns: function()
		{
			return BX.findChild(this.getPanel(), {class: this.parent.settings.get('classDropdown')}, true, true);
		},

		getCheckboxes: function()
		{
			return BX.findChild(this.getPanel(), {class: this.parent.settings.get('classPanelCheckbox')}, true, true);
		},

		isDropdown: function(node)
		{
			return BX.hasClass(node, this.parent.settings.get('classDropdown'));
		},

		isCheckbox: function(node)
		{
			return BX.hasClass(node, this.parent.settings.get('classPanelCheckbox'));
		},

		isTextInput: function(node)
		{
			return node.type === 'text';
		},

		createDropdown: function(data, relative)
		{
			var container = this.createContainer(data.ID, relative);
			var dropdown = BX.create('div', {
				props: {
					className: 'main-dropdown main-grid-panel-control',
					id: data.ID + '_control'
				},
				attrs: {
					name: data.NAME,
					'data-items': JSON.stringify(data.ITEMS),
					'data-value': data.ITEMS[0].VALUE
				},
				html: data.ITEMS[0].NAME
			});

			container.appendChild(dropdown);

			return container;
		},

		createCheckbox: function(data, relative)
		{
			var checkbox = this.createContainer(data.ID, relative);

			var inner = BX.create('span', {
				props: {
					className: 'main-grid-checkbox-container'
				}
			});

			var titleSpan = BX.create('span', {
				props: {
					className: 'main-grid-control-panel-content-title'
				}
			});

			var input = BX.create('input', {
				props: {
					type: 'checkbox',
					className: this.parent.settings.get('classPanelCheckbox') + ' main-grid-checkbox',
					id: data.ID + '_control'
				},
				attrs: {
					value: data.VALUE || '',
					title: data.TITLE || '',
					name: data.NAME || '',
					'data-onchange': JSON.stringify(data.ONCHANGE)
				}
			});

			input.checked = data.CHECKED || null;

			checkbox.appendChild(inner);
			checkbox.appendChild(titleSpan);

			inner.appendChild(input);

			inner.appendChild(BX.create('label', {
				props: {
					className: 'main-grid-checkbox'
				},
				attrs: {
					for: data.ID + '_control',
					title: data.TITLE
				}
			}));

			titleSpan.appendChild(BX.create('label', {
				attrs: {
					for: data.ID + '_control',
					title: data.TITLE
				},
				html: data.LABEL
			}));

			return checkbox;
		},

		createText: function(data, relative)
		{
			var container = this.createContainer(data.ID, relative);
			var label = BX.create('label', {
				attrs: {
					title: data.TITLE || '',
					for: data.ID + '_control'
				}
			});
			var input = BX.create('input', {
				props: {
					className: 'main-grid-control-panel-input-text main-grid-panel-control',
					id: data.ID + '_control'
				},
				attrs: {
					name: data.NAME,
					title: data.TITLE || '',
					placeholder: data.PLACEHOLDER || '',
					value: data.VALUE || '',
					'data-onchange': JSON.stringify(data.ONCHANGE || [])
				}
			});

			container.appendChild(label);
			container.appendChild(input);

			return container;
		},

		createHidden: function(data, relative)
		{
			var container = this.createContainer(data.ID, relative);
			container.appendChild(
				BX.create(
					'input',
					{
						props:
							{
								id: data.ID + '_control',
								type: 'hidden'
							},
						attrs:
							{
								name: data.NAME,
								value: data.VALUE || ''
							}
					}
				)
			);

			return container;
		},

		createButton: function(data, relative)
		{
			var container = this.createContainer(data.ID, relative);
			var button = BX.create('button', {
				props: {
					className: 'main-grid-buttons' + (data.CLASS ? ' ' + data.CLASS : ''),
					id: data.id + '_control'
				},
				attrs: {
					name: data.NAME || '',
					'data-onchange': JSON.stringify(data.ONCHANGE || [])
				},
				html: data.TEXT
			});

			container.appendChild(button);

			return container;
		},

		createLink: function(data, relative)
		{
			var container = this.createContainer(data.ID, relative);
			var link = BX.create('a', {
				props: {
					className: 'main-grid-link' + (data.CLASS ? ' ' + data.CLASS : ''),
					id: data.ID + '_control'
				},
				attrs: {
					href: data.HREF || '',
					'data-onchange': JSON.stringify(data.ONCHANGE || [])
				},
				html: data.TEXT
			});

			container.appendChild(link);

			return container;
		},

		createCustom: function(data, relative)
		{

		},

		createContainer: function(id, relative)
		{
			id = id.replace('_control', '');
			relative = relative.replace('_control', '');

			return BX.create('span', {
				props: {
					className: this.parent.settings.get('classPanelControlContainer'),
					id: id
				},
				attrs: {
					'data-relative': relative
				}
			});
		},

		removeItemsRelativeCurrent: function(node)
		{
			var element = node;
			var relative = node.id;
			var result = [];
			var dataRelative;

			while (element) {
				dataRelative = BX.data(element, 'relative');

				if (dataRelative === relative || dataRelative === node.id)
				{
					relative = element.id;
					result.push(element);
				}

				element = element.nextElementSibling;
			}

			result.forEach(function(current) {
				BX.remove(current);
			});
		},


		validateData: function(data)
		{
			return (
				('ONCHANGE' in data) &&
				BX.type.isArray(data.ONCHANGE)
			);
		},

		activateControl: function(id)
		{
			var element = BX(id);

			if (BX.type.isDomNode(element))
			{
				BX.removeClass(element, this.parent.settings.get('classDisable'));
				element.disabled = null;
			}
		},

		deactivateControl: function(id)
		{
			var element = BX(id);

			if (BX.type.isDomNode(element))
			{
				BX.addClass(element, this.parent.settings.get('classDisable'));
				element.disabled = true;
			}
		},

		showControl: function(id)
		{
			var control = BX(id);

			if (BX.type.isDomNode(control))
			{
				BX.show(control);
			}
		},

		hideControl: function(id)
		{
			var control = BX(id);

			if (BX.type.isDomNode(control))
			{
				BX.hide(control);
			}
		},


		validateActionObject: function(action)
		{
			return (
				BX.type.isPlainObject(action) &&
				('ACTION' in action) &&
				BX.type.isNotEmptyString(action.ACTION) &&
				('DATA' in action) &&
				BX.type.isArray(action.DATA)
			);
		},

		validateControlObject: function(controlObject)
		{
			return (
				BX.type.isPlainObject(controlObject) &&
				('TYPE' in controlObject) &&
				('ID' in controlObject)
			);
		},

		createControl: function(controlObject, relativeId)
		{
			var newElement;

			switch (controlObject.TYPE) {
				case this.types.DROPDOWN : {
					newElement = this.createDropdown(controlObject, relativeId);
					break;
				}

				case this.types.CHECKBOX : {
					newElement = this.createCheckbox(controlObject, relativeId);
					break;
				}

				case this.types.TEXT : {
					newElement = this.createText(controlObject, relativeId);
					break;
				}

				case this.types.HIDDEN : {
					newElement = this.createHidden(controlObject, relativeId);
					break;
				}

				case this.types.BUTTON : {
					newElement = this.createButton(controlObject, relativeId);
					break;
				}

				case this.types.LINK : {
					newElement = this.createLink(controlObject, relativeId);
					break;
				}

				case this.types.CUSTOM : {
					newElement = this.createCustom(controlObject, relativeId);
					break;
				}

				default : {
					break;
				}
			}

			return newElement;
		},

		onChangeHandler: function(container, actions)
		{
			var newElement, callback;
			var self = this;

			if (BX.type.isDomNode(container) && BX.type.isArray(actions))
			{
				actions.forEach(function(action) {
					if (self.validateActionObject(action))
					{
						if (action.ACTION === self.actions.CREATE)
						{
							self.removeItemsRelativeCurrent(container);
							action.DATA.reverse();

							action.DATA.forEach(function(controlObject) {
								if (self.validateControlObject(controlObject))
								{
									newElement = self.createControl(controlObject, BX.data(container, 'relative') || container.id);

									if (BX.type.isDomNode(newElement))
									{
										BX.insertAfter(newElement, container);

										if (('ONCHANGE' in controlObject) &&
											controlObject.TYPE === self.types.CHECKBOX &&
											('CHECKED' in controlObject) &&
											controlObject.CHECKED)
										{
											self.onChangeHandler(newElement, controlObject.ONCHANGE);
										}

										if (controlObject.TYPE === self.types.DROPDOWN &&
											BX.type.isArray(controlObject.ITEMS) &&
											controlObject.ITEMS.length &&
											('ONCHANGE' in controlObject.ITEMS[0]) &&
											BX.type.isArray(controlObject.ITEMS[0].ONCHANGE))
										{
											self.onChangeHandler(newElement, controlObject.ITEMS[0].ONCHANGE);
										}
									}
								}
							});
						}

						if (action.ACTION === self.actions.ACTIVATE)
						{
							self.removeItemsRelativeCurrent(container);

							if (BX.type.isArray(action.DATA))
							{
								action.DATA.forEach(function(currentId) {
									self.lastActivated.push(currentId.ID);
									self.activateControl(currentId.ID);
								});
							}
						}

						if (action.ACTION === self.actions.SHOW)
						{
							if (BX.type.isArray(action.DATA))
							{
								action.DATA.forEach(function(showCurrent) {
									self.showControl(showCurrent.ID);
								});
							}
						}

						if (action.ACTION === self.actions.HIDE)
						{
							if (BX.type.isArray(action.DATA))
							{
								action.DATA.forEach(function(hideCurrent) {
									self.hideControl(hideCurrent.ID);
								});
							}
						}

						if (action.ACTION === self.actions.HIDE_ALL_EXPECT)
						{
							if (BX.type.isArray(action.DATA))
							{
								(self.getControls() || []).forEach(function(current) {
									if (!action.DATA.some(function(el) { return el.ID === current.id}))
									{
										self.hideControl(current.id);
									}
								});
							}
						}

						if (action.ACTION === self.actions.SHOW_ALL)
						{
							(self.getControls() || []).forEach(function(current) {
								self.showControl(current.id);
							});
						}

						if (action.ACTION === self.actions.REMOVE)
						{
							if (BX.type.isArray(action.DATA))
							{
								action.DATA.forEach(function(removeCurrent) {
									BX.remove(BX(removeCurrent.ID));
								});
							}
						}

						if (action.ACTION === self.actions.CALLBACK)
						{
							if (BX.type.isArray(action.DATA))
							{
								action.DATA.forEach(function(currentCallback) {
									if (currentCallback.JS.indexOf('Grid.') !== -1)
									{
										callback = currentCallback.JS.replace('Grid', 'self.parent');

										try {
											eval(callback); // jshint ignore:line
										} catch(err) {
											console.log(err);
										}
									}
								});
							}
						}
					}
				});

			}
			else
			{
				this.removeItemsRelativeCurrent(container);

				self.lastActivated.forEach(function(current) {
					self.deactivateControl(current);
				});

				self.lastActivated = [];
			}
		},

		_dropdownChange: function(id, event, item, dataItem)
		{
			var dropdown = BX(id);
			var container = dropdown.parentNode;
			var onChange = dataItem && ('ONCHANGE' in dataItem) ? dataItem.ONCHANGE : null;

			this.onChangeHandler(container, onChange);
		},

		_checkboxChange: function(event)
		{
			var onChange;

			try {
				onChange = JSON.parse(BX.data(event.target, 'onchange'));
			} catch(err) {
				onChange = null;
			}

			this.onChangeHandler(
				BX.findParent(event.target, {
					className: this.parent.settings.get('classPanelContainer')
				}, true, false),
				event.target.checked ? onChange : null
			);
		},

		_clickOnButton: function(event)
		{
			var onChange;

			if (this.isButton(event.target))
			{
				event.preventDefault();

				try {
					onChange = JSON.parse(BX.data(event.target, 'onchange'));
				} catch(err) {
					onChange = null;
				}

				this.onChangeHandler(
					BX.findParent(event.target, {
						className: this.parent.settings.get('classPanelContainer')
					}, true, false),
					onChange
				);
			}
		},

		isButton: function(node)
		{
			return BX.hasClass(node, this.parent.settings.get('classPanelButton'));
		},

		getSelectedIds: function()
		{
			var rows = this.parent.getRows().getSelected();

			return rows.map(function(current) {
				return current.getId();
			});
		},

		getRequestData: function()
		{
			return {
				panel: this.getValues(),
				selectedRows: this.getSelectedIds()
			};
		},

		getControls: function()
		{
			var result = BX.findChild(this.getPanel(), {
				className: this.parent.settings.get('classPanelControlContainer')
			}, true, true);

			return result;
		},

		getValues: function()
		{
			var data = {};
			var self = this;
			var controls = [].concat(
				this.getDropdowns(),
				this.getTextInputs(),
				this.getCheckboxes()
			);

			(controls || []).forEach(function(current) {
				if (BX.type.isDomNode(current))
				{
					if (self.isDropdown(current))
					{
						data[current.getAttribute('name')] = BX.data(current, 'value');
					}

					if (self.isCheckbox(current) && current.checked)
					{
						data[current.getAttribute('name')] = current.value;
					}

					if (self.isTextInput(current))
					{
						data[current.getAttribute('name')] = current.value;
					}
				}
			});

			return data;
		}

	};


	GridPinHeader = function(parent)
	{
		this.parent = null;
		this.fixedTable = null;
		this.header = null;
		this.init(parent);
	};

	GridPinHeader.prototype = {
		init: function(parent)
		{
			this.parent = parent;
			this.fixedTable = this.getFixedTable();

			this.bindOnScroll();
		},

		bindOnScroll: function()
		{
			BX.bind(window, 'scroll', BX.delegate(this._onScroll, this));
		},

		getFixedTable: function()
		{
			if (!BX.type.isDomNode(this.fixedTable))
			{
				this.fixedTable = BX.create('table', {props: {className: 'main-grid-fixed-top main-grid-table'}});
				this.parent.getScrollContainer().appendChild(this.fixedTable);
			}

			return this.fixedTable;
		},

		checkHeaderPosition: function()
		{
			var headerRect = this.getHeader().getBoundingClientRect();

			return headerRect.top <= 0;
		},

		getHeader: function()
		{
			this.header = this.header || this.parent.getHead();
			return this.header;
		},

		pinHeader: function()
		{
			var fixedTable = this.getFixedTable();
			var clone = BX.clone(this.getHeader());

			if (!this.isPinned())
			{
				fixedTable.appendChild(clone);

				BX.style(fixedTable, 'top', BX.scrollTop(window) - BX.pos(this.getHeader()).top + 'px');
				//BX.style(fixedTable, 'width', BX.width(this.parent.getTable()) + 'px');
				BX.onCustomEvent(window, 'Grid::headerPinned', []);
			}
			else
			{
				BX.style(fixedTable, 'top', BX.scrollTop(window) - BX.pos(this.getHeader()).top + 'px');
			}
		},

		unpinHeader: function()
		{
			if (this.isPinned())
			{
				BX.html(this.getFixedTable(), '');
				BX.onCustomEvent(window, 'Grid::headerUnpinned', []);
			}
		},

		isPinned: function()
		{
			return this.getFixedTable().children.length;
		},

		_onScroll: function()
		{
			if (this.checkHeaderPosition())
			{
				this.pinHeader();
			}
			else
			{
				this.unpinHeader();
			}
		}
	};


	GridPinPanel = function(parent)
	{
		this.parent = null;
		this.panel = null;
		this.panelRect = null;
		this.isSelected = null;
		this.offset = null;
		this.animationDuration = null;
		this.lastIsSelected = null;
		this.init(parent);
	};

	GridPinPanel.prototype = {
		init: function(parent) {
			this.parent = parent;
			this.offset = 10;
			this.animationDuration = 200;
			this.panel = this.getPanel();
			this.bindOnRowsEvents();
		},

		bindOnRowsEvents: function()
		{
			BX.addCustomEvent('Grid::thereSelectedRows', BX.delegate(this._onThereSelectedRows, this));
			BX.addCustomEvent('Grid::allRowsSelected', BX.delegate(this._onThereSelectedRows, this));


			BX.addCustomEvent('Grid::noSelectedRows', BX.delegate(this._onNoSelectedRows, this));
			BX.addCustomEvent('Grid::allRowsUnselected', BX.delegate(this._onNoSelectedRows, this));

			BX.addCustomEvent('Grid::updated', BX.delegate(this._onNoSelectedRows, this));

		},

		bindOnWindowEvents: function()
		{
			BX.bind(window, 'resize', BX.delegate(this._onResize, this));
			BX.bind(window, 'scroll', BX.delegate(this._onScroll, this));
		},

		unbindOnWindowEvents: function()
		{
			BX.unbind(window, 'resize', BX.delegate(this._onResize, this));
			BX.unbind(window, 'scroll', BX.delegate(this._onScroll, this));
		},

		getPanel: function() {
			this.panel = this.panel || this.parent.getActionsPanel().getPanel();
			return this.panel;
		},

		getScrollBottom: function()
		{
			return (BX.scrollTop(window) + this.getWindowHeight());
		},

		getPanelRect: function()
		{
			this.panelRect = this.panelRect || this.getPanel().getBoundingClientRect();
			return this.panelRect;
		},

		getPanelPrevBottom: function()
		{
			var prev = BX.previousSibling(this.getPanel());
			return BX.pos(prev).bottom + parseFloat(BX.style(prev, 'margin-bottom'));
		},

		getWindowHeight: function()
		{
			this.windowHeight = this.windowHeight || BX.height(window);
			return this.windowHeight;
		},

		pinPanel: function()
		{
			BX.style(this.getPanel(), 'width', BX.width(this.getPanel().parentNode) + 'px');
			BX.style(this.getPanel().parentNode, 'height', BX.height(this.getPanel().parentNode) + 'px');
			BX.addClass(this.getPanel(), 'main-grid-fixed-bottom');
			BX.style(this.getPanel(), 'bottom', '');
		},

		unpinPanel: function()
		{
			BX.removeClass(this.getPanel(), 'main-grid-fixed-bottom');
			BX.style(this.getPanel(), 'width', '');
			BX.style(this.getPanel().parentNode, 'height', '');
			BX.style(this.getPanel(), 'bottom', '');
		},

		isSelectedRows: function()
		{
			return this.isSelected;
		},

		isNeedPinAbsolute: function()
		{
			return (
				((BX.pos(this.parent.getBody()).top + this.getPanelRect().height) >= this.getScrollBottom())
			);
		},

		isNeedPin: function()
		{
			return (this.getScrollBottom() - this.getPanelRect().height) <= this.getPanelPrevBottom();
		},

		pinController: function(isNeedAnimation)
		{
			if(!this.getPanel())
			{
				return;
			}
			var self = this;

			if (this.isNeedPin() && this.isSelectedRows())
			{
				if (isNeedAnimation)
				{
					BX.style(this.getPanel(), 'bottom', -this.getStartDiffPanelPosition() + 'px');
					setTimeout(function() {
						self.pinPanel();
					}, 200);
				}
				else
				{
					this.pinPanel();
				}

				if (this.isNeedPinAbsolute() && !this.absolutePin)
				{
					this.absolutePin = true;
					BX.style(this.getPanel(), 'transition', '');
					BX.style(this.getPanel(), 'top', (BX.pos(this.parent.getBody()).top - parseFloat(BX.style(this.getPanel(), 'margin-top'))) + 'px');
					BX.style(self.getPanel(), 'position', 'absolute');
				}
				else if (!this.isNeedPinAbsolute() && this.absolutePin)
				{
					this.absolutePin = false;
					BX.style(this.getPanel(), 'position', '');
					BX.style(this.getPanel(), 'top', '');
				}
			}
			else
			{
				if (isNeedAnimation)
				{
					BX.style(this.getPanel(), 'bottom', -this.getEndDiffPanelPosition() + 'px');
					setTimeout(function() {
						self.unpinPanel();
					}, 200);
				}
				else
				{
					this.unpinPanel();
				}
			}
		},

		getEndDiffPanelPosition: function()
		{
			var panelPos = BX.pos(this.getPanel());
			var prevPanelPos = BX.pos(BX.previousSibling(this.getPanel()));
			var scrollTop = BX.scrollTop(window);
			var scrollBottom = scrollTop + BX.height(window);
			var diff = panelPos.height + this.offset;
			var prevPanelBottom = (prevPanelPos.bottom + parseFloat(BX.style(this.getPanel(), 'margin-top')));

			if (prevPanelBottom < scrollBottom && (prevPanelBottom + panelPos.height) > scrollBottom)
			{
				diff = Math.abs(scrollBottom - (prevPanelBottom + panelPos.height));
			}

			return diff;
		},

		getStartDiffPanelPosition: function()
		{
			var panelPos = BX.pos(this.getPanel());
			var scrollTop = BX.scrollTop(window);
			var scrollBottom = scrollTop + BX.height(window);
			var diff = panelPos.height + this.offset;

			if (panelPos.bottom > scrollBottom && panelPos.top < scrollBottom)
			{
				diff = panelPos.bottom - scrollBottom;
			}

			return diff;
		},

		_onThereSelectedRows: function()
		{
			this.bindOnWindowEvents();
			this.isSelected = true;

			if (this.lastIsSelected)
			{
				this.pinController();
			}
			else
			{
				this.lastIsSelected = true;
				this.pinController(true);
			}

		},

		_onNoSelectedRows: function()
		{
			this.unbindOnWindowEvents();
			this.isSelected = false;
			this.pinController(true);
			this.lastIsSelected = false;
		},

		_onScroll: function()
		{
			this.pinController();
		},

		_onResize: function()
		{
			this.windowHeight = BX.height(window);
			this.panel = this.parent.getActionsPanel().getPanel();
			this.panelRect = this.getPanel().getBoundingClientRect();
			this.pinController();
		}
	};



	/**
	 * @event Grid::ready
	 * @event Grid::columnMoved
	 * @event Grid::rowMoved
	 * @event Grid::pageSizeChanged
	 * @event Grid::optionsUpdated
	 * @event Grid::dataSorted
	 * @event Grid::thereSelectedRows
	 * @event Grid::allRowsSelected
	 * @event Grid::allRowsUnselected
	 * @event Grid::noSelectedRows
	 * @event Grid::updated
	 * @event Grid::headerPinned
	 * @event Grid::headerUnpinned
	 * @event Grid::beforeRequest
	 * @param containerId
	 * @param userOptions
	 * @param userOptionsActions
	 * @param userOptionsHandlerUrl
	 * @returns {Grid}
	 */
	BX.Main.grid = function(
		containerId,
		arParams,
		userOptions,
		userOptionsActions,
		userOptionsHandlerUrl,
		panelActions,
		panelTypes,
		editorTypes
	)
	{
		this.settings = null;
		this.containerId = '';
		this.container = null;
		this.wrapper = null;
		this.fadeContainer = null;
		this.scrollContainer = null;
		this.pagination = null;
		this.moreButton = null;
		this.table = null;
		this.rows = null;
		this.history = false;
		this.userOptions = null;
		this.checkAll = null;
		this.sortable = null;
		this.updater = null;
		this.data = null;
		this.fader = null;
		this.oldGrid = null;
		this.editor = null;
		this.isEditMode = null;
		this.pinHeader = null;
		this.pinPanel = null;
		this.arParams = null;
		this.init(
			containerId,
			arParams,
			userOptions,
			userOptionsActions,
			userOptionsHandlerUrl,
			panelActions,
			panelTypes,
			editorTypes
		);
	};

	BX.Main.grid.prototype = {
		init: function(
			containerId,
			arParams,
			userOptions,
			userOptionsActions,
			userOptionsHandlerUrl,
			panelActions,
			panelTypes,
			editorTypes
		)
		{
			if (!BX.type.isNotEmptyString(containerId))
			{
				throw 'BX.Main.grid.init: parameter containerId is empty';
			}

			try {
				this.arParams = JSON.parse(arParams);
			} catch(err) {
				this.arParams = {};
			}

			this.settings = new GridSettings();
			this.containerId = containerId;
			this.userOptions = new GridUserOptions(this, userOptions, userOptionsActions, userOptionsHandlerUrl);

			if (this.getParam('ALLOW_HORIZONTAL_SCROLL'))
			{
				this.fader = new GridFader(this);
			}

			this.pageSize = new GridPageSize(this);

			if (this.getParam('SHOW_ACTION_PANEL'))
			{
				this.actionPanel = new GridActionPanel(this, panelActions, panelTypes);
			}

			this.oldGrid = window['bxGrid_'+ this.getContainerId()];
			this.editor = new GridInlineEditor(this, editorTypes);

			if (this.getParam('ALLOW_PIN_HEADER'))
			{
				this.pinHeader = new GridPinHeader(this);
			}

			if (this.getParam('SHOW_ACTION_PANEL'))
			{
				this.pinPanel = new GridPinPanel(this);
			}

			this.isEditMode = false;

			if (!BX.type.isDomNode(this.getContainer()))
			{
				throw 'BX.Main.grid.init: Failed to find container with id ' + this.getContainerId();
			}

			if (!BX.type.isDomNode(this.getTable()))
			{
				throw 'BX.Main.grid.init: Failed to find table';
			}

			if (this.getParam('SHOW_ROW_CHECKBOXES'))
			{
				this.bindOnRowEvents();
			}

			this.bindOnMoreButtonEvents();
			this.bindOnClickPaginationLinks();
			this.bindOnClickHeader();
			this.bindOnCheckAll();

			if (this.getParam('ALLOW_ROWS_SORT'))
			{
				this.initRowsDragAndDrop();
			}

			if (this.getParam('ALLOW_COLUMNS_SORT'))
			{
				this.initColsDragAndDrop();
			}

			this.bindOnClickOnRowActionsMenu();
			BX.onCustomEvent(this.getContainer(), 'Grid::ready', [this]);
		},

		getParam: function(paramName, defaultValue)
		{
			if(defaultValue === undefined)
			{
				defaultValue = null;
			}
			return (this.arParams.hasOwnProperty(paramName) ? this.arParams[paramName] : defaultValue);
		},

		getActionKey: function()
		{
			return ('action_button_' + this.getId());
		},

		getPinHeader: function()
		{
			this.pinHeader = this.pinHeader || new GridPinHeader(this);
			return this.pinHeader;
		},

		editSelected: function()
		{
			this.getRows().editSelected();
		},

		editSelectedSave: function()
		{
			var data = { 'FIELDS': this.getRows().getEditSelectedValues() };
			data[this.getActionKey()] = 'edit';
			this.reloadTable('POST', data);
		},

		editSelectedCancel: function()
		{
			this.getRows().editSelectedCancel();
		},

		removeSelected: function()
		{
			var data = { 'ID': this.getRows().getSelectedIds() };
			data[this.getActionKey()] = 'delete';
			this.reloadTable('POST', data);
		},

		sendSelected: function()
		{
			var values = this.getActionsPanel().getValues();
			var selectedRows = this.getRows().getSelectedIds();
			var data = {
				rows: selectedRows,
				controls: values
			};

			this.reloadTable('POST', data);
		},

		getActionsPanel: function()
		{
			this.actionPanel = this.actionPanel || new GridActionPanel(this);
			return this.actionPanel;
		},

		getApplyButton: function()
		{
			return BX.findChild(this.getContainer(), {class: this.settings.get('classPanelButton')}, true, false);
		},

		getEditor: function()
		{
			return this.editor;
		},

		reload: function()
		{
			this.reloadTable("GET", {});
		},

		reloadTable: function(method, data)
		{
			if(!BX.type.isNotEmptyString(method))
			{
				method = "GET";
			}

			if(!BX.type.isPlainObject(data))
			{
				data = {};
			}

			var self = this;
			this.tableFade();

			this.getData().request('', method, data, '', function() {
				self.getUpdater().updateHeadRows(this.getHeadRows());
				self.getUpdater().updateBodyRows(this.getBodyRows());
				self.getUpdater().updateFootRows(this.getFootRows());
				self.getUpdater().updatePagination(this.getPagination());
				self.getUpdater().updateMoreButton(this.getMoreButton());

				if (self.getParam('SHOW_ROW_CHECKBOXES'))
				{
					self.bindOnRowEvents();
				}

				self.bindOnMoreButtonEvents();
				self.bindOnClickPaginationLinks();
				self.bindOnClickHeader();
				self.bindOnCheckAll();
				self.updateCounterDisplayed();
				self.updateCounterSelected();

				if (self.getParam('ALLOW_COLUMNS_SORT'))
				{
					self.colsSortable.reinit();
				}

				if (self.getParam('ALLOW_ROWS_SORT'))
				{
					self.rowsSortable.reinit();
				}

				self.oldGrid.InitTable();
				self.bindOnClickOnRowActionsMenu();
				self.tableUnfade();

				BX.onCustomEvent(window, 'Grid::updated', []);
			});
		},

		getGroupEditButton: function()
		{
			return BX.findChild(this.getContainer(), {
				class: this.settings.get('classGroupEditButton')
			}, true, false);
		},

		getGroupDeleteButton: function()
		{
			return BX.findChild(this.getContainer(), {
				class: this.settings.get('classGroupDeleteButton')
			}, true, false);
		},

		enableGroupActions: function()
		{
			var editButton = this.getGroupEditButton();
			var deleteButton = this.getGroupDeleteButton();

			if (BX.type.isDomNode(editButton))
			{
				BX.removeClass(editButton, this.settings.get('classGroupActionsDisabled'));
			}

			if (BX.type.isDomNode(deleteButton))
			{
				BX.removeClass(deleteButton, this.settings.get('classGroupActionsDisabled'));
			}
		},

		disableGroupActions: function()
		{
			var editButton = this.getGroupEditButton();
			var deleteButton = this.getGroupDeleteButton();

			if (BX.type.isDomNode(editButton))
			{
				BX.addClass(editButton, this.settings.get('classGroupActionsDisabled'));
			}

			if (BX.type.isDomNode(deleteButton))
			{
				BX.addClass(deleteButton, this.settings.get('classGroupActionsDisabled'));
			}
		},

		getPageSize: function()
		{
			return this.pageSize;
		},

		getFader: function()
		{
			return this.fader;
		},

		getData: function()
		{
			this.data = this.data || new GridData(this);
			return this.data;
		},

		getUpdater: function()
		{
			this.updater = this.updater || new GridUpdater(this);
			return this.updater;
		},

		isSortableHeader: function(item)
		{
			return (
				BX.hasClass(item, this.settings.get('classHeaderSortable'))
			);
		},

		bindOnClickHeader: function()
		{
			var self = this;
			var cell;

			BX.bind(this.getScrollContainer(), 'click', function(event) {
				cell = BX.findParent(event.target, {tag: 'th'}, true, false);

				if (cell && self.isSortableHeader(cell))
				{
					self._clickOnSortableHeader(cell, event);
				}
			});
		},

		enableEditMode: function()
		{
			this.isEditMode = true;
		},

		disableEditMode: function()
		{
			this.isEditMode = false;
		},

		isEditMode: function()
		{
			return this.isEditMode;
		},

		_clickOnSortableHeader: function(header, event)
		{
			var self = this;
			event.preventDefault();

			if (!BX.hasClass(header, this.settings.get('classLoad')))
			{
				BX.addClass(header, this.settings.get('classLoad'));

				this.getUserOptions().setSort(BX.data(header, 'sort-by'), BX.data(header, 'sort-order'), function() {
					self.getData().request(BX.data(header, 'sort-url'), null, null, 'sort', function() {
						BX.removeClass(header, self.settings.get('classLoad'));
						self.getUpdater().updateHeadRows(this.getHeadRows());
						self.getUpdater().updateBodyRows(this.getBodyRows());
						self.getUpdater().updatePagination(this.getPagination());
						self.getUpdater().updateMoreButton(this.getMoreButton());

						if (self.getParam('SHOW_ROW_CHECKBOXES'))
						{
							self.bindOnRowEvents();
						}

						self.bindOnMoreButtonEvents();
						self.bindOnClickPaginationLinks();
						self.bindOnClickHeader();
						self.bindOnCheckAll();
						self.updateCounterDisplayed();
						self.updateCounterSelected();

						if (self.getParam('ALLOW_ROWS_SORT'))
						{
							self.rowsSortable.reinit();
						}

						if (self.getParam('ALLOW_COLUMNS_SORT'))
						{
							self.colsSortable.reinit();
						}

						self.replaceState(BX.data(header, 'sort-url'));
						self.oldGrid.InitTable();
						self.bindOnClickOnRowActionsMenu();
						BX.onCustomEvent(self.getContainer(), 'Grid::dataSorted', [self.parent]);
						BX.onCustomEvent(window, 'Grid::updated', []);
					});
				});
			}
		},

		getObserver: function()
		{
			return GridObserver;
		},

		initRowsDragAndDrop: function()
		{
			this.rowsSortable = new GridRowsSortable(this);
		},

		initColsDragAndDrop: function()
		{
			this.colsSortable = new GridColsSortable(this);
		},

		getRowsSortable: function()
		{
			return this.rowsSortable;
		},

		getColsSortable: function()
		{
			return this.colsSortable;
		},

		getUserOptionsHandlerUrl: function()
		{
			return this.userOptionsHandlerUrl || '';
		},

		getUserOptions: function()
		{
			return this.userOptions;
		},

		getCheckAllCheckboxes: function()
		{
			var checkAllNodes = BX.findChild(
				this.getContainer(),
				{class: this.settings.get('classCheckAllCheckboxes')},
				true,
				true
			);

			this.checkAll = checkAllNodes.map(function(current) {
					return new GridElement(current);
				}) || [];

			return this.checkAll;
		},

		selectAllCheckAllCheckboxes: function()
		{
			this.getCheckAllCheckboxes().forEach(function(current) {
				current.getNode().checked = true;
			});
		},

		unselectAllCheckAllCheckboxes: function()
		{
			this.getCheckAllCheckboxes().forEach(function(current) {
				current.getNode().checked = false;
			});
		},

		bindOnCheckAll: function()
		{
			var self = this;

			this.getCheckAllCheckboxes().forEach(function(current) {
				current.getObserver().add(
					current.getNode(),
					'change',
					self._clickOnCheckAll,
					self
				);
			});
		},

		_clickOnCheckAll: function(event)
		{
			event.preventDefault();

			if (event.target.checked)
			{
				this.getRows().selectAll();
				this.selectAllCheckAllCheckboxes();
				BX.onCustomEvent(window, 'Grid::allRowsSelected', []);
			}
			else
			{
				this.getRows().unselectAll();
				this.unselectAllCheckAllCheckboxes();
				BX.onCustomEvent(window, 'Grid::allRowsUnselected', []);
			}

			this.updateCounterSelected();
		},

		bindOnClickPaginationLinks: function()
		{
			var self = this;

			this.getPagination().getLinks().forEach(function(current) {
				current.getObserver().add(
					current.getNode(),
					'click',
					self._clickOnPaginationLink,
					self
				);
			});
		},

		bindOnMoreButtonEvents: function()
		{
			var self = this;

			this.getMoreButton().getObserver().add(
				this.getMoreButton().getNode(),
				'click',
				self._clickOnMoreButton,
				self
			);
		},

		bindOnRowEvents: function()
		{
			var self = this;

			this.getRows().getBodyChild().forEach(function(current) {
				current.getObserver().add(
					current.getNode(),
					'click',
					self._onClickOnRow,
					self
				);
			});
		},

		bindOnClickOnRowActionsMenu: function()
		{
			var self = this;
			this.getRows().getBodyChild().forEach(function(current) {
				BX.bind(current.getActionsButton(), 'click', BX.delegate(self._clickOnRowActionsButton, self));
			});
		},

		_clickOnRowActionsButton: function(event)
		{
			var row = this.getRows().get(event.target);
			event.preventDefault();

			if (!row.actionsMenuIsShown())
			{
				row.showActionsMenu();
			}
			else
			{
				row.closeActionsMenu();
			}
		},

		_onClickOnRow: function(event)
		{
			var rows, row, containsNotSelected, min, max;

			if (event.target.nodeName !== 'A' && event.target.nodeName !== 'INPUT')
			{
				if (event.target.nodeName === 'LABEL')
				{
					event.preventDefault();
				}

				row = this.getRows().get(event.target);

				if (row.getCheckbox())
				{
					rows = [];

					this.currentIndex = row.getIndex();
					this.lastIndex = this.lastIndex || this.currentIndex;

					if (!event.shiftKey)
					{
						if (!row.isSelected())
						{
							row.select();
						}
						else
						{
							row.unselect();
							this.unselectAllCheckAllCheckboxes();
						}
					}
					else
					{
						min = Math.min(this.currentIndex, this.lastIndex);
						max = Math.max(this.currentIndex, this.lastIndex);

						while (min <= max)
						{
							rows.push(this.getRows().getByIndex(min));
							min++;
						}

						containsNotSelected = rows.some(function(current) {
							return !current.isSelected();
						});

						if (containsNotSelected)
						{
							rows.forEach(function(current) {
								current.select();
							});
						}
						else
						{
							rows.forEach(function(current) {
								current.unselect();
							});
						}
					}

					this.updateCounterSelected();
					this.lastIndex = this.currentIndex;
				}

				if (this.getRows().isSelected())
				{
					BX.onCustomEvent(window, 'Grid::thereSelectedRows', []);
				}
				else
				{
					BX.onCustomEvent(window, 'Grid::noSelectedRows', []);
				}

			}
		},

		getPagination: function()
		{
			return new GridPagination(this);
		},

		isHistoryApi: function()
		{
			this.history = this.history || (window.history && history.pushState);
			return this.history;
		},

		pushState: function(url)
		{
			if (this.isHistoryApi())
			{
				window.history.pushState({}, '', url);
			}
		},

		replaceState: function(url)
		{
			if (this.isHistoryApi() && !this.getParam('PRESERVE_HISTORY', false))
			{
				window.history.replaceState({}, '', url);
			}
		},

		getState: function()
		{
			return window.history.state;
		},

		tableFade: function()
		{
			BX.addClass(this.getTable(), this.settings.get('classTableFade'));
		},

		tableUnfade: function()
		{
			BX.removeClass(this.getTable(), this.settings.get('classTableFade'));
		},

		_clickOnPaginationLink: function(event)
		{
			event.preventDefault();

			var self = this;
			var link = this.getPagination().getLink(event.target);

			if (!link.isLoad())
			{
				link.load();
				this.tableFade();

				this.getData().request(link.getLink(), null, null, 'pagination', function() {
					self.getUpdater().updateBodyRows(this.getBodyRows());
					self.getUpdater().updateHeadRows(this.getHeadRows());
					self.getUpdater().updateMoreButton(this.getMoreButton());
					self.getUpdater().updatePagination(this.getPagination());

					if (self.getParam('SHOW_ROW_CHECKBOXES'))
					{
						self.bindOnRowEvents();
					}

					self.bindOnMoreButtonEvents();
					self.bindOnClickPaginationLinks();
					self.bindOnClickHeader();
					self.bindOnCheckAll();
					self.updateCounterDisplayed();
					self.updateCounterSelected();

					if (self.getParam('ALLOW_ROWS_SORT'))
					{
						self.rowsSortable.reinit();
					}

					if (self.getParam('ALLOW_COLUMNS_SORT'))
					{
						self.colsSortable.reinit();
					}

					link.unload();
					self.tableUnfade();
					self.replaceState(link.getLink());
					self.oldGrid.InitTable();
					self.bindOnClickOnRowActionsMenu();

					BX.onCustomEvent(window, 'Grid::updated', []);
				});
			}
		},

		_clickOnMoreButton: function(event)
		{
			event.preventDefault();

			var self = this;
			var moreButton = this.getMoreButton();

			moreButton.load();

			this.getData().request(moreButton.getLink(), null, null, 'more', function() {
				self.getUpdater().appendBodyRows(this.getBodyRows());
				self.getUpdater().updateMoreButton(this.getMoreButton());
				self.getUpdater().updatePagination(this.getPagination());

				if (self.getParam('SHOW_ROW_CHECKBOXES'))
				{
					self.bindOnRowEvents();
				}

				self.bindOnMoreButtonEvents();
				self.bindOnClickPaginationLinks();
				self.bindOnClickHeader();
				self.bindOnCheckAll();
				self.updateCounterDisplayed();
				self.updateCounterSelected();

				if (self.getParam('ALLOW_ROWS_SORT'))
				{
					self.rowsSortable.reinit();
				}

				if (self.getParam('ALLOW_COLUMNS_SORT'))
				{
					self.colsSortable.reinit();
				}

				self.replaceState(moreButton.getLink());
				self.bindOnClickOnRowActionsMenu();
			});
		},

		getAjaxId: function()
		{
			return BX.data(
				this.getContainer(),
				this.settings.get('ajaxIdDataProp')
			);
		},

		update: function(data, action)
		{
			var newRows, newHeadRows, newNavPanel, thisBody, thisHead, thisNavPanel;

			if (!BX.type.isNotEmptyString(data))
			{
				return;
			}

			thisBody = BX.findChild(this.getTable(), {tag: 'tbody'}, true, false);
			thisHead = BX.findChild(this.getTable(), {tag: 'thead'}, true, false);
			thisNavPanel = BX.findChild(this.getContainer(), {class: this.settings.get('classNavPanel')}, true, false);

			data = BX.create('div', {html: data});
			newHeadRows = BX.findChild(data, {class: this.settings.get('classHeadRow')}, true, true);
			newRows = BX.findChild(data, {class: this.settings.get('classDataRows')}, true, true);
			newNavPanel = BX.findChild(data, {class: this.settings.get('classNavPanel')}, true, false);

			if (action === this.settings.get('updateActionMore'))
			{
				this.getRows().addRows(newRows);
				this.unselectAllCheckAllCheckboxes();
			}

			if (action === this.settings.get('updateActionPagination'))
			{
				BX.cleanNode(thisBody);
				this.getRows().addRows(newRows);
				this.unselectAllCheckAllCheckboxes();
			}

			if (action === this.settings.get('updateActionSort'))
			{
				BX.cleanNode(thisHead);
				BX.cleanNode(thisBody);
				thisHead.appendChild(newHeadRows[0]);
				this.getRows().addRows(newRows);

			}

			thisNavPanel.innerHTML = newNavPanel.innerHTML;

			if (this.getParam('SHOW_ROW_CHECKBOXES'))
			{
				this.bindOnRowEvents();
			}

			this.bindOnMoreButtonEvents();
			this.bindOnClickPaginationLinks();
			this.bindOnClickHeader();
			this.bindOnCheckAll();
			this.updateCounterDisplayed();
			this.updateCounterSelected();
			this.sortable.reinit();
		},

		getCounterDisplayed: function()
		{
			return BX.findChild(
				this.getContainer(),
				{class: this.settings.get('classCounterDisplayed')},
				true,
				false
			);
		},

		getCounterSelected: function()
		{
			return BX.findChild(
				this.getContainer(),
				{class: this.settings.get('classCounterSelected')},
				true,
				false
			);
		},

		updateCounterDisplayed: function()
		{
			var counterDisplayed = this.getCounterDisplayed();

			if (BX.type.isDomNode(counterDisplayed))
			{
				this.getCounterDisplayed().innerText = this.getRows().getCountDisplayed();
			}
		},

		updateCounterSelected: function()
		{
			var counterSelected = this.getCounterSelected();

			if (BX.type.isDomNode(counterSelected))
			{
				this.getCounterSelected().innerText = this.getRows().getCountSelected();
			}
		},

		getContainerId: function()
		{
			return this.containerId;
		},

		getId: function()
		{
			//ID is equals to container Id
			return this.containerId;
		},

		getContainer: function()
		{
			return BX(this.getContainerId());
		},

		getScrollContainer: function()
		{
			this.scrollContainer = (
				this.scrollContainer || BX.findChild(
					this.getContainer(),
					{class: this.settings.get('classScrollContainer')},
					true,
					false
				)
			);

			return this.scrollContainer;
		},

		getWrapper: function()
		{
			this.wrapper = (
				this.wrapper || BX.findChild(
					this.getContainer(),
					{class: this.settings.get('classWrapper')},
					true,
					false
				)
			);

			return this.wrapper;
		},

		getFadeContainer: function()
		{
			this.fadeContainer = (
				this.fadeContainer || BX.findChild(
					this.getContainer(),
					{class: this.settings.get('classFadeContainer')},
					true,
					false
				)
			);

			return this.fadeContainer;
		},

		getTable: function()
		{
			return BX.findChild(
				this.getContainer(),
				{class: this.settings.get('classTable')},
				true,
				false
			);
		},

		getHeaders: function()
		{
			return BX.findChild(
				this.getScrollContainer(),
				{className: 'main-grid-header', 'data-relative': this.getContainerId},
				true,
				true
			);
		},

		getHead: function()
		{
			return BX.findChild(
				this.getTable(),
				{tag: 'thead'},
				true,
				false
			);
		},

		getBody: function()
		{
			return BX.findChild(
				this.getTable(),
				{tag: 'tbody'},
				true,
				false
			);
		},

		getFoot: function()
		{
			return BX.findChild(
				this.getTable(),
				{tag: 'tfoot'},
				true,
				false
			);
		},

		getRows: function()
		{
			return new GridRows(this);
		},

		getMoreButton: function()
		{
			return new GridElement(BX.findChild(
				this.getContainer(),
				{class: this.settings.get('classMoreButton')},
				true,
				false
			), this);
		}
	};

	/**
	 * Works with grid instances
	 * @type {{data: Array, push: BX.Main.gridManager.push, getById: BX.Main.gridManager.getById}}
	 */
	BX.Main.gridManager = {
		data: [],

		push: function(id, instance, instanceOfOldModule)
		{
			if (BX.type.isNotEmptyString(id) && instance)
			{
				var object = {
					id: id,
					instance: instance,
					old: instanceOfOldModule || null
				};

				if (this.getById(id) === null)
				{
					this.data.push(object);
				}
				else
				{
					this.data[0] = object;
				}
			}
		},

		getById: function(id)
		{
			var result = this.data.filter(function(current) {
				return (current.id === id) || (current.id.replace('main_grid_', '') === id);
			});

			return result.length === 1 ? result[0] : null;
		},

		getInstanceById: function(id)
		{
			var result = this.getById(id);
			return BX.type.isPlainObject(result) ? result["instance"] : null;
		},

		reload: function(id)
		{
			var instance = this.getInstanceById(id);
			if(instance)
			{
				instance.reload();
			}
		}
	};
})();


(function(BX) {
	BX.namespace('BX.Main');

	BX.Main.dropdown = function(dropdown)
	{
		this.id = null;
		this.dropdown = null;
		this.items = null;
		this.value = null;
		this.menuId = null;
		this.menu = null;
		this.menuItems = null;
		this.dataItems = 'items';
		this.dataValue = 'value';
		this.dropdownItemClass = 'main-dropdown-item';
		this.activeClass = 'main-dropdown-active';
		this.selectedClass = 'main-dropdown-item-selected';
		this.notSelectedClass = 'main-dropdown-item-not-selected';
		this.menuItemClass = 'menu-popup-item';
		this.init(dropdown);
	};

	BX.Main.dropdown.prototype = {
		init: function(dropdown)
		{
			this.id = dropdown.id;
			this.dropdown = dropdown;
			this.items = this.getItems();
			this.value = this.getValue();
			this.menuId = this.getMenuId();
			this.menu = this.createMenu();
			this.menu.popupWindow.show();

			BX.bind(this.dropdown, 'click', BX.delegate(this.showMenu, this));
		},

		getMenuId: function()
		{
			return this.id + '_menu';
		},

		getItems: function()
		{
			var result;
			var dataValue;

			try {
				dataValue = BX.data(this.dropdown, this.dataItems);
				result = JSON.parse(dataValue);
			} catch (err) {
				result = [];
			}

			return result;
		},

		getValue: function()
		{
			return BX.data(this.dropdown, this.dataValue);
		},

		prepareMenuItems: function()
		{
			var self = this;
			var attrs, subItem;
			var currentValue = this.getValue();

			return this.getItems().map(function(item) {
				attrs = {};
				attrs['data-'+self.dataValue] = item.VALUE;

				subItem = BX.create('div', {children: [
					BX.create('span', {
						props: {
							className: self.dropdownItemClass
						},
						attrs: attrs,
						text: item.NAME
					})
				]});

				return {
					text: subItem.innerHTML,
					className: currentValue === item.VALUE ? self.selectedClass : self.notSelectedClass,
					delimiter: item.SEPORATOR
				};
			});
		},

		createMenu: function()
		{
			var self = this;

			return BX.PopupMenu.create(
				this.getMenuId(),
				this.dropdown,
				this.prepareMenuItems(),
				{
					'autoHide': true,
					'offsetTop': -8,
					'offsetLeft': 40,
					'angle': {
						'position': 'bottom',
						'offset': 0
					},
					'events': {
						'onPopupClose': BX.delegate(this._onCloseMenu, this),
						'onPopupShow': function() {
							self._onShowMenu();
						}
					}
				}
			);
		},

		showMenu: function()
		{
			this.menu = BX.PopupMenu.getMenuById(this.menuId);

			if (!this.menu)
			{
				this.menu = this.createMenu();
				this.menu.popupWindow.show();
			}
		},

		getSubItem: function(node)
		{
			return BX.findChild(node, {class: this.dropdownItemClass}, true, false);
		},

		refresh: function(item)
		{
			var subItem = this.getSubItem(item);
			var value = BX.data(subItem, this.dataValue);

			this.dropdown.innerText = subItem.innerText;
			this.dropdown.dataset[this.dataValue] = value;
		},

		selectItem: function(node)
		{
			var self = this;

			(this.menu.menuItems || []).forEach(function(current) {
				BX.removeClass(current.layout.item, self.selectedClass);

				if (node !== current.layout.item)
				{
					BX.addClass(current.layout.item, self.notSelectedClass);
				}
				else
				{
					BX.removeClass(current.layout.item, self.notSelectedClass);
				}
			});

			BX.addClass(node, this.selectedClass);
		},

		getDataItemIndexByValue: function(items, value)
		{
			var result;

			if (BX.type.isArray(items))
			{
				items.map(function(current, index) {
					if (current.VALUE === value)
					{
						result = index;
						return false;
					}
				});
			}

			return false;
		},

		getDataItemByValue: function(value)
		{
			var result = this.getItems().filter(function(current) {
				return current.VALUE === value;
			});

			return result.length > 0 ? result[0] : null;
		},

		_onShowMenu: function()
		{
			var self = this;

			BX.addClass(this.dropdown, this.activeClass);
			(this.menu.menuItems || []).forEach(function(current) {
				BX.bind(current.layout.item, 'click', BX.delegate(self._onItemClick, self));
			});
		},

		_onCloseMenu: function()
		{
			BX.removeClass(this.dropdown, this.activeClass);
			BX.PopupMenu.destroy(this.menuId);
		},

		_onItemClick: function(event)
		{
			var item = this.getMenuItem(event.target);
			var value, dataItem;

			this.refresh(item);
			this.selectItem(item);
			this.menu.popupWindow.close();

			value = this.getValue();
			dataItem = this.getDataItemByValue(value);

			BX.onCustomEvent(window, 'Dropdown::change', [this.dropdown.id, event, item, dataItem, value]);
		},

		getMenuItem: function(node)
		{
			var item = node;

			if (!BX.hasClass(item, this.menuItemClass))
			{
				item = BX.findParent(item, {class: this.menuItemClass});
			}

			return item;
		}
	};



	BX.Main.dropdownManager = {
		dropdownClass: 'main-dropdown',
		data: {},
		init: function()
		{
			var self = this;
			var result;
			var onLoadItems;
			var items;

			BX.bind(document, 'click', BX.delegate(function(event) {
				if (BX.hasClass(event.target, this.dropdownClass))
				{
					event.preventDefault();

					result = this.getById(event.target.id);

					if (result && result.dropdown === event.target)
					{
						self.push(event.target.id, this.getById(event.target.id));
					}
					else
					{
						self.push(event.target.id, new BX.Main.dropdown(event.target));
					}
				}
			}, this));

			BX(BX.delegate(function() {
				onLoadItems = BX.findChild(document, {className: this.dropdownClass}, true, true);

				if (BX.type.isArray(onLoadItems))
				{
					onLoadItems.forEach(function(current) {
						result = self.getById(current.id);
						try {
							items = JSON.parse(BX.data(current, 'items'));
						} catch (err) {}

						BX.onCustomEvent(window, 'Dropdown::load', [current.id, {}, null, BX.type.isArray(items) && items.length ? items[0] : [], BX.data(current, 'value')]);
					});
				}
			}, this));

		},

		push: function(id, instance)
		{
			this.data[id] = instance;
		},

		getById: function(id)
		{
			return (id in this.data) ? this.data[id] : null;
		}
	};

	BX(function() {
		BX.Main.dropdownManager.init();
	});

})(BX);


(function() {
	'use strict';

	BX.namespace('BX.Main');

	BX.Main.submenu = {
		data: [],
		init: function(anchor, id, level, menuItems)
		{
			this.id = id;
			this.anchor = anchor;
			this.menuItems = menuItems;
			this.level = level;

			this.anchorRect = BX.pos(this.anchor);
			this.toggleMenu();
		},

		toggleMenu: function()
		{
			var currentLeft;
			var tempLeft;
			var tmpWindow;
			var current = this.anchor.menu;
			var currentWindow = current ? this.anchor.menu.popupWindow : null;

			if (current && currentWindow.isShown())
			{
				currentLeft = currentWindow.bindOptions.left;

				this.data.forEach(function(currentMenu) {
					tmpWindow = currentMenu.popupWindow;
					tempLeft = tmpWindow.bindOptions.left;

					if (currentLeft <= tempLeft)
					{
						currentMenu.popupWindow.close();
					}
				});
			}
			else
			{
				BX.PopupMenu.destroy(this.id);
				this.anchor.menu = this.createMenu();
				this.pushMenu(this.anchor.menu);
				this.anchor.menu.popupWindow.adjustPosition(BX.pos(this.anchor));
				this.anchor.menu.popupWindow.show();

				current = this.anchor.menu;
				currentWindow = current.popupWindow;
				currentLeft = currentWindow.bindOptions.left;

				this.data.forEach(function(currentMenu) {
					tmpWindow = currentMenu.popupWindow;
					tempLeft = tmpWindow.bindOptions.left;

					if (currentLeft <= tempLeft && current.id !== currentMenu.id)
					{
						currentMenu.popupWindow.close();
					}
				});
			}
		},

		pushMenu: function(menu)
		{
			var index = this.getMenu(menu);
			if (menu)
			{
				if (index === null)
				{
					this.data.push(menu);
				}
				else
				{
					this.data[index] = menu;
				}
			}
		},

		getMenu: function(menu)
		{
			var index = null;

			this.data.forEach(function(current, key) {
				if (current.id === menu.id)
				{
					index = key;
					return false;
				}
			});

			return index;
		},

		createMenu: function()
		{
			return BX.PopupMenu.create(
				this.id,
				this.anchor,
				this.menuItems,
				{
					'autoHide': true,
					'offsetTop': -((this.anchorRect.height / 2) + 26),
					'offsetLeft': this.anchorRect.width + 4,
					'angle': {
						'position': 'left',
						'offset': ((this.anchorRect.height / 2) - 8)
					}
				}
			);
		}
	};
})();