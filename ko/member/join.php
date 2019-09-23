<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";

	include "../inc/header.php";
?>

<!-- container -->
		<div id="container">

			<section>
				<div class="comList">
					<div class="content">
						<h2>회원가입</h2>
						<div class="signBox cfx">
							<ul>
								<li class="signGeneral memb">
									<a href="join_form.php?grownup=1">
										<span class="general"></span>
										<strong>일반 회원가입</strong>
										<p>만 14세 이상 회원가입</p>
									</a>
								</li>
								<li class="signChild memb">
									<a href="join_form.php?grownup=0">
										<span class="children"></span>
										<strong>어린이 회원가입</strong>
										<p>만 14세 미만 회원가입</p>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>

