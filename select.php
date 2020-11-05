<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>图片懒加载</title>
	<link href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.css" type="text/css" rel="stylesheet"></link>
	<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
</head>
<body>
	<select name="" id="select">
		<option value="1">请选择</option>
	</select>
</body>
<script>
	// 测试效果 chrome network->slow_3G
	$(function(){
		$('#select').one('mouseover',function(){
			var opts = "<option value='2' >222</option>"
				+"<option value='3' >333</option>"
				+"<option value='4' >444</option>";
			$(this).append(opts);
		})
	})
</script>
</html>
				
