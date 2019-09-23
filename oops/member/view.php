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
	if ($gubun == "") { $gubun  = "view" ;}

	//기존데이터 수정인경우
	if ($gubun  == "view") {
		//테이블에서 글을 가져옵니다.
		$query = "select * from ".$initial."_".$_t." where user_id='".$user_id."'";
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

	}

	$popup = "1";
	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>

<script language=JavaScript>
<!--
//-->
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
							<?=$user_code?>
							</div>

						</div>
						<div class="form-group">
						  <label for="user_id">아이디</label>

							<input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>">
							<div class="form-group has-success">
								<label class="control-label" for="user_id">
								<h3 class="profile-username"><?=$user_id?></h3>
								</label>
							</div>
						</div>
						<div class="form-group">
						  <label for="email">이메일</label>
						  <div class="input-group">
							<?=$user_email?>
						  </div>
						</div>
						<div class="form-group">
						  <label for="site_kind">사이트 회원구분</label>
						  <div class="input-group">
						   <?if(preg_match("/ko/i", $site_kind)) {?><b class="label label-warning">국문</b> <?}?>
						   <?if(preg_match("/en/i", $site_kind)) {?><b class="label label-success">영문</b> <?}?>
						  </div>
						</div>
						<!-- <div class="form-group">
						  <label for="site_kind1">온/오프라인 회원구분</label>
						  <div class="input-group">
						   <?if(preg_match("/on/i", $site_kind)) {?> <b class="label label-warning">온라인</b> <?}?>
						   <?if(preg_match("/off/i", $site_kind)) {?><br><b class="label label-success">오프라인</b> <?}?>
						  </div>
						</div> -->
						<div class="form-group">
						  <label for="user_name">이름</label>
						  <div class="input-group">
							<?=$user_name?>
						  </div>
						</div>
						<div class="form-group">
							<label for="user_hp">휴대폰</label>
							<div class="input-group">
								<?=$user_hp?>
							</div>
						</div>
						<div class="form-group">
						  <label for="user_birth">생년월일</label>
							<div class="input-group">
								<?=$user_birth?>
							</div>
						</div>
						<div class="form-group">
						  <label for="user_calendar">음력/양력</label>
							<div class="input-group">
								<?=$user_calendar=="solar"?"양력":""?>
								<?=$user_calendar=="lunar"?"음력":""?>
							</div>
						</div>


						<div class="form-group">
						  <label for="user_sex">성별</label>
							<div class="input-group">
								<?=$user_sex=="M"?"남자":""?>
								<?=$user_sex=="F"?"여자":""?>
							</div>
						</div>
						<div class="form-group">
						  <label for="zipcode">주소</label>
						  <div class="row">
							<div class="col-xs-3">
								우 <?=$zipcode?>
							</div>
							<div class=" col-xs-12">
							  <?=$addr1?>
							</div>
							<div class=" col-xs-12">
							  <?=$addr2?>
							</div>
							<div class=" col-xs-12">
							  <?=$addr3?>
							</div>
						  </div>
						</div>

						<div class="form-group">
						  <label for="user_state">상태</label>
							<div class="input-group">
							  <?=$user_state=="0"?"해지":""?>
							  <?=$user_state=="1"?"승인":""?>
							  <?=$user_state=="2"?"가입신청":""?>
							</div>
						</div>
						<!-- <div class="form-group">
						  <label for="email_flag">이메일수신여부</label>
							<div class="input-group">
							  <?=$email_flag=="Y"?"허용":""?>
							  <?=$email_flag=="N"?"거부":""?>
							</div>
						</div>
						<div class="form-group">
						  <label for="sms_flag">SMS수신여부</label>
							<div class="input-group">
							  <?=$sms_flag=="Y"?"허용":""?>
							  <?=$sms_flag=="N"?"거부":""?>
							</div>
						</div>
						<div class="form-group">
						  <label for="position">직위</label>
							<div class="input-group">
								<?=getCodeNameDB("code_position", $position, $dbconn)?>
							</div>
						</div>
						<div class="form-group">
						  <label for="department">부서</label>
							<div class="input-group">
							  <?=$department?>
							</div>
						</div>
						<div class="form-group">
						  <label for="user_name">직무분야</label>
							<div class="input-group">
							  <?=$duty?>
							</div>
						</div> -->


					</div>
					<div class="box-footer">
					<?if($popup=="1") {?>
						<button type="button" class="btn btn-default" onclick="self.close()">닫기</button>
					<?} else {?>
						<button type="button" class="btn btn-default" onclick="fn_cancel()">취소</button>
					<?}?>
						<!-- <button type="button" class="btn btn-primary pull-right" onclick="fn_edit('<?=$idx?>')">수정</button> -->
					</div>
				</div>

			</div>
			<!-- .col-md-6-->


			<!-- <div class="col-md-6">
				<div class="box box-success">
					<div class="box-header with-border">
					  <h3 class="box-title">회사 정보 </h3>
					  <input type="hidden" name="client_code" value="<?=$client_code?>" />
					  <input type="hidden" name="client_name" value="<?=$client_name?>" />
					</div>
					<div class="box-body">

						<div class="form-group">
							<label for="client_tel">회사 연락처</label>
							<div class="input-group">
								<?=$client_tel?>
							</div>
						</div>

						<div class="form-group">
						  <label for="client_zipcode">회사주소</label>
						  <div class="row">
							<div class="col-xs-3">

								우 <?=$client_zipcode?>
							</div>
							<div class=" col-xs-12">
							  <?=$client_addr1?>
							</div>
							<div class=" col-xs-12">
							  <?=$client_addr2?>
							</div>
							<div class=" col-xs-12">
							  <?=$client_addr3?>
							</div>
						  </div>
						</div>
						<div class="form-group">
						  <label for="edu_charge_department">담당자 부서</label>
							<div class="input-group">
								<?=$edu_charge_department?>
							</div>
						</div>
						<div class="form-group">
							<label for="edu_charge_tel">담당자 연락처</label>
							<div class="input-group">
								<?=$edu_charge_tel?>
							</div>
						</div>

					</div>
					<div class="box-footer">
					<?if($popup=="1") {?>
						<button type="button" class="btn btn-default" onclick="self.close()">닫기</button>
					<?} else {?>
						<button type="button" class="btn btn-default" onclick="fn_cancel()">취소</button>
					<?}?>
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