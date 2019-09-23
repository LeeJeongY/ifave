<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	@set_time_limit(0);
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";
?>
<?	include "../inc/header.php"; ?>
<script language="javascript">
<!--
function go_delete() {
	var ans=confirm('선택한 정보는 완전삭제되므로 복구할수 없습니다.\n\n             삭제하시겠습니까?');
	if(ans) document.listform.submit();
}
 //-->
 </script>

  <div class="content-wrapper">

    <section class="content">


<?

	include "tabmenu_navi.php";

?>


<?
	if($tbl == "") $tbl	= "referer"; 				//테이블 이름
	$foldername  = "../../$upload_dir/$tbl/";

	if($page == '') $page = 1;
	$list_num = 30;
	$page_num = 10;
	$offset = $list_num*($page-1);

	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "$PHP_SELF?ipaddr=$ipaddr&search=$search&search_text=$search_text&type=$type&cate=$cate&category=$category&menu_b=$menu_b&menu_m=$menu_m&menu_t=$menu_t&tbl=$tbl&";

	if($search_text != "") $qry_where .= " and $search like '%$search_text%'" ;
	if($ipaddr!="") $qry_where .= " and addr='$ipaddr'";

	$query="select count(idx) from ".$initial."_".$tbl." where signdate is not null ";
	$query = $query." $qry_where ";

	$result=mysql_query($query,$dbconn) or die (mysql_error());
	$row=mysql_fetch_row($result);
	$total_no=$row[0];

	$total_page=ceil($total_no/$list_num);
	$cur_num=$total_no - $list_num*($page-1);

	$query = "select idx, addr, referer, uri, agent, from_unixtime(signdate, '%Y-%m-%d %H:%i:%s') as signdate from ".$initial."_".$tbl." where signdate is not null  ";
	$query .= $qry_where;
	$query .= " order by signdate desc limit $offset, $list_num";
	$result = mysql_query($query,$dbconn) or die (mysql_error());
?>


	<?=$page?> / <?=$total_page?> page

	<form name="search" method="post" action="<?=$PHP_SELF?>">
	<input type="hidden" name="menu_b" value="<?=$menu_b?>">
	<input type="hidden" name="menu_m" value="<?=$menu_m?>">
	<input type="hidden" name="menu_t" value="<?=$menu_t?>">
	<select name="keyfield">
		<option value="addr" <?if($keyfield=="addr") echo("selected");?>>주소</option>
		<option value="referer" <?if($keyfield=="referer") echo("selected");?>>경유지</option>
	</select>&nbsp;
	<INPUT type="text" name="key" value="<?=$key?>">&nbsp;
	<input type="button" name="Bsearch" value=" 검 색 " onClick="javascript:document.search.submit()">
	</form>

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">경로 접속통계</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
				<form name=listform method="post" action="connect_delete.php">
				<input type="hidden" name="menu_b" value="<?=$menu_b?>">
				<input type="hidden" name="menu_m" value="<?=$menu_m?>">
				<input type="hidden" name="menu_t" value="<?=$menu_t?>">
                <tr>
					<th style="width: 80px">NO</th>
					<th style="width: 100px">IP 주소</th>
					<th>경유지</th>
					<th style="width: 180px">접속PAGE</th>
					<th style="width: 280px">브라우저</th>
					<th style="width: 100px">접속일</th>
                </tr>
		<?
			if($total_no == 0) {
		?>
				<tr height="30">
					<td align="center" colspan="6">검색된 내역이 없습니다.</td>
				</tr>

		<?
			} else {
				while ($array=mysql_fetch_array($result)) {
					$rot_num += 1;
					$idx		= stripslashes($array[idx]);
					$addr		= stripslashes($array[addr]);
					$referer	= stripslashes($array[referer]);
					$uri		= stripslashes($array[uri]);
					$agent		= stripslashes($array[agent]);
					$signdate	= stripslashes($array[signdate]);

					$cut_referer	= cut_string($referer,100);
					$cut_uri		= cut_string($uri,50);


		?>

				<tr>
				  <td><?=$idx?></td>
				  <td><?=$addr?></td>
				  <td><?if($referer != "직접입력"){?><a href="<?=$referer?>" target="_blank" title="<?=$referer?>"><?}?><?=$cut_referer?></a></td>
				  <td><span title="<?=$referer?>"><?=$cut_uri?></span></td>
				  <td><?=$agent?></td>
				  <td><?=$signdate?></td>
				</tr>
<?
		$cur_num--;
		}
	}
?>
			  </form>
			</table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
				<?=fn_page($total_page, $page_num, $page, $link_url)?>
              </ul>
            </div>
          </div>
          <!-- /.box -->

        </div>
      </div>
	</section>

</div>
<?	include "../inc/footer.php"; ?>
<? mysql_close($dbconn); ?>
