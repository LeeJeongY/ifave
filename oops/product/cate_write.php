<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl1 = "product_cate1";
	$tbl2 = "product_cate2";

	include "../inc/header.php";
?>



<script Language="javascript">
<!--
	function change_menu()
	{
		var fm = document.fm;
		fm.method = "get";
		fm.action = "cate_write.php";
		fm.submit();
	}

    function fn_submit()
    {
        var fm = document.fm;
		if(fm.name.value == "")
        {
        	alert("메뉴명을 입력 하십시오.");
        	fm.name.focus();
        	return false;
        }
		fm.cmd.value = "insert";
		fm.method = "post";
		fm.action = "cate_write_ok.php";
		fm.submit();
    }
//-->
</script>


  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup-":""?>content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        제품분류
        <small>전체 제품분류 목록</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 제품관리</a></li>
        <li class="active">제품분류</li>
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
				  <h3 class="box-title">Form</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form role="form" name="fm" id="fm" onsubmit="return fn_submit()">
				<input type="hidden" name="cmd">
				<input type="hidden" name="depth">
				<input type="hidden" name="popup" value="<?=$popup?>">
				<div class="box-body">
					<div class="form-group">
					  <label for="bid">1DEPTH</label>

						<select name="bid" id="bid" class="form-control" onChange="change_menu();">
						  <option value="">1Depth
						<?
						$query = "select * from ".$initial."_".$tbl1." where bid is not null "; 				// SQL 쿼리문
						$query .= " order by bid asc";
						$result =mysql_query($query, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
						while ($array=mysql_fetch_array($result)) {
							$bbid		= $array[bid];
							$bname  = db2html($array[name]);	  //이름
						?>
							<option value="<?=$bbid?>" <?if($bid == $bbid) {?>selected<?}?>><?=$bname?></option>
						<?
						}
						?>
						</select>
					</div>
					<div class="form-group">
					  <label for="mid">2DEPT</label>

						<select name="mid" id="mid" class="form-control" onChange="change_menu();">
						  <option value="">2Depth
						<?
						if($bid != "") {
							$query = "select * from ".$initial."_".$tbl2." where bid is not null and bid = '$bid' "; 				// SQL 쿼리문
							$query .= " order by mid asc, bid asc";
							$result =mysql_query($query, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과

							while ($array=mysql_fetch_array($result)) {
								$mmid	= $array[mid];
								$mbid	= $array[bid];
								$mname  = db2html($array[name]);	  //이름
						?>
							<option value="<?=$mmid?>" <?if($mid == $mmid) {?>selected<?}?>><?=$mname?></option>
						<?
							}
						}
						?>
						</select>

					</div>
					<div class="form-group">
					  <label for="name">분류명</label>
					  <input type="text" class="form-control" name="name" id="name" value="<?=$name?>" placeholder="">
					</div>
					<div class="form-group">
					  <label for="remark">비고</label>
					  <input type="text" class="form-control" name="remark" id="remark" value="<?=$remark?>" placeholder="">
					</div>

					<div class="form-group">
					  <label for="use_flag">사용여부</label>

					  <div class="radio">
						<label>
							<input type="radio" name="use_flag" id="use_flag" value="1" <?if($use_flag=="1"){?>checked<?}?>> 사용
						</label>
						<label>
							<input type="radio" name="use_flag" id="use_flag" value="0" <?if($use_flag=="0" || $use_flag == ""){?>checked<?}?>> 미사용
						</label>
					  </div>
					</div>
				</div>
				<!-- /.box-body -->

				<div class="box-footer">
					<button class="btn btn-default" onclick="self.close();">닫기</button>
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