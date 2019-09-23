
              <table class="table table-bordered">
				<form name=listform method="post" action="connect_delete.php">
				<input type="hidden" name="menu_b" value="<?=$menu_b?>">
				<input type="hidden" name="menu_m" value="<?=$menu_m?>">
				<input type="hidden" name="menu_t" value="<?=$menu_t?>">
                <tr>
					<th style="width: 120px">IP정보</th>
					<th><?=$curr_year?>년 <?=$curr_month?>월 일자별 접속현황</th>
					<th>경유지</th>
					<th>건수</th>
                </tr>

<?
if ($curr_year=="") {
	$curr_year = date("Y");
}
if ($curr_month=="") {
	$curr_month = date("m");
}

for ($ld=27; checkdate($curr_month,$ld,$curr_year) ; $ld++){}
$month_last_day=$ld-1;

$sdate = $curr_year . $curr_month . "01";
$edate = $curr_year . $curr_month . $month_last_day;

//총갯수
$query = "SELECT count(".$signdate.") as totcnt FROM ".$initial."_".$tbl." ";
$query .= " WHERE from_unixtime(".$signdate.", '%Y%m%d') >= '".$sdate."' AND from_unixtime(".$signdate.", '%Y%m%d') <= '".$edate."'  ";
$query .= $qry_where;
$result = mysql_query($query,$dbconn) or die (mysql_error());
$row = mysql_fetch_row($result);
$total_count = $row[0];

$query = "SELECT addr, count(".$signdate.") as cnt FROM ".$initial."_".$tbl." ";
$query .= " WHERE from_unixtime(".$signdate.", '%Y%m%d') >= '".$sdate."' ";
$query .= " AND from_unixtime(".$signdate.", '%Y%m%d') <= '".$edate."' ";
$query .= $qry_where;
$query .= "	group by addr ";

$result=mysql_query($query,$dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
$i= 1;
while ($array = mysql_fetch_array($result)) {

		$addr	= $array[addr];
		$yy = substr($mdate,0,4);
		$mm = substr($mdate,4,2);
		$dd = substr($mdate,6,2);

		$cnt	= $array[cnt];
		if($total_count>0) $width_len = (intval($cnt) / $total_count) * 100;
		else $width_len = 0;

		$width_len_p = Intval($width_len) * 2;
		$width_len_per = round($width_len,2);
		$tmp_count =  number_format($cnt);

		$width_len_t = $width_len_t + $width_len;


?>
	          <tr>
                <td><a href="javascript:go_ipdetail('<?=$addr?>')"><?=$addr?></a></td>
                <td>
				<div class="progress progress-xs progress-striped active">
				  <div class="progress-bar progress-bar-success" style="width: <?=$width_len_p?>%"></div>
				</div>
				</td>
				<td><span class="badge bg-green"><?=$width_len_per?>%</span></td>
                <td><?=$tmp_count?></td>
              </tr>
<?
	$i++;
}
$total_count =  number_format($total_count);
?>

              <tr>
                <td>합 계</td>
                <td colspan="2">
				<div class="progress progress-xs progress-striped active">
				  <div class="progress-bar progress-bar-success" style="width: <?=$width_len_t?>%"></div>
				</div>

				</td>
                <td><?=$total_count?></td>
              </tr>
            </table>
