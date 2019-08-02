<?php
/**
 * @Author: Marte
 * @Date:   2017-05-23 20:45:18
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-09-08 21:38:15
 */
header('Cache-control: private, must-revalidate');
 session_cache_limiter('private, must-revalidate');
 session_start();
 define('IN_TG', true);

 define('SCRIPT', 'login');
 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
 _login_state();//登录状态判断
 if (isset($_GET['action'])=='login') {
    //验证码
    _check_code($_POST["code"],$_SESSION["code"]);
    //引入验证文件进行验证
     include ROOT_PATH.'/includes/login.func.php';
     //创建数组接收数据
     $_clean=array();
     $_clean["username"]=_check_username($_POST["username"],2,20);
     $_clean["password"]=_check_password($_POST["password"],6);
     $_clean["time"]=_check_time($_POST["time"]);
     if (!!$_rows=_fetch_array("select tg_username,tg_uniqid from tg_uger where tg_username='{$_clean["username"]}' and tg_password='{$_clean["password"]}' LIMIT 1")){
        //每次登陆后ip和登陆时间的更新
      _query("UPDATE tg_uger SET
                tg_last_time=NOW(),
                tg_last_ip='{$_SERVER["REMOTE_ADDR"]}',
                tg_login_count=tg_login_count +1
              WHERE
                tg_username='{$_rows['tg_username']}'");

            mysql_close();
            _session_destroy();
            _setcookies($_rows["tg_username"],$_rows["tg_uniqid"],$_clean["time"]);
            _location(null,'index.php');
    }
    else{
        mysql_close();
        _session_destroy();
        _location('用户名或密码不正确，或该账户未激活!','login.php');

     }

  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--登录loginaa</title>
    <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
    <link rel="stylesheet" type="text/css" href="style/1/login.css">
    <script type="text/javascript" src="js/login.js"></script>
</head>
<body>
 <?php
    require ROOT_PATH.'includes/header.inc.php';
?>

<div id="login">
    <h2>登录</h2>
    <form action="login.php?action=login" method="post" name="login">
      <fieldset>
          <legend>龙攀留言系统登录</legend>
            <dl>
                <dd>用户名：<input type="text" name="username" class="text"></dd>
                <dd>密　码：<input type="password" name="password" class="text"></dd>
                <dd>　　　　　　<input type="checkbox" value="1" name="time" />记住登录</dd>
                <dd>验证码：<input type="text" name="code" maxlength="4">
                            <img src="yzm/text.php" id="code"></dd>
                <dd><input type="submit" style="width: 90px;height: 50px;" value="登录" >
                    <a href="register.php" style="border: 1px solid #000;padding: 10px;text-decoration:none; ">注册</a></dd>
            </dl>
      </fieldset>

    </form>
</div>


<?php
    require ROOT_PATH.'includes/footer.inc.php';
 ?>
</body>
</html>
