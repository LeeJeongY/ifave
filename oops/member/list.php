<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";


	if($_t=="") $_t = "members"; 				//테이블 이름
	$foldername = "../../$upload_dir/$_t/";

	if($page == '') $page = 1; 					//페이지 번호가 없으면 1
	$list_num = 30; 							//한 페이지에 보여줄 목록 갯수
	$page_num = 10; 							//한 화면에 보여줄 페이지 링크(묶음) 갯수
	$offset = $list_num*($page-1); 				//한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "?_t=$_t&s_site_kind=$s_site_kind&client_code=$client_code&search_chk=$search_chk&s_regdate=$s_regdate&s_user_state=$s_user_state&s_email_flag=$s_email_flag&s_sms_flag=$s_sms_flag&search=$search&search_text=$search_text&popup=$popup&menu_b=$menu_b&menu_m=$menu_m&";


	if ($search_text != "") {
		$search_text   = trim(stripslashes(addslashes($search_text)));
		if($search == "all") {
			$qry_where .= " AND (";
			$qry_where .= " user_name like '%$search_text%'";
			$qry_where .= " OR user_id like '%$search_text%'";
			$qry_where .= " OR user_hp like '%$search_text%'";
			$qry_where .= " OR user_email like '%$search_text%'";
			$qry_where .= " OR client_name like '%$search_text%'";
			$qry_where .= ")";
		} else {
			$qry_where .= " AND $search like '%$search_text%'";
		}
	}

	if($s_regdate) {
		list($start_date, $end_date) = explode("-",trim($s_regdate));
		$start_date = str_replace("/","",trim($start_date));
		$end_date = str_replace("/","",trim($end_date));

		$qry_where .= " AND replace(left(regdate,10),'-','')>='".$start_date."' ";
		$qry_where .= " AND replace(left(regdate,10),'-','')<='".$end_date."' ";
	}

	if($s_site_kind)	$qry_where .= " AND site_kind	= '".$s_site_kind."' ";
	if($client_code)	$qry_where .= " AND client_code	= '".$client_code."' ";
	if($s_user_state)	$qry_where .= " AND user_state  = '".$s_user_state."' ";
	if($s_email_flag)	$qry_where .= " AND email_flag  = '".$s_email_flag."' ";
	if($s_sms_flag)		$qry_where .= " AND sms_flag	= '".$s_sms_flag."' ";

	$query  ="SELECT count(idx) as cnt FROM ".$initial."_".$_t." WHERE idx IS NOT NULL ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array=mysql_fetch_array($result)) {
		$total_no		= $array[cnt];
	}

	$total_page = ceil($total_no/$list_num);
	$cur_num = $total_no - $list_num*($page-1);

	$query  = "SELECT * FROM ".$initial."_".$_t." WHERE idx IS NOT NULL ";
	$query .= $qry_where;
	$query .= " ORDER BY regdate DESC LIMIT $offset, $list_num";
	//echo $query;
	$result = mysql_query($query, $dbconn) or die (mysql_error());


	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>
<script language="javascript">
<!--
function go_state(idx,str) {
	var fm = document.form;
	fm.gubun.value = "state";
	fm.idx.value = idx;
	fm.active_flag.value = str;
	fm.method = "post";
	fm.action = "write_ok.php";
	fm.submit();
}

function go_excel() {
	var fm = document.schform;
	fm.method = "post";
	fm.action = "excel_list.php";
	fm.submit();
}

$(document).ready(function(){
	$("#search_chk").click(function(){
		if($("#search_chk").is(":checked")) {
			//$(".s_date_flag").show();
			$("#app_date").attr( 'disabled', false );
		} else {
			//$(".s_date_flag").hide();
			$("#app_date").attr( 'disabled', true );
		}
	});
});


