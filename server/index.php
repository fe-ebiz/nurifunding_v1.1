<?php
$page_type = "idx";
	include_once("./common/top.php");
?>
<section class="main">
	<div class="container main-box main-common">
		<div class="s1-div-1">
		  <p class="nth-0">☎ 누리펀딩 고객센터  1666-4570</p>
		  <p class="nth-1"><span class="f-bd">펀딩 이자</span>만으로 <span class="f-bd">해외여행</span> 갈 수 있을까요?</p>
		  <p class="nth-2"><span class="xs-block sm-block">누리펀딩에서는</span> 가능합니다<i>!</i></p>
		  <p class="nth-3">누리펀딩에서 고금리 혜택을 누려보세요</p>
		</div>
	</div>
	<div class="container main-box swiper-container" id="main-slider">
		<ul class="swiper-wrapper">
			<!-- <li class="swiper-slide review">
				<a href="https://www.nurifunding.co.kr/notice/view.php?var=EUw=&page=1" class="hidden-xs"><img src="https://www.nurifunding.co.kr/img/banner/banner_review_pc.png" alt="누리펀딩 이용후기 이벤트, 블로그와 SNS에 누리펀딩 이용후기 남기고 푸짐한 경품 받으세요!"></a>
				<a href="https://www.nurifunding.co.kr/notice/view.php?var=EUw=&page=1" class="hidden-md"><img src="https://www.nurifunding.co.kr/img/banner/banner_review_m.png" alt="누리펀딩 이용후기 이벤트, 블로그와 SNS에 누리펀딩 이용후기 남기고 푸짐한 경품 받으세요!"></a>
			</li> -->
			<li class="swiper-slide nth-1">
				<div class="s1-div-2">
				  <div class="d1">
					<p class="nth-1">MY LITTLE 펀딩 버킷리스트</p>
					<p class="nth-2"><span class="xs-block sm-block">이 모든 게 펀딩이자만으로</span> 가능합니다!</p>
				  </div>
				  <div class="d2">
					<p class="nth-1"><img src="<?=base_img2;?>/check_icon_02.png" alt="체크아이콘"> 몰디브에서 모히또 한 잔</p>
					<p class="nth-2"><img src="<?=base_img2;?>/check_icon_02.png" alt="체크아이콘"> 세계 맛집 탐방하기</p>
					<p class="nth-3"><img src="<?=base_img2;?>/check_icon_02.png" alt="체크아이콘"> 부모님께 효도 관광시켜드리기</p>
					<p class="nth-4"><img src="<?=base_img2;?>/check_icon_02.png" alt="체크아이콘"> 나만의 공간 만들기</p>
					<p class="nth-5"><img src="<?=base_img2;?>/check_icon_02.png" alt="체크아이콘"> 10년 동안 1억 만들기</p>
				  </div>
				</div>
				<div class="s1-div-3"><img src="<?=base_img2;?>/ms_ill_01.png" alt="고금리혜택"></div>
			  </li>
			  <li class="swiper-slide nth-2">
				<div class="s1-div-2 s2-div-2">
				  <div class="d1">
					<p class="nth-2">리스크 조기경보시스템 작동</p>
				  </div>
				  <div class="d2">
					<p class="nth-1">누리펀딩에서는</p>
					<p class="nth-2">원금 손실 방지를 위해</p>
					<p class="nth-3">담보 부동산 가치를</p>
					<p class="nth-4">실시간으로</p>
					<p class="nth-5">알려드립니다.</p>
				  </div>
				</div>
				<div class="s1-div-3 s2-div-3"><img src="<?=base_img2;?>/ms_ill_02.png" alt="고금리혜택"></div>
			  </li>
			  <li class="swiper-slide nth-3">
				<div class="s1-div-2 s3-div-2">
				  <div class="d1">
					<p class="nth-2">원리금상환 능력점검</p>
				  </div>
				  <div class="d2">
					<p class="nth-1">투자한 돈을 돌려받을 수 있도록</p>
					<p class="nth-2">부동산 가치 상승, 임대료,</p>
					<p class="nth-3">기타 수익 등 꼼꼼한</p>
					<p class="nth-4">원리금 상환</p>
					<p class="nth-5">CASH FLOW 점검</p>
				  </div>
				</div>
				<div class="s1-div-3 s3-div-3"><img src="<?=base_img2;?>/ms_ill_03.png" alt="고금리혜택"></div>
			  </li>
		</ul>
	</div>

