<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";


	if($_t=="") $_t	= "members"; 				//테이블 이름
	$foldername = "../../$upload_dir/$_t/";

	if($page == '') $page = 1; 					//페이지 번호가 없으면 1
	$list_num = 30; 							//한 페이지에 보여줄 목록 갯수
	$page_num = 10; 							//한 화면에 보여줄 페이지 링크(묶음) 갯수
	$offset = $list_num*($page-1); 				//한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "?search=$search&search_text=$search_text&";


	if ($search_text != "") {
		$search_text   = trim(stripslashes(addslashes($search_text)));
		$qry_where .= " AND (user_name like '%$search_text%' OR client_name like '%$search_text%')";
	}

	$query  ="select count(idx) as cnt from ".$initial."_".$_t." where idx is not null ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array=mysql_fetch_array($result)) {
		$total_no		= $array[cnt];
	}

	$total_page = ceil($total_no/$list_num);
	$cur_num = $total_no - $list_num*($page-1);

	$query  = "select * ";
	$query .= " from ".$initial."_".$_t." where idx is not null ";
	$query .= $qry_where;
	$query .= " order by regdate desc limit $offset, $list_num";
	$result = mysql_query($query, $dbconn) or die (mysql_error());


	include "../inc/header_popup.php";
	//스크립트
	include "../js/goto_page.js.php";
?>
<script language="javascript">
<!--
	function go_select(uid, uname, hp, email, client_code) {
		window.opener.document.fm.user_id.value		= uid;
		window.opener.document.fm.user_name.value	= uname;
		window.opener.document.fm.user_hp.value		= hp;
		window.opener.document.fm.user_email.value	= email;
		window.opener.document.fm.client_code.value	= client_code;
		window.close();
	}
//-->
</script>
<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="active_flag">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
</form>


  <!-- Content Wrapper. Contains page content -->
  <div class="popup-content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        회원정보 관리
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 회원관리</a></li>
        <li class="active">회원정보 관리</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->


      <div class="row">
        <div class="col-xs-12">
          <div class="box">
			<form method="post" action="<?=$PHP_SELF?>" name="schform">
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
			<input type="hidden" name="menu_t" value="<?=$menu_t?>">
			<input type="hidden" name="_t" value="<?=$_t?>">
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
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="search_text" value="<?=$search_text?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
			<input type="hidden" name="menu_t" value="<?=$menu_t?>">
              <table class="table table-hover" id="_table_">
                <tr>
                  <th nowrap width="80">선택</th>
                  <th nowrap>회원명(아이디)</th>
                  <th nowrap width="60">온/오프</th>
                  <th nowrap width="50">소속</th>
                  <th nowrap width="100">휴대폰</th>
                  <th nowrap width="100">이메일</th>
                  <th nowrap width="60">권한</th>
                </tr>
				<?
				if($total_no == 0) {
				?>
                <tr>
                  <td align="center" colspan="10">등록된 정보가 없습니다.</td>
                </tr>
				<?
				} else {
					while ($array = mysql_fetch_assoc($result)) {
						$rot_num += 1;

						foreach ($array as $tmpKey => $tmpValue) {

							$$tmpKey = $tmpValue;
						}// end foreach

						$active_flag	= $array[active_flag];

						//제목자르기
						//$subject = cut_string($subject,42);
						//$subject = getNewicon2($subject,$regdate,$link);
				?>
                <tr>
                  <td nowrap data-title="선택">
				  <button type="button" class="btn btn-flat btn-xs btn-info" onClick="go_select('<?=$user_id?>','<?=$user_name?>','<?=$user_hp?>','<?=$user_email?>','<?=$client_code?>')" data-toggle="tooltip" data-container="body" title="선택"><i class="fa fa-check"></i> 선택</button>
				  </td>
                  <td nowrap data-title="이름" class="f11"><?=$user_name?>(<?=$user_id?>)</td>
                  <td nowrap data-title="온/오프구분">
				   <?if(preg_match("/on/i", $site_kind)) {?> <b class="label label-warning">온라인</b> <?}?>
				   <?if(preg_match("/off/i", $site_kind)) {?><br><b class="label label-success">오프라인</b> <?}?>
				  </td>
                  <td nowrap data-title="소속기관명" class="f11"><?=$client_name?></td>
                  <td nowrap data-title="휴대폰" class="f11"><?=$user_hp?></td>
                  <td nowrap data-title="이메일" class="f11"><?=$user_email?></td>
				  <td nowrap data-title="상태">
				  <a class="label <?if($user_state==1) {?>label-success<?} else if($user_state==2) {?>label-warning<?} else if($user_state==0) {?>label-primary<?} else {?>label-danger<?}?>" <?if($user_state=="1") {?> title="클릭시 차단"<?} else {?> title="클릭시 승인"<?}?>>
				  <?if($user_state=="1") {?>
				  승인
				  <?} else if($user_state=="2") {?>
				  가입신청
				  <?} else if($user_state=="0") {?>
				  해지
				  <?}?>
				  </a>
				  </td>
                </tr>
				<?
						$origin_list = "";
						$cur_num --;
					}
				}
				?>
              </table>
			 </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
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
include "../inc/footer_popup.php";
mysql_close($dbconn);
?>