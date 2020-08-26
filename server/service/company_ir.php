<?php
	$page_type = "service";
	include_once("/home/ebizpub/web-home/nurifunding.co.kr/www/web-home/common/top.php");
?>
<!--테이블용 CSS (ir-table)-->
<link rel="stylesheet" href="https://nurifunding.co.kr/static/css/service/service_table.css">
<!--테이블용 CSS-->

		<section class="page-sect">
			<div class="container">
				<div class="ps-wrap com-box">
					<!--변경내용 제목변경-->
					<h2 class="ps-h2">기업 IR 정보</h2>
				</div>
			</div>
		</section>

		<section class="info-sect ir-sect">
			<div class="container">
				<h2 class="">누리펀딩 <span class="c-blue">사업정보제공</span></h2>
			</div>
			<div class="container cont-ir cont-struc">
				<h3><span class="c-blue">1. </span>P2P 대출의 구조 및 영업방식, 상품유형별 누적 대출금액, 대출잔액, 연체율, 연체건수(비중 포함)</h3>
				<div class="subtit"><span class="c-blue"><span class="dot">■</span> <span>2020년 7월</span></span> <span class="pull-right unit">(단위: 만원)</span></div>
				<div class="ir-table">
                    <!--모바일을 위해 3개로 쪼갬-->
                    <div class="table-area">
                        <ul class="ul-header">
                            <li><p>구분</p></li>
                            <li><p>전월말 기준</p></li>
                            <li><p>신용</p></li>
                            <li><p>부동산 담보</p></li>
                            <li><p>부동산 PF</p></li>
                            <li><p>매출채권</p></li>
                            <li><p>총계</p></li>
                        </ul>
                        <ul>
                            <li><p>누적대출금액</p></li>
                            <li><p>3,948,906</p></li>
                            <li><p></p></li>
                            <li><p>6,000</p></li>
                            <li><p></p></li>
                            <li><p>4,212,514</p></li>
                            <li><p>4,218,514</p></li>
                        </ul>
                        <ul>
                            <li><p>대출잔액</p></li>
                            <li><p>382,786</p></li>
                            <li><p></p></li>
                            <li><p>3,000</p></li>
                            <li><p></p></li>
                            <li><p>342,994</p></li>
                            <li><p>345,994</p></li>
                        </ul>
                    </div>
                    <div class="table-area">
                        <ul class="pc-hidden ul-header">
                            <li><p>구분</p></li>
                            <li><p>전월말 기준</p></li>
                            <li><p>신용</p></li>
                            <li><p>부동산 담보</p></li>
                            <li><p>부동산 PF</p></li>
                            <li><p>매출채권</p></li>
                            <li><p>총계</p></li>
                        </ul>
                        <ul>
                            <li><p>연체율</p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p>0</p></li>
                        </ul>
                        <ul>
                            <li><p>연체건수/<br>연체비중</p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p>0</p></li>
                        </ul>
                        <ul>
                            <li><p>부실채권/<br>매각내역</p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p>0</p></li>
                        </ul>
                    </div>
                    <div class="table-area">
                        <ul class="pc-hidden ul-header">
                            <li><p>구분</p></li>
                            <li><p>전월말 기준</p></li>
                            <li><p>신용</p></li>
                            <li><p>부동산 담보</p></li>
                            <li><p>부동산 PF</p></li>
                            <li><p>매출채권</p></li>
                            <li><p>총계</p></li>
                        </ul>
                        <ul>
                            <li><p>매각대금</p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p>0</p></li>
                        </ul>
                        <ul>
                            <li><p>부실채권금액</p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p>0</p></li>
                        </ul>
                        <ul>
                            <li><p>매각처</p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p></p></li>
                            <li><p>0</p></li>
                            <li><p>0</p></li>
                        </ul>
                    </div>
                </div>
				<!-- <div class="cf grid-tbl vertical struc-tbl">
					<ul class="cf nth-1 rowCol">
						<li class="cell th-cell"><div class="inCell">구분</div></li>
						<li class="cell td-cell"><div class="inCell">전월말 기준</div></li>
						<li class="cell td-cell"><div class="inCell">신용</div></li>
						<li class="cell td-cell"><div class="inCell">부동산 담보</div></li>
						<li class="cell td-cell"><div class="inCell">부동산 PF</div></li>
						<li class="cell td-cell"><div class="inCell">매출채권</div></li>
						<li class="cell td-cell total-cell"><div class="inCell">총계</div></li>
					</ul>
					<ul class="cf nth-2 rowCol">
						<li class="cell th-cell"><div class="inCell">누적대출금액</div></li>
						<li class="cell td-cell"><div class="inCell">2,683,516</div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell">3,000</div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell">2,989,841</div></li>
						<li class="cell td-cell total-cell"><div class="inCell">2,992,841</div></li>
					</ul>
					<ul class="cf nth-3 rowCol">
						<li class="cell th-cell"><div class="inCell">대출잔액</div></li>
						<li class="cell td-cell"><div class="inCell">277,592</div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell">0</div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell">323,841</div></li>
						<li class="cell td-cell total-cell"><div class="inCell">323,841</div></li>
					</ul>
					<div class="cf show-xs division"></div>
					<ul class="cf nth-1 rowCol show-xs">
						<li class="cell th-cell"><div class="inCell">구분</div></li>
						<li class="cell td-cell"><div class="inCell">전월말 기준</div></li>
						<li class="cell td-cell"><div class="inCell">신용</div></li>
						<li class="cell td-cell"><div class="inCell">부동산 담보</div></li>
						<li class="cell td-cell"><div class="inCell">부동산 PF</div></li>
						<li class="cell td-cell"><div class="inCell">매출채권</div></li>
						<li class="cell td-cell total-cell"><div class="inCell">총계</div></li>
					</ul>
					<ul class="cf nth-4 rowCol">
						<li class="cell th-cell"><div class="inCell">연체율</div></li>
						<li class="cell td-cell"><div class="inCell">0</div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell">0</div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell">0</div></li>
						<li class="cell td-cell total-cell"><div class="inCell">0</div></li>
					</ul>
					<ul class="cf nth-5 rowCol">
						<li class="cell th-cell row-2"><div class="inCell">연체건수/<br>연체비중</div></li>
						<li class="cell td-cell"><div class="inCell">0</div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell">0</div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell">0</div></li>
						<li class="cell td-cell total-cell"><div class="inCell">0</div></li>
					</ul>
					<ul class="cf nth-6 rowCol">
						<li class="cell th-cell row-2"><div class="inCell">부실채권/<br>매각내역</div></li>
						<li class="cell td-cell"><div class="inCell">0</div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell">0</div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell">0</div></li>
						<li class="cell td-cell total-cell"><div class="inCell">0</div></li>
					</ul>
				</div> -->
				<p class="add-info">
					* 연체율 15% 초과한 경우와 금융사고 발생 등은 사유가 발생한 날의 다음날까지 공개
				</p>
				<p class="add-info">
					* 매월 15일 까지 전월 실적 공지 및 누적대출금액. 대출잔액.연체율.연체건수는 과거 5년간 사업연도별 구분하여 공시
				</p>
				<p class="add-info">
					* 청산업무절차는 법무법인(유한)대륙아주와 업무제휴 협약서를 체결하여 청산업무를 위탁하였습니다.(체결일:2019.2.20.) 
				</p>
			</div>

			<div class="container cont-ir cont-finance">
				<h3><span class="c-blue">2. </span>재무현황 <span class="pull-right unit">(단위: 만원)</span></h3>
				<table class="ir-table2">
                        <thead>
                            <tr>
                                <th>년도</th>
                                <th>회사명</th>
                                <th>총자산</th>
                                <th>자본금</th>
                                <th>매출액</th>
                                <th>영업이익</th>
                                <th>당기순이익</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="2">2019</td>
                                <td>(주)누리펀딩</td>
                                <td>103,772</td>
                                <td>50,000</td>
                                <td>35,222</td>
                                <td>5,263</td>
                                <td>3,905</td>
                            </tr>
                            <tr>
                                <td>(주)누리펀딩대부</td>
                                <td>310,593</td>
                                <td>50,000</td>
                                <td>29,097</td>
                                <td>-2,163</td>
                                <td>-1,074</td>
                            </tr>
                            <tr>
                                <td rowspan="2">2018</td>
                                <td>(주)누리펀딩</td>
                                <td>58,167</td>
                                <td>31,000</td>
                                <td>16,835</td>
                                <td>-3,261</td>
                                <td>-3,268</td>
                            </tr>
                            </tr>
                            <tr>
                                <td>(주)누리펀딩대부</td>
                                <td>348,021</td>
                                <td>31,000</td>
                                <td>12,950</td>
                                <td>-1,898</td>
                                <td>1,544</td>
                            </tr>
                            </tr>
                            <tr>
                                <td rowspan="2">2017</td>
                                <td>(주)누리펀딩</td>
                                <td>30,393</td>
                                <td>30,000</td>
                                <td>-</td>
                                <td>-127</td>
                                <td>-126</td>
                            </tr>
                            <tr>
                                <td>(주)누리펀딩대부</td>
                                <td>29,531</td>
                                <td>30,000</td>
                                <td>71</td>
                                <td>-468</td>
                                <td>-468</td>
                            </tr>
                        </tbody>
                    </table>
				<!-- <div class="cf grid-tbl horizon contents-tbl">
					<ul class="cf nth-1 rowCol">
						<li class="cell nth-1 th-cell"><div class="inCell">년도</div></li>
						<li class="cell nth-2 th-cell"><div class="inCell">총자산</div></li>
						<li class="cell nth-2 th-cell"><div class="inCell">자본금</div></li>
						<li class="cell nth-3 th-cell"><div class="inCell">매출액</div></li>
						<li class="cell nth-4 th-cell"><div class="inCell">영업이익</div></li>
						<li class="cell nth-5 th-cell"><div class="inCell">당기순이익</div></li>
					</ul>
					<ul class="cf nth-2 rowCol">
						<li class="cell nth-1 td-cell th-col"><div class="inCell">2019</div></li>
						<li class="cell nth-2 td-cell"><div class="inCell">103,772</div></li>
						<li class="cell nth-2 td-cell"><div class="inCell">50,000</div></li>
						<li class="cell nth-3 td-cell"><div class="inCell">35,222</div></li>
						<li class="cell nth-4 td-cell"><div class="inCell">5,263</div></li>
						<li class="cell nth-5 td-cell"><div class="inCell">3,905</div></li>
					</ul>
					<ul class="cf nth-2 rowCol">
						<li class="cell nth-1 td-cell th-col"><div class="inCell">2018</div></li>
						<li class="cell nth-2 td-cell"><div class="inCell">-</div></li>
						<li class="cell nth-2 td-cell"><div class="inCell">31,000</div></li>
						<li class="cell nth-3 td-cell"><div class="inCell">16,835</div></li>
						<li class="cell nth-4 td-cell"><div class="inCell">-3,261</div></li>
						<li class="cell nth-5 td-cell"><div class="inCell">-3,268</div></li>
					</ul>
					<ul class="cf nth-3 rowCol">
						<li class="cell nth-1 td-cell th-col"><div class="inCell">2017</div></li>
						<li class="cell nth-2 td-cell"><div class="inCell">30,393</div></li>
						<li class="cell nth-2 td-cell"><div class="inCell">30,000</div></li>
						<li class="cell nth-3 td-cell"><div class="inCell">0</div></li>
						<li class="cell nth-4 td-cell"><div class="inCell">-128</div></li>
						<li class="cell nth-5 td-cell"><div class="inCell">-126</div></li>
					</ul>
				</div> -->
			</div>

			<div class="container cont-ir cont-execu">
				<h3><span class="c-blue">3. </span>임직원 현황</h3>
				<div class="cf grid-tbl vertical contents-tbl">
					<ul class="cf nth-1 rowCol">
						<li class="cell th-cell"><div class="inCell">임직원</div></li>
						<li class="cell td-cell"><div class="inCell">16명(업무협약직원 12명)</div></li>
					</ul>
					<ul class="cf nth-2 rowCol">
						<li class="cell th-cell"><div class="inCell">여신심사역수</div></li>
						<li class="cell td-cell"><div class="inCell">3명</div></li>
					</ul>
					<div class="cf show-xs division"></div>
					<ul class="cf nth-3 rowCol">
						<li class="cell th-cell"><div class="inCell">전문가</div></li>
						<li class="cell td-cell"><div class="inCell">변호사 1명(김부식), 신용분석사 1명(김정권)</div></li>
					</ul>
				</div>
			</div>

			<div class="container cont-ir cont-grand">
				<h3><span class="c-blue">4. </span>대대주 현황</h3>
				<div class="cf grid-tbl vertical contents-tbl">
					<ul class="cf nth-1 rowCol">
						<li class="cell th-cell"><div class="inCell">성명</div></li>
						<li class="cell td-cell"><div class="inCell">김정권</div></li>
					</ul>
					<ul class="cf nth-2 rowCol">
						<li class="cell th-cell"><div class="inCell">직위</div></li>
						<li class="cell td-cell"><div class="inCell">대표이사</div></li>
					</ul>
					<ul class="cf nth-3 rowCol">
						<li class="cell th-cell"><div class="inCell">보유 주식수</div></li>
						<li class="cell td-cell"><div class="inCell">62,000주</div></li>
					</ul>
					<ul class="cf nth-4 rowCol">
						<li class="cell th-cell"><div class="inCell">비율</div></li>
						<li class="cell td-cell"><div class="inCell">100%</div></li>
					</ul>
				</div>
				<div class="cf grid-tbl horizon total-tbl">
					<ul class="cf rowCol">
						<li class="cell nth-1 td-cell total-cell"><div class="inCell">총 계</div></li>
						<li class="cell nth-1 td-cell total-cell"><div class="inCell"></div></li>
						<li class="cell nth-2 td-cell total-cell"><div class="inCell">62,000주</div></li>
						<li class="cell nth-3 td-cell total-cell"><div class="inCell">100%</div></li>
					</ul>
				</div>
			</div>

