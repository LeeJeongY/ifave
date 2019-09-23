<?
	//로그인 경우 ============================
	if ($gubun_log == "login") {

		// max 구하기
		$query		= "SELECT max(idx) FROM ".$initial."_".$tbl."_log ";
		$result		= mysql_query($query, $dbconn);
		$max_log_idx	= mysql_result($result, 0, 0);
		if($max_log_idx < 0) {
			$max_log_idx = 1;
		} else {
			$max_log_idx = $max_log_idx+1;
		}

		$query = "INSERT INTO ".$initial."_".$tbl."_log SET ";
		$query .= "   idx			= '".$max_log_idx."'";
		$query .= "  , userid		= '".$UID."'";
		$query .= "  , device		= '".$device."'";
		$query .= "  , agent		= '".$_SERVER['HTTP_USER_AGENT']."'";
		$query .= "  , remote_ip	= '".$remoteip."'";
		$query .= "  , in_date      = '".$signdate."'";

		$result = mysql_query($query, $dbconn) or die (mysql_error());

		$msg = "등록";
	}

	//로그아웃 경우 ======================
	if ($gubun_log  == "logout") {
		$signdate	= date("Y"."-"."m"."-"."d H:i:s");

		$query = "UPDATE ".$initial."_".$tbl."_log SET ";
		$query .= "  out_date	= '".$signdate."'";
		$query .= " WHERE idx	= '".$LOGIN_IDX."'";
		$query .= " AND userid	= '".$UID."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
	}
?>