<?php
	$page_type = "mypage";

	$url = empty($_GET["url"]) ? "/" : $_GET["url"];

	include_once("/home/ebizpub/web-home/nurifunding.co.kr/www/web-home/common/top.php");
	include_once(INC_DIR.'/config/KISA_SEED_ECB.php');

	include_once (INC_DIR.'/config/aes.class.php');

	if(empty($member_info["num"]) || $member_info["num"] < 1) {
		echo "<script>
			alert('로그인 후 이용하실 수 있습니다.');
			location.href='./login.php';
		</script>";
		exit;
	}

	if($member_info["info"] != "Y") {
		echo "<script>
			location.href='./join_info.php';
		</script>";
		exit;
	}
	
	/*
	if($_POST["state"] != "Y") {
		echo "<script>
			alert('잘못된 접근입니다.');
			location.href='/';
		</script>";
	}
	*/
	
	$g_bszUser_key = "2b,7e,15,71,28,ae,d2,a6,cd,f7,15,11,09,aa,7f,3c";
	function decrypt($bszUser_key, $str) {
		$planBytes = explode(",",$str);
		$keyBytes = explode(",",$bszUser_key);
		
		for($i = 0; $i < 16; $i++)
		{
			$keyBytes[$i] = hexdec($keyBytes[$i]);
		}

		for ($i = 0; $i < count($planBytes); $i++) {
			$planBytes[$i] = hexdec($planBytes[$i]);
		}

		if (count($planBytes) == 0) {
			return $str;
		}

		$pdwRoundKey = array_pad(array(),32,0);

		$bszPlainText = null;
		$planBytresMessage = null;
		

		// 방법 1
		$bszPlainText = KISA_SEED_ECB::SEED_ECB_Decrypt($keyBytes, $planBytes, 0, count($planBytes));
		for($i=0;$i< @sizeof($bszPlainText);$i++) {
			$planBytresMessage .=  sprintf("%02X", $bszPlainText[$i]).",";
		}

		return substr($planBytresMessage,0,strlen($planBytresMessage)-1);
	}

	$dec	= decrypt($g_bszUser_key, $member_info["jumin"]);
	$decAr	= explode(",",$dec);

	$char = "";
	for($i=0; $i<count($decAr); $i++) {
		$dec_i = substr($decAr[$i], 1, 1);

		$char .= $dec_i;
	}

	$jumin	= $member_info["mtype"] != "2" ? $char : $member_info["jumin"];

	
	if($member_info["mtype"] != "2") {
		$jumin1	= substr($jumin, 0, 6);
		$jumin2	= substr($jumin, 6, 7);
	}
	
	$bank_list = array();
	//## =========================== 실계좌 등록을 위한 은행목록 조회 ===========================
	$url_1			= "/v5/code/listOf/banks";
	$val			= "_method=GET&reqMemGuid=".$Guid."";

	$result			= apiAct($url_1, $val, "GET", $Guid, $KeyP);

	foreach($result["data"] as $key => $val) {
		$bank_list[] = $val;
	}
	//## =========================== 실계좌 등록을 위한 은행목록 조회 - 끝 ===========================

	//## =========================== 실계좌 등록을 위한 증권사 조회 - 끝 ===========================
	$url_2			= "/v5/code/listOf/securities";
	
	$result2		= apiAct($url_2, "", "GET", $Guid, $KeyP);

	foreach($result2["data"] as $key => $val) {
		$bank_list[] = $val;
	}
	//## =========================== 실계좌 등록을 위한 증권사 조회 - 끝 ===========================
?>
	<script type="text/javascript" src="https://www.nurifunding.co.kr/post/post.php" charset="UTF-8"></script>

