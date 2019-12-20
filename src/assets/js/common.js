$(function() {
    
    /*함수실행*/
    //popupCen();
    hdFn();
    
    /*모바일 바 클릭시 모바일 네비게이션 등장*/
    $(".header .nav-tab").on("click", function() {
        $("#mlnb-wrap").addClass("on");
    });
    /*모바일 네비게이션 닫기 버튼*/
    $("#mlnb-wrap .cls-btn").on("click", function() {
        $("#mlnb-wrap").removeClass("on");
    });
    /* 드롭다운 */
    $(".dropdown").on("click", ".btn", function() {
        $(this).next().slideToggle("fast");
    });
    /*텝박스 기능*/
    $(".tab-box li").on("click", function() {
        var thIdx = $(this).index();
        $(this).closest("ul").find("li").removeClass("on");
        $(this).closest("ul").find("li").eq(thIdx).addClass("on");
        $(this).closest("ul").next().find("li").removeClass("on");
        $(this).closest("ul").next().find("li").eq(thIdx).addClass("on");
    });
  

	$(window).resize(function(){
        var winW = $(window).width();
        
        /* 툴팁 */
        if (winW <= 768) {
            $(".btn-tooltip").on("click", function() {
             $(".tooltip-detail").fadeIn();
            });

            $(".tooltip-detail").on("click", function() {
                $(".tooltip-detail").fadeOut();
            });
        }else{
            $(".btn-tooltip").hover(function(){
                $(".tooltip-detail").fadeIn();
            }, function(){
                $(".tooltip-detail").fadeOut();
            });
        }
        
	}).resize();
    
    //팝업 닫기
    $('.pop-close').on('click', function(){
        popupOff('.pop-com');
    });
});

// 상단 배너 높이 
function hdFn() {
    $(function() {
        var hd = $("#header"),
            el = hd.children(),
            ht_total = 0;
        el.each(function() {
            ht_total += $(this).outerHeight();
        });
        hd.height(ht_total);
    });
}

/* 팝업 오픈  */
function popupOn(openitem){
    var oitm = $(openitem);
    
    oitm.show();
    
    $('html').css({'overflow': 'hidden', 'height': '100%'});
    
    popupCen(oitm);
}

/* 팝업 고정해제 */
function popupOff(closeitem){
    var citm = $(closeitem);
    
    citm.hide();
    $('html').css({'overflow': 'auto', 'height': '100%'});

    citm.off('scroll touchmove mousewheel');
    
}

/* 팝업 가운데 정렬 */
function popupCen(itm){
    var winW2 = $(window).width();
    var popWrap = itm.find('.pop-wrap');
    var popCen = popWrap.width();
    var popMid = popWrap.height();

    if (winW2 <= 768) {
        popWrap.css({'margin-top':'-'+(popMid/2)+'px'});
    }else{
        popWrap.css({'margin-left':'-'+(popCen/2)+'px'});
    }
}

//# 자동투자 금액선택
function auto_price(pri) {
	$('input[name="at_price"]').val(pri);
}


//# 자동투자 인증문자 회신여부 체크
function at_tid_chk(tid) {	
	var tid_timer = setInterval(function() {
		$.ajax({
			type	:	"POST",
			data	:	{"mode":"SAofVzdCAUAoFQ==","tid":tid},
			url		:	"/inc/state.php",
			success	:	function(data) {
				if(data == "Y") {
					clearInterval(tid_timer);
					location.reload();
				}
			}
		});
	}, 1000);
}

//# 자동투자 신청
function auto_ask(n) {
	var at_chk = $('input[name="autopay_chk"]');

	// 1: 신규신청 / 2: 연장하기
	if(n == 1) {
		if(at_chk.is(":checked") !== true) {
			alert("자동투자 이용동의에 체크해주세요.");
			return;
		}
		var at_price = $('input[name="at_price"]').val();
	} else {
		var at_price = $('input[name="at_price2"]').val();
	}

	if(at_price < 1) {
		alert("상품별 투자금액을 선택해주세요.");
		return;
	}

	$.ajax({
		type	:	"POST",
		data	:	{"price":at_price},
		url		:	"/member/auto/autopay.php",
		success	:	function(data) {
			var ret = data.split("^");

			if(ret[0] == "FAIL") {
				alert(ret[1]);
			} else {
				at_tid_chk(ret[1]);
				$('#autopay_pop').css('display','block');
			}
		}
	});
}

//# 자동투자 해지
function auto_cancel() {
	$.ajax({
		type	:	"POST",
		url		:	"/member/auto/autopay_cancel.php",
		success	:	function(data) {
			if(data == "FAIL") {
				alert("해지에 실패하였습니다.");
			} else {
				alert("해지가 완료되었습니다.");
				location.reload();
			}
		}
	});
}