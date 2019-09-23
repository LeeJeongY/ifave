<?
ini_set('register_globals','1'); 
ini_set('session.bug_compat_42','1'); 
ini_set('session.bug_compat_warn','0'); 
ini_set('session.auto_start','1');

session_start();

header("Content-type:text/html;charset=utf-8");
include "../modules/dbcon.php";
include "../modules/config.php";
include "../modules/func.php";
include "../modules/func_q.php";
//include "../modules/check.php";
// echo "123";exit;
$userid		= strtolower($userid);
$userid		= inject2db($userid);
$passwd		= inject2db($passwd);
$return_url	= inject2db($return_url);
$md			= inject2db($md);
$curr_date	= date("Y"."-"."m"."-"."d H:i:s");	

//관리자 체크
$query 	= "select * from ".$initial."_staff ";
$query .= " where userid = '$userid'";
$query .= " and  userpwd = password('$passwd')";
$query .= " and  active = '1'";
$result = mysql_query($query,$dbconn) or die (mysql_error());
$row	= mysql_num_rows($result);
if($row == 0) {
	popup_msg("Id와 Password가 일치 하지 않습니다.");
 } else	{
	$array 	= mysql_fetch_array($result);												//위 결과 값을 하나하나 배열로 저장합니다.

	$SUPER_UID		= $array[userid];
	$SUPER_UNAME	= $array[username];
	$SUPER_UEMAIL	= $array[email];
	$SUPER_ULEVEL	= $array[grade];
	$SUPER_UMENU	= $array[menunum];
	$SUPER_UIMG		= $array[user_file];

	//사용 구분자

	if($SUPER_ULEVEL == "1") {
		$_USER_CLASS = "01";	//슈퍼관리자
	} else if($SUPER_ULEVEL == "2") {
		$_USER_CLASS = "02";	//총관리자
	} else if($SUPER_ULEVEL == "3") {
		$_USER_CLASS = "03";	//부관리자
	} else if($SUPER_ULEVEL == "4") {
		$_USER_CLASS = "04";	//직원
	}
	// 세션변수를 등록
	$_SESSION['_USER_CLASS']	= $_USER_CLASS;
	$_SESSION['SUPER_UID']		= $SUPER_UID;
	$_SESSION['SUPER_UNAME']	= $SUPER_UNAME;
	$_SESSION['SUPER_UEMAIL']	= $SUPER_UEMAIL;
	$_SESSION['SUPER_UHP']		= $SUPER_UHP;
	$_SESSION['SUPER_ULEVEL']	= $SUPER_ULEVEL;
	$_SESSION['SUPER_UMENU']	= $SUPER_UMENU;
	$_SESSION['SUPER_UIMG']		= $SUPER_UIMG;

	$return_page = $root_url;
?>
	<script language=JavaScript>
	<!--
		document.location="<?=$return_page?>";
	//-->
	</script>
<?}?> 
<?mysql_close($dbconn);?>
