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
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title?><?if($site_name) {?> - <?=$site_name?><?}?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=$root_url?>/bootstrap/css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?=$root_url?>/dist/css/admin.css">
  
  <!-- jQuery 2.2.3 -->
  <script src="<?=$root_url?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?=$root_url?>/bootstrap/js/bootstrap.min.js"></script>

  <script src="<?=$root_url?>/js/common.js"></script>

</head>
<body>
<?
	//스크립트
	include "../js/goto_page.js.php";
?>

<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">	
<input type="hidden" name="_t" value="<?=$_t?>" id="_t">
<input type="hidden" name="tag" id="tag" value="">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>

  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->

      <!-- Your Page Content Here -->

		<!-- left column -->

			<!-- /.box-header -->
			<!-- form start -->
			<form role="form" method="get" name="fm" id="fm">
			<input type="hidden" name="page" value='<?=$page?>'>
			<input type="hidden" name="idx" value='<?=$idx?>'>
			<input type="hidden" name="gubun" value='<?=$gubun?>'>
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="search" value='<?=$search?>'>
			<input type="hidden" name="search_text" value='<?=$search_text?>'>
			

				<div class="form-group ">
					<span class="contents_info" id="contents_html" onClick="">
					<?if($img_file) {?>
					  <img src="<?=$foldername?><?=$img_file?>">
					<?} else {?>
					  <?=convertHashtags($contents)?>
					<?}?>
					</span>
				</div> 
			<!-- /.box-body --> 


			</form>


		<!-- /.box -->	  
  <!-- /.content-wrapper -->

</body>
</html>

<?
mysql_close($dbconn);
?>