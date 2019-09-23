<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";

	if($tbl=="") $tbl	= "member";
	$foldername  = "../../$upload_dir/$tbl/";
	if($returnurl == "") $returnurl = $_SERVER["HTTP_REFERER"];

	include "../inc/header.php";
?>

<script>
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
	select.find('span').addClass('spanOn');
    con.eq(num).show();

    menu.click(function(){
        if(select!==null){
            select.removeClass("on");
			select.find('span').removeClass('spanOn');
            con.eq(i).hide();
        }

        select = $(this);
        i = $(this).index();

		$('#auth_flag').val(i);

        select.addClass('on');
		select.find('span').addClass('spanOn');
        con.eq(i).show();



    });
}


function go_submit() {
	if($('#auth_flag').val()=="0") {
		if($.trim($('#user_id').val()) == ''){
			alert("아이디를 입력하세요.");
			$('#user_id').focus();
			return false;
		}
		if($.trim($('#user_pwd').val()) == ''){
			alert("비밀번호를 입력하세요.");
			$('#user_pwd').focus();
			return false;
		}
		$("#fm").attr("target", "_self");
		$("#fm").attr("method", "post");
		$("#fm").attr("action", "/common/auth.php");
	} else {
		if($.trim($('#order_name').val()) == ''){
			alert("주문자 이름을 입력하세요.");
			$('#order_name').focus();
			return false;
		}
		if($.trim($('#order_number').val()) == ''){
			alert("주문번호를 입력하세요.");
			$('#order_number').focus();
			return false;
		}
		$("#fm").attr("target", "_self");
		$("#fm").attr("method", "post");
		$("#fm").attr("action", "/common/auth.order.php");

	}

}
</script>
		<!-- container -->
		<div id="container">

			<section>
				<div class="comList">
					<div class="content">
						<h2>로그인</h2>
						<div class="memBox">
							<ul class="tab cfx" id="tab">
								<li><span>FAVE 회원 로그인</span></li>
								<li><span>비회원 주문조회 및 확인</span></li>
							</ul>
							<form method="post" name="fm" id="fm" onSubmit="return go_submit()">
							<input type="hidden" name="returnurl" value='<?=$returnurl?>'>
							<input type="hidden" name="auth_flag" id="auth_flag" value='0'>
							<div class="tab_con" id="tab_con">
								<div class="ibox">
									<input type="text" name="user_id" id="user_id" class="tp1" placeholder="아이디">
									<input type="password" name="user_pwd" id="user_pwd" class="tp1" placeholder="비밀번호">
									<input type="submit" value="LOGIN" class="btn-login">
								</div>
								<div class="ibox">
									<input type="text" name="order_name" id="order_name" class="tp1" placeholder="주문자 성함">
									<input type="password" name="order_number" id="order_number" class="tp1" placeholder="주문번호">
									<input type="submit" value="로그인" class="btn-login">
								</div>
							</div>
							</form>
						</div>
						<div class="sideMem">
							<ul>
								<li><a href="join.php">회원가입</a></li>
								<li><a href="find_id.php">아이디 찾기</a></li>
								<li><a href="find_pw.php">비밀번호 찾기</a></li>
							</ul>
						</div>
					</div>
				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
