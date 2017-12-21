<?php
namespace Bitrix\Pull;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Config
{
	public static function get($params = array())
	{
		if (!\CPullOptions::GetQueueServerStatus())
			return false;
		
		$userId = intval($params['USER_ID']);
		if ($userId <= 0)
		{
			global $USER;
			$userId = $USER->GetID();
		}
		if ($userId <= 0)
		{
			return false;
		}
		
		$cache = $params['CACHE'] != 'N';
		$reopen = $params['REOPEN'] != 'N';
		
		$privateChannel = \CPullChannel::Get($userId, $cache, $reopen);
		$sharedChannel = \CPullChannel::GetShared($cache, $reopen);
		
		$domain = defined('BX24_HOST_NAME')? BX24_HOST_NAME: $_SERVER['SERVER_NAME'];
		
		$config['SERVER'] = Array(
			'VERSION' => \CPullOptions::GetQueueServerVersion(),
			'LONG_POLLING' => str_replace('#DOMAIN#', $domain, \CPullOptions::GetListenUrl()).'?CHANNEL_ID=',
			'LONG_POOLING_SECURE' => str_replace('#DOMAIN#', $domain, \CPullOptions::GetListenSecureUrl()).'?CHANNEL_ID=',
			'WEBSOCKET' => str_replace('#DOMAIN#', $domain, \CPullOptions::GetWebSocketUrl()).'?CHANNEL_ID=',
			'WEBSOCKET_SECURE' => str_replace('#DOMAIN#', $domain, \CPullOptions::GetWebSocketSecureUrl()).'?CHANNEL_ID=',
		);
		$config['CHANNEL'] = Array(
			'SHARED' => Array(
				'ID' => \CPullChannel::SignChannel($sharedChannel["CHANNEL_ID"]),
				'START' => $sharedChannel['CHANNEL_DT'],
				'END' => $sharedChannel['CHANNEL_DT']+43205,
			),
			'PRIVATE' => Array(
				'ID' => \CPullChannel::SignChannel($privateChannel["CHANNEL_ID"]),
				'START' => $privateChannel['CHANNEL_DT'],
				'END' => $privateChannel['CHANNEL_DT']+43205,
			)
		);
		
		return $config;
		
	}
}
