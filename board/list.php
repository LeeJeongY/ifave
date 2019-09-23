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
	include "../modules/board/list.top.php";


	include "../".$lng."/inc/header.php";

	if($cfg_bbs_type=="faq") {
?>


<script>
$(document).ready(function(){
	var action = 'click';
	var speed = "500";

	$('li.q').on(action, function(){
		$(this).next().slideToggle(speed).siblings('li.a').slideUp();
		/*
		var img = $(this).children('img');
		$('img').not(img).removeClass('rotate');
		img.toggleClass('rotate');
		*/
	});
});
</script>
<?
	}
?>
		<!-- container -->
		<div id="container">

			<section>
				<div class="comList">
					<div class="content">
						<h2><?=$cfg_bbs_id=="notice"?ucfirst($cfg_bbs_id):strtoupper($cfg_bbs_id)?></h2>
						<?
							if($cfg_bbs_type=="image")	$ul_css = "prList cfx";
							if($cfg_bbs_type=="list")	$ul_css = "bd-list";
							if($cfg_bbs_type=="faq")	$ul_css = "faq";
						?>
						<ul class="<?=$ul_css?>">

				<?
				//$total_no = 0;
				if($total_no == 0) {
				?>
							<li>
								<div class="c-num"></div>
								<div class="c-text">
									<p class="notice_p" style="text-align:center;">
										<strong>
										<?if($lng=="ko") {?>
										정보가 존재하지 않습니다.
										<?} else {?>
										No posts found
										<?}?>
										
										</strong>
									</p>
								</div>
								<div class="c-date"></div>
							</li>
				<?
				} else {
					while ($array = mysql_fetch_array($result)) {

						//게시판 리스트 정보
						include "../modules/board/list.array.php";

						if($cfg_bbs_type=="faq") {

							?>

							<li class="q">
								<span class="cateText qna-q">Q</span>
								<span class="ico_q"><?=$subject?></span>
							</li>
							<li class="a">
								<span class="cateText qna-a">A</span>
								<span class="ico_a"><?=$contents?></span>
							</li>
					<?
						} else if($cfg_bbs_type=="image") {

							$subject = cut_string($title, 40, "..");
							$contents	= cut_string($contents,50, "..");
					?>
							<li>
								<a href="view.php?idx=<?=$idx?>&_t=<?=$_t?>&page=<?=$page?>">
									<img src="<?=$foldername?><?=$img_real_filename?>">
									<div>
										<h4><?=$subject?></h4>
										<p><?=$contents?></p>
										<div class="heart">
											<span><?=number_format($counts)?></span> view
										</div>
									</div>
								</a>
							</li>

					<?
						} else {
							$contents	= cut_string($contents,250, "..");
					?>
							<li>
								<div class="c-num"><?=$idx?></div>
								<a href="view.php?idx=<?=$idx?>&_t=<?=$_t?>&page=<?=$page?>">
								<div class="c-text">
									<p class="notice_p">
										<strong><?=$subject?></strong>
										<?if($contents) {?>
										<span><?=$contents?></span>
										<?}?>
									</p>
								</div>
								</a>
								<div class="c-date"><?=str_replace("-",". ",substr($regdate,0,10))?></div>
							</li>
					<?
						}
						$depth_str = "";
						$cur_num--;
					}
				}
				?>
						</ul>

						<div class="paging">
							<!-- <strong>1</strong><a href="#">2</a> -->
							<?=fn_page_user($total_page, $page_num, $page, $link_url)?>
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
