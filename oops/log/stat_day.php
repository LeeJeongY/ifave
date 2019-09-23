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

$query = "SELECT distinct from_unixtime(".$signdate.", '%Y%m%d') as mdate, count(".$signdate.") as cnt FROM ".$initial."_".$tbl." ";
$query .= " WHERE from_unixtime(".$signdate.", '%Y%m%d') >= '".$sdate."' ";
$query .= " AND from_unixtime(".$signdate.", '%Y%m%d') <= '".$edate."' ";
$query .= $qry_where;
$query .= "	group by mdate ";

$result=mysql_query($query,$dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
$i= 1;

$graph_day = "";
$_day_num = 0;
while ($array = mysql_fetch_array($result)) {

	$mdate	= $array[mdate];
	$yy = substr($mdate,0,4);
	$mm = substr($mdate,4,2);
	$dd = substr($mdate,6,2);

	$cnt	= $array[cnt];

	if($_day_num == 0) {
		$graph_day .= "'".$dd."일'";
		$graph_day_value .= $cnt;
	} else {
		$graph_day .= ",'".$dd."일'";
		$graph_day_value .= ",".$cnt;
	}
	$i++;
	$_day_num++;
}
$total_count =  number_format($total_count);
?>

<script type="text/javascript">
$(function () {
    $('#container_day').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: '<?=$curr_year?>년 <?=$curr_month?>월'
        },
        subtitle: {
            text: '일자별'
        },
        xAxis: {
            categories: [<?=$graph_day?>],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ' (건)',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' 건'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: '<?=$curr_year?>년 <?=$curr_month?>월 총 ',
            data: [<?=$graph_day_value?>]
        }]
    });
});
		</script>

<div id="container_day" style="min-width: 100%; max-width: 800px; height: 900px; margin: 0 auto"></div>
