<?
	session_start();
	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";
	include "../../modules/check.php";

	$tbl	= "product"; 							//테이블 이름
	$_t1 = "product_cate1";
	$_t2 = "product_cate2";
	$foldername  = "../../$upload_dir/$tbl/";

	//신규등록인 경우 ============================
	if ($gubun == "") { $gubun  = "insert" ;}

	//기존데이터 수정인경우
	if ($gubun  == "update") {
		$query = "SELECT * FROM ".$initial."_".$tbl."_order WHERE seq = '".$idx."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$order_seq			= $array[seq];
			$order_tid         	= $array[order_tid];
			$order_num         	= $array[order_num];
			$order_id          	= $array[order_id];
			$order_name        	= db2html($array[order_name]);
			$order_tel         	= $array[order_tel];
			$order_hp          	= $array[order_hp];
			$order_email       	= $array[order_email];
			$order_zipcode     	= $array[order_zipcode];
			$order_addr1       	= $array[order_addr1];
			$order_addr2       	= $array[order_addr2];
			$order_addr3       	= $array[order_addr3];
			$receive_name      	= db2html($array[receive_name]);
			$receive_tel       	= $array[receive_tel];
			$receive_hp        	= $array[receive_hp];
			$receive_email     	= $array[receive_email];
			$receive_zipcode   	= $array[receive_zipcode];
			$receive_addr1     	= $array[receive_addr1];
			$receive_addr2     	= $array[receive_addr2];
			$receive_addr3     	= $array[receive_addr3];
			$title             	= db2html($array[title]);
			$message           	= db2html($array[message]);
			$pay_state         	= $array[pay_state];
			$pay_type          	= $array[pay_type];
			$sum_amount        	= $array[sum_amount];
			$fee_amount        	= $array[fee_amount];
			$pay_amount        	= $array[pay_amount];
			$pay_bank_code     	= $array[pay_bank_code];
			$pay_bank_name     	= db2html($array[pay_bank_name]);
			$pay_deposit_name  	= db2html($array[pay_deposit_name]);
			$pay_account_number	= $array[pay_account_number];
			$pay_deposit_date  	= $array[pay_deposit_date];
			$pay_card_code     	= $array[pay_card_code];
			$pay_card_name     	= $array[pay_card_name];
			$pay_card_number   	= $array[pay_card_number];
			$delivery_state    	= $array[delivery_state];
			$delivery_company  	= $array[delivery_company];
			$delivery_number   	= $array[delivery_number];
			$delivery_date     	= $array[delivery_date];
			$remark            	= db2html($array[remark]);
			$site           	= $array[site];
			$regdate           	= $array[regdate];
			$upddate           	= $array[upddate];
			$candate           	= $array[candate];

			//임시 변수 변환
			$pay_type_falg = $pay_type;
		}

	} else {
		//등록인 경우
	}
?>
<?
	include "../inc/header_popup.php";
	//스크립트
	include "../js/goto_page.js.php";
?>
<script language=JavaScript>
<!--
	function fn_submit(){
		var fm = document.fm;
		if($('#order_name').val() =='') {
			alert('이름을 입력하세요.');
			$('#order_name').focus();
			return false;
		}
		<?if($order_seq) {?>
		fm.gubun.value = "update";
		<?} else {?>
		fm.gubun.value = "insert";
		<?}?>
		fm.target = "_self";
		fm.action = "write_ok.php";
		fm.submit();
	}

	function go_list() {
		var frm = document.fm;
		frm.gubun.value = "";
		frm.order_seq.value = "";
		frm.method = "get";
		frm.target = "self";
		frm.action = "list.php";
		frm.submit();
	}
