
			<section>
				<div class="main_cont" >
					<!-- visual -->
					<div class="main_visual">
						<!-- slide big img -->
						<ul class="main_slide_box">
							<li class="visual_1">
								<div class="vic">
									<span>Exciting Balance Exercise</span>
									<p>Smart Balance<br>Trainer</p>
									<a href="/<?=$lng?>/goods/">FAVE PRODUCTS INFO</a>
								</div>
							</li>
							<li class="visual_2">
								<div class="vic vic2">
									<span>Smart Balance Trainer</span>
									<p>Exercising Makes you<br>happy</p>
									<a href="/<?=$lng?>/goods/">FAVE PRODUCTS INFO</a>
								</div>
							</li>
							<li class="visual_3">
								<div class="vic vic2">
									<span>Smart Balance Trainer</span>
									<p>Impressionable IOT<br>healthcare platform</p>
									<a href="/<?=$lng?>/goods/">FAVE PRODUCTS INFO</a>
								</div>
							</li>
							<li class="visual_4">
								<div class="vic vic2">
									<span>Smart Balance Trainer</span>
									<p>Balancing exerxise<br>by playing games!</p>
									<a href="/<?=$lng?>/goods/">FAVE PRODUCTS INFO</a>
								</div>
							</li>
						</ul>
						<div class="main_bx_btn_box">
							<p class="bx_prev"><span>이전페이지</span></p>
							<p class="bx_next"><span>다음페이지</span></p>
						</div>
					</div>
					<!-- //visual -->
				</div>
			</section>
            <section>
                <div class="recentWrap cfx">
                    <div class="notice recent">
						<h3>Notice</h3>
						<ul>
							<?
							$_t = "notice";
							include "modules/main_board.php";
							?>
							<!--
							<li>
								<a href="#n">LEARN AND RUN! TURN YOUR PASSION INTO…</a>
							</li>
							<li>
								<a href="#n">LEARN AND RUN! TURN YOUR PASSION INTO…</a>
							</li>
							<li>
								<a href="#n">LEARN AND RUN! TURN YOUR PASSION INTO…</a>
							</li> -->
						</ul>
						<a href="/board/list.php?_t=notice&lng=<?=$lng?>"><span class="blind">더보기</span></a>
                    </div>
                    <div class="pr recent">
						<h3>PR</h3>
						<ul>
							<?
							$_t = "pr";
							include "modules/main_board.php";
							?>
							<!-- <li>
								<a href="#n">LEARN AND RUN! TURN YOUR PASSION INTO…</a>
							</li>
							<li>
								<a href="#n">LEARN AND RUN! TURN YOUR PASSION INTO…</a>
							</li>
							<li>
								<a href="#n">LEARN AND RUN! TURN YOUR PASSION INTO…</a>
							</li> -->
						</ul>
						<a href="/board/list.php?_t=pr&lng=<?=$lng?>"><span class="blind">더보기</span></a>
                    </div>
                </div>
            </section>

            <section>
                <div class="movieWrap cfx">
					<div>
						<div class="child"></div>
						<div class="load-movie">
							<video controls preload="auto" autoplay="" muted="" loop="" poster="">
							   <source src="/movie/mv.mp4" type="video/mp4">
							   <source src="/movie/mv.ogg" type="video/mp4">
							   IE 8 이하는 비디오가 나오지 않습니다. IE 버전을 업데이트 하시길 바랍니다.
							</video>
						</div>
					</div>
                </div>
            </section>
