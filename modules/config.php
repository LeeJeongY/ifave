<?
//------------------------------------------------------------------------------
//        SYSTEM NAME			: REGISTER_GLOBALS OFF
//        SUBSYSTEM NAME		:
//        PROGRAM ID			: config.php
//        PROGRAM TYPE			: php script
//        PROGRAM NAME			: REGISTER_GLOBALS 변수 설정
//        PROGRAM 설명			: php.ini파일의 register_globals Off
//        작성일,작성자			:
//        수정일,수정자			:
//        수정일,수정자			:
//        수정내용				:
//        소유자				:
//        사용TABLE				: 없음
//------------------------------------------------------------------------------

if (isset($HTTP_SERVER_VARS))	$_SERVER = &$HTTP_SERVER_VARS;
if (isset($HTTP_GET_VARS))		$_GET = &$HTTP_GET_VARS;
if (isset($HTTP_POST_VARS))		$_POST = &$HTTP_POST_VARS;
if (isset($HTTP_COOKIE_VARS))	$_COOKIE = &$HTTP_COOKIE_VARS;
if (isset($HTTP_SESSION_VARS))	$_SESSION = &$HTTP_SESSION_VARS;
if (isset($HTTP_POST_FILES))	$_FILES = &$HTTP_POST_FILES;
if (isset($HTTP_ENV_VARS))		$_ENV = &$HTTP_ENV_VARS;
if (count($_GET))		extract($_GET);
if (count($_POST))		extract($_POST);
if (count($_SESSION))	extract($_SESSION);
if (count($_COOKIE))	extract($_COOKIE);
if (count($_ENV))		extract($_ENV);
$PHP_SELF		= $_SERVER["PHP_SELF"];
$HTTP_REFERER	= $_SERVER["HTTP_REFERER"];
$REMOTE_ADDR	= $_SERVER["REMOTE_ADDR"];
$SERVER_ADDR	= $_SERVER["SERVER_ADDR"];
$HTTP_HOST		= $_SERVER["HTTP_HOST"];
$REQUEST_URI	= $_SERVER["REQUEST_URI"];



// 언어 설정
if($_SESSION["lng"]=="")	$lng = "en";
if($_GET["lng"]=="ko")		$lng = "ko";
if($_GET["lng"]=="en")		$lng = "en";

$_SESSION['lng']			= $lng;


/***********************************************/
// 사이트 설정 start
/***********************************************/

//디비 초기 변수 설정
$initial = "fave";
//사이트 홈 주소
if($_SERVER["SERVER_NAME"] == "") $site_url = $_SERVER["HTTP_HOST"];
else $site_url = $_SERVER["SERVER_NAME"];
$site_url = "http://".$site_url;

/***********************************************/
// 사이트 설정 end
/***********************************************/

$remoteip = getenv("REMOTE_ADDR");

//관리자 이상 권한 _staff 테이블의 grade 필드 부분
$chk_level_num = 3;
$arrViewFlag = array("1" => "노출", "0" => "숨김", "" => "숨김");

$send_url = $site_url.$_SERVER["REQUEST_URI"];
$editor_dir = "/editor";

