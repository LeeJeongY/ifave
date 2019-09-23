<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	//게시판 목록보기에 필요한 각종 변수 초기값을 설정합니다.
	if($_t == "") $_t	= "qna"; 				//테이블 이름
	$foldername  = "../../$upload_dir/$tbl/";
	
	if ($gubun == "category") {

		for($i=0;$i<count($idxchk);$i++) { 

			######### 변경 ##########
			$query 	= "update ".$initial."_bbs_".$_t." set ";
			$query .= " category='".$catecode."'";
			$query .= " where idx = '".$idxchk[$i]."'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
		}
		$msg = "수정";
	}
?>
<? mysql_close($dbconn); ?>
<form name="form" method="get" action="list.php">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="_t" value="<?=$_t?>">
</form>
<script language="javascript">
<!--
	alert("정상적으로 <?=$msg?>되었습니다.");
	document.form.submit();
//-->
</script>
