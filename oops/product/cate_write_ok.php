<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	//게시판 목록보기에 필요한 각종 변수 초기값을 설정합니다.
	//수정, 답변에 사용될 히든값
	$bid   = addslashes($bid);
	$mid   = addslashes($mid);
	$name   = html2db($name);

	if($cmd == "insert") {

		if($bid != "" && $mid != "" && $tid == "") {
			$tbl = "product_cate3";
			$max_field = "tid";
		} else if($bid != "" && $mid == "") {
			$tbl = "product_cate2";
			$max_field = "mid";
		} else if($bid == "") {
			$tbl = "product_cate1";
			$max_field = "bid";
		}

	}


	if ($name == "") {
		echo "<script>alert('각 항목의 내용을 입력하십시오');history.back();</script>";
		exit;
	} else {   # 내용이 존재하면 등록/답변, 수정, 삭제 처리 시작
		// $gubun 값에 의해서 등록/수정, 삭제

		if ($cmd == "update") {  # 수정일때

			if($bid != "" && $mid != "" && $tid != "") {
				$tbl = "product_cate3";
				$where_qry = " where bid=$bid and mid=$mid and tid=$tid";
			} else if($bid != "" && $mid != "" && $tid == "") {
				$tbl = "product_cate2";
				$where_qry = " where bid=$bid and mid=$mid";
			} else if($bid != "" && $mid == "" && $tid == "") {
				$tbl = "product_cate1";
				$where_qry = " where bid=$bid";
			}
			$upqry = " update ".$initial."_".$tbl." set";
			$upqry .= " name		='$name'";
			$upqry .= ", remark		='$remark'";
			$upqry .= ", use_flag	='$use_flag'";
			$upqry .= $where_qry;


			$result = mysql_query($upqry, $dbconn);
			$msg = "수정";
			if(!$result) {
				echo "<script>alert('정상적으로 처리되지 않았습니다.\nERROR : ".mysql_error()."');history.back();</script>";
				exit;
			} else {
				$msg = "수정";
			}

			// 수정 완료
		} else if ($cmd == "insert") {   # 새로 등록이거나 답변일경우
			$maxnum_qry = "select max($max_field) as maxVal from ".$initial."_".$tbl."";
			$maxnum_result = mysql_query($maxnum_qry, $dbconn) or die(mysql_error());
			if($maxnum_array = mysql_fetch_array($maxnum_result)) {
				$maxnum		= $maxnum_array[maxVal];
				if ($maxnum == "" || $maxnum == NULL) $seq = 1;
				else $seq = $maxnum + 1;
			}

			if($max_field == "tid") {
				$ins_qry = "insert into ".$initial."_".$tbl."
						( tid, bid, mid, name, remark, use_flag) values ( $seq, $bid, $mid, '$name', '$remark','$use_flag')";
			} else if($max_field == "mid") {
				$ins_qry = "insert into ".$initial."_".$tbl."
						( mid, bid, name, remark, use_flag) values ( $seq, $bid, '$name', '$remark','$use_flag')";
			} else if($max_field == "bid") {
				$ins_qry = "insert into ".$initial."_".$tbl."
						( bid, name, remark, use_flag) values ( $seq, '$name', '$remark','$use_flag')";
			}
			$result = mysql_query($ins_qry, $dbconn);

			if(!$result) {
				echo "<script>self.window.alert(\"정상적으로 처리되지 않았습니다.\nERROR : ".mysql_error()."\");history.back();</script>";
				exit;
			} else {
				$msg = "등록";
			}
		}   # end of if ($gubun == "update") { ...
	}   # end of if($webgub=="" || $writer=="" || ...
?>
<form name="form" method="get" action="cate_list.php">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>
<script language="javascript">
<!--
	alert("정상적으로 <?=$msg?>되었습니다.");
	<?if($popup=="1") {?>
	window.opener.document.location.href = window.opener.document.URL;
	self.close();
	<?} else {?>
	document.form.submit();
	<?}?>

//-->
</script>
<? mysql_close($dbconn); ?>