<!--
			<div class="container cont-ir cont-">
				<h3><span class="c-blue">. </span><span class="pull-right unit">(단위: 만원)</span></h3>
				<div class="cf grid-tbl struc-tbl">
					<ul class="cf nth- rowCol">
						<li class="cell th-cell"><div class="inCell"></div></li>
						<li class="cell td-cell"><div class="inCell"></div></li>
						<li class="cell td-cell total-cell"><div class="inCell"></div></li>
					</ul>
				</div>
			</div>
-->

			<div class="container cont-guide">
				<div class="guide-area">
					<div class="pd-area">
						<h3>P2P대출 가이드 라인 준수내용</h3>
                        <div class="fp-contents">
							1. 투자자 유의사항<br>
							&nbsp;- 모든 투자상품은 현행 법률상 수익율을 보장할 수 없습니다. 또한 차입자가 원금의 전부 또는 일부를 상환하지 못할 경우 발생하게 되는 투자금 손실 등 투자위험은 투자자가 부담하게 됩니다.<br>
							&nbsp;- 누리펀딩 플랫폼에서 제공하는 P2P 투자상품은 현행 금융관련 법령에 근거한 상품이 아니며, 투자원금과 수익을 보장하지 않는 상품으로 투자손실에 대한 책임은 모두 투자자에게 있습니다.<br>
							<br>
							2. 누리펀딩의 의무.<br>
							&nbsp;- 누리펀딩은 투자상품에 대한 연체가 발생하는 경우 채권 추심에 최선을 다하며, 추심을 통해 회수한 금액을 투자자에게 투자 비율에 따라서 균등하게 배분할 의무가 있습니다. 단, 자체 추심 또는 외부 기관 위탁, 부실채권 매각 등으로 추심관련 수수료가 발생할 경우 해당 비용을 차감한 후 추심액을 분배합니다.<br>
							&nbsp;- 누리펀딩에서 제공하는 상품등급 및 관련 기업정보 등은 Nice Credit 평가 정보이거나, 이를 당사에서 가공한 정보입니다. 당사와 정보 제공업체는 정보의 정확성이나 안정성을 보장할 수 없으며, 상황에 따라 일부 오류 또는 지연이 발생할 수 있었습니다.<br>
							<br>
							3. 차입자에 관한 사항은 "상품 설명서" 를 참고하시기 바랍니다.<br>
							 <br>
							4. 투자하신 상품의 상환시 지급하는 투자수익에 대하여 이자소득세(25%)와 지방소득세(2.5%)가 원천징수 됩니다. 투자상품에 대한 원리금이 회수되면 7일 이내 또는 상품 만기일 이내에 (단, 은행휴무일인 경우에는 그 익일)투자자에게 원금 및 수익금을 정산하여 지급합니다. 투자자는 원칙적으로 투자모집 이후에는 투자 취소가 불가능합니다.<br>
							<br>
							5. 투자자가 유의하여야 할 사항(계약의 해제·해지에 관한 사항 및 조기 상환조건에 관한 사항)에 관해 "상품설명서"에 포함 하였습니다. 조기상환은 가능합니다.<br>
							<br>
							6. 상품 유형별 &lt;별표&gt;에서 정하는 필수정보는 "상품설명서"에 포함 하였습니다.<br>
							<br>
							7. 동일차주 대출현황 (만기연장 등 투자자 재모집·분할모집 등 고위험 상품 여부)은 해당 사항이 있는 경우 "상품 설명서"에 포함 하였습니다.<br>
							<br>
							8. 투자자 재모집 또는 분할 모집의 경우에는 별도 재연장 불가시 부실 가능성이 높습니다.<br>
							<br>
							9. 그 밖의 계약의 주요 내용은 파악된 내용을 기준으로 "상품설명서"에 포함하였습니다.<br>
							<br>
							P2P 가이드라인 개정안(2020.08.27. 시행)을 준수하고 있음을<br>
							위와 같이 공시합니다.<br>
							<br>
							<br>
							㈜누리펀딩 대표 김정권<br>
							<br>
							<br>
							<a href="https://www.nurifunding.co.kr/img/detail/view_15977429742.hwp" target="_blank"><font color="blue">▶ 금융위원회 "P2P대출 가이드라인 개정 방안 및 법제화 방향" 자세히 보기</font></a><br>
							<br>
						</div>

						<!-- <div class="fp-contents">
                            1. 사업정보의 제공<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;1) P2P 대출의 구조, 유형별 누적 대출금액 / 대출잔액 / 연체율 / 연체건수(비중 포함)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;2) 재무현황<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;3) 임직원수: 14명(업무협약직원 9명)<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;4) 여신심사역수: 3명<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;5) 전문가: 변호사 1명(김부식), 신용분석사 1명(김정권). <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;6) 대주주 현황<br>
                            <br>
                            2. 차입자에게 제공하는 정보: 차입자의 대출이용에 도움을 줄 수 있는 정보를 “가이드라인 내용” 에 따라 차입자가 쉽게 이해할 수 있도록 제공하고 있습니다.<br>
                            <br>
                            3. 투자광고: P2P 대출 투자를 위한 표시, 광고, 계약 체결 등 행위를 할 때 “가이드라인 내용” 을준수하고 있습니다<br>
                             <br>
                            4. 투자자에게 제공하는 정보: 투자판단에 도움을 줄 수 있는 정보를 투자자가 쉽게 이해할 수 있도록 홈페이지에 게재하고 있습니다.<br>
                            O. 차입자에 대한 정보는 투자자에게 제공하기 전 “가이드라인 내용”에 따라 확인한 후 왜곡 없이 제공하고 있습니다.<br>
                            <br>
                            5. 영업행위: P2P 대출 영업행위를 함에 있어서“가이드라인 내용” 에 따라 준수하고 있습니다.<br>
                            <br>
                            6. 투자금 및 대출금상환금 별도 관리: 투자자로부터 받은 자산을 P2P 대출정보 중개업체 등의 자산과 명확히 분리하여 관리하고 있습니다.<br>
                            <br>
                            7. 투자한도: 투자자에 대해 “가이드라인 내용” 에 따라 투자한도를 준수하고 있습니다.<br>
                            <br>
                            8. 온라인개인정보 관리실태 점검: 외부기관 등을 통해 온라인 개인정보 관리실태를 연1회 이상 점검한 후 3개월 이내에 홈페이지에 공시할 계획입니다.<br>
                             -외부기관 점검(금보원, 인터넷진흥원): 검토중임<br>
                             -자체점검(온라인 개인정보보호 자율점검 체크리스트): 확인중임<br>
                            <br>
                            9. 자료제공: 연계 금융회사에 가이드라인 준수 여부를 확인할 수 있는 자료를 충분히 금융감독원에 제공하고 미준수 시 금융감독원 및 소속 협회에 통보 하겠습니다.<br>
                            <br>
                            10.  청산업무처리절차 마련: 부도, 청산 등 영업중단 등에 대비하여 채권추심 및 상환금 배분 등을 법무법인 등 외부기관에 위탁하는 등 공정하고 투명한 청산절차를 마련 하겠습니다.<br>
                             -청산업무 처리 절차 마련: 마련중임<br>
                             -연체 추심 현황 및 관리실태 공시: 연체 없음<br>
                            <br>
                            11. 법령과의 관계: P2P 대출에 현재 적용되고 있는 관련 법령을 준수 하겠습니다.<br>
                            <br>
                            12. 부동산 PF 취급시 “가이드라인 내용”을 준수 하겠습니다.<br>
                            <br>
                            P2P 가이드라인 개정안(2019.1.1. 시행)을 준수하고 있음을<br>
                            위와 같이 공시합니다.<br>
                            <br>
                            <br>
                            ㈜누리펀딩 대표 김정권<br>
                            <br>
                            <br>
                            <a href="https://www.fsc.go.kr/info/ntc_news_view.jsp?bbsid=BBS0030&amp;page=1&amp;sch1=subject&amp;sword=P2P&amp;r_url=&amp;menu=7210100&amp;no=32841" target="_blank"><font color="blue">▶ 금융위원회 "P2P대출 가이드라인 개정 방안 및 법제화 방향" 자세히 보기</font></a><br>
                            <br>
                        </div> -->
					</div>
					<div class="row-btn">
						<a class="btn-more fn-toggleOn"></a>
					</div>
					<script>
						$(function() {
							$(".fn-toggleOn").on("click", function() {
								$(this).toggleClass("on");
								$(".fp-contents").toggleClass("on");
							});
						});
					</script>
				</div>
			</div>
        </section>
	</div>
<?php
	include_once(INC_DIR."/www/web-home/common/bottom.php");
?>