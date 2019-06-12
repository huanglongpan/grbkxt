<?php
/**
 * @Author: Marte
 * @Date:   2017-09-26 19:07:12
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-09-26 20:30:08
 */
 header('Cache-control: private, must-revalidate');
 session_cache_limiter('private, must-revalidate');
 session_start();
 define('IN_TG', true);

 define('SCRIPT', 'friend');
 require dirname(__FILE__).'/includes/common.inc.php';
 include ROOT_PATH.'/includes/register.func.php';
 //引用公共文件common.inc.php
// _login_state();//登录状态判断
 if (!isset($_COOKIE['username'])) {
    _alert_close('请先登录后再进行操作');
 }

//添加好友
if (isset($_GET['action'])=='add') {
    _check_code($_POST['code'],$_SESSION['code']);
    if (!!$_rows=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
          _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);}
    $_clean=array();
    $_clean['touser']=$_POST['touser'];
    $_clean['formuser']=$_COOKIE['username'];
    $_clean['content']=$_POST['content'];
    $_clean=_mysql_string($_clean);
    if (!!$_rows=_fetch_array("SELECT tg_id
                            FROM tg_friend
                            WHERE (tg_touser='{$_clean['touser']}' AND tg_formuser='{$_clean['formuser']}')
                            OR (tg_touser='{$_clean['formuser']}' AND tg_formuser='{$_clean['touser']}')
                            LIMIT 1
                            ")) {
        _alert_close('验证消息已发出，等待对方验证！');
    }else{
        _query("INSERT INTO tg_friend (
                                        tg_touser,tg_formuser,tg_content,tg_date
                                      )
                                VALUES(
                                        '{$_clean['touser']}',
                                        '{$_clean['formuser']}',
                                        '{$_clean['content']}',
                                        NOW()
                                )");
        if (_affected_rows()==1) {
            mysql_close();
            _session_destroy();
            _alert_close('好友添加成功！等待对方验证！');
        }else{
            mysql_close();
            _session_destroy();
            _alert_back('消息发送失败');
        }
    }
}

//获取数据
 if (isset($_GET['id'])) {
     if (!!$_rows=_fetch_array("SELECT
                                    tg_username
                                FROM tg_uger
                                WHERE tg_id='{$_GET['id']}'
                                LIMIT 1")) {
            $_html=array();
            $_html['touser']=_html($_rows['tg_username']);


    }else{
        _alert_close('此用户不存在！');
    }
    if ($_html['touser']==$_COOKIE['username']) {
                _alert_close('不能添加自己为好友');
            }
 }else{
    _alert_back("非法操作！");
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>多用户留言系统——添加好友</title>
    <link rel="stylesheet" type="text/css" href="style/1/message.css">
</head>
<body>
    <div id="message">
        <h3>添加好友</h3>
        <form action="?action=add" method="post" accept-charset="utf-8">
            <input type="hidden" name="touser" value="<?php echo $_html['touser']?>">
            <dl>
                <dd>To：<?php echo $_html['touser']?></dd>
                <dd>验证信息：</dd>
                <dd><textarea name="content" class="text" maxlength="200" placeholder="我是..."></textarea></dd>
                <dd>验证码：<input type="text" name="code" maxlength="4">
                     <img src="yzm/text.php" id="code">
                </dd>
                <dd><input type="submit" name="submit" value="添加好友" class="submit"></dd>
            </dl>
        </form>
    </div>
</body>
</html>