<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";



	$link_url = "$PHP_SELF?flag=$flag&q=$q&";

	if($q) {
		$key = "qKcHPUfKH6R6kwncOqbEg3eXfAk18Qv%2BPGWmqe9tuDF%2FVFwv%2FS7OsTGLmxZeC0R8anTfFzlrC9n1T1W6AzZNnw%3D%3D";

		if($currentPage == "") $currentPage = 1;
		if($countPerPage == "") $countPerPage = 20;
		$page_num	= 10;

		$ch = curl_init();
		$url = 'http://openapi.epost.go.kr/postal/retrieveNewAdressAreaCdSearchAllService/retrieveNewAdressAreaCdSearchAllService/getNewAddressListAreaCdSearchAll'; /*URL*/
		$queryParams = '?' . urlencode('ServiceKey') . '=' . $key; /*Service Key*/
		//$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('999'); /*검색건수*/
		//$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode($pageNo); /*페이지 번호*/
		$queryParams .= '&' . urlencode('countPerPage') . '=' . urlencode($countPerPage); /*페이지당 출력 개수*/
		$queryParams .= '&' . urlencode('currentPage') . '=' . urlencode($currentPage); /*페이지 번호*/
		$queryParams .= '&' . urlencode('srchwrd') . '=' . urlencode($q); /*검색어*/


		curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$response = curl_exec($ch);
		//curl_close($ch);
		//var_dump($response);
		//print_r($response);
		//convert the XML result into array
		if($response === false){
			$error = curl_error($ch);
			echo $error;
			die('error occured');
		} else {

			//$xml = json_decode(json_encode(simplexml_load_string($response)), true);
			$xml = simplexml_load_string($response);
		}
		curl_close($ch);
	}

	$responseTime	= $xml->cmmMsgHeader->responseTime;
	$totalCount		= $xml->cmmMsgHeader->totalCount;
	//$countPerPage	= $xml->cmmMsgHeader->countPerPage;
	$totalPage		= $xml->cmmMsgHeader->totalPage;
	//$currentPage	= $xml->cmmMsgHeader->currentPage;

	include "../inc/header_popup.php";
?>
	<script language="javascript">
	<!--
	function addr_select(arg1, arg2, arg3){

	  if (document.sform.q.value != "") {
		 <?if($flag=="h") {?>
		  opener.document.getElementById("zipcode").value = arg1;
		  opener.document.getElementById("addr1").value = arg2;
		  opener.document.getElementById("addr2").value = arg3;
		  opener.document.getElementById("addr3").focus();

		 <?} else if($flag=="p") {?>
		  window.opener.document.form.pay_zipcode.value	= arg1;
		  window.opener.document.form.pay_addr1.value	= arg2;
		  window.opener.document.form.pay_addr2.value	= arg3;
		  window.opener.document.form.pay_addr3.focus();
		 <?} else if($flag=="o") {?>
		  window.opener.document.form.order_zipcode.value	= arg1;
		  window.opener.document.form.order_addr1.value	= arg2;
		  window.opener.document.form.order_addr2.value	= arg3;
		  window.opener.document.form.order_addr3.focus();
		 <?} else if($flag=="r") {?>
		  window.opener.document.form.receive_zipcode.value	= arg1;
		  window.opener.document.form.receive_addr1.value	= arg2;
		  window.opener.document.form.receive_addr2.value	= arg3;
		  window.opener.document.form.receive_addr3.focus();
		 <?} else {?>
		  window.opener.document.form.zipcode.value	= arg1;
		  window.opener.document.form.addr1.value	= arg2;
		  window.opener.document.form.addr2.value	= arg3;
		  window.opener.document.form.addr3.focus();
		 <?}?>
		  this.close();
	  }	else	{
		alert("검색주소를 입력해 주세요.");
		document.sform.q.focus();
		return;
	  }
	}

	function go_submit() {
	  if (document.sform.q.value==""){
		alert("도로명 또는 동이름을 입력하세요.");
		document.sform.q.focus();
		return;
	  }
	  document.sform.submit();
	}

	function cancel_Click() {
	  this.close();
	}
	//-->
	</SCRIPT>

  <!-- Content Wrapper. Contains page content -->
  <div class="popup-content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        우편번호 검색
        <small>전국 우편번호 검색</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 우편번호 검색</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="width:95%">

      <!-- Your Page Content Here -->

		<div class="row">

			<form name="sform" onsubmit="return go_sumbit()">
			<input type="hidden" name="flag" value="<?=$flag?>" />
			<div class="box box-success col-xs-10">
				<div class="box-header with-border">
				  <h3 class="box-title">도로명 또는 지번을 입력하여 검색</h3>
				</div>
				<div class="box-body">

					<div class="form-group">
					  <div class="row">
							<div class="input-group input-group-sm">

								<input type="text" class="form-control" name="q" id="q" value="<?=$q?>" placeholder="예) 부암동, 부암1동, 신천대로 246 등">
								<span class="input-group-btn">
								  <a type="button" class="btn btn-info btn-flat" href="javascript:_address()"><i class="fa fa-search"></i> 검색</a>
								</span>
							</div>
					  </div>
					</div>

				</div>
			</div>
			<!-- /.box -->

			<?if($q=="") {
				$totalCount = 0;
			}?>
            <div class="box-header">
              <h3 class="box-title">Total : <?=$totalCount?></h3>
            </div>

          <div class="box">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th nowrap width="10">선택</th>
                  <th nowrap width="100">우편번호</th>
                  <th nowrap>주소</th>
                </tr>
				<?
				if($q) {

					$total_page = ceil($totalCount/$countPerPage);
					for($i = 0 ; $i < $totalCount ; $i++){
					//foreach($xml->newAddressListAreaCdSearchAll as $value) {
					//	$zipNo = $value->zipNo;
					//	$lnmAdres = $value->lnmAdres;
					//	$rnAdres = $value->rnAdres;
						$zipNo	= $xml->newAddressListAreaCdSearchAll[$i]->zipNo;
						$lnmAdres	= $xml->newAddressListAreaCdSearchAll[$i]->lnmAdres;
						$rnAdres	= $xml->newAddressListAreaCdSearchAll[$i]->rnAdres;
				?>
                <tr>
                  <td nowrap data-title="선택">
				  <a class="label label-success" onclick="javascript:addr_select('<?=$zipNo?>','<?=$lnmAdres?>','<?=$rnAdres?>');"> 선택 </a>
				  </td>
                  <td nowrap data-title="우편번호"><?=$zipNo?></td>
                  <td nowrap data-title="주소">
				  <?=$lnmAdres?><br>
				  <?=$rnAdres?>
				  </td>
                </tr>
			<?
				}
			} else {
			?>
				<tr>
					<td colspan="3" align="center">
					등록된 정보가 없습니다.
					</td>
				</tr>
			<?}?>
              </table>
            </div>
			<?if($q) {?>
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
				<?=fn_page($total_page, $page_num, $currentPage, $link_url)?>
              </ul>
            </div>
			<?}?>
		</div>

		</form>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?
	include "../inc/footer.php";
?>
<?mysql_close($dbconn)?>