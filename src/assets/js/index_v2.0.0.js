$(function () {

    sliderFn();
    firstStep();
    wayP();

    //이미지로드 지연 - 로딩속도 단축
    /*$("img.lazy").lazyload({
      threshold : 300,        
      effect : "fadeIn"       
    });*/

    $(window).resize(function () {
        var winWidth = $(window).width();
        // console.log(winWidth)
        if (winWidth <= 991) {
            ingProductFn();
            benefitChart("#per-chart", "11");
        }
        if (winWidth >= 992) {
            benefitChart("#per-chart", "19");
        }
    }).resize();
});

// slider 영역
function sliderFn() {
    $('#main-slider').bxSlider({
        adaptiveHeight: true,
        mode: 'fade',
        auto: true,
        speed: 100,
        pause: 8000,
        // autoDelay: 1000,
    });
}

// 진행중인 상품 영역 - 모바일
function ingProductFn() {
    var ipSwiper = new Swiper('.ip-container', {
        autoplay: {
            delay: 8000,
        },
        slidesPerView: 'auto',
        spaceBetween: 15,
        centeredSlides: true,
        pagination: {
            el: '.swiper-pagination',
            type: 'fraction',
        },
    });
    $(window).resize(function () {
        var winWidth = $(window).width();
        if (winWidth >= 992) {
            ipSwiper.destroy();
        }
    });
}

// 처음 방문하셨나요?
function firstStep() {
    var main = $('#main');
    main.find('.quick-bar .box-1').on('click', function () {
        // console.log('work');
        $(this).toggleClass('on');
        $(this).closest('.quick-bar').find('.box-1-2').toggleClass('on');
    });
}

//애니메이션 함수 호출  영역
function wayP() {
    // 진행중인 투자상품
    $(".ip-outer").each(function (idx, item) {
        $(item).addClass("blind");
        $(item).waypoint(function () {
            $(item).addClass('animated fadeInUp');
        }, {
            offset: '70%'
        });
    });
    // 쉬운 대출
    $("#easy .split-2").each(function (idx, item) {
        $(item).addClass("blind");
        $(item).waypoint(function () {
            $(item).addClass('animated fadeInUp');
        }, {
            offset: '75%'
        });
    });
    // 자주하는 질문
    $("#faq .fq-outer").each(function (idx, item) {
        $(item).addClass("blind");
        $(item).waypoint(function () {
            $(item).addClass('animated fadeInUp');
        }, {
            offset: '75%'
        });
    });
}

// 차트
function benefitChart(itm, ht) {
    var perHeightArray = [];
    var htMax = 200;
    // 차트
    $(itm).children('div').each(function (index, item) {
        var perData = $(item).find('.p-per > span').text(),
            perHeight = perData * ht;
        perHeightArray.push(perHeight);

        $(itm).waypoint(function () {
            $(item).children('.p-chart').height(perHeight);
            $(item).addClass('on');
            $(itm).children('.tooltip').addClass('on');

        }, {
            offset: '75%'
        });
    });
    // console.log(perHeightArray);
    htMax = Math.max.apply(null, perHeightArray);
    // console.log(htMax);
    $(itm).height(htMax + 70);
}