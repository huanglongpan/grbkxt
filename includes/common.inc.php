<!-- 公共文件，处理多种问题 -->
<?php

 //define('SCRIPT', 'register');
 if (!defined('IN_TG')) {
     exit('Access Defined');
 }

//设置字符编码
header("Content-Type:text/html;charset=utf-8");


//转换硬路径常量
 define('ROOT_PATH', substr(dirname(__FILE__), 0,-8));


//创建一个是否自动转义的的变量
define('GPC',get_magic_quotes_gpc());

//拒绝低版本的PHP
 if (PHP_VERSION<'4.6.1') {
 	exit('PHP版本太低，无法运行');
 }
//拒绝高版本php
  if (PHP_VERSION>'5.6.0') {
    exit('PHP版本太高，部分函数失效，无法运行');
 }

 require ROOT_PATH."/includes/global.func.php";  //引入核心函数库
 require ROOT_PATH."/includes/mysql.func.php";

 //数据库连接
 define('DB_HOST', 'localhost');
 define('DB_USER', 'root');
 define('DB_PWD', '123456');
 define('DB_NAME', 'textguest');

 _connect();
 _select_db();
 _set_names();


//短信提醒
if (isset($_COOKIE['username'])) {
    $_message=_fetch_array("SELECT
                                COUNT(tg_id)
                            AS count
                            FROM tg_message
                            WHERE tg_state=0 AND tg_touser='{$_COOKIE['username']}'");
    if (empty($_message['count'])) {
        $GLOBALS['message']='<strong class="noread"></strong>';
    }else{
        $GLOBALS['message']='<strong class="read"><a href="member_message.php">'.($_message['count']).'</a></strong>';
    }
}


?>