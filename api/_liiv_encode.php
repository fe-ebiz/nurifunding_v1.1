<?php

include("/home/ebizpub/web-home/nurifunding.co.kr/config/KB_Liiv_lib.php");

$kb_param = array("tm"=>"1589354018","ci"=>"odGppVcGcG96k1KxzlOyPaC9OBrVKsWP5Glf4DYyjq68jUpl0cRqqDsvHQyomk/nX+90J7yqH1p2XmmFMaEelw==","cid"=>"34adca9d72a5758629e69ce8cf6d6eb071afceb37c76173275cb7285399ef08d");
$kb_param = json_encode($kb_param);

echo aes_encode($kb_param, $key);