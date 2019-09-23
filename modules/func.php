<?
	/***********************************************/
	// 기본함수 정의 start
	/***********************************************/

	// sql injection 처리
	function inject2db( $value ) {
		// magic quotes gpc가 PHP 세팅에서 on으로 되어있는지 확인
		// gpc는 get, post, cookie의 약자임
		$magic_quotes_active = get_magic_quotes_gpc();

		// PHP 버전 4.3.0 이상에서만 존재하는 mysql_real_escape_string 함수의 사용이 가능한지 확인
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			// 만약 magic quotes gpc의 PHP 세팅이 적용되었다면 magic quotes 적용을 취소하고 원래 상태로 되돌림
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			// mysql_real_escape_string 함수로 query문을 정화한다.
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			// 만약 magic quotes gpc 세팅이 안 되어 있다면 addslashes 함수로 직접 정화한다.
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
				// if magic quotes are active, then the slashes already exist
				// 만약 magic quotes gpc 세팅이 적용되어 있다면 그냥 이 기능을 사용한다.
		}
		return $value;
	}

	//팝업 알림창
	function popup_msg($msg) {
	   echo("<script language=\"javascript\">
	   <!--
	   alert('$msg');
	   history.back();
	   //-->
	   </script>");
	   exit;
	}


	/***********************************************/
	// 기본함수 정의 end
	/***********************************************/
	//입력시
    function html2db( $str ) {
        global $PHP_SELF;
        $str = str_replace( "\\", "&ys", $str );
        $str = str_replace( "'", "&yq", $str );
		//$str = str_replace("&","&amp;",$str);

        $str = str_replace( chr(34), "&ydq", $str );
        $str = addslashes( $str );


        return $str;
    }

	//출력시
    function db2html( $str ) {
		//$str=stripslashes($str);

        //$str=eregi_replace("\n","<br>",$str);
        $str = str_replace( "&yq", "'", $str );
        $str = str_replace( "&ydq", chr(34), $str );
        //$str = str_replace( "\\", "\n", $str );
        $str = str_replace( "&ys", "\n", $str );
		$str = str_replace( uchr("10"), "", $str );
        return $str;
    }

	//에디터(위즈윅 사용안 할때 뷰페이지)
    function nE_db2html_v( $str ) {
		//$str=stripslashes($str);&ys&yq

        $str = str_replace( "\\", "\n", $str );
        $str = str_replace( "&ys", "\n", $str );
        $str = str_replace("\n","<br>",$str);
        $str = str_replace( "&yq", "'", $str );
        $str = str_replace( "&ydq", chr(34), $str );
        $str = str_replace( "&ys", "\\", $str );
		$str = str_replace( uchr("10"), "", $str );

        return $str;
    }

	//에디터 입력이 아닌경우 출력시
    function nE_db2html( $str ) {
		//$str=stripslashes($str);&ys&yq

        $str = str_replace("<br>","\n",$str);
        $str = str_replace( "&yq", "'", $str );
        $str = str_replace( "&ydq", chr(34), $str );
        $str = str_replace( "&ys", "\\", $str );
        $str = str_replace( "\\", "\n", $str );
        $str = str_replace( "&ys", "\n", $str );
		$str = str_replace( uchr("10"), "", $str );

        return $str;
    }

	function uchr ($codes) {
		if (is_scalar($codes)) $codes= func_get_args();
		$str= '';
		foreach ($codes as $code) $str.= html_entity_decode('&#'.$code.';',ENT_NOQUOTES,'UTF-8');
		return $str;
	}

	//문자 자르기
	function cut_string($str, $len, $ELLIP="..") {

		preg_match_all('/[\xE0-\xFF][\x80-\xFF]{2}|./', $str, $match);

	    $m = $match[0];
	    $slen = strlen($str); // length of source string
	    $tail = '..';
	    $tlen = $tail; // length of tail string
	    if ($slen <= $len) return $str;
	    $ret = array();
	    $count = 0;
	    for ($i=0; $i < $len; $i++){
	        $count += (strlen($m[$i]) > 1)?2:1;

	        if ($count + $tlen > $len) break;
	        $ret[] = $m[$i];
	    }
	    return join('', $ret).$tail;
	}


	// 글자를 일정한 크기로 잘라주고 뒤에 .. 을 붙여준다.
	function WShortString($sData, $nLength) {
		if (strlen($sData) > $nLength) {
				   for($i=0; $i < $nLength-1; $i++)  {
							if(ord(substr($sData, $i, 1))>127) $i++;
				   }
				   $sData = substr($sData,0,$i) . "..";
				   //...을 없앰 - 이유는 지져분해서
		}
		return $sData;
	}

	//랜덤 문자 가져오기 8자(비밀번호 찾기에서 사용)
	function getStringRandom($no) {
		$str = str_repeat('123456789abcdefghjkmnpqrstuvwxyz', $no);
		$str = str_shuffle($str);
		$str = substr($str,0, $no);
		return $str;
	}


	//랜덤 숫자 가져오기(회원가입시 사용)
	function getNumberRandom($no) {
		$str = str_repeat('1234567890', $no);
		$str = str_shuffle($str);
		$str = substr($str,0, $no);
		return $str;
	}

	/* 본문 내용에서 이미지 출력 */
	function getImageContent($contents) {
		preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $contents , $match);
		for($i=0; $i<count($match[1]); $i++) {
			$_array = explode("/",$match[1][$i]);
			$_return[$i][0] = $_array[count($_array)-1];
			$_return[$i][1] = str_replace($_return[$i][0],"",$match[1][$i]);
		}
		return $_return;
	}

	/* 사용법 */
	/*
	$_img = getImageContent($body);
	for ($i=0; $i<count($_img); $i++) {
		echo $_img[$i][0]."<br>"; // 파일명
		echo $_img[$i][1]."<P>"; // 파일명을 뺀 URL 명
	}
	*/

	// 페이징 처리
	function fn_page($total_page, $page_num, $page, $link_url) {
		$total_block	= ceil($total_page/$page_num);	// 한 화면에 보이는 블록
		$block			= ceil($page/$page_num);			// 현재 블록

		$first			= ($block-1)*$page_num;			// 페이지 블록이 시작하는 첫 페이지
		$last			= $block*$page_num;				// 페이지 블록의 끝 페이지

		if($block >= $total_block) {
			$last		= $total_page;
		}

		// 이전 블록
		if($block > 1) {
			$prev	= $first - 1;
			echo "<li><a href='$link_url"."page=$prev'>&laquo;</a></li>";
		} else {
			echo "<li><a>&laquo;</a></li>";
		}

		// 페이지 링크
		if ($total_page == "") {
			echo "";
		} else {
			for ($page_link=$first+1;$page_link<=$last;$page_link++) {
				if($page_link != "1") echo "<li></li>";
				if($page_link==$page) {
					echo "<li><a><b>$page_link</b></a></li>";
				} else {
					echo "<li><a href='$link_url"."page=$page_link'>$page_link</a></li>";
				}
			}
		}

		// 다음 블록
		if($block < $total_block) {
			$next		= $last + 1;
			echo "<li><a href='$link_url"."page=$next'>&raquo;</a></li>";
		} else {
			echo "<li><a>&raquo;</a></li>";
		}
	}


	// 페이징 처리
	function fn_page_user($total_page, $page_num, $page, $link_url) {
		$total_block	= ceil($total_page/$page_num);	// 한 화면에 보이는 블록
		$block			= ceil($page/$page_num);			// 현재 블록

		$first			= ($block-1)*$page_num;			// 페이지 블록이 시작하는 첫 페이지
		$last			= $block*$page_num;				// 페이지 블록의 끝 페이지

		if($block >= $total_block) {
			$last		= $total_page;
		}

		// 이전 블록
		if($block > 1) {
			$prev	= $first - 1;
			echo "<a href=\"$link_url\" class=\"prev\">< prev</a>";
		} else {
			echo "<a href=\"javascript:;\" class=\"prev\">< prev</a>";
		}

		// 페이지 링크
		if ($total_page == "") {
			echo "";
		} else {
			for ($page_link=$first+1;$page_link<=$last;$page_link++) {
				if($page_link != "1") echo "<li></li>";
				if($page_link==$page) {
					echo "<strong>$page_link</strong>";
				} else {
					echo "<a href=\"$link_url"."page=$page_link\">$page_link</a>";
				}
			}
		}

		// 다음 블록
		if($block < $total_block) {
			$next		= $last + 1;
			echo "<a href=\"$link_url\" class=\"next\">next ></a>";
		} else {
			echo "<a href=\"javascript:;\" class=\"next\">next ></a>";
		}
	}



	//우편번호 페이징 처리함수
	function epost_page($total_page, $page_num, $page, $link_url) {

		$html = "";

		$total_block	= ceil($total_page/$page_num);	// 한 화면에 보이는 블록
		$block			= ceil($page/$page_num);			// 현재 블록

		$first			= ($block-1)*$page_num;			// 페이지 블록이 시작하는 첫 페이지
		$last			= $block*$page_num;				// 페이지 블록의 끝 페이지

		if($block >= $total_block) {
			$last		= $total_page;
		}// end if


		// 이전 블록
		if($block > 1) {
			$prev		= $first - 1;
			$html .= "<a href='$link_url"."currentPage=$prev' title='이전' class=\"direction\">|◀</a> ";
		} else {

			$html .= "<a href='$link_url"."currentPage=$prev' title='이전' class=\"direction\">◀</a> ";
		}// end if

		// 페이지 링크
		if ($total_page == "") {
			$html .= "<span class='on'>1</span>";
		}else {
			for ($page_link=$first+1;$page_link<=$last;$page_link++) {
				if($page_link != "1") echo " ";
				if($page_link==$page) {
					// $html .= "<strong>$page_link</strong>";
					$html .= "<span style='color:#458115;font-size:11pt;font-weight:bold;'>".$page_link."</span>";
				}
				else {
					$html .= " <a href='$link_url"."currentPage=$page_link' title='$page_link 페이지로 이동합니다.'>$page_link</a> ";
				}// end if
			}// end for
		}// end if

		// 다음 블록
		if($block < $total_block) {

			$next		= $last + 1;
			$html .= " <a href='$link_url"."currentPage=$next' title='다음' class=\"direction\"> ▶ </a>";
		} else {

			$html .= " <a href='$link_url"."currentPage=$next' title='다음' class=\"direction\"> ▶| </a>";
		}

		return $html;
	}// end function


	//페이징 처리함수
	function user_page($total_page, $page_num, $page, $link_url) {

		$html = "";

		$total_block	= ceil($total_page/$page_num);	// 한 화면에 보이는 블록
		$block			= ceil($page/$page_num);			// 현재 블록

		$first			= ($block-1)*$page_num;			// 페이지 블록이 시작하는 첫 페이지
		$last			= $block*$page_num;				// 페이지 블록의 끝 페이지

		if($block >= $total_block) {
			$last		= $total_page;
		}// end if


		// 이전 블록
		if($block > 1) {
			$prev		= $first - 1;
			$html .= "<li class=\"page-item\"> <a class=\"page-link\" href=\"$link_url"."currentPage=$prev\">Prev</a> </li>";
		} else {

			$html .= "<li class=\"page-item\"> <a class=\"page-link\" href=\"$link_url"."currentPage=$prev\">Prev</a> </li>";
		}// end if

		// 페이지 링크
		if ($total_page == "") {
			$html .= "<li class=\"page-item active\"> <a class=\"page-link\" href=\"\">1</a> </li>";
		}else {
			for ($page_link=$first+1;$page_link<=$last;$page_link++) {
				if($page_link != "1") echo " ";
				if($page_link==$page) {
					// $html .= "<strong>$page_link</strong>";
					$html .= "<li class=\"page-item active\"> <a class=\"page-link\">".$page_link."</a> </li>";
				}
				else {
					$html .= "<li class=\"page-item\"> <a class=\"page-link\" href=\"$link_url"."currentPage=$page_link\">$page_link</a> </li>";
				}// end if
			}// end for
		}// end if

		// 다음 블록
		if($block < $total_block) {

			$next		= $last + 1;
			$html .= "<li class=\"page-item\"> <a class=\"page-link\" href=\"$link_url"."currentPage=$next\">Next</a> </li>";
		} else {

			$html .= "<li class=\"page-item\"> <a class=\"page-link\" href=\"$link_url"."currentPage=$next\">Next</a> </li>";
		}

		return $html;
	}// end function

	//이미지 업로드
	function upload_file_save($img_name, $foldername, $width, $height, $img) {

		if ($img_name != "" ) { // 만약 화일이 있다면
			 $full_filename = explode("\\", "$img_name");
			 $pure_filename = $full_filename[sizeof($full_filename)-1];


			 $pure_filename = strtolower($pure_filename);
			 $full_filename = explode(".", "$pure_filename");
			 $extension = $full_filename[sizeof($full_filename)-1];
			 $extension = strtolower($extension);

			 if( !($extension == "gif" || $extension == "bmp" || $extension == "jpg" || $extension == "jpeg" || $extension == "png")) {
				   echo ("
						   <script>
						   alert('이미지파일만 첨부할 수 있습니다.')
						   history.go(-1)
						   </script>
					   ");
					   exit;
			}

			$img_FullFilename = $img_name;

			//파일 확장자 뺀 파일명 추출
			for($i = 0;$i < sizeof($full_filename)-1;$i++) {
				if($i > 0) $img_Filename .= "." . $full_filename[$i];
				else $img_Filename .= $full_filename[$i];
			}
			//파일명 중복검사
			$num = 1;
			while (file_exists($foldername.$img_FullFilename) == true) {
				$img_FullFilename = $img_Filename . "($num)." . $extension;
				$num++;
			}
			//폴더 생성
			if(!is_dir($foldername)){
				mkdir($foldername, 0777);
			}
			// 원본 이미지 파일
			$srcFile = $foldername. $img_FullFilename;
			 if (!@copy($img,$srcFile)) {
					?>
				  <script language="JavaScript">
				  window.alert('폴더가 삭제 되었거나, 쓰기권한이 없읍니다.');
				  history.go(-1);
				  </script><?
				  exit;
			 }
			 if (!@unlink($img)) {  ?>
				  <script language="JavaScript">
				  window.alert('업로드중 오류발생 관리자에게 문의 하셔요!');
				  history.go(-1);
				  </script><?
				  exit;

			 }

			if($width != "") {
				// 타겟 이미지 파일
				$thum_savedir = $foldername."thumb";

				$thumbFile = $thum_savedir . "/".$img_FullFilename;

				thumbnail($srcFile, $thumbFile, $width, $height);

				//썸네일 크롭
				$thumbFile_Center = $foldername."list"."/".$img_FullFilename;;
				MakeThumb($srcFile, $thumbFile_Center, "2");
			}
		}
		return $img_FullFilename;
	}

	//파일 업로드
	function dataload_file_save($ufile_name, $foldername, $ufile) {

		if ($ufile_name != "" ) { // 만약 화일이 있다면
			 $full_filename = explode("\\", "$ufile_name");
			 $pure_filename = $full_filename[sizeof($full_filename)-1];


			 $pure_filename = strtolower($pure_filename);
			 $full_filename = explode(".", "$pure_filename");
			 $extension = $full_filename[sizeof($full_filename)-1];
			 $extension = strtolower($extension);

			 if(($extension == "gif" || $extension == "bmp" || $extension == "jpg" || $extension == "jpeg")) {
				   echo ("
						   <script>
						   alert('이미지파일은 첨부할 수 없습니다.')
						   history.go(-1)
						   </script>
					   ");
					   exit;
			 }

			 $ufile_FullFilename = $ufile_name;

			//파일 확장자 뺀 파일명 추출
			for($i = 0;$i < sizeof($full_filename)-1;$i++) {
				if($i > 0) $ufile_Filename .= "." . $full_filename[$i];
				else $ufile_Filename .= $full_filename[$i];
			}
			//파일명 중복검사
			$num = 1;
			while (file_exists($foldername.$ufile_FullFilename) == true) {
				$ufile_FullFilename = $ufile_Filename . "($num)." . $extension;
				$num++;
			}
			//폴더 생성
			if(!is_dir($foldername)){
				mkdir($foldername, 0777);
			}

			// 원본 파일
			$srcFile = $foldername.$ufile_FullFilename;
			 if (!@copy($ufile,$srcFile)) {
					?>
				  <script language="JavaScript">
				  window.alert('폴더가 삭제 되었거나, 쓰기권한이 없읍니다.');
				  history.go(-1);
				  </script><?
				  exit;
			 }
			 if (!@unlink($ufile)) {  ?>
				  <script language="JavaScript">
				  window.alert('업로드중 오류발생 관리자에게 문의 하셔요!');
				  history.go(-1);
				  </script><?
				  exit;

			 }

		}
		return $ufile_FullFilename;
	}



	// 원본 이미지 -> 썸네일로 만드는 함수
	function thumbnail($file, $save_filename, $max_width, $max_height)
	{
			$src_img = ImageCreateFromJPEG($file); //JPG파일로부터 이미지를 읽어옵니다

			$img_info = getImageSize($file);//원본이미지의 정보를 얻어옵니다
			$img_width = $img_info[0];
			$img_height = $img_info[1];



			if(($img_width/$max_width) == ($img_height/$max_height))
			{//원본과 썸네일의 가로세로비율이 같은경우
				$dst_width=$max_width;
				$dst_height=$max_height;
			}
			elseif(($img_width/$max_width) < ($img_height/$max_height))
			{//세로에 기준을 둔경우
				$dst_width=$max_height*($img_width/$img_height);
				$dst_height=$max_height;
			}
			else{//가로에 기준을 둔경우
				$dst_width=$max_width;
				$dst_height=$max_width*($img_height/$img_width);
			}//그림사이즈를 비교해 원하는 썸네일 크기이하로 가로세로 크기를 설정합니다.



			$dst_img = imagecreatetruecolor($dst_width, $dst_height); //타겟이미지를 생성합니다



			ImageCopyResized($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $img_width, $img_height); //타겟이미지에 원하는 사이즈의 이미지를 저장합니다



			ImageInterlace($dst_img);
			ImageJPEG($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
			ImageDestroy($dst_img);
			ImageDestroy($src_img);
	}


	//썸네일 중앙에 생성
	//썸네일 크롭
	//http://apmusers.com/tt/dbckdghk/43 참고할것
	//http://blog.naver.com/PostView.nhn?blogId=action1020&logNo=120151935839
	function MakeThumb($file_path, $save_path, $type){
		$imginfo = getimagesize($file_path);
		if($imginfo[2] != 1 && $imginfo[2] != 2 && $imginfo[2] != 3)
		return "확장자가 jp(e)g/png/gif 가 아닙니다.";

		if($imginfo[2] == 1) $cfile = imagecreatefromgif($file_path);
		else if($imginfo[2] == 2) $cfile = imagecreatefromjpeg($file_path);
		else if($imginfo[2] == 3) $cfile = imagecreatefrompng($file_path);

		if ($type == 1) {
			if($imginfo[0] > $imginfo[1]){
				$new_h=($imginfo[1]*198) / $imginfo[0];
				$new_w=198;
			} //width가 클때
			if($imginfo[0] < $imginfo[1]){
				$new_w=($imginfo[0]*198) / $imginfo[1];
				$new_h=198;
			} //height가 클때
			if($imginfo[0] == $imginfo[1]){
				$new_w=198;
				$new_h=198;
			} //같을때

			$dest = imagecreatetruecolor($new_w, $new_h);
		}

		else if ($type == 2) {
			$new_h=($imginfo[1]*198) / $imginfo[0];
			$new_w=198;
			$tmp= ( $new_h > 215) ? 215 : $new_h;
			$dest = imagecreatetruecolor($new_w, $tmp);
		}

		imagecopyresampled($dest, $cfile, 0, 0, 0, 0, $new_w, $new_h, $imginfo[0], $imginfo[1]);

		if($imginfo[2] == 1) imagegif($dest, $save_path, 90);    // 1~100
		else if($imginfo[2] == 2) imagejpeg($dest, $save_path, 90); // 1~100
		else if($imginfo[2] == 3) imagepng($dest, $save_path, 9);  //  1~9

		imagedestroy($dest);
		return 1;
	}



	// 주소에 따른 네이버 좌표 정보 가져오기
	function getNaverGeocode($addr) {
		global $naver_cId;
		global $naver_cSecret;

		$arrData = array();

		$addr = urlencode($addr);
		$url = "https://openapi.naver.com/v1/map/geocode?encoding=utf-8&coord=latlng&output=json&query=".$addr;

		$headers = array();
		$headers[] = "GET https://openapi.naver.com/v1/map/geocode?".$addr;
		$headers[] ="Host: openapi.naver.com";
		$headers[] ="Accept: */*";
		$headers[] ="Content-Type: application/json";
		$headers[] ="X-Naver-Client-Id: ".$naver_cId;
		$headers[] ="X-Naver-Client-Secret: ".$naver_cSecret;
		$headers[] ="Connection: Close";

		$result = getHttp($url, $headers);

		$data = json_decode($result,1);
		$arrData['X']= $data['result']['items'][0]['point']['x'];
		$arrData['Y'] = $data['result']['items'][0]['point']['y'];

		return $arrData;
	}// end function

	// 주소에 따른 다음 좌표 정보 가져오기
	function getDaumGeocode($addr) {
		global $daum_apiKey;

		$arrData = array();
		//$apiKey = "a9afceed5c925f868a90c7e63b8f00c9c1d74a2d";

		$addr = urlencode($addr);
		$url = "https://openapi.naver.com/v1/map/geocode?encoding=utf-8&coord=latlng&output=json&query=".$addr;

		$url = "https://apis.daum.net/local/geo/addr2coord?apikey=".$daum_apiKey."&q=".$addr."&output=json";

		$headers = array();
		// $headers[] = "GET https://openapi.naver.com/v1/map/geocode?".$addr;
		// $headers[] ="Host: openapi.naver.com";
		// $headers[] ="Accept: */*";
		// $headers[] ="Content-Type: application/json";
		// $headers[] ="X-Naver-Client-Id: ".$cId;
		// $headers[] ="X-Naver-Client-Secret: ".$cSecret;
		// $headers[] ="Connection: Close";

		$result = getHttp($url, $headers);

		$data = json_decode($result,1);

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit;

		$arrData['X']= $data['channel']['item'][0]['point_x'];
		$arrData['Y'] = $data['channel']['item'][0]['point_y'];

		// echo "<pre>";
		// print_r($arrData);
		// echo "</pre>";
		// exit;

		return $arrData;
	}// end function

	// curl 통신 하기
	function getHttp($url, $headers=null){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}// end function


	//전화번호 자동변환
	function tel_hyphen($str) {

		$str = trim($str);
		$str = str_replace("-","",$str);
		$len = strlen($str);
		if($len == 11) {
			$str_val = substr($str,0,3)."-".substr($str,3,4)."-".substr($str,7,4);
		} else if($len == 10) {
			$str_val = substr($str,0,3)."-".substr($str,3,3)."-".substr($str,6,4);
		} else if($len == 9) {
			$str_val = substr($str,0,2)."-".substr($str,2,3)."-".substr($str,5,4);
		}
		return $str_val;
	}

	//파일 용량 정보
	function byteConvert($bytes) {
		$s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
		$e = floor(log($bytes)/log(1024));
		return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
	}

	//해시태그 변환
	function convertHashtags($str){
		$regex = "/\\#([0-9a-zA-Z가-힣]*)/";
		$str = preg_replace($regex, '<a href="hashtag.php?tag=$1">$0</a>', $str);
		return($str);
	}

	//xml 블로그 파싱
	function parsing_data($url, $data) {
		$agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36';
		$curlsession = curl_init ();
		curl_setopt ($curlsession, CURLOPT_URL, $url); // 파싱 주소 url
		//curl_setopt ($curlsession, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
		//curl_setopt ($curlsession, CURLOPT_SSLVERSION,3); // SSL 버젼 (https 접속시에 필요)
		curl_setopt ($curlsession, CURLOPT_HEADER, 0);
		curl_setopt ($curlsession, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curlsession, CURLOPT_POST, 0); // POST = 1, GET = 0
		curl_setopt ($curlsession, CURLOPT_POSTFIELDS, "".$data.""); // POST 일경우 data 값을 받아 넣을수 ㅆ다.이
		curl_setopt ($curlsession, CURLOPT_USERAGENT, $agent);
		curl_setopt ($curlsession, CURLOPT_REFERER, $url); // 일부 사이트의 경우 referer 을 확인할 수 있다.
		curl_setopt ($curlsession, CURLOPT_TIMEOUT, 120); // 해당 웹사이트가 오래걸릴수 있으므로 2분동안 타임아웃 대기
		$buffer = curl_exec ($curlsession);
		$cinfo = curl_getinfo($curlsession);
		curl_close($curlsession);

		if ($cinfo['http_code'] != 200){
			return $cinfo['http_code'];
		}

		$buffer = simplexml_load_string($buffer);
		return $buffer;
	}

	//new 버튼
	function new_icon($regdate, $imgsrc) {
		global $new_button_day_conf;
		list($_ymd,$_his) = explode(" ",$regdate);
		list($_year,$_month,$_day) = explode("-",$_ymd);
		list($_hour,$_min,$_sec) = explode(":",$_his);
		$_timestemp = mktime($_hour, $_min, $_sec, $_month, $_day, $_year);
		$_newdate = date("YmdHis",strtotime("+".$new_button_day_conf." day", $_timestemp));
		if($_newdate > date("YmdHis")) {
			$new_img_icon = $imgsrc;
		} else {
			$new_img_icon = "";
		}
		return $new_img_icon;
	}

	//시:분:초 = 초 변환
	function TimeSecondsFormat($time) {
		list($time_h, $time_m, $time_s) = explode(":", $time);
		$h_time = number_format($time_h);
		$m_time = number_format($time_m);
		$s_time = number_format($time_s);
		$h_sec = $h_time * 60 * 60;
		$m_sec = $m_time * 60;
		$seconds = $h_sec + $m_sec + $time_s;

		return $seconds;
	}


	function getTimeFormat($time) {
		$temp = $time;
		$dd=floor($temp/(3600*24));

		$temp=$temp%(3600*24);
		$hh=floor($temp/(60*60));

		$temp=$temp%(60*60);
		$ii=floor($temp/60);

		$temp=$temp%60;
		$ss=floor($temp);

		//일을 다시 시간으로 곱함
		$dd = $dd * 24;
		$hh = $dd + $hh;

		return sprintf('%02d', $hh).":".sprintf('%02d', $ii).":".sprintf('%02d', $ss);
	}


	function select_week($today_week)
	{
		switch ($today_week) {
			case 0:
			$today_week = "일";
			break;
			case 1:
			$today_week = "월";
			break;
			case 2:
			$today_week = "화";
			break;
			case 3:
			$today_week = "수";
			break;
			case 4:
			$today_week = "목";
			break;
			case 5:
			$today_week = "금";
			break;
			case 6:
			$today_week = "토";
			break;
		}
		return $today_week;
	}
?>
