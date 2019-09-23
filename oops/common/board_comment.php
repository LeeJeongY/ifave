
<script>

	var c=false;
	function chn () {
		if ( c ) return;
		document.rfm.name.style.backgroundImage="";
		c=true;
	}

	var p=false;
	function chp () {
		if ( p ) return;
		document.rfm.passwd.style.backgroundImage="";
		p=true;
	}

	function showPasswordForm(str,gb){

		document.all.pwdLayer.style.display="";
		document.dform.idx.value = str;
		document.dform.gubun.value = gb;
		document.dform.passwd.focus();
	}

	function go_passwdSubmit() {
		if(document.dform.passwd.value == "") {
			alert('비밀번호를 입력하여 주십시요.');
			document.dform.passwd.focus();
			return false;
		}

		if(document.dform.gubun.value == "r_delete") {
			document.dform.action = "../common/board_comment_ok.php";
		}
	}


	function submitForm() {
		var fm = document.rform;
		if(fm.msg_text.value == "") {
			alert('내용을 입력하세요');
			fm.msg_text.focus();
			return false;
		}
		fm.method = "post";
	}

	function fn_recommdel(str, uid) {
		if (confirm("정말 삭제 하시겠습니까?") == true ) location.href = str;
	}


	var cflag = new Array();
	function CmtReplay(no){ 
		cflag[0] = 0;
		if(!cflag[no]){cflag[no] = 0; }
		if(cflag[no] == 0)
		{
			cflag[no] = 1;
			document.all['CmtRE'+no].style.display = ''; 
		}
		else if(cflag[no] == 1)
		{
			cflag[no] = 0;
			document.all['CmtRE'+no].style.display = 'none'; 
		}
		return;
	}

	//댓글 답변
	function go_CmtReplySubmit(str) {
		var form = eval("document.repfm"+str);
		if(form.msg_text.value == "") {
			alert('내용을 입력하세요!');
			form.msg_text.focus();
			return;
		}
		form.action = "../common/board_comment_ok.php";
		form.submit();
	}
</script>

	<?
	$comment_query = "select count(idx) from ".$initial."_bbs_boardcomment WHERE idx IS NOT NULL";
	$comment_query .= " AND fid = '$idx'";
	$comment_query .= " AND tbl	='$_t'";
	$comment_query .= " AND depth = 0";
	$comment_result = mysql_query($comment_query, $dbconn) or die (mysql_error());
	$comment_row = mysql_fetch_row($comment_result);
	$comment_total_no = $comment_row[0];
	?>
	  <div class="box box-primary direct-chat direct-chat-primary">
		<div class="box-header with-border">
		  <h3 class="box-title">댓글</h3>
		  <div class="box-tools pull-right">
			<span data-toggle="tooltip" title="<?=$comment_total_no?>의 새로운 댓글" class="badge bg-light-blue"><?=$comment_total_no?></span>
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
			<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		  </div>
		</div><!-- /.box-header -->


		<div class="box-footer">
		  <form name="rform" id="rform" action="../common/board_comment_ok.php" method="post">
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="fid" value="<?=$idx?>">
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="gubun" value="r_insert">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="search_text" value="<?=$search_text?>">
			<input type="hidden" name="gotourl" value="<?=$PHP_SELF?>">
			<input type="hidden" name="userid" value="<?=$SUPER_UID?>">
			<input type="hidden" name="username" value="<?=$SUPER_UNAME?>">
			<input type="hidden" name="adminid" value="<?=$SUPER_UID?>">
			<div class="input-group">
			  <input type="text" name="msg_text" id="msg_text" placeholder="입력하세요 ..." class="form-control" required>
			  <span class="input-group-btn">
				<button type="submit" class="btn btn-primary btn-flat">확인</button>
			  </span>
			</div>
		  </form>
		</div><!-- /.box-footer-->


		<div class="box-body">
		  <!-- Conversations are loaded here -->
		  <div class="direct-chat-messages">

