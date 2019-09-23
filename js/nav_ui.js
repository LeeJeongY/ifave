function overGNB(){		

		if (jQuery('[id^=gnb2th_]').attr('class') == "gnbsingle"){			
			jQuery('[id^=gnb2th_]').attr('class','gnbsingle');
			var gnbMM = jQuery(this).attr('class');
			var gnbHeight = "H"+gnbMM;	


			jQuery('#gnb_Bg').show();
			jQuery('#gnb_bottom_line').show();
			jQuery('.gnb_s').hide();
			jQuery('#gnb h2 a').removeClass('active');

			jQuery('.gnb_s li a').addClass('active')
			
			jQuery('.m_logo').addClass('m_logo_over')
			jQuery('.all_gnb').addClass('all_gnb_over')


			//jQuery('.gnb_s > li:last-child').css('background','none')
			jQuery(this).children().children().show();
			//jQuery('#gnb_Bg').animate({height:"25px"},100);
			if (gnbHeight == "Hgm_1"){
				jQuery('h2 > a',this).addClass('active')
				jQuery('h2 > a').addClass('active')

			    jQuery('#gnb_bottom_line').stop().animate({left:"250px"},100, 'easeOutExpo')
			    jQuery('#gnb_bottom_line').css({'width':'60px'})
				jQuery('#gnb_Bg').stop().animate({height:"50px"},100, 'easeOutExpo')
				//jQuery('#gm_1').show()//IE7,IE8 첫하위메뉴 활성화
			} else if (gnbHeight == "Hgm_2"){
				jQuery('h2 > a',this).addClass('active')
				jQuery('h2 > a').addClass('active')

				jQuery('#gnb_bottom_line').stop().animate({left:"350px"},100, 'easeOutExpo')	
				jQuery('#gnb_bottom_line').css({'width':'30px'})
				jQuery('#gnb_Bg').stop().animate({height:"50px"},100, 'easeOutExpo')
			} else if (gnbHeight == "Hgm_3"){
				jQuery('h2 > a',this).addClass('active')
				jQuery('h2 > a').addClass('active')

				jQuery('#gnb_bottom_line').stop().animate({left:"410px"},100, 'easeOutExpo')
				jQuery('#gnb_bottom_line').css({'width':'66px'})					
				jQuery('#gnb_Bg').stop().animate({height:"50px"},100, 'easeOutExpo')
			} else if (gnbHeight == "Hgm_4"){
				jQuery('h2 > a',this).addClass('active')
				jQuery('h2 > a').addClass('active')

				jQuery('#gnb_bottom_line').stop().animate({left:"515px"},100, 'easeOutExpo')		
				jQuery('#gnb_bottom_line').css({'width':'90px'})	
				jQuery('#gnb_Bg').stop().animate({height:"50px"},100, 'easeOutExpo')
			} else if (gnbHeight == "Hgm_5"){
				jQuery('h2 > a',this).addClass('active')
				jQuery('h2 > a').addClass('active')

				jQuery('#gnb_bottom_line').stop().animate({left:"638px"},100, 'easeOutExpo')	
				jQuery('#gnb_bottom_line').css({'width':'48px'})	
				jQuery('#gnb_Bg').stop().animate({height:"50px"},100, 'easeOutExpo')
			}
		}
	}
	function closeGnb(){
			jQuery('#gnb_Bg').slideUp(100);
			jQuery('#gnb_bottom_line').hide();
			jQuery('.gnb_s').hide();
			jQuery('.gnbmm li').css('opacity','1');
			jQuery('#gnb h2 a').removeClass('active');

			jQuery('.m_logo').removeClass('m_logo_over')
			jQuery('.all_gnb').removeClass('all_gnb_over')
		}
	function nofunction(){
	}
	jQuery(function(){
		jQuery('[id^=menu_]').hover(overGNB,nofunction);
		jQuery(".gnboverarea").hover(nofunction,closeGnb);
		
	jQuery('[id^=menu_] h2 a').keyup(function(){
		var mid = jQuery(this).parent().parent().attr('id');
		jQuery('#'+mid).mouseover();
	});
	
})