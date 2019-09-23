<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";

	include "../inc/header.php";
?>

		<!-- container -->
		<div id="container">

			<section>
				<div class="cont_sign">
					<h2>Thank you for your order!</h2>
					<form>
						<article>
							<div class="payComBox mt60">
								<table class="oTable1">
									<colgroup>
										<col width="70%">
										<col width="30%">
									</colgroup>
									<thead>
										<tr>
											<th colspan="2">Product name</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="o-product">
												<strong>FAVE 350</strong>
												<span>Quantity / 1</span>
											</td>
											<td class="o-price">215,000 won</td>
										</tr>
									</tbody>
								</table>
							</div>
						</article>

						<article>
							<div class="payComBox">
								<table class="oTable1">
									<colgroup>
										<col width="70%">
										<col width="30%">
									</colgroup>
									<thead>
										<tr>
											<th colspan="2">Payment Information</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="o-product">
												<span>Paypal express cheakout</span>
											</td>
											<td class="o-price">215,000 won</td>
										</tr>
									</tbody>
								</table>
							</div>
						</article>

						<article>
							<div class="payComBox">
								<table class="oTable2">
									<colgroup>
										<col width="25%">
										<col width="75%">
									</colgroup>
									<thead>
										<tr>
											<th colspan="2">Payment Information</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th>Buyer Name</th>
											<td>iqv</td>
										</tr>
										<tr>
											<th>Recipient Name</th>
											<td>iqv</td>
										</tr>
										<tr>
											<th>Shipping address</th>
											<td>Busan, Centum jungang-ro 97</td>
										</tr>
										<tr>
											<th>Contact</th>
											<td>010-000-0000</td>
										</tr>
									</tbody>
								</table>
							</div>
						</article>

						<div class="btn-area">
							<a href="/" class="btn-orange btn-c">My page</a>
							<a href="/" class="btn-white ml25 btn-c">Home</a>
						</div>

					</form>
				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
