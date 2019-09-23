
			<?if($cfg_bbs_type!="sns") {?>
			if($('#title').val() == '') {
				alert("제목을 입력하세요.");
				$('#title').focus();
				return;
			}
			<?if($SUPER_UID == "") {?>
			/*
			if($('#email').val() == '') {
				alert('메일을 입력하세요.');
				$('#email').focus();
				return;
			}
			if($('#passwd').val() == '') {
				alert('비밀번호를 입력하세요.');
				$('#passwd').focus();
				return;
			}
			*/
			<?}?>
			<?}?>
			if($('#username').val() == '') {
				alert("작성자를 입력하세요.");				
				$('#username').focus();
				return;
			}