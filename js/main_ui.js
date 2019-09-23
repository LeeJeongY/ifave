$(document).ready(function(){

	/* gnb on off */
	$(".gnb_menu > li > a").mouseenter(function(){
		$(".gnb_menu > li > a").each(function(){
			$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_on","_off"));			
//			$(this).css('background','');
		});
		$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_off","_on"));
		if($(this).parent().attr("class") != "on"){			
			$(".depth").hide();
			$(".header_box").addClass("bg_depth")
			$(this).next().show();
		}
	}).mouseleave(function(){
		/* 1depth on off */
		if($(this).parent().attr("class") != "on"){			
			$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_on","_off"));
			$(".depth").hide();
			$(".header_box").removeClass("bg_depth");
		}
		$(".depth").mouseenter(function(){
			$(this).parent().children("a").find("img").attr("src",$(this).parent().children("a").find("img").attr("src").replace("_off","_on"));
			$(this).show();
			$(".header_box").addClass("bg_depth");
		}).mouseleave(function(){
			$(this).parent().children("a").find("img").attr("src",$(this).parent().children("a").find("img").attr("src").replace("_on","_off"));
//			$(".depth").hide();
//			$(".header_box").removeClass("bg_depth");
		});
		/* 2depth on off */
		$(".depth li a").mouseenter(function(){
			$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_off","_on"));
		}).mouseleave(function(){
			$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_on","_off"));
		});
	});

	$(".gnb_menu > li > .depth a").mouseenter(function(){
		$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_off","_on"));
	}).mouseleave(function(){
		/* 1depth on off */
		if($(this).parent().attr("class") != "on"){			
			$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_on","_off"));
		}
		$(".depth").mouseenter(function(){
			$(this).parent().children("a").find("img").attr("src",$(this).parent().children("a").find("img").attr("src").replace("_off","_on"));
		}).mouseleave(function(){
			if($(this).parent().attr("class") != "on"){			
				$(this).parent().children("a").find("img").attr("src",$(this).parent().children("a").find("img").attr("src").replace("_on","_off"));
			}
			$(".depth").hide();
			$(".header_box").removeClass("bg_depth");
		});	
	});

	/* img hover */
	$(".hover").mouseenter(function(){
		$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_off","_on"));
	}).mouseleave(function(){
		$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_on","_off"));
	});

});


$(window).scroll(setEvent);
function setEvent(){
	var st = $(this).scrollTop();
	var speed = 50;
	if (st > 157){
		$("#header").animate({"top":"-157px"}, speed);
	}else if(st < 157){
		$("#header").animate({"top":"0"}, speed);
	}
}


/*
$(document).ready(function(){
	$("#language_id").selectbox(); js select 
});
*/