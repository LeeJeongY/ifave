<?
	$BBS_INFO			= getBoardConfigDB($_t, $dbconn);

	/*
	bbs_kind : board,data,gallery,inquiry,sns
	bbs_type : list,image,multi
	cate_flag : 1(사용),0(미사용)
	option_list : secret,tel,hp,email,homep,movie_url,address
	use_grade : 1(관리자),2(직원이상),3(회원만),9(누구나)
	skill_list : view,write,edit,reply,del,comment,like
	target_send : mail,sms,lms,mms
	share_media : kakao,blog,facebook,google+,twitter,instargram
	item_close : writer,rdate,count,file
	*/

	$cfg_bbs_kind		= $BBS_INFO[0];
	$cfg_bbs_type		= $BBS_INFO[1];
	$cfg_bbs_name		= $BBS_INFO[2];
	$cfg_cate_flag		= $BBS_INFO[3];
	$cfg_cate_code		= $BBS_INFO[4];
	$cfg_bbs_title		= $BBS_INFO[5];
	$cfg_user_file		= $BBS_INFO[6];
	$cfg_option_list	= $BBS_INFO[7];
	$cfg_use_grade		= $BBS_INFO[8];
	$cfg_skill_list		= $BBS_INFO[9];
	$cfg_target_send	= $BBS_INFO[10];
	$cfg_share_media	= $BBS_INFO[11];
	$cfg_item_close		= $BBS_INFO[12];
	$cfg_img_flag		= $BBS_INFO[13];
	$cfg_file_flag		= $BBS_INFO[14];
	$cfg_list_counts	= $BBS_INFO[15];
	$cfg_bbs_id			= $BBS_INFO[16];


	$debug_msg = "bbs_type		: $cfg_bbs_type <br> ";
	$debug_msg .= "bbs_kind		: $cfg_bbs_kind<br> ";
	$debug_msg .= "bbs_name		: $cfg_bbs_name<br> ";
	$debug_msg .= "cate_flag	: $cfg_cate_flag<br> ";
	$debug_msg .= "cate_code	: $cfg_cate_code<br> ";
	$debug_msg .= "bbs_title	: $cfg_bbs_title<br> ";
	$debug_msg .= "user_file	: $cfg_user_file<br> ";
	$debug_msg .= "option_list	: $cfg_option_list<br> ";
	$debug_msg .= "use_grade	: $cfg_use_grade<br> ";
	$debug_msg .= "skill_list	: $cfg_skill_list<br> ";
	$debug_msg .= "target_send	: $cfg_target_send<br> ";
	$debug_msg .= "share_media	: $cfg_share_media<br> ";
	$debug_msg .= "item_close	: $cfg_item_close<br> ";
	$debug_msg .= "img_flag		: $cfg_img_flag<br> ";
	$debug_msg .= "file_flag	: $cfg_file_flag<br> ";
	$debug_msg .= "list_counts	: $cfg_list_counts<br> ";
	$debug_msg .= "bbs_id		: $cfg_bbs_id<br> ";


	//파일경로
	$foldername  = "../$upload_dir/$cfg_bbs_kind/$_t/";
	$download_foldername  = "../$upload_dir/$cfg_bbs_kind/$_t/";

?>