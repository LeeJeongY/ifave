<?
		$qry_where = " and view_flag='1'";
		$qry_where = " and site='".$lng."'";
		$query = "SELECT count(idx) as cnt FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT NULL ";
		$query .= $qry_where;
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		$total_no = 0;
		if($array = mysql_fetch_array($result)) {
			$total_no		= $array[cnt];
		}

		if($total_no > 0) {

			$query  = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT NULL";
			$query .= $qry_where;
			$query .= " ORDER BY thread DESC, pos ASC LIMIT 3";
			$result = mysql_query($query, $dbconn) or die (mysql_error());

			while ($array = mysql_fetch_array($result)) {
				$idx			= stripslashes($array[idx]);
				$view_flag		= stripslashes($array[view_flag]);
				$category		= stripslashes($array[category]);
				$title			= db2html($array[title]);
				$notice_yn		= stripslashes($array[notice_yn]);
				$subject		= cut_string($title, 50, "..");
				$regdate		= substr(stripslashes($array[regdate]), 0, 10);
				?>
				<li>
					<a href="/board/view.php?idx=<?=$idx?>&gubun=view&_t=<?=$_t?>&lng=<?=$lng?>"><?=$subject?></a>
				</li>
				<?
			}
		}
?>