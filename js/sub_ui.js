$(document).ready(function(){

	/* gnb on off */
	$(".gnb_menu > li > a").mouseenter(function(){
		$(".gnb_menu > li > a").each(function(){
			$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_on","_off"));			
		});
		$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_off","_on"));
		if($(this).parent().attr("class") != "on"){			
			$(".depth").hide();
			$(".header_box").addClass("bg_depth");
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
			if($(this).parent().attr("class") != "on"){			
				$(this).parent().children("a").find("img").attr("src",$(this).parent().children("a").find("img").attr("src").replace("_on","_off"));
			}
		});
		/* 2depth on off */
		$(".depth li a").mouseenter(function(){
			$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_off","_on"));
		}).mouseleave(function(){
			if($(this).parent().attr("class") != "on"){
				$(this).find("img").attr("src",$(this).find("img").attr("src").replace("_on","_off"));
			}
		});
	});

	$(".gnb_menu > li").mouseenter(function(){		
	}).mouseleave(function(){
		$(".depth").hide();
		$(".header_box").removeClass("bg_depth");
		$(".gnb_menu li.on .active").find("img").attr("src",$(".gnb_menu li.on .active").find("img").attr("src").replace("_off","_on"));
		$(".gnb_menu li.on").find(".depth").show();
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
			$(".gnb_menu li.on").find(".depth").show();
			$(".gnb_menu li.on .active").find("img").attr("src",$(".gnb_menu li.on .active").find("img").attr("src").replace("_off","_on"));
		});	
	});
});

/*
$(window).scroll(setEvent);
function setEvent(){
	var st = $(this).scrollTop();
	var speed = 50;
	if (st > 158){
		$("#header").animate({"top":"-158px"}, speed);
	}else if(st < 158){
		$("#header").animate({"top":"0"}, speed);
	}
}
*/

