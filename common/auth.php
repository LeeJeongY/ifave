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




	foreach ($_POST as $tmpKey => $tmpValue) {

		// echo $tmpKey."//".$tmpValue."<br>";
		$$tmpKey = $tmpValue;
	}// end foreach

	$UGUBUN			= inject2db($login_flag);
	$user_id		= inject2db($user_id);
	$user_pwd		= inject2db($user_pwd);
	$return_url		= inject2db($return_url);
	$login_flag		= inject2db($login_flag);


	$tbl	= "members"; 				//테이블 이름
	$foldername = "../$upload_dir/$tbl/";

	//==== request값 ================================

	$user_id	= stripslashes($user_id);			// 아이디
	$signdate	= date("Y"."-"."m"."-"."d H:i:s");

	/*
	* 동시접속자를 위한 변수 설정
	*/
	$session_id_chk = $cookie_id_chk	= md5(uniqid(rand()));
	//$session_id_chk = $cookie_id_chk	= session_id();

	/*
	* 중복체크를 위한 세션, 쿠키 변수 재설정
	*/
	$USESSION	= $session_id_chk;
	$UCOOKIE	= $cookie_id_chk;

	//$log_time			= time();
	//$USESSION_TIME	= $log_time;
	//include "../common/session_key.php";


	//아이디 체크
	if($user_id!="") {
		$query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
		$query .= " WHERE user_id='".$user_id."'";
		$query .= " AND user_state='1'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}

		if($count_chk > 0) {


			//비밀번호 암호화 변경되었는지 체크
			$chk_query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
			$chk_query .= " WHERE user_id='".$user_id."'";
			$chk_query .= " AND user_state='1'";
			$chk_query .= " AND passwd_flag='1'";
			$chk_result = mysql_query($chk_query, $dbconn) or die (mysql_error());
			if($chk_array = mysql_fetch_array($chk_result)) {
				$passwd_chk = $chk_array[cnt];
			}


			$sql = "SELECT * from ".$initial."_".$tbl."";
			$sql .= " WHERE user_id = '".$user_id."'";

			//비밀번호 암호화 조건에 맞게 적용
			if($passwd_chk == 0)	$sql .= " AND  user_pwd = password('$user_pwd')";
			else					$sql .= " AND  user_pwd = SHA1(MD5('$user_pwd'))";

			$sql .= " AND  user_state = '1'";
			$rs		= mysql_query($sql,$dbconn) or die (mysql_error());
			$rows	= mysql_num_rows($rs);
			if($rows == 0) {
				popup_msg("Id and Password do not match.");
			 } else	{
				if($arr 	= mysql_fetch_array($rs)) {
					$UID	= $arr[user_id];
					$UNAME	= $arr[user_name];
					$UEMAIL	= $arr[user_email];
					$UCODE	= $arr[user_code];
					$UHP	= $arr[user_hp];
					$UCCODE	= $arr[client_code];
					$UCNAME	= $arr[client_name];

					//현재 디비세션
					$db_session_id	= $arr[session_id_chk];
					$db_session_ip	= $arr[session_ip_chk];


					$passwd_flag	= $arr[passwd_flag];

					//비밀번호 암호화 변경
					if($passwd_flag=="0") {
						/*
						* 변경안함..
						*/
						/*
						$passwdQuery = "update ".$initial."_".$tbl." set ";
						$passwdQuery .= " user_pwd=SHA1(MD5('$user_pwd'))";
						$passwdQuery .= ", passwd_flag='1'";
						$passwdQuery .= " where user_id='".$user_id."'";
						mysql_query($passwdQuery, $dbconn) or die (mysql_error());
						*/
					}



					//동시 접속 체크
					//include "login_check_ok.php";



					// 세션변수를 등록
					$_SESSION['UGUBUN']		= $UGUBUN;
					$_SESSION['UID']		= $UID;
					$_SESSION['UNAME']		= $UNAME;
					$_SESSION['UEMAIL']		= $UEMAIL;
					$_SESSION['UCODE']		= $UCODE;
					$_SESSION['UHP']		= $UHP;
					$_SESSION['UCCODE']		= $UCCODE;
					$_SESSION['UCNAME']		= $UCNAME;
					$_SESSION['USESSION']	= $USESSION;


					setcookie('UCOOKIE_CHK', $UCOOKIE, time()+(60*60*24), "/");
					setcookie('UCOOKIE_IP', $remoteip, time()+(60*60*24), "/");

					/*
					* 최근 로그인 정보 로그기록
					*/
					$gubun_log = "login";
					include "../common/auth.log.php";

					$_SESSION['LOGIN_IDX']		= $max_log_idx;


					/*
					* 로그인 정보 업데이트
					*/
					$strSql = "UPDATE ".$initial."_".$tbl." SET ";
					$strSql .= " session_id_chk		='".$session_id_chk."'";
					$strSql .= ", session_ip_chk	='".$remoteip."'";
					$strSql .= ", last_login		='".$signdate."'";
					$strSql .= ", counts			= counts+1 ";
					$strSql .= " WHERE user_id		='".$user_id."'";
					mysql_query($strSql, $dbconn) or die (mysql_error());

				}
			 }
		} else {
			popup_msg("Id and Password do not match.");
		}
	}// end if

	// 페이지 이동
	if($returnurl=="") $returnurl = $home_url;

	mysql_close($dbconn);
?>
<script language="javascript">
<!--
	location.href="<?=$returnurl?>";
//-->
</script>