</section>

<!--변경내용 bg-darkBlue변경, 애니메이션추가-->
<section class="rate bg-darkBlue">
    <div class="container">
		<div class="row">	
			<?php
				$qry	= "SELECT COUNT(num) AS cnt, SUM(price) AS price, SUM(profit) AS profit FROM goods WHERE state = 'Y'";
				$sql	= mysqli_query($dbconn, $qry);
				$row	= mysqli_fetch_array($sql);

				$profit3	= ($row["profit"] / $row["cnt"]);

				$profit2	= number_format($profit3, 2);
				$profit		= str_replace('.', '', $profit2);

				//# loan
				$l_qry	= "select sum(price) as price from loan_pay where state = 'Y'";
				$l_res	= mysqli_query($dbconn, $l_qry);
				$loan	= mysqli_fetch_array($l_res);
				
				$repay	= mysqli_fetch_array(mysqli_query($dbconn, "SELECT SUM(price) as price FROM pay WHERE gubun = '+' AND state = 'Y' AND goodsno > 0"));

				$repay_money = $loan["price"] - $repay["price"];

				$main_qry	= mysqli_fetch_array(mysqli_query($dbconn, "select * from main_price order by num desc limit 1"));

			?>
			<div class="col-xs-6 col-sm-6 rr-nth-1">
				<h2 class="r-f">누적 상환액</h2>
				<p class="r-f2"><span id="n1"><?=number_change($main_qry["price1"]);?></span> 원</p>
			</div>
			<div class="col-xs-6 col-sm-6 rr-nth-2">
				<h2 class="r-f">대출잔액</h2>
				<p class="r-f2"><span id="n2"><?=number_change($main_qry["price2"]);?></span> 원</p>
			</div>
			<div class="col-xs-6 col-sm-6 rr-nth-3 mt">
				<h2 class="r-f">누적대출 취급액</h2>
				<p class="r-f2"><span id="n3"><?=number_change($main_qry["price3"]);?></span> 원</p>
			</div>
			<div class="col-xs-6 col-sm-6 rr-nth-4 mt">
				<h2 class="r-f">평균금리</h2>
				<p class="r-f2"><span id="n4"><?=$profit2;?></span>%</p>
			</div>
			<div class="col-xs-6 col-sm-6 rr-nth-5 mt">
				<h2 class="r-f">연체율
					<span class="q-w">
						<span class="q">?
							<span class="q-t">
								약정된 상환이 일부<br/>혹은 전부 지연되기<br/>시작해 30일 이상<br/>경과한 대출<br><br>
								연체율 = 연체잔여원금<br>
								/ 대출잔여금<br>
								(P2P금융협회기준)
							</span>
						</span>
					</span>
				</h2>
				<p class="r-f2"><span id="n6">0</span>%</p>
            </div>
            <div class="col-xs-6 col-sm-6 rr-nth-6 mt">
                <h2 class="r-f">
                    부실률
                </h2>
                <p class="r-f2">
                    <span id="n6">0</span>%
                </p>
            </div>
		</div>
	</div>
	<script>
	/*
		$("#n1").animateNumber({
			number: 300000000 / 1000000,
			numberStep: $.animateNumber.numberStepFactories.separator(',', 3)
		}, 2000);
		$("#n2").animateNumber({
			number: 1175500000 / 1000000,
			numberStep: $.animateNumber.numberStepFactories.separator(',', 3)
		}, 2000);
		$("#n3").animateNumber({
			number: <?=$loan['price']?> / 1000000,
			numberStep: $.animateNumber.numberStepFactories.separator(',', 3)
		}, 2000);
		$("#n4").animateNumber({
			number: <?=$profit?>,
			numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
		}, 2000);
		$("#n5").animateNumber({
			number: 0,
			numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
		}, 2000);
		$("#n6").animateNumber({
			number: 0,
			numberStep: $.animateNumber.numberStepFactories.separator('.', 2)
		}, 2000);*/
	</script>
