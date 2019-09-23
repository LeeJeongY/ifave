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
				<div class="cont_my">
					<h2>My page</h2>
					<p>Edit membership information</p>
					<div class="myInfo">
						<p>USER NAME</p>
						<ul class="my-ul1">
							<li>
								<strong>Membership</strong>
								<span>General</span>
							</li>
							<li>
								<strong>Mobile phone number</strong>
								<span>010-000-0000</span>
							</li>
						</ul>
						<ul class="my-ul2">
							<li>
								<strong>Email address</strong>
								<span>iqv@iqv.co.kr</span>
							</li>
							<li>
								<strong>Delivery Address</strong>
								<span>Busan, Centum jungang-ro 97</span>
							</li>
						</ul>
						<a href="#n" class="btn-info-modify"><span class="blind">개인정보수정</span></a>
					</div>

					<article>
						<div class="orderHistory">
							<h3>Order History</h3>
							<table class="oTable">
								<colgroup>
									<col width="30%">
									<col width="40%">
									<col width="30%">
								</colgroup>
								<thead>
									<tr>
										<th>Order Number</th>
										<th>Product name</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>41832</td>
										<td class="product-name">FAVE 350</td>
										<td>2018.11.10</td>
									</tr>
								</tbody>
							</table>
						</div>
					</article>

					<div class="btn-area">
						<a href="/" class="btn-c btn-more">+MORE</a>
					</div>

				</div>
			</section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
