<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "banner"; 				//테이블 이름
	$foldername  = "../$upload_dir/$_t/";

	if ($gubun == "") {
		$gubun = "insert";
	}

	if ($idx) {
		//테이블에서 글을 가져옵니다.
		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx        = stripslashes($array[idx]);
			$title      = db2html($array[title]);
			$body       = db2html($array[body]);
			$category   = stripslashes($array[category]);
			$counts     = stripslashes($array[counts]);
			$img_file   = stripslashes($array[img_file]);
			$width      = stripslashes($array[width]);
			$height     = stripslashes($array[height]);
			$winopen    = stripslashes($array[winopen]);
			$startdate  = stripslashes($array[startdate]);
			$enddate    = stripslashes($array[enddate]);
			$date = $startdate." - ".$enddate;
			$pageurl    = stripslashes($array[pageurl]);
			$view_flag  = stripslashes($array[view_flag]);
			$regdate    = stripslashes($array[regdate]);
			$upddate    = stripslashes($array[upddate]);
		}

	} else {
		$username	= $SUPER_UNAME;
		$category	= "001";
	}

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>

<script language="javascript">
<!--
function fn_submit() {
	if($.trim($('#title').val()) == ''){
		alert("배너명을 입력하세요.");
		$('#title').focus();
		return false;
	}
	<?if($gubun=="insert") {?>
	if($.trim($('#img_file').val()) == ''){
		alert("이미지를 입력하세요.");
		$('#img_file').focus();
		return false;
	}
	<?}?>
	if($.trim($('#pageurl').val()) == ''){
		alert("이동주소를 입력하세요.");
		$('#pageurl').focus();
		return false;
	}
	$("#fm").attr("target", "_self");
	$("#fm").attr("method", "post");
	$("#fm").attr("action", "write_ok.php");

}

//-->
</script>

<form name="form" id="form">
<input type="hidden" name="idx">
<input type="hidden" name="gubun">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

	<?
	include "navigation.php";
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
			

			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title">Form</h3>
				</div>
				<!-- /.box-header -->

				<!-- form start -->
				<form role="form" method="post" name="fm" id="fm" enctype="multipart/form-data" onSubmit="return fn_submit()">
				<input type="hidden" name="_t" value="<?=$_t?>">
				<input type="hidden" name="idx" value='<?=$idx?>'>
				<input type="hidden" name="gubun" value='<?=$gubun?>'>
				<input type="hidden" name="banner" value="<?=$popup?>">
				<input type="hidden" name="userid" value="<?=$userid?>">
				<input type="hidden" name="username" value="<?=$username?>">
				<input type="hidden" name="adminid" value="<?=$adminid?>">
				<input type="hidden" name="page" value='<?=$page?>'>
				<input type="hidden" name="search" value='<?=$search?>'>
				<input type="hidden" name="search_text" value='<?=$search_text?>'>
				<div class="box-body">
					<div class="form-group">
					  <label for="category">구분</label>
					  <div class="radio">
						<div class="input-group">
						<?
						//코드값 정의
						$code_type = "code_banner";

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
						<?=getCodeNameBoxDB($code_type, $category, "radio", "category",$dbconn)?>
							<span class="input-group-btn">
							  <button type="button" class="btn btn-info btn-flat" onclick="go_category_add('<?=$kind_code?>', '<?=$kind_name?>')">추가</button>
							</span>
						</div>
					  </div>
					</div>

					<div class="form-group">
					  <label for="active">뷰설정</label>
					  <div class="radio">
						<label>
							<input type="radio" name="view_flag" id="view_flag" class="flat-red" value="1" <?if($view_flag=="1"){?>checked<?}?>> 보임
						</label>
						<label>
							<input type="radio" name="view_flag" id="view_flag" class="flat-red" value="0" <?if($view_flag=="0" || $view_flag == ""){?>checked<?}?>> 숨김
						</label>
					  </div>
					</div>


					<div class="form-group">
					  <label for="title">배너명</label>
					  <input type="text" name="title" id="title" value="<?=$title?>" class="form-control" placeholder="">
					</div>


					<div class="form-group">
					  <label for="width">배너크기</label>
					  <div class="row">
						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
							  <input type="text" class="form-control" name="width" id="width" value="<?=$width?>" placeholder="너비" onkeyup="chkNumeric(fm.width)">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">Pixel</button>
								</span>
							  </div>
						   </div>
						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
							  <input type="text" class="form-control" name="height" id="height" value="<?=$height?>" placeholder="높이" onkeyup="chkNumeric(fm.height)">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">Pixel</button>
								</span>
							  </div>
						   </div>
					   </div>
					</div>
					

					<div class="form-group">
					  <label for="date">기간</label>
					  <div class="row">
						  <div class="col-xs-4">
							  <div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								  </div>
								  <input type="text" name="date" id="reservation" value="<?=$date?>" class="form-control pull-right">
							  </div>
						   </div>
					   </div>
					</div>

					<div class="form-group">
					  <label for="img_file">이미지파일</label>
					  <input type="file" name="img_file" id="img_file" value="" class="form-control">
						<?
						if($img_file!="") {
							?>
							  <p class="help-block"><a href="../../common/download.php?fl=<?=$foldername?>&fi=<?=$img_file?>"><?=$img_file?></a></p>
							<?
						}

						$img_file = "";
						?>
					</div>

					<div class="form-group">
					  <label for="title">이동주소</label>
					  <input type="text" name="pageurl" id="pageurl" value="<?=$pageurl?>" class="form-control" placeholder="">
					  <font color="#CC0000">* 클릭시 이동할 페이지 주소</font><br>
						ex.1) http://<?=$_SERVER["HTTP_HOST"]?>/board/view.php?id=41<br>
						ex.2) /board/view.php?id=41
					</div>

					<div class="form-group">
					  <label for="notice_yn">새창여부</label>
					  <div class="checkbox">
						<label>
							<input type="checkbox" name="winopen" id="winopen" value="Y" <?=$winopen=="Y"?"checked":""?> class="flat-red" onClick="checkOk()" > <font color="#CC0000">* 클릭시 새창으로 열기.</font>
						</label>
					  </div>
					</div>


					<div class="form-group">
					  <label for="site_info">내용정보</label>
					  
						<div class="box-body pad">
							<textarea class="textarea" name="body" id="body" placeholder="" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?=$body?></textarea>
						</div>
					</div>
				</div>
				<!-- /.box-body -->

				<div class="box-footer">
					<button type="text" class="btn btn-default" onClick="fn_cancel()">취소</button>
					<button type="submit" class="btn btn-primary pull-right">확인</button>
				</div>
				</form>
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