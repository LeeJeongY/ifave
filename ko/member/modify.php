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
					<h2>회원정보 수정</h2>
					<p>Edit membership information</p>
					<div class="myInfo">
						<p>USER NAME</p>
						<ul class="my-ul1">
							<li>
								<strong>회원</strong>
								<span>일반</span>
							</li>
							<li>
								<strong>연락처</strong>
								<span>010-000-0000</span>
							</li>
						</ul>
						<ul class="my-ul2">
							<li>
								<strong>이메일</strong>
								<span>iqv@iqv.co.kr</span>
							</li>
							<li>
								<strong>배송지</strong>
								<span>부산광역시 센텀중앙로 97 센텀스카이비즈 2310호</span>
							</li>
						</ul>
						<a href="#n" class="btn-info-modify"><span class="blind">개인정보수정</span></a>
					</div>
					<form>
						<article>
							<div class="infoBox2">
								<ul class="inList">
									<li>
										<label for="id">아이디</label>
										<ul>
											<li><input type="text" class="itx int1" name="id" id="id"></li>
										</ul>
										<input type="button" class="ibx1" value="ID duplication check">
									</li>
									<li>
										<label for="pw">비밀번호</label>
										<ul>
											<li><input type="password" class="itx int1" name="pw" id="pw"></li>
										</ul>
									</li>
									<li>
										<label for="c-pw">비밀번호 확인</label>
										<ul>
											<li><input type="password" class="itx int1" name="c-pw" id="c-pw"></li>
										</ul>
									</li>
									<li>
										<label for="email">이메일</label>
										<ul>
											<li><input type="text" class="itx int3" name="email" id="email"></li>
										</ul>
									</li>
									<li>
										<label for="home-addr">주소</label>
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
							<a href="/" class="btn-c btn-complete">회원정보 수정</a>
							<a href="/" class="btn-c btn-cancel ml25">취소</a>
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
