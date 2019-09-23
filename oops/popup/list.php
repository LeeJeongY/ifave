<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t = "popup";
	$foldername  = "../../$upload_dir/$_t/";

	if($page == '') $page = 1; 					//페이지 번호가 없으면 1
	$list_num = 20; 							//한 페이지에 보여줄 목록 갯수
	$page_num = 10; 							//한 화면에 보여줄 페이지 링크(묶음) 갯수
	$offset = $list_num*($page-1); 				//한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

	$rot_num = 0;

	$link_menu_url = "&menu_b=$menu_b&menu_m=$menu_m&";
	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "$PHP_SELF?_t=$_t&_cate=$_cate&search=$search&search_text=$search_text&".$link_menu_url;

	if ($search_text != "") {
		$search_text   = stripslashes(addslashes($search_text));
		$qry_where = $qry_where . " and $search like '%$search_text%'";
	}
	if($_cate) $qry_where .= " and category='".$_cate."'";

	$query  ="SELECT count(idx) FROM ".$initial."_bbs_".$_t." WHERE idx is not null AND nflag != '1' ";
	$query .= $qry_where;

	$result = mysql_query($query,$dbconn) or die (mysql_error());
	$row = mysql_fetch_row($result);
	$total_no = $row[0];

	$total_page = ceil($total_no/$list_num);
	$cur_num = $total_no - $list_num*($page-1);

	$query  = "SELECT * ";
	$query .= " FROM ".$initial."_bbs_".$_t." WHERE idx is not null AND nflag != '1' ";
	$query .= $qry_where;
	$query .= " ORDER BY regdate DESC limit $offset, $list_num";
	$result = mysql_query($query,$dbconn) or die (mysql_error());

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
	//게시판 모바일 css
	include "../js/board_mobile.css.php";
?>
<script type="text/javascript">
/*
$(function(){
    $("#popbutton").click(function(){
        $('div.modal').modal({remote : '../banner/layer.html'});
    });
});

function go_preview(idx, w, h) {
	alert(idx);
	$('div.modal').modal({remote : 'layer.php?idx='+idx});
}
*/

function go_preview(idx, w, h, l, t) {
	$.ajax({
		type : 'POST',
		url : 'layer.php',
		data : {'idx':idx,'gubun':'preview'},
		success : function(data) {
			$('.modal').css({position:'absolute'}).css({
				left: l,
				top: t
				/*
				left: ($(window).width() - $('.className').outerWidth())/2,
				top: ($(window).height() - $('.className').outerHeight())/2
				*/
			});

			$('div.modal').modal();
			/*
			$("#modal_body").width(w);
			$(".modal-content").css("width",w);
			*/
			$("#modal_body").html(data);
			$("#modal_body img").width("100%");
		}
	});
}
</script>


