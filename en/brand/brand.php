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
				<div class="sv_intro">
					<dl>
						<dt>Smart Balance<br>Trainer</dt>
						<dd>A smart healthcare product that<br>
						combines functional training equipment<br>
						and ICT technology.
						</dd>
					</dl>
				</div>
			</section>

            <section>
                <div class="funFave cfx">
                    <div class="fun">
						<dl>
							<dt><strong>Working Out </strong>Can BE<strong> FUN!</strong></dt>
							<dd>
								<div class="fun_pc">
									SMART BALANCE TRAINER is<br>
									Motion detection sensor is built in the product,<br>
									so you can enjoy mobile games and<br>
									various sensible contents,<br>
									and you can receive health information<br>
									<strong>related to exercise through smart device app.</strong>
								</div>
								<div class="fun_mobile">
									SMART BALANCE TRAINER is<br>
									Motion detection sensor is<br>
									built in the product, so you<br>
									can enjoy mobile games and<br>
									various sensible contents,<br>
									and you can receive health<br> 
									information related to exercise<br> 
									<strong>through smart device app.</strong>
								</div>
							</dd>
						</dl>
                    </div>
                    <div class="fave">
						<dl>
							<dt><img src="/images/contents/sv1-logo.png" alt="FAVE"></dt>
							<dd>
								<strong>F</strong>amily<br>
								<strong>A</strong>ce<br>
								<strong>V</strong>irtualize<br>
								<strong>E</strong>ntertainment
							</dd>
						</dl>
                    </div>
                </div>
            </section>

            <section>
                <div class="brand">
					<dl>
						<dt>BRAND STORY</dt>
						<dd>The whole family loves the best<br>
						health care products in the world.<br>
						It contains the thoughts of strong friends.
						</dd>
					</dl>
					<div class="brand-img"></div>
                </div>
            </section>

			<section>
                <div class="mania">
					<dl>
						<dt>2015 Musclemania 1st<br>
						2015 Fitness Universe (Las vegas) Top5
						</dt>
						<dd>
							I've been a bodybuilding player and<br>
							I've been working with professional athletes and<br>
							elite athletes for a long time.<br>
							I've been a sports expert. It's a passionate product.
						</dd>
					</dl>
                </div>
            </section>

			<section>
                <div class="product">
					<dl>
						<dt>Gamification Healthcare Product : <strong>FAVE</strong></dt>
						<dd>
							What is a Gamification?<br>
							The fun of games is how to solve problems.<br>
							the growth of children and obesity of adults.<br>
							What you're trying to do with fun using a game of impression?<br>
							The core value of FAVE.
						</dd>
					</dl>
					<div class="prod-img"></div>
                </div>
            </section>

		</div>
		<!-- //container -->

<?
include("../inc/footer.php");
mysql_close($dbconn);
?>
