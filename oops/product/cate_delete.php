<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	//게시판 목록보기에 필요한 각종 변수 초기값을 설정합니다.

	foreach ($_REQUEST as $key => $value) {
		// echo $key."//".$value."<br>";
		$$key = $value;
	}// end foreach

	$tbl1 = "product_cate1";
	$tbl2 = "product_cate2";
	$tbl3 = "product_cate3";


	if($gubun == "delete"){


		if($tbl == "product_cate1"){
			$delQuery = "DELETE FROM ".$initial."_".$tbl1." WHERE bid = '".$bid."' ";
			mysql_query($delQuery, $dbconn);

			$delQuery = "DELETE FROM ".$initial."_".$tbl2." WHERE bid = '".$bid."' ";
			mysql_query($delQuery, $dbconn);

			$delQuery = "DELETE FROM ".$initial."_".$tbl3." WHERE bid = '".$bid."' ";
			mysql_query($delQuery, $dbconn);
		} else if($tbl == "product_cate2"){

			$delQuery = "DELETE FROM ".$initial."_".$tbl2." WHERE mid = '".$mid."' ";
			mysql_query($delQuery, $dbconn);

			$delQuery = "DELETE FROM ".$initial."_".$tbl3." WHERE mid = '".$mid."' ";
			mysql_query($delQuery, $dbconn);
		} else if($tbl == "product_cate3"){

			$delQuery = "DELETE FROM ".$initial."_".$tbl3." WHERE mid = '".$tid."' ";
			mysql_query($delQuery, $dbconn);
		}

		$msg = "삭제";

	}// end if

?>
<form name="form" method="get" action="cate_list.php">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>
<script language="javascript">
<!--
	alert("정상적으로 <?=$msg?>되었습니다.");

	if('<?=$popup?>' == "1"){
		window.opener.document.location.href = window.opener.document.URL;
		self.close();
	}else{
		document.form.submit();
	}

//-->
</script>
<? mysql_close($dbconn); ?>
