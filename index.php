<?php
   define('IN_TG', true);
   define('SCRIPT','index');
   require dirname(__FILE__).'/includes/common.inc.php';
   $_html=_html(_get_xml('new.xml'));
   //读取帖子列表
   
   global $_pagenum,$_pagesize;
   if (isset($_GEt["action"]) && $_GET['action']=='ss') {
    $_sousuo=$_POST['ss'];
      _page("SELECT tg_id FROM tg_article WHERE tg_reid=0 AND tg_title like '%$_sousuo%'",10);//指定每页数据条数

      //从数据库里提取数据
      $_result=_query("SELECT
                      tg_id,tg_title,tg_type,tg_readcount,tg_commendcount
                  FROM tg_article
                  WHERE tg_reid=0 AND tg_title like '%$_sousuo%'
                  ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize");
   }else{
  _page("SELECT tg_id FROM tg_article WHERE tg_reid=0",10);//指定每页数据条数

  //从数据库里提取数据
 $_result=_query("SELECT
                      tg_id,tg_title,tg_type,tg_readcount,tg_commendcount
                  FROM tg_article
                  WHERE tg_reid=0 
                  ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize");
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>多用户留言系统主</title>
	<title>多用户留言系统-index</title>

	<link rel="shortcut icon" href="images/huaji.ico">
	<link rel="stylesheet" type="text/css" href="style/1/basic.css">
	<link rel="stylesheet" type="text/css" href="style/1/index.css">
  <link rel="stylesheet" type="text/css" href="style/1/源码css.css">
  <script type="text/javascript" src="js/源码js.js"></script>

</head>
<body>

    <?php
      require ROOT_PATH.'includes/header.inc.php';
    ?>

	<div id="list">
		<h2>帖子列表</h2>
    <form action="?action=ss"  method="post" accept-charset="utf-8">
        <input type="text" name="ss" id="ss" placeholder="帖子名" value="">
        <input type="submit" name="">
    </form>
        <a href="post.php" class="post"></a>
        <ul class="article">
            <?php
              $_htmllist=array();
              while (!!$_rows=_fetch_array_list($_result)) {
                $_htmllist['id']=$_rows['tg_id'];
                $_htmllist['type']=$_rows['tg_type'];
                $_htmllist['title']=$_rows['tg_title'];
                $_htmllist['readcount']=$_rows['tg_readcount'];
                $_htmllist['commendcount']=$_rows['tg_commendcount'];
                $_htmllist=_html($_htmllist);
            ?>
            <li class="icon<?php echo $_htmllist['type']?>"><a href="article.php?id=<?php echo $_htmllist['id'];?>" target="_blank"><?php echo _title($_htmllist['title'],17)?></a>
            <em>评论数(<?php echo $_htmllist['commendcount']?>)</em>
            <em>阅读数(<?php echo $_htmllist['readcount']?>)　</em></li>
            <?php
              }
            ?>
        </ul>
        <?php _paging(2); ?>
	</div>
	<div id="user">
		<h2>通知中心</h2>
        <dl>
            <dd>欢迎 <span style="color:red;"><?php echo $_html['username'] ?> </span>注册加入！</dd>
            <dd>域名正在备案中，暂时无法通过域名访问！敬请期待</dd>
            <dd><marquee>♉本网站之后可能会更新，敬请期待♉</marquee></dd>
        </dl>
	</div>
	<div id="pics">
		<h2>最新图片</h2>
      <div id="container">
          <div id="last" style="left: -334px;">
              <img src="img/5.jpg" alt="1"/>
              <img src="img/1.jpg" alt="1"/>
              <img src="img/2.jpg" alt="2"/>
              <img src="img/3.jpg" alt="3"/>
              <img src="img/4.jpg" alt="4"/>
              <img src="img/5.jpg" alt="5"/>
              <img src="img/1.jpg" alt="5"/>
          </div>
          <div id="buttons">
              <span index="1" class="on"></span>
              <span index="2"></span>
              <span index="3"></span>
              <span index="4"></span>
              <span index="5"></span>
          </div>
          <a href="javascript:;" id="prev" class="arrow">&lt;</a>
          <a href="javascript:;" id="next" class="arrow">&gt;</a>
      </div>
	</div>

    <?php
       require ROOT_PATH.'includes/footer.inc.php';
    ?>

</body>
</html>
