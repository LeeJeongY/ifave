<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";

	include "../inc/header.php";
?>

		<!-- container -->
		<div id="container">

			<section>
				<div class="cont_cp">
					<h2><img src="/images/contents/cp-logo.png" alt="FAVE"></h2>
					<p>회원가입을 축하드립니다.<br><span>이제, FAVE와 함께 즐겁게 운동하세요.</span></p>
					<ul>
						<li><a href="/?lng=<?=$lng?>" class="btn-home">홈으로</a></li>
						<li><a href="../member/login.php" class="btn-login-com">로그인</a></li>
					</ul>
				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
