<?php

	switch ($search_type) {
		case 'client_search':	$tmpTitle = "회사 정보 찾기";
		break;
		case 'coach_search'	:	$tmpTitle = "강사 찾기";
		break;
		case 'code_search'	:	$tmpTitle = "콘텐츠 찾기";
		break;
		default	:	$tmpTitle = "팝업 공지";
		break;
	}// end switch

?>

    <section class="content-header">
      <h1>
       <?=$tmpTitle?>
        <small> 팝업관리</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 팝업관리</a></li>
        <li class="active"><?=$tmpTitle?></li>
      </ol>
    </section>