<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl = "kindcode";

	if ($idx) {
		//테이블에서 글을 가져옵니다. 
		$query = "SELECT * FROM ".$initial."_code_".$tbl." WHERE kind_idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$kind_idx		= $array[kind_idx];
			$kind_name		= html2db($array[kind_name]);
			$kind_code		= $array[kind_code];
			$code_format	= $array[code_format];
			$use_yn			= $array[use_yn];
			$display_code   = $array[display_code];
			$remarks		= db2html($array[remarks]);
			$regdate		= $array[regdate];
			$upddate		= $array[upddate];
		}

		if ($regdate == "0000-00-00 00:00:00"){ $regdate = ""; }
		if ($upddate == "0000-00-00 00:00:00"){ $upddate = ""; }		
	}

	include "../inc/header.php";
?>
<script language="javascript">
function fn_submit() {
	if($.trim($('#kind_name').val()) == ''){
		alert("코드명을 입력하세요.");
		$('#kind_name').focus();
		return false;
	}
	if($.trim($('#kind_code').val()) == ''){
		alert("코드를 입력하세요.");
		$('#kind_code').focus();
		return false;
	}
	if($.trim($('#display_code').val()) == ''){
		alert("정렬순서를 입력하세요.");
		$('#display_code').focus();
		return false;
	}	
	<? if($idx == "") {?>
	$('#gubun').val("insert");
	<? } else { ?>
	$('#gubun').val("update");
	<? } ?>
	$("#fm").attr("action", "write_ok.php");
}
</script>

<form name="form"> 
<input type="hidden" name="idx">
<input type="hidden" name="gubun">
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
        상위코드관리
        <small>편리한 환경을 위한 코드관리를 체계화</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 코드관리</a></li>
        <li class="active">상위코드관리</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->

		<div class="row">
		<!-- left column -->

			<!-- <div class="col-md-6">
			</div>
			
	        <div class="col-md-6">
			</div>
			-->
			

			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title">상위코드 Form</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form role="form" name="fm" id="fm" method="post" action="" onSubmit="return fn_submit()">
				<input type="hidden" name="gubun" id="gubun">
				<input type="hidden" name="tbl" id="tbl" value="<?=$tbl?>">
				<input type="hidden" name="kind_idx" id="kind_idx" value="<?=$idx?>">
				<input type="hidden" name="menu_b" value="<?=$menu_b?>">
				<input type="hidden" name="menu_m" value="<?=$menu_m?>">
				<input type="hidden" name="menu_t" value="<?=$menu_t?>">
				<div class="box-body">
					<div class="form-group">
					  <label for="kind_name">코드종류</label>
					  <input type="text" class="form-control" name="kind_name" id="kind_name" value="<?=$kind_name?>" placeholder="">
					</div>
					<div class="form-group">
					  <label for="kind_code">코드</label>
					  <input type="text" class="form-control" name="kind_code" id="kind_code" value="<?=$kind_code?>" placeholder="">
					</div>
					<div class="form-group">
					  <label for="code_format">포멧형식</label>
					  <input type="text" class="form-control" name="code_format" id="code_format" value="<?=$code_format?>" placeholder="">
					</div>
					<div class="form-group">
					  <label for="use_yn">사용여부</label>
					  <div class="radio">
						<label>
							<input type="radio" name="use_yn" id="use_yn" value="Y" class="flat-red" <?if($use_yn=="Y"){?>checked<?}?>> 사용
						</label>
						<label>
							<input type="radio" name="use_yn" id="use_yn" value="N" class="flat-red" <?if($use_yn=="N" || $use_yn == ""){?>checked<?}?>> 정지
						</label>
					  </div>
					</div>
					<div class="form-group">
					  <label for="display_code">정렬순</label>
					  <input type="text" class="form-control" name="display_code" id="display_code" value="<?=$display_code?>" placeholder="">
					</div>
					<div class="form-group">
					  <label for="remarks">비고</label>
					  
						<div class="box-body pad">
							<textarea class="textarea" name="remarks" id="remarks" placeholder="" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?=$remarks?></textarea>
						</div>
					</div>
				</div>
				<!-- /.box-body -->

				<div class="box-footer">
					<button type="button" class="btn btn-default" onclick="self.close()">취소</button>
					<button type="submit" class="btn btn-primary pull-right">확인</button>
				</div>
				</form>
			</div>
			<!-- /.box -->
		</div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?
include "../inc/footer.php";
mysql_close($dbconn);
?>