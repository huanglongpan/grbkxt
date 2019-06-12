<?php
define('IN_TG', true);

define('SCRIPT', 'active');

 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
 //开始激活处理
 if (!isset($_GET['active'])) {
     _alert_back("非法操作");
 }
 if (isset($_GET['action'])&&isset($_GET['active'])&&$_GET["action"]=="ok") {
     $_active=_mysql_string($_GET['active']);
     if (_fetch_array("select tg_active from tg_uger where tg_active='$_active' LIMIT 1")) {
        _query("update tg_uger set tg_active=NULL where tg_active='$_active' LIMIT 1");
        if (_affected_rows()==1) {
            mysql_close();
            _location("账户激活成功","login.php");
        }else{
            mysql_close();
            _location("账户激活失败","register.php");
        }
     }else{
        _alert_back("非法操作");
     }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>多用户留言系统--激活</title>
    <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
    <link rel="stylesheet" type="text/css" href="style/1/active.css">
</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
?>


    <div id="active">
        <h2>激活界面</h2>
        <p>本页面是为了模拟您的邮箱激活账户的</p>
        <p><a href="active.php?action=ok&amp;active=<?php echo $_GET["active"] ?>">
            <?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"] ?>active.php?action=ok&amp;active=<?php echo $_GET["active"] ?>
        </a></p>
    </div>


<?php
    require ROOT_PATH.'includes/footer.inc.php';
 ?>
</body>
</html>