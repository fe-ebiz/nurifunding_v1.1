<?php
	$page_type = "invest";
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/www/web-home/common/top.php");
	include_once (INC_DIR.'/config/aes.class.php');

		#if($_SERVER["REMOTE_ADDR"] != "61.74.233.194" && $_SERVER["REMOTE_ADDR"] != "61.74.233.195") {
			if(empty($_POST["num"])) {
				echo "<script>
					alert('잘못된 접근입니다.');
					location.href='/invest/';
				</script>";
				exit;
			}
			if($login_mode != true) {
				echo "<script>
					location.href='/member/login.php?url=/invest/view.php?num=".$_POST['num']."';
				</script>";
				exit;
			} else {
				if($member_info["info"] != "Y") {
					echo "<form action='/member/member_info.php?url=/invest/view.php/?num=".$_POST['num']."' method='POST' name='iform'>
						<input name='state' type='hidden' value='Y'/>
					</form>";
					echo "<script>
						alert('회원정보 입력 후 이용하실 수 있습니다.');
						document.iform.submit();
					</script>";
					exit;
				}
			}
		#}


		$nonce			= $member_info["num"].time();
		$name			= $member_info["name"];
		$phoneNo		= $member_info["phone"];

		//## =========================== 멤버 잔액조회 ===========================
		$url			= "/v5/member/seyfert/inquiry/balance";

		$val			= "reqMemGuid=".$Guid;
		$val			.= "&_method=GET";
		$val			.= "&nonce=".$member_info["num"].time();
		$val			.= "&_lang=ko";
		$val			.= "&dstMemGuid=".$member_info["guid"];
		$val			.= "&crrncy=KRW";

		$result			= apiAct($url, $val, "GET", $Guid, $KeyP);

		if($result["status"] == "SUCCESS") {
			$cash	= $result["data"]["moneyPair"]["amount"];
		} else {
			$cash	= 0;
		}
		//## =========================== 멤버 잔액조회 - 끝 ===========================	

		$num = $_POST["num"];
		$gqry = "select * from goods where num = '".$num."'";
		$gres = mysqli_query($dbconn, $gqry);
		$row = mysqli_fetch_array($gres);
		
		$_sdate		= strtotime($row['sdate']);		// 시작일 timestamp
		$_edate		= strtotime($row['edate']);		// 종료일 timestamp


		$mprice2_price	= 0;
		$mprice2_chk	= "";

		if($row["sdate"] > date("Y-m-d H:i:s")) {
		
			if($member_info["mtype"] == "2" || $member_info["mtype"] == "4" || $member_info["mtype"] == "7") {
				$check_date = date("Y-m-d H:i:s", strtotime('-1 hours', $_sdate));

				if(date("Y-m-d H:i:s") > $check_date) {
					
					$mprice2_qry = "SELECT sum(price) as price FROM pay WHERE goodsno='".$num."' AND wdate < '".$row["sdate"]."' AND state='Y' AND gubun='-'";
					$mprice2_res = mysqli_query($dbconn, $mprice2_qry);
					$mprice2	= mysqli_fetch_array($mprice2_res);

					$mprice2_chk	= "1";
					$mprice2_price	= $mprice2["price"];			
				} else {
					echo "<script>alert('".date("Y년 m월 d일", $_sdate)."부터 투자 가능합니다.'); history.back(-1);</script>";
				}
			} else {
				echo "<script>alert('".date("Y년 m월 d일", $_sdate)."부터 투자 가능합니다.'); history.back(-1);</script>";
			}
		} else {
			if($_edate < time()) {
			#	echo "<script>alert('투자가 종료된 상품입니다.'); history.back(-1);</script>";
			}
		}
		
		//## =========================== 멤버 한도조회 ===========================	
		$limit1			= 0;	// 동일 차업자 한도
		$limit2			= 0;	// 전체금액
		$limit3			= 0;	// 부동산
		$limit4			= 0;	// 동산
		$mem_chk_qry	= "SELECT SUM(a.price) AS all_price, b.gtype as gtype, b.uid as goods_uid FROM pay AS a LEFT JOIN goods AS b ON a.goodsno = b.num WHERE a.uid = ".$member_info["num"]." AND a.state = 'Y' and b.reward != 'Y' AND a.type='none' AND a.gubun = '-' GROUP BY a.goodsno";
		$mem_chk_res	= mysqli_query($dbconn, $mem_chk_qry);
		while($mem_all	= @mysqli_fetch_array($mem_chk_res)) {
			switch($mem_all["gtype"]) {
				case '부동산' :
					$limit3 += $mem_all["all_price"];
				break;
				case '동산' :
					$limit4 += $mem_all["all_price"];
				break;
			}

			if($mem_all["goods_uid"] == $row["uid"]) {
				$limit1	+= $mem_all["all_price"];
			}
			$limit2		+= $mem_all["all_price"];
		}	
		//## =========================== 멤버 한도조회 - 끝 ===========================	

		//## =========================== 멤버 잔역 한도 조회 (투자금 - 회수원금) ===========================	
		$money_qry		= "SELECT SUM(a.price) AS all_price, b.gtype AS gtype, b.uid AS goods_uid FROM pay AS a LEFT JOIN goods AS b ON a.goodsno = b.num WHERE a.uid = ".$member_info["num"]." AND a.state = 'Y' and b.reward != 'Y' AND a.type2 = 'money' AND a.gubun = '+' GROUP BY a.goodsno";
		$money_res		= mysqli_query($dbconn, $money_qry);
		while($money	= @mysqli_fetch_array($money_res)) {
			switch($money["gtype"]) {
				case '부동산' :
					$limit3 -= $money["all_price"];
				break;
				case '동산' :
					$limit4 -= $money["all_price"];
				break;
			}
			
			//# 2018.09.27 박상현 : 동일 차업자 한도 조회시 상환한 내역 차감
			if($money["goods_uid"] == $row["uid"]) {
				$limit1 -= $money["all_price"];
			}

			$limit2		= $limit2 - $money["all_price"];
		}
		//## =========================== 멤버 잔역 한도 조회 (투자금 - 회수원금) - 끝 ===========================	
		
