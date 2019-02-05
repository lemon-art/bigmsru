<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<?if (0 < $arResult["SECTIONS_COUNT"] && $arResult['SECTION']['UF_SHOWSUBCAT'])
{
	?>
	<section class="content__subcat subcat">
		<ul class="subcat__list">
			<?
			$i = 1;
			foreach ($arResult['SECTIONS'] as &$arSection)
			{
				//if($arSection["UF_ACTIVE"] == 3 || $arSection["UF_ACTIVE"] == 4){
					$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
					$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
					
					$class = "";
					/* if ($i % 5 == 0)
					{
						$class = "five";
					} */
					if ($i % 4 == 0)
					{
						$class = "four";
					}
					?>
							<?
							if($arSection["PICTURE"]["SRC"]){
								$img = $arSection["PICTURE"]["SRC"];
							}
							else{
								$img = SITE_TEMPLATE_PATH.'/images/no_photo.png';
							}
							if($arSection["UF_PICTURE"] != "" && $arSection["UF_CUSTOM_URL"] != ""){
								$img = CFile::GetPath($arSection["UF_PICTURE"]);
							}
							?>
					
						<li class="subcat__item" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
							<div class="subcat_img">
								<img src="<?=$img?>" alt="<?=$arSection["NAME"]?>">
							</div>
							<a href="<?=$arSection["SECTION_PAGE_URL"];?>" class="subcat__text"><?=$arSection["NAME"]?></a>
						</li>
					

					<?
					$i++;
				//}
			}
			unset($arSection);
			?>
		</ul>
	</section>
	<?
}
?>
