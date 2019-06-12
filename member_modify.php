<?php
/**
 * @Author: Marte
 * @Date:   2017-06-11 15:09:38
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-09-25 19:36:10
 */
 session_start();
 define('IN_TG', true);

 define('SCRIPT', 'member_modify');

 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
//修改资料
if (isset($_GET['action'])=='modify') {
    if (!!$_rows=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
          _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
            //引入验证文件进行验证
         include ROOT_PATH.'/includes/register.func.php';
         _check_code($_POST["code"],$_SESSION["code"]);
         $_clean=array();
         $_clean["sex"]=_check_sex($_POST["sex"]);
         $_clean["face"]=_check_face($_POST["face"]);
         $_clean["qq"]=_check_qq($_POST["qq"]);
         //$_clean["password"]=_check_modif_password($_POST["xgpassword"],6);
         // print_r($_clean);
         //if (empty($_clean['password'])) {
                mysql_query("UPDATE tg_uger SET
                                    tg_sex='{$_clean['sex']}',
                                    tg_face='{$_clean['face']}',
                                    tg_qq='{$_clean['qq']}'
                                WHERE
                                  tg_username='{$_COOKIE['username']}'");
         // }else{
         //    mysql_query("UPDATE tg_uger set
         //                            tg_password='{$_clean['password']}',
         //                            tg_sex='{$_clean['sex']}',
         //                            tg_face='{$_clean['face']}'
         //                        where
         //                          tg_username='{$_COOKIE['username']}'");
         // }
         if (_affected_rows()) {
             //关闭数据库
             mysql_close();
             _session_destroy();
             _location('恭喜您修改成功','member.php');
         }else{
            mysql_close();
            _session_destroy();
           _location('未进行任何修改！','member_modify.php');
         }

    }

 }

 if (isset($_COOKIE['username'])) {
    $_rows = _fetch_array("SELECT tg_level,tg_username,tg_sex,tg_face,tg_qq,tg_reg_time FROM tg_uger WHERE tg_username='{$_COOKIE['username']}'");

    if ($_rows) {
        $_html=array();
        $_html['username']=$_rows['tg_username'];
        $_html['sex']=$_rows['tg_sex'];
        $_html['face']=$_rows['tg_face'];
        $_html['qq']=$_rows['tg_qq'];
        $_html=_html($_html);
        if ($_html['sex']=='男') {
            $_html['sex_html']='<input type="radio" name="sex" value="男" checked="checked" /> 男 <input type="radio" name="sex" value="女" />女';
        }elseif($_html['sex']=='女'){
            $_html['sex_html']='<input type="radio" name="sex" value="男" /> 男 <input type="radio" name="sex" value="女" checked="checked" />女';
        }

    }else{
        _alert_back('此用户不存在');
    }
 }else{
    _alert_back('非法登录');
 }
 //$_face='<img class="face" name="face" src="'.$_html['face'].'" id="faceimg">';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>多用户留言系统--修改资料</title>
    <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
    <link rel="stylesheet" type="text/css" href="style/1/member_modify.css">
    <script type="text/javascript" src="js/register.js"></script>
</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
?>

    <div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php'; ?>
        <div id="member_main">
            <h2>修改资料</h2>
            <form action="member_modify.php?action=modify" method="post" name="register">
            <dl>
                <dt></dt>
                <dd><span>用 户 名：</span>　<?php echo $_html['username'] ?></dd>
                <dd><span>性 　 别：</span>　<?php echo $_html['sex_html'] ?></dd>
                <dd><span>头　  像：</span>　
                <input type="hidden" name="face" value="<?php echo $_html['face']?>" id="face">
                <img class="face" src="<?php echo $_html['face']?>"  title="头像选择" id="faceimg">
                </dd>
                <!-- <?php echo $_face ?></dd> -->
                <!-- <dd><span>电子邮箱:</span> 　<input type="email" name="email" class="text" value="<?php echo $_html['email'] ?>" /></dd> -->
                <dd><span>QQ　　 :</span>  　<input type="text" name="qq" class="text" value="<?php echo $_html['qq'] ?>" /></dd>
                <!-- <dd><span>密　  码：</span>  　<input type="password" class="text" name="xgpassword">(不填则不修改)</dd> -->
                <dd><span>验 证 码：</span>　　<input type="text" name="code" maxlength="4">
                     <img src="yzm/text.php" id="code"></dd>
                <dd><input type="submit" class="submit" value="修改资料"></dd>
            </dl>
            </form>

        </div>
    </div>

<?php
    require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>