?>
<script type="text/javascript">

var util = {
	pop: function(url, name, w, h){
		var ww = window.open(url, name, "toolbar=no,scrollbars=yes,directories=no,status=no,menubar=no,width=" + w +",height=" + h + ",resizable=no, top=50, left="+((screen.width - 450)/2)+"");
		ww.focus();
	}
}
function app_submit() {
	if($("input[name='chk']").is(":checked") == false) {
		alert("주의사항 안내 동의 후 투자하실 수 있습니다");
		return false;
	}
	if($("input[name='chk1']").is(":checked") == false) {
		alert("개인정보처리방침 동의 후 투자하실 수 있습니다");
		return false;
	}
	if($("input[name='chk2']").is(":checked") == false) {
		alert("서비스이용약관 동의 후 투자하실 수 있습니다");
		return false;
	}
	if($("input[name='chk3']").is(":checked") == false) {
		alert("대부거래 기본약관 동의 후 투자하실 수 있습니다");
		return false;
	}
	if($("input[name='chk4']").is(":checked") == false) {
		alert("투자이용약관 동의 후 투자하실 수 있습니다");
		return false;
	}

	if($("input[name='use_cash']").val() <= 0) {
		alert("투자금액을 확인해주세요");
		return false;
	}


	if($("input[name='use_cash']").val()*10000 < 10000) {
		alert("투자금액은 최소 1만원 입니다.");
		return false;
	}

	// 투자실행금
	var use_cash = Number($("input[name='use_cash']").val()) * 10000;

	if(use_cash > Number($("input[name='info_cash']").val()) + Number($("input[name='event_cash']").val())) {
		alert("투자금액이 보유하신 예치금보다 많습니다.");
		return false;
	}

	if($("input[name='mtype_lev']").val() == 1 || $("input[name='mtype_lev']").val() == 3) {
		var this_price	= use_cash + (Number($("input[name='mem_chk_1']").val()));
		var this_limit	= (Number($("input[name='limit1']").val()));
		
		var all_price	= use_cash + (Number($("input[name='mem_chk_2']").val()));
		var all_limit	= (Number($("input[name='limit2']").val()));

		var gtype		= $('input[name="gtype"]').val();

		if(this_price > this_limit) {
			var calc_price = (Number($("input[name='limit1']").val())) - (Number($("input[name='mem_chk_1']").val()));

			alert("회원님의 현재 상품(차주)에 투자 가능한 금액은 "+(calc_price/10000)+"만원 입니다.");
			return false;
		}

		if(gtype == "부동산") {
			var limit_pri	= use_cash + (Number($("input[name='mem_chk_3']").val()));
			var mtype_limit	= (Number($("input[name='limit3']").val()));
		} else {
			var limit_pri	= use_cash + (Number($("input[name='mem_chk_4']").val()));
			var mtype_limit	= (Number($("input[name='limit4']").val()));
		}

		if(limit_pri > mtype_limit) {
			alert(gtype+" 상품에 대한 투자한도가 초과되었습니다.");
			return false;
		}
		
		if(all_price > all_limit) {
			alert("플랫폼 투자한도가 초과되었습니다.");
			return false;
		}
	}

	// 조기투자 한도체크
	if($("input[name='mprice2_chk']").val() != "") {
		var mprice = $('input[name="mprice"]').val();
		var mprice2	= use_cash + (Number($('input[name="mprice2"]').val()));

		if(mprice2 > mprice) {
			alert("조기 투자한도가 초과되었습니다.");
			return false;
		}		
	}
	
	popupOpen('#popup-container1');
}

