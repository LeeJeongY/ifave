<?php
	include "../../../modules/config.php";

	// default redirection
	$url = $_REQUEST["callback"].'?callback_func='.$_REQUEST["callback_func"];
	$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);

	// SUCCESSFUL
	if(bSuccessUpload) {
		$tmp_name = $_FILES['Filedata']['tmp_name'];
		$name = $_FILES['Filedata']['name'];
		
		$filename_ext = strtolower(array_pop(explode('.',$name)));
		$allow_file = array("jpg", "png", "bmp", "gif");
		
		$base_filename = $name;
		$full_filename = explode(".", "$base_filename");

		if(!in_array($filename_ext, $allow_file)) {
			$url .= '&errstr='.$name;
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
			
			$newPath = $uploadDir.urlencode($ufile_FullFilename);
			
			@move_uploaded_file($tmp_name, $newPath);
			
			$url .= "&bNewLine=true";
			$url .= "&sFileName=".urlencode(urlencode($ufile_FullFilename));
			$url .= "&sFileURL=/".$upload_dir."/smarteditor/".$createDir."/".urlencode(urlencode($ufile_FullFilename));

		}
	}
	// FAILED
	else {
		$url .= '&errstr=error';
	}
		
	header('Location: '. $url);
?>