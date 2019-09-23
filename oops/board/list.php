<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t = "qna";
	//게시판 정보
	include "../../modules/boardinfo.php";
	//파일경로
	$foldername  = "../../$upload_dir/$cfg_bbs_kind/$_t/";

	if($cfg_list_counts == 0) {
		$cfg_list_counts = 10;
	}

	if($page == '') $page = 1;
	$list_num = $cfg_list_counts;	//목록수
	$page_num = 10;
	$offset = $list_num*($page-1);

	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "$PHP_SELF?_t=$_t&s_site=$s_site&search=$search&search_text=$search_text&type=$type&cfg_cate_flag=$cfg_cate_flag&category=$category&menu_b=$menu_b&menu_m=$menu_m&";

	if($tag != "")			$qry_where .= " and tag like '%$tag%'" ;
	if($search_text != "")	{
		if($search=="") $qry_where .= " and (user_name like '%$search_text%' OR title like '%$search_text%' OR body like '%$search_text%')";
		else $qry_where .= " and $search like '%$search_text%'" ;
	}
	if($category != "")		$qry_where .= " and category = '$category'";
	if($_ADMINID != "")		{
		$qry_where .= " and (adminid = '$_ADMINID')";
	}


	if($_t=="note" || $_t == "question") {
		if($s_course_id)	$qry_where .= " and course_id = '$s_course_id'";
	}

	if($s_site)	$qry_where .= " and site = '$s_site'";

	$query = "SELECT count(idx) as cnt FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT NULL ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	$total_no = 0;
	if($array = mysql_fetch_array($result)) {
		$total_no		= $array[cnt];
	}

	$total_page = ceil($total_no/$list_num);
	$cur_num = $total_no - $list_num*($page-1);

	$query  = "SELECT * ";
	$query .= " FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT NULL";
	if($cfg_bbs_type != "sns") $query .= " AND notice_yn !='1'";
	$query .= $qry_where;
	//$query .= " order by thread desc, idx asc limit $offset, $list_num";
	if($cfg_bbs_type != "sns") $query .= " ORDER BY thread DESC, pos ASC LIMIT $offset, $list_num";
	else $query .= " ORDER BY regdate DESC LIMIT $offset, $list_num";
	$result = mysql_query($query, $dbconn) or die (mysql_error());


	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
	//게시판 모바일 css
	include "../js/board_mobile.css.php";
?>
<style type="text/css">
<?if(preg_match("/tag/i", $cfg_option_list)) {?>
.tag-editor {
    list-style-type: none; padding: 2px 5px 0 16px; margin: 0; overflow: hidden; cursor: text;
    font: normal 12px sans-serif; color: #555; line-height: 20px;
}
.tag-pointer {float:left; padding:0px 5px; margin:2px 5px; color: #46799b; background: #e0eaf1; white-space: nowrap;overflow: hidden; cursor: pointer; border-radius: 2px 0 0 2px;}
<?}?>

<?if($cfg_share_media!="") {?>
#divShare {
 position:absolute;
 display:none;
 background-color:#ffffff;
 border:solid 1px #d0d0d0;
 width:auto;
 height:auto;
 padding:10px;
 z-index:100;
}
<?}?>
</style>

<script language="javascript">
<!--
<?if($cfg_share_media!="") {?>
function fn_share(idx) {
	var pos = $('#canvas'+idx).position();
	$('#divShare').css({position:'absolute'}).css({
		"position": "absolute",
		left:pos.left + 30,
		top:pos.top
		//center
		/*
		left: ($(window).width() - $('#divShare').outerWidth())/2,
		top: ($(window).height() - $('#divShare').outerHeight())/2
		*/
	}).show();
}
<?}?>
//-->
</script>

