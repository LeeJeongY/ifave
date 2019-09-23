<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	@set_time_limit(0);
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($tbl == "") $tbl	= "referer"; 				//테이블 이름

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

function go_ipdetail(ipaddr){
	var url = "connect.php?tbl=<?=$tbl?>&field=<?=$field?>&curr_year=<?=$curr_year?>&curr_month=<?=$curr_month?>&ipaddr="+ipaddr+"&curr_cal=dhour";
	location.href=url;
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

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">IP 접속통계</h3>
            </div>
            <!-- /.box-header -->

			<div class="box-body">

			<?
			include "ip_day.php";
			?>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
	</section>
</div>

<?	include "../inc/footer.php"; ?>
<? mysql_close($dbconn); ?>
