<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>

<?
if (0 < $arResult["SECTIONS_COUNT"])
{
	?>
	<ul class="list">
		<?
		$intCurrentDepth = 1;
		$boolFirst = true;
		
		foreach ($arResult['SECTIONS'] as &$arSection)
		{
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
			
			if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL'])
			{
				if (0 < $intCurrentDepth)
					echo "\n",str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']),'<ul class="hidden">';
			}
			elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL'])
			{
				if (!$boolFirst)
					echo '</li>';
			}
			else
			{
				while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL'])
				{
					echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
					$intCurrentDepth--;
				}
				echo str_repeat("\t", $intCurrentDepth-1),'</li>';
			}

			echo (!$boolFirst ? "\n" : ''),str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
			?>
			
			<li id="<?=$this->GetEditAreaId($arSection['ID']);?>" class="item">
				<a href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><span><? echo $arSection["NAME"];?></span></a>
				
				<?
				$intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
				$boolFirst = false;
				?>

				<?
		}
		unset($arSection);
		while ($intCurrentDepth > 1)
		{
			echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
			$intCurrentDepth--;
		}
		if ($intCurrentDepth > 0)
		{
			echo '</li>',"\n";
		}
		?>
	</ul>
	<?
}
?>