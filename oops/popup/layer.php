<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "popup"; 				//테이블 이름
	$foldername  = "../../$upload_dir/$_t/";
	$download_foldername  = "../$upload_dir/$_t/";

	$regdate	= date("Y"."-"."m"."-"."d H:i:s");

	if ($gubun == "") {
		$gubun = "view";
	}

	if ($idx) {
		//조회수 증가
		if ($_USER_CLASS <= 10) {

			$query = "UPDATE ".$initial."_bbs_".$_t." SET counts=counts+1 WHERE idx = '$idx'";
			mysql_query($query, $dbconn);
		}

		//테이블에서 글을 가져옵니다.
		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx      	= stripslashes($array[idx]);
			$title    	= db2html($array[title]);
			$body     	= stripslashes($array[body]);
			$contents	= db2html($body);
			$category 	= stripslashes($array[category]);
			$popup_flag	= stripslashes($array[popup_flag]);
			$counts   	= stripslashes($array[counts]);
			$user_file	= stripslashes($array[user_file]);
			$img_file 	= stripslashes($array[img_file]);
			$nflag    	= stripslashes($array[nflag]);
			$list_add 	= stripslashes($array[list_add]);
			$scrollbar	= stripslashes($array[scrollbar]);
			$ptop     	= stripslashes($array[ptop]);
			$pleft    	= stripslashes($array[pleft]);
			$width    	= stripslashes($array[width]);
			$height   	= stripslashes($array[height]);
			$winopen  	= stripslashes($array[winopen]);
			$startdate	= stripslashes($array[startdate]);
			$enddate  	= stripslashes($array[enddate]);
			$pageurl  	= stripslashes($array[pageurl]);
			$mapflag  	= stripslashes($array[mapflag]);
			$image_map	= stripslashes($array[image_map]);
			$tag		= stripslashes($array[tag]);
			$view_flag	= stripslashes($array[view_flag]);
			$userid   	= stripslashes($array[userid]);
			$username 	= db2html($array[username]);
			$regdate  	= stripslashes($array[regdate]);
			$upddate  	= stripslashes($array[upddate]);
			$vodpath  	= stripslashes($array[vodpath]);
			$vodfile1 	= stripslashes($array[vodfile1]);
			$vodfile2 	= stripslashes($array[vodfile2]);
			$vodfile3 	= stripslashes($array[vodfile3]);
			$bfilepath	= stripslashes($array[bfilepath]);
			$bfile1   	= stripslashes($array[bfile1]);
			$bfile2   	= stripslashes($array[bfile2]);
			$bfile3   	= stripslashes($array[bfile3]);

			if($pageurl=="") $pageurl = "../popup/view.php?idx=$idx";
		}
	}
?>
<!-- header -->
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">×</button>
  <h4 class="modal-title"><?=$title?></h4>
</div>
<!-- body -->
<div class="modal-body" onClick="location.href='<?=$pageurl?>'">
	<?if($img_file) {?>
	  <img src="<?=$foldername?><?=$img_file?>">
	<?} else {?>
	  <?=convertHashtags($contents)?>
	<?}?> 
</div>
<!-- Footer -->
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
</div>

<?
mysql_close($dbconn);
?>