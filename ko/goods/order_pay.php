<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";

	include "../inc/header.php";

	//회원정보
	$query = "SELECT * FROM ".$initial."_members WHERE user_id='".$UID."'";
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array = mysql_fetch_array($result)) {
		$zipcode	= $array[zipcode];
		$addr1		= $array[addr1];
		$addr2    	= $array[addr2];
		$addr3    	= $array[addr3];
	}
	$order_name	= $UNAME;
	$order_hp	= $UHP;
	$order_email= $UEMAIL;

?>
<script language="javascript">
$(document).ready(function(){
	$("#order_submit").click(function() {
		if($("#title").val()=="") {
			alert("상품을 선택하세요.");
			$('#title').focus();
			return false;
		}
		if($("#order_name").val()=="") {
			alert("이름을 입력하세요.");
			$('#order_name').focus();
			return false;
		}
		if($("#order_hp").val()=="") {
			alert("연락처를 입력하세요.");
			$('#order_hp').focus();
			return false;
		}
		if($("#order_email").val()=="") {
			alert("이메일을 입력하세요.");
			$('#order_email').focus();
			return false;
		}


		if($.trim($('#receive_zipcode').val()) == ''){
			alert("우편번호를 입력하세요.");
			$('#receive_zipcode').focus();
			return false;
		}
		if($.trim($('#receive_name').val()) == ''){
			alert("받는 분의 이름을 입력하세요.");
			$('#receive_name').focus();
			return false;
		}
		if($.trim($('#receive_addr1').val()) == ''){
			alert("주소를 입력하세요.");
			$('#receive_addr1').focus();
			return false;
		}



		$("#fm").attr("target", "_self");
		$("#fm").attr("method", "post");
		if($("input:radio[name=pay_type]:checked").val()=="Card") {
			//$("#fm").attr("action", "order_pg_company.php");
			var w = window.open("order_pg_company.php", "popupWindow", "width=600, height=400, scrollbars=yes");
            var $w = $(w.document.body);
			return false;
		} else {

			$("#fm").attr("action", "order_progress.php");
		}
		$("#fm").submit();
	});



	$("#sameinfo").click(function() {
		var order_name = $('#order_name').val();
		var order_hp = $('#order_hp').val();
		if($("input:checkbox[id='sameinfo']").is(":checked")==true) {
			$('#receive_name').val(order_name);
			$('#receive_hp').val(order_hp);
			$('#receive_addr1').val("<?=$addr1?>");
			$('#receive_addr2').val("<?=$addr2?>");
			$('#receive_addr3').val("<?=$addr3?>");
			$('#receive_zipcode').val("<?=$zipcode?>");
		} else {
			$('#receive_name').val("");
			$('#receive_hp').val("");
			$('#receive_addr1').val("");
			$('#receive_addr2').val("");
			$('#receive_addr3').val("");
			$('#receive_zipcode').val("");
		}
	});
});

