<?
namespace Bitrix\Sale\Delivery\Packing;

class Packer
{
	/**
	 * Returns Dimensions of space filled by boxes
	 * @param array $boxesSizes
	 * @return array
	 */
	public static function countMinContainerSize(array $boxesSizes)
	{
		$container = new Container();

		foreach($boxesSizes as $box)
			$container->addBox($box);
			
		return $container->getFilledDimensions();
	}
}
