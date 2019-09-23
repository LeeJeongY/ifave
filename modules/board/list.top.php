<?

	//파일경로
	$foldername  = "../$upload_dir/$cfg_bbs_kind/$_t/";
	$download_foldername  = "../$upload_dir/$cfg_bbs_kind/$_t/";

	if($cfg_list_counts == 0) {
		$cfg_list_counts = 10;
	}

	if($page == '') $page = 1;
	$list_num = $cfg_list_counts;	//목록수
	$page_num = 10;
	$offset = $list_num*($page-1);

	$rot_num = 0;

	//페이지 링크주소 매개변수를 여러개 넘길때는 끝에 '&' 추가
	$link_url = "$PHP_SELF?_t=$_t&search=$search&search_text=$search_text&type=$type&cfg_cate_flag=$cfg_cate_flag&category=$category&";

	if($tag != "")			$qry_where .= " and tag like '%$tag%'" ;
	if($search_text != "")	{
		if($search=="all") {
			$qry_where .= " and (title like '%$search_text%' or body like '%$search_text%')" ;
		} else {
			$qry_where .= " and $search like '%$search_text%'" ;
		}
	}
	if($category != "")		$qry_where .= " and category = '$category'";
	if($_ADMINID != "")		{
		$qry_where .= " and (adminid = '$_ADMINID')";
	}
	$qry_where .= " and view_flag='1'";
	$qry_where .= " and site='".$lng."'";

	if($_t == "qna" || $_t == "question" || $_t == "note") {
		$qry_where .= " and userid='$UID'";
	}

	$query = "SELECT count(idx) as cnt FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT NULL ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	$total_no = 0;
	if($array = mysql_fetch_array($result)) {
		$total_no		= $array[cnt];
	}

	$total_page = ceil($total_no/$list_num);
	$cur_num = $total_no - $list_num*($page-1);

	$query  = "SELECT * ";
	$query .= " FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT NULL";
	if($cfg_bbs_type != "sns") $query .= " AND notice_yn !='1'";
	$query .= $qry_where;
	//$query .= " order by thread desc, idx asc limit $offset, $list_num";
	if($cfg_bbs_type != "sns") $query .= " ORDER BY thread DESC, pos ASC LIMIT $offset, $list_num";
	else $query .= " ORDER BY regdate DESC LIMIT $offset, $list_num";
	$result = mysql_query($query, $dbconn) or die (mysql_error());


	//스크립트
	include "../modules/js/goto_page.js.php";
	//게시판 모바일 css
	include "../modules/css/board_mobile.css.php";
?>
<style type="text/css">
<?if(preg_match("/tag/i", $cfg_option_list)) {?>
.tag-editor {
    list-style-type: none; padding: 2px 5px 0 16px; margin: 0; overflow: hidden; cursor: text;
    font: normal 12px sans-serif; color: #555; line-height: 20px;
}
.tag-pointer {float:left; padding:0px 5px; margin:2px 5px; color: #46799b; background: #e0eaf1; white-space: nowrap;overflow: hidden; cursor: pointer; border-radius: 2px 0 0 2px;}
<?}?>

<?if($cfg_share_media!="") {?>
#divShare {
 position:absolute;
 display:none;
 background-color:#ffffff;
 border:solid 1px #d0d0d0;
 width:auto;
 height:auto;
 padding:10px;
 z-index:100;
}
<?}?>
</style>

<script language="javascript">
<!--
<?if($cfg_share_media!="") {?>
function fn_share(idx) {
	var pos = $('#canvas'+idx).position();
	$('#divShare').css({position:'absolute'}).css({
		"position": "absolute",
		left:pos.left + 30,
		top:pos.top
		//center
		/*
		left: ($(window).width() - $('#divShare').outerWidth())/2,
		top: ($(window).height() - $('#divShare').outerHeight())/2
		*/
	}).show();
}
<?}?>
//-->
</script>

<script>
/*
$(function () {
	tab('#tab',0);
});

function tab(e, num){
    var num = num || 0;
    var menu = $(e).children();
    var con = $(e+'_con').children();
    var select = $(menu).eq(num);
    var i = num;

    select.addClass('on');
    con.eq(num).show();

    menu.click(function(){
        if(select!==null){
            select.removeClass("on");
            con.eq(i).hide();
        }

        select = $(this);
        i = $(this).index();

        select.addClass('on');
        con.eq(i).show();
    });
}
*/
$(function(){
 var article = $('.faq .article');
   article.addClass('hide');
   article.find('.a').slideUp(100);
 $('.faq .article .trigger').click(function(){
  var myArticle = $(this).parents('.article:first');
  if(myArticle.hasClass('hide')){
   article.addClass('hide').removeClass('show'); // 아코디언 효과를 원치 않으면 이 라인을 지우세요
   article.find('.a').slideUp(100); // 아코디언 효과를 원치 않으면 이 라인을 지우세요
   myArticle.removeClass('hide').addClass('show');
   myArticle.find('.a').slideDown(100);
  } else {
   myArticle.removeClass('show').addClass('hide');
   myArticle.find('.a').slideUp(100);
  }
 });
 $('.faq .hgroup .trigger').click(function(){
  var hidden = $('.faq .article.hide').length;
  if(hidden > 0){
   article.removeClass('hide').addClass('show');
   article.find('.a').slideDown(100);
  } else {
   article.removeClass('show').addClass('hide');
   article.find('.a').slideUp(100);
  }
 });
});
</script>
<form name="form" id="form">
<input type="hidden" name="idx" id="idx">
<input type="hidden" name="gubun" id="gbn">
<input type="hidden" name="_t" value="<?=$_t?>" id="_t">
<input type="hidden" name="tag" id="tag" value="">
<input type="hidden" name="cfg_cate_flag" value="<?=$cfg_cate_flag?>">
<input type="hidden" name="popup" value="<?=$popup?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="search" value="<?=$search?>">
<input type="hidden" name="search_text" value="<?=$search_text?>">
</form>