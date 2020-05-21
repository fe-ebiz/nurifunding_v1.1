<?php
	@header("Content-Type: text/html; charset=UTF-8");
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/config/config.php");


	$chk = "Y";
	if(empty($_POST["cid"]) || $_POST["cid"] == "") {	$chk = "N";	}
	if(empty($_POST["ci"]) || $_POST["ci"] == "") {	$chk = "N";	}
	if(empty($_POST["name"]) || $_POST["name"] == "") {	$chk = "N";	}
	if(empty($_POST["phone"]) || $_POST["phone"] == "") {	$chk = "N";	}

	if($chk == "Y") {

		$ci		= $_POST["ci"];
		$name	= $_POST["name"];
		$phone	= $_POST["phone"];
		$cid	= $_POST["cid"];

		$qry = "select * from liivmate where cid = '".$cid."'";
		$res = mysqli_query($dbconn, $qry);
		$num = mysqli_num_rows($res);

		if($num > 0) {
			$status = "Y";
			$msg = "Success";
		} else {

			//# 동일한 정보로 회원이 이미 있는지 확인
			$qry_m = "select num from member where ci = '".$ci."' and phone = '".$phone."' and name = '".$name."'";
			$qry_r = mysqli_query($dbconn, $qry_m);
			$qm_chk = mysqli_num_rows($qry_r);

			if($qm_chk > 0) {

				//# 이미 누리펀딩 회원일 경우 리브메이트 계정 연동 추가
				$member = mysqli_fetch_array($qry_r);
				$insert_q = "insert into liivmate (cid, uid, wdate) values ('".$cid."', '".$member["num"]."', now())";
				mysqli_query($dbconn, $insert_q);

				$status = "Y";
				$msg = "Success";

			} else {
				
				//# 누리펀딩 회원가입 진행
				$userid = $phone;
				$insert_q = "insert into member (userid, name, phone, pid, flag, wdate, ci) values";
				$insert_q .= " ('".$userid."', '".$name."', '".$phone."', 'liivmate', 'm', now(), '".$ci."')";
				$insert = mysqli_query($dbconn, $insert_q);

				$m_num = mysqli_insert_id($dbconn);

				if($m_num != "") {
					//# 가입완료 후 리브메이트 연동 저장
					$insert_q2 = "insert into liivmate (cid, uid, wdate) values ('".$cid."', '".$m_num."', now())";
					mysqli_query($dbconn, $insert_q2);

					$status = "Y";
					$msg = "Success";
				} else {
					$status = "N";
					$msg = "No Member";
				}
			}
		}

		$return = array();
		$return["status"] = $status;
		$return["msg"] = $msg;
		$return["cid"] = $cid;
	} else {
		$return = array();
		$return["status"] = "N";
		$return["msg"] = "Parameter Error";
	}

	echo json_encode($return);
?>