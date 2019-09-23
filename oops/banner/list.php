<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t = "banner";
	$foldername  = "../../$upload_dir/$_t/";

	if($page == '') $page = 1; 					//페이지 번호가 없으면 1
	$list_num = 20; 							//한 페이지에 보여줄 목록 갯수
	$page_num = 10; 							//한 화면에 보여줄 페이지 링크(묶음) 갯수
	$offset = $list_num*($page-1); 				//한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
	
	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "$PHP_SELF?_t=$_t&_cate=$_cate&search=$search&search_text=$search_text&";
	
	if ($search_text != "") {
		$search_text   = stripslashes(addslashes($search_text));
		$qry_where = $qry_where . " and $search like '%$search_text%'";
	}
	if($_cate) $qry_where .= " and category='".$_cate."'";

	$query  ="SELECT count(idx) FROM ".$initial."_bbs_".$_t." WHERE idx is not null  ";
	$query .= $qry_where;

	$result = mysql_query($query,$dbconn) or die (mysql_error());
	$row = mysql_fetch_row($result);
	$total_no = $row[0];

	$total_page = ceil($total_no/$list_num);
	$cur_num = $total_no - $list_num*($page-1);

	$query  = "SELECT * ";
	$query .= " FROM ".$initial."_bbs_".$_t." WHERE idx is not null  ";
	$query .= $qry_where;
	$query .= " ORDER BY regdate DESC limit $offset, $list_num";
	$result = mysql_query($query,$dbconn) or die (mysql_error());

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
	//게시판 모바일 css
	include "../js/board_mobile.css.php";
