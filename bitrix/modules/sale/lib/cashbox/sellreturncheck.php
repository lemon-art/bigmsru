<?php

namespace Bitrix\Sale\Cashbox;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\NotImplementedException;

Loc::loadMessages(__FILE__);

/**
 * Class SellReturnCheck
 * @package Bitrix\Sale\Cashbox
 */
class SellReturnCheck extends SellCheck
{
	/**
	 * @return string
	 */
	public static function getType()
	{
		return 'sellreturn';
	}

	/**
	 * @throws NotImplementedException
	 * @return string
	 */
	public static function getCalculatedSign()
	{
		return static::CALCULATED_SIGN_CONSUMPTION;
	}

	/**
	 * @return string
	 */
	public static function getName()
	{
		return Loc::getMessage('SALE_CASHBOX_SELL_RETURN_NAME');
	}

	/**
	 * @param array $entities
	 * @return array
	 */
	public function extractDataFromEntities(array $entities)
	{
		$result = parent::extractDataFromEntities($entities);

		if (isset($result['PAYMENTS']))
		{
			foreach ($result['PAYMENTS'] as $i => $payment)
				$result['PAYMENTS'][$i]['IS_CASH'] = 'N';

		}

		return $result;
	}
}