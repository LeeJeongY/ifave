<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../modules/dbcon.php";
	include "../modules/config.php";
	include "../modules/func.php";
	include "../modules/func_q.php";

	set_time_limit(0);

	$folder	=  $_GET[fl];
	$file	=  $_GET[fi];
	$seq	=  $_GET[s];
	$fid	=  $_GET[fid];
	$_t		=  $_GET[t];

	$full_filename = explode(".", "$file");
	$ext = $full_filename[sizeof($full_filename)-1];

	if(!preg_match("/php|PHP|php3|PHP3|html|HTML|htm|HTM|jsp|JSP|java|JAVA|inc|INC|cgi|GGI|asp||ASP|js|JS|exe|EXE|sh|SH|dll|DLL/i", $ext)) {
	   echo ("
			   <script>
				location.href='$main_url';
			   </script>
		   ");
		   exit;
	}

	$file_conv	= iconv("UTF-8", "euc-kr", $file);		// 한글깨짐 방지
	$file_path	=  $folder.$file;

	if($dn == "") $dn = "1";							// 1 이면 다운 0 이면 브라우져가 인식하면 화면에 출력
	$dn_yn = ($dn) ? "attachment" : "inline";


	if(preg_match("/MSIE 5.5|MSIE 6.0/i", $HTTP_USER_AGENT)) {	// 브라우져 구분
		Header("Content-type: application/octet-stream");
		Header("Content-Length: ".filesize("$file_path"));		// 이부부을 넣어 주어야지 다운로드 진행 상태가 표시 됩니다.
		Header("Content-Disposition: ". $dn_yn . ";" . " filename=" . $file_conv);
		Header("Cache-control: private");						//이것..중요...... 파일열기..선택시...정상동작위해서
		//Header("Content-Description: PHP3 Generated Data");
		Header("Content-Transfer-Encoding: binary");
		Header("Pragma: no-cache");
		Header("Expires: 0");
	} else {
		Header("Content-type: file/unknown");
		Header("Content-type: application/octet-stream");
		Header("Content-Length: ".filesize("$file_path"));
		Header("Content-Disposition: ". $dn_yn . ";" . " filename=" . $file_conv);
		Header("Content-Description: PHP5 Generated Data");
		Header("Pragma: no-cache");
		Header("Expires: 0");
	}

	if($seq && $fid && $_t) {
		//  다운로드 수 업뎃
		$sql = "UPDATE ".$initial."_data_files SET ";
		$sql .= " counts = counts+1 ";
		$sql .= " WHERE fid = '".$fid."'";
		$sql .= " AND tbl	= '".$_t."'";
		$sql .= " AND seq	='".$seq."'";
		@mysql_query($sql,$dbconn) or die (mysql_error());
	}


	if (is_file("$file_path")) {
		$fp = fopen("$file_path", "r");
		if (!fpassthru($fp)) fclose($fp); // 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 기타 보단 이방법이...
	} else {
		echo "해당파일이나 경로가 존재하지 않습니다.";
	}

	mysql_close($dbconn);
?>
