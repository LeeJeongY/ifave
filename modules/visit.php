<?
	if($_COOKIE["O2OOM_VISIT"]!="Y") {
		$signdate = time();
		######### 데이터베이스에 입력값을 삽입한다. #########
		if($_SERVER["HTTP_REFERER"]=="") $_SERVER["HTTP_REFERER"]="unknown";
		if($_SERVER["REQUEST_URI"]=="/index.php") $_SERVER["REQUEST_URI"] = "/";


		$query = "INSERT INTO ".$initial."_log (";
		$query .= " referer";
		$query .= ", addr";
		$query .= ", uri";
		$query .= ", agent";
		$query .= ", signdate";
		$query .= ") VALUES (";
		$query .= "'".$_SERVER["HTTP_REFERER"]."'";
		$query .= ", '".$_SERVER['REMOTE_ADDR']."'";
		$query .= ", '".$_SERVER["REQUEST_URI"]."'";
		$query .= ", '".$_SERVER['HTTP_USER_AGENT']."'";
		$query .= ", '$signdate'";
		$query .= ")";

		$result = @mysql_query($query, $dbconn) or die (@mysql_error());

		//	$alive_time = time() + 3600; // 시간설정

		//	SetCookie("LUX_VISIT","Y",$alive_time,"/");
		@SetCookie("O2OOM_VISIT","Y",0,"/");
		//창을 닫으면 쿠키 삭제

	}
?>
