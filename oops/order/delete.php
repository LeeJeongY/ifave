<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/register_globals.php";
	include "../../modules/lib.php";
	include "../../modules/auth_chk.php";
	include "../../modules/func.php";
	include "../../modules/func_sql.php";

	$tbl	= "order"; 				//테이블 이름

	if($gubun != "remove") {
		?>
		<script>
			alert('잘못된 경로로 접근하셨습니다.');
			history.go(-1);
		</script>
		<?
		exit;
	}

	$idx_no = count($idxChk);

	for($i=0;$i<$idx_no;$i++) {
		######### 삭제 ##########
		$query 	= "delete from ".$initial."_".$tbl." where ordernum = '$idxChk[$i]'";
		$msg = "삭제";

		$result=mysql_query($query,$dbconn) or die (mysql_error());
	}

	mysql_close($dbconn);
?>

<form name="form" method="post" action="list.php">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="s_site" value="<?=$s_site?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
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
