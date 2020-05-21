<?php

include("/home/ebizpub/web-home/nurifunding.co.kr/config/KB_Liiv_lib.php");


$tracking_cd = $_GET["tracking_cd"];
$kblm_param = str_replace(" ", "+", $_GET["kblm_param"]);

$kb_param = json_decode(aes_decode($kblm_param, $key));

$tm = $kb_param->tm;
$ci = $kb_param->ci;
$cid = $kb_param->cid;

$qry = "select * from liivmate where cid = '".$cid."'";
$res = mysqli_query($dbconn, $qry);
$num = mysqli_num_rows($res);

if($num < 1) {
?>
	<form action="./intro.php" method="post" name="kData" />
		<input type="hidden" name="tracking_cd" value="<?=$tracking_cd;?>" />
		<input type="hidden" name="tm" value="<?=$tm;?>" />
		<input type="hidden" name="ci" value="<?=$ci;?>" />
		<input type="hidden" name="cid" value="<?=$cid;?>" />
	</form>

	<script>
		window.document.kData.submit();
	</script>
<?php
} else {
	$row = mysqli_fetch_array($res);
	$member = mysqli_fetch_array(mysqli_query($dbconn, "select * from userid where num = '".$row["uid"]."'"));
	
	//# 로그인처리
	setcookie(XOREncode("userid"), XOREncode($member["userid"]), 0, "/", base_cookie);

	jsMsg('', './invest/list.php');
}




#api.nurifunding.co.kr/member_join.php?tracking_cd=CZOMCk2L4VqDZPFtr/2j72lmQ/KFry4+wJJaXaTA0qbbrmIk=&kblm_param=WpxI8Vmx0f/MsanzqvFoictGh7hheH0bFR9tcSyO2FkyxXdMz3hkFwRbqlp00QDEihEoeBaKX8ntIG9BIcN5qYTYmLc1xuPFFTlbXfp4xD5VTs04RMsqhmSXxLQD1NjBys9tROzWnFKyILA+Lm2cz5+5Ex4Nwo6rngxzyaoacN8iTTn//xnqYtFdccT4jBlsDNZreKaimaeOX8iYleqTQ81Yyhfo2Tl8+3IvxqgshYg5VwNUieGYcA3vjKgJvNbf