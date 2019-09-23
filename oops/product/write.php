<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl	= "product"; 							//테이블 이름
	$_t1 = "product_cate1";
	$_t2 = "product_cate2";
	$foldername  = "../../$upload_dir/$tbl/";

	//신규등록인 경우 ============================
	if ($gubun == "") { $gubun  = "insert" ;}

	//기존데이터 수정인경우
	if ($gubun  == "update") {
		$query = "select * from ".$initial."_".$tbl." where idx='$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx      	= $array[idx];
			$cate1    	= $array[cate1];
			$cate2    	= $array[cate2];
			$pcode    	= $array[pcode];
			$pname		= db2html($array[pname]);
			$option_color 	= $array[option_color];
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

	} else {
		//등록인 경우
		$use_flag	= "1";
		$content	= "";
	}
?>
<?
	include "../inc/header_popup.php";
	//스크립트
	include "../js/goto_page.js.php";
?>
<script language=JavaScript>
<!--
	function category_select(){

		var frm = document.fm;
		frm.cate_flag.value = "Y";
		var cate1 = $("select[name=cate1]").val();
		frm.method = "get";
		frm.action = "<?=$PHP_SELF?>";
		frm.submit();
	}

	function fn_submit(){
		var fm = document.fm;
		/*
		if($('#cate1').val() =='') {
			alert('분류를 선택하세요.');
			$('#cate1').focus();
			return false;
		}
		*/
		if($('#pname').val() =='') {
			alert('상품명을 입력하세요.');
			$('#pname').focus();
			return false;
		}
		if($('#pcode').val() =='') {
			alert('상품코드를 입력하세요.');
			$('#pcode').focus();
			return false;
		}
		if($('#option_color').val() =='') {
			alert('색상을 선택하세요.');
			$('#option_color').focus();
			return false;
		}
		if($('#price').val() =='') {
			alert('가격을 입력하세요.');
			$('#price').focus();
			return false;
		}
		<?if($idx) {?>
		fm.gubun.value = "update";
		<?} else {?>
		fm.gubun.value = "insert";
		<?}?>
		fm.target = "_self";
		fm.action = "write_ok.php";
		fm.submit();
	}


	$(document).ready(function(){
	var checkAjaxSetTimeout;
		$('#pname').keyup(function(){
			clearTimeout(checkAjaxSetTimeout);
			checkAjaxSetTimeout = setTimeout(function() {

				if ($('#pname').val().length > 6) {
					var id = $('#pname').val();
					// ajax 실행
					$.ajax({
						type : 'POST',
						url : 'write_ok.php',
						data : {'pname':id,'gubun':'pnamecheck'},
						success : function(data) {
							//console.log(data);

							if (data == "ok") {
								$("#pname_check").html("<span style='color:#0066cc;'>사용 가능한 상품명 입니다.</span>");
							} else {
								$("#pname_check").html("<span style='color:#FF3300;'>사용 중인 상품명 입니다.</span>");
							}
						}
					}); // end ajax
				}

			},500); //end setTimeout

		}); // end keyup
	});



	function go_list() {
		var frm = document.fm;
		frm.gubun.value = "";
		frm.id.value = "";
		frm.method = "get";
		frm.target = "self";
		frm.action = "list.php";
		frm.submit();
	}
