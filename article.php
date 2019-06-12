<?php
/**
 * @Author: Marte
 * @Date:   2017-10-10 18:03:52
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-23 22:16:06
 */
 header('Cache-control: private, must-revalidate');
 session_cache_limiter('private, must-revalidate');
 session_start();
 define('IN_TG', true);

 define('SCRIPT', 'article');

 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php

 if (isset($_GET['action']) && $_GET['action']=='rearticle') {
     _check_code($_POST["code"],$_SESSION["code"]);//验证码
    if (!!$_rows=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
          _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
        $_clean=array();
        $_clean['reid']=$_POST['reid'];
        $_clean['content']=$_POST['content'];
        $_clean['username']=$_COOKIE['username'];
        $_clean=_mysql_string($_clean);

        //写人评论表
        _query("INSERT INTO tg_article(
                                        tg_reid,
                                        tg_username,
                                        tg_content,
                                        tg_date
                                    )VALUES(
                                        '{$_clean['reid']}',
                                        '{$_clean['username']}',
                                        '{$_clean['content']}',
                                        NOW()
                                    )");
        if (_affected_rows()==1) {
         //关闭数据库
         _query("UPDATE tg_article SET tg_commendcount=tg_commendcount+1 WHERE tg_reid=0 AND tg_id='{$_clean['reid']}'");
            mysql_close();
            _session_destroy();
         //跳转到首页
         _location('恭喜您，评论成功','article.php?id='.$_clean['reid']);
        }else{
            mysql_close();
            _session_destroy();
        //跳转到首页
            _alert_back('很遗憾评论失败');
        }
    }else{
        _alert_back('操作异常！');
    }
 }

 if (isset($_GET['id'])) {
    if(!!$_rows=_fetch_array("SELECT
                                *
                            FROM tg_article
                            WHERE tg_reid=0 AND tg_id='{$_GET['id']}'")){
              //累计阅读量
      _query("UPDATE tg_article SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");

        $_html=array();
        $_html['reid']=$_rows['tg_id'];
        $_html['username']=$_rows['tg_username'];
        $_html['title']=$_rows['tg_title'];
        $_html['type']=$_rows['tg_type'];
        $_html['content']=$_rows['tg_content'];
        $_html['readcount']=$_rows['tg_readcount'];
        $_html['commendcount']=$_rows['tg_commendcount'];
        $_html['date']=$_rows['tg_date'];
        // print_r($_html);
        // 创建一个全局变量，做个待参的分页
        global $_id;
        $_id='id='.$_html['reid'].'&';

        //拿出用户名去tg_uger中查找用户信息
        if (!!$_rows=_fetch_array("SELECT
                                        tg_id,tg_face,tg_sex,tg_level
                                FROM tg_uger
                                WHERE tg_username='{$_html['username']}'")) {
            $_html['ugerid']=$_rows['tg_id'];
            $_html['face']=$_rows['tg_face'];
            $_html['sex']=$_rows['tg_sex'];
            $_html['level']=$_rows['tg_level'];

            //读取评论
            global $_pagenum,$_pagesize;
            _page("SELECT tg_id FROM tg_article WHERE tg_reid='{$_html['reid']}'",10);
            //从数据库里提取数据
            $_result=_query("SELECT tg_username,tg_content,tg_date
                FROM tg_article
                WHERE tg_reid='{$_html['reid']}'
                ORDER BY tg_date ASC
                LIMIT $_pagenum,$_pagesize");
        }else{
            //用户已被删除
        }
    }else{
        _alert_back("此帖子不存在");
    }
 }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>多用户留言系统--帖子详情</title>
    <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
    <link rel="stylesheet" type="text/css" href="style/1/article.css">
    <script type="text/javascript" src="js/article.js"></script>
</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
?>

<div id="article">
    <h2>帖子详情</h2>
    <?php if($_page==1){ ?>
    <h3>主题：<?php echo $_html['title']; ?> <img src="images/icon<?php echo $_html['type']; ?>.gif" alt="icon"></h3>
    <div id="subject">
        <dl>
            <dd class="user"><?php echo $_html['username'] ?>

                         <?php if($_html['sex']=="男")
                                echo '<img src="images/nan.png">';
                               else echo '<img src="images/nv.png">' ?>
            </dd>
            <dt><img src="<?php echo $_html['face']; ?>" alt="<?php echo $_html['username'];?>"></dt>
            <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['ugerid'] ?>">发消息</a></dd>
            <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['ugerid'] ?>">加为好友</a></dd>
            <dd class="guest">写留言</dd>
            <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['ugerid'] ?>">点赞</a></dd>
        </dl>

        <div class="content">
            <div class="user">
                <span>1楼</span><?php echo $_html['username']; ?> | 发表于：<?php echo $_html['date']; ?>
            </div>
            <div class="detail">
                <?php echo _ubb($_html['content']); ?>
            </div>
            <div class="read">
                阅读量：(<?php echo $_html['readcount']; ?>)  评论量：(<?php echo $_html['commendcount']; ?>)
            </div>
        </div>
    </div>
    <p class="line"></p>
    <?php } ?>
    <?php
        $_i=2;
        while (!!$_rows=_fetch_array_list($_result)) {
            $_html['username_html']=$_rows['tg_username'];
            $_html['content']=$_rows['tg_content'];
            $_html['date']=$_rows['tg_date'];
            $_html=_html($_html);
            //拿出评论者的用户名去tg_uger中查找用户信息
            if (!!$_rows=_fetch_array("SELECT
                                        tg_id,tg_face,tg_sex,tg_level
                                FROM tg_uger
                                WHERE tg_username='{$_html['username_html']}'")) {
                $_html['ugerid']=$_rows['tg_id'];
                $_html['face']=$_rows['tg_face'];
                $_html['sex']=$_rows['tg_sex'];
                $_html['level']=$_rows['tg_level'];
            }
    ?>

    <div class="re">
        <dl>
            <dd class="user"><?php echo $_html['username_html'] ?>
            <?php if ($_html['level']=='1') {
                echo '<span style="color:#111;font-size:12px;">(站长)</span>';
            }else{
                if ($_html['username_html']==$_html['username']) {
                echo '<span style="color:#111;font-size:12px;">(楼主)</span>';
            } }?>
                         <?php if($_html['sex']=="男")
                                echo '<img src="images/nan.png">';
                               else echo '<img src="images/nv.png">' ?>
            </dd>
            <dt><img src="<?php echo $_html['face']; ?>" alt="<?php echo $_html['username'];?>"></dt>
            <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['ugerid'] ?>">发消息</a></dd>
            <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['ugerid'] ?>">加为好友</a></dd>
            <dd class="guest">写留言</dd>
            <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['ugerid'] ?>">点赞</a></dd>
        </dl>

        <div class="content">
            <div class="user">
                <span><?php echo ($_i+($_page-1)*$_pagesize); ?>楼</span><?php echo $_html['username']; ?> | 发表于：<?php echo $_html['date']; ?>
            </div>
            <div class="detail">
                <?php echo _ubb($_html['content']); ?>
            </div>
        </div>
    </div>
    <p class="line"></p>

    <?php
        }
        _free_result($_result);
        _paging(1);
        _paging(2);
    ?>


    <?php if (isset($_COOKIE['username'])) { ?>
    <form action="?action=rearticle" method="post" >
    <div id="toux">
        <div id="close">关闭</div>
        <h5>选择图片</h5>
        <div id="one">
            <?php
                foreach(range(1,48) as $num){
            ?>
            <dd><img src="images/1/<?php echo $num?>.gif" alt="images/1/<?php echo $num?>.gif"></dd>
            <?php } ?>
        </div>
        <div id="two">
            <?php
                foreach(range(1,10) as $num){
            ?>
            <dd><img src="images/2/<?php echo $num?>.gif" alt="images/2/<?php echo $num?>.gif"></dd>
            <?php } ?>
        </div>
        <div id="three">
            <?php
                foreach(range(1,39) as $num){
            ?>
            <dd><img src="images/3/<?php echo $num?>.gif" alt="images/3/<?php echo $num?>.gif"></dd>
            <?php } ?>
        </div>
    </div>
    <input type="hidden" name="reid" value="<?php echo $_html['reid'] ?>">
        <dl>
            <dd id="tt">贴　　图：<a href="javascript:;">Q图系列【1】</a>  <a href="javascript:;">Q图系列【2】</a>  <a href="javascript:;">Q图系列【3】</a></dd>
            <dd>
            <div id="ubb">
                <img src="images/fontsize.gif" title="字体大小">
                <img src="images/space.gif" alt="">
                <img src="images/bold.gif" title="加粗">
                <img src="images/underline.gif" title="斜体">
                <img src="images/underline.gif" title="下划线">
                <img src="images/strikethrough.gif" title="删除线">
                <img src="images/space.gif">
                <img src="images/color.gif" title="颜色">
                <img src="images/url.gif" title="链接">
                <img src="images/email.gif" title="邮件">
                <img src="images/image.gif" title="图片">
                <img src="images/swf.gif" title="flash">
                <img src="images/movie.gif" title="影片">
                <img src="images/space.gif">
                <img src="images/left.gif" title="居左">
                <img src="images/center.gif" title="居中">
                <img src="images/right.gif" title="居右">
                <img src="images/space.gif">
                <img src="images/increase.gif" title="扩大输入区">
                <img src="images/decrease.gif" title="缩小输入区">
                <img src="images/help.gif" title="帮助">
            </div>
            <textarea name="content"></textarea>
            </dd>
            <dd>验证码： <input type="text" name="code" maxlength="4">
                     <img src="yzm/text.php" id="code"></dd>
            <dd><input type="submit" value="发表帖子" class="submit" /></dd>
        </dl>
    </form>
    <?php }else{ ?>
        <div style="width:500px;height:100px;border:2px dashed #000;margin: auto;font-size: 30px;text-align: center;line-height: 100px;">登录后才可以发起评论</div>
        <?php } ?>
</div>

<?php
    require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>