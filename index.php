<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "./modules/dbcon.php";
	include "./modules/config.php";
	include "./modules/func.php";
	include "./modules/func_q.php";




	if($tbl=="") $tbl	= "member";
	$foldername  = "./$upload_dir/$tbl/";
	if($returnurl == "") $returnurl = $_SERVER["HTTP_REFERER"];

	include "./".$lng."/inc/header.php";
?>
		<!-- container -->
		<div id="container">

		<?

		// index.en.php : 영문, index.ko.php : 국문

		include "./index.".$lng.".php";


		?>

		</div>
		<!-- //container -->
<?
	include "./".$lng."/inc/footer.php";
	mysql_close($dbconn);
?>