<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($tbl == "") $tbl	= "inquiry";
	$foldername  = "../../$upload_dir/$tbl/";

	//hidden에 있던 값 전송
	$gubun	= addslashes($gubun);
	$page	= addslashes($page);

	if($page == "") { $page = 1; }

	//수정, 답변에 사용될 히든값
	$id   = addslashes($id);

	if ($gubun == "category") {
		$query = " update ".$initial."_bbs_".$tbl." set
					category='$category'";
		$query .= " where id=$id ";
		mysql_query("set autocommit=0");
		$result = mysql_query($query, $dbconn);
		if(!$result) {
			echo "<script>self.window.alert('오류발생 ".mysql_error()."');history.back();</script>";
			mysql_query("rollback");
			exit;
		} else {
			mysql_query("commit");
			$msg = "수정";
		}
	}
?>
<? mysql_close($dbconn); ?>
<form name="form" method="get" action="list.php">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="cate" value="<?=$cate?>">
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("정상적으로 <?=$msg?>되었습니다.");
	document.form.submit();
//-->
</SCRIPT>
