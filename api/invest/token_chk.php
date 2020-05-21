<?php

	header("Content-type:text/html; charset=utf-8;");
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/config/config.php");


	//# 365일 선인증 인증진행 api

	$url			= "/v5/transaction/auth/token";

	$val			= "_method=PUT";
	$val			.= "&reqMemGuid=".$Guid;
	$val			.= "&_lang=ko";
	$val			.= "&token=".$member_info["guid"];
	$val			.= "&text=".$_POST["txt"];
	$result			= apiAct($url, $val, "PUT", $Guid, $KeyP);	


	if($result["status"] != "ERROR") {
		$msg = $result["data"]["activityResult"];

		if($msg == "ALERT_MSG_ANSWER_YES") {
			$return = "SUCC^성공";
		} else {
			$return = "FAIL^";

			if($msg == "ALERT_MSG_ANSWER_TRY_AGAIN") {
				$return .= "인증번호를 확인해주세요.";
			} else {
				$return .= "다시 확인해주세요.";
			}
		}
	} else {
		$return = "FAIL^다시 시도해주세요.";
	}

	echo $return;