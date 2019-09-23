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
			alert("Name is a required field.");
			$('#user_name').focus();
			return false;
		}
		if($.trim($('#user_id').val()) == ''){
			alert("ID is a required field.");
			$('#user_id').focus();
			return false;
		}
		if($.trim($('#user_email').val()) == ''){
			alert("Email is a required field.");
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
					<h2>Forgot your password?</h2>
					<p>
						Do not you remember your Password?<br>
						We will help you to retrieve your personal information safely.
					</p>

					<form name="fm" id="fm">
					<input type="hidden" name="gubun" value="">
					<input type="hidden" name="pw_flag" id="pw_flag" value="1">
					<div class="findBox">
						<ul class="inList">
							<li>
								<label for="user_name">Name</label>
								<ul>
									<li class="block"><input type="text" class="itx int5" name="user_name" id="user_name" value=""></li>
								</ul>
							</li>
							<li>
								<label for="user_id">ID</label>
								<ul>
									<li class="block"><input type="text" class="itx int5" name="user_id" id="user_id"></li>
								</ul>
							</li>
							<li>
								<label for="user_email">e-mail</label>
								<ul>
									<li class="block"><input type="text" class="itx int5" name="user_email" id="user_email"></li>
								</ul>
							</li>
						</ul>
					</div>

					<div class="btn-area">
						<a href="javascript:;" id="find_submit" class="btn-c btn-complete">Send</a>
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
