<?
	session_start();

	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";

	foreach ($_POST as $tmpKey => $tmpValue) {
		//echo $tmpKey." = ".$tmpValue."<br>";
		$$tmpKey = $tmpValue;
	}// end foreach

	$tbl	= "product"; 				//테이블 이름
	$foldername = "../../$upload_dir/$tbl/";

	$idx			= stripslashes($idx);
	$order_name		= html2db($order_name);
	$order_hp		= stripslashes($order_hp);
	$order_email	= stripslashes($order_email);
	$receive_name	= html2db($receive_name);
	$receive_hp		= stripslashes($receive_hp);
	$receive_zipcode= stripslashes($receive_zipcode);
	$receive_addr1	= stripslashes($receive_addr1);
	$receive_addr2	= stripslashes($receive_addr2);
	$receive_addr3	= stripslashes($receive_addr3);
	$message		= html2db($message);
	$remark			= html2db($remark);

	if($gubun=="") $gubun = "pay";

	if($gubun == "pay") {

		$query = "SELECT max(seq) as maxVal FROM ".$initial."_".$tbl."_order";
		$result = mysql_query($query, $dbconn);
		if($array = mysql_fetch_array($result)) {
			$max_val = $array[maxVal];
			if($max_val < 0) $max_num = 1;
			else $max_num = $max_val + 1;
		}

		//$order_num = date("YmdHi").sprintf('%02d', $cate1).sprintf('%02d', $cate2).sprintf('%06d', $max_num);
		$order_num = date("YmdH")."-".sprintf('%06d', $max_num);

		$pay_state = "0";
		//승인
		if($pay_result == "00") {
			$pay_state = "1";
		}

		//배송상태
		$delivery_state = 0;

		$query = "INSERT INTO ".$initial."_".$tbl."_order SET ";
		$query .= "  seq                = '".$max_num."'";
		$query .= ", order_tid          = '".$order_tid."'";
		$query .= ", order_num          = '".$order_num."'";
		$query .= ", order_id           = '".$UID."'";
		$query .= ", order_name         = '".$order_name."'";
		$query .= ", order_tel          = '".$order_tel."'";
		$query .= ", order_hp           = '".$order_hp."'";
		$query .= ", order_email        = '".$order_email."'";
		$query .= ", order_zipcode      = '".$order_zipcode."'";
		$query .= ", order_addr1        = '".$order_addr1."'";
		$query .= ", order_addr2        = '".$order_addr2."'";
		$query .= ", order_addr3        = '".$order_addr3."'";
		$query .= ", receive_name       = '".$receive_name."'";
		$query .= ", receive_tel        = '".$receive_tel."'";
		$query .= ", receive_hp         = '".$receive_hp."'";
		$query .= ", receive_email      = '".$receive_email."'";
		$query .= ", receive_zipcode    = '".$receive_zipcode."'";
		$query .= ", receive_addr1      = '".$receive_addr1."'";
		$query .= ", receive_addr2      = '".$receive_addr2."'";
		$query .= ", receive_addr3      = '".$receive_addr3."'";
		$query .= ", title              = '".$title."'";
		$query .= ", message            = '".$message."'";
		$query .= ", pay_state          = '".$pay_state."'";
		$query .= ", pay_type           = '".$pay_type."'";
		$query .= ", sum_amount         = '".$sum_amount."'";
		$query .= ", fee_amount         = '".$fee_amount."'";
		$query .= ", pay_amount         = '".$pay_amount."'";
		$query .= ", pay_bank_code      = '".$pay_bank_code."'";
		$query .= ", pay_bank_name      = '".$pay_bank_name."'";
		$query .= ", pay_deposit_name   = '".$pay_deposit_name."'";
		$query .= ", pay_account_number = '".$pay_account_number."'";
		$query .= ", pay_deposit_date   = '".$pay_deposit_date."'";
		$query .= ", pay_card_code      = '".$pay_card_code."'";
		$query .= ", pay_card_name      = '".$pay_card_name."'";
		$query .= ", pay_card_number    = '".$pay_card_number."'";
		$query .= ", delivery_state     = '".$delivery_state."'";
		$query .= ", delivery_company   = '".$delivery_company."'";
		$query .= ", delivery_number    = '".$delivery_number."'";
		$query .= ", delivery_date      = '".$delivery_date."'";
		$query .= ", remark             = '".$remark."'";
		$query .= ", site				= 'en'";
		$query .= ", regdate            = now()";

		//$query .= ", upddate            = '".$upddate."'";
		//$query .= ", candate            = '".$candate."'";

		$result=mysql_query($query, $dbconn) or die (mysql_error());


		for($i = 0;$i < count($r_pcode);$i++) {
			$debug .= "pcode = ".$r_pcode[$i]."<br>";
			$debug .= "pname = ".$r_pname[$i]."<br>";
			$debug .= "price = ".$r_price[$i]."<br>";
			$debug .= "qty = ".$r_qty[$i]."<br>";

			$sql = "SELECT max(idx) as maxVal FROM ".$initial."_".$tbl."_order_list";
			$rs = mysql_query($sql, $dbconn);
			if($arr = mysql_fetch_array($rs)) {
				$idx_val = $arr[maxVal];
				if($idx_val < 0) $idx_num = 1;
				else $idx_num = $idx_val + 1;
			}


			$sql = "INSERT INTO ".$initial."_".$tbl."_order_list SET ";
			$sql .= "  idx             = '".$idx_num."'";
			$sql .= ", order_fid       = '".$max_num."'";
			$sql .= ", order_num       = '".$order_num."'";
			$sql .= ", user_id	       = '".$UID."'";
			$sql .= ", pidx            = '".$r_pidx[$i]."'";
			$sql .= ", pcode           = '".$r_pcode[$i]."'";
			$sql .= ", pname           = '".$r_pname[$i]."'";
			$sql .= ", quantity        = '".$r_qty[$i]."'";
			$sql .= ", unit_price      = '".$r_price[$i]."'";
			$sql .= ", order_state     = '".$pay_state."'";
			$sql .= ", delivery_state  = '".$delivery_state."'";
			//$sql .= ", remark          = '".$remark."'";
			$sql .= ", regdate         = now()";
			mysql_query($sql, $dbconn) or die (mysql_error());
		}


		$msg = "주문하신 상품이 신청";






		/*

		* 비회원일 경우 메일 발송 할 것
		* 주문번호

		*/

	}
	mysql_close($dbconn);

?>
<form name="form" method="get" action="order_complete.php">
<input type="hidden" name="order_num" value="<?=$order_num?>">
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	//alert("성공적으로 <?=$msg?>되었습니다.");
	<?//if($gubun=="delete" || $gubun=="remove" || $gubun=="state") {?>
	document.form.submit();
	<?//} else {?>
	//window.opener.document.location.href = window.opener.document.URL;
	//self.close();
	<?//}?>
//-->
</SCRIPT>