</section>

<!-- 미리페이 띠배너 -->
<section class="miripayBn">
	<h2 class="hidden">보유하신 매출채권으로 필요자금 긴급지원! 미리페이 선지급 서비스로 간편하고 빠르게!</h2>
	<figure>
		<a href="/miripay/">
			<img src="//nurifunding.co.kr/img/banner/bn_miripay.png" alt="미리페이 선지급 서비스" class="hidden-xs">
			<img src="//nurifunding.co.kr/img/banner/bn_miripay_m.png" alt="미리페이 선지급 서비스" class="hidden-md">
		</a>
	</figure>
</section>
<!-- 20191226 누리세이프 -->
<section class="bnBar nurisafeBn">
	<h2 class="hidden">채권의 연체 및 투자 원금 손실위험에서 투자자를 보호하는 누리세이프 플랜으로 안심하고 투자하세요!</h2>
	<figure>
		<a href="/member/safe.php">
			<img src="https://nurifunding.co.kr/img/banner/nurisafe/bn_safe.png" alt="누리세이프 플랜" class="hidden-xs">
			<img src="https://nurifunding.co.kr/img/banner/nurisafe/bn_safe_m.png" alt="누리세이프 플랜" class="hidden-md">
		</a>
	</figure>
</section>

<section class="benefit com-pd">
    <div class="container">
	<!--변경내용 fc-white제거-->
		<h2 class="com-ft">WHY <span class="c-blue2">NURI</span> FUNDING?</h2>
		<!--변경내용 p태그 추가-->
		<p class="p1">P2P 투자는 수익률이 먼저? NO! 누리펀딩은 원금을 지키는 리스크 관리를 더 소중하게 생각합니다.</p>
		<!--변경내용 시작-->
		<div class="row com-box hidden-xs list-4" id="per-chart">
			<div class="nth-1">
				<p class="p-per"><span id="p-per1">1.56</span>%</p>
				<p class="p-chart"></p>
				<p class="p-tit">예금 금리</p>
			</div>
			<div class="nth-2">
				<p class="p-per"><span id="p-per2">1.89</span>%</p>
				<p class="p-chart"></p>
				<p class="p-tit">국고채 (5년물)</p>
			</div>
			<div class="nth-3">
				<p class="p-per"><span id="p-per3">5.61</span>%</p>
				<p class="p-chart"></p>
				<p class="p-tit">KOSPI</p>
			</div>
			<div class="nth-4 nuri">
				<p class="p-per"><span id="p-per5"><?=$profit2;?></span>%</p>
				<p class="p-chart"></p>
				<p class="p-tit">누리펀딩</p>
			</div>
			<!--div class="nth-5">
				<p class="p-per"><span id="p-per4">12.96</span>%</p>
				<p class="p-chart"></p>
				<p class="p-tit">P2P업체 평균</p>
			</div-->
			<input type="hidden" id="per5_val" value="<?=$profit;?>" />
			<script>
				$("#per-chart > div").each(function(idx, item) {
					var $this = $(this),
						perData = $this.find(".p-per > span").text(),
						perHeight = perData * 27;
					
					$this.children(".p-chart").height(perHeight);
				});
			</script>
		</div>
		<!--변경내용 끝-->

  
		<div class="row com-box show-xs list-4" id="per-chart-m">
			<div class="nth-1">
				<p class="p-per"><span id="p-per1">1.56</span>%</p>
				<p class="p-chart"></p>
				<p class="p-tit">예금 금리</p>
			</div>
			<div class="nth-2">
				<p class="p-per"><span id="p-per2">1.89</span>%</p>
				<p class="p-chart"></p>
				<p class="p-tit">국고채 (5년물)</p>
			</div>
			<div class="nth-3">
				<p class="p-per"><span id="p-per3">5.61</span>%</p>
				<p class="p-chart"></p>
				<p class="p-tit">KOSPI</p>
			</div>
			<div class="nth-4 nuri">
				<p class="p-per"><span id="p-per5"><?=$profit2;?></span>%</p>
				<p class="p-chart"></p>
				<p class="p-tit">누리펀딩</p>
			</div>
			<!--div class="nth-5">
				<p class="p-per"><span id="p-per4">12.96</span>%</p>
				<p class="p-chart"></p>
				<p class="p-tit">P2P업체 평균</p>
			</div-->
			<input type="hidden" id="per5_val" value="<?=$profit2;?>" />
		</div>
					
			<!-- 180625 텍스트 추가 -->
		<p class="benefit-b-txt">은행연합회, 금융투자협회, 저축은행중앙회, 누리펀딩(2018년 6월 현재)</p>
    </div>
