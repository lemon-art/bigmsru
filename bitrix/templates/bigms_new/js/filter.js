$(document).ready(function() {

	$('.checkbox-custom').click(function(e) {
		$(this).prev().click();
	});
  
  $('.filter-result__delete').click(function(e) {
        e.preventDefault();
        if ($('.filter-result__list li .filter-result__value').length == 1) {
            filterReset();
            return false;
        }
        if ($(this).hasClass('price') || $(this).hasClass('range')) {
            var newLink = deleteFilterForRange($(this).data('param'));
            location.href = newLink;
        } else {
            deleteFilterUrl($(this).data('param') ,$(this).data('url'));
            //newLink += newLink + '#downtofilter';
            //location.href = newLink;
        }
    });
	
	$('#del_filter').click(function() {
        $('.bx_filter_section input[checked=checked]').trigger('click');
        $('.bx_filter_section input').removeAttr('value');
        $('.filter-result').fadeOut();
        filterReset();
    });
	
	function deleteFilterUrl(param, item) {

		var param2 = param === undefined ? '' : param
    	var item2 = item === undefined ? '' : item;
		
		$.post("/tools/getfilterurl.php",
				   {'shortUrl': location.pathname},
				   function(result){
				   
				   
						if ( result !== "" ){
							var linkArray = result.split('/');
							
						}
						else {
							var linkArray = location.pathname.split('/');
						}
						
						var link = '';
						param2 = param2.toLowerCase();
						if (!isNumeric(item2)) {
							item2 = item2.replace(/\s/ig, '+');
						}
						item2 = encodeURI(item2);
						for (var i = 0; i < linkArray.length; i++) {
							if (linkArray[i].indexOf(param2) != -1 && linkArray[i].indexOf(item2) != -1) {
								linkArray[i] = linkArray[i].replace(item2, '');
								linkArray[i] = linkArray[i].replace(/--or-/,'-').replace(/-or-$/,'');
							}
							if (linkArray[i] != '') {
								link = link + '/' + linkArray[i];
							}
						}
						link += '/#downtofilter';
												
						location.href = link;
				   
				  }
			);

		
	}


    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }
	
	function deleteFilterForRange(param) {

		var param2 = param === undefined ? '' : param;

		var linkArray = location.pathname.split('/');
		var link = '';
		param2 = param2.toLowerCase();
		for (var i = 0; i < linkArray.length; i++) {
			if (linkArray[i].indexOf(param2) == -1 && linkArray[i] != '') {
				link = link + '/' + linkArray[i];
			}
		}
		return link + '/';
	}
	
	function filterReset() {
	
		$.post("/tools/getfilterurl.php",
				   {'shortUrl': location.pathname},
				   function(result){
						if ( result !== "" ){
							var linkArray = result.split('/');
							
						}
						else {
							var linkArray = location.pathname.split('/');
						}
							
						var link = '';
						for (var i = 0; i < linkArray.length; i++) {
							if (linkArray[i] == 'filter') {
								link = link + '/';
								break;
							}
							if (linkArray[i] != '') {
								link = link + '/' + linkArray[i];
							}
						}
						if (link[link.length - 1] !== '/'){
							link += '/';
						}
						location.href = link;
				   
				  }
		);
	
        
    }
  
  
  
});
