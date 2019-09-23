<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";


	foreach ($_POST as $tmpKey => $tmpValue) {
		//echo $tmpKey."//".$tmpValue."<br>";
		$$tmpKey = $tmpValue;
	}// end foreach

	// mysql_close($dbconn);
	//exit;

	$tbl	= "members"; 				//테이블 이름
	$foldername = "../../$upload_dir/$tbl/";

	//==== request값 ================================

	$idx			= stripslashes($idx);
	$cgubun			= stripslashes($cgubun);			// 구분
	$user_code		= stripslashes($user_code);			// 회원코드
	$user_id		= stripslashes($user_id);			// 아이디
	$user_name		= html2db($user_name);				// 이름
	$user_email		= stripslashes($user_email);		// 이메일
	$user_hp		= stripslashes($user_hp);			// 휴대폰
	$user_calendar	= stripslashes($user_calendar);		// 음력/양력
	$email_flag		= stripslashes($email_flag);		// 이메일 수신여부
	$sms_flag		= stripslashes($sms_flag);			// sms 수신여부
	$user_sex		= stripslashes($user_sex);			// 성별
	$zipcode		= stripslashes($zipcode);			// 우편번호
	$addr1			= html2db($addr1);					// 새주소
	$addr2			= html2db($addr2);					// 지번주소
	$addr3			= html2db($addr3);					// 상세주소

	$grownup		= stripslashes($grownup);
	$parent_name	= stripslashes($parent_name);
	$parent_tel		= stripslashes($parent_tel);
	$agree1			= stripslashes($check_agree1);
	$agree2			= stripslashes($check_agree2);
	$agree3			= stripslashes($check_agree3);
	$agree4			= stripslashes($check_agree4);

	$position		= stripslashes($position);			// 직위
	$department		= stripslashes($department);		// 부서
	$duty			= stripslashes($duty);				// 직무분야

	$client_code	= stripslashes($client_code);		// 소속기관코드(회사)
	$client_tel		= stripslashes($client_tel);		// 회사 연락처
	$client_zipcode = stripslashes($client_zipcode); // 회사 우편번호
	$client_addr1	= html2db($client_addr1);			// 새주소
	$client_addr2	= html2db($client_addr2);			// 지번주소
	$client_addr3	= html2db($client_addr3);			// 상세주소

	$edu_charge_department	= stripslashes($edu_charge_department); // 교육담당자 부서
	$edu_charge_tel			= stripslashes($edu_charge_tel);		// 담당자 연락처

	if($client_tel == "--") $client_tel = "";
	if($hp == "--") $hp = "";
	if($edu_charge_tel == "--") $edu_charge_tel = "";

	//국문, 영문 구분(사용자페이지에서는 hidden)
	$site_kind = "ko";
	/*
	for($i=0;$i < count($site_kind);$i++) {
		if($i == 0) $comma = "";
		else $comma = ",";
		$site_kind_arr .= $comma.$site_kind[$i];
	}
	*/

	$signdate	= date("Y"."-"."m"."-"."d H:i:s");

	if($gubun=="") $gubun = "insert";

	//신규등록인 경우 ============================
	if ($gubun == "insert") {
		if($user_id=="" || $user_name=="") {
			popup_msg("필수 요청값이 존재하지 않습니다.");
		}

		//아이디 중복체크
		if($user_id!="") {
			$query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
			$query .= " WHERE user_id='".$user_id."'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			if($array = mysql_fetch_array($result)) {
				$count_chk = $array[cnt];
			}

			if($count_chk > 0) {
				popup_msg("중복된 아이디가 존재합니다.");
			}
		}// end if

		//코드 중복체크
		/*
		if($user_code!="") {
			$query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
			$query .= " WHERE user_code='".$user_code."'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			if($array = mysql_fetch_array($result)) {
				$count_chk = $array[cnt];
			}
			if($count_chk > 0) {
				//popup_msg("중복된 코드가 존재합니다.");
			}
		}// end if
		*/

		$query = "SELECT max(idx) as maxVal FROM ".$initial."_".$tbl."";
		$result = mysql_query($query, $dbconn);
		if($array = mysql_fetch_array($result)) {
			$max_val = $array[maxVal];
			if($max_val < 0) $max_num = 1;
			else $max_num = $max_val + 1;
		}
		$user_code = sprintf('%06d', $max_num);
		//가입 승인
		$user_state = "1";

		$query = "INSERT INTO ".$initial."_".$tbl." SET ";
		$query .= "  idx						= '".$max_num."'";
		$query .= "  , user_code				= '".$user_code."'";
		$query .= "  , user_id					= '".$user_id."'";
		$query .= "  , user_email				= '".$user_email."'";
		$query .= "  , user_pwd					= password('$user_pwd')";
		//$query .= " , user_pwd					= SHA1(MD5('$user_pwd'))";
		$query .= "  , user_name				= '".$user_name."'";
		$query .= "  , user_hp					= '".$user_hp."'";
		$query .= "  , user_birth				= '".$user_birth."'";
		$query .= "  , user_calendar			= '".$user_calendar."'";
		$query .= "  , user_sex					= '".$user_sex."'";
		$query .= "  , zipcode					= '".$zipcode."'";
		$query .= "  , addr1					= '".$addr1."'";
		$query .= "  , addr2					= '".$addr2."'";
		$query .= "  , addr3					= '".$addr3."'";
		$query .= "  , grownup					= '".$grownup."'";
		$query .= "  , parent_name				= '".$parent_name."'";
		$query .= "  , parent_tel				= '".$parent_tel."'";
		$query .= "  , agree1					= '".$agree1."'";
		$query .= "  , agree2					= '".$agree2."'";
		$query .= "  , agree3					= '".$agree3."'";
		$query .= "  , agree4					= '".$agree4."'";
		$query .= "  , site_kind				= '".$site_kind."'";
		$query .= "  , client_code				= '".$client_code."'";
		$query .= "  , client_name				= '".$client_name."'";
		$query .= "  , position					= '".$position."'";
		$query .= "  , department				= '".$department."'";
		$query .= "  , duty						= '".$duty."'";
		$query .= "  , client_tel				= '".$client_tel."'";
		$query .= "  , client_zipcode			= '".$client_zipcode."'";
		$query .= "  , client_addr1				= '".$client_addr1."'";
		$query .= "  , client_addr2				= '".$client_addr2."'";
		$query .= "  , client_addr3				= '".$client_addr3."'";
		$query .= "  , edu_charge_department	= '".$edu_charge_department."'";
		$query .= "  , edu_charge_tel			= '".$edu_charge_tel."'";
		$query .= "  , regdate					= '".$signdate."'";
		$query .= "  , user_state				= '".$user_state."'";
		$query .= "  , join_path				= '".$join_path."'";
		$query .= "  , email_flag				= '".$email_flag."'";
		$query .= "  , sms_flag					= '".$sms_flag."'";
		$query .= "  , user_remote_ip			= '".$_SERVER["REMOTE_ADDR"]."'";
		$query .= "  , passwd_flag				= '0'";		//1일 경우 비밀번호 SHA1(MD5('형식으로 변경')), 0이면 기존 db password 함수 사용

		$result=mysql_query($query, $dbconn) or die (mysql_error());

		$msg = "등록";

