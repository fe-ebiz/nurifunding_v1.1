<?php
	@header("Content-Type: text/html; charset=UTF-8");
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/config/config.php");
	include_once (INC_DIR.'/config/aes.class.php');

	foreach($_POST as $key=> $value) {
		$$key = $value;
	}


	$ordno = array();

	$pid = empty($_COOKIE["pid"]) ? "home" : $_COOKIE["pid"];
	$ad1 = empty($_COOKIE["c_adsort1"]) ? "X" : $_COOKIE["c_adsort1"];
	$ad2 = empty($_COOKIE["c_adsort1"]) ? "X" : $_COOKIE["c_adsort2"];

	$goodsno = XORDecode($_POST["goodsno"]);
	$_price = $_POST["use_cash"]*10000;

	if(!empty($goodsno) && $goodsno > 0) {
		$state = "Y";
		$qry = "select * from goods where num = '".$goodsno."'";
		$res = mysqli_query($dbconn, $qry);
		$row = mysqli_fetch_array($res);
		if(!$row["num"]) {
			echo 'FAIL^잘못된 접근입니다.';
			exit;
		}

		if(($row["price"] - $row["mprice"]) < $_price){
			echo 'FAIL^모집금액을 초과할 수 없습니다.';
			exit;
		}	

		// 회원 플랫폼 / 대출자별 / 상품 타입별 한도조회
		include("./limit_chk.php");

		//## ======================================== 오버부킹 방지용 한도조회 ========================================
		$o_qry	= "SELECT sum(price) as price FROM pay WHERE goodsno = '".$goodsno."' AND state = 'Y' AND gubun = '-' AND TYPE = 'none'";
		$o_res	= mysqli_query($dbconn, $o_qry);
		$o_row	= mysqli_fetch_array($o_res);
		$over	= $o_row["price"];

		$over_chk	= $over + $_price;

		if($over_chk > $row["price"]) {
			echo "FAIL^투자가 진행중입니다.\n잠시후에 다시 시도해주세요.";
			exit;
		}
		//## ======================================== 오버부킹 방지용 한도조회 - 끝 ========================================		

		//## =========================== 멤버 잔액조회 ===========================
		$_url			= "/v5/member/seyfert/inquiry/balance";

		$_val			= "reqMemGuid=".$Guid;
		$_val			.= "&_method=GET";
		$_val			.= "&_lang=ko";
		$_val			.= "&dstMemGuid=".$member_info["guid"];
		$_val			.= "&crrncy=KRW";

		$_result			= apiAct($_url, $_val, "GET", $Guid, $KeyP);

		if($_result["status"] == "SUCCESS") {
			$info_cash	= $_result["data"]["moneyPair"]["amount"];
		} else {
			$info_cash	= 0;
		}
		//## =========================== 멤버 잔액조회 - 끝 ===========================	
		
		$price_rest = $info_cash - $_price;

		$rand = substr(str_shuffle("1234567890"), 0, 3);
		$order_id = time().$rand;

		//# 회원유형
		switch($member_info["mtype"]) {
			case "4" :
			case "3" :
				$src_mType	= "IB";
			break;
			case "2" :
				$src_mType	= "IC";
			break;
			case "1" :
			default:
				$src_mType	= "IA";
			break;
		}

		$pre_pay_qry = "insert into pre_pay (ono, uid, goodsno, price, wdate, pid, ad1, ad2, state, price_rest, flag) values ('".$order_id."', '".$member_info["num"]."', '".$goodsno."', '".$_price."', now(), '".$pid."', '".$ad1."', '".$ad2."', 'N', '".$price_rest."', '".user_flag."')";
		$pre_pay_res = mysqli_query($dbconn, $pre_pay_qry);

		$pay_index = mysqli_insert_id($dbconn);

		//## =========================== p2p 용 이체확정보류 ===========================
		$url			= "/v5/transaction/seyfert/transferPending/p2p";

		$val			= "reqMemGuid=".$Guid;
		$val			.= "&_method=POST";
		$val			.= "&_lang=ko";

		$val			.= "&title=누리펀딩 ".$row["num"]."호".$msg["invest"];	// 거래제목 ( 및 설명 )
		$val			.= "&refld=".$order_id;						// 거래번호
		$val			.= "&authType=".$member_info["auth_type"];

		$val			.= "&srcMemGuid=".$member_info["guid"];		// 돈 내는사람
		$val			.= "&dstMemGuid=".$Guid;					// 돈 받는사람
		$val			.= "&amount=".$_price;				// 금액
		$val			.= "&crrncy=KRW";							// 단위
		$val			.= "&transferReason=investment";			// 거래형태
		$val			.= "&srcMemType=".$src_mType;				// 돈 내는사람 유형
		$val			.= "&dstMemType=PA";						// 돈 받는사람 유형
		$val			.= "&authSessionTimeout=0";					// 인증여부 ( 매번 인증 )

		$result			= apiAct($url, $val, "POST", $Guid, $KeyP);		
		//## =========================== p2p 용 이체확정보류 - 끝 ===========================

		if($result["status"] == "SUCCESS") {
			$pay_qry = "update pre_pay set tid = '".$result["data"]["tid"]."', state = 'T' where num = '".$pay_index."'";
			$pay_res = mysqli_query($dbconn, $pay_qry);

			$ordno[] = $order_id;
		} else {
			echo "FAIL^투자가 실패되었습니다.";
			exit;
		}
	} else {
		echo 'FAIL^잘못된 접근입니다.';
		exit;
	}


	if($_price <= $info_cash) {		
		$ono2 = implode("||", $ordno);
		echo "SUCC^".$result["data"]["tid"]."^".XOREncode($ono2);
	} else {
		echo "FAIL^잔액이 부족합니다.";
	}
?>

<?php
	include_once(INC_DIR."/config/closedb.php");
?>