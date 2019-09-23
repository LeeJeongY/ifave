<?
	//============================================================================
	//내  용 : 공지사항 레이어 띄우기
	//파  일 : popup_view.asp
	//작성자 : 박홍근
	//작성일 : 2008.04.02
	//수정일 :
	//비  고 :
	//============================================================================

?>
<script language="JavaScript1.2">
<!--
var x =0
var y=0
drag = 0
move = 0
window.document.onmouseup = mouseUp
window.document.ondragstart = mouseStop
window.document.onmousemove = mouseMove
window.document.onmousedown = mouseDown

function mouseMove() {
if (move) {
dragObj.style.left = window.event.x - clickleft
dragObj.style.top = window.event.y - clicktop
}
}
function mouseUp() {
move = 0
}
function mouseDown() {
if (drag) {
clickleft = window.event.x - parseInt(dragObj.style.left)
clicktop = window.event.y - parseInt(dragObj.style.top)
dragObj.style.zIndex += 1
move = 1
}
}

function mouseStop() {
window.event.returnValue = false
}
function View(ID) {
ID.filters.blendTrans.apply();
ID.style.display='';
//ID.style.visibility = "visible";
ID.filters.blendTrans.play();
}
function Close(ID) {
ID.filters.blendTrans.apply();
ID.style.display='none';
//ID.style.visibility = "hidden";
ID.filters.blendTrans.play();
}
//-->
</script>
<?
	//============================================================================
	//팝업 리스트 가저오기
	//============================================================================
?>
<script language="JavaScript">
<!--
function setCookie( name, value, expiredays ) {
    var todayDate = new Date();
        todayDate.setDate( todayDate.getDate() + expiredays );
        document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
    }

function popup_page(url) {
	window.open(url, '_popup', 'width=800, height=600, menubar=0, scrollbars=1, resizable=auto')
}
//-->
</script>


<?
	$nowdate = date("Ymd");

	//bbs테이블에서 목록을 가져옵니다. (위의 쿼리문 사용예와 비슷합니다.)
	$query  = "select * ";
	$query .= " from ".$initial."_bbs_popup where idx is not null "; 				// SQL 쿼리문
	$query .= " and winopen='Y' and replace(startdate,'/','') <= '$nowdate' and replace(enddate,'/','') >= '$nowdate' ";
	$query .= " and view_flag='1'";
	$query .= " order by regdate desc";

	$result = mysql_query($query, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
	//쿼리 결과를 하나씩 불러와 실제 HTML에 나타내는 것은 HTML 문 중간에 삽입합니다.

	while ($array = mysql_fetch_array($result)) {
		$rot_num += 1;

		$idx			= stripslashes($array[idx]);
		$userid			= stripslashes($array[userid]);
		$username		= stripslashes($array[username]);
		$title			= db2html($array[title]);
		$body			= db2html(stripslashes($array[body]));
		$img_file		= stripslashes($array[img_file]);
		$list_add		= stripslashes($array[list_add]);
		$scrollbar		= stripslashes($array[scrollbar]);
		$ptop			= stripslashes($array[ptop]);
		$pleft			= stripslashes($array[pleft]);
		$width			= stripslashes($array[width]);
		$height			= stripslashes($array[height]);
		$winopen		= stripslashes($array[winopen]);
		$startdate		= stripslashes($array[startdate]);
		$enddate		= stripslashes($array[enddate]);
		$counts			= stripslashes($array[counts]);
		$reg_date		= stripslashes($array[regdate]);
		$category		= $array[category];
		$pageurl		= $array[pageurl];

?>

<div id="divpop<?=$id?>" style="position:absolute;left:<?=$pleft?>px;top:<?=$ptop?>px;z-index:10000;visibility:hidden; filter:revealTrans(transition=23,duration=0.5) blendTrans(duration=0.5);background-color:#FFFFFF;"  onmouseover="dragObj=divpop<?=$id?>; drag=1;move=0" onmouseout="drag=0">
<table width="<?=$width?>" height="<?=$height?>" border="0" cellpadding="0" cellspacing="0">
<form name="notice_form<?=$id?>">
	<tr>
		<td align="center" valign="top" style="border:1px #666666 solid">
			<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
				<!-- <tr>
					<td bgcolor="#cdcdcd" style="padding:5px;font-size:14px;" align="center"><b><font color="#000"><?=$title?></font></b></td>
				</tr> -->
				<tr>
					<td valign="top" bgcolor="#FFFFFF" style="padding:0px;text-align:left;">
					<?if($img_file != "") {?>

						<?if($pageurl != "") {?>
							<a href="<?=$pageurl?>">
						<?} else {?>
							<a href="javascript:popup_page('/common/popup.php?action=view&idx=<?=$idx?>&v=&_cate=&_t=popup&search=&search_text=&opt=&page=1');">
							<!-- <a href="javascript:closeWin<?=$id?>();"> -->
						<?}?>

						<img src="/<?=$upload_dir?>/popup/<?=$img_file?>" usemap="#pop_img" border="0"></a><br>
					<?} else {?>
					<?=$body?>
					<?}?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="right" bgcolor="#cdcdcd">
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="left" style="padding-left:5px;font-size:14px;"><input type="checkbox" name="chkbox" value="checkbox" style="border:0;"><font color="#000"> 오늘 하루 이 창을 열지 않음</font></td>
				<td align="right" style="padding-right:10px;font-size:14px;"><a href="javascript:closeWin<?=$id?>();"><font color="#000"><b>닫기</b></font></a></td>
			</tr>
		</table>
		</td>
	</tr>
</form>
</table>


<?if($mapflag == "Y") {?>
<map name="pop_img<?=$idx?>">
<?=$image_map?>
</map>
<?}?>

</div>

<script language="javascript">
	function closeWin<?=$id?>() {
		if ( document.notice_form<?=$id?>.chkbox.checked ){
			setCookie( "maindiv<?=$id?>", "done" , 1 );
		}
		document.all['divpop<?=$id?>'].style.visibility = "hidden";
	}
//-->
</script>

<script language="Javascript">
	cookiedata = document.cookie;
	if ( cookiedata.indexOf("maindiv<?=$id?>=done") < 0 ){
		document.all['divpop<?=$id?>'].style.visibility = "visible";
	}
	else {
		document.all['divpop<?=$id?>'].style.visibility = "hidden";
	}
</script>
<?
	}
?>
<?//=$img_file?>