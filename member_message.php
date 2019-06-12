<?php
/**
 * @Author: Marte
 * @Date:   2017-08-24 18:44:14
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-15 19:18:12
 */
 session_start();
 define('IN_TG',true);
 define('SCRIPT','member_message');
 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
 if (!isset($_COOKIE['username'])) {
     _alert_back('请先登录!');
 }

//批量标为未读已读
if (isset($_GET['action'])&& $_GET['action']=='yidu') {
    $_clean=array();
    $_clean['ids'] =_mysql_string(implode(",",$_POST['ids']));
    if (!!$_rows3=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
          _uniqid($_rows3['tg_uniqid'],$_COOKIE['uniqid']);
      _query("UPDATE
                        tg_message
                    SET tg_state=1
                    WHERE tg_id
                    IN ({$_clean['ids']})");
      if (_affected_rows()) {
                 //关闭数据库
                 mysql_close();
                 _session_destroy();
                 //跳转到首页
                 _location('已标为已读','member_message.php');
             }else{
                mysql_close();
                _session_destroy();
               //跳转到首页
               _alert_back('操作失败');
             }
    }else{
        _alert_back('危险操作');
    }
    exit();
}

//批量标为未读
if (isset($_GET['action'])&& $_GET['action']=='weidu') {
    $_clean=array();
    $_clean['ids'] =_mysql_string(implode(",",$_POST['ids']));
    if (!!$_rows3=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
          _uniqid($_rows3['tg_uniqid'],$_COOKIE['uniqid']);
      _query("UPDATE
                        tg_message
                    SET tg_state=0
                    WHERE tg_id
                    IN ({$_clean['ids']})");
      if (_affected_rows()) {
                 //关闭数据库
                 mysql_close();
                 _session_destroy();
                 //跳转到首页
                 _location('已标为未读','member_message.php');
             }else{
                mysql_close();
                _session_destroy();
               //跳转到首页
               _alert_back('操作失败');
             }
    }else{
        _alert_back('危险操作');
    }
    exit();
}

//批量删除短信
if (isset($_GET['action'])&& $_GET['action']=='delete') {
    $_clean=array();
    $_clean['ids'] =_mysql_string(implode(",",$_POST['ids']));
    //echo $_clean['ids'];
    //敏感操作，比较唯一标识符
    if (!!$_rows2=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
          _uniqid($_rows2['tg_uniqid'],$_COOKIE['uniqid']);
      _query("DELETE FROM
                tg_message
            WHERE tg_id
            IN ({$_clean['ids']})"
            );
      if (_affected_rows()) {
                 //关闭数据库
                 mysql_close();
                 _session_destroy();
                 //跳转到首页
                 _location('删除成功','member_message.php');
             }else{
                mysql_close();
                _session_destroy();
               //跳转到首页
               _alert_back('删除失败');
             }
    }else{
        _alert_back('危险操作');
    }
    exit();
}

 //分页
 global $_pagenum,$_pagesize;
 _page("SELECT tg_id FROM tg_message WHERE tg_touser='{$_COOKIE['username']}'",12);//分页
  $_result=_query("SELECT tg_id,tg_state,tg_formuser,tg_content,tg_date
    FROM tg_message
    WHERE tg_touser='{$_COOKIE['username']}'
    ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>多用户留言系统——收信箱</title>
    <?php
        require ROOT_PATH.'includes/title.inc.php';
    ?>
    <link rel="stylesheet" type="text/css" href="style/1/member_message.css">
    <script type="text/javascript" src="js/member_message.js">
    </script>
</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
?>
    <div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php'; ?>
        <div id="member_main">
            <h2>短信管理</h2>
            <form method="post" name="form">
                <table  cellspacing="1">
                        <tr>
                            <th>发件人</th>
                            <th>短信内容</th>
                            <th>时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        <?php
                            $_html=array();
                            while (!!$_rows=_fetch_array_list($_result)) {

                                $_html['id']=$_rows['tg_id'];
                                $_html['formuser']=$_rows['tg_formuser'];
                                $_html['content']=$_rows['tg_content'];
                                $_html['date']=$_rows['tg_date'];
                                $_html=_html($_html);
                                if ($_rows['tg_state']=='0') {
                                    $_html['state']='<img src="images/wd.gif" alt="未读" title="未读">';
                                    $_html['content_html']='<b>'._title($_html['content'],14).'</b>';
                                    $_html['formuser']='<strong>'.$_html['formuser'].'</strong>';
                                    $_html['date']='<strong>'.$_html['date'].'</strong>';
                                }else{
                                    $_html['state']='<img src="images/yd.png" alt="已读" title="已读">';
                                    $_html['content_html']=_title($_html['content'],14);
                                }
                        ?>
                        <tr>
                            <td><?php echo $_html['formuser'];?></td>
                            <td title="<?php echo $_html['content']?>">
                                <a href="member_message_detail.php?id=<?php echo $_html['id'] ?>">
                                    <?php echo $_html['content_html'];?>
                                </a>
                            </td>
                            <td><?php echo $_html['date'];?></td>
                            <td><?php echo $_html['state']?></td>
                            <td><input type="checkbox" name="ids[]" value="<?php echo $_html['id']?>" /></td>
                        </tr>
                        <?php
                            }
                            _free_result($_result);
                        ?>
                        <tr><td colspan="5"><label for="all">全选 <input type="checkbox" name="chkall" id="all" /></label>
                        <input type="submit" value="批量删除" id="delete">
                        <input type="submit" value="标为未读" id="weidu">
                        <input type="submit" value="标为已读" id="yidu">
                        </td></tr>
                </table>
                <?php _paging(2); ?>
            </form>

        </div>
    </div>

<?php
    require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>