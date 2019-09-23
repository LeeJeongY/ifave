<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";

	include "../inc/header.php";
?>


<script type='text/javascript'>
$(document).ready(function(){

	$("#pwd_submit").click(function() {

		if($.trim($('#user_pwd').val()) == ''){
			alert("Password is a required field.");
			$('#user_pwd').focus();
			return false;
		}
		$("#fm").attr("target", "_self");
		$("#fm").attr("method", "post");
		$("#fm").attr("action", "join_edit.php");
		$("#fm").submit();
	});

});
</script>

		<!-- container -->
		<div id="container">
			<section>
				<div class="cont_my">
					<h2>비밀번호 인증</h2>
					<p>비밀번호를 입력하세요.</p>

					<form name="fm" id="fm">
					<input type="hidden" name="gubun" value="">
					<div class="findBox">
						<ul class="inList">
							<li>
								<label for="user_pwd">비밀번호</label>
								<ul>
									<li class="block"><input type="password" class="itx int5" name="user_pwd" id="user_pwd" value=""></li>
								</ul>
							</li>
						</ul>
					</div>

					<div class="btn-area">
						<a href="javascript:;" id="pwd_submit" class="btn-c btn-complete">확인</a>
						<a href="javascript:history.go(-1);" class="btn-c btn-cancel ml38">뒤로가기</a>
					</div>
					</form>

				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
