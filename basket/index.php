<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");

if(!empty($_GET["ORDER_ID"])){
	LocalRedirect("/personal/order/make/?ORDER_ID=".$_GET["ORDER_ID"]);
}
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket",
	"cart", 
	Array(
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "Y",	// Рассчитывать скидку для каждой позиции (на все количество товара)
		"COLUMNS_LIST" => array(	// Выводимые колонки
			0 => "NAME",
			1 => "PROPS",
			2 => "DELETE",
			3 => "QUANTITY",
			4 => "PRICE",
			5 => "DISCOUNT",
			6 => "SUM",
		),
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"PATH_TO_ORDER" => "/personal/order/make/",	// Страница оформления заказа
		"HIDE_COUPON" => "Y",	// Спрятать поле ввода купона
		"QUANTITY_FLOAT" => "N",	// Использовать дробное значение количества
		"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"AJAX_OPTION_ADDITIONAL" => "",
		"OFFERS_PROPS" => array(
			0 => "SIZES_SHOES",
			1 => "SIZES_CLOTHES",
			2 => "COLOR_REF",
		),
		"COMPONENT_TEMPLATE" => ".default",
		"USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
		"ACTION_VARIABLE" => "action",	// Название переменной действия
	),
	false
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>