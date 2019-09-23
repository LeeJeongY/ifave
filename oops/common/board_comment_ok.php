<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	//hidden에 있던 값 전송
	$gubun		= addslashes($gubun);
	$page		= addslashes($page);	
	if ($page == "") { $page = 1; }
	$username	= html2db($username);
	$passwd		= addslashes($passwd);
	$msg_text   = html2db($msg_text);	
	$regdate	= date("Y"."-"."m"."-"."d H:i:s");	


	if ($gubun=="r_insert" || $gubun=="r_reply") {
		# idx값 구하기
		$maxnum_qry = "select max(idx) from ".$initial."_bbs_boardcomment";
		$maxnum_result = mysql_query($maxnum_qry,$dbconn) or die(mysql_error());
		$maxnum_array = mysql_fetch_array($maxnum_result);
		$maxnum = $maxnum_array[0];
		if ($maxnum == "" or $maxnum == NULL) {
			$idx   = 1;
		} else {
			$idx   = $maxnum + 1;
		}	
		
		if($gubun == "r_insert") {

			// ------------  쓰레드 찾기 ---------
			$que		= "select MAX(thread) from ".$initial."_bbs_boardcomment" ;
			$res		= mysql_query($que, $dbconn);
			$row		= mysql_fetch_array($res);
			$thread		= $row[0]+1;

			// ------------  포지션 찾기 ---------
			$que		= "select MIN(pos) from ".$initial."_bbs_boardcomment" ;
			$res		= mysql_query($que, $dbconn);
			$row		= mysql_fetch_array($res);
			$pos		= $row[0]+1;

			mysql_query("update ".$initial."_bbs_boardcomment set pos=pos+1 where pos>0", $dbconn);
		} else {
			mysql_query("update ".$initial."_bbs_boardcomment set pos=pos+1 where pos>=$pos", $dbconn);
		}

		$ins_qry = "insert into ".$initial."_bbs_boardcomment (";
		$ins_qry .= "  idx";
		$ins_qry .= ", fid";
		$ins_qry .= ", tbl";
		$ins_qry .= ", username";
		$ins_qry .= ", userid";
		$ins_qry .= ", passwd";
		$ins_qry .= ", userip";
		$ins_qry .= ", msg_text";
		$ins_qry .= ", regdate";
		$ins_qry .= ", org_idx";
		$ins_qry .= ", thread";
		$ins_qry .= ", depth";
		$ins_qry .= ", pos";
		$ins_qry .= ", thread2";
		$ins_qry .= ", referer_url";
		$ins_qry .= ", device";
		$ins_qry .= ", adminid";
		$ins_qry .= ") values (";
		$ins_qry .= "  '$idx'";
		$ins_qry .= ", '$fid'";
		$ins_qry .= ", '$_t'";
		$ins_qry .= ", '$username'";
		$ins_qry .= ", '$userid'";
		$ins_qry .= ", '$passwd'";
		$ins_qry .= ", '$remoteip'";
		$ins_qry .= ", '$msg_text'";
		$ins_qry .= ", '$regdate'";
		$ins_qry .= ", '$org_idx'";
		$ins_qry .= ", '$thread'";
		$ins_qry .= ", '$depth'";
		$ins_qry .= ", '$pos'";
		$ins_qry .= ", '$thread2'";
		$ins_qry .= ", '$referer_url'";
		$ins_qry .= ", '$device'";
		$ins_qry .= ", '$adminid'";
		$ins_qry .= ")";
		$result = mysql_query($ins_qry,$dbconn); 
		if(!$result) {
			echo "<script>self.window.alert('오류발생 ".mysql_error()."');history.back();</script>";
			exit; 
		} else {
			$msg = "등록";
		}

		$idx = $fid;
	}

	/*

	if ($gubun == "del2") {  # 삭제일때

		if($UID == "") {
			# 오리지날 비밀번호 가져옴
			$chkqry = " select passwd from ".$initial."_bbs_boardcomment where idx = '$idx' ";
			$chkresult = mysql_query($chkqry,$dbconn) or die(mysql_error());
			$chkarray = mysql_fetch_array($chkresult);
			
			$origpasswords = $chkarray[passwd];
			
			if ($origpasswords != $passwd) { // 비밀번호가 틀리면
				echo "<script>self.window.alert('비밀번호가 틀립니다');history.back();</script>";
				exit;
			}
		} else {
			# 오리지날 비밀번호 가져옴
			$chkqry = " select userid from ".$initial."_bbs_boardcomment where idx = '$idx' ";
			$chkresult = mysql_query($chkqry,$dbconn) or die(mysql_error());
			$chkarray = mysql_fetch_array($chkresult);
			
			$origuserid = $chkarray[userid];
			
			if ($origuserid != $UID) { // 비밀번호가 틀리면
				echo "<script>self.window.alert('권한이 없습니다.');history.back();</script>";
				exit;
			}
		}
	}
	*/

	if ($gubun == "r_delete") {
		$del_qry = "DELETE FROM ".$initial."_bbs_boardcomment WHERE idx = '$idx'";
		$result = mysql_query($del_qry,$dbconn); 
		if(!$result) {
			echo "<script>self.window.alert('오류발생 ".mysql_error()."');history.back();</script>";
			exit; 
		} else {
			$msg = "삭제";
		}
	}
	
	//$gotourl = str_replace("|", "&", $gotourl);

?>
<? mysql_close($dbconn); ?>
<form name="form" method="get" action="<?=$gotourl?>">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="idx" value="<?=$idx?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>
<script language="javascript">
<!--
	alert("정상적으로 <?=$msg?>되었습니다.");
	document.form.submit();
//-->
</script>