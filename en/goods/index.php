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
					alert('We have duplicate products.');
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
			alert("Please select a product.");
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
							You don't need<br>a lot of exercise.
							</strong>
							<span>
							All you need to do is play a game<br>anytime, anywhere.
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
							<a href="javascript:;" id="buy_submit" class="btn-c btn-orange">BUY NOW</a>
						</div>
						</form>
					</div>
				</div>
			</section>

            <section>
                <div class="proDetail cfx">
					<article>
						<div class="det1">
							<img src="/images/contents/product/img-game-sport.png">
							<p>
								<img src="/images/contents/product/img-product-fave1.png">
							</p>
						</div>
					</article>

					<article>
						<div class="det2">
							<dl class="fave450">
								<dt>
									<strong>FAVE 450</strong> (Beginner & Public)
								</dt>
								<dd>
									<p>
										It is wide and low in height, and is recommended <br>
										for beginners and the general public.(Including children)<br>
										D(diameter) : 450mm / H(height) : 130mm / W(weight) : 1.5kg
									</p>
									<ul>
										<li>
											<img src="/images/contents/product/img-p450-1.png">
											<span>GREEN</span>
										</li>
										<li>
											<img src="/images/contents/product/img-p450-4-ko.png">
											<span>PINK</span>
										</li>
										<li>
											<img src="/images/contents/product/img-p450-2.png">
											<span>YELLOW</span>
										</li>
										<li>
											<img src="/images/contents/product/img-p450-3.png">
											<span>ORANGE</span>
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
									<strong>FAVE 350</strong> (Expert)
								</dt>
								<dd>
									<p>
										The width is narrow and the height is high.<br>
										It is recommended for those who have excellent motor skills.<br>
										D(diameter) : 350mm / H(height) : 150mm / W(weight) : 0.9kg
									</p>
									<ul class="cfx">
										<li>
											<img src="/images/contents/product/img-p350-1.png">
											<span>GREEN</span>
										</li>
										<li>
											<img src="/images/contents/product/img-p350-2.png">
											<span>PINK</span>
										</li>
										<li>
											<img src="/images/contents/product/img-p350-3.png">
											<span>VIOLET</span>
										</li>
									</ul>
									<em>
										* If you are new to the balance board for the first time, please purchase FAVE 450.<br>
										Exercise should be carried out safely at your own level.
									</em>
								</dd>
							</dl>
						</div>
					</article>

					<article>
						<div class="det4">
							<dl>
								<dt>
									Balancing exercise<br>
									by playing games!
								</dt>
								<dd>
									Smart Balance Trainer is compatible with Smartphone, <br>
									PC / Tablet, AR / VR device, TV and Bluetooth. <br>
									Motion sensor is reflected in the movement of the <br>
									character in the game.
								</dd>
							</dl>
							<h5>GAME DOWNLOAD LINK</h5>
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
									<span>Fave Manual Download</span>
									<a href="/download/manual.pdf" target="_blank"><img src="/images/contents/product/ico-down-load.png"></a>
								</li>
							</ul>
							<div class="sample-img"></div>
						</div>
					</article>

					<article>
						<div class="det5">
							<div class="det5-img">
								<img src="/images/contents/product/img-product-kind.png">
							</div>
							<div class="det5-right">
								<img src="/images/contents/product/img-product-document.png">
								<dl>
									<dt>
										All of these technologies <br>
										are protected by seven patents <br>
										and intellectual property rights.<br>
									</dt>
									<dd>
										Our technical skills A Study on the Development of <br>
										GI-MAC Equilibrium Exercise System <br>
										Motion-detection sensor, User movement <br>
										information delivery algorithm, light weight, <br>
										It's in a special material.
									</dd>
								</dl>
							</div>
						</div>
					</article>

					<article>
						<div class="det6">
							<p>
								<strong>Effectiveness</strong>
								through various changes <br>
								in the central axis with a short amount of <br>
								exercise improvement of nerve muscle, tendon, <br>
								and ligament And the growth plates around <br>
								the hip, knees, and ankles. It's a variety of stimuli.
							</p>
						</div>
					</article>

					<article>
						<div class="det7">

							<img src="/images/contents/product/img-product-diagram.png">
							<p>
								When you exercise on the product, <br>
								the motion sensor moves Reflect on the behavior of <br>
								characters in the game. Not only on TV but also on smartphones.<br>
								Now, with "Fave" and smartphones, you can go anytime, anywhere.<br>
								All grownups and kids, just running, running, and taking <br>
								risks It helps prevent obesity and growth.
							</p>

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
										<strong>FAVE 450</strong> (Beginner & Public)
									</dt>
									<dd>
										<p>
											It is wide and low in height, and is recommended <br>
											for beginners and the general public.(Including children)<br>
											D(diameter) : 450mm / H(height) : 130mm / W(weight) : 1.5kg
										</p>
										<ul>
											<li>
												<img src="/images/contents/product/img-p450-1.png">
												<span>GREEN</span>
											</li>
											<li>
												<img src="/images/contents/product/img-p450-4-ko.png">
												<span>PINK</span>
											</li>
											<li>
												<img src="/images/contents/product/img-p450-2.png">
												<span>YELLOW</span>
											</li>
											<li>
												<img src="/images/contents/product/img-p450-3.png">
												<span>ORANGE</span>
											</li>
										</ul>
									</dd>
								</dl>

								<dl class="m_fave350">
									<dt>
										<strong>FAVE 350</strong> (Expert)
									</dt>
									<dd>
										<p>
											The width is narrow and the height is high.<br>
											It is recommended for those who have excellent motor skills.<br>
											D(diameter) : 350mm / H(height) : 150mm / W(weight) : 0.9kg
										</p>
										<ul class="cfx">
											<li>
												<img src="/images/contents/product/img-p350-1.png">
												<span>GREEN</span>
											</li>
											<li>
												<img src="/images/contents/product/img-p350-2.png">
												<span>YELLOW</span>
											</li>
											<li>
												<img src="/images/contents/product/img-p350-3.png">
												<span>VIOLET</span>
											</li>
										</ul>
										<em>
											* If you are new to the balance board for the first time, please purchase FAVE 450.<br>
											Exercise should be carried out safely at your own level.
										</em>
									</dd>
								</dl>

								<div class="exercise">
									<dl>
										<dt>
											Balancing exercise by playing games!
										</dt>
										<dd>
											<div class="m_sample-img">
												<img src="/images/contents/product/img-product-sample.png">
											</div>
											<div class="m_cross-img">
												<img src="/images/contents/product/img-product-cross.png">
											</div>
											Smart Balance Trainer is compatible with Smartphone, <br>
											PC / Tablet, AR / VR device, TV and Bluetooth. <br>
											Motion sensor is reflected in the movement of the <br>
											character in the game.
										</dd>
									</dl>
									<h5>GAME DOWNLOAD LINK</h5>
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
											<span>Fave Manual Download</span>
											<a href="/download/manual.pdf" target="_blank"><img src="/images/contents/product/ico-down-load.png"></a>
										</li>
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
									All of these technologies<br>
									are protected by seven patents<br>
									and intellectual property rights.
								</dt>
								<dd>
									Our technical skills A Study on the Development of <br>
									GI-MAC Equilibrium Exercise System Motion-detection sensor,
									User movement information delivery algorithm, light weight,
									It's in a special material.
								</dd>
							</dl>
							<span><img src="/images/contents/product/img-product-document.png"></span>
						</div>
					</article>

					<article>
						<div class="m_det4">
							<img src="/images/contents/product/s-prod4.png" class="w100">
							<p>
								<strong>Effectiveness</strong>
								through various changes <br>
								in the central axis with a short amount of <br>
								exercise improvement of nerve muscle, tendon, <br>
								and ligament And the growth plates around <br>
								the hip, knees, and ankles. It's a variety of stimuli.
							</p>
						</div>
					</article>

					<article>
						<div class="m_det5">
							
								<img src="/images/contents/product/img-product-diagram.png">
								<p>
									When you exercise on the product,
									the motion sensor moves Reflect on the behavior of
									characters in the game. Not only on TV but also on smartphones.<br>
									Now, with "Fave" and smartphones, you can go anytime, anywhere.<br>
									All grownups and kids, just running, running, and taking
									risks It helps prevent obesity and growth.
								</p>
								<span><img src="/images/contents/product/img-product-phone.png"></span>
							
						</div>
					</article>
				</div>
			</section>