<?
	$comment_query = " SELECT * FROM ".$initial."_bbs_boardcomment WHERE idx IS NOT NULL";
	$comment_query .= " AND fid = '$idx'";
	$comment_query .= " AND tbl	='$_t'";
	$comment_query .= " AND depth = 0";
	$comment_query .= " ORDER BY thread DESC, idx ASC";
	$comment_result=mysql_query($comment_query, $dbconn) or die (mysql_error());
	$r_num = 0;
	while ($comment_array=mysql_fetch_array($comment_result)) {

		$r_idx        	= stripslashes($comment_array[idx]);
		$r_fid        	= stripslashes($comment_array[fid]);
		$r_tbl        	= stripslashes($comment_array[tbl]);
		$r_username   	= db2html($comment_array[username]);
		$r_userid     	= stripslashes($comment_array[userid]);
		$r_passwd     	= stripslashes($comment_array[passwd]);
		$r_userip     	= stripslashes($comment_array[userip]);
		$r_msg_text   	= db2html($comment_array[msg_text]);
		$r_regdate    	= stripslashes($comment_array[regdate]);
		$r_org_idx    	= stripslashes($comment_array[org_idx]);
		$r_thread     	= stripslashes($comment_array[thread]);
		$r_depth      	= stripslashes($comment_array[depth]);
		$r_pos        	= stripslashes($comment_array[pos]);
		$r_thread2    	= stripslashes($comment_array[thread2]);
		$r_referer_url	= stripslashes($comment_array[referer_url]);
		$r_device     	= stripslashes($comment_array[device]);
		$r_adminid     	= stripslashes($comment_array[adminid]);
		if (substr($r_regdate,0,10) == date("Y-m-d")) $r_regdate = substr($r_regdate,11,5);
		else $r_regdate = substr($r_regdate,0,10);



		//댓글 답글/////////////////////////////////////
		$comment_depth		= $r_depth + 1;
		$que2 = "SELECT count(idx) FROM ".$initial."_bbs_boardcomment " ;
		$que2 .= " WHERE fid = '$idx'";
		$que2 .= " AND tbl ='$_t'";
		$que2 .= " AND thread='$r_thread'";
		$que2 .=" AND depth > '$r_depth'" ;
		$result2 = mysql_query($que2,$dbconn);
		$row2 = mysql_fetch_row($result2);
		$comment_plus_pos = $row2[0] ;

		$comment_pos = $r_pos + $comment_plus_pos + 1 ;
		///////////////////////////////////////////

		$que3 = "SELECT count(idx) FROM ".$initial."_bbs_boardcomment" ;
		$que3 .= " WHERE fid = '$idx'";
		$que3 .= " AND tbl ='$_t'";
		$que3 .= " AND depth > 0";
		$que3 .= " AND org_idx = '$r_idx'";
		$rs3 = mysql_query($que3,$dbconn);
		$row3 = mysql_fetch_row($rs3);
		$reply_cnt = $row3[0] ;


?>

			<!-- Message. Default to the left -->
			<div class="direct-chat-msg <?=$r_adminid!=""?" right":""?>">
			  <div class="direct-chat-info clearfix">
					<?if($r_adminid!="") {?>
					<span class="username">
						<a href="#"><?=$r_username?></a>
					<span class="description"><?=$r_regdate?></span>
					</span>
					<span class="username">
						<a href="javascript:fn_recommdel('../common/board_comment_ok.php?idx=<?=$r_idx?>&gubun=r_delete&_t=<?=$_t?>&fid=<?=$idx?>&search=<?=$search?>&search_text=<?=$search_text?>&pot=<?=$opt?>&gotourl=<?=$PHP_SELF?>','<?=$r_userid?>')" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
					</span>
					<?} else {?>
					<span class="username">
					  <a href="#"><?=$r_username?></a>
					  <a href="javascript:fn_recommdel('../common/board_comment_ok.php?idx=<?=$r_idx?>&gubun=r_delete&_t=<?=$_t?>&fid=<?=$idx?>&search=<?=$search?>&search_text=<?=$search_text?>&gotourl=<?=$PHP_SELF?>','<?=$r_userid?>')" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
					</span>
					<span class="description"><?=$r_regdate?></span>
					<?}?>
			  </div>
			  <!-- /.direct-chat-info -->
			  <img class="direct-chat-img" src="../dist/img/user1-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
			  <div class="direct-chat-text">
				<?=$r_msg_text?>
			  </div><!-- /.direct-chat-text -->
			</div><!-- /.direct-chat-msg -->


			<p><span style="font-size:11px;font-weight:bold;"><a href="javascript:CmtReplay('<?=$r_idx?>')"><i class="fa fa-reply transform"></i> 답글 <b><?=$reply_cnt?></b></a>&nbsp;</span></p>

			<div id="CmtRE<?=$r_idx?>" style="display :none;">
			
			<form name="repfm<?=$r_idx?>" method="psot" action="">
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="fid" value="<?=$idx?>">
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="gubun" value="r_reply">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="search_text" value="<?=$search_text?>">
			<input type="hidden" name="gotourl" value="<?=$PHP_SELF?>">
			<input type="hidden" name="userid" value="<?=$SUPER_UID?>">
			<input type="hidden" name="username" value="<?=$SUPER_UNAME?>">
			<input type="hidden" name="pos" value="<?=$comment_pos?>">
			<input type="hidden" name="thread" value="<?=$r_thread?>">
			<input type="hidden" name="depth" value="<?=$comment_depth?>">
			<input type="hidden" name="org_idx" value="<?=$r_idx?>">

			<div class="input-group">
			  <input type="text" name="msg_text" id="msg_text" placeholder="입력하세요 ..." class="form-control" required>
			  <span class="input-group-btn">
				<a class="btn btn-primary btn-flat" href="javascript:go_CmtReplySubmit('<?=$r_idx?>')">확인</a>
			  </span>
			</div>

			</form>
			<?
				

			$que4 = " SELECT *  FROM ".$initial."_bbs_boardcomment WHERE fid = '$idx' AND tbl ='$_t'";
			$que4 .= " AND depth > 0";
			$que4 .= " AND org_idx = '$r_idx'";
			$que4 .= " ORDER BY thread DESC, idx ASC";
			$rs4 = mysql_query($que4, $dbconn);
			while ($arr4=mysql_fetch_array($rs4)) {
				$rep_idx        	= $arr4[idx];
				$rep_fid        	= $arr4[fid];
				$rep_tbl        	= $arr4[tbl];
				$rep_username   	= db2html($arr4[username]);
				$rep_userid     	= $arr4[userid];
				$rep_passwd     	= $arr4[passwd];
				$rep_userip     	= $arr4[userip];
				$rep_msg_text   	= db2html($arr4[msg_text]);
				$rep_regdate    	= $arr4[regdate];
				$rep_ord_idx    	= $arr4[ord_idx];
				$rep_thread     	= $arr4[thread];
				$rep_depth      	= $arr4[depth];
				$rep_pos        	= $arr4[pos];
				$rep_thread2    	= $arr4[thread2];
				$rep_referer_url	= $arr4[referer_url];
				$rep_device     	= $arr4[device];
				$rep_adminid    	= $arr4[adminid];
				if (substr($rep_regdate,0,10) == date("Y-m-d")) $rep_regdate = substr($rep_regdate,11,5);
				else $rep_regdate = substr($rep_regdate,0,10);
		 
			?>
			<p><i class="fa fa-reply transform"></i>&nbsp;<b><?=$rep_username?></b> <?=$rep_msg_text?> <span class="description"><?=$rep_regdate?></span> <a href="javascript:;"   onClick="fn_recommdel('../common/board_comment_ok.php?idx=<?=$rep_idx?>&gubun=r_delete&_t=<?=$_t?>&fid=<?=$idx?>&search=<?=$search?>&search_text=<?=$search_text?>&gotourl=<?=$PHP_SELF?>','<?=$rep_userid?>')"><i class="fa fa-times"></i></a></p>
			<?
			}
			?>
			</div>



<?
		$r_num++;
	}
