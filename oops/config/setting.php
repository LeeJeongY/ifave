<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl	= "site_config"; 							//테이블 이름
	$foldername = "../../$upload_dir/$tbl/";
	$foldername_download = "../$upload_dir/$tbl/";


	//신규등록인 경우 ============================
	if ($gubun == "") { $gubun  = "insert";}

	$query = "SELECT * FROM ".$initial."_".$tbl." WHERE idx IS NOT NULL ";
	if($idx) $query .= " AND idx='$idx'";
	$query .= " ORDER BY idx DESC LIMIT 1";
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array = mysql_fetch_array($result)) {
		$idx                     	= $array[idx];
		$site_name               	= $array[site_name];
		$site_tel                	= $array[site_tel];
		$site_fax                	= $array[site_fax];
		$site_zipcode            	= $array[site_zipcode];
		$site_addr1              	= $array[site_addr1];
		$site_addr2              	= $array[site_addr2];
		$site_addr3              	= $array[site_addr3];
		$site_biznum             	= $array[site_biznum];
		$site_ceo                	= $array[site_ceo];
		$html_title              	= $array[html_title];
		$html_description        	= $array[html_description];
		$html_author             	= $array[html_author];
		$naver_site_verification 	= $array[naver_site_verification];
		$google_site_verification	= $array[google_site_verification];
		$admin_title             	= $array[admin_title];
		$admin_name              	= $array[admin_name];
		$admin_email             	= $array[admin_email];
		$admin_hp                	= $array[admin_hp];
		$image_logo              	= $array[image_logo];
		$admin_home_dir          	= $array[admin_home_dir];
		$upload_home_dir         	= $array[upload_home_dir];
		$new_button_day_conf     	= $array[new_button_day_conf];
		$data_go_kr_skey         	= $array[data_go_kr_skey];
		$naver_cid               	= $array[naver_cid];
		$naver_csecret           	= $array[naver_csecret];
		$daum_api_key            	= $array[daum_api_key];
		$sns_naverblog           	= $array[sns_naverblog];
		$sns_kakaotalk           	= $array[sns_kakaotalk];
		$sns_google              	= $array[sns_google];
		$sns_facebook            	= $array[sns_facebook];
		$sns_instagram            	= $array[sns_instagram];
		$sns_tweet               	= $array[sns_tweet];
		$contents                	= $array[contents];
		$regdate                 	= $array[regdate];
		$upddate                 	= $array[upddate];



		list($site_tel1,$site_tel2,$site_tel3)			= explode("-",$site_tel);
		list($site_fax1,$site_fax2,$site_fax3)			= explode("-",$site_fax);
		list($admin_hp1,$admin_hp2,$admin_hp3)			= explode("-",$admin_hp);
		list($site_biznum1,$site_biznum2,$site_biznum3) = explode("-",$site_biznum);

		$gubun  = "update";
	}

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>
<script>
<!--
function fn_submit() {
	if($.trim($('#site_name').val()) == ''){
		alert("사이트명을 입력하세요.");
		$('#site_name').focus();
		return false;
	}
	if($.trim($('#site_tel1').val()) == '' || $.trim($('#site_tel2').val()) == '' || $.trim($('#site_tel3').val()) == ''){
		alert("연락처를 입력하세요.");
		$('#site_tel1').focus();
		return false;
	}
	if($.trim($('#html_title').val()) == ''){
		alert("제목을 입력하세요.");
		$('#html_title').focus();
		return false;
	}
	if($.trim($('#admin_name').val()) == ''){
		alert("담당자명을 입력하세요.");
		$('#admin_name').focus();
		return false;
	}
	if($.trim($('#admin_email').val()) == ''){
		alert("담당자 이메일을 입력하세요.");
		$('#admin_email').focus();
		return false;
	}
	$("#fm").attr("target", "_self");
	$("#fm").attr("method", "post");
	$("#fm").attr("action", "write_ok.php");
}
//-->
</script>