</section>

<section class="ingProduct com-pd">
    <div class="container">
   
		<h2 class="com-ft">진행중인 투자상품</h2>
		<div class="row com-box ip-wrap"id="ip-wrap">
		  <!--(div.col-xs-12.ip-box>h3.iph3+ul.ip-inner>(li.ipli-nth-$>p.pull-left+p.pull-right)*4)*2-->
		  <?php
			$i = 0;
			## 2018.10.04 상품순서 정렬
			## 1순위 : 투자유치중 - 내부 정렬 투자모집만기일 가까운 순 우선노출
			## 2순위 : 준비중(예정) - 투자 개시일 가까운 순 우선노출
			## 3순위 : 상환중 - 상품번호 높은순 우선
			## 4순위 : 투자완료 - 상품번호 높은순 우선

			$gArray = array();
			$qry1 = 'SELECT * FROM goods WHERE state="Y" AND state2 IN ("Y", "S") AND mprice != price ORDER BY FIELD(state2, "Y", "S"), sdate, edate';
			$res1 = mysqli_query($dbconn, $qry1);
			while($row1 = mysqli_fetch_array($res1)) {
				$gArray[] = $row1;
			}

			if(count($gArray) < 2) {
				$qry2 = 'select * from goods where state="Y" and state2 in ("Y", "S") AND mprice = price order by field(state2, "Y", "S"), sdate,  edate';
				$res2 = mysqli_query($dbconn, $qry2);
				while($row2 = mysqli_fetch_array($res2)) {
					$gArray[] = $row2;
				}
			}

			if(count($gArray) < 2) {
				$qry3 = 'select * from goods where state="Y" and state2 in ("G", "E") order by field(state2, "G", "E"), num desc';
				$res3 = mysqli_query($dbconn, $qry3);
				while($row3 = mysqli_fetch_array($res3)) {
					$gArray[] = $row3;
				}
			}

			foreach($gArray as $key => $row) {

				if($i >= 2) break;

				$ivt_btn1 = "";
				$per = ($row["mprice"]/$row["price"])*100;
				$per = @round($per, 2);
				$pqry = "select count(num) as cnt from pay where goodsno = '".$row["num"]."' and state = 'Y'";
				$pres = mysqli_query($dbconn, $pqry);
				$cnt = mysqli_fetch_array($pres);
				switch($row["state2"]) {
					case "S":
						$type	= "투자모집완료";
						$button	= "투자모집완료";
					break;
					case "G":
						$type	= "상환중";
						$button	= "상환중";
					break;
					case "E":
						$type = $button = "상환완료";
					break;
					case "Y":
					default:
						$type = "진행중";
						$button = "투자하기";
					break;
				}

				
				// =============================================================================
				$sdate		= $row['sdate'];				// 시작일 string
				$_sdate		= strtotime($row['sdate']);		// 시작일 timestamp

				//$_edate		= strtotime("+".$row['end_turn']." ".$timestamp, $_sdate);	// 종료일 timestamp
				$_edate		= strtotime($row["edate"]." 23:59:59");
				$edate		= date("Y-m-d H:i:s", $_edate);	// 종료일 string

				if($_sdate > time()) {
					$s_date = explode(" ", $row["sdate"]);
					$e_date = explode(" ", $row["edate"]);

					$dday	= $s_date[0]." ~ ".$e_date[0];
					$button	= "준비중";

					$ivt_btn1 = "ivt_btn_".$row["num"];
				} else {						
					if($per == "100") {
						$dday = "펀딩완료";
					} else {
						if($_edate >= time()) {
							$last_time = $_edate - time();				// 종료일 - 오늘 timestamp
							$dday = "D-".ceil(($last_time) / 86400)."일";			// dday 구하기
						} else {
							$dday = "펀딩종료";
						}
					}
				}

				$repay = json_decode($row['repay'], true);

				$repayment = $repay['repay1'];
				$repayment.= (!empty($repay['repay2'])) ? '(거치기간 '.$repay['repay2'].')' : '';
				
				$_sdate		= strtotime($row['sdate']);		// 시작일 timestamp
				if($_sdate > time()) {
					$row["mprice"] = 0;
					$per = 0;
				}

				if($row["mprice"] > $row["price"]) {
					$row["mprice"] = $row["price"];
					$per = 100;
				}
				// =============================================================================
		  ?>
		  <div class="col-xs-12 col-sm-6 ip-outer" onclick="javascript: invest_view_new('<?=$row['num']?>')" style="cursor:pointer;">
			<div class="ip-box br4">

				
				<!-- 191118 상품 상세내용 노출 -->
				<!-- <div class="thumb-box">
					<div class="thumb-text-wrapper">
						<p class="title">스와브 롱패딩/롱사파리</p>
						<p class="price">70,000원</p>
						<p class="text">백화점 판매 동일 모델</p>
					</div>
				</div> -->
			  <div class="thumb-box">          
				<?php	if($per == "100") {	?><div class="end"><span>펀딩완료</span></div><?php	}	?>
				<?php	if($i == 0){	?><span class="new">NEW</span><?php	}	?>   
				<?php
					if($row["auto_chk"] == "Y") {
				?>
				<div class="autoinv">
					<span class="txt">자동</span>
					<p class="box">
						<span></span>
						자동투자방식이
						가능한 상품입니다.
					</p>
				</div>  
				<?php
					}
				?>

				<?php
					if($row["sdate"] >= "2019-12-18 00:00:00") {
				?>
				<!-- 20191226 누리세이프 -->
				<div class="safe-mark">
					<img src="https://nurifunding.co.kr/img/nurisafe/safe_mark2.png" alt="누리세이프마크">
				</div>
				<?php
					}
				?>
			  </div>

			  <h3 class="iph3"><?=$row["name"]?></h3>
			  <ul class="ip-inner">
				<li class="ipli-nth-1 clearfix">
				  <p class="pull-left">예상수익률</p>
				  <p class="pull-right"><?=$row["profit"]?>%</p>
				</li>
				<li class="ipli-nth-2 clearfix">
				  <p class="pull-left">기간</p>
				  <p class="pull-right"><?=$row["end_turn"]?>개월</p>
				</li>
				<li class="ipli-nth-3 clearfix">
				  <p class="pull-left">상환방식</p>
				  <p class="pull-right"><?=$repayment;?></p>
				</li>
				<li class="ipli-nth-4 clearfix">
				  <p class="pull-left">모집현황</p>
				  <!--p class="pull-right"><?=number_format($row["mprice"]/1000000, 1)?> / <?=number_format($row["price"]/1000000, 1)?>백만원</p-->
				  <p class="pull-right"><?=number_change($row["mprice"])?>원 / <?=number_change($row["price"])?>원</p>
				</li>
				<li class="ipli-nth-5 clearfix">
				  <p class="ip-per-bar bg-blue" style="width:<?=$per?>%;"></p>
				</li>
				<li class="ipli-nth-6 clearfix">
				

					<?php
						if($_sdate > time()) {
					?>
					<p class="pull-left">투자기간</p>
					<p class="pull-right ip-percent fc-blue"><?=$dday?></p>
					<?php
						} else {
					?>
					  <p class="pull-left"><?=$type?><!--span class="ip-per-num">(<?=number_format($cnt["cnt"])?> 명)</span--></p>
					  <p class="pull-right ip-percent fc-blue"><?=$per?>%</p>
					<?php
						}
					?>
				</li>
			  </ul>
			  <p class="ip-btn-box">
				<a href="javascript: invest_view_new('<?=$row['num']?>')" id="<?=$ivt_btn1;?>" class="ip-btn bg-blue br4"><?=$button?></a>
			  </p>
			</div>
		  </div>
		  
		<script>
			$("#ip-wrap > div").eq(<?=$i;?>).find(".thumb-box").css({
				"background": "url(<?=$row['img'];?>) no-repeat center",
				"background-size": "cover"
			});
		</script>
			<?php
				if($ivt_btn1 != "") {
			?>
				<script>
					$(function() {
						var a_id = "<?=$ivt_btn1;?>";
						var tid_timer = setInterval(function() {
							$.ajax({
								type	:	"POST",
								data	:	{"mode":"<?=XOREncode('time_chk');?>","num":"<?=$row['num'];?>"},
								url		:	"/inc/state.php",
								success	:	function(a) {
									$('#'+a_id).html(a);
								}
							});
						}, 1000);
					});
				</script>
			<?php
				}
			?>
		  <?php
				$i++;
			}
		  ?>	  
		  
		</div>
		<form action="" method="POST" id="iform">
			<input type="hidden" name="num" />
		</form>
		
		<div class="row com-box ip-more-outer-2">
			<div class="ip-more-box"><a href="/invest/" class="ip-more-btn br4">투자상품 보러가기<span class="arr-icon black-r-icon"></span></a></div>
            <div class="ip-more-box"><a href="/invest/nuri.php" class="ip-more-btn br4">누리워드 보러가기<span class="arr-icon black-r-icon"></span></a></div>
		</div>
	
    </div>
