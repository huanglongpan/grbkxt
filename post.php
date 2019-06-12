<?php
/**
 * @Author: Marte
 * @Date:   2017-10-07 19:45:06
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-18 18:11:30
 */
 header('Cache-control: private, must-revalidate');
 session_cache_limiter('private, must-revalidate');
 session_start();
 define('IN_TG', true);
 define('SCRIPT', 'post');

 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
 if (!isset($_COOKIE['username'])) {
     _location('发帖前请先登录！','login.php');
 }
 if (isset($_GET['action']) && $_GET['action']=='post') {
    _check_code($_POST["code"],$_SESSION["code"]);//验证码
    if (!!$_rows=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
          _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
      include ROOT_PATH.'/includes/register.func.php';//引入验证文件

      $_clean=array();
      $_clean['username']=$_COOKIE['username'];
      $_clean['type']=$_POST['type'];
      $_clean['title']=_check_post_title($_POST['title'],2,40);
      $_clean['content']=_check_post_content($_POST['content']);
      $_clean=_mysql_string($_clean);
      _query("INSERT INTO tg_article(
                                        tg_username,
                                        tg_title,
                                        tg_type,
                                        tg_content,
                                        tg_date
                                    )
                        VALUES(
                                 '{$_clean['username']}',
                                 '{$_clean['title']}',
                                 '{$_clean['type']}',
                                 '{$_clean['content']}',
                                 NOW()
                                )");
      if (_affected_rows()==1) {
         //关闭数据库
         mysql_close();
         _session_destroy();
         //跳转到首页
         _location('恭喜您，发帖成功','index.php');
     }else{
        mysql_close();
        _session_destroy();
       //跳转到首页
       _alert_back('很遗憾发帖失败');
     }
    }
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>多用户留言系统--发表帖子</title>
    <link rel="stylesheet" type="text/css" href="style/1/post.css">
  <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
  <script type="text/javascript" src="js/post.js"></script>


</head>
<body>

 <?php
    require ROOT_PATH.'includes/header.inc.php';
?>

   <div id="post">
    <h2>发表帖子</h2>
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

    <form method="post" name="post" action="?action=post">
        <dl>
        <input type="hidden" name="uniqid" value="<?php echo $_uniqud ?>" >
        <dt>请填写下列内容:</dt>
        <dd>
            类　　型：
            <?php
                foreach (range(1,16) as $_num) {
                    switch ($_num) {
                        case '1':
                            $_title="文章";
                            break;
                        case '2':
                            $_title="情感";
                            break;
                        case '3':
                            $_title="绿色";
                            break;
                        case '4':
                            $_title="音乐";
                            break;
                        case '5':
                            $_title="光盘";
                            break;
                        case '6':
                            $_title="扑克牌";
                            break;
                        case '7':
                            $_title="摄影";
                            break;
                        case '8':
                            $_title="军事";
                            break;
                        case '9':
                            $_title="影视";
                            break;
                        case '10':
                            $_title="热血";
                            break;
                        case '11':
                            $_title="运动";
                            break;
                        case '12':
                            $_title="错误";
                            break;
                        case '13':
                            $_title="阳光";
                            break;
                        case '14':
                            $_title="诗歌";
                            break;
                        case '15':
                            $_title="鲜花";
                            break;
                        case '16':
                            $_title="其他";
                            break;
                    }
                    if ($_num==1) {
                        echo '<label for="type'.$_num.'"><input type="radio" name="type" id="type'.$_num.'" value="'.$_num.'" checked="checked" /> ';
                    }else{
                        echo '<label for="type'.$_num.'"><input type="radio" name="type" id="type'.$_num.'" value="'.$_num.'" /> ';
                    }
                    echo '<img src="images/icon'.$_num.'.gif" alt="类型" id="type'.$_num.'" title="'.$_title.'"></label>';
                    if ($_num==8) {
                        echo '<br>　　　 　　';
                    }
                }
            ?>
        </dd>
        <dd>标　　题：<input type="text" name="title" class="text" maxlength="40" />(*,必须是2以上)</dd>
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
   </div>


 <?php
    require ROOT_PATH.'includes/footer.inc.php';
 ?>
</body>
</html>