<?

namespace Bitrix\Main\Grid\Panel\Snippet;

class Onchange
{
	protected $actions;

	public function __construct($actions = array())
	{
		if (!empty($actions) && is_array($actions) && count($actions) > 0)
		{
			$this->actions = $actions;
		}
	}

	public function addAction($action = array())
	{
		$this->actions[] = $action;
	}

	public function toArray()
	{
		return $this->actions;
	}
}