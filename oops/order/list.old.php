<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl = "order";							//테이블명
	$tbl_s = "sell";
	$tbl_b = "bcode";						//테이블명
	$tbl_m = "mcode";						//테이블명
	$foldername	= "../../goods_img/";		//폴더 이름



	if($syear == "") {
		$year_s = date("Y");
		$month_s = date("m");
		if($month_s < 10) $month_s = substr($month_s,1,1);
		$day_s = date("d");
		if($day_s < 10) $day_s = substr($day_s,1,1);

		$year_e = date("Y");
		$month_e = date("m");
		if($month_e < 10) $month_e = substr($month_e,1,1);
		$day_e = date("d");
		if($day_e < 10) $day_e = substr($day_e,1,1);

	} else {
		$year_s = $syear;
		$month_s = $smonth;
		$day_s = $sday;

		$year_e = $eyear;
		$month_e = $emonth;
		$day_e = $eday;
	}

	if($syear != "" ) {
		if($smonth < 10) $tmp_smonth = "0".$smonth;
		else $tmp_smonth = $smonth;
		if($sday < 10) $tmp_sday = "0".$sday;
		else $tmp_sday = $sday;

		$sdate = $syear . $tmp_smonth . $tmp_sday;
	}
	if($eyear != "" ) {
		if($emonth < 10) $tmp_emonth = "0".$emonth;
		else $tmp_emonth = $emonth;
		if($eday < 10) $tmp_eday = "0".$eday;
		else $tmp_eday = $eday;

		$edate = $eyear . $tmp_emonth . $tmp_eday;
	}


	if($page == '') $page = 1; 					//페이지 번호가 없으면 1
	$list_num = 20; 							//한 페이지에 보여줄 목록 갯수
	$page_num = 10; 							//한 화면에 보여줄 페이지 링크(묶음) 갯수
	$offset = $list_num*($page-1); 				//한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "$PHP_SELF?search=$search&search_text=$search_text&ostatus=$ostatus&menu_b=$menu_b&menu_m=$menu_m&menu_t=$menu_t&";

	if ($sdate != "" || $edate != "") $qry_where = $qry_where . " and DATE_FORMAT(signdate,'%Y%m%d') >= '$sdate' and DATE_FORMAT(signdate,'%Y%m%d') <= '$edate' " ;
	if ($ostatus != "") $qry_where = "and status = '$ostatus' ";
	if ($search != "") $qry_where = $qry_where . " and $search like '%$search_text%'" ;

	$query = "select count(ordernum) from ".$initial."_".$tbl." where ordernum is not null ";
	$query .= $qry_where;

	$result=mysql_query($query,$dbconn) or die (mysql_error());
	$row=mysql_fetch_row($result);
	$total_no=$row[0];

	$total_page=ceil($total_no/$list_num);
	$cur_num=$total_no - $list_num*($page-1);

	$query = "select * from ".$initial."_".$tbl." where ordernum is not null ";
	$query .= $qry_where;
	$query .= " order by signdate desc limit $offset, $list_num";
	$result=mysql_query($query) or die (mysql_error());

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
	//상태 변경 셀렉트 메뉴
	include "../js/select_menu.js.php";
?>
<script language="JavaScript">
<!--

	//선택하여 삭제 할때
	function CheckAll() {
		len = document.liform.elements.length;
		var i=0;
		for(i=0; i < len; i++)	{
			if( document.liform.elements[i].checked == false) {
				document.liform.elements[i].checked=true;
			}
			else {
				document.liform.elements[i].checked = false;
			}
		}
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

	//상태변경
	function go_status(param1, param2) {
		var fm = document.form;
		fm.ordernum.value = param1;
		fm.ostatus.value = param2;
		fm.method = "post";
		fm.action = "status_ok.php";
		fm.submit();
	}


	function go_edit(str) {

		var url_page = "write.php?idx="+str+"&popup=1&gubun=update";
		var w = "750";
		var h = "650";
		var win = window.open(url_page, "_item", 'width='+w+',height='+h+', menubar=0, scrollbars=1, resizable=1');
		win.focus();


	}


	function go_list() {
		var frm = document.form;
		frm.method = "get";
		frm.action = "<?=$PHP_SELF?>";
		frm.submit();
	}

	function go_view(param) {
		var frm = document.form;
		frm.ordernum.value = param;
		frm.gubun.value = "view";
		frm.method = "get";
		frm.action = "view.php";
		frm.submit();
	}
//-->
</script>

<style>
/*@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {*/
@media only screen and (max-width: 800px) {
  #_table_ table, thead, tbody, tr, th, td{
	display:block;
  }
  #_table_ thead tr{
	position:absolute;
	top:-9999px;
	left:-9999px;
  }
  #_table_ tr {
	border-bottom:1px solid #ccc;
  }
  #_table_ td {
	border: none;
	border-bottom: 1px solid #eee;
	position: relative;
	padding-left: 50%;
	white-space: normal;
	text-align:left;
  }
  #_table_ td:before {
	/* Now like a table header */
	position: absolute;
	/* Top/left values mimic padding */
	top: 6px;
	left: 6px;
	width: 45%;
	padding-right: 10px;
	/*white-space: nowrap;*/
	text-align:left;
	font-weight: bold;
  }
  #_table_ th {
	display:none;
  }
 #_table_  td:before{content: attr(data-title);}
 #_table_ td:nth-child(8),
 #_table_ th:nth-child(8) {display: none;}
}
</style>

