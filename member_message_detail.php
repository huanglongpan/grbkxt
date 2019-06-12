<?php
/**
 * @Author: Marte
 * @Date:   2017-09-21 21:54:41
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-10 20:28:44
 */
 session_start();
 define('IN_TG',true);
 define('SCRIPT','member_message_detail');
 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
 if (!isset($_COOKIE['username'])) {
     _alert_back('请先登录!');
 }

  //标为未读
if (isset($_GET['action'])&& $_GET['action']=='weidu' && isset($_GET['id'])) {
    if (!!$_rows = _fetch_array("SELECT
            tg_id
        FROM
            tg_message
        WHERE
            tg_id='{$_GET['id']}'
        LIMIT 1")) {
        //敏感操作，对唯一标识符进行验证
        if (!!$_rows2=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
          _uniqid($_rows2['tg_uniqid'],$_COOKIE['uniqid']);
      //标为未读
         _query("UPDATE
                        tg_message
                    SET tg_state=0
                    WHERE tg_id='{$_GET['id']}'
                    LIMIT 1");
         if (_affected_rows()==1) {
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
             }
             }else{
            _alert_back('此短信不存在');
        }
    exit();

}
 //删除短信
 if (isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['id'])) {
    //验证短信是否存在
    if (!!$_rows = _fetch_array("SELECT
            tg_id
        FROM
            tg_message
        WHERE
            tg_id='{$_GET['id']}'
        LIMIT 1")) {
        //敏感操作，对唯一标识符进行验证
        if (!!$_rows2=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
          _uniqid($_rows2['tg_uniqid'],$_COOKIE['uniqid']);
      //删除短信
      _query("DELETE FROM
                tg_message
            WHERE
                tg_id='{$_GET['id']}'
            LIMIT 1");
              if (_affected_rows()==1) {
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
        }
    }else{
        _alert_back('此短信不存在');
    }

    exit();
 }



//获取数据
 if (isset($_GET['id'])) {
     $_rows = _fetch_array("SELECT
            tg_id,tg_state,tg_formuser,tg_content,tg_date
        FROM
            tg_message
        WHERE
            tg_id='{$_GET['id']}'
        LIMIT 1");
     if ($_rows) {
        if ($_rows['tg_state']=='0') {
            _query("UPDATE
                    tg_message
                SET tg_state=1
                WHERE tg_id='{$_GET['id']}'
                LIMIT 1");
            if (!_affected_rows()) {
                _alert_back('异常');
            }
        }
         $_html=array();
         $_html['id']=$_rows['tg_id'];
         $_html['formuser']=$_rows['tg_formuser'];
         $_html['content']=$_rows['tg_content'];
         $_html['date']=$_rows['tg_date'];
     }else{
        _alert_back('此短信不存在');
     }
 }else{
        _alert_back('非法登录');
     }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>个人博客系统--短信查询</title>
    <?php
        require ROOT_PATH.'includes/title.inc.php';
    ?>
    <link rel="stylesheet" type="text/css" href="style/1/member_message_detail.css">
    <script type="text/javascript" src="js/member_message_detail.js"></script>
</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
?>
<div id="member">
    <?php require ROOT_PATH.'includes/member.inc.php'; ?>
    <div id="member_main">
        <h2>短信查看</h2>
        <div id="page1">
            <input type="button" value="《 返回列表  " id="return" class="input" />
            <input type="button" value="删除" class="input" id="delete" name="<?php echo $_html['id']?>">
            <a href="javascript:;" id="huixin" title="<?php echo $_html['formuser'] ?>">回信</a>
            <!-- <input type="button" value="回信" class="input"  id="message" title="<?php echo $_html['formuser'] ?>" > -->
            <input type="button" class="input" id="weidu" value="标为未读" name="<?php echo $_html['id']?>" />

        </div>
        <dl>
            <div id="page2">

                <dd><b>发件人：</b><?php echo $_html['formuser']?></dd>
                <dd><b>发件时间：</b><?php echo $_html['date']?></dd>
            </div>

            <dd><b>内容：</b></dd>
            <dd>　　<?php echo _ubb($_html['content']);?></dd>
        </dl>
    </div>
</div>


<?php
    require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>