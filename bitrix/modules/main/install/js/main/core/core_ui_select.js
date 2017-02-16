;(function() {
	'use strict';

	BX.namespace('BX.Main.ui');
	BX.namespace('BX.Main.ui.block');

	BX.Main.ui.select = function(node, params)
	{
		this.params = null;
		this.node = null;
		this.items = null;
		this.value = null;
		this.tabindex = null;
		this.searchButton = null;
		this.clearButton = null;
		this.removeButton = null;
		this.classSearchButton = null;
		this.classClearButton = '';
		this.classSquareRemove = 'main-ui-square-delete';
		this.classSquareText = 'main-ui-square-item';
		this.classSquareIcon = 'main-ui-item-icon';
		this.classPopup = 'main-ui-select-inner';
		this.classShow = 'main-ui-popup-fast-show-animation';
		this.classClose = 'main-ui-popup-fast-close-animation';
		this.classInput = 'main-ui-square-search-item';
		this.classMenuItem = 'main-ui-select-inner-item';
		this.classMenuItemText = 'main-ui-select-inner-item-element';
		this.classMenuMultiItemText = 'main-ui-select-inner-label';
		this.classMenuItemChecked = 'main-ui-checked';
		this.classSquare = 'main-ui-square';
		this.classSquareContainer = 'main-ui-square-container';
		this.classTextValueNode = 'main-ui-select-name';
		this.classPopupItemInput = 'main-ui-select-inner-input';
		this.classPopupItemLabel = 'main-ui-select-inner-label';
		this.classMultiSelect = 'main-ui-multi-select';
		this.classSelect = 'main-ui-select';
		this.classDelete = 'main-ui-delete';
		this.classValueDelete = 'main-ui-control-value-delete';
		this.classValueDeleteItem = 'main-ui-control-value-delete-item';
		this.classSquareSelected = 'main-ui-square-selected';
		this.popup = null;
		this.popupItems = null;
		this.isShown = false;
		this.isMulti = false;
		this.input = null;
		this.init(node, params);
	};

	BX.Main.ui.select.prototype = {
		init: function(node, params)
		{
			var node, popup, input, popupContainer;

			if (BX.type.isDomNode(node))
			{
				this.node = node;
			}

			try {
				params = params || JSON.parse(BX.data(node, 'params'));
			} catch (err) {}

			if (BX.type.isPlainObject(params))
			{
				this.params = params;
				this.classSearchButton = this.prepareParam('classSearchButton');
				this.classClearButton = this.prepareParam('classClearButton');
				this.classSquareRemove = this.prepareParam('classSquareRemove');
				this.isMulti = this.prepareParam('isMulti');
			}

			popup = this.getPopup();
			input = this.getInput();
			popupContainer = popup.popupContainer;
			node = this.getNode();

			BX.bind(input, 'blur', BX.delegate(this._onBlur, this));
			BX.bind(input, 'focus', BX.delegate(this._onFocus, this));
			BX.bind(input, 'keydown', BX.delegate(this._onKeyDown, this));
			BX.bind(popupContainer, 'click', BX.delegate(this._onPopupClick, this));
			BX.bind(node, 'click', BX.delegate(this._onControlClick, this));
		},

		_onKeyDown: function(event)
		{
			var target = event.target;
			var lastSquare, data;

			if (this.isMulti)
			{
				if (BX.hasClass(target, this.classInput))
				{
					lastSquare = this.getLastSquare();

					if (target.value.length === 0 && event.code === 'Backspace')
					{
						if (BX.type.isDomNode(lastSquare))
						{
							if (this.isSelected(lastSquare))
							{
								data = JSON.parse(BX.data(lastSquare, 'item'));
								this.unselectItem(data);
							}
							else
							{
								this.selectSquare(lastSquare);
							}
						}
					}
					else
					{
						this.unselectSquare(lastSquare);
					}
				}
			}
		},

		isSelected: function(square)
		{
			return BX.hasClass(square, this.classSquareSelected);
		},

		selectSquare: function(square)
		{
			BX.addClass(square, this.classSquareSelected);
		},

		unselectSquare: function(square)
		{
			BX.removeClass(square, this.classSquareSelected);
		},

		getLastSquare: function()
		{
			var squares = this.getSquares();
			var lastSquare;

			if (BX.type.isArray(squares) && squares.length)
			{
				lastSquare = squares[squares.length-1];
			}

			return lastSquare;
		},

		_onMenuItemClick: function(event)
		{
			var target = event.target;
			var data, square;

			if (!BX.hasClass(target, this.classMenuItem))
			{
				target = BX.findParent(target, {class: this.classMenuItem});
			}

			try {
				data = JSON.parse(BX.data(target, 'item'));
			} catch (err) {}

			if (this.isMulti)
			{
				square = this.getSquare(data);

				if (!BX.type.isDomNode(square))
				{
					this.selectItem(data);
				}
				else
				{
					this.unselectItem(data);
				}

				this.adjustPopupPosition();
				this.inputFocus();
			}
			else
			{
				this.updateDataValue(data);
				this.updateValue(data);
				this.closePopup();
				this.inputBlur();
			}

			BX.onCustomEvent(window, 'UI::Select::change', [this, data]);
		},

		selectItem: function(data)
		{
			var popupItem = this.getPopupItem(data);

			this.addSquare(data);

			if (BX.type.isDomNode(popupItem))
			{
				this.checkItem(popupItem);
			}

			this.addMultiValue(data);
		},

		unselectItem: function(data)
		{
			var square = this.getSquare(data);
			var popupItem = this.getPopupItem(data);

			this.removeSquare(square);
			this.uncheckItem(popupItem);
			this.removeMultiValue(data);
		},

		addMultiValue: function(data)
		{
			var currentValue = this.getDataValue();

			if (BX.type.isArray(currentValue))
			{
				currentValue.push(data);
				this.updateDataValue(currentValue);
			}
		},

		removeMultiValue: function(data)
		{
			var currentValue = this.getDataValue();

			if (BX.type.isArray(currentValue) && currentValue.length)
			{
				currentValue = currentValue.filter(function(current) {
					return current.VALUE !== data.VALUE && current.NAME !== data.NAME;
				}, this);

				this.updateDataValue(currentValue);
			}
		},

		getPopupItems: function()
		{
			var popupContainer = this.getPopup().popupContainer;

			if (!BX.type.isArray(this.popupItems))
			{
				this.popupItems = BX.findChild(popupContainer, {class: this.classMenuItem}, true, true);
			}

			return this.popupItems;
		},

		getPopupItem: function(data)
		{
			var popupItems = this.getPopupItems();
			var tmp;
			var item = (popupItems || []).filter(function(current) {
				tmp = JSON.parse(BX.data(current, 'item'));
				return data.VALUE === tmp.VALUE && data.NAME === tmp.NAME;
			});

			return BX.type.isArray(item) && item.length > 0 ? item[0] : null;
		},

		checkItem: function(item)
		{
			if (!BX.hasClass(item, this.classMenuItemChecked))
			{
				BX.addClass(item, this.classMenuItemChecked);
			}
		},

		uncheckItem: function(item)
		{
			if (BX.hasClass(item, this.classMenuItemChecked))
			{
				BX.removeClass(item, this.classMenuItemChecked);
			}
		},

		updateDataValue: function(data)
		{
			var node = this.getNode();
			var dataString = JSON.stringify(data);
			node.dataset.value = dataString;
		},

		getDataValue: function()
		{
			var node = this.getNode();
			var value;

			try {
				value = JSON.parse(BX.data(node, 'value'));
			} catch (err) {}

			if (!BX.type.isPlainObject(value) && !BX.type.isArray(value))
			{
				value = this.isMulti ? [] : {};
			}

			return value;
		},

		getTextValueNode: function()
		{
			var node = this.getNode();
			var textValueNode = BX.findChild(node, {class: this.classTextValueNode}, true, false);

			return textValueNode;
		},

		updateValue: function(data)
		{
			var textValueNode = this.getTextValueNode();
			BX.html(textValueNode, data.NAME);
		},

		adjustPopupPosition: function()
		{
			var popup = this.getPopup();
			var pos = BX.pos(this.getNode());
			pos.forceBindPosition = true;
			popup.adjustPosition(pos);
		},

		_onControlClick: function(event)
		{
			var squareData, square, squares;
			var target = event.target;

			if (!this.getPopup().isShown() || this.isMulti)
			{
				this.inputFocus();
			}
			else
			{
				this.inputBlur();
			}

			if (!BX.hasClass(target, this.classValueDelete) && !BX.hasClass(target, this.classValueDeleteItem))
			{
				if (BX.hasClass(target, this.classSquareRemove))
				{
					square = target.parentNode;
					squareData = JSON.parse(BX.data(square, 'item'));
					this.unselectItem(squareData);
				}
			}
			else
			{
				squares = this.getSquares();

				(squares || []).forEach(function(current) {
					squareData = JSON.parse(BX.data(current, 'item'));
					this.unselectItem(squareData);
				}, this);

				this.getInput().value = '';

				return false;
			}
		},

		inputBlur: function()
		{
			var input = this.getInput();

			if (BX.type.isDomNode(input))
			{
				this.getInput().blur();
			}
			else
			{
				this._onBlur();
			}
		},

		inputFocus: function()
		{
			var input = this.getInput();

			if (BX.type.isDomNode(input))
			{
				if (document.activeElement !== input)
				{
					input.focus();
				}
			}
		},

		_onPopupClick: function(event)
		{
			this.inputFocus();
		},

		_onFocus: function()
		{
			var popup = this.getPopup();

			clearTimeout(this.blurTimer);

			if (!popup.isShown())
			{
				this.showPopup();
			}
		},

		_onBlur: function(event)
		{
			var self = this;

			this.blurTimer = setTimeout(function() {
				self.closePopup();
			}, 50);
		},

		getInput: function()
		{
			if (!BX.type.isDomNode(this.input))
			{
				this.input = BX.findChild(this.getNode(), {class: this.classInput}, true, false);
			}

			return this.input;
		},

		getSquares: function()
		{
			return BX.findChild(this.getSquareContainer(), {class: this.classSquare}, true, true);
		},

		getSquare: function(data)
		{
			var squares = this.getSquares();
			var filtered, currentData;

			if (!BX.type.isPlainObject(data))
			{
				try {
					data = JSON.parse(data);
				} catch (err) {}
			}

			filtered = (squares || []).filter(function(current) {
				try {
					currentData = JSON.parse(BX.data(current, 'item'));
				} catch (err) {
					currentData = {};
				}

				return currentData.VALUE === data.VALUE && currentData.NAME === data.NAME;
			});

			return filtered.length ? filtered[0] : null;
		},

		removeSquare: function(squareNodeOrSquareData)
		{
			var square;

			if (BX.type.isDomNode(squareNodeOrSquareData))
			{
				square = squareNodeOrSquareData;
			}
			else
			{
				square = this.getSquare(data);
			}

			BX.remove(square);

			this.adjustPopupPosition();
		},

		createItem: function(itemData)
		{
			var itemText, itemContainer;

			itemContainer = BX.create('div', {
				props: {
					className: this.classMenuItem
				},
				attrs: {
					'data-item': JSON.stringify(itemData)
				}
			});

			if (!this.isMulti)
			{
				itemText = BX.create('div', {props: {
					className: this.classMenuItemText
				}, text: itemData.NAME});
			}
			else
			{
				itemText = BX.create('div', {props: {
					className: this.classMenuMultiItemText
				}, text: itemData.NAME});
			}

			BX.append(itemText, itemContainer);

			return itemContainer;
		},

		createSquare: function(data)
		{
			if (!BX.type.isPlainObject(data))
			{
				try {
					data = JSON.parse(data);
				} catch (err) {}
			}

			var square = BX.create('span', {
				props: {
					className: this.classSquare
				}
			});

			square.dataset.item = JSON.stringify(data);

			var squareText = BX.create('span', {
				props: {
					className: this.classSquareText
				},
				text: data.NAME
			});

			var squareRemove = BX.create('span', {
				props: {
					className: [this.classSquareIcon, this.classSquareRemove].join(' ')
				}
			});

			BX.append(squareText, square);
			BX.append(squareRemove, square);

			return square;
		},

		getSquareContainer: function()
		{
			if (!BX.type.isDomNode(this.squareContainer))
			{
				this.squareContainer = BX.findChild(this.getNode(), {class: this.classSquareContainer}, true, false);
			}

			return this.squareContainer;
		},

		addSquare: function(data)
		{
			var container = this.getSquareContainer();
			var square = this.createSquare(data);
			BX.append(square, container);
		},

		closePopup: function()
		{
			var popup = this.getPopup();
			var popupContainer = popup.popupContainer;
			var closeDelay = 0;
			var self = this;

			BX.removeClass(popupContainer, this.classShow);
			BX.addClass(popupContainer, this.classClose);

			closeDelay = parseFloat(BX.style(popupContainer, 'animation-duration'));

			if (BX.type.isNumber(closeDelay))
			{
				closeDelay = closeDelay * 1000;
			}

			setTimeout(function() {
				popup.close();
				self.inputBlur();
			}, closeDelay);
		},

		getNode: function()
		{
			return this.node;
		},

		showPopup: function()
		{
			var self = this;
			var popup = this.getPopup();
			var input = this.getInput();
			var popupContainer = popup.popupContainer;

			if (!popup.isShown())
			{
				this.adjustPopupPosition();
				popup.show();
				BX.removeClass(popupContainer, this.classClose);
				BX.addClass(popupContainer, self.classShow);
			}
		},

		getItems: function()
		{
			var dataItems = BX.data(this.getNode(), 'items');

			if (!BX.type.isArray(this.items))
			{
				if (!BX.type.isArray(dataItems))
				{
					this.items = JSON.parse(dataItems);
				}
				else
				{
					this.items = dataItems;
				}
			}

			return this.items;
		},

		getPopup: function()
		{
			if (!this.popup)
			{
				this.popup = this.createPopup(this.getItems());
			}

			return this.popup;
		},

		createPopupItems: function(items)
		{
			var container = BX.create('div');
			var item;

			items.forEach(function(current) {
				item = this.createItem(current);
				BX.append(item, container);
				BX.bind(item, 'click', BX.delegate(this._onMenuItemClick, this));
			}, this);

			return container;
		},

		createPopup: function(items)
		{
			var popup, nodeRect, popupItems;

			if (BX.type.isArray(items) && !this.popup)
			{
				nodeRect = BX.pos(this.getNode());
				this.popup = new BX.PopupWindow(
					'main-filter-control-popup',
					this.getNode(),
					{
						autoHide : false,
						offsetTop : 2,
						offsetLeft : 0,
						lightShadow : true,
						closeIcon : false,
						closeByEsc : false,
						noAllPaddings: true,
						zIndex: 2000
					}
				);

				BX.style(this.popup.popupContainer, 'min-width', nodeRect.width + 'px');
				BX.addClass(this.popup.popupContainer, this.classPopup);

				popupItems = this.createPopupItems(items);
				this.popup.setContent(popupItems);
			}

			return this.popup;
		},


		/**
		 * Returns custom or preset value
		 * @param paramName
		 * @returns {*}
		 */
		prepareParam: function(paramName)
		{
			return (paramName in this.params) ? this.params[paramName] : this[paramName];
		},

		getParams: function()
		{
			return this.params;
		}
	};


	BX.Main.ui.block['main-ui-square'] = function(data)
	{
		return {
			block: 'main-ui-square',
			attrs: {
				'data-item': 'item' in data ? JSON.stringify(data.item) : ''
			},
			content: [
				{
					block: 'main-ui-square-item',
					content: 'name' in data ? data.name : ''
				},
				{
					block: 'main-ui-square-delete',
					mix: ['main-ui-item-icon']
				}
			]
		}
	};

	BX.Main.ui.block['main-ui-multi-select'] = function(data)
	{
		var control, square, squareContainer, valueDelete, search;
		var squares = [];

		if ('value' in data && BX.type.isArray(data.value))
		{
			squares = data.value.map(function(current) {
				return {
					block: 'main-ui-square',
					name: 'NAME' in current ? current.NAME : '',
					item: current
				};
			}, this);
		}

		control = {
			block: 'main-ui-multi-select',
			mix: ['main-ui-control'],
			attrs: {
				'data-name': data.name,
				'data-params': JSON.stringify(data.params),
				'data-items': JSON.stringify(data.items),
				'data-value': JSON.stringify(data.value)
			},
			content: []
		};

		squareContainer = {
			block: 'main-ui-square-container',
			tag: 'span',
			content: squares
		};

		search = {
			block: 'main-ui-square-search',
			tag: 'span',
			content: {
				block: 'main-ui-square-search-item',
				tag: 'input',
				attrs: {
					type: 'text',
					tabindex: 'tabindex' in data ? data.tabindex : '',
					placeholder: 'placeholder' in data ? data.placeholder : ''
				}
			}
		};

		control.content.push(squareContainer);
		control.content.push(search);

		if ('valueDelete' in data && data.valueDelete === true)
		{
			valueDelete = {
				block: 'main-ui-control-value-delete',
				tag: 'span',
				content: {
					block: 'main-ui-control-value-delete-item'
				}
			};

			control.content.push(valueDelete);
		}

		return control;
	};


	/**
	 * BX.decl control declaration
	 * @param data
	 * @returns {{block: string, mix: string[], attrs: {data-name: *, data-params:
	 *     (data.params|{getSonetGroupAvailableList, getLivefeedUrl, checkParams}|*), data-items: *, data-value:
	 *     string}, content: Array}|*}
	 */
	BX.Main.ui.block['main-ui-select'] = function(data)
	{
		var control, name, search, valueDelete;

		control = {
			block: 'main-ui-select',
			mix: ['main-ui-control'],
			attrs: {
				'data-name': data.name,
				'data-params': JSON.stringify(data.params),
				'data-items': JSON.stringify(data.items),
				'data-value': JSON.stringify(data.value)
			},
			content: []
		};

		name = {
			block: 'main-ui-select-name',
			tag: 'span',
			content: 'value' in data && BX.type.isPlainObject(data.value) ? data.value.NAME : ''
		};

		search = {
			block: 'main-ui-square-search',
			tag: 'span',
			content: {
				block: 'main-ui-square-search-item',
				tag: 'input',
				attrs: {
					type: 'text',
					tabindex: data.tabindex
				}
			}
		};

		if ('valueDelete' in data && data.valueDelete === true)
		{
			valueDelete = {
				block: 'main-ui-control-value-delete',
				content: {
					block: 'main-ui-control-value-delete-item',
					tag: 'span'
				}
			};
		}

		control.content.push(name);
		control.content.push(search);

		if (BX.type.isPlainObject(valueDelete))
		{
			control.content.push(valueDelete);
		}

		return control;
	};

})();