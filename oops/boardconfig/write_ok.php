<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "master"; 				//테이블명
	$foldername  = "../../$upload_dir/$_t/";


	//hidden에 있던 값 전송
	$gubun	= addslashes($gubun);
	$page   = addslashes($page);
	if($page == "") { $page = 1; }

	$idx		= addslashes($idx);
	$use_flag	= addslashes($use_flag);
	$writer		= addslashes($writer);
	$bbs_name	= html2db($bbs_name);
	$bbs_title	= html2db($bbs_title);
	if($winflag != "Y") $winflag = "";

	//옵션사용
	for($i=0;$i<count($option_list);$i++) {
		if($i==0) $comma = "";
		else $comma = "|";
		$option_list_array .= $comma.$option_list[$i];
	}
	//기능
	for($i=0;$i<count($skill_list);$i++) {
		if($i==0) $comma = "";
		else $comma = "|";
		$skill_list_array .= $comma.$skill_list[$i];
	}
	//발송
	for($i=0;$i<count($target_send);$i++) {
		if($i==0) $comma = "";
		else $comma = "|";
		$target_send_array .= $comma.$target_send[$i];
	}
	//공유
	for($i=0;$i<count($share_media);$i++) {
		if($i==0) $comma = "";
		else $comma = "|";
		$share_media_array .= $comma.$share_media[$i];
	}
	//뷰 숨김
	for($i=0;$i<count($item_close);$i++) {
		if($i==0) $comma = "";
		else $comma = "|";
		$item_close_array .= $comma.$item_close[$i];
	}
	$signdate   = date("Y"."-"."m"."-"."d H:i:s");


	if($gubun == "update" || $gubun == "insert") {

		$img_name1		= $_FILES["user_file"]["name"];			// 파일명
		$img_filesize1	= $_FILES["user_file"]["size"];			// 파일 사이즈
		$img1			= $_FILES["user_file"]["tmp_name"];		// 임시파일저장

		$img_FullFilename1 = upload_file_save($img_name1, $foldername,$thumb_w,$thumb_h, $img1);
	}

	if ($gubun == "update") {  # 수정일때
		$query = " UPDATE ".$initial."_bbs_".$_t." SET ";
		$query .= " use_flag	='$use_flag'";
		$query .= ", bbs_name	='$bbs_name'";
		$query .= ", bbs_type	='$bbs_type'";
		$query .= ", bbs_kind	='$bbs_kind'";
		$query .= ", cate_flag	='$cate_flag'";
		$query .= ", cate_code	='$cate_code'";
		$query .= ", bbs_title	='$bbs_title'";
		if($img_FullFilename1) $upqry .= ", user_file	='$img_FullFilename1'";
		$query .= ", option_list='$option_list_array'";
		$query .= ", use_grade	='$use_grade'";
		$query .= ", skill_list	='$skill_list_array'";
		$query .= ", target_send='$target_send_array'";
		$query .= ", share_media='$share_media_array'";
		$query .= ", item_close	='$item_close_array'";
		$query .= ", img_flag	='$img_flag'";
		$query .= ", file_flag	='$file_flag'";
		$query .= ", list_counts='$list_counts'";
		$query .= " WHERE idx='$idx'";

		$result = mysql_query($query, $dbconn);
		if(!$result) {
			echo "<script>self.window.alert(\"오류발생 ".mysql_error()."\");history.back();</script>";
			exit;
		} else {
			$msg = "수정";
		}   # end of if(!$result) { ...
		// 수정 완료
	}

	if ($gubun == "insert" ) {   # 새로 등록

		# cat, par값 구하기
		$maxnum_qry = "SELECT max(idx) as max_idx FROM ".$initial."_bbs_".$_t."";
		$maxnum_result = mysql_query($maxnum_qry,$dbconn) or die (mysql_error());
		if($maxnum_array=mysql_fetch_array($maxnum_result)) {
			$maxnum		= $maxnum_array[max_idx];
		}
		if ($maxnum == "" or $maxnum == NULL) {
			$idx   = 1;
		} else {
			$idx   = $maxnum + 1;
		}

		$query = "INSERT INTO ".$initial."_bbs_".$_t." SET ";
		$query .= " idx					= '".$idx."'";
		$query .= ", use_flag			= '".$use_flag."'";
		$query .= ", bbs_id				= '".$bbs_id."'";
		$query .= ", bbs_name			= '".$bbs_name."'";
		$query .= ", user_file			= '".$img_FullFilename1."'";
		$query .= ", bbs_type			= '".$bbs_type."'";
		$query .= ", bbs_kind			= '".$bbs_kind."'";
		$query .= ", cate_flag			= '".$cate_flag."'";
		$query .= ", cate_code			= '".$cate_code."'";
		$query .= ", bbs_title			= '".$bbs_title."'";
		$query .= ", use_grade			= '".$use_grade."'";
		$query .= ", skill_list			= '".$skill_list_array."'";
		$query .= ", target_send		= '".$target_send_array."'";
		$query .= ", share_media		= '".$share_media_array."'";
		$query .= ", item_close			= '".$item_close_array."'";
		$query .= ", img_flag			= '".$img_flag."'";
		$query .= ", file_flag			= '".$file_flag."'";
		$query .= ", list_counts		= '".$list_counts."'";
		$query .= ", signdate			= '".$signdate."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());

		$sql = "";
		$table_name = $initial."_bbs_".$bbs_id;
		$sql .= "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".$DATABASE."' AND table_name = '".$table_name."'";
		$rs = mysql_query($sql, $dbconn) or die (mysql_error());
		$row = mysql_fetch_row($rs);
		$chk_no = $row[0];

		//테이블이 없을 경우 테이블 생성, 있을 경우 패스~
		if($chk_no == 0) {

			/*
			$sql = "";
			$sql .= "DROP TABLE IF EXISTS `".$initial."_bbs_".$bbs_id."`;".chr(10);
			$result = mysql_query($sql,$dbconn) or die (mysql_error());
			*/

			$sql = "";
			if($bbs_kind=="board" || $bbs_kind=="data" || $bbs_kind=="gallery") {
				$sql .= "CREATE TABLE IF NOT EXISTS `".$initial."_bbs_".$bbs_id."` (".chr(10);
				$sql .= "`idx` int(11) NOT NULL AUTO_INCREMENT,".chr(10);
				$sql .= "`view_flag` varchar(1) DEFAULT '',".chr(10);
				$sql .= "`category` varchar(30) DEFAULT '',".chr(10);
				$sql .= "`userid` varchar(30) DEFAULT '',".chr(10);
				$sql .= "`username` varchar(30) DEFAULT NULL,".chr(10);
				$sql .= "`email` varchar(50) DEFAULT NULL,".chr(10);
				$sql .= "`homep` varchar(250) DEFAULT NULL,".chr(10);
				$sql .= "`tel` varchar(20) DEFAULT NULL,".chr(10);
				$sql .= "`hp` varchar(20) DEFAULT NULL,".chr(10);
				$sql .= "`murl` varchar(250) DEFAULT NULL,".chr(10);
				/*
				$sql .= "`zipcode` varchar(10) DEFAULT NULL,".chr(10);
				$sql .= "`address1` varchar(100) DEFAULT NULL,".chr(10);
				$sql .= "`address2` varchar(100) DEFAULT NULL,".chr(10);
				$sql .= "`address3` varchar(100) DEFAULT NULL,".chr(10);
				*/
				$sql .= "`title` varchar(200) DEFAULT '',".chr(10);
				$sql .= "`body` text,".chr(10);
				$sql .= "`regdate` datetime DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "`upddate` datetime DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "`counts` int(11) DEFAULT '0',".chr(10);
				$sql .= "`org_idx` int(11) DEFAULT '0',".chr(10);
				$sql .= "`thread` int(11) DEFAULT '0',".chr(10);
				$sql .= "`depth` smallint(6) DEFAULT '0',".chr(10);
				$sql .= "`pos` int(11) DEFAULT '0',".chr(10);
				$sql .= "`passwd` varchar(8) DEFAULT '',".chr(10);
				$sql .= "`user_file` varchar(50) DEFAULT '',".chr(10);
				$sql .= "`img_file` varchar(50) DEFAULT '',".chr(10);
				$sql .= "`user_ip` varchar(20) DEFAULT '',".chr(10);
				$sql .= "`delflag` char(1) DEFAULT '',".chr(10);
				$sql .= "`is_secret` char(1) NOT NULL DEFAULT '0',".chr(10);
				$sql .= "`notice_yn` char(1) NOT NULL DEFAULT '0',".chr(10);
				$sql .= "`site` varchar(20) NOT NULL,".chr(10);
				$sql .= "`counts_comment` int(5) DEFAULT '0',".chr(10);
				$sql .= "`counts_like` int(5) DEFAULT '0',".chr(10);
				$sql .= "`counts_bad` int(5) DEFAULT '0',".chr(10);
				$sql .= "`tag` text,".chr(10);
				$sql .= "`mailflag` varchar(1) DEFAULT '',".chr(10);
				$sql .= "`smsflag` varchar(1) DEFAULT '',".chr(10);
				$sql .= "`adminid` varchar(50) NOT NULL,".chr(10);
				$sql .= "PRIMARY KEY (`idx`)".chr(10);
				$sql .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;".chr(10);
			} else if($bbs_kind=="sns") {
				$sql .= "CREATE TABLE IF NOT EXISTS `".$initial."_bbs_".$bbs_id."` (".chr(10);
				$sql .= "`idx` int(11) NOT NULL AUTO_INCREMENT,".chr(10);
				$sql .= "`view_flag` varchar(1) DEFAULT '',".chr(10);
				$sql .= "`category` varchar(30) DEFAULT '',".chr(10);
				$sql .= "`userid` varchar(20) NOT NULL DEFAULT '',".chr(10);
				$sql .= "`username` varchar(30) DEFAULT '',".chr(10);
				$sql .= "`title` varchar(250) NOT NULL,".chr(10);
				$sql .= "`body` text,".chr(10);
				$sql .= "`regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "`upddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "`user_ip` varchar(20) DEFAULT '',".chr(10);
				$sql .= "`counts` int(11) DEFAULT '0',".chr(10);
				$sql .= "`counts_comment` int(5) DEFAULT '0',".chr(10);
				$sql .= "`counts_like` int(5) DEFAULT '0',".chr(10);
				$sql .= "`counts_bad` int(5) DEFAULT '0',".chr(10);
				$sql .= "`tag` text,".chr(10);
				$sql .= "`adminid` varchar(50) NOT NULL,".chr(10);
				$sql .= "PRIMARY KEY (`idx`)".chr(10);
				$sql .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;".chr(10);
			} else if($bbs_kind=="inquiry") {

				$sql .= "CREATE TABLE IF NOT EXISTS `".$initial."_bbs_".$bbs_id."` (".chr(10);
				$sql .= "`idx` int(11) unsigned NOT NULL AUTO_INCREMENT,".chr(10);
				$sql .= "`title` varchar(250) DEFAULT '',".chr(10);
				$sql .= "`category` varchar(10) NOT NULL DEFAULT '',".chr(10);
				$sql .= "`user_id` varchar(20) NOT NULL DEFAULT '',".chr(10);
				$sql .= "`user_name` varchar(30) DEFAULT '',".chr(10);
				$sql .= "`user_group` varchar(30) DEFAULT '',".chr(10);
				$sql .= "`user_tel` varchar(30) DEFAULT '',".chr(10);
				$sql .= "`user_email` varchar(100) DEFAULT '',".chr(10);
				$sql .= "`question_type` varchar(30) DEFAULT '',".chr(10);
				$sql .= "`contents` text,".chr(10);
				$sql .= "`user_ip` varchar(100) NOT NULL DEFAULT '',".chr(10);
				$sql .= "`user_state` varchar(4) DEFAULT '',".chr(10);
				$sql .= "`ans_text` text,".chr(10);
				$sql .= "`ans_name` varchar(50) DEFAULT '',".chr(10);
				$sql .= "`regdate` datetime DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "`editdate` datetime DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "`ansdate` datetime DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "PRIMARY KEY (`idx`)".chr(10);
				$sql .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;".chr(10);
			} else if($bbs_kind=="popup") {

				$sql .= "CREATE TABLE IF NOT EXISTS `".$initial."_bbs_".$bbs_id."` (".chr(10);
				$sql .= "  `idx` int(11) NOT NULL AUTO_INCREMENT,".chr(10);
				$sql .= "  `view_flag` char(1) NOT NULL DEFAULT '',".chr(10);
				$sql .= "  `title` varchar(250) NOT NULL DEFAULT '',".chr(10);
				$sql .= "  `body` text,".chr(10);
				$sql .= "  `category` varchar(30) DEFAULT '',".chr(10);
				$sql .= "  `popup_flag` varchar(10) NOT NULL,".chr(10);
				$sql .= "  `counts` int(11) NOT NULL DEFAULT '0',".chr(10);
				$sql .= "  `user_file` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  `img_file` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  `nflag` char(1) DEFAULT '',".chr(10);
				$sql .= "  `list_add` char(1) DEFAULT 'N',".chr(10);
				$sql .= "  `scrollbar` varchar(10) DEFAULT '',".chr(10);
				$sql .= "  `ptop` int(4) DEFAULT '0',".chr(10);
				$sql .= "  `pleft` int(4) DEFAULT '0',".chr(10);
				$sql .= "  `width` int(4) DEFAULT '0',".chr(10);
				$sql .= "  `height` int(4) DEFAULT '0',".chr(10);
				$sql .= "  `winopen` char(1) DEFAULT 'N',".chr(10);
				$sql .= "  `startdate` varchar(10) DEFAULT '',".chr(10);
				$sql .= "  `enddate` varchar(10) DEFAULT '',".chr(10);
				$sql .= "  `pageurl` varchar(250) DEFAULT '',".chr(10);
				$sql .= "  `mapflag` char(1) DEFAULT 'N',".chr(10);
				$sql .= "  `image_map` text,".chr(10);
				$sql .= "  `tag` text NOT NULL,".chr(10);
				$sql .= "  `userid` varchar(30) DEFAULT '',".chr(10);
				$sql .= "  `username` varchar(30) DEFAULT '',".chr(10);
				$sql .= "  `regdate` datetime DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "  `upddate` datetime DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "  `vodpath` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  `vodfile1` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  `vodfile2` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  `vodfile3` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  `bfilepath` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  `bfile1` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  `bfile2` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  `bfile3` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  PRIMARY KEY (`idx`)".chr(10);
				$sql .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;".chr(10);
			} else if($bbs_kind=="banner") {

				$sql .= "CREATE TABLE IF NOT EXISTS `".$initial."_bbs_".$bbs_id."` (".chr(10);
				$sql .= "  `idx` int(11) NOT NULL AUTO_INCREMENT,".chr(10);
				$sql .= "  `view_flag` char(1) NOT NULL DEFAULT '',".chr(10);
				$sql .= "  `title` varchar(250) NOT NULL DEFAULT '',".chr(10);
				$sql .= "  `body` text,".chr(10);
				$sql .= "  `category` varchar(30) DEFAULT '',".chr(10);
				$sql .= "  `counts` int(11) NOT NULL DEFAULT '0',".chr(10);
				$sql .= "  `img_file` varchar(50) DEFAULT '',".chr(10);
				$sql .= "  `width` int(4) DEFAULT '0',".chr(10);
				$sql .= "  `height` int(4) DEFAULT '0',".chr(10);
				$sql .= "  `winopen` char(1) DEFAULT 'N',".chr(10);
				$sql .= "  `startdate` varchar(10) DEFAULT '',".chr(10);
				$sql .= "  `enddate` varchar(10) DEFAULT '',".chr(10);
				$sql .= "  `pageurl` varchar(250) DEFAULT '',".chr(10);
				$sql .= "  `userid` varchar(30) NOT NULL DEFAULT '',".chr(10);
				$sql .= "  `username` varchar(30) NOT NULL DEFAULT '',".chr(10);
				$sql .= "  `regdate` datetime DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "  `upddate` datetime DEFAULT '0000-00-00 00:00:00',".chr(10);
				$sql .= "  PRIMARY KEY (`idx`)".chr(10);
				$sql .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;".chr(10);

			}

			$result = mysql_query($sql, $dbconn) or die (mysql_error());
			if($result==true) {
				$msg_tbl = "DB ".$initial."_bbs_".$bbs_id." 테이블도 생성하였습니다.";
			}

		}

		if(!$result) {
			echo "<script>self.window.alert(\"오류발생 ".mysql_error()."\");history.back();</script>";
			exit;
		} else {
			$msg = "등록";
		}
		//멀티 게시판은 board 생성
		$board_foldername  = "../../$upload_dir/$bbs_kind/";
		if(!is_dir($board_foldername)){
			mkdir($board_foldername, 0777);
			chmod($board_foldername, 0777);
		}

	}   # end of if ($gubun == "update") { ...


	if ($gubun == "delete") {   # 삭제
		$file_qry = " SELECT user_file, bbs_id FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx' ";
		$file_result = mysql_query($file_qry, $dbconn) or die(mysql_error());
		if($file_array = mysql_fetch_array($file_result)) {
			$user_file	= stripslashes($file_array[user_file]);
			$bbs_id		= stripslashes($file_array[bbs_id]);
			if($user_file != "") {
				@unlink($foldername.$user_file);
			}
		}

		# 삭제
		$del_qry = " DELETE FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx' ";
		$result = mysql_query($del_qry, $dbconn);

		$sql = "";
		$sql .= "DROP TABLE IF EXISTS `".$initial."_bbs_".$bbs_id."`;".chr(10);
		$result = mysql_query($sql,$dbconn) or die (mysql_error());
		if($result == true) {
			$msg_tbl = "".$initial."_bbs_".$bbs_id." 테이블도 삭제되었습니다.";
		}

		if(!$result) {
			echo "<script>self.window.alert(\"오류발생 ".mysql_error()."\");history.back();</script>";
			exit;
		} else {
			$msg = "삭제";
		}
	}   # end of if ($gubun == "delete") { ...

	if($gubun == "remove") {

		for($i=0;$i<count($idxchk);$i++) {

			$query  =  "SELECT bbs_id, user_file FROM ".$initial."_bbs_".$_t." WHERE idx = '$idxchk[$i]'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			$array  = mysql_fetch_array($result);
			$bbs_id		= db2html($array[bbs_id]);
			$user_file	= stripslashes($array[user_file]);

			$savedir = "../../$upload_dir/$_t";
			########## 디렉토리에 저장된 이전 파일을 삭제한다. ##########
			if( $user_file != "" ){
				@unlink("$savedir/$user_file");
			}
			######### 삭제 ##########
			$query 	= "DELETE FROM ".$initial."_bbs_".$_t." WHERE idx = '$idxchk[$i]'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());


			$sql = "";
			$sql .= "DROP TABLE IF EXISTS `".$initial."_bbs_".$bbs_id."`;".chr(10);
			$result = mysql_query($sql,$dbconn) or die (mysql_error());
			if($result == true) {
				$msg_tbl = "".$initial."_bbs_".$bbs_id." 테이블도 삭제되었습니다.";
			}
			$msg = "삭제";
		}

	}

	if($gubun == "idcheck") {
		//중복 검색
		$query = "SELECT count(idx) as cnt FROM ".$initial."_bbs_".$_t."";
		$query .= " WHERE bbs_id='$bbs_id'";
		$query .= " AND (bbs_id!='boardcomment'";
		$query .= " OR bbs_id!='popup'";
		$query .= " OR bbs_id!='boardcounts'";
		$query .= " OR bbs_id!='boardtag'";
		$query .= " OR bbs_id!='master')";
		$result=mysql_query($query, $dbconn) or die (mysql_error());
		if($array=mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}

		//아이디 생성 안됨...
		if($bbs_id=="boardcomment" || $bbs_id=="boardcounts" || $bbs_id=="boardtag" || $bbs_id=="master") {
			$count_chk = 1;
		}

		if($count_chk > 0) {
			echo "no";
		} else {
			echo "ok";
		}
		mysql_close($dbconn);
		exit;
	}
?>
<? mysql_close($dbconn); ?>
<form name="form" method="get" action="list.php">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
</form>
<script language="javascript">
<!--
	alert("정상적으로 <?=$msg?>되었습니다. <?=$msg_tbl?>");
	document.form.submit();
//-->
</script>
