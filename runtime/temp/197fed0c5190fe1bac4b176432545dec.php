<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:41:"./application/admin/view/news\upload.html";i:1500619865;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>upload测试</title>
</head>
<body>
	<form action="<?php echo U('News/upload'); ?>" enctype="multipart/form-data" method="post">
	<input type="file" name="image" />
	<!-- <input type="file" name="image[]" /> <br> 
	<input type="file" name="image[]" /> <br> 
	<input type="file" name="image[]" /> <br> -->
	<input type="submit" value="上传" /> 
	</form> 
</body>
</html>