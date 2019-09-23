<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";


	//게시판 목록보기에 필요한 각종 변수 초기값을 설정합니다.
	if($_t == "") $_t	= "master"; 				//테이블 이름
	$foldername  = "../$upload_dir/$_t/";

	if ($gubun == "") {
		$gubun = "insert";
	}

	//게시판 카테고리 여부
	$cate = getBoardInfoDB($_t, "cate", $dbconn);

	if ($idx) {
		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";

		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx			= $array[idx];
			$use_flag		= stripslashes($array[use_flag]);
			$bbs_id			= db2html(stripslashes($array[bbs_id]));
			$bbs_name		= db2html(stripslashes($array[bbs_name]));
			$bbs_title		= db2html(stripslashes($array[bbs_title]));
			$bbs_type		= $array[bbs_type];
			$bbs_kind		= $array[bbs_kind];
			$cate_flag		= $array[cate_flag];
			$cate_code		= $array[cate_code];
			$cate_name		= getBigCodeNameDB($cate_code, $dbconn);
			$user_file		= $array[user_file];				//이미지
			$option_list	= stripslashes($array[option_list]);
			$use_grade		= stripslashes($array[use_grade]);
			$skill_list		= stripslashes($array[skill_list]);
			$target_send	= stripslashes($array[target_send]);
			$share_media	= stripslashes($array[share_media]);
			$item_close		= stripslashes($array[item_close]);
			$img_flag		= stripslashes($array[img_flag]);
			$file_flag		= stripslashes($array[file_flag]);
			$list_counts	= stripslashes($array[list_counts]);
			$counts			= $array[counts];					//조회수
			$signdate		= $array[signdate];					//작성일
			$signdate		= substr($signdate, 0, 10);
			if($signdate == "0000-00-00 00:00:00"){ $signdate = ""; }
		}
	} else {
		$use_flag = "1";
		$bbs_kind = "board";
		$bbs_type = "list";
		$cate_flag = "0";
		$use_grade = "9";
		$skill_list = "view";
	}

	include "../inc/header.php";
?>

<script language="javascript">
<!--
function fn_submit() {
	<?if($bbs_id=="") {?>
	if($.trim($('#bbs_id').val()) == ''){
		alert("아이디를 입력하세요.");
		$('#bbs_id').focus();
		return false;
	}
	<?}?>
	if($.trim($('#bbs_name').val()) == ''){
		alert("게시판명을 입력하세요.");
		$('#bbs_name').focus();
		return false;
	}
	if($.trim($('#bbs_name').val()) == ''){
		alert("게시판명을 입력하세요.");
		$('#bbs_name').focus();
		return false;
	}

	$("#fm").attr("target", "_self");
	$("#fm").attr("method", "post");
	$("#fm").attr("action", "write_ok.php");
}


