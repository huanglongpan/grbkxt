<?php
/**
 * @Author: Marte
 * @Date:   2017-10-15 19:07:30
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-15 20:30:15
 */
session_start();
 define('IN_TG', true);

 define('SCRIPT', 'sanchu');
 require dirname(__FILE__).'/includes/common.inc.php';
 if (!!$_rows2=_fetch_array("SELECT
                                tg_uniqid
                            FROM
                                tg_uger
                            WHERE tg_username='{$_COOKIE['username']}'
                            LIMIT 1")) {
          //防止cookie伪造，比对唯一标识符
          _uniqid($_rows2['tg_uniqid'],$_COOKIE['uniqid']);
_query("DELETE FROM tg_friend WHERE ((tg_formuser='{$_GET['name']}' AND tg_touser='{$_COOKIE['username']}') OR (tg_touser='{$_GET['name']}' AND tg_formuser='{$_COOKIE['username']}')) ");
if (_affected_rows()==1) {
                 //关闭数据库
                 mysql_close();
                 _session_destroy();
                 //跳转到首页
                 _location('删除成功','member_wdhy.php');
             }else{
                mysql_close();
                _session_destroy();
               //跳转到首页
               _location('删除成功','member_wdhy.php');
             }
}else{
    _alert_back("操作异常！");
}

 ?>