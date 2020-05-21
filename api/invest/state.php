<?php
	@header("Content-Type: text/html; charset=UTF-8");
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/config/config.php");
	include_once(INC_DIR.'/config/KISA_SHA256.php');


	function encrypt($str) {
		$planBytes = array_slice(unpack('c*',$str), 0); // 평문을 바이트 배열로 변환
		$ret = null;
		$bszChiperText = null;
		KISA_SEED_SHA256::SHA256_Encrypt($planBytes, count($planBytes), $bszChiperText);
		$r = count($bszChiperText);

		foreach($bszChiperText as $encryptedString) {
			$ret .= bin2hex(chr($encryptedString)); // 암호화된 16진수 스트링 추가 저장
		}
		return $ret;
	}

	foreach($_POST as $key=> $value) {
		$$key = $value;
	}

	switch(XORDecode($mode)) {
		case "tid_chk" :
			$qry	= "select state from pre_pay where tid = '".$tid."'";
			$res	= mysqli_query($dbconn, $qry);
			$row	= mysqli_fetch_array($res);

			echo $row["state"];
		break;
	}

	include_once(INC_DIR."/config/closedb.php");