<form name="form">
<input type="hidden" name="idx">
<input type="hidden" name="gubun">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>


  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup-":""?>content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        사이트정보 설정
        <small>사이트 정보 설정</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 운영관리</a></li>
        <li class="active"> 사이트정보 설정</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->

		<div class="row">
		<!-- left column -->

			<!-- <div class="col-md-6">
			</div>

			-->

	        <div class="col-md-12">

				<div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title">Form</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form role="form" name="fm" id="fm" enctype="multipart/form-data" onSubmit="return fn_submit()">
					<input type="hidden" name="page" value='<?=$page?>'>
					<input type="hidden" name="idx" value='<?=$idx?>'>
					<input type="hidden" name="gubun" value='<?=$gubun?>'>
					<input type="hidden" name="popup" value='<?=$popup?>'>
					<input type="hidden" name="setting" value='Y'>
					<div class="box-body">
						<div class="form-group">
						  <label for="site_name">사이트명</label>
						  <input type="text" class="form-control" name="site_name" id="site_name" value="<?=$site_name?>" placeholder="사이트명" required>
						</div>
						<div class="form-group">
						  <label for="site_tel">연락처</label>
						  <div class="row">
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="site_tel1" id="site_tel1" value="<?=$site_tel1?>" placeholder="">
							  </div>
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="site_tel2" id="site_tel2" value="<?=$site_tel2?>" placeholder="">
							  </div>
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="site_tel3" id="site_tel3" value="<?=$site_tel3?>" placeholder="">
							  </div>
						  </div>
						</div>
						<div class="form-group">
						  <label for="site_fax">팩스</label>
						  <div class="row">
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="site_fax1" id="site_fax1" value="<?=$site_fax1?>" placeholder="">
							  </div>
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="site_fax2" id="site_fax2" value="<?=$site_fax2?>" placeholder="">
							  </div>
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="site_fax3" id="site_fax3" value="<?=$site_fax3?>" placeholder="">
							  </div>
						  </div>
						</div>
						<div class="form-group">
						  <label for="address">주소</label>
						  <div class="row">
							<div class="col-xs-3">

								<div class="input-group input-group-sm">

									<input type="text" class="form-control" name="zipcode" id="zipcode" value="<?=$site_zipcode?>" placeholder="우편번호">
									<span class="input-group-btn">
									  <a type="button" class="btn btn-info btn-flat" href="javascript:_address('h')">찾기</a>
									</span>
								</div>


							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="addr1" id="addr1" value="<?=$site_addr1?>" placeholder="">
							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="addr2" id="addr2" value="<?=$site_addr2?>" placeholder="">
							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="addr3" id="addr3" value="<?=$site_addr3?>" placeholder="">
							</div>
						  </div>
						</div>

						<div class="form-group">
						  <label for="site_biznum">사업자등록번호</label>
						  <div class="row">
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="site_biznum1" id="site_biznum1" value="<?=$site_biznum1?>" placeholder="">
							  </div>
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="site_biznum2" id="site_biznum2" value="<?=$site_biznum2?>" placeholder="">
							  </div>
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="site_biznum3" id="site_biznum3" value="<?=$site_biznum3?>" placeholder="">
							  </div>
						  </div>
						</div>
						<div class="form-group">
						  <label for="site_ceo">대표자명</label>
						  <input type="text" class="form-control" name="site_ceo" id="site_ceo" value="<?=$site_ceo?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="html_title">제목</label>
						  <input type="text" class="form-control" name="html_title" id="html_title" value="<?=$html_title?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="html_description">설명</label>
						  <input type="email" class="form-control" name="html_description" id="html_description" value="<?=$html_description?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="html_author">저작자</label>
						  <input type="text" class="form-control" name="html_author" id="html_author" value="<?=$html_author?>" placeholder="" required>
						</div>
						<div class="form-group">
						  <label for="naver_site_verification">naver-site-verification</label>
						  <input type="text" class="form-control" name="naver_site_verification" id="naver_site_verification" value="<?=$naver_site_verification?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="google_site_verification">google-site-verification</label>
						  <input type="text" class="form-control" name="google_site_verification" id="google_site_verification" value="<?=$google_site_verification?>" placeholder="">
						</div>

						<div class="form-group">
						  <label for="admin_title">관리자 제목</label>
						  <input type="text" class="form-control" name="admin_title" id="admin_title" value="<?=$admin_title?>" placeholder="">
						</div>

						<div class="form-group">
						  <label for="admin_name">담당자</label>
						  <input type="text" class="form-control" name="admin_name" id="admin_name" value="<?=$admin_name?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="admin_email">담당자 이메일</label>
						  <input type="text" class="form-control" name="admin_email" id="admin_email" value="<?=$admin_email?>" placeholder="">
						</div>

						<div class="form-group">
						  <label for="admin_hp">담당자 휴대폰</label>
						  <div class="row">
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="admin_hp1" id="admin_hp1" value="<?=$admin_hp1?>" placeholder="">
							  </div>
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="admin_hp2" id="admin_hp2" value="<?=$admin_hp2?>" placeholder="">
							  </div>
							  <div class="col-xs-4">
							  <input type="text" class="form-control" name="admin_hp3" id="admin_hp3" value="<?=$admin_hp3?>" placeholder="">
							  </div>
						  </div>
						</div>
						<div class="form-group">
						  <label for="image_logo">로고</label>
						  <input type="file" class="form-control" name="image_logo" id="image_logo" value="">
							<?
							if($image_logo!="") {
								?>
								  <p class="help-block"><i class="fa fa-download"></i> <a href="../../common/download.php?fl=<?=$foldername_download?>&fi=<?=$image_logo?>"><?=$image_logo?></a> <input type="checkbox" name="img_file_chk" id="img_file_chk" value="Y"  class="flat-red"> 삭제</p>
								<?
							}
							?>
						</div>
						<div class="form-group">
						  <label for="admin_home_dir">관리자 홈디렉토리</label>
						  <input type="text" class="form-control" name="admin_home_dir" id="admin_home_dir" value="<?=$admin_home_dir?>" placeholder="">
						</div>

						<div class="form-group">
						  <label for="upload_home_dir">업로드 홈디렉토리</label>
						  <input type="text" class="form-control" name="upload_home_dir" id="upload_home_dir" value="<?=$upload_home_dir?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="new_button_day_conf">NEW 버튼 노출시간(단위:일)</label>
						  <input type="text" class="form-control" name="new_button_day_conf" id="new_button_day_conf" value="<?=$new_button_day_conf?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="data_go_kr_skey">공공데이터 서비스키(data.go.kr)</label>
						  <input type="text" class="form-control" name="data_go_kr_skey" id="data_go_kr_skey" value="<?=$data_go_kr_skey?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="naver_cid">네이버 API ID</label>
						  <input type="text" class="form-control" name="naver_cid" id="naver_cid" value="<?=$naver_cid?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="naver_csecret">네이버 API secret</label>
						  <input type="text" class="form-control" name="naver_csecret" id="naver_csecret" value="<?=$naver_csecret?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="daum_api_key">다음 API KEY</label>
						  <input type="text" class="form-control" name="daum_api_key" id="daum_api_key" value="<?=$daum_api_key?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="sns_naverblog">네이버 블로그</label>
						  <input type="text" class="form-control" name="sns_naverblog" id="sns_naverblog" value="<?=$sns_naverblog?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="sns_kakaotalk">카카오톡</label>
						  <input type="text" class="form-control" name="sns_kakaotalk" id="sns_kakaotalk" value="<?=$sns_kakaotalk?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="sns_google">구글</label>
						  <input type="text" class="form-control" name="sns_google" id="sns_google" value="<?=$sns_google?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="sns_facebook">페이스북</label>
						  <input type="text" class="form-control" name="sns_facebook" id="sns_facebook" value="<?=$sns_facebook?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="sns_instagram">인스타그램</label>
						  <input type="text" class="form-control" name="sns_instagram" id="sns_instagram" value="<?=$sns_instagram?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="sns_tweet">트위트</label>
						  <input type="text" class="form-control" name="sns_tweet" id="sns_tweet" value="<?=$sns_tweet?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="contents">기타내용</label>

							<div class="box-body pad">
								<textarea class="textarea" name="contents" id="contents" placeholder="" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?=$contents?></textarea>
							</div>
						</div>

					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<button type="button" class="btn btn-default" onclick="fn_cancel()">취소</button>
						<button type="submit" class="btn btn-primary pull-right">확인</button>
					</div>
					</form>
				</div>
				<!-- /.box -->
			</div>
		</div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?
include "../inc/footer.php";
mysql_close($dbconn);
?>