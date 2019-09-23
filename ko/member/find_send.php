<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	header("Pragma: no-cache");

	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/func_sms.php";

	$tbl = "members";

	if($user_id == "") {
		?>
		<script>
			alert('전달값 중 필요한 정보가 없습니다.');
			history.go(-1);
		</script>
		<?
		exit;
	}

	$query 	= "select user_id,user_pwd,user_email,user_name,user_hp,regdate from ".$initial."_".$tbl." where user_state='1' ";
	$query .= " and user_id = '".$user_id."'";

	$result = mysql_query($query,$dbconn) or die (mysql_error());
	$row	= mysql_num_rows($result);
	if($row > 0){
		if($array 	= mysql_fetch_array($result)) {

			$user_id 		= $array[user_id];
			$user_pwd		= $array[user_pwd];					//비밀번호
			$user_email		= $array[user_email];
			$user_name 		= $array[user_name];
			$user_hp 		= $array[user_hp];
			$regdate 		= $array[regdate];

			$randpwd = getStringRandom(8);


			//이메일 발소
			if($mkind == "e") {
				include "find_send_email.php";

				if($mail_result==true) {
					//비밀번호 변경
					$upqry = "update ".$initial."_".$tbl." set user_pwd = password('$randpwd') where user_id='$user_id'";
					$result = mysql_query($upqry,$dbconn);

					$msg_txt = "회원가입시 이메일 주소로 메일을 발송하였습니다.\\n\\n고객센터 문의(☎ $customer_tel)";
				} else {
					$msg_txt = "죄송합니다.\\n\\n메일발송 중 에러가 발생하였습니다.\\n\\n고객센터로 문의바랍니다(☎ $customer_tel).\\n\\n또는 다른인증방식을 사용을 추천합니다.";
				}

			//휴대폰 전송
			} else if($mkind == "h") {

				if($user_hp != "") {
					//include "find_send_sms.php";

					if($sms_result == true) {
						//비밀번호 변경
						$upqry = "update ".$initial."_".$tbl." set user_pwd = password('$randpwd') where user_id='$user_id'";
						$result = mysql_query($upqry,$dbconn);

						$msg_txt = "회원가입시 휴대폰으로 전송하였습니다.\\n\\n고객센터 문의(☎ $customer_tel)";
					} else {
						$msg_txt = "죄송합니다.\\n\\n전송 중 에러가 발생하였습니다.\\n\\n고객센터로 문의바랍니다(☎ $customer_tel).\\n\\n또는 다른인증방식을 사용을 추천합니다.";
					}
				}


			}


		}
	}
?>
<?mysql_close($dbconn);?>
<script>
//alert('<?=$msg_txt?>');
location.href="find_id.php";
</script>