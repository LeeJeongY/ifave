<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";

	include "../inc/header.php";
?>

<script type='text/javascript'>
/* 약관동의 - 전체동의 */
function allCheckFunc( obj ) {
		$("[name=check-agree]").prop("checked", $(obj).prop("checked") );
}

/* 체크박스 체크시 전체선택 체크 여부 */
function oneCheckFunc( obj )
{
	var allObj = $("[name=check-all]");
	var objName = $(obj).attr("name");

	if( $(obj).prop("checked") )
	{
		checkBoxLength = $("[name="+ objName +"]").length;
		checkedLength = $("[name="+ objName +"]:checked").length;

		if( checkBoxLength == checkedLength ) {
			allObj.prop("checked", true);
		} else {
			allObj.prop("checked", false);
		}
	}
	else
	{
		allObj.prop("checked", false);
	}
}

$(function(){
	$("[name=check-all]").click(function(){
		allCheckFunc( this );
	});
	$("[name=check-agree]").each(function(){
		$(this).click(function(){
			oneCheckFunc( $(this) );
		});
	});
});
</script>

		<!-- container -->
		<div id="container">

			<section>
				<div class="cont_sign">
					<h2>Sign Up</h2>
					<form>
						<article>
							<div class="infoBox">
								<ul class="inList">
									<li>
										<label for="name">Name</label>
										<ul>
											<li><input type="text" class="itx int1" name="name" id="name"></li>
										</ul>
									</li>
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
										<label>Sex / Date of birth</label>
										<ul class="d-type">
											<li><input type="radio" name="sex" id="man"> <label for="man">Man</label></li>
											<li><input type="radio" name="sex" id="woman"> <label for="woman">Woman</label></li>
											<li class="dob first">
												<select class="selec1 int6">
													<option>Year</option>
												</select>
											</li>
											<li class="dob">
												<select class="selec1 int6">
													<option>Month</option>
												</select>
											</li>
											<li class="dob">
												<select class="selec1 int6">
													<option>Day</option>
												</select>
											</li>
										</ul>
									</li>
									<li>
										<label for="contact">Contact</label>
										<ul class="d-type">
											<li>
												<select class="selec1 int6">
													<option>Select</option>
												</select>
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int7">
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int7">
											</li>
										</ul>
									</li>
								</ul>
							</div>
						</article>

						<article>
							<div class="infoBox">
								<h3>· Parental Information</h3>
								<ul class="inList">
									<li>
										<label for="p-name">Parent's name</label>
										<ul>
											<li><input type="text" class="itx int1" name="p-name" id="p-name"></li>
										</ul>
									</li>
									<li>
										<label for="p-contact">Contact</label>
										<ul class="d-type">
											<li>
												<select class="selec1 int6">
													<option>Select</option>
												</select>
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int7">
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int7">
											</li>
										</ul>
									</li>
								</ul>
							</div>
						</article>

						<article>
							<div class="infoBox">
								<h3>· Additional Information</h3>
								<ul class="inList">
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
												<input type="text" class="itx int2">
												<input type="text" class="itx int4">
											</li>
										</ul>
									</li>
								</ul>

							</div>
						</article>

						<div class="agreeBox">
							<h4>
								<label class="checkbox2 check-left" for="all-ind-agree">
									<span>Accept all terms and conditions</span>

									<input type="checkbox" id="all-ind-agree" name="check-all">
									<i class="chk"></i>
								</label>
							</h4>
							<ul>
								<li>
									<label class="checkbox2 check-left" for="ind-agree-1">
										<span>Terms of Use agreement</span>
										<input type="checkbox" id="ind-agree-1" name="check-agree">
										<i class="chk"></i>
									</label>
									<a href="#n">View Terms and Conditions ></a>
								</li>
								<li>
									<label class="checkbox2 check-left" for="ind-agree-2">
										<span>Privacy Policy View Agreement</span>
										<input type="checkbox" id="ind-agree-2" name="check-agree">
										<i class="chk"></i>
									</label>
									<a href="#n">View Terms and Conditions ></a>
								</li>
								<li>
									<label class="checkbox2 check-left" for="ind-agree-3">
										<span>Personal information Third-party provision and referral agreement</span>
										<input type="checkbox" id="ind-agree-3" name="check-agree">
										<i class="chk"></i>
									</label>
									<a href="#n">View Terms and Conditions ></a>
								</li>
								<li>
									<label class="checkbox2 check-left" for="ind-agree-4">
										<span>Accept event notifications (optional)</span>
										<input type="checkbox" id="ind-agree-4" name="check-agree">
										<i class="chk"></i>
									</label>
								</li>
							</ul>
						</div>

						<div class="btn-area">
							<a href="/?lng=<?=$lng?>" class="btn-c btn-complete">Completed membership</a>
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
