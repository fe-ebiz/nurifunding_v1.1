<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";
?>		
		<script>
			document.domain = 'nurifunding.co.kr';
			function verify_chk() {
				alert("'본인인증' 후 회원가입이 가능합니다 ");

				$('form[name="iData"]').submit();
				
				//var url		= "http://verify.nurifunding.co.kr/chk/cert2.php";
				//location.href = url;

				//var ww		= window.open(url, name, "toolbar=no,scrollbars=yes,directories=no,status=no,menubar=no,width=500,height=600,resizable=no");
				//ww.focus();
		
			}
		</script>
		
		<form name="iData" method="POST" action="http://verify.nurifunding.co.kr/chk/cert2.php" />
			<?php
				foreach($_POST as $key => $val) {
			?>
			<input type="hidden" name="<?=$key;?>" value="<?=$val;?>" />
			<?php
				}
			?>
		</form>

        <main id="container" class="container" role="main">
            <div class="page-content verify-content">
                <div class="page-body">
                    <div class="body-title lv-title-l">
                        본인인증을 진행해주세요.
                    </div>
                    <div class="verify-form-list mt-type-1">
                        <div class="text">
						
							<div class="form-group d-flex align-items-center justify-space-between">
								<div class="lv-form-input-cover">
									<input type="text" class="lv-form-input lv-title-s" onclick="javascript: verify_chk();" placeholder="이름">
									<i class="lv-form-text-remove" data-role="form-text-remove"><img src="https://nurifunding.co.kr/img/livemate/common/form_text_remove.svg" alt="입력텍스트삭제"></i>
								</div>
							</div>
							<div class="form-group d-flex align-items-center justify-space-between">
								<div class="lv-form-input-cover">
									<input type="text" class="lv-form-input lv-title-s" onclick="javascript: verify_chk();" placeholder="휴대폰번호">
									<i class="lv-form-text-remove" data-role="form-text-remove"><img src="https://nurifunding.co.kr/img/livemate/common/form_text_remove.svg" alt="입력텍스트삭제"></i>
								</div>
							</div>
							<div class="form-group d-flex align-items-center justify-space-between">
								<div class="lv-form-input-cover">
									<input type="text" class="lv-form-input lv-title-s" onclick="javascript: verify_chk();" placeholder="주민등록번호">
									<i class="lv-form-text-remove" data-role="form-text-remove"><img src="https://nurifunding.co.kr/img/livemate/common/form_text_remove.svg" alt="입력텍스트삭제"></i>
								</div>
							</div>

                        </div>
                    </div>
                </div>
                <div class="page-footer">
                    <div class="lv-btn-float-cover">
                        <!-- 필수 체크 됐을 경우 disabled 제거 -->
                        <a href="./verify_02.html" class="lv-btn-primary" disabled>다음</a>
                        <!-- <a href="./verify_02.html" class="lv-btn-primary">다음</a> -->
                    </div>
                </div>
            </div>
        </main>
        <!-- /.container -->


<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>