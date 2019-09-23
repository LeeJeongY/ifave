<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t=="") $_t	= "members"; 							//테이블 이름
	$foldername = "../../$upload_dir/$_t/";

	//신규등록인 경우 ============================
	if ($gubun == "") { $gubun  = "insert" ;}

	//기존데이터 수정인경우
	if ($gubun  == "update") {
		//테이블에서 글을 가져옵니다.
		$query = "select * from ".$initial."_".$_t." where idx='$idx'"; // 글 번호를 가지고 조회를 합니다.
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
		//등록인 경우
		$site_kind	= "ko";
		$remark		= "";


	}

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>

<script language=JavaScript>
<!--
function fn_submit() {
	if($.trim($('#user_id').val()) == ''){
		alert("아이디를 입력하세요.");
		$('#user_id').focus();
		return false;
	}
	<?if($idx == "") {?>
	if($.trim($('#user_pwd').val()) == ''){
		alert("비밀번호를 입력하세요.");
		$('#userpwd').focus();
		return false;
	}
	if($.trim($('#user_pwd2').val()) == ''){
		alert("비밀번호확인을 다시 해 주세요.");
		$('#userpwd2').focus();
		return false;
	}
	if($.trim($('#user_pwd').val()) != $.trim($('#user_pwd2').val())){
		alert("비밀번호를 동일하지 않습니다.");
		$('#user_pwd2').focus();
		return false;
	}
	<?}?>

	$("#fm").attr("target", "_self");
	$("#fm").attr("method", "post");
	$("#fm").attr("action", "write_ok.php");

}

$(document).ready(function(){
	if($('#user_id').val().length>=4){
		$('#user_id').keypress(function(){
			var id = $('#user_id').val();
			alert(id);
			$.ajax({
				type : 'GET',
				url : 'write_ok.php',
				data : {'user_id':id,'gubun':'idcheck'},
				success : function(data){
					console.log(data);
				}
			});
		});
	} else {
	}
});


$(document).ready(function(){
var checkAjaxSetTimeout;
    $('#user_id').keyup(function(){
        clearTimeout(checkAjaxSetTimeout);
        checkAjaxSetTimeout = setTimeout(function() {

			if ($('#user_id').val().length >= 4) {
				var id = $('#user_id').val();

				// ajax 실행
				$.ajax({
					type : 'POST',
					url : 'write_ok.php',
					data : {'user_id':id,'gubun':'idcheck'},
					success : function(data) {
						if (data == "ok") {
							$("#idcheck").html("<span style='color:#0066cc;'>사용 가능한 아이디 입니다.</span>");
						} else {
							$("#idcheck").html("<span style='color:#FF3300;'>사용 중인 아이디 입니다.</span>");
						}
					}
				}); // end ajax
			}

		},500); //end setTimeout

    }); // end keyup
});


function fn_user_code() {

	document.fm.gubun.value = "recode";
	document.fm.target = "_progress";
	document.fm.action = "write_ok.php";
	document.fm.submit();
}
//-->

function client_search(){

	w=700;
	h=900;

	width=screen.width;
	height=screen.height;

	 x=(width/2)-(w/2);
	 y=(height/2)-(h/2);

	window.open("../client/popup_client_search.php?popup=1&search_type=client_search","client_search", "resizable=yes,top="+y+",left="+x+",width="+w+",height="+h+",scrollbars=no");

}// end function

$(function() {
	$( "#datepicker1" ).datepicker({
		 format: "yyyy-mm-dd",
		 language: "kr",autoclose: true
	});
});

</script>

