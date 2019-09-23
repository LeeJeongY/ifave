<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "inquiry";
	$foldername  = "../../$upload_dir/$_t/";

	//hidden에 있던 값 전송
	$gubun	= addslashes($gubun);
	$page   = addslashes($page);

	if ($page == "") { $page = 1; }

	//수정, 답변에 사용될 히든값
	$idx		= addslashes($idx);
	$username   = addslashes($username);
	$email		= addslashes($email);
	$title		= html2db($title);
	if($_POST["ir1"]) $message	= $_POST["ir1"];
	$ans_text	= html2db($ans_text);
	$ans_name	= html2db($ans_name);
	$remote_ip	= getenv("REMOTE_ADDR");
	$regdate	= date("Y"."-"."m"."-"."d H:i:s");

	if ($gubun == "update") {  # 수정일때
		$query = " UPDATE ".$initial."_bbs_".$_t." SET";
		$query .= " title			='$title'";
		$query .= ", contents		='$contents'";
		$query .= " WHERE idx='$idx'";

		$result = mysql_query($query, $dbconn);
		$msg = "수정";
		// 수정 완료
	}	# end of if ($gubun == "update") { ...

	if ($gubun == "ans") {  # 처리일때
		$query = " UPDATE ".$initial."_bbs_".$_t." set";
		$query .= " user_state	='$user_state'";
		$query .= ", ans_text	='$ans_text'";
		$query .= ", ans_name	='$ans_name'";
		$query .= ", ansdate	='$regdate'";
		$query .= " WHERE idx='$idx'";

		$result = mysql_query($query, $dbconn);
		$msg = "접수처리";

		// 수정 완료
	}	# end of if ($gubun == "update") { ...

	if ($gubun == "insert") {
		# cat, par값 구하기
		$maxnum_qry = "SELECT max(idx) as maxVal FROM ".$initial."_bbs_".$_t."";
		$maxnum_result = mysql_query($maxnum_qry, $dbconn) or die(mysql_error());
		if($maxnum_array = mysql_fetch_array($maxnum_result)) {
			$maxnum = $maxnum_array[maxVal];
			if ($maxnum == "" or $maxnum == NULL) {
				$idx   = 1;
			} else {
				$idx   = $maxnum + 1;
			}
		}

		$query = "INSERT INTO ".$initial."_bbs_".$_t." (";
		$query .= "idx";
		$query .= ", title";
		$query .= ", contents";
		$query .= ") VALUES (";
		$query .= "$idx";
		$query .= ",'$title'";
		$query .= ", '$contents'";
		$query .= ")";

		$result = mysql_query($query, $dbconn);
		$msg = "등록";
	}	# end of if ($gubun == "insert") { ...

	if($gubun == "remove") {

		for($i=0;$i<count($idxchk);$i++) {

			######### 삭제 ##########
			$query 	= "DELETE FROM ".$initial."_bbs_".$_t." WHERE idx = '$idxchk[$i]'";
			$result	= mysql_query($query, $dbconn) or die (mysql_error());
			$msg	= "삭제";
		}

	}	# end of if ($gubun == "remove") { ...

	if ($gubun == "delete") {
		# 삭제
		$query = " DELETE FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx' ";
		$result = mysql_query($query, $dbconn);
		$msg = "삭제";
	}   # end of if ($gubun == "delete") { ...

?>
<? mysql_close($dbconn); ?>
<form name="form" method="get" action="list.php">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="cate" value="<?=$cate?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
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