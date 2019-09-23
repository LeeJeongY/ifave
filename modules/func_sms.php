<?

function CallEmailSend($email_gubun, $receive_email, $receive_id, $receive_name, $send_email, $send_id, $send_name, $autoname, $stran_kind, $reservedate, $title, $contents, $f_tbl, $f_id) {
	global $initial;
	global $dbconn;
	global $site_name;

	if($session_id == "") {
		$session_id = @session_id();
		@session_register("session_id");
	}

	//결과 선언
	$result_code = 0;
	$state = 0;
	$remoteip		= getenv("REMOTE_ADDR");
	$signdate		= date("Y"."-"."m"."-"."d H:i:s");


	$state = "1";


	/************************************************************************/
	$mailserver = 'localhost';	//STMP Server ex:smtp.your.com
	$port = '25';				//STMP port ex:25

	ini_set('SMTP', $mailserver);
	ini_set('smtp_port', $port);
	ini_set('sendmail_from', $send_email);

	$mailheader .= "Return-Path: ".$receive_email." \r\n";
	$mailheader .= "From: ".$site_name." Customer Service<".$send_email.">\n";
	$mailheader .= "Content-Type: text/html; charset=utf-8\r\n";

	$Result = mail($receive_email, $title, $contents, $mailheader);


	//결과코드
	$result_code	= $Result;
	$result_msg		= $alert;

	//발송결과 알림
	if($result_code) {
		$alert = "Successfully sent.";
		$state = 1;
	} else {
		$alert = "[Error]".$Result;
		$state = 0;
	}

	/*******************************************************************/
	//디비 전송
	/*******************************************************************/

	// max, pcode 구하기
	$query = "SELECT max(idx) FROM ".$initial."_email_log";
	$result = mysql_query($query,$dbconn);
	$email_max_idx = mysql_result($result,0,0);
	if($email_max_idx < 0) {
		$email_max_idx = 1;
	} else {
		$email_max_idx = $email_max_idx+1;
	}

	$sql = "insert into ".$initial."_email_log set ";
	$sql .= "  idx      	='".$email_max_idx."'";
	$sql .= ", foreign_tbl	='".$f_tbl."'";
	$sql .= ", foreign_id	='".$f_id."'";
	$sql .= ", session_id	='".$session_id."'";
	$sql .= ", email_gubun	='".$email_gubun."'";
	$sql .= ", receive_id	='".$receive_id."'";
	$sql .= ", receive_name	='".$receive_name."'";
	$sql .= ", receive_email='".$receive_email."'";
	$sql .= ", send_id		='".$send_id."'";
	$sql .= ", send_name	='".$send_name."'";
	$sql .= ", send_email	='".$send_email."'";
	$sql .= ", title		='".$title."'";
	$sql .= ", contents		='".$contents."'";
	$sql .= ", state		='".$state."'";
	$sql .= ", result_code	='".$result_code."'";
	$sql .= ", result_msg	='".$result_msg."'";
	$sql .= ", remote_ip 	='".$remoteip."'";
	$sql .= ", regdate  	='".$signdate."'";
	@mysql_query($sql, $dbconn) or die (mysql_error());

	return $result_code;
}
?>
