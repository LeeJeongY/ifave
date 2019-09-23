<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";


	$tbl	= "kindcode";
	$query = "select count(kind_idx) as cnt from ".$initial."_code_".$tbl." where kind_idx is not null ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn);
	if($array=mysql_fetch_array($result)) {
		$total_no		= $array[cnt];
	}

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>

<script language="javascript">
<!--

$(document).ready(function(){
	$('#chkall').click(function(){
		var chk = $("#chkall").is(":checked");
		if(chk) {
			$("input:checkbox[id=idxchk]").prop("checked", true);
		} else {
			$("input:checkbox[id=idxchk]").prop("checked", false);
		}
	});
});

function go_write() {
	var frm = document.form;
	_popup_page('write.php?popup=1','_p','600','600');
}
function go_edit(code) {
	var frm = document.form;
	_popup_page('write.php?idx='+code+'&popup=1','_p','600','600');
}
function go_delete(code) {
	var ans=confirm('코드를 삭제하시겠습니까?');
	var frm = document.form;
	frm.gubun.value = "delete";
	frm.idx.value = code;
	frm.action = "write_ok.php";
	if(ans) frm.submit();
}
function go_add(code, name) {
	var frm = document.form2;
	_popup_page('sub_write.php?code='+code+'&kind_name='+name+'&popup=1','_p','600','600');
}
function go_edit2(idx, code, name) {
	var frm = document.form2;
	_popup_page('sub_write.php?idx='+idx+'&code='+code+'&kind_name='+name+'&gubun=update&popup=1','_p','600','600');
}
function go_delete2(idx, code, name) {
	var ans=confirm('하위코드를 삭제하시겠습니까?');
	var frm = document.form2;
	frm.gubun.value = "delete";
	frm.idx.value = idx;
	frm.code.value = code;
	frm.kind_name.value = name;
	frm.action = "sub_write_ok.php";
	if(ans) frm.submit();
}

$(document).ready(function(){
	var action = 'click';
	var speed = "500";

	$('tr.maincode').on(action, function(){
		$(this).next().slideToggle(speed).siblings('tr.subcode').slideUp();
		/*
		var img = $(this).children('img');
		$('img').not(img).removeClass('rotate');
		img.toggleClass('rotate');
		*/
	});
});
//-->
</script>

<style>
tr.maincode {cursor:pointer;}
tr.subcode {display:none;}
</style>

<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
</form>


