
<script language="javascript">
<!--

$(document).ready(function(){
	$('#chkall').click(function(){
		var chk = $("#chkall").is(":checked");
		if(chk) {
			$("input:checkbox[id=idxchk]").prop("checked", true);
		} else {
			$("input:checkbox[id=idxchk]").prop("checked", false);
		}
	});
});

//취소
function fn_cancel() {
	history.go(-1);
}

function fn_close() {
	self.close();
}
//선택삭제
function go_remove() {
	var checked = 0;
	checked = $("#idxchk:checked").length;
	if(checked == 0) {
		alert('선택해 주세요.');
		return false;
	} else {
		var result = confirm('정말 삭제하시겠습니까?');

		if(result) {
			$('#gubun').val("remove");
			$("#listform").attr("action", "write_ok.php");
			$("#listform").submit();
		}
	}
}
// 목록
function go_list() {
	$("#form").attr("method", "get");
	$("#form").attr("action", "list.php");
	$("#form").submit();
}
// 등록
function go_write() {
	$('#gubun').val("insert");
	$("#form").attr("method", "get");
	$("#form").attr("action", "write.php");
	$("#form").submit();
}
// 수정
function go_edit(param) {
	$('#idx').val(param);
	$('#gbn').val("update");
	$("#form").attr("method", "get");
	$("#form").attr("action", "write.php");
	$("#form").attr("target", "_self");
	$("#form").submit();
}
//팝업 창에서 수정시
function go_popup_edit(param) {
	$('#idx').val(param);
	$('#gbn').val("update");
	$("#form").attr("method", "get");
	$("#form").attr("action", "write.php");
	$("#form").submit();
}
// 보기
function go_view(param) {
	$('#idx').val(param);
	$('#gbn').val("view");
	$("#form").attr("method", "get");
	$("#form").attr("action", "view.php");
	$("#form").submit();
}

// 리스트 보기
function go_viewList(param) {
	$('#idx').val(param);
	$('#gbn').val("view");
	$("#form").attr("method", "get");
	$("#form").attr("action", "list.php");
	$("#form").submit();
}

// 삭제
function go_delete(param) {
	var fm = document.form;
	if (confirm("정말 삭제 하시겠습니까?") == true )
	{
		$('#idx').val(param);
		$('#gbn').val("delete");
		$("#form").attr("method", "post");
		$("#form").attr("action", "write_ok.php");
		$("#form").submit();
	}
}
//답변
function go_reply(param) {
	$('#idx').val(param);
	$('#gbn').val("reply");
	$("#form").attr("method", "get");
	$("#form").attr("action", "write.php");
	$("#form").submit();
}
//태그 검색
function go_tag(param) {
	$('#tag').val(param);
	$("#form").attr("method", "get");
	$("#form").attr("action", "list.php");
	$("#form").submit();
}
//해시태그 검색
function go_hashtag(param) {
	$('#tag').val(param);
	$("#form").attr("method", "get");
	$("#form").attr("action", "list.php");
	$("#form").submit();
}

function fn_category(param) {

	var checked = 0;
	checked = $("#idxchk:checked").length;
	if(checked == 0) {
		alert('선택해 주세요.');
		return false;
	} else {
		var result = confirm('분류를 변경하시겠습니까?');

		if(result) {
			$('#catecode').val(param);
			$('#gubun').val("category");
			$("#listform").attr("action", "category_ok.php");
			$("#listform").submit();
		}
	}
}

function go_boardconfig() {
	self.close();
}

function go_counter(division,idx) {
	var _t = $('#_t').val();
	// ajax 실행
	$.ajax({
		type : 'POST',
		url : 'write_ok.php',
		data : {'fid':idx,'gubun':'counts','division':division,'_t':_t},
		success : function(data) {
			if (division == "like") {
				$("#like_"+idx).html(""+data+"");
			} else if (division == "bad") {
				$("#bad_"+idx).html(""+data+"");
			}
		}
	}); // end ajax
}

function go_code_add(code, name) {
	var page = (code.length > 0)? "sub_write" : "write";
	var frm = document.form;
	// _popup_page('../code/sub_write.php?code='+code+'&kind_name='+name+'&popup=1','_p','600','600');
	_popup_page('../code/'+page+'.php?code='+code+'&kind_name='+name+'&popup=1','_p','680','600');
}

function go_category_add(code, name) {
	var page = (code.length > 0)? "write" : "write";
	var frm = document.form;
	// _popup_page('../code/sub_write.php?code='+code+'&kind_name='+name+'&popup=1','_p','600','600');
	_popup_page('../category/'+page+'.php?bid='+code+'&kind_name='+name+'&popup=1','_p','680','600');
}

