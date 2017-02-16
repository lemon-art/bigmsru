<?
// ќтмечаем товары, добавленные ы отложенные и в сравнение
$rsBasket = CSaleBasket::GetList(	array( "NAME" => "ASC", "ID" => "ASC"   ),
									array(  "FUSER_ID" => CSaleBasket::GetBasketUserID(),  "LID" => SITE_ID, "ORDER_ID" => "NULL", "SUBSCRIBE" => "N" ),
									false, false, array("ID", "PRODUCT_ID", "QUANTITY", "DELAY") ); 
while( $arBasket = $rsBasket->GetNext() )
{
	if( $arBasket["DELAY"] == "Y" ){ $delay_items[] = $arBasket["PRODUCT_ID"];}
	else{$basket_items[] = $arBasket["PRODUCT_ID"];}
}
global $compare_items;	
?>
<script>
	$(document).ready(function(){
		<?
		if(count($delay_items) > 0){
			foreach($delay_items as $item_id ){?>
				$('a.share_button[data-id="<?=$item_id?>"]').addClass('active');
				$('a.share_button[data-id="<?=$item_id?>"]').removeAttr('onclick');
				
				$('.catalog_block a.share_button[data-id="<?=$item_id?>"]').replaceWith("<p class='share_button active' data-text='В закладках'></p>");

				$('.catalog_detail a.share_button[data-id="<?=$item_id?>"], .catalog_list a.share_button[data-id="<?=$item_id?>"]').replaceWith("<p class='share_button active'><span>В закладках</span></p>");
			<?
			}
		}?>
		
		<?
		if(count($compare_items) > 0){
			foreach($compare_items as $item_id ){?>
				$('a.compare_button[data-id="<?=$item_id?>"]').addClass('active');
				$('a.compare_button[data-id="<?=$item_id?>"]').removeAttr('onclick');
				
				$('.catalog_block a.compare_button[data-id="<?=$item_id?>"]').replaceWith("<p class='compare_button active' data-text='В сравнении'></p>");

				$('.catalog_detail a.compare_button[data-id="<?=$item_id?>"], .catalog_list a.compare_button[data-id="<?=$item_id?>"]').replaceWith("<p class='compare_button active'><span>В сравнении</span></p>");
			<?
			}
		}
		?>
	})
</script>