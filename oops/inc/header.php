<?
if($popup=="1") include "../inc/header_popup.php";
else {
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$admin_title?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- <meta property="fb:app_id" content="APP_ID" /> -->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?=$title?>" />
  <meta property="og:url" content="<?=$send_url?>" />
  <meta property="og:description" content="<?=strip_tags($body)?>" />
  <meta property="og:image" content="<?=$logo_img?>" />

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=$root_url?>/bootstrap/css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">



  <!-- daterange picker -->
  <link rel="stylesheet" href="<?=$root_url?>/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?=$root_url?>/plugins/datepicker/datepicker3.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <!-- <link rel="stylesheet" href="<?=$root_url?>/plugins/iCheck/all.css"> -->
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?=$root_url?>/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?=$root_url?>/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?=$root_url?>/plugins/select2/select2.min.css">


  <!-- Theme style -->
  <link rel="stylesheet" href="<?=$root_url?>/dist/css/admin.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?=$root_url?>/dist/css/skins/skin-blue.css">



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- jQuery 2.2.3 -->
  <script src="<?=$root_url?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?=$root_url?>/bootstrap/js/bootstrap.min.js"></script>

  <script src="<?=$root_url?>/js/common.js"></script>

<?
//플레이어 스크립트
?>
  <link href="http://vjs.zencdn.net/6.2.0/video-js.css" rel="stylesheet">
  <!-- If you'd like to support IE8 -->
  <script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>


</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="<?=$root_url?>/index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?=$site_name?></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
	  <?if($logo_img) {?>
	  <img src="<?=$logo_img?>" alt="<?=$site_name?>" height="40">
	  <?} else {?>
	  <?=$site_name?>
	  <?}?>
	  </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">
		<?
		//include "../inc/top_menu.php";
		?>


          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
			<?if($img_staff) {?>
              <img src="<?=$img_staff?>" class="user-image" alt="User Image">
			<?}?>
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?=$SUPER_UNAME?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?=$root_url?>/logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>

          <li>
            <a href="<?=$root_url?>/logout.php"><i class="fa fa-power-off"></i> 로그아웃</a>
          </li>
        </ul>

      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
		  <?if($img_staff) {?>
          <img src="<?=$img_staff?>" class="img-circle" alt="<?=$SUPER_UNAME?>">
		  <?}?>
        </div>
        <div class="pull-left info">
          <p><?=$SUPER_UNAME?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->

<!--
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
 -->

      <!-- /.search form -->

      <!-- Sidebar Menu -->
	  <?
	  if($main_flag=="1") include "./inc/sidebar_menu.php";
	  else include "../inc/sidebar_menu.php";
	  ?>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
<?}?>