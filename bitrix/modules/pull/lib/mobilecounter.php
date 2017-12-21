<?php
namespace Bitrix\Pull;

class MobileCounter
{
	public static function getTypes()
	{
		$types = Array();
		
		$event = new \Bitrix\Main\Event("pull", "onGetMobileCounterTypes");
		$event->send();
		
		foreach ($event->getResults() as $eventResult)
		{
			if ($eventResult->getType() != \Bitrix\Main\EventResult::SUCCESS)
			{
				continue;
			}
			
			$result = $eventResult->getParameters();
			if (!is_array($types))
			{
				continue;
			}
				
			foreach ($result as $type => $config)
			{
				$config['TYPE'] = $eventResult->getModuleId().'_'.$type;
				$types[$eventResult->getModuleId().'_'.$type] = $config;
			}
		}
		
		return $types;
	}
	
	public static function get($userId)
	{
		$counter = 0;
		
		$userId = intval($userId);
		if ($userId <= 0)
		{
			return $counter;
		}
		
		$siteId = \Bitrix\Main\Context::getCurrent()->getSite();
		if (!$siteId)
		{
			$siteId = 's1';
		}
		
		$event = new \Bitrix\Main\Event("pull", "onGetMobileCounter", array(
			'USER_ID' => $userId,
			'SITE_ID' => $siteId
		));
		$event->send();
		
		$typeStatus = self::getUserConfig($userId);
		
		foreach ($event->getResults() as $eventResult)
		{
			if ($eventResult->getType() != \Bitrix\Main\EventResult::SUCCESS)
			{
				continue;
			}
			
			$result = $eventResult->getParameters();
			
			$type = $eventResult->getModuleId().'_'.$result['TYPE'];
			if ($typeStatus[$type] === false)
			{
				continue;
			}
			
			if (intval($result['COUNTER']) > 0)
			{
				$counter += $result['COUNTER'];
			}
		}
		
		return $counter;
	}
	
	public static function getUserConfig($userId)
	{
		$userId = intval($userId);
		
		$types = Array();
		
		foreach (self::getTypes() as $type => $config)
		{
			$types[$type] = $config['DEFAULT'];
		}
		
		$options = \CUserOptions::GetOption('pull', 'mobileCounterType', Array(), $userId);
		foreach ($options as $type => $default)
		{
			$types[$type] = $default;
		}
		
		return $types;
	}
	
	public static function setUserConfig($userId, $config)
	{
		$userId = intval($userId);
		if ($userId <= 0)
		{
			return false;
		}
		
		$types = self::getUserConfig($userId);
		
		foreach ($config as $type => $status)
		{
			if (!isset($types[$type]))
			{
				continue;
			}
			$types[$type] = (bool)$status;
		}
		
		\CUserOptions::SetOption('pull', 'mobileCounterType', $types, $userId);
		
		return true;
	}
}