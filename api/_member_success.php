<?php


include_once "/home/ebizpub/web-home/nurifunding.co.kr/config/config.php";
include "/home/ebizpub/web-home/nurifunding.co.kr/config/KB_Liiv_lib.php";
include "/home/ebizpub/web-home/nurifunding.co.kr/config/Snoopy_class.php";

$tracking_cd = "CZOMCk2L4VqDZPFtr/2j72lmQ/KFry4+wJJaXaTA0qbbrmIk=";

$pA = array();
$pA["trackingCd"]	= $tracking_cd;
$pA["affCd"]		= $affCd;
$pA["affPdCd"]		= $affPdCd;

$pp = json_encode($pA);

$mnum = "2654";
$phone = "01085252069";
$ci = "TESTCI1584066284653zEJsTjU\/89scmfMSF8cOKqVzdSxZS6Why7cnwoRSGIVBLWPyY0Q+y8\/53yUkY4flpAg==";

$epA = array();
$epA["tranID"]	= XOREncode($mnum.$phone);
$epA["uID"]		= $ci;
$epA["uFlag"]	= "1";

$ep = json_encode($epA);
$ep = aes_encode($ep, $key);

$url = $kbUrl."/uaasv3/FIN031A.do";


$data = array();
$data["pp"] = $pp;
$data["ep"] = $ep;

$header = array();
$header[] = "Content-type: application/json";
$header[] = "charset: UTF-8";
$header[] = "Accept: application/json";


$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $url);

$headers = [
    'Accept: application/json',
    'Content-Type: application/json; charset=utf-8'
];

curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', 'charset: UTF-8'));

#curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt ($ch, CURLOPT_VERBOSE, true);

curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);

#curl_setopt ($ch, CURLOPT_SSLVERSION,3);
curl_setopt ($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
curl_setopt ($ch, CURLOPT_POST, 1);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);


$result = curl_exec ($ch);

print_r($result);
echo "\r\n";
print_r($data);

echo "\r\n";
echo $url;


/*
print_r(curl_getinfo($ch)); //모든정보 출력
echo "errno : ".curl_errno($ch); //에러정보 출력
echo "error : ".curl_error($ch); //에러정보 출력

*/


curl_close ($ch);


exit;