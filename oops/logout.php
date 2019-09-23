<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../modules/dbcon.php";
	include "../modules/config.php";
	include "../modules/func.php";
	//사용자 접속해제 로그...
	unset($_SESSION['SUPER_UID']);
	unset($_SESSION['SUPER_UNAME']);
	unset($_SESSION['SUPER_UEMAIL']);
	unset($_SESSION['SUPER_ULEVEL']);
	unset($_SESSION['SUPER_UMENU']);
	unset($_SESSION['SUPER_UIMG']);

	$_SESSION["SUPER_UID"] = null;
	$_SESSION["SUPER_UNAME"] = null;
	$_SESSION["SUPER_UEMAIL"] = null;
	$_SESSION["SUPER_ULEVEL"] = null;
	$_SESSION["SUPER_UMENU"] = null;
	$_SESSION["SUPER_UIMG"] = null;
	session_destroy();

?>
<? mysql_close($dbconn); ?>
<script language=JavaScript>
<!--
	document.location.href="<?=$root_url?>";
//-->
</script>
