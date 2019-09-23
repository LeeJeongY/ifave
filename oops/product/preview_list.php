<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/register_globals.php";
	include "../../modules/func.php";
	include "../../modules/func_sql.php";
	include "../../modules/lib.php";
	include "../../modules/auth_chk.php";
	include "../../modules/mobile_device_detect.php";

	$tbl = "product"; 				//테이블 이름
	$_t1 = "product_cate1";
	$_t2 = "product_cate2";
	$foldername  = "../../$upload_dir/$tbl/";

	if($page == '') $page = 1; 					//페이지 번호가 없으면 1
	$list_num = 30; 							//한 페이지에 보여줄 목록 갯수
	$page_num = 10; 							//한 화면에 보여줄 페이지 링크(묶음) 갯수
	$offset = $list_num*($page-1); 				//한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "?s_cate1=$s_cate1&s_cate2=$s_cate2&s_class=$s_class&s_standard=$s_standard&search=$search&search_text=$search_text&menu_b=$menu_b&menu_m=$menu_m&menu_t=$menu_t&";

	if ($search_text != "") {
		$search_text   = trim(stripslashes(addslashes($search_text)));
		if($search == "all") {
			$qry_where .= " AND (iname like '%$search_text%' OR icode like '%$search_text%')";
		} else {
			if($search_text) {
				$qry_where .= " AND $search like '%$search_text%'";
			}
		}
	}
	if($s_cate1) $qry_where .= " AND cate1='$s_cate1'";
	if($s_cate2) $qry_where .= " AND cate2='$s_cate2'";
	if($s_class) $qry_where .= " AND class='$s_class'";
	if($s_standard) $qry_where .= " AND class='$s_standard'";

	$query  ="select count(idx) from ".$initial."_".$tbl." where idx is not null ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	$row = mysql_fetch_row($result);
	$total_no = $row[0];

	$total_page = ceil($total_no/$list_num);
	$cur_num = $total_no - $list_num*($page-1);

	$query  = "select * ";
	$query .= " from ".$initial."_".$tbl." where idx is not null ";
	$query .= $qry_where;
	$query .= " order by regdate desc limit $offset, $list_num";
	$result = mysql_query($query, $dbconn) or die (mysql_error());
?>
<?
	include "../inc/header.php";
	//상태 변경 셀렉트 메뉴
	include "../js/select_menu.js.php";
?>
<script language="JavaScript">
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

function go_view(str) {
	/*
	var frm = document.form;
	frm.idx.value = str;
	frm.gubun.value = "view";
	frm.target = "_self";
	frm.method = "get";
	frm.action = "view.php";
	frm.submit();
	*/

	var url_page = "view.php?idx="+str+"&popup=1&gubun=view";
	var w = "450";
	var h = "650";
	var win = window.open(url_page, "_item", 'width='+w+',height='+h+', menubar=0, scrollbars=1, resizable=1');
	win.focus();
}

function go_edit(str) {
	/*
	var frm = document.form;
	frm.idx.value = str;
	frm.gubun.value = "update";
	frm.target = "_self";
	frm.method = "get";
	frm.action = "write.php";
	frm.submit();
	*/

	var url_page = "write.php?idx="+str+"&popup=1&gubun=update";
	var w = "450";
	var h = "650";
	var win = window.open(url_page, "_item", 'width='+w+',height='+h+', menubar=0, scrollbars=1, resizable=1');
	win.focus();


}

function go_write() {
	/*
	var frm = document.form;
	frm.gubun.value = "insert";
	frm.target = "_self";
	frm.method = "get";
	frm.action = "write.php";
	frm.submit();
	*/

	var url_page = "write.php?popup=1";
	var w = "450";
	var h = "650";
	var win = window.open(url_page, "_item", 'width='+w+',height='+h+', menubar=0, scrollbars=1, resizable=1');
	win.focus();


}