function go_cluster_category_add(code, name) {
	var page = (code.length > 0)? "sub_write" : "write";
	var frm = document.form;
	// _popup_page('../code/sub_write.php?code='+code+'&kind_name='+name+'&popup=1','_p','600','600');
	_popup_page('../cluster_category/'+page+'.php?code='+code+'&kind_name='+name+'&popup=1','_p','680','600');
}

// 사용자 보기
function goto_view(param1,param2) {
	$('#idx').val(param1);
	$('#_t').val(param2);
	$('#gbn').val("view");
	$("#form").attr("method", "get");
	$("#form").attr("action", "view.php");
	$("#form").submit();
}


/* 참고사이트 : http://dev.epiloum.net/916 */
function fn_sendSns(sns, url, txt)
{
    var o;
    var _url = encodeURIComponent(url);
    var _txt = encodeURIComponent(txt);
    var _br  = encodeURIComponent('\r\n');
    switch(sns)
    {
        case 'facebook':
            o = {
                method:'popup',
                url:'http://www.facebook.com/sharer/sharer.php?u=' + _url + '&t=' + _txt
            };
            break;

        case 'twitter':
            o = {
                method:'popup',
                url:'http://twitter.com/intent/tweet?text=' + _txt + '&url=' + _url
            };
            break;

        case 'googleplus':
            o = {
                method:'popup',
                url:'https://plus.google.com/share?&url=' + _url
            };
            break;
        case 'me2day':
            o = {
                method:'popup',
                url:'http://me2day.net/posts/new?new_post[body]=' + _txt + _br + _url + '&new_post[tags]=epiloum'
            };
            break;

        case 'kakaotalk':
            o = {
                method:'web2app',
                param:'sendurl?msg=' + _txt + '&url=' + _url + '&type=link&apiver=2.0.1&appver=2.0&appid=dev.epiloum.net&appname=' + encodeURIComponent(_txt),
                a_store:'itms-apps://itunes.apple.com/app/id362057947?mt=8',
                g_store:'market://details?id=com.kakao.talk',
                a_proto:'kakaolink://',
                g_proto:'scheme=kakaolink;package=com.kakao.talk'
            };
            break;

        case 'kakaostory':
            o = {
                method:'popup',
                url:'https://story.kakao.com/s/share?url='+_url
				/*
                method:'web2app',
                param:'posting?post=' + _txt + _br + _url + '&apiver=1.0&appver=2.0&appid=dev.epiloum.net&appname=' + encodeURIComponent('Epiloum 개발노트'),
                a_store:'itms-apps://itunes.apple.com/app/id486244601?mt=8',
                g_store:'market://details?id=com.kakao.story',
                a_proto:'storylink://',
                g_proto:'scheme=kakaolink;package=com.kakao.story'
				*/
            };
            break;

        case 'band':
            o = {
                method:'web2app',
                param:'create/post?text=' + _txt + _br + _url,
                a_store:'itms-apps://itunes.apple.com/app/id542613198?mt=8',
                g_store:'market://details?id=com.nhn.android.band',
                a_proto:'bandapp://',
                g_proto:'scheme=bandapp;package=com.nhn.android.band'
            };
            break;

        case 'naver':
            o = {
                method:'popup',
                url:'http://share.naver.com/web/shareView.nhn?url=' + _url + '&title=' + _txt
            };
            break;

        default:
            alert('지원하지 않는 SNS입니다.');
            return false;
    }

    switch(o.method)
    {
        case 'popup':
            window.open(o.url, sns, 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');
            break;

        case 'web2app':
            if(navigator.userAgent.match(/android/i))
            {
                // Android
                setTimeout(function(){ location.href = 'intent://' + o.param + '#Intent;' + o.g_proto + ';end'}, 100);
            }
            else if(navigator.userAgent.match(/(iphone)|(ipod)|(ipad)/i))
            {
                // Apple
                setTimeout(function(){ location.href = o.a_store; }, 200);
                setTimeout(function(){ location.href = o.a_proto + o.param }, 100);
            }
            else
            {
                alert('이 기능은 모바일에서만 사용할 수 있습니다.');
            }
            break;
    }
}



function coach_search(){

	w=700;
	h=900;

	width=screen.width;
	height=screen.height;

	 x=(width/2)-(w/2);
	 y=(height/2)-(h/2);

	window.open("../coach/popup_coach_search.php?popup=1&search_type=coach_search","_coach_search", "resizable=yes,top="+y+",left="+x+",width="+w+",height="+h+",scrollbars=no");

}// end function

//-->
</script>