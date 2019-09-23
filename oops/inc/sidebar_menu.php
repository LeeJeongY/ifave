
      <ul class="sidebar-menu">
        <li class="header">MENU NAVIGATION</li>
        <!-- Optionally, you can add icons to the links -->
<?php
	$menu_que = "select a.bid, a.name, a.url, a.flag from ".$initial."_menu_admin1 a, ".$initial."_menu_grade b where a.bid is not null ";
	$menu_que .= " and b.userid='".$SUPER_UID."'";
	$menu_que .= " and a.bid=b.bid";
	$menu_que .= " and b.sitegubun='1'";
	$menu_que .= " group by a.bid";
	$menu_que .= " order by bid asc";
	$menu_rst = mysql_query($menu_que, $dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
	while ($menu_arr = mysql_fetch_array($menu_rst)) {
		$menu_bid		= $menu_arr[bid];
		$menu_name		= db2html($menu_arr[name]);	  //이름
		$menu_url		= $menu_arr[url];
		$menu_flag		= $menu_arr[flag];

		if($menu_bid!="") {
?>
			<li class="treeview<?if($menu_bid==$menu_b) {?> active<?}?>">

				<a href="#"><i class="fa fa-link"></i> <span><?//=$menu_bid?> <?=$menu_name?></span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
		<?
		$menu2_que = "select a.mid, a.name, a.url, a.flag from ".$initial."_menu_admin2 a, ".$initial."_menu_grade b where a.mid is not null ";
		$menu2_que .= " and a.bid = '".$menu_bid."'";
		$menu2_que .= " and b.userid='".$SUPER_UID."'";
		$menu2_que .= " and a.bid=b.bid";
		$menu2_que .= " and a.mid=b.mid";
		$menu2_que .= " and b.sitegubun='1'";
		$menu2_que .= " order by a.mid asc";
		$menu2_rst = mysql_query($menu2_que,$dbconn) or die (mysql_error()); // 쿼리문을 실행 결과
		while ($menu2_arr = mysql_fetch_array($menu2_rst)) {
			$menu_mid		= $menu2_arr[mid];
			$menu_mname		= db2html($menu2_arr[name]);	  //이름
			$menu_murl		= $menu2_arr[url];
			$menu_mflag		= $menu2_arr[flag];

			if($main_flag == "1") {
				$menu_murl = substr($menu_murl, 1, strlen($menu_murl)-1);
			}

			if($menu_murl != "") {
				if(preg_match("/_t=/i", $menu_murl)) {
					$menu_murl = "$menu_murl&menu_b=$menu_bid&menu_m=$menu_mid";
				} else {
					$menu_murl = "$menu_murl?menu_b=$menu_bid&menu_m=$menu_mid";
				}
		?>
					<li<?if($menu_mid==$menu_m) {?> class="active"<?}?>><a href="<?=$menu_murl?>"><i class="fa fa-circle-o"></i> <?=$menu_mname?></a></li>
		<?
			}
		}
		?>
				</ul>
			</li>

		<?
		}
	}
	?>
	</ul>