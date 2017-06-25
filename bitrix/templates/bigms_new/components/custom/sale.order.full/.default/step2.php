<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?
$arCitys = Array();
$arFirstCity = Array();
$res = \Bitrix\Sale\Location\LocationTable::getList(array(
    'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'TYPE_CODE' => 'CITY'),
    'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE'),
	'order' => array(
        'NAME.NAME' => 'asc'
    )
));
while($item = $res->fetch())
{
	if ($item["ID"] == 20 ){
		$arFirstCity[0] = $item;
	}
	elseif($item["ID"] == 32 ){
		$arFirstCity[1] = $item;
	}
	else{
		$arCitys[] = $item;
	}
	
}
$arCitys = array_merge($arFirstCity, $arCitys);
?>


	
                        <div data-step="2" class="form__container form-city">
                          <strong class="form__title">Выберите ваш город</strong>
                          <div class="form-city__subtitle">Ваш город - <a href="#" class="form-city__link" data-city="">выберите город</a>

							<div class="form-city__popup city-popup">
                              <div class="form__row form__row_search">
                                <input class="form__input city-search" type="text" name="search" value="">
                              </div>
                              <ul id="cities" class="city-popup__list">
								<?foreach ( $arCitys as $arCity ):?>
									<li class="city-popup__item" data-city="<?=$arCity["ID"]?>"><a href="#"><?=$arCity["NAME_RU"]?></a></li>
								<?endforeach;?>
                                
                              
                              </ul>
                            </div>
                          </div>
                          <p class="form__text">От города зависят возможные<br>способы оплаты и доставки</p>
                        </div>
                 			  

