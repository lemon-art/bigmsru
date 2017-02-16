<?

namespace Bitrix\Main\UI\Filter;

class Field
{
	public static function string($name, $defaultValue = "", $placeholder = "")
	{
		$field = array(
			"ID" => uniqid("field_"),
			"TYPE" => Type::STRING,
			"NAME" => $name,
			"VALUE" => $defaultValue,
			"PLACEHOLDER" => $placeholder
		);

		return $field;
	}

	public static function date($name, $type = DateType::SINGLE, $values = array(), $placeholder = "")
	{
		$selectParams = array("isMulti" => false);

		$field = array(
			"ID" => uniqid("field_"),
			"TYPE" => Type::DATE,
			"NAME" => $name,
			"SUB_TYPE" => $type,
			"VALUES" => $values,
			"PLACEHOLDER" => $placeholder,
			"SELECT_PARAMS" => $selectParams
		);

		return $field;
	}

	public static function select($name, $items, Array $defaultValue = array(), $placeholder = "")
	{
		if (empty($defaultValue) && count($items))
		{
			$defaultValue["NAME"] = $items[0]["NAME"];
			$defaultValue["VALUE"] = $items[0]["VALUE"];
		}

		$field = array(
			"ID" => uniqid("field_"),
			"TYPE" => Type::SELECT,
			"NAME" => $name,
			"VALUE" => $defaultValue,
			"PLACEHOLDER" => $placeholder,
			"ITEMS" => $items,
			"PARAMS" => array("isMulti" => false)
		);

		return $field;
	}

	public static function multiSelect($name, $items, $defaultValues = array(), $placeholder = "")
	{
		$field = array(
			"ID" => uniqid("field_"),
			"TYPE" => Type::MULTI_SELECT,
			"NAME" => $name,
			"VALUE" => $defaultValues,
			"PLACEHOLDER" => $placeholder,
			"ITEMS" => $items,
			"PARAMS" => array("isMulti" => true)
		);

		return $field;
	}
}