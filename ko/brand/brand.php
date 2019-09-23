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
						<dt>FAVE<br>스마트 밸런스 트레이너</dt>
						<dd>
							<span><strong>FAVE의 스마트 밸런스 트레이너</strong>는,</span>
							<span>기능성 트레이닝 운동기구와 ICT 기술을 융합한 스마트 헬스케어 제품입니다.</span>
							<span>스마트폰, PC/태블릿, AR/VR 기기, TV 등과 Bluetooth 연동이 가능하며</span>
							<span>모션감지센서가 사용자의 움직임을 감지하여, 게임 속 캐릭터의</span>
							<span>동작에 반영되는 제품입니다.</span>
						</dd>
					</dl>
				</div>
			</section>

            <section>
                <div class="funFave cfx">
                    <div class="fun">
						<dl>
							<dt><strong>운동 = 재미</strong></dt>
							<dd>
								<span>운동전문가집단에서 출발한 우리의 고민은,</span>
								<span>"어떻게 하면 모든 사람이 즐겁게 운동을 할 수 있을까"</span>
								<span>하는 것이었습니다. 우리는 신뢰할 수 있는 전문기관의 자문과</span>
								<span>협력을 통하여 그 해답을 스마트 밸런스 트레이너에 담았습니다.</span>
								<strong>재밌고 스마트한 운동습관, 스마트 밸런스 트레이너입니다.</strong>
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
						<dd>스마트 밸런스 트레이너는<br>
						온가족 모두가 좋아하는 세계 최고의 체감형 헬스케어 제품을<br>
						만들고자 하는 (주)건강한친구의 생각을 담고 있습니다.
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
							보디빌딩 선수출신이자 오랜기간 프로선수와<br>
							엘리트 운동선수들을 지도해 온 운동 전문가출신 CEO와<br>
							의학박사, 전자공학 전문가가 열정을 다해 만들어낸 제품입니다.<br>
							CEO는 한국에서는 다수의 대회에서 우승하였고<br>
							피트니스 세계대회 랭킹 Top5의 경력을 가지고 있습니다.
						</dd>
					</dl>
                </div>
            </section>

			<section>
                <div class="product">
					<dl>
						<dt>게이미피케이션 체감형 헬스케어 제품 : FAVE</dt>
						<dd>
							<strong>FAVE의 핵심가치 : </strong><br>
							게이미피케이션이란, 게임의 즐거움을 통해 문제를 해결하는 방식을 말합니다.<br>
							어린이의 성장과 성인의 비만 등, 현대인의 다양한 건강문제를<br>
							체감형 게임을 통해 즐겁게 해결하고자 합니다.<br>
							이제 복잡한 운동방법은 필요없습니다.<br>
							언제 어디서나 게임을 통해 운동을 신나게 즐기기만 하면 됩니다.
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
