<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");

echo '<div class="left_text">';
?>

<p>В личном кабинете Вы можете проверить текущее состояние корзины, ход выполнения Ваших заказов, просмотреть или изменить личную информацию.</p>

<?
echo '</div>';

$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/personal_menu.php",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);

echo '<div class="clear"></div>';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>