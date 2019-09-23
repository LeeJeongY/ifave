<?
	function getUserCode($user_code) {
		global $initial;
		global $dbconn;
		$query = "SELECT user_code FROM ".$initial."_user_info WHERE user_id IS NOT NULL ";
		$query .= " AND user_code='".$user_code."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$user_code	= stripslashes($array[user_code]);
			$user_code = getUserCode($user_code);
		}
		return $user_code;
	}


	function setDataFilesAdd($user_code,$user_class,$user_id,$fid,$tbl,$realfiles,$varfiles,$sizefiles,$typefiles,$extfiles) {
		global $initial;
		global $dbconn;
		$signdate = date("Y"."-"."m"."-"."d H:i:s");

		$maxnum_qry = "SELECT max(seq) FROM ".$initial."_data_files";
		$maxnum_result = mysql_query($maxnum_qry, $dbconn) or die(mysql_error());
		$maxnum_array = mysql_fetch_array($maxnum_result);
		$maxnum = $maxnum_array[0];
		if ($maxnum == "" or $maxnum == NULL) {
			$maxidx   = 1;
		} else {
			$maxidx   = $maxnum + 1;
		}
		$sql = "INSERT INTO ".$initial."_data_files SET ";
		$sql .= " seq='".$maxidx."'";
		$sql .= ", user_code='".$user_code."'";
		$sql .= ", user_class='".$user_class."'";
		$sql .= ", user_id='".$user_id."'";
		$sql .= ", fid='".$fid."'";
		$sql .= ", tbl='".$tbl."'";
		$sql .= ", realfilename='".$realfiles."'";
		$sql .= ", varfilename='".$varfiles."'";
		$sql .= ", filesize='".$sizefiles."'";
		$sql .= ", filetype='".$typefiles."'";
		$sql .= ", fileext='".$extfiles."'";
		$sql .= ", regdate='".$signdate."'";
		$result = mysql_query($sql, $dbconn);

		return $result;
	}

	function getDataFilesView($user_code,$user_class,$user_id,$fid,$tbl,$realfiles,$varfiles,$sizefiles,$typefiles,$extfiles) {
		global $initial;
		global $dbconn;

		$query = "SELECT * FROM ".$initial."_data_files WHERE tbl='".$_t."'";
		$query .= " AND user_id = '".$_USER_ID."'";
		$query .= " AND user_class = '".$_USER_CLASS."'";
		$query .= " AND fid = '".$user_seq."'";
		$result = mysql_query($query, $dbconn) or die (mysql_error());
		if($array = mysql_fetch_array($result)) {
			$realfilename		= stripslashes($array[realfilename]);
		}

		return $result;
	}


	function getBoardConfigDB($tbl, $dbconn) {
		global $initial;
		$sql = "SELECT * FROM ".$initial."_bbs_master WHERE bbs_id = '$tbl'";
		$res = mysql_query($sql,$dbconn) or die (mysql_error());
		if($arr = mysql_fetch_array($res)) {
			$bbs_kind		= $arr[bbs_kind];
			$bbs_type		= $arr[bbs_type];
			$bbs_name		= $arr[bbs_name];
			$cate_flag		= $arr[cate_flag];
			$cate_code		= $arr[cate_code];
			$bbs_title		= $arr[bbs_title];
			$user_file		= $arr[user_file];
			$option_list	= stripslashes($arr[option_list]);
			$use_grade		= stripslashes($arr[use_grade]);
			$skill_list		= stripslashes($arr[skill_list]);
			$target_send	= stripslashes($arr[target_send]);
			$share_media	= stripslashes($arr[share_media]);
			$item_close		= stripslashes($arr[item_close]);
			$img_flag		= stripslashes($arr[img_flag]);
			$file_flag		= stripslashes($arr[file_flag]);
			$list_counts	= stripslashes($arr[list_counts]);
			$bbs_id			= $arr[bbs_id];

		}

		$array_value = array($bbs_kind,$bbs_type,$bbs_name,$cate_flag,$cate_code,$bbs_title,$user_file,$option_list,$use_grade,$skill_list,$target_send,$share_media,$item_close,$img_flag,$file_flag,$list_counts,$bbs_id);

		return $array_value;
	}

	function getBoardInfoDB($tbl, $flag, $dbconn) {
		global $initial;
		$sql = "SELECT * FROM ".$initial."_bbs_master WHERE bbs_id = '$tbl'";

		$res = mysql_query($sql,$dbconn) or die (mysql_error());
		$arr = mysql_fetch_array($res);
		if($flag == "type") $str_value		= $arr[bbs_type];
		if($flag == "kind") $str_value		= $arr[bbs_kind];
		if($flag == "cate") $str_value		= $arr[cate_flag];
		if($flag == "code") $str_value		= $arr[cate_code];

		return $str_value;
	}

	function getBigCodeNameDB($kind_code, $dbconn) {
		global $initial;
		$sql = "SELECT kind_name FROM ".$initial."_code_kindcode WHERE kind_idx  IS NOT NULL ";
		$sql .= " AND kind_code = '$kind_code'";
		$rst = mysql_query($sql,$dbconn) or die (mysql_error());
		if($arr = mysql_fetch_array($rst)) {
			$code_name = db2html($arr[kind_name]);
		}
		return $code_name;
	}

	function getCodeNameDB($kind_code, $sel_code="", $dbconn) {
		global $initial;
		$sql = "SELECT * FROM ".$initial."_code_selcode WHERE code_idx  IS NOT NULL ";
		$sql .= " AND kind_code = '$kind_code'";
		$sql .= " AND s_code = '$sel_code'";
		//$sql = $sql . " and use_yn = 'Y'";
		$rst = mysql_query($sql,$dbconn) or die (mysql_error());
		if($arr = mysql_fetch_array($rst)) {
			$code_name = db2html($arr[code_name]);
		}
		return $code_name;
	}


	function getCodeNameRemarkDB($kind_code, $sel_code="", $dbconn) {
		global $initial;
		$sql = "SELECT * FROM ".$initial."_code_selcode WHERE code_idx  IS NOT NULL ";
		$sql .= " AND kind_code = '$kind_code'";
		$sql .= " AND s_code = '$sel_code'";
		//$sql = $sql . " and use_yn = 'Y'";
		$rst = mysql_query($sql,$dbconn) or die (mysql_error());
		if($arr = mysql_fetch_array($rst)) {
			$code_name = db2html($arr[remarks]);
		}
		return $code_name;
	}


	function getCodeNameCheckBoxDB($kind_code, $sel_code="", $dbconn) {
		global $initial;
		$sel_arr = explode("|",$sel_code);
		$return_val;
		for($i=0;$i < count($sel_arr);$i++) {
			$sql = "SELECT * from ".$initial."_code_selcode WHERE code_idx  IS NOT NULL ";
			$sql .= " AND kind_code = '$kind_code'";
			$sql .= " AND s_code='".$sel_arr[$i]."'";
			//$sql = $sql . " and use_yn = 'Y'";
			$rst = mysql_query($sql,$dbconn) or die (mysql_error());
			if($arr = mysql_fetch_array($rst)) {
				if($i>0) $comma = ",";
				else $comma = "";

				$return_val .= $comma.db2html($arr[code_name]);

			}
		}
		return $return_val;
	}

	function getCodeNameBoxDB($kind_code, $sel_code="", $type, $name, $dbconn) {
		global $initial;
		$sql = "SELECT * from ".$initial."_code_selcode WHERE code_idx  IS NOT NULL ";
		$sql = $sql . " AND kind_code = '$kind_code'";
		$sql = $sql . " AND use_yn = 'Y'";
		$sql = $sql . " ORDER BY seq_no  ASC";
		$rst=mysql_query($sql) or die (mysql_error());

		if($type=="combobox") {
			if($sel_code=="") $checked = "selected";
			else $checked = "";
			$code_str = "<select name=\"".$name."\" id=\"".$name."\" class=\"form-control boxed\">";
			$code_str .= "<option value=\"\" $checked>- 선택 -</option>";
		}

		$num = 1;
		while ($arr=mysql_fetch_array($rst)) {
			$s_code			= $arr[s_code];
			$code_name		= db2html($arr[code_name]);	  //이름

			//체크박스일 경우
			if($type=="checkbox") {
				if($sel_code!="") {
					if(eregi("$sel_code", $s_code)) {
						$checked = "checked";
					} else {
						$checked = "";
					}
				}
			} else if($type=="radio") {
				if($s_code==$sel_code) $checked = "checked";
				else $checked = "";
			} else if($type=="combobox") {
				if($s_code==$sel_code) $checked = "selected";
				else $checked = "";
			}

			if($type=="combobox") {
				$code_str .= "<option value=\"".$s_code."\" $checked>".$code_name."</option>";
			} else {
				$code_str .= "<label><input type=\"".$type."\" class=\"".$type." flat-red\" name=\"".$name."\" id=\"".$name.$num."\" value=\"".$s_code."\"  ".$checked."><span>".$code_name."&nbsp;&nbsp;</span> </label>";
			}
			$num++;
		}
		if($type=="combobox") {
			$code_str .= "</select>";
		}



		return $code_str;
	}



	function getCodeNameSelectDB($kind_code, $sel_code="", $dbconn) {
		global $initial;
		$sql = "SELECT * FROM ".$initial."_code_selcode WHERE code_idx  IS NOT NULL ";
		$sql .= " AND kind_code = '".$kind_code."'";
		$sql .= " AND use_yn = 'Y'";
		$sql .= " ORDER BY seq_no  ASC";
		$rst = mysql_query($sql, $dbconn) or die (mysql_error());
		while ($arr=mysql_fetch_array($rst)) {
			$s_code			= $arr[s_code];
			$code_name		= db2html($arr[code_name]);	  //이름
			if($sel_code == $s_code) $selected = "selected";
			else $selected = "";
			$code_str .= "<option value=\"".$s_code."\" $selected>".$code_name."</option>";
		}
		return $code_str;
	}


	function getCodeNameActionDB($kind_code, $sel_code="", $dbconn) {
		global $initial;
		$sql = "SELECT * from ".$initial."_code_selcode WHERE code_idx  IS NOT NULL ";
		$sql .= " AND kind_code = '".$kind_code."'";
		$sql .= " AND use_yn = 'Y'";
		$sql .= " ORDER BY seq_no  ASC";
		$rst = mysql_query($sql, $dbconn) or die (mysql_error());
		while ($arr=mysql_fetch_array($rst)) {
			$s_code			= $arr[s_code];
			$code_name		= db2html($arr[code_name]);	  //이름
			if($sel_code == $s_code) $selected = "selected";
			else $selected = "";
			$code_str .= "<li><a href=\"javascript:fn_category('".$s_code."');\">".$code_name."</a></li>";
            //$code_str .= "<li class=\"divider\"></li>";
		}
		return $code_str;
	}


	//상품 카테고리1
	function getCategoryName1($cate1, $dbconn) {
		global $initial;
		$sql = "SELECT * FROM ".$initial."_product_cate1 WHERE bid IS NOT NULL ";
		$sql .= " AND bid = '$cate1'";
		$rst = mysql_query($sql,$dbconn) or die (mysql_error());
		if($arr = mysql_fetch_array($rst)) {
			$_name = db2html($arr[name]);
		}
		return $_name;
	}


	//상품 카테고리2
	function getCategoryName2($cate1, $cate2, $dbconn) {
		global $initial;
		$sql = "SELECT * FROM ".$initial."_product_cate2 WHERE bid IS NOT NULL ";
		$sql .= " AND bid = '$cate1'";
		$sql .= " AND mid = '$cate2'";
		$rst = mysql_query($sql,$dbconn) or die (mysql_error());
		if($arr = mysql_fetch_array($rst)) {
			$_name = db2html($arr[name]);
		}
		return $_name;
	}
?>