function tid_chk(tid) {	
	var tid_timer = setInterval(function() {
		$.ajax({
			type	:	"POST",
			data	:	{"mode":"<?=XOREncode('_tid_chk')?>","tid":tid},
			url		:	"/inc/state.php",
			success	:	function(data) {
				if(data == "Y") {
					clearInterval(tid_timer);
					$('#div_ing').hide();
					$('#agr_btn').show();
				} else if(data == "C") {
					alert("상품모집금액을 초과하여 투자할 수 없습니다.");
					clearInterval(tid_timer);
					location.reload();
				}

			}
		});
	}, 1000);
}

function agree_pay() {
	var agree_chk	= $('input[name="agree"]').val();

	if(agree_chk != "동의함") {
		alert("동의함을 입력해주세요");
		$('input[name="agree"]').focus();
		return false;
	}

	popupClose('#popup-container1');
	popupOpen('#popup-container2');

	$.ajax({
		type	:	"POST",
		data	:	$("form[name='order']").serialize(),
		url		:	"/pay/_pay.php",
		success	:	function(data) {
			//$('#popup-container2').html(data);
			
			var ret = data.split("^");

			if(ret[0] == "FAIL") {
				alert(ret[1]);
				if(ret[1] == "투자가 진행중입니다.\n잠시후에 다시 시도해주세요.") {
					location.reload();
				}
			} else {
				tid_chk(ret[1]);
				$('#agr_btn').attr('href', ret[2]);
			}
			
		}
	});
}

function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function policy_show(p_num) {
	if($('#policy_'+p_num).css('display') == 'none') {
		$('#policy_'+p_num).show();
	} else {
		$('#policy_'+p_num).hide();
	}
}

function policy_all_chk() {
	if($('input[name="all_chk"]').is(":checked") == true) {
		$("#chk").prop('checked', true);
		$("#chk1").prop('checked', true);
		$("#chk2").prop('checked', true);
		$("#chk3").prop('checked', true);
		$("#chk4").prop('checked', true);
	} else {
		$("#chk").prop('checked', false);
		$("#chk1").prop('checked', false);
		$("#chk2").prop('checked', false);
		$("#chk3").prop('checked', false);
		$("#chk4").prop('checked', false);
	}
}