<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="_t" value="<?=$_t?>" id="_t">
<input type="hidden" name="tag" id="tag" value="">
<input type="hidden" name="cfg_cate_flag" value="<?=$cfg_cate_flag?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="s_site" value="<?=$s_site?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_s" value="<?=$menu_s?>">
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
        <div class="col-xs-12">
          <div class="box">

			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li<?=$s_site==""?" class=\"active\"":""?>><a href="?_t=<?=$_t?>&s_site=&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>">전체</a></li>
					<li<?=$s_site=="ko"?" class=\"active\"":""?>><a href="?_t=<?=$_t?>&s_site=ko&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>">국문</a></li>
					<li<?=$s_site=="en"?" class=\"active\"":""?>><a href="?_t=<?=$_t?>&s_site=en&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>">영문</a></li>
				</ul>
			</div>


			<form method="post" action="<?=$PHP_SELF?>" name="schform">
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="gubun">
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="s_site" value="<?=$s_site?>">
			<input type="hidden" name="type" value="<?=$type?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
			<input type="hidden" name="menu_s" value="<?=$menu_s?>">
            <div class="box-header">
              <h3 class="box-title">Total : <?=$total_no?>, <?=$page?> / <?=$total_page?> page</h3>

              <div class="box-tools">
				<div class="input-group input-group-sm">
					<div class="input-group col-xs-12">
					<?if($_t=="note" || $_t == "question") {?>
						<select name="s_course_id" class="select2">
							<option value="" <? echo $s_course_id == ""?"selected":"";?>>전체 과정</option>
						<?

						$cQue = "SELECT idx, bcode, mcode, content_code, subject, coach_name  FROM ".$initial."_edu_course WHERE idx IS NOT NULL " ;
						//$cQue .= " AND idx = '".$course_id."'";
						$cQue .= " ORDER BY idx DESC";
						$cRs = mysql_query($cQue,$dbconn);
						while($cArr=mysql_fetch_array($cRs)) {
							$l_course_id	= $cArr[idx];
							$l_bcode		= $cArr[bcode];
							$l_mcode		= $cArr[mcode];
							$l_content_code	= $cArr[content_code];
							$l_course_subject	= $cArr[subject];
							$l_coach_name	= $cArr[coach_name];

						?>
							<option value="<?=$l_course_id?>" <? echo $l_course_id == $s_course_id?"selected":"";?>><?=$l_course_subject?></option>
						<?}?>
						</select>

					<?}?>
						<select name="search" class="select2" style="width:100px;">
							<option value="" <? echo $search == ""?"selected":"";?>>전체</option>
							<option value="title" <? echo $search == "title"?"selected":"";?>>제목</option>
							<option value="body" <? echo $search == "body"?"selected":"";?>>내용</option>
							<option value="user_name" <? echo $search == "user_name"?"selected":"";?>>작성자</option>
						</select>
						<input type="text" name="search_text" class="form-control pull-right" placeholder="Search" value="<?=$search_text?>" style="width: 150px;">

						<div class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
					</div>
                </div>
              </div>
            </div>
			</form>

            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			<form name="listform" id="listform" method="post">
			<input type="hidden" name="gubun" id="gubun">
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="catecode" id="catecode">
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="s_site" value="<?=$s_site?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="search_text" value="<?=$search_text?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
			<input type="hidden" name="menu_s" value="<?=$menu_s?>">

			<?if($cfg_share_media!="") {?>
			<!-- 공유 버튼 -->
			<div id="divShare">
				<div class="pull-left">
				<img src="../dist/img/sns/_facebook.png" data-toggle="tooltip" data-container="body" title="페이스북">
				<img src="../dist/img/sns/_twitter.png" data-toggle="tooltip" data-container="body" title="트위트">
				<img src="../dist/img/sns/_gplus.png" data-toggle="tooltip" data-container="body" title="구글+">
				<img src="../dist/img/sns/_kaostory.png" data-toggle="tooltip" data-container="body" title="카카오스토리">
				<img src="../dist/img/sns/_band.png" data-toggle="tooltip" data-container="body" title="네이버 밴드">
				<img src="../dist/img/sns/_naver_blog.png" data-toggle="tooltip" data-container="body" title="블로그">
				</div>
				<div class="pull-right" style="padding-left:10px;">
					<i onClick="javascript:document.getElementById('divShare').style.display='none'" class="fa fa-close" style="cursor:pointer;"></i>
				</div>
			</div>
			<?}?>

			<?
			include "__".$cfg_bbs_type."__.php";
			/*
			include "__list__.php";
			include "__image__.php";
			include "__multi__.php";
			include "__faq__.php";
			include "__sns__.php";
			*/
			?>




			</form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
				<div class="btn-group">
			    <a type="submit" class="btn btn-sm btn-primary" href="write.php?_t=<?=$_t?>&s_site=<?=$s_site?>&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>&popup=<?=$popup?>"><i class="fa fa-plus"></i> 추가</a>
			    <a type="text" class="btn btn-sm btn-default" href="javascript:go_remove();"><i class="fa fa-minus"></i> 삭제</a>
				<!--
					<div class="input-group input-group-sm" style="width:150px;">
					<?if($cfg_cate_flag == "1") {?>
						<select class="form-control pull-right" name="cate" onChange="fn_category('<?=$idx?>')">
						<option value=""> - 선택 - </option>
						<?=getCodeNameSelectDB($cfg_cate_code, $category, $dbconn)?>
						</select>

						<div class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> 변경</button>
						</div>
					<?}?>
					</div>
				 -->

				</div>


				<?if($cfg_cate_flag == "1") {?>
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-warning">분류변경</button>
                  <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
					<?=getCodeNameActionDB($cfg_cate_code, $category, $dbconn)?>
                  </ul>
                </div>
				<?}?>

				<ul class="pagination pagination-sm no-margin pull-right">
					<?=fn_page($total_page, $page_num, $page, $link_url)?>
				</ul>


            </div>


          </div>
          <!-- /.box -->
        </div>
      </div>



    </section>
    <!-- /.content -->
  </div>
  <!-- /.popup-content-wrapper -->

<?
include "../inc/footer.php";
mysql_close($dbconn);
?>