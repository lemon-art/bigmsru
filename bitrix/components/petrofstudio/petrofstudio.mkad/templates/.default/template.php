<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<script id="sidebarTemplate" type="text/x-jquery-tmpl">
	{{if results.value2 == '0'}}
			<div class="big-tarif big-distance"><?=str_replace("#MAX_DISTANCE#",$arParams['MAX_DISTANCE'],GetMessage("BIG_DISTANCE"));?></div>
	{{else}}
		{{if results.value == '0'}}
			<div class="big-tarif big-distance-17"><?=GetMessage("V_PREDELAH_MKAD");?></div>
		{{else}}
			<div class="big-tarif big-distance-17"><?=GetMessage("ZA_MKAD");?></div>
			<div class="descr-distance big-distance"><?=GetMessage("DISTANCE_FROM_MKAD");?></div>
			<div>
				<b class="no-mrg">${results.distance}</b> <?=GetMessage("KM");?>
			</div>
		{{/if}}
			{{if results.value3 == '0'}}
			<div class="descr-distance big-distance"><?=GetMessage("DELIVERY_COST");?></div>
			<div class="radius-block">
				<?if($arParams['SUMMA_ZAKAZ_TARIF']!=''):?><?=GetMessage("ZAKAZ_MENEE");?> <?=$arParams['COST_FREE_DELIVERY']?> <?=GetMessage("RUBLEI");?>: <br /><?endif;?>
				<b>{{if results.value == '0'}}<?=GetMessage("FREE_COST");?>{{else}}${results.value} <?=GetMessage("RUBLEI");?>{{/if}}</b><br />
				<?=GetMessage("FORMULA");?> <?=$arParams['ADDITIONAL_TARIF']?> <?=GetMessage("RUBLEI");?> + <?=$arParams['COST_BY_KM']?> <?=GetMessage("RUB_KM");?>
			</div>
			<?if($arParams['SUMMA_ZAKAZ_TARIF']!=''):?>
			<div class="radius-block">
				<?=GetMessage("ZAKAZ_BOLEE");?> <?=$arParams['COST_FREE_DELIVERY']?> <?=GetMessage("RUBLEI");?>: <br />
				<b>{{if results.value == '0'}}<?=GetMessage("FREE_COST");?>{{else}}${results.value2} <?=GetMessage("RUBLEI");?>{{/if}}</b><br />
				<?=GetMessage("FORMULA");?> <?=$arParams['COST_BY_KM']?> <?=GetMessage("RUB_KM");?>
			</div>
			<?endif;?>
			{{else}}
			<div class="descr-distance big-distance"><?=GetMessage("DELIVERY_COST");?></div>
			<div class="radius-block">
				<?=GetMessage("ZAKAZ_BOLEE");?> <?=$arParams['COST_FREE_DELIVERY']?> <?=GetMessage("RUBLEI");?>: <br /><b>{{if results.value == '0'}}<?=GetMessage("FREE_COST");?>{{else}}${results.value} <?=GetMessage("RUBLEI");?>{{/if}}</b>
			</div>
			<div class="radius-block">
				<?=GetMessage("ZAKAZ_MENEE");?> <?=$arParams['COST_FREE_DELIVERY']?> <?=GetMessage("RUBLEI");?>: <br /><b>${results.value3} <?=GetMessage("RUBLEI");?></b>
			</div>
			{{/if}}
			<div class="descr-distance big-distance"><?=GetMessage("DELIVERY_TIME");?></div>
			<div class="no-mrg-no-bold">
				<?=$arParams['BLIZ_VREMYA_DOSTAVKI']?>
			</div>
	{{/if}}
</script>

<div class="hero-unit">
	<div class="container-fluid">
        <div class="row-fluid">
            <div id="YMapsID" class="span8"></div>
            <div id="sidebar2" class="span4">
				<div><b class="no-mrg-no-bold"><?=GetMessage("POISK_ADRESS");?></b></div>
				<input type="hidden" id="tmp_hid" name="tmp_hid" value="0"/>
				<div id="sidebar3"></div>					
			</div>
        </div>
    </div>
</div>
<div style="clear:both;"></div>