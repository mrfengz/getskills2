<?php
	$imgs = array('fj1.jpg','fj2.jpg','fj3.jpg','fj4.jpg','fj5.jpg',
		'gqmv1.jpg','gqmv2.jpg','liuyan-006.jpg','liuyan-007.jpg','liuyan-008.jpg'
		);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>图片懒加载</title>
	<link href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.css" type="text/css" rel="stylesheet"></link>
	<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
</head>
<body>
	<?php foreach($imgs as $val) {?>
	<div>
		<img src="../images/loading3.gif" alt="通用的占位符缩略图" data-src="../images/<?php echo $val;?>">
	</div>
	<?php } ?>
</body>
<script>
// 测试效果 chrome network->slow_3G
	$(function(){
		// 图片对象
		var lazyImgs = $("img[data-src]");
		var offset = $(window).height(); //可视窗口高度
		function winScroll() {
			if(lazyImgs.length > 0) {
				var imgIdx = [];
				var scrollTop = $(this).scrollTop(); //滚动条位置
				lazyImgs.each(function(i){
					if($(this).data('src') != $(this).attr('src')) {
						if($(this).offset().top - offset < scrollTop) { //判断高度 图片距离顶部高度 - 视窗高度 < 滚动条高度
							$(this).attr('src', $(this).data('src'));
						}
					}
				})
			}
		}
		$(window).scroll(winScroll);
		// 第一次进入时，加载视窗中的图片
		winScroll();
	})
</script>
</html>
				
