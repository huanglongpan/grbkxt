<?php
/**
 * @Author: Marte
 * @Date:   2017-07-17 11:32:54
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-14 20:35:32
 */
 session_start();
 define('IN_TG', true);

 define('SCRIPT', 'member_mima');

 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
 if (isset($_COOKIE['username'])) {
    if (isset($_GET['action']) && $_GET['action']=='mima') {
        include ROOT_PATH.'/includes/register.func.php';
        _check_code($_POST["code"],$_SESSION["code"]);
        if (!!$_rows=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
            _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
            $_rows = _fetch_array("SELECT tg_password FROM tg_uger WHERE tg_username='{$_COOKIE['username']}'");
            $_html=array();
            $_html['password']=$_rows['tg_password'];
            $_html['jiupassword']=sha1($_POST['password']);
            $_html['xinpassword']=$_POST['xinpassword'];
            $_html['qrpassword']=$_POST['qrpassword'];

            if ($_html['password']==$_html['jiupassword']) {
                $_html['xinpassword']=_check_password($_html['xinpassword'],$_html['qrpassword'],6);
                _query("UPDATE tg_uger SET
                                    tg_password='{$_html['xinpassword']}'
                                WHERE
                                  tg_username='{$_COOKIE['username']}'");
                    if (_affected_rows()==1) {
                        //关闭数据库
                        mysql_close();
                        //_alert_back('修改成功！');
                        setcookie('username','');
                        setcookie('uniqid','');
                        _session_destroy();
                        _location('恭喜您修改成功','login.php');
                    }else{
                        mysql_close();
                        _session_destroy();
                        _location('未进行任何修改！','member.php');
                    }
            }else{
                _alert_back("密码错误，重新输入");
            }
        }else{
            _alert_back("非法操作！");
        }
    }
 }else{
    _alert_back('请先登录！');
 }
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>多用户留言系统--个人中心</title>
    <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
    <link rel="stylesheet" type="text/css" href="style/1/member.css">
    <script type="text/javascript" src="js/member.mima.js"></script>
</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
?>
    <div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php'; ?>
        <div id="member_main">
        <form action="member_mima.php?action=mima" method="post" accept-charset="utf-8">
            <h2>修改密码</h2>
            <dl>
                <dt></dt>
                <dd>旧密码：　　<input type="text" name="password" class="text" value="" /></dd>
                <dd>新密码：　　<input type="password" name="xinpassword" class="text" value="" /></dd>
                <dd>确认新密码：<input type="password" name="qrpassword" class="text" value="" /></dd>
                <dd><span>验 证 码：</span>　　<input type="text" name="code" maxlength="4">
                     <img src="yzm/text.php" id="code"></dd>
                <dd><input type="submit" class="submit" value="修改密码"></dd>
            </dl>
        </form>

        </div>
    </div>
</body>
</html>