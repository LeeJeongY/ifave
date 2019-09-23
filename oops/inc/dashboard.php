
    <!-- Main content -->
    <section class="content">


      <!-- Main row -->
      <div class="row">

          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">

<?

	$_t	= "master"; 				//테이블 이름
	$foldername  = "../../$upload_dir/$_t/";

	if ($search_text != "") $qry_where .= " and $search like '%$search_text%'" ;
	$qry_where .= " AND use_flag='1'";

	$query = "SELECT count(idx) as cnt FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT NULL ";
	$query .= $qry_where;
	$result = mysql_query($query, $dbconn) or die (mysql_error());
	if($array=mysql_fetch_array($result)) {
		$total_no	= $array[cnt];
	}

?>
			<?
			if($total_no == 0) {
			?>


			<?
			} else {
				$query = "SELECT * FROM ".$initial."_bbs_".$_t." WHERE idx IS NOT NULL ";
				$query .= $qry_where;
				$query .= " ORDER BY signdate ASC";

				$result = mysql_query($query, $dbconn) or die (mysql_error());
				while ($array = mysql_fetch_array($result)) {
					$rot_num += 1;
					$idx			= $array[idx];
					$use_flag		= stripslashes($array[use_flag]);			//사용여부(Y, N)
					$bbs_name		= db2html(stripslashes($array[bbs_name]));	//제목
					$bbs_id			= db2html(stripslashes($array[bbs_id]));
					$user_file		= $array[user_file];
					$bbs_type		= $array[bbs_type];
					$bbs_kind		= $array[bbs_kind];
					$cate_flag		= $array[cate_flag];
					$cate_code		= $array[cate_code];
					$option_list	= stripslashes($array[option_list]);
					$img_flag		= stripslashes($array[img_flag]);
					$file_flag		= stripslashes($array[file_flag]);
					$counts			= $array[counts];								//조회수
					$signdate		= $array[signdate];
					$site			= $array[site];
					//$signdate	= substr($signdate, 0, 10);

					if($use_flag=="1")			$use_flag_txt = "<span class=\"label label-success\">사용</span>";
					if($use_flag=="0")			$use_flag_txt = "<span class=\"label label-danger\">정지</span>";

					if($bbs_kind=="board")		$bbs_kind_txt = "답변형";
					if($bbs_kind=="data")		$bbs_kind_txt = "자료형";
					if($bbs_kind=="gallery")	$bbs_kind_txt = "갤러리형";
					if($bbs_kind=="inquiry")	$bbs_kind_txt = "문의/요청형";
					if($bbs_kind=="popup")		$bbs_kind_txt = "팝업";

					if($bbs_type=="list")		$bbs_type_txt = "리스트형";
					if($bbs_type=="image")		$bbs_type_txt = "이미지형";
					if($bbs_type=="multi")		$bbs_type_txt = "이미지+리스트형";
					if($bbs_type=="sns")		$bbs_type_txt = "SNS형";

					if($cate_flag=="1")			$cate_flag_txt = "<span class=\"label label-success\">사용</span>";
					if($cate_flag=="0")			$cate_flag_txt = "<span class=\"label label-danger\">미사용</span>";


					if($bbs_kind=="popup")		$page_link = "popup";
					if($bbs_kind=="inquiry")	$page_link = "inquiry";
					else						$page_link = "board";


					$sql= "SELECT count(idx) as cnt FROM ".$initial."_bbs_".$bbs_id." WHERE idx IS NOT NULL";
					$rs = mysql_query($sql, $dbconn) or die (mysql_error());
					if($arr = mysql_fetch_array($rs)) {
						$tcnt	= $arr[cnt];
					}

					$sql= "SELECT count(idx) as cnt FROM ".$initial."_bbs_".$bbs_id." WHERE idx IS NOT NULL AND replace(left(regdate,10),'-','') = '".date("Ymd")."'";
					$rs = mysql_query($sql, $dbconn) or die (mysql_error());
					if($arr = mysql_fetch_array($rs)) {
						$cnt	= $arr[cnt];
					}

			?>
            <div class="box-header with-border">
              <h3 class="box-title"><?=$bbs_name?></h3>

              <div class="box-tools pull-right">
                total : <?=number_format($tcnt)?>, today : <?=number_format($cnt)?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th width="100">사이트구분</th>
                    <th width="100">일련번호</th>
                    <th>제목</th>
                    <th width="200"><?if($bbs_kind!="inquiry") {?>등록자<?} else {?>신청자<?}?></th>
                    <th width="100"><?if($bbs_kind!="inquiry") {?>조회수<?} else {?>상태<?}?></th>
                    <th width="200">등록일</th>
                  </tr>
                  </thead>
                  <tbody>
				<?
				$sub_query = "SELECT * FROM ".$initial."_bbs_".$bbs_id." WHERE idx IS NOT NULL ";
				//$sub_query .= " AND order_id"
				$sub_query .= " ORDER BY regdate DESC limit 5";
				$sub_result = mysql_query($sub_query, $dbconn) or die (mysql_error());
				while ($sub_array = mysql_fetch_array($sub_result)) {

					if($bbs_kind!="inquiry") {
						$sub_idx			= stripslashes($sub_array[idx]);
						$sub_category		= stripslashes($sub_array[category]);
						$sub_username		= db2html($sub_array[username]);
						$sub_email			= stripslashes($sub_array[email]);
						$sub_tel			= stripslashes($sub_array[tel]);
						$sub_title			= db2html($sub_array[title]);
						$sub_body			= db2html($sub_array[body]);
						$sub_regdate		= stripslashes($sub_array[regdate]);
						$sub_counts			= stripslashes($sub_array[counts]);
					} else {
						$sub_idx				= $sub_array[idx];
						$sub_category			= $sub_array[category];
						$sub_title				= db2html($sub_array[title]);
						$sub_username			= db2html($sub_array[user_name]);
						$sub_user_group			= stripslashes($sub_array[user_group]);
						$sub_tel			= stripslashes($sub_array[user_tel]);
						$sub_email			= stripslashes($sub_array[user_email]);
						$sub_question_type		= stripslashes($sub_array[question_type]);
						$sub_contents			= db2html($sub_array[contents]);
						$sub_user_ip			= stripslashes($sub_array[user_ip]);
						$sub_user_state			= stripslashes($sub_array[user_state]);
						$sub_regdate			= stripslashes($sub_array[regdate]);


					}


				?>
                  <tr>
                    <td><?=$sub_idx?></td>
                    <td><?=$site=="ko"?"<b>국문</b>":"영문"?></td>
                    <td align="left">
					<?if($bbs_kind!="inquiry") {?>
					<a href="./<?=$page_link?>/view.php?_t=<?=$bbs_id?>&idx=<?=$sub_idx?>"><?=$sub_title?></a>
					<?} else {?>
					<a href="javascript:_popup_page('./<?=$page_link?>/view.php?_t=<?=$bbs_id?>&idx=<?=$sub_idx?>&popup=1','_preview','750','600');"><?=$sub_title?></a>
					<?}?>

					</td>
                    <td><?=$sub_username?></td>
                    <td>
					<?if($bbs_kind!="inquiry") {?>
					<?=$sub_counts?>
					<?} else {?>
					<?=$sub_user_state=="0"?"<span class=\"label label-success\">신청</span>":""?>
					<?=$sub_user_state=="1"?"<span class=\"label label-warning\">확인</span>":""?>
					<?=$sub_user_state=="2"?"<span class=\"label label-danger\">완료</span>":""?>
					</span>
					<?}?>
					</td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20"><?=$sub_regdate?></div>
                    </td>
                  </tr>
				<?
				}
				?>
                  </tbody>
                </table>
              </div>


              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="./<?=$page_link?>/list.php?_t=<?=$bbs_id?>" class="btn btn-sm btn-info btn-flat pull-left">바로가기</a>
			  <?if($bbs_kind!="inquiry") {?>
              <a href="./<?=$page_link?>/write.php?_t=<?=$bbs_id?>" class="btn btn-sm btn-default btn-flat pull-right">글쓰기</a>
			  <?}?>
            </div>
            <!-- /.box-footer -->
			<?
						$cur_num --;
					}
				}
			?>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->