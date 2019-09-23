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
					<h2>Order</h2>
					<form>
						<article>
							<div class="orderInfo">
								<h3>Order Information</h3>
								<table class="oTable">
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
							<div class="payBox">
								<h3>Buyer Information</h3>
								<ul class="inList">
									<li>
										<label for="name">Name</label>
										<ul>
											<li><input type="text" class="itx int1" name="name" id="name"></li>
										</ul>
									</li>
									<li>
										<label for="p-contact">Contact</label>
										<ul class="d-type">
											<li>
												<select class="selec1 int6">
													<option>Select</option>
												</select>
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int7">
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int7">
											</li>
										</ul>
									</li>
									<li>
										<label for="email">e-mail</label>
										<ul>
											<li><input type="text" class="itx int3" name="email" id="email"></li>
										</ul>
									</li>
								</ul>
							</div>
						</article>

						<article>
							<div class="payBox">
								<h3>Shipping Information</h3>
								<ul class="inList">
									<li>
										<label for="receiver">Receiver</label>
										<ul>
											<li><input type="text" class="itx int1" name="receiver" id="receiver"></li>
										</ul>
									</li>
									<li>
										<label for="s-contact">Contact</label>
										<ul class="d-type">
											<li>
												<select class="selec1 int6">
													<option>Select</option>
												</select>
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int7">
											</li>
											<li class="dash">-</li>
											<li>
												<input type="text" class="itx int7">
											</li>
										</ul>
									</li>
									<li>
										<label for="home-addr">Address</label>
										<ul class="d-type-addr">
											<li>
												<input type="text" class="itx int2">
												<input type="button" class="ibx2" name="home-addr" id="home-addr" value="Search address">
											</li>
											<li>
												<input type="text" class="itx int2">
												<input type="text" class="itx int4">
											</li>
										</ul>
									</li>
									<li>
										<label for="message">Shipping Message</label>
										<ul>
											<li style="display:block;"><textarea class="itx txta1" name="message" id="message"></textarea></li>
										</ul>
									</li>
								</ul>

							</div>
						</article>

						<div class="totalBox cfx">
							<ul>
								<li>
									<strong>Total product amount</strong>
									<span><strong>215,000</strong> won</span>
								</li>
								<li>
									<strong>Shipping fee</strong>
									<span><strong>2,500</strong> won</span>
								</li>
							</ul>
							<dl>
								<dt>Total payment amount</dt>
								<dd><strong>217,500</strong> won</dd>
							</dl>
							<a href="order_complete.php" class="btn-complete payment btn-c">MAKE A PAYMENT</a>
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
