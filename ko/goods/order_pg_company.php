<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";

?>
<!DOCTYPE HTML>
<html lang="ko">
<head>
<title>FAVE Smart Balance Trainer</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="description" content="FAVE Smart Balance Trainer" />
<meta name="keywords" content="FAVE Smart Balance Trainer" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" type="text/css" href="../css/common.css" />

</head>

<body>
	<div id="wrap">
		<!-- container -->
		<div id="container">

			<section>
				<div class="cont_sign">
					<h2>credit card payment</h2>

						<div class="btn-area">
							<a href="javascript:;" class="btn-orange btn-c">PG사 연동 할 것</a>
							<a href="javascript:self.close();" class="btn-white ml25 btn-c">Close</a>
						</div>

					</form>
				</div>
			</section>

		</div>
		<!-- //container -->

	</div>
</body>
</html>
<?
mysql_close($dbconn);
?>
