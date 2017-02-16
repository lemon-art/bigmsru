<?

namespace Bitrix\Main\UI\Filter;

/**
 * Class Options
 * To work with filter user options
 * @package Bitrix\Main\UI\Filter
 */
class Options
{
	private $optionCategory = "main.ui.filter";

	protected $options;
	protected $presets;
	protected $filterId;


	/**
	 * Options constructor.
	 *
	 * @param $filterId $arParams["FILTER_ID"]
	 */
	public function __construct($filterId)
	{
		$this->filterId = $filterId;
		$this->prepareOptions();
	}


	/**
	 * Gets filter id
	 * @return mixed
	 */
	public function getFilterId()
	{
		return $this->filterId;
	}


	protected function getOptionCategory()
	{
		return $this->optionCategory;
	}

	protected function prepareOptions()
	{
		$currentOptions = $this->getOptions();

		if (!is_array($currentOptions))
		{
			$this->options = array(
				"filters" => array()
			);

			$this->save();
		}
	}

	protected function setOptions($options)
	{
		if (is_array($options))
		{
			$this->options = $options;
		}
	}

	public function setFilters($filters = array())
	{
		if (!empty($filters))
		{
			$options = $this->getOptions();

			if (empty($options["filters"]))
			{
				$this->options["filters"] = $filters;
			}
			else
			{
				foreach ($filters as $key => $filter)
				{
					$tmpFilter = $filter;
					unset($tmpFilter["filter_id"]);
					$this->options["filters"][$filter["filter_id"]] = $tmpFilter;
				}
			}
		}
	}

	public function getOptions()
	{
		if (!is_array($this->options))
		{
			$optionCategory = $this->getOptionCategory();
			$optionName = $this->getFilterId();

			$options = \CUserOptions::getOption($optionCategory, $optionName);

			$this->options = $options;
		}

		return $this->options;
	}

	public function save()
	{
		$optionCategory = $this->getOptionCategory();
		$optionName = $this->getFilterId();
		$options = $this->getOptions();

		\CUserOptions::setOption($optionCategory, $optionName, $options);
	}
}