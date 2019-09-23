
            <div class="box-body">
				<div class="pad-lr-15">
					  <div class="checkbox">
						<label style="font-size:12px;">
						<input type="checkbox" name="chkall" id="chkall" value="chkall" class="flat-red"> 선택
						</label>
					  </div>
				</div>
				<?
				if($total_no == 0) {
				?>
				<div class="attachment-block clearfix">

					<div class="attachment-pushed">

						<div class="attachment-text text-center" style="font-size:12px;">
						등록된 정보가 없습니다.
						</div>
						<!-- /.attachment-text -->
					</div>
				<!-- /.attachment-pushed -->
				</div>
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
						$body			= stripslashes($array[body]);
						if($_t=="note" || $_t=="question") {
							$contents	= nE_db2html_v($body);
						} else {
							$contents	= db2html($body);
						}
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


						if($_t=="note" || $_t == "question") {
							$course_id		= stripslashes($array[course_id]);
							$client_code	= stripslashes($array[client_code]);
							$train_id		= stripslashes($array[train_id]);
							$content_code	= stripslashes($array[content_code]);
							$con_id			= stripslashes($array[con_id]);
							$h_choi			= stripslashes($array[h_choi]);
							$h_page			= stripslashes($array[h_page]);
						}


						if($cfg_bbs_kind=="board") {
							// ---------  응답의 인덴트 -----------------
							if($depth > 0) {
								for($j = 2 ;$j <= $depth;$j++) {
								  $depth_str .= "&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								$depth_str .= "&nbsp;&nbsp;&nbsp;<i class=\"fa  fa-reply transform\"></i> ";
							}
						}

						$subject	= cut_string($title, 50, "..");


						if($_t=="note" || $_t == "question") {
						} else {
							$contents	= strip_tags($body);
							$contents_length = strlen($contents);
							$contents	= cut_string($contents,300, "..");
							$contents	= convertHashtags($contents);
						}
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

						//댓글수
						$sql= "select count(idx) as cnt from ".$initial."_bbs_boardcomment where idx is not null and fid = '$idx' and tbl ='$_t'";
						$rs = mysql_query($sql,$dbconn) or die (mysql_error());
						if($arr = mysql_fetch_array($rs)) {
							$cnt	= $arr[cnt];
						}

						//이미지정보
						$sql= "select * from ".$initial."_data_files where seq is not null and fid = '$idx' and tbl ='$_t'";
						$sql .= " and data_type='img'";
						$sql .= " and num='1'";
						$rs = mysql_query($sql,$dbconn) or die (mysql_error());
						if($arr = mysql_fetch_array($rs)) {
							$img_real_filename	= $arr[real_filename];
							$img_file_size      = stripslashes($arr[file_size]);
							$img_file_type      = stripslashes($arr[file_type]);
							$img_file_ext       = stripslashes($arr[file_ext]);
						}

						//본문내용중 이미지 추출
						$body = str_replace("/$upload_dir", $image_site_url."/$upload_dir", $body);
						$_img = getImageContent($body);
						$_img_count = count($_img);
						for ($i=0; $i<$_img_count; $i++) {
							//echo $_img[$i][0]."<br>"; // 파일명
							//echo $_img[$i][1]."<P>"; // 파일명을 뺀 URL 명

							$_img_ = $_img[$i][1].$_img[$i][0];
						}

						//태그
						if($tag) {
							$tag_array = explode(",",$tag);
							$tag_list = "";
							for($i=0;$i<count($tag_array);$i++) {
								$tag_list .= "<div class=\"tag-pointer\" onClick=\"go_tag('".$tag_array[$i]."')\">".$tag_array[$i]."</div>&nbsp;";
							}
						}


						$courseQue = "SELECT bcode, mcode, content_code, subject, coach_name  FROM ".$initial."_edu_course WHERE idx IS NOT NULL " ;
						$courseQue .= " AND idx = '".$course_id."'";
						$courseRs = mysql_query($courseQue,$dbconn);
						if($courseArr=mysql_fetch_array($courseRs)) {
							$bcode = $courseArr[bcode];
							$mcode = $courseArr[mcode];
							$content_code	= $courseArr[content_code];
							$course_subject	= $courseArr[subject];
							$coach_name		= $courseArr[coach_name];


							$conQuery  = "select * ";
							$conQuery .= " from ".$initial."_edu_content where con_idx is not null ";
							$conQuery .= " and con_idx='".$con_id."'";
							//$conQuery .= " order by CAST(con_chaci as signed) asc, CAST(con_page as signed) asc";
							$conResult = mysql_query($conQuery, $dbconn) or die (mysql_error());
							if($conArray = mysql_fetch_assoc($conResult)) {
								$con_flag	= $conArray[con_flag];
								$con_url	= $conArray[con_url];
							}
						}


				?>
				<div class="box-body" style="font-size:12px;">
					<div class="sns-block clearfix">
					<?if($img_real_filename!="") {?>
						<a href="javascript:go_view('<?=$idx?>');"><img class="sns-img" src="<?=$foldername?><?=$img_real_filename?>" alt="<?=$img_real_filename?>"></a>
					<?} else {?>
						<?if($_img_count>0) {?>
						<a href="javascript:go_view('<?=$idx?>');"><img class="sns-img" src="<?=$_img[0][1].$_img[0][0]?>" alt="<?=$img_real_filename?>"></a>
						<?}?>
					<?}?>

						<div class="sns-pushed">
							<div style="padding:5px 0px 10px 0px;">
								<b style="font-size:1.2em;"><?=$course_subject?></b>
								<a href="javascript:fn_training('<?=$con_id?>','<?=$train_id?>', '<?=$con_flag?>','<?=$con_url?>');" style="background:#ff5f11;color:#fff;padding:5px 10px;border-radius: 10px;font-size:11px;">바로가기</a>
								<!-- <?=$h_choi?>차시 <?=$h_page?>page -->
							</div>
							<div class="sns-text" onClick="go_view('<?=$idx?>');" style="cursor:pointer;">
							<?=$contents?><?if($contents_length>200) {?> <a href="javascript:go_view('<?=$idx?>');">더 보기</a><?}?>
							</div>

							<!-- /.attachment-text -->
						</div>
						<div class="tag-editor">
						<?if(preg_match("/tag/i", $cfg_option_list)) {?>
							<?=$tag_list?>
						<?}?>


							<div class="pull-right text-muted">
							<?if($_t == "question") {?>
							<button onClick="go_view('<?=$idx?>');" type="button" class="btn btn-flat btn-xs btn-primary" data-toggle="tooltip" data-container="body" title="답변"><i class="fa  fa-reply"></i></button>
							<?}?>

							<button onClick="go_edit('<?=$idx?>');" type="button" class="btn btn-flat btn-xs btn-warning" data-toggle="tooltip" data-container="body" title="수정"><i class="fa fa-edit"></i></button>

							<button onClick="go_delete('<?=$idx?>');" type="button" class="btn btn-flat btn-xs btn-danger" data-toggle="tooltip" data-container="body" title="삭제"><i class="fa fa-trash-o"></i></button>
							</div>
						</div>
					<!-- /.attachment-pushed -->
					</div>
					<!-- Social sharing buttons -->
					<div >
					<input type="checkbox" name="idxchk[]" id="idxchk" value="<?=$idx?>" class="idxchk flat-red">
					<small class="label <?=$view_flag=="1"?"label-primary":"label-warning"?>"><?=$arrViewFlag[$view_flag]?></small>
					<span> <i class="fa fa-user"></i> <?=$username?>(<a href="javascript:go_login('<?=$userid?>');" data-toggle="tooltip" data-container="body" title="'<?=$userid?>'님으로 로그인합니다"><?=$userid?></a>)</span>
					<span> <i class="fa fa-calendar"></i> <?=$array[regdate]?></span>

				<?if($cfg_share_media!="") {?>
					<a href="javascript:fn_share('<?=$idx?>');" class="btn btn-default btn-xs"><i class="fa fa-share"></i> <span  id="canvas<?=$idx?>">공유</span></a>
				<?}?>
				<?if(preg_match("/like/i", $cfg_skill_list)) {?>
					<button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> 좋아요</button>
				<?}?>
					<span class="pull-right text-muted"><?if(preg_match("/like/i", $cfg_skill_list)) {?><span class="badge bg-navy" id="like_<?=$idx?>"><i class="fa fa-heart"></i> <?=$counts_like?></span> <?}?><span class="badge bg-navy"><i class="fa fa-comments"></i> <?=$cnt?></span> </span>
					</div>
				</div>
				<?
						$depth_str = "";
						$tag_list = "";
						$cur_num--;
					}
				}
				?>
				</ul>
              </div>