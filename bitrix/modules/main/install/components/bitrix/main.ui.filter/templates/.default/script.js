;(function() {
	'use strict';

	BX.namespace('BX.Main');

	var FilterSettings,
		FilterFields,
		FilterSearch,
		FilterPresets,
		FilterUtils;

	/**
	 * Filter settings class
	 * @param options
	 * @param parent
	 * @constructor
	 */
	FilterSettings = function(options, parent)
	{
		/**
		 * Field
		 * @type {string}
		 */
		this.classField = 'main-ui-control-field';
		this.classFieldGroup = 'main-ui-control-field-group';
		this.classFieldLine = 'main-ui-filter-field-line';
		this.classFieldDelete = 'main-ui-delete';
		this.classControl = 'main-ui-control';
		this.classDateControl = 'main-ui-date';
		this.classDateInput = 'main-ui-date-input';
		this.classSelect = 'main-ui-select';
		this.classMultiSelect = 'main-ui-multi-select';
		this.classValueDelete = 'main-ui-control-value-delete';
		this.classAddField = 'main-ui-filter-field-add-item';
		this.classAddPresetField = 'main-ui-filter-new-filter';
		this.classAddPresetFieldInput = 'main-ui-filter-sidebar-edit-control';
		this.classAddPresetButton = 'main-ui-filter-add-item';
		this.classButtonsContainer = 'main-ui-filter-field-button-container';
		this.classSaveButton = 'main-ui-filter-save';
		this.classCancelButton = 'main-ui-filter-cancel';
		this.classMenuItem = 'main-ui-select-inner-item';
		this.classMenuItemText = 'main-ui-select-inner-item-element';
		this.classMenuMultiItemText = 'main-ui-select-inner-label';
		this.classMenuItemChecked = 'main-ui-checked';
		this.classSearchContainer = 'main-ui-filter-search';
		this.classDefaultPopup = 'popup-window';
		this.classPopupFieldList = 'main-ui-filter-popup-field-list';
		this.classPopupFieldList1Column = 'main-ui-filter-field-list-1-column';
		this.classPopupFieldList2Column = 'main-ui-filter-field-list-2-column';
		this.classPopupFieldList3Column = 'main-ui-filter-field-list-3-column';
		this.classFieldListItem = 'main-ui-filter-field-list-item';
		this.classSquareSearchInput = 'main-ui-square-search-item';
		this.classEditButton = 'main-ui-filter-add-edit';
		this.classPresetEdit = 'main-ui-filter-edit';
		this.classPresetNameEdit = 'main-ui-filter-edit-text';
		this.classPresetDeleteButton = 'main-ui-delete';
		this.classPresetDragButton = 'main-ui-filter-icon-grab';
		this.classPresetEditButton = 'main-ui-filter-icon-edit';
		this.classPresetEditInput = 'main-ui-filter-sidebar-item-input';
		this.classPresetOndrag = 'main-ui-filter-sidebar-item-ondrag';

		this.minSearchLength = 3;

		/**
		 * Square item
		 * @type {string}
		 */
		this.classSquare = 'main-ui-square';

		/**
		 * Square delete button
		 * @type {string}
		 */
		this.classSquareDelete = 'main-ui-square-delete';

		/**
		 * Presets container
		 * @type {string}
		 */
		this.classPresetsContainer = 'main-ui-filter-sidebar-item-container';

		/**
		 * Preset item
		 * @type {string}
		 */
		this.classPreset = 'main-ui-filter-sidebar-item';

		/**
		 * Current preset
		 * @type {string}
		 */
		this.classPresetCurrent = 'main-ui-filter-current-item';

		/**
		 * Filter container
		 * @type {string}
		 */
		this.classFilterContainer = 'main-ui-filter-wrapper';

		/**
		 * Control list container
		 * @type {string}
		 */
		this.classFileldControlList = 'main-ui-filter-field-container-list';

		/**
		 * Square from search input
		 * @type {string}
		 */
		this.classSearchSquare = 'main-ui-filter-search-square';

		/**
		 * Clear search value button from search input
		 * @type {string}
		 */
		this.classClearSearchValueButton = 'main-ui-delete';

		/**
		 * Search button from search input
		 * @type {string}
		 */
		this.classSearchButton = 'main-ui-search';

		this.classRemoveAnimation = 'main-ui-remove-animation';

		/**
		 * Show animation
		 * @type {string}
		 */
		this.classAnimationShow = 'main-ui-popup-show-animation';

		/**
		 * Close animation
		 * @type {string}
		 */
		this.classAnimationClose = 'main-ui-popup-close-animation';


		this.searchContainerPostfix = '_search_container';
		this.searchPostfix = '_search';
		this.classButtonContainer = 'main-ui-filter-field-button-container';
		this.textPlaceholderWithFilter = 'Поиск';
		this.textPlaceholderWithoutFilter = 'Поиск + Фильтр';
		this.generalTemplateId = '';
		this.stringTemplateId = '';
		this.dateTemplateId = '';
		this.numberTemplateId = '';
		this.selectTemplateId = '';
		this.multiSelectTemplateId = '';
		this.userTemplateId = '';
		this.entityTemplateId = '';
		this.squareTemplateId = '';
		this.dateFieldTemplateId = '';
		this.fieldLineTemplateId = '';
		this.init(options, parent);
	};
	FilterSettings.prototype = {
		init: function(options, parent)
		{
			var filterId = parent.getParam('FILTER_ID');
			var types = parent.types;

			this.generalTemplateId = filterId + '_GENERAL_template';
			this.squareTemplateId = filterId + '_SQUARE_template';
			this.stringTemplateId = filterId + '_' + types.STRING + '_template';
			this.dateTemplateId = filterId + '_' + types.DATE + '_template';
			this.dateFieldTemplateId = filterId + '_' + types.DATE + '_FIELD_template';
			this.fieldLineTemplateId = filterId + '_FIELD_LINE_template';
			this.numberTemplateId = filterId + '_' + types.NUMBER + '_template';
			this.selectTemplateId = filterId + '_' + types.SELECT + '_template';
			this.multiSelectTemplateId = filterId + '_' + types.MULTI_SELECT + '_template';
			this.userTemplateId = filterId + '_' + types.USER + '_template';
			this.entityTemplateId = filterId + '_' + types.ENTITY + '_template';
			this.mergeSettings(options);
		},

		mergeSettings: function(options)
		{
			var keys;
			var self = this;

			if (BX.type.isPlainObject(options))
			{
				keys = Object.keys(options);

				keys.forEach(function(key) {
					if (!BX.type.isFunction(self[key]))
					{
						self[key] = options[key];
					}
				});
			}
		}
	};


	/**
	 * Filter presets class
	 * @param parent
	 * @constructor
	 */
	FilterPresets = function(parent)
	{
		this.parent = null;
		this.presets = null;
		this.container = null;
		this.addPresetField = null;
		this.addPresetFieldInput = null;
		this.init(parent);
	};
	FilterPresets.prototype = {
		init: function(parent)
		{
			this.parent = parent;
			this.bindOnPresetClick();
		},

		bindOnPresetClick: function()
		{
			var presets = this.getPresets();
			var self = this;

			(presets || []).forEach(function(current) {
				BX.bind(current, 'click', BX.delegate(self._onPresetClick, self));
			});
		},

		getAddPresetField: function()
		{
			return FilterUtils.getByClass(this.getContainer(), this.parent.settings.classAddPresetField);
		},

		getAddPresetFieldInput: function()
		{
			return FilterUtils.getByClass(this.getAddPresetField(), this.parent.settings.classAddPresetFieldInput);
		},

		normalizePreset: function(node)
		{
			if (!BX.hasClass(node, this.parent.settings.classPreset))
			{
				node = BX.findParent(node, {class: this.parent.settings.classPreset}, true, false);
			}

			return node;
		},

		deactivateAllPresets: function()
		{
			var presets = this.getPresets();
			var self = this;

			(presets || []).forEach(function(current) {
				if (BX.hasClass(current, self.parent.settings.classPresetCurrent))
				{
					BX.removeClass(current, self.parent.settings.classPresetCurrent)
				}
			});
		},

		activatePreset: function(preset)
		{
			this.deactivateAllPresets();

			if (!BX.hasClass(preset, this.parent.settings.classPresetCurrent))
			{
				BX.addClass(preset, this.parent.settings.classPresetCurrent);
			}
		},

		getPresetId: function(preset)
		{
			return BX.data(preset, 'id');
		},

		_onPresetClick: function(event) {
			var presetId;
			var eventTarget = event.target;
			var parent = this.parent;
			var settings = parent.settings;
			var presetNode = this.normalizePreset(event.target);

			if (BX.type.isDomNode(presetNode))
			{
				if (BX.hasClass(eventTarget, settings.classPresetEditButton))
				{
					this.enableEditPresetName(presetNode, eventTarget);
				}
				else
				{
					if (!BX.hasClass(presetNode, this.parent.settings.classAddPresetField) &&
						!BX.hasClass(event.target, this.parent.settings.classPresetDragButton) &&
						!BX.hasClass(event.target, this.parent.settings.classPresetDeleteButton) &&
						!BX.hasClass(event.target, this.parent.settings.classPresetEditInput))
					{
						presetId = this.getPresetId(presetNode);
						this.activatePreset(presetNode);
						this.applyPreset(presetId);
						parent.applyFilter();

						parent.closePopup();

						if (parent.isAddPresetEnabled())
						{
							parent.disableAddPreset();
						}
					}
				}
			}
		},

		getPresetInput: function(presetNode)
		{
			return BX.findChild(presetNode, {class: this.parent.settings.classPresetEditInput}, true, false);
		},

		enableEditPresetName: function(presetNode)
		{
			var input = this.getPresetInput(presetNode);

			BX.addClass(presetNode, this.parent.settings.classPresetNameEdit);
			input.focus();
			//noinspection SillyAssignmentJS
			input.value = input.value;
		},

		disableEditPresetName: function(presetNode)
		{
			var input = this.getPresetInput(presetNode);

			BX.removeClass(presetNode, this.parent.settings.classPresetNameEdit);

			if (BX.type.isDomNode(input))
			{
				input.blur();
			}
		},

		getPreset: function(presetId)
		{
			var filtered = this.parent.getParam('PRESETS').filter(function(current) {
				return current.ID === presetId;
			});

			return filtered.length !== 0 ? filtered[0] : null;
		},

		applyPreset: function(presetId)
		{
			var preset = this.getPreset(presetId);
			this.parent.getSearch().updatePreset(preset);
			this.updatePresetFields(preset);
		},

		resetPreset: function()
		{
			var fieldContainer = this.parent.getFieldListContainer();

			if (BX.type.isDomNode(fieldContainer))
			{
				BX.cleanNode(fieldContainer);
			}
		},

		getFields: function()
		{
			var container = this.parent.getFieldListContainer();
			var fields = null;
			var fieldGroups;

			if (BX.type.isDomNode(container))
			{
				fields = BX.findChild(container, {class: this.parent.settings.classField}, true, true);
				fieldGroups = BX.findChild(container, {class: this.parent.settings.classFieldGroup}, true, true);

				(fieldGroups || []).forEach(function(current) {
					fields.push(current);
				});
			}

			return fields;
		},

		getField: function(fieldData)
		{
			var fields = this.getFields();
			var field = null;
			var tmpName, filtered;

			if (BX.type.isArray(fields) && fields.length)
			{
				filtered = fields.filter(function(current) {
					if (BX.type.isDomNode(current))
					{
						tmpName = BX.data(current, 'name');
					}
					return tmpName === fieldData.NAME;
				}, this);

				field = filtered.length > 0 ? filtered[0] : null;
			}

			return field;
		},

		removeField: function(fieldData)
		{
			var field = this.getField(fieldData);

			if (BX.type.isDomNode(field))
			{
				this.parent.getFields().deleteField(field, true);
			}
		},

		addField: function(fieldData)
		{
			var container, control, controls;

			if (BX.type.isPlainObject(fieldData))
			{
				container = this.parent.getFieldListContainer();
				controls = this.parent.getControls();
				control = BX.type.isArray(controls) ? controls[controls.length-1] : null;

				if (BX.type.isDomNode(control))
				{
					if (control.nodeName !== 'INPUT')
					{
						control = BX.findChild(control, {tag: 'input'}, true, false)
					}

					fieldData.TABINDEX = parseInt(control.getAttribute('tabindex')) + 1;
				}
				else
				{
					fieldData.TABINDEX = 2;
				}

				if (BX.type.isDomNode(container))
				{
					control = this.createControl(fieldData);

					if (BX.type.isDomNode(control))
					{
						BX.append(control, container);
					}
				}
			}
		},

		createControl: function(fieldData)
		{
			var control;

			switch (fieldData.TYPE)
			{
				case this.parent.types.STRING : {
					control = this.parent.getFields().createInputText(fieldData);
					break;
				}

				case this.parent.types.SELECT : {
					control = this.parent.getFields().createSelect(fieldData);
					break;
				}

				case this.parent.types.MULTI_SELECT : {
					control = this.parent.getFields().createMultiSelect(fieldData);
					break;
				}

				case this.parent.types.NUMBER : {
					control = this.parent.getFields().createNumber(fieldData);
					break;
				}

				case this.parent.types.DATE : {
					control = this.parent.getFields().createDate(fieldData);
					break;
				}

				case this.parent.types.USER : {
					control = this.parent.getFields().createUser(fieldData);
					break;
				}

				case this.parent.types.ENTITY : {
					control = this.parent.getFields().createEntity(fieldData);
					break;
				}

				default : {
					break;
				}
			}

			if (BX.type.isDomNode(control))
			{
				control.dataset.name = fieldData.NAME;
			}

			return control;
		},

		updatePresetFields: function(preset)
		{
			var fields, fieldListContainer;
			var fieldNodes = [];

			if (BX.type.isPlainObject(preset) && ('FIELDS' in preset))
			{
				fields = preset.FIELDS;

				(fields || []).forEach(function(fieldData, index) {
					fieldData.TABINDEX = index+1;
					fieldNodes.push(this.createControl(fieldData));
				}, this);

				if (fieldNodes.length)
				{
					fieldListContainer = this.parent.getFieldListContainer();

					BX.cleanNode(fieldListContainer);

					fieldNodes.forEach(function(current) {
						if (BX.type.isDomNode(current))
						{
							BX.append(current, fieldListContainer);
						}
					});
				}
			}
		},

		getCurrentPreset: function()
		{
			return BX.findChild(this.getContainer(), {class: this.parent.settings.classPresetCurrent}, true, false);
		},

		getCurrentPresetId: function()
		{
			var current = this.getCurrentPreset();
			var currentId = null;

			if (BX.type.isDomNode(current))
			{
				currentId = this.getPresetId(current);
			}

			return currentId;
		},

		getCurrentPresetData: function()
		{
			var currentId = this.getCurrentPresetId();
			var currentData = null;

			if (BX.type.isNotEmptyString(currentId))
			{
				currentData = this.getPreset(currentId);
			}

			return currentData;
		},

		getContainer: function()
		{
			return FilterUtils.getByClass(this.parent.getFilter(), this.parent.settings.classPresetsContainer);
		},

		getPresets: function()
		{
			return FilterUtils.getByClass(this.getContainer(), this.parent.settings.classPreset, true);
		}
	};


	/**
	 * Filter search block class
	 * @param parent
	 * @constructor
	 */
	FilterSearch = function(parent)
	{
		this.parent = null;
		this.container = null;
		this.input = null;
		this.preset = null;
		this.init(parent);
	};
	FilterSearch.prototype = {
		init: function(parent)
		{
			this.parent = parent;

			BX.bind(this.getInput(), 'input', BX.debounce(BX.delegate(this._onInput, this), 150));
		},

		_onInput: function(event)
		{
			var parent = this.parent;
			var eventTarget = event.target;

			if (parent.getPopup().isShown())
			{
				parent.closePopup();
			}

			if (eventTarget.value.length >= parent.settings.minSearchLength)
			{
				parent.applyFilter();
				this.isClear = false;
			}
			else
			{
				if (!this.isClear)
				{
					this.isClear = true;
					parent.applyFilter(true, true);
				}
			}
		},

		getInput: function()
		{
			var inputId;

			if (!BX.type.isDomNode(this.input))
			{
				inputId = [this.parent.getParam('FILTER_ID', ''), '_search'].join('');
				this.input = BX(inputId);
			}

			return this.input;
		},

		getContainer: function()
		{
			var containerId;

			if (!BX.type.isDomNode(this.container))
			{
				containerId = [this.parent.getParam('FILTER_ID'), '_search_container'].join('');
				this.container = BX(containerId);
			}

			return this.container;
		},

		adjustInputPaddings: function()
		{
			var preset = this.getPreset();
			var input = this.getInput();
			var presetRect, inputPaddingleft, afterWidth;

			if (BX.type.isDomNode(preset) && BX.type.isDomNode(input))
			{
				BX.style(input, 'padding-left', '');
				inputPaddingleft = parseInt(BX.style(input, 'padding-left'));
				presetRect = BX.pos(preset, this.getContainer());
				afterWidth = parseFloat(window.getComputedStyle(preset, '::after').getPropertyValue('width'))-1;
				BX.style(input, 'padding-left', (presetRect.width + afterWidth + inputPaddingleft) + 'px');
			}
			else
			{
				BX.style(input, 'padding-left', '');
			}
		},

		setInputPlaceholder: function(text)
		{
			var input = this.getInput();
			input.placeholder = text;
		},

		clearInput: function()
		{
			var form = this.getInput();

			if (BX.type.isDomNode(form))
			{
				form.value = null;
			}
		},

		clearForm: function()
		{
			this.clearInput();
			this.removePreset();
		},

		setPreset: function(presetData)
		{
			var container = this.getContainer();
			var template, presetLabel, presetClass, tmp, presetLabelClass;

			if (BX.type.isDomNode(container) && BX.type.isPlainObject(presetData))
			{
				template = this.parent.getTemplateValueLabel();
				presetLabel = template
					.replace('{{ID}}', presetData.ID)
					.replace('{{TITLE}}', presetData.TITLE);
				presetClass = this.parent.settings.classSquare;
				presetLabelClass = this.parent.settings.classSearchSquare;
				tmp = BX.create('div', {html: presetLabel});
				presetLabel = BX.findChild(tmp, {class: presetClass}, true, false);
				BX.addClass(presetLabel, presetLabelClass);
				BX.prepend(presetLabel, container);
				this.adjustInputPaddings();
				this.setInputPlaceholder(this.parent.settings.textPlaceholderWithFilter);
			}
		},

		getPreset: function()
		{
			var container = this.getContainer();
			var presetClass = this.parent.settings.classSquare;
			var preset = null;

			if (BX.type.isDomNode(container))
			{
				preset = BX.findChild(container, {class: presetClass}, true, false);
			}

			return preset;
		},

		removePreset: function()
		{
			var preset = this.getPreset();

			if (BX.type.isDomNode(preset))
			{
				BX.remove(preset);
				this.adjustInputPaddings();
				this.setInputPlaceholder(this.parent.settings.textPlaceholderWithoutFilter);
			}
		},

		updatePreset: function(presetData)
		{
			this.removePreset();
			this.setPreset(presetData);
		}
	};


	BX.Main.ui.block['main-ui-control-field'] = function(data)
	{
		var field, deleteButton;

		field = {
			block: 'main-ui-control-field',
			attrs: {
				'data-name': 'name' in data ? data.name : ''
			},
			content: []
		};

		if (BX.type.isArray(data.content))
		{
			data.content.forEach(function(current) {
				field.content.push(current);
			});
		}
		else if (BX.type.isPlainObject(data.content) ||
				 BX.type.isNotEmptyString(data.content))
		{
			field.content.push(data.content);
		}

		if ('deleteButton' in data && data.deleteButton === true)
		{
			deleteButton = {
				block: 'main-ui-item-icon-container',
				content: {
					block: 'main-ui-item-icon',
					mix: ['main-ui-delete'],
					tag: 'span'
				}
			};

			field.content.push(deleteButton);
		}

		return field;
	};

	BX.Main.ui.block['main-ui-control-field-group'] = function(data)
	{
		return {
			block: 'main-ui-control-field-group',
			attrs: {
				'data-name': 'name' in data ? data.name : ''
			},
			content: 'content' in data ? data.content : ''
		};
	};

	BX.Main.ui.block['date-group'] = function(data)
	{
		var group, select;

		group = {
			block: 'main-ui-control-field-group',
			name: 'name' ? data.name : '',
			content: []
		};

		select = {
			block: 'main-ui-control-field',
			content: {
				block: 'main-ui-select',
				tabindex: 'tabindex' in data ? data.tabindex : '',
				value: 'value' in data ? data.value : '',
				items: 'items' in data ? data.items : '',
				name: 'name' in data ? data.name : '',
				params: 'params' in data ? data.params : '',
				valueDelete: false
			}
		};

		group.content.push(select);

		if ('content' in data && BX.type.isArray(data.content))
		{
			data.content.forEach(function(current) {
				group.content.push(current);
			});
		}

		if ('content' in data &&
			(BX.type.isPlainObject(data.content) || BX.type.isNotEmptyString(data.content)))
		{
			group.content.push(data.content);
		}

		return group;
	};


	/**
	 * Filter fields class
	 * @param parent
	 * @constructor
	 */
	FilterFields = function(parent)
	{
		this.parent = null;
		this.init(parent);
	};
	FilterFields.prototype = {
		init: function(parent)
		{
			this.parent = parent;
			BX.addCustomEvent(window, 'UI::Select::change', BX.delegate(this._onDateTypeChange, this));
		},

		deleteField: function(node)
		{
			BX.remove(node);
		},

		isFieldDelete: function(node)
		{
			return BX.hasClass(node, this.parent.settings.classFieldDelete);
		},

		isField: function(node)
		{
			return BX.hasClass(node, this.parent.settings.classField);
		},

		isFieldGroup: function(node)
		{
			return BX.hasClass(node, this.parent.settings.classFieldGroup);
		},

		getField: function(node)
		{
			var field;

			if (BX.type.isDomNode(node))
			{
				field = BX.findParent(node, {class: this.parent.settings.classField}, true, false);

				if (!BX.type.isDomNode(field))
				{
					field = BX.findParent(node, {class: this.parent.settings.classFieldGroup}, true, false);
				}
			}

			return field;
		},

		getTemplateById: function(id)
		{
			return BX.html(BX(id));
		},

		render: function(template, data)
		{

			var dataKeys, result, tmp, placeholder;

			if (BX.type.isPlainObject(data) && BX.type.isNotEmptyString(template))
			{
				dataKeys = Object.keys(data);

				dataKeys.forEach(function(key) {
					placeholder = '{{'+key+'}}';
					template = template.replace(new RegExp(placeholder, 'g'), data[key]);
				});

				tmp = BX.create('div', {html: template});
				result = BX.findChild(tmp, {class: this.parent.settings.classFieldGroup}, true, false);

				if (!BX.type.isDomNode(result))
				{
					result = BX.findChild(tmp, {class: this.parent.settings.classField}, true, false);
				}

				if (!BX.type.isDomNode(result))
				{
					result = BX.findChild(tmp, {class: this.parent.settings.classFieldLine}, true, false);
				}
			}

			return result;
		},

		createInputText: function(fieldData)
		{
			var template = this.getTemplateById(this.parent.settings.stringTemplateId);
			return this.render(template, fieldData);
		},

		createSelect: function(fieldData)
		{
			return BX.decl({
				block: 'main-ui-control-field',
				name: fieldData.NAME,
				deleteButton: true,
				content: {
					block: this.parent.settings.classSelect,
					name: fieldData.NAME,
					items: fieldData.ITEMS,
					value: fieldData.ITEMS[0],
					params: fieldData.PARAMS,
					tabindex: fieldData.TABINDEX,
					valueDelete: false
				}
			});
		},

		createMultiSelect: function(fieldData)
		{
			return BX.decl({
				block: 'main-ui-control-field',
				name: fieldData.NAME,
				deleteButton: true,
				content: {
					block: 'main-ui-multi-select',
					name: fieldData.NAME,
					tabindex: 'TABINDEX' in fieldData ? fieldData.TABINDEX : '',
					placeholder: 'PLACEHOLDER' in fieldData ? fieldData.PLACEHOLDER : '',
					items: 'ITEMS' in fieldData ? fieldData.ITEMS : [],
					value: 'VALUE' in fieldData ? fieldData.VALUE : [],
					params: 'PARAMS' in fieldData ? fieldData.PARAMS : {isMulti: true},
					valueDelete: true
				}
			});
		},

		_onDateTypeChange: function(instance, data)
		{
			var fieldData = {};
			var dateGroup = null;
			var group, params;

			if (BX.type.isPlainObject(data) && 'VALUE' in data)
			{
				params = instance.getParams();

				if (!BX.type.isPlainObject(params))
				{
					group = instance.getNode().parentNode.parentNode;
					fieldData.TABINDEX = instance.getInput().getAttribute('tabindex');
					fieldData.SUB_TYPES = instance.getItems();
					fieldData.SUB_TYPE = data;
					fieldData.NAME = BX.data(instance.getNode(), 'name');

					dateGroup = this.createDate(fieldData);

					BX.insertAfter(dateGroup, group);
					BX.remove(group);
				}
			}
		},

		createDate: function(fieldData)
		{
			var group, dateFrom, dateTo, singleDate, line;
			var subTypes = this.parent.dateTypes;
			var subType = subTypes.SINGLE;

			if ('SUB_TYPE' in fieldData && BX.type.isPlainObject(fieldData.SUB_TYPE))
			{
				subType = fieldData.SUB_TYPE.VALUE;
			}

			group = {
				block: 'date-group',
				tabindex: 'TABINDEX' in fieldData ? fieldData.TABINDEX : '',
				value: 'SUB_TYPE' in fieldData ? fieldData.SUB_TYPE : {},
				items: 'SUB_TYPES' in fieldData ? fieldData.SUB_TYPES : [],
				name: 'NAME' in fieldData ? fieldData.NAME : '',
				deleteButton: true,
				content: []
			};

			if (subType === subTypes.SINGLE)
			{
				singleDate = {
					block: 'main-ui-control-field',
					content: {
						block: 'main-ui-date',
						mix: ['filter-type-single'],
						calendarButton: true,
						valueDelete: true,
						name: 'NAME' in fieldData ? fieldData.NAME : '',
						tabindex: 'TABINDEX' in fieldData ? fieldData.TABINDEX : ''
					}
				};

				group.content.push(singleDate);
			}

			if (subType === subTypes.AFTER)
			{
				singleDate = {
					block: 'main-ui-control-field',
					content: {
						block: 'main-ui-date',
						mix: ['filter-type-single'],
						calendarButton: true,
						valueDelete: true,
						name: 'NAME' in fieldData ? (fieldData.NAME + '_after') : '',
						tabindex: 'TABINDEX' in fieldData ? fieldData.TABINDEX : ''
					}
				};

				group.content.push(singleDate);
			}

			if (subType === subTypes.BEFORE)
			{
				singleDate = {
					block: 'main-ui-control-field',
					content: {
						block: 'main-ui-date',
						mix: ['filter-type-single'],
						calendarButton: true,
						valueDelete: true,
						name: 'NAME' in fieldData ? (fieldData.NAME + '_before') : '',
						tabindex: 'TABINDEX' in fieldData ? fieldData.TABINDEX : ''
					}
				};

				group.content.push(singleDate);
			}

			if (subType === subTypes.RANGE)
			{
				dateFrom = {
					block: 'main-ui-control-field',
					content: {
						block: 'main-ui-date',
						calendarButton: true,
						valueDelete: true,
						name: 'NAME' in fieldData ? (fieldData.NAME + '_from') : '',
						tabindex: 'TABINDEX' in fieldData ? fieldData.TABINDEX : ''
					}
				};

				line = {
					block: 'main-ui-filter-field-line',
					content: {
						block: 'main-ui-filter-field-line-item',
						tag: 'span'
					}
				};

				dateTo = {
					block: 'main-ui-control-field',
					content: {
						block: 'main-ui-date',
						calendarButton: true,
						valueDelete: true,
						name: 'NAME' in fieldData ? (fieldData.NAME + '_to') : '',
						tabindex: 'TABINDEX' in fieldData ? fieldData.TABINDEX : ''
					}
				};

				group.content.push(dateFrom);
				group.content.push(line);
				group.content.push(dateTo);
			}

			return BX.decl(group);
		}
	};

	BX.Main.ui.block['sidebar-item'] = function(data)
	{
		return {
			block: 'main-ui-filter-sidebar-item',
			attrs: {
				'data-id': 'id' in data ? data.id : ''
			},
			content: {
				block: 'main-ui-filter-sidebar-item-text-container',
				tag: 'span',
				content: {
					block: 'main-ui-filter-sidebar-item-text',
					tag: 'span',
					content: 'text' in data ? data.text : ''
				}
			}
		};
	};


	/**
	 * General filter class
	 * @param arParams
	 * @param options
	 * @param types
	 * @param dateTypes
	 */
	BX.Main.filter = function(arParams, options, types, dateTypes)
	{
		this.params = null;
		this.search = null;
		this.popup = null;
		this.presets = null;
		this.fields = null;
		this.types = null;
		this.dateTypes = null;
		this.settings = null;
		this.filter = null;
		this.isAddPresetModeState = false;
		this.init(arParams, options, types, dateTypes);
	};

	BX.Main.filter.prototype = {
		init: function(arParams, options, types, dateTypes)
		{
			try {
				this.params = JSON.parse(arParams);
				this.types = JSON.parse(types);
				this.dateTypes = JSON.parse(dateTypes);
				this.settings = new FilterSettings(options, this);
				this.getSearch().adjustInputPaddings();

				BX.bind(document, 'click', BX.delegate(this._onDocumentClick, this));

				BX.bind(this.getSearch().getContainer(), 'click', BX.delegate(this._onSearchContainerClick, this));

				if (this.getParam('GRID_ID'))
				{
					BX.addCustomEvent('Grid::ready', BX.delegate(this._onGridReady, this));
				}
			} catch (err) {
				throw err;
			}
		},

		getPresetValues: function()
		{
			var fields = this.getPreset().getFields();

			if (BX.type.isArray(fields) && fields.length)
			{
				fields.forEach(function(current) {

				});
			}
		},


		savePreset: function()
		{
			//var postData, getData, fieldsStr, tmpName, fieldsOb,
			//	sidebarItem, presetName, presetId, addPresetField, presetsContainer, preparedFields, tmpFilter;
			//var fields = this.getPreset().getFields();
			//var fieldsIds = (fields || []).map(function(current) {
			//	tmpName = BX.data(current, 'name');
			//	fieldsOb = fieldsOb || {};
			//
			//	fieldsOb[tmpName] = '';
			//
			//	return tmpName;
			//}, this);
			//
			//presetName = this.getPreset().getAddPresetFieldInput().value;
			//presetId = 'filter_' + (+new Date());
			//
			//fieldsStr = fieldsIds.length ? fieldsIds.join(',') : '';
			//
			//postData = {
			//	'name': presetName,
			//	'filter_id': presetId,
			//	'filter_rows': fieldsStr,
			//	'fields': fieldsOb || {}
			//};
			//
			//getData = {
			//	'FILTER_ID': this.getParam('FILTER_ID'),
			//	'GRID_ID': this.getParam('GRID_ID'),
			//	'action': 'SET_FILTER'
			//};
			//
			//this.saveOptions(postData, getData);
			//
			//sidebarItem = BX.decl({
			//	block: 'sidebar-item',
			//	text: presetName,
			//	id: presetId
			//});
			//
			//presetsContainer = this.getPreset().getContainer();
			//addPresetField = this.getPreset().getAddPresetField();
			//
			//presetsContainer.insertBefore(sidebarItem, addPresetField);
			//
			//BX.bind(sidebarItem, 'click', BX.delegate(this.getPreset()._onPresetClick, this.getPreset()));
			//
			//if ('PRESETS' in this.params && BX.type.isArray(this.params.PRESETS))
			//{
			//	preparedFields = fieldsIds.map(function(current) {
			//		tmpFilter = this.params.FIELDS.filter(function(fieldItem) {
			//			return fieldItem.NAME === current;
			//		});
			//
			//		if (BX.type.isArray(tmpFilter) && tmpFilter.length)
			//		{
			//			return tmpFilter[0];
			//		}
			//	}, this);
			//
			//	this.params.PRESETS.push({
			//		TITLE: postData.name,
			//		ID: postData.filter_id,
			//		FIELDS: preparedFields
			//	});
			//}
			//
			//this.disableAddPreset();
			//sidebarItem.click();
			//this.getPreset().getAddPresetFieldInput().value = '';
		},

		updatePreset: function()
		{
			var postData, getData, fieldsStr, tmpName, fieldsOb;
			var currentPresetId = this.getPreset().getCurrentPresetId();
			var currentPreset = this.getPreset().getCurrentPresetData();
			var fields = this.getPreset().getFields();
			var fieldsIds = (fields || []).map(function(current) {
				tmpName = BX.data(current, 'name');
				fieldsOb = fieldsOb || {};

				fieldsOb[tmpName] = '';

				return tmpName;
			}, this);

			fieldsStr = fieldsIds.length ? fieldsIds.join(',') : '';

			postData = {
				'name': currentPreset.TITLE,
				'filter_id': currentPresetId,
				'filter_rows': fieldsStr,
				'fields': fieldsOb
			};

			getData = {
				'FILTER_ID': this.getParam('FILTER_ID'),
				'GRID_ID': this.getParam('GRID_ID'),
				'action': 'SET_FILTER'
			};

			this.saveOptions(postData, getData);
		},

		saveOptions: function(postData, getData)
		{
			var url = BX.util.add_url_param(this.getParam('SETTINGS_URL'), getData || {});

			BX.ajax.post(url, postData);
		},

		prepareEvent: function(event)
		{
			var i, x;

			if (!('path' in event) || !event.path.length)
			{
				event.path = [event.target];
				i = 0;

				while ((x = event.path[i++].parentNode) != null)
				{
					event.path.push(x);
				}
			}

			return event;
		},

		_onDocumentClick: function(event)
		{
			var isFilterInsideClick, condition, isInsideFieldsPopupClick;
			var popup = this.getPopup();
			var fieldsPopup = this.getFieldsPopup();

			if (popup && popup.isShown())
			{
				event = this.prepareEvent(event);

				isFilterInsideClick = (event.path || []).some(function(current) {
					condition = false;

					if (BX.type.isDomNode(current))
					{
						condition = (
							BX.hasClass(current, this.settings.classFilterContainer) ||
							BX.hasClass(current, this.settings.classSearchContainer) ||
							BX.hasClass(current, this.settings.classDefaultPopup)
						);
					}

					return condition;
				}, this);

				if (!isFilterInsideClick)
				{
					this.closePopup();
				}
			}

			if (fieldsPopup && fieldsPopup.isShown())
			{
				isInsideFieldsPopupClick = (event.path || []).some(function(current) {
					condition = false;

					if (BX.type.isDomNode(current))
					{
						condition = (
							BX.hasClass(current, this.settings.classFieldListItem) ||
							BX.hasClass(current, this.settings.classPopupFieldList)
						);
					}

					return condition;
				}, this);

				if (!isInsideFieldsPopupClick)
				{
					this.closeFieldListPopup();
				}
			}
		},

		_onAddFieldClick: function(event)
		{
			var popup = this.getFieldsPopup();
			event.stopPropagation();

			if (popup && !popup.isShown())
			{
				this.showFieldsPopup();
			}
			else
			{
				this.closeFieldListPopup();
			}
		},

		getFieldListPopupItems: function()
		{
			var itemText, itemContainer;
			var data = this.getParam('FIELDS');
			var itemsContainer = BX.create('div', {props: {className: this.settings.classPopupFieldList}});

			if (BX.type.isArray(data) && data.length)
			{
				if (data.length < 6)
				{
					BX.addClass(itemsContainer, this.settings.classPopupFieldList1Column);
				}

				if (data.length > 6 && data.length < 12)
				{
					BX.addClass(itemsContainer, this.settings.classPopupFieldList2Column);
				}

				if (data.length > 12)
				{
					BX.addClass(itemsContainer, this.settings.classPopupFieldList3Column);
				}

				data.forEach(function(itemData) {
					itemContainer = BX.create('div', {
						props: {
							className: [this.settings.classMenuItem, this.settings.classFieldListItem].join(' ')
						},
						attrs: {
							'data-item': JSON.stringify(itemData)
						}
					});

					itemText = BX.create('div', {props: {
						className: this.settings.classMenuMultiItemText
					}, text: itemData.PLACEHOLDER});
					BX.append(itemText, itemContainer);
					BX.append(itemContainer, itemsContainer);
					BX.bind(itemContainer, 'click', BX.delegate(this._clickOnFieldListItem, this));
				}, this);
			}

			return itemsContainer;
		},

		_clickOnFieldListItem: function(event)
		{
			var target = event.target;
			var data;

			if (!BX.hasClass(target, this.settings.classFieldListItem))
			{
				target = BX.findParent(target, {class: this.settings.classFieldListItem}, true, false);
			}

			if (BX.type.isDomNode(target))
			{
				try {
					data = JSON.parse(BX.data(target, 'item'));
				} catch (err) {}

				if (BX.hasClass(target, this.settings.classMenuItemChecked))
				{
					BX.removeClass(target, this.settings.classMenuItemChecked);
					this.getPreset().removeField(data);
				}
				else
				{
					if (BX.type.isPlainObject(data))
					{
						this.getPreset().addField(data);
						BX.addClass(target, this.settings.classMenuItemChecked);
					}
				}

				if (!this.isAddPresetEnabled())
				{
					this.updatePreset();
				}
			}
		},

		showFieldsPopup: function()
		{
			var popup = this.getFieldsPopup();
			this.adjustFieldListPopupPosition();
			popup.show();
		},

		closeFieldListPopup: function()
		{
			var popup = this.getFieldsPopup();
			popup.close();
		},

		adjustFieldListPopupPosition: function()
		{
			var popup = this.getFieldsPopup();
			var pos = BX.pos(this.getAddField());
			pos.forceBindPosition = true;
			popup.adjustPosition(pos);
		},

		getFieldsPopup: function()
		{
			var addFiledButton = this.getAddField();

			if (!this.fieldsPopup)
			{
				this.fieldsPopup = new BX.PopupWindow(
					this.getParam('FILTER_ID') + '_fields_popup',
					addFiledButton,
					{
						autoHide : false,
						offsetTop : 4,
						offsetLeft : 0,
						lightShadow : true,
						closeIcon : false,
						closeByEsc : false,
						noAllPaddings: true,
						zIndex: 13
					}
				);

				this.fieldsPopup.setContent(this.getFieldListPopupItems());
			}

			return this.fieldsPopup;
		},

		_onAddPresetClick: function()
		{
			this.enableAddPreset();
		},

		_onSaveButtonClick: function()
		{
			if (this.isEditEnabled() || this.isAddPresetEnabled())
			{
				this.savePreset();
				this.disableEdit();
				this.disableAddPreset();
			}
		},

		_onCancelButtonClick: function()
		{
			this.disableAddPreset();
			this.getPreset().getAddPresetFieldInput().value = '';
			this.disableEdit();
		},

		_onGridReady: function(grid)
		{
			if (!this.grid && grid.getContainerId() === this.getParam('GRID_ID'))
			{
				this.grid = grid;
			}
		},

		_onFilterClick: function(event)
		{
			var Fields = this.getFields();
			var target = event.target;
			var field, control;

			if (Fields.isFieldDelete(target))
			{
				field = Fields.getField(target);
				Fields.deleteField(field);
			}

			if (BX.hasClass(target, this.settings.classValueDelete) ||
				BX.hasClass(target.parentNode, this.settings.classValueDelete))
			{
				field = Fields.getField(target);

				if (BX.type.isDomNode(field))
				{
					control = BX.findChild(field, {class: this.settings.classControl}, true, false);
					if (BX.type.isDomNode(control))
					{
						if (control.tagName === 'INPUT' && control.type === 'text')
						{
							control.value = '';
						}
					}
				}
			}
		},

		getButtonsContainer: function()
		{
			return FilterUtils.getByClass(this.getFilter(), this.settings.classButtonsContainer);
		},

		getSaveButton: function()
		{
			return FilterUtils.getByClass(this.getFilter(), this.settings.classSaveButton);
		},

		getCancelButton: function()
		{
			return FilterUtils.getByClass(this.getFilter(), this.settings.classCancelButton);
		},

		getAddPresetButton: function()
		{
			return FilterUtils.getByClass(this.getFilter(), this.settings.classAddPresetButton);
		},

		isAddPresetEnabled: function()
		{
			return this.isAddPresetModeState;
		},

		enableAddPreset: function()
		{
			var Preset = this.getPreset();
			var addPresetField = Preset.getAddPresetField();
			var addPresetFieldInput = Preset.getAddPresetFieldInput();
			var buttonsContainer = this.getButtonsContainer();

			BX.show(addPresetField);
			BX.show(buttonsContainer);

			if (BX.type.isDomNode(addPresetFieldInput))
			{
				addPresetFieldInput.focus();
			}

			this.isAddPresetModeState = true;
		},

		disableAddPreset: function()
		{
			var Preset = this.getPreset();
			var addPresetField = Preset.getAddPresetField();
			var buttonsContainer = this.getButtonsContainer();
			var presetId = Preset.getCurrentPresetId();

			BX.hide(addPresetField);
			BX.hide(buttonsContainer);

			if (BX.type.isNotEmptyString(presetId))
			{
				Preset.applyPreset(presetId);
			}

			this.isAddPresetModeState = false;
		},

		getControls: function()
		{
			var container = this.getFieldListContainer();
			var controls = null;

			if (BX.type.isDomNode(container))
			{
				controls = BX.findChild(container, {class: this.settings.classControl}, true, true);
			}

			return controls;
		},

		getControlValues: function()
		{
			var controls = this.getControls();
			var values = {};
			var value, name, input, searchInput;

			controls.forEach(function(current) {
				if (!BX.hasClass(current, this.settings.classDateControl))
				{
					if ('value' in current)
					{
						value = current.value;
					}
					else
					{
						value = BX.data(current, 'value');

						try {
							value = JSON.parse(value);
						} catch(err) {}

						if (BX.hasClass(current, this.settings.classSelect))
						{
							value = value.VALUE;
						}
					}

					name = current.getAttribute('name');

					if (!BX.type.isNotEmptyString(name))
					{
						name = BX.data(current, 'name');
					}
				}
				else
				{
					input = BX.findChild(current, {class: this.settings.classDateInput}, true, false);
					name = input.getAttribute('name');
					value = input.value;
				}

				values[name] = value;

			}, this);

			searchInput = this.getSearch().getInput();
			name = searchInput.getAttribute('name');
			value = searchInput.value;

			values[name] = value;

			return values;
		},

		applyFilter: function(isEmpty, isSearchOnlyEmpty)
		{
			var values = this.getControlValues();
			var valuesKeys;

			if (isEmpty && !isSearchOnlyEmpty)
			{
				valuesKeys = Object.keys(values);

				valuesKeys.forEach(function(current) {
					if (current !== 'FIND')
					{
						values[current] = '';
					}
				}, this);
			}

			if (isEmpty && isSearchOnlyEmpty)
			{
				values.FIND = '';
			}

			if (this.grid)
			{
				this.grid.reloadTable('POST', values);
			}

			BX.onCustomEvent(window, 'Filter::apply', [this, values]);
		},

		getAddField: function()
		{
			return FilterUtils.getByClass(this.getFilter(), this.settings.classAddField);
		},

		getAddFieldInput: function()
		{
			return FilterUtils.getByClass(this.getAddField(), this.settings.classAddPresetFieldInput)
		},


		getFieldListContainer: function()
		{
			return FilterUtils.getByClass(this.getFilter(), this.settings.classFileldControlList);
		},

		getFields: function()
		{
			if (!(this.fields instanceof FilterFields))
			{
				this.fields = new FilterFields(this);
			}

			return this.fields;
		},

		getPreset: function()
		{
			if (!(this.presets instanceof FilterPresets))
			{
				this.presets = new FilterPresets(this);
			}

			return this.presets;
		},

		_onSearchContainerClick: function(event)
		{
			var search = this.getSearch();
			var preset, searchValue;

			if (!BX.hasClass(event.target, this.settings.classSquareDelete) &&
				!BX.hasClass(event.target, this.settings.classClearSearchValueButton) &&
				!BX.hasClass(event.target, this.settings.classSearchButton))
			{
				if (!this.getPopup().isShown())
				{
					this.showPopup();
				}
			}
			else
			{
				if (BX.hasClass(event.target, this.settings.classSquareDelete))
				{
					search.removePreset();

					if (this.getPopup())
					{
						this.getPreset().deactivateAllPresets();

						if (!this.isAddPresetEnabled())
						{
							this.getPreset().resetPreset();
						}
					}
					search.getInput().focus();
					this.applyFilter(true);

					if (this.getPopup().isShown())
					{
						this.closePopup();
					}
				}

				if (BX.hasClass(event.target, this.settings.classClearSearchValueButton))
				{
					preset = search.getPreset();
					searchValue = search.getInput().value;

					if (preset || searchValue)
					{
						search.clearForm();
						search.getInput().focus();
						this.getPreset().deactivateAllPresets();
						this.getPreset().resetPreset();

						this.applyFilter(true);
					}

					if (this.getPopup().isShown())
					{
						this.closePopup();
					}
				}

				if (BX.hasClass(event.target, this.settings.classSearchButton))
				{
					preset = search.getPreset();
					searchValue = search.getInput().value;

					if (!preset || !searchValue)
					{
						search.getInput().focus();
					}

					if (this.getPopup().isShown())
					{
						this.closePopup();
					}
				}
			}



		},

		getTemplate: function()
		{
			return BX.html(BX(this.settings.generalTemplateId));
		},

		getTemplateValueLabel: function()
		{
			return BX.html(BX(this.settings.squareTemplateId));
		},


		closePopup: function()
		{
			var popup = this.getPopup();
			var popupContainer = popup.popupContainer;
			var closeDelay;

			BX.removeClass(popupContainer, this.settings.classAnimationShow);
			BX.addClass(popupContainer, this.settings.classAnimationClose);

			closeDelay = parseFloat(BX.style(popupContainer, 'animation-duration'));

			if (BX.type.isNumber(closeDelay))
			{
				closeDelay = closeDelay * 1000;
			}

			setTimeout(function() {
				popup.close();
			}, closeDelay);
		},

		showPopup: function()
		{
			var popup = this.getPopup();
			var self = this;
			var popupContainer;

			if (!popup.isShown())
			{
				popup.show();
				popupContainer = popup.popupContainer;
				BX.removeClass(popupContainer, this.settings.classAnimationClose);
				BX.addClass(popupContainer, self.settings.classAnimationShow);
			}
		},

		getPopup: function()
		{
			if (!(this.popup instanceof BX.PopupWindow))
			{
				this.popup =  new BX.PopupWindow(
					this.getParam('FILTER_ID') + this.settings.searchContainerPostfix,
					this.getSearch().getContainer(),
					{
						autoHide : false,
						offsetTop : 4,
						offsetLeft : 0,
						lightShadow : true,
						closeIcon : false,
						closeByEsc : false,
						noAllPaddings: true,
						zIndex: 12
					}
				);

				this.popup.setContent(this.getTemplate());
				BX.bind(this.getFilter(), 'click', BX.delegate(this._onFilterClick, this));
				BX.bind(this.getAddPresetButton(), 'click', BX.delegate(this._onAddPresetClick, this));
				BX.bind(this.getSaveButton(), 'click', BX.delegate(this._onSaveButtonClick, this));
				BX.bind(this.getCancelButton(), 'click', BX.delegate(this._onCancelButtonClick, this));
				BX.bind(this.getAddField(), 'click', BX.delegate(this._onAddFieldClick, this));
				BX.bind(this.getEditButton(), 'click', BX.delegate(this._onEditButtonClick, this));
				this.getPreset();
			}

			return this.popup;
		},

		_onEditButtonClick: function()
		{
			if (!this.isEditEnabled())
			{
				this.enableEdit();
			}
			else
			{
				this.disableEdit();
			}
		},

		enablePresetsDragAndDrop: function()
		{
			var Preset, presets, dragButton, presetId;

			Preset = this.getPreset();
			presets = Preset.getPresets();
			this.presetsList = [];

			if (BX.type.isArray(presets) && presets.length)
			{
				presets.forEach(function(current) {
					presetId = Preset.getPresetId(current);

					if (!BX.hasClass(current, this.settings.classAddPresetField) && presetId !== 'default_filter')
					{
						dragButton = this.getDragButton(current);
						dragButton.onbxdragstart = BX.delegate(this._onDragStart, this);
						dragButton.onbxdragstop = BX.delegate(this._onDragStop, this);
						dragButton.onbxdrag = BX.delegate(this._onDrag, this);
						jsDD.registerObject(dragButton);
						jsDD.registerDest(dragButton);
						this.presetsList.push(current);
					}
				}, this);
			}
		},

		getDragButton: function(presetNode)
		{
			return BX.findChild(presetNode, {class: this.settings.classPresetDragButton}, true, false);
		},

		disablePresetsDragAndDrop: function()
		{
			if (BX.type.isArray(this.presetsList) && this.presetsList.length)
			{
				this.presetsList.forEach(function(current) {
					if (!BX.hasClass(current, this.settings.classAddPresetField))
					{
						jsDD.unregisterObject(current);
						jsDD.unregisterDest(current);
					}
				}, this);
			}
		},

		_onDragStart: function()
		{
			this.dragItem = this.getPreset().normalizePreset(jsDD.current_node);
			this.dragIndex = FilterUtils.getIndex(this.presetsList, this.dragItem);
			this.dragRect = this.dragItem.getBoundingClientRect();
			this.offset = this.dragRect.height;
			this.dragStartOffset = (jsDD.start_y - (this.dragRect.top + BX.scrollTop(window)));

			FilterUtils.styleForEach(this.list, {'transition': '100ms'});
			BX.addClass(this.dragItem, this.settings.classPresetOndrag);
			BX.bind(document, 'mousemove', BX.delegate(this._onMouseMove, this));
		},

		_onMouseMove: function(event)
		{
			this.realX = event.clientX;
			this.realY = event.clientY;
		},

		getDragOffset: function()
		{
			return (jsDD.x - this.startDragOffset - this.dragRect.left);
		},

		_onDragStop: function()
		{
			var Preset, presets;

			BX.unbind(document, 'mousemove', BX.delegate(this._onMouseMove, this));
			BX.removeClass(this.dragItem, this.settings.classPresetOndrag);

			FilterUtils.styleForEach(this.presetsList, {'transition': '', 'transform': ''});
			FilterUtils.collectionSort(this.dragItem, this.targetItem);

			Preset = this.getPreset();
			presets = Preset.getPresets();
			this.presetsList = [];

			if (BX.type.isArray(presets) && presets.length)
			{
				presets.forEach(function(current) {
					if (!BX.hasClass(current, this.settings.classAddPresetField))
					{
						this.presetsList.push(current);
					}
				}, this);
			}

		},

		_onDrag: function()
		{
			var self = this;
			var currentRect, currentMiddle;

			this.dragOffset = (this.realY - this.dragRect.top - this.dragStartOffset);
			this.sortOffset = self.realY + BX.scrollTop(window);

			FilterUtils.styleForEach([this.dragItem], {
				'transition': '0ms',
				'transform': 'translate3d(0px, '+this.dragOffset+'px, 0px)'
			});

			this.presetsList.forEach(function(current, index) {
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
						BX.style(current, 'transition', '300ms');
					}

					if (index < self.dragIndex && self.sortOffset < currentMiddle &&
						current.style.transform !== 'translate3d(0px, '+(self.offset)+'px, 0px)' &&
						current.style.transform !== '')
					{
						self.targetItem = current;
						BX.style(current, 'transform', 'translate3d(0px, '+(self.offset)+'px, 0px)');
						BX.style(current, 'transition', '300ms');
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
						BX.style(current, 'transition', '300ms');
					}
				}
			});
		},


		enableEdit: function()
		{
			var Preset = this.getPreset();
			var presets = Preset.getPresets();
			var presetId;

			if (BX.type.isArray(presets) && presets.length)
			{
				presets.forEach(function(current) {
					presetId = Preset.getPresetId(current);
					if (!BX.hasClass(current, this.settings.classAddPresetField) && presetId !== 'default_filter')
					{
						BX.addClass(current, this.settings.classPresetEdit);
					}
				}, this);
			}

			this.enablePresetsDragAndDrop();
			BX.show(this.getButtonsContainer());

			this.isEditEnabledState = true;
		},

		disableEdit: function()
		{
			var Preset = this.getPreset();
			var presets = Preset.getPresets();

			if (BX.type.isArray(presets) && presets.length)
			{
				presets.forEach(function(current) {
					if (!BX.hasClass(current, this.settings.classAddPresetField))
					{
						BX.removeClass(current, this.settings.classPresetEdit);
						this.getPreset().disableEditPresetName(current);
					}
				}, this);
			}

			this.disablePresetsDragAndDrop();

			if (!this.isAddPresetEnabled())
			{
				BX.style(this.getButtonsContainer(), 'display', '');
			}

			this.isEditEnabledState = false;
		},

		isEditEnabled: function()
		{
			return this.isEditEnabledState;
		},

		getEditButton: function()
		{
			return FilterUtils.getByClass(this.getFilter(), this.settings.classEditButton);
		},

		getPopupOverlay: function()
		{
			var popup = this.getPopup();

			return popup.overlay.element;
		},

		getParam: function(paramName, defaultValue)
		{
			return this.params[paramName] ? this.params[paramName] : defaultValue;
		},

		getFilter: function()
		{
			return FilterUtils.getByClass(document, this.settings.classFilterContainer);
		},

		getSearch: function()
		{
			if (!(this.search instanceof FilterSearch))
			{
				this.search = new FilterSearch(this);
			}

			return this.search;
		}
	};

	FilterUtils = {
		cache: {},
		styleForEach: function(collection, properties)
		{
			properties = BX.type.isPlainObject(properties) ? properties : null;
			var keys = Object.keys(properties);

			[].forEach.call((collection || []), function(current) {
				keys.forEach(function(propKey) {
					BX.style(current, propKey, properties[propKey]);
				});
			});
		},
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
		closestChilds: function(item)
		{
			if (item) { return item.children || null; }
		},
		getNext: function(currentItem)
		{
			if (currentItem) { return currentItem.nextElementSibling || null; }
		},
		getPrev: function(currentItem)
		{
			if (currentItem) { return currentItem.previousElementSibling || null; }
		},
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
		getIndex: function(collection, item)
		{
			return [].indexOf.call((collection || []), item);
		},
		getByClass: function(node, className, isAll)
		{
			isAll = BX.type.isBoolean(isAll) ? isAll : false;

			if (!BX.type.isDomNode(this.cache[className]))
			{
				this.cache[className] = BX.findChild(node, {class: className}, true, isAll);
			}

			return this.cache[className];
		}
	};
})();


(function() {
	BX.Main.filterManager = {
		data: {},

		push: function(id, instance)
		{
			if (BX.type.isNotEmptyString(id) && instance)
			{
				this.data[id] = instance;
			}
		},

		getById: function(id)
		{
			var result = null;

			if (id in this.data)
			{
				result = this.data[id];
			}

			return result;
		}
	};
})();