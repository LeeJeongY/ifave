<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl = "order";
	// order
	$pay_state	= addslashes($pay_state);
	$sql = "UPDATE ".$initial."_product_".$tbl." SET ";
	if($kind_state=="pay")		$sql .= " pay_state='".$pay_state."'";
	if($kind_state=="delivery")	$sql .= " delivery_state='".$pay_state."'";
	$sql .= " WHERE seq ='".$order_seq."'";
	mysql_query($sql, $dbconn) or die (mysql_error());

	// order list
	$sql = "UPDATE ".$initial."_product_".$tbl."_list SET ";
	if($kind_state=="pay")		$sql .= " order_state='".$pay_state."'";
	if($kind_state=="delivery")	$sql .= " delivery_state='".$pay_state."'";
	$sql .= " WHERE order_fid ='".$order_seq."'";
	mysql_query($sql, $dbconn) or die (mysql_error());

	$msg = "변경";
?>
<? mysql_close($dbconn); ?>

<form name="form" method="get" action="list.php">
<input type="hidden" name="s_pay_type" value="<?=$s_pay_type?>">
<input type="hidden" name="s_pay_state" value="<?=$s_pay_state?>">
<input type="hidden" name="s_delivery_state" value="<?=$s_delivery_state?>">
<input type="hidden" name="page" value="<?=$page?>">
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
	alert("정상적으로 <?=$msg?>되었습니다.");
	document.form.submit();
//-->
</SCRIPT>