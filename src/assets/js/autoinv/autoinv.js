$(function() {

    $(".dropdown").each(function(idx, item) {
		$(item).find(".dropdown-menu li a").on("click", function() {
			var thTxt = $(this).text();
			var thHtml = thTxt + "<span class='pull-right'>▼</span>";
			$(this).closest(".dropdown").find(".btn").html(thHtml);
			$(this).closest(".dropdown").find(".dropdown-menu").slideToggle("fast");
			event.preventDefault();
		});
	});
});
    
function popupOpen(itm) {
	$(itm).show(); 
	var itm; 
    $('html').css({'overflow': 'hidden', 'height': '100%'});
	$(itm).on('scroll touchmove mousewheel', function(event){
		event.preventDefault();
		event.stopPropagation();
		return false;
	});
}


function popupClose(itm) {
    $('html').css({'overflow': 'auto', 'height': '100%'});
    $(itm).hide().off('scroll touchmove mousewheel');
    //console.log('닫기');
}