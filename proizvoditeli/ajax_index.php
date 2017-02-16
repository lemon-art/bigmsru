<?require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("iblock");
CModule::IncludeModule("highloadblock");
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$hlblock_id = 2;
$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);

$entity_data_class = $entity->getDataClass();
$entity_table_name = $hlblock['TABLE_NAME'];

$arFilter = array(); //задаете фильтр по вашим полям

$sTableID = 'tbl_'.$entity_table_name;
$rsData = $entity_data_class::getList(array(
	"select" => array('UF_XML_ID', 'UF_NAME', 'UF_FILE'), //выбираем поля
	"filter" => $arFilter,
	"order" => array()
));
$rsData = new CDBResult($rsData, $sTableID);
while($arRes = $rsData->Fetch()){
	$arSelect = Array("ID", "NAME", "PROPERTY_BREND");
	$arFilter2 = Array("IBLOCK_ID"=>12, "ACTIVE"=>"Y", "PROPERTY_BREND"=>$arRes["UF_XML_ID"]);
	$res = CIBlockElement::GetList(array(), $arFilter2, false, array("nPageSize"=>1), $arSelect);
	while($ar_fields = $res->GetNext())
	{
		?>
		<?$file = CFile::ResizeImageGet($arRes["UF_FILE"], array('width'=>148, 'height'=>61), BX_RESIZE_IMAGE_EXACT, true);?>

		<li class="item">
			<a class="logo" href="/proizvoditeli/bytovaya/<?=$arRes["UF_NAME"]?>" style="background-image:url(<?=$file["src"]?>);"></a>
			<div class="title"><a href="/proizvoditeli/bytovaya/<?=$arRes["UF_NAME"]?>"><?echo $arRes["UF_NAME"]?></a></div>
		</li>
		<?
	}
}