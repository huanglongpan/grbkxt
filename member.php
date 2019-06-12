<?php
/**
 * @Author: Marte
 * @Date:   2017-06-09 18:15:00
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-09-08 21:46:38
 */
 define('IN_TG', true);

 define('SCRIPT', 'member');

 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
 if (isset($_COOKIE['username'])) {
    $_rows = _fetch_array("SELECT tg_level,tg_username,tg_sex,tg_face,tg_qq,tg_reg_time FROM tg_uger WHERE tg_username='{$_COOKIE['username']}'");
    if ($_rows) {
        $_html=array();
        $_html['username']=$_rows['tg_username'];
        $_html['sex']=$_rows['tg_sex'];
        $_html['face']=$_rows['tg_face'];
        //$_html['email']=$_rows['tg_email'];
        $_html['qq']=$_rows['tg_qq'];
        $_html['reg_time']=$_rows['tg_reg_time'];
        switch ($_rows['tg_level']) {
            case 0:
                $_html['level']='普通会员';
                break;
            case 1:
                $_html['level']='管理员';
                break;
            default:$_html['level']='出错';
        }
        $_html=_html($_html);
    }else{
        _alert_back('此用户不存在');
    }
 }else{
    _alert_back('非法登录');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>多用户留言系统--个人中心</title>
    <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
    <link rel="stylesheet" type="text/css" href="style/1/member.css">
</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
?>

    <div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php'; ?>
        <div id="member_main">
            <h2>信息管理</h2>
            <dl>
                <dt></dt>
                <dd><span>用 户 名：</span>　<?php echo $_html['username'] ?></dd>
                <dd><span>性 　 别：</span>　<?php echo $_html['sex'] ?></dd>
                <dd><span>头 　 像：</span>　<img src="<?php echo $_html['face'] ?>" width="100" height="100"></dd>
                <!-- <dd><span>电子邮箱:</span> 　<?php echo $_html['email'] ?></dd> -->
                <dd><span>QQ　　 :</span>  　<?php echo $_html['qq'] ?></dd>
                <dd><span>注册时间:</span> 　<?php echo $_html['reg_time'] ?></dd>
                <dd><span>身 　 份：</span>　<?php echo $_html['level'] ?></dd>
            </dl>
        </div>
    </div>

<?php
    require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>