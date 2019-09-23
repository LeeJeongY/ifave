
$(window).scroll(setEvent);
function setEvent(){
	var st = $(this).scrollTop();
	var speed = 50;
	if (st > 730){
		$("#snb_wrap").animate({"top":"0"}, speed);
		$("#snb_wrap").css("position","fixed");
	}else if(st < 730){
		$("#snb_wrap").animate({"top":"0"}, speed);
		$("#snb_wrap").css("position","relative");
	}
}

