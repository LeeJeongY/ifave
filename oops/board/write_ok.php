<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/func_sms.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "qna"; 				//테이블 이름
	//게시판 정보
	include "../../modules/boardinfo.php";
	//파일경로
	$foldername  = "../../$upload_dir/$cfg_bbs_kind/$_t/";

	//hidden에 있던 값 전송
	$gubun   = addslashes($gubun);
	$page   = addslashes($page);

	if ($page == "") { $page = 1; }

	//수정, 답변에 사용될 히든값
	$idx		= addslashes($idx);
	$username	= addslashes($username);
	$passwd		= addslashes($passwd);
	$tel = $tel1."-".$tel2."-".$tel3;
	if($tel=="--") $tel = "";
	$hp = $hp1."-".$hp2."-".$hp3;
	if($hp=="--") $hp = "";
	$email		= addslashes($email);
	$title		= html2db($title);
	if($_POST["ir1"]!="") $body	= $_POST["ir1"];
	$body		= html2db($body);
	$regdate	= date("Y"."-"."m"."-"."d H:i:s");

	//해쉬태그 추출
	preg_match_all("/\\#([0-9a-zA-Z가-힣]*)/", $body, $hashtags);
	//print_r( $hashtags );

	if ($gubun == "update") {  # 수정일때
		$upqry = " UPDATE ".$initial."_bbs_".$_t." SET";
		$upqry .= " title			='$title'";
		$upqry .= ", body			='$body'";
		$upqry .= ", tag			='$tag'";
		$upqry .= ", view_flag		='$view_flag'";
		if($username) $upqry .= ", username		='$username'";

		if($cfg_bbs_type!="sns") {
			$upqry .= ", thread			='$thread'";
			$upqry .= ", depth			='$depth'";
			$upqry .= ", pos			='$pos'";
			$upqry .= ", is_secret		='$is_secret'";
			$upqry .= ", notice_yn		='$notice_yn'";
			$upqry .= ", email			='$email'";
			$upqry .= ", homep			='$homep'";
			$upqry .= ", tel			='$tel'";
			$upqry .= ", hp				='$hp'";
			$upqry .= ", murl			='$murl'";
			$upqry .= ", site			='$site'";
		}


		$upqry .= ", user_ip		='$remoteip'";
		$upqry .= ", upddate		='$regdate'";
		if($cfg_cate_flag == "1") $upqry .= ", category='$category'";
		if ($data_FullFilename != "") {
			$upqry .= ", user_file	='$data_FullFilename'";
		}
		if ($img_FullFilename != "") {
			$upqry .= ", img_file	='$img_FullFilename'";
		}
		$upqry .= " WHERE idx='$idx'";


		$result = mysql_query($upqry, $dbconn);
		if(!$result) {
			$error_msg = mysql_error();
		} else {
			$msg = "수정";
		}   # end of if(!$result) { ...
		// 수정 완료
	} # end of if ($gubun == "update") { ...

	if ($gubun == "insert" or $gubun == "reply") {   # 새로 등록이거나 답변일경우

		# max 값 구하기
		$maxnum_qry = "SELECT max(idx) as maxVal FROM ".$initial."_bbs_".$_t."";
		$maxnum_result = mysql_query($maxnum_qry, $dbconn) or die(mysql_error());
		if($maxnum_array = mysql_fetch_array($maxnum_result)) {
			$maxnum = $maxnum_array[maxVal];
			if ($maxnum == "" or $maxnum == NULL) {
				$idx   = 1;
			} else {
				$idx   = $maxnum + 1;
			}
		}

		if($gubun == "insert") {

			if($cfg_bbs_type!="sns") {
				// ------------  쓰레드 찾기 ---------
				$query = "SELECT max(thread) as maxVal FROM ".$initial."_bbs_".$_t."";
				$result = mysql_query($query, $dbconn);
				if($array = mysql_fetch_array($result)) {
					$thread = $array[maxVal];
					$thread = $thread+1;
				}

				// ------------  포지션 찾기 ---------
				$query = "SELECT min(pos) as minVal FROM ".$initial."_bbs_".$_t."";
				$result = mysql_query($query, $dbconn);
				if($array = mysql_fetch_array($result)) {
					$pos = $array[minVal];
					$pos = $pos+1;
				}

				$query = "UPDATE ".$initial."_bbs_".$_t." SET pos=pos+1 WHERE pos>0";
				mysql_query($query, $dbconn);
			}
			//$depth = 1;
			//$pos = 1;
		} else {
			if($cfg_bbs_type!="sns") {
				$query = "UPDATE ".$initial."_bbs_".$_t." SET pos=pos+1 WHERE pos>=$pos";
				mysql_query($query, $dbconn);
			}
		}

		if($gubun=="reply" && $_t == "qna") {
			if($sms_flag=="Y" && $sms_hp!="") {

				/*
				* sms log 등록
				*/
				$SMS_TITLE	= "1:1문의 답변문자";
				$SMS_MSG	= "(국제원격평생교육원)1:1문의하신 글에 답글이 게시되었습니다. 확인바랍니다.";
				$RECV_UHP	= $sms_hp;
				$RECV_UID	= $recvid;
				$RECV_UNAME	= $recvname;
				$send_id	= $adminid;

				$autoname		= "";					//이름포함해서 보낼 경우 Y
				//$stran_kind	= "reserve";			//예약시
				if($stran_kind=="reserve") {
					$reservedate	= $reserve_date." ".$reserve_minuts.":".$reserve_minuts.":"."00";
				}
				$F_TBL	= $_t;
				$F_ID	= $max_idx;


				//문자 전송
				$r = CallSmsSend("qna", $RECV_UHP, $RECV_UID, $RECV_UNAME, $company_tel, $send_id, $company_name, $autoname, $stran_kind, $reservedate, $SMS_TITLE, $SMS_MSG, $F_TBL, $F_ID);


			}
		}
		$ins_qry = "INSERT INTO ".$initial."_bbs_".$_t." (";
		$ins_qry .= "idx";
		if($cfg_cate_flag == "1") $ins_qry .= ",category";
		$ins_qry .= ", title";
		$ins_qry .= ", body";
		$ins_qry .= ", userid";
		$ins_qry .= ", username";
		$ins_qry .= ", tag";
		$ins_qry .= ", view_flag";

		if($cfg_bbs_type!="sns") {
			//$ins_qry .= ", user_file";
			//$ins_qry .= ", img_file";
			$ins_qry .= ", passwd";
			$ins_qry .= ", counts";
			$ins_qry .= ", org_idx";
			$ins_qry .= ", thread";
			$ins_qry .= ", depth";
			$ins_qry .= ", pos";
			$ins_qry .= ", email";
			$ins_qry .= ", homep";
			$ins_qry .= ", tel";
			$ins_qry .= ", hp";
			$ins_qry .= ", murl";
			$ins_qry .= ", is_secret";
			$ins_qry .= ", notice_yn";
			$ins_qry .= ", site";
		}
		$ins_qry .= ", user_ip";
		$ins_qry .= ", regdate";
		$ins_qry .= ", adminid";
		$ins_qry .= ") VALUES (";
		$ins_qry .= " $idx";
		if($cfg_cate_flag == "1") $ins_qry .= ", '$category'";
		$ins_qry .= ", '$title'";
		$ins_qry .= ", '$body'";
		$ins_qry .= ", '$userid'";
		$ins_qry .= ", '$username'";
		$ins_qry .= ", '$tag'";
		$ins_qry .= ", '$view_flag'";
		if($cfg_bbs_type!="sns") {
			//$ins_qry .= ", '$data_FullFilename'";
			//$ins_qry .= ", '$img_FullFilename'";
			$ins_qry .= ", '$passwd'";
			$ins_qry .= ", 0";
			$ins_qry .= ", '$org_idx'";
			$ins_qry .= ", '$thread'";
			$ins_qry .= ", '$depth'";
			$ins_qry .= ", '$pos'";
			$ins_qry .= ", '$email'";
			$ins_qry .= ", '$homep'";
			$ins_qry .= ", '$tel'";
			$ins_qry .= ", '$hp'";
			$ins_qry .= ", '$murl'";
			$ins_qry .= ", '$is_secret'";
			$ins_qry .= ", '$notice_yn'";
			$ins_qry .= ", '$site'";
		}
		$ins_qry .= ", '$remoteip'";
		$ins_qry .= ", '$regdate'";
		$ins_qry .= ", '$adminid'";
		$ins_qry .= ") ";

		$result = mysql_query($ins_qry, $dbconn);

		if(!$result) {
			$error_msg = mysql_error();

			echo $error_msg;
			exit;


		} else {
			$msg = "등록";
		}
	}   # end of if ($gubun == "insert or reply") { ...


	if($gubun=="insert" || $gubun=="update" || $gubun=="reply") {

		//#################### 이미지 첨부
		/*
		$img_name		= $_FILES["img_file"]["name"];
		$img_filesize	= $_FILES["img_file"]["size"];
		$imgfile		= $_FILES["img_file"]["tmp_name"];
		if($imgfile!="") {
			//$img_FullFilename = upload_file_save($img_name, $foldername,$thumb_w,$thumb_h, $imgfile);
		}
		*/
		//초기화
		$img_num=1;
		for($i=0;$i<$cfg_img_flag;$i++) {

			$img_name		= $_FILES["img_file"]["name"][$i];
			$img_filesize	= $_FILES["img_file"]["size"][$i];
			$img_filetype	= $_FILES["img_file"]["type"][$i];
			$imgfile		= $_FILES["img_file"]["tmp_name"][$i];

			$img_remark	= html2db($image_remark[$i]);

			//move_uploaded_file($tmp_name, "$foldername/$img_name");
			//자체 업로드 함수 사용
			if($img_name != "") {
				$img_FullFilename =upload_file_save($img_name, $foldername,$thumb_w,$thumb_h, $imgfile);


				$full_filename = explode("\\", "$img_name");
				$pure_filename = $full_filename[sizeof($full_filename)-1];
				$pure_filename = strtolower($pure_filename);
				$full_filename = explode(".", "$pure_filename");
				$extension = $full_filename[sizeof($full_filename)-1];
				$extension = strtolower($extension);


				// max, pcode 구하기
				$query = "SELECT max(seq) FROM ".$initial."_data_files ";
				$result = mysql_query($query, $dbconn);
				$max_seq = mysql_result($result,0,0);
				if($max_seq < 0) {
					$max_seq = 1;
				} else {
					$max_seq = $max_seq+1;
				}

				$counts = 0;

				$sql = "INSERT INTO ".$initial."_data_files (";
				$sql .= " seq";
				$sql .= ", fid";
				$sql .= ", tbl";
				$sql .= ", userid";
				$sql .= ", num";
				$sql .= ", data_type";
				if($i==0) $sql .= ", data_base";
				$sql .= ", real_filename";
				$sql .= ", virtual_filename";
				$sql .= ", file_size";
				$sql .= ", file_type";
				$sql .= ", file_ext";
				$sql .= ", remark";
				$sql .= ", regdate";
				//$sql .= ", upddate";
				$sql .= ", counts";
				$sql .= ") VALUES (";
				$sql .= "$max_seq";
				$sql .= ", '$idx'";
				$sql .= ", '$_t'";
				$sql .= ", '$userid'";
				$sql .= ", '$img_num'";
				$sql .= ", 'img'";
				if($i==0) $sql .= ", '1'";
				$sql .= ", '$img_FullFilename'";
				$sql .= ", '$img_FullFilename'";
				$sql .= ", '$img_filesize'";
				$sql .= ", '$img_filetype'";
				$sql .= ", '$extension'";
				$sql .= ", '$img_remark'";
				$sql .= ", '$regdate'";
				//$sql .= ", '$upddate'";
				$sql .= ", '$counts'";

				$sql .= ")";

				mysql_query($sql, $dbconn) or die (mysql_error());


				$img_num++;

			}
		}
		//#################### 파일 첨부

		/*

		$data_name = $_FILES["user_file"]["name"];
		$data_filesize = $_FILES["user_file"]["size"];
		$datafile = $_FILES["user_file"]["tmp_name"];
		if($datafile!="") {
			//$data_FullFilename = dataload_file_save($data_name, $foldername, $datafile);
		}
		*/
		//초기화
		$data_num=1;
		for($i=0;$i<$cfg_file_flag;$i++) {

			$data_name		= $_FILES["user_file"]["name"][$i];
			$data_filesize	= $_FILES["user_file"]["size"][$i];
			$data_filetype	= $_FILES["user_file"]["type"][$i];
			$datafile		= $_FILES["user_file"]["tmp_name"][$i];

			$data_remark	= html2db($file_remark[$i]);
			//move_uploaded_file($tmp_name, "$foldername/$img_name");
			//자체 업로드 함수 사용
			if($data_name != "") {
				$data_FullFilename = dataload_file_save($data_name, $foldername, $datafile);

				$full_filename = explode("\\", "$data_name");
				$pure_filename = $full_filename[sizeof($full_filename)-1];
				$pure_filename = strtolower($pure_filename);
				$full_filename = explode(".", "$pure_filename");
				$extension = $full_filename[sizeof($full_filename)-1];
				$extension = strtolower($extension);


				// max, pcode 구하기
				$query = "SELECT max(seq) FROM ".$initial."_data_files ";
				$result = mysql_query($query, $dbconn);
				$max_seq = mysql_result($result,0,0);
				if($max_seq < 0) {
					$max_seq = 1;
				} else {
					$max_seq = $max_seq+1;
				}

				$counts = 0;

				$sql = "INSERT INTO ".$initial."_data_files (";
				$sql .= " seq";
				$sql .= ", fid";
				$sql .= ", tbl";
				$sql .= ", userid";
				$sql .= ", num";
				$sql .= ", data_type";
				if($i==0) $sql .= ", data_base";
				$sql .= ", real_filename";
				$sql .= ", virtual_filename";
				$sql .= ", file_size";
				$sql .= ", file_type";
				$sql .= ", file_ext";
				$sql .= ", remark";
				$sql .= ", regdate";
				//$sql .= ", upddate";
				$sql .= ", counts";
				$sql .= ") VALUES (";
				$sql .= "$max_seq";
				$sql .= ", '$idx'";
				$sql .= ", '$_t'";
				$sql .= ", '$userid'";
				$sql .= ", '$data_num'";
				$sql .= ", 'file'";
				if($i==0) $sql .= ", '1'";
				$sql .= ", '$data_FullFilename'";
				$sql .= ", '$data_FullFilename'";
				$sql .= ", '$data_filesize'";
				$sql .= ", '$data_filetype'";
				$sql .= ", '$extension'";
				$sql .= ", '$data_remark'";
				$sql .= ", '$regdate'";
				//$sql .= ", '$upddate'";
				$sql .= ", '$counts'";

				$sql .= ")";

				mysql_query($sql, $dbconn) or die (mysql_error());


				$data_num++;

			}
		}

		$msg = "등록";
	}


	if ($gubun == "delete") {   # 삭제
		/*
		$query  =  "SELECT user_file, img_file FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$array  = mysql_fetch_array($result);
		$user_file	= stripslashes($array[user_file]);
		$img_file	= stripslashes($array[img_file]);

		########## 디렉토리에 저장된 이전 파일을 삭제한다. ##########
		if( $user_file != "" ){
			@unlink($foldername.$user_file);
		}
		if( $img_file != "" ){
			@unlink($foldername.$img_file);
		}
		*/


		$query  =  "SELECT real_filename FROM ".$initial."_data_files WHERE fid = '$idx' AND tbl='".$_t."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		while($array  = mysql_fetch_array($result)) {
			$real_filename	= stripslashes($array[real_filename]);
			if( $real_filename != "" ){
				@unlink($foldername.$real_filename);
			}
		}

		# 파일 삭제
		$del_qry = " DELETE FROM ".$initial."_data_files WHERE fid = '$idx' AND tbl='".$_t."' ";
		$result = mysql_query($del_qry, $dbconn);

		# 댓글
		$del_qry = " DELETE FROM ".$initial."_bbs_boardcomment WHERE fid = '$idx' AND tbl='".$_t."'  ";
		$result = mysql_query($del_qry, $dbconn);

		# 삭제
		$del_qry = " DELETE FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx' ";
		$result = mysql_query($del_qry, $dbconn);
		if(!$result) {
			$error_msg = mysql_error();
		} else {
			$msg = "삭제";
		}
	}   # end of if ($gubun == "delete") { ...

	if($gubun == "remove") {

		for($i=0;$i<count($idxchk);$i++) {
			/*
			$query  =  "SELECT user_file, img_file FROM ".$initial."_bbs_".$_t." WHERE idx = '$idxchk[$i]'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			$array  = mysql_fetch_array($result);
			$user_file	= stripslashes($array[user_file]);
			$img_file	= stripslashes($array[img_file]);
			########## 디렉토리에 저장된 이전 파일을 삭제한다. ##########
			if( $user_file != "" ){
				@unlink($foldername.$user_file);
			}
			if( $img_file != "" ){
				@unlink($foldername.$img_file);
			}
			*/

			$query  =  "SELECT real_filename FROM ".$initial."_data_files WHERE fid = '$idxchk[$i]' AND tbl='".$_t."'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			while($array  = mysql_fetch_array($result)) {
				$real_filename	= stripslashes($array[real_filename]);
				if( $real_filename != "" ){
					@unlink($foldername.$real_filename);
				}
			}

			# 파일 삭제
			$del_qry = " DELETE FROM ".$initial."_data_files WHERE fid = '$idxchk[$i]'  AND tbl='".$_t."'";
			$result = mysql_query($del_qry, $dbconn);


			# 댓글
			$del_qry = " DELETE FROM ".$initial."_bbs_boardcomment WHERE fid = '$idxchk[$i]' AND tbl='".$_t."'  ";
			$result = mysql_query($del_qry, $dbconn);


			######### 삭제 ##########
			$query 	= "DELETE FROM ".$initial."_bbs_".$_t." WHERE idx = '$idxchk[$i]'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
		}
		$msg = "삭제";
	}

	if ($gubun == "restore") {   # 복구
		# 복구
		$upd_qry = " UPDATE ".$initial."_bbs_".$_t." SET delflag='' WHERE idx = '$idx' ";
		$result = mysql_query($upd_qry, $dbconn);
		if(!$result) {
			$error_msg = mysql_error();
		} else {
			$msg = "복구";
		}
	}   # end of if ($gubun == "restore") { ...

	//////////////////////////////////////////////////////////////////////////
	//	태그 정보 수집
	//////////////////////////////////////////////////////////////////////////
	if($gubun == "insert" || $gubun == "update" || $gubun == "reply") {

		//태그 항목이 있을 경우
		if(preg_match("/tag/i", $cfg_option_list)) {
			$tag_array = explode(",",$tag);
			//수정일 경우 기존 정보 삭제
			if($gubun == "update") {
				$query 	= "DELETE FROM ".$initial."_bbs_boardtag WHERE fid = '".$idx."'";
				$query .= " AND tbl='".$_t."'";
				$query .= " AND division='tag'";
				$result = mysql_query($query, $dbconn) or die (mysql_error());
			}

			for($i=0;$i<count($tag_array);$i++) {
				$tag_data = $tag_array[$i];
				//echo $tag_arr."<br>";

				// max 구하기
				$query = "SELECT max(idx) FROM ".$initial."_bbs_boardtag ";
				$result = mysql_query($query, $dbconn);
				$max_idx = mysql_result($result,0,0);
				if($max_idx < 0) {
					$max_idx = 1;
				} else {
					$max_idx = $max_idx+1;
				}

				$sql = "INSERT INTO ".$initial."_bbs_boardtag (";
				$sql .= " idx";
				$sql .= ", fid";
				$sql .= ", tbl";
				$sql .= ", division";
				$sql .= ", tag_title";
				$sql .= ", userid";
				$sql .= ", counts";
				$sql .= ", remoteip";
				$sql .= ", regdate";
				$sql .= ") VALUES (";
				$sql .= " $max_idx";
				$sql .= ", '$idx'";
				$sql .= ", '$_t'";
				$sql .= ", 'tag'";
				$sql .= ", '$tag_data'";
				$sql .= ", '$SUPER_UID'";
				$sql .= ", '0'";
				$sql .= ", '$remoteip'";
				$sql .= ", '$regdate'";
				$sql .= ")";
				mysql_query($sql, $dbconn) or die (mysql_error());
			}
		}


		// body 항목에서만 사용했을 경우
		//해쉬태그 등록
		foreach($hashtags as $hashtag_array=>$sub_array) {
			foreach($sub_array as $k=>$tag_val){
				//echo "<br>[$hashtag_array][$k] : $tag_val\n";

				if($hashtag_array==1) {
					if($tag_val!="") {

						//수정일 경우 기존 정보 삭제
						if($gubun == "update") {
							$query 	= "DELETE FROM ".$initial."_bbs_boardtag WHERE fid = '".$idx."'";
							$query .= " AND tbl='".$_t."'";
							$query .= " AND division='hashtag'";
							$result = mysql_query($query, $dbconn) or die (mysql_error());
						}

						// max 구하기
						$query = "SELECT max(idx) FROM ".$initial."_bbs_boardtag ";
						$result = mysql_query($query, $dbconn);
						$max_idx = mysql_result($result,0,0);
						if($max_idx < 0) {
							$max_idx = 1;
						} else {
							$max_idx = $max_idx+1;
						}

						$sql = "INSERT INTO ".$initial."_bbs_boardtag (";
						$sql .= " idx";
						$sql .= ", fid";
						$sql .= ", tbl";
						$sql .= ", division";
						$sql .= ", tag_title";
						$sql .= ", userid";
						$sql .= ", counts";
						$sql .= ", remoteip";
						$sql .= ", regdate";
						$sql .= ") VALUES (";
						$sql .= " $max_idx";
						$sql .= ", '$idx'";
						$sql .= ", '$_t'";
						$sql .= ", 'hashtag'";
						$sql .= ", '$tag_val'";
						$sql .= ", '$SUPER_UID'";
						$sql .= ", '0'";
						$sql .= ", '$remoteip'";
						$sql .= ", '$regdate'";
						$sql .= ")";
						mysql_query($sql, $dbconn) or die (mysql_error());
					}
				}

			}
		}
	}




	if ($gubun == "counts") {   # 카운터
		// max 구하기
		$query = "SELECT max(idx) FROM ".$initial."_bbs_boardcounts ";
		$result = mysql_query($query, $dbconn);
		$max_idx = mysql_result($result,0,0);
		if($max_idx < 0) {
			$max_idx = 1;
		} else {
			$max_idx = $max_idx+1;
		}

		$sql = "INSERT INTO ".$initial."_bbs_boardcounts (";
		$sql .= " idx";
		$sql .= ", fid";
		$sql .= ", tbl";
		$sql .= ", division";
		$sql .= ", userid";
		$sql .= ", remoteip";
		$sql .= ", regdate";
		$sql .= ") VALUES (";
		$sql .= " $max_idx";
		$sql .= ", '$fid'";
		$sql .= ", '$_t'";
		$sql .= ", '$division'";
		$sql .= ", '$SUPER_UID'";
		$sql .= ", '$remoteip'";
		$sql .= ", '$regdate'";
		$sql .= ")";
		mysql_query($sql, $dbconn) or die (mysql_error());

		$upd_qry = " UPDATE ".$initial."_bbs_".$_t." SET ";
		if($division=="counts")	$upd_qry .= " counts=counts+1 ";
		if($division=="like")	$upd_qry .= " counts_like=counts_like+1 ";
		if($division=="bad")	$upd_qry .= " counts_bad=counts_bad+1 ";
		$upd_qry .= " WHERE idx = '$fid' ";
		mysql_query($upd_qry, $dbconn);

		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$fid'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			if($division=="counts")	$chkcounts	= stripslashes($array[counts]);
			if($division=="like")	$chkcounts	= stripslashes($array[counts_like]);
			if($division=="bad")	$chkcounts	= stripslashes($array[counts_bad]);
		}
		echo $chkcounts;
		mysql_close($dbconn);
		exit;

	}   # end of if ($gubun == "counts") { ...
?>
<? mysql_close($dbconn); ?>
<?
if($error_msg!="") {
?>
<form name="form" method="post" action="../common/500.php">
<input type="hidden" name="error_msg" value="<?=$error_msg?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
</form>
<script language="javascript">
<!--
	document.form.submit();
//-->
</script>
<?} else {?>
<form name="form" method="get" action="list.php">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_s" value="<?=$menu_s?>">
</form>
<script language="javascript">
<!--
	alert("정상적으로 <?=$msg?>되었습니다.");
	document.form.submit();
//-->
</script>
<?}?>