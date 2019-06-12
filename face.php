<?php
 session_start();
 define('IN_TG', true);

 define('SCRIPT', 'face');

 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<?php  require ROOT_PATH.'includes/title.inc.php'; ?>
	<link rel="stylesheet" type="text/css" href="style/1/face.css">
	<script type="text/javascript">
		window.onload=function(){
		    var img=document.getElementsByTagName('img');
		    function _opener(src){
		    	var faceimg=opener.document.getElementById('faceimg');
		    	faceimg.src=src;
		    	opener.document.register.face.value=src;
			}
			function _close(){
		    	window.close();
			};
		    for (var i=0 ;i< img.length; i++) {
		        img[i].onclick=function(){
		            _opener(this.alt);
		            _close();
		        };
		    };
		};
		
	</script>
</head>
<body>
	<div id="face">
	   <h3>选择头像</h3>
	   <dl>
	   <?php foreach ( range(1,9) as $num)  { ?>
		 <dd onclick="_close()">
			 <img src="face/0<?php echo $num ?>.jpg" title="头像<?php echo $num?>" alt="face/0<?php echo $num  ?>.jpg">
		 </dd>
	   <?php } ?>
	   </dl>

	   <dl>
	   <?php foreach( range(10,37) as $num) { ?>
	   	<dd onclick="_close()">
	   		<img src="face/<?php echo $num ?>.jpg" title="头像<?php echo $num ?>" alt="face/<?php echo $num ?>.jpg">
	   	</dd>
	   <?php } ?>
	   </dl>
	</div>
</body>
</html>