$(document).ready(function(){
var checkAjaxSetTimeout;
    $('#bbs_id').keyup(function(){
        clearTimeout(checkAjaxSetTimeout);
        checkAjaxSetTimeout = setTimeout(function() {

			if ($('#bbs_id').val().length > 2) {
				var id = $('#bbs_id').val();
				// ajax 실행
				$.ajax({
					type : 'POST',
					url : 'write_ok.php',
					data : {'bbs_id':id,'gubun':'idcheck'},
					success : function(data) {

						console.log(data);

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


function go_codelist() {
	var	w = window.open('code_list.php?popup=1','code_list','width=500,height=500,scrollbars=1');
	w.focus();
}

//-->
</script>

<form name="form">
<input type="hidden" name="idx">
<input type="hidden" name="gubun">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup":"content"?>-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        게시판설정
        <small>게시판 환경설정을 할 수 있습니다.</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 운영관리</a></li>
        <li class="active">게시판설정</li>
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

			<div class="col-md-12">

			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title">Form</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form role="form" method="post" action="write_ok.php" name="fm" id="fm" enctype="multipart/form-data" onSubmit="return fn_submit()">
				<input type="hidden" name="gubun" value='<?=$gubun?>'>
				<input type="hidden" name="page" value='<?=$page?>'>
				<input type="hidden" name="idx" value='<?=$idx?>'>
				<input type="hidden" name="search" value="<?=$search?>">
				<input type="hidden" name="search_text" value="<?=$search_text?>">
				<input type="hidden" name="_t" value="<?=$_t?>">
				<input type="hidden" name="bbsidcheck" value="">
				<input type="hidden" name="menu_b" value="<?=$menu_b?>">
				<input type="hidden" name="menu_m" value="<?=$menu_m?>">
				<div class="box-body">
					<div class="form-group">
					  <label for="use_flag">사용여부</label>
					  <div class="radio">
						<label>
						<input type="radio" required="" name="use_flag" id="use_flag" value="1" <? echo $use_flag == "1"?"checked":"";?> class="flat-red"> 예
						</label>
						<label>
						<input type="radio" required="" name="use_flag" id="use_flag" value="0" <? echo $use_flag == "0"?"checked":"";?> class="flat-red"> 아니오
						</label>
					  </div>
					</div>

					<div class="form-group">
					  <label for="bbs_id">아이디</label>
					  <input type="text" class="form-control" name="bbs_id" id="bbs_id" value="<?=$bbs_id?>" placeholder="" required>
					  <div id="idcheck"></div>
					</div>

					<div class="form-group">
					  <label for="bbs_name">게시판명</label>
					  <input type="text" name="bbs_name" id="bbs_name" value="<?=$bbs_name?>" class="form-control" placeholder="">
					</div>
					<div class="form-group">
					  <label for="bbs_title">소개문구</label>
					  <input type="text" name="bbs_title" id="bbs_title" value="<?=$bbs_title?>" class="form-control" placeholder="">
					</div>


					<div class="form-group">
					  <label for="bbs_kind">종류</label>
					  <div class="radio">
						<label>
						<input type="radio" required="" name="bbs_kind" id="bbs_kind" value="board" <? echo $bbs_kind == "board"?"checked":"";?> class="flat-red"> 답변형
						</label>
						<label>
						<input type="radio" required="" name="bbs_kind" id="bbs_kind" value="data" <? echo $bbs_kind == "data"?"checked":"";?> class="flat-red"> 자료형
						</label>
						<label>
						<input type="radio" required="" name="bbs_kind" id="bbs_kind" value="gallery" <? echo $bbs_kind == "gallery"?"checked":"";?> class="flat-red"> 갤러리형
						</label>
						<label>
						<input type="radio" required="" name="bbs_kind" id="bbs_kind" value="inquiry" <? echo $bbs_kind == "inquiry"?"checked":"";?> class="flat-red"> 문의/요청형
						</label>
						<label>
						<input type="radio" required="" name="bbs_kind" id="bbs_kind" value="popup" <? echo $bbs_kind == "popup"?"checked":"";?> class="flat-red"> 팝업
						</label>
						<label>
						<input type="radio" required="" name="bbs_kind" id="bbs_kind" value="banner" <? echo $bbs_kind == "banner"?"checked":"";?> class="flat-red"> 배너
						</label>
					  </div>
					</div>

					<div class="form-group">
					  <label for="bbs_type">타입</label>
					  <div class="radio">
						<label>
						<input type="radio" required="" name="bbs_type" id="bbs_type" value="list" <? echo $bbs_type == "list"?"checked":"";?> class="flat-red"> 리스트형
						</label>
						<label>
						<input type="radio" required="" name="bbs_type" id="bbs_type" value="image" <? echo $bbs_type == "image"?"checked":"";?> class="flat-red"> 이미지형
						</label>
						<label>
						<input type="radio" required="" name="bbs_type" id="bbs_type" value="multi" <? echo $bbs_type == "multi"?"checked":"";?> class="flat-red"> 이미지+리스트형
						</label>
						<label>
						<input type="radio" required="" name="bbs_type" id="bbs_type" value="faq" <? echo $bbs_type == "faq"?"checked":"";?> class="flat-red"> FAQ형
						</label>
						<label>
						<input type="radio" required="" name="bbs_type" id="bbs_type" value="sns" <? echo $bbs_type == "sns"?"checked":"";?> class="flat-red"> SNS형
						</label>
					  </div>
					</div>

					<div class="form-group">
					  <label for="cate_flag">분류사용</label>
					  <div class="radio">
						<label>
						<input type="radio" required="" name="cate_flag" id="cate_flag" value="1" <? echo $cate_flag == "1"?"checked":"";?> class="flat-red"> 예
						</label>
						<label>
						<input type="radio" required="" name="cate_flag" id="cate_flag" value="0" <? echo $cate_flag == "0"?"checked":"";?> class="flat-red"> 아니오
						</label>
					  </div>
					</div>

					<div class="form-group">
					  <label for="cate_code">분류 코드</label>
					  <input type="hidden" name="cate_code" id="cate_code" value="<?=$cate_code?>">
						<div class="input-group">
							<input type="text" name="cate_name" id="cate_name" value="<?=$cate_name?>" class="form-control" placeholder="코드를 선택하세요">
							<span class="input-group-btn">
							  <button type="button" class="btn btn-info btn-flat" onclick="go_codelist()">찾아보기</button>
							</span>
						</div>
					</div>

					<div class="form-group">
					  <label for="user_file">타이틀 이미지</label>
					  <input type="file" class="form-control" name="user_file" id="user_file" value="">
						<?
						if($user_file!="") {
							?>
							  <p class="help-block"><i class="fa fa-download"></i> <a href="../../common/download.php?fl=<?=$foldername?>&fi=<?=$user_file?>"><?=$user_file?></a> <input type="checkbox" name="user_file_chk" id="user_file_chk" value="Y"  class="flat-red"> 삭제</p>
							<?
						}
						?>
					</div>

					<div class="form-group">
					  <label for="option_list">옵션사용</label>
					  <div class="checkbox">
						<label>
						<input type="checkbox" name="option_list[]" id="option_list1" value="notice" <?=preg_match("/notice/i", $option_list)?"checked":"";?> class="flat-red"> 공지글
						</label>
						<label>
						<input type="checkbox" name="option_list[]" id="option_list2" value="secret" <?=preg_match("/secret/i", $option_list)?"checked":"";?> class="flat-red"> 비밀글
						</label>
						<label>
						<input type="checkbox" name="option_list[]" id="option_list3" value="tel" <?=preg_match("/tel/i", $option_list)?"checked":"";?> class="flat-red"> 전화번호
						</label>
						<label>
						<input type="checkbox" name="option_list[]" id="option_list4" value="hp" <?=preg_match("/hp/i", $option_list)?"checked":"";?> class="flat-red"> 휴대폰번호
						</label>
						<label>
						<input type="checkbox" name="option_list[]" id="option_list5" value="email" <?=preg_match("/email/i", $option_list)?"checked":"";?> class="flat-red"> 이메일
						</label>
						<label>
						<input type="checkbox" name="option_list[]" id="option_list6" value="homep" <?=preg_match("/homep/i", $option_list)?"checked":"";?> class="flat-red"> 홈페이지
						</label>
						<label>
						<input type="checkbox" name="option_list[]" id="option_list7" value="movie_url" <?=preg_match("/movie_url/i", $option_list)?"checked":"";?> class="flat-red"> 동영상경로
						</label>
						<label>
						<input type="checkbox" name="option_list[]" id="option_list8" value="tag" <?=preg_match("/tag/i", $option_list)?"checked":"";?> class="flat-red"> 태그
						</label>
						<label>
						<input type="checkbox" name="option_list[]" id="option_list9" value="address" <?=preg_match("/address/i", $option_list)?"checked":"";?> class="flat-red"> 주소(문의/요청형일 경우)
						</label>
					  </div>
					</div>

					<div class="form-group">
					  <label for="use_grade">사용권한</label>
					  <div class="radio">
						<label>
						<input type="radio" name="use_grade" id="use_grade1" value="1" <? echo $use_grade == "1"?"checked":"";?> class="flat-red"> 관리자
						</label>
						<label>
						<input type="radio" name="use_grade" id="use_grade2" value="2" <? echo $use_grade == "2"?"checked":"";?> class="flat-red"> 직원이상
						</label>
						<label>
						<input type="radio" name="use_grade" id="use_grade3" value="3" <? echo $use_grade == "3"?"checked":"";?> class="flat-red"> 회원만
						</label>
						<label>
						<input type="radio" name="use_grade" id="use_grade4" value="9" <? echo $use_grade == "9"?"checked":"";?> class="flat-red"> 누구나
						</label>
					</div>

					<div class="form-group">
					  <label for="skill_list">기능</label>
					  <div class="checkbox">
						<label>
						<input type="checkbox" name="skill_list[]" id="skill_list1" value="view" <?=preg_match("/view/i", $skill_list)?"checked":"";?> class="flat-red"> 읽기
						</label>
						<label>
						<input type="checkbox" name="skill_list[]" id="skill_list2" value="write" <?=preg_match("/write/i", $skill_list)?"checked":"";?> class="flat-red"> 쓰기
						</label>
						<label>
						<input type="checkbox" name="skill_list[]" id="skill_list3" value="edit" <?=preg_match("/edit/i", $skill_list)?"checked":"";?> class="flat-red"> 수정
						</label>
						<label>
						<input type="checkbox" name="skill_list[]" id="skill_list4" value="reply" <?=preg_match("/reply/i", $skill_list)?"checked":"";?> class="flat-red"> 답변
						</label>
						<label>
						<input type="checkbox" name="skill_list[]" id="skill_list5" value="del" <?=preg_match("/del/i", $skill_list)?"checked":"";?> class="flat-red"> 삭제
						</label>
						<label>
						<input type="checkbox" name="skill_list[]" id="skill_list6" value="comment" <?=preg_match("/comment/i", $skill_list)?"checked":"";?> class="flat-red"> 댓글사용
						</label>
						<label>
						<input type="checkbox" name="skill_list[]" id="skill_list7" value="like" <?=preg_match("/like/i", $skill_list)?"checked":"";?> class="flat-red"> 좋아요
						</label>
						<label>
						<input type="checkbox" name="skill_list[]" id="skill_list8" value="bad" <?=preg_match("/bad/i", $skill_list)?"checked":"";?> class="flat-red"> 나빠요
						</label>
					</div>

					<div class="form-group">
					  <label for="target_send">발송</label>
					  <div class="checkbox">
						<label>
						<input type="checkbox" name="target_send[]" id="target_send1" value="mail" <?=preg_match("/mail/i", $target_send)?"checked":"";?> class="flat-red"> 메일
						</label>
						<label>
						<input type="checkbox" name="target_send[]" id="target_send2" value="sms" <?=preg_match("/sms/i", $target_send)?"checked":"";?> class="flat-red"> SMS
						</label>
						<label>
						<input type="checkbox" name="target_send[]" id="target_send3" value="lms" <?=preg_match("/lms/i", $target_send)?"checked":"";?> class="flat-red"> LMS
						</label>
						<label>
						<input type="checkbox" name="target_send[]" id="target_send4" value="mms" <?=preg_match("/mms/i", $target_send)?"checked":"";?> class="flat-red"> MMS
						</label>
					</div>

					<div class="form-group">
					  <label for="share_media">공유</label>
					  <div class="checkbox">
						<label>
						<input type="checkbox" name="share_media[]" id="share_media1" value="kakao" <?=preg_match("/kakao/i", $share_media)?"checked":"";?> class="flat-red"> 카카오스토리
						</label>
						<label>
						<input type="checkbox" name="share_media[]" id="share_media2" value="blog" <?=preg_match("/blog/i", $share_media)?"checked":"";?> class="flat-red"> 네이버블로그
						</label>
						<label>
						<input type="checkbox" name="share_media[]" id="share_media3" value="facebook" <?=preg_match("/facebook/i", $share_media)?"checked":"";?> class="flat-red"> 페이스북
						</label>
						<label>
						<input type="checkbox" name="share_media[]" id="share_media4" value="google+" <?=preg_match("/google+/i", $share_media)?"checked":"";?> class="flat-red"> 구글+
						</label>
						<label>
						<input type="checkbox" name="share_media[]" id="share_media5" value="twitter" <?=preg_match("/twitter/i", $share_media)?"checked":"";?> class="flat-red"> 트위트
						</label>
						<label>
						<input type="checkbox" name="share_media[]" id="share_media6" value="instargram" <?=preg_match("/instargram/i", $share_media)?"checked":"";?> class="flat-red"> 인스타그램
						</label>
					</div>

					<div class="form-group">
					  <label for="item_close">목록항목 숨김</label>
					  <div class="checkbox">
						<label>
						<input type="checkbox" name="item_close[]" id="item_close1" value="writer" <?=preg_match("/writer/i", $item_close)?"checked":"";?> class="flat-red"> 등록자
						</label>
						<label>
						<input type="checkbox" name="item_close[]" id="item_close2" value="rdate" <?=preg_match("/rdate/i", $item_close)?"checked":"";?> class="flat-red"> 등록일
						</label>
						<label>
						<input type="checkbox" name="item_close[]" id="item_close3" value="count" <?=preg_match("/count/i", $item_close)?"checked":"";?> class="flat-red"> 조회수
						</label>
						<label>
						<input type="checkbox" name="item_close[]" id="item_close4" value="file" <?=preg_match("/file/i", $item_close)?"checked":"";?> class="flat-red"> 첨부파일
						</label>
					</div>

					<div class="form-group">
					  <label for="img_flag">이미지첨부</label>
					  <select name="img_flag" id="img_flag" class="form-control boxed">
						  <option value="0" >- 선택 -</option>
						  <option value="1" <?=$img_flag=="1"?"selected":""?>>1</option>
						  <option value="2" <?=$img_flag=="2"?"selected":""?>>2</option>
						  <option value="3" <?=$img_flag=="3"?"selected":""?>>3</option>
						  <option value="4" <?=$img_flag=="4"?"selected":""?>>4</option>
						  <option value="5" <?=$img_flag=="5"?"selected":""?>>5</option>
						  <option value="10" <?=$img_flag=="10"?"selected":""?>>10</option>
					  </select>
					</div>

					<div class="form-group">
					  <label for="file_flag">파일첨부</label>
					  <select name="file_flag" id="file_flag" class="form-control boxed">
						  <option value="0" >- 선택 -</option>
						  <option value="1" <?=$file_flag=="1"?"selected":""?>>1</option>
						  <option value="2" <?=$file_flag=="2"?"selected":""?>>2</option>
						  <option value="3" <?=$file_flag=="3"?"selected":""?>>3</option>
						  <option value="4" <?=$file_flag=="4"?"selected":""?>>4</option>
						  <option value="5" <?=$file_flag=="5"?"selected":""?>>5</option>
						  <option value="10" <?=$file_flag=="10"?"selected":""?>>10</option>
					  </select>
					</div>

					<div class="form-group">
					  <label for="list_counts">목록수</label>
					  <select name="list_counts" id="list_counts" class="form-control boxed">
						  <option value="0" >- 선택 -</option>
						  <option value="10" <?=$list_counts=="10"?"selected":""?>>10</option>
						  <option value="12" <?=$list_counts=="12"?"selected":""?>>12</option>
						  <option value="15" <?=$list_counts=="15"?"selected":""?>>15</option>
						  <option value="16" <?=$list_counts=="16"?"selected":""?>>16</option>
						  <option value="16" <?=$list_counts=="18"?"selected":""?>>18</option>
						  <option value="20" <?=$list_counts=="20"?"selected":""?>>20</option>
						  <option value="30" <?=$list_counts=="30"?"selected":""?>>30</option>
						  <option value="40" <?=$list_counts=="40"?"selected":""?>>40</option>
						  <option value="50" <?=$list_counts=="50"?"selected":""?>>50</option>
						  <option value="100" <?=$list_counts=="100"?"selected":""?>>100</option>
					  </select>
					</div>
				</div>
				<!-- /.box-body -->

				<div class="box-footer">
					<?if($popup=="1") {?>
					<button type="text" class="btn btn-default" onClick="self.close()">닫기</button>
					<?} else {?>
					<button type="text" class="btn btn-default" onClick="history.go(-1)">취소</button>
					<?}?>
					<button type="submit" class="btn btn-primary pull-right">확인</button>
				</div>
				</form>
			</div>
			</div>
			<!-- /.box -->
		</div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?
include "../inc/footer.php";
mysql_close($dbconn);
?>