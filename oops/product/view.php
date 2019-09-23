<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl = "product"; 							//테이블 이름
	$_t1 = "product_cate1";
	$_t2 = "product_cate2";
	$foldername  = "../../$upload_dir/$tbl/";

	//테이블에서 글을 가져옵니다.
	$query = "select * from ".$initial."_".$tbl." where ";
	$query .= " idx='$idx'";
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array = mysql_fetch_array($result)) {
		$idx      	= $array[idx];
		$cate1    	= $array[cate1];
		$cate2    	= $array[cate2];
		$pcode    	= $array[pcode];
		$pname		= db2html($array[pname]);
		$img_file 	= $array[img_file];
		$price    	= $array[price];
		$quantity 	= $array[quantity];
		$title		= db2html($array[title]);
		$intro		= db2html($array[intro]);
		$content	= db2html($array[content]);
		$main_flag	= $array[main_flag];
		$use_flag 	= $array[use_flag];
		$regdate  	= $array[regdate];
		$upddate  	= $array[upddate];
		$user_wid 	= $array[user_wid];
		$user_eid 	= $array[user_eid];
	}

?>
<?
	include "../inc/header_popup.php";
?>
<script language=JavaScript>
<!--
function go_list() {
	var frm = document.fm;
	frm.gubun.value = "";
	frm.id.value = "";
	frm.method = "get";
	frm.target = "_self";
	frm.action = "list.php";
	frm.submit();
}

function go_edit(){
	var frm = document.fm;
	frm.gubun.value = "update";
	frm.target = "_self";
	frm.method = "get";
	frm.action = "write.php";
	frm.submit();
}

function go_delete(){
	var frm = document.fm;
	var ans=confirm("정말 삭제 하시겠습니까?");
	if(ans==true){
		frm.gubun.value = "delete";
		frm.target = "_self";
		frm.method = "post";
		frm.action = "write_ok.php";
		frm.submit();
	}
}
//-->
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup-":""?>content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품관리
        <small>상품 상세정보</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 상품관리</a></li>
        <li class="active">상품 <?=$idx==""?"등록":"수정"?></li>
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

			<div class="col-md-12">

			<div class="box box-info">


				<form method="post" name="fm">
				<input type="hidden" name="page" value='<?=$page?>'>
				<input type="hidden" name="idx" value='<?=$idx?>'>
				<input type="hidden" name="gubun" value='<?=$gubun?>'>


				<div class="box-header with-border">
				  <h3 class="box-title">상품정보</h3>
				</div>

				<div class="box-body">

					<div class="form-group">
					  <label for="cate">분류</label>

						<div class="input-group">
						<?
						$cate1_text = getCategoryName1($cate1,$dbconn);
						$cate2_text = getCategoryName2($cate1,$cate2,$dbconn);
						?>
						<?=$cate1_text?> <?if($cate2_text) {?>&gt; <?=$cate2_text?><?}?>

						</div>

					</div>
					<div class="form-group">
					  <label for="icode">상품코드</label>
						<div class="input-group">
							<?=$pcode?>
						</div>
					</div>
					<div class="form-group">
					  <label for="iname">상품명</label>
						<div class="input-group">
							<?=$pname?>
						</div>
					</div>
					<div class="form-group">
					  <label for="price">가격</label>
						<div class="input-group">
							<?=number_format($price)?>
						</div>
					</div>
					<div class="form-group">
						<label for="img_file">대표이미지</label>
						<div class="input-group">
						<a href="../common/download.php?fl=../../<?=$upload_dir?>/<?=$tbl?>/&fi=<?=$img_file?>&s=<?=$idx?>&t=<?=$tbl?>"><img src="<?=$foldername?><?=$img_file?>" alt="<?=$img_file?>" width="160" border="0"></a>
						</div>
					</div>
					<!-- <div class="form-group">
						<label for="img_file1">이미지1</label>
						<div class="input-group">
						<a href="../common/download.php?fl=../../<?=$upload_dir?>/<?=$tbl?>/&fi=<?=$img_file1?>&s=<?=$idx?>&t=<?=$tbl?>"><img src="<?=$foldername?><?=$img_file1?>" alt="<?=$img_file1?>" width="260" border="0"></a>
						</div>
					</div>
					<div class="form-group">
						<label for="img_file2">이미지2</label>
						<div class="input-group">
						<a href="../common/download.php?fl=../../<?=$upload_dir?>/<?=$tbl?>/&fi=<?=$img_file2?>&s=<?=$idx?>&t=<?=$tbl?>"><img src="<?=$foldername?><?=$img_file2?>" alt="<?=$img_file2?>" width="260" border="0"></a>
						</div>
					</div> -->
					<div class="form-group">
						<label for="use_flag">사용여부</label>
						<div class="radio">
						<?=getCodeNameDB("code_useflag", $use_flag, $dbconn)?>
						</div>
					</div>
					<div class="form-group">
						<label for="content">내용</label>
						<?=$content?>
					</div>
					<div class="form-group">
						<label for="regdate">등록일</label>
						<?=$regdate?> (<?=$regid?>)
					</div>
					<div class="form-group">
						<label for="upddate">수정일</label>
						<?=$upddate?> (<?=$updid?>)
					</div>
				</div>
				<div class="box-footer">
					<button type="button" class="btn btn-default" onclick="go_edit()">수정</button>
					<button type="button" class="btn btn-primary pull-right" onclick="go_delete()">삭제</button>
				</div>
			</div>
			</form>
			<!-- /.box -->

			</div>

		</div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

	<iframe id="_progress" name="_progress" width="0" height="0"></iframe>
<?
	include "../inc/footer.php";
?>
<? mysql_close($dbconn); ?>

