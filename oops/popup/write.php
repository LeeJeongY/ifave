<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "popup"; 				//테이블 이름
	$foldername  = "../$upload_dir/$_t/";

	if ($gubun == "") {
		$gubun = "insert";
	}

	if ($idx) {
		//테이블에서 글을 가져옵니다.
		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx      	= stripslashes($array[idx]);
			$title    	= db2html($array[title]);
			$body     	= db2html($array[body]);
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
			$date = $startdate." - ".$enddate;
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
		}

	} else {
		$username	= $SUPER_UNAME;
		$category	= "001";
		$popup_flag	= "window";
	}

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>

<script language="javascript">
<!--
function checkOk() {
	var fm = document.fm;

	if (fm.winopen.checked == true) {
		fm.width.disabled		= false;
		fm.height.disabled		= false;
		fm.ptop.disabled		= false;
		fm.pleft.disabled		= false;
		fm.scrollbar.disabled	= false;
		fm.syear.disabled		= false;
		fm.smonth.disabled 		= false;
		fm.sday.disabled 		= false;
		fm.eyear.disabled		= false;
		fm.emonth.disabled		= false;
		fm.eday.disabled		= false;
		fm.list_add.disabled	= false;
	} else {
		fm.width.disabled		= true;
		fm.height.disabled		= true;
		fm.ptop.disabled		= true;
		fm.pleft.disabled		= true;
		fm.scrollbar.disabled	= true;
		fm.syear.disabled 		= true;
		fm.smonth.disabled 		= true;
		fm.sday.disabled 		= true;
		fm.eyear.disabled		= true;
		fm.emonth.disabled		= true;
		fm.eday.disabled		= true;
		fm.list_add.disabled	= true;
		fm.width.value			= 0;
		fm.height.value			= 0;
		fm.ptop.value			= 0;
		fm.pleft.value			= 0;
	}
}
//이미지 맵 뷰
function fn_imagemap() {
	var fm = document.fm;
	if (fm.mapflag.checked == true) {
		document.getElementById('image_map').style.display = "";
	} else {
		document.getElementById('image_map').style.display = "none";
	}
}
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
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup":"content"?>-wrapper">
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
			<div class="col-md-12">


			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title">Form</h3>
				</div>
				<!-- /.box-header -->

				<!-- form start -->
				<form role="form" method="post" action="write_ok.php" name="fm" id="fm" enctype="multipart/form-data">
				<input type="hidden" name="_t" value="<?=$_t?>">
				<input type="hidden" name="idx" value='<?=$idx?>'>
				<input type="hidden" name="gubun" value='<?=$gubun?>'>
				<input type="hidden" name="popup" value="<?=$popup?>">
				<input type="hidden" name="userid" value="<?=$userid?>">
				<input type="hidden" name="adminid" value="<?=$adminid?>">
				<input type="hidden" name="page" value='<?=$page?>'>
				<input type="hidden" name="search" value='<?=$search?>'>
				<input type="hidden" name="search_text" value='<?=$search_text?>'>
				<input type="hidden" name="menu_b" value="<?=$menu_b?>">
				<input type="hidden" name="menu_m" value="<?=$menu_m?>">
				<div class="box-body">
					<!-- <div class="form-group">
					  <label for="category">구분</label>
					  <div class="radio">
					  <?=getCodeNameBoxDB($cfg_cate_code, $category, "radio", "category",$dbconn)?>
					  </div>
					</div> -->

					<div class="form-group">
					  <label for="view_flag">뷰설정</label>
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
					  <label for="popup_flag">팝업구분</label>
					  <div class="radio">
						<label>
							<input type="radio" name="popup_flag" id="popup_flag" class="flat-red" value="window" <?if($popup_flag=="window"){?>checked<?}?>> 새창팝업
						</label>
						<label>
							<input type="radio" name="popup_flag" id="popup_flag" class="flat-red" value="layer" <?if($popup_flag=="layer"){?>checked<?}?>> 레이어팝업
						</label>
					  </div>
					</div>


					<div class="form-group">
					  <label for="title">제목</label>
					  <input type="text" name="title" id="title" value="<?=$title?>" class="form-control" placeholder="">
					</div>
				<?if($SUPER_ULEVEL <= 2) {?>
					<div class="form-group">
					  <label for="nflag">공지여부</label>
					  <div class="checkbox">
						<label>
							<input type="checkbox" name="nflag" id="nflag" value="1" <?=$nflag=="1"?"checked":""?> class="flat-red"> 체크시 공지
						</label>
					  </div>
					</div>
				<?}?>
					<div class="form-group">
					  <label for="date">기간</label>
					  <div class="row">
						  <div class="col-xs-4">
							  <div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								  </div>
								  <input type="text" name="date" id="edu_date" value="<?=$date?>" class="form-control pull-right">
							  </div>
						   </div>
					   </div>
					</div>

					<!-- <div class="form-group">
					  <label for="popup_flag">종류</label>
					  <div class="radio">
						<label>
							<input type="radio" name="popup_kind" id="popup_kind" class="flat-red" value="img" <?if($popup_kind=="img"){?>checked<?}?>> 이미지
						</label>
						<label>
							<input type="radio" name="popup_kind" id="popup_kind" class="flat-red" value="slide" <?if($popup_kind=="slide"){?>checked<?}?>> 슬라이더
						</label>
					  </div>
					</div> -->

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
						<input type="checkbox" name="mapflag" id="mapflag" value="Y" <?if($mapflag == "Y") {?>checked<?}?> style="border:0;" onclick="fn_imagemap()">첨부이미지 <b>이미지맵</b>사용
						<span id="image_map" style="display: <?echo $mapflag == "Y"?"":"none";?>;"><br>
						<textarea name="image_map" id="image_map" class="form-control"><?=$image_map?></textarea>
						<br>
						사용방법) &lt;area shape="rect" coords="좌표" href="링크"&gt;<br>
						예) &lt;area shape="rect" coords="140, 102, 197, 136" href="<?=$_SERVER["HTTP_HOST"]?>"&gt;
						</span>
					</div>

					<div class="form-group">
					  <label for="pageurl">이동주소</label>
					  <input type="text" name="pageurl" id="pageurl" value="<?=$pageurl?>" class="form-control" placeholder="">
					  <font color="#CC0000">* 새창에서 클릭시 이동할 페이지 주소</font><br>
						ex.1) http://<?=$_SERVER["HTTP_HOST"]?>/board/view.php?idx=2<br>
						ex.2) /board/view.php?idx=2
					</div>


					<div class="form-group">
					  <label for="winopen">새창여부</label>
					  <div class="checkbox">
						<label>
							<input type="checkbox" name="winopen" id="winopen" value="Y" <?=$winopen=="Y"?"checked":""?> class="flat-red" onClick="checkOk()" > <font color="#CC0000">* 메인화면의 공지사항 새창여부를 선택해 주세요.</font>
						</label>
					  </div>
					</div>

					<div class="form-group">
					  <label for="width">새창크기</label>
					  <div class="row">
						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
							  <input type="text" class="form-control" name="width" id="width" value="<?=$width?>" placeholder="새창 너비" onkeyup="chkNumeric(fm.width)">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">Pixel</button>
								</span>
							  </div>
						   </div>
						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
							  <input type="text" class="form-control" name="height" id="height" value="<?=$height?>" placeholder="새창 높이" onkeyup="chkNumeric(fm.height)">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">Pixel</button>
								</span>
							  </div>
						   </div>
					   </div>
					</div>

					<div class="form-group">
					  <label for="pleft">새창위치</label>
					  <div class="row">
						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
							  <input type="text" class="form-control" name="pleft" id="pleft" value="<?=$pleft?>" placeholder="Left.." onkeyup="chkNumeric(fm.height)">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">Pixel</button>
								</span>
							  </div>
						   </div>
						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
							  <input type="text" class="form-control" name="ptop" id="ptop" value="<?=$ptop?>" placeholder="Top.." onkeyup="chkNumeric(fm.height)">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">Pixel</button>
								</span>
							  </div>
						   </div>
					   </div>
					</div>

					<div class="form-group">
					  <label for="scrollbar">새창스크롤여부</label>
					  <div class="row">
						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
								<select name="scrollbar" id="scrollbar" class="form-control">
									<option value="yes" <? echo $scrollbar == "yes"?"selected":"";?>>Yes</option>
									<option value="no"  <? echo $scrollbar == "no"?"selected":"";?>>No</option>
									<option value="auto" <? echo $scrollbar == "auto"?"selected":"";?>>Auto</option>
								</select>
							  </div>
						   </div>
					   </div>
					</div>


					<div class="form-group">
					  <label for="username">작성자</label>
					  <div class="row">
						  <div class="col-xs-2">
							  <div class="input-group">
								<input type="text" name="username" id="username" value="<?=$username?>" class="form-control" placeholder="">
							  </div>
						   </div>
					   </div>
					</div>


					<div class="form-group">
					  <?
						include "../../smarteditor/SmartEditor.php";
					  ?>
					</div>

					<!-- <div class="form-group">
					  <label for="tag">태그</label>
						<?
						if($tag) {
							$tag = "'".str_replace(",","','",$tag)."'";
						}
						?>
					  <textarea id="tagstyle1" name="tag" value="<?=$tag?>" class="form-control"></textarea>
					</div> -->

					<div class="form-group">
					  <label for="user_file">첨부파일</label>
					  <input type="file" name="user_file" id="user_file" value="" class="form-control">
						<?
						if($user_file!="") {
							?>
							  <p class="help-block"><a href="../../common/download.php?fl=<?=$foldername?>&fi=<?=$user_file?>"><?=$user_file?></a></p>
							<?
						}

						$user_file = "";
						?>
					</div>


					<div class="form-group">
					  <label for="vodpath">영상</label>
					  <div class="row">
						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">경로</button>
								</span>
								<input type="text" name="vodpath" id="vodpath" value="<?=$vodpath?>" class="form-control" placeholder="">
							  </div>
						   </div>

						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">파일1</button>
								</span>
								<input type="text" name="vodfile1" id="vodfile1" value="<?=$vodfile1?>" class="form-control" placeholder="">
							  </div>
						   </div>

						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">파일2</button>
								</span>
								<input type="text" name="vodfile2" id="vodfile2" value="<?=$vodfile2?>" class="form-control" placeholder="">
							  </div>
						   </div>

						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">파일3</button>
								</span>
								<input type="text" name="vodfile1" id="vodfile1" value="<?=$vodfile1?>" class="form-control" placeholder="">
							  </div>
						   </div>
					   </div>
					</div>

					<div class="form-group">
					  <label for="bfilepath">파일</label>
					  <div class="row">
						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">경로</button>
								</span>
								<input type="text" name="bfilepath" id="bfilepath" value="<?=$bfilepath?>" class="form-control" placeholder="">
							  </div>
						   </div>

						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">파일1</button>
								</span>
								<input type="text" name="bfile1" id="bfile1" value="<?=$bfile1?>" class="form-control" placeholder="">
							  </div>
						   </div>

						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">파일2</button>
								</span>
								<input type="text" name="bfile2" id="bfile2" value="<?=$bfile2?>" class="form-control" placeholder="">
							  </div>
						   </div>

						  <div class="col-xs-2">
							  <div class="input-group input-group-sm">
								<span class="input-group-btn">
								  <button type="button" class="btn btn-info">파일3</button>
								</span>
								<input type="text" name="bfile1" id="bfile1" value="<?=$bfile1?>" class="form-control" placeholder="">
							  </div>
						   </div>
					   </div>
					</div>
				</div>
				<!-- /.box-body -->

				<div class="box-footer">
					<button type="text" class="btn btn-default" onClick="fn_cancel()">취소</button>
					<button type="text"  onclick="submitContents(this);" class="btn btn-primary pull-right">확인</button>
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