<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl = "product";
	$foldername	= "../../$upload_dir/$tbl/";

	$order_num				= addslashes($order_num);

	//기존데이터 수정인경우 ======================
	if ($gubun  == "update") {

		$query = "UPDATE ".$initial."_".$tbl."_order SET ";
		$query .= "  order_name        ='".$order_name."'";
		$query .= ", order_tel         ='".$order_tel."'";
		$query .= ", order_hp          ='".$order_hp."'";
		$query .= ", order_email       ='".$order_email."'";
		$query .= ", order_zipcode     ='".$order_zipcode."'";
		$query .= ", order_addr1       ='".$order_addr1."'";
		$query .= ", order_addr2       ='".$order_addr2."'";
		$query .= ", order_addr3       ='".$order_addr3."'";
		$query .= ", receive_name      ='".$receive_name."'";
		$query .= ", receive_tel       ='".$receive_tel."'";
		$query .= ", receive_hp        ='".$receive_hp."'";
		$query .= ", receive_email     ='".$receive_email."'";
		$query .= ", receive_zipcode   ='".$receive_zipcode."'";
		$query .= ", receive_addr1     ='".$receive_addr1."'";
		$query .= ", receive_addr2     ='".$receive_addr2."'";
		$query .= ", receive_addr3     ='".$receive_addr3."'";
		$query .= ", title             ='".$title."'";
		$query .= ", message           ='".$message."'";
		$query .= ", pay_state         ='".$pay_state."'";
		$query .= ", pay_type          ='".$pay_type."'";
		$query .= ", sum_amount        ='".$sum_amount."'";
		$query .= ", fee_amount        ='".$fee_amount."'";
		$query .= ", pay_amount        ='".$pay_amount."'";
		$query .= ", pay_bank_code     ='".$pay_bank_code."'";
		$query .= ", pay_bank_name     ='".$pay_bank_name."'";
		$query .= ", pay_deposit_name  ='".$pay_deposit_name."'";
		$query .= ", pay_account_number='".$pay_account_number."'";
		$query .= ", pay_deposit_date  ='".$pay_deposit_date."'";
		$query .= ", pay_card_code     ='".$pay_card_code."'";
		$query .= ", pay_card_name     ='".$pay_card_name."'";
		$query .= ", pay_card_number   ='".$pay_card_number."'";
		$query .= ", delivery_state    ='".$delivery_state."'";
		$query .= ", delivery_company  ='".$delivery_company."'";
		$query .= ", delivery_number   ='".$delivery_number."'";
		$query .= ", delivery_date     ='".$delivery_date."'";
		$query .= ", remark            ='".$remark."'";
		$query .= ", upddate           = now()";
		//$query .= ", candate           ='".$candate."'";
		$query .= " WHERE seq = '".$order_seq."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());

		$msg = "수정";
	}


	if($gubun == "delete") {
		$sql = "DELETE FROM ".$initial."_".$tbl."_order_list WHERE order_fid='".$order_seq."'";
		mysql_query($sql,$dbconn) or die (mysql_error());

		$sql = "DELETE FROM ".$initial."_".$tbl."_order WHERE seq='".$order_seq."'";
		mysql_query($sql,$dbconn) or die (mysql_error());

		$msg = "삭제";
	}
?>
<? mysql_close($dbconn); ?>
<form name="form" method="get" action="list.php">
<input type="hidden" name="s_pay_type" value="<?=$s_pay_type?>">
<input type="hidden" name="s_pay_state" value="<?=$s_pay_state?>">
<input type="hidden" name="s_delivery_state" value="<?=$s_delivery_state?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="s_site" value="<?=$s_site?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("성공적으로 <?=$msg?>되었습니다.");
	<?if($popup=="1") {?>
	window.opener.document.location.href = window.opener.document.URL;
	self.close();
	<?} else {?>
	document.form.submit();
	<?}?>
//-->
</SCRIPT>
