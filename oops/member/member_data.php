<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	//변수 설정
	if($_t=="") $_t = "members";						//테이블명
	$foldername	= "../../$upload_dir/".$_t."/";


	## /oops/member/popup_member_list.php에서 불러옴
	$data_list = "";
	$data_list .= "	<div class=\"form-group\">";
	$data_list .= "		<label for=\"user_list\">회원목록</label>";
	$data_list .= "		<div class=\"box-body pad\">";
	$data_list .= "			<table border=\"0\" width=\"100%\">";
	for($i=0;$i < count($idxchk);$i++) {
		$query = "SELECT * FROM ".$initial."_".$_t." WHERE idx='".$idxchk[$i]."'";

		$result= mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			foreach ($array as $tmpKey => $tmpValue) {

				$$tmpKey = $tmpValue;
			}// end foreach

			$subject	= db2html($subject);

		}

		$user_list = "	<input type=\"hidden\" name=\"user_id[]\" value=\"$user_id\">";
		$user_list = "	<input type=\"hidden\" name=\"user_name[]\" value=\"$user_name\">";
		$user_list = "	<input type=\"hidden\" name=\"user_email[]\" value=\"$user_email\">";
		$user_list = "	<input type=\"hidden\" name=\"user_hp[]\" value=\"$user_hp\">";
		$user_list .= "	<tr>";
		$user_list .= "		<td>$user_name</td>";
		$user_list .= "		<td>$user_id</td>";
		$user_list .= "		<td>$user_hp</td>";
		$user_list .= "		<td>$user_email</td>";
		$user_list .= "	</tr>";

		$data_list .= $user_list;

	}
	$data_list .= "			</tr>";
	$data_list .= "		</div>";
	$data_list .= "	</div>";

	echo $data_list;
?>
<? mysql_close($dbconn); ?>