<?php

namespace Bitrix\Sale\Internals;

use Bitrix\Main;
use Bitrix\Sale;

class Events
{
	/**
	 * @internal
	 * @param Main\Event $event
	 *
	 * @return Main\EventResult
	 */
	public static function onSaleBasketItemEntitySaved(Main\Event $event)
	{
		\CBitrixComponent::includeComponentClass("bitrix:sale.basket.basket.line");
		$component = new \SaleBasketLineComponent();
		$component->onIncludeComponentLang();
		return $component->onSaleBasketItemEntitySaved($event);
	}

	/**
	 * @internal
	 * @param Main\Event $event
	 *
	 * @return Main\EventResult
	 */
	public static function onSaleBasketItemDeleted(Main\Event $event)
	{
		\CBitrixComponent::includeComponentClass("bitrix:sale.basket.basket.line");
		$component = new \SaleBasketLineComponent();
		$component->onIncludeComponentLang();
		return $component->onSaleBasketItemDeleted($event);
	}
}