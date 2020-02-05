<?php
	$page_type = "autoinv";

	$url = empty($_GET["url"]) ? "/" : $_GET["url"];

	include_once("/home/ebizdev/web-home/nurifunding.co.kr/www/web-home/common/top.php");
	include_once ('/home/ebizdev/web-home/nurifunding.co.kr/config/aes.class.php');

	if(empty($member_info["num"]) || $member_info["num"] < 1) {
		echo "<script>
			alert('로그인 후 이용하실 수 있습니다.');
			location.href='./login.php';
		</script>";
	}

	if($member_info["info"] != "Y") {
		echo "<script>
			location.href='./join_info.php';
		</script>";
	}

	
	$qry = "select * from auto_pay where uid = '".$member_info["num"]."' and state = 'Y'";
	$res = mysql_query($qry);
	$row = @mysql_fetch_array($res);

	if(empty($row)) {
		$at_price	= 0;
		$last_time	= 0;
		$last_day	= 0;
	} else {
		$at_price	= $row["price"] / 10000;
		$last_time	= time() - strtotime($row["wdate"]);
		$last_day	= 90 - (floor(($last_time) / 86400));
	}

	//## =========================== 멤버 잔액조회 ===========================
	$nonce			= $member_info["num"].time().substr(str_shuffle("1234567890"), 0, 3);

	$url			= "/v5/member/seyfert/inquiry/balance";

	$val			= "reqMemGuid=".$Guid;
	$val			.= "&_method=GET";
	$val			.= "&nonce=".$nonce;
	$val			.= "&_lang=ko";
	$val			.= "&dstMemGuid=".$member_info["guid"];
	$val			.= "&crrncy=KRW";

	$result			= apiAct($url, $val, "GET", $Guid, $KeyP);

	if($result["status"] == "SUCCESS") {
		$cash	= $result["data"]["moneyPair"]["amount"];
	} else {
		$cash	= 0;
	}
	//## =========================== 멤버 잔액조회 =========================== - 끝
?>


<script>
	function auto_txt_in() {
		var txt = $('#auto_txt').val();

		if(txt == "") {
			alert("인증번호를 입력해주세요.");
			return false;
		} else {
			$.ajax({
				type	:	"POST",
				data	:	{"txt":txt},
				url		:	"/member/auto/token_chk.php",
				success	:	function(data) {
					var ret = data.split("^");

					if(ret[0] == "FAIL") {
						alert(ret[1]);
					} else {
						alert("자동투자 설정이 완료되었습니다.");
						location.reload();
					}
				}
			});
		}
	}
</script>

