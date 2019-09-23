<?
	session_start();

	header("Content-type:text/html;charset=utf-8");
	include "../../modules/dbcon.php";
	include "../../modules/config.php";
	include "../../modules/func.php";
	include "../../modules/func_q.php";


	if($gubun == "getProduct") {

		foreach ($_POST as $tmpKey => $tmpValue) {
			//echo $tmpKey."=".$tmpValue.chr(10).chr(13);
			$$tmpKey = $tmpValue;
		}// end foreach



		$query = "select * from ".$initial."_product where pcode='".$product_id."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$idx      	= $array[idx];
			$cate1    	= $array[cate1];
			$cate2    	= $array[cate2];
			$pcode    	= $array[pcode];
			$pname		= db2html($array[pname]);
			$option_color 	= $array[option_color];
			$img_file 	= $array[img_file];
			$price    	= $array[price];
			$quantity 	= $array[quantity];
			$title		= db2html($array[title]);
			$intro		= db2html($array[intro]);
			$content	= db2html($array[content]);
			$main_flag	= $array[main_flag];
			$use_flag 	= $array[use_flag];
			$regdate  	= $array[regdate];
			$upddate  	= $array[upddate];
			$user_wid 	= $array[user_wid];
			$user_eid 	= $array[user_eid];
		}
		/*
		$html_data = "<li>";
		$html_data .= "	<strong>$pname</strong>";
		$html_data .= "	<select>";
		$html_data .= "		<option>1</option>";
		$html_data .= "		<option>2</option>";
		$html_data .= "		<option>3</option>";
		$html_data .= "		<option>4</option>";
		$html_data .= "		<option>5</option>";
		$html_data .= "	</select>";
		$html_data .= "	<a href=\"javascript:cart_del('$pcode');\">￦".number_format($price)."</a>";
		$html_data .= "</li>";
		*/
		//$product_code_array = count($product_code);
		//echo "product_code_array = ".$product_code_array;

		$product_chk = 0;
		for($i=0;$i < count($product_code);$i++) {
			//echo "product_code[$i] = ".$product_code[$i].chr(10).chr(13);

			if($product_code[$i]==$product_id) {
				$product_chk++;
			}
		}

		//echo $html_data;
		echo $pname."@".$pcode."@".$price."@".$idx."@".$product_chk;

	} else if($gubun=="calculation") {

		foreach ($_POST as $tmpKey => $tmpValue) {
			//echo $tmpKey."=".$tmpValue.chr(10).chr(13);
			$$tmpKey = $tmpValue;
		}// end foreach

		$data_value = "";

		for($i=0;$i < count($qty);$i++) {
			$data_value .= "qty[$i] = ". $qty[$i].chr(10).chr(13);
			$data_value .= "unit_price[$i] = ". $unit_price[$i].chr(10).chr(13);
			$data_value .= "sum_price[$i] = ". $sum_price[$i].chr(10).chr(13);

			$total_amount += $sum_price[$i];
		}
		if($total_amount=="") $total_amount = 0;
		//echo $data_value;
		echo $total_amount;
	}

	mysql_close($dbconn);
?>