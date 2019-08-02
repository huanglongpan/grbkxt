<?php
/**
 * @Author: Marte
 * @Date:   2017-05-25 20:28:14
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-14 20:22:58
 */
 session_start();
 define('IN_TG', true);
 require dirname(__FILE__).'/includes/common.inc.php';
 _unsetcookies('index.php');
 echo "logout.php";
?>
