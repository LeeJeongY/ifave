<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl	= "staff"; 							//테이블 이름

	//신규등록인 경우 ============================
	if ($gubun == "") { $gubun  = "insert" ;}
	if($idx!="" || $userid !="") $gubun = "view";
	//기존데이터 수정인경우
	if ($gubun  == "view") {
		$query = "select * from ".$initial."_".$tbl." where idx is not null ";
		if($idx) $query .= " and idx='$idx'";
		if($userid) $query .= " and userid='$userid'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx		= $array[idx];
			$sgubun		= $array[sgubun];
			$userid		= $array[userid];
			$userpwd	= $array[userpwd];
			$username	= db2html($array[username]);
			$nickname	= db2html($array[nickname]);
			$tel		= $array[tel];
			$hp			= $array[hp];
			$email		= $array[email];
			$user_file	= $array[user_file];
			$grade		= $array[grade];
			$menunum	= $array[menunum];
			$active		= $array[active];
			$remoteip	= $array[remoteip];
			$lastlogin	= $array[lastlogin];
			$lastlogout	= $array[lastlogout];
			$zipcode	= $array[zipcode];
			$addr1		= db2html($array[addr1]);
			$addr2		= db2html($array[addr2]);
			$birthdate	= $array[birthdate];
			$calkind	= $array[calkind];
			$duty		= $array[duty];
			$charge		= $array[charge];
			$sfoption	= $array[sfoption];
			$remark		= db2html($array[remark]);
			$regdate	= $array[regdate];
			$editdate	= $array[editdate];
			list($tel1,$tel2,$tel3) = explode("-",$tel);
			list($hp1,$hp2,$hp3) = explode("-",$hp);
			list($zip1,$zip2) = explode("-",$zipcode);
		}


	} else {
		//등록인 경우
		$remark		= "";
	}

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>
<script>
<!--
function fn_submit() {
	<?if($userid=="") {?>
	if($.trim($('#userid').val()) == ''){
		alert("아이디를 입력하세요.");
		$('#userid').focus();
		return false;
	}
	<?}?>
	if($.trim($('#email').val()) == ''){
		alert("이메일을 입력하세요.");
		$('#email').focus();
		return false;
	}
	<?if($userid == "") {?>
	if($.trim($('#userpwd').val()) == ''){
		alert("비밀번호를 입력하세요.");
		$('#userpwd').focus();
		return false;
	}
	if($.trim($('#userpwd2').val()) == ''){
		alert("비밀번호확인을 다시 해 주세요.");
		$('#userpwd2').focus();
		return false;
	}
	if($.trim($('#userpwd').val()) != $.trim($('#userpwd2').val())){
		alert("비밀번호를 동일하지 않습니다.");
		$('#userpwd2').focus();
		return false;
	}
	<?}?>
	if($.trim($('#username').val()) == ''){
		alert("이름을 입력하세요.");
		$('#username').focus();
		return false;
	}
	if($.trim($('#hp').val()) == ''){
		alert("연락처를 입력하세요.");
		$('#hp').focus();
		return false;
	}
	$("#fm").attr("target", "_self");
	$("#fm").attr("method", "post");
	$("#fm").attr("action", "write_ok.php");
}


$(document).ready(function(){
var checkAjaxSetTimeout;
    $('#userid').keyup(function(){
        clearTimeout(checkAjaxSetTimeout);
        checkAjaxSetTimeout = setTimeout(function() {

			if ($('#userid').val().length > 6) {
				var id = $('#userid').val();
				// ajax 실행
				$.ajax({
					type : 'POST',
					url : 'write_ok.php',
					data : {'userid':id,'gubun':'idcheck'},
					success : function(data) {
						if (data == "ok") {
							$("#idcheck").html("<span style='color:#0066cc;'>사용 가능한 아이디 입니다.</span>");
						} else {
							$("#idcheck").html("<span style='color:#FF3300;'>사용 중인 아이디 입니다.</span>");
						}
					}
				}); // end ajax
			}

		},500); //end setTimeout

    }); // end keyup
});




