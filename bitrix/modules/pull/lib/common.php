<?php
namespace Bitrix\Pull;

class Common
{
	public static function jsonEncode($param)
	{
		$option = null;
		if (version_compare(phpversion(), '5.4') >= 0)
		{
			$option = JSON_UNESCAPED_UNICODE;
		}
		
		return \Bitrix\Main\Web\Json::encode($param, $option);
	}
}
