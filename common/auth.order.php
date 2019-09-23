<?
	ini_set('register_globals','1');
	ini_set('session.bug_compat_42','1');
	ini_set('session.bug_compat_warn','0');
	ini_set('session.auto_start','1');

	session_start();

	header("Content-type:text/html;charset=utf-8");
	include "../modules/dbcon.php";
	include "../modules/config.php";
	include "../modules/func.php";
	include "../modules/func_q.php";




	foreach ($_POST as $tmpKey => $tmpValue) {

		// echo $tmpKey."//".$tmpValue."<br>";
		$$tmpKey = $tmpValue;
	}// end foreach

	$UGUBUN			= inject2db($login_flag);
	$user_id		= inject2db($user_id);
	$user_pwd		= inject2db($user_pwd);
	$return_url		= inject2db($return_url);
	$login_flag		= inject2db($login_flag);


	$tbl	= "order"; 				//테이블 이름
	$foldername = "../$upload_dir/$tbl/";

	//==== request값 ================================

	$user_id	= stripslashes($user_id);			// 아이디
	$signdate	= date("Y"."-"."m"."-"."d H:i:s");


	//아이디 체크
	if($order_name!="") {
		$query = "SELECT count(seq) as cnt FROM ".$initial."_product_".$tbl."";
		$query .= " WHERE order_name='".$order_name."'";
		$query .= " AND order_num='".$order_number."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}

		if($count_chk > 0) {

			$sql = "SELECT * from ".$initial."_product_".$tbl."";
			$sql .= " WHERE order_name = '".$order_name."'";
			$sql .= " AND order_num = '".$order_number."'";
			$rs		= mysql_query($sql,$dbconn) or die (mysql_error());
			$rows	= mysql_num_rows($rs);
			if($rows == 0) {
				popup_msg("Order number do not match.");
			 } else	{
				if($arr 	= mysql_fetch_array($rs)) {


					$order_num         	= $arr[order_num];
					$order_id          	= $arr[order_id];
					$order_name        	= db2html($arr[order_name]);
					$order_tel         	= $arr[order_tel];
					$order_hp          	= $arr[order_hp];
					$order_email       	= $arr[order_email];
					$order_zipcode     	= $arr[order_zipcode];
					$order_addr1       	= $arr[order_addr1];
					$order_addr2       	= $arr[order_addr2];
					$order_addr3       	= $arr[order_addr3];
					$receive_name      	= db2html($arr[receive_name]);
					$receive_tel       	= $arr[receive_tel];
					$receive_hp        	= $arr[receive_hp];
					$receive_email     	= $arr[receive_email];
					$receive_zipcode   	= $arr[receive_zipcode];
					$receive_addr1     	= $arr[receive_addr1];
					$receive_addr2     	= $arr[receive_addr2];
					$receive_addr3     	= $arr[receive_addr3];



				}
			 }
		} else {
			popup_msg("Order number do not match.");
		}
	}// end if

	// 페이지 이동
	if($returnurl=="") $returnurl = $home_url;

	mysql_close($dbconn);
?>
<script language="javascript">
<!--
	location.href="../member/mypage.php?order_num=<?=$order_num?>";
//-->
</script>
