<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$_t1 = "product_cate1";
	$_t2 = "product_cate2";
	$_t3 = "product_cate3";

	include "../inc/header.php";
?>
<script language="javascript">
function go_write() {
	_popup_page('cate_write.php?popup=1','_p','600','600');
}
function go_submenu(bid) {
	_popup_page('cate_write.php?bid='+bid+'&popup=1','_p','600','600');
}

function go_update(arg1, arg2, arg3, arg4, arg5) {
	var fm = document.fm;
	var name		= "";
	var remark		= "";
	var name_ch		= "";
	var remark_ch	= "";
	var use_flag	= "";
	if(arg1 == "<?=$_t1?>") {
		 name		= eval("document.fm.bname_" + arg2 + ".value");
		 remark		= eval("document.fm.remark_" + arg2 + ".value");
		 //name_ch	= eval("document.fm.bname_ch_" + arg2 + ".value");
		 //remark_ch	= eval("document.fm.remark_ch_" + arg2 + ".value");
		 use_flag	= eval("document.fm.use_flag_" + arg2 + ".checked");
	} else if(arg1 == "<?=$_t2?>") {
		name = eval("document.fm.mname_" + arg2 + "_" + arg3 + ".value");
		remark = eval("document.fm.remark_" + arg2 + "_" + arg3 + ".value");
		use_flag = eval("document.fm.use_flag_" + arg2 + "_" + arg3 + ".checked");
	} else if(arg1 == "<?=$_t3?>") {
		name = eval("document.fm.sname_" + arg2 + "_"  + arg3 + "_" + arg4 + ".value");
		remark = eval("document.fm.remark_" + arg2 + "_"  + arg3 + "_" + arg4 + ".value");
		use_flag = eval("document.fm.use_flag_" + arg2 + "_"  + arg3 + "_" + arg4 + ".checked");
	}

	document.fms.name.value = name;
	document.fms.remark.value = remark;
	//document.fms.name_ch.value = name_ch;
	//document.fms.remark_ch.value = remark_ch;
	if(use_flag == true) {
		document.fms.use_flag.value = "1";
	} else {
		document.fms.use_flag.value = "0";
	}
	document.fms.bid.value = arg2;
	document.fms.mid.value = arg3;
	document.fms.tid.value = arg4;
	document.fms.tablename.value = arg5;
	document.fms.cmd.value = "update";
	document.fms.action = "cate_write_ok.php";
	document.fms.submit();
}


function go_delete(str){
	var ans = confirm("정말 삭제 하시겠습니까?");
	if(ans==true){
		document.location.href = str;
	}
}

</script>

<form name="form">
<input type="hidden" name="idx">
<input type="hidden" name="gubun">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>


