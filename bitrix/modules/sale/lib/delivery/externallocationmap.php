<?
namespace Bitrix\Sale\Delivery;

use Bitrix\Sale\Result;
use Bitrix\Main\Text\Encoding;
use Bitrix\Main\SystemException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Sale\Location\ExternalTable;
use Bitrix\Sale\Location\LocationTable;
use Bitrix\Sale\Location\ExternalServiceTable;

class ExternalLocationMap
{
	//Dlivery idtifyer, stored in \Bitrix\Sale\Location\ExternalServiceTable : CODE
	const EXTERNAL_SERVICE_CODE = '';
	//Path to file (if exist) were we can get prepared locations map
	const CSV_FILE_PATH = '';
	const CITY_NAME_IDX = 0;
	const REGION_NAME_IDX = 1;
	const CITY_XML_ID_IDX = 2;

	/**
	 * Abstract.
	 * Must return in Result->data all locations from external delivery service.
	 * @return Result.
	 * @throws SystemException
	 */
	protected static function getAllLocations()
	{
		throw new SystemException('Must be impemented!');
	}

	/**
	 * Abstract.
	 * Return location Id.
	 * @param string $cityName
	 * @param string $regionName
	 * @return int Location Id.
	 * @throws SystemException
	 */
	protected static function getLocationIdByNames($cityName, $regionName)
	{
		throw new SystemException('Must be impemented!');
	}

	/**
	 * Returns internal location id
	 * @param string $externalCode
	 * @return int
	 * @throws \Bitrix\Main\ArgumentException
	 */
	public static function getInternalId($externalCode)
	{
		if(strlen($externalCode) <= 0)
			return 0;

		$srvId = static::getExternalServiceId();

		if($srvId <= 0)
			return 0;

		$res = ExternalTable::getList(array(
			'filter' => array(
				'=XML_ID' => $externalCode,
				'=SERVICE_ID' => $srvId
			)
		));

		if($loc = $res->fetch())
			return $loc['ID'];

		return 0;
	}

	/**
	 * Returns external location id
	 * @param int $locationId
	 * @return int|string
	 * @throws \Bitrix\Main\ArgumentException
	 */
	public static function getExternalId($locationId)
	{
		if(strlen($locationId) <= 0)
			return '';

		$srvId = static::getExternalServiceId();

		if($srvId <= 0)
			return 0;

		$res = LocationTable::getList(array(
			'filter' => array(
				array(
					'LOGIC' => 'OR',
					'=CODE' => $locationId,
					'=ID' => $locationId
				),
				'=EXTERNAL.SERVICE_ID' => $srvId
			),
			'select' => array(
				'ID', 'CODE',
				'XML_ID' => 'EXTERNAL.XML_ID'
			)
		));

		if($loc = $res->fetch())
			return $loc['XML_ID'];

		return '';
	}

	/**
	 * Returns external location city id
	 * @param int $locationId
	 * @return int|string
	 * @throws \Bitrix\Main\ArgumentException
	 */
	public static function getCityId($locationId)
	{
		if(strlen($locationId) <= 0)
			return 0;

		$res = LocationTable::getList(array(
			'filter' => array(
				array(
					'LOGIC' => 'OR',
					'=CODE' => $locationId,
					'=ID' => $locationId,
				),
				array(
					'=TYPE.CODE' => 'CITY',
					'=PARENTS.TYPE.CODE' => 'CITY'
				),
			),
			'select' => array(
				'ID', 'CODE',
				'TYPE_CODE' => 'TYPE.CODE',
				'PID' => 'PARENTS.ID',
			)
		));

		if($loc = $res->fetch())
		{
			return $loc['PID'];
		}

		return 0;
	}


	/**
	 * Install locations map.
	 * @return Result
	 */
	public static function install()
	{
		$result = new Result();

		if(static::isInstalled())
			return $result;

		$imported = static::importFromCsv($_SERVER['DOCUMENT_ROOT'].static::CSV_FILE_PATH);

		if(intval($imported) <= 0)
			$result = static::refresh();

		return $result;
	}

	/**
	 * Uninstall locations map.
	 * @return Result
	 * @throws \Exception
	 */
	public static function unInstall()
	{
		$result = new Result();

		if(!static::isInstalled())
			return $result;

		$con = \Bitrix\Main\Application::getConnection();
		$sqlHelper = $con->getSqlHelper();
		$srvId = $sqlHelper->forSql(static::getExternalServiceId());
		$con->queryExecute("DELETE FROM b_sale_loc_ext WHERE SERVICE_ID=".$srvId);
		ExternalServiceTable::delete($srvId);
		return $result;
	}

	/**
	 * Check locations map was sat.
	 * @return bool
	 * @throws \Bitrix\Main\ArgumentException
	 */
	public static function isInstalled()
	{
		static $result = null;

		if($result === null)
		{
			$result = false;
			$res = ExternalServiceTable::getList(array(
					'filter' => array('=CODE' => static::EXTERNAL_SERVICE_CODE)
			));

			if($res->fetch())
				$result = true;
		}

		return $result;
	}

	/**
	 * Refresh locations map.
	 * @return Result
	 * @throws ArgumentNullException
	 */
	public static function refresh()
	{
		set_time_limit(0);
		$result = new Result();
		$res = static::getAllLocations();

		if($res->isSuccess())
		{
			$locations = $res->getData();

			if(is_array($locations) && !empty($locations))
			{
				$res = static::setMap($locations);

				if(!$res->isSuccess())
					$result->addErrors($res->getErrors());
			}
		}
		else
		{
			$result->addErrors($res->getErrors());
		}

		return new Result();
	}