<script type="text/javascript">
	document.domain = "nurifunding.co.kr";

	function info_submit() {
		var mtype_val = $("input[name='mtype']:radio:checked").val();

		if(mtype_val == 1) {
			name_title = "이름을 입력해주세요.(2자 이상)"
		} else {
			name_title = "사업자명을 입력해주세요.(2자 이상)"
		}

		if($("input[name='name']").val() == "" || ($("input[name='name']").val()).length < 2) {
			alert(name_title);
			$("input[name='name']").focus();
			return false;
		}
		if($("input[name='cellphone']").val() == "") {
			alert("휴대전화를 입력해주세요.");
			$("input[name='cellphone']").focus();
			return false;
		}
		if(($("input[name='cellphone']").val()).length < 9) {
			alert("휴대전화를 바르게 입력해주세요");
			$("input[name='cellphone']").focus();
			return false;
		}
		if($("input[name='email']").val() == "") {
			alert("이메일주소를 바르게 입력해주세요");
			$("input[name='email']").focus();
			return false;
		}
		
		if($("input[name='addr']").val() == "") {
			alert("주소를 입력해주세요");
			$("input[name='addr']").focus();
			return false;
		}
		if($("input[name='addr_sub']").val() == "") {
			alert("주소를 입력해주세요");
			$("input[name='addr_sub']").focus();
			return false;
		}
		
		if(mtype_val == 1) {
			if(($("input[name='jumin']").val()).length < 6 && $("input[name='jumin']").val() != "") {
				alert("주민등록번호를 바르게 입력해주세요");
				$("input[name='jumin']").focus();
				return false;
			}
			
			if(($("input[name='jumin2']").val()).length < 7 && $("input[name='jumin2']").val() != "") {
				alert("주민등록번호를 바르게 입력해주세요");
				$("input[name='jumin2']").focus();
				return false;
			}
		} else {
			if(($("input[name='jumin3']").val()).length < 10 && $("input[name='jumin3']").val() != "") {
				alert("사업자 등록번호를 바르게 입력해주세요");
				$("input[name='jumin3']").focus();
				return false;
			}
		}

		$.ajax({
			type	:	"POST",
			data	:	$("#iform").serialize(),
			url		:	"/inc/state_new.php",
			success	:	function(data) {
				if(data == "SUCC") {
					alert("회원정보가 성공적으로 수정되었습니다.");
					location.href="<?=$url?>";
				} else {
					alert("[ERORR]저장에러 고객센터에 문의 부탁드립니다");
				}
			}
			
		})
	}

	function member_type(e) {
		var title1 = "이름";
		var title2 = "주민등록번호";

		switch(e) {
			case 2 :
				title1 = "사업자명";
				title2 = "등록번호";
				//$('.mib-p2').css('display','none');
				$('#mtype2_info').css('display','block');
				$('#mtype1_info').css('display','none');
			break;
			case 1 :
			default :
				title1 = "이름";
				title2 = "주민등록번호";
				//$('.mib-p2').css('display','block');
				$('#mtype2_info').css('display','none');
				$('#mtype1_info').css('display','block');
			break;
		}

		$('#mtype_t1').html(title1);
		//$('#mtype_t2').html(title2);

	}

	function bank_sel(val_name, val_code) {
		$('input[name="bank"]').val(val_name);
		$('input[name="bank_code"]').val(val_code);
	}
	
	function bank_insert() {
		var name	= "예치금계좌 발급받기";
		var url		= "/member/bank_insert.php";
		var ww		= window.open(url, name, "toolbar=no,scrollbars=yes,directories=no,status=no,menubar=no,width=500,height=500,resizable=no, top=50, left="+((screen.width - 450)/2)+"");
		ww.focus();
	}

	function r_bankChk() {
		var bankname	= $('input[name="bank"]').val();
		var banknum		= $('input[name="bank_no"]').val();
		var bankcode	= $('input[name="bank_code"]').val();

		var name	= "실계좌 등록하기";
		var url		= "/member/real_bank.php?bank="+bankname+"&banknum="+banknum+"&bankcode="+bankcode;
		var ww		= window.open(url, name, "toolbar=no,scrollbars=yes,directories=no,status=no,menubar=no,width=500,height=500,resizable=no, top=50, left="+((screen.width - 450)/2)+"");
	}

	
	function ssnCheck(_ssn1, _ssn2) {
		var ssn1    = _ssn1,
			ssn2    = _ssn2,
			ssn     = ssn1+''+ssn2,
			arr_ssn = [],
			compare = [2,3,4,5,6,7,8,9,2,3,4,5],
			sum     = 0;
	 
		// 입력여부 체크
		if (ssn1 == '') {
			alert('주민등록번호를 기입해주세요.');
			return false;
		}
	 
		if (ssn2 == '') {
			alert('주민등록번호를 기입해주세요.');
			return false;
		}   
	 
		// 입력값 체크
		if (ssn1.match('[^0-9]')) {
			alert("주민등록번호는 숫자만 입력하셔야 합니다.");
			return false;
		}
		if (ssn2.match('[^0-9]')) {
			alert("주민등록번호는 숫자만 입력하셔야 합니다.");
			return false;
		}
	 
		// 자리수 체크
		if (ssn.length != 13) {
			alert("올바른 주민등록 번호를 입력하여 주세요.");return false;
		}   
	 
	 
		// 공식: M = (11 - ((2×A + 3×B + 4×C + 5×D + 6×E + 7×F + 8×G + 9×H + 2×I + 3×J + 4×K + 5×L) % 11)) % 11
		for (var i = 0; i<13; i++) {
			arr_ssn[i] = ssn.substring(i,i+1);
		}
		 
		for (var i = 0; i<12; i++) {
			sum = sum + (arr_ssn[i] * compare[i]);
		}
	 
		sum = (11 - (sum % 11)) % 10;
		 
		if (sum != arr_ssn[12]) {
			alert("올바른 주민등록 번호를 입력하여 주세요.");
			return false;
		}
	 
		return true;
	}

	$(function() {
		member_type(<?=$member_info["mtype"];?>);
	});

