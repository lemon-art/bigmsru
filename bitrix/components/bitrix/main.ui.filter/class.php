<?

use Bitrix\Main\UI\Filter\Type;
use Bitrix\Main\UI\Filter\Field;
use Bitrix\Main\UI\Filter\DateType;
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

Loc::loadMessages(__FILE__);


class CMainUiFilter extends CBitrixComponent
{
	protected $defaultViewSort = 500;
	protected $options;
	protected $gridOptions;


	protected function prepareResult()
	{
		$this->arResult["FILTER_ID"] = $this->arParams["FILTER_ID"];
		$this->arResult["GRID_ID"] = $this->arParams["GRID_ID"];
		$this->arResult["FIELDS"] = $this->prepareFields();
		$this->arResult["PRESETS"] = $this->preparePresets();
		$this->arResult["TARGET_VIEW_ID"] = $this->getViewId();
		$this->arResult["TARGET_VIEW_SORT"] = $this->getViewSort();
		$this->arResult["SETTINGS_URL"] = $this->prepareSettingsUrl();
		$this->arResult["FILTER_ROWS"] = $this->prepareFilterRows();
		$this->arResult["CURRENT_PRESET"] = $this->getDefaultPreset();
	}

	protected function prepareCurrentPreset()
	{
		$options = $this->getOptions()->getOptions();
		$currentFilter = $this->prepareDefaultPreset();

		if (isset($options["filter"]) && !empty($options["filter"]))
		{
			$currentFilter = $options["filter"];
		}

		return $currentFilter;
	}

	protected function prepareFilterRows()
	{
		$resultRows = array();

		if (is_array($this->arParams["FILTER_ROWS"]))
		{
			$sourceRows = $this->arParams["FILTER_ROWS"];

			foreach ($sourceRows as $filedId => $fieldValue)
			{
				$resultRows[] = $this->preparePresetField($filedId, $fieldValue);
			}
		}

		return $resultRows;
	}

	protected function preparePresets()
	{
		if (!is_array($this->arResult["PRESETS"]))
		{
			$defaultPreset = $this->prepareDefaultPreset();
			$sourcePresets = $this->arParams["FILTER_PRESETS"];
			$sourcePresets["default_filter"] = $defaultPreset["default_filter"];

			if (!empty($sourcePresets))
			{
				foreach ($sourcePresets as $presetId => $preset)
				{
					$tmpPreset = array();
					$tmpPreset["TITLE"] = $preset["name"];
					$tmpPreset["ID"] = $presetId;
					$tmpPreset["FIELDS"] = array();

					if (isset($preset["fields"]) && is_array($preset["fields"]))
					{
						foreach ($preset["fields"] as $fieldId => $fieldValue)
						{
							$tmpPreset["FIELDS"][] = $this->preparePresetField($fieldId, $fieldValue);
						}
					}

					$this->arResult["PRESETS"][] = $tmpPreset;
				}
			}
		}

		return $this->arResult["PRESETS"];
	}

	protected function getDefaultPreset()
	{
		$presets = $this->preparePresets();
		$preset = array();

		if (is_array($presets) && !empty($presets))
		{
			foreach ($presets as $presetKey => $currentPreset)
			{
				if ($currentPreset["ID"] === "default_filter")
				{
					$preset = $currentPreset;
				}
			}
		}

		return $preset;
	}

	protected function prepareDefaultPreset()
	{
		return array(
			"default_filter" => array(
				"name" => Loc::getMessage("MAIN_UI_FILTER__DEFAULT_FILTER_NAME"),
				"fields" => $this->arParams["FILTER_ROWS"]
			)
		);
	}


	protected function preparePresetField($fieldId, $fieldValue = "")
	{
		$field = $this->getField($fieldId);
		$field["VALUE"] = !empty($fieldValue) ? $fieldValue : $field["VALUE"];
		return $field;
	}