</section>


<section class="easy com-pd">
	<div class="container">
		<h2 class="com-ft">웹 보안 + 금융 노하우 + 법률 자문<br>P2P 금융의 최고의 인력입니다.</h2>
		<div class="row com-box" id="easy">
			<div class="col-xs-12 col-sm-4 col-md-3 nth-1">
				<img src="<?=base_img2?>/easy_01.png" alt="개인정보유출방지">
				<h3>IT전문기업의<br>개인 정보 유출 방지</h3>
				<img class="plus" src="<?=base_img2?>/icon_plus.png" alt="플러스">
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-md-offset-1 nth-2">
				<img src="<?=base_img2?>/easy_02.png" alt="전문가의설명">
				<h3>금융 전문가의<br>여신심사 금융 노하우</h3>
				<img class="plus" src="<?=base_img2?>/icon_plus.png" alt="플러스">
			</div>
			<div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1 nth-3">
				<img src="<?=base_img2?>/easy_03.png" alt="쉬운투자">
				<h3>변호사<br>계약서 법률 검토</h3>
			</div>
			<div class="col-xs-12 ip-more-outer">
				<div class="col-xs-12 com-sm-4 ip-more-box"><a href="/service/" class="ip-more-btn br4">자세히 보러가기<span class="arr-icon black-r-icon"></span></a></div>
			</div>
		</div>
	</div>
