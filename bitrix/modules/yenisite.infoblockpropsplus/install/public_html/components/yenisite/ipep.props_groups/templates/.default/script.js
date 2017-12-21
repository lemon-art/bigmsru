$(function () {
    if (typeof Tipped == "object") {
        Tipped.create('.yeni_ipep_prop_with_comment_box', {skin: 'white', radius: 5});
    }
    else if (typeof(jQuery) != 'undefined' && typeof(jQuery('').tooltip) == 'function') {
        $(".yeni_ipep_prop_with_comment_box").tooltip({
            position: {
                my: "center bottom-5",
                at: "center top",
            }
        });
    }
});
