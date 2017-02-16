<?

namespace Bitrix\Main\UI\Filter;

class Actions
{
	const SET_FILTER = "SET_FILTER";

	public static function getList()
	{
		$reflection = new \ReflectionClass(__CLASS__);
		return $reflection->getConstants();
	}
}