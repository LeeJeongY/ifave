<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";

	//주문정보
	$query = "SELECT * FROM ".$initial."_product_order WHERE order_num='".$order_num."'";
	//if($UID) $query .= " AND order_id='".$UID."'";
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array = mysql_fetch_array($result)) {
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

	}

	include "../inc/header.php";
?>

		<!-- container -->
		<div id="container">

			<section>
				<div class="cont_sign">
					<h2>Thank you for your order!</h2>
					<form>
						<article>
							<div class="payComBox mt60">
								<table class="oTable1">
									<colgroup>
										<col width="70%">
										<col width="30%">
									</colgroup>
									<thead>
										<tr>
											<th colspan="2">Product name</th>
										</tr>
									</thead>
									<tbody>
										<?
										$strQuery = "select * from ".$initial."_product_order_list where order_num='".$order_num."'";
										$strResult = mysql_query($strQuery, $dbconn) or die (mysql_error());
										while($strArray = mysql_fetch_array($strResult)) {
											$pidx		= $strArray[pidx];
											$pcode		= $strArray[pcode];
											$pname		= db2html($strArray[pname]);
											$quantity	= $strArray[quantity];
											$unit_price	= $strArray[unit_price];
										?>
										<tr>
											<td class="o-product">
												<strong><?=$pname?></strong>
												<span>Quantity / <?=$quantity?></span>
											</td>
											<td class="o-price"><?=number_format($unit_price)?> won</td>
										</tr>
										<?}?>
									</tbody>
								</table>
							</div>
						</article>

						<article>
							<div class="payComBox">
								<table class="oTable1">
									<colgroup>
										<col width="70%">
										<col width="30%">
									</colgroup>
									<thead>
										<tr>
											<th colspan="2">Payment Information</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="o-product">
												<span>Paypal express cheakout</span>
											</td>
											<td class="o-price"><?=number_format($pay_amount)?> won</td>
										</tr>
									</tbody>
								</table>
							</div>
						</article>

						<article>
							<div class="payComBox">
								<table class="oTable2">
									<colgroup>
										<col width="25%">
										<col width="75%">
									</colgroup>
									<thead>
										<tr>
											<th colspan="2">Shipping Information</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th>Order Number</th>
											<td><b><?=$order_num?></b></td>
										</tr>
										<tr>
											<th>Buyer Name</th>
											<td><?=$order_name?></td>
										</tr>
										<tr>
											<th>Recipient Name</th>
											<td><?=$receive_name?></td>
										</tr>
										<tr>
											<th>Shipping address</th>
											<td><?=$receive_addr3?>, <?=$receive_addr2?>, <?=$receive_addr1?></td>
										</tr>
										<tr>
											<th>Contact</th>
											<td><?=$receive_hp?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</article>

						<div class="btn-area">
							<?if($UID!="") {?>
							<a href="../member/mypage.php" class="btn-orange btn-c">My page</a>
							<?} else {?>
							<a href="../member/mypage.php?order_num=<?=$order_num?>" class="btn-orange btn-c">My page</a>
							<?}?>
							<a href="/?lng=<?=$lng?>" class="btn-white ml25 btn-c">Home</a>
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
