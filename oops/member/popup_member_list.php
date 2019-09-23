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
	$link_url = "?_t=$_t&client_code=$client_code&search=$search&search_text=$search_text&popup=$popup&menu_b=$menu_b&menu_m=$menu_m&";


	if ($search_text != "") {
		$search_text   = trim(stripslashes(addslashes($search_text)));
		if($search == "all") {
			$qry_where .= " AND (user_name like '%$search_text%' OR user_id like '%$search_text%' OR user_hp like '%$search_text%' OR user_email like '%$search_text%' OR client_name like '%$search_text%')";
		} else {
			$qry_where .= " AND $search like '%$search_text%'";
		}
	}
	if($client_code) $qry_where .= " and client_code  = '".$client_code."' ";

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
	$result = mysql_query($query, $dbconn) or die (mysql_error());


	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>
<script language="javascript">
<!--

//선택
function go_select() {
	var checked = 0;
	checked = $("#idxchk:checked").length;
	if(checked == 0) {
		alert('선택해 주세요.');
		return false;
	} else {

		$.ajax({
			url: "member_data.php",
			type: "post",
			data: $('.idxchk:checked').serialize(),
			success: function(data) {
				//alert(data);
				//return;

				/*
				var arr			= data.split('@@');
				var text		= arr[0];
				var title		= arr[1];
				var price		= arr[2];
				*/

				$('#member_data_list', opener.document).html(data);
				window.close();
			},
			error: function(data) {
				alert('error Process');
			}
		});

	}
}

//-->
</script>
<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="active_flag">
<input type="hidden" name="_t" value="<?=$_t?>">
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
        회원정보 관리
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 회원관리</a></li>
        <li class="active">회원정보</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->


      <div class="row">
        <div class="col-xs-12">
          <div class="box">

			<form method="post" action="<?=$PHP_SELF?>" name="schform">
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

						<select name="search" class="select2" style="width:80px;">
							<option value="all" <? echo $search == "all"?"selected":"";?>>전체</option>
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
              <a type="submit" class="btn btn-sm btn-primary" href="javascript:go_select();"><i class="fa fa-plus"></i> 선택</a>
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
              <table class="table table-hover">
                <tr>
                  <th nowrap width="10"><input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"></th>
                  <th nowrap>회원정보</th>
                  <th nowrap width="120">연락정보</th>
                  <th nowrap width="120">개인정보</th>
                  <th nowrap width="60">수신여부</th>
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
                  <td nowrap data-title="선택"><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$idx?>" class="idxchk flat-red"></td>
                  <td nowrap data-title="회원정보" class="f11">
				  회원명 : <a href="javascript:go_memberinfo('<?=$user_id?>');" data-toggle="tooltip" data-container="body" title="'<?=$user_name?>' 회원정보 상세보기"><?=$user_name?></a>
				  <br/>아이디 : <a href="javascript:go_login('<?=$user_id?>');" data-toggle="tooltip" data-container="body" title="'<?=$user_id?>'로 로그인합니다"><?=$user_id?></a>
				  <?if($client_name) {?><br/>소속 기관명 : <a href="javascript:go_clientinfo('<?=$client_code?>');" data-toggle="tooltip" data-container="body" title="'소속기관정보 상세보기"><?=$client_name?></a><?} else {?><br/>소속 기관명 : 없음<?}?>
				  </td>
                  <td nowrap data-title="연락 정보" class="f11">
				  휴대폰 : <a href="javascript:go_sms('<?=$user_id?>','<?=$user_hp?>','<?=$sms_flag?>');" data-toggle="tooltip" data-container="body" title="'<?=$user_hp?>'로 문자보내기"><?=$user_hp?></a>
				  <br/>이메일 : <a href="javascript:go_email('<?=$user_id?>','<?=$user_email?>','<?=$email_flag?>');" data-toggle="tooltip" data-container="body" title="'<?=$user_email?>'로 메일보내기"><?=$user_email?></a>
				  <br/>회원코드 : <?=$user_code?>
				  </td>
                  <td nowrap data-title="개인정보" class="f11">
				  생년월일 : <?=$user_birth?>
				  <br/>음/양력 : <?=$user_calendar=="solar"?"양력":"음력"?>
				  <br/>성별 : <?=$user_sex=="M"?"남":"여"?>
				  </td>
                  <td nowrap data-title="수신여부" class="f11">
				  EMAIL : <?=$email_flag=="Y"?"허용":"<span style='color:#ff0000;'>거부</span>"?>
				  <br/>SMS : <?=$sms_flag=="Y"?"허용":"<span style='color:#ff0000;'>거부</span>"?>
				  </td>
				  <td nowrap data-title="상태">
				  <span class="label <?if($user_state==1) {?>label-success<?} else if($user_state==2) {?>label-warning<?} else if($user_state==0) {?>label-primary<?} else {?>label-danger<?}?>">
				  <?if($user_state=="1") {?>
				  승인
				  <?} else if($user_state=="2") {?>
				  가입신청
				  <?} else if($user_state=="0") {?>
				  해지
				  <?}?>
				  </span>
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
              <a type="submit" class="btn btn-sm btn-primary" href="javascript:go_select();"><i class="fa fa-plus"></i> 선택</a>
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