<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";


	foreach ($_POST as $tmpKey => $tmpValue) {

		// echo $tmpKey."//".$tmpValue."<br>";
		$$tmpKey = $tmpValue;
	}// end foreach

	// mysql_close($dbconn);
	// exit;


	if($_t=="") $_t	= "members"; 				//테이블 이름
	$foldername = "../../$upload_dir/$_t/";

	//==== request값 ================================

	$idx			= stripslashes($idx);
	$cgubun			= stripslashes($cgubun);			// 구분
	$user_code		= stripslashes($user_code);			// 회원코드
	$user_id		= stripslashes($user_id);			// 아이디
	$user_name		= html2db($user_name);				// 이름
	$user_email		= stripslashes($user_email);		// 이메일
	$user_hp		= stripslashes($user_hp);			// 휴대폰
	//$user_hp		= stripslashes($user_hp1)."-".stripslashes($user_hp2)."-".stripslashes($user_hp3); // 휴대폰
	$user_calendar	= stripslashes($user_calendar);		// 음력/양력
	$zipcode		= stripslashes($zipcode);			// 회사 우편번호
	$addr1			= html2db($addr1);					// 새주소
	$addr2			= html2db($addr2);					// 지번주소
	$addr3			= html2db($addr3);					// 상세주소
	$email_flag		= stripslashes($email_flag);		// 이메일 수신여부
	$sms_flag		= stripslashes($sms_flag);			// sms 수신여부
	$user_sex		= stripslashes($user_sex);			// 성별
	$position		= stripslashes($position);			// 직위
	$department		= stripslashes($department);		// 부서
	$duty			= stripslashes($duty);				// 직무분야

	$client_code	= stripslashes($client_code);		// 소속기관코드(회사)
	$client_tel		= stripslashes($client_tel);		// 회사 연락처
	$client_zipcode	= stripslashes($client_zipcode); // 회사 우편번호
	$client_addr1	= html2db($client_addr1);			// 새주소
	$client_addr2	= html2db($client_addr2);			// 지번주소
	$client_addr3	= html2db($client_addr3);			// 상세주소

	$edu_charge_department	= stripslashes($edu_charge_department); // 교육담당자 부서
	$edu_charge_tel			= stripslashes($edu_charge_tel);		// 담당자 연락처

	if($client_tel == "--") $client_tel = "";
	if($hp == "--") $hp = "";
	if($edu_charge_tel == "--") $edu_charge_tel = "";

	for($i=0;$i < count($site_kind);$i++) {
		if($i == 0) $comma = "";
		else $comma = ",";
		$site_kind_arr .= $comma.$site_kind[$i];
	}

	$signdate	= date("Y"."-"."m"."-"."d H:i:s");

	//신규등록인 경우 ============================
	if ($gubun == "insert") {

		//아이디 중복체크
		if($user_id!="") {
			$query = "SELECT count(idx) as cnt FROM ".$initial."_".$_t."";
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
			$query = "SELECT count(idx) as cnt FROM ".$initial."_".$_t."";
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

		$query = "SELECT max(idx) as maxVal FROM ".$initial."_".$_t."";
		$result = mysql_query($query, $dbconn);
		if($array = mysql_fetch_array($result)) {
			$max_val = $array[maxVal];
			if($max_val < 0) $max_num = 1;
			else $max_num = $max_val + 1;
		}

		$user_code = sprintf('%06d', $max_num);

		$query = "insert into ".$initial."_".$_t." ( ";
		$query .= "  user_code";
		$query .= "  , user_id";
		$query .= "  , user_email";
		$query .= "  , user_pwd";
		$query .= "  , user_name";
		$query .= "  , user_hp";
		$query .= "  , user_birth";
		$query .= "  , user_calendar";
		$query .= "  , user_sex";
		$query .= "  , zipcode";
		$query .= "  , addr1";
		$query .= "  , addr2";
		$query .= "  , addr3";
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
		$query .= "  ) values (";
		$query .= "  '".$user_code."'";
		$query .= "  , '".$user_id."'";
		$query .= "  , '".$user_email."'";
		$query .= "  , '".$user_pwd."'";
		$query .= "  , '".$user_name."'";
		$query .= "  , '".$user_hp."'";
		$query .= "  , '".$user_birth."'";
		$query .= "  , '".$user_calendar."'";
		$query .= "  , '".$user_sex."'";
		$query .= "  , '".$zipcode."'";
		$query .= "  , '".$addr1."'";
		$query .= "  , '".$addr2."'";
		$query .= "  , '".$addr3."'";
		$query .= "  , '".$site_kind."'";
		$query .= "  , '".$client_code."'";
		$query .= "  , '".$client_name."'";
		$query .= "  , '".$position."'";
		$query .= "  , '".$department."'";
		$query .= "  , '".$duty."'";
		$query .= "  , '".$client_tel."'";
		$query .= "  , '".$client_zipcode."'";
		$query .= "  , '".$client_addr1."'";
		$query .= "  , '".$client_addr2."'";
		$query .= "  , '".$client_addr3."'";
		$query .= "  , '".$edu_charge_department."'";
		$query .= "  , '".$edu_charge_tel."'";
		$query .= "  , '".$signdate."'";
		$query .= "  , '".$user_state."'";
		$query .= "  , '".$join_path."'";
		$query .= "  , '".$email_flag."'";
		$query .= "  , '".$sms_flag."'";
		$query .= "  , '".$_SERVER["REMOTE_ADDR"]."'";
		$query .= "  )";

		$result=mysql_query($query, $dbconn) or die (mysql_error());

		$msg = "등록";
	}



	//기존데이터 수정인경우 ======================
	if ($gubun  == "update") {

		//$clientnum = $cgubun . sprintf('%06d', $idx);

		$query = "update ".$initial."_".$_t." set ";
		$query .= "  user_email			= '".$user_email."'";
		if($user_pwd!="") $query .= "  , user_pwd	=password('$user_pwd')";
		$query .= "  , user_name		= '".$user_name."'";
		$query .= "  , user_hp			= '".$user_hp."'";
		$query .= "  , user_birth		= '".$user_birth."'";
		$query .= "  , user_calendar	= '".$user_calendar."'";
		$query .= "  , user_sex			= '".$user_sex."'";
		$query .= "  , zipcode			= '".$zipcode."'";
		$query .= "  , addr1			= '".$addr1."'";
		$query .= "  , addr2			= '".$addr2."'";
		$query .= "  , addr3			= '".$addr3."'";
		$query .= "  , site_kind		= '".$site_kind_arr."'";
		$query .= "  , client_code		= '".$client_code."'";
		$query .= "  , client_name		= '".$client_name."'";
		$query .= "  , position			= '".$position."'";
		$query .= "  , department		= '".$department."'";
		$query .= "  , duty				= '".$duty."'";
		$query .= "  , client_tel		= '".$client_tel."'";
		$query .= "  , client_zipcode	= '".$client_zipcode."'";
		$query .= "  , client_addr1		= '".$client_addr1."'";
		$query .= "  , client_addr2		= '".$client_addr2."'";
		$query .= "  , client_addr3		= '".$client_addr3."'";
		$query .= "  , edu_charge_department = '".$edu_charge_department."'";
		$query .= "  , edu_charge_tel	= '".$edu_charge_tel."'";
		$query .= "  , udtdate			= '".$signdate."'";
		$query .= "  , user_state		= '".$user_state."'";
		$query .= "  , join_path		= '".$join_path."'";
		if($user_state == 0){	$query .= "  , candate	='".$signdate."'";		}
		if($user_state != 0){	$query .= "  , candate	='0000-00-00 00:00:00'";		}
		$query .= "  , email_flag		= '".$email_flag."'";
		$query .= "  , sms_flag			= '".$sms_flag."'";
		$query .= "  , user_remote_ip = '".$_SERVER["REMOTE_ADDR"]."'";

		$query .= " where idx = '".$idx."'";

		$result = mysql_query($query, $dbconn) or die (mysql_error());


		$msg = "수정";
	}

	if ($gubun  == "state") {
		$query = "update ".$initial."_".$_t." set ";
		$query .= "   active_flag	='".$active_flag."'";
		$query .= " where idx = '".$idx."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$msg = "변경";
	}

	//기존데이터 삭제 ============================
	if ($gubun == "delete") {
		$query 	= "delete from ".$initial."_".$_t." where idx = '".$idx."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$msg = "삭제";
	}

	if($gubun == "remove") {

		foreach ($idxchk as $tmpIdx) {
			/*
			$query  =  "SELECT user_file, img_file FROM ".$initial."_".$_t." WHERE idx = '".$tmpIdx."'";
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
			*/
			######### 삭제 ##########
			$query 	= "delete from ".$initial."_".$_t." where idx = '".$tmpIdx."'";
			$result = mysql_query($query, $dbconn) or die (sqlsrv_error());
		}
		$msg = "삭제";
	}

	if($gubun == "recode") {
		//고유번호 구하기
		$query = "SELECT max(idx) as maxVal FROM ".$initial."_".$_t."";
		$result = mysql_query($query, $dbconn);
		if($array = mysql_fetch_array($result)) {
			$max_val = $array[maxVal];
			if($max_val < 0) $max_num = 1;
			else $max_num = $max_val + 1;
		}
		$user_code = $cgubun . sprintf('%06d', $max_num);
		if($idx) $gubun = "update";
		else $gubun = "insert";
		?>
		<script language="javascript">
			parent.document.fm.gubun.value="<?=$gubun?>";
			parent.document.fm.user_code.value="<?=$user_code?>";
		</script>
		<?
			mysql_close($dbconn);
		exit;
	}

	if($gubun == "idcheck") {
		//아이디 구하기
		$query="SELECT count(idx) as cnt FROM ".$initial."_".$_t."";
		$query.=" WHERE user_id='".$user_id."'";
		$result=mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}

		if($idx!="") $gubun = "update";
		else $gubun = "insert";

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
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("성공적으로 <?=$msg?>되었습니다.");
	<?if($gubun=="delete" || $gubun=="remove" || $gubun=="state") {?>
	document.form.submit();
	<?} else {?>
	window.opener.document.location.href = window.opener.document.URL;
	self.close();
	<?}?>
//-->
</SCRIPT>
