<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../modules/dbcon.php";
	include "../modules/config.php";
	include "../modules/func.php";

	$tbl = "members";
	
	
	//로그아웃 로그 기록
	$gubun_log = "logout";	
	include "auth.log.php";


	$strSql = "UPDATE ".$initial."_".$tbl." SET ";
	$strSql .= " session_id_chk=''";
	$strSql .= ", session_ip_chk=''";
	$strSql .= " WHERE user_id='".$_SESSION['UID']."'";
	mysql_query($strSql, $dbconn) or die (mysql_error());

	//사용자 접속해제 로그...
	unset($_SESSION['UGUBUN']);
	unset($_SESSION['UID']);
	unset($_SESSION['UNAME']);
	unset($_SESSION['UEMAIL']);
	unset($_SESSION['UCODE']);
	unset($_SESSION['UHP']);
	unset($_SESSION['UCCODE']);
	unset($_SESSION['LOGIN_IDX']);
	unset($_SESSION['USESSION']);

	$_SESSION["UGUBUN"]	= null;
	$_SESSION["UID"]	= null;
	$_SESSION["UNAME"]	= null;
	$_SESSION["UEMAIL"] = null;
	$_SESSION["UCODE"]	= null;
	$_SESSION["UHP"]	= null;
	$_SESSION["UCCODE"] = null;
	$_SESSION['UCNAME'] = null;
	$_SESSION['LOGIN_IDX']	= null;
	$_SESSION['USESSION']	= null;

	//기업
	unset($_SESSION['CID']);
	unset($_SESSION['CNAME']);
	unset($_SESSION['CEMAIL']);
	unset($_SESSION['CCODE']);
	unset($_SESSION['CHP']);

	$_SESSION['UGUBUN']		= null;
	$_SESSION['CID']		= null;
	$_SESSION['CNAME']		= null;
	$_SESSION['CEMAIL']		= null;
	$_SESSION['CCODE']		= null;
	$_SESSION['CHP']		= null;

	session_destroy();

?>
<? mysql_close($dbconn); ?>
<script language=JavaScript>
<!--
	location.href="/";
//-->
</script>