if($setting!="Y") {
	$cfg_site_query = "SELECT * FROM ".$initial."_site_config WHERE idx IS NOT NULL ";
	$cfg_site_query .= " ORDER BY idx DESC LIMIT 1";
	$cfg_site_result = mysql_query($cfg_site_query, $dbconn) or die (mysql_error());
	if($cfg_site_array = mysql_fetch_array($cfg_site_result)) {
		$site_idx                  	= $cfg_site_array[idx];
		$site_name               	= $cfg_site_array[site_name];
		$site_tel                	= $cfg_site_array[site_tel];
		$site_fax                	= $cfg_site_array[site_fax];
		$site_zipcode            	= $cfg_site_array[site_zipcode];
		$site_addr1              	= $cfg_site_array[site_addr1];
		$site_addr2              	= $cfg_site_array[site_addr2];
		$site_addr3              	= $cfg_site_array[site_addr3];
		$site_biznum             	= $cfg_site_array[site_biznum];
		$site_ceo                	= $cfg_site_array[site_ceo];
		$html_title              	= $cfg_site_array[html_title];
		$html_description        	= $cfg_site_array[html_description];
		$html_author             	= $cfg_site_array[html_author];
		$naver_site_verification 	= $cfg_site_array[naver_site_verification];
		$google_site_verification	= $cfg_site_array[google_site_verification];
		$admin_title             	= $cfg_site_array[admin_title];
		$admin_name              	= $cfg_site_array[admin_name];
		$admin_email             	= $cfg_site_array[admin_email];
		$admin_hp                	= $cfg_site_array[admin_hp];
		$image_logo              	= $cfg_site_array[image_logo];
		$admin_home_dir          	= $cfg_site_array[admin_home_dir];
		$upload_home_dir         	= $cfg_site_array[upload_home_dir];
		$new_button_day_conf     	= $cfg_site_array[new_button_day_conf];
		$data_go_kr_skey         	= $cfg_site_array[data_go_kr_skey];
		$naver_cid               	= $cfg_site_array[naver_cid];
		$naver_csecret           	= $cfg_site_array[naver_csecret];
		$daum_api_key            	= $cfg_site_array[daum_api_key];
		$sns_naverblog           	= $cfg_site_array[sns_naverblog];
		$sns_kakaotalk           	= $cfg_site_array[sns_kakaotalk];
		$sns_google              	= $cfg_site_array[sns_google];
		$sns_facebook            	= $cfg_site_array[sns_facebook];
		$sns_instagram            	= $cfg_site_array[sns_instagram];
		$sns_tweet               	= $cfg_site_array[sns_tweet];
		$contents                	= $cfg_site_array[contents];
		$regdate                 	= $cfg_site_array[regdate];
		$upddate                 	= $cfg_site_array[upddate];

		$root_url				= $admin_home_dir;
		$upload_dir				= $upload_home_dir;
		if($image_logo) $logo_img	= $site_url."/".$upload_dir."/site_config/".$image_logo;
		else $logo_img = "";
		$new_button_day_conf	= $new_button_day_conf;
		$serviceKey				= $data_go_kr_skey;
		$naver_cId				= $naver_cid;
		$naver_cSecret			= $naver_csecret;
		$daum_apiKey			= $daum_api_key;
	}
} else {

	//관리자 홈 주소
	$root_url = "/oops";
	$logo_img = $site_url."/images/inc/logo.png";
	$upload_dir = "datafiles";

	//NEW 버튼 노출 시간(일)
	$new_button_day_conf = 2;

	//공공데이터 서비스키 data.go.kr
	$serviceKey = "qKcHPUfKH6R6kwncOqbEg3eXfAk18Qv%2BPGWmqe9tuDF%2FVFwv%2FS7OsTGLmxZeC0R8anTfFzlrC9n1T1W6AzZNnw%3D%3D";

	//네이버 API KEY
	$naver_cId		= "fDxyj_lQ0vOcx1_TrcR9";
	$naver_cSecret	= "VpembjASXl";

	//다음 API KEY
	$daum_apiKey = "a9afceed5c925f868a90c7e63b8f00c9c1d74a2d";

	/***********************************************/
	// html header 설정 start
	/***********************************************/
	$html_title = "FAVE Smart Balance Trainer";
	$html_description = "";
	$html_author = "건강한 친구";

	$site_name = "STRONG FRIEND";
	$admin_title = "관리자 : $site_name";

	$admin_name = "FAVE";
	$admin_email = "kikli1@naver.com";
	//$admin_name = "박홍근";
	//$admin_email = "ghdrms@gmail.com";
	/***********************************************/
	// html header 설정 end
	/***********************************************/
}


//send mail
$company_email	= $admin_email;
$company_name	= $admin_name;


//배송비(쇼핑몰일 경우에 사용)
$fee_amount = 2500;
?>