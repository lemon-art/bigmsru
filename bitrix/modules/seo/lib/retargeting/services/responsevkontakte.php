<?

namespace Bitrix\Seo\Retargeting\Services;

use \Bitrix\Main\Error;
use \Bitrix\Main\Web\Json;
use \Bitrix\Seo\Retargeting\Response;


class ResponseVkontakte extends Response
{
	const TYPE_CODE = 'vkontakte';

	public function parse($data)
	{
		$parsed = Json::decode($data);
		if ($parsed['error'])
		{
			$this->addError(new Error($parsed['error']['error_msg'], $parsed['error']['error_code']));
		}

		$result = array();
		if ($parsed['response'])
		{
			$result = $parsed['response'];
		}
		else if(!isset($parsed['error']))
		{
			$result = $parsed;
		}

		$this->setData(is_array($result) ? $result : array($result));
	}
}