//메뉴 권한
function fn_GradeChk(str) {

	var form = document.fm;
	var b_val = "";
	var m_obj = "";
	var s_obj = "";
	if(str == "") {

		for(i=0;i < form.elements['bmenu[]'].length;i++) {

			b_val = form.elements['bmenu[]'][i].value;
			m_obj = eval("document.fm.elements['mmenu_"+b_val+"[]']");

			if(form.elements['bmenu[]'][i].checked == false) {


				for(j=0;j < m_obj.length;j++) {

					s_obj = eval("document.fm.elements['mmenu_"+b_val+"[]'][j]");
					s_obj.disabled	= true;
					s_obj.checked	= false;

				}
			}
		}

	} else {
		for(i=0;i < form.elements['bmenu[]'].length;i++) {

			b_val = form.elements['bmenu[]'][i].value;
			m_obj = eval("document.fm.elements['mmenu_"+b_val+"[]']");
			if(form.elements['bmenu[]'][i].checked == false) {

				for(j=0;j < m_obj.length;j++) {

					s_obj = eval("document.fm.elements['mmenu_"+b_val+"[]'][j]");
					s_obj.disabled	= true;

				}
			} else {
				for(j=0;j < m_obj.length;j++) {

					s_obj = eval("document.fm.elements['mmenu_"+b_val+"[]'][j]");
					s_obj.disabled	= false;
					s_obj.checked	= true;


				}
			}
		}
	}
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


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        관리자관리
        <small>전체 관리자정보 목록</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 운영관리</a></li>
        <li class="active">관리자관리</li>
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
				<div class="box-header with-border">
				  <h3 class="box-title">Form</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form role="form" name="fm" id="fm" enctype="multipart/form-data" onSubmit="return fn_submit()">
				<input type="hidden" name="page" value='<?=$page?>'>
				<input type="hidden" name="idx" value='<?=$idx?>'>
				<input type="hidden" name="gubun" value='<?=$gubun?>'>
				<input type="hidden" name="charge_data" value="">
				<div class="box-body">
					<div class="form-group">
					  <label for="userid">구분</label>
					  <?=getCodeNameBoxDB("code_staff", $sgubun, "combobox", "sgubun", $dbconn)?>
					</div>
					<div class="form-group">
					  <label for="userid">아이디</label>
					  <input type="text" class="form-control" name="userid" id="userid" value="<?=$userid?>" placeholder="ID" required>
					  <div id="idcheck"></div>
					</div>
					<div class="form-group">
					  <label for="email">이메일</label>
					  <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						<input type="email" class="form-control" name="email" id="email" value="<?=$email?>" placeholder="Email" required>
					  </div>
					</div>
					<div class="form-group">
					  <label for="userpwd">비밀번호</label>
					  <input type="password" class="form-control" name="userpwd" id="userpwd" value="" placeholder="Password">
					</div>
					<?if($userid == "") {?>
					<div class="form-group">
					  <label for="userpwd2">비밀번호 확인</label>
					  <input type="password" class="form-control" name="userpwd2" id="userpwd2" placeholder="Password">
					</div>
					<?}?>
					<div class="form-group">
					  <label for="username">이름</label>
					  <input type="text" class="form-control" name="username" id="username" value="<?=$username?>" placeholder="" required>
					</div>
					<div class="form-group">
						<label for="hp">연락처</label>
						<div class="input-group">
							<div class="input-group-addon">
							<i class="fa fa-phone"></i>
							</div>
							<input type="text" class="form-control" name="hp" id="hp" value="<?=$hp?>" placeholder="" data-inputmask='"mask": "999-999-9999"' data-mask required>
						</div>
					</div>
					<div class="form-group">
					  <label for="grade">관리자 권한</label>

					  <div class="radio">
						<?if($_ULEVEL <= "1") {?>
						<label>
						<input type="radio" name="grade" id="grade" class="flat-red" value="1" <?=$grade=="1"?"checked":""?>> 슈퍼 관리자
						</label>
						<?}?>
						<?=getCodeNameBoxDB("code_admin", $grade, "radio", "grade", $dbconn)?>
					  </div>
					</div>

					<div class="form-group">

					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
						<?

						$menu_q1 = "select * from ".$initial."_menu_admin1 where bid is not null "; 				// SQL 쿼리문
						$menu_q1 .= " order by bid asc";
						$menu_rs1 = mysql_query($menu_q1, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
						while ($menu_arr1 = mysql_fetch_array($menu_rs1)) {
							$rot_num += 1;
							$bid		= $menu_arr1[bid];
							$bmenu_name	= db2html($menu_arr1[name]);	  //이름
							$url		= $menu_arr1[url];
							$open		= $menu_arr1[open];

							$sub_q1 = "select count(*) as bcnt from ".$initial."_menu_grade where userid='$userid'";
							$sub_q1 .= " and bid='$bid'";
							$sub_q1 .= " and sitegubun='1'";
							$sub_rs1 = mysql_query($sub_q1, $dbconn) or die (mysql_error());
							$sub_row1 = mysql_fetch_row($sub_rs1);
							$bcnt = $sub_row1[0];
						?>
						<tr>
							<td><input type="checkbox" name="bmenu[]" value="<?=$bid?>" style="border:0px;" <?=$bcnt == 0?"":"checked"?>  onclick="fn_GradeChk('<?=$bid?>')"><b <?=$bcnt == 0?"":"style='color:#FF3300;'"?>> <?=$bmenu_name?></b></td>
							<td valign="top" style="padding:5px;">
							<table border="0" cellspacing="0" cellpadding="0">
								<tr>
							<?
							$menu_q2 = "select * from ".$initial."_menu_admin2 where mid is not null ";
							$menu_q2 .= " and bid = $bid";
							$menu_q2 .= " order by mid asc";
							$menu_rs2 = mysql_query($menu_q2, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
							$j = 0;
							while ($menu_arr2 = mysql_fetch_array($menu_rs2)) {
								$mid		= $menu_arr2[mid];
								$mmenu_name	= db2html($menu_arr2[name]);	  //이름
								$murl		= $menu_arr2[url];
								$mopen		= $menu_arr2[open];


								$sub_q2 = "select count(*) as bcnt from ".$initial."_menu_grade where userid='$userid'";
								$sub_q2 .= " and mid='$mid'";
								$sub_q2 .= " and sitegubun='1'";
								$sub_rs2 = mysql_query($sub_q2, $dbconn) or die (mysql_error());
								$sub_row2 = mysql_fetch_row($sub_rs2);
								$mcnt = $sub_row2[0];

								if($j % 6 == 0) {
									echo "</tr><tr>";
								}
								?>
									<td width="140"><input type="checkbox" name="mmenu_<?=$bid?>[]" value="<?=$mid?>" style="border:0px;" <?=$mcnt == 0?"":"checked"?>> <span  <?=$mcnt == 0?"":"style='color:#FF3300;'"?>><?=$mmenu_name?></span>&nbsp;</td>
								<?
									$j++;
								}
								?>
									<td></td>
								</tr>
							</table>
							</td>

						</tr>
						<?
						}
						?>
					  </table>

					  <script>fn_GradeChk('')</script>


					</div>
					<div class="form-group">
					  <label for="active">승인여부</label>

					  <div class="radio">
						<label>
							<input type="radio" name="active" id="active" class="flat-red" value="1" <?if($active=="1"){?>checked<?}?>> 승인
						</label>
						<label>
							<input type="radio" name="active" id="active" class="flat-red" value="0" <?if($active=="0" || $active == ""){?>checked<?}?>> 거부
						</label>
					  </div>
					</div>

					<div class="form-group">
					  <label for="exampleInputFile">사진첨부</label>
					  <input type="file" class="form-control" name="user_file" id="user_file" value="">
						<?
						if($user_file!="") {
							?>
							  <p class="help-block"><i class="fa fa-download"></i> <a href="../../common/download.php?fl=<?=$foldername?>&fi=<?=$user_file?>"><?=$user_file?></a> <input type="checkbox" name="user_file_chk" id="user_file_chk" value="Y"  class="flat-red"> 삭제</p>
							<?
						}
						?>
					</div>
				</div>
				<!-- /.box-body -->

				<div class="box-footer">
					<button type="button" class="btn btn-default" onclick="fn_cancel()">취소</button>
					<button type="submit" class="btn btn-primary pull-right">확인</button>
				</div>
				</form>
			</div>
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