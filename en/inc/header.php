<!DOCTYPE HTML>
<html lang="<?=$lng?>">
<head>
<title>FAVE Smart Balance Trainer</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="description" content="FAVE Smart Balance Trainer" />
<meta name="keywords" content="FAVE Smart Balance Trainer" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" type="text/css" href="/css/common_en.css" />

<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.bxslider.js"></script>
<script type="text/javascript" src="/js/selectbox-min.js"></script><!-- js select -->
<script type="text/javascript" src="/js/nav_ui.js"></script>
<script type="text/javascript" src="/js/jquery.slides.min.js"></script>
<script type="text/javascript" src="/js/jquery.slide.banner.js"></script>
<script>
	$(function(){
	$('.anb').hide();
		$('.m-menu').click(function(){
			$('.anb').slideToggle(100, function(){
				if($(this).is(':hidden')) $('.all_gnb').html('<img src="../images/inc/am_close.gif">');
				else $('.all_gnb').html('');
			});
		});
		$('.btn-p-close').click(function(){
			$('.anb').slideToggle(100, function(){
				if($(this).is(':hidden')) $('.btn-p-close');
				else $('.btn-p-close');
			});
        });
	});
</script>

<script type="text/javascript">
    $(document).ready(function(){

        /* visual silde */
        $(".main_slide_box").bxSlider({
            captions: true,
            auto: false,
            pager: true,
            speed: 500,
            controls:true,
            infiniteLoop: true,
            nextSelector: $(".main_bx_btn_box").find(".bx_next"),
            prevSelector: $(".main_bx_btn_box").find(".bx_prev")
        });

    });
</script>

</head>

<body>
<!-- //전체메뉴 -->
<div class="anb">
    <div class="aheader">
		<ul class="amen">
			<?if($UID!="") {?>
				<li><a href="/common/logout.php">LOGOUT</a></li>
				<li><a href="/<?=$lng?>/member/mypage.php">MYPAGE</a></li>
			<?} else {?>
				<li><a href="/<?=$lng?>/member/join.php">SIGN UP</a></li>
				<li><a href="/<?=$lng?>/member/login.php">LOG IN</a></li>
			<?}?>
		</ul>
		<a href="/ko/" class="btn_lang_m">KOR</a>
	</div>
	<div class="ah_ins">
		<ul class="anav">
			<li><a href="/<?=$lng?>/brand/brand.php">BRAND</a></li>
			<li><a href="/<?=$lng?>/goods">PRODUCTS</a></li>
			<li><a href="/board/list.php?_t=notice&lng=en">NOTICE</a></li>
			<li><a href="/board/list.php?_t=pr&lng=en">PR</a></li>
			<li><a href="/board/list.php?_t=faq&lng=en">FAQ</a></li>
		</ul>
	</div>
	<a href="#n" class="btn-p-close"><img src="/images/inc/btn-p-close.png" alt="닫기"></a>

</div>
<!-- //전체메뉴 -->

	<div id="wrap">
		<!-- header -->
		<header>
            <div class="header">
                <div class="hd_top">
					<div>
						<ul>
						<?if($UID!="") {?>
							<li><a href="/common/logout.php">LOGOUT</a></li>
							<li><a href="/<?=$lng?>/member/mypage.php">MYPAGE</a></li>
						<?} else {?>
							<li><a href="/<?=$lng?>/member/join.php">SIGN UP</a></li>
							<li><a href="/<?=$lng?>/member/login.php">LOG IN</a></li>
						<?}?>
						</ul>
						<a href="/ko/" class="btn_lang">KOR</a>
					</div>
                </div>

				<div class="hd_bottom">
					<div>
						<a href="#n" class="m-menu"><span class="blind">메뉴</span></a>
						<h1><a href="/?lng=<?=$lng?>" class="logo"><span class="blind">FAVE Smart Balance Trainer</span></a></h1>
						<nav>
							<!-- gnb -->
							<div class="gnb">
								<ul>
									<li><a href="/<?=$lng?>/brand/brand.php">BRAND</a></li>
									<li><a href="/<?=$lng?>/goods">PRODUCTS</a></li>
									<li><a href="/board/list.php?_t=notice&lng=en">NOTICE</a></li>
									<li><a href="/board/list.php?_t=pr&lng=en">PR</a></li>
									<li><a href="/board/list.php?_t=faq&lng=en">FAQ</a></li>
								</ul>
							</div>
							<!-- // gnb -->
						</nav>
						<ul class="t-sns">
							<li><a href="<?if($sns_facebook!="") {?>https://www.facebook.com/<?=$sns_facebook?><?} else {?>javascript:alert('관리자모드에서 주소를 설정하세요.');<?}?>" class="m-facebook" target="_blank"><span class="blind">Facebook</span></a></li>
							<li><a href="<?if($sns_instagram!="") {?>https://www.instagram.com/<?=$sns_instagram?><?} else {?>javascript:alert('관리자모드에서 주소를 설정하세요.');<?}?>" class="m-instagram" target="_blank"><span class="blind">Instagram</span></a></li>
						</ul>
						<a href="/<?=$lng?>/member/login.php" class="m-login"><span class="blind">로그인</span></a>
					</div>
                </div>
            </div>
		</header>
		<!-- //header -->