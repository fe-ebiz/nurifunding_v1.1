$(function() {
  $(".dropdown").each(function(idx, item) {
    $(item).find(".dropdown-menu li a").on("click", function() {
      var thTxt = $(this).text();
      var thHtml = thTxt + "<span class='pull-right'>▼</span>";
      $(this).closest(".dropdown").find(".btn").html(thHtml);
      $(this).closest(".dropdown").find(".btn").addClass("on");
      $(this).closest(".dropdown").find(".dropdown-menu").slideToggle("fast");
      event.preventDefault();
    });
  });
  //자동투자모드
  $("#modify-tab .on-btn").on("click", function() {
    $("#modify-box").css("display","block");
    $("#modify-tab").css("display", "none");
    return false;
  });
  $("#modify-box .cancle-btn").on("click", function() {
    $("#modify-tab").css("display", "block");
    $("#modify-box").css("display", "none");
    return false;
  });
  
  //나의 포트폴리오
  $("#pf-tab-box a").on("click", function() {
    var thIdx = $(this).index();
	
    $("#pf-tab-box").find("a").removeClass("on");
    $("#pf-tab-box").find("a").eq(thIdx).addClass("on");

    $("#pf-tab-box").next().find("li").removeClass("on");
    $("#pf-tab-box").next().find("li").eq(thIdx).addClass("on");
    return false;
  });

  //거래내용보기
  $('.btn-mp.btn-view').on('click', function(){
    if( $(this).siblings('.tab-cont-box').css('display') == 'none' ){
        $('.btn-mp.btn-view span').text('닫기');
    }else{
        $('.btn-mp.btn-view span').text('보기');
    }
    
    $(this).siblings('.tab-cont-box').slideToggle();
  });
});