
<script>
$(document).ready(function(){
	var action = 'click';
	var speed = "500";

	$('tr.q').on(action, function(){
		$(this).next().slideToggle(speed).siblings('tr.a').slideUp();
		/*
		var img = $(this).children('img');
		$('img').not(img).removeClass('rotate');
		img.toggleClass('rotate');
		*/
	});
});
</script>
<style>
tr.q {cursor:pointer;}
tr.a {display:none;}
</style>
              <table class="table table-hover" id="_table_">
			  <tbody>
                <tr>
                  <th nowrap width="10"><input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"></th>
                  <th nowrap width="20">No</td>
				<?if($cfg_cate_flag == "1") {?>
                  <th nowrap width="100">분류</td>
				<?}?>
                  <th nowrap>제목</th>
				<?if(!preg_match("/file/i", $cfg_item_close)) {?>
                  <th nowrap width="100">첨부파일</td>
				<?}?>
				<?if(!preg_match("/count/i", $cfg_item_close)) {?>
                  <th nowrap width="80">조회</td>
				<?}?>
				<?if(!preg_match("/writer/i", $cfg_item_close)) {?>
                  <th nowrap width="200">작성자</td>
				<?}?>
				<?if(!preg_match("/rdate/i", $cfg_item_close)) {?>
                  <th nowrap width="60">등록일</td>
				<?}?>
				<?if($SUPER_ULEVEL <= 2) {?>
                  <th nowrap width="120">관리</td>
				<?}?>
                </tr>

				<?
				$sql  ="select count(idx) as cnt from ".$initial."_bbs_".$_t." where idx is not null and notice_yn = '1' ";
				$sql .= $qry_where;

				$rs = mysql_query($sql, $dbconn) or die (mysql_error());
				$ntotal_no = 0;
				if($arr = mysql_fetch_array($rs)) {
					$ntotal_no		= $arr[cnt];
				}

				$n_query  = "select * ";
				$n_query .= " from ".$initial."_bbs_".$_t." where idx is not null and notice_yn ='1'";
				$n_query .= $qry_where;
				$n_query .= " order by regdate desc";

				$n_result = mysql_query($n_query, $dbconn) or die (mysql_error());
				if($ntotal_no != 0) {
					while ($n_array = mysql_fetch_array($n_result)) {
						$n_rot_num += 1;

						$n_idx			= stripslashes($n_array[idx]);
						$n_view_flag	= stripslashes($n_array[view_flag]);
						$n_category		= stripslashes($n_array[category]);
						$n_userid		= stripslashes($n_array[userid]);
						$n_username		= db2html($n_array[username]);
						$n_email		= stripslashes($n_array[email]);
						$n_homep		= stripslashes($n_array[homep]);
						$n_tel			= stripslashes($n_array[tel]);
						$n_title		= db2html($n_array[title]);
						$n_body			= db2html($n_array[body]);
						$n_regdate		= stripslashes($n_array[regdate]);
						$n_counts		= stripslashes($n_array[counts]);
						$n_thread		= stripslashes($n_array[thread]);
						$n_depth		= stripslashes($n_array[depth]);
						$n_pos			= stripslashes($n_array[pos]);
						$n_passwd		= stripslashes($n_array[passwd]);
						$n_user_file	= stripslashes($n_array[user_file]);
						$n_img_file		= stripslashes($n_array[img_file]);
						$n_user_ip		= stripslashes($n_array[user_ip]);
						$n_delflag		= stripslashes($n_array[delflag]);
						$n_is_secret	= stripslashes($n_array[is_secret]);
						$n_notice_yn	= stripslashes($n_array[notice_yn]);
						$n_site			= stripslashes($n_array[site]);
						$n_comment		= stripslashes($n_array[comment]);
						$n_counts_like	= stripslashes($n_array[counts_like]);
						$n_counts_bad	= stripslashes($n_array[counts_bad]);
						$n_tag			= stripslashes($n_array[tag]);
						$n_mailflag	 	= stripslashes($n_array[mailflag]);
						$n_smsflag	 	= stripslashes($n_array[smsflag]);
						$n_adminid	 	= stripslashes($n_array[adminid]);


						if($n_tel == "--") $n_tel = "";

						$n_subject = cut_string($n_title, 50, "..");
						//$subject = WShortString($title, 60);

						list($_ymd,$_his) = explode(" ",$n_regdate);
						list($_year,$_month,$_day) = explode("-",$_ymd);
						list($_hour,$_min,$_sec) = explode(":",$_his);

						$_timestemp = mktime($_hour, $_min, $_sec, $_month, $_day, $_year);
						$_newdate = date("YmdHis",strtotime("+2 day", $_timestemp));
						if($_newdate > date("YmdHis")) {
							$n_new_img = "<span class=\"pull-right-container\"><small class=\"label  label-danger\">new</small></span>";
						} else {
							$n_new_img = "";
						}

						if(substr($n_regdate,0,10) == date("Y-m-d")) $n_regdate = substr($n_regdate,11,5);
						else $n_regdate = substr($n_regdate,0,10);

						$n_sql="select count(idx) as cnt from ".$initial."_bbs_boardcomment where idx is not null and fid = '$n_idx' and tbl ='$_t'";
						$n_rs=mysql_query($n_sql, $dbconn) or die (mysql_error());
						if($n_arr = mysql_fetch_array($n_rs)) {
							$n_cnt		= $n_arr[cnt];
						}

						$n_sql= "select count(seq) as cnt from ".$initial."_data_files where seq is not null and fid = '$n_idx' and tbl ='$_t'";
						$n_sql .= " and data_type='file'";
						$n_rs = mysql_query($n_sql,$dbconn) or die (mysql_error());
						if($n_arr = mysql_fetch_array($n_rs)) {
							$n_file_cnt	= $n_arr[cnt];
						}


				?>
                <tr class="q">
                  <td nowrap class="chk"><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$n_idx?>" class="idxchk flat-red"></td>
                  <td nowrap class="notice">
					<span class="pull-right-container">
						<small class="label bg-green">공지</small>
					</span>
				  </td>

				<?if($cfg_cate_flag == "1") {?>
                  <td nowrap class="category">
					<?=getCodeNameDB($cfg_cate_code, $n_category,$dbconn)?>
				  </td>
				<?}?>
                  <td nowrap class="title">
					<small class="label <?=$view_flag=="1"?"label-primary":"label-warning"?>"><?=$arrViewFlag[$view_flag]?></small>
					<?if($n_img_file != "") {?>
					<img src="<?echo $foldername.$n_img_file;?>" width="80" align="left">
					<?}?>
					<?=$n_depth_str?> <span><?=$n_title?> <?=$n_new_img?></span>
					<?if($n_cnt > 0) {?>[<span style="font-size:0.9em;color:#cc3300;"><?=$n_cnt?></span>]<?}?>
				  </td>
				<?if(!preg_match("/file/i", $cfg_item_close)) {?>
                  <td nowrap class="download">
				  <?if($n_file_cnt) {?>
				  <i class="fa fa-paperclip"></i>
				  <?}?>
				  </td>
				<?}?>
				<?if(!preg_match("/count/i", $cfg_item_close)) {?>
                  <td nowrap class="counts"><?=$n_counts?></td>
				<?}?>
				<?if(!preg_match("/writer/i", $cfg_item_close)) {?>
                  <td nowrap class="username"><?=$n_username?><?if($SUPER_UID!="") {?>(<?=$n_userid?>)<?}?></td>
				<?}?>
				<?if(!preg_match("/rdate/i", $cfg_item_close)) {?>
                  <td nowrap class="date"><?=$n_regdate?></td>
				<?}?>
				<?if($SUPER_ULEVEL <= 2) {?>
                  <td nowrap class="admin">
				  <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$n_idx?>')" data-toggle="tooltip" data-container="body" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
				  <button type="button" class="btn btn-flat btn-xs btn-danger" onClick="go_delete('<?=$n_idx?>')" data-toggle="tooltip" data-container="body" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
				  </td>
				<?}?>
                </tr>
				<tr class="a">
					<td colspan="10"><?=$n_body?></td>
				</tr>
				<?
					}
				}
				//공지 게시물 끝
				?>


				<?
				if($total_no == 0 && $n_total_no == 0) {
				?>
                <tr>
                  <td align="center" colspan="10">등록된 정보가 없습니다.</td>
                </tr>
				<?
				} else {
					while ($array = mysql_fetch_array($result)) {
						$rot_num += 1;

						$idx			= stripslashes($array[idx]);
						$view_flag		= stripslashes($array[view_flag]);
						$category		= stripslashes($array[category]);
						$userid			= stripslashes($array[userid]);
						$username		= db2html($array[username]);
						$email			= stripslashes($array[email]);
						$homep			= stripslashes($array[homep]);
						$tel			= stripslashes($array[tel]);
						$title			= db2html($array[title]);
						$body			= db2html($array[body]);
						$regdate		= stripslashes($array[regdate]);
						$counts			= stripslashes($array[counts]);
						$thread			= stripslashes($array[thread]);
						$depth			= stripslashes($array[depth]);
						$pos			= stripslashes($array[pos]);
						$passwd			= stripslashes($array[passwd]);
						$user_file		= stripslashes($array[user_file]);
						$img_file		= stripslashes($array[img_file]);
						$user_ip		= stripslashes($array[user_ip]);
						$delflag		= stripslashes($array[delflag]);
						$is_secret		= stripslashes($array[is_secret]);
						$notice_yn		= stripslashes($array[notice_yn]);
						$site			= stripslashes($array[site]);
						$comment		= stripslashes($array[comment]);
						$counts_like	= stripslashes($array[counts_like]);
						$counts_bad		= stripslashes($array[counts_bad]);
						$tag			= stripslashes($array[tag]);
						$mailflag	 	= stripslashes($array[mailflag]);
						$smsflag	 	= stripslashes($array[smsflag]);
						$adminid	 	= stripslashes($array[adminid]);


						if($cfg_bbs_kind=="board") {
							// ---------  응답의 인덴트 -----------------
							if($depth > 0) {
								for($j = 2 ;$j <= $depth;$j++) {
								  $depth_str .= "&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								$depth_str .= "&nbsp;&nbsp;&nbsp;<i class=\"fa  fa-reply text-blue transform\"></i> ";
							}
						}

						$subject = cut_string($title, 50, "..");
						//$subject = WShortString($title, 60);

						list($_ymd,$_his) = explode(" ",$regdate);
						list($_year,$_month,$_day) = explode("-",$_ymd);
						list($_hour,$_min,$_sec) = explode(":",$_his);

						$_timestemp = mktime($_hour, $_min, $_sec, $_month, $_day, $_year);
						$_newdate = date("YmdHis",strtotime("+2 day", $_timestemp));
						if($_newdate > date("YmdHis")) {
							$new_img = "<span class=\"pull-right-container\"><small class=\"label  label-danger\">new</small></span>";
						} else {
							$new_img = "";
						}

						if(substr($regdate,0,10) == date("Y-m-d")) $regdate = substr($regdate,11,5);
						else $regdate = substr($regdate,0,10);

						$sql= "select count(idx) as cnt from ".$initial."_bbs_boardcomment where idx is not null and fid = '$idx' and tbl ='$_t'";
						$rs = mysql_query($sql,$dbconn) or die (mysql_error());
						if($arr = mysql_fetch_array($rs)) {
							$cnt	= $arr[cnt];
						}

						$sql= "select count(seq) as cnt from ".$initial."_data_files where seq is not null and fid = '$idx' and tbl ='$_t'";
						$sql .= " and data_type='file'";
						$rs = mysql_query($sql,$dbconn) or die (mysql_error());
						if($arr = mysql_fetch_array($rs)) {
							$file_cnt	= $arr[cnt];
						}

						if($is_secret == "1") $secret_img = "<i class=\"fa fa-lock text-blue\"></i> ";
						else $secret_img = "";
				?>
                <tr class="q">
                  <td nowrap class="chk"><input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$idx?>" class="idxchk flat-red"></td>
                  <td nowrap class="idx"><?=$idx?></td>

				<?if($cfg_cate_flag == "1") {?>
                  <td nowrap class="category">
					<?=getCodeNameDB($cfg_cate_code, $category, $dbconn)?>
				  </td>
				<?}?>
                  <td nowrap class="title">
					<small class="label <?=$view_flag=="1"?"label-primary":"label-warning"?>"><?=$arrViewFlag[$view_flag]?></small>
					<?if($img_file != "") {?>
					<img src="<?echo $foldername.$img_file;?>" width="80" align="left">
					<?}?>
					<?=$depth_str?> <?=$secret_img?><?=$title?>&nbsp;<?=$new_img?> <?if($cnt > 0) {?>[<span style="font-size:0.9em;color:#cc3300;"><?=$cnt?></span>]<?}?>
				  </td>
				<?if(!preg_match("/file/i", $cfg_item_close)) {?>
                  <td nowrap class="download">
				  <?if($file_cnt) {?>
				  <i class="fa fa-paperclip"></i>
				  <?}?>
				  </td>
				<?}?>
				<?if(!preg_match("/count/i", $cfg_item_close)) {?>
                  <td nowrap class="counts"><?=$counts?></td>
				<?}?>
				<?if(!preg_match("/writer/i", $cfg_item_close)) {?>
                  <td nowrap class="username"><?=$username?><?if($SUPER_UID!="") {?>(<?=$userid?>)<?}?></td>
				<?}?>
				<?if(!preg_match("/rdate/i", $cfg_item_close)) {?>
                  <td nowrap class="date"><?=$regdate?></td>
				<?}?>
				<?if($SUPER_ULEVEL <= 2) {?>
                  <td nowrap class="admin">
				  <button type="button" class="btn btn-flat btn-xs btn-warning" onClick="go_edit('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>
				  <button type="button" class="btn btn-flat btn-xs btn-danger" onClick="go_delete('<?=$idx?>')" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
				  </td>
				<?}?>
                </tr>
				<tr class="a">
					<td colspan="10"><?=$body?></td>
				</tr>
				<?
						$depth_str = "";
						$cur_num--;
					}
				}
				?>
				</tbody>
              </table>