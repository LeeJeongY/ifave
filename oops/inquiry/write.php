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
		$gubun = "insert";
	}

	if ($idx) {
		//테이블에서 글을 가져옵니다.
		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx		= $array[idx];
			$category	= $array[category];
			$title		= db2html($array[title]);
			$user_id	= $array[user_id];
			$user_name	= db2html($array[user_name]);
			$user_group	= stripslashes($array[user_group]);
			$user_tel	= stripslashes($array[user_tel]);
			$user_email	= stripslashes($array[user_email]);
			$question_type	= stripslashes($array[question_type]);
			$contents	= db2html($array[contents]);
			$user_ip	= stripslashes($array[user_ip]);
			$user_state	= stripslashes($array[user_state]);
			$regdate	= stripslashes($array[regdate]);
			$editdate	= stripslashes($array[editdate]);
		}

	} else {
		$user_name	= $SUPER_UNAME;
		$user_email	= $SUPER_UEMAIL;
	}

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>

<script language="javascript">
<!--
//-->
</script>

<form name="form" id="form">
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
  <div class="content-wrapper">
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
					  <h3 class="box-title">Form</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form role="form" method="post" name="fm" id="fm" enctype="multipart/form-data">
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
						  <label for="title">제목</label>
						  <input type="text" name="title" id="title" value="<?=$title?>" class="form-control" placeholder="">
						</div>
						<div class="form-group">
						  <label for="username">작성자</label>
						  <input type="text" name="username" id="username" value="<?=$username?>" class="form-control" placeholder="">
						</div>

						<div class="form-group">
						  <?
							include "../../smarteditor/SmartEditor.php";
						  ?>
						</div>


					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<button type="text" class="btn btn-default" onClick="fn_cancel()">취소</button>
						<button type="text"  onclick="submitContents(this);" class="btn btn-primary pull-right">확인</button>
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