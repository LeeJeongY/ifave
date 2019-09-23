<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";


	//게시판 목록보기에 필요한 각종 변수 초기값을 설정합니다.
	if($_t == "") $_t	= "inquiry"; 				//테이블 이름
	$foldername  = "../../$upload_dir/$_t/";

	//게시판 정보
	include "../../modules/boardinfo.php";

	if ($gubun == "") {
		$gubun = "view";
	}

	if ($idx) {

		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$user_state		= $array[user_state];
		}
		//신청시 확인으로 변경
		if($user_state==0) {
			$query = "UPDATE ".$initial."_bbs_".$_t." SET user_state='1' WHERE idx = '$idx'";
			mysql_query($query, $dbconn);
		}

		//테이블에서 글을 가져옵니다.
		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx		= $array[idx];
			$category	= $array[category];
			$title		= db2html($array[title]);
			$user_name	= db2html($array[user_name]);
			$user_group	= stripslashes($array[user_group]);
			$user_tel	= stripslashes($array[user_tel]);
			$user_email	= stripslashes($array[user_email]);
			$question_type	= stripslashes($array[question_type]);
			$contents	= nE_db2html_v($array[contents]);
			$user_ip	= stripslashes($array[user_ip]);
			$user_state	= stripslashes($array[user_state]);
			$ans_text	= nE_db2html($array[ans_text]);
			$ans_name	= db2html($array[ans_name]);
			$regdate	= stripslashes($array[regdate]);
			$editdate	= stripslashes($array[editdate]);
			$ansdate	= stripslashes($array[ansdate]);
		}
	}

	if($ans_name=="") $ans_name = $SUPER_UNAME;

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>

<script language="javascript">
<!--
function fn_answer() {

		if($('#iname').val() =='') {
			alert('제품명을 입력하세요.');
			$('#iname').focus();
			return false;
		}
		fm.gubun.value = "ans";
		fm.target = "_self";
		fm.action = "write_ok.php";
		fm.submit();
}
//-->
</script>

<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup-":""?>content-wrapper">
    <!-- Content Header (Page header) -->
	<?
	include "../inc/navi_board.php";
	?>

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
				  <h3 class="box-title"><?=$notice_yn=="1"?"<span class=\"pull-right-container\"><small class=\"label bg-green\">공지</small></span>":""?><?=$title?></h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form role="form" method="get" name="fm" id="fm">
				<input type="hidden" name="page" value='<?=$page?>'>
				<input type="hidden" name="idx" value='<?=$idx?>'>
				<input type="hidden" name="gubun" value='<?=$gubun?>'>
				<input type="hidden" name="popup" value="<?=$popup?>">
				<input type="hidden" name="search" value='<?=$search?>'>
				<input type="hidden" name="search_text" value='<?=$search_text?>'>
				<input type="hidden" name="menu_b" value="<?=$menu_b?>">
				<input type="hidden" name="menu_m" value="<?=$menu_m?>">
				<div class="box-body">

					<div class="form-group">
					  <label for="category">구분</label>
					  <div class="input-group">

						<?=$category=="01"?"문의하기":""?>
						<?=$category=="02"?"제안하기":""?>
						<?=$category=="03"?"채용문의":""?>
					  </div>
					</div>
					<div class="form-group">
					  <label for="user_name">성명</label>
					  <div class="input-group">
					  <?=$user_name?>
					  </div>
					</div>
					<?if($user_group) {?>
					<div class="form-group">
					  <label for="user_group">소속</label>
					  <div class="input-group">
					  <?=$user_group?>
					  </div>
					</div>
					<?}?>
					<div class="form-group">
					  <label for="subject">제목</label>
					  <div class="input-group">
					  <?=$title?>
					  </div>
					</div>
					<div class="form-group">
					  <label for="tel">연락처</label>
					  <div class="input-group">
					  <?=$user_tel?>
					  </div>
					</div>
					<div class="form-group">
					  <label for="email">이메일</label>
					  <div class="input-group">
					  <?=$user_email?>
					  </div>
					</div>
					<?if($question_type) {?>
					<div class="form-group">
					  <label for="subject">문의유형</label>
					  <div class="input-group">
					  <?=getCodeNameDB("code_question_type", $question_type, $dbconn)?>
					  </div>
					</div>
					<?}?>


					<div class="form-group">
					  <label for="subject">내용</label>
					  <div class="input-group">
					  <?=$contents?>
					  </div>
					</div>
					<div class="form-group">
					  <label for="subject">IP정보</label>
					  <div class="input-group">
					  <?=$user_ip?>
					  </div>
					</div>
					<div class="form-group">
					  <label for="subject">상태</label>
					  <div class="input-group">
						<!-- <?=$user_state=="0"?"신청":""?>
						<?=$user_state=="1"?"확인":""?>
						<?=$user_state=="2"?"완료":""?> -->

						<select name="user_state" id="user_state" class="form-control boxed select2">
							<option value="">- 상태변경 -</option>
							<option value="0" <?if($user_state == "0") {?>selected<?}?>>신청</option>
							<option value="1" <?if($user_state == "1") {?>selected<?}?>>확인</option>
							<option value="2" <?if($user_state == "2") {?>selected<?}?>>완료</option>
						</select>

					  </div>
					</div>
					<div class="form-group">
					  <label for="ans_text">처리내용</label>
						<textarea name="ans_text" id="ans_text" style="width:100%;height:100px;"><?=$ans_text?></textarea/>
					</div>
					<div class="form-group">
					  <label for="ans_name">처리자</label>
						<input type="text" name="ans_name" id="ans_name" value="<?=$ans_name?>" class="form-control" required=""/>
					</div>
					<div class="form-group">
					  <label for="ans_name">처리일</label>
						<?=$ansdate?>
					</div>



				</div>
				<!-- /.box-body -->

				<div class="box-footer">
					<button type="text" class="btn btn-default" onClick="self.close()">닫기</button>
					<!-- <button type="text" class="btn btn-warning"  onclick="go_edit('<?=$idx?>');">수정</button> -->
					<button type="text" class="btn btn-danger pull-right"  onclick="fn_answer();">확인</button>
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