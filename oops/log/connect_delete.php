<?
//------------------------------------------------------------------------------
//        SYSTEM NAME		:        UCCC Admin
//        SUBSYSTEM NAME	:
//        PROGRAM ID			:        connect_delete.php
//        PROGRAM TYPE		:        php script
//        PROGRAM NAME		:        접속 로그 관리 
//        PROGRAM 설명		:        접속 로그  삭제
//        작성일,작성자		:        2008-03-20, 박홍근
//        수정일,수정자		:        
//        소유자					:        
//        사용TABLE			:        referer
//------------------------------------------------------------------------------     
	include "../../module/dbcon.utf8.php";  
	include "../../module/register_globals.php";
	include "../../module/function.utf8.php";
	header("Content-type:text/html;charset=utf-8");
	
	$check_no = count($checknum); 

	if($tbl == "") $tbl	= "referer"; 				//테이블 이름
	for($i=0;$i<$check_no;$i++) { 

		######### 삭제 ##########
		$query = "DELETE FROM ".$initial."_".$tbl." WHERE uid = '$checknum[$i]'";
		$result = mysql_query($query,$dbconn);
	}
//	echo "<meta http-equiv='Refresh' content='0; URL=./connect.php'>";
	mysql_close($dbconn);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("성공적으로 삭제되었습니다.");
	document.location = "connect.php?menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>&menu_t=<?=$menu_t?>";
//-->
</SCRIPT>
