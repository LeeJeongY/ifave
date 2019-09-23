<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$kind_name	= html2db($kind_name);
	$kind_code	= html2db($kind_code);
	$code		= html2db($code);
	$code_name	= html2db($code_name);
	$use_yn		= html2db($use_yn);
	$seq_no		= html2db($seq_no);
	$remarks	= html2db($remarks);

	if($tbl2 == "") $tbl2 = "selcode";
	$signdate   = date("Y"."-"."m"."-"."d H:i:s");

	if ($code_name == "" && $gubun != "delete") {
		echo "<script>self.window.alert('각 항목의 내용을 입력하십시오');history.back();</script>";
		exit;
	}
	# 내용이 존재하면 등록/답변, 수정, 삭제 처리 시작
	// $gubun 값에 의해서 등록/수정, 삭제

	if ($gubun == "update") {  # 수정일때

		$upqry = " UPDATE ".$initial."_code_".$tbl2." SET ";
		$upqry .= " use_yn		= '".$use_yn."'";
		$upqry .= ", code_name	= '".$code_name."'";
		$upqry .= ", s_code		= '".$code."'";
		$upqry .= ", seq_no		= '".$seq_no."'";
		$upqry .= ", remarks	= '".$remarks."'";
		$upqry .= ", upddate	= '".$signdate."'";
		$upqry .= " WHERE code_idx = '".$code_idx."' ";

		$result = mysql_query($upqry, $dbconn);
		if(!$result) {
			echo "<script>self.window.alert('정상적으로 처리되지 않았습니다.\nERROR : ".mysql_error()."');history.back();</script>";
			exit;
		} else {
			$msg = "수정";
		}   # end of if(!$result) { ...

		// 수정 완료

	} else if ($gubun == "delete") {
		$delqry = " DELETE FROM ".$initial."_code_".$tbl2." ";
		$delqry .= " WHERE kind_code = '".$code."'";
		$delqry .= " AND code_idx = '".$idx."' ";
		$result = mysql_query($delqry, $dbconn);
		if(!$result) {
			echo "<script>self.window.alert('정상적으로 처리되지 않았습니다.\nERROR : ".mysql_error()."');history.back();</script>";
			exit;
		} else {
			$msg = "삭제";
		}   # end of if(!$result) { ...

	//삭제 완료

	} else if ($gubun == "insert") {   # 새로 등록이거나 답변일경우

		$maxnum_qry = "SELECT max(code_idx) as maxVal FROM ".$initial."_code_".$tbl2."";
		$maxnum_result = mysql_query($maxnum_qry, $dbconn) or die(mysql_error());
		if($maxnum_array = mysql_fetch_array($maxnum_result)) {
			$maxnum		= $maxnum_array[maxVal];
			if ($maxnum == "" or $maxnum == NULL) $seq = 1;
			else $seq = $maxnum + 1;
		}

		$ins_qry = "INSERT INTO ".$initial."_code_".$tbl2." (";
		$ins_qry .= " code_idx";
		$ins_qry .= ", kind_code";
		$ins_qry .= ", s_code";
		$ins_qry .= ", code_name";
		$ins_qry .= ", seq_no";
		$ins_qry .= ", use_yn";
		$ins_qry .= ", remarks";
		$ins_qry .= ", regdate";
		$ins_qry .= " ) VALUES (";
		$ins_qry .= " $seq";
		$ins_qry .= ", '$kind_code'";
		$ins_qry .= ", '$code'";
		$ins_qry .= ", '$code_name'";
		$ins_qry .= ", '$seq_no'";
		$ins_qry .= ", '$use_yn'";
		$ins_qry .= ", '$remarks'";
		$ins_qry .= ", '$signdate'";
		$ins_qry .= ")";
		$result = mysql_query($ins_qry, $dbconn);

		if(!$result) {
			echo "<script>self.window.alert('정상적으로 처리되지 않았습니다.\nERROR : ".mysql_error()."');history.back();</script>";
			exit;
		} else {
			$msg = "등록";
		}
	}   # end of if ($gubun == "update") { ...
?>
<?if($gubun=="insert") {?>
<form name="fm" method="get" action="sub_write.php">
<?} else {?>
<form name="fm" method="get" action="list.php">
<?}?>
<input type="hidden" name="code" value="<?=$kind_code?>">
<input type="hidden" name="kind_name" value="<?=$kind_name?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
</form>
<script>
alert('정상적으로 <?=$msg?> 되었습니다.');
<?if($gubun=="delete" || $gubun=="insert") {?>
document.fm.submit();
<?} else {?>
window.opener.document.location.href = window.opener.document.URL;
self.close();
<?}?>
</script>
<? mysql_close($dbconn); ?>