//-->
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup-":""?>content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품관리
        <small>상품<?=$idx==""?"등록":"수정"?></small>
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

			<!-- <form role="form" method="post" name="fm" id="fm" enctype="multipart/form-data"> -->
			<!-- <form role="form" method="post" name="fm" id="fm" action="write_ok.php" enctype="multipart/form-data" accept-charset="utf-8"> -->
			<form role="form" method="post" name="fm" id="fm" action="write_ok.php" enctype="multipart/form-data" accept-charset="utf-8">
			<input type="hidden" name="page" value='<?=$page?>'>
			<input type="hidden" name="idx" value='<?=$idx?>'>
			<input type="hidden" name="gubun" value='<?=$gubun?>'>
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="search" value='<?=$search?>'>
			<input type="hidden" name="search_text" value='<?=$search_text?>'>
			<input type="hidden" name="cate_flag" value=''>

			<div class="col-md-12">

			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title">상품정보</h3>
				</div>

				<div class="box-body">

					<div class="form-group">
					  <label for="cate">분류</label>

						<div class="input-group">
						<select name="cate1" id="cate1" class="form-control boxed select2" onchange="category_select();">
							<option value="">- 선택 -</option>
							<?
								$get_que = "SELECT * FROM ".$initial."_".$_t1." WHERE bid IS NOT NULL ";
								$get_que .= " AND use_flag='1'";
								$get_que .= " ORDER BY bid ASC";
								$get_rst =mysql_query($get_que, $dbconn) or die (mysql_error());
								while ($get_arr = mysql_fetch_array($get_rst)) {
									$cate1_bid	= sprintf('%02d', $get_arr[bid]);
									$cate1_name	= db2html($get_arr[name]);
							?>
							<option value="<?=$cate1_bid?>" <?if($cate1_bid == $cate1) {?>selected<?}?>><?=$cate1_name?></option>
							<?
								}
							?>
						</select>


						<?php
						if(strlen(trim($cate1)) > 0){
						?>
							<select name="cate2" id="cate2" class="form-control boxed select2">
								<option value= "">- 선택 -</option>

							<?php

							$strQuery = "SELECT * FROM ".$initial."_".$_t2." WHERE mid IS NOT NULL ";
							$strQuery .= " AND bid='".$cate1."'";
							$strResult = mysql_query($strQuery, $dbconn);
							while ($arrResult = mysql_fetch_array($strResult)) {
								$rot_num += 1;
								$cate2_mid		= $arrResult[mid];
								$cate2_name		= db2html($arrResult[name]);	  //이름

								$selected = ($cate2 == $cate2_mid)? " selected " : "";
							?>
								<option value="<?=$cate2_mid?>" <?=$selected?>><?=$cate2_name?></option>
							<?
							}
							?>
							</select>
							</span>
						<?} else {?>
							<select name="cate2" id="cate2" class="form-control boxed select2">
								<option value="">- 선택 -</option>
							</select>
						<?}?>

						</div>


					</div>
					<div class="form-group">
						<label for="pname">상품명</label>
						<input type="text" name="pname" id="pname" value="<?=$pname?>" class="form-control" required=""/>
						<div class="input-group">
						<span id="pname_check" style="color:#FF3300;"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="pcode">상품코드</label>
						<input type="text" name="pcode" id="pcode" value="<?=$pcode?>" class="form-control" required=""/>
					</div>
					<div class="form-group">
						<label for="option_color">옵션(색상)</label>
						<div class="input-group">
							<select name="option_color" id="option_color" class="form-control boxed select2">
								<option value="">색상선택</option>
								<option value="GREEN" <?=$option_color=="GREEN"?"selected":""?>>GREEN</option>
								<option value="PINK" <?=$option_color=="PINK"?"selected":""?>>PINK</option>
								<option value="YELLOW" <?=$option_color=="YELLOW"?"selected":""?>>YELLOW</option>
								<option value="ORANGE" <?=$option_color=="ORANGE"?"selected":""?>>ORANGE</option>
								<option value="VIOLET" <?=$option_color=="VIOLET"?"selected":""?>>VIOLET</option>
								<option value="BLUE" <?=$option_color=="BLUE"?"selected":""?>>BLUE</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="img_file">대표이미지(썸네일)</label>
						<div class="input-group">
						<? if ($gubun == "insert") { ?>
						  <INPUT type="hidden" name="MAX_FILE_SIZE" value="2097152">
						  <input name="img_file" id="img_file" type ="file" class="form-control">
						  <? } else { ?>
						  <input name="img_file" id="img_file" type ="file" class="form-control">
						&nbsp;&nbsp;&nbsp;
						<br/>
						<?   if ($img_file != "") { ?>
						<input type="checkbox" value="Y" name="img_file_chk" style="border:1;">
						<span class="label label-primary">파일삭제</span> <a href="<?=$foldername?><?=$img_file?>" target="_blank"><?=$img_file?></a>
						<INPUT type="hidden" name="MAX_FILE_SIZE" value="2097152">
						<INPUT type="hidden" name="old_img_file" value="<?=$img_file?>">
						<?   } ?>
						<? } ?>
						<br/>이미지크기 : 270 X 161 (Pixel)
						</div>
					</div>
					<div class="form-group">
						<label for="price">가격</label>
						<input type="text" name="price" id="price" value="<?=$price?>" class="form-control" required=""/>
					</div>
					<div class="form-group">
						<label for="use_flag">사용여부</label>
						<div class="radio">
						<?=getCodeNameBoxDB("code_useflag", $use_flag, "radio", "use_flag", $dbconn)?>
						</div>
					</div>
					<div class="form-group">
						<label for="intro">소개</label>
						<textarea type="text" name="intro" id="intro" class="form-control"/><?=$intro?></textarea>
					</div>
					<div class="form-group">
						<label for="remark">내용</label>
						<?
						$content = $remark;
						//다음 에디터
						include "../../editor/editor.php";

						//include "../../smarteditor/SmartEditor.php";
						?>
					</div>
				</div>
				<div class="box-footer">
					<button type="button" class="btn btn-default" onclick="fn_cancel()">취소</button>
					<!-- <button type="submit" class="btn btn-primary pull-right">확인</button> -->
					<!-- <input type="button" onclick="fn_submit();" value="확인" class="btn btn-primary pull-right" /> --> <!--  일반적일 경우 -->
					<input type="button" onclick="saveContent();" value="확인" class="btn btn-primary pull-right" /> <!--  daum editor -->
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
