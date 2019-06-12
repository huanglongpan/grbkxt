<?php
/**
 * @Author: Marte
 * @Date:   2017-10-14 20:42:46
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-15 20:30:02
 */
 session_start();
 define('IN_TG', true);

 define('SCRIPT', 'blog');

 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php

 //分页参数
 // global $_pagenum,$_pagesize;
 // _page("SELECT tg_id FROM tg_friend WHERE tg_state=1 AND (tg_touser='{$_COOKIE['username']}' OR tg_formuser='{$_COOKIE['username']}')",10);//指定每页数据条数
    $_html=array();
    //$_html['username']=$_COOKIE['username'];
 //从数据库里提取数据
 $_result=_query("SELECT tg_id,tg_state,tg_formuser,tg_content,tg_touser,tg_date
                    FROM tg_friend
                    WHERE tg_state=1 AND (tg_touser='{$_COOKIE['username']}' OR tg_formuser='{$_COOKIE['username']}')
                    ORDER BY tg_date DESC ");
// //删除好友
// if (isset($_GET['action']) && $_GET['action']=='delete') {
//     _query("DELETE FROM tg_friend WHERE ((tg_formuser='{$_html['username']}' AND tg_touser='{$_COOKIE['usernaem']}') OR (tg_touser='{$_html['username']}' AND tg_formuser='{$_COOKIE['username']}')) ");
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>多用户留言系统--博友</title>
    <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
    <link rel="stylesheet" type="text/css" href="style/1/member_wdhy.css">
    <script src="js/member_wdhy.js" type="text/javascript"></script>
</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
?>
<div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php'; ?>
    <div id="member_main">
        <h2>我的好友</h2>
        <div id="boyou">
            <?php

                while (!!$_rows=_fetch_array_list($_result)) {

                    $_html['touser']=$_rows['tg_touser'];
                    $_html['formuser']=$_rows['tg_formuser'];
                    if ($_html['touser']==$_COOKIE['username']) {
                        $_html['username']=$_html['formuser'];
                    }elseif ($_html['formuser']==$_COOKIE['username']) {
                        $_html['username']=$_html['touser'];
                    }




                    $_html=_html($_html);
                    //拿出用户名去tg_uger中查找用户信息
                if (!!$_rows=_fetch_array("SELECT
                                            tg_id,tg_face,tg_sex,tg_level
                                    FROM tg_uger
                                    WHERE tg_username='{$_html['username']}'")) {

                    $_html['ugerid']=$_rows['tg_id'];
                    $_html['face']=$_rows['tg_face'];
                    $_html['sex']=$_rows['tg_sex'];
                }
            ?>
        <dl>
            <dd class="user"><?php echo $_html['username'] ?>
                             <?php if($_html['sex']=="男")
                                    echo '<img src="images/nan.png">';
                                   else echo '<img src="images/nv.png">' ?>
            </dd>
            <dt><img src="<?php echo $_html['face']; ?>"></dt>
            <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['ugerid'] ?>">发消息</a></dd>

            <dd class="friend"><a href="sanchu.php?name=<?php echo $_html['username']; ?>"  id="delete" title="<?php echo $_html['ugerid']; ?>">删除好友</a></dd>
            <dd class="guest">写留言</dd>
            <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['ugerid'] ?>">点赞</a></dd>
        </dl>
        <?php
            }
            _free_result($_result);
        ?>

        <?php
         // _paging(1);
         // _paging(2);
        ?>

        </div>



    </div>
</div>


<?php
    require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>