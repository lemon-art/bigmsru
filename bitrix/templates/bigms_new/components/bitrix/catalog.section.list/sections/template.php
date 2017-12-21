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

$strTitle = "";
?>
<div class="section_list">
	<?
	$TOP_DEPTH = $arResult["SECTION"]["DEPTH_LEVEL"];
	$CURRENT_DEPTH = $TOP_DEPTH;
	
	$i = -1;
	foreach($arResult["SECTIONS"] as $key=>$arSection) {
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
			if($CURRENT_DEPTH < $arSection["DEPTH_LEVEL"])
			{
				echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH),"<ul>";
			}
			elseif($CURRENT_DEPTH == $arSection["DEPTH_LEVEL"])
			{
				echo "</li>";
			}
			else
			{
				while($CURRENT_DEPTH > $arSection["DEPTH_LEVEL"])
				{
					echo "</li>";
					echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</ul>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
					$CURRENT_DEPTH--;
				}
				echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</li>";
			}

			$count = $arParams["COUNT_ELEMENTS"] && $arSection["ELEMENT_CNT"] ? " (".$arSection["ELEMENT_CNT"].")" : "";

			if ($_REQUEST['SECTION_ID']==$arSection['ID'])
			{
				$link = '<b>'.$arSection["NAME"].$count.'</b>';
				$strTitle = $arSection["NAME"];
			}
			else
			{

//				if($arSection["UF_CUSTOM_URL"] != ""){
//					$link = '<a href="'.$arSection["UF_CUSTOM_URL"].'">'.$arSection["NAME"].$count.'</a>';
//				}else{
//					$link = '<a href="'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"].$count.'</a>';
//				}
				$link = '<a href="'.$arSection["SECTION_PAGE_URL"].'">'.$arSection["NAME"].$count.'</a>';
			}

			echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH);


			$icon = '';
			if($arSection["DEPTH_LEVEL"] == 1){
				if($arSection["UF_ICON"] > 0){
					$arFile = CFile::GetFileArray($arSection["UF_ICON"]);
					$icon = 'style="background-image:url('.$arFile['SRC'].');"';

				}
				$i++;
				$k = 0;

				$parent_href = $arSection["SECTION_PAGE_URL"];
			}
			else{
				$k++;
			}

			if($i % 3 == 0){
				echo '<li class="clear"></li>';
			}
			?>

			<?if($i > 8){$hidden_deth0 = "hidden_deth0";}?>

			<?if(!$arParams["SHOW_ALL"]){
				if($k < 10){?>
					<li id="<?=$this->GetEditAreaId($arSection['ID']);?>" class='deth<?=$arSection["DEPTH_LEVEL"]-1?> <?=$hidden_deth0?>'><span class="icon" <?=$icon?>></span><?=$link?>
				<?
				}
				else if($k == 10){
					?><li><a href="<?=$parent_href?>" class="all">все категории</a></li>
					<li id="<?=$this->GetEditAreaId($arSection['ID']);?>" class='deth<?=$arSection["DEPTH_LEVEL"]-1?> <?=$hidden_deth0?> hidden'><span class="icon" <?=$icon?>></span><?=$link?>
				<?
				}
				else{?>
					<li id="<?=$this->GetEditAreaId($arSection['ID']);?>" class='deth<?=$arSection["DEPTH_LEVEL"]-1?> <?=$hidden_deth0?> hidden'><span class="icon" <?=$icon?>></span><?=$link?>
				<?}
			}
			else{
				?>
				<li id="<?=$this->GetEditAreaId($arSection['ID']);?>" class='deth<?=$arSection["DEPTH_LEVEL"]-1?> <?=$hidden_deth0?>'><span class="icon" <?=$icon?>></span><?=$link?>
				<?
			}

			$CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];

	}

	while($CURRENT_DEPTH > $TOP_DEPTH)
	{
		echo "</li>";
		echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</ul>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
		$CURRENT_DEPTH--;
	}
	?>
	<div class="clear"></div>
</div>


<?if($i > 9){?>
	<a href="#" class="link_str"><span><?=GetMessage('CT_BCSL_ALL')?></span></a>
<?}?>
