<?php
/**
 * @Author: Marte
 * @Date:   2017-06-09 19:08:06
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-15 20:43:53
 */
 if (!defined('IN_TG')) {
     exit('Access Defined');
 }
 $_message=_fetch_array("SELECT
                            COUNT(tg_id)
                        AS count
                        FROM tg_message
                        WHERE tg_state=0 AND tg_touser='{$_COOKIE['username']}'");
if (empty($_messages['count'])) {

}else{
    $_messages_html='<strong class="read"><a href="../member_message.php">'.($_message['count']).'</a></strong>';
}
?>
<div id="member_sidebar">
    <h2>中心导航</h2>
    <dl>
        <dt>账号管理</dt>
        <dd><a href="member.php">个人信息</a></dd>
        <dd><a href="member_modify.php">修改资料</a></dd>
        <dd><a href="member_mima.php">修改密码</a></dd>
    </dl>
    <dl>
        <dt>其他管理</dt>
        <dd><a href="member_message.php">短信查询</a></dd>
        
        <dd><a href="member_friend.php">好友申请</a></dd>
        <dd><a href="member_flower.php">点赞查询</a></dd>
        <dd><a href="member_wdhy.php">我的好友</a></dd>
        
    </dl>


</div>