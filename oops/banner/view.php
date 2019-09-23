<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "banner"; 				//테이블 이름
	$foldername  = "../../$upload_dir/$_t/";
	$download_foldername  = "../$upload_dir/$_t/";

	if ($gubun == "") {
		$gubun = "view";
	}

	if ($idx) {
		//조회수 증가
		if ($_USER_CLASS <= 10) {
			$query = "UPDATE ".$initial."_bbs_".$_t." SET counts=counts+1 WHERE idx = '$idx'";
			mysql_query($query, $dbconn);
		}

		//테이블에서 글을 가져옵니다.
		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx        = stripslashes($array[idx]);
			$title      = db2html($array[title]);
			$body       = nE_db2html_v($array[body]);
			$contents	= $body;
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
			//$regdate	= substr($regdate, 0, 10);
		}

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
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">	
<input type="hidden" name="_t" value="<?=$_t?>" id="_t">
<input type="hidden" name="tag" id="tag" value="">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="banner" value="<?=$popup?>">
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

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->

		<!-- left column -->

		<div class="box box-info">
			<!-- <div class="box-header with-border">
			  <h3 class="box-title"><?=$notice_yn=="1"?"<span class=\"pull-right-container\"><small class=\"label bg-green\">공지</small> </span>":""?><?=$title?></h3>
			</div> -->
			<!-- /.box-header -->
			<!-- form start -->
			<form role="form" method="get" name="fm" id="fm">
			<input type="hidden" name="page" value='<?=$page?>'>
			<input type="hidden" name="idx" value='<?=$idx?>'>
			<input type="hidden" name="gubun" value='<?=$gubun?>'>
			<input type="hidden" name="banner" value="<?=$popup?>">
			<input type="hidden" name="search" value='<?=$search?>'>
			<input type="hidden" name="search_text" value='<?=$search_text?>'>
			
            <div class="box-body no-padding">
				<div class="viewbox-read-info">
					<h3><?=$notice_yn=="1"?"<span class=\"pull-right-container\"><small class=\"label bg-green\">공지</small> </span>":""?>
					
					<?if($cfg_cate_flag == "1") {?>
					<?//구분?>
					[<?=getCodeNameDB($cfg_cate_code, $category, $dbconn)?>]
					<?}?>

					<?=$title?></h3>
					<h5><?=$username?> 
					<?if($startdate) {?>
					<span class="pipeline">|</span> 기간 <?=$startdate?>~<?=$enddate?>
					<?}?>
					<span class="viewbox-read-time pull-right"><?=$counts?> <span class="pipeline">|</span> <?=$upddate=="0000-00-00 00:00:00"?$regdate:$upddate?></span></h5>

				</div>
			</div>

			<div class="box-body">
			  <ul class="list-group list-group-unbordered">
				<li class="list-group-item">
				  <b>뷰설정</b> <a class="pull-right"><?=$view_flag=="1"?"보임":"숨김"?></a>
				</li>
				<li class="list-group-item">
				  <b>이미지파일</b> 
						<?
						if($img_file!="") {
							?>
							  <a href="../../common/download.php?fl=<?=$foldername?>&fi=<?=$img_file?>" class="pull-right"><?=$img_file?></a>
							<?
						}

						$img_file = "";
						?>
				</li>
				<li class="list-group-item">
				  <b>이동주소</b> <a class="pull-right"><?=$pageurl?></a>
				  <?=$image_map?>
				</li>
			  </ul>
				<div class="form-group ">
					<span class="contents_info" id="contents_html">
					  <?=$contents?>
					</span>
				</div>

			</div>
			<!-- /.box-body --> 

			<div class="box-footer">
				<div class="btn-group">
					<a type="text" class="btn btn-default" href="javascript:go_list();">목록</a>
					<a type="text" class="btn btn-warning" href="javascript:go_write();">새글</a> 
				</div>
				
				<div class="btn-group pull-right">
				<a type="text" class="btn btn-warning" href="javascript:go_edit('<?=$idx?>');">수정</a>
				<a type="text" class="btn btn-danger " href="javascript:go_delete('<?=$idx?>');">삭제</a>
				</div>
			</div>
			</form>



		</div>
		<!-- /.box -->	  


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?
include "../inc/footer.php";
mysql_close($dbconn);
?>