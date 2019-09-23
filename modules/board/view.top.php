<?

	if ($idx) {
		//조회수 증가
		if ($_USER_CLASS <= 10) {
			// max 구하기
			$query = "SELECT max(idx) FROM ".$initial."_bbs_boardcounts ";
			$result = mysql_query($query, $dbconn);
			$max_idx = mysql_result($result,0,0);
			if($max_idx < 0) {
				$max_idx = 1;
			} else {
				$max_idx = $max_idx+1;
			}

			$sql = "INSERT INTO ".$initial."_bbs_boardcounts SET ";
			$sql .= " idx			= '".$max_idx."'";
			$sql .= ", fid			= '".$idx."'";
			$sql .= ", tbl			= '".$_t."'";
			$sql .= ", division		= 'counts'";
			if($UID) $sql .= ", userid		= '".$UID."'";
			$sql .= ", remoteip		= '".$remoteip."'";
			$sql .= ", regdate		= '".$regdate."'";
			mysql_query($sql, $dbconn) or die (mysql_error());

			$query = "UPDATE ".$initial."_bbs_".$_t." SET counts=counts+1 WHERE idx = '$idx'";
			mysql_query($query, $dbconn);
		}

		//테이블에서 글을 가져옵니다.
		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$v_view_flag		= stripslashes($array[view_flag]);	// 뷰설정
			if($cfg_cate_flag == "1") $v_category	= stripslashes($array[category]);   // 카테고리
			$v_title			= db2html($array[title]);			// 글제목
			$v_counts			= stripslashes($array[counts]);		// 조회수
			$v_counts_like		= stripslashes($array[counts_like]);// 좋아요
			$v_counts_bad		= stripslashes($array[counts_bad]);	// 나빠요
			$v_tag				= stripslashes($array[tag]);		// 태그
			$v_username			= db2html($array[username]);		// 작성자
			$v_userid			= stripslashes($array[userid]);		// 아이디
			$v_body				= stripslashes($array[body]);
			if($_t=="postscript") {
				$v_contents	= nE_db2html_v($v_body);
			} else {
				$v_contents	= db2html($v_body);
			}
			$v_regdate	= $array[regdate];					// 등록일
			$v_upddate	= $array[upddate];					// 수정일

			if($cfg_bbs_type!="sns") {
				$v_dbpasswd		= stripslashes($array[passwd]);		// 비밀번호
				$v_org_idx		= stripslashes($array[org_idx]);	// 원문글번호
				$v_thread		= stripslashes($array[thread]);		// thread
				$v_depth		= stripslashes($array[depth]);		// depth
				$v_pos			= stripslashes($array[pos]);		// pos
				$v_user_file	= stripslashes($array[user_file]);
				$v_img_file		= stripslashes($array[img_file]);
				$v_is_secret	= stripslashes($array[is_secret]);   // 비밀글
				$v_tel			= stripslashes($array[tel]);		// 연락처
				$v_hp			= stripslashes($array[hp]);			// 휴대폰
				$v_email		= stripslashes($array[email]);		// mail
				$v_homep		= stripslashes($array[homep]);		// 홈페이지
				$v_murl			= stripslashes($array[murl]);		// 영상
				$v_notice_yn	= stripslashes($array[notice_yn]);	// 공지
			}
			//$regdate	= substr($regdate, 0, 10);
		}

		//원문 내용 불러오기
		if($org_idx > 0) {
			$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$org_idx'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			if($array = mysql_fetch_array($result)) {
				$v_original_contents	= stripslashes($array[body]);
				$v_original_contents	= db2html($v_original_contents);
			}
		}

		$query = "SELECT min(idx) as idx_max FROM ".$initial."_bbs_".$_t." ";
		$query .= " WHERE idx > '".$idx."'";
		$query .= " AND view_flag = '1'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$prev_idx		= $array[idx_max];
		}// end if

		$query = "SELECT title FROM ".$initial."_bbs_".$_t." ";
		$query .= " WHERE idx = '".$prev_idx."'";
		$query .= " AND view_flag = '1'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$prev_title		= db2html($array[title]);
		}// end if

		$query = "SELECT max(idx) as idx_min FROM ".$initial."_bbs_".$_t." ";
		$query .= " WHERE idx < '".$idx."'";
		$query .= " AND view_flag = '1'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$next_idx		= $array[idx_min];
		}// end if

		$query = "SELECT title FROM ".$initial."_bbs_".$_t." ";
		$query .= " WHERE idx = '".$next_idx."'";
		$query .= " AND view_flag = '1'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$next_title		= db2html($array[title]);
		}// end if

	}
?>