//-->
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="<?=$popup=="1"?"popup-":""?>content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        주문내역
        <small>주문내역 <?=$idx==""?"등록":"수정"?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 주문관리</a></li>
        <li class="active">주문내역 <?=$idx==""?"등록":"수정"?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->

		<div class="row">
		<!-- left column -->

			<!-- <div class="col-md-6">
			</div>

	        <div class="col-md-6">
			</div>
			-->

			<!-- <form role="form" method="post" name="fm" id="fm" enctype="multipart/form-data"> -->
			<!-- <form role="form" method="post" name="fm" id="fm" action="write_ok.php" enctype="multipart/form-data" accept-charset="utf-8"> -->
			<form role="form" method="post" name="fm" id="fm" action="write_ok.php" enctype="multipart/form-data" accept-charset="utf-8">
			<input type="hidden" name="page" value='<?=$page?>'>
			<input type="hidden" name="order_seq" value='<?=$order_seq?>'>
			<input type="hidden" name="gubun" value='<?=$gubun?>'>
			<input type="hidden" name="popup" value="<?=$popup?>">
			<input type="hidden" name="s_site" value="<?=$s_site?>">
			<input type="hidden" name="search" value='<?=$search?>'>
			<input type="hidden" name="search_text" value='<?=$search_text?>'>
			<input type="hidden" name="cate_flag" value=''>

			<div class="col-md-6">

				<div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title">주문정보</h3>
					</div>

					<div class="box-body">

						<div class="form-group">
							<label for="order_num">주문번호</label>
							<input type="text" name="order_num" id="order_num" value="<?=$order_num?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="order_tid">TID</label>
							<input type="text" name="order_tid" id="order_tid" value="<?=$order_tid?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="title">제목</label>
							<input type="text" name="title" id="title" value="<?=$title?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="message">메시지</label>
							<div class="box-body pad">
								<textarea class="textarea" name="message" id="message" placeholder="" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?=$message?></textarea>
							</div>
						</div>



					</div>
				</div>

				<div class="box box-navy">
					<div class="box-header with-border">
					  <h3 class="box-title">상품 정보</h3>
					</div>

					<div class="box-body">

						<div class="box-body table-responsive no-padding">
						  <table class="table table-hover" id="_table_">
							<tr>
							  <th nowrap width="60">No</th>
							  <th nowrap>상품명</th>
							  <th nowrap width="100">단가</th>
							  <th nowrap width="100">수량</th>
							  <th nowrap width="150">가격</th>
							</tr>
							<?

							$query  ="SELECT count(idx) as cnt FROM ".$initial."_product_order_list WHERE idx is not null ";
							$query .= " AND order_fid='".$idx."'";
							$result = mysql_query($query, $dbconn) or die (mysql_error());
							if($array=mysql_fetch_array($result)) {
								$total_no		= $array[cnt];
							}


							if($total_no == 0) {
							?>
							<tr>
							  <td align="center" colspan="10">등록된 정보가 없습니다.</td>
							</tr>
							<?
							} else {

								$strQuery  = "SELECT * ";
								$strQuery .= " FROM ".$initial."_product_order_list WHERE idx IS NOT NULL ";
								$strQuery .= " AND order_fid='".$idx."'";
								$strResult = mysql_query($strQuery, $dbconn) or die (mysql_error());
								while ($strArray = mysql_fetch_assoc($strResult)) {
									$rot_num += 1;

									$order_num		= $strArray[order_num];
									$user_id		= $strArray[user_id];
									$pidx			= $strArray[pidx];
									$pcode			= $strArray[pcode];
									$pname			= db2html($strArray[pname]);
									$quantity		= $strArray[quantity];
									$unit_price		= $strArray[unit_price];
									//$order_state	= $strArray[order_state];
									//$delivery_state	= $strArray[delivery_state];
									$v_regdate		= $strArray[regdate];

									$price = $unit_price * $quantity;

							?>
							<input type="hidden" name="r_pidx[]" value="<?=$pidx?>">
							<input type="hidden" name="r_pname[]" value="<?=$pname?>">
							<input type="hidden" name="r_pcode[]" value="<?=$pcode?>">
							<input type="hidden" name="r_price[]" value="<?=$unit_price?>">
							<input type="hidden" name="r_qty[]" value="<?=$quantity?>">
							<tr>
							  <td nowrap data-title="번호"><?=$rot_num?></td>
							  <td nowrap data-title="상품명" style="font-weight:bold;"><?=$pname?></td>
							  <td nowrap data-title="단가" class="list_br"><?=number_format($unit_price)?></td>
							  <td nowrap data-title="수량" class="list_br"><?=$quantity?></td>
							  <td nowrap data-title="가격" class="list_br"><?=number_format($price)?></td>
							</tr>
							<?
									$cur_num --;
								}
							}
							?>
						  </table>
						</div>

					</div>
				</div>
				<div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">주문자 정보</h3>
					</div>

					<div class="box-body">




						<div class="form-group">
							<label for="order_id">아이디</label>
							<input type="text" name="order_id" id="order_id" value="<?=$order_id?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="order_name">주문자</label>
							<input type="text" name="order_name" id="order_name" value="<?=$order_name?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="order_hp">연락처</label>
							<input type="text" name="order_hp" id="order_hp" value="<?=$order_hp?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="order_email">이메일</label>
							<input type="text" name="order_email" id="order_email" value="<?=$order_email?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
						  <label for="address">주소</label>
						  <div class="row">
							<div class="col-xs-3">

								<div class="input-group input-group-sm">

									<input type="text" class="form-control" name="order_zipcode" id="zipcode" value="<?=$order_zipcode?>" placeholder="우편번호" readonly>
									<span class="input-group-btn">
									  <a type="button" class="btn btn-info btn-flat" href="javascript:_address('o')">찾기</a>
									</span>
								</div>

							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="order_addr1" id="addr1" value="<?=$order_addr1?>" placeholder="">
							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="order_addr2" id="addr2" value="<?=$order_addr2?>" placeholder="">
							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="order_addr3" id="addr3" value="<?=$order_addr3?>" placeholder="">
							</div>
						  </div>
						</div>
						<!-- //box -->
					</div>
				</div>

				<div class="box box-danger">
					<div class="box-header with-border">
					  <h3 class="box-title">수령자 정보</h3>
					</div>

					<div class="box-body">


						<div class="form-group">
							<label for="receive_name">수령자</label>
							<input type="text" name="receive_name" id="receive_name" value="<?=$receive_name?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="order_hp">연락처</label>
							<input type="text" name="receive_hp" id="receive_hp" value="<?=$receive_hp?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="receive_email">이메일</label>
							<input type="text" name="receive_email" id="receive_email" value="<?=$receive_email?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
						  <label for="address">주소</label>
						  <div class="row">
							<div class="col-xs-3">

								<div class="input-group input-group-sm">

									<input type="text" class="form-control" name="receive_zipcode" id="zipcode" value="<?=$receive_zipcode?>" placeholder="우편번호" readonly>
									<span class="input-group-btn">
									  <a type="button" class="btn btn-info btn-flat" href="javascript:_address('r')">찾기</a>
									</span>
								</div>

							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="receive_addr1" id="addr1" value="<?=$receive_addr1?>" placeholder="">
							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="receive_addr2" id="addr2" value="<?=$receive_addr2?>" placeholder="">
							</div>
							<div class=" col-xs-12">
							  <input type="text" class="form-control" name="receive_addr3" id="addr3" value="<?=$receive_addr3?>" placeholder="">
							</div>
						  </div>
						</div>






					</div>
				</div>

			</div>
			<div class="col-md-6">
				<div class="box box-warning">
					<div class="box-header with-border">
					  <h3 class="box-title">결제 정보</h3>
					</div>

					<div class="box-body">

						<div class="form-group">
							<label for="pay_type">결제방식</label>

							<div class="input-group">
								<select name="pay_type" class="select2" style="width:120px;">
									<option value="" <? echo $pay_state == ""?"selected":"";?>>결제방식</option>
									<?=getCodeNameSelectDB("code_pay_type", $pay_type, $dbconn)?>
								</select>
							</div>
						</div>


						<div class="form-group">
							<label for="pay_state">결제상태</label>

							<div class="input-group">
								<select name="pay_state" class="select2" style="width:120px;">
									<option value="" <? echo $pay_state == ""?"selected":"";?>>결제상태</option>
									<?=getCodeNameSelectDB("code_pay_state", $pay_state, $dbconn)?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="sum_amount">주문금액</label>
							<input type="text" name="sum_amount" id="sum_amount" value="<?=$sum_amount?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="fee_amount">배송금액</label>
							<input type="text" name="fee_amount" id="fee_amount" value="<?=$fee_amount?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="pay_amount">결제금액</label>
							<input type="text" name="pay_amount" id="pay_amount" value="<?=$pay_amount?>" class="form-control" required=""/>
						</div>

					</div>
				</div>


				<?if($pay_type_falg!="Free") {?>
				<div class="box box-success">
					<div class="box-header with-border">
					  <h3 class="box-title">금융 정보</h3>
					</div>

					<div class="box-body">

					<?if($pay_type_falg=="Card") {?>
						<div class="form-group">
							<label for="pay_card_code">카드코드</label>
							<input type="text" name="pay_card_code" id="pay_card_code" value="<?=$pay_card_code?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="pay_card_name">카드회사</label>
							<input type="text" name="pay_card_name" id="pay_card_name" value="<?=$pay_card_name?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="pay_card_number">카드번호</label>
							<input type="text" name="pay_card_number" id="pay_card_number" value="<?=$pay_card_number?>" class="form-control" required=""/>
						</div>
					<?} else if($pay_type_falg=="VBank") {?>
						<div class="form-group">
							<label for="pay_bank_code">은행코드</label>
							<input type="text" name="pay_bank_code" id="pay_bank_code" value="<?=$pay_bank_code?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="pay_bank_name">은행명</label>
							<input type="text" name="pay_bank_name" id="pay_bank_name" value="<?=$pay_bank_name?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="pay_deposit_name">입금자명</label>
							<input type="text" name="pay_deposit_name" id="pay_deposit_name" value="<?=$pay_deposit_name?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="pay_account_number">계좌번호</label>
							<input type="text" name="pay_account_number" id="pay_account_number" value="<?=$pay_account_number?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="pay_deposit_date">입금일</label>
							<input type="text" name="pay_deposit_date" id="pay_deposit_date" value="<?=$pay_deposit_date?>" class="form-control" required=""/>
						</div>
					<?} else if($pay_type_falg=="Free") {?>
					<?}?>
					</div>
				</div>
				<?}?>

				<div class="box box-success">
					<div class="box-header with-border">
					  <h3 class="box-title">배송 정보</h3>
					</div>

					<div class="box-body">


						<div class="form-group">
							<label for="delivery_state">배송상태</label>
							<div class="input-group">
								<select name="delivery_state" class="select2" style="width:120px;">
									<option value="" <? echo $pay_type == ""?"selected":"";?>>결제상태</option>
									<?=getCodeNameSelectDB("code_delivery_state", $delivery_state, $dbconn)?>
								</select>
							</div>
						</div>


						<div class="form-group">
							<label for="delivery_company">택배회사</label>
							<input type="text" name="delivery_company" id="delivery_company" value="<?=$delivery_company?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="delivery_number">송장번호</label>
							<input type="text" name="delivery_number" id="delivery_number" value="<?=$delivery_number?>" class="form-control" required=""/>
						</div>
						<div class="form-group">
							<label for="delivery_date">배송일자</label>
							<input type="text" name="delivery_date" id="datepicker" value="<?=$delivery_date?>" class="form-control" required=""/>
						</div>

						<div class="form-group">
							<label for="remark">비고(관리자입력)</label>
							<textarea type="text" name="remark" id="remark" class="form-control" placeholder="" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"/><?=$remark?></textarea>
						</div>
					</div>
					<div class="box-footer">
						<button type="button" class="btn btn-default" onclick="fn_cancel()">취소</button>
						<!-- <button type="submit" class="btn btn-primary pull-right">확인</button> -->
						<input type="button" onclick="fn_submit();" value="확인" class="btn btn-primary pull-right" /> <!--  일반적일 경우 -->
						<!-- <input type="button" onclick="saveContent();" value="확인" class="btn btn-primary pull-right" /> --> <!--  daum editor -->
					</div>
				</div>
				</form>
				<!-- /.box -->

			</div>
		</div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?
	include "../inc/footer.php";
?>
<? mysql_close($dbconn); ?>
