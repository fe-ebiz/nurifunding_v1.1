<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/top.php";
?>
        <main id="container" class="container" role="main">
            <div class="page-content product-list-content">
                <div class="page-body">
                    <div class="body-title lv-title-l lv-group-1 mt-3">
                        <?=$member_info["name"];?>님이 투자하기 좋은<br>
                        고수익 이커머스 상품
                    </div>
                    <div class="body-subtitle lv-title-s text-notemphasis lv-group-1 mt-1">
                        1만원부터 투자가능한 연 10% 고수익 상품!
                    </div>
                    <div class="product-list-wrapper lv-group-1">
                        <ul class="product-list">
							<?php
								if($_SERVER["REMOTE_ADDR"] == "61.74.233.194") {
									$qry = "select * from goods where num = 7";
								} else {
									$qry = "select * from goods where state = 'Y' and  and liiv = 'Y' order by num desc";
								}
								$res = mysqli_query($dbconn, $qry);
								while($row = mysqli_fetch_array($res)) {
									$name = mb_substr($row["name"], 0, 20);
									$name = $name."...";

									$sdate = date("m.d H:i", strtotime($row["sdate"]));
									$edate = date("m.d H:i", strtotime($row["edate"]));

									$state_btn = "";
									if(time() < strtotime($row["sdate"])) {
										$state_btn = '<span class="lv-btn-flag text-base bor-0 badge-period">예정</span>';
									} else {
										$state_btn = '<span class="lv-btn-flag text-blue border-blue badge-period">모집중</span>';
									}
							?>
                            <li class="product-item">
                                <a href="./view.php?num=<?=$row["num"];?>">
                                    <div class="item-title lv-text"><?=$name;?></div>
                                    <div class="item-text lv-title-l d-flex align-items-center justify-content-space-between">
                                        <div class="">
                                            <span class="text-blue"><b>연 <?=$row["profit"];?>%</b></span> <b><?=$row["end_turn"];?>개월</b>
                                        </div>
                                        <img src="https://nurifunding.co.kr/img/livemate/common/arr_right_black.svg" alt="이동" class="init">
                                    </div>
                                    <div class="item-period">
                                        <?=$state_btn;?><span class="lv-text text-support"><?=$sdate;?> ~ <?=$edate;?></span>
                                    </div>
                                </a>
                            </li>
							<?php
								}
							?>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
        <!-- /.container -->

<?php
	include "/home/ebizpub/web-home/nurifunding.co.kr/api/web-home/common/bottom.php";
?>