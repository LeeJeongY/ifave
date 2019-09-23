<?
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

	// mysql_close($dbconn);
	// exit;

	if($tbl=="")	$tbl	= "inquiry"; 				//테이블 이름
	$foldername = "../$upload_dir/$tbl/";


	//==== request값 ================================
	$title		= html2db($title);
	$contents	= html2db($message);
	$user_name	= html2db($user_name);
	//$user_tel	= $user_tel1."-".$user_tel2."-".$user_tel3;
	//$user_email	= $user_email1."@".$user_email2;

	if($gubun=="") $gubun = "insert";
	$signdate	= date("Y"."-"."m"."-"."d H:i:s");

	if($category=="") $category = "01";


	//신규등록인 경우 ============================
	if ($gubun == "insert") {

		// max 구하기
		$query		= "SELECT max(idx) as max_idx FROM ".$initial."_bbs_".$tbl." ";
		$result		= mysql_query($query, $dbconn);
		if($maxnum_array = mysql_fetch_array($result)) {
			$max_idx = $maxnum_array[max_idx];
			if ($max_idx == "" or $max_idx == NULL) {
				$max_idx   = 1;
			} else {
				$max_idx   = $max_idx + 1;
			}
		}

		$user_state = 0;

		$query = "INSERT INTO ".$initial."_bbs_".$tbl." SET ";
		$query .= "    idx				= '$max_idx'";
		$query .= "  , title			= '$title'";
		$query .= "  , category			= '$category'";
		$query .= "  , user_name		= '$user_name'";
		$query .= "  , user_group		= '$user_group'";
		$query .= "  , user_tel			= '$user_tel'";
		$query .= "  , user_email		= '$user_email'";
		$query .= "  , question_type	= '$question_type'";
		$query .= "  , contents			= '$contents'";
		$query .= "  , user_ip			= '$remoteip'";
		$query .= "  , user_state		= '$user_state'";
		$query .= "  , regdate			= '$signdate'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());


		/*
		* 메일 발송
		*/
/*
		$nameFrom	= $admin_name;		//보내는 이
		$mailFrom	= $admin_email;		//보내는 사람 이메일
		$nameTo		= $user_name;		//받는 이
		$mailTo		= $user_email;		//받는사람 이메일
*/
		$nameFrom	= $user_name;		//보내는 이
		$mailFrom	= $user_email;		//보내는 사람 이메일
		$nameTo		= $admin_name;		//받는 이
		$mailTo		= $admin_email;		//받는사람 이메일

		$subject	= $title;			//제목

		$cc			= "";				//참조
		$bcc		= "";				//숨은참조


		$content = "<b>이름</b> : $user_name <br>";
		$content .= "<b>연락처</b> : $user_tel <br><br>";
		$content .= $message;


		$charset = "UTF-8";

		$nameFrom	= "=?$charset?B?".base64_encode($nameFrom)."?=";
		$nameTo		= "=?$charset?B?".base64_encode($nameTo)."?=";
		$subject	= "=?$charset?B?".base64_encode($subject)."?=";

		$header  = "Content-Type: text/html; charset=utf-8\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Return-Path: <". $mailFrom .">\r\n";
		$header .= "From: ". $nameFrom ." <". $mailFrom .">\r\n";
		$header .= "Reply-To: <". $mailFrom .">\r\n";
		if ($cc)  $header .= "Cc: ". $cc ."\r\n";
		if ($bcc) $header .= "Bcc: ". $bcc ."\r\n";


		$mailserver = 'localhost'; //STMP Server ex:smtp.your.com
		$port = '25'; //STMP port ex:25

		ini_set('SMTP', $mailserver);
		ini_set('smtp_port', $port);
		ini_set('sendmail_from', $sendEmail);

		$result = mail($mailTo, $subject, $content, $header, $mailFrom);


		$msg = "등록";
	}



	//기존데이터 수정인경우 ======================
	if ($gubun  == "update") {

		$query = "UPDATE ".$initial."_bbs_".$tbl." SET ";
		$query .= "   title			= '$title'";
		$query .= "  , category		= '$category'";
		$query .= "  , contents		= '$contents'";
		$query .= "  , user_state	= '$user_state'";
		$query .= "  , user_ip		= '$user_ip'";
		$query .= "  , user_name	= '$user_name'";
		$query .= "  , user_tel		= '$user_tel'";
		$query .= "  , user_email	= '$user_email'";
		$query .= "  , upddate		= '$signdate'";
		$query .= " WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());

		$msg = "수정";
	}


	//기존 데이터 삭제 ============================
	if ($gubun == "delete") {

		//결제신청 정보 삭제
		$query 	= "DELETE FROM ".$initial."_bbs_".$tbl." WHERE idx = '".$idx."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());

		$msg = "삭제";
	}

	mysql_close($dbconn);

	if($return_page=="") $return_page = "/";
?>
<form name="form" method="get" action="<?=$return_page?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("성공적으로 <?=$msg?>되었습니다.");
	//window.opener.document.location.href = window.opener.document.URL;
	//self.close();
	document.form.submit();
//-->
</SCRIPT>