?>
<style>
.tag-editor {
    list-style-type: none; padding: 2px 5px 0 16px; margin: 0; overflow: hidden; cursor: text;
    font: normal 12px sans-serif; color: #555; line-height: 20px;
}
.tag-pointer {float:left; padding:0px 5px; margin:2px 5px; color: #46799b; background: #e0eaf1; white-space: nowrap;overflow: hidden; cursor: pointer; border-radius: 2px 0 0 2px;}
</style>
<script language="javascript">
function go_link(idx) {
	alert('준비중');
}
</script>


<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="cate" value="<?=$cate?>">
<input type="hidden" name="banner" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
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
        <div class="col-xs-12">
          <div class="box">
			<form method="post" action="<?=$PHP_SELF?>" name="schform">
			<input type="hidden" name="banner" value="<?=$popup?>">
			<input type="hidden" name="gubun">
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="type" value="<?=$type?>">
			<input type="hidden" name="cate" value="<?=$cate?>">
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
			<input type="hidden" name="banner" value="<?=$popup?>">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="search_text" value="<?=$search_text?>">
			<input type="hidden" name="cate" value="<?=$cate?>">


            <div class="box-body">

				<div class="pad-lr-15">
					  <div class="checkbox">
						<label>
						<input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"> 선택
						</label>
					  </div>
				</div>
				<?
				if($total_no == 0) {
				?>
				<div class="attachment-block clearfix">

					<div class="attachment-pushed">

						<div class="attachment-text text-center">
						등록된 정보가 없습니다.
						</div>
						<!-- /.attachment-text -->
					</div>
				<!-- /.attachment-pushed -->
				</div>
				<?
				} else {
					while ($array = mysql_fetch_array($result)) {
						$rot_num += 1;

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
						$pageurl    = stripslashes($array[pageurl]);
						$view_flag  = stripslashes($array[view_flag]);
						$regdate    = stripslashes($array[regdate]);
						$upddate    = stripslashes($array[upddate]);


						$subject	= cut_string($title, 50, "..");
						$contents	= strip_tags($body);
						$contents_length = strlen($contents);
						$contents	= cut_string($contents,300, "..");
						$contents	= convertHashtags($contents);
						//$subject = WShortString($title, 60);

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

						if(substr($regdate,0,10) == date("Y-m-d")) $regdate = substr($regdate,11,5);
						else $regdate = substr($regdate,0,10);

						//댓글수
						$sql= "select count(idx) as cnt from ".$initial."_bbs_boardcomment where idx is not null and fid = '$idx' and tbl ='$_t'";
						$rs = mysql_query($sql,$dbconn) or die (mysql_error());
						if($arr = mysql_fetch_array($rs)) {
							$cnt	= $arr[cnt];
						}

						if( str_replace("/","",$enddate) < date("Ymd")) $strDate  = "<font color='#FF3300'>" . $startdate . " ~ " . $enddate . "</font>";
						else $strDate  = "<font color='#339900'>" . $startdate . " ~ " . $enddate . "</font>";

						//본문내용중 이미지 추출
						$body = str_replace("/$upload_dir", $image_site_url."/$upload_dir", $body);
						$_img = getImageContent($body);
						$_img_count = count($_img);
						for ($i=0; $i<$_img_count; $i++) {
							//echo $_img[$i][0]."<br>"; // 파일명
							//echo $_img[$i][1]."<P>"; // 파일명을 뺀 URL 명

							$_img_ = $_img[$i][1].$_img[$i][0];
						}


				?>
				<div class="box-body">
					<div class="attachment-block clearfix">
					<?if($img_file!="") {?>
						<a href="javascript:go_view('<?=$idx?>');"><img class="attachment-img" src="<?=$foldername?><?=$img_file?>" alt="<?=$img_file?>"></a>
					<?} else {?>
						<?if($_img_count>0) {?>
						<a href="javascript:go_view('<?=$idx?>');"><img class="attachment-img" src="<?=$_img[0][1].$_img[0][0]?>" alt="<?=$img_real_filename?>"></a>
						<?}?>
					<?}?>

						<div class="attachment-pushed">
							<h4 class="attachment-heading">
							<a href="javascript:go_view('<?=$idx?>');"><?=$title?></a></h4>

							<div class="attachment-text">
							<?=$contents?><?if($contents_length>200) {?> <a href="javascript:go_view('<?=$idx?>');">더 보기</a><?}?>
							</div>
							<!-- /.attachment-text -->
						</div>
						<div class="tag-editor">
							<div class="tag-pointer"><?=getCodeNameDB("code_banner", $category,$dbconn)?></div>

							<div class="pull-right text-muted">
							<button onClick="go_edit('<?=$idx?>');" type="button" class="btn btn-flat btn-xs btn-warning" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
							
							<button onClick="go_delete('<?=$idx?>');" type="button" class="btn btn-flat btn-xs btn-danger" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
							</div>
						</div>
					<!-- /.attachment-pushed -->
					</div>
					<!-- Social sharing buttons -->
					<input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$idx?>" class="idxchk flat-red"> 
					<small class="label <?=$view_flag=="1"?"label-primary":"label-warning"?>"><?=$arrViewFlag[$view_flag]?></small> 
					
					<button type="button" class="btn btn-default btn-xs"><i class="fa fa-calendar"></i> <?=$strDate?></button>

				<?if($pageurl) {?>
					<a href="javascript:go_link('<?=$idx?>');" class="btn btn-default btn-xs"><i class="fa fa-link"></i> <?=$pageurl?></a>
				<?}?>
					<span class="pull-right text-muted"><?if(preg_match("/like/i", $cfg_skill_list)) {?><span class="badge bg-navy" id="like_<?=$idx?>"><i class="fa fa-heart"></i> <?=$counts_like?></span> <?}?><span class="badge bg-navy"><i class="fa fa-eye"></i> <?=$cnt?></span> </span>
				</div>
				<?
						$depth_str = "";
						$tag_list = "";
						$cur_num--;
					}
				}
				?>
				</ul>
              </div>

			</form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a type="submit" class="btn btn-sm btn-primary" href="write.php?_t=<?=$_t?>"><i class="fa fa-plus"></i> 추가</a>
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