<!-- 콘텐츠 영역 -->
		<div class="contents autoinv">
			<h2 class="page-tit ft-nt">선정산 상품 자동 투자 <span class="ic-new big">NEW</span></h2>
			<div class="cont">

				<!-- 190416 -->
				<div class="pop-container fixed autoinv" id="autopay_pop" style="display: none" onmousewheel="return false">
					<div class="bg-back"></div>

					<div class="pop-wrapper">
                        <?php
                            if($_SERVER["REMOTE_ADDR"] == "61.74.233.194") {
                        ?>
                        <div class="pop-contents">
                            <img src="http://nurifunding.co.kr/img/invest/autoinv_m_certi_new.png" alt="자동투자관련휴대폰인증안내" class="img-pop">
                            <div class="form-wrapper">
                                <div class="form-group">
                                    <label class="label"><span>인증번호(4자리)</span> <input type="text" class="form-base"></label>
                                </div>
                                <div class="form-group">
                                    <a href="javascript:;" class="btn-base btn-blue ok-btn" onclick="$(this).closest('.pop-container').hide()">인증확인</a>
                                </div>
                            </div>
                        </div>
                        <?php
                            } else {
                        ?>
                        <div class="pop-contents">
                            <img src="http://nurifunding.co.kr/img/invest/autoinv_m_certi.png" alt="자동투자관련휴대폰인증안내" class="img-pop">
                            <img src="https://nurifunding.co.kr/img/invest/loading_bar.gif" alt="로딩" class="loading">
                        </div>
                        <?php
                            }
                        ?>
					</div>
				</div>

				<section class="sec intro">
					<div class="sec-top">
						<h1 class="sec-tit ftfm-nt ta-center">선정산(미리페이) 상품 자동 투자 기능<span class="hidden-md">은</span><span
								class="hidden-xs">이란</span>?</h1>
					</div>
					<div class="sec-mid">
						<p class="row-txt ta-center">
							나의 투자성향에 맞게 <span class="c-blue">
								신규 선정산관련 상품이<span class="show-xs"></span> 나올 때 마다<span class="show-md"></span>
								'투자금액'으로 정하신 예치금 금액이<span class="show-xs"></span> 자동으로 투자되는 맞춤형 간편투자 기능
							</span>입니다.
						</p>
						<p class="row-txt small ta-center">
							본 기능은 투자 회원님의 보호를 위해 최초 동의 후<span class="show-xs"></span> 90일까지 적용되며,<span
								class="show-md"></span>
							연장 희망 시 재인증을 통해<span class="show-xs"></span> 기간연장을 하실 수 있습니다.
						</p>

						<!-- 190423 -->
						<div class="row-box type-02 ta-center">
							<span class="c-blue">나의 예치금 계좌</span> : <?=$member_info["debank"];?> / <?=$member_info["debank_no"];?><br/>
							<span class="c-blue">현재 예치금 잔액</span> : <?=@number_format($cash);?>원
						</div>


						<?php						
						$qry = "select * from auto_pay where uid = '".$member_info["num"]."' and state = 'Y'";
						$res = mysql_query($qry);
						$row = @mysql_fetch_array($res);

						if(empty($row)) {
						?>

							<!-- 투자 전 -->
							<div class="row-box type-01 ta-center">
								상품별 투자금액
								<div class="dropdown prc">
									<input type="hidden" name="at_cash" value="<?=$cash;?>" />
									<input type="hidden" name="at_price" value="" />

									<button type="button" class="btn">금액선택<span class="pull-right">▼</span></button>
									<ul class="dropdown-menu">
										<?php
											for($i=0; $i<count($atp_Arr); $i++) {
										?>
										<li><a href="#" onclick="javascript: auto_price(<?=$atp_Arr[$i];?>);"><?=$atp_Arr[$i];?>만원</a></li>
										<?php
											}
										?>
									</ul>
								</div>

								<br class="show-xs" />
								<span class="form-box">
									<label><input type="checkbox" name="autopay_chk" class="form-check" /> 자동투자에 동의함</label>
								</span>
							</div>
							<div class="row-btn">
								<a href="#" onclick="javascript: auto_ask(1);" class="btn-base btn-blue">자동투자 설정하기</a>
								<div class="cmt ta-center">
									<p class="c-red">※ 자동투자 금액에 비하여 예치금이 작을 경우<span class="show-xs"></span> 투자는 진행되지 않습니다.<br/>반드시 고객님의 예치금을 확인해주세요.</p>
									<p>※ 기능 설정 시 설정시점 이후의 선정산 상품부터<span class="show-xs"></span>자동투자가 시작됩니다.</p>
								</div>
							</div>
						<?php
						} else {
							$at_price	= $row["price"] / 10000;
							$last_time	= time() - strtotime($row["wdate"]);
							$last_day	= 90 - (floor(($last_time) / 86400));
							$end_day	= strtotime($row["wdate"]." +90 days");

							if($last_day > 30) {
								$ask_btn = "alert('자동투자 만료 30일 전부터 연장 가능합니다.');";
							} else {
								$ask_btn = "auto_ask(2);";
							}
						?>
							<input type="hidden" name="at_cash" value="<?=$cash;?>" />
							<input type="hidden" name="at_price2" value="<?=$at_price;?>" />
							<!-- 투자 후 -->

							<input type="hidden" name="at_index" value="<?=$row["num"];?>" />

							<div class="row-box type-01 ta-center">
								<span class="c-blue">
									<em><?=@number_format($at_price);?></em>만원 자동 투자 중
									<a href="javascript:void(0);" onclick="popupOpen('.pop-autoinv');" class="btn-base btn-blue">투자금 변경</a> 
								</span>
								<span class="sun"></span>
								<span class="hidden-xs">&nbsp;/&nbsp;</span> 
								잔여기한 [ <span class="c-red"><?=$last_day;?>일</span> ] 
								종료일 [ <span class="c-red"><?=date("Y-m-d", $end_day);?></span> ]
							</div>
							<div class="row-btn">
								<a href="#" onclick="javascript: <?=$ask_btn;?>" class="btn-base btn-blue">자동투자 기한 연장하기</a> 
								<a href="#" onclick="javascript: auto_cancel();" class="btn-base btn-gray">자동투자 해지하기</a> 
								<div class="cmt ta-center">※ 자동투자 해지는 반드시 누리펀딩 홈페이지에서만<span class="show-xs"></span> 이용해 주시기 바랍니다.</div>
							</div>
						<?php
						}
						?>
					</div>
				</section>
				<hr class="sun" />
				<section class="sec merit">
					<div class="sec-top">
						<h1 class="sec-tit ft-nt ta-center">너무 편리한 자동 투자 기능!</h1>
					</div>
					<div class="sec-mid">
						<p class="row-txt ta-center">
							나만의 투자성향으로 <span class="c-blue">신규 선정산 상품이<span class="show-xs"></span> 나올 때 마다 자동
								투자</span><span class="show-md"></span>
							자산도 투자도 자동으로 쉽고 빠르게 척척!
						</p>
						<div class="cf row-box">
							<ul class="list ta-center">
								<li class="item nth-1">
									<figure>
										<img src="https://nurifunding.co.kr/img/autoinv/pic_watch.png" alt="시계" />
										<figcaption>다른 일로 바빠도,<br />상품 오픈을 몰라도 OK!</figcaption>
									</figure>
								</li>
								<li class="item sun hidden-xs"></li>
								<li class="item nth-2">
									<figure>
										<img src="https://nurifunding.co.kr/img/autoinv/pic_gear.png" alt="자동" />
										<figcaption>내가 원하는 조건으로<br />자동 투자를 척척!</figcaption>
									</figure>
								</li>
								<li class="item sun hidden-xs"></li>
								<li class="item nth-3">
									<figure>
										<img src="https://nurifunding.co.kr/img/autoinv/pic_gold.png" alt="금" />
										<figcaption>상환금이 쉬지 않도록<br />재투자로 복리효과까지</figcaption>
									</figure>
								</li>
							</ul>
						</div>
						<p class="row-txt ta-center smart">이렇게 좋은 자동 투자기능! 이제 스마트하게 펀딩하세요.</p>
						<div class="row-txt notice">
							<strong>※ 자동투자 시 유의사항</strong>
							<p class="row row-dot">
								<span class="dot">1.</span> 자동투자는 유형에 맞는 상품이 오픈되면서 자동으로 투자가 진행되기때문에 상품에 관한 
									정보를 미리 알지 못한 상태에서 투자가 진행될 수 있습니다.
							</p>
							<p class="row row-dot">
								<span class="dot">2.</span> 자동투자 신청 전 이용방법, 상품 구조, 투자위험에 대해 충분히 숙지해주십시오.
							</p>
							<p class="row row-dot">
								<span class="dot">3.</span> 자동투자는 조건에 부합하는 상품이 오픈했을 때, 서비스 신청 순번에 따라 자동으로 투자가 
									진행됩니다.
							</p>
							<p class="row row-dot">
								<span class="dot">4.</span> 투자 상품이 오픈되어도 신청 순번이 도래하지 않거나 예치금 부족 등의 사유로 투자가
									진행되지 않을 수 있습니다. 이 경우 다음 투자상품 모집 시 해당 투자자들부터 신청 순번에 
									따라 자동투자가 진행됩니다.
							</p>
							<p class="row row-dot">
								<span class="dot">5.</span> 자동투자 후 투자된 상품의 모집이 완료되면 투자를 취소하거나 투자금액을 변경할 수  
									없습니다.
							</p>
						</div>
					</div>
				</section>
				<hr class="sun" />
				<section class="sec certi">
					<h1 class="text-hide">자동투자 설정 시 휴대폰 인증 안내</h1>
					<figure class="ta-center">
						<img src="https://nurifunding.co.kr/img/invest/autoinv_m_certi.png"
							alt="고객님의 휴대폰으로 전송된 인증관련 문자를 확인해주세요" />
						<!-- <img src="https://nurifunding.co.kr/img/invest/autoinv_m_certi_des.png"
							alt="고객님의 휴대폰으로 전송된 인증관련 문자를 확인해주세요" /> -->
					</figure>
				</section>
			</div>
		</div>

		<!-- 20190619 팝업 추가 -->
		<div class="pop-container pop-autoinv" style="display: none">
            <div class="bg-back"></div>
            <div class="pop-wrapper">
				<div class="pop-area clr">
                     <div class="row">
                        <div class="dropdown prc">
							<input type="hidden" name="at_upprice" value="0" />

                            <button type="button" class="btn">금액선택<span class="pull-right">▼</span></button>
                            <ul class="dropdown-menu">
								<?php
									for($i=0; $i<count($atp_Arr); $i++) {
								?>
								<li><a href="#" onclick="javascript: auto_update(<?=$atp_Arr[$i];?>);"><?=$atp_Arr[$i];?></a></li>
								<?php
									}
								?>
                            </ul>
                        </div>
                        <span>만원 자동투자</span>
                    </div>
                    <div class="row row-btn">
                        <a href="javascript:void(0);" onclick="auto_up_ask();" class="btn-base btn-blue"><span class="show-xs">변경</span><span class="hidden-xs">변경하기</span></a> 
                        <a href="javascript:void(0);" onclick="popupClose('.pop-autoinv');" class="btn-base btn-gray"><span class="show-xs">취소</span><span class="hidden-xs">변경취소</span></a> 
                    </div>
                </div>
            </div>
		</div>
		<!--// .pop-container.pop-autoinv-->

<?php
	include_once("/home/ebizdev/web-home/nurifunding.co.kr/www/web-home/common/bottom.php");
?>