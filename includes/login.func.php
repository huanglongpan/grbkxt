<?php
/**
 * @Author: Marte
 * @Date:   2017-05-24 19:04:20
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-05-25 20:43:12
 */

if (!defined('IN_TG'))
    {
    exit("Access Defined");
   }

//检查函数是否存在
if (!function_exists('_alert_back')) {
    exit('_alert_back函数不存在，请检查');
}

if (!function_exists('_mysql_string')) {
    exit('_mysql_string函数不存在，请检查');
}

function _setcookies($_username,$_uniqud,$_time)
{

    switch ($_time) {
        case '1':
            setcookie('username',$_username,time()+9999999);
            setcookie('uniqid',$_uniqud,time()+9999999);
            break;

        default:
            setcookie('username',$_username);
            setcookie('uniqid',$_uniqud);
            break;
    }
}






function _check_username($_string,$_min_num,$_max_num){
    //去除用户名两边的空格
    $_string=trim($_string);
    //用户名长度的限制
    if (mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num) {
        _alert_back('用户名长度必须大于'.$_min_num.'位，小于'.$_max_num.'位');
    }

   //将用户名转义输入
   return _mysql_string($_string);
   // return mysql_real_escape_string($_string);
}


//验证密码
function _check_password($_string,$_min_num)
{
    //判断密码
    if (strlen($_string)<$_min_num) {
        _alert_back('密码不得小于'.$_min_num.'位!');
    }
    return sha1($_string);
}

function _check_time($_string){
    $_time=array('1','');
    if (!in_array($_string,$_time)) {
        _alert_back("保留方式出错");
    }
    return _mysql_string($_string);
}
?>