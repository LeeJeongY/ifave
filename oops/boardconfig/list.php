<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "master"; 				//테이블 이름
	$foldername  = "../../$upload_dir/$_t/";

	if($page == '') $page = 1;
	$list_num = 10;
	$page_num = 10;
	$offset = $list_num*($page-1);

	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "$PHP_SELF?search=$search&search_text=$search_text&_t=$_t&";

	if ($search_text != "") $qry_where .= " and $search like '%$search_text%'" ;

	$query = "SELECT count(idx) as cnt FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT NULL ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array=mysql_fetch_array($result)) {
		$total_no	= $array[cnt];
	}

	$total_page = ceil($total_no/$list_num);
	$cur_num = $total_no - $list_num*($page-1);

	$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT NULL ";
	$query .= $qry_where;
	$query .= " ORDER BY signdate DESC LIMIT $offset, $list_num";
	$result = mysql_query($query, $dbconn) or die (mysql_error());

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
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" id="pop" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
</form>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
        <div class="col-xs-12">
          <div class="box">
			<form method="get" action="<?=$PHP_SELF?>" name="schform">
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="gubun">
			<input type="hidden" name="_t" value="<?=$_t?>">
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
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
              <table class="table table-hover" id="_table_">
			  <tbody>
                <tr>
                  <th nowrap width="10"><input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"></th>
                  <th nowrap width="20">No</td>
                  <th nowrap width="100">사용여부</td>
                  <th nowrap>게시판명(ID)</th>
                  <th nowrap width="100">게시물수</td>
                  <th nowrap width="100">바로가기</td>
                  <th nowrap width="100">종류</td>
                  <th nowrap width="100">타입</td>
                  <th nowrap width="100">분류여부</td>
                  <th nowrap width="100">분류코드</td>
                  <th nowrap width="100">등록일</td>
                  <th nowrap width="120">관리</td>
                </tr>
				<?
				if($total_no == 0) {
				?>
                <tr>
                  <td align="center" colspan="10">등록된 정보가 없습니다.</td>
                </tr>
				<?
				} else {
					while ($array = mysql_fetch_array($result)) {
						$rot_num += 1;
						$idx			= $array[idx];
						$use_flag		= stripslashes($array[use_flag]);			//사용여부(Y, N)
						$bbs_name		= db2html(stripslashes($array[bbs_name]));	//제목
						$bbs_id			= db2html(stripslashes($array[bbs_id]));
						$user_file		= $array[user_file];
						$bbs_type		= $array[bbs_type];
						$bbs_kind		= $array[bbs_kind];
						$cate_flag		= $array[cate_flag];
						$cate_code		= $array[cate_code];
						$option_list	= stripslashes($array[option_list]);
						$img_flag		= stripslashes($array[img_flag]);
						$file_flag		= stripslashes($array[file_flag]);
						$counts			= $array[counts];								//조회수
						$signdate		= $array[signdate];
						//$signdate	= substr($signdate, 0, 10);

						if($use_flag=="1")			$use_flag_txt = "<span class=\"label label-success\">사용</span>";
						if($use_flag=="0")			$use_flag_txt = "<span class=\"label label-danger\">정지</span>";

						if($bbs_kind=="board")		$bbs_kind_txt = "답변형";
						if($bbs_kind=="data")		$bbs_kind_txt = "자료형";
						if($bbs_kind=="gallery")	$bbs_kind_txt = "갤러리형";
						if($bbs_kind=="inquiry")	$bbs_kind_txt = "문의/요청형";
						if($bbs_kind=="popup")		$bbs_kind_txt = "팝업";

						if($bbs_type=="list")		$bbs_type_txt = "리스트형";
						if($bbs_type=="image")		$bbs_type_txt = "이미지형";
						if($bbs_type=="multi")		$bbs_type_txt = "이미지+리스트형";
						if($bbs_type=="faq")		$bbs_type_txt = "FAQ형";
						if($bbs_type=="sns")		$bbs_type_txt = "SNS형";

						if($cate_flag=="1")			$cate_flag_txt = "<span class=\"label label-success\">사용</span>";
						if($cate_flag=="0")			$cate_flag_txt = "<span class=\"label label-danger\">미사용</span>";


						if($bbs_kind=="popup")		$page_link = "popup";
						if($bbs_kind=="inquiry")	$page_link = "inquiry";
						else						$page_link = "board";


						$sql= "select count(idx) as cnt from ".$initial."_bbs_".$bbs_id." where idx is not null";
						$rs = mysql_query($sql,$dbconn) or die (mysql_error());
						if($arr = mysql_fetch_array($rs)) {
							$tcnt	= $arr[cnt];
						}
						$sql= "select count(idx) as cnt from ".$initial."_bbs_".$bbs_id." where idx is not null and replace(left(regdate,10),'-','') = '".date("Ymd")."'";
						$rs = mysql_query($sql,$dbconn) or die (mysql_error());
						if($arr = mysql_fetch_array($rs)) {
							$cnt	= $arr[cnt];
						}
				?>
                <tr>
                  <td nowrap class="chk"><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$idx?>" class="idxchk flat-red"></td>
                  <td nowrap class="idx"><?=$idx?></td>
                  <td nowrap class="category"><?=$use_flag_txt?></td>
                  <td nowrap class="title">
					<a href="javascript:go_edit('<?=$idx?>')"><?=$bbs_name?></a>(<?=$bbs_id?>)
				  </td>
                  <td nowrap class="username">오늘 <a href="javascript:_popup_page('../<?=$page_link?>/list.php?_t=<?=$bbs_id?>&popup=1','_p','1000','900');" class="label <?if($cnt>0) {?>label-danger<?} else {?>label-default<?}?>" title="<?=$bbs_name?>"><b <?if($cnt>0) {?>style="color:yellow;"<?}?>><?=$cnt?></b></a> / 총 <?=$tcnt?></td>
                  <td nowrap class="link">
				  <!-- <a href="javascript:_popup_page('../<?=$bbs_kind?>/list.php?_t=<?=$bbs_id?>&popup=1','_p','960','900');" class="label label-default" title="<?=$bbs_name?>"><i class="fa fa-link"></i></a> -->
				  <a href="javascript:_popup_page('../<?=$page_link?>/list.php?_t=<?=$bbs_id?>&popup=1','_p','1000','900');" class="label label-default" title="<?=$bbs_name?>"><i class="fa fa-link"></i></a>
				  <!-- <a href="javascript:_popup_page('../<?=$bbs_kind?>/list.php?_t=<?=$bbs_id?>&popup=1','_p','960','900');" class="label label-default" title="<?=$bbs_name?>"><i class="fa fa-link"></i></a> -->
				  </td>
                  <td nowrap class="username"><?=$bbs_kind_txt?></td>
                  <td nowrap class="counts"><?=$bbs_type_txt?></td>
                  <td nowrap class="date"><?=$cate_flag_txt?></td>
                  <td nowrap class="modify"><?=$cate_code?></td>
                  <td nowrap class="modify"><?=$signdate?></td>
                  <td nowrap class="admin">
				  <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
				  <button type="button" class="btn btn-flat btn-xs btn-danger" onClick="go_delete('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
				  </td>
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
              <a type="submit" class="btn btn-sm btn-primary" href="write.php?_t=<?=$_t?>&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>&menu_t=<?=$menu_t?>"><i class="fa fa-plus"></i> 추가</a>
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