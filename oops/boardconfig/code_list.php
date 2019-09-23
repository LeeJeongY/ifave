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
function go_select(code,name) {
	opener.document.fm.cate_code.value = code;
	opener.document.fm.cate_name.value = name;
	self.close();
}
//-->
</script>
<form name="form"> 
<input type="hidden" name="idx">
<input type="hidden" name="gubun">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
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
              <table class="table table-hover">
                <tr>
                  <th width="10">선택</th>
                  <th width="20">No</th>
                  <th width="150">명칭</th>
                  <th>코드</th>
                  <th width="80">사용</th>
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
						$regdate		= $array[regdate];
						$upddate		= $array[upddate];
				?>
                <tr>
                  <td><a href="javascript:go_select('<?=$kind_code?>','<?=$kind_name?>');" class="label label-default">확인</a></td>
                  <td><?=$display_code?></td>
                  <td><a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$kind_idx?>"><?=$kind_name?></a></td>
                  <td><?=$kind_code?></td>
                  <td><?if($use_yn=="Y") {?><span class="label label-success">사용</span><?} else {?><span class="label label-danger">정지</span><?}?></td>
                </tr>
				<tr id="collapse<?=$kind_idx?>" class="panel-collapse collapse <?if($rot_num=="1") {?>in<?}?>">
					<td colspan="2">
					<td colspan="5">
					<table class="table table-hover">

						<tr align="center">
							<th width="40">순서</th>
							<th width="100">코드명</th>
							<th width="80">코드</th>
							<th width="80">사용</th>
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
		$regdate		= $array2[regdate];
		$upddate		= $array2[upddate];
	?> 
						<tr>
						  <td><?=$seq_no?></td>
						  <td><?=$code_name?></td>
						  <td><?=$s_code?></td>
						  <td><?if($use_yn=="Y") {?><span class="label label-success">사용</span><?} else {?><span class="label label-danger">정지</span><?}?></td>
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
              <a type="submit" class="btn btn-sm btn-primary" href="javascript:self.close();"> 닫기</a>
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