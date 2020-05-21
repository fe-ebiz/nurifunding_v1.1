<?php

	//## =========================== 멤버 한도조회 ===========================			
	$limit_1	= $member_limit["limit1"];	// 동일 차업자 한도
	$limit_2	= $member_limit["limit2"];	// 플랫폼 투자한도
	$limit_3	= $member_limit["limit3"];	// 부동산 한도
	$limit_4	= $member_limit["limit4"];	// 동산 한도

	$limit1		= 0;	// 동일 차업자 한도
	$limit2		= 0;	// 전체금액
	$limit3		= 0;	// 부동산
	$limit4		= 0;	// 동산

	$mem_chk_qry	= "SELECT SUM(a.price) AS all_price, b.gtype as gtype, b.uid as goods_uid FROM pay AS a LEFT JOIN goods AS b ON a.goodsno = b.num WHERE a.uid = ".$member_info["num"]." AND a.state = 'Y' AND a.type='none' AND a.gubun = '-' GROUP BY a.goodsno";
	$mem_chk_res	= mysqli_query($dbconn, $mem_chk_qry);
	while($mem_all	= mysqli_fetch_array($mem_chk_res)) {
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

	//## =========================== 멤버 잔여 한도 조회 (투자금 - 회수원금) ===========================	
	$money_qry		= "SELECT SUM(a.price) AS all_price, b.gtype AS gtype, b.uid AS goods_uid FROM pay AS a LEFT JOIN goods AS b ON a.goodsno = b.num WHERE a.uid = ".$member_info["num"]." AND a.state = 'Y' AND a.type2 = 'money' AND a.gubun = '+' GROUP BY a.goodsno";
	$money_res		= mysqli_query($dbconn, $money_qry);
	while($money	= mysqli_fetch_array($money_res)) {
		switch($money["gtype"]) {
			case '부동산' :
				$limit3 -= $money["all_price"];
			break;
			case '동산' :
				$limit4 -= $money["all_price"];
			break;
		}
		if($money["goods_uid"] == $row["uid"]) {
			$limit1 -= $money["all_price"];
		}

		$limit2		= $limit2 - $money["all_price"];
	}
	//## =========================== 멤버 잔여 한도 조회 (투자금 - 회수원금) - 끝 ===========================

	$this_price	= $limit1 + $_price;
	$all_price	= $limit2 + $_price;
	$limit_pri3	= $limit3 + $_price;
	$limit_pri4	= $limit4 + $_price;

	if($this_price > $limit_1) {
		echo 'FAIL^동일 차업자에 대한 투자한도가 초과되었습니다.';
		exit;
	}

	if($all_price > $limit_2) {
		echo 'FAIL^플랫폼 투자한도가 초과되었습니다.';
		exit;
	}

	if($row["gtype"] == "부동산") {
		if($limit_pri3 > $limit_3) {
			echo 'FAIL^부동산 상품에 대한 투자한도가 초과되었습니다.';
			exit;
		}
	} else {
		if($limit_pri4 > $limit_4) {
			echo 'FAIL^동산 상품에 대한 투자한도가 초과되었습니다.';
			exit;
		}
	}

?>