<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="cate" value="<?=$cate?>">
<input type="hidden" name="popup" id="pop" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
</form>


	<!-- 모달창 remote ajax call -->
	<div class="modal fade">
	  <div class="modal-dialog">
		<div class="modal-content">
				<p id="modal_body"></p>
		</div>
	  </div>
	</div>

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
        <div class="col-xs-12">
          <div class="box">
			<form method="post" action="<?=$PHP_SELF?>" name="schform">
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="gubun">
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="type" value="<?=$type?>">
			<input type="hidden" name="cate" value="<?=$cate?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
            <div class="box-header">
              <h3 class="box-title">Total : <?=$total_no?>, <?=$page?> / <?=$total_page?> page</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
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
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="search_text" value="<?=$search_text?>">
			<input type="hidden" name="type" value="<?=$type?>">
			<input type="hidden" name="cate" value="<?=$cate?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
              <table class="table table-hover" id="_table_">
			  <tbody>
                <tr>
                  <th nowrap width="10"><input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"></th>
                  <th nowrap width="20">No</td>
				<?if($cate == "Y") {?>
                  <th nowrap width="100">분류</td>
				<?}?>
                  <th nowrap>제목</th>
                  <th nowrap width="100">기간</td>
                  <th nowrap width="80">조회</td>
                  <th nowrap width="200">작성자</td>
                  <th nowrap width="60">등록일</td>
                  <th nowrap width="60">보기</td>
				<?if($SUPER_ULEVEL <= 2) {?>
                  <th nowrap width="120">관리</td>
				<?}?>
                </tr>

				<?
				$sql  ="SELECT count(idx) as cnt FROM ".$initial."_bbs_".$_t." WHERE idx is not null AND nflag = '1' ";
				$sql .= $qry_where;

				$rs = mysql_query($sql, $dbconn) or die (mysql_error());
				$ntotal_no = 0;
				if($arr = mysql_fetch_array($rs)) {
					$ntotal_no		= $arr[cnt];
				}


				$n_query  = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx is not null AND nflag ='1'";
				$n_query .= $qry_where;
				$n_query .= " ORDER BY regdate DESC";

				$n_result = mysql_query($n_query, $dbconn) or die (mysql_error());
				if($ntotal_no != 0) {
					while ($n_array = mysql_fetch_array($n_result)) {
						$n_rot_num += 1;

						$n_idx      	= stripslashes($n_array[idx]);
						$n_title    	= db2html($n_array[title]);
						$n_body     	= db2html($n_array[body]);
						$n_category 	= stripslashes($n_array[category]);
						$n_popup_flag	= stripslashes($n_array[popup_flag]);
						$n_counts   	= stripslashes($n_array[counts]);
						$n_user_file	= stripslashes($n_array[user_file]);
						$n_img_file 	= stripslashes($n_array[img_file]);
						$n_nflag    	= stripslashes($n_array[nflag]);
						$n_list_add 	= stripslashes($n_array[list_add]);
						$n_scrollbar	= stripslashes($n_array[scrollbar]);
						$n_ptop     	= stripslashes($n_array[ptop]);
						$n_pleft    	= stripslashes($n_array[pleft]);
						$n_width    	= stripslashes($n_array[width]);
						$n_height   	= stripslashes($n_array[height]);
						$n_winopen  	= stripslashes($n_array[winopen]);
						$n_startdate	= stripslashes($n_array[startdate]);
						$n_enddate  	= stripslashes($n_array[enddate]);
						$n_pageurl  	= stripslashes($n_array[pageurl]);
						$n_mapflag  	= stripslashes($n_array[mapflag]);
						$n_image_map	= stripslashes($n_array[image_map]);
						$n_tag			= stripslashes($n_array[tag]);
						$n_view_flag	= stripslashes($n_array[view_flag]);
						$n_userid   	= stripslashes($n_array[userid]);
						$n_username 	= db2html($n_array[username]);
						$n_regdate  	= stripslashes($n_array[regdate]);
						$n_upddate  	= stripslashes($n_array[upddate]);
						$n_vodpath  	= stripslashes($n_array[vodpath]);
						$n_vodfile1 	= stripslashes($n_array[vodfile1]);
						$n_vodfile2 	= stripslashes($n_array[vodfile2]);
						$n_vodfile3 	= stripslashes($n_array[vodfile3]);
						$n_bfilepath	= stripslashes($n_array[bfilepath]);
						$n_bfile1   	= stripslashes($n_array[bfile1]);
						$n_bfile2   	= stripslashes($n_array[bfile2]);
						$n_bfile3   	= stripslashes($n_array[bfile3]);
						//$n_regdate	= substr($n_regdate, 0, 10);


						list($_ymd,$_his) = explode(" ",$n_regdate);
						list($_year,$_month,$_day) = explode("-",$_ymd);
						list($_hour,$_min,$_sec) = explode(":",$_his);

						$_timestemp = mktime($_hour, $_min, $_sec, $_month, $_day, $_year);
						$_newdate = date("YmdHis",strtotime("+2 day", $_timestemp));
						if($_newdate > date("YmdHis")) {
							$n_new_img = "<span class=\"pull-right-container\"><small class=\"label  label-danger\">new</small></span>";
						} else {
							$n_new_img = "";
						}

						if (substr($n_regdate,0,10) == date("Y-m-d")) $n_regdate = substr($n_regdate,11,5);
						else $n_regdate = substr($n_regdate,0,10);


						if ($n_winopen == "Y") {
							if( str_replace("/","",$n_enddate) < date("Ymd")) $n_strDate  = "<font color='#FF3300'>" . $n_startdate . " ~ " . $n_enddate . "</font>";
							else $n_strDate  = "<font color='#339900'>" . $n_startdate . " ~ " . $n_enddate . "</font>";
						} else {
							$n_strDate  = "-";
						}

						//댓글
						$n_sql="SELECT count(idx) as cnt FROM ".$initial."_bbs_boardcomment WHERE idx is not null AND idx = '$n_idx' and tbl ='$_t'";
						$n_rs=mysql_query($n_sql, $dbconn) or die (mysql_error());
						if($n_arr = mysql_fetch_array($n_rs)) {
							$n_cnt		= $n_arr[cnt];
						}

				?>
                <tr>
                  <td nowrap class="chk"><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$n_idx?>" class="idxchk flat-red"></td>
                  <td nowrap class="notice">
					<span class="pull-right-container">
						<small class="label bg-green">공지</small>
					</span>
				  </td>

				<?if($n_cate == "Y") {?>
                  <td nowrap class="category">
					<?=getMCodeNameDB($_t, $n_category,$dbconn)?>
				  </td>
				<?}?>
                  <td nowrap class="title">
					<small class="label <?=$view_flag=="1"?"label-primary":"label-warning"?>"><?=$arrViewFlag[$view_flag]?></small>
					<a href="javascript:go_view('<?=$n_idx?>')";><?=$n_title?></a> <?=$n_new_img?></span>
					<?if($n_cnt > 0) {?>[<span style="font-size:0.9em;color:#cc3300;"><?=$n_cnt?></span>]<?}?>
				  </td>
                  <td nowrap class="date">
				  <?=$n_strDate?>
				  </td>
                  <td nowrap class="counts">
					<?=$n_counts?>
				  </td>
                  <td nowrap class="username"><?=$n_username?><?if($n_userid!="") {?>(<?=$n_userid?>)<?}?></td>
                  <td nowrap class="date">
				  <?=$n_regdate?>
				  </td>
                  <td nowrap class="modify">
					<? if($n_winopen == "Y") { ?>
					<? if($n_popup_flag=="window") {	//새창?>
					<a href="javascript:_popup_page('preview.php?idx=<?=$n_idx?>&popup=1','_popup','<?=$n_width?>','<?=$n_height?>');" class="label label-success" title="미리보기"><i class="fa fa-eye"></i></a>
					<? } else if($n_popup_flag=="layer") { //레이어팝업?>
					<a href="javascript:go_preview('<?=$n_idx?>','<?=$n_width?>','<?=$n_height?>','<?=$n_pleft?>','<?=$n_ptop?>');" class="label label-success" title="미리보기"><i class="fa fa-eye"></i></a>
					<? } ?>

					<? } else { ?>
					-
					<? } ?>
				  </td>
				<?if($SUPER_ULEVEL <= 2) {?>
                  <td nowrap class="admin">
				  <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$n_idx?>')" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
				  <button type="button" class="btn btn-flat btn-xs btn-danger" onClick="go_delete('<?=$n_idx?>')" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
				  </td>
				<?}?>
                </tr>
				<?
					}
				}
				//공지 게시물 끝
				?>


				<?
				if($total_no == 0 && $n_total_no == 0) {
				?>
                <tr>
                  <td align="center" colspan="10">등록된 정보가 없습니다.</td>
                </tr>
				<?
				} else {
					while ($array = mysql_fetch_array($result)) {
						$rot_num += 1;
						$idx        = stripslashes($array[idx]);
						$title      = db2html($array[title]);
						$body       = db2html($array[body]);
						$category   = stripslashes($array[category]);
						$popup_flag	= stripslashes($array[popup_flag]);
						$counts     = stripslashes($array[counts]);
						$user_file  = stripslashes($array[user_file]);
						$img_file   = stripslashes($array[img_file]);
						$nflag      = stripslashes($array[nflag]);
						$list_add   = stripslashes($array[list_add]);
						$scrollbar  = stripslashes($array[scrollbar]);
						$ptop       = stripslashes($array[ptop]);
						$pleft      = stripslashes($array[pleft]);
						$width      = stripslashes($array[width]);
						$height     = stripslashes($array[height]);
						$winopen    = stripslashes($array[winopen]);
						$startdate  = stripslashes($array[startdate]);
						$enddate    = stripslashes($array[enddate]);
						$pageurl    = stripslashes($array[pageurl]);
						$mapflag    = stripslashes($array[mapflag]);
						$image_map  = stripslashes($array[image_map]);
						$tag		= stripslashes($array[tag]);
						$view_flag  = stripslashes($array[view_flag]);
						$userid     = stripslashes($array[userid]);
						$username   = db2html($array[username]);
						$regdate    = stripslashes($array[regdate]);
						$upddate    = stripslashes($array[upddate]);
						$vodpath    = stripslashes($array[vodpath]);
						$vodfile1   = stripslashes($array[vodfile1]);
						$vodfile2   = stripslashes($array[vodfile2]);
						$vodfile3   = stripslashes($array[vodfile3]);
						$bfilepath  = stripslashes($array[bfilepath]);
						$bfile1     = stripslashes($array[bfile1]);
						$bfile2     = stripslashes($array[bfile2]);
						$bfile3     = stripslashes($array[bfile3]);
						//$regdate	= substr($regdate, 0, 10);

						list($_ymd,$_his) = explode(" ",$regdate);
						list($_year,$_month,$_day) = explode("-",$_ymd);
						list($_hour,$_min,$_sec) = explode(":",$_his);

						$_timestemp = mktime($_hour, $_min, $_sec, $_month, $_day, $_year);
						$_newdate = date("YmdHis",strtotime("+2 day", $_timestemp));
						if($_newdate > date("YmdHis")) {
							$new_img = "<span class=\"pull-right-container\"><small class=\"label  label-danger\">new</small></span>";
						} else {
							$new_img = "";
						}

						if (substr($regdate,0,10) == date("Y-m-d")) $regdate = substr($regdate,11,5);
						else $regdate = substr($regdate,0,10);

						if ($winopen == "Y") {
							if( str_replace("/","",$enddate) < date("Ymd")) $strDate  = "<font color='#FF3300'>" . $startdate . " ~ " . $enddate . "</font>";
							else $strDate  = "<font color='#339900'>" . $startdate . " ~ " . $enddate . "</font>";
						} else {
							$strDate  = "-";
						}

						//댓글
						$sql= "SELECT count(idx) as cnt FROM ".$initial."_bbs_boardcomment WHERE idx is not null AND fid = '$idx' and tbl ='$_t'";
						$rs = mysql_query($sql,$dbconn) or die (mysql_error());
						if($arr = mysql_fetch_array($rs)) {
							$cnt	= $arr[cnt];
						}
				?>
                <tr>
                  <td nowrap class="chk"><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$idx?>" class="idxchk flat-red"></td>
                  <td nowrap class="idx"><?=$idx?><?//=$idx?></td>

				<?if($cate == "Y") {?>
                  <td nowrap class="category">
					<?=getMCodeNameDB($_t, $category,$dbconn)?>
				  </td>
				<?}?>
                  <td nowrap class="title">
					<small class="label <?=$view_flag=="1"?"label-primary":"label-warning"?>"><?=$arrViewFlag[$view_flag]?></small>
					<a href="javascript:go_view('<?=$idx?>')";><?=$title?></a>&nbsp;<?=$new_img?> <?if($cnt > 0) {?>[<span style="font-size:0.9em;color:#cc3300;"><?=$cnt?></span>]<?}?>
				  </td>
                  <td nowrap class="date">
				  <?=$strDate?>
				  </td>
                  <td nowrap class="counts">
					<?=$counts?>
				  </td>
                  <td nowrap class="username"><?=$username?><?if($userid!="") {?>(<?=$userid?>)<?}?></td>
                  <td nowrap class="date">
				  <?=$regdate?>
				  </td>
                  <td nowrap class="modify">
					<? if($winopen == "Y") { ?>
					<? if($popup_flag=="window") {	//새창?>
					<a href="javascript:_popup_page('preview.php?idx=<?=$idx?>&popup=1','_popup','<?=$width?>','<?=$height?>');" class="label label-success" title="미리보기"><i class="fa fa-eye"></i></a>
					<? } else if($popup_flag=="layer") { //레이어팝업?>
					<a href="javascript:go_preview('<?=$idx?>','<?=$width?>','<?=$height?>','<?=$pleft?>','<?=$ptop?>');" class="label label-success" title="미리보기"><i class="fa fa-eye"></i></a>
					<? } ?>
					<? } else { ?>
					-
					<? } ?>
				  </td>
				<?if($SUPER_ULEVEL <= 2) {?>
                  <td nowrap class="admin">
				  <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
				  <button type="button" class="btn btn-flat btn-xs btn-danger" onClick="go_delete('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
				  </td>
				<?}?>
                </tr>
				<?
						$cur_num --;
					}
				}
				?>
				</tbody>
              </table>

			</form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a type="submit" class="btn btn-sm btn-primary" href="write.php?_t=<?=$_t?>&popup=<?=$popup?>&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>"><i class="fa fa-plus"></i> 추가</a>
              <a type="text" class="btn btn-sm btn-default" href="javascript:go_remove();"><i class="fa fa-minus"></i> 삭제</a>

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
  <!-- /.content-wrapper -->

<?
include "../inc/footer.php";
mysql_close($dbconn);
?>
