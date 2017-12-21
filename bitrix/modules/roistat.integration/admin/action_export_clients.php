<?php

global $DB;
$modifiedDate = isset($_GET['date']) ? (int)$_GET['date'] : time() - 31 * 24 * 60 * 60;

$sql = "SELECT
          ID,
          TIMESTAMP_X,
          NAME,
          LAST_NAME,
          SECOND_NAME,
          EMAIL,
          DATE_REGISTER,
          PERSONAL_PHONE,
          PERSONAL_FAX,
          PERSONAL_MOBILE,
          PERSONAL_BIRTHDAY,
          WORK_PHONE,
          WORK_FAX,
          WORK_COMPANY
        FROM
          b_user
        WHERE
          TIMESTAMP_X >= FROM_UNIXTIME({$modifiedDate})
        OR
          DATE_REGISTER >= FROM_UNIXTIME({$modifiedDate})";

$arUsers = $DB->Query($sql, false, 'Roistat: export clients ' . __LINE__);

/**
 * @param string $phone
 * @return string
 */
function _stripNotNumericSymbols($phone)
{
    $normalizedPhone = preg_replace('#[^\d]#', '', $phone);
    return $normalizedPhone ?: null;
}

/**
 * [
 *     'CLIENT_ID' => 'USER_ID',
 * ]
 *
 * @param array $usersIds
 * @return array
 */
function _loadShopClientsByUsersIds(array $usersIds)
{
    static $result;
    if ($result === null)
    {
        $result = array();
        $dbClients = CSaleOrderUserProps::GetList(
            array('DATE_UPDATE' => 'DESC'),
            array('USER_ID' => $usersIds)
        );
        while ($arClient = $dbClients->Fetch())
        {
            $userId = $arClient['USER_ID'];
            $clientId = $arClient['ID'];
            $result[$clientId] = $userId;
        }
    }
    return $result;
}

/**
 * @param array $usersIds
 * @return array
 */
function _loadShopContactsDataByUserIds(array $usersIds)
{
    $result = array();
    $userIdByClientId = _loadShopClientsByUsersIds($usersIds);
    $clientsIds = array_keys($userIdByClientId);

    $dbPropertiesValues = CSaleOrderUserPropsValue::GetList(($b='SORT'), ($o='ASC'), Array('USER_PROPS_ID' => $clientsIds));
    while ($arPropertyValues = $dbPropertiesValues->Fetch())
    {
        $clientId = $arPropertyValues['USER_PROPS_ID'];
        $value = $arPropertyValues['VALUE'];
        if (!array_key_exists($clientId, $userIdByClientId))
        {
            continue;
        }

        $userId = $userIdByClientId[$clientId];
        $propertyCode = strtoupper($arPropertyValues['CODE']);

        if (!in_array($propertyCode, array('PHONE', 'EMAIL')))
        {
            continue;
        }
        if (!array_key_exists($userId, $result))
        {
            $result[$userId] = array();
        }
        if (!array_key_exists($propertyCode, $result[$userId]))
        {
            $result[$userId][$propertyCode] = array();
        }
        if ($propertyCode === 'PHONE')
        {
            $value = _stripNotNumericSymbols($value);
        }
        $result[$userId][$propertyCode][] = $value;
    }
    return $result;
}

/**
 * @param string $stringWithValues
 * @param string $userId
 * @param string $propertyCode
 * @param array $contactsData
 * @return string
 */
function _addContactsValuesFromShopClients($stringWithValues, $userId, $propertyCode, array $contactsData)
{
    $result = $stringWithValues;
    if (!array_key_exists($userId, $contactsData) || !array_key_exists($propertyCode, $contactsData[$userId]))
    {
        return $result;
    }
    foreach ($contactsData[$userId][$propertyCode] as $contactValue)
    {
        if (strpos($result, $contactValue) !== false)
        {
            continue;
        }
        if (strlen($result) !== 0 && substr($result, -1) !== ',')
        {
            $result .= ',';
        }
        $result .= $contactValue;
    }
    return $result;
}

/**
 * @param array $userData
 * @param array $allowedFields
 * @param string $delimiter
 * @return string
 */
function _extractContactFields(array $userData, array $allowedFields, $delimiter = ', ')
{
    $result = array();
    foreach ($userData as $fieldName => $fieldValue)
    {
        if (!in_array($fieldName, $allowedFields) || strlen($fieldValue) === 0)
        {
            continue;
        }
        $result[] = $fieldValue;
    }
    return implode($delimiter, $result);
}

$usersIds = array();
$response = array();
while ($arUser = $arUsers->Fetch())
{
    $phonesFields = array(
        'PERSONAL_PHONE',
        'PERSONAL_FAX',
        'PERSONAL_MOBILE',
        'WORK_PHONE',
        'WORK_FAX',
    );
    $nameFields = array(
        'NAME',
        'LAST_NAME',
        'SECOND_NAME',
    );
    $usersIds[] = $arUser['ID'];
    $userData = array(
        'id'         => $arUser['ID'],
        'name'       => _extractContactFields($arUser, $nameFields, ' '),
        'phone'      => _extractContactFields($arUser, $phonesFields),
        'email'      => $arUser['EMAIL'],
        'company'    => $arUser['WORK_COMPANY'],
        'birth_date' => $arUser['PERSONAL_BIRTHDAY'],
    );
    $response[] = $userData;
}

// @todo :: temporarily
$shopContactsData = _loadShopContactsDataByUserIds($usersIds);
foreach ($response as $index => $userData)
{
    $userId = $userData['id'];
    $phones = $response[$index]['phone'];
    $emails = $response[$index]['email'];
    $response[$index]['phone'] = _addContactsValuesFromShopClients($phones, $userId, 'PHONE', $shopContactsData);
    $response[$index]['email'] = _addContactsValuesFromShopClients($emails, $userId, 'EMAIL', $shopContactsData);
}

echo json_encode(array('clients' => $response));