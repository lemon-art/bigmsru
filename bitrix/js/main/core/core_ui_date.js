;(function() {
	'use strict';

	BX.namespace('BX.Main.ui');
	BX.namespace('BX.Main.ui.block');

	BX.Main.ui.date = function(node) {
		this.node = null;
		this.classControl = 'main-ui-date';
		this.classButton = 'main-ui-date-button';
		this.classInput = 'main-ui-date-input';
		this.button = null;
		this.input = null;
		this.init(node);
	};

	BX.Main.ui.date.prototype = {
		init: function(node)
		{
			if (BX.type.isDomNode(node) && BX.hasClass(node, this.classControl))
			{
				this.node = node;

				BX.bind(this.getButton(), 'click', BX.delegate(this.calendar, this));
				BX.bind(this.getInput(), 'focus', BX.delegate(this.calendar, this));
				BX.bind(this.getInput(), 'input', BX.delegate(this.calendar, this));
				BX.bind(this.getInput(), 'click', BX.delegate(this.calendar, this));
				document.addEventListener('focus', BX.delegate(this._onDocumentFocus, this), true);
			}
		},

		_onDocumentFocus: function(event)
		{
			if (event.target.nodeName === 'INPUT' && event.target !== this.getInput())
			{
				this.calendar().Close();
			}
		},

		calendar: function()
		{
			var input = this.getInput();
			var button = this.getButton();
			var params = {node: button, field: input, bTime: true};

			return BX.calendar(params);
		},

		getNode: function()
		{
			return this.node;
		},

		getButton: function()
		{
			if (!BX.type.isDomNode(this.button))
			{
				this.button = BX.findChild(this.getNode(), {class: this.classButton}, true, false);
			}

			return this.button;
		},

		getInput: function()
		{
			if (!BX.type.isDomNode(this.input))
			{
				this.input = BX.findChild(this.getNode(), {class: this.classInput}, true, false);
			}

			return this.input;
		}
	};


	BX.Main.ui.block['main-ui-date'] = function(data)
	{
		var control, calendarButton, input, valueDelete;

		control = {
			block: 'main-ui-date',
			mix: ['main-ui-control'],
			content: []
		};

		if ('mix' in data && BX.type.isArray(data.mix))
		{
			data.mix.forEach(function(current) {
				control.mix.push(current);
			});
		}

		if ('calendarButton' in data && data.calendarButton === true)
		{
			calendarButton = {
				block: 'main-ui-date-button',
				tag: 'span'
			};

			control.content.push(calendarButton);
		}

		input = {
			block: 'main-ui-date-input',
			mix: ['main-ui-control-input'],
			tag: 'input',
			attrs: {
				type: 'text',
				name: 'name' in data ? data.name : '',
				tabindex: 'tabindex' in data ? data.tabindex : '',
				value: 'value' in data ? data.value : ''
			}
		};


		control.content.push(input);

		if ('valueDelete' in data && data.valueDelete === true)
		{
			valueDelete = {
				block: 'main-ui-control-value-delete',
				content: {
					block: 'main-ui-control-value-delete-item',
					tag: 'span'
				}
			};

			control.content.push(valueDelete);
		}

		return control;
	};

})();