<form name="form">
<input type="hidden" name="idx">
<input type="hidden" name="gubun">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup":"content"?>-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        일반회원 관리
        <small>전체 일반회원정보입니다.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 회원관리</a></li>
        <li class="active">일반회원 관리</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->

		<div class="row">
		<!-- left column -->

			<!-- <div class="col-md-6">
			</div>

	        <div class="col-md-6">
			</div>
			-->

			<form role="form" method="post" name="fm" id="fm" enctype="multipart/form-data" onSubmit="return fn_submit()">
			<input type="hidden" name="page" value='<?=$page?>'>
			<input type="hidden" name="idx" value='<?=$idx?>'>
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="gubun" value='<?=$gubun?>'>
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="search" value='<?=$search?>'>
			<input type="hidden" name="search_text" value='<?=$search_text?>'>
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
			<input type="hidden" name="menu_t" value="<?=$menu_t?>">

			<div class="col-md-12">


				<div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title">기본정보</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<div class="box-body">
						<div class="form-group">
						  <label for="user_code">회원코드</label>
							<div class="input-group">
						<?php if(strlen(trim($user_code)) == 0){?>

								<input type="text" name="user_code" id="user_code" value="<?=$user_code?>" class="form-control" placeholder="코드값을 입력하지 않을 경우 자동생성됩니다.">

								<span class="input-group-btn">
								  <button type="button" class="btn btn-info btn-flat" onclick="fn_user_code()">코드 자동불러오기</button>
								</span>
						<?}else{?>
							<?=$user_code?>
						<?}?>

							</div>

						</div>
						<div class="form-group">
						  <label for="user_id">아이디</label>

							<?if($user_id == "") {?>
							<input type="text" name="user_id" id="user_id" value="<?=$user_id?>" class="form-control" placeholder="4~8자 영문숫자조합으로 입력하세요">
							<div id="idcheck"></div>
							<?} else {?>
							<input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>">
							<div class="form-group has-success">
								<label class="control-label" for="user_id">
								<h3 class="profile-username"><?=$user_id?></h3>
								</label>
							</div>

							<?}?>
						</div>
						<div class="form-group">
						  <label for="user_pwd">비밀번호</label>
						  <input type="password" class="form-control" name="user_pwd" id="user_pwd" placeholder="4~10자 비밀번호를 입력">
							<?if($user_id != "") {?>
							<br>&nbsp;&nbsp;&nbsp;<font color="red">비밀번호 입력시 입력된 비밀번호로 변경됩니다.</font>
							<?}?>
						</div>
						<?if($user_id == "") {?>
						<div class="form-group">
						  <label for="user_pwd2">비밀번호 확인</label>
						  <input type="password" class="form-control" name="user_pwd2" id="user_pwd2" placeholder="다시 한번 비밀번호를 입력해주세요">
						</div>
						<?}?>
						<div class="form-group">
						  <label for="email">이메일</label>
						  <div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
							<input type="email" class="form-control" name="user_email" id="user_email" value="<?=$user_email?>" placeholder="Email" >
						  </div>
						</div>
						<!-- <div class="form-group">
						  <label for="site_kind1">온/오프라인 회원구분</label>
						  <div class="checkbox">
							<label>
							<input type="checkbox" name="site_kind[]" id="site_kind1" class="flat-red" value="on" <?if(preg_match("/on/i", $site_kind)) {?> checked<?}?>> 온라인회원
							</label>
							<label>
							<input type="checkbox" name="site_kind[]" id="site_kind2" class="flat-red" value="off" <?if(preg_match("/off/i", $site_kind)) {?> checked<?}?>> 오프라인회원
							</label>
						  </div>
						</div> -->
						<div class="form-group">
						  <label for="site_kind">사이트 회원구분</label>
						  <div class="radio">
							<label>
							<input type="radio" name="site_kind" id="site_kind1" class="flat-red" value="ko" <?if(preg_match("/ko/i", $site_kind)) {?> checked<?}?>> 국문
							</label>
							<label>
							<input type="radio" name="site_kind" id="site_kind2" class="flat-red" value="en" <?if(preg_match("/en/i", $site_kind)) {?> checked<?}?>> 영문
							</label>
						  </div>
						</div>
						<div class="form-group">
						  <label for="user_name">이름</label>
						  <input type="text" class="form-control" name="user_name" id="user_name" value="<?=$user_name?>" placeholder="">
						</div>
						<div class="form-group">
							<label for="user_hp">휴대폰</label>
							<div class="input-group">
								<div class="input-group-addon">
								<i class="fa fa-phone"></i>
								</div>
								<input type="text" class="form-control" name="user_hp" id="user_hp" value="<?=$user_hp?>" placeholder="" data-inputmask='"mask": "999-9999-9999"' data-mask >
							</div>
						</div>
						<div class="form-group">
						  <label for="user_birth">생년월일</label>
							<div class="input-group date" data-provide="datepicker" id="datepicker1">
								<input type="text" class="form-control" name="user_birth" value="<?=$user_birth?>">
								<div class="input-group-addon">
									<span class="glyphicon glyphicon-th"></span>
								</div>
							</div>
						</div>
						<div class="form-group">
						  <label for="user_calendar">음력/양력</label>
						  <div class="radio">
							<label>
							<input type="radio" name="user_calendar" id="user_calendar" class="flat-red" value="solar" <?=$user_calendar=="solar"?"checked":""?>> 양력
							</label>
							<label>
							<input type="radio" name="user_calendar" id="user_calendar" class="flat-red" value="lunar" <?=$user_calendar=="lunar"?"checked":""?>> 음력
							</label>
						  </div>
						</div>


						<div class="form-group">
						  <label for="user_sex">성별</label>
						  <div class="radio">
							<label>
							<input type="radio" name="user_sex" id="user_sex" class="flat-red" value="M" <?=$user_sex=="M"?"checked":""?>> 남자
							</label>
							<label>
							<input type="radio" name="user_sex" id="user_sex" class="flat-red" value="F" <?=$user_sex=="F"?"checked":""?>> 여자
							</label>
						  </div>
						</div>
						<div class="form-group">
						  <label for="zipcode">주소</label>
						  <div class="row">
							<div class="col-xs-3">

								<div class="input-group input-group-sm">

									<input type="text" class="form-control" name="zipcode" id="zipcode" value="<?=$zipcode?>" placeholder="우편번호" readonly>
									<span class="input-group-btn">
									  <a type="button" class="btn btn-info btn-flat" href="javascript:_address('h')">찾기</a>
									</span>
								</div>

							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="addr1" id="addr1" value="<?=$addr1?>" placeholder="">
							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="addr2" id="addr2" value="<?=$addr2?>" placeholder="">
							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="addr3" id="addr3" value="<?=$addr3?>" placeholder="">
							</div>
						  </div>
						</div>


	<!--
						<div class="form-group">
						  <label for="email_flag">이메일수신여부</label>
						  <div class="radio">
							<label>
							<input type="radio" name="email_flag" id="email_flag" class="flat-red" value="Y" <?=$email_flag=="Y"?"checked":""?>> 허용
							</label>
							<label>
							<input type="radio" name="email_flag" id="email_flag" class="flat-red" value="N" <?=$email_flag=="N"?"checked":""?>> 거부
							</label>
						  </div>
						</div>
						<div class="form-group">
						  <label for="sms_flag">SMS수신여부</label>
						  <div class="radio">
							<label>
							<input type="radio" name="sms_flag" id="sms_flag" class="flat-red" value="Y" <?=$sms_flag=="Y"?"checked":""?>> 허용
							</label>
							<label>
							<input type="radio" name="sms_flag" id="sms_flag" class="flat-red" value="N" <?=$sms_flag=="N"?"checked":""?>> 거부
							</label>
						  </div>
						</div> -->
						<div class="form-group">
						  <label for="user_state">상태</label>
						  <div class="radio">
							<label>
							<input type="radio" name="user_state" id="user_state" class="flat-red" value="0" <?=$user_state=="0"?"checked":""?>> 해지
							</label>
							<label>
							<input type="radio" name="user_state" id="user_state" class="flat-red" value="1" <?=$user_state=="1"?"checked":""?>> 승인
							</label>
							<label>
							<input type="radio" name="user_state" id="user_state" class="flat-red" value="2" <?=$user_state=="2"?"checked":""?>> 가입신청
							</label>
						  </div>
						</div>
						<!-- <div class="form-group">
						  <label for="position">직위</label>
							<div class="input-group">
							<?
							//코드값 정의
							$code_type = "code_position";

							$que = "select * from ".$initial."_code_kindcode where kind_idx is not null "; 				// SQL 쿼리문
							$que .= " and kind_code='".$code_type."'";
							$rs = mysql_query($que, $dbconn);
							if ($arr=mysql_fetch_array($rs)) {
								$rot_num += 1;
								$kind_idx		= $arr[kind_idx];
								$kind_code		= $arr[kind_code];
								$kind_name		= db2html($arr[kind_name]);	  //이름
							}
							?>
							<?=getCodeNameBoxDB($code_type, $position, "combobox", "position", $dbconn)?>
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info btn-flat" onclick="go_code_add('<?=$kind_code?>', '<?=$kind_name?>')">추가</button>
								</span>
							</div>
						</div>
						<div class="form-group">
						  <label for="department">부서</label>
						  <input type="text" class="form-control" name="department" id="department" value="<?=$department?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="user_name">직무분야</label>
						  <input type="text" class="form-control" name="duty" id="duty" value="<?=$duty?>" placeholder="">
						</div> -->


					</div>
					<div class="box-footer">
						<button type="button" class="btn btn-default" onclick="fn_cancel()">취소</button>
						<button type="submit" class="btn btn-primary pull-right">확인</button>
					</div>
				</div>

			</div>
			<!-- .col-md-12-->


			<!-- <div class="col-md-6">
			<div class="box box-success">
				<div class="box-header with-border">
				  <h3 class="box-title">회사 정보 <a type="button" class="btn btn-info btn-flat" href="javascript:client_search()">회사 찾기</a></h3>
				  <input type="hidden" name="client_code" value="<?=$client_code?>" />
				  <input type="hidden" name="client_name" value="<?=$client_name?>" />
				</div>
				<div class="box-body">

					<div class="form-group">
						<label for="client_tel">회사 연락처</label>
						<div class="input-group">
							<div class="input-group-addon">
							<i class="fa fa-phone"></i>
							</div>
							<input type="text" class="form-control" name="client_tel" id="client_tel" value="<?=$client_tel?>" placeholder="">
						</div>
					</div>

					<div class="form-group">
					  <label for="client_zipcode">회사주소</label>
					  <div class="row">
						<div class="col-xs-3">

							<div class="input-group input-group-sm">

								<input type="text" class="form-control" name="client_zipcode" id="client_zipcode" value="<?=$client_zipcode?>" placeholder="우편번호" readonly>
								<span class="input-group-btn">
								  <a type="button" class="btn btn-info btn-flat" href="javascript:_address('c')">찾기</a>
								</span>
							</div>

						</div>
						<div class=" col-xs-12">
						  <input type="text" class="form-control" name="client_addr1" id="client_addr1" value="<?=$client_addr1?>" placeholder="">
						</div>
						<div class=" col-xs-12">
						  <input type="text" class="form-control" name="client_addr2" id="client_addr2" value="<?=$client_addr2?>" placeholder="">
						</div>
						<div class=" col-xs-12">
						  <input type="text" class="form-control" name="client_addr3" id="client_addr3" value="<?=$client_addr3?>" placeholder="">
						</div>
					  </div>
					</div>
					<div class="form-group">
					  <label for="edu_charge_department">담당자 부서</label>
					  <input type="text" class="form-control" name="edu_charge_department" id="edu_charge_department" value="<?=$edu_charge_department?>" placeholder="">
					</div>
					<div class="form-group">
						<label for="edu_charge_tel">담당자 연락처</label>
						<div class="input-group">
							<div class="input-group-addon">
							<i class="fa fa-phone"></i>
							</div>
							<input type="text" class="form-control" name="edu_charge_tel" id="edu_charge_tel" value="<?=$edu_charge_tel?>" placeholder="">
						</div>
					</div>
				</div>
				<div class="box-footer">
					<button type="button" class="btn btn-default" onclick="fn_cancel()">취소</button>
					<button type="submit" class="btn btn-primary pull-right">확인</button>
				</div>
			</div>
			</div> -->
			</form>
		</div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

	<iframe id="_progress" name="_progress" width="0" height="0"></iframe>
<?
include "../inc/footer.php";
mysql_close($dbconn);
?>