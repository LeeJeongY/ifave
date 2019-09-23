<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "popup";
	$foldername  = "../../$upload_dir/$_t/";

	//hidden에 있던 값 전송
	$gubun	= addslashes($gubun);
	$page   = addslashes($page);

	if ($page == "") { $page = 1; }

	//수정, 답변에 사용될 히든값
	$idx		= addslashes($idx);
	$username   = addslashes($username);
	$title		= html2db($title);
	if($_POST["ir1"]) $body		= $_POST["ir1"];
	$body		= html2db($body);
	$regdate	= date("Y"."-"."m"."-"."d H:i:s");
	list($startdate, $enddate) = explode(" - ",trim($date));
	if($_ADMINID!="") $adminid = $_ADMINID;
	$img_name		= $_FILES["img_file"]["name"];
	$img_filesize	= $_FILES["img_file"]["size"];
	$imgfile		= $_FILES["img_file"]["tmp_name"];
	if($imgfile!="") {
		$img_FullFilename = upload_file_save($img_name, $foldername,$thumb_w,$thumb_h, $imgfile);
	}

	$data_name = $_FILES["user_file"]["name"];
	$data_filesize = $_FILES["user_file"]["size"];
	$datafile = $_FILES["user_file"]["tmp_name"];
	if($datafile!="") {
		$data_FullFilename = dataload_file_save($data_name, $foldername, $datafile);
	}

	if ($gubun == "update") {  # 수정일때
		$upqry = " update ".$initial."_bbs_".$_t." set";
		$upqry .= "  title    	='$title'";
		$upqry .= ", body     	='$body'";
		$upqry .= ", category 	='$category'";
		$upqry .= ", popup_flag	='$popup_flag'";
		//$upqry .= ", counts	='$counts'";
		$upqry .= ", nflag    	='$nflag'";
		$upqry .= ", list_add 	='$list_add'";
		$upqry .= ", scrollbar	='$scrollbar'";
		$upqry .= ", ptop     	='$ptop'";
		$upqry .= ", pleft    	='$pleft'";
		$upqry .= ", width    	='$width'";
		$upqry .= ", height   	='$height'";
		$upqry .= ", winopen  	='$winopen'";
		$upqry .= ", startdate	='$startdate'";
		$upqry .= ", enddate  	='$enddate'";
		$upqry .= ", pageurl  	='$pageurl'";
		$upqry .= ", mapflag  	='$mapflag'";
		$upqry .= ", image_map	='$image_map'";
		$upqry .= ", tag		='$tag'";
		$upqry .= ", view_flag	='$view_flag'";
		$upqry .= ", userid   	='$userid'";
		$upqry .= ", username 	='$username'";
		//$upqry .= ", regdate  	='$regdate'";
		$upqry .= ", upddate  	='$upddate'";
		$upqry .= ", vodpath  	='$vodpath'";
		$upqry .= ", vodfile1 	='$vodfile1'";
		$upqry .= ", vodfile2 	='$vodfile2'";
		$upqry .= ", vodfile3 	='$vodfile3'";
		$upqry .= ", bfilepath	='$bfilepath'";
		$upqry .= ", bfile1   	='$bfile1'";
		$upqry .= ", bfile2   	='$bfile2'";
		$upqry .= ", bfile3   	='$bfile3'";
		if ($data_FullFilename != "") {
			$upqry .= ", user_file	='$data_FullFilename'";
		}
		if ($img_FullFilename != "") {
			$upqry .= ", img_file	='$img_FullFilename'";
		}
		$upqry .= " where idx='$idx'";

		$result = mysql_query($upqry, $dbconn);
		if(!$result) {
			$error_msg = mysql_error();
		} else {
			$msg = "수정";
		}   # end of if(!$result) { ...
		// 수정 완료
	}	# end of if ($gubun == "update") { ...
	
	if ($gubun == "insert") {
		# cat, par값 구하기
		$maxnum_qry = "select max(idx) as maxVal from ".$initial."_bbs_".$_t."";
		$maxnum_result = mysql_query($maxnum_qry, $dbconn) or die(mysql_error());
		if($maxnum_array = mysql_fetch_array($maxnum_result)) {
			$maxnum = $maxnum_array[maxVal];
			if ($maxnum == "" or $maxnum == NULL) {
				$idx   = 1;
			} else {
				$idx   = $maxnum + 1;
			}
		}

		$ins_qry = "insert into ".$initial."_bbs_".$_t." (";
		$ins_qry .= "idx";
		$ins_qry .= ", title";
		$ins_qry .= ", body";
		$ins_qry .= ", category";
		$ins_qry .= ", popup_flag";
		$ins_qry .= ", counts";
		$ins_qry .= ", user_file";
		$ins_qry .= ", img_file";
		$ins_qry .= ", nflag";
		$ins_qry .= ", list_add";
		$ins_qry .= ", scrollbar";
		$ins_qry .= ", ptop";
		$ins_qry .= ", pleft";
		$ins_qry .= ", width";
		$ins_qry .= ", height";
		$ins_qry .= ", winopen";
		$ins_qry .= ", startdate";
		$ins_qry .= ", enddate";
		$ins_qry .= ", pageurl";
		$ins_qry .= ", mapflag";
		$ins_qry .= ", image_map";
		$ins_qry .= ", tag";
		$ins_qry .= ", view_flag";
		$ins_qry .= ", userid";
		$ins_qry .= ", username";
		$ins_qry .= ", regdate";
		$ins_qry .= ", upddate";
		$ins_qry .= ", vodpath";
		$ins_qry .= ", vodfile1";
		$ins_qry .= ", vodfile2";
		$ins_qry .= ", vodfile3";
		$ins_qry .= ", bfilepath";
		$ins_qry .= ", bfile1";
		$ins_qry .= ", bfile2";
		$ins_qry .= ", bfile3";
		$ins_qry .= ") values (";
		$ins_qry .= "$idx";
		$ins_qry .= ", '$title'";
		$ins_qry .= ", '$body'";
		$ins_qry .= ", '$category'";
		$ins_qry .= ", '$popup_flag'";
		$ins_qry .= ", '0'";
		$ins_qry .= ", '$data_FullFilename'";
		$ins_qry .= ", '$img_FullFilename'";
		$ins_qry .= ", '$nflag'";
		$ins_qry .= ", '$list_add'";
		$ins_qry .= ", '$scrollbar'";
		$ins_qry .= ", '$ptop'";
		$ins_qry .= ", '$pleft'";
		$ins_qry .= ", '$width'";
		$ins_qry .= ", '$height'";
		$ins_qry .= ", '$winopen'";
		$ins_qry .= ", '$startdate'";
		$ins_qry .= ", '$enddate'";
		$ins_qry .= ", '$pageurl'";
		$ins_qry .= ", '$mapflag'";
		$ins_qry .= ", '$image_map'";
		$ins_qry .= ", '$tag'";
		$ins_qry .= ", '$view_flag'";
		$ins_qry .= ", '$userid'";
		$ins_qry .= ", '$username'";
		$ins_qry .= ", '$regdate'";
		$ins_qry .= ", '$upddate'";
		$ins_qry .= ", '$vodpath'";
		$ins_qry .= ", '$vodfile1'";
		$ins_qry .= ", '$vodfile2'";
		$ins_qry .= ", '$vodfile3'";
		$ins_qry .= ", '$bfilepath'";
		$ins_qry .= ", '$bfile1'";
		$ins_qry .= ", '$bfile2'";
		$ins_qry .= ", '$bfile3'";
		$ins_qry .= ") ";

		$result = mysql_query($ins_qry, $dbconn);
		if(!$result) {
			$error_msg = mysql_error();
		} else {
			$msg = "등록";
		}
	}	# end of if ($gubun == "insert") { ...
	
	if($gubun == "remove") {

		for($i=0;$i<count($idxchk);$i++) {

			$query  = "SELECT user_file, img_file FROM ".$initial."_bbs_".$_t." WHERE idx = '$idxchk[$i]'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			$array  = mysql_fetch_array($result);
			$user_file	= stripslashes($array[user_file]);
			$img_file	= stripslashes($array[img_file]);

			########## 디렉토리에 저장된 이전 파일을 삭제한다. ##########
			if( $user_file != "" ){
				@unlink($foldername.$user_file);
			}
			if( $img_file != "" ){
				@unlink($foldername.$img_file);
			}
			######### 삭제 ##########
			$query 	= "delete from ".$initial."_bbs_".$_t." where idx = '$idxchk[$i]'";
			$result	= mysql_query($query, $dbconn) or die (mysql_error());
			$msg	= "삭제";
		}

	}	# end of if ($gubun == "remove") { ...
		
	if ($gubun == "delete") {   # 삭제
		$query  = "SELECT user_file, img_file FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$array  = mysql_fetch_array($result);
		$user_file	= stripslashes($array[user_file]);
		$img_file	= stripslashes($array[img_file]);

		########## 디렉토리에 저장된 이전 파일을 삭제한다. ##########
		if( $user_file != "" ){
			@unlink($foldername.$user_file);
		}
		if( $img_file != "" ){
			@unlink($foldername.$img_file);
		}
		# 삭제
		$del_qry = " delete from ".$initial."_bbs_".$_t." where idx = '$idx' ";
		$result = mysql_query($del_qry, $dbconn);
		if(!$result) {
			$error_msg = mysql_error();
		} else {
			$msg = "삭제";
		}
	}   # end of if ($gubun == "delete") { ...
?>
<? mysql_close($dbconn); ?>
<form name="form" method="get" action="list.php">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="cate" value="<?=$cate?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
</form>
<script language="javascript">
<!--
	alert("정상적으로 <?=$msg?>되었습니다.");
	document.form.submit();
//-->
</script>

