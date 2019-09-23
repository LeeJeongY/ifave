<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";

	include "../inc/header.php";
?>

<script language="javascript">

function numberFormat(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).ready(function(){
	$('#product_id').on("change", function() {
		var product_id = $("#product_id option:selected").val();

		var sum_price = 0;
		var total_amount = 0;

		var html_data = "";
		$("#gubun").val("getProduct");

		var params = $("#fm").serialize();
		$.ajax({
			type : 'POST',
			url : 'data_load.php',
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
			data : params,
			success : function(data) {

				console.log(data);

				var data_array	= data.split("@");
				var pname		= data_array[0];
				var pcode		= data_array[1];
				var unit_price	= data_array[2];
				var seq			= data_array[3];
				var pcheck		= data_array[4];

				if(pcheck==0) {
					html_data = "<li id='add_"+seq+"'>";
					html_data += "	<strong>"+pname+"</strong>";
					html_data += "	<select name='qty[]' class='qty' id='qty_"+seq+"'>";
					html_data += "		<option value='1' selected>1</option>";
					html_data += "		<option value='2'>2</option>";
					html_data += "		<option value='3'>3</option>";
					html_data += "		<option value='4'>4</option>";
					html_data += "		<option value='5'>5</option>";
					html_data += "	</select>";
					html_data += "	<a href='javascript:;' class='cartDel' id='cartDel_"+seq+"'>￦<span id='html_price_"+seq+"'>"+numberFormat(unit_price)+"</span></a>";
					html_data += "	<input type='hidden' name='unit_price[]' id='unit_price_"+seq+"' value='"+unit_price+"'>";
					html_data += "	<input type='hidden' name='sum_price[]' id='sum_price_"+seq+"' value='0'>";
					html_data += "	<input type='hidden' name='product_code[]' id='product_code_"+seq+"' value='"+pcode+"'>";
					html_data += "</li>";

					sum_price = parseInt(unit_price)*1;				// 단가 * 수량(기본:1)


					var pay_amount =  $("#payment_amount").val();
					total_amount = parseInt(pay_amount) + parseInt(sum_price);		//합계

					$("#cart_list").append(html_data);								//상품 정보 목록
					$("#sum_price_"+seq).val(sum_price);
					$("#payment_amount").val(total_amount);							//실결제금액
					$("#total_amount").html(numberFormat(total_amount));			//총합계금액
				} else {
					alert('중복된 상품이 있습니다.');
				}

			}
		}); // end ajax
	});

    //수량 선택
    $(document).on("change",".qty",function(){
		var qty_id		= $(this).attr("id");
		//var id		= qty_id.replace("qty_","");
		var id_arr		= qty_id.split('_');
		var id			= id_arr[1];
		var qty_num		= $("#qty_"+id+" option:selected").val();
		var unit_price	= $('#unit_price_'+id).val();
		var sum_price	= parseInt(unit_price) * parseInt(qty_num);		//단가 * 수량

		// console.log("qty_id : "+qty_id+", id : "+id+", qty[] value : " + qty_num);
		// console.log("unit_price : " + unit_price);

		//각 상품에 대한 계산
		$("#html_price_"+id).html(numberFormat(sum_price));
		$("#sum_price_"+id).val(sum_price);								//실단가*수량 값 저장
		$("#gubun").val("calculation");


		var params = $("#fm").serialize();
		$.ajax({
			type : 'POST',
			url : 'data_load.php',
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
			data : params,
			success : function(data) {

				//console.log(data);


				$("#payment_amount").val(data);							//실결제금액
				$("#total_amount").html(numberFormat(data));			//총합계금액


			}
		}); // end ajax

    });

    //삭제 버튼
    $(document).on("click",".cartDel",function(){
		//var html_data = $(this).parent();

		var del_id		= $(this).attr("id");
		var id_arr		= del_id.split('_');
		var id			= id_arr[1];

        $("#add_"+id).remove();

		$("#gubun").val("calculation");


		var params = $("#fm").serialize();
		$.ajax({
			type : 'POST',
			url : 'data_load.php',
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
			data : params,
			success : function(data) {

				console.log(data);


				$("#payment_amount").val(data);							//실결제금액
				$("#total_amount").html(numberFormat(data));			//총합계금액


			}
		}); // end ajax
    });




	$("#buy_submit").click(function() {
		if($("#payment_amount").val()==0) {
			alert("상품을 선택하세요.");
			$('#product_code').focus();
			return false;
		}

		$("#fm").attr("target", "_self");
		$("#fm").attr("method", "post");
		$("#fm").attr("action", "order_pay.php");
		$("#fm").submit();
	});

});


