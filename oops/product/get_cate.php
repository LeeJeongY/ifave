<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$_t2 = "product_cate2";
	$cate1 = $_GET['cateval'];
	$gb = $_GET['gb'];
	//$cateval_len=strlen($cateval);

	if($gb=="list") {
?>
<script language="javascript">
function go_chk() {
	var sel = document.getElementById("sel2").options[document.getElementById("sel2").selectedIndex].value;
	document.fm.s_cate2.value = sel;
}
</script>
<select name="s_cate2" id="sel2" class="select2 form-control" style="width:100px;" onchange="go_chk()">
	<option value="">- 선택 -</option>
<?
	$cate_que = "select * from ".$initial."_".$_t2." where mid is not null ";
	$cate_que .= " and bid = '".$cate1."'";
	$cate_que .= " order by mid asc";
	$cate_rst = mysql_query($cate_que, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
	while ($cate_arr = mysql_fetch_array($cate_rst)) {
		$mid		= sprintf('%02d', $cate_arr[mid]);
		$mname		= db2html($cate_arr[name]);	  //이름
		$muse_flag	= $cate_arr[use_flag];
		?>
		<option value="<?=$mid?>" <?=$mid==$cate2?"selected":""?>><?=$mname?></option>
		<?
	}
?>
</select>
<?} else {?>
<script language="javascript">
function go_chk() {
	var sel = document.getElementById("sel2").options[document.getElementById("sel2").selectedIndex].value;
	document.fm.cate2.value = sel;
}
</script>
<select name="cate2" id="sel2" class="select2 form-control boxed" onchange="go_chk()">
	<option value="">- 선택 -</option>
<?
	$cate_que = "select * from ".$initial."_".$_t2." where mid is not null ";
	$cate_que .= " and bid = '".$cate1."'";
	$cate_que .= " order by mid asc";
	$cate_rst = mysql_query($cate_que, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
	while ($cate_arr = mysql_fetch_array($cate_rst)) {
		$mid		= sprintf('%02d', $cate_arr[mid]);
		$mname		= db2html($cate_arr[name]);	  //이름
		$muse_flag	= $cate_arr[use_flag];
		?>
		<option value="<?=$mid?>" <?=$mid==$cate2?"selected":""?>><?=$mname?></option>
		<?
	}
?>
</select>
<?}?>
<?mysql_close($dbconn);?>