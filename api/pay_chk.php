<?php
	@header("Content-Type: text/html; charset=UTF-8");
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/config/config.php");


	if(!empty($_POST["cid"]) && $_POST["cid"] != "") {
		$cid = $_POST["cid"];
		#$cid = "test1";

		$qry = "select * from liivmate where cid = '".$cid."'";
		$res = mysqli_query($dbconn, $qry);
		$num = mysqli_num_rows($res);

		$data = array();

		if($num < 1) {
			$status = "N";
			$msg = "No Member";
		} else {
			$row = mysqli_fetch_array($res);

			$where = "AND state = 'Y' AND gubun = '-' AND TYPE = 'none' AND goodsno > 0 AND goodsno != 493";

			$all_cnt = $ing_cnt = $end_cnt = 0;
			$all_money = $ing_money = $end_money = 0;

			$p_qry = "SELECT goodsno, price FROM pay WHERE uid = '".$row["uid"]."' ".$where." GROUP BY goodsno";
			$p_res = mysqli_query($dbconn, $p_qry);
			while($pay = mysqli_fetch_array($p_res)) {

				$price = $pay["price"];

				$goods = mysqli_fetch_array(mysqli_query($dbconn, "select state2 from goods where num = '".$pay['goodsno']."'"));

				switch($goods["state2"]) {
					case "Y":
					case "S" :
					case "G":
						$ing_cnt++;
						$ing_money+=$price;
					break;
					case "E":
						$end_cnt++;
						$end_money+=$price;
					break;
				}
				$all_cnt++;
				$all_money+=$price;
			}

			$status = "Y";
			$msg = "Success";

			#$data["all"] = array("cnt"=>$all_cnt, "price"=>$all_money);
			#$data["ing"] = array("cnt"=>$ing_cnt, "price"=>$ing_money);
			#$data["end"] = array("cnt"=>$end_cnt, "price"=>$end_money);
		}

		$return = array();
		$return["status"] = $status;
		$return["msg"] = $msg;

		if($status == "Y") {
			$return["all_cnt"] = $all_cnt;
			$return["all_money"] = $all_money;
			$return["ing_cnt"] = $ing_cnt;
			$return["ing_money"] = $ing_money;
			$return["end_cnt"] = $end_cnt;
			$return["end_money"] = $end_money;
		}
	} else {
		$return = array();
		$return["status"] = "N";
		$return["msg"] = "No CID";
	}

	
	echo json_encode($return);