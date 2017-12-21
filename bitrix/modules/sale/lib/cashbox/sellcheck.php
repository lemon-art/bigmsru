<?php

namespace Bitrix\Sale\Cashbox;

use Bitrix\Main;
use Bitrix\Sale\Payment;
use Bitrix\Sale\PaySystem;
use Bitrix\Sale\Result;
use Bitrix\Sale\Shipment;
use Bitrix\Sale\ShipmentItem;

Main\Localization\Loc::loadMessages(__FILE__);

/**
 * Class SellCheck
 * @package Bitrix\Sale\Cashbox
 */
class SellCheck extends Check
{
	/**
	 * @return string
	 */
	public static function getType()
	{
		return 'sell';
	}

	/**
	 * @throws Main\NotImplementedException
	 * @return string
	 */
	public static function getCalculatedSign()
	{
		return static::CALCULATED_SIGN_INCOME;
	}

	/**
	 * @return string
	 */
	public static function getName()
	{
		return Main\Localization\Loc::getMessage('SALE_CASHBOX_SELL_NAME');
	}
	
	/**
	 * @return array
	 */
	public function getDataForCheck()
	{
		$result = array(
			'type' => static::getType(),
			'unique_id' => $this->getField('ID'),
			'items' => array(),
			'date_create' => new Main\Type\DateTime()
		);

		$order = null;
		$entities = $this->getEntities();

		if ($entities)
		{
			$entitiesData = $this->extractDataFromEntities($entities);

			foreach ($entitiesData['PAYMENTS'] as $payment)
			{
				$result['payments'][] = array(
					'is_cash' => $payment['IS_CASH'],
					'sum' => $payment['SUM']
				);
			}

			if (isset($entitiesData['PRODUCTS']))
			{
				foreach ($entitiesData['PRODUCTS'] as $product)
				{
					$item = array(
						'name' => $product['NAME'],
						'base_price' => $product['BASE_PRICE'],
						'price' => $product['PRICE'],
						'sum' => $product['SUM'],
						'quantity' => $product['QUANTITY'],
						'vat' => $product['VAT']
					);

					if ($product['DISCOUNT'])
					{
						$item['discount'] = array(
							'discount' => $product['DISCOUNT']['PRICE'],
							'discount_type' => $product['DISCOUNT']['TYPE'],
						);
					}

					$result['items'][] = $item;
				}
			}

			if (isset($entitiesData['DELIVERY']))
			{
				foreach ($entitiesData['DELIVERY'] as $delivery)
				{
					$item = array(
						'name' => $delivery['NAME'],
						'base_price' => $delivery['BASE_PRICE'],
						'price' => $delivery['PRICE'],
						'sum' => $delivery['SUM'],
						'quantity' => $delivery['QUANTITY'],
						'vat' => $delivery['VAT']
					);

					if ($delivery['DISCOUNT'])
					{
						$item['discount'] = array(
							'discount' => $delivery['DISCOUNT']['PRICE'],
							'discount_type' => $delivery['DISCOUNT']['TYPE'],
						);
					}

					$result['items'][] = $item;
				}
			}

			if (isset($entitiesData['BUYER']))
			{
				if (isset($entitiesData['BUYER']['EMAIL']))
					$result['client_email'] = $entitiesData['BUYER']['EMAIL'];

				if (isset($entitiesData['BUYER']['PHONE']))
					$result['client_phone'] = $entitiesData['BUYER']['PHONE'];
			}

			$result['total_sum'] = $entitiesData['TOTAL_SUM'];
		}

		return $result;
	}

	/**
	 * @return Result
	 */
	public function validate()
	{
		$result = new Result();

		$data = $this->extractDataFromEntities($this->getEntities());

		if (!isset($data['PRODUCTS']))
		{
			$result->addError(new Main\Error(Main\Localization\Loc::getMessage('SALE_CASHBOX_SELL_ERROR_NO_PRODUCTS')));
			return $result;
		}

		if (!$this->isCorrectSum($data))
		{
			$result->addError(new Main\Error(Main\Localization\Loc::getMessage('SALE_CASHBOX_SELL_ERROR_CHECK_SUM')));
			return $result;
		}

		return $result;
	}

	/**
	 * @param $data
	 * @return bool
	 */
	private function isCorrectSum($data)
	{
		$eps = 0.00001;

		$productSum = 0;
		foreach ($data['PRODUCTS'] as $item)
			$productSum += $item['SUM'];

		if (isset($data['DELIVERY']))
		{
			foreach ($data['DELIVERY'] as $delivery)
				$productSum += $delivery['PRICE'];
		}

		$paymentSum = 0;
		foreach ($data['PAYMENTS'] as $payment)
		{
			$paymentSum += $payment['SUM'];
		}

		return abs($productSum - $paymentSum) < $eps;
	}

}