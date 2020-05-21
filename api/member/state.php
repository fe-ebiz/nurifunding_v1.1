<?php
	@header("Content-Type: text/html; charset=UTF-8");
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/config/config.php");
	include_once (INC_DIR.'/config/KISA_SHA256.php');
	include_once (INC_DIR.'/config/aes.class.php');

	function encrypt($str) {
		$planBytes = array_slice(unpack('c*',$str), 0);
		$ret = null;
		$bszChiperText = null;
		KISA_SEED_SHA256::SHA256_Encrypt($planBytes, count($planBytes), $bszChiperText);
		$r = count($bszChiperText);

		foreach($bszChiperText as $encryptedString) {
			$ret .= bin2hex(chr($encryptedString));
		}
		return $ret;
	}

	
	foreach($_POST as $key=> $value) {
		$$key = $value;
	}

	$url			= "/v5/code/listOf/availableVABanks/p2p/permanent/ko";
	$result			= apiAct($url, "", "", $Guid, $KeyP);

	switch(XORDecode($mode)) {
		case "join":
			$pass = encrypt($pw1);

			if($_SERVER["REMOTE_ADDR"] == "61.74.233.194") {
				$q_chk = "select * from member where name = 'qweaazxcv'";
			} else {
				$q_chk = "select * from member where phone = '".$phone."' || ci = '".$ci."'";
			}

			$r_chk = mysqli_query($dbconn, $q_chk);
			$num = mysqli_num_rows($r_chk);
			if($num > 0) {
				jsMsg('누리펀딩에 가입되어있는 회원입니다.', '../intro.php');
			} else {
				# 회원가입
				$qry = "insert into member (userid, pass, phone, is_sms, is_mail, pid, flag, state, wdate, ad1, ad2, type, name, ci, di, jumin) values ('".$phone."', '".$pass."','".$phone."','Y', 'Y','liivmate','".user_flag."','Y',now(),'".$ad1."','".$ad2."', 'liivmate', '".$name."', '".$ci."', '".$di."', '".$jumin."')";

				mysqli_query($dbconn, $qry);
				$mnum = mysqli_insert_id($dbconn);

				$liv_q = "insert into liivmate (cid, uid, wdate) values ('".$cid."', '".$mnum."', now())";
				mysqli_query($dbconn, $liv_q);

				//# 리브메이트 데이터 전송
				include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/_member_success.php";

				# 페이게이트 Guid 발급
				$url			= "/v5a/member/createMember";

				$val			= "_method=POST";
				$val			.= "&reqMemGuid=".$Guid."";
				$val			.= "&desc=desc";
				$val			.= "&phoneNo=".$phone."";
				$val			.= "&phoneCntryCd=KOR";
				$val			.= "&keyTp=PHONE";
				$val			.= "&memberType=PRIVATE";
				
				$result			= apiAct($url, $val, "POST", $Guid, $KeyP);

				$guid = "";
				if($result["status"] == "SUCCESS") {
					$guid = $result["data"]["memGuid"];
					$qry = "update member set guid = '".$guid."' where num = '".$mnum."'";
					mysqli_query($dbconn, $qry);

					$debank_code	= "SC_023";
					$debank			= "SC제일은행";

					//==================== 2018.02.23 박상현 : 가상계좌 할당 ====================
					$url2			= "/v5a/member/assignVirtualAccount/p2p";

					$val2			= "reqMemGuid=".$Guid;
					$val2			.= "&_method=PUT";
					$val2			.= "&_lang=ko";
					$val2			.= "&nmLangCd=ko";
					$val2			.= "&dstMemGuid=".$guid;
					$val2			.= "&bnkCd=".$debank_code;

					$result2			= apiAct($url2, $val2, "PUT", $Guid, $KeyP);

					if($result2["status"] != "SUCCESS") {
						jsMsg('가상계좌 생성에 실패했습니다.', '../intro.php');
					} else {
						$qry	= "update member set ";
						$qry	.= "debank = '".$debank."', debank_code = '".$debank_code."', debank_no = '".$result2["data"]["accntNo"]."', debank_name = '".$name."'";
						$qry	.= " where num = '".$mnum."'";

						$u_sql	= mysqli_query($dbconn, $qry);

						if($u_sql) {
							//# 로그인처리
							setcookie(XOREncode("userid"), XOREncode($phone), 0, "/", base_cookie);
							jsMsg('누리펀딩 회원가입이 완료되었습니다.', './complete.php?num='.XOREncode($mnum).'');
						}
					}
				} else {
					jsMsg('다시 시도해주세요.', '../intro.php');
				}
			}

		break;
		default:
		break;
	}

	include_once(INC_DIR."/config/closedb.php");
?>