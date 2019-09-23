<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl	= "product"; 				//테이블 이름
	$foldername  = "../../$upload_dir/$tbl/";

	//==== request값 ================================

	$idx		= stripslashes($idx);
	$pname		= html2db($pname);
	$title		= html2db($title);
	$intro		= html2db($intro);
	$signdate	= date("Y"."-"."m"."-"."d H:i:s");
	if($_POST["content"])	$content = $_POST["content"];
	$content	= html2db($content);

	if($gubun == "update" or $gubun == "insert") {

		//if($thumb_w == "") $thumb_w = "198";
		//if($thumb_h == "") $thumb_h = "215";

		$img_name1		= $_FILES["img_file"]["name"]; // 파일명
		$img_filesize1	= $_FILES["img_file"]["size"]; // 파일 사이즈
		$img1			= $_FILES["img_file"]["tmp_name"]; //임시파일저장

		$img_FullFilename1 = upload_file_save($img_name1, $foldername,$thumb_w,$thumb_h, $img1);

	}


	//신규등록인 경우 ============================
	if ($gubun == "insert") {

		//중복체크
		if($pname!="") {
			$query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
			$query .= " WHERE pname='".$pname."'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			if($array = mysql_fetch_array($result)) {
				$count_chk = $array[cnt];
			}
			if($count_chk > 0) {
				popup_msg("중복된 품목명이 존재합니다.");
			}
		}

		// max 구하기
		$query="SELECT max(idx) as max_idx FROM ".$initial."_".$tbl."";
		$result=mysql_query($query, $dbconn);
		if($array = mysql_fetch_array($result)) {
			$max_idx = $array[max_idx];
		}
		if($max_idx < 0) {
			$max_idx = 1;
		} else {
			$max_idx = $max_idx+1;
		}

		if($pcode=="") $pcode =  sprintf('%02d', $cate1).sprintf('%02d', $cate2).sprintf('%06d', $max_idx);

		$query = "INSERT INTO ".$initial."_".$tbl." SET ";
		$query .= "  idx       = '".$max_idx."'";
		$query .= ", cate1     = '".$cate1."'";
		$query .= ", cate2     = '".$cate2."'";
		$query .= ", pcode     = '".$pcode."'";
		$query .= ", pname     = '".$pname."'";
		$query .= ", option_color     = '".$option_color."'";
		$query .= ", img_file  = '".$img_FullFilename1 ."'";
		$query .= ", price     = '".$price."'";
		$query .= ", quantity  = '".$quantity."'";
		$query .= ", title     = '".$title."'";
		$query .= ", intro     = '".$intro."'";
		$query .= ", content   = '".$content."'";
		$query .= ", main_flag = '".$main_flag."'";
		$query .= ", use_flag  = '".$use_flag."'";
		$query .= ", regdate   = '".$signdate."'";
		$query .= ", user_wid  = '".$_SESSION['SUPER_UID']."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());

		$msg = "등록";
	}



	//기존데이터 수정인경우 ======================
	if ($gubun  == "update") {

		//$pcode =  sprintf('%02d', $cate1).sprintf('%02d', $cate2).sprintf('%06d', $idx);

		//파일삭제시
		if($img_file_chk == "Y") {
			$file_qry = " select img_file from ".$initial."_".$tbl." where idx = '".$idx."'";
			$file_result = mysql_query($dbconn, $file_qry) or die(mysql_error());
			if($file_array = mysql_fetch_array($file_result)) {
				$img_file   = stripslashes($array[img_file]);

				if( $img_file != "" ){
					@unlink($foldername.$img_file);
				}
			}
			$upqry = " UPDATE ".$initial."_".$tbl." SET";
			$upqry .= " upddate			='$signdate'";
			if($img_file_chk == "Y")	$upqry .= ",  img_file =''";
			$upqry .= " WHERE idx='".$idx."'";
			mysql_query($upqry, $dbconn);
		}

		//$stock_qty = 0;

		$query = "UPDATE ".$initial."_".$tbl." SET ";
		$query .= "  pcode		='".$pcode."'";
		$query .= ", cate1		='".$cate1."'";
		$query .= ", cate2		='".$cate2."'";
		$query .= ", pname		='".$pname."'";
		$query .= ", option_color	='".$option_color."'";
		$query .= ", title		='".$title."'";
		$query .= ", intro		='".$intro."'";
		$query .= ", price		='".$price."'";
		if($img_FullFilename1) $query .= ", img_file ='".$img_FullFilename1."'";
		$query .= ", use_flag	='".$use_flag."'";
		$query .= ", content	='".$content."'";
		$query .= ", upddate	='".$signdate."'";
		$query .= ", user_eid	='".$_SESSION['SUPER_UID']."'";
		$query .= " WHERE idx = '".$idx."'";
		$result=mysql_query($query, $dbconn) or die (mysql_error());

		$msg = "수정";
	}


	//기존데이터 삭제 ============================
	if ($gubun == "delete") {

		$file_qry = " SELECT img_file FROM ".$initial."_".$tbl." WHERE idx = '".$idx."' ";
		$file_result = mysql_query($file_qry, $dbconn) or die(mysql_error());
		if($file_array = mysql_fetch_array($file_result)) {
			$img_file   = stripslashes($array[img_file]);
			if( $img_file != "" ){
				@unlink($foldername.$img_file);
			}
		}
		$query 	= "DELETE FROM ".$initial."_".$tbl." WHERE idx = '".$idx."'";
		$result=mysql_query($query, $dbconn) or die (mysql_error());
		$msg = "삭제";

	}

	if($gubun == "remove") {
		for($i=0;$i<count($idxchk);$i++) {
			$query  =  "SELECT img_file FROM ".$initial."_".$tbl." WHERE idx = '".$idxchk[$i]."'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			$array  = mysql_fetch_array($result);
			$img_file	= stripslashes($array[img_file]);
			########## 디렉토리에 저장된 이전 파일을 삭제한다. ##########
			if( $img_file != "" ){
				@unlink($foldername.$img_file);
			}
			######### 삭제 ##########
			$query 	= "DELETE FROM ".$initial."_".$tbl." WHERE idx = '".$idxchk[$i]."'";
			$result = mysql_query($query, $dbconn) or die (sqlsrv_error());
		}
		$msg = "삭제";
	}

	if($gubun == "pnamecheck") {
		//중복 검색
		$query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
		$query .= " WHERE pname='".$pname."'";
		$result=mysql_query($query, $dbconn) or die (mysql_error());
		if($array=mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}

		if($count_chk > 0) {
			echo "no";
		} else {
			echo "ok";
		}
		mysql_close($dbconn);
		exit;
	}

	mysql_close($dbconn);
?>
<form name="form" method="get" action="list.php">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("성공적으로 <?=$msg?>되었습니다.");
	<?if($popup=="1") {?>
	window.opener.document.location.href = window.opener.document.URL;
	self.close();
	<?} else {?>
	document.form.submit();
	<?}?>
//-->
</SCRIPT>
