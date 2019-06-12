<?php
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

//唯一标识符
function _check_uniqid($_first_uniqid,$_end_uniqid){
    if ($_first_uniqid!=$_end_uniqid) {
        _alert_back("唯一标识符异常");
    }
    return _mysql_string($_first_uniqid);
}

//_check_username验证用户名
function _check_username($_string,$_min_num,$_max_num){
	//去除用户名两边的空格
	$_string=trim($_string);
	//用户名长度的限制
	if (mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num) {
		_alert_back('用户名长度必须大于'.$_min_num.'位，小于'.$_max_num.'位');
	}

    //限制敏感字符
    $_char_pattern='/[<>\'\"\\ ]/';
    if (preg_match($_char_pattern, $_string)) {
    	_alert_back('用户名不能包含敏感字符!');
    }
    //过滤敏感用户名
    // $_mg[0]='黄龙攀';

    //  foreach ($_mg as $_mg_string =>$value) {
    //  	$_mg_string.=$value.'\n';
    //  }

    // if (in_array($_string,$_mg)) {
    // 	_alert_back("$_mg_string.'以上为敏感用户名不得使用!'");
    // }

   //将用户名转义输入
   return _mysql_string($_string);
   // return mysql_real_escape_string($_string);
}


//验证密码
function _check_password($_first_pass,$_end_pass,$_min_num)
{
    //判断密码
    if (strlen($_first_pass)<$_min_num) {
        _alert_back('密码不得小于'.$_min_num.'位!');
    }
    if ($_first_pass!=$_end_pass) {
        _alert_back('两次密码必须一致');
    }

    return _mysql_string(sha1($_first_pass));
}

//修改密码
function _check_modif_password($_string,$_min_num){
    if (!empty($_string)) {
        if (strlen($_string)<$_min_num) {
            _alert_back('密码不得小于'.$_min_num.'位！');
        }else{
            return null;
        }
    }
    return sha1($_string);
}

function _modif_face($_string){
    $pattern ='<img.*?src="(.*?)">';
    preg_match($pattern,$_string,$matches);
    return $matches[1];
}

 //密码提示
function _check_question($_string,$_min_num,$_max_num)
{
    $_string=trim($_string);
    if (mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num) {
        _alert_back('密码提示长度必须大于'.$_min_num.'位，小于'.$_max_num.'位');
    }
    return _mysql_string($_string);
   // return mysql_real_escape_string($_string);
}


//提示答案
function _check_answer($_ques,$_answ,$_min_num,$_max_num)
{
    $_answ=trim($_answ);
   if (mb_strlen($_answ,'utf-8')<$_min_num || mb_strlen($_answ,'utf-8')>$_max_num) {
        _alert_back('密码提示答案长度必须大于'.$_min_num.'位，小于'.$_max_num.'位');
    }
   //密码提示与提示答案不得一致
   if ($_ques==$_answ) {
       _alert_back('密码提示与提示答案不得一致');
    }

    return _mysql_string(sha1($_answ));
}
function _check_sex($_string){
    return _mysql_string($_string);
}
function _check_face($_string){
    return _mysql_string($_string);
}

//email
function _check_email($_string)
{
    $_string=trim($_string);
    //email格式,正则表达式
    if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)) {
            _alert_back('email格式不正确!');
        }
    return _mysql_string($_string);
}


//QQ
function _check_qq($_string){
    $_string=trim($_string);
    if (empty($_string)) {
        return null;
    }elseif (!preg_match('/^[1-9]{1}[0-9]{4,10}$/',$_string)) {
        _alert_back('QQ号码不正确');
    }
    return _mysql_string($_string);
}

//验证帖子标题
function _check_post_title($_string,$_min,$_max){
    $_string=trim($_string);
    if (mb_strlen($_string,'utf-8')<$_min || mb_strlen($_string,'utf-8')>$_max) {
        _alert_back('帖子标题长度必须大于'.$_min.'位，小于'.$_max.'位');
    }
    return $_string;
}

//贴子内容不多为空
function _check_post_content($_string){
    if (mb_strlen($_string,'utf-8')<1) {
        _alert_back('内容不得为空!');
    }
    return $_string;
}
?>