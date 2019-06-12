<?php
/**
 * @Author: Marte
 * @Date:   2017-05-31 17:47:51
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-18 19:33:57
 */
 session_start();
 define('IN_TG', true);

 define('SCRIPT', 'blog');

 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
 global $_pagenum,$_pagesize;
if (isset($_GET['action']) && $_GET['action']=='ss') {
    $_sousuo=$_POST['ss'];
    _page("SELECT tg_id FROM tg_uger WHERE tg_username like '%$_sousuo%'",10);
    $_result=_query("SELECT tg_id,tg_username,tg_sex,tg_face FROM tg_uger WHERE tg_username like '%$_sousuo%' ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize");
}else{
 _page("SELECT tg_id FROM tg_uger",10);//指定每页数据条数
 //从数据库里提取数据
 $_result=_query("SELECT tg_id,tg_username,tg_sex,tg_face,tg_level FROM tg_uger ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>多用户留言系统--博友</title>
    <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
    <link rel="stylesheet" type="text/css" href="style/1/blog.css">
    <script src="js/blog.js" type="text/javascript"></script>
</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
?>

<div id="blog">
    <h2>博友列表</h2>
    <div class="ss">
    <form action="?action=ss"  method="post" accept-charset="utf-8">
        <input type="text" name="ss" id="ss" placeholder="用户名" value="">
        <input type="submit" name="">
    </form>

    </div>
    <div id="boyou">
        <?php
            $_html=array();
            while (!!$_rows=_fetch_array_list($_result)) {

                $_html['id']=$_rows['tg_id'];
                $_html['username']=$_rows['tg_username'];
                $_html['face']=$_rows['tg_face'];
                $_html['sex']=$_rows['tg_sex'];
                //$_html['level']=$_rows['tg_level'];
                $_html=_html($_html);
        ?>
    <dl>
        <dd class="user"><?php echo $_html['username'] ?>
                        
                         <?php if($_html['sex']=="男")
                                echo '<img src="images/nan.png">';
                               else echo '<img src="images/nv.png">' ?>
        </dd>
        <dt><img src="<?php echo $_html['face']; ?>"></dt>
        <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['id'] ?>">发消息</a></dd>
        <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['id'] ?>">加为好友</a></dd>
        <dd class="guest">写留言</dd>
        <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['id'] ?>">点赞</a></dd>
    </dl>
    <?php
        }
        _free_result($_result);
    ?>

    <?php
     _paging(1);
     _paging(2);
    ?>
    </div>



</div>

<?php
    require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>