<form name="fms" method="post">
<input type="hidden" name="name" value="">
<input type="hidden" name="bid" value="">
<input type="hidden" name="mid" value="">
<input type="hidden" name="tid" value="">
<input type="hidden" name="remark" value="">
<input type="hidden" name="name_ch" value="">
<input type="hidden" name="remark_ch" value="">
<input type="hidden" name="use_flag" value="">
<input type="hidden" name="tablename" value="">
<input type="hidden" name="page" value="">
<input type="hidden" name="cmd" value="">
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품분류
        <small>전체 상품분류 목록</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 상품관리</a></li>
        <li class="active">상품분류</li>
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
            <div class="box-body table-responsive no-padding">
			<form name="fm" method="post">
              <table class="table table-hover">
                <tr>
                  <th width="80">No</th>
                  <th width="300">분류명</th>
                  <th>비고</th>
                  <th width="50">상태</th>
                  <th width="80">관리</th>
                </tr>
		<?
			$query = "select * from ".$initial."_".$_t1." where bid is not null "; 				// SQL 쿼리문
			$query = $query." order by bid asc";
			$result=mysql_query($query, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
			while ($array=mysql_fetch_array($result)) {
				$rot_num += 1;
				$bid		= $array[bid];
				$name		= db2html($array[name]);	  //이름
				$name_ch	= db2html($array[name_ch]);	  //중문
				$remark		= db2html($array[remark]);
				$remark_ch	= db2html($array[remark_ch]);
				$use_flag	= $array[use_flag];
		?>
				<tr>
					<td><b><?=$bid?></b></td>
					<td>
					  <div class="input-group input-group-sm">
					  <input type="text" class="form-control" name="bname_<?=$bid?>" value="<?=$name?>" placeholder="">
						<span class="input-group-btn">
						  <button type="button" class="btn btn-default" onclick="go_submenu('<?=$bid?>')"><i class="fa fa-level-down"></i> 추가</button>
						</span>
					  </div>
					</td>
					<td>
					<div class="input-group input-group-sm col-xs-12">
					<input type="text" class="form-control" name="remark_<?=$bid?>" value="<?=$remark?>">
					</div>
					</td>
					<td><input type="checkbox" name="use_flag_<?=$bid?>" value="1"  <? echo $use_flag == "1"?"checked":"";?>></td>
					<td>
					<a href="javascript:go_update('<?=$_t1?>','<?=$bid?>','','')" class="btn btn-flat btn-xs btn-warning" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></a>
					<a href="javascript:go_delete('cate_delete.php?gubun=delete&page=<?=$page?>&tbl=<?=$_t1?>&bid=<?=$bid?>')" class="btn btn-flat btn-xs btn-danger" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></a>
					</td>
				</tr>
				<!-- <tr>
					<td>중문</td>
					<td>
					  <div class="input-group">
					  <input type="text" class="form-control" name="bname_ch_<?=$bid?>" value="<?=$name_ch?>" placeholder="">
					  </div>
					</td>
					<td>
					<div class="input-group input-group-sm col-xs-12">
					<input type="text" class="form-control" name="remark_ch_<?=$bid?>" value="<?=$remark_ch?>" placeholder="">
					</div>
					</td>
					<td></td>
					<td></td>
				</tr> -->
		<?
			$query2 = "select * from ".$initial."_".$_t2." where mid is not null ";
			$query2 = $query2 . " and bid = $bid";
			$query2 = $query2 . " order by mid asc";
			$result2=mysql_query($query2, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
			while ($array2=mysql_fetch_array($result2)) {
				$mid		= $array2[mid];
				$mname		= db2html($array2[name]);	  //이름
				$mremark	= $array2[remark];
				$muse_flag	= $array2[use_flag];

				$depth = "";
				if(strlen($mid) > 1) $depth = "&nbsp;&nbsp;";
		?>
				<tr>
					<td>&nbsp;&nbsp;<?=$depth?>┗&nbsp;<span style="color:#ff0000;"><?=$mid?></span></td>
					<td>
					  <div class="input-group input-group-sm">
					  <input type="text" class="form-control" name="mname_<?=$bid?>_<?=$mid?>" value="<?=$mname?>" placeholder="">
					  </div>
					</td>
					<td>
					<div class="input-group input-group-sm col-xs-12">
					<input type="text" class="form-control col-xs-3" name="remark_<?=$bid?>_<?=$mid?>" value="<?=$mremark?>">
					</div>
					</td>
					<td><input type="checkbox" name="use_flag_<?=$bid?>_<?=$mid?>" value="1"  <? echo $muse_flag == "1"?"checked":"";?>></td>
					<td>
					<a href="javascript:go_update('<?=$_t2?>','<?=$bid?>','<?=$mid?>','')" class="btn btn-flat btn-xs btn-warning" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></a>
					<a href="javascript:go_delete('cate_delete.php?gubun=delete&page=<?=$page?>&tbl=<?=$_t2?>&bid=<?=$bid?>&mid=<?=$mid?>')" class="btn btn-flat btn-xs btn-danger" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></a>
					</td>
				</tr>
		<?

				$query3 = "select * from ".$initial."_".$_t3." where tid is not null ";
				$query3 = $query3 . " and bid = $bid";
				$query3 = $query3 . " and mid = $mid";
				$query3 = $query3 . " order by tid asc";
				$result3=mysql_query($query3, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
				while ($array3=mysql_fetch_array($result3)) {
					$tid			= $array3[tid];
					$sname			= db2html($array3[name]);	  //이름
					$tuse_flag		= $array3[use_flag];
		?>


				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="form-control" name="sname_<?=$bid?>_<?=$mid?>_<?=$tid?>" value="<?=$sname?>"></td>
					<td><input type="text" class="form-control" name="remark_<?=$bid?>_<?=$mid?>_<?=$tid?>" value="<?=$tmremark?>"></td>
					<td><input type="checkbox" name="use_flag_<?=$bid?>_<?=$mid?>_<?=$tid?>" value="1"  <? echo $tuse_flag == "1"?"checked":"";?> style="border:0"></td>
					<td>
					<a href="javascript:go_update('<?=$_t3?>','<?=$bid?>','<?=$mid?>','<?=$tid?>')" class="btn btn-flat btn-xs btn-warning" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></a>
					<a href="javascript:go_delete('cate_delete.php?gubun=delete&page=<?=$page?>&tbl=<?=$_t3?>&bid=<?=$bid?>&mid=<?=$mid?>&tid=<?=$tid?>')" class="btn btn-flat btn-xs btn-danger" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></a></td>
				</tr>

		<?
				}
			}
			$cur_num --;
		}
		?>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a type="submit" class="btn btn-sm btn-primary" href="javascript:go_write();"><i class="fa fa-plus"></i> 추가</a>
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