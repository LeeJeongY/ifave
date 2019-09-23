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
				<div class="cont_my">
					<h2>Profile</h2>
					<p>Edit membership information</p>
					<div class="myInfo">
						<p>USER NAME</p>
						<ul class="my-ul1">
							<li>
								<strong>Membership</strong>
								<span>General</span>
							</li>
							<li>
								<strong>Mobile phone number</strong>
								<span>010-000-0000</span>
							</li>
						</ul>
						<ul class="my-ul2">
							<li>
								<strong>Email address</strong>
								<span>iqv@iqv.co.kr</span>
							</li>
							<li>
								<strong>Delivery Address</strong>
								<span>Busan, Centum jungang-ro 97</span>
							</li>
						</ul>
						<a href="#n" class="btn-info-modify"><span class="blind">개인정보수정</span></a>
					</div>
					<form>
						<article>
							<div class="infoBox2">
								<ul class="inList">
									<li>
										<label for="id">ID</label>
										<ul>
											<li><input type="text" class="itx int1" name="id" id="id"></li>
										</ul>
										<input type="button" class="ibx1" value="ID duplication check">
									</li>
									<li>
										<label for="pw">Password</label>
										<ul>
											<li><input type="password" class="itx int1" name="pw" id="pw"></li>
										</ul>
									</li>
									<li>
										<label for="c-pw">Confirm Password</label>
										<ul>
											<li><input type="password" class="itx int1" name="c-pw" id="c-pw"></li>
										</ul>
									</li>
									<li>
										<label for="email">e-mail</label>
										<ul>
											<li><input type="text" class="itx int3" name="email" id="email"></li>
										</ul>
									</li>
									<li>
										<label for="home-addr">Home address</label>
										<ul class="d-type-addr">
											<li>
												<input type="text" class="itx int2">
												<input type="button" class="ibx2" name="home-addr" id="home-addr" value="Search address">
											</li>
											<li>
												<input type="text" class="itx int2 smb5">
												<input type="text" class="itx int4">
											</li>
										</ul>
									</li>
								</ul>
							</div>
						</article>

						<div class="btn-area">
							<a href="/" class="btn-c btn-complete">Completed membership</a>
							<a href="/" class="btn-c btn-cancel ml25">Cancel</a>
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
