<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";


	//게시판 목록보기에 필요한 각종 변수 초기값을 설정합니다.
	if($_t == "") $_t	= "qna"; 				//테이블 이름
	//게시판 정보
	include "../../modules/boardinfo.php";
	//파일경로
	$foldername  = "../../$upload_dir/$cfg_bbs_kind/$_t/";
	$download_foldername  = "../$upload_dir/$cfg_bbs_kind/$_t/";

	if ($gubun == "") {
		$gubun = "insert";
	}

	if ($idx) {
		//테이블에서 글을 가져옵니다.
		$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx = '$idx'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$array = mysql_fetch_array($result);


		if($cfg_cate_flag == "1") $category	= stripslashes($array[category]);   // 카테고리
		$title		= db2html($array[title]);					// 글제목
		$dbpasswd	= stripslashes($array[passwd]);				//비밀번호
		if($gubun == "reply") {
			$userid		= stripslashes($array[userid]);			// userid
			$recvid		= stripslashes($array[userid]);			// userid
			$thread		= stripslashes($array[thread]);			// thread
			$l_depth	= stripslashes($array[depth]);			// depth
			$pos		= stripslashes($array[pos]);			// pos
			$recvname	= stripslashes($array[username]);		// username
			$is_secret	= stripslashes($array[is_secret]);		// 비밀

			$depth		= $l_depth + 1;
			$que2="select count(idx) from ".$initial."_bbs_".$_t." where thread=$thread and depth > $l_depth" ;
			$result2=mysql_query($que2, $dbconn);
			if($array2=mysql_fetch_array($result2)) {
				$plus_pos		= $array2[cnt];
			}
			$pos = $pos + $plus_pos + 1 ;


			if($is_secret == "1") $passwd		= stripslashes($array[passwd]);		// password
			$body_prev		= stripslashes($array[body]);
			$body_prev		= db2html($body_prev);
			if($_USER_CLASS!="10") {
				$adminid	= stripslashes($array[adminid]);		// 관리자id
			}

			//$userid = $SUPER_UID;
			$adminid		= $SUPER_UID;
			$username = $SUPER_UNAME;

		}

		if($gubun == "update") {
			$view_flag	= stripslashes($array[view_flag]);	// 뷰설정
			$thread		= stripslashes($array[thread]);		// thread
			$depth		= stripslashes($array[depth]);		// depth
			$pos		= stripslashes($array[pos]);		// pos
			$user_file  = stripslashes($array[user_file]);
			$img_file	= stripslashes($array[img_file]);
			$counts		= stripslashes($array[counts]);		// 조회수
			$username	= db2html($array[username]);		// name
			$is_secret	= stripslashes($array[is_secret]);	// 비밀
			$tel		= stripslashes($array[tel]);		// tel
			$hp			= stripslashes($array[hp]);			// hp
			list($tel1,$tel2,$tel3) = explode("-",$tel);
			list($hp1,$hp2,$hp3) = explode("-",$hp);
			$email		= stripslashes($array[email]);		// mail
			$homep		= stripslashes($array[homep]);		// 홈페이지
			$murl		= stripslashes($array[murl]);		// 영상주소
			$tag		= stripslashes($array[tag]);		// 태그
			$regdate	= $array[regdate];					// 등록일
			$body		= stripslashes($array[body]);
			$contents	= db2html($body);
			$notice_yn		= stripslashes($array[notice_yn]);
			$site		= stripslashes($array[site]);

		}


	} else {
		$userid		= $SUPER_UID;
		$username	= $SUPER_UNAME;
		$email		= $SUPER_UEMAIL;
		$category	= "01";
		$view_flag = "1";
		if($s_site=="") $s_site = "ko";
		$site		= $s_site;
	}

	include "../inc/header.php";
	//스크립트
	include "../js/goto_page.js.php";
?>

<?if(preg_match("/tag/i", $cfg_option_list)) {?>
<link rel="stylesheet" href="../js/tags/jquery.tag-editor.css">
<?}?>

<script language="javascript">
<!--
//-->
</script>

