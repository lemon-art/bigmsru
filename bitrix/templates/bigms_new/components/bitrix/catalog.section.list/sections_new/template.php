<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

    <section class="content-categories">
        <ul class="content-categories__list">
		
			<?$i=1;?>
			<?$lastLevel = 0;?>
			<?foreach ($arResult['SECTIONS'] as &$arSection):?>
					
					<?if ($i == 1 ):?>
						<li class="content-categories__row">
					<?endif;?>
					
					<?if ( $arSection["DEPTH_LEVEL"] == 1 ):?>
					
						<?if ( $arSection["DEPTH_LEVEL"] <= $lastLevel):?>
									</ul>
								<?if ( $levelCount > 5 ):?>
									<a href="#" class="content-categories__more">Смотреть</a>
								<?endif;?>
							  </div>
							</div>
						<?endif;?>
						<?$lastLevel = $arSection["DEPTH_LEVEL"];?>
						
						<?$levelCount = 0;?>
						<?$i++;?>
						
						<?if ( $i == 3 ){ $i = 1;}?>
						<div class="content-categories__item">
						  <div class="content-categories__img-wrap">
						  	<?
							if( $arSection["PICTURE"]["SRC"] ){
								$img = $arSection["PICTURE"]["SRC"];
							}
							else{
								$img = '/bitrix/templates/bigms/images/logo_bw.png';
							}
							if($arSection["UF_PICTURE"] != "" && $arSection["UF_CUSTOM_URL"] != ""){
								$img = CFile::GetPath($arSection["UF_PICTURE"]);
							}
							?>
							<img src="<?=$img?>" alt="<?=$arSection["NAME"]?>">

						  </div>
						  <div class="content-categories__text">
							<h2 class="content-categories__title"><?=$arSection["NAME"]?></h2>
							<ul class="content-categories__inner-list">
					
					<?else:?>
						<?$lastLevel = $arSection["DEPTH_LEVEL"];?>
						<?$levelCount++;?>
						<li class="content-categories__inner-item">
							<a href="<?=$arSection["SECTION_PAGE_URL"];?>" class="content-categories__inner-link"><?=$arSection["NAME"]?></a>
						</li>
					<?endif;?>
							
					
					

					<?
			endforeach;
			unset($arSection);
			?>
		</ul>
	</section>

