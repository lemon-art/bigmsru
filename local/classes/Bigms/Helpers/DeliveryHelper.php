<?
namespace Bigms\Helpers;

use Bitrix\Sale\Location\LocationTable;
use Bitrix\Main\Loader;

class DeliveryHelper
{
    /**
     * ID города Москва
     * @var int
     */
    public static $moscowCityId = 20;

    /**
     * Метод получения массива с ID городов Московской области
     *
     * @return array
     */
    public static function getMoscowRegionLocationCityIds()
    {
        $cityIds = [];
        Loader::includeModule('sale');
		
				$res = LocationTable::getList(array(
					'filter' => array(
						'ID' => 3
					),
					'select' => array('ID', 'LEFT_MARGIN', 'RIGHT_MARGIN')
				));

				if($loc = $res->fetch())
				{
					$leftMargin = $loc['LEFT_MARGIN'];
					$rightMargin = $loc['RIGHT_MARGIN'];
				}
		
		
		
        $dbLocations = LocationTable::getList([
            'filter' => ['TYPE_CODE' => 'CITY', '>LEFT_MARGIN' => $leftMargin, '<RIGHT_MARGIN' => $rightMargin],
            'select' => ['ID', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE'],
        ]);
        while($arLocations = $dbLocations->fetch()) {
            $cityIds[] = $arLocations['ID'];
        }
        return $cityIds;
    }

    /**
     * Метод определяет является ли город Москвой или принадлежит к Московской области
     *
     * @param $id
     * @return bool
     */
    public static function isMoscowRegion($id)
    {
        if ($id == self::$moscowCityId) {
            return true;
        }

        $arMoscowRegionIds = self::getMoscowRegionLocationCityIds();
        if (in_array($id, $arMoscowRegionIds)) {
            return true;
        }

        return false;
    }
}
?>