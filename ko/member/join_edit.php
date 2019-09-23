<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";

	$tbl	= "members"; 							//테이블 이름
	$foldername = "../../$upload_dir/$tbl/";

	if ($UID && $user_pwd) {

		//비밀번호 확인
		$query = "select count(user_id) as cnt from ".$initial."_".$tbl." where user_id='".$UID."'";
		$query .= " and user_pwd=password('".$user_pwd."')";
		//$query .= " and user_pwd=SHA1(MD5('$user_pwd'))";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}

		if($count_chk == 0) {
			popup_msg("Passwords do not match.\\nPlease check again.");
		}

		//회원정보 출력
		$query = "select * from ".$initial."_".$tbl." where user_id='".$UID."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {

			foreach ($array as $tmpKey => $tmpValue) {

				$$tmpKey = $tmpValue;
			}// end foreach

			list($user_hp1,$user_hp2,$user_hp3) = explode("-",$user_hp);
			list($client_tel1,$client_tel2,$client_tel3) = explode("-",$client_tel);
			list($client_tel1,$client_tel2,$client_tel3) = explode("-",$client_tel);

			list($edu_charge_tel1,$edu_charge_tel2,$edu_charge_tel3) = explode("-",$edu_charge_tel);

		}

	} else {
		//비밀번호 인증
		?>
		<script>
			location.href="password.php?md=edit";
		</script>
		<?
		exit;
	}

	include "../inc/header.php";
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$( function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	} );
</script>
<script>


$(document).ready(function(){

	$("#join_submit").click(function() {

		if($.trim($('#user_name').val()) == ''){
			alert("이름을 입력하세요.");
			$('#user_name').focus();
			return false;
		}
		if($.trim($('#user_pwd').val()) == ''){
			alert("비밀번호를 입력하세요.");
			$('#user_pwd').focus();
			return false;
		}
		if($(':radio[name="user_sex"]').is(":checked") == false) {
			alert("성별을 선택하세요.");
			$('#user_calendar1').focus();
			return false;
		}
		if($.trim($('#datepicker').val()) == ''){
			alert("생년월일을 입력하십시오.");
			$('#datepicker').focus();
			return false;
		}
		if($.trim($('#user_hp').val()) == ''){
			alert("연락처를 입력하세요.");
			$('#user_hp').focus();
			return false;
		}
		<?if($grownup == "0") {?>
		if($.trim($('#parent_name').val()) == ''){
			alert("보호자 이름을 입력하세요.");
			$('#parent_name').focus();
			return false;
		}
		if($.trim($('#parent_tel').val()) == ''){
			alert("보호자 연락처를 입력하세요.");
			$('#parent_tel').focus();
			return false;
		}
		<?}?>
		if($.trim($('#user_email').val()) == ''){
			alert("이메일을 입력하세요.");
			$('#user_email').focus();
			return false;
		}
		if($.trim($('#zipcode').val()) == ''){
			alert("우편번호를 입력하세요.");
			$('#zipcode').focus();
			return false;
		}
		if($.trim($('#addr1').val()) == ''){
			alert("주소를 입력하세요.");
			$('#addr1').focus();
			return false;
		}

		$('#gubun').val("update");
		$("#fm").attr("target", "_self");
		$("#fm").attr("method", "post");
		$("#fm").attr("action", "join_ok.php");
		$("#fm").submit();
	});

});

