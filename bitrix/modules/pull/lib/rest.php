<?php
namespace Bitrix\Pull;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;

if(!\Bitrix\Main\Loader::includeModule('rest'))
	return;

Loc::loadMessages(__FILE__);

class Rest extends \IRestService
{
	public static function onRestServiceBuildDescription()
	{
		return array(
			'pull' => array(
				'pull.watch.extend' =>  array('callback' => array(__CLASS__, 'watchExtend'), 'options' => array()),
			),
			'pull_channel' => array(
				'pull.config.get' =>  array('callback' => array(__CLASS__, 'configGet'), 'options' => array()),
			),
			'mobile' => Array(
				'mobile.counter.types.get' => array('callback' => array(__CLASS__, 'counterTypesGet'), 'options' => array()),
				'mobile.counter.get' => array('callback' => array(__CLASS__, 'counterGet'), 'options' => array()),
				'mobile.counter.config.get' => array('callback' => array(__CLASS__, 'counterConfigGet'), 'options' => array()),
				'mobile.counter.config.set' => array('callback' => array(__CLASS__, 'counterConfigSet'), 'options' => array()),
			)
		);
	}
	

	public static function configGet($params, $n, \CRestServer $server)
	{
		$params = array_change_key_case($params, CASE_UPPER);
		
		if (!method_exists('CRestServer', 'getAuthType'))
		{
			throw new \Bitrix\Rest\RestException("Please install rest 17.5.0 for use this method.", "NEED_UPDATE", \CRestServer::STATUS_INTERNAL);
		}
		
		if (!in_array($server->getAuthType(), Array(
			\Bitrix\Rest\SessionAuth\Auth::AUTH_TYPE,
			\Bitrix\Rest\APAuth\Auth::AUTH_TYPE
		)))
		{
			throw new \Bitrix\Rest\RestException("Get access to Push & Pull config available only for session or webhook authorization.", "AUTH_TYPE", \CRestServer::STATUS_FORBIDDEN); 
		}
		
		$configParams = Array();
		$configParams['CACHE'] = $params['CACHE'] != 'N';
		$configParams['REOPEN'] = $params['REOPEN'] != 'N';
		
		$config = \Bitrix\Pull\Config::get($configParams);
		if (!$config)
		{
			throw new \Bitrix\Rest\RestException("Push & Pull server is not configured", "SERVER_ERROR", \CRestServer::STATUS_INTERNAL);
		}
		
		$result['server'] = array_change_key_case($config['SERVER'], CASE_LOWER);
		
		foreach ($config['CHANNEL'] as $type => $config)
		{
			$type = strtolower($type);
			$result['channel'][$type] = array_change_key_case($config, CASE_LOWER);
			$result['channel'][$type]['type'] = $type;
			$result['channel'][$type]['start'] = date('c', $config['START']);
			$result['channel'][$type]['end'] = date('c', $config['END']);
		}
		
		return $result;
	}
	
	public static function watchExtend($params, $n, \CRestServer $server)
	{
		$params = array_change_key_case($params, CASE_UPPER);
		
		if(is_string($params['TAGS']))
		{
			$params['TAGS'] = \CUtil::JsObjectToPhp($params['TAGS']);
		}
		
		global $USER;
		$userId = $USER->GetID();
		
		$result = Array();
		foreach ($params['TAGS'] as $tag)
		{
			$result[$tag] = \CPullWatch::Extend($userId, $tag);
		}
		
		return $result;
	}
	
	public static function counterTypesGet($params, $n, \CRestServer $server)
	{
		$types = \Bitrix\Pull\MobileCounter::getTypes();
		
		$result = Array();
		foreach ($types as $type)
		{
			$result[] = array_change_key_case($type, CASE_LOWER);
		}
		
		return $result;
	}
	
	public static function counterGet($params, $n, \CRestServer $server)
	{
		global $USER;
		
		return \Bitrix\Pull\MobileCounter::get($USER->GetID());
	}
	
	public static function counterConfigGet($params, $n, \CRestServer $server)
	{
		global $USER;
		
		$result = Array();
		$config = \Bitrix\Pull\MobileCounter::getUserConfig($USER->GetID());
		foreach ($config as $type => $value)
		{
			$result[] = Array(
				'type' => $type,
				'value' => $value,
			);
		}
		
		return $result;
	}
	
	public static function counterConfigSet($params, $n, \CRestServer $server)
	{
		$params = array_change_key_case($params, CASE_UPPER);
		
		if(is_string($params['CONFIG']))
		{
			$params['CONFIG'] = \CUtil::JsObjectToPhp($params['CONFIG']);
		}
		
		if (!is_array($params['CONFIG']) || empty($params['CONFIG']))
		{
			throw new \Bitrix\Rest\RestException("New config is not specified", "CONFIG_ERROR", \CRestServer::STATUS_WRONG_REQUEST);
		}
		
		global $USER;
		\Bitrix\Pull\MobileCounter::setUserConfig($USER->GetID(), $params['CONFIG']);
			 
		return true;	
	}
}
