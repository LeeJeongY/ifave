<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../modules/dbcon.php";
	include "../modules/config.php";
	include "../modules/func.php";
	include "../modules/func_q.php";

	$lng				= "en";
	$_SESSION['lng']	= $lng;


	if($tbl=="") $tbl	= "member";
	$foldername  = "./$upload_dir/$tbl/";
	if($returnurl == "") $returnurl = $_SERVER["HTTP_REFERER"];

	include "./inc/header.php";
?>
		<!-- container -->
		<div id="container">

		<?
		// Ȩ���丮��
		// index.en.php : ����, index.ko.php : ����

		include "../index.en.php";


		?>

		</div>
		<!-- //container -->
<?
	include "inc/footer.php";
	mysql_close($dbconn);
?>