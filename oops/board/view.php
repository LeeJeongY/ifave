<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	if($_t == "") $_t	= "qna"; 				//테이블 이름
	//게시판 정보
	include "../../modules/boardinfo.php";
	//파일경로
	$foldername  = "../../$upload_dir/$cfg_bbs_kind/$_t/";
	$download_foldername  = "../$upload_dir/$cfg_bbs_kind/$_t/";
	$regdate	= date("Y"."-"."m"."-"."d H:i:s");

	if ($gubun == "") {
		$gubun = "view";
	}

	if ($idx) {
		//조회수 증가
		if ($_USER_CLASS <= 10) {
			// max 구하기
			$query = "SELECT max(idx) FROM ".$initial."_bbs_boardcounts ";
			$result = mysql_query($query, $dbconn);
			$max_idx = mysql_result($result,0,0);
			if($max_idx < 0) {
				$max_idx = 1;
			} else {
				$max_idx = $max_idx+1;
			}

			$sql = "INSERT INTO ".$initial."_bbs_boardcounts (";
			$sql .= " idx";
			$sql .= ", fid";
			$sql .= ", tbl";
			$sql .= ", division";
			$sql .= ", userid";
			$sql .= ", remoteip";
			$sql .= ", regdate";
			$sql .= ") VALUES (";
			$sql .= " $max_idx";
			$sql .= ", '$idx'";
			$sql .= ", '$_t'";
			$sql .= ", 'counts'";
			$sql .= ", '$SUPER_UID'";
			$sql .= ", '$remoteip'";
			$sql .= ", '$regdate'";
			$sql .= ")";
			mysql_query($sql, $dbconn) or die (mysql_error());

			$query = "UPDATE ".$initial."_bbs_".$_t." SET counts=counts+1 WHERE idx = '$idx'";
			mysql_query($query, $dbconn);
		}

		//테이블에서 글을 가져옵니다.
		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$view_flag	= stripslashes($array[view_flag]);	// 뷰설정
			if($cfg_cate_flag == "1") $category	= stripslashes($array[category]);   // 카테고리
			$title		= db2html($array[title]);			// 글제목
			$counts		= stripslashes($array[counts]);		// 조회수
			$counts_like= stripslashes($array[counts_like]);// 좋아요
			$counts_bad	= stripslashes($array[counts_bad]);	// 나빠요
			$tag		= stripslashes($array[tag]);		// 태그
			$username	= db2html($array[username]);		// 작성자
			$userid		= stripslashes($array[userid]);		// 아이디
			$body		= stripslashes($array[body]);
			if($_t=="note" || $_t=="question") {
				$contents	= nE_db2html_v($body);
			} else {
				$contents	= db2html($body);
			}
			$regdate	= $array[regdate];					// 등록일
			$upddate	= $array[upddate];					// 수정일
			$site		= $array[site];

			if($cfg_bbs_type!="sns") {
				$dbpasswd	= stripslashes($array[passwd]);		// 비밀번호
				$org_idx	= stripslashes($array[org_idx]);	// 원문글번호
				$thread		= stripslashes($array[thread]);		// thread
				$depth		= stripslashes($array[depth]);		// depth
				$pos		= stripslashes($array[pos]);		// pos
				$user_file  = stripslashes($array[user_file]);
				$img_file	= stripslashes($array[img_file]);
				$is_secret	= stripslashes($array[is_secret]);   // 비밀글
				$tel		= stripslashes($array[tel]);		// 연락처
				$hp			= stripslashes($array[hp]);			// 휴대폰
				$email		= stripslashes($array[email]);		// mail
				$homep		= stripslashes($array[homep]);		// 홈페이지
				$murl		= stripslashes($array[murl]);		// 영상
				$notice_yn	= stripslashes($array[notice_yn]);	// 공지
			}
			//$regdate	= substr($regdate, 0, 10);
		}

		//원문 내용 불러오기
		if($org_idx > 0) {
			$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$org_idx'";
			$result = mysql_query($query, $dbconn) or die (mysql_error());
			if($array = mysql_fetch_array($result)) {
				$original_contents	= stripslashes($array[body]);
				$original_contents	= db2html($original_contents);
			}
		}


		if($_t=="note" || $_t == "question") {
			$course_id		= stripslashes($array[course_id]);
			$client_code	= stripslashes($array[client_code]);
			$train_id		= stripslashes($array[train_id]);
			$content_code	= stripslashes($array[content_code]);
			$con_id			= stripslashes($array[con_id]);
			$h_choi			= stripslashes($array[h_choi]);
			$h_page			= stripslashes($array[h_page]);
		}


		if($course_id) {
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
		}

	}

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>
<style type="text/css">
<?if(preg_match("/tag/i", $cfg_option_list)) {?>
.tag-editor {
    list-style-type: none; padding: 0 5px 0 0; margin: 0; overflow: hidden; cursor: text;
    font: normal 14px sans-serif; color: #555; background: #fff; line-height: 20px;
}
.tag-pointer {float:left;padding:0px 5px; margin:0px 5px; color: #46799b; background: #e0eaf1; white-space: nowrap;overflow: hidden; cursor: pointer; border-radius: 2px 0 0 2px;}
<?}?>
</style>

<!-- <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="//connect.facebook.net/ko_KR/sdk.js"></script> -->

<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="_t" value="<?=$_t?>" id="_t">
<input type="hidden" name="tag" id="tag" value="">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="s_site" value="<?=$s_site?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
<input type="hidden" name="menu_s" value="<?=$menu_s?>">
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup-":""?>content-wrapper">
    <!-- Content Header (Page header) -->

	<?
	include "../inc/navi_board.php";
	?>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->

		<!-- left column -->

		<div class="box box-info">
			<!-- <div class="box-header with-border">
			  <h3 class="box-title"><?=$notice_yn=="1"?"<span class=\"pull-right-container\"><small class=\"label bg-green\">공지</small> </span>":""?><?=$title?></h3>
			</div> -->
			<!-- /.box-header -->
			<!-- form start -->
			<form role="form" method="get" name="fm" id="fm">
			<input type="hidden" name="page" value='<?=$page?>'>
			<input type="hidden" name="idx" value='<?=$idx?>'>
			<input type="hidden" name="gubun" value='<?=$gubun?>'>
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="s_site" value="<?=$s_site?>">
			<input type="hidden" name="search" value='<?=$search?>'>
			<input type="hidden" name="search_text" value='<?=$search_text?>'>
			<input type="hidden" name="menu_b" value="<?=$menu_b?>">
			<input type="hidden" name="menu_m" value="<?=$menu_m?>">

			<!--
            <div class="box-header with-border">
              <h3 class="box-title"><?=$notice_yn=="1"?"<span class=\"pull-right-container\"><small class=\"label bg-green\">공지</small> </span>":""?>
				<?if($cfg_cate_flag == "1") {?>
					<?//구분?>
				[<?=getCodeNameDB($cfg_cate_code, $category, $dbconn)?>]
				<?}?>

				<?=$title?></h3>

              <div class="box-tools pull-right">
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
              </div>
            </div> -->
            <div class="box-body no-padding">
				<div class="viewbox-read-info">
					<h3><?=$notice_yn=="1"?"<span class=\"pull-right-container\"><small class=\"label bg-green\">공지</small> </span>":""?>

					<?if($cfg_cate_flag == "1") {?>
					<?//구분?>
					[<?=getCodeNameDB($cfg_cate_code, $category, $dbconn)?>]
					<?}?>

					<?=$title?></h3>
					<h5><?=$username?>(<a href="javascript:go_login('<?=$userid?>');" data-toggle="tooltip" data-container="body" title="'<?=$userid?>'님으로 로그인합니다"><?=$userid?></a>)
					<?if(preg_match("/email/i", $cfg_option_list)) {?>
						<?if($email) {?>
						<span class="pipeline">|</span><?=$email?>
						<?}?>
					<?}?>
					<span class="viewbox-read-time pull-right"><?=$counts?> <span class="pipeline">|</span> <?=$upddate=="0000-00-00 00:00:00"?$regdate:$upddate?></span></h5>

					<h5>
					<?if(preg_match("/secret/i", $cfg_option_list)) {?>
						<?if($is_secret=="1") {?>
						<!-- 비밀글 -->
						<?=$is_secret=="1"?"비밀글":""?>
						<?}?>
					<?}?>
					<?if(preg_match("/tel/i", $cfg_option_list)) {?>
						<?if($tel) {?>
						<!-- 전화번호 -->
						<span class="pipeline">|</span><?=$tel?>
						<?}?>
					<?}?>
					<?if(preg_match("/hp/i", $cfg_option_list)) {?>
						<?if($hp) {?>
						<!-- 휴대폰번호 -->
						<span class="pipeline">|</span><?=$hp?>
						<?}?>
					<?} else {?>
						<?if($hp) {?>
						<!-- 휴대폰번호 -->
						<span class="pipeline">|</span><?=$hp?>
						<?}?>
					<?}?>
					<span class="viewbox-read-time pull-right">
					<?if(preg_match("/homep/i", $cfg_option_list)) {?>
						<?if($homep) {?>
						<!-- 홈페이지 -->
						<p class="text-muted"><a href="<?=$homep?>" target="_blank"><?=$homep?></a></p>
						<?}?>
					<?}?>
					</h5>
				</div>
			</div>

			<div class="box-body">
			  <!-- <dl class="dl-horizontal">
				<dt>등록일</dt>
				<dd><?=$regdate?></dd>
				<dt>수정일</dt>
				<dd><?=$upddate?></dd>
			  </dl>-->
			  <!--
			  <ul class="list-group list-group-unbordered">
				<li class="list-group-item">
				  <b>등록일</b> <a class="pull-right"><?=$regdate?></a>
				</li>
				<li class="list-group-item">
				  <b>수정일</b> <a class="pull-right"><?=$upddate?></a>
				</li>
				<li class="list-group-item">
				  <b>조회수</b> <a class="pull-right"><?=$counts?></a>
				</li>
				<li class="list-group-item">
				  <b>작성자</b> <a class="pull-right"><?=$username?></a>
				</li>
			  </ul> -->


				<div class="form-group">
				  <label for="site">사이트 구분</label>
				  <div class="input-group">
				   <?if(preg_match("/ko/i", $site)) {?> <b class="label label-warning">국문</b> <?}?>
				   <?if(preg_match("/en/i", $site)) {?><br><b class="label label-success">영문</b> <?}?>
				  </div>
				</div>
			<?if($org_idx > 0) {?>
				<div class="form-group ">
				<strong> 원문글</strong>
				  <?=$original_contents?>
				</div>
			<?}?>
				<div class="form-group ">

				<?if(preg_match("/movie_url/i", $cfg_option_list)) {?>
					<?if($murl) {?>
					<div class="videowrapper">
					<p class="text-center">
					<iframe width="854" height="480" src="<?=$murl?>" frameborder="0" allowfullscreen></iframe>
					</p>

					</div>
					<p class="chat"><i class="fa fa-video-camera"></i> <a href="<?=$murl?>" target="_blank"><?=$murl?></a></p>
					<p>&nbsp;</p>
					<?}?>
				<?}?>
					<span class="contents_info" id="contents_html">
					<?if($course_subject) {?>
							<div style="padding:5px 0px 10px 0px;">
								<b style="font-size:1.2em;"><?=$course_subject?></b>
								<a href="javascript:fn_training('<?=$con_id?>','<?=$train_id?>', '<?=$con_flag?>','<?=$con_url?>');" style="background:#ff5f11;color:#fff;padding:5px 10px;border-radius: 10px;font-size:11px;">바로가기</a>
								<!-- <?=$h_choi?>차시 <?=$h_page?>page -->
							</div>
					<?}?>






					<?if($cfg_img_flag > 0) {
					?>
					<script language="javascript">
					$(document).ready(function() {
						//이미지 리사이즈
					    $('.thumbnail').each(function() {
							var maxWidth = 1100;
							var maxHeight = 1100;
							var ratio = 0;
							var width = $(this).width();
							var height = $(this).height();

						    if(width > maxWidth){
								ratio = maxWidth / width;
						        $(this).css("width", maxWidth);
						        $(this).css("height", height * ratio);
						        height = height * ratio;
						    }
							var width = $(this).width();
							var height = $(this).height();

						    if(height > maxHeight){
						        ratio = maxHeight / height;
						        $(this).css("height", maxHeight);
						        $(this).css("width", width * ratio);
						        width = width * ratio;
						    }
						});
					});
					</script>

					<?
						for($i=1;$i<=$cfg_img_flag;$i++) {
							$img_query = "select * from ".$initial."_data_files where seq is not null ";
							$img_query .= " and fid='".$idx."'";
							$img_query .= " and tbl='".$_t."'";
							$img_query .= " and num='".$i."'";
							$img_query .= " and data_type='img'";
							$img_query .= " order by num asc";
							$img_result = mysql_query($img_query,$dbconn) or die (mysql_error());
							if($img_array=mysql_fetch_array($img_result)) {
								$img_seq              = stripslashes($img_array[seq]);
								$img_fid              = stripslashes($img_array[fid]);
								$img_tbl              = stripslashes($img_array[tbl]);
								$img_userid           = stripslashes($img_array[userid]);
								$img_num              = stripslashes($img_array[num]);
								$img_real_filename    = stripslashes($img_array[real_filename]);
								$img_virtual_filename = stripslashes($img_array[virtual_filename]);
								$img_file_size        = stripslashes($img_array[file_size]);
								$img_file_type        = stripslashes($img_array[file_type]);
								$img_file_ext         = stripslashes($img_array[file_ext]);
								$img_remark           = stripslashes($img_array[remark]);
								$img_regdate          = stripslashes($img_array[regdate]);
								$img_upddate          = stripslashes($img_array[upddate]);
								$img_counts           = stripslashes($img_array[counts]);
							}

							if($img_real_filename!="") {
					?>
						<img src="<?=$foldername?><?=$img_real_filename?>" class="thumbnail">
					<?
							}
							$img_real_filename = "";
						}
					}
					?>














					  <?=convertHashtags($contents)?>
					</span>
				</div>

				<?if($tag) {

					$tag_array = explode(",",$tag);
					$tag_list = "";
					for($i=0;$i<count($tag_array);$i++) {
						$tag_list .= "<div class=\"tag-pointer\" onClick=\"go_tag('".$tag_array[$i]."')\">".$tag_array[$i]."</div>&nbsp;";
					}
				?>
				<div class="form-group ">
				<strong class="pull-left"> <i class="fa fa-tags"></i></strong> <div class="tag-editor"><?=$tag_list?></div>
				</div>
				<?}?>

			</div>
			<!-- /.box-body -->


            <div class="box-footer">

			<?if($cfg_img_flag > 0) {?>
              <ul class="mailbox-attachments clearfix">
				<?
				for($i=1;$i<=$cfg_img_flag;$i++) {
					$img_query = "select * from ".$initial."_data_files where seq is not null ";
					$img_query .= " and fid='".$idx."'";
					$img_query .= " and tbl='".$_t."'";
					$img_query .= " and num='".$i."'";
					$img_query .= " and data_type='img'";
					$img_query .= " order by num asc";
					$img_result = mysql_query($img_query,$dbconn) or die (mysql_error());
					if($img_array=mysql_fetch_array($img_result)) {
						$img_seq              = stripslashes($img_array[seq]);
						$img_fid              = stripslashes($img_array[fid]);
						$img_tbl              = stripslashes($img_array[tbl]);
						$img_userid           = stripslashes($img_array[userid]);
						$img_num              = stripslashes($img_array[num]);
						$img_real_filename    = stripslashes($img_array[real_filename]);
						$img_virtual_filename = stripslashes($img_array[virtual_filename]);
						$img_file_size        = stripslashes($img_array[file_size]);
						$img_file_type        = stripslashes($img_array[file_type]);
						$img_file_ext         = stripslashes($img_array[file_ext]);
						$img_remark           = stripslashes($img_array[remark]);
						$img_regdate          = stripslashes($img_array[regdate]);
						$img_upddate          = stripslashes($img_array[upddate]);
						$img_counts           = stripslashes($img_array[counts]);
					}

					if($img_real_filename!="") {
				?>
                <li>
				  <span class="mailbox-attachment-icon has-img"><img src="<?=$foldername?><?=$img_real_filename?>" alt="Attachment"></span>

				  <div class="mailbox-attachment-info">
					<a href="../../common/download.php?fl=<?=$download_foldername?>&fi=<?=$img_real_filename?>&fid=<?=$img_fid?>&s=<?=$img_seq?>&t=<?=$img_tbl?>" class="mailbox-attachment-name"><i class="fa fa-camera"></i> <?=$img_real_filename?></a>
						<span class="mailbox-attachment-size">
						  <?=byteConvert($img_file_size)?>
						  <a href="../../common/download.php?fl=<?=$download_foldername?>&fi=<?=$img_real_filename?>&fid=<?=$img_fid?>&s=<?=$img_seq?>&t=<?=$img_tbl?>" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
						</span>
				  </div>
				</li>
				<?
					}
					$img_real_filename = "";
				}
				?>
              </ul>
			<?}?>

			<?if($cfg_file_flag > 0) {?>
              <ul class="mailbox-attachments clearfix">
				<?for($i=1;$i<=$cfg_file_flag;$i++) {

					$file_query = "select * from ".$initial."_data_files where seq is not null ";
					$file_query .= " and fid='".$idx."'";
					$file_query .= " and tbl='".$_t."'";
					$file_query .= " and num='".$i."'";
					$file_query .= " and data_type='file'";
					$file_query .= " order by num asc";
					$file_result = mysql_query($file_query,$dbconn) or die (mysql_error());
					if($file_array=mysql_fetch_array($file_result)) {
						$file_seq              = stripslashes($file_array[seq]);
						$file_fid              = stripslashes($file_array[fid]);
						$file_tbl              = stripslashes($file_array[tbl]);
						$file_userid           = stripslashes($file_array[userid]);
						$file_num              = stripslashes($file_array[num]);
						$file_data_type        = stripslashes($file_array[data_type]);
						$file_data_base        = stripslashes($file_array[data_base]);
						$file_real_filename    = stripslashes($file_array[real_filename]);
						$file_virtual_filename = stripslashes($file_array[virtual_filename]);
						$file_file_size        = stripslashes($file_array[file_size]);
						$file_file_type        = stripslashes($file_array[file_type]);
						$file_file_ext         = stripslashes($file_array[file_ext]);
						$file_remark           = stripslashes($file_array[remark]);
						$file_regdate          = stripslashes($file_array[regdate]);
						$file_upddate          = stripslashes($file_array[upddate]);
						$file_counts           = stripslashes($file_array[counts]);

					}
					if($file_real_filename!="") {
				?>
                <li>
				  <span class="mailbox-attachment-icon"><i class="fa fa-file-<?=$file_file_ext?>-o"></i></span>

				  <div class="mailbox-attachment-info">
					<a href="../../common/download.php?fl=<?=$download_foldername?>&fi=<?=$file_real_filename?>&fid=<?=$file_fid?>&s=<?=$file_seq?>&t=<?=$file_tbl?>" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?=$file_real_filename?></a>
						<span class="mailbox-attachment-size">
						  <?=byteConvert($file_file_size)?>
						  <a href="../../common/download.php?fl=<?=$download_foldername?>&fi=<?=$file_real_filename?>&fid=<?=$file_fid?>&s=<?=$file_seq?>&t=<?=$file_tbl?>" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
						</span>
				  </div>
				</li>
				<?
					}
					$file_real_filename = "";
				}
				?>
              </ul>
			<?}?>
			</div>
			<!-- /.box-body -->

			<div class="box-body text-center">
				<?if($cfg_share_media!="") {?>
					<!-- <a class="btn btn-app" href="javascript:fn_share('<?=$idx?>');">
					<i class="fa fa-share"></i> <span id="canvas<?=$idx?>">공유</span>
					</a> -->
				<?}?>

				<?if(preg_match("/like/i", $cfg_skill_list)) {?>
				<a type="text" class="btn btn-app" href="javascript:go_counter('like','<?=$idx?>');">
                <span class="badge bg-red" id="like_<?=$idx?>"><?=$counts_like?></span>
				<i class="fa fa-thumbs-o-up"></i> 좋아요
				</a>
				<!-- <a class="btn btn-app">
				<span class="badge bg-red">531</span>
				<i class="fa fa-heart-o"></i> 좋아요
				</a> -->
				<?}?>
				<?if(preg_match("/bad/i", $cfg_skill_list)) {?>
				<a type="text" class="btn btn-app" href="javascript:go_counter('bad','<?=$idx?>');">
                <span class="badge bg-yellow" id="bad_<?=$idx?>"><?=$counts_bad?></span>
				<i class="fa fa-thumbs-o-down"></i> 나빠요
				</a>
				<?}?>

			</div>
			<!-- /.box-body -->


			<?if($cfg_share_media!="") {?>
			<!-- 공유 버튼 -->
			<?//=$send_url?>
			<div class="box-body text-center">
				<a href="javascript:fn_sendSns('facebook', '<?=$send_url?>', 'sdsdd')"><img src="../dist/img/sns/_facebook.png" data-toggle="tooltip" data-container="body" title="페이스북"></a>
				<a href="javascript:fn_sendSns('twitter', '<?=$send_url?>', 'sdsdd')"><img src="../dist/img/sns/_twitter.png" data-toggle="tooltip" data-container="body" title="트위트"></a>
				<a href="javascript:fn_sendSns('googleplus', '<?=$send_url?>', 'sdsdd')"><img src="../dist/img/sns/_gplus.png" data-toggle="tooltip" data-container="body" title="구글+"></a>
				<a href="javascript:fn_sendSns('kakaostory', '<?=$send_url?>', 'sdsdd')"><img src="../dist/img/sns/_kaostory.png" data-toggle="tooltip" data-container="body" title="카카오스토리"></a>
				<a href="javascript:fn_sendSns('band', '<?=$send_url?>', 'sdsdd')"><img src="../dist/img/sns/_band.png" data-toggle="tooltip" data-container="body" title="네이버 밴드"></a>
				<a href="javascript:fn_sendSns('naver', '<?=$send_url?>', 'sdsdd')"><img src="../dist/img/sns/_naver_blog.png" data-toggle="tooltip" data-container="body" title="블로그"></a>


				<!--
				<a href="#" onclick="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(document.URL)+'&t='+encodeURIComponent(document.title),'facebooksharedialog',
'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" alt="Share on Facebook" ><img src="../dist/img/sns/_facebook.png" data-toggle="tooltip" data-container="body" title="페이스북"></a>
				<a href="#" onclick="javascript:window.open('https://twitter.com/intent/tweet?text=[%EA%B3%B5%EC%9C%A0]%20'
+encodeURIComponent(document.URL)+'%20-%20'+encodeURIComponent(document.title), 'twittersharedialog','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" alt="Share on Twitter"><img src="../dist/img/sns/_twitter.png" data-toggle="tooltip" data-container="body" title="트위트"></a>
				<a href="#" onclick="javascript:window.open('https://plus.google.com/share?url='+encodeURIComponent(document.URL),'googleplussharedialog','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=600');return false;" target="_blank" alt="Share on Google+"><img src="../dist/img/sns/_gplus.png" data-toggle="tooltip" data-container="body" title="구글+"></a>
				<a href="#" onclick="javascript:window.open('https://story.kakao.com/s/share?url='+encodeURIComponent(document.URL), 'kakaostorysharedialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;" target="_blank" alt="Share on kakaostory"><img src="../dist/img/sns/_kaostory.png" data-toggle="tooltip" data-container="body" title="카카오스토리"></a>
				<img src="../dist/img/sns/_band.png" data-toggle="tooltip" data-container="body" title="네이버 밴드">
				<a href="#" onclick="javascript:window.open('http://share.naver.com/web/shareView.nhn?url='+encodeURIComponent(document.URL)+'&title='+encodeURIComponent(document.title),'naversharedialog','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" alt="Share on Naver" ><img src="../dist/img/sns/_naver_blog.png" data-toggle="tooltip" data-container="body" title="블로그"></a> -->
			</div>
			<?}?>


			<div class="box-footer">
				<div class="btn-group">
					<a type="text" class="btn btn-default" href="javascript:go_list();">목록</a>
					<a type="text" class="btn btn-warning" href="javascript:go_write();">새글</a>
				</div>
				<div class="btn-group pull-right">
				<?if($notice_yn!="1") {?>
				<?if(preg_match("/board/i", $cfg_bbs_kind)) {?>
				<a type="text" class="btn btn-success" href="javascript:go_reply('<?=$idx?>');">답글</a>
				<?}?>
				<?}?>
				<a type="text" class="btn btn-warning" href="javascript:go_edit('<?=$idx?>');">수정</a>
				<a type="text" class="btn btn-danger " href="javascript:go_delete('<?=$idx?>');">삭제</a>
				</div>
			</div>
			</form>



		</div>
		<!-- /.box -->


	<?if(preg_match("/comment/i", $cfg_skill_list)) {?>

		<?
		include "../common/board_comment.php";
		?>

	<?}?>




    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?
include "../inc/footer.php";
mysql_close($dbconn);
?>