<form name="form">
<input type="hidden" name="idx">
<input type="hidden" name="gubun">
<input type="hidden" name="_t" value="<?=$_t?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="s_site" value="<?=$s_site?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
<input type="hidden" name="menu_b" value="<?=$menu_b?>">
<input type="hidden" name="menu_m" value="<?=$menu_m?>">
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

		<div class="row">
		<!-- left column -->

			<!-- <div class="col-md-6">
			</div>

	        <div class="col-md-6">
			</div>
			-->

			<div class="col-md-12">


			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title">Form</h3>
				</div>
				<!-- /.box-header -->

				<!-- form start -->
				<form role="form" method="post" action="write_ok.php" name="fm" id="fm" enctype="multipart/form-data">
				<input type="hidden" name="_t" value="<?=$_t?>">
				<input type="hidden" name="idx" value='<?=$idx?>'>
				<input type="hidden" name="org_idx" value='<?=$idx?>'>
				<input type="hidden" name="gubun" value='<?=$gubun?>'>
				<input type="hidden" name="popup" value="<?=$popup?>">
				<input type="hidden" name="pos" value="<?=$pos?>">
				<input type="hidden" name="depth" value="<?=$depth?>">
				<input type="hidden" name="thread" value="<?=$thread?>">
				<input type="hidden" name="userid" value="<?=$userid?>">
				<input type="hidden" name="adminid" value="<?=$adminid?>">
				<input type="hidden" name="page" value='<?=$page?>'>
				<input type="hidden" name="search" value='<?=$search?>'>
				<input type="hidden" name="search_text" value='<?=$search_text?>'>
				<input type="hidden" name="menu_b" value="<?=$menu_b?>">
				<input type="hidden" name="menu_m" value="<?=$menu_m?>">
				<input type="hidden" name="menu_s" value="<?=$menu_s?>">
				<div class="box-body">

					<div class="form-group">
					  <label for="site_kind">사이트 구분</label>
					  <div class="radio">
						<label for="site1">
						<input type="radio" name="site" id="site1" class="flat-red" value="ko" <?if(preg_match("/ko/i", $site)) {?> checked<?}?>> 국문
						</label>
						<label for="site2">
						<input type="radio" name="site" id="site2" class="flat-red" value="en" <?if(preg_match("/en/i", $site)) {?> checked<?}?>> 영문
						</label>
					  </div>
					</div>
				<?if($cfg_cate_flag == "1") {?>
					<div class="form-group">
					  <label for="category">구분</label>
					  <div class="radio">
					  <?=getCodeNameBoxDB($cfg_cate_code, $category, "radio", "category",$dbconn)?>
					  </div>
					</div>
				<?}?>

					<div class="form-group">
					  <label for="active">뷰 설정</label>
					  <div class="radio">
						<label>
							<input type="radio" name="view_flag" id="view_flag" class="flat-red" value="1" <?if($view_flag=="1"){?>checked<?}?>> 보임
						</label>
						<label>
							<input type="radio" name="view_flag" id="view_flag" class="flat-red" value="0" <?if($view_flag=="0"){?>checked<?}?>> 숨김
						</label>
					  </div>
					</div>

				<?if($cfg_bbs_type != "sns") {?>
					<div class="form-group">
					  <label for="title">제목</label>
					  <input type="text" name="title" id="title" value="<?=$title?>" class="form-control" placeholder="">
					</div>
				<?}?>
				<?if(preg_match("/notice/i", $cfg_option_list)) {?>
					<div class="form-group">
					  <label for="notice">공지</label>
					  <div class="checkbox">
						<label>
						  <input type="checkbox" name="notice_yn" id="notice_yn" value="1" <?=$notice_yn=="1"?"checked":""?>  class="flat-red"> 체크시 공지
						</label>
					  </div>
					</div>
				<?}?>
				<?if(preg_match("/secret/i", $cfg_option_list)) {?>
					<div class="form-group">
					  <label for="secret">비밀글</label>
					  <div class="checkbox">
						<label>
						  <input type="checkbox" name="is_secret" id="is_secret" value="1" <?=$is_secret=="1"?"checked":""?>  class="flat-red"> 체크시 비밀설정
						</label>
					  </div>
					</div>
				<?if($cfg_use_grade==9) {?>
					<div class="form-group">
					  <label for="passwd">비밀번호</label>
					  <input type="password" name="passwd" id="passwd" value="<?=$passwd?>" class="form-control" placeholder="">
					</div>
				<?}?>
				<?}?>

				<?if(preg_match("/tel/i", $cfg_option_list)) {?>
					<div class="form-group">
					  <label for="tel">전화번호</label>
					  <div class="row">
						  <div class="col-xs-4">
						  <input type="text" class="form-control" name="tel1" id="tel1" value="<?=$tel1?>" placeholder="">
						  </div>
						  <div class="col-xs-4">
						  <input type="text" class="form-control" name="tel2" id="tel2" value="<?=$tel2?>" placeholder="">
						  </div>
						  <div class="col-xs-4">
						  <input type="text" class="form-control" name="tel3" id="tel3" value="<?=$tel3?>" placeholder="">
						  </div>
					  </div>
					</div>
				<?}?>
				<?if(preg_match("/hp/i", $cfg_option_list)) {?>
					<div class="form-group">
					  <label for="hp">휴대폰</label>
					  <div class="row">
						  <div class="col-xs-4">
						  <input type="text" class="form-control" name="hp1" id="hp1" value="<?=$hp1?>" placeholder="">
						  </div>
						  <div class="col-xs-4">
						  <input type="text" class="form-control" name="hp2" id="hp2" value="<?=$hp2?>" placeholder="">
						  </div>
						  <div class="col-xs-4">
						  <input type="text" class="form-control" name="hp3" id="hp3" value="<?=$hp3?>" placeholder="">
						  </div>
					  </div>
					</div>
				<?} else {?>
				<?if($_t=="qna" && $gubun == "reply" ) {?>
					<input type="hidden" name="sms_hp" value="<?=$sms_hp?>">
					<input type="hidden" name="recvid" value="<?=$recvid?>">
					<input type="hidden" name="recvname" value="<?=$recvname?>">
					<div class="form-group">
					  <label for="hp">휴대폰</label>
					  <div class="input-group">
						  <?=$sms_hp?> <input type="checkbox" name="sms_flag" value="Y" checked> 답변문자 발송시 체크
					  </div>
					</div>
				<?}?>
				<?}?>
				<?if(preg_match("/email/i", $cfg_option_list)) {?>
					<div class="form-group">
					  <label for="email">이메일</label>
					  <input type="email" name="email" id="email" value="<?=$email?>" class="form-control" placeholder="">
					</div>
				<?}?>
				<?if(preg_match("/homep/i", $cfg_option_list)) {?>
					<div class="form-group">
					  <label for="homep">홈페이지</label>
					  <input type="text" name="homep" id="homep" value="<?=$homep?>" class="form-control" placeholder="">
					</div>
				<?}?>
				<?if(preg_match("/movie_url/i", $cfg_option_list)) {?>
					<div class="form-group">
					  <label for="murl">영상주소</label>
					  <input type="text" name="murl" id="murl" value="<?=$murl?>" class="form-control" placeholder="">
					</div>
				<?}?>
				<?if(preg_match("/address/i", $cfg_option_list)) {?>
					<!-- <div class="form-group">
					  <label for="corp_reg_num">주소</label>
					  <div class="row">
						<div class="col-xs-3">

							<div class="input-group input-group-sm">

								<input type="text" class="form-control" name="zipcode" id="zipcode" value="<?=$zipcode?>" placeholder="우편번호">
								<span class="input-group-btn">
								  <a type="button" class="btn btn-info btn-flat" href="javascript:_address('h')">찾기</a>
								</span>
							</div>


						</div>
						<div class=" col-xs-12">
						  <input type="text" class="form-control" name="addr1" id="addr1" value="<?=$addr1?>" placeholder="">
						</div>
						<div class=" col-xs-12">
						  <input type="text" class="form-control" name="addr2" id="addr2" value="<?=$addr2?>" placeholder="">
						</div>
						<div class=" col-xs-12">
						  <input type="text" class="form-control" name="addr3" id="addr3" value="<?=$addr3?>" placeholder="">
						</div>
					  </div>
					</div> -->
				<?}?>

				<?if($cfg_img_flag > 0) {?>
					<div class="form-group">
					  <label for="img_file">이미지파일</label>
					<?
					for($i=1;$i<=$cfg_img_flag;$i++) {

						if($gubun!="reply") {
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
						}

					?>
					  <input type="file" name="img_file[]" id="img_file<?=$i?>" value="" class="form-control">
						<?
						if($img_real_filename!="") {
							?>
							  <p class="help-block"><a href="../../common/download.php?fl=<?=$download_foldername?>&fi=<?=$img_real_filename?>"><?=$img_real_filename?></a></p>
							<?
						}

						$img_real_filename = "";
						?>
					<?}?>
					</div>
				<?}?>

				<?if($cfg_file_flag > 0) {?>
					<div class="form-group">
					  <label for="user_file">첨부파일</label>
					<?
					for($i=1;$i<=$cfg_file_flag;$i++) {
						if($gubun!="reply") {
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
						}

					?>
					  <input type="file" name="user_file[]" id="user_file<?=$i?>" value="<?=$user_file?>" class="form-control">
						<?
						if($file_real_filename!="") {
							?>
							  <p class="help-block"><a href="../../common/download.php?fl=<?=$download_foldername?>&fi=<?=$file_real_filename?>"><?=$file_real_filename?></a></p>
							<?
						}

						$file_real_filename = "";

						?>
					<?}?>
					</div>
				<?}?>

					<div class="form-group">
					  <label for="username">작성자</label>
					  <input type="text" name="username" id="username" value="<?=$username?>" class="form-control" placeholder="">
					</div>

					<?if($gubun == "reply"){ ?>
					<div class="form-group">
					  <label for="username">원문 글내용</label>
					  <?=$body_prev?>
					</div>
					<?}?>



					<div class="form-group">
					  <?
						include "../../smarteditor/SmartEditor.php";
					  ?>
					</div>

				<?if(preg_match("/tag/i", $cfg_option_list)) {?>
					<div class="form-group">
					  <label for="tag">태그</label>
						<?
						if($tag) {
							$tag = "'".str_replace(",","','",$tag)."'";
						}

						?>

					  <textarea id="tagstyle1" name="tag" value="<?=$tag?>" class="form-control"></textarea>
					</div>
				<?}?>

				</div>
				<!-- /.box-body -->

				<div class="box-footer">
					<?if($popup=="1") {?>
					<button type="text" class="btn btn-default" onClick="fn_close()">닫기</button>
					<?} else {?>
					<button type="text" class="btn btn-default" onClick="fn_cancel()">취소</button>
					<?}?>
					<button type="text"  onclick="submitContents(this);" class="btn btn-primary pull-right">확인</button>
				</div>
				</form>
			</div>
			<!-- /.box -->
		</div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

	<?if(preg_match("/tag/i", $cfg_option_list)) {?>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
    <script src="../js/tags/jquery.caret.min.js"></script>
    <script src="../js/tags/jquery.tag-editor.js"></script>

    <script>
        // jQuery UI autocomplete extension - suggest labels may contain HTML tags
        // github.com/scottgonzalez/jquery-ui-extensions/blob/master/src/autocomplete/jquery.ui.autocomplete.html.js
        (function($){var proto=$.ui.autocomplete.prototype,initSource=proto._initSource;function filter(array,term){var matcher=new RegExp($.ui.autocomplete.escapeRegex(term),"i");return $.grep(array,function(value){return matcher.test($("<div>").html(value.label||value.value||value).text());});}$.extend(proto,{_initSource:function(){if(this.options.html&&$.isArray(this.options.source)){this.source=function(request,response){response(filter(this.options.source,request.term));};}else{initSource.call(this);}},_renderItem:function(ul,item){return $("<li></li>").data("item.autocomplete",item).append($("<a></a>")[this.options.html?"html":"text"](item.label)).appendTo(ul);}});})(jQuery);

        var cache = {};
        function googleSuggest(request, response) {
            var term = request.term;
            if (term in cache) { response(cache[term]); return; }
            $.ajax({
                url: 'https://query.yahooapis.com/v1/public/yql',
                dataType: 'JSONP',
                data: { format: 'json', q: 'select * from xml where url="http://google.com/complete/search?output=toolbar&q='+term+'"' },
                success: function(data) {
                    var suggestions = [];
                    try { var results = data.query.results.toplevel.CompleteSuggestion; } catch(e) { var results = []; }
                    $.each(results, function() {
                        try {
                            var s = this.suggestion.data.toLowerCase();
                            suggestions.push({label: s.replace(term, '<b>'+term+'</b>'), value: s});
                        } catch(e){}
                    });
                    cache[term] = suggestions;
                    response(suggestions);
                }
            });
        }

        $(function() {
            $('#hero-tagstyle').tagEditor({
                placeholder: 'Enter tags ...',
                autocomplete: { source: googleSuggest, minLength: 3, delay: 250, html: true, position: { collision: 'flip' } }
            });

            $('#tagstyle1').tagEditor({ initialTags: [<?=$tag?>], delimiter: ', ', placeholder: 'Enter tags ...' }).css('display', 'block').attr('readonly', true);

            $('#tagstyle2').tagEditor({
                autocomplete: { delay: 0, position: { collision: 'flip' }, source: ['ActionScript', 'AppleScript', 'Asp', 'BASIC', 'C', 'C++', 'CSS', 'Clojure', 'COBOL', 'ColdFusion', 'Erlang', 'Fortran', 'Groovy', 'Haskell', 'HTML', 'Java', 'JavaScript', 'Lisp', 'Perl', 'PHP', 'Python', 'Ruby', 'Scala', 'Scheme'] },
                forceLowercase: false,
                placeholder: 'Programming languages ...'
            });

            $('#tagstyle3').tagEditor({ initialTags: ['Hello', 'World'], placeholder: 'Enter tags ...' });
            $('#remove_all_tags').click(function() {
                var tags = $('#tagstyle3').tagEditor('getTags')[0].tags;
                for (i=0;i<tags.length;i++){ $('#tagstyle3').tagEditor('removeTag', tags[i]); }
            });

            $('#tagstyle4').tagEditor({
                initialTags: ['Hello', 'World'],
                placeholder: 'Enter tags ...',
                onChange: function(field, editor, tags) { $('#response').prepend('Tags changed to: <i>'+(tags.length ? tags.join(', ') : '----')+'</i><hr>'); },
                beforeTagSave: function(field, editor, tags, tag, val) { $('#response').prepend('Tag <i>'+val+'</i> saved'+(tag ? ' over <i>'+tag+'</i>' : '')+'.<hr>'); },
                beforeTagDelete: function(field, editor, tags, val) {
                    var q = confirm('Remove tag "'+val+'"?');
                    if (q) $('#response').prepend('Tag <i>'+val+'</i> deleted.<hr>');
                    else $('#response').prepend('Removal of <i>'+val+'</i> discarded.<hr>');
                    return q;
                }
            });

            $('#tagstyle5').tagEditor({ clickDelete: true, initialTags: ['custom style', 'dark tags', 'delete on click', 'no delete icon', 'hello', 'world'], placeholder: 'Enter tags ...' });

            function tag_classes(field, editor, tags) {
                $('li', editor).each(function(){
                    var li = $(this);
                    if (li.find('.tag-editor-tag').html() == 'red') li.addClass('red-tag');
                    else if (li.find('.tag-editor-tag').html() == 'green') li.addClass('green-tag')
                    else li.removeClass('red-tag green-tag');
                });
            }
            $('#tagstyle6').tagEditor({ initialTags: ['custom', 'class', 'red', 'green', 'tagstyle'], onChange: tag_classes });
            tag_classes(null, $('#tagstyle6').tagEditor('getTags')[0].editor); // or editor == $('#tagstyle6').next()
        });
		/*
        if (~window.location.href.indexOf('http')) {
            (function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();
            (function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=114593902037957";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
            $('#github_social').html('\
                <iframe style="float:left;margin-right:15px" src="//ghbtns.com/github-btn.html?user=Pixabay&repo=jQuery-tagEditor&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>\
                <iframe style="float:left;margin-right:15px" src="//ghbtns.com/github-btn.html?user=Pixabay&repo=jQuery-tagEditor&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>\
            ');
        }
		*/
    </script>
	<?}?>
<?
include "../inc/footer.php";
mysql_close($dbconn);
?>