<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "popup"; 				//테이블 이름
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
			$idx      	= stripslashes($array[idx]);
			$title    	= db2html($array[title]);
			$body     	= stripslashes($array[body]);
			$contents	= db2html($body);
			$category 	= stripslashes($array[category]);
			$popup_flag	= stripslashes($array[popup_flag]);
			$counts   	= stripslashes($array[counts]);
			$user_file	= stripslashes($array[user_file]);
			$img_file 	= stripslashes($array[img_file]);
			$nflag    	= stripslashes($array[nflag]);
			$list_add 	= stripslashes($array[list_add]);
			$scrollbar	= stripslashes($array[scrollbar]);
			$ptop     	= stripslashes($array[ptop]);
			$pleft    	= stripslashes($array[pleft]);
			$width    	= stripslashes($array[width]);
			$height   	= stripslashes($array[height]);
			$winopen  	= stripslashes($array[winopen]);
			$startdate	= stripslashes($array[startdate]);
			$enddate  	= stripslashes($array[enddate]);
			$pageurl  	= stripslashes($array[pageurl]);
			$mapflag  	= stripslashes($array[mapflag]);
			$image_map	= stripslashes($array[image_map]);
			$tag		= stripslashes($array[tag]);
			$view_flag	= stripslashes($array[view_flag]);
			$userid   	= stripslashes($array[userid]);
			$username 	= db2html($array[username]);
			$regdate  	= stripslashes($array[regdate]);
			$upddate  	= stripslashes($array[upddate]);
			$vodpath  	= stripslashes($array[vodpath]);
			$vodfile1 	= stripslashes($array[vodfile1]);
			$vodfile2 	= stripslashes($array[vodfile2]);
			$vodfile3 	= stripslashes($array[vodfile3]);
			$bfilepath	= stripslashes($array[bfilepath]);
			$bfile1   	= stripslashes($array[bfile1]);
			$bfile2   	= stripslashes($array[bfile2]);
			$bfile3   	= stripslashes($array[bfile3]);
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
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup":"content"?>-wrapper">
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
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="search" value='<?=$search?>'>
			<input type="hidden" name="search_text" value='<?=$search_text?>'>
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">

            <div class="box-body no-padding">
				<div class="viewbox-read-info">
					<h3><?=$notice_yn=="1"?"<span class=\"pull-right-container\"><small class=\"label bg-green\">공지</small> </span>":""?>

					<?if($cfg_cate_flag == "1") {?>
					<?//구분?>
					[<?=getCodeNameDB($cfg_cate_code, $category, $dbconn)?>]
					<?}?>

					<?=$title?></h3>
					<h5><?=$username?>
					<?if($winopen == "Y") {?>
						<?if($startdate) {?>
						<span class="pipeline">|</span> 기간 <?=$startdate?>~<?=$enddate?>
						<?}?>
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
				  <b>팝업구분</b> <a class="pull-right"><?=$popup_flag=="window"?"새창팝업":"레이어팝업"?></a>
				</li>
				<li class="list-group-item">
				  <b>공지여부</b> <a class="pull-right"><?=$nflag=="1"?"공지":""?></a>
				</li>
				<li class="list-group-item">
				  <b>새창여부</b> <a class="pull-right"><?=$winopen=="Y"?"새창":""?></a>
				</li>
				<li class="list-group-item">
				  <b>새창스크롤여부</b> <a class="pull-right">
					<? echo $scrollbar;?>
				  </a>
				</li>
				<li class="list-group-item">
				  <b>이미지파일</b>
						<?
						if($img_file!="") {
							?>
							  <a href="../../common/download.php?fl=<?=$download_foldername?>&fi=<?=$img_file?>" class="pull-right"><?=$img_file?></a>
							  <br>
							  <img src="<?=$foldername?><?=$img_file?>">
							<?
						}

						$img_file = "";
						?>
				</li>
				<li class="list-group-item">
				  <b>이미지맵사용</b> <a class="pull-right"><?echo $mapflag == "Y"?"":"사용";?></a>
				  <?=$image_map?>
				</li>
				<li class="list-group-item">
				  <b>이동주소</b> <a class="pull-right"><?=$pageurl?></a>
				</li>
				<li class="list-group-item">
				  <b>첨부파일</b>
						<?
						if($user_file!="") {
							?>
							  <a href="../../common/download.php?fl=<?=$foldername?>&fi=<?=$user_file?>"><?=$user_file?></a>
							<?
						}

						$user_file = "";
						?>
				</li>
			  </ul>
				<div class="form-group ">
					<span class="contents_info" id="contents_html">
					  <?=convertHashtags($contents)?>
					</span>
				</div>

			</div>
			<!-- /.box-body -->


			<div class="box-body text-center">

				<?if($cfg_share_media!="") {?>
					<a type="text" class="btn btn-app" href="javascript:go_share('<?=$idx?>');">
					<i class="fa fa-share"></i> 공유
					</a>
				<?}?>

				<?if(preg_match("/like/i", $cfg_skill_list)) {?>
				<a type="text" class="btn btn-app" href="javascript:go_counter('like','<?=$idx?>');">
                <span class="badge bg-red" id="like"><?=$counts_like?></span>
				<i class="fa fa-thumbs-o-up"></i> 좋아요
				</a>
				<!-- <a class="btn btn-app">
				<span class="badge bg-red">531</span>
				<i class="fa fa-heart-o"></i> 좋아요
				</a> -->
				<?}?>
				<?if(preg_match("/bad/i", $cfg_skill_list)) {?>
				<a type="text" class="btn btn-app" href="javascript:go_counter('bad','<?=$idx?>');">
                <span class="badge bg-yellow" id="bad"><?=$counts_bad?></span>
				<i class="fa fa-thumbs-o-down"></i> 나빠요
				</a>
				<?}?>

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