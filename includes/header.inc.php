<?php
   if (!defined('IN_TG'))
    {
   	exit("Access Defined");
   }
 ?>

<div id="header">
 <script src="http://api.asilu.com/cdn/jquery.js,jquery.backstretch.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $.backstretch([
            'face/1/001.jpg',
            'face/1/002.jpg',
            'face/1/003.jpg',
            'face/1/004.jpg',
            'face/1/005.jpg',
            'face/1/006.jpg'
        ], {
        fade : 750,
duration : 5000});
</script>
		<h1><a href="index.php">longpan233.top</a></h1>
		<ul>
			<li><a href="index.php">首页</a></li>


            <?php
              if (isset($_COOKIE["username"])) {
                echo '<li><a href="member.php">'.$_COOKIE["username"].'●个人中心</a>'.$GLOBALS['message'].'</li>';
                echo "\n";
                echo '<li><a href="blog.php">博友</a></li>';
              }else{
                echo '<li><a href="register.php">注册</a></li>';
                echo "\n";
                echo "\t";
                echo '<li><a href="login.php">登录</a></li>';
                echo "\n";
              }
            ?>

			<li>风格</li>
			<li>管理</li>

            <?php
                if (isset($_COOKIE["username"])) {
                    echo '<li><a href="logout.php">退出</a></li>';
                }
            ?>

		</ul>
	</div>