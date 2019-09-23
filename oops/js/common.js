
//숫자만 입력
function chkNumeric(objText) {
	var chrTmp;
	var strTmp = objText.value;
	var chkAlpha = false;
	var resString = '';

	for (var i=0; i<=strTmp.length; i++) {
		chrTmp = strTmp.charCodeAt(i);
		if ((chrTmp <=47 && chrTmp > 31) || chrTmp >= 58) {
			chkAlpha = true;
		} else {
			resString = resString + String.fromCharCode(chrTmp);
		}
	}
	if (chkAlpha == true) {
		alert("숫자만 입력가능합니다.");
		objText.value = resString;
		objText.focus();
		return false;
	}
	return true;
}

//새창
function _popup_page(str,p,w,h) {
	var url_page = str;
	var win = window.open(url_page, p, 'width='+w+',height='+h+', menubar=0, scrollbars=1, resizable=auto');
	win.focus();
}

function deving(str) { alert('서비스 준비중입니다.'); return;}

function goto_back() {
	history.go(-1);
}

//주소찾기
function _address(flag) {
	var strAddr = "../common/zipcode.php?flag="+flag;
	window.open(strAddr,'_zipcode','width=450,height=600,left=100,top=112,scrollbars=auto');
}


function go_login(param) {

	var frm = document.loginf;
	if (confirm("해당 아이디로 로그인 하시겠습니까?") == true )
	{
		frm.user_id.value = param;
		frm.target = "_blank";
		frm.action = "../../common/auth_root.php";
		frm.submit();
	}
}

//회원상세정보
function go_memberinfo(id) {
	_popup_page("../member/view.php?user_id="+id,"_member_info","800","800");
}


//접속로그
function go_conn_log(id) {
	_popup_page("../member/log_list.php?user_id="+id+"&popup=1","_email","800","800");

}