<style>
.m_proDetail { display:none; }
@media (max-width:1200px) {

	.proDetail { display:none; }
	.m_proDetail { display:block; }
	.w100 { max-width:100%; width:100%; display:block; }

	.m_det2 { height:auto; position:relative; background:url(/images/contents/product/s-prod2.png) no-repeat center bottom; }
	.md_view { position:relative; width:100%; }
	.m_fave450 { padding:50px 0 0; }
	.m_fave450 dt { font-size:18px; font-weight:400; text-align:center; }
	.m_fave450 dt strong { font-size:30px; font-weight:900; font-family:'Nanumsquare'; margin-right:4px; line-height:30px; }
	.m_fave450 dd p { color:#434343; font-size:13px; line-height:20px; padding:15px 0 30px; text-align:center;}
	.m_fave450 dd ul li { float:none; width:40%; text-align:center; height:auto; margin:0 auto 15px;  }
	.m_fave450 dd ul li img { width:100%; }
	.m_fave450 dd ul li span { display:block; padding-top:10px; font-size:14px; font-weight:700; color:#434343; }

	.m_fave350 { padding:30px 0 0; }
	.m_fave350 dt { font-size:18px; font-weight:400; text-align:center;}
	.m_fave350 dt strong { font-size:30px; font-weight:900; font-family:'Nanumsquare'; margin-right:4px; line-height:30px; }
	.m_fave350 dd { }
	.m_fave350 dd p { color:#434343; font-size:13px; line-height:20px; padding:15px 0 30px; text-align:center; }
	.m_fave350 dd ul li { float:none; width:40%; text-align:center; height:auto; margin:0 auto 15px;}
	.m_fave350 dd ul li img { width:100%; }
	.m_fave350 dd ul li:first-child { margin:0 auto 15px; }
	.m_fave350 dd ul li span { display:block; padding-top:10px; font-size:14px; font-weight:700; color:#434343; }
	.m_fave350 dd em { display:none; line-height:31px; color:#434343; font-size:18px; padding:65px 0 0; }

	.exercise { width:100%; margin:0 auto; position:relative; height:auto; padding:40px 0; }
	.exercise dl dt { font-size:20px; color:#ec6a48; line-height:22px; padding-bottom:10px; text-align:center; font-weight:700; }
	.exercise dl dd { font-size:13px; line-height:20px; color:#434343; padding:30px 10% 0; }
	.exercise h5 { padding:30px 10% 12px; font-weight:700; color:#575757; line-height:18px; font-size:15px; }
	.exercise ul { width:78%; margin:0 auto; }
	.exercise ul li { float:left; width:55%; }
	.exercise ul li:first-child { width:45%; }
	.exercise ul li span { display:block; font-size:14px; color:#575757; padding-bottom:15px; }

	.m_sample-img {
		width:70%; position:relative; margin:0 auto;
		padding-bottom:40px;
	}
	.m_sample-img img { width:100%; }

	.m_cross-img {
		width:35%; position:relative;
		padding-bottom:10px;
	}
	.m_cross-img img { width:100%; }


	.m_det3 { height:auto; background:#e2e6ef; padding:0 0 20px; }
	.m_det3 dl { padding:0 12%; }
	.m_det3 dl dt { color:#ec6a48; font-size:20px; font-weight:700; line-height:26px; letter-spacing:-0.02em; padding:30px 0 15px; }
	.m_det3 dl dd { color:#323232; font-size:13px; line-height:20px; letter-spacing:-0.02em; padding:0 0 12px;}
	.m_det3 span { display:block; width:60%; margin:0 auto; }
	.m_det3 span img { width:100%; }

	.m_det4 { position:relative; }
	.m_det4 p { font-size:13px; color:#323232; line-height:20px; letter-spacing:-0.02em; position:absolute; left:12%; top:20%; width:76%; }
	.m_det4 p strong { font-size:20px; color:#ec6a48; font-weight:700; display:block; line-height:30px; }

	.m_det5 { position:relative; }
	.m_det5_box { position:absolute; left:12%; top:4%; width:76%; }
	.m_det5_box > img { width:100%; }
	.m_det5_box p { font-size:13px; color:#fff; line-height:20px; letter-spacing:-0.02em; padding:20px 0 20px 10px;}
	.m_det5_box span { display:block; width:50%; margin:0 auto; }
	.m_det5_box span > img { width:100%; }

	.proBox { position:relative; height:auto; overflow:hidden; }
	.proImg { position:relative; left:0; top:10px; margin-left:0; z-index:2; }
	.proImg img { width:100%; max-width:100%; }

	.proInfo {
		width:85%; height:auto; position:relative; left:0; top:40px;
		margin-left:-660px; margin:0 auto; z-index:3;
	}
	.proInfo > p {
		color:#ec6a48;
		width:320px; margin:0 auto;
	}
	.proInfo > p strong {
		display:block; font-size:40px; font-weight:900; font-family:'Nanumsquare';
		line-height:44px; letter-spacing:-0.04em;
	}
	.proInfo > p span {
		display:block; font-size:16px; font-weight:700; margin-top:12px;
		line-height:20px;
	}
	.btnPrice { text-align:center; }
	.proOption { padding:50px 0 25px; }
	.poSelt {
		height:53px; background:#f4f4f4; font-size:17px; color:#3c3836; padding:3px 10px 0 13px;
		font-weight:300; font-family:'Nanumsquare'; margin-bottom:13px; display:block; width:100%;
		border:0;
	}
	.cartList { border-top:1px solid #ededed;}
	.cartList li { height:72px; border-bottom:1px solid #ededed; }
	.cartList li:after { content:"";clear:both;display:block; }
	.cartList li * { display:block; font-weight:300; font-family:'Nanumsquare';}
	.cartList li strong { float:left; width:55%; color:#3c3836; font-size:17px; padding:25px 0 25px 10px; }
	.cartList li select {
		float:left; width:15%; border:1px solid #ed6f4e; height:30px; margin-top:20px;
		text-align:right; padding:0 0 0 5px;
	}
	.cartList li a {
		float:right; width:30%; font-size:13px; color:#3c3836; padding:25px 30px 25px 0;
		background:url(/images/contents/product/product-del.png) no-repeat right 10px center;
		text-align:right; margin-right:0;
	}
	.totalPrice { color:#3c3836; text-align:right; padding:20px 0 10px;}
	.totalPrice strong { font-weight:900; font-family:'Nanumsquare'; font-size:36px; line-height:36px; }
	.totalPrice strong em { font-weight:400; font-family:'Nanumsquare'; font-size:36px;}
	.totalPrice span { font-weight:300; font-family:'Nanumsquare'; font-size:23px; margin-left:6px;}
	.btnPrice { height:130px; }

	a.btn-orange {
		background:#eb613d; font-size:18px; color:#fff; text-align:center; height:42px; letter-spacing:-0.05em; line-height:24px;
		width:160px; border:0; cursor:pointer; display:inline-block; padding:9px 0 0;
		border:1px solid #eb613d;
	}


	.checkBox {
		position:relative; z-index:!; height:auto; display:block;
		background:url(/images/contents/product/p_bg_check.jpg) no-repeat center top;
	}
	.checkIt { width:100%; margin:0 auto; padding:55px 6% 50px;}
	.checkIt h4 { color:#3c3836; font-size:30px; font-weight:900; font-family:'Nanumsquare'; padding:0 0 30px; text-align:center; }
	.checkIt h4 span { font-weight:700; }

	.checkIt > p { font-size:13px; color:#3c3836; letter-spacing:-0.02em; line-height:17px; }
	.checkIt > p strong { color:#ec6a48; }
	.checkIt > p span { display:block; padding-top:18px; }

	.checkIt dl { letter-spacing:-0.02em; padding:20px 0 0; }
	.checkIt dl dt { color:#3c3836; font-weight:900; font-family:'Nanumsquare'; font-size:18px;  line-height:22px; padding-bottom:10px; }
	.checkIt dl dd { color:#3c3836; font-size:13px; line-height:17px; }
	.checkIt dl dd strong { font-weight:400; color:#ec6a48; }

	.checkIt dl.ti_dl { margin-top:40px; border-top:1px dashed #ec6a48; padding:40px 0 0; }
	.checkIt dl.ti_dl dd { margin-bottom:12px; }

}

</style>

            <section>
                <div class="checkBox">
					<div class="checkIt">
						<h4>CHECK <span>IT</span></h4>
						<p>A refund / exchange request is possible within <strong>7 days</strong> from the delivery completion date.
						<span>How to request a refund / exchange</span>
						</p>
						<dl>
							<dt>· refund</dt>
							<dd>
								home page > Request a refund on the purchase history page<br>
								Courier Article refund Collection <br>
								Refund completed
							</dd>
						</dl>
						<dl>
							<dt>· exchange</dt>
							<dd>
								Home page > Request an exchange from the Purchase History page<br>
								Courier Article Exchange Collection<br>
								Refund completed
							</dd>
						</dl>
						<dl>
							<dt>· Refund / Exchange Shipping</dt>
							<dd>
								Refund : If the product is defective or misplaced, the seller will pay the postage<br>
								If the remorse is simple, the buyer will pay the shipping cost.<br>
								In addition to the basic transportation costs of the mountainous area and overseas shipping products, there are
								additional shipping costs.<br><br>
							</dd>
							<dd>
								Exchange : If the product is defective or misplaced, the seller will pay the postage<br>
								If it is a simple remorse, please check the return shipping cost and enclose it in the box.<br>
								It is usually 5,000 won, but depends on the product. If there is no stock, it may be refunded.
							</dd>
						</dl>
						<dl>
							<dt>· non-refund / non-exchange</dt>
							<dd>
								<strong>Please note that if the product is unpacked or the packaging is damaged, refund / exchange is not possible.<br>
								If you use the product, it will not be refunded or exchanged.</strong><br>
								If the refund / exchange request period is exceeded(When delivery exceeds 7 days)<br>
								Lost / damaged / broken / contaminated<br>
								If the image of color etc. differs from the actual one due to the difference in monitor resolution
							</dd>
						</dl>
						<dl class="ti_dl">
							<dt>· Transaction Information</dt>
							<dd>
								How to supply goods and supplies<br>
								: See detailed description in content
							</dd>
							<dd>
								Withdrawal of subscription and release of contract<br>
							   : See shipping / refund information and detailed description on content
							</dd>
							<dd>
								Conditions for payment of compensation for delayed refund or refund<br>
								: Subject to the provisions of the Act on Consumer Protection in Electronic Commerce etc.
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
