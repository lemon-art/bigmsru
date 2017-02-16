<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<?if (0 < $arResult["SECTIONS_COUNT"] && $arResult['SECTION']['UF_SHOWSUBCAT'])
{
	?>
	<ul class="list">
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
				<li id="<?=$this->GetEditAreaId($arSection['ID']);?>" class="item <?=$class?>">
					<a href="<?=$arSection["SECTION_PAGE_URL"];//if($arSection["UF_CUSTOM_URL"] != "") { echo $arSection["UF_CUSTOM_URL"]; }else{ echo $arSection["SECTION_PAGE_URL"]; }?>">
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
						<div class="icon" style="background-image:url(<?=$img?>);"></div>
						<span><? echo $arSection["NAME"];?></span>
					</a>
				</li>

				<?
				$i++;
			//}
		}
		unset($arSection);
		?>
		<li class="clear"></li>
	</ul>
	
	<?
}
?>
<?if(!empty($arResult["SECTION"]["DESCRIPTION"])){?>
	<div class="seo_text">
		<?if(!empty($arResult["SECTION"]["PICTURE_SRC"])){?>
			<div class="img">
				<img src="<?=$arResult["SECTION"]["PICTURE_SRC"]?>" alt="" />
			</div>
		<?}?>
		
		<div class="text_block">
			<div class="anons"><?=$arResult["SECTION"]["DESCRIPTION"]?></div>

			<?if(!empty($arResult["SECTION"]["UF_TEXT"])){?>
				<div class="detail"><?=$arResult["SECTION"]["UF_TEXT"]?></div>
				
				<div class="more"><a href="#" title="Читать далее">Читать далее</a></div>
			<?}?>
		</div>
		
		<div class="clear"></div>
	</div>
<?}?>