</script>
		<!-- container -->
		<div id="container">

			<section>
				<div class="cont_sign">
					<h2>주문</h2>
					<form name="fm" id="fm">
					<input type="hidden" name="gubun" value="pay">
						<article>
							<div class="orderInfo">
								<h3>주문 정보</h3>
								<table class="oTable">
									<colgroup>
										<col width="70%">
										<col width="30%">
									</colgroup>
									<thead>
										<tr>
											<th colspan="2">제품명</th>
										</tr>
									</thead>
									<tbody>
									<?
									$order_count = count($product_code);
									for($i=0;$i < $order_count;$i++) {
										$data_value .= "qty[$i] = ". $qty[$i].chr(10).chr(13);
										$data_value .= "unit_price[$i] = ". $unit_price[$i].chr(10).chr(13);
										$data_value .= "sum_price[$i] = ". $sum_price[$i].chr(10).chr(13);

										$total_amount += $sum_price[$i];


										$query = "select * from ".$initial."_product where pcode='".$product_code[$i]."'";
										$result = mysql_query($query, $dbconn) or die (mysql_error());
										if($array = mysql_fetch_array($result)) {
											$pidx    		= $array[idx];
											$pcode    		= $array[pcode];
											$pname			= db2html($array[pname]);
											$option_color 	= $array[option_color];
											$img_file 		= $array[img_file];
											$price    		= $array[price];
										}

										if($i==0) {
											$order_title = $pname;
										}
									?>

										<input type="hidden" name="r_pidx[]" value="<?=$pidx?>">
										<input type="hidden" name="r_pname[]" value="<?=$pname?>">
										<input type="hidden" name="r_pcode[]" value="<?=$pcode?>">
										<input type="hidden" name="r_price[]" value="<?=$price?>">
										<input type="hidden" name="r_qty[]" value="<?=$qty[$i]?>">
										<tr>
											<td class="o-product">
												<strong><?=$pname?></strong>
												<span>수량 / <?=$qty[$i]?></span>
											</td>
											<td class="o-price"><?=number_format($sum_price[$i])?> 원</td>
										</tr>
									<?}?>
									<?
									//결제금액(총금액 + 배송비)
									$pay_amount = $total_amount + $fee_amount;
									if($order_count > 1) {
										//$sub_title = " 외 ".($order_count-1)."건";
										$sub_title = ", and ".($order_count-1)."EA";
									}
									$title = $order_title.$sub_title;
									?>
									<input type="hidden" name="title" id="title" value="<?=$title?>">
									</tbody>
								</table>
							</div>
						</article>

						<article>
							<div class="payBox">
								<h3>구매자 정보</h3>
								<ul class="inList">
									<li>
										<label for="order_name">이름</label>
										<ul>
											<li><input type="text" class="itx int1" name="order_name" id="order_name" value="<?=$order_name?>"></li>
										</ul>
									</li>
									<li>
										<label for="order_hp">연락처</label>
										<ul>
											<li><input type="text" class="itx int3" name="order_hp" id="order_hp" value="<?=$order_hp?>"></li>
										</ul>
										<!-- <ul class="d-type">
											<li>
												<select class="selec1 int6">
													<option>Select</option>
												</select>
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int7">
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int7">
											</li>
										</ul> -->
									</li>
									<li>
										<label for="order_email">이메일</label>
										<ul>
											<li><input type="text" class="itx int3" name="order_email" id="order_email" value="<?=$order_email?>"></li>
										</ul>
									</li>
								</ul>
							</div>
						</article>

						<article>
							<div class="payBox">
								<h3>쇼핑 정보<span style="float:right;font-size:0.5em;"><input type="checkbox" name="sameinfo" id="sameinfo" value="Y"> <label for="sameinfo">동일한 정보</label></span></h3>
								<ul class="inList">
									<li>
										<label for="receive_name">받는사람</label>
										<ul>
											<li><input type="text" class="itx int1" name="receive_name" id="receive_name" value=""></li>
										</ul>
									</li>
									<li>
										<label for="receive_hp">연락처</label>
										<ul>
											<li><input type="text" class="itx int3" name="receive_hp" id="receive_hp" value=""></li>
										</ul>
									</li>
									<li>
										<label for="receive_addr">주소</label>
										<ul class="d-type-addr">
											<li>
												<input type="text" class="itx int2" name="receive_zipcode" id="receive_zipcode" value="" placeholder="ZIP/Postal Code">
											</li>
											<li>
												<input type="text" class="itx int4" name="receive_addr1" id="receive_addr1" value="" placeholder="State/Province/County">
											</li>
											<li>
												<input type="text" class="itx int4" name="receive_addr2" id="receive_addr2" value="" placeholder="City">
											</li>
											<li>
												<input type="text" class="itx int4" name="receive_addr3" id="receive_addr3" value="" placeholder="Address">
											</li>
										</ul>
									</li>
									<li>
										<label for="message">배송 메시지</label>
										<ul>
											<li style="display:block;"><textarea class="itx txta1" name="message" id="message"></textarea></li>
										</ul>
									</li>
								</ul>

							</div>
						</article>





						<article>
							<div class="payBox">
								<h3>결제 정보</h3>
								<ul class="inList">
									<li>
										<label for="pay_type">지불 방법</label>
										<ul>
											<li>
											<input type="radio" name="pay_type" id="pay_type_card" value="Card" checked> <label for="pay_type_card">신용 카드</label>
											<!-- <input type="radio" name="pay_type" id="pay_type_directbank" value="DirectBank"> <label for="pay_type_directbank">Real-time bank account transfer</label>
											<input type="radio" name="pay_type" id="pay_type_vbank" value="VBank"> <label for="pay_type_vbank">Bank deposit</label> -->
											<input type="radio" name="pay_type" id="pay_type_free" value="Free"> <label for="pay_type_free">Free</label>
											</li>
										</ul>
									</li>
								</ul>

							</div>
						</article>






						<div class="totalBox cfx">
							<ul>
								<li>
									<strong>비용</strong>
									<span><strong><?=number_format($total_amount)?></strong> 원</span>
								</li>
								<li>
									<strong>배송료</strong>
									<span><strong><?=number_format($fee_amount)?></strong> 원</span>
								</li>
							</ul>
							<dl>
								<dt>전체 금액</dt>
								<dd><strong><?=number_format($pay_amount)?></strong> 원</dd>
							</dl>
							<input type="hidden" name="sum_amount" id="sum_amount" value="<?=$total_amount?>">
							<input type="hidden" name="fee_amount" id="fee_amount" value="<?=$fee_amount?>">
							<input type="hidden" name="pay_amount" id="pay_amount" value="<?=$pay_amount?>">
							<a href="javascript:;" id="order_submit" class="btn-complete payment btn-c">결제하기</a>
						</div>

					</form>
				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