<form name="form">
<input type="hidden" name="idx">
<input type="hidden" name="gubun">
<input type="hidden" name="s_icode" value="">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup-":""?>content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        주문내역
        <small>상품주문내역</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 주문관리</a></li>
        <li class="active">주문내역</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->


      <div class="row">
        <div class="col-xs-12">
          <div class="box">


			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li <?=$s_cate1==""?"class=\"active\"":""?>><a href="?s_cate1=&popup=<?=$popup?>&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>">전체목록</a></li>
				<?
				//분류 1차
				$strQuery = "SELECT * from ".$initial."_product_cate1 WHERE bid IS NOT NULL ";
				$strQuery .= " AND use_flag='1'";
				$strQuery .= " ORDER BY bid ASC";
				$strResult = mysql_query($strQuery, $dbconn);
				while ($arrResult = mysql_fetch_array($strResult)) {
					$cate1_id		= $arrResult[bid];
					$cate1_name		= db2html($arrResult[name]);
					$cate1_bcode	= sprintf('%02d', $cate1_id);
				?>
					<li <?=$cate1_bcode==$s_cate1?"class=\"active\"":""?>><a href="?s_cate1=<?=$cate1_bcode?>&popup=<?=$popup?>&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>"><?=$cate1_name?></a></li>
				<?
				}
				?>
				</ul>
				<?
				if($s_cate1) {
					//분류 2차
					$strQuery = "SELECT * FROM ".$initial."_product_cate2 WHERE mid is not null ";
					$strQuery .= " AND bid='".$s_cate1."'";
					$strQuery .= " AND use_flag='1'";
					$strQuery .= " ORDER BY CAST(mid as signed) ASC";
					$strResult = mysql_query($strQuery, $dbconn);
					$cate2_no = mysql_num_rows($strResult);
					if($cate2_no > 0) {
					?>
						<span class="category_tabs2 nav-tabs" ><a href="?s_cate1=<?=$s_cate1?>&s_cate2=&popup=<?=$popup?>&search=<?=$search?>&search_text=<?=$search_text?>&<?=$link_menu_url?>" class="label <?=$s_cate2==""?"label-info":"label-default"?>">전체</a></span>
						<?
						while ($arrResult = mysql_fetch_array($strResult)) {
							$cate2_id		= $arrResult[mid];
							$cate2_name		= db2html($arrResult[name]);
							$cate2_mcode	= sprintf('%02d', $cate2_id);
						?>
						<span class="category_tabs2 nav-tabs" ><a href="?s_cate1=<?=$s_cate1?>&s_cate2=<?=$cate2_id?>&popup=<?=$popup?>&search=<?=$search?>&search_text=<?=$search_text?>&<?=$link_menu_url?>" class="label <?=$cate2_mcode==$s_cate2?"label-info":"label-default"?>"><?=$cate2_name?></a></span>
						<?
						}
					}
				}
				?>
			</div>


			<form method="get" action="<?=$PHP_SELF?>" name="schform">
			<input type="hidden" name="s_cate1" value="<?=$s_cate1?>">
			<input type="hidden" name="s_cate2" value="<?=$s_cate2?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
            <div class="box-header">
              <h3 class="box-title">Total : <?=$total_no?>, <?=$page?> / <?=$total_page?> page</h3>

              <div class="box-tools">

                <div class="input-group input-group-sm">
					<div class="input-group col-xs-12">
						<!-- 제목,내용,글쓴이로 검색 -->
						<select name="ostatus" class="select2" style="width:120px;">
							<option value="" <? echo $ostatus == ""?"selected":"";?>>전체</option>
							<option value="주문접수" <? echo $ostatus == "주문접수"?"selected":"";?>>주문접수</option>
							<option value="카드결제" <? echo $ostatus == "카드결제"?"selected":"";?>>카드결제</option>
							<option value="입금완료" <? echo $ostatus == "입금완료"?"selected":"";?>>입금완료</option>
							<option value="주문취소" <? echo $ostatus == "주문취소"?"selected":"";?>>주문취소</option>
							<option value="배송예정" <? echo $ostatus == "배송예정"?"selected":"";?>>배송예정</option>
							<option value="배송중" <? echo $ostatus == "배송중"?"selected":"";?>>배송중</option>
							<option value="배송완료" <? echo $ostatus == "배송완료"?"selected":"";?>>배송완료</option>
							<option value="반송" <? echo $ostatus == "반송"?"selected":"";?>>반송</option>
							<option value="반품" <? echo $ostatus == "반품"?"selected":"";?>>반품</option>
						</select>
						<select name="search" class="select2" style="width:80px;">
							<option value="all" <? echo $search == "all"?"selected":"";?>>전체</option>
							<option value="pay_name" <? echo $search == "pay_name"?"selected":"";?>>주문자</option>
							<option value="userid" <? echo $search == "pcode"?"selected":"";?>>아이디</option>
							<option value="title" <? echo $search == "title"?"selected":"";?>>제목</option>
							<option value="content" <? echo $search == "content"?"selected":"";?>>내용</option>
						</select>
						<input type="text" name="search_text" value="<?=$search_text?>" style="width: 150px;" class="form-control pull-right" placeholder="Search">

						<div class="input-group-btn">
						<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</div>
              </div>
            </div>
			</form>


            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			<form name="listform" id="listform" method="post">
			<input type="hidden" name="gubun" id="gubun">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="search_text" value="<?=$search_text?>">
			<input type="hidden" name="s_cate1" value="<?=$s_cate1?>">
			<input type="hidden" name="s_cate2" value="<?=$s_cate2?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
              <table class="table table-hover" id="_table_">
                <tr>
                  <th nowrap width="10"><input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"></th>
				  <th nowrap width="20">No.</td>
				  <th nowrap width="100" style="text-align:center">주문자</th>
				  <th nowrap width="100">주문상품</th>
				  <th nowrap width="100">결제방법</th>
				  <th nowrap width="70">총금액</th>
				  <th nowrap width="120">처리상황</th>
				  <th nowrap width="120">결제여부</th>
				  <th nowrap width="120">주문일</th>
				  <th nowrap width="100">관리</th>
				</tr>
				<?
					if($total_no == 0) {
				?>
                <tr>
                  <td align="center" colspan="16">등록된 정보가 없습니다.</td>
                </tr>
				<?
					} else {
						while ($array = mysql_fetch_array($result)) {
							$rot_num += 1;

							$orderseq = stripslashes($array[orderseq]);
							$ordernum = stripslashes($array[ordernum]);
							$pay_name = stripslashes($array[pay_name]);
							$pay_tel1 = stripslashes($array[pay_tel1]);
							$pay_tel2 = stripslashes($array[pay_tel2]);
							$pay_tel3 = stripslashes($array[pay_tel3]);
							$pay_mobile1 = stripslashes($array[pay_mobile1]);
							$pay_mobile2 = stripslashes($array[pay_mobile2]);
							$pay_mobile3 = stripslashes($array[pay_mobile3]);
							$pay_zip1 = stripslashes($array[pay_zip1]);
							$pay_zip2 = stripslashes($array[pay_zip2]);
							$pay_addr = stripslashes($array[pay_addr]);
							$pay_email = stripslashes($array[pay_email]);
							$receive_name = stripslashes($array[receive_name]);
							$receive_tel1 = stripslashes($array[receive_tel1]);
							$receive_tel2 = stripslashes($array[receive_tel2]);
							$receive_tel3 = stripslashes($array[receive_tel3]);
							$receive_mobile1 = stripslashes($array[receive_mobile1]);
							$receive_mobile2 = stripslashes($array[receive_mobile2]);
							$receive_mobile3 = stripslashes($array[receive_mobile3]);
							$receive_zip1 = stripslashes($array[receive_zip1]);
							$receive_zip2 = stripslashes($array[receive_zip2]);
							$receive_addr = stripslashes($array[receive_addr]);
							$receive_email = stripslashes($array[receive_email]);
							$skind = stripslashes($array[skind]);
							$bank = stripslashes($array[bank]);
							$in_name = stripslashes($array[in_name]);
							$in_year = stripslashes($array[in_year]);
							$in_month = stripslashes($array[in_month]);
							$in_day = stripslashes($array[in_day]);
							$charge = stripslashes($array[charge]);
							$char_year = stripslashes($array[char_year]);
							$char_month = stripslashes($array[char_month]);
							$char_day = stripslashes($array[char_day]);
							$char_num = stripslashes($array[char_num]);
							$ostatus = stripslashes($array[status]);
							$passwd = stripslashes($array[passwd]);
							$signdate = stripslashes($array[signdate]);
							$tid = stripslashes($array[tid]);
							$doc = stripslashes($array[doc]);
							$kind = stripslashes($array[kind]);
							$userid = stripslashes($array[userid]);
							$secu = stripslashes($array[secu]);



							$signdate=substr($signdate,0,10); 					//주문일

							if($skind == "2") $skindStr = "무통장 입금";
							else if($skind == "1") $skindStr = "신용카드";


							$secuStr ="";
							if($secu == "1") $secuStr = "<font color='blue'>성공</font>";
							else if($secu == "0") $secuStr = "<font color='red'>실패</font>";

							if($skind == "2") $secuStr = "<font color='blue'>무통장</font>";

							if($signdate == "0000-00-00") $signdate = "-";

							$boolnull = $rot_num % 2;

							if ($boolnull == 0) {
								$bgcol = "background-color:#FFFFFF;";
							} else {
								$bgcol = "background-color:#eee;";
							}

				?>
                <tr>
                  <td nowrap data-title="선택"><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$idx?>" class="idxchk flat-red"></td>
				  <td nowrap data-title="번호"><?=$cur_num?>(<?=$idx?>)</td>
				  <td nowrap data-title="주문자" align="center">
					<?=$pay_name?>(<?=$userid?>)
				  </td>
				  <td nowrap data-title="주문상품명">
				  <span class="category"><?=$cate1_text?> <?if($cate2_text) {?>&gt; <?=$cate2_text?><?}?></span><br>
				  <span class="title"><a href="javascript:go_view('<?=$idx?>');">

				<?
					if($ordernum != "") {
					$mQuery = "select * from ".$initial."_".$tbl_s." where ordernum = '$ordernum' order by seq asc";
					$mResult=mysql_query($mQuery) or die (mysql_error()); // 쿼리문을 실행 결과
					$m_total = mysql_num_rows($mResult);
					while ($mArray=mysql_fetch_array($mResult)) {
						$l_seq			= $mArray[seq];
						$l_pcode		= $mArray[pcode];
						$l_name			= $mArray[pname];
						$l_price		= $mArray[price];
						$l_qty			= $mArray[qty];

						$sum_money = $l_price * $l_qty;
						$total_money += $sum_money;

						echo $l_name . "<br>";
					}
					$total_settle = $total_money + $charge;

				}?>

				  </a></span><br>
				  <span class="code"><?=$pcode?></span>
				  </td>
				  <td nowrap data-title="상품정보">

					<a href="javascript:mopen(<?=$orderseq?>);" class="menu area-btn white small kr-01" id="mmenu<?=$orderseq?>"><?=$ostatus?></a>
					<div class="submenu" id="menu<?=$orderseq?>">
					<a href="javascript:go_status('<?=$ordernum?>','주문접수');">주문접수</a>
					<a href="javascript:go_status('<?=$ordernum?>','카드결제');">카드결제</a>
					<a href="javascript:go_status('<?=$ordernum?>','입금완료');">입금완료</a>
					<a href="javascript:go_status('<?=$ordernum?>','주문취소');">주문취소</a>
					<a href="javascript:go_status('<?=$ordernum?>','배송예정');">배송예정</a>
					<a href="javascript:go_status('<?=$ordernum?>','배송중');">배송중</a>
					<a href="javascript:go_status('<?=$ordernum?>','배송완료');">배송완료</a>
					<a href="javascript:go_status('<?=$ordernum?>','반송');">반송</a>
					<a href="javascript:go_status('<?=$ordernum?>','반품');">반품</a>
					</div>

				  </td>
				  <td nowrap data-title="사용여부"><?=getCodeNameDB("code_useflag",$use_flag, $dbconn)?></td>
				  <td nowrap data-title="등록일">
				  <?=$regdate?>
				  <?if($upddate!="0000-00-00 00:00:00") {?>
				  <br/><?=$upddate?>
				  <?}?>
				  </td>
				  <td nowrap data-title="관리">
				  <!--
					<a href="javascript:mopen(<?=$idx?>);" class="btn btn-flat btn-xs btn-warning" id="mmenu<?=$idx?>">관리</a>
					<div class="submenu" id="menu<?=$idx?>">
					<a href="javascript:go_search('<?=$icode?>');">검색</a>
					<a href="javascript:go_view('<?=$idx?>');">보기</a>
					<a href="javascript:go_edit('<?=$idx?>');">수정</a>
					<a href="javascript:go_delete('<?=$idx?>')">삭제</a>
					</div>
					 -->
				  <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
				  <button type="button" class="btn btn-flat btn-xs btn-danger" onClick="go_delete('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
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
              <a type="submit" class="btn btn-sm btn-primary" href="javascript:go_write();"><i class="fa fa-plus"></i> 추가</a>
              <a type="text" class="btn btn-sm btn-default" href="javascript:go_remove();"><i class="fa fa-minus"></i> 삭제</a>
              <ul class="pagination pagination-sm no-margin pull-right">
				<?=fn_page($total_page, $page_num, $page, $link_url)?>
              </ul>
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
?>
<? mysql_close($dbconn); ?>