</script>
		<!-- container -->
		<div id="container">
			<section>
				<div class="cont_my">
					<h2>Profile</h2>
					<p>Edit membership information</p>
					<div class="myInfo">
						<p><?=$user_name?></p>
						<ul class="my-ul1">
							<li>
								<strong>Membership</strong>
								<span>General</span>
							</li>
							<li>
								<strong>Mobile phone number</strong>
								<span><?=$user_hp?></span>
							</li>
						</ul>
						<ul class="my-ul2">
							<li>
								<strong>Email address</strong>
								<span><?=$user_email?></span>
							</li>
							<li>
								<strong>Delivery Address</strong>
								<span><?=$addr3?>, <?=$addr2?>, <?=$addr1?> <?=$zipcode?></span>
							</li>
						</ul>
					</div>


						<form method="post" name="fm" id="fm" enctype="multipart/form-data">
						<input type="hidden" name="page" value='<?=$page?>'>
						<input type="hidden" name="idx" value='<?=$idx?>'>
						<input type="hidden" name="gubun" id="gubun" value='<?=$gubun?>'>
						<input type="hidden" name="popup" value="<?=$popup?>">
						<input type="hidden" name="idchk" id="idchk" value="">


						<article>
							<div class="infoBox2">
								<h3>· 보호자 정보</h3>
								<ul class="inList">
									<li>
										<label for="name">성함</label>
										<ul>
											<li><input type="text" class="itx int1" name="user_name" id="user_name" value="<?=$user_name?>"></li>
										</ul>
									</li>
									<li>
										<label for="id">아이디</label>
										<ul>
											<li>
											<?=$user_id?>
											</li>
										</ul>
										<!-- <input type="button" class="ibx1" value="ID duplication check"> -->
									</li>
									<li>
										<label for="pw">비밀번호</label>
										<ul>
											<li><input type="password" class="itx int1" name="user_pwd" id="user_pwd" value=""></li>
										</ul>
									</li>
									<li>
										<label>성별 / 생년월일</label>
										<ul class="d-type">
											<li><input type="radio" name="user_sex" id="man" value="M" <?=$user_sex=="M"?"checked":""?>> <label for="man">남성</label></li>
											<li><input type="radio" name="user_sex" id="woman" value="F" <?=$user_sex=="F"?"checked":""?>> <label for="woman">여성</label></li>
											<li class="dob first">
											<input type="text" class="itx int1" name="user_birth" id="datepicker" value="<?=$user_birth?>">
											<!--
												<select class="selec1 int2" name="user_birth">
													<option value="">Year</option>
													<?for($i=date("Y");$i > 1900 ;$i--) {?>
													<option value="<?=$i?>"><?=$i?></option>
													<?}?>
												</select> -->
											</li><!--
											<li class="dob">
												<select class="selec1 int2">
													<option>Month</option>
												</select>
											</li>
											<li class="dob">
												<select class="selec1 int2">
													<option>Day</option>
												</select>
											</li> -->
										</ul>
									</li>
									<li>
										<label for="user_hp">연락처</label>
										<ul>
											<li><input type="text" class="itx int3" name="user_hp" id="user_hp" value="<?=$user_hp?>"></li>
										</ul>
										<!-- <ul class="d-type">
											<li>
												<select class="selec1 int2">
													<option>Select</option>
												</select>
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int2">
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int2">
											</li>
										</ul> -->
									</li>
								</ul>
							</div>
						</article>
						<?if($grownup=="0") {?>
						<article>
							<div class="infoBox2">
								<h3>· 추가정보</h3>
								<ul class="inList">
									<li>
										<label for="p-name">보호자 성함</label>
										<ul>
											<li><input type="text" class="itx int1" name="parent_name" id="parent_name" value="<?=$parent_name?>"></li>
										</ul>
									</li>
									<li>
										<label for="p-contact">연락처</label>
										<ul>
											<li><input type="text" class="itx int3" name="parent_tel" id="parent_tel" value="<?=$parent_tel?>"></li>
										</ul>
										<!-- <ul class="d-type">
											<li>
												<select class="selec1 int2">
													<option>Select</option>
												</select>
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int2">
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int2">
											</li>
										</ul> -->
									</li>
								</ul>
							</div>
						</article>
						<?}?>
						<article>
							<div class="infoBox2">
								<ul class="inList">
									<li>
										<label for="user_email">이메일</label>
										<ul>
											<li><input type="text" class="itx int3" name="user_email" id="user_email" value="<?=$user_email?>"></li>
										</ul>
									</li>
									<li>
										<label for="home-addr">주소</label>
										<ul class="d-type-addr">
											<li>
												<input type="text" class="itx int2" name="zipcode" id="zipcode" value="<?=$zipcode?>" placeholder="ZIP/Postal Code">
											</li>
											<li>
												<input type="text" class="itx int4" name="addr1" id="addr1" value="<?=$addr1?>" placeholder="State/Province/County">
											</li>
											<li>
												<input type="text" class="itx int4" name="addr2" id="addr2" value="<?=$addr2?>" placeholder="City">
											</li>
											<li>
												<input type="text" class="itx int4" name="addr3" id="addr3" value="<?=$addr3?>" placeholder="Address">
												<!-- <input type="button" class="ibx2" name="home-addr" id="home-addr" value="Search address"> -->
											</li>
										</ul>
									</li>
								</ul>

							</div>
						</article>

						<div class="btn-area">
							<a href="javascript:;" id="join_submit" class="btn-c btn-complete">회원정보수정</a>
							<a href="javascript:history.go(-1);" class="btn-c btn-cancel ml25">취소</a>
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