</script>


<h2 class="com-ft">마이페이지</h2>
<form id="iform" >
<input type="hidden" name="mode" value="<?=XOREncode("member_info")?>" />
<!--02.비밀번호 입력 후 확인버튼 클릭시 노출-->
<section class="member-info com-mg">
<div class="container">

<div class="mi-box com-box row br3">
<h3 class="align-center">회원정보</h3>
<p class="mib-p0 align-center">회원정보를 입력해야 투자 하실 수 있습니다.</p>
<p class="mib-p1">
<span class="label">회원구분</span>
<?php
if($member_info["mtype"] != "") {

switch($member_info["mtype"]) {
case "1":	$mtype = "일반투자자";			break;
case "2":	$mtype = "과세법인투자자";		break;
case "3":	$mtype = "개인소득적격투자자";		break;
case "4":	$mtype = "전문투자자";			break;
case "5":	$mtype = "개인대부업투자자";		break;
case "6":	$mtype = "개인대부업소득적격자";	break;
case "7":	$mtype = "비과세법인투자자";		break;
}
?>
<input type="text" class="nr-text" value="<?=$mtype?>" readonly>
<input type="radio" name="mtype" value="<?=$member_info["mtype"];?>" checked style="display:none;" />
<!--span><?=$mtype;?></span-->
<?php
} else {
?>
<input type="radio" value="1" name="mtype" class="nr-radio" id="mtype1" onclick="javascript: member_type(1);" <?php if($member_info["mtype"] != "2") { echo "checked"; }?> /> <label for="mtype1">개인회원</label>
<input type="radio" value="2" name="mtype" class="nr-radio ml" id="mtype2" onclick="javascript: member_type(2);" <?php if($member_info["mtype"] == "2") { echo "checked"; }?> /> <label for="mtype2">법인회원</label>
<?php			
}
?>
</p>
<p class="mib-p1"><span class="label" id="mtype_t1">이름</span><input type="text" class="nr-text" name="name" readonly value="<?=$member_info["name"]?>" maxlength="20"></p>
<?php
if($member_info["phone"] != "") {
?>
<p class="mib-p1"><span class="label">휴대전화</span><input type="text" class="nr-text" name="cellphone" value="<?=$member_info["phone"]?>" readonly maxlength="11" onkeyup="javascript:checktype('number', 'cellphone')"></p>
<?php
} else {
?>
<p class="mib-p1"><span class="label">휴대전화</span><input type="text" class="nr-text" name="cellphone" value="" maxlength="11" onkeyup="javascript:checktype('number', 'cellphone')"></p>
<?php
}
?>
<p class="mib-p1"><span class="label">이메일주소</span><input type="text" class="nr-text" name="email" value="<?=$member_info["email"]?>" readonly></p>