	protected function getField($name = "")
	{
		$fields = $this->prepareFields();
		$filteredField = array();

		if (is_array($fields) && !empty($fields))
		{
			foreach ($fields as $key => $field)
			{
				if ($field["NAME"] === $name)
				{
					$filteredField = $this->prepareField($field);
					break;
				}
			}
		}

		return $filteredField;
	}

	protected function getDataTypesList()
	{
		if (!isset($this->dateTypesList))
		{
			$this->dateTypesList = DateType::getList();
		}

		return $this->dateTypesList;
	}

	protected function getDateTypesList()
	{
		return DateType::getList();
	}

	protected function prepareField($field = array())
	{
		if ($field["TYPE"] === Type::DATE)
		{
			$subTypes = array();
			$subType = is_array($field["SUB_TYPE"]) ? $field["SUB_TYPE"]["VALUE"] : $field["SUB_TYPE"];
			$dateTypesList = $this->getDateTypesList();

			foreach ($dateTypesList as $key => $type)
			{
				$subTypes[] = array(
					"NAME" => Loc::getMessage("MAIN_UI_FILTER__".$key),
					"VALUE" => $key
				);
			}

			$field["SUB_TYPES"] = $subTypes;
			$field["SUB_TYPE"] = array(
				"NAME" => Loc::getMessage("MAIN_UI_FILTER__".$subType),
				"VALUE" => $subType
			);
		}

		return $field;
	}

	protected function prepareFields()
	{
		if (!is_array($this->arResult["FIELDS"]))
		{
			$fields = array();
			$sourceFields = $this->getSourceFields();

			foreach ($sourceFields as $key => $item)
			{
				$tmpField = array();

				switch ($item["type"])
				{
					case "list" : {
						$items = array();

						foreach ($item["items"] as $selectItemValue => $selectItemText)
						{
							$items[] = array("NAME" => $selectItemText, "VALUE" => $selectItemValue);
						}

						if ($item["params"]["multiple"] !== "Y")
						{
							$tmpField = Field::select($item["id"], $items, array(), $item["name"]);
						}
						else
						{
							$tmpField = Field::multiSelect($item["id"], $items, array(), $item["name"]);
						}

						break;
					}

					case "date" : {
						$tmpField = Field::date($item["id"], DateType::SINGLE, array(), $item["name"]);
						$tmpField = $this->prepareField($tmpField);
						break;
					}

					case "checkbox" : {
						$items = array(
							array("NAME" => Loc::getMessage("MAIN_UI_FILTER__YES"), "VALUE" => "true"),
							array("NAME" => Loc::getMessage("MAIN_UI_FILTER__NO"), "VALUE" => "false"),
						);

						$tmpField = Field::select($item["id"], $items, $items[1], $item["name"]);

						break;
					}


					default : {
						$tmpField = Field::string($item["id"], "", $item["name"]);
						break;
					}
				}

				$fields[] = $tmpField;
			}

			$this->arResult["FIELDS"] = $fields;
		}

		return $this->arResult["FIELDS"];
	}


	protected function getSourceFields()
	{
		$sourceFields = array();

		if (isset($this->arParams["FILTER"]) &&
			!empty($this->arParams["FILTER"]) &&
			is_array($this->arParams["FILTER"]))
		{
			$sourceFields = $this->arParams["FILTER"];
		}
		else if (isset($this->arParams["FILTER_FIELDS"]) &&
				 !empty($this->arParams["FILTER_FIELDS"]) &&
				 is_array($this->arParams["FILTER_FIELDS"]))
		{
			$sourceFields = $this->arParams["FILTER_FIELDS"];
		}

		return $sourceFields;
	}

	protected function getViewId()
	{
		$viewId = "";

		if (isset($this->arParams["RENDER_FILTER_INTO_VIEW"]) &&
			!empty($this->arParams["RENDER_FILTER_INTO_VIEW"]) &&
			is_string($this->arParams["RENDER_FILTER_INTO_VIEW"]))
		{
			$viewId = $this->arParams["RENDER_FILTER_INTO_VIEW"];
		}

		return $viewId;
	}

