$(function () {

	$('#show_more_groups').click(function(){
		$('.more_groups').show();
		$('.short_groups').hide();
		return false;
	});
	
	$('#hide_more_groups').click(function(){
		$('.more_groups').hide();
		$('.short_groups').show();
		
	});


    if (typeof Tipped == "object") {
        Tipped.create('.yeni_ipep_prop_with_comment_box', {skin: 'white', radius: 5});
    }
    else if (typeof(jQuery) != 'undefined' && typeof(jQuery('').tooltip) == 'function') {

		
		$(".yeni_ipep_prop_with_comment_box").tooltip({
          content: function () {
              return $(this).prop('title');
          },
		  position: {
                my: "center bottom-5",
                at: "center top",
            }
      });
    }
});