</section>

	
<!--section class="vcfund fom-pd">
	<div class="container">
		<p class="vf-tit-1"><span class="f-bd">KOSDAQ </span>VC Fund</p>
		<h2 class="com-ft c-blue2 f-bd">코스닥 벤처펀드도 누리펀딩!</h2>
		<p class="vf-tit-2">친절한 상담을 약속드립니다.</p>
		<div class="vf-box">
			<p class="vf-txt-1">코스닥벤처펀드란?</p>
			<p class="vf-txt-2">
				코스닥 시장활성화 방안의 일환으로 도입된 펀드로 펀드 투자금의 절반을 혁신, 벤처기업에 투자하는 상품입니다.<br>
				(2018년 3월 5일 첫 선을 보임)
			</p>
		</div>
	</div>
</section-->

<section class="faq com-pd">
	<div class="container">
		<h2 class="com-ft">자주하는 질문</h2>
		<div class="row com-box fq-wrap">

			<div class="col-xs-12 col-sm-4 fq-outer">
				<div class="fq-box br4">
					<!--h3 class="fqh3"><span class="arr-icon q-icon"></span>고금리의 대출을 갈아탈 수 있나요?</h3>
		<p class="fq-a"><span class="arr-icon a-icon"></span>가능합니다. 年 45~20%의 고객별 최적화된 중/저금리로 상환 부담을 덜어드리며 기존 고금리 대출을 전환하시는 고객께는 더 나은 조건의 금리와 한도 혜택을 드립니다.</p-->
					<h3 class="fqh3"><span class="arr-icon q-icon"></span>누리펀딩은 어떻게 만들어졌나요?</h3>
					<p class="fq-a"><span class="arr-icon a-icon"></span>30년 경력 탄탄한 금융 전문가와 토탈 IT 서비스 전문 기업으로10년 동안 온라인 사이트의 보안을 책임져온 ㈜이비즈네트웍스가 누리펀딩에서 만났습니다.</p>
				</div>
			</div>

			<div class="col-xs-12 col-sm-4 fq-outer">
				<div class="fq-box br4">
					<h3 class="fqh3"><span class="arr-icon q-icon"></span>대출 신청 자격 요건은 무엇인가요?</h3>
					<p class="fq-a"><span class="arr-icon a-icon"></span>기업과 개인 신용등급이 낮은 경우에도 대출취급이 가능하나 담보물 가치에 따라 대출금액이 제한 됩니다.</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 fq-outer">
				<div class="fq-box br4">
					<h3 class="fqh3"><span class="arr-icon q-icon"></span>누리여신평가 등급이 무엇인가요?</h3>
					<p class="fq-a"><span class="arr-icon a-icon"></span>누리펀딩이 개발한 알고리즘을 바탕으로 채무자의 신용등급과 담보 가치를 결합한 여신평가 등급입니다.</p>
				</div>
			</div>

		</div>

		<div class="row com-box fq-btn-outer">
			<div class="col-xs-12 com-sm-4 fq-btn-box"><a href="/faq/" class="fq-btn br4">질문 전체 보러가기<span class="arr-icon black-r-icon"></span></a></div>
		</div>

	</div>