	protected function getViewSort()
	{
		$viewSort = $this->defaultViewSort;

		if (isset($this->arParams["RENDER_FILTER_INTO_VIEW_SORT"]) &&
			!empty($this->arParams["RENDER_FILTER_INTO_VIEW_SORT"]))
		{
			$viewSort = (int) $this->arParams["RENDER_FILTER_INTO_VIEW_SORT"];
		}

		return $viewSort;
	}

	protected function getGridId()
	{
		return $this->arParams["GRID_ID"];
	}

	protected function getFilterId()
	{
		return $this->arParams["FILTER_ID"];
	}

	protected function getPresets()
	{
		return is_array($this->arParams["FILTER_PRESETS"]) ? $this->arParams["FILTER_PRESETS"] : array();
	}


	protected function getGridOptions()
	{
		if (!($this->gridOptions instanceof \Bitrix\Main\Grid\Options))
		{
			$gridId = $this->getGridId();

			if (!empty($gridId) && is_string($gridId))
			{
				$presets = $this->getPresets();
				$this->gridOptions = new \Bitrix\Main\Grid\Options($gridId, $presets);
			}
		}

		return $this->gridOptions;
	}


	protected function getOptions()
	{
		if (!($this->options instanceof \Bitrix\Main\UI\Filter\Options))
		{
			$filterId = $this->getFilterId();
			$this->options = null;

			if (!empty($filterId) && is_string($filterId))
			{
				$this->options = new \Bitrix\Main\UI\Filter\Options($filterId);
			}
		}

		return $this->options;
	}

	protected function prepareOptions()
	{
		$options = $this->getOptions();
		$filterOptions = $options->getOptions();

		if (empty($filterOptions["filters"]))
		{
			$gridOptions = $this->getGridOptions();

			if ($gridOptions instanceof \Bitrix\Main\Grid\Options)
			{
				$gridOptions = $gridOptions->GetOptions();
				$gridFilters = $gridOptions["filters"];

				if (is_array($gridFilters) && !empty($gridFilters))
				{
					$options->setFilters($gridFilters);
					$options->save();
				}
			}

			$presets = $this->getPresets();

			if (!empty($presets) && is_array($presets))
			{
				$options->setFilters($presets);
				$options->save();
			}
		}
	}

	protected function prepareOptionsPresets($presets)
	{
		$resultPresets = array();

		if (!empty($presets))
		{
			foreach ($presets as $presetId => $preset)
			{
				$tmpPreset = $preset;
				$fields = explode(",", $preset["filter_rows"]);

				foreach ($fields as $fieldKey => $field)
				{
					$fieldValue = $tmpPreset[$field];

					$preset["fields"][$field] = !empty($fieldValue) ? $fieldValue : "";
				}

				$resultPresets[$presetId] = $preset;
			}
		}

		return $resultPresets;
	}

	protected function applyOptions()
	{
		$options = $this->getOptions();
		$filterOptions = $options->getOptions();
		$filterPresets = $filterOptions["filters"];

		if (!empty($filterPresets))
		{
			$this->arParams["FILTER_PRESETS"] = $this->prepareOptionsPresets($filterPresets);
		}
	}


	protected function prepareSettingsUrl()
	{
		$path = $this->getPath();
		return join("/", array($path, "settings.ajax.php"));
	}


	protected function checkRequiredParams()
	{
		$errors = new \Bitrix\Main\ErrorCollection();

		if (!isset($this->arParams["FILTER_ID"]) ||
			empty($this->arParams["FILTER_ID"]) ||
			!is_string($this->arParams["FILTER_ID"]))
		{
			$errors->add(array(new \Bitrix\Main\Error(Loc::getMessage("MAIN_UI_FILTER__FILTER_ID_NOT_SET"))));
		}

		foreach ($errors->toArray() as $key => $error)
		{
			ShowError($error);
		}

		return $errors->count() === 0;
	}


	public function executeComponent()
	{
		if ($this->checkRequiredParams())
		{
			$this->prepareOptions();
			$this->applyOptions();
			$this->prepareResult();
			$this->includeComponentTemplate();
		}
	}
}