function go_delete(str){
	var frm = document.form;
	var ans=confirm("정말 삭제 하시겠습니까?");
	if(ans==true){
		frm.idx.value = str;
		frm.gubun.value = "delete";
		frm.target = "_self";
		frm.method = "post";
		frm.action = "write_ok.php";
		frm.submit();
	}
}
//-->
</script>

<?
	//메뉴 네비게이션
	include "../inc/menu_navi.php";
?>


	<form name="form">
	<input type="hidden" name="idx">
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


	<div class="search_box">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbl_wrap">
	<form method="get" action="<?=$PHP_SELF?>" name="fm">
	<input type="hidden" name="menu_b" value="<?=$menu_b?>">
	<input type="hidden" name="menu_m" value="<?=$menu_m?>">
	<input type="hidden" name="menu_t" value="<?=$menu_t?>">
		<tr>
			<td width="5"> </td>
			<td class="totalpage">
			total : <?=$total_no?>, <?=$page?> / <?=$total_page?> page
			</td>
			<td align="right">

				<select name="s_cate1" class="input3">
					<option value=""> - 분류1 - </option>
					<?
					$get_que = "select * from ".$initial."_".$_t1." where bid is not null ";
					$get_que .= " and use_flag='1'";
					$get_que .= " order by bid asc";
					$get_rst =mysql_query($dbconn, $get_que) or die (mysql_error());
					while ($get_arr = mysql_fetch_array($get_rst)) {
						$bid	= sprintf('%02d', $get_arr[bid]);
						$name	= db2html($get_arr[name]);
					?>
					<option value="<?=$bid?>" <?if($bid == $s_cate1) {?>selected<?}?>><?=$name?></option>
					<?
					}
					?>
				</select>
				<select name="s_cate2" class="input3">
					<option value=""> - 분류2 - </option>
					<?
					if($cate1) {
						$cate_que = "select * from ".$initial."_".$_t2." where mid is not null ";
						$cate_que .= " and bid = '".$cate1."'";
						$cate_que .= " order by mid asc";
						$cate_rst = mysql_query($cate_que, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
						while ($cate_arr = mysql_fetch_array($cate_rst)) {
							$mid		= sprintf('%02d', $cate_arr[mid]);
							$mname		= db2html($cate_arr[name]);	  //이름
							$muse_flag	= $cate_arr[use_flag];
							?>
							<option value="<?=$mid?>" <?=$mid==$s_cate2?"selected":""?>><?=$mname?></option>
							<?
						}
					}
					?>
				</select>
				<!-- 제목,내용,글쓴이로 검색 -->
				<select name="search" size="1" class="input3">
					<option value="all" <? echo $search == "all"?"selected":"";?>>전체</option>
					<option value="iname" <? echo $search == "iname"?"selected":"";?>>품명</option>
					<option value="icode" <? echo $search == "icode"?"selected":"";?>>코드</option>
				</select>
				<input type="text" name="search_text" maxlength="20" value="<?=$search_text?>" size="14">
				<input type="submit" class="area-btn white small kr-01" border="0" value="검색">
			</td>
		</tr>
		<tr>
			<td> </td>
			<td> </td>
			<td colspan="2" height="5"> </td>
		</tr>
	</table>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbl_wrap">
		<tr>
		  <td colspan="15" height="1" class="bgcolor1" ></td>
		</tr>
		<tr class="bgcolor2" align="center" height="45">
		  <td height="25" align="center" nowrap class="no"><b>No.</b></td>
		  <td nowrap><b>이미지</b></td>
		  <td nowrap><b>품명</b></td>
		  <td nowrap><b>구분</b></td>
		  <td nowrap><b>규격</b></td>
		  <td nowrap><b>재고량</b></td>
		  <td nowrap><b>사용여부</b></td>
		</tr>
		<tr>
		  <td colspan="15" class="t_bborder1"></td>
		</tr>
		<?
			if($total_no == 0) {
		?>
		<tr align="center">
		  <td colspan="15">등록된 내용이 없습니다.</td>
		</tr>
		<tr>
		  <td colspan="15" class="t_bborder1"></td>
		</tr>
		<?
			} else {
				while ($array = mysql_fetch_array($result)) {
					$rot_num += 1;

					$idx        = $array[idx];
					$icode		= $array[icode];
					$cate1      = $array[cate1];
					$cate2		= $array[cate2];
					$iname		= db2html($array[iname]);
					$class		= $array["class"];
					$standard	= $array[standard];
					$img_file	= $array[img_file];
					$use_flag   = $array[use_flag];
					$stock_qty  = $array[stock_qty];
					$remark		= db2html($array[remark]);
					$regdate	= $array[regdate];
					$upddate    = $array[upddate];
					$regid		= $array[regid];
					$updid		= $array[updid];

					//$subject = cut_string($subject,42);			//제목자르기
					//$subject = getNewicon2($subject,$writedate,$link);

					$cate1_text = getCategoryName1($cate1,$dbconn);
					$cate2_text = getCategoryName2($cate1,$cate2,$dbconn);
					$regdate	= substr($regdate, 0, 10); 				//등록일
					//수정일
					if($upddate == "0000-00-00 00:00:00") $upddate = "-";
					else $upddate	= substr($upddate, 0, 10);

					$boolnull = $rot_num % 2;

					if ($boolnull == 0) {
						$bgcol = "background-color:#FFFFFF;";
					} else {
						$bgcol = "background-color:#eee;";
					}

		?>
		<tr style="text-align:center;<?=$bgcol?>" height="30" class="row_off" onMouseOver="this.className='row_on'" onMouseOut="this.className='row_off'">
		  <td height="25" width="70"><?=$cur_num?></td>
		  <td width="100">
			<?if($img_file) {?>
			<a href="javascript:go_view('<?=$idx?>')"><img src="<?=$foldername?><?=fileKor($img_file)?>" alt="<?=$img_file?>" width="60" border="0"></a>
			<?} else {?>
			<a href="javascript:go_view('<?=$idx?>')"><img src="../images/no_img.png" alt="no image" width="60" border="0"></a>
			<?}?>
		  </td>
		  <td align="left">
		  <span class="category"><?=$cate1_text?> <?if($cate2_text) {?>&gt; <?=$cate2_text?><?}?></span><br>
		  <span class="title"><a href="javascript:go_view('<?=$idx?>');"><?=$iname?></a></span><br>
		  <span class="code"><?=$icode?></span>
		  </td>
		  <td width="60">
		  <?=getCodeNameDB("code_itemkind",$class,$dbconn)?>
		  </td>
		  <td width="60">
		  <?=getCodeNameDB("code_standard",$standard,$dbconn)?>
		  </td>
		  <td width="80"><?=$stock_qty?></td>
		  <td width="60"><?=getArrayVal($__array_active, $use_flag)?></td>
		</tr>
		<tr>
		  <td colspan="15" class="t_bborder1"></td>
		</tr>
		<?
					$cur_num --;
				}
			}
		?>
	</table>

	<table align='center' border='0' cellspacing='1' cellpadding='0' width='100%' id="tbl_wrap">
		<tr>
			<td align='center' height="30">
				<?=fn_page($total_page, $page_num, $page, $link_url)?>
			</td>
		</tr>
	</table>
	<br>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbl_wrap">
		<tr>
			<td height="30">
			<?if($popup=="1") {?>
			<a href="javascript:self.close()" class="area-btn white default kr-01">닫기</a>
			<?} else {?>
			<a href="javascript:go_list()" class="area-btn white default kr-01">목록</a>
			<?}?>
			</td>
			<td align="right">
			</td>
		</tr>
		<tr align="center">
			<td colspan="2" height="30"> </td>
		</tr>
	</form>
	</table>
<?

	include "../inc/footer.php";
?>
<? mysql_close($dbconn); ?>
