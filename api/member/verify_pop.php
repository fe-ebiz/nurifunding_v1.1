<?php
	foreach($_POST as $key=> $value) {
		$$key = $value;
	}

	if($_SERVER["REMOTE_ADDR"] != "61.74.233.194") {
		echo "<xmp>";
		print_r($_POST);
		echo "</xmp>";
		exit;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>KCB 생년월일 본인 확인서비스 </title>

		<script language="javascript" type="text/javascript" >
			document.domain = 'nurifunding.co.kr';
			function fncOpenerSubmit() {
				var birthday = '<?=$birthday;?>';
				var ssn1 = birthday.substring(2, 8);
				alert(opener.document.getElementById("verify_form").attr('name'));

				opener.document.getElementById("verify_form").di.value = "<?=$di;?>";
				opener.document.verify_form.ci.value = "<?=$ci;?>";
				opener.document.verify_form.name.value = "<?=$name;?>";
				opener.document.verify_form.gender.value = "<?=$gender;?>";
				opener.document.verify_form.phone.value = "<?=$tel_no;?>";
				opener.document.verify_form.jumin1.value = ssn1;

				opener.document.getElementById("verify-btn").style.display = "none";

				self.close();
			}	
		</script>
	</head>

	<body onload="javascript: fncOpenerSubmit()">
	</body>
</html>