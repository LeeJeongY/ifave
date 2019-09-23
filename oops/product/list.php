<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl	= "product"; 				//테이블 이름
	$_t1	= "product_cate1";
	$_t2	= "product_cate2";
	$foldername  = "../../$upload_dir/$tbl/";

	if($page == '') $page = 1; 					//페이지 번호가 없으면 1
	$list_num = 30; 							//한 페이지에 보여줄 목록 갯수
	$page_num = 10; 							//한 화면에 보여줄 페이지 링크(묶음) 갯수
	$offset = $list_num*($page-1); 				//한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "?s_cate1=$s_cate1&s_cate2=$s_cate2&search=$search&search_text=$search_text&menu_b=$menu_b&menu_m=$menu_m&menu_t=$menu_t&";

	if ($search_text != "") {
		$search_text   = trim(stripslashes(addslashes($search_text)));
		if($search == "all") {
			$qry_where .= " AND (pname like '%$search_text%' OR pcode like '%$search_text%' OR title like '%$search_text%' OR content like '%$search_text%')";
		} else {
			if($search_text) {
				$qry_where .= " AND $search like '%$search_text%'";
			}
		}
	}
	if($s_cate1)	$qry_where .= " AND cate1='$s_cate1'";
	if($s_cate2)	$qry_where .= " AND cate2='$s_cate2'";

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
	//스크립트
	include "../js/goto_page.js.php";
	//상태 변경 셀렉트 메뉴
	include "../js/select_menu.js.php";
?>
<script language="JavaScript">
<!--

	function go_list() {
		var frm = document.form;
		frm.gubun.value = "";
		frm.idx.value = "";
		frm.method = "get";
		frm.target = "_self";
		frm.action = "list.php";
		frm.submit();
	}
/*
	function go_search(param) {
		var frm = document.form;
		frm.s_icode.value = param;
		frm.gubun.value = "";
		frm.method = "get";
		frm.target = "_self";
		frm.action = "../warehouse/list.php";
		frm.submit();
	}
*/
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
		var w = "750";
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
		var w = "750";
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
		var w = "750";
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
        상품목록
        <small>상품전체관리</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 상품관리</a></li>
        <li class="active">상품목록</li>
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
						<select name="search" class="select2" style="width:80px;">
							<option value="all" <? echo $search == "all"?"selected":"";?>>전체</option>
							<option value="pname" <? echo $search == "pname"?"selected":"";?>>상품명</option>
							<option value="pcode" <? echo $search == "pcode"?"selected":"";?>>상품코드</option>
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
				  <th nowrap width="100" style="text-align:center">이미지</th>
				  <th nowrap>상품명</th>
				  <th nowrap width="100">상품정보</th>
				  <th nowrap width="70">사용여부</th>
				  <!-- <th nowrap>하위상품관리</th> -->
				  <th nowrap width="120">등록/수정</th>
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



							//$title = cut_string($title,42);			//제목자르기
							//$title = getNewicon2($title,$regdate,$link);

							//카테고리
							$cate1_text = getCategoryName1($cate1, $dbconn);
							//$cate2_text = getCategoryName2($cate1,$cate2,$dbconn);

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
				  <td nowrap data-title="이미지" align="center">
					<?if($img_file) {?>
					<a href="javascript:go_view('<?=$idx?>')"><img src="<?=$foldername?><?=$img_file?>" alt="<?=$img_file?>" height="80" border="0"></a>
					<?} else {?>
					<a href="javascript:go_view('<?=$idx?>')"><img src="../images/noimage.png" alt="no image" height="80" border="0"></a>
					<?}?>
				  </td>
				  <td nowrap data-title="상품명">

				  <span class="title"><a href="javascript:go_view('<?=$idx?>');"><b><?=$pname?></b></a></span>
				  <?if($cate1_text) {?>
				  <br><span class="category"><?=$cate1_text?> <?if($cate2_text) {?>&gt; <?=$cate2_text?><?}?></span>
				  <?}?>
				  <?if($pcode) {?>
				  <br><span class="code"><?=$pcode?></span>
				  <?}?>
				  </td>
				  <!-- <td nowrap data-title="구분">
				  <?=getCodeNameDB("code_itemkind",$class,$dbconn)?>
				  </td> -->
				  <td nowrap data-title="상품정보">
				  <?if($option_color) {?>색상 : <?=$option_color?><?}?>
				  <?if($price) {?><br>가격 : <?=number_format($price)?><?}?>
				  </td>
				  <td nowrap data-title="사용여부"><?=getCodeNameDB("code_useflag",$use_flag, $dbconn)?></td>
				  <!-- <td nowrap data-title="하위상품등록">
					<a href="javascript:mopen(<?=$idx?>);" class="menu label label-primary" id="mmenu<?=$idx?>">하위상품(<?=$sub_no?>)</a>
					<div class="submenu" id="menu<?=$idx?>">
					<a href="javascript:_popup_page('pp_sub_list.php?fid=<?=$idx?>&popup=1','_sub','1000','800');">하위상품 등록하기</a>
					</div>
				  </td> -->
				  <!-- <td nowrap data-title="내용"><?//=$remark?></td> -->
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