?>
		  </div><!--/.direct-chat-messages-->



		  <!-- Contacts are loaded here -->
		  <?if($comment_total_no > 0) {?>
		  <div class="direct-chat-contacts">
			<ul class="contacts-list">
			  <li>
				<a href="#">
				  <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg" alt="Contact Avatar">
				  <div class="contacts-list-info">
					<span class="contacts-list-name">
					  Count Dracula
					  <small class="contacts-list-date pull-right">2/28/2015</small>
					</span>
					<span class="contacts-list-msg">How have you been? I was...</span>
				  </div><!-- /.contacts-list-info -->
				</a>
			  </li><!-- End Contact Item -->
			</ul><!-- /.contatcts-list -->
		  </div><!-- /.direct-chat-pane -->
		  <?}?>


		</div><!-- /.box-body -->

		<?if($comment_total_no > 0) {?>
		<div class="box-footer">
		  <form name="rform2" id="rform" action="../common/board_comment_ok.php" method="post">
			<input type="hidden" name="_t" value="<?=$_t?>">
			<input type="hidden" name="fid" value="<?=$idx?>">
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="gubun" value="r_insert">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="search_text" value="<?=$search_text?>">
			<input type="hidden" name="gotourl" value="<?=$PHP_SELF?>">			
			<input type="hidden" name="userid" value="<?=$SUPER_UID?>">
			<input type="hidden" name="username" value="<?=$SUPER_UNAME?>">
			<input type="hidden" name="adminid" value="<?=$SUPER_UID?>">
			<div class="input-group">
			  <input type="text" name="msg_text" id="msg_text" placeholder="입력하세요 ..." class="form-control" required>
			  <span class="input-group-btn">
				<button type="submit" class="btn btn-primary btn-flat">확인</button>
			  </span>
			</div>
		  </form>
		</div>
		<!-- /.box-footer-->
		<?}?>


	  </div><!--/.direct-chat -->