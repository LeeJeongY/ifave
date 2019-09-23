<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";

	$tbl	= "members"; 							//테이블 이름
	$foldername = "../../$upload_dir/$tbl/";

	if ($UID) {

		//회원정보 출력
		$query = "select * from ".$initial."_".$tbl." where user_id='".$UID."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {

			foreach ($array as $tmpKey => $tmpValue) {

				$$tmpKey = $tmpValue;
			}// end foreach

			list($user_hp1,$user_hp2,$user_hp3) = explode("-",$user_hp);
			list($client_tel1,$client_tel2,$client_tel3) = explode("-",$client_tel);
			list($client_tel1,$client_tel2,$client_tel3) = explode("-",$client_tel);

			list($edu_charge_tel1,$edu_charge_tel2,$edu_charge_tel3) = explode("-",$edu_charge_tel);

		}

	}

	include "../inc/header.php";
?>

<script>
$(document).ready(function(){
	var action = 'click';
	var speed = "500";

	$('tr.q').on(action, function(){
		$(this).next().slideToggle(speed).siblings('tr.a').slideUp();
	});
});
</script>
<style>
/*
.oTable tr.q {cursor:pointer;}
*/
.order_list {padding-top:20px;}
.order_list ul {clear:both;padding-top:5px;}
.order_list ul li {float:left;padding-left:10px;}
.order_list ul li.or_name {text-align:left;width:160px;}
.order_list ul li.or_price {width:100px;}
</style>
		<!-- container -->
		<div id="container">
			<section>
				<div class="cont_my">
					<?if($UID!="") {?>
					<h2>My page</h2>
					<p>Edit membership information</p>
					<div class="myInfo">
						<p><?=$user_name?></p>
						<ul class="my-ul1">
							<li>
								<strong>Membership</strong>
								<span>General</span>
							</li>
							<li>
								<strong>Mobile phone number</strong>
								<span><?=$user_hp?></span>
							</li>
						</ul>
						<ul class="my-ul2">
							<li>
								<strong>Email address</strong>
								<span><?=$user_email?></span>
							</li>
							<li>
								<strong>Delivery Address</strong>
								<span><?=$addr3?>, <?=$addr2?>, <?=$addr1?> <?=$zipcode?></span>
							</li>
						</ul>
						<a href="join_edit.php" class="btn-info-modify"><span class="blind">개인정보수정</span></a>
					</div>
					<?} else {?>
					<h2>My page</h2>
					<p>Order information</p>
					<?}?>

					<article>
						<div class="orderHistory">
							<h3>Order History</h3>
							<table class="oTable">
								<colgroup>
									<col width="20%">
									<col width="15%">
									<col width="30%">
									<col width="15%">
									<col width="20%">
								</colgroup>
								<thead>
									<tr>
										<th>Order Number</th>
										<th>Date</th>
										<th>Product name</th>
										<th>Price</th>
										<th>Order status</th>
									</tr>
								</thead>
								<tbody>


									<?
									//주문정보
									$query = "SELECT * FROM ".$initial."_product_order WHERE seq is not null";
									if($UID) {
										$query .= " AND order_id='".$UID."'";
										$query .= " AND order_id!=''";
									} else {
										$query .= " AND order_num='".$order_num."'";
										$query .= " AND order_id=''";
									}
									$result = mysql_query($query, $dbconn) or die (mysql_error());
									$chk_num = 0;
									while($array = mysql_fetch_array($result)) {
										$seq               	= $array[seq];
										$order_tid         	= $array[order_tid];
										$order_num         	= $array[order_num];
										$order_id          	= $array[order_id];
										$order_name        	= db2html($array[order_name]);
										$order_tel         	= $array[order_tel];
										$order_hp          	= $array[order_hp];
										$order_email       	= $array[order_email];
										$order_zipcode     	= $array[order_zipcode];
										$order_addr1       	= $array[order_addr1];
										$order_addr2       	= $array[order_addr2];
										$order_addr3       	= $array[order_addr3];
										$receive_name      	= db2html($array[receive_name]);
										$receive_tel       	= $array[receive_tel];
										$receive_hp        	= $array[receive_hp];
										$receive_email     	= $array[receive_email];
										$receive_zipcode   	= $array[receive_zipcode];
										$receive_addr1     	= $array[receive_addr1];
										$receive_addr2     	= $array[receive_addr2];
										$receive_addr3     	= $array[receive_addr3];
										$title             	= db2html($array[title]);
										$message           	= db2html($array[message]);
										$pay_state         	= $array[pay_state];
										$pay_type          	= $array[pay_type];
										$pay_amount        	= $array[pay_amount];
										$pay_bank_code     	= $array[pay_bank_code];
										$pay_bank_name     	= db2html($array[pay_bank_name]);
										$pay_deposit_name  	= db2html($array[pay_deposit_name]);
										$pay_account_number	= $array[pay_account_number];
										$pay_deposit_date  	= $array[pay_deposit_date];
										$pay_card_code     	= $array[pay_card_code];
										$pay_card_name     	= $array[pay_card_name];
										$pay_card_number   	= $array[pay_card_number];
										$delivery_state    	= $array[delivery_state];
										$delivery_company  	= $array[delivery_company];
										$delivery_number   	= $array[delivery_number];
										$delivery_date     	= $array[delivery_date];
										$remark            	= db2html($array[remark]);
										$regdate           	= $array[regdate];
										$upddate           	= $array[upddate];
										$candate           	= $array[candate];


									?>
									<tr class="q">
										<td><?=$order_num?></td>
										<td><?=substr($regdate,0,10)?></td>
										<td class="pro-name">
										<?=$title?>
										<div class="order_list">

									<?
										$strQuery = "select * from ".$initial."_product_order_list where order_fid='".$seq."'";
										$strResult = mysql_query($strQuery, $dbconn) or die (mysql_error());
										while($strArray = mysql_fetch_array($strResult)) {
											$order_num		= $strArray[order_num];
											$user_id		= $strArray[user_id];
											$pidx			= $strArray[pidx];
											$pcode			= $strArray[pcode];
											$pname			= db2html($strArray[pname]);
											$quantity		= $strArray[quantity];
											$unit_price		= $strArray[unit_price];
											//$order_state	= $strArray[order_state];
											//$delivery_state	= $strArray[delivery_state];
											$v_regdate		= $strArray[regdate];
									?>
											<ul>
												<li class="or_name"><?=$pname?></li>
												<li class="or_price"><?=number_format($unit_price)?> * <?=$quantity?></li>
											</ul>
									<?
										}
									?>
										</div>

										</td>
										<td><?=number_format($pay_amount)?></td>
										<td>
										<?if($pay_state=="1") {?>
										<?=getCodeNameRemarkDB("code_delivery_state",$delivery_state, $dbconn)?>
										<?} else {?>
										<?=getCodeNameRemarkDB("code_pay_state",$pay_state, $dbconn)?>
										<?}?>
										</td>
									</tr>
									<?
										$chk_num++;
									}

									if($chk_num == 0) {
									?>

									<tr>
										<td colspan="5">not found</td>
									</tr>
									<?}?>



									<!-- <tr>
										<td>181110-212121</td>
										<td>2018-12-11</td>
										<td class="pro-name">FAVE 350</td>
										<td>215,000</td>
										<td>Deposit standby</td>
									</tr>
									<tr>
										<td>181110-688222</td>
										<td>2018-12-11</td>
										<td class="pro-name">FAVE 450</td>
										<td>215,000</td>
										<td>Deposit completed</td>
									</tr>
									<tr>
										<td>181110-267563</td>
										<td>2018-10-11</td>
										<td class="pro-name">FAVE 450</td>
										<td>215,000</td>
										<td>Preparing the product</td>
									</tr>
									<tr>
										<td>181110-245524</td>
										<td>2018-09-09</td>
										<td class="pro-name">FAVE 350</td>
										<td>215,000</td>
										<td>Shipped</td>
									</tr>
									<tr>
										<td>181110-212234</td>
										<td>2018-08-27</td>
										<td class="pro-name">FAVE 350</td>
										<td>215,000</td>
										<td>Deliver complete</td>
									</tr> -->
								</tbody>
							</table>
						</div>
					</article>

					<!-- <div class="btn-area">
						<a href="/" class="btn-c btn-more">+MORE</a>
					</div> -->

				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
