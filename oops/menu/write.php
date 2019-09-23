<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl1 = "menu_admin1";
	$tbl2 = "menu_admin2";

	include "../inc/header.php";

	if($flag == "") $flag="Y";
?>



<script Language="javascript">
<!--
	function change_menu()
	{
		var fm = document.fm;
		fm.method = "get";
		fm.action = "write.php";
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
		fm.action = "write_ok.php";
		fm.submit();
    }
//-->
</script>


  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup==1?"popup-":""?>content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        메뉴관리
        <small>전체 메뉴정보 목록</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 운영관리</a></li>
        <li class="active">메뉴관리</li>
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
				  <h3 class="box-title">Menu Form</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form role="form" name="fm" id="fm" onsubmit="return fn_submit()">
				<input type="hidden" name="cmd">
				<input type="hidden" name="depth">
				<input type="hidden" name="popup" value="<?=$popup?>">
				<input type="hidden" name="menu_b" value="<?=$menu_b?>">
				<input type="hidden" name="menu_m" value="<?=$menu_m?>">
				<div class="box-body">
					<div class="form-group">
					  <label for="bid">1DEPTH</label>

						<select name="bid" id="bid" class="form-control" onChange="change_menu();">
						  <option value="">1Depth
						<?
						$query1 = "select * from ".$initial."_".$tbl1." where bid is not null "; 				// SQL 쿼리문
						$query1 = $query1." order by bid asc";
						$result1 =mysql_query($query1, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
						while ($array1=mysql_fetch_array($result1)) {
							$bbid		= $array1[bid];
							$bname  = db2html($array1[name]);	  //이름
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
							$query2 = "select * from ".$initial."_".$tbl2." where bid is not null and bid = '$bid' "; 				// SQL 쿼리문
							$query2 = $query2." order by mid asc, bid asc";
							$result2 =mysql_query($query2, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과

							while ($array2=mysql_fetch_array($result2)) {
								$mmid	= $array2[mid];
								$mbid	= $array2[bid];
								$mname  = db2html($array2[name]);	  //이름
						?>
							<option value="<?=$mmid?>" <?if($mid == $mmid) {?>selected<?}?>><?=$mname?></option>
						<?
							}
						}
						?>
						</select>

					</div>
					<div class="form-group">
					  <label for="userpwd">메뉴명</label>
					  <input type="text" class="form-control" name="name" id="name" value="<?=$name?>" placeholder="">
					</div>
					<div class="form-group">
					  <label for="userpwd">URL</label>
					  <input type="text" class="form-control" name="url" id="url" value="<?=$url?>" placeholder="">
					</div>

					<div class="form-group">
					  <label for="active">상태여부</label>

					  <div class="radio">
						<label>
							<input type="radio" name="flag" id="flag" value="Y" <?if($flag=="Y"){?>checked<?}?>> 사용
						</label>
						<label>
							<input type="radio" name="flag" id="flag" value="N" <?if($flag=="N" || $flag == ""){?>checked<?}?>> 숨김
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