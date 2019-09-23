<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	set_time_limit(0);

	$today=date('Ymd');
	$file_name="회원목록_".$today.".xls"; //저장할 파일이름

	header( "Content-type: application/vnd.ms-excel;charset=utf-8");
	header( "Content-Disposition: attachment; filename=$file_name" );
	header( "Content-Description: PHP4 Generated Data" );
	//print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");




	if($_t=="") $_t	= "members"; 				//테이블 이름
	$foldername = "../../$upload_dir/$_t/";

	$rot_num = 0;


	if ($search_text != "") {
		$search_text   = trim(stripslashes(addslashes($search_text)));
		if($search == "all") {
			$qry_where .= " AND (user_name like '%$search_text%' OR user_id like '%$search_text%' OR user_hp like '%$search_text%' OR user_email like '%$search_text%' OR client_name like '%$search_text%')";
		} else {
			$qry_where .= " AND $search like '%$search_text%'";
		}
	}

	if($s_regdate) {
		list($start_date, $end_date) = explode("-",trim($s_regdate));
		$start_date = str_replace("/","",trim($start_date));
		$end_date = str_replace("/","",trim($end_date));

		$qry_where .= " AND replace(left(regdate,10),'-','')>='".$start_date."' ";
		$qry_where .= " AND replace(left(regdate,10),'-','')<='".$end_date."' ";
	}

	if($client_code)	$qry_where .= " AND client_code  = '".$client_code."' ";
	if($s_user_state)	$qry_where .= " AND user_state  = '".$s_user_state."' ";
	if($s_email_flag)	$qry_where .= " AND email_flag  = '".$s_email_flag."' ";
	if($s_sms_flag)		$qry_where .= " AND sms_flag  = '".$s_sms_flag."' ";

	$query  ="SELECT count(idx) as cnt FROM ".$initial."_".$_t." WHERE idx IS NOT NULL ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array=mysql_fetch_array($result)) {
		$total_no		= $array[cnt];
	}

	$query  = "SELECT * FROM ".$initial."_".$_t." WHERE idx IS NOT NULL ";
	$query .= $qry_where;
	$query .= " ORDER BY regdate DESC";
	//echo $query;
	$result = mysql_query($query, $dbconn) or die (mysql_error());


	include "../inc/header_excel.php";
?>
              <table width="100%" border="1">
                <tr>
                  <th nowrap width="20">No</th>
                  <th nowrap width="80">구분</th>
                  <th nowrap width="100">회원명</th>
                  <th nowrap width="100">아이디</th>
                  <th nowrap width="100">회원코드</th>
                  <th nowrap width="100">소속회사코드</th>
                  <th nowrap width="100">소속회사명</th>
                  <th nowrap width="120">최근 로그인</th>
                  <th nowrap width="100">휴대폰</th>
                  <th nowrap width="120">이메일</th>
                  <th nowrap width="100">생년월일</th>
                  <th nowrap width="100">양/음</th>
                  <th nowrap width="100">성별</th>
                  <th nowrap width="100">이메일수신여부</th>
                  <th nowrap width="100">문자수신여부</th>
                  <th nowrap width="100">권한</th>
                  <th nowrap width="100">가입일</th>
                  <th nowrap width="100">수정일</th>
                </tr>
				<?
				if($total_no == 0) {
				?>
                <tr>
                  <td align="center" colspan="20">등록된 정보가 없습니다.</td>
                </tr>
				<?
				} else {
					while ($array = mysql_fetch_assoc($result)) {
						$rot_num += 1;

						foreach ($array as $tmpKey => $tmpValue) {

							$$tmpKey = $tmpValue;
						}// end foreach

						$active_flag	= $array[active_flag];

						//제목자르기
						//$subject = cut_string($subject,42);
						//$subject = getNewicon2($subject,$regdate,$link);
				?>
                <tr>
                  <td><?=$rot_num?></td>
                  <td>
				   <?if(preg_match("/on/i", $site_kind)) {?>온라인<?}?>
				   <?if(preg_match("/off/i", $site_kind)) {?>오프라인<?}?>
				  </td>
				  <td><?=$user_name?></td>
				  <td><?=$user_id?></td>
				  <td><?=$user_code?></td>
				  <td><?=$client_code?></td>
				  <td><?=$client_name?></td>
				  <td><?=$last_login?></td>
				  <td><?=$user_hp?></td>
				  <td><?=$user_email?></td>
				  <td><?=$user_birth?></td>
				  <td><?=$user_calendar=="solar"?"양력":"음력"?></td>
				  <td><?=$user_sex=="M"?"남":"여"?></td>
				  <td><?=$email_flag=="Y"?"허용":"거부"?></td>
				  <td><?=$sms_flag=="Y"?"허용":"거부"?></td>
				  <td>
				  <?=$user_state=="1"?"승인":""?>
				  <?=$user_state=="2"?"신청":""?>
				  <?=$user_state=="0"?"해지":""?>
				  </td>
				  <td><?=$regdate?></td>
				  <td><?=$udtdate?></td>
                </tr>
				<?
						$cur_num --;
					}
				}
				?>
              </table>
<?
include "../inc/footer_excel.php";
mysql_close($dbconn);
?>