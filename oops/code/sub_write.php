<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($tbl2 == "") $tbl2 = "selcode";

	if ($idx) {
		//테이블에서 글을 가져옵니다. 
		$query = "SELECT * FROM ".$initial."_code_".$tbl2." WHERE code_idx = '$idx'";
		
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$code_idx   = $array[code_idx];
			$s_code		= $array[s_code];
			$code_name	= html2db($array[code_name]);
			$kind_code	= $array[kind_code];
			$seq_no		= $array[seq_no];
			$use_yn		= $array[use_yn];
			$remarks	= $array[remarks];
			$regdate	= $array[regdate];
			$upddate	= $array[upddate];
		}

		if ($regdate == "0000-00-00 00:00:00"){ $regdate = ""; }
		if ($upddate == "0000-00-00 00:00:00"){ $upddate = ""; }
	} else {
		$kind_code	= $code;
	}

	include "../inc/header.php";
?>
<script language="javascript">
<!--
function fn_submit() {
	if($('#code').val() == ''){
		alert("코드를 입력하세요.");
		$('#code').focus();
		return false;
	}
	if($('#code_name').val() == ''){
		alert("코드명을 입력하세요.");
		$('#code_name').focus();
		return false;
	}
	if($('#seq_no').val() == ''){
		alert("정렬순서를 입력하세요.");
		$('#seq_no').focus();
		return false;
	}	
	<? if($idx == "") {?>
	$('#gubun').val("insert");
	<? } else { ?>
	$('#gubun').val("update");
	<? } ?>
	$("#fm").attr("action", "sub_write_ok.php");
}

//-->
</script>

<form name="form"> 
<input type="hidden" name="gubun">
<input type="hidden" name="tbl" value="<?=$tbl?>">	
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
        하위 코드관리
        <small>편리한 환경을 위한 코드관리를 체계화</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 코드관리</a></li>
        <li class="active">하위코드</li>
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
				  <h3 class="box-title"><?=$kind_name?> <span><?=$kind_code?></span></h3>
				</div>
				<!-- /.box-header -->
			</div>
			<!-- /.box -->

			<div class="col-xs-6">
			  <div class="box table-responsive">
				<table class="table">
				  <tr>
					<td>순서</td>
					<td>코드명</td>
					<td>코드</td>
					<td>코드</td>
				  </tr>
				<?
					$query2 = "select * from ".$initial."_code_selcode where code_idx  is not null ";
					$query2 .= " and kind_code = '".$kind_code."'";
					$query2 .= " order by seq_no  asc";
					$result2 = mysql_query($query2, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
					while ($array2 = mysql_fetch_array($result2)) {
						$v_code_idx		= $array2[code_idx];
						$v_kind_code	= $array2[kind_code];
						$v_s_code		= $array2[s_code];
						$v_code_name	= db2html($array2[code_name]);	  //이름
						$v_seq_no		= $array2[seq_no];
						$v_use_yn		= $array2[use_yn];
						$v_remarks		= $array2[remarks];
						$v_regdate		= $array2[regdate];
						$v_upddate		= $array2[upddate];
				?>
				  <tr>
					<td><?=$v_seq_no?></td>
					<th style="width:50%"><a href="?idx=<?=$v_code_idx?>&code=<?=$v_kind_code?>&kind_name=<?=$kind_name?>&popup=<?=$popup?>" data-toggle="tooltip" data-container="body" title="<?=$v_remarks?>"><?=$v_code_name?></a></th>
					<td><?=$v_s_code?></td>
					<td><?if($v_use_yn=="Y") {?><span class="label label-success">사용</span><?} else {?><span class="label label-danger">정지</span><?}?></td>
				  </tr>
				<?
					}
				?>
				</table>
			  </div>
			  
				<a href="?code=<?=$code?>&kind_name=<?=$kind_name?>&popup=<?=$popup?>" class="btn btn-flat btn-xs btn-info"><i class="fa fa-plus"></i> 추가</a>
			  <!-- <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
				Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
				dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
			  </p> -->
			</div>

			<div class="col-xs-6">
			  <h5><?=$kind_name?> 하위코드</h5>


				<div class="box box-danger">
				<!-- form start -->
				<form role="form" name="fm" id="fm" method="post" onSubmit="return fn_submit()">
				<input type="hidden" name="gubun" id="gubun">
				<input type="hidden" name="popup" id="popup" value="<?=$popup?>">
				<input type="hidden" name="tbl2" id="tbl2" value="<?=$tbl2?>">
				<input type="hidden" name="kind_code" id="kind_code" value="<?=$kind_code?>">
				<input type="hidden" name="code_idx" id="code_idx" value="<?=$code_idx?>">
				<input type="hidden" name="menu_b" value="<?=$menu_b?>">
				<input type="hidden" name="menu_m" value="<?=$menu_m?>">
				<input type="hidden" name="menu_t" value="<?=$menu_t?>">
					<div class="box-body">
						<div class="form-group">
						  <label for="kind_name">코드명</label>
						  <input type="text" class="form-control" name="code_name" id="code_name" value="<?=$code_name?>" placeholder="">
						</div>
						<div class="form-group">
						  <label for="kind_code">코드</label>
						  <input type="text" class="form-control" name="code" id="code" value="<?=$s_code?>"placeholder="">
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
						  <input type="text" class="form-control" name="seq_no" id="seq_no" value="<?=$seq_no?>" placeholder="">
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
						<button type="button" class="btn btn-default" onclick="self.close()">취소/닫기</button>
						<button type="submit" class="btn btn-primary pull-right">확인</button>
					</div>
				</form>
				</div>


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