function go_edit(str) {

	var url_page = "write.php?idx="+str+"&popup=1&gubun=update";
	var w = "750";
	var h = "650";
	var win = window.open(url_page, "_write", 'width='+w+',height='+h+', menubar=0, scrollbars=1, resizable=1');
	win.focus();


}
//-->
</script>
<style>
/*@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {*/
@media only screen and (max-width: 800px) {
  #_table_ table, thead, tbody, tr, th, td{
	display:block;
  }
  #_table_ thead tr{
	position:absolute;
	top:-9999px;
	left:-9999px;
  }
  #_table_ tr {
	border-bottom:1px solid #ccc;
  }
  #_table_ td {
	border: none;
	border-bottom: 1px solid #eee;
	position: relative;
	padding-left: 50%;
	white-space: normal;
	text-align:left;
  }
  #_table_ td:before {
	/* Now like a table header */
	position: absolute;
	/* Top/left values mimic padding */
	top: 6px;
	left: 6px;
	width: 45%;
	padding-right: 10px;
	/*white-space: nowrap;*/
	text-align:left;
	font-weight: bold;
  }
  #_table_ th {
	display:none;
  }
 #_table_  td:before{content: attr(data-title);}
 #_table_ td:nth-child(8),
 #_table_ th:nth-child(8) {display: none;}
}
</style>
<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="active_flag">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="client_code" value="<?=$client_code?>">
<input type="hidden" name="s_site_kind" value="<?=$s_site_kind?>">
<input type="hidden" name="popup" id="pop" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
</form>


  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup-":""?>content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        회원 관리
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

			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="list.php?_t=<?=$_t?>&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>">회원관리</a></li>
					<li><a href="log_list.php?_t=<?=$_t?>&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>">회원접속내역</a></li>
				</ul>
			</div>

			<form method="get" action="<?=$PHP_SELF?>" name="schform">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
			<input type="hidden" name="menu_t" value="<?=$menu_t?>">
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="client_code" value="<?=$client_code?>">
            <div class="box-header">
              <h3 class="box-title">Total : <?=$total_no?>, <?=$page?> / <?=$total_page?> page</h3>


              <div class="box-tools">
                <div class="input-group input-group-sm">
					<div class="input-group col-xs-12">

						<label for="search_chk" style="width:120px;">
						<input type="checkbox" name="search_chk" id="search_chk" class="flat-red" value="Y" <?=$search_chk=="Y"?"checked":""?>>
						가입일 검색
						</label>

						<div class="input-group-addon s_date_flag"  data-toggle="tooltip" data-container="body" title="가입일 기준 검색">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control s_date_flag" name="s_regdate" value="<?=$s_regdate?>" id="app_date" style="width:200px;" <?if($search_chk!="Y") {?>disabled<?}?>/>

						<select name="s_site_kind" class="select2" style="width:80px;">
							<option value="" <? echo $s_site_kind == ""?"selected":"";?>>사이트</option>
							<option value="ko" <? echo $s_site_kind == "ko"?"selected":"";?>>국문</option>
							<option value="en" <? echo $s_site_kind == "en"?"selected":"";?>>영문</option>
						</select>

						<select name="s_email_flag" class="select2" style="width:80px;">
							<option value="" <? echo $s_email_flag == ""?"selected":"";?>>이메일</option>
							<option value="Y" <? echo $s_email_flag == "Y"?"selected":"";?>>허용</option>
							<option value="N" <? echo $s_email_flag == "N"?"selected":"";?>>거부</option>
						</select>

						<select name="s_sms_flag" class="select2" style="width:80px;">
							<option value="" <? echo $s_sms_flag == ""?"selected":"";?>>SMS</option>
							<option value="Y" <? echo $s_sms_flag == "Y"?"selected":"";?>>허용</option>
							<option value="N" <? echo $s_sms_flag == "N"?"selected":"";?>>거부</option>
						</select>

						<select name="s_user_state" class="select2" style="width:80px;">
							<option value="" <? echo $s_user_state == ""?"selected":"";?>>권한</option>
							<option value="1" <? echo $s_user_state == "1"?"selected":"";?>>승인</option>
							<option value="2" <? echo $s_user_state == "2"?"selected":"";?>>신청</option>
						</select>
						<select name="search" class="select2" style="width:80px;">
							<option value="all" <? echo $search == "all"?"selected":"";?>>전체</option>
							<option value="user_name" <? echo $search == "user_name"?"selected":"";?>>회원명</option>
							<option value="user_id" <? echo $search == "user_id"?"selected":"";?>>아이디</option>
							<option value="user_hp" <? echo $search == "user_hp"?"selected":"";?>>휴대폰</option>
							<option value="user_email" <? echo $search == "user_email"?"selected":"";?>>이메일</option>
						</select>

						<input type="text" name="search_text" value="<?=$search_text?>" class="form-control pull-right" placeholder="Search" style="width: 150px;">

						<div class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
					</div>
                </div>
              </div>
            </div>
			</form>

            <div class="box-footer clearfix">
              <a type="submit" class="btn btn-sm btn-primary" href="javascript:_popup_page('write.php?popup=1','_write','750','600');"><i class="fa fa-plus"></i> 추가</a>
              <a type="text" class="btn btn-sm btn-default" href="javascript:go_remove();"><i class="fa fa-minus"></i> 삭제</a>
			  <a type="text" class="btn btn-sm btn-success" href="javascript:go_excel();"><i class="fa fa-file-excel-o"></i> Excel</a>
              <ul class="pagination pagination-sm no-margin pull-right">
				<?=fn_page($total_page, $page_num, $page, $link_url)?>
              </ul>
            </div>

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
                  <th nowrap width="10"><input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"></th>
                  <th nowrap width="20">No</th>
                  <th nowrap width="80">구분</th>
                  <th nowrap>회원정보</th>
                  <th nowrap width="120">최근 로그인</th>
                  <th nowrap width="120">연락정보</th>
                  <th nowrap width="100">개인정보</th>
                  <th nowrap width="60">수신여부</th>
                  <th nowrap width="50">권한</th>
                  <th nowrap width="120">가입일</th>
                  <th nowrap width="60">관리</th>
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
                  <td nowrap data-title="선택"><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$idx?>" class="idxchk flat-red"></td>
                  <td nowrap data-title="번호"><?=$idx?></td>
                  <td nowrap data-title="사이트구분">
				   <?if(preg_match("/ko/i", $site_kind)) {?><b class="label label-warning">국문</b> <?}?>
				   <?if(preg_match("/en/i", $site_kind)) {?><b class="label label-success">영문</b> <?}?>
				  </td>
                  <td nowrap data-title="회원정보" class="f11">
				  회원명 : <a href="javascript:go_memberinfo('<?=$user_id?>');" data-toggle="tooltip" data-container="body" title="'<?=$user_name?>' 회원정보 상세보기"><?=$user_name?></a>
				  <br/>아이디 : <a href="javascript:go_login('<?=$user_id?>');" data-toggle="tooltip" data-container="body" title="'<?=$user_id?>'로 로그인합니다"><?=$user_id?></a>
				  <?if($client_name) {?><br/>소속 기관명 : <a href="javascript:go_clientinfo('<?=$client_code?>');" data-toggle="tooltip" data-container="body" title="'소속기관정보 상세보기"><?=$client_name?></a><?}?>
				  </td>
                  <td nowrap data-title="최근 로그인 정보" class="f11">
				  <a href="javascript:go_conn_log('<?=$user_id?>');"><?=$last_login=="0000-00-00 00:00:00"?"-":"$last_login"?></a>
				  </td>
                  <td nowrap data-title="연락 정보" class="f11">
				  휴대폰 : <a href="javascript:go_sms('<?=$user_id?>','<?=$user_hp?>','<?=$sms_flag?>');" data-toggle="tooltip" data-container="body" title="'<?=$user_hp?>'로 문자보내기"><?=$user_hp?></a>
				  <br/>이메일 : <a href="javascript:go_email('<?=$user_id?>','<?=$user_email?>','<?=$email_flag?>');" data-toggle="tooltip" data-container="body" title="'<?=$user_email?>'로 메일보내기"><?=$user_email?></a>
				  <br/>회원코드 : <?=$user_code?>
				  </td>
                  <td nowrap data-title="개인 정보" class="f11">
				  생년월일 : <?=$user_birth?>
				  <br/>음/양력 : <?=$user_calendar=="solar"?"양력":"음력"?>
				  <br/>성별 : <?=$user_sex=="M"?"남":"여"?>
				  </td>
                  <td nowrap data-title="수신여부" class="f11">
				  EMAIL : <?=$email_flag=="Y"?"허용":"<span style='color:#ff0000;'>거부</span>"?>
				  <br/>SMS : <?=$sms_flag=="Y"?"허용":"<span style='color:#ff0000;'>거부</span>"?>
				  </td>
				  <td nowrap data-title="상태">
				  <a class="label <?if($user_state==1) {?>label-success<?} else if($user_state==2) {?>label-warning<?} else if($user_state==0) {?>label-primary<?} else {?>label-danger<?}?>" <?if($user_state=="1") {?>onclick="go_state('<?=$idx?>','0');"  data-toggle="tooltip" data-container="body" title="클릭시 차단"<?} else {?>onclick="go_state('<?=$idx?>','1');" title="클릭시 승인"<?}?>>
				  <?if($user_state=="1") {?>
				  승인
				  <?} else if($user_state=="2") {?>
				  가입신청
				  <?} else if($user_state=="0") {?>
				  해지
				  <?}?>
				  </a>
				  </td>
                  <td nowrap data-title="가입일" class="f11">
				  <?=$regdate?>
				  <?if($udtdate) {?><br/><?=$udtdate?><?}?>
				  <?if($candate) {?><br/><?=$candate?><?}?>
				  </td>
                  <td nowrap data-title="관리">
				  <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
				  <button type="button" class="btn btn-flat btn-xs btn-danger" onClick="go_delete('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
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
              <a type="submit" class="btn btn-sm btn-primary" href="javascript:_popup_page('write.php?popup=1','_write','750','600');"><i class="fa fa-plus"></i> 추가</a>
              <a type="text" class="btn btn-sm btn-default" href="javascript:go_remove();"><i class="fa fa-minus"></i> 삭제</a>
			  <a type="text" class="btn btn-sm btn-success" href="javascript:go_excel();"><i class="fa fa-file-excel-o"></i> Excel</a>
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