/*
		// 세션변수를 등록
		$_SESSION['UGUBUN']		= $UGUBUN;
		$_SESSION['UID']		= $user_id;
		$_SESSION['UNAME']		= $user_name;
		$_SESSION['UEMAIL']		= $user_email;
		$_SESSION['UCODE']		= $UCODE;
		$_SESSION['UHP']		= $user_hp;
		$_SESSION['UCCODE']		= $client_code;
		$_SESSION['UCNAME']		= $client_name;
*/
		//메인페이지로...
		$goto_page = "join_complete.php";

	}



	//기존데이터 수정인경우 ======================
	if ($gubun  == "update") {


		//비밀번호 암호화 변경되었는지 체크
		$chk_query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
		$chk_query .= " WHERE user_id='".$UID."'";
		$chk_query .= " AND user_state='1'";
		//$chk_query .= " AND passwd_flag='1'";
		$chk_result = mysql_query($chk_query, $dbconn) or die (mysql_error());
		if($chk_array = mysql_fetch_array($chk_result)) {
			$passwd_chk = $chk_array[cnt];
		}

		//비밀번호 확인
		$query = "SELECT count(user_id) as cnt FROM ".$initial."_".$tbl." WHERE user_id='".$UID."'";
		if($passwd_chk==0)	$query .= " AND user_pwd=password('".$user_pwd."')";
		else				$query .= " AND user_pwd=SHA1(MD5('".$user_pwd."'))";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}

		if($count_chk == 0) {
			popup_msg("암호가 일치하지 않습니다.\\n다시 확인하세요.");
		}


		//$clientnum = $cgubun . sprintf('%06d', $idx);

		$query = "UPDATE ".$initial."_".$tbl." SET ";
		$query .= "  user_email			= '$user_email'";
		$query .= "  , user_name		= '$user_name'";
		$query .= "  , user_hp			= '$user_hp'";
		$query .= "  , user_birth		= '$user_birth'";
		$query .= "  , user_calendar	= '$user_calendar'";
		$query .= "  , user_sex			= '$user_sex'";
		$query .= "  , zipcode			= '$zipcode'";
		$query .= "  , addr1			= '$addr1'";
		$query .= "  , addr2			= '$addr2'";
		$query .= "  , addr3			= '$addr3'";
		$query .= "  , grownup			= '$grownup'";
		$query .= "  , parent_name		= '$parent_name'";
		$query .= "  , parent_tel		= '$parent_tel'";
