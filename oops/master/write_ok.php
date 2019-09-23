<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl		= "staff"; 				//테이블 이름
	$foldername	= "../../$upload_dir/$tbl/";

	if($gubun=="") $gubun = "insert";

	//==== request값 ================================

	$idx     = stripslashes($idx);
	$sgubun  = stripslashes($sgubun);
	$userid  = stripslashes($userid);
	$username= html2db($username);
	$nickname= html2db($nickname);
	//$tel     = stripslashes($tel1)."-".stripslashes($tel2)."-".stripslashes($tel3);
	//$hp      = stripslashes($hp1)."-".stripslashes($hp2)."-".stripslashes($hp3);
	$email   = stripslashes($email);
	$zipcode = stripslashes($zip1)."-".stripslashes($zip2);
	$addr1   = html2db($addr1);
	$addr2   = html2db($addr2);
	$addr3   = html2db($addr3);
	$duty    = stripslashes($duty);
	$remark  = html2db($remark);

	if($tel == "--") $tel = "";
	if($hp == "--") $hp = "";
	if($zipcode == "-") $zipcode = "";


	$regdate   = date("Y"."-"."m"."-"."d H:i:s");

	if($gubun == "update" || $gubun == "insert") {

		$img_name1		= $_FILES["user_file"]["name"];			// 파일명
		$img_filesize1	= $_FILES["user_file"]["size"];			// 파일 사이즈
		$img1			= $_FILES["user_file"]["tmp_name"];		// 임시파일저장

		$img_FullFilename1 = upload_file_save($img_name1, $foldername,$thumb_w,$thumb_h, $img1);
	}


	//신규등록인 경우 ============================
	if ($gubun == "insert") {

		//아이디 중복체크
		if($userid!="") {
			$query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
			$query .= " WHERE userid='$userid'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			if($array = mysql_fetch_array($result)) {
				$count_chk = $array[cnt];
			}
			if($count_chk > 0) {
				popup_msg("동일한 아이디가 존재합니다.");
			}
		}

		// max 구하기
		$query = "SELECT max(idx) as maxVal FROM ".$initial."_".$tbl."";
		$result = mysql_query($query, $dbconn);
		if($array = mysql_fetch_array($result)) {
			$max_idx		= $array[maxVal];
			if($max_idx < 0) $max_idx = 1;
			else $max_idx = $max_idx+1;
		}

		$query = "INSERT INTO ".$initial."_".$tbl." SET ";
		$query .= " idx				= '".$max_idx."'";
		$query .= " , sgubun		= '".$sgubun."'";
		$query .= " , userid		= '".$userid."'";
		$query .= " , userpwd		= '".$userpwd."'";
		$query .= " , username		= '".$username."'";
		$query .= " , nickname		= '".$nickname."'";
		$query .= " , tel			= '".$tel."'";
		$query .= " , hp			= '".$hp."'";
		$query .= " , email			= '".$email."'";
		$query .= " , user_file		= '".$img_FullFilename1."'";
		$query .= " , grade			= '".$grade."'";
		$query .= " , menunum		= '".$menunum."'";
		$query .= " , active		= '".$active."'";
		$query .= " , remoteip		= '".$remoteip."'";
		//$query .= " , lastlogin	 ., '".$lastlogin."'";
		//$query .= " , lastlogout	 ., '".$lastlogout."'";
		$query .= " , zipcode		= '".$zipcode."'";
		$query .= " , addr1			= '".$addr1."'";
		$query .= " , addr2			= '".$addr2."'";
		$query .= " , birthdate		= '".$birthdate."'";
		$query .= " , calkind		= '".$calkind."'";
		$query .= " , duty			= '".$duty."'";
		$query .= " , charge		= '".$charge_data."'";
		$query .= " , sfoption		= '".$sfoption."'";
		$query .= " , remark		= '".$remark."'";
		$query .= " , regdate		= '".$regdate."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());



		/******************************************/
		// 메뉴 권한 설정
		/******************************************/
		//체크 갯수
		$chk_bmenu = count($bmenu);

		$num = 0;
		for($i = 0; $i < $chk_bmenu;$i++) {				//대분류 데이터

			//echo "$i = " . $bmenu[$i]."<br>";

			$maxnum_sql = "SELECT max(idx) as maxVal FROM ".$initial."_menu_grade";
			$maxnum_rs = mysql_query($maxnum_sql, $dbconn) or die(mysql_error());
			if($maxnum_array = mysql_fetch_array($maxnum_rs)) {
				$maxnum		= $maxnum_array[maxVal];
				if ($maxnum == "" or $maxnum == NULL) $max_idx = 1;
				else $max_idx = $maxnum + 1;
			}

			$sql = "INSERT INTO ".$initial."_menu_grade SET ";
			$sql .= " idx			= '".$max_idx."'";
			$sql .= ", userid		= '".$userid."'";
			$sql .= ", bid			= '".$bmenu[$i]."'";
			$sql .= ", sitegubun	= '1'";
			$rs = mysql_query($sql, $dbconn);

			/******************************************/
			// 중분류 데이터 변수 설정 및 값 정보 설정
			/******************************************/
			$mmenu_value = "mmenu_".$bmenu[$i];
			$mmenu = $$mmenu_value;

			$chk_mmenu = count($mmenu);
			//echo "<b>chk_mmenu</b> = " . $chk_mmenu ."<br>";
			for($j = 0;$j < $chk_mmenu;$j++) {			//중분류 데이터

				//echo "$j = " . $mmenu[$j] . "<br>";
				$maxnum_sql = "SELECT max(idx) as maxVal FROM ".$initial."_menu_grade";
				$maxnum_rs = mysql_query($maxnum_sql, $dbconn) or die(mysql_error());
				if($maxnum_array = mysql_fetch_array($maxnum_rs)) {
					$maxnum		= $maxnum_array[maxVal];
					if ($maxnum == "" or $maxnum == NULL) $max_idx = 1;
					else $max_idx = $maxnum + 1;
				}

				$sql = "INSERT INTO ".$initial."_menu_grade SET ";
				$sql .= " idx			= '".$max_idx."'";
				$sql .= ", userid		= '".$userid."'";
				$sql .= ", bid			= '".$bmenu[$i]."'";
				$sql .= ", mid			= '".$mmenu[$j]."'";
				$sql .= ", sitegubun	= '1'";
				$rs = mysql_query($sql, $dbconn);

			}
			$num++;

		}



		$msg = "등록";
	}



	//기존데이터 수정인경우 ======================
	if ($gubun  == "update") {


		if($user_file_chk == "Y") {

			$file_qry = " SELECT user_file FROM ".$initial."_".$tbl." WHERE idx = '$idx' ";
			$file_result = mysql_query($file_qry, $dbconn) or die(mysql_error());
			if($file_array = mysql_fetch_array($file_result)) {
				$user_file   = stripslashes($array[user_file]);

				if( $user_file != "" ){
					@unlink($foldername.$user_file);
				}
			}


			$query = " UPDATE ".$initial."_".$tbl." SET";
			$query .= "  user_file	  =''";
			$query .= " WHERE idx='$idx'";
			mysql_query($query, $dbconn);
		}


		$query = "UPDATE ".$initial."_".$tbl." SET ";
		$query .= "  nickname	='$nickname'";
		if($userpwd!="") $query .= " , userpwd=password('$userpwd')";
		$query .= " , tel		='$tel'";
		$query .= " , hp		='$hp'";
		$query .= " , email		='$email'";
		$query .= " , zipcode	='$zipcode'";
		$query .= " , addr1		='$addr1'";
		$query .= " , addr2		='$addr2'";
		$query .= " , birthdate	='$birthdate'";
		$query .= " , calkind	='$calkind'";
		$query .= " , editdate	='$regdate'";
		if ($img_FullFilename1 != "") {
			$query .= ", user_file ='$img_FullFilename1'";
		}
		//chk_level_num 정의는 register_globals.php
		if($SUPER_ULEVEL < $chk_level_num) {
			$query .= " , sgubun	='$sgubun'";
			//$query .= " , userid	='$userid'";
			$query .= " , username	='$username'";
			$query .= " , grade		='$grade'";
			$query .= " , menunum	='$menunum'";
			$query .= " , active	='$active'";
			//$query .= " , remoteip	='$remoteip'";
			//$query .= " , lastlogin	='$lastlogin'";
			//$query .= " , lastlogout='$lastlogout'";
			$query .= " , duty		='$duty'";
			$query .= " , charge	='$charge_data'";
			$query .= " , sfoption	='$sfoption'";
			$query .= " , remark	='$remark'";
		}
		$query .= " where idx = '$idx'";

		$result = mysql_query($query, $dbconn) or die (mysql_error());


		/******************************************/
		// 메뉴 권한 설정
		/******************************************/
		if($SUPER_ULEVEL < $chk_level_num) {
			$del_sql = "DELETE from ".$initial."_menu_grade WHERE userid='".$userid."'";
			mysql_query($del_sql, $dbconn) or die (mysql_error());

			//체크 갯수
			$chk_bmenu = count($bmenu);

			$num = 0;
			for($i = 0; $i < $chk_bmenu;$i++) {				//대분류 데이터

				//echo "$i = " . $bmenu[$i]."<br>";


				$maxnum_sql = "SELECT max(idx) as maxVal FROM ".$initial."_menu_grade";
				$maxnum_rs = mysql_query($maxnum_sql, $dbconn) or die(mysql_error());
				if($maxnum_array = mysql_fetch_array($maxnum_rs)) {
					$maxnum		= $maxnum_array[maxVal];
					if ($maxnum == "" or $maxnum == NULL) $max_idx = 1;
					else $max_idx = $maxnum + 1;
				}


				$sql = "INSERT INTO ".$initial."_menu_grade SET ";
				$sql .= " idx			= '".$max_idx."'";
				$sql .= ", userid		= '".$userid."'";
				$sql .= ", bid			= '".$bmenu[$i]."'";
				$sql .= ", sitegubun	= '1'";
				$rs = mysql_query($sql, $dbconn);


				/******************************************/
				// 중분류 데이터 변수 설정 및 값 정보 설정
				/******************************************/
				$mmenu_value = "mmenu_".$bmenu[$i];
				$mmenu = $$mmenu_value;

				$chk_mmenu = count($mmenu);
				//echo "<b>chk_mmenu</b> = " . $chk_mmenu ."<br>";

				for($j = 0;$j < $chk_mmenu;$j++) {			//중분류 데이터

					//echo "$j = " . $mmenu[$j] . "<br>";
					$maxnum_sql = "SELECT max(idx) as maxVal FROM ".$initial."_menu_grade";
					$maxnum_rs = mysql_query($maxnum_sql, $dbconn) or die(mysql_error());
					if($maxnum_array = mysql_fetch_array($maxnum_rs)) {
						$maxnum		= $maxnum_array[maxVal];
						if ($maxnum == "" or $maxnum == NULL) $max_idx = 1;
						else $max_idx = $maxnum + 1;
					}

					$sql = "INSERT INTO ".$initial."_menu_grade SET ";
					$sql .= " idx			= '".$max_idx."'";
					$sql .= ", userid		= '".$userid."'";
					$sql .= ", bid			= '".$bmenu[$i]."'";
					$sql .= ", mid			= '".$mmenu[$j]."'";
					$sql .= ", sitegubun	= '1'";
					$rs = mysql_query($sql, $dbconn);

				}
				$num++;

			}
		}	//총관리자이상만 메뉴권한 설정 가능

		$msg = "수정";
	}

	//기존데이터 삭제 ============================
	if ($gubun == "delete") {

		$query = "DELETE FROM ".$initial."_".$tbl." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$msg = "삭제";
	}

	if($gubun == "remove") {

		for($i=0;$i<count($idxchk);$i++) {
			$query  =  "SELECT user_file FROM ".$initial."_".$tbl." WHERE idx = '$idxchk[$i]'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			$array  = mysql_fetch_array($result);
			$user_file	= stripslashes($array[user_file]);

			########## 디렉토리에 저장된 이전 파일을 삭제한다. ##########
			if( $user_file != "" ){
				@unlink($foldername.$user_file);
			}
			######### 삭제 ##########
			$query 	= "DELETE FROM ".$initial."_".$tbl." WHERE idx = '$idxchk[$i]'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			$msg = "삭제";
		}

	}

	if($gubun == "idcheck") {
		//중복 검색
		$query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
		$query .= " WHERE userid='$userid'";
		if($idx!="") $query .= " AND idx!='$idx'";
		$result=mysql_query($query, $dbconn) or die (mysql_error());
		if($array=mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}

		if($count_chk > 0) {
			echo "no";
		} else {
			echo "ok";
		}
		mysql_close($dbconn);
		exit;
	}


	if($gubun == "nickcheck") {
		//중복 검색
		$query = "SELECT count(idx) as cnt FROM ".$initial."_".$tbl."";
		$query .= " WHERE nickname='$nickname'";
		if($idx!="") $query .= " AND idx!='$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array=mysql_fetch_array($result)) {
			$count_chk = $array[cnt];
		}
		if($idx!="") $gubun = "update";
		else $gubun = "insert";

		if($count_chk > 0) {
			echo "no";
		} else {
			echo "ok";
		}
		mysql_close($dbconn);
		exit;
	}
	mysql_close($dbconn);

	$goto_page = "list.php";
?>
<form name="form" method="get" action="<?=$goto_page?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("정상적으로 <?=$msg?>되었습니다.");
	<?//if($gubun=="delete" || $gubun=="remove") {?>
	document.form.submit();
	<?//} else {?>
	//window.opener.document.location.href = window.opener.document.URL;
	//self.close();
	<?//}?>
//-->
</SCRIPT>
