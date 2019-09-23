<?
$comment_query = "select count(idx) from ".$initial."_board_comment where id is not null and id = '$id' and tbl ='$_t'";
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
		<div class="box-body">
		  <!-- Conversations are loaded here -->
		  <div class="direct-chat-messages">
			<!-- Message. Default to the left -->
			<div class="direct-chat-msg">

			  <!-- <div class="direct-chat-info clearfix">
				<span class="direct-chat-name pull-left">Alexander Pierce</span>
				<span class="username">
					<span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
				</span>
			  </div> -->

			  <div class="direct-chat-info clearfix">
					<span class="username">
					  <a href="#">Jonathan Burke Jr.</a>
					  <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
					</span>
					<span class="description">23 Jan 2:00 pm</span>
			  </div>

			  
			  <!-- <div class="user-block">
				<img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
					<span class="username">
					  <a href="#">Jonathan Burke Jr.</a>
					  <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
					</span>
				<span class="description">Shared publicly - 7:30 PM today</span>
			  </div> -->
			  <!-- /.direct-chat-info -->
			  <img class="direct-chat-img" src="../dist/img/user1-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
			  <div class="direct-chat-text">
				Is this template really for free? That's unbelievable!
			  </div><!-- /.direct-chat-text -->
			</div><!-- /.direct-chat-msg -->

			<!-- Message to the right -->
			<div class="direct-chat-msg right">
			  <div class="direct-chat-info clearfix">
				<span class="username">
					<a href="#">Sarah Bullock</a>
					<span class="description">23 Jan 2:05 pm</span>
				</span>
				<span class="username">
				  <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
				</span>
			  </div><!-- /.direct-chat-info -->
			  <img class="direct-chat-img" src="../dist/img/user3-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
			  <div class="direct-chat-text">
				You better believe it!
			  </div><!-- /.direct-chat-text -->
			</div><!-- /.direct-chat-msg -->
		  </div><!--/.direct-chat-messages-->

		  <!-- Contacts are loaded here -->
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
		</div><!-- /.box-body -->


		<div class="box-footer">
		  <form action="#" method="post">
			<div class="input-group">
			  <input type="text" name="message" placeholder="Type Message ..." class="form-control">
			  <span class="input-group-btn">
				<button type="button" class="btn btn-primary btn-flat">Send</button>
			  </span>
			</div>
		  </form>
		</div><!-- /.box-footer-->
	  </div><!--/.direct-chat -->