/*
		$query .= "  , site_kind		= '$site_kind_arr'";
		$query .= "  , client_code		= '$client_code'";
		$query .= "  , client_name		= '$client_name'";
		$query .= "  , position			= '$position'";
		$query .= "  , department		= '$department'";
		$query .= "  , duty				= '$duty'";
		$query .= "  , client_tel		= '$client_tel'";
		$query .= "  , client_zipcode	= '$client_zipcode'";
		$query .= "  , client_addr1		= '$client_addr1'";
		$query .= "  , client_addr2		= '$client_addr2'";
		$query .= "  , client_addr3		= '$client_addr3'";
		$query .= "  , edu_charge_department = '$edu_charge_department'";
		$query .= "  , edu_charge_tel	= '$edu_charge_tel'";
		//$query .= "  , user_state		= '$user_state'";
		$query .= "  , join_path		= '$join_path'";
*/
		$query .= "  , udtdate			= '$signdate'";
		if($user_state == 0){	$query .= "  , candate	='$signdate'";		}
		if($user_state != 0){	$query .= "  , candate	='0000-00-00 00:00:00'";		}
		$query .= "  , email_flag		= '$email_flag'";
		$query .= "  , sms_flag			= '$sms_flag'";
		$query .= "  , user_remote_ip	= '".$_SERVER["REMOTE_ADDR"]."'";

		$query .= " where idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());

		$msg = "수정";
		//메인페이지로...
		$goto_page = "/";
	}

	if ($gubun  == "state") {
		$query = "update ".$initial."_".$tbl." set ";
		$query .= "   active_flag	='$active_flag'";
		$query .= " where idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$msg = "변경";

		//메인페이지로...
		$goto_page = "/";
	}

	if ($gubun  == "newpasswd") {

		//비밀번호 확인
		/*
		$query = "select count(user_id) as cnt from ".$initial."_".$tbl." where user_id='".$UID."'";
		$query .= " and user_pwd=password('".$user_pwd."')";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}

		if($count_chk == 0) {
			popup_msg("기존 비밀번호가 일치하지 않습니다.\\n다시 확인바랍니다.");
		}
		*/


		$query = "update ".$initial."_".$tbl." set ";
		//$query .= "   user_pwd	=password('$user_pwd_new')";
		//$query .= " user_pwd	=SHA1(MD5('$user_pwd_new'))";
		$query .= " user_pwd	=password('$user_pwd_new')";
		$query .= " where user_id = '".$UID."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$msg = "변경";

		//메인페이지로...
		$goto_page = "mypage.php";
	}

	if ($gubun  == "quit") {



		//비밀번호 암호화 변경되었는지 체크
		$chk_query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
		$chk_query .= " WHERE user_id='".$UID."'";
		$chk_query .= " AND user_state='1'";
		//$chk_query .= " AND passwd_flag='1'";
		$chk_result = mysql_query($chk_query, $dbconn) or die (mysql_error());
		if($chk_array = mysql_fetch_array($chk_result)) {
			$passwd_chk = $chk_array[cnt];
		}

		//비밀번호 확인
		$query = "SELECT count(user_id) as cnt FROM ".$initial."_".$tbl." WHERE user_id='".$UID."'";
		if($passwd_chk==0)	$query .= " AND user_pwd=password('".$user_pwd."')";
		else				$query .= " AND user_pwd=SHA1(MD5('".$user_pwd."'))";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}

		if($count_chk == 0) {
			popup_msg("암호가 일치하지 않습니다.\\n다시 확인하세요.");
		}


		$query = "SELECT * FROM ".$initial."_".$tbl." WHERE user_id='".$UID."'"; // 글 번호를 가지고 조회를 합니다.
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_assoc($result)) {

			foreach ($array as $tmpKey => $tmpValue) {
				$$tmpKey = $tmpValue;
			}// end foreach



			$query = "SELECT max(idx) as maxVal FROM ".$initial."_".$tbl."_quit ";
			$result = mysql_query($query, $dbconn);
			if($array = mysql_fetch_array($result)) {
				$max_val = $array[maxVal];
				if($max_val < 0) $max_num = 1;
				else $max_num = $max_val + 1;
			}

			$user_state = "0";

			$query = "INSERT INTO ".$initial."_".$tbl."_quit ( ";
			$query .= "  idx";
			$query .= "  , user_code";
			$query .= "  , user_id";
			$query .= "  , user_email";
			$query .= "  , user_pwd";
			$query .= "  , user_name";
			$query .= "  , user_hp";
			$query .= "  , user_birth";
			$query .= "  , user_calendar";
			$query .= "  , user_sex";
			$query .= "  , site_kind";
			$query .= "  , client_code";
			$query .= "  , client_name";
			$query .= "  , position";
			$query .= "  , department";
			$query .= "  , duty";
			$query .= "  , client_tel";
			$query .= "  , client_zipcode";
			$query .= "  , client_addr1";
			$query .= "  , client_addr2";
			$query .= "  , client_addr3";
			$query .= "  , edu_charge_department";
			$query .= "  , edu_charge_tel";
			$query .= "  , regdate";
			$query .= "  , user_state";
			$query .= "  , join_path";
			$query .= "  , email_flag";
			$query .= "  , sms_flag";
			$query .= "  , user_remote_ip";
			$query .= "  , user_reason";
			$query .= "  , user_msg";
			$query .= "  ) values (";
			$query .= "  '$max_num'";
			$query .= "  , '$user_code'";
			$query .= "  , '$user_id'";
			$query .= "  , '$user_email'";
			//$query .= "  , SHA1(MD5('".$user_pwd."'))";
			$query .= "  , password('".$user_pwd."')";
			$query .= "  , '$user_name'";
			$query .= "  , '$user_hp'";
			$query .= "  , '$user_birth'";
			$query .= "  , '$user_calendar'";
			$query .= "  , '$user_sex'";
			$query .= "  , '$site_kind'";
			$query .= "  , '$client_code'";
			$query .= "  , '$client_name'";
			$query .= "  , '$position'";
			$query .= "  , '$department'";
			$query .= "  , '$duty'";
			$query .= "  , '$client_tel'";
			$query .= "  , '$client_zipcode'";
			$query .= "  , '$client_addr1'";
			$query .= "  , '$client_addr2'";
			$query .= "  , '$client_addr3'";
			$query .= "  , '$edu_charge_department'";
			$query .= "  , '$edu_charge_tel'";
			$query .= "  , '$regdate'";
			$query .= "  , '$user_state'";
			$query .= "  , '$join_path'";
			$query .= "  , '$email_flag'";
			$query .= "  , '$sms_flag'";
			$query .= "  , '".$user_remote_ip."'";
			$query .= "  , '".$user_reason."'";
			$query .= "  , '".html2db($user_msg)."'";
			$query .= "  )";

			$result=mysql_query($query, $dbconn) or die (mysql_error());

		}// end if

		//원본 삭제
		$query 	= "delete from ".$initial."_".$tbl." where user_id = '".$UID."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());



		unset($_SESSION['UGUBUN']);
		unset($_SESSION['UID']);
		unset($_SESSION['UNAME']);
		unset($_SESSION['UEMAIL']);
		unset($_SESSION['UCODE']);
		unset($_SESSION['UHP']);
		unset($_SESSION['UCCODE']);
		unset($_SESSION['UCNAME']);

		$_SESSION["UGUBUN"]	= null;
		$_SESSION["UID"]	= null;
		$_SESSION["UNAME"]	= null;
		$_SESSION["UEMAIL"] = null;
		$_SESSION["UCODE"]	= null;
		$_SESSION["UHP"]	= null;
		$_SESSION["UCCODE"] = null;
		$_SESSION['UCNAME'] = null;
		session_destroy();


		$msg = "탈퇴";

		//메인페이지로...
		$goto_page = "/";
	}

	if($gubun == "idcheck") {
		//아이디 구하기
		$query="SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
		$query.=" WHERE user_id='".$user_id."'";
		$result=mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
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



	if($gubun == "join_chk") {

		$query="SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
		$query.=" WHERE user_name='".$user_name."'";
		$query.=" AND user_hp='".$user_hp."'";
		$query.=" AND replace(user_birth,'-','')='".$user_birth."'";
		$query.=" AND user_sex='".$user_sex."'";

		$result=mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}
		if($count_chk > 0) {
		?>
			<script>
			alert("이미가입된 정보입니다.");
			history.go(-1);
			</script>
		<?
		} else {
			//메인페이지로...
			$goto_page = "../popup/member_result.php";
		?>
			<script>
			opener.document.getElementById("join_chk").style.display = "block";
			opener.document.getElementById("join_chk2").style.display = "none";
			self.close();
			//location.href="<?=$goto_page?>";
			</script>
		<?
		}

		mysql_close($dbconn);
		exit;
	}

	mysql_close($dbconn);
?>
<form name="form" method="get" action="<?=$goto_page?>">
<input type="hidden" name="lng" value="<?=$lng?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	//alert("성공적으로 <?=$msg?>되었습니다.");
	<?//if($gubun=="delete" || $gubun=="remove" || $gubun=="state") {?>
	document.form.submit();
	<?//} else {?>
	//window.opener.document.location.href = window.opener.document.URL;
	//self.close();
	<?//}?>
//-->
</SCRIPT>
