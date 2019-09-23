<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	@set_time_limit(0);
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($tbl == "") $tbl	= "log"; 				//테이블 이름

	$signdate = "signdate";
?>
<?	include "../inc/header.php"; ?>
<script language="javascript">
function go_stat(){
	document.form.submit();
}
function go_month(sel){
	document.form.tbl.value="<?=$tbl?>";
	document.form.curr_month.value=sel;
	document.form.submit();
}

function go_daytime(sel){
	var url = "stat_dhour.php?tbl=<?=$tbl?>&field=<?=$field?>&curr_year=<?=$curr_year?>&curr_month=<?=$curr_month?>&curr_day="+sel+"&curr_cal=dhour";
	window.open(url,'_time','width=800, height=700, scroll=auto');
}

 function sel_kind2()
 {
	document.form.action="<?=$PHP_SELF?>";
 	document.form.submit();
 }
</script>

<?
$comp_num=10;
$company[0]="unknown";
$company[1]="naver";
$company[2]="daum";
$company[3]="yahoo";
$company[4]="nate";
$company[5]="empas";
$company[6]="paran";
$company[7]="korea";
$company[8]="msn";
$company[9]="google";


$company_name[0]="직접입력";
$company_name[1]="네이버";
$company_name[2]="다음";
$company_name[3]="야후";
$company_name[4]="네이트";
$company_name[5]="엠파스";
$company_name[6]="파란닷컴";
$company_name[7]="코리아닷컴";
$company_name[8]="msn";
$company_name[9]="구글";

if($curr_company!="") $qry_where = " and referer like '%$company[$curr_company]%'";

if ($curr_year=="") {
	$curr_year = date("Y");
}
if ($curr_month=="") {
	$curr_month = date("m");
}
?>

<div class="content-wrapper">
    <section class="content">
<?

	include "tabmenu_navi.php";

?>


		<form name="form" method="post" action="stat.php">
		<input type="hidden" name="menu_b" value="<?=$menu_b?>">
		<input type="hidden" name="menu_m" value="<?=$menu_m?>">
		<input type="hidden" name="menu_t" value="<?=$menu_t?>">
		<input type="hidden" name="tbl" value="<?=$tbl?>">
		<input type="hidden" name="sgbn" value="<?=$sgbn?>">
		<input type="hidden" name="cmenu" value="<?=$cmenu?>">
		<input type="hidden" name="curr_month" value="<?=$curr_month?>">
		<input type="hidden" name="inc" value="<?=$inc?>">
			검색조건
			&nbsp;&nbsp;&nbsp;
			<select name="curr_cal" class="input">
				<option value="day" <?if ($curr_cal=='day') echo("selected")?>>일자별</option>
				<option value="hour" <?if ($curr_cal=='hour') echo("selected")?>>시간별</option>
				<option value="week" <?if ($curr_cal=='week') echo("selected")?>>주간별</option>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<select name="curr_year" class="input">
				<?for($i=date("Y")+1;$i >= 2010;$i--) {?>
				<option value="<?=$i?>" <?if ($curr_year==$i) echo("selected")?>><?=$i?></option>
				<?}?>
			</select> 년

			<select name="curr_company" class="input">
				<option value="" selected>전체보기</option>
				<?
				for($j=0;$j<$comp_num;$j++)	{
					if ("$curr_company"=="$j")
						echo "<option value=\"$j\" selected>$company_name[$j]</option>
							";
					else
						echo "<option value=\"$j\">$company_name[$j]</option>
							";
				}
				?>
			</select>

			 <input type="button" name="Bsearch" value=" 검 색 " onClick="javascript:go_stat()"></a>
		</form>



      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">접속통계</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table class="table table-bordered">
                <tr>
					<th style="width: 80px">월별</th>
					<th><a href="javascript:go_month('01')">1월</a></th>
					<th><a href="javascript:go_month('02')">2월</a></th>
					<th><a href="javascript:go_month('03')">3월</a></th>
					<th><a href="javascript:go_month('04')">4월</a></th>
					<th><a href="javascript:go_month('05')">5월</a></th>
					<th><a href="javascript:go_month('06')">6월</a></th>
					<th><a href="javascript:go_month('07')">7월</a></th>
					<th><a href="javascript:go_month('08')">8월</a></th>
					<th><a href="javascript:go_month('09')">9월</a></th>
					<th><a href="javascript:go_month('10')">10월</a></th>
					<th><a href="javascript:go_month('11')">11월</a></th>
					<th><a href="javascript:go_month('12')">12월</a></th>
                </tr>

                <tr>
                  <td>총 건수<?if($curr_company != ""){?>(<?=$company_name[$curr_company]?>)<?}?></td>
<?



		$num = 0;
		for($a = 1;$a <= 12;$a++) {
			if($a < 10) $mm = "0".$a;
			else  $mm = $a;

			$mtndate = $curr_year . $mm;
			$mquery = "SELECT count(".$signdate.") as cnt FROM ".$initial."_".$tbl." ";
			$mquery .= " WHERE from_unixtime(".$signdate.", '%Y%m') = '".$mtndate."' ";
			$mresult = mysql_query($mquery,$dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
			if ($marray = mysql_fetch_array($mresult)) {
				$mcnt	= $marray[cnt];
				echo "<td>".number_format($mcnt)."</td>";


				if($num == 0) {
					$categories .= "'".$mm."'";
					$graph_value .= $mcnt;
				} else {
					$categories .= ",'".$mm."'";
					$graph_value .= ",".$mcnt;
				}


			}



			$num++;

		}
?>
 				</tr>
			</table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

	<br>

		<script type="text/javascript">
		$(function () {
			$('#container').highcharts({
				title: {
					text: 'Monthly Hit',
					x: -20 //center
				},
				subtitle: {
					text: '<?=$HTTP_HOST?>',
					x: -20
				},
				xAxis: {
					//categories: [<?=$categories?>]
					categories: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월']
				},
				yAxis: {
					title: {
						text: '건수'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					valueSuffix: '건'
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					borderWidth: 0
				},
				series: [{
					name: '<?=$curr_year?>',
					data: [<?=$graph_value?>]
				}]
			});
		});
		</script>


		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	<br>



	<?
	if($curr_cal=="hour")include "stat_hour.php";
	else if($curr_cal=="week")include "stat_week.php";
	else if($curr_cal=="dhour")include "stat_dhour.php";
	else include "stat_day.php";
	?>

        </div>
      </div>
	</section>
</div>
<?	include "../inc/footer.php"; ?>
<script src="<?=$root_url?>/js/chart/highcharts.js"></script>
<script src="<?=$root_url?>/js/chart/modules/exporting.js"></script>
<? mysql_close($dbconn); ?>
