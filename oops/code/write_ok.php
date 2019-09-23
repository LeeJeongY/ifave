<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";
	
	$kind_name		= html2db($kind_name);
	$kind_code		= html2db($kind_code);
	$code_format	= html2db($code_format);
	$use_yn			= html2db($use_yn);
	$display_code   = html2db($display_code);
	$remarks		= html2db($remarks);

	if($tbl == "") $tbl = "kindcode";
	if($tbl_sub == "") $tbl_sub = "selcode";

	$signdate   = date("Y"."-"."m"."-"."d H:i:s");	

	// $gubun 값에 의해서 등록/수정, 삭제
	if ($gubun == "update") {  # 수정일때

		$upqry = " update ".$initial."_code_".$tbl." set ";
		$upqry .= " use_yn			= '$use_yn'";
		$upqry .= ", kind_name		= '$kind_name'";
		$upqry .= ", kind_code		= '$kind_code'";
		$upqry .= ", code_format	= '$code_format'";
		$upqry .= ", display_code	= '$display_code'";
		$upqry .= ", remarks		= '$remarks'";
		$upqry .= ", upddate		= '$signdate'";
		$upqry .= " where kind_idx	= '$kind_idx' ";
		$result = mysql_query($upqry, $dbconn); 
		if(!$result) {
			echo "<script>self.window.alert('정상적으로 처리되지 않았습니다.\nERROR : ".mysql_error()."');history.back();</script>";
			exit; 
		} else {
			$msg = "수정";
		}   # end of if(!$result) { ... 
	// 수정 완료
	}


	if ($gubun == "delete") {
		$delqry = " delete from ".$initial."_code_".$tbl." ";
		$delqry .= " where kind_idx = '$idx' ";
		$result = mysql_query($delqry, $dbconn); 
		if(!$result) {
			echo "<script>self.window.alert('정상적으로 처리되지 않았습니다.\nERROR : ".mysql_error()."');history.back();</script>";
			exit; 
		} else {
			$msg = "삭제";
		}   # end of if(!$result) { ... 
	
	//삭제 완료
	}

	if($gubun == "remove") {
		for($i=0;$i<count($idxchk);$i++) {
			//하위코드
			$query 	= "delete from ".$initial."_code_".$tbl_sub." where kind_code = '$idxchk[$i]'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			//상위코드
			$query 	= "delete from ".$initial."_code_".$tbl." where kind_code = '$idxchk[$i]'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			$msg = "삭제";
		}
	}

	if ($gubun == "insert") {

		$maxnum_qry = "select max(kind_idx) as maxVal from ".$initial."_code_".$tbl."";
		$maxnum_result = mysql_query($maxnum_qry, $dbconn) or die(mysql_error());		
		if($maxnum_array = mysql_fetch_array($maxnum_result)) {
			$maxnum		= $maxnum_array[maxVal];
			if ($maxnum == "" or $maxnum == NULL) $seq = 1;
			else $seq = $maxnum + 1;
		}

		$ins_qry = "insert into ".$initial."_code_".$tbl." (";
		$ins_qry .= " kind_idx";
		$ins_qry .= ", kind_code";
		$ins_qry .= ", kind_name";
		$ins_qry .= ", code_format";
		$ins_qry .= ", use_yn";
		$ins_qry .= ", display_code";
		$ins_qry .= ", remarks";
		$ins_qry .= ", regdate";
		$ins_qry .= " ) values (";
		$ins_qry .= " $seq";
		$ins_qry .= ", '$kind_code'";
		$ins_qry .= ", '$kind_name'";
		$ins_qry .= ", '$code_format'";
		$ins_qry .= ", '$use_yn'";
		$ins_qry .= ", '$display_code'";
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
<form name="fm" method="get" action="list.php">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
<input type="hidden" name="page" value="<?=$page?>">
</form>
<script>
alert('정상적으로 <?=$msg?> 되었습니다.');
<?if($gubun=="delete" || $gubun=="remove") {?>
document.fm.submit();
<?} else {?>
window.opener.document.location.href = window.opener.document.URL;
self.close();
<?}?>
</script>
<? mysql_close($dbconn); ?>