</section>

<?php
if(!empty($member_info)) {
	$qry = "select * from popup_chk where uid = '".$member_info["num"]."' and type='out'";
	$res = mysqli_query($dbconn, $qry);
	$num = @mysqli_num_rows($res);

	if($num < 1) {
?>
<script>
function pop_chk(tt) {
	$.ajax({
		type	:	"POST",
		data	:	{"mode":"<?=XOREncode('pop_chk')?>", "type":tt},
		url		:	"/inc/state.php",
		success	:	function(data) {
			$('#voice_pop').hide();
		}
	});		
}
</script>

<section class="pop-sec pop-phishing" id="voice_pop">
	<div class="dropDown-bg"></div>
	<div class="pop-contents">
		<div class="pop-top">
			<span class="left">누리펀딩에서 알려드립니다.</span>
			<span class="right"><img src="https://nurifunding.co.kr/img/logo.png" alt="누리펀딩"></span>
			<div class="clr"></div>
			<h2>보이스피싱 및 메시지피싱으로 인한 <br class="show-xs"> 출금제한 안내</h2>
		</div>
		<div class="pop-middle">
			<p>최근 발생되고 있는 보이스피싱 피해사례로 인해 <br class="show-xs"> 이상거래탐지 시스템이 <br class="hidden-xs">
				보다 강화되었음을 알려드립니다.</p>

			<p class="c-blue fwe-700">일반 투자자들도 투자 외의 출금 시도시 <br class="show-xs"> 출금거래가 차단될 수 있으며 <br class="hidden-xs">
				이에 대해 출금차단 해제는 <br class="show-xs"> 현재 세이퍼트 모니터링 요원들이 업무시간 <br class="hidden-xs">
				내에 <br class="show-xs"> 순차적으로 리뷰 후 출금 가능하도록 수동으로 <br class="show-xs"> 조치하고 있습니다.</p>

			<p>다소 불편하시겠지만 출금 자동 제한이 당분간 <br class="show-xs"> 유지될 예정이오니 <br class="hidden-xs">
				이용에 참고하여 주십시오. </p>

			<p>불편을 드려 죄송합니다. 감사합니다.</p>
		</div>
		<div class="pop-bottom">
			<a href="javascript: void(0);" onclick="javascript: pop_chk('out');">더이상 이 창을 열지 않습니다.</a>
			<a href="javascript: void(0);" onclick="javascript: pop_chk('out');" class="clsBtn">창닫기</a>
		</div>
	</div>
</section>
<?php
	}
}

?>


<?php
	include_once(INC_DIR."/www/web-home/common/bottom.php");
?>