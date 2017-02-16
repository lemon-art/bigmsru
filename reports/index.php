<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Форма оценки. Большой мастер - интернет-магазин инженерной и бытовой сантехники");
$APPLICATION->SetPageProperty("title", "Форма оценки");
if(intval($_REQUEST["S"]) < 7){
	$message = "из 10, а значит что-то прошло не гладко. Расскажите нам – что именно вам не понравилось:"; 
	$message_title = "Расскажите нам – что случилось?"; 
}else{
	$message = "из 10. Теперь Вы можете её прокомментировать:"; 
	$message_title = "Спасибо за Вашу оценку."; 
}
CModule::IncludeModule("sale");
$APPLICATION->SetTitle($message_title);
?>
<style>
.star_form_content{
    width: 50%;
	padding: 0 30px;
}
.star_form{
    width: 50%;
}
.star_form_content_text{
    margin-bottom: 20px;
    margin-top: 20px;
}
</style>
<?
if ($arOrder = CSaleOrder::GetByID($_REQUEST["ORDER_ID"]))
{
	$mail = $arOrder["USER_EMAIL"];
	if($arOrder["USER_NAME"] != "")
		$username = $arOrder["USER_NAME"];
	
	$db_vals = CSaleOrderPropsValue::GetList(
		array("SORT" => "ASC"),
		array(
				"ORDER_ID" => $_REQUEST["ORDER_ID"],
				"CODE" => "NAME"
			)
	);
	if ($arVals = $db_vals->Fetch()){
		$PAYER_NAME = $arVals["VALUE"];
	}
}
if($_POST["web_form_submit"]){
	$arEventFields = array(
		"ORDER_ID"	=>	$_REQUEST["ORDER_ID"],
		"USER_MAIL"	=>	$_POST["mail"],
		"COMMENT"	=>	$_POST["comment"],
		"STAR"		=>	intval($_REQUEST["S"])
		);
	CEvent::Send("SEND_STAR", "s1", $arEventFields);
	LocalRedirect(SITE_DIR);
}
?>
<?if($_REQUEST["S"] != "" && intval($_REQUEST["S"]) != ""):?>
	<div class="star_form_content">
		<p class="star_form_content_text">
			<?if($PAYER_NAME || $username):?><?=($PAYER_NAME ? $PAYER_NAME : $username)?>,<?endif;?> Ваша оценка – <?=intval($_REQUEST["S"])?> <?=$message?>
		</p>
		<div class="star_form">
			<form name="SIMPLE_FORM_2" action="" method="POST" enctype="multipart/form-data">
				<div class="field">
					<div>
						<input type="email" class="inputtext" name="mail" required placeholder="Почта для ответа *" value="<?=$mail?>" size="0">
						<input type="text" class="inputtext" style="display:none;" name="order" value="<?=$_REQUEST["ORDER_ID"]?>">						
					</div>
				</div>
				<br>
				<div class="field">
					<div>
						<textarea name="comment" cols="40" rows="5" required placeholder="Ваш комментарий *" class="inputtextarea"></textarea>			
					</div>
				</div>
				<br>
				<div class="">
					<input type="submit" name="web_form_submit" class="send_star" value="Отправить">
				</div>
			</form>
		</div>
		<p class="star_form_content_text">
			Ваш ответ будет рассморен руководителем отдела клиентского сервиса
			и поможет нам стать лучше и не повторять своих ошибок.
		</p>
	</div>
<?else:?>
	<div class="star_form_content">Ошибка загрузки оценки</div>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>