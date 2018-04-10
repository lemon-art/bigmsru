<?php
// @codingStandardsIgnoreStart
/**
 * @return string
 */
function _getSiteId() {
    $dbSites = CSite::GetList($by = 'sort', $order = 'desc');
    while ($arSite = $dbSites->Fetch()) {
        if ($arSite['DEF'] !== 'Y') {
            continue;
        }
        return $arSite['LID'];
    }
    return false;
}

/**
 * @param string $name
 * @param string $phone
 * @param string $email
 * @return bool|int
 */
function _addUser($name, $phone, $email) {
    if ($email === null || $email === '') {
        $email = time() . '@client-mail.com';
    }
    $randomCode = GetRandomCode();
	$CUser = new CUser();
    return $CUser->Add(array(
        "LOGIN" => $name . " [{$randomCode}]",
        "NAME" => $name,
        "EMAIL" => $email,
        "PERSONAL_MOBILE" => $phone,
        "PASSWORD" => $randomCode,
        "CONFIRM_PASSWORD" => $randomCode,
        "ACTIVE" => "Y",
    ));
}

/**
 * @param string $siteId
 * @param string $currencyCode
 * @param int $userId
 * @param string $commentText
 * @return int
 */
function _addOrder($siteId, $currencyCode, $userId, $commentText) {
	$CSaleOrder = new CSaleOrder();
    $orderId = $CSaleOrder->Add(array(
        "LID" => $siteId,
        "PERSON_TYPE_ID" => 1,
        "USER_ID" => $userId,
        "PAYED" => "N",
        "CURRENCY" => $currencyCode,
        "USER_DESCRIPTION" => $commentText,
    ));

    return $orderId;
}

/**
 * @param string $phone
 * @param string $email
 * @return bool|string
 */
function _getUserIdByContacts($phone, $email) {
    foreach (array('PERSONAL_MOBILE' => $phone, 'EMAIL' => $email) as $fieldCode => $fieldValue) {
        if (strlen($fieldValue) < 4) {
            continue;
        }
        $filter = array(
            $fieldCode => $fieldValue,
        );
        $result = CUser::GetList($by = "id", $order = "desc", $filter)->Fetch();
        if (is_array($result) && array_key_exists('ID', $result)) {
            return $result['ID'];
        }
    }
    return false;
}

$currencyId = COption::GetOptionString("sale", "default_currency", false);
$siteId = _getSiteId();

if ($siteId === false) {
    exit('DEFAULT SITE IS NOT FOUND');
}
if ($currencyId === false) {
    exit('DEFAULT CURRENCY IS NOT FOUND');
}


$requestData = $_REQUEST;
foreach ($requestData as $key => $value) {
    $requestData[$key] = iconv('UTF-8', SITE_CHARSET, $value);
}

$title   = $requestData['title'];
$comment = $requestData['text'];
$name    = $requestData['name'];
$phone   = $requestData['phone'];
$email   = $requestData['email'];

$userId = _getUserIdByContacts($phone, $email);
if (!$userId) {
    $userId = _addUser($name, $phone, $email);
}
$orderId = _addOrder($siteId, $currencyId, $userId, $comment);

if (!is_int($orderId)) {
    echo json_encode(array('status' => 'error'));
} else {
    echo json_encode(array('status' => 'ok', 'order_id' => $orderId));
}
// @codingStandardsIgnoreEnd
