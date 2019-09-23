<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";


	$tbl	= "site_config"; 				//테이블 이름
	$foldername = "../../$upload_dir/$tbl/";

	//==== request값 ================================

	$idx			= stripslashes($idx);
	$site_name		= html2db($site_name);
	$site_ceo		= html2db($site_ceo);
	$site_biznum	= stripslashes($site_biznum1)."-".stripslashes($site_biznum2)."-".stripslashes($site_biznum3);
	$site_tel		= stripslashes($site_tel1)."-".stripslashes($site_tel2)."-".stripslashes($site_tel3);
	$site_fax		= stripslashes($site_fax1)."-".stripslashes($site_fax2)."-".stripslashes($site_fax3);
	$addr1			= html2db($addr1);
	$addr2			= html2db($addr2);
	$addr3			= html2db($addr3);
	$admin_name		= html2db($admin_name);
	$admin_email	= stripslashes($admin_email);
	$admin_hp		= stripslashes($admin_hp1)."-".stripslashes($admin_hp2)."-".stripslashes($admin_hp3);
	$contents		= html2db($contents);

	$data_name		= $_FILES["image_logo"]["name"];
	$data_filesize	= $_FILES["image_logo"]["size"];
	$datafile		= $_FILES["image_logo"]["tmp_name"];
	if($datafile!="") {
		$logo_FullFilename = upload_file_save($data_name, $foldername,$thumb_w,$thumb_h, $datafile);
	}

	if($site_tel == "--")	$site_tel = "";
	if($site_fax == "--")	$site_fax = "";
	if($admin_hp == "--")	$admin_hp = "";
	if($zipcode == "-")		$zipcode = "";

	$site_zipcode	= $zipcode;
	$site_addr1		= $addr1;
	$site_addr2		= $addr2;
	$site_addr3		= $addr3;

	$signdate	= date("Y"."-"."m"."-"."d H:i:s");

	//신규등록인 경우 ============================
	if ($gubun == "insert") {


		$query="SELECT max(idx) as maxVal FROM ".$initial."_".$tbl."";
		$result = mysql_query($query, $dbconn);
		if($array = mysql_fetch_array($result)) {
			$max_idx = $array[maxVal];
			if($max_idx < 0) $max_idx = 1;
			else $max_idx = $max_idx + 1;
		}

		$query = "INSERT INTO ".$initial."_".$tbl." SET ";
		$query .= "	   idx                     = '".$max_idx."'";
		$query .= "  , site_name               	= '".$site_name."'";
		$query .= "  , site_tel                	= '".$site_tel."'";
		$query .= "  , site_fax                	= '".$site_fax."'";
		$query .= "  , site_zipcode            	= '".$site_zipcode."'";
		$query .= "  , site_addr1              	= '".$site_addr1."'";
		$query .= "  , site_addr2              	= '".$site_addr2."'";
		$query .= "  , site_addr3              	= '".$site_addr3."'";
		$query .= "  , site_biznum             	= '".$site_biznum."'";
		$query .= "  , site_ceo                	= '".$site_ceo."'";
		$query .= "  , html_title              	= '".$html_title."'";
		$query .= "  , html_description        	= '".$html_description."'";
		$query .= "  , html_author             	= '".$html_author."'";
		$query .= "  , naver_site_verification 	= '".$naver_site_verification."'";
		$query .= "  , google_site_verification	= '".$google_site_verification."'";
		$query .= "  , admin_title             	= '".$admin_title."'";
		$query .= "  , admin_name              	= '".$admin_name."'";
		$query .= "  , admin_email             	= '".$admin_email."'";
		$query .= "  , admin_hp                	= '".$admin_hp."'";
		$query .= "  , image_logo              	= '".$logo_FullFilename."'";
		$query .= "  , admin_home_dir          	= '".$admin_home_dir."'";
		$query .= "  , upload_home_dir         	= '".$upload_home_dir."'";
		$query .= "  , new_button_day_conf     	= '".$new_button_day_conf."'";
		$query .= "  , data_go_kr_skey         	= '".$data_go_kr_skey."'";
		$query .= "  , naver_cid               	= '".$naver_cid."'";
		$query .= "  , naver_csecret           	= '".$naver_csecret."'";
		$query .= "  , daum_api_key            	= '".$daum_api_key."'";
		$query .= "  , sns_naverblog           	= '".$sns_naverblog."'";
		$query .= "  , sns_kakaotalk           	= '".$sns_kakaotalk."'";
		$query .= "  , sns_google              	= '".$sns_google."'";
		$query .= "  , sns_facebook            	= '".$sns_facebook."'";
		$query .= "  , sns_instagram           = '".$sns_instagram."'";
		$query .= "  , sns_tweet               	= '".$sns_tweet."'";
		$query .= "  , contents                	= '".$contents."'";
		$query .= "  , regdate                 	= '".$regdate."'";
		//$query .= "  , upddate                = '".$upddate."'";
		$result=mysql_query($query, $dbconn) or die (mysql_error());

		/*
		if($datafile!="") {
			$_result_files = setDataFilesAdd($_USER_CODE,$_USER_CLASS,$_USER_ID,$max_idx,$tbl,$data_name,$datafile,$data_filesize,$typefiles,$extfiles);
		}
		*/
		$msg = "등록";
	}



	//기존데이터 수정인경우 ======================
	if ($gubun  == "update") {

		//$clientnum = $cgubun . sprintf('%06d', $idx);

		//파일삭제시
		if($img_file_chk == "Y") {
			$file_qry = " SELECT image_logo from ".$initial."_".$tbl." WHERE idx = '".$idx."'";
			$file_result = mysql_query($file_qry, $dbconn) or die(mysql_error());
			if($file_array = mysql_fetch_array($file_result)) {
				$img_file   = stripslashes($array[img_file]);

				if( $img_file != "" ){
					@unlink($foldername.$img_file);
				}
			}
			$upqry = " UPDATE ".$initial."_".$tbl." SET";
			$upqry .= " upddate			='".$signdate."'";
			if($img_file_chk == "Y")	$upqry .= ",  image_logo =''";
			$upqry .= " WHERE idx='".$idx."'";
			mysql_query($upqry, $dbconn);
		}

		$query = "update ".$initial."_".$tbl." set ";
		$query .= "    site_name               	= '".$site_name."'";
		$query .= "  , site_tel                	= '".$site_tel."'";
		$query .= "  , site_fax                	= '".$site_fax."'";
		$query .= "  , site_zipcode            	= '".$site_zipcode."'";
		$query .= "  , site_addr1              	= '".$site_addr1."'";
		$query .= "  , site_addr2              	= '".$site_addr2."'";
		$query .= "  , site_addr3              	= '".$site_addr3."'";
		$query .= "  , site_biznum             	= '".$site_biznum."'";
		$query .= "  , site_ceo                	= '".$site_ceo."'";
		$query .= "  , html_title              	= '".$html_title."'";
		$query .= "  , html_description        	= '".$html_description."'";
		$query .= "  , html_author             	= '".$html_author."'";
		$query .= "  , naver_site_verification 	= '".$naver_site_verification."'";
		$query .= "  , google_site_verification	= '".$google_site_verification."'";
		$query .= "  , admin_title             	= '".$admin_title."'";
		$query .= "  , admin_name              	= '".$admin_name."'";
		$query .= "  , admin_email             	= '".$admin_email."'";
		$query .= "  , admin_hp                	= '".$admin_hp."'";
		if($logo_FullFilename) $query .= "  , image_logo = '".$logo_FullFilename."'";
		$query .= "  , admin_home_dir          	= '".$admin_home_dir."'";
		$query .= "  , upload_home_dir         	= '".$upload_home_dir."'";
		$query .= "  , new_button_day_conf     	= '".$new_button_day_conf."'";
		$query .= "  , data_go_kr_skey         	= '".$data_go_kr_skey."'";
		$query .= "  , naver_cid               	= '".$naver_cid."'";
		$query .= "  , naver_csecret           	= '".$naver_csecret."'";
		$query .= "  , daum_api_key            	= '".$daum_api_key."'";
		$query .= "  , sns_naverblog           	= '".$sns_naverblog."'";
		$query .= "  , sns_kakaotalk           	= '".$sns_kakaotalk."'";
		$query .= "  , sns_google              	= '".$sns_google."'";
		$query .= "  , sns_facebook            	= '".$sns_facebook."'";
		$query .= "  , sns_instagram			= '".$sns_instagram."'";
		$query .= "  , sns_tweet               	= '".$sns_tweet."'";
		$query .= "  , contents                	= '".$contents."'";
		$query .= "  , upddate					= '".$upddate."'";
		$query .= " where idx = '".$idx."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$msg = "수정";
	}

	//기존데이터 삭제 ============================
	if ($gubun == "delete") {
		$query  =  "SELECT image_logo FROM ".$initial."_".$tbl." WHERE idx = '".$idx."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$array  = mysql_fetch_array($result);
		$image_logo	= stripslashes($array[image_logo]);

		########## 디렉토리에 저장된 이전 파일을 삭제한다. ##########
		if( $image_logo != "" ){
			@unlink($foldername.$image_logo);
		}
		$query 	= "delete from ".$initial."_".$tbl." where idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$msg = "삭제";
	}

	if($gubun == "remove") {
		for($i=0;$i<count($idxchk);$i++) {
			$query  =  "SELECT image_logo FROM ".$initial."_".$tbl." WHERE idx = '".$idxchk[$i]."'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			$array  = mysql_fetch_array($result);
			$image_logo	= stripslashes($array[image_logo]);

			########## 디렉토리에 저장된 이전 파일을 삭제한다. ##########
			if( $image_logo != "" ){
				@unlink($foldername.$image_logo);
			}
			######### 삭제 ##########
			$query 	= "DELETE FROM ".$initial."_".$tbl." WHERE idx = '$idxchk[$i]'";
			$result = mysql_query($query, $dbconn) or die (sqlsrv_error());
		}
		$msg = "삭제";
	}

	mysql_close($dbconn);
?>
<form name="form" method="get" action="setting.php">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="tbl" value="<?=$tbl?>">
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("성공적으로 <?=$msg?>되었습니다.");
	document.form.submit();
//-->
</SCRIPT>
