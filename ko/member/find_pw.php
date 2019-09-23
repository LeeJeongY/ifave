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

	$("#find_submit").click(function() {

		if($.trim($('#user_name').val()) == ''){
			alert("이름을 입력하세요.");
			$('#user_name').focus();
			return false;
		}
		if($.trim($('#user_id').val()) == ''){
			alert("아이디를 입력하세요.");
			$('#user_id').focus();
			return false;
		}
		if($.trim($('#user_email').val()) == ''){
			alert("이메일을 입력하세요.");
			$('#user_email').focus();
			return false;
		}
		$("#fm").attr("target", "_self");
		$("#fm").attr("method", "post");
		$("#fm").attr("action", "find_chk.php");
		$("#fm").submit();
	});

});
</script>
		<!-- container -->
		<div id="container">
			<section>
				<div class="cont_my">
					<h2>비밀번호 찾기</h2>
					<p>
						비밀번호가 생각나지 않으세요?<br>
						회원님의 개인정보를 안전하게 되찾으실 수 있도록 도와드리겠습니다.
					</p>

					<form name="fm" id="fm">
					<input type="hidden" name="gubun" value="">
					<input type="hidden" name="pw_flag" id="pw_flag" value="1">
					<div class="findBox">
						<ul class="inList">
							<li>
								<label for="user_name">성 함</label>
								<ul>
									<li class="block"><input type="text" class="itx int5" name="user_name" id="user_name" value=""></li>
								</ul>
							</li>
							<li>
								<label for="user_id">아이디</label>
								<ul>
									<li class="block"><input type="text" class="itx int5" name="user_id" id="user_id"></li>
								</ul>
							</li>
							<li>
								<label for="user_email">이메일</label>
								<ul>
									<li class="block"><input type="text" class="itx int5" name="user_email" id="user_email"></li>
								</ul>
							</li>
						</ul>
					</div>

					<div class="btn-area">
						<a href="javascript:;" id="find_submit" class="btn-c btn-complete">보내기</a>
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
