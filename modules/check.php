<?php
//로그인 체크
if($SUPER_UID=="") {
	//include "../common/login_false.php";
	//exit;
	?>
	<script>
	alert('로그인 정보가 없습니다.');
	location.href = "<?=$root_url?>/login.php";
	</script>
	<?
	exit;
}


if($SUPER_UIMG!="") {
	$img_staff = "../../".$upload_dir."/staff/".$SUPER_UIMG;
} else {
	$img_staff = "../../".$upload_dir."/staff/noimg.png";
}
?>