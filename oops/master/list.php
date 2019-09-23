<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl	= "staff";
	$foldername	= "../../$upload_dir/$tbl/";

	if($page == '') $page = 1;
	$list_num = 30;
	$page_num = 10;
	$offset = $list_num*($page-1);

	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "?search=$search&search_text=$search_text&menu_b=$menu_b&menu_m=$menu_m&menu_t=$menu_t&";


	if ($search_text != "") {
		$search_text   = trim(stripslashes(addslashes($search_text)));
		if($search == "all") {
			$qry_where .= " AND (username like '%$search_text%' OR userid like '%$search_text%' OR remark like '%$search_text%')";
		} else {
			$qry_where .= " AND $search like '%$search_text%'";
		}
	}


	if($SUPER_ULEVEL != "1") {
		$qry_where .= " AND grade!='1'";
	}

	$query  ="select count(idx) as cnt from ".$initial."_".$tbl." where idx is not null ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array=mysql_fetch_array($result)) {
		$total_no		= $array[cnt];
	}

	$total_page = ceil($total_no/$list_num);
	$cur_num = $total_no - $list_num*($page-1);

	$query  = "select * ";
	$query .= " from ".$initial."_".$tbl." where idx is not null ";
	$query .= $qry_where;
	$query .= " order by idx desc limit $offset, $list_num";
	$result = mysql_query($query, $dbconn) or die (mysql_error());


	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>

<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="popup" id="pop" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        관리자관리
        <small>전체 관리자정보 목록</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 운영관리</a></li>
        <li class="active">관리자관리</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->


      <div class="row">
        <div class="col-xs-12">
          <div class="box">
			<form method="get" action="<?=$PHP_SELF?>" name="schform">
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
			<input type="hidden" name="gubun" id="gubun" value="<?=$gubun?>">
			<input type="hidden" name="page" id="page" value="<?=$page?>">
			<input type="hidden" name="search" id="search" value="<?=$search?>">
			<input type="hidden" name="search_text" id="search_text" value="<?=$search_text?>">
              <table class="table table-hover">
                <tr>
                  <th width="10"><input type="checkbox" name="chkall" id="chkall" value=""></th>
                  <th width="20">No</th>
                  <th>관리자정보</th>
                  <th width="200">이메일</th>
                  <th width="80">권한</th>
                  <th width="20">상태</th>
                  <th width="80">관리</th>
                </tr>
				<?
				if($total_no == 0) {
				?>
                <tr>
                  <td align="center" colspan="7">등록된 정보가 없습니다.</td>
                </tr>
				<?
				} else {
					while ($array = mysql_fetch_array($result)) {
						$rot_num += 1;

						$idx		= $array[idx];
						$sgubun		= $array[sgubun];
						$userid		= $array[userid];
						$username	= db2html($array[username]);
						$nickname	= db2html($array[nickname]);
						$tel		= $array[tel];
						$hp			= $array[hp];
						$email		= $array[email];
						$user_file	= $array[user_file];
						$grade		= $array[grade];
						$menunum	= $array[menunum];
						$active		= $array[active];
						$remoteip	= $array[remoteip];
						$lastlogin	= $array[lastlogin];
						$lastlogout	= $array[lastlogout];
						$zipcode	= $array[zipcode];
						$addr1		= db2html($array[addr1]);
						$addr2		= db2html($array[addr2]);
						$addr3		= db2html($array[addr3]);
						$birthdate	= $array[birthdate];
						$calkind	= $array[calkind];
						$duty		= $array[duty];
						$charge		= $array[charge];
						$remark		= db2html($array[remark]);
						$regdate	= $array[regdate];
						$editdate	= $array[editdate];

						$sgubun		= getCodeNameDB("code_staff", $sgubun, $dbconn);
						$duty		= getCodeNameDB("code_position", $duty, $dbconn);
						$grade_txt	= getCodeNameDB("code_admin", $grade, $dbconn);
						$charge		= getCodeNameCheckBoxDB("code_work", $charge, $dbconn);
						//등록일
						//$regdate	= substr($regdate, 0, 10);
						//수정일
						//if($editdate == "0000-00-00 00:00:00") $editdate = "-";
						//else $editdate = substr($editdate, 0, 10);

						if($user_file=="") $user_file = "noimg.png";
				?>
                <tr>
                  <td><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$idx?>" class="idxchk flat-red"></td>
                  <td><?=$idx?></td>
                  <td>
				  <div class="user-block">

				  <?if($user_file!="") {?>
				  <img class="img-circle img-bordered-sm" src="<?=$foldername?>/<?=$_t?>/<?=$user_file?>" alt="<?=$username?>">
				  <?} else {?>
				  <?}?>

					<span class="username">
					  <a href="javascript:go_edit('<?=$idx?>');"><?=$username?></a>
					  <!-- <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a> -->
					</span>
                    <span class="description"><?=$userid?> - <?=$hp?></span>
				  </div>

				  </td>
                  <td><?=$email?></td>
                  <td><span class="label label-<?if($grade=="1") {?>primary<?} else if($grade=="2") {?>danger<?} else if($grade=="3") {?>success<?}?>"><?=$grade_txt?></span></td>
                  <td><?if($active=="1") {?><span class="label label-success" class="btn btn-flat btn-xs btn-danger" data-toggle="tooltip" data-container="인증">인증</span><?} else {?><span class="label label-danger" class="btn btn-flat btn-xs btn-danger" data-toggle="tooltip" data-container="거부">거부</span><?}?></td>
                  <td>
				  <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
				  <button type="button" class="btn btn-flat btn-xs btn-danger" onClick="go_delete('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
				  </td>
                </tr>
				<?
						$cur_num --;
					}
				}
				?>
              </table>
			 </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a type="text" class="btn btn-sm btn-primary" href="javascript:_popup_page('write.php?popup=1','_write','750','600');"><i class="fa fa-plus"></i> 추가</a>
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