/*
function calculatePrice()
{
    var totalprice = 0;
    var itemprice = parseInt($('span#item-price').text().replace(/[^0-9]/g, ''));
    $('ul#selected-result li').each(function() {
        var $prcelmt = $(this).find('.price-value');
        var optprc = 0;
        var itcnt = parseInt($(this).find('input').val());
        $prcelmt.each(function() {
            var prc = parseInt($(this).text());
            optprc += prc;
        });
        totalprice += (itemprice + optprc) * itcnt;
    });
    $('#total-price span').text(number_format(totalprice) + '원');
}
*/
</script>
		<!-- container -->
		<div id="container">
			<section>
				<div class="proBox">
					<div class="proImg">
						<img src="/images/contents/product/img-product1.png">
					</div>
					<div class="proInfo">
						<p>
							<strong>
							FAVE<br>스마트 밸런스 트레이너
							</strong>
							<span>
							이제 복잡한 운동방법은 필요없습니다.<br>언제 어디서나 게임을 통해<br>운동을 신나게 즐기기만 하면 됩니다!
							</span>
						</p>
						<form name="fm" id="fm">
						<input type="hidden" name="gubun" id="gubun" value="">
						<div class="proOption">
							<select class="poSelt" name="product_id" id="product_id">
								<option value="">- Product Select -</option>

							<?php

							$strQuery = "SELECT * FROM ".$initial."_product WHERE idx IS NOT NULL ";
							$strQuery .= " AND use_flag='1'";
							$strQuery .= " ORDER BY idx DESC";
							$strResult = mysql_query($strQuery, $dbconn);
							while ($arrResult = mysql_fetch_array($strResult)) {
								$pcode	= $arrResult[pcode];
								$pname	= db2html($arrResult[pname]);	  //이름

								$selected = ($pcode == $product_code)? " selected " : "";
							?>
								<option value="<?=$pcode?>" <?=$selected?>><?=$pname?></option>
							<?
							}
							?>
							</select>

							<ul class="cartList" id="cart_list"></ul>


							<input type="hidden" name="payment_amount" id="payment_amount" value="0">
							<div class="totalPrice">
								<strong><em>￦</em><span id="total_amount">0</span></strong>
								<span>won</span>
							</div>

						</div>
						<div class="btnPrice">
							<a href="javascript:;" id="buy_submit" class="btn-c btn-orange">구매하기</a>
						</div>
						</form>
					</div>
				</div>
			</section>

            <section>
                <div class="proDetail cfx">
					<article>
						<div class="det1">
							<img src="/images/contents/product/img-game-sport-ko.png">
							<p>
								<img src="/images/contents/product/img-product-fave1.png">
							</p>
						</div>
					</article>

					<article>
						<div class="det2">
							<dl class="fave450">
								<dt>
									<strong>FAVE 450</strong> 초보자 및 일반인용
								</dt>
								<dd>
									<p>
										폭이 넓고 높이가 낮아 초보자 및 일반인에게 추천합니다. (어린이 포함)
										<em>지름 : 450mm / 높이 : 130mm / 무게 : 1.5kg</em>
									</p>
									<ul>
										<li>
											<img src="/images/contents/product/img-p450-1.png">
											<span>그린</span>
										</li>
										<li>
											<img src="/images/contents/product/img-p450-4-ko.png">
											<span>핑크</span>
										</li>
										<li>
											<img src="/images/contents/product/img-p450-2.png">
											<span>옐로우</span>
										</li>
										<li>
											<img src="/images/contents/product/img-p450-3.png">
											<span>오렌지</span>
										</li>
									</ul>
								</dd>
							</dl>
						</div>
					</article>

					<article>
						<div class="det3">
							<dl class="fave350">
								<dt>
									<strong>FAVE 350</strong> 숙련자용
								</dt>
								<dd>
									<p>
										폭이 좁고 높이가 높아 숙련자 또는 운동신경이 뛰어나신 분께 추천합니다.
										<em>지름 : 350mm / 높이 : 150mm / 무게 : 0.9kg</em>
									</p>
									<ul class="cfx">
										<li>
											<img src="/images/contents/product/img-p350-1.png">
											<span>그린</span>
										</li>
										<li>
											<img src="/images/contents/product/img-p350-2.png">
											<span>핑크</span>
										</li>
										<li>
											<img src="/images/contents/product/img-p350-3.png">
											<span>바이올렛</span>
										</li>
									</ul>
									<em>
										* 처음 밸런스 보드를 접하시는 분들은 반드시 450을 구매하시기 바랍니다.<br>
										운동은 차근차근 본인의 수준에 맞게 안전하게 실시하여야 합니다.
									</em>
								</dd>
							</dl>
						</div>
					</article>

					<article>
						<div class="det4">
							<dl>
								<dt>
									게임 + 밸런스 운동
								</dt>
								<dd>
									비만과 성장발육, 쉽게 싫증을 내는 사람들의 특성을 모두 고려해서<br>
									게임을 통해 즐겁게 밸런스 운동을 할 수 있도록 만들었습니다. <br>
									저희 제품은 어떤 밸런스 운동기구도 갖추지 못한 <br>
									자체 개발한 모션감지센서와 게임 콘텐츠를 가지고 있습니다.
								</dd>
							</dl>
							<h5>게임 다운로드</h5>
							<ul class="cfx">
								<li>
									<span>Fave Mad Runner</span>
									<a href="https://itunes.apple.com/kr/app/%EB%A7%A4%EB%93%9C-%EB%9F%AC%EB%84%88-%EB%AC%BC%EC%97%90-%EB%B9%A0%EC%A7%84-%EC%84%B8%EC%83%81/id1312772982?mt=8" target="_blank"><img src="/images/contents/product/ico-app-apple.png"></a> <a href="https://play.google.com/store/apps/details?id=com.Obliqueline.MadRunnerKo" target="_blank"><img src="/images/contents/product/ico-app-android.png"></a> <a href="/datafiles/app/MadRunnerKo_ver1.0.109_1101_ForEvent.apk" target="_blank"><img src="/images/contents/product/ico-down-load.png"></a>
								</li>
								<li>
									<span>Fave Balance and Jump</span>
									<a href="https://play.google.com/store/apps/details?id=tea.qra.mjm.unitybluetoothcode" target="_blank"><img src="/images/contents/product/ico-app-android.png"></a>
								</li>
							</ul>
							<ul class="cfx det4-ul2">
								<li>
									<span>제품 사용설명서 다운로드</span>
									<a href="/download/manual.pdf" target="_blank"><img src="/images/contents/product/ico-down-load.png"></a>
								</li>
							</ul>
							<div class="sample-img"></div>
						</div>
					</article>

					<article>
						<div class="det5">
							<div class="det5-img">
								<img src="/images/contents/product/img-product-kind-ko.png">
							</div>
							<div class="det5-right">
								<img src="/images/contents/product/img-product-document.png">
								<dl>
									<dt>
										모든 기술은 총 7개의 특허와<br>
										지적재산권으로 보호받고 있습니다.
									</dt>
									<dd>
										저희의 기술력은 게이미피케이션 밸런스 운동시스템의 구축과<br>
										독자개발 모션감지센서, 사용자 운동정보제공 알고리즘,<br>
										가벼운무게, 특수한 소재에 있습니다.
									</dd>
								</dl>
							</div>
						</div>
					</article>

					<article>
						<div class="det6">
							<p>
								<strong>스마트 밸런스 트레이너만의<em>특장점</em></strong><br>
								스마트 밸런스 트레이너는 중심축의 다양한 변화를 통해 짧은시간 내에 많은 운동량과<br>
								신경근육질의 향상은 물론, 근육, 건, 인대의 강화<br>
								그리고 고관절, 무릎, 발목 주변의 성장판에 다양한 자극을 줍니다.<br><br>

								0.9kg와 1.5kg 두가지 제품으로 글로벌 제품에 반해 4분의 1 이상 가볍습니다.<br>
								아이들도 들고 다니면서 사용할 수 있고 소프트한 재질로 부상을 당하지 않습니다.
							</p>
						</div>
					</article>


					<article>
						<div class="det7">

							<img src="/images/contents/product/img-product-diagram-ko.png">
							<div>
								스마트 밸런스 트레이너는, 스마트앱을 통해 운동효과를 바로 확인할 수 있습니다.<br>
								COP 지표와 티네티버그 척도와 같은 전문 의학 지표는 물론 운동량과<br>
								칼로리 소모량과 같은 기본적인 정보들도 제공해 줍니다.<br>
								이제 "페이브"와 스마트폰만 있으면 언제 어디서나 어른, 아이 모두<br>
								게임속 캐릭터가 되어 뛰고 달리고 모험하는 것만으로도 성장과 비만방지에 좋은<br>
								밸런스트레이닝을 하게됩니다.
							</div>

						</div>
					</article>

                </div>
            </section>


			<section>
                <div class="m_proDetail cfx">
					<article>
						<div class="m_det1">
							<img src="/images/contents/product/s-prod1.png" class="w100">
						</div>
					</article>
					<article>
						<div class="m_det2">
							<div class="md_view">
								<dl class="m_fave450">
									<dt>
										<strong>FAVE 450</strong> 초보자 및 일반인용
									</dt>
									<dd>
										<p>
											폭이 넓고 높이가 낮아 초보자 및 일반인에게 추천합니다. (어린이 포함)
											<em>지름 : 450mm / 높이 : 130mm / 무게 : 1.5kg</em>
										</p>
										<ul>
											<li>
												<img src="/images/contents/product/img-p450-1.png">
												<span>그린</span>
											</li>
											<li>
												<img src="/images/contents/product/img-p450-4-ko.png">
												<span>핑크</span>
											</li>
											<li>
												<img src="/images/contents/product/img-p450-2.png">
												<span>옐로우</span>
											</li>
											<li>
												<img src="/images/contents/product/img-p450-3.png">
												<span>오렌지</span>
											</li>
										</ul>
									</dd>
								</dl>

								<dl class="m_fave350">
									<dt>
										<strong>FAVE 350</strong> 숙련자용
									</dt>
									<dd>
										<p>
											폭이 좁고 높이가 높아 숙련자 또는 운동신경이 뛰어나신 분께 추천합니다.
											<em>지름 : 350mm / 높이 : 150mm / 무게 : 0.9kg</em>
										</p>
										<ul class="cfx">
											<li>
												<img src="/images/contents/product/img-p350-1.png">
												<span>그린</span>
											</li>
											<li>
												<img src="/images/contents/product/img-p350-2.png">
												<span>옐로우</span>
											</li>
											<li>
												<img src="/images/contents/product/img-p350-3.png">
												<span>바이올렛</span>
											</li>
										</ul>
										<em>
											* 처음 밸런스 보드를 접하시는 분들은 반드시 450을 구매하시기 바랍니다.<br>
										     운동은 차근차근 본인의 수준에 맞게 안전하게 실시하여야 합니다.
										</em>
									</dd>
								</dl>

								<div class="exercise">
									<dl>
										<dt>
											게임 + 밸런스 운동
										</dt>
										<dd>
											<div class="m_sample-img">
												<img src="/images/contents/product/img-product-sample.png">
											</div>
											<div class="m_cross-img">
												<img src="/images/contents/product/img-product-cross.png">
											</div>
											<span>비만과 성장발육, 쉽게 싫증을 내는 사람들의 특성을 모두 고려해서</span>
											<span>게임을 통해 즐겁게 밸런스 운동을 할 수 있도록 만들었습니다.</span>
											<span>저희 제품은 어떤 밸런스 운동기구도 갖추지 못한</span>
											<span>자체 개발한 모션감지센서와 게임 콘텐츠를 가지고 있습니다.</span>
										</dd>
									</dl>
									<h5>게임 다운로드</h5>
									<ul class="cfx">
										<li>
											<span>Fave Mad Runner</span>
											<a href="https://itunes.apple.com/kr/app/%EB%A7%A4%EB%93%9C-%EB%9F%AC%EB%84%88-%EB%AC%BC%EC%97%90-%EB%B9%A0%EC%A7%84-%EC%84%B8%EC%83%81/id1312772982?mt=8" target="_blank"><img src="/images/contents/product/ico-app-apple.png"></a> <a href="https://play.google.com/store/apps/details?id=com.Obliqueline.MadRunnerKo" target="_blank"><img src="/images/contents/product/ico-app-android.png"></a>
											<a href="/datafiles/app/MadRunnerKo_ver1.0.109_1101_ForEvent.apk" target="_blank"><img src="/images/contents/product/ico-down-load.png"></a>
										</li>
										<li>
											<span>Fave Balance and Jump</span>
											<a href="https://play.google.com/store/apps/details?id=tea.qra.mjm.unitybluetoothcode"><img src="/images/contents/product/ico-app-android.png"></a>
										</li>
									</ul>
									<ul class="cfx det4-ul2">
										<li>
											<span>제품 사용설명서 다운로드</span>
											<a href="/download/manual.pdf" target="_blank"><img src="/images/contents/product/ico-down-load.png"></a>
										</li>
										<li></li>
									</ul>
								</div>
							</div>
						</div>
					</article>

					<article>
						<div class="m_det3">
							<img src="/images/contents/product/s-prod3.png" class="w100">
							<dl>
								<dt>
									<span>모든 기술은 총 7개의 특허와</span>
									<span>지적재산권으로 보호받고 있습니다.</span>
								</dt>
								<dd>
									<span>저희의 기술력은 게이미피케이션 밸런스 운동시스템의 구축과</span>
									<span>독자개발 모션감지센서, 사용자 운동정보제공 알고리즘,</span>
									<span>가벼운무게, 특수한 소재에 있습니다.</span>
								</dd>
							</dl>
							<span><img src="/images/contents/product/img-product-document.png"></span>
						</div>
					</article>

					<article>
						<div class="m_det4">
							<img src="/images/contents/product/s-prod4.png" class="w100">
							<p>
								<strong>스마트 밸런스 트레이너만의<em>특장점</em></strong>
								<span>스마트 밸런스 트레이너는 중심축의 다양한 변화를 통해 짧은시간 내에 많은 운동량과</span>
								<span>신경근육질의 향상은 물론, 근육, 건, 인대의 강화</span>
								<span>그리고 고관절, 무릎, 발목 주변의 성장판에 다양한 자극을 줍니다.</span><br>

								<span>0.9kg와 1.5kg 두가지 제품으로 글로벌 제품에 반해 4분의 1 이상 가볍습니다.</span>
								<span>아이들도 들고 다니면서 사용할 수 있고 소프트한 재질로 부상을 당하지 않습니다.</span>
							</p>
						</div>
					</article>

					<article>
						<div class="m_det5">
							<div class="m_det5_box">
								<img src="/images/contents/product/img-product-diagram-ko.png">
								<p>
									<span>스마트 밸런스 트레이너는, 스마트앱을 통해 운동효과를 바로 확인할 수 있습니다.</span><br>
									<span>COP 지표와 티네티버그 척도와 같은 전문 의학 지표는 물론 운동량과</span>
									<span>칼로리 소모량과 같은 기본적인 정보들도 제공해 줍니다.</span><br><br>
									<span>이제 "페이브"와 스마트폰만 있으면 언제 어디서나 어른, 아이 모두</span>
									<span>게임속 캐릭터가 되어 뛰고 달리고 모험하는 것만으로도 성장과 비만방지에 좋은</span>
									<span>밸런스트레이닝을 하게됩니다.</span>
								</p>
								<span><img src="/images/contents/product/img-product-phone.png"></span>
							</div>
						</div>
					</article>
				</div>
			</section>

            <section>
                <div class="checkBox">
					<div class="checkIt">
						<h4>환불 및 교환정보</h4>
						<p>환불/교환 요청은 배송완료 시점으로부터 <strong>7일 이내</strong> 에 가능합니다.
						<h5>환불/교환 요청방법</h5>
						</p>
						<dl>
							<dt>· 환불</dt>
							<dd>1. 고객센터에서 접수 (051-761-5166)</dd>
							<dd>2. 택배기사 반품상품 수거</dd>
							<dd>3. 환불완료</dd>
						</dl>
						<dl>
							<dt>· 교환</dt>
							<dd>1. 고객센터에서 접수 (051-761-5166)</dd>
							<dd>2. 택배기사 교환상품 수거</dd>
							<dd>3. 새제품 재배송</dd>
						</dl>
						<dl class="refund-dl">
							<dt>· 환불/교환 배송비</dt>
							<dd>
								1. 환불시: 환불배송비는 제품하자 및 오배송인 경우 판매자 부담, 단순변심인 경우 반품배송비를 차감 후 환불<br>
								무료배송, 조건부 무료배송의 경우 최초배송비 + 반품배송비가 차감됩니다.<br>
								단, 도시 / 산간지역 및 설치 / 해외배송 상품은 기본 배송비 외 추가 배송비가 발생할 수 있습니다.
								<br>
							</dd>
							<dd>
								2. 교환시: 제품하자 및 오배송인 경우 판매자 부담이며, 단순 변심인 경우 왕복 배송비를 확인 후 박스에 동봉해서 보내주시면 됩니다.<br>
								일반적으로 5,000원이지만 상품에 따라 상이하며, 재고가 없는 경우 환불처리 될 수 있습니다.
							</dd>
						</dl>
						<dl class="ti_dl">
							<dt>· 환불/교환 불가사유</dt>
							<dd>
								<strong>· 본 제품은 가전 및 운동용품으로 포장을 개봉하였거나 포장이 훼손된 경우 환불 / 교환 불가하오니 유의바랍니다.</strong>
							</dd>
							<dd>
								· 구매자가 사용한 경우 환불/교환되지 않습니다.
							</dd>
							<dd>
								· 환불 / 교환 요청 가능기간이 초과한 경우(배송완료 시점으로부터 7일 초과시)
							</dd>
							<dd>
								· 분실 / 파손 / 고장 / 오염이 발생한 경우
							</dd>
							<dd>
								· 모니터 해상도 차이로 인하여 색상 등 이미지가 실제와 상이한 경우
							</dd>
						</dl>
						<dl class="ti_dl">
							<dt>· 거래정보</dt>
							<dd>
								· 재화 등의 공급방법 및 공급시기<br>
								: 컨텐츠에 기재된 상세설명 참조
							</dd>
							<dd>
								· 청약철회 및 계약의 해제에 관한 사항<br>
							   : 컨텐츠에 기재된 배송/환불 정보 및 상세설명 참조
							</dd>
							<dd>
								· 재화 등의 교환 반품 보증과 대금 환불 및 환불의 지연에 따른 배상금 지급의 조건 절차<br>
								: 전자상거래 등에서의 소비자 보호에 관한 법률의 규정에 따름
							</dd>
						</dl>
					</div>
				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
