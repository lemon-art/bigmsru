<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>



	<?foreach($arResult as $kk=>$arItem):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
		
			<li class="side-nav__icon-item icon_<?=$arItem["ICON"]?>">
              <a href="#">
                <span class="side-nav__icon-img"></span>
              </a>
            </li>
		<?endif;?>
		
	<?endforeach?>


