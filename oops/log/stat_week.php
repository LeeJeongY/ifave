		<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolorlight="#999999" bordercolordark="#FFFFFF" bgcolor="#FFFFFF">
		  <tr align="center" class="tblheader"> 
			<td width="100" height="30">날 짜</td>
			<td height="30"><?=$curr_year?>년 <?=$curr_month?>월 주간별</td>			
			<td width="120">건수</td>
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
if($tbl == "referer" || $tbl == "referer_wedding" || $tbl == "referer_hall" || $tbl == "referer_landing" || $tbl == "referer_mobile" || $tbl == "referer_m" || $tbl == "referer_spa") {
	$query .= " WHERE from_unixtime(".$signdate.", '%Y%m%d') >= '".$sdate."' AND from_unixtime(".$signdate.", '%Y%m%d') <= '".$edate."'  ";
} else {
	$query .= " WHERE replace(left(".$signdate.", 10) >= '".$sdate."' AND replace(left(".$signdate.", 10) <= '".$edate."'  ";
}

$query .= $qry_where;
$result = mysql_query($query,$dbconn) or die (mysql_error());
$row = mysql_fetch_row($result);
$total_count = $row[0];

if($tbl == "referer" || $tbl == "referer_wedding" || $tbl == "referer_hall" || $tbl == "referer_landing" || $tbl == "referer_mobile" || $tbl == "referer_m" || $tbl == "referer_spa") {
	$query = "SELECT distinct from_unixtime(".$signdate.", '%w') as mweek, count(".$signdate.") as cnt FROM ".$initial."_".$tbl." ";
	$query .= " WHERE from_unixtime(".$signdate.", '%Y%m%d') >= '".$sdate."' ";
	$query .= " AND from_unixtime(".$signdate.", '%Y%m%d') <= '".$edate."' ";
} else {
	$query = "SELECT distinct from_unixtime(".$signdate.", '%w') as mweek, count(".$signdate.") as cnt FROM ".$initial."_".$tbl." ";
	$query .= " WHERE replace(left(".$signdate.", 10) >= '".$sdate."' ";
	$query .= " AND replace(left(".$signdate.", 10) <= '".$edate."' ";
}
$query .= $qry_where;
$query .= "	group by mweek ";

$result=mysql_query($query,$dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
$i= 1;
while ($array = mysql_fetch_array($result)) {		

		$mweek	= $array[mweek];
		$cnt	= $array[cnt];
		if($total_count>0) $width_len = (intval($cnt) / $total_count) * 100;
		else $width_len = 0;

		$width_len_p = Intval($width_len) * 2;
		$width_len_per = round($width_len,2);
		$tmp_count =  number_format($cnt);

		$width_len_t = $width_len_t + $width_len;

		if($mweek==0) $title="일요일";
		else if($mweek==1) $title="월요일";
		else if($mweek==2) $title="화요일";
		else if($mweek==3) $title="수요일";
		else if($mweek==4) $title="목요일";
		else if($mweek==5) $title="금요일";
		else if($mweek==6) $title="토요일";

?>
	          <tr align="center" bgcolor="#FFFFFF"> 
                <td width="100" height="20" bgcolor="#FFFFFF"><?=$title?></td>
                <td align="left" height="20"><img src="../images/graph.gif" width="<?=$width_len_p?>" height="10">&nbsp;<?=$width_len_per?>%</td>
                <td width="120" height="20"><?=$tmp_count?></td>
              </tr>
<?
}
$total_count =  number_format($total_count);
?>

              <tr align="center" class="tblheader"> 
                <td width="100" height="30">합 계</td>
                <td align="left" height="30"><img src="../images/graph.gif" width="90%" height="20">&nbsp;<?=$width_len_t?>%</td>
                <td width="120" height="30">&nbsp;<?=$total_count?></td>
              </tr>
            </table>
