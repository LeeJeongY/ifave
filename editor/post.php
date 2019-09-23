<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
	#viewContents p {margin:0;}
	</style>
</head>
<body>	
<?

// 다음 위지윅 에디터에서 글을 POST로 받아온 후 글 내용을 변수에 지정하기  'content', 'attach_image', 'attach_file'

$subject = $_POST['subject']; 
$content = $_POST['content']; 

$subject = stripslashes($subject);
$content = stripslashes($content);

echo ("글제목 : $subject <br><br>");


echo ("<span id=viewContents>$content</span>");
?>
</body>
</html>
