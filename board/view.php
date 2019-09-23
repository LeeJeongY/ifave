<?

	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../modules/dbcon.php";
	include "../modules/config.php";
	include "../modules/func.php";
	include "../modules/func_q.php";
	//include "../modules/check.php";

	if($_t == "") $_t = "notice";

	//게시판 정보
	include "../modules/boardinfo.php";

	//게시판 상단 정보
	include "../modules/board/view.top.php";


	include "../".$lng."/inc/header.php";
?>

		<!-- container -->
		<div id="container">

			<section>
				<div class="comView">
					<div class="contentView">
						<div class="path">HOME > <?=ucfirst($cfg_bbs_id)?></div>
						<div class="viewBox">
							<div>
								<?
								//첨부이미지
								if($cfg_img_flag > 0) {
								?>
								<script language="javascript">
								$(document).ready(function() {
									//이미지 리사이즈
								    $('.thumbnail').each(function() {
										var maxWidth = 726;
										var maxHeight = 726;
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

								<p><?=convertHashtags($v_contents)?></p>

								<?
								//첨부파일
								if($cfg_file_flag > 0) {
									for($i=1;$i<=$cfg_file_flag;$i++) {

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
									<p>첨부파일 : <a href="../common/download.php?fl=<?=$download_foldername?>&fi=<?=$file_real_filename?>&fid=<?=$file_fid?>&s=<?=$file_seq?>&t=<?=$file_tbl?>"><?=$file_real_filename?></a></strong> <?=byteConvert($file_file_size)?></p>
									<?
										}
										$file_real_filename = "";
									}
								}
								?>
							</div>
						</div>
						<div class="btnArea">
							<a href="<?if($prev_idx=="") {?>javascript:;<?} else {?>javascript:location.href='?_t=<?=$_t?>&idx=<?=$prev_idx?>&page=<?=$page?>&search=<?=$search?>&search_text=<?=$search_text?>';<?}?>" class="btn-prev pa-left">< PREV</a>
							<a href="list.php?_t=<?=$_t?>&page=<?=$page?>" class="btn-list">LIST</a>
							<a href="<?if($next_idx=="") {?>javascript:;<?} else {?>javascript:location.href='?_t=<?=$_t?>&idx=<?=$next_idx?>&page=<?=$page?>&search=<?=$search?>&search_text=<?=$search_text?>';<?}?>" class="btn-next pa-right">NEXT ></a>
						</div>
					</div>
				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../".$lng."/inc/footer.php");
mysql_close($dbconn);
?>
