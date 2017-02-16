<?require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
if (isset($_GET['IBLOCK_ID'])){
    $iblock_id = intval($_GET['IBLOCK_ID']);
    echo count($_SESSION['CATALOG_COMPARE_LIST'][$iblock_id]['ITEMS']);
}
