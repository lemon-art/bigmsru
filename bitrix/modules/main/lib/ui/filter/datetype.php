<?

namespace Bitrix\Main\UI\Filter;

class DateType
{
	const NONE = "NONE";
	const TODAY = "TODAY";
	const YESTERDAY = "YESTERDAY";
	const THIS_WEEK = "THIS_WEEK";
	const LAST_WEEK = "LAST_WEEK";
	const THIS_MONTH = "THIS_MONTH";
	const LAST_MONTH = "LAST_MONTH";
	const OVER_THE_PAST_PAYS = "OVER_THE_PAST_PAYS";
	const SINGLE = "SINGLE";
	const RANGE = "RANGE";
	const BEFORE = "BEFORE";
	const AFTER = "AFTER";

	public static function getList()
	{
		$reflection = new \ReflectionClass(__CLASS__);
		return $reflection->getConstants();
	}
}