function cmaComma(obj) {
	var firstNum = obj.value.substring(0, 1);
	var strNum = /^[/,/,0,1,2,3,4,5,6,7,8,9,/]/;
	var str = "" + obj.value.replace(/,/gi,'');
	var regx = new RegExp(/(-?\d+)(\d{3})/);  
	var bExists = str.indexOf(".",0);  
	var strArr = str.split('.');  
 
	if (!strNum.test(obj.value)) {
		obj.value = "";
		return false;
	}
 
	if ((firstNum < "0" || "9" < firstNum)){
		obj.value = "";
		return false;
	}
 
	while(regx.test(strArr[0])){  
		strArr[0] = strArr[0].replace(regx,"$1,$2");  
	}  
	if (bExists > -1)  {
		obj.value = strArr[0] + "." + strArr[1];  
	} else  {
		obj.value = strArr[0]; 
	}
}

</script>
<form action="" name="order" id="order" method="POST">
<!-- 03. 투자신청서 -->

    <section class="proposal com-pd">
      <div class="container">
		<?php
			$limit_t	= $member_limit["limit1"];	// 동일 차업자 한도
			$limit_a	= $member_limit["limit2"];	// 플랫폼 투자한도
			$limit_3	= $member_limit["limit3"];	// 부동산 한도
			$limit_4	= $member_limit["limit4"];	// 동산 한도
		?>
		<input type="hidden" name="limit1" value="<?=$limit_t;?>" />
		<input type="hidden" name="limit2" value="<?=$limit_a;?>" />
		<input type="hidden" name="limit3" value="<?=$limit_3;?>" />
		<input type="hidden" name="limit4" value="<?=$limit_4;?>" />
		
		<input type="hidden" name="mem_chk_1" value="<?=$limit1;?>" />
		<input type="hidden" name="mem_chk_2" value="<?=$limit2;?>" />
		<input type="hidden" name="mem_chk_3" value="<?=$limit3;?>" />
		<input type="hidden" name="mem_chk_4" value="<?=$limit4;?>" />

		<input type="hidden" name="mprice2_chk" value="<?=$mprice2_chk;?>" />
		<input type="hidden" name="mprice2" value="<?=$mprice2_price;?>" />
		<input type="hidden" name="mprice" value="<?=$row["price"];?>" />


		<input type="hidden" name="gtype" value="<?=$row["gtype"];?>" />

		<input type="hidden" name="mtype_lev" value="<?=$member_info["mtype"];?>" />
    
        <h2 class="com-ft"><span class="fc-blue"><?=$member_info["name"]?></span> 님의 투자 신청서</h2>
        <div class="com-box br4">
          <div class="prps-d-0 clearfix">
            <p class="m pull-left">한번에 금액을 변경하세요</p>
            <p class="pc pull-left">
              <span class="nth-1">채권명</span>
              <span class="nth-2">등급</span>
              <span class="nth-3">금리</span>
              <span class="nth-4">기간</span>
            </p>
          </div>
          
          <div class="prps-d-1">
            <ul class="prps-d1-ul clearfix">
              <li class="prps-d1-li1">
                <div class="nth-1">채권명</div>
                <div class="nr-box nth-2">
                  <input type="checkbox" id="goodsno" value="<?=$row["num"]?>" name="goodsno" checked onclick="javascript:total_price();" class="nr-check"><span><?=$row["num"]?>호 <?=$row["name"]?></span>
                </div>
              </li>
              <li class="prps-d1-li2">
                <div class="nth-1">등급</div>
                <div class="nth-2">A-</div>
              </li>
              <li class="prps-d1-li3">
                <div class="nth-1">금리</div>
                <div class="nth-2"><?=$row["profit"]?>%</div>
              </li>
              <li class="prps-d1-li4">
                <div class="nth-1">기간</div>
                <div class="nth-2"><?=$row["end_turn"]?>개월</div>
              </li>
            </ul>
          </div>
          
          <div class="prps-d-2 br4">
            <ul class="prps-d2-ul prps-invest-ul">
			<?php
				if(!empty($member_info["debank_no"]) && $member_info["debank_no"] != "") {
			?>
              <li>
                <p class="pu-left">나의 예치금 계좌 잔액</p>
                <p class="pu-right"><?=number_format($cash+$member_info["cash"])?>원</p>
              </li>
			<?php
				}
			?>
			  <li>
				<p class="pu-left">
					<span>투자 가능 금액</span>
					<span class="pu-small-txet">(동일차주 500만원 한도)</span>
				</p>
				<p class="pu-right">60 만원</p>
			  </li>

              <li class="prps-d2-li1 prps-investment">
                <p class="pull-left">투자금액</p>
                <p class="pull-right">
					<span class="fc-blue">
						<input type='text' name='use_cash' value='<?=$_POST['invest_price']?>' class="input-type" onkeyup="javascript: checktype('number', 'use_cash')">
					</span> 만원
				</p>
			  </li>
			  <li class="prps-notice">
				<p>※ 개인 투자자의 경우
					<span class="c-org">동일 대출자에게는 </span>
					<span class="c-org">500만원까지 투자가 가능</span>합니다.</p>
			  </li>

				<!-- 190412 -->
				<li class="miri-autoinv">
					<div class="row-txt top">
						<h3><span class="c-blue">선정산(미리페이)<span class="hidden-xs">상품</span> 자동 투자기능!</span> <span
								class="ic-new">NEW</span></h3>
						<?php
							$qry = "select * from auto_pay where uid = '".$member_info["num"]."' and state = 'Y'";
							$res = mysqli_query($dbconn, $qry);
							$row = @mysqli_fetch_array($res);

							if(empty($row)) {
						?>
						<!-- 인증 전 화면 -->
						<div class="row-txt mid before">
							시간에 구애받지 않는 너무 편리한 자동투자!<br />
							기능 설명을 확인<span class="hidden-xs">하신</span> 후 자동 투자 기능을 설정하시겠습니까?
							<div class="setup">
								<p class="c-org">※ 현재 자동 투자 미사용 중</p>
								<a href="../member/auto.php" class="btn-base termi">기능설명 확인 후 설정하기</a>
							</div>
						</div>
						<?php
							} else {
							
								if($row["gubun"] == "new") {
									$dday_chk_num = 365;
								} else {
									$dday_chk_num = 90;
								}

								$at_price	= $row["price"] / 10000;
								$last_time	= time() - strtotime($row["wdate"]);
								$last_day	= $dday_chk_num - (floor(($last_time) / 86400));
								$end_day	= strtotime($row["wdate"]." +".$dday_chk_num." days");

								if($last_day < 1) {
						?>
						<div class="row-txt mid before">
							시간에 구애받지 않는 너무 편리한 자동투자!<br />
							기능 설명을 확인<span class="hidden-xs">하신</span> 후 자동 투자 기능을 설정하시겠습니까?
							<div class="setup">
								<p class="c-org">※ 현재 자동 투자 미사용 중</p>
								<a href="../member/auto.php" class="btn-base termi">기능설명 확인 후 설정하기</a>
							</div>
						</div>
						<?php
								} else {
						?>
						<!-- 인증 후 화면 -->
						<div class="row-txt mid after">
							<span class="c-blue"><?=@number_format($at_price);?>만원 자동 투자 중</span>
							<br class="show-xs" />
							<span class="hidden-xs">/</span> 
							잔여기한 [<span class="c-red"><?=$last_day;?>일</span>]
							종료일 [<span class="c-red"><?=date("Y-m-d", $end_day);?></span>]
							<div class="setup">
								<p class="c-green">※ 현재 자동 투자 사용 중</p>
								<a href="../member/auto.php" class="btn-base termi bg-org">기간연장 또는 해지하기</a>
							</div>
						</div>
						<?php
								}
							}
						?>
					</div>
				</li>
            </ul>
          </div>
			
		<p class="prps-p1"><a href="javascript: void(0);" onclick="javascript: app_submit();" class="btn br4 fc-white bg-blue">투자 동의</a></p>
          
          <p class="prps-ps c-orange" id="money_txt" style="display:none">예치금 계좌에 잔여금액이 부족합니다.</p>
		  <input type="hidden" name="info_cash" value="<?=$cash?>"  />
		  <input type="hidden" name="event_cash" value="<?=$member_info["cash"];?>" />

          <h3 class="prps-h3" style="text-align:right;"><input type='checkbox' name='all_chk' id='all_chk' onclick="javascript: policy_all_chk();" checked='checked'>&nbsp;<label for="all_chk">전체 동의합니다.</label></h3>

          <h3 class="prps-h3" onclick="javascript: policy_show('1');" style="background:#666; color:#fff; padding:2%;">투자시 주의사항 안내</h3>
          
          <div class="prps-d-3 br4" style="display:none;" id="policy_1">
            <p class="prps-d3-p1">
              1. 당사는 원금 및 수익을 보장하지 않습니다. 다만, 채권 추심에 도의적 책임을 다합니다.<br/>
              2. 상환 일정 및 지급액 안내, 연체 시 연체이율안내, 연체 시 불이익 안내에 최선을 다하며 장기 연체시 채권 추심
              (매각 등) 후 투자자에게 배분합니다.<br/> 
              3. 투자 신청 취소는 해당 채권의 투자 모집이 마감되기 이전까지만 가능합니다. 마감 후에는 취소가 불가능합니다.<br/>
              4. 투자 지급액은 나의 예치금 계좌로 입금해 드립니다.<br/>
              5. 대출자가 대출을 취소할 경우, 투자금은 나의 예치금 계좌로 입금 됩니다.<br/>
            </p>
            <p class="prps-d3-p2 nr-box"><input type="checkbox" name="chk" id="chk" class="nr-check" checked='checked'> <label for="chk"><span class="c-orange">[필수]</span><span class="f0">위 내용을 이해하였으며 이에 동의합니다.</span></label></p>
          </div>

			<h3 class="prps-h3" onclick="javascript: policy_show('2');" style="background:#666; color:#fff; padding:2%;">개인정보처리방침</h3>

			<div class="prps-d-3 br4" style="display:none;" id="policy_2">
				<p class="prps-d3-p1">
					<?php include(INC_DIR."/www/web-home/invest/policy.php"); ?>
				</p>
				<p class="prps-d3-p2 nr-box">
					<input type="checkbox" name="chk1" id="chk1" class="nr-check" checked='checked'>
					<label for="chk1">
						<span class="c-orange">[필수]</span>
						<span class="f0">위 내용을 이해하였으며 이에 동의합니다.</span>
					</label>
				</p>
			</div>
			
			<h3 class="prps-h3" onclick="javascript: policy_show('3');" style="background:#666; color:#fff; padding:2%;">서비스이용약관</h3>

			<div class="prps-d-3 br4" style="display:none;" id="policy_3">
				<p class="prps-d3-p1">
					<?php include(INC_DIR."/www/web-home/invest/service.php"); ?>
				</p>
				<p class="prps-d3-p2 nr-box">
					<input type="checkbox" name="chk2" id="chk2" class="nr-check" checked='checked'>
					<label for="chk2">
						<span class="c-orange">[필수]</span>
						<span class="f0">위 내용을 이해하였으며 이에 동의합니다.</span>
					</label>
				</p>
			</div>
			
			<h3 class="prps-h3" onclick="javascript: policy_show('4');" style="background:#666; color:#fff; padding:2%;">투자이용약관</h3>

			<div class="prps-d-3 br4" style="display:none;" id="policy_4">
				<p class="prps-d3-p1">
					<?php include(INC_DIR."/www/web-home/invest/invest.php"); ?>
				</p>
				<p class="prps-d3-p2 nr-box">
					<input type="checkbox" name="chk4" id="chk4" class="nr-check" checked='checked'>
					<label for="chk4">
						<span class="c-orange">[필수]</span>
						<span class="f0">위 내용을 이해하였으며 이에 동의합니다.</span>
					</label>
				</p>
			</div>
			
			<h3 class="prps-h3" onclick="javascript: policy_show('5');" style="background:#666; color:#fff; padding:2%;">대부거래 기본약관</h3>

			<div class="prps-d-3 br4" style="display:none;" id="policy_5">
				<p class="prps-d3-p1">
					<?php include(INC_DIR."/www/web-home/invest/basic.php"); ?>
				</p>
				<p class="prps-d3-p2 nr-box">
					<input type="checkbox" name="chk3" id="chk3" class="nr-check" checked='checked'>
					<label for="chk3">
						<span class="c-orange">[필수]</span>
						<span class="f0">위 내용을 이해하였으며 이에 동의합니다.</span>
					</label>
				</p>
			</div>
          
          <p class="prps-p1"><a href="javascript: void(0);" onclick="javascript: app_submit();" class="btn br4 fc-white bg-blue">투자 동의</a></p>
          <p class="prps-p2">계속하시면 <a href="../policy/policy.php" target="_blank">개인정보 취급방침</a> 및 <a href="../policy/invest.php" target="_blank">투자이용약관</a>에 동의하게 됩니다.</p>
          
        </div>
      </div>
    </section>
	</form>
		
	<!-- 20180320 투자하기 클릭시 나타나는 레이어 팝업 -->


	<div class="invst-popup" id="popup-container1">
		<div class="popup-wrap">
			<div class="popup-container br4">
				<p class="popup-tit">투자 위험 고지</p>
				<div class="popup-info-box br4">
					<p>본 투자상품은 원금이 보장되지 않습니다. 모든 투자상품은 현행 법률 상 '유사수신 행위의 규제에 관한 법률'에 의거하여 원금과 수익을 보장할 수 없습니다. 또한 차입자가 원금의 전부 또는 일부를 상환하지 못할 경우 발생하게 되는 투자금 손실 등 투자위험은 투자자가 부담하게 됩니다.</p>
				</div>
				<div class="popup-form">
					<p class="popup-form-txt">
						나 <span class="fc-blue"><?=$member_info["name"];?></span>은(는) 상기 내용을 확인하였으며 그 내용에
					</p>
					<p class="popup-input">
						<input class="input-agree" name="agree" placeholder="동의함">
					</p>
					<div class="est-box nth-3">
						<a href="javascript: void(0);" onclick="javascript: agree_pay();" class="bg-blue fc-white br4">투자 동의</a>
					</div>
				</div>
				<a href="javascript:void(0);" onclick="popupClose('#popup-container1');" class="pop-close"></a>
			</div>
		</div>
	</div>	
		
	<div class="invst-popup" id="popup-container2" style="display: none;">
		<div class="popup-wrap">
			<div class="popup-container br4">
				<div class="popup-info-box br4" style=" text-align:center;">
					<?php
						$qrya = "select * from auto_pay where uid = '".$member_info["num"]."' and state = 'Y'";
						$resa = mysqli_query($dbconn, $qrya);
						$rowa = @mysqli_fetch_array($resa);

						$img_Link = "https://nurifunding.co.kr/img/invest_notice.jpg";
						if(!empty($rowa)) {
							$img_Link = "https://nurifunding.co.kr/img/invest_notice_auto.jpg";
						}
					?>
					<img src="<?=$img_Link;?>" alt="투자안내">
				</div>
				<div class="popup-form">
					<div id="div_ing">
						<img src="https://nurifunding.co.kr/img/progress-bar.gif" alt="진행중">
						<p class="fc-blue">문자메세지에 숫자 4자리 회신 후 투자가 완료됩니다!</p>
					</div>
					<div class="est-box nth-3">
						<a id="agr_btn" style="display:none;" href="https://www.nurifunding.co.kr/invest/end.php?num=GEtyGm0fbxdyTxoRRw==&#13;&#10;" class="bg-blue fc-white br4">투자가 완료되었습니다.</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	
			
	<!--// -->

<?php
	include_once(INC_DIR."/www/web-home/common/bottom.php");
?>