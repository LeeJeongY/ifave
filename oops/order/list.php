<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl = "product";
	$foldername  = "../../$upload_dir/$tbl/";

	if($page == '') $page = 1;
	$list_num = 30;
	$page_num = 10;
	$offset = $list_num*($page-1);

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "$PHP_SELF?s_site=$s_site&search=$search&search_text=$search_text&s_pay_state=$s_pay_state&s_delivery_state=$s_delivery_state&menu_b=$menu_b&menu_m=$menu_m&menu_t=$menu_t&";

	if ($sdate != "" || $edate != "") $qry_where .= " AND DATE_FORMAT(regdate,'%Y%m%d') >= '$sdate' and DATE_FORMAT(regdate,'%Y%m%d') <= '$edate' " ;


	if ($s_pay_state != "")			$qry_where .= " AND pay_state = '".$s_pay_state."' ";
	if ($s_delivery_state != "")	$qry_where .= " AND delivery_state = '".$s_delivery_state."' ";
	if ($search_text != "") {
		$search_text   = trim(stripslashes(addslashes($search_text)));
		if($search == "all") {
			$qry_where .= " AND (order_name like '%$search_text%' OR receive_name like '%$search_text%' OR remark like '%$search_text%' OR title like '%$search_text%' OR message like '%$search_text%')";
		} else {
			if($search_text) {
				$qry_where .= " AND $search like '%$search_text%'";
			}
		}
	}
	if($s_site)	$qry_where .= " and site = '$s_site'";

	$query = "SELECT count(order_num) FROM ".$initial."_".$tbl."_order WHERE order_num IS NOT NULL ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	$rownum = mysql_fetch_row($result);
	$total_no = $rownum[0];

	$total_page = ceil($total_no/$list_num);
	$cur_num = $total_no - $list_num*($page-1);

	$query = "SELECT * FROM ".$initial."_".$tbl."_order WHERE order_num IS NOT NULL ";
	$query .= $qry_where;
	$query .= " ORDER BY regdate DESC LIMIT $offset, $list_num";
	$result = mysql_query($query, $dbconn) or die (mysql_error());


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
			frm.order_seq.value = str;
			frm.gubun.value = "delete";
			frm.target = "_self";
			frm.method = "post";
			frm.action = "write_ok.php";
			frm.submit();
		}
	}

	//상태변경
	function go_state_update(kind, param1, param2) {
		var fm = document.form;
		fm.kind_state.value = kind;
		fm.order_seq.value	= param1;
		fm.pay_state.value	= param2;
		fm.method = "post";
		fm.action = "state_ok.php";
		fm.submit();
	}


	function go_edit(param) {

		var url_page = "write.php?idx="+param+"&popup=1&gubun=update";
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
		var url_page = "view.php?idx="+param+"&popup=1&gubun=view";
		var w = "750";
		var h = "650";
		var win = window.open(url_page, "_item", 'width='+w+',height='+h+', menubar=0, scrollbars=1, resizable=1');
		win.focus();
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

.order_list {}
.order_list ul {clear:both;list-style:none;padding-left:0px;}
.order_list ul li {float:left;text-align:left;font-size:12px;}
.order_list ul li.or_name {width:120px;}
.order_list ul li.or_price {text-align:right;}
</style>

<form name="form">
<input type="hidden" name="idx">
<input type="hidden" name="gubun">
<input type="hidden" name="kind_state" value="">
<input type="hidden" name="order_seq" value="">
<input type="hidden" name="pay_state" value="">
<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="s_site" value="<?=$s_site?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="s_pay_type" value="<?=$s_pay_type?>">
<input type="hidden" name="s_pay_state" value="<?=$s_pay_state?>">
<input type="hidden" name="s_delivery_state" value="<?=$s_delivery_state?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_t" value="<?=$menu_t?>">
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


			<!-- <div class="nav-tabs-custom">
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
			</div> -->



			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li<?=$s_site==""?" class=\"active\"":""?>><a href="?s_site=&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>">전체</a></li>
					<li<?=$s_site=="ko"?" class=\"active\"":""?>><a href="?s_site=ko&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>">국문</a></li>
					<li<?=$s_site=="en"?" class=\"active\"":""?>><a href="?s_site=en&menu_b=<?=$menu_b?>&menu_m=<?=$menu_m?>">영문</a></li>
				</ul>
			</div>



			<form method="get" action="<?=$PHP_SELF?>" name="schform">
			<input type="hidden" name="s_site" value="<?=$s_site?>">
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
						<select name="s_pay_type" class="select2" style="width:120px;">
							<option value="" <? echo $ostatus == ""?"selected":"";?>>결제방식</option>
							<?=getCodeNameSelectDB("code_pay_type", $s_pay_type, $dbconn)?>
						</select>
						<select name="s_pay_state" class="select2" style="width:120px;">
							<option value="" <? echo $ostatus == ""?"selected":"";?>>결제상태</option>
							<?=getCodeNameSelectDB("code_pay_state", $s_pay_state, $dbconn)?>
						</select>
						<select name="s_delivery_state" class="select2" style="width:120px;">
							<option value="" <? echo $ostatus == ""?"selected":"";?>>배송상태</option>
							<?=getCodeNameSelectDB("code_delivery_state", $s_delivery_state, $dbconn)?>
						</select>
						<select name="search" class="select2" style="width:120px;">
							<option value="all" <? echo $search == "all"?"selected":"";?>>전체</option>
							<option value="order_name" <? echo $search == "order_name"?"selected":"";?>>주문자</option>
							<option value="order_id" <? echo $search == "order_id"?"selected":"";?>>아이디</option>
							<option value="receive_name" <? echo $search == "receive_name"?"selected":"";?>>수령자</option>
							<option value="title" <? echo $search == "title"?"selected":"";?>>제목</option>
							<option value="message" <? echo $search == "message"?"selected":"";?>>내용</option>
							<option value="remark" <? echo $search == "remark"?"selected":"";?>>비고</option>
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
			<input type="hidden" name="s_pay_type" value="<?=$s_pay_type?>">
			<input type="hidden" name="s_pay_state" value="<?=$s_pay_state?>">
			<input type="hidden" name="s_delivery_state" value="<?=$s_delivery_state?>">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="s_site" value="<?=$s_site?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="search_text" value="<?=$search_text?>">
			<input type="hidden" name="s_cate1" value="<?=$s_cate1?>">
			<input type="hidden" name="s_cate2" value="<?=$s_cate2?>">
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">
			<input type="hidden" name="menu_t" value="<?=$menu_t?>">
              <table class="table table-hover" id="_table_">
                <tr>
                  <th nowrap width="10"><input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"></th>
				  <th nowrap width="20">No.</td>
				  <th nowrap width="200" style="text-align:center">주문자 정보</th>
				  <th nowrap>상품정보</th>
				  <th nowrap width="200">결제정보</th>
				  <th nowrap width="120">주문정보</th>
				  <th nowrap width="120">배송정보</th>
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

							$order_seq			= $array[seq];
							$order_tid         	= $array[order_tid];
							$order_num         	= $array[order_num];
							$order_id          	= $array[order_id];
							$order_name        	= db2html($array[order_name]);
							$order_tel         	= $array[order_tel];
							$order_hp          	= $array[order_hp];
							$order_email       	= $array[order_email];
							$order_zipcode     	= $array[order_zipcode];
							$order_addr1       	= $array[order_addr1];
							$order_addr2       	= $array[order_addr2];
							$order_addr3       	= $array[order_addr3];
							$receive_name      	= db2html($array[receive_name]);
							$receive_tel       	= $array[receive_tel];
							$receive_hp        	= $array[receive_hp];
							$receive_email     	= $array[receive_email];
							$receive_zipcode   	= $array[receive_zipcode];
							$receive_addr1     	= $array[receive_addr1];
							$receive_addr2     	= $array[receive_addr2];
							$receive_addr3     	= $array[receive_addr3];
							$title             	= db2html($array[title]);
							$message           	= db2html($array[message]);
							$pay_state         	= $array[pay_state];
							$pay_type          	= $array[pay_type];
							$sum_amount        	= $array[sum_amount];
							$fee_amount        	= $array[fee_amount];
							$pay_amount        	= $array[pay_amount];
							$pay_bank_code     	= $array[pay_bank_code];
							$pay_bank_name     	= db2html($array[pay_bank_name]);
							$pay_deposit_name  	= db2html($array[pay_deposit_name]);
							$pay_account_number	= $array[pay_account_number];
							$pay_deposit_date  	= $array[pay_deposit_date];
							$pay_card_code     	= $array[pay_card_code];
							$pay_card_name     	= $array[pay_card_name];
							$pay_card_number   	= $array[pay_card_number];
							$delivery_state    	= $array[delivery_state];
							$delivery_company  	= $array[delivery_company];
							$delivery_number   	= $array[delivery_number];
							$delivery_date     	= $array[delivery_date];
							$remark            	= db2html($array[remark]);
							$site           	= $array[site];
							$regdate           	= $array[regdate];
							$upddate           	= $array[upddate];
							$candate           	= $array[candate];


							if($regdate == "0000-00-00") $regdate = "-";

							$boolnull = $rot_num % 2;

							if ($boolnull == 0) {
								$bgcol = "background-color:#FFFFFF;";
							} else {
								$bgcol = "background-color:#eee;";
							}

				?>
                <tr>
                  <td nowrap data-title="선택"><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$order_seq?>" class="idxchk flat-red"></td>
				  <td nowrap data-title="번호" class="f11"><?=$cur_num?></td>
				  <td nowrap data-title="주문자 정보" class="f11">
					주문자 : <b><?=$order_name?></b>
					<?if($order_id!="") {?><br><span class="f11">아이디 : <?=$order_id?></span><?} else {?><br><span class="f11 btn btn-flat btn-xs btn-success">비회원</span><?}?>
					<?if($order_hp) {?><br>연락처 : <?=$order_hp?><?}?>
					<?if($order_email) {?><br>이메일 : <?=$order_email?><?}?>
				  </td>
				  <td nowrap data-title="상품 정보">
				  <span class="title"><a href="javascript:go_view('<?=$order_seq?>');"><?=$title?></a></span>
				  <?if($cate1) {?><br><span class="category"><?=$cate1_text?> <?if($cate2_text) {?>&gt; <?=$cate2_text?><?}?></span><?}?>
					<div class="order_list">
				<?
					$strQuery = "select * from ".$initial."_product_order_list where order_fid='".$order_seq."'";
					$strResult = mysql_query($strQuery, $dbconn) or die (mysql_error());
					while($strArray = mysql_fetch_array($strResult)) {
						$order_num		= $strArray[order_num];
						$user_id		= $strArray[user_id];
						$pidx			= $strArray[pidx];
						$pcode			= $strArray[pcode];
						$pname			= db2html($strArray[pname]);
						$quantity		= $strArray[quantity];
						$unit_price		= $strArray[unit_price];
						//$order_state	= $strArray[order_state];
						//$delivery_state	= $strArray[delivery_state];
						$v_regdate		= $strArray[regdate];
				?>
						<ul>
							<li class="or_name"><?=$pname?></li>
							<li class="or_price"><?=number_format($unit_price)?> * <?=$quantity?></li>
						</ul>
				<?
					}
				?>
					</div>

				  </td>
				  <td nowrap data-title="결제 정보" class="f11">
					<span class="code">결제방식 : <?=getCodeNameDB("code_pay_type",$pay_type, $dbconn)?></span>
					<br>상태정보 :
					<a href="javascript:mopen(<?=$order_seq?>);" class="menu area-btn white default kr-01" id="mmenu<?=$order_seq?>"><?=getCodeNameDB("code_pay_state",$pay_state, $dbconn)?></a>
					<div class="submenu" id="menu<?=$order_seq?>">
					<?
					$sql = "SELECT * FROM ".$initial."_code_selcode WHERE code_idx  IS NOT NULL ";
					$sql .= " AND kind_code = 'code_pay_state'";
					$sql .= " AND use_yn = 'Y'";
					$sql .= " ORDER BY seq_no  ASC";
					$rst = mysql_query($sql, $dbconn) or die (mysql_error());
					while ($arr=mysql_fetch_array($rst)) {
						$s_code			= $arr[s_code];
						$code_name		= db2html($arr[code_name]);	  //이름
					?>
					<a href="javascript:go_state_update('pay','<?=$order_seq?>','<?=$s_code?>', '<?=$code_name?>');"><?=$code_name?></a>
					<?
					}
					?>

					</div>
					<br>주문금액 : <?=number_format($sum_amount)?>, 배송금액 : <?=number_format($fee_amount)?>
					<br><b>결제금액</b> : <?=number_format($pay_amount)?>

				  </td>
				  <td nowrap data-title="주문 정보" class="f11">
					<?if($order_num) {?><span>주문번호 : <b><?=$order_num?></b></span><?}?>
					<br>주문일 : <?=$regdate?>
					<?if($upddate!="0000-00-00 00:00:00") {?>
					<br/>수정일 : <?=$upddate?>
					<?}?>
					<?if($order_tid) {?><span class="code">TID번호 : <?=$order_tid?></span><?}?>
				  </td>
				  <td nowrap data-title="배송 정보" class="f11">
				  배송상태 :

					<a href="javascript:mopen(1<?=$order_seq?>);" class="menu area-btn white default kr-01" id="mmenu1<?=$order_seq?>"><?=getCodeNameDB("code_delivery_state",$delivery_state, $dbconn)?></a>
					<div class="submenu" id="menu1<?=$order_seq?>">
					<?
					$sql = "SELECT * FROM ".$initial."_code_selcode WHERE code_idx  IS NOT NULL ";
					$sql .= " AND kind_code = 'code_delivery_state'";
					$sql .= " AND use_yn = 'Y'";
					$sql .= " ORDER BY seq_no  ASC";
					$rst = mysql_query($sql, $dbconn) or die (mysql_error());
					while ($arr=mysql_fetch_array($rst)) {
						$s_code			= $arr[s_code];
						$code_name		= db2html($arr[code_name]);	  //이름
					?>
					<a href="javascript:go_state_update('delivery','<?=$order_seq?>','<?=$s_code?>', '<?=$code_name?>');"><?=$code_name?></a>
					<?
					}
					?>
					</div>


						<?//=getCodeNameDB("code_delivery_state",$delivery_state, $dbconn)?>
						<?if($delivery_company) {?><br>택배회사 : <?=$delivery_company?><?}?>
						<?if($delivery_number) {?><br>송장번호 : <?=$delivery_number?><?}?>
						<?if($delivery_date) {?><br>배송일자 : <?=$delivery_date?><?}?>
						<?if($receive_name) {?><br>수령인 : <?=$receive_name?><?}?>
						<?if($receive_addr1) {?><br>배송주소 : <?=$receive_addr1?>, <?=$receive_addr2?><?}?>

				  </td>
				  <td nowrap data-title="관리">
				  <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$order_seq?>')" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
				  <button type="button" class="btn btn-flat btn-xs btn-danger" onClick="go_delete('<?=$order_seq?>')" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
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
              <!-- <a type="submit" class="btn btn-sm btn-primary" href="javascript:go_write();"><i class="fa fa-plus"></i> 추가</a> -->
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