	/**
	 * Import locations map from csv file to database.
	 * @param string $path
	 * @return bool|int Quantity of mapped locations.
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Exception
	 */
	public static function importFromCsv($path)
	{
		$imported  = 0;
		set_time_limit(0);
		$content = file_get_contents($path);

		if($content === false)
			return false;

		$lines = explode("\n", $content);

		if(!is_array($lines))
			return false;

		$srvId = static::getExternalServiceId();

		if($srvId <= 0)
			return false;

		$existXmlId = array();

		$res = ExternalTable::getList(array(
			'filter' => array(
				'SERVICE_ID' => $srvId,
			)
		));

		while($et = $res->fetch())
			$existXmlId[] = $et['XML_ID'];

		foreach($lines as $line)
		{
			$codes = explode(';', $line);

			if(in_array($codes[1], $existXmlId))
				continue;

			if(!is_array($codes) || count($codes) != 2)
				continue;

			$res = LocationTable::getList(array(
					'filter' => array('=CODE' => $codes[0]),
					'select' => array('ID')
			));

			if(!$loc = $res->fetch())
				continue;

			$res = ExternalTable::add(array(
					'SERVICE_ID' => $srvId,
					'LOCATION_ID' => $loc['ID'],
					'XML_ID' => $codes[1]
			));

			if($res->isSuccess())
				$imported++;
		}

		return $imported;
	}

	/**
	 * Export locations map from database to file, csv format.
	 * @param string $path
	 * @return bool|int
	 * @throws \Bitrix\Main\ArgumentException
	 */
	public static function exportToCsv($path)
	{
		set_time_limit(0);
		$srvId = static::getExternalServiceId();

		if($srvId <= 0)
			return false;

		$res = LocationTable::getList(array(
				'filter' => array(
						'=EXTERNAL.SERVICE_ID' => $srvId
				),
				'select' => array(
						'CODE',
						'XML_ID' => 'EXTERNAL.XML_ID'
				)
		));

		$content = '';

		while($row = $res->fetch())
			if(strlen($row['CODE']) > 0)
				$content .= $row['CODE'].";".$row['XML_ID']."\n";

		return file_put_contents($path, $content);
	}

	/**
	 * If exist returns id, if not exist create it
	 * @return int External service Id
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Exception
	 */
	protected static function getExternalServiceId()
	{
		if(strlen(static::EXTERNAL_SERVICE_CODE) <=0)
			throw new SystemException('EXTERNAL_SERVICE_CODE must be defined!');

		static $result = null;

		if($result !== null)
			return $result;

		$res = ExternalServiceTable::getList(array(
			'filter' => array('=CODE' => static::EXTERNAL_SERVICE_CODE)
		));

		if($srv = $res->fetch())
		{
			$result = $srv['ID'];
			return $result;
		}

		$res = ExternalServiceTable::add(array('CODE' => static::EXTERNAL_SERVICE_CODE));

		if(!$res->isSuccess())
		{
			$result = 0;
			return $result;
		}

		$result =  $res->getId();
		return $result;
	}

	/**
	 * Decodes data from utf8 if we need
	 * @param $str
	 * @return bool|string
	 */
	protected static function utfDecode($str)
	{
		if(strtolower(SITE_CHARSET) != 'utf-8')
			$str = Encoding::convertEncoding($str, 'UTF-8', SITE_CHARSET);

		return $str;
	}

	/**
	 * Convert find location by city and region names and add mapping to base
	 * @param array $cities
	 * @return Result
	 * @throws ArgumentNullException
	 * @throws \Bitrix\Main\ArgumentException
	 * @throws \Exception
	 */
	protected static function setMap(array $cities)
	{
		$result = new Result();

		if(empty($cities))
			throw new ArgumentNullException('cities');

		$xmlIdExist = array();
		$locationIdExist = array();
		$xmlIds = array_keys($cities);
		$srvId = static::getExternalServiceId();

		$res = ExternalTable::getList(array(
				'filter' => array(
						'=SERVICE_ID' => $srvId
				)
		));

		while($map = $res->fetch())
		{
			$xmlIdExist[] = $map['XML_ID'];
			$locationIdExist[] = $map['LOCATION_ID'];

			//we already have this location
			if(in_array($map['XML_ID'], $xmlIds))
				unset($cities[$map['XML_ID']]);
		}

		//nothing to import
		if(empty($cities))
			return $result;

		foreach($cities as $city)
		{
			$xmlId = $city[self::CITY_XML_ID_IDX];
			$locId = static::getLocationIdByNames($city[static::CITY_NAME_IDX], $city[static::REGION_NAME_IDX]);

			if(intval($locId) > 0 && !in_array($xmlId, $xmlIdExist) && !in_array($locId, $locationIdExist))
			{
				ExternalTable::add(array(
						'SERVICE_ID' => $srvId,
						'LOCATION_ID' => $locId,
						'XML_ID' => $xmlId
				));

				$xmlIdExist[] = $xmlId;
				$locationIdExist[] = $locId;
			}

			unset($cities[$xmlId]);
		}

		return $result;
	}
}