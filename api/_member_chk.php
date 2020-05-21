<?php
	@header("Content-Type: text/html; charset=UTF-8");
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/config/config.php");


	$chk = "Y";
	if(empty($_POST["cid"]) || $_POST["cid"] == "") {	$chk = "N";	}

	if($chk == "Y") {

		$cid	= $_POST["cid"];

		$qry = "select * from liivmate where cid = '".$cid."'";
		$res = mysqli_query($dbconn, $qry);
		$num = mysqli_num_rows($res);

		if($num > 0) {
			$status = "Y";
			$msg = "Success";
		} else {
			$status = "N";
			$msg = "No Member";
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