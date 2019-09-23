<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";

	$tbl	= "members"; 				//테이블 이름
	$foldername = "../../$upload_dir/$tbl/";


	//아이디 비번 찾기
	if($id_flag == "1") $qry_where .= " and user_email	='".$user_email."'";
	if($id_flag == "2") $qry_where .= " and user_hp	='".$user_hp."'";

	if($pw_flag == "1") $qry_where .= " and user_id='".$user_id."' and user_email	='".$user_email."'";
	if($pw_flag == "2") $qry_where .= " and user_id='".$user_id."' and user_hp	='".$user_hp."'";


	//아이디 체크
	$query = "select count(user_id) as cnt from ".$initial."_".$tbl." where user_name='".$user_name."'";
	$query .= $qry_where;

	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array = mysql_fetch_array($result)) {
		$count_chk = $array[cnt];
	}

	if($count_chk>0) {
		$query = "select idx, user_id, user_pwd, regdate from ".$initial."_".$tbl." where user_name='".$user_name."'";
		$query .= $qry_where;
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx		= $array[idx];
			$user_id	= $array[user_id];
			$user_pwd	= $array[user_pwd];
			$regdate	= $array[regdate];
		}
	}

	//아이디
	$ulen		= strlen($user_id)-2;
	$userid		= substr($user_id, 0,$ulen)."**";
	//이메일
	list($email1,$email2) = explode("@",$user_email);
	$email_len		= strlen($email1)-2;
	$email_f		= substr($email1, 0,$email_len)."**";
	$email_send = $email_f."@".$email2;
	//휴대폰
	list($hp1,$hp2,$hp3) = explode("-",$user_hp);
	$hp_send = $hp1."-".$hp2."-"."****";

	$randpwd = getStringRandom(8);


	include "../inc/header.php";
?>


<script type='text/javascript'>
<?
if($pw_flag) {
?>
$(document).ready(function(){

	$("#send_submit").click(function() {
		var fm = document.sendform;
		fm.user_id.value = "<?=$user_id?>";
		var s = confirm("발송하시겠습니까?")
		if(s == true) {
			fm.action = "find_send.php";
			fm.submit();
		}


	});

});
<?}?>
</script>


	<form name="sendform" id="sendform" method="post" >
	<input type="hidden" name="mkind" value="e">
	<input type="hidden" name="user_id" value="">
	<input type="hidden" name="user_name" value="<?=$user_name?>">
	</form>

		<!-- container -->
		<div id="container">
			<section>
				<div class="cont_my">
			<?
			if($count_chk > 0) {
				if($id_flag == "1") {
			?>
					<h2>아이디 찾기</h2>
					<p>
						개인정보보호를 위해 아이디 끝자리 두개는 *로 표시하였습니다.
					</p>

					<div class="findBox">
						<ul>
							<li style="text-align:center;">
							<input type="text" class="itx none" name="user_id" id="user_id" value="<?=$userid?>" readonly>
							(<input type="text" class="itx none" name="join_date" id="join_date" size="10" value="<?=substr($regdate,0,10)?>" readonly> <b>가입일</b>)

							</li>
						</ul>
					</div>

					<div class="btn-area">
						<a href="find_pw.php" class="btn-c btn-complete">비밀번호 찾기</a>
						<a href="javascript:history.go(-1);" class="btn-c btn-cancel ml38">뒤로가기</a>
					</div>

			<?
				//비밀번호 찾기(메일,휴대폰)
				}

				if($pw_flag == "1" ) {
				//이메일
			?>
					<h2>비밀번호 찾기</h2>
					<p>
						회원정보에 등록된 메일주소로 임시 비밀번호를 발송합니다.
					</p>

					<div class="findBox">
						<ul>
							<li style="text-align:center;"><input type="text" class="itx none" name="user_email" id="user_email" value="<?=$email_send?>" readonly></li>
						</ul>
					</div>

					<div class="btn-area">
						<a href="javascript:;" id="send_submit" class="btn-c btn-complete">보내기</a>
						<a href="find_pw.php" class="btn-c btn-cancel ml38">뒤로가기</a>
					</div>
			<?
				}
			} else {
			?>
					<h2>Not Found</h2>
					<div class="findBox">
						<ul>
							<li style="text-align:center;">입력한 정보와 일치하는 정보가 없습니다.</li>
						</ul>
					</div>

					<div class="btn-area">
						<a href="javascript:history.go(-1);" class="btn-c btn-cancel ml38">뒤로가기</a>
					</div>

			<?}?>
				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
