<?

	header("Content-type:text/html;charset=utf-8");

	$wwwurl = "http://".$_SERVER["HTTP_HOST"];


	$subject = "[".$site_name."]This is the requested information.";

	$item_text = "임시 비밀번호";
	$info_msg = "임시 비밀번호로 로그인하고 비밀번호를 변경하십시오.";

	$Send_msg = "<!DOCTYPE html>".chr(10).chr(13);
	$Send_msg .= "<html lang=\"ko\">".chr(10).chr(13);
	$Send_msg .= "<head>".chr(10).chr(13);
	$Send_msg .= "<meta charset=\"utf-8\">".chr(10).chr(13);
	$Send_msg .= "<title>".$site_name."</title>".chr(10).chr(13);
	$Send_msg .= "</head>".chr(10).chr(13);
	$Send_msg .= "<body>".chr(10).chr(13);
	$Send_msg .= "	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">".chr(10).chr(13);
	$Send_msg .= "		<tr>".chr(10).chr(13);
	$Send_msg .= "			<td align=\"center\">".chr(10).chr(13);
	$Send_msg .= "			<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">".chr(10).chr(13);
	$Send_msg .= "				<tr>".chr(10).chr(13);
	$Send_msg .= "					<td style=\"font-weight:bold; color:#555; padding:5px 20px;\"><a href=\"".$wwwurl."\" target=\"_blank\"><img src=\"".$logo_img."\" alt=\"".$site_name."\"></h2></a></td>".chr(10).chr(13);
	$Send_msg .= "				</tr>".chr(10).chr(13);
	$Send_msg .= "				<tr>".chr(10).chr(13);
	$Send_msg .= "					<td style=\"padding:10px 20px 10px 20px;\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">".chr(10).chr(13);
	$Send_msg .= "				<tr>".chr(10).chr(13);
	$Send_msg .= "					<td style=\"border:1px solid #dce3d0; background:#e9efe0; height:24px; font-weight:bold; color:#555; padding:10px; text-align:left;\">".$item_text."</td>".chr(10).chr(13);
	$Send_msg .= "				</tr>".chr(10).chr(13);
	$Send_msg .= "				<tr>".chr(10).chr(13);
	$Send_msg .= "					<td style=\"padding:20px; background:#f9f9f9; text-align:left;font-size:24px;\"><b>".$randpwd."</b></td>".chr(10).chr(13);
	$Send_msg .= "				</tr>".chr(10).chr(13);
	$Send_msg .= "				<tr>".chr(10).chr(13);
	$Send_msg .= "					<td style=\"font-size:14px;padding:10px 10px;\">".$info_msg."</td>".chr(10).chr(13);
	$Send_msg .= "				</tr>".chr(10).chr(13);
	$Send_msg .= "			</table>".chr(10).chr(13);
	$Send_msg .= "			</td>".chr(10).chr(13);
	$Send_msg .= "		</tr>".chr(10).chr(13);
	$Send_msg .= "		<tr>".chr(10).chr(13);
	$Send_msg .= "			<td height=\"100\"></td>".chr(10).chr(13);
	$Send_msg .= "		</tr>".chr(10).chr(13);
	$Send_msg .= "	</table>".chr(10).chr(13);
	$Send_msg .= "</body>".chr(10).chr(13);
	$Send_msg .= "</html>";


	$mail_result = CallEmailSend("find", $user_email, $user_id, $user_name, $company_email, $send_id="system", $company_name, $autoname, $stran_kind, $reservedate, $subject, $Send_msg, $F_TBL, $F_ID);
?>