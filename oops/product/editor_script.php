
		if($('#pname').val() =='') {
			alert('상품명을 입력하세요.');
			$('#pname').focus();
			return false;
		}
		if($('#option_color').val() =='') {
			alert('색상을 선택하세요.');
			$('#option_color').focus();
			return false;
		}
		if($('#price').val() =='') {
			alert('가격을 입력하세요.');
			$('#price').focus();
			return false;
		}