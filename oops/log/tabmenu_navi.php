
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li <?=eregi("stat.php", $PHP_SELF)?"class=\"active\"":""?>><a href="stat.php?tbl=<?=$tbl?>">접속통계</a></li>
				<li <?=eregi("ip.php", $PHP_SELF)?"class=\"active\"":""?>><a href="ip.php?tbl=<?=$tbl?>">IP 접속로그</a></li>
				<li <?=eregi("connect.php", $PHP_SELF)?"class=\"active\"":""?>><a href="connect.php?tbl=<?=$tbl?>">접속경로 상세내역</a></li>
			</ul>
		</div>