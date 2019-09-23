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
					<p>Thank you for registering with us</p>
					<ul>
						<li><a href="/?lng=<?=$lng?>" class="btn-home">Home</a></li>
						<li><a href="../member/login.php" class="btn-login-com">Login</a></li>
					</ul>
				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