<form name="form2">
<input type="hidden" name="idx">
<input type="hidden" name="code">
<input type="hidden" name="gubun">
<input type="hidden" name="tbl" value="<?=$tbl2?>">
<input type="hidden" name="kind_name">
<input type="hidden" name="npage" value="<?=$nowPage?>">
<input type="hidden" name="field" value="<?=$field?>">
<input type="hidden" name="keyword" value="<?=$keyword?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
</form>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        코드 관리
        <small>편리한 환경을 위한 코드관리를 체계화</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 코드관리</a></li>
        <li class="active">코드 관리</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->


      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Total : <?=$total_no?></h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding" id="accordion">
			<form name="listform" id="listform" method="post">
			<input type="hidden" name="gubun" id="gubun">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="search_text" value="<?=$search_text?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
			<input type="hidden" name="menu_t" value="<?=$menu_t?>">
              <table class="table table-hover">
                <tr>
                  <th width="10"><input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"></th>
                  <th width="20">No</th>
                  <th width="150">명칭</th>
                  <th>코드</th>
                  <th width="80">사용</th>
                  <th width="80">하위코드</th>
                  <th width="80">관리</th>
                </tr>
				<?
				if($total_no == 0) {
				?>
                <tr>
                  <td colspan="8">등록된 정보가 없습니다.</td>
                </tr>
				<?
				} else {
					$query = "select * from ".$initial."_code_".$tbl." where kind_idx is not null "; 				// SQL 쿼리문
					$query .= " order by display_code asc";
					$result = mysql_query($query, $dbconn);
					while ($array=mysql_fetch_array($result)) {
						$rot_num += 1;
						$kind_idx		= $array[kind_idx];
						$kind_code		= $array[kind_code];
						$kind_name		= db2html($array[kind_name]);	  //이름
						$code_format	= $array[code_format];
						$use_yn			= $array[use_yn];
						$display_code	= $array[display_code];
						$remarks		= db2html($array[remarks]);
						$regdate		= $array[regdate];
						$upddate		= $array[upddate];
				?>
                <tr class="maincode">
                  <td><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$kind_code?>" class="idxchk flat-red"></td>
                  <td><?=$display_code?></td>
                  <td><a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$kind_idx?>"><?=$kind_name?></a></td>
                  <td><a  data-toggle="tooltip" data-container="body" title="<?=$remarks?>"><?=$kind_code?></a></td>
                  <td><?if($use_yn=="Y") {?><span class="label label-success">사용</span><?} else {?><span class="label label-danger">정지</span><?}?></td>
                  <td><button type="button" class="btn btn-flat btn-xs btn-info" onClick="go_add('<?=$kind_code?>', '<?=$kind_name?>')" data-toggle="tooltip" data-container="body" title="하위코드 추가"><i class="fa fa-plus"></i></button></td>
                  <td>
				  <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$kind_idx?>');" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
				  <button type="button" class="btn btn-flat btn-xs btn-danger" onClick="go_delete('<?=$kind_idx?>');" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
				  </td>
                </tr>

				<!-- <tr id="collapse<?=$kind_idx?>" class="panel-collapse collapse <?if($rot_num=="1") {?>in<?}?>"> -->
				<tr id="collapse<?=$kind_idx?>" class="subcode">
					<td colspan="2">
					<td colspan="5">
					<table class="table table-hover">

						<tr align="center">
							<th width="60">순서</th>
							<th width="140">코드명</th>
							<th width="100">코드</th>
							<th>비고</th>
							<th width="80">사용</th>
							<th width="80">관리</th>
						</tr>
	<?
	$query2 = "select * from ".$initial."_code_selcode where code_idx  is not null ";
	$query2 .= " and kind_code = '$kind_code'";
	$query2 .= " order by seq_no  asc";
	$result2 = mysql_query($query2, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
	while ($array2 = mysql_fetch_array($result2)) {
		$code_idx		= $array2[code_idx];
		$kind_code		= $array2[kind_code];
		$s_code			= $array2[s_code];
		$code_name		= db2html($array2[code_name]);	  //이름
		$seq_no			= $array2[seq_no];
		$use_yn			= $array2[use_yn];
		$s_remarks		= nE_db2html($array2[remarks]);
		$regdate		= $array2[regdate];
		$upddate		= $array2[upddate];
	?>
						<tr>
						  <td><?=$seq_no?></td>
						  <td><a data-toggle="tooltip" data-container="body" title="<?=$s_remarks?>"><?=$code_name?></a></td>
						  <td><?=$s_code?></td>
						  <td><?=$s_remarks?></td>
						  <td><?if($use_yn=="Y") {?><span class="label label-success">사용</span><?} else {?><span class="label label-danger">정지</span><?}?></td>
						  <td>
							<button onClick="go_edit2('<?=$code_idx?>','<?=$kind_code?>','<?=$kind_name?>');" type="button" class="btn btn-flat btn-xs btn-warning" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
							<button onClick="go_delete2('<?=$code_idx?>','<?=$kind_code?>','<?=$kind_name?>');" type="button" class="btn btn-flat btn-xs btn-danger" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
						  </td>
						</tr>
	<?
	}
	?>
					</table>
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
              <a type="submit" class="btn btn-sm btn-primary" href="javascript:go_write();"><i class="fa fa-plus"></i> 추가</a>
              <a type="text" class="btn btn-sm btn-default" href="javascript:go_remove();"><i class="fa fa-minus"></i> 삭제</a>
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