<p class="mib-p1">
<span class="label">주소</span>

<input type="hidden" name="addr_zip" id="addrZip" />
<input type="text" name="addr" id="memberAdr" class="nr-text" value="<?=$member_info["addr1"]?>" onclick="javascript: ebizPost.search_popup();" readonly maxlength="255" style="cursor:pointer;">
<input type="text" class="nr-text detail" name="addr_sub" id="memberPhone" value="<?=$member_info["addr2"]?>" maxlength="255">
</p>

<!--input type="hidden" name="addr_zip" value="" />
<input type="hidden" name="addr1" value="<?=$member_info["addr1"]?>" />
<input type="hidden" name="addr2" value="<?=$member_info["addr2"]?>" /-->

<div id="mtype1_info">                   
<p class="mib-p1 type-prinum">
<span class="label" id="mtype_t2">주민등록번호</span>
<input type="text" class="nr-text" name="jumin" value="<?=$jumin1?>" placeholder="주민번호 앞 6자리" maxlength="6" onkeypress="javascript:checktype('number', 'jumin')" <?php if($member_info["jumin"] != '87,FB,A3,16,05,CD,AB,84,36,50,00,11,36,3D,A2,86') {?> readonly <?php } ?>>
<span class="deco-line">-</span>
<input type="password" class="nr-text" name="jumin2" value="<?=$jumin2?>" maxlength="7" placeholder="주민번호 뒷 7자리" onkeypress="javascript:checktype('number', 'jumin')">
</p>

<p class="mib-p2">
<span class="c-orange">왜 주민등록번호와 주소가 필요한가요?</span>
주민번호와 주소 정보는 현행 세법상 원천징수 납부에 사용됩니다. 주민번호와 주소 정보 없이도
사이트 이용은 가능하나, 현행 세법상 누리펀딩 내부의 투자는 이용하실 수없습니다.<br/>
사이트 탈퇴시 모든 개인정보는 즉시 삭제 됩니다.

<?php
if($_SERVER["REMOTE_ADDR"] == '61.74.233.194' || $_SERVER["REMOTE_ADDR"] == '61.74.233.195') {
?>
<br/><br/>
<input type="checkbox" name="is_sms" value="Y" <?php if($member_info["is_sms"] == "Y") { echo "checked"; } ?> />&nbsp;sms 수신
<br/>
<input type="checkbox" name="is_mail" value="Y"  <?php if($member_info["is_mail"] == "Y") { echo "checked"; } ?> />&nbsp;email 수신
<?php
}
?>

</p>          
</div>

<div id="mtype2_info">
<p class="mib-p1">
<span class="label" id="mtype_t2">사업자 등록번호</span>
<input type="text" class="nr-text" name="jumin3" value="<?=$jumin?>" onkeypress="javascript:checktype('number', 'jumin')" />

<?php
if($_SERVER["REMOTE_ADDR"] == '61.74.233.194' || $_SERVER["REMOTE_ADDR"] == '61.74.233.195') {
?>
<br/><br/>
<input type="checkbox" name="is_sms" value="Y" <?php if($member_info["is_sms"] == "Y") { echo "checked"; } ?> />&nbsp;sms 수신
<br/>
<input type="checkbox" name="is_mail" value="Y"  <?php if($member_info["is_mail"] == "Y") { echo "checked"; } ?> />&nbsp;email 수신
<?php
}
?>
</p>
</div>
<!--탈퇴 버튼추가-->
<div class="withdrawal-box">
	<button class="btn_withdrawal" type="button">회원탈퇴</button>
</div>
<!--탈퇴 버튼추가-->
<p class="mib-p3"><a href="javascript: info_submit();" class="btn fc-white bg-blue center-block align-center br4">저장하기</a></p>


</div>
</div>

</div>
</section>
</form>
<?php
	include_once(INC_DIR."/www/web-home/common/bottom.php");
?>