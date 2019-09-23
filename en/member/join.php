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
						<h2>Sign Up</h2>
						<div class="signBox cfx">
							<ul>
								<li class="signGeneral memb">
									<a href="join_form.php?grownup=1">
										<span class="general"></span>
										<strong>General Member</strong>
										<p>JOIN 14years old or older</p>
									</a>
								</li>
								<li class="signChild memb">
									<a href="join_form.php?grownup=0">
										<span class="children"></span>
										<strong>Child Member</strong>
										<p>JOIN under 14years old</p>
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

