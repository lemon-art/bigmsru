<?php

namespace Bitrix\Sale\PaySystem;

use Bitrix\Sale\Payment;

interface ICheckable
{
	public function check(Payment $payment);
}
