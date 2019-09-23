$(function() {
	$('.hide').hide();
	hide_func();
	
	$('[class^=menu]').hover(
		function() {
			hide_func();
			$('[class^=menu]').css('background','');
			$('[class^=menu]').css('color','');
			var nm = $(this).attr('class');
			$(this).css('background','#d6232a');
			$(this).css('color','#fff');
			//alert(nm);
			$('#'+nm).show();
		},
		function() {
			var nm = $(this).attr('class');
			//alert(nm);
			if($('#'+nm).is(':hidden'))
				$('.hide').hide();
		}
	);
	
	$('[class^=submenu]').hover(
		function() {
			$('.submenu').css('background','');
			var idx = $('.submenu').index(this);
			//alert(idx);
			$('.submenu:eq('+idx+')').css('background','');
			$('ul.hide').hide();
			$('.submenu:eq('+idx+')>ul.hide').show();
		},
		function() {
			
		}
	);
	
	$('.hide>li').hover(
		function() {
			$('.hide li').css('background','');
			var idx = $('.hide>li').index(this);
			$('.hide li:eq('+idx+')').css('background','gold');
			
		},
		function() {
			//$('.hide li').css('background','');	
		}
	);
});

function hide_func() {
	$('[id^=menu]').hide();
	$('ul.hide').hide();	
}

$(function(){
$('.nav_wrap_s').hide();
	$('.btn_t_cate a').click(function(){
		$('.nav_wrap_s').slideToggle(500, function(){
			if($(this).is(':hidden')) $('.btn_t_cate a').html('<img src="../images/inc/btn_all_close.jpg">');
			else $('.btn_t_cate a').html('<img src="../images/inc/btn_all.jpg">'); 
		});
	});
});