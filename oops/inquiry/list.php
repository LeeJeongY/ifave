<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t = "inquiry";
	$foldername  = "../$upload_dir/$_t/";

	//게시판 정보
	include "../../modules/boardinfo.php";

	if($page == '') $page = 1;
	$list_num = 30;
	$page_num = 10;
	$offset = $list_num*($page-1);

	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "$PHP_SELF?_t=$_t&search=$search&search_text=$search_text&type=$type&cate=$cate&category=$category&";

	if($search_text != "") $qry_where .= " AND (title like '%$search_text%' OR user_name LIKE '%$search_text%' OR contents LIKE '%$search_text%' OR user_email LIKE '%$search_text%' OR user_tel LIKE '%$search_text%')" ;
	if($category != "") $qry_where .= " AND category = '$category'";

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
	$query .= " FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT null ";
	$query .= $qry_where;
	$query .= " ORDER BY idx DESC LIMIT $offset, $list_num";
	$result = mysql_query($query, $dbconn) or die (mysql_error());


	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
	//게시판 모바일 css
	include "../js/board_mobile.css.php";
?>
<script language="javascript">
<!--
function fn_category(param) {

	var frm = document.form;
	var cate = "";
	frm.idx.value = param;
	cate_form = eval("document.liform.cate"+param);
	cate = cate_form.selectedIndex;
	frm.category.value = cate_form.options[cate].value;

	frm.gubun.value = "category";
	frm.action = "category_ok.php";
	frm.submit();
}

<?if($cate == "Y") {?>
function go_cate(str) {
	document.fm.category.value = str;
	document.fm.submit();
}
<?}?>
//-->
</script>


<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="type" value="<?=$type?>">
<input type="hidden" name="cate" value="<?=$cate?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
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
			<form method="get" action="<?=$PHP_SELF?>" name="schform">
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="gubun">
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="type" value="<?=$type?>">
			<input type="hidden" name="cate" value="<?=$cate?>">
            <div class="box-header">
              <h3 class="box-title">Total : <?=$total_no?>, <?=$page?> / <?=$total_page?> page</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="search_text" value="<?=$search_text?>" class="form-control pull-right" placeholder="Search">

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
              <table class="table table-hover" id="_table_">
			  <tbody>
                <tr>
                  <th nowrap width="10"><input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"></th>
                  <th nowrap width="20">No</td>
                  <th nowrap width="100">구분</td>
                  <th nowrap width="120">신청자명</td>
                  <!-- <th nowrap width="120">소속</td> -->
                  <th nowrap>제목</th>
                  <th nowrap width="100">연락처</td>
                  <th nowrap width="100">이메일</td>
                  <!-- <th nowrap width="100">문의유형</td> -->
                  <th nowrap width="80">상태</td>
                  <th nowrap width="100">IP</td>
                  <th nowrap width="60">등록일</td>
				<?if($SUPER_ULEVEL <= 2) {?>
                  <th nowrap width="60">관리</td>
				<?}?>
                </tr>

				<?
				if($total_no == 0) {
				?>
                <tr>
                  <td align="center" colspan="12">등록된 정보가 없습니다.</td>
                </tr>
				<?
				} else {
					while ($array = mysql_fetch_array($result)) {
						$rot_num += 1;
						$idx		= $array[idx];
						$category	= $array[category];
						$title		= db2html($array[title]);
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
				?>
                <tr>
                  <td nowrap class="chk"><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$idx?>" class="idxchk flat-red"></td>
                  <td nowrap class="idx"><?=$idx?></td>
                  <td nowrap class="category">
					<?=$category=="01"?"문의하기":""?>
					<?=$category=="02"?"제안하기":""?>
					<?=$category=="03"?"채용문의":""?>
				  </td>
                  <td nowrap class="username"><?=$user_name?></td>
                  <!-- <td nowrap class="download">
				  <?=$user_group?>
				  </td> -->
                  <td nowrap class="title">
					<a href="javascript:_popup_page('view.php?idx=<?=$idx?>&_t=<?=$_t?>&popup=1','_preview','750','600');"><?=$title?></a>&nbsp;<?=$new_img?>
				  </td>
                  <td nowrap class="download">
				  <?=$user_tel?>
				  </td>
                  <td nowrap class="download">
				  <?=$user_email?>
				  </td>
                  <!-- <td nowrap class="download">
				  <?=getCodeNameDB("code_question_type", $question_type, $dbconn)?>
				  </td> -->
                  <td nowrap class="counts">
					<?=$user_state=="0"?"신청":""?>
					<?=$user_state=="1"?"확인":""?>
					<?=$user_state=="2"?"완료":""?>
				  </td>
                  <td nowrap class="date">
				  <?=$user_ip?>
				  </td>
                  <td nowrap class="date">
				  <?=$regdate?>
				  </td>
				<?if($SUPER_ULEVEL <= 2) {?>
				<?if($cate == "Y") {?>
                  <td nowrap class="modify">
				  <select name="cate<?=$idx?>" onChange="fn_category('<?=$idx?>')">
				  <option value="">+선택+</option>
				  <?=getCodeNameSelectDB($_t, $category, $dbconn)?>
				  </select>
				  </td>
				<?}?>
                  <td nowrap class="admin">
				  <!-- <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button> -->
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
              <!-- <a type="submit" class="btn btn-sm btn-primary" href="write.php?_t=<?=$_t?>"><i class="fa fa-plus"></i> 추가</a> -->
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