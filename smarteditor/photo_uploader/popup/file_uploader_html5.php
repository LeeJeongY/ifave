<?php
	include "../../../modules/config.php";

 	$sFileInfo = '';
	$headers = array();
	 
	foreach($_SERVER as $k => $v) {
		if(substr($k, 0, 9) == "HTTP_FILE") {
			$k = substr(strtolower($k), 5);
			$headers[$k] = $v;
		} 
	}
	
	$file = new stdClass;
	$file->name = rawurldecode($headers['file_name']);
	$file->size = $headers['file_size'];
	$file->content = file_get_contents("php://input");
	
	$filename_ext = strtolower(array_pop(explode('.',$file->name)));
	$allow_file = array("jpg", "png", "bmp", "gif"); 
	
	$base_filename = $file->name;
	$full_filename = explode(".", "$base_filename");

	if(!in_array($filename_ext, $allow_file)) {
		echo "NOTALLOW_".$file->name;
	} else {

		$createDir = date("Ymd");	//폴더 생성
		$uploadDir = '../../../'.$upload_dir.'/smarteditor/'.$createDir.'/';

		$ufile_FullFilename = $base_filename;
		//파일 확장자 뺀 파일명 추출
		for($i = 0;$i < sizeof($full_filename)-1;$i++) {
			if($i > 0) $ufile_Filename .= "." . $full_filename[$i];
			else $ufile_Filename .= $full_filename[$i];
		}
		//파일명 중복검사
		$num = 1;
		while (file_exists($uploadDir.$ufile_FullFilename) == true) {
			$ufile_FullFilename = $ufile_Filename . "_".$num."." . $filename_ext;
			$num++;		
		}


		if(!is_dir($uploadDir)){
			mkdir($uploadDir, 0777);
		}
		
		$newPath = $uploadDir.urlencode(iconv("utf-8", "cp949", $ufile_FullFilename));
		
		if(file_put_contents($newPath, $file->content)) {
			$sFileInfo .= "&bNewLine=true";
			$sFileInfo .= "&sFileName=".urlencode(urlencode($ufile_FullFilename));
			$sFileInfo .= "&sFileURL=/".$upload_dir."/smarteditor/".$createDir."/".urlencode(urlencode($ufile_FullFilename));
		}
		
		echo $sFileInfo;
	}
?>