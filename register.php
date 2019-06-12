<?php
header('Cache-control: private, must-revalidate');
 session_cache_limiter('private, must-revalidate');
 session_start();
 define('IN_TG', true);

 define('SCRIPT', 'register');

 require dirname(__FILE__).'/includes/common.inc.php';   //引用公共文件common.inc.php
 _login_state();//登录状态判断
 if (isset($_GET['action'])=='register') {
  //验证码
  _check_code($_POST["code"],$_SESSION["code"]);
     //引入验证文件进行验证
     include ROOT_PATH.'/includes/register.func.php';

     //创建一个空数组，用来存放提交过来的合法数据
     $_clean=array();
     $_clean["uniqid"]=_check_uniqid($_POST['uniqid'],$_SESSION["uniqid"]);
     //$_clean["active"]=sha1(uniqid(rand(),true));
     $_clean["username"]=_check_username($_POST["username"],2,20);
     $_clean["password"]=_check_password($_POST["password"],$_POST["notpassword"],6);
     $_clean["question"]=_check_question($_POST["question"],4,20);
     $_clean["answer"]=_check_answer($_POST["question"],$_POST["answer"],2,20);
     $_clean["sex"]=_check_sex($_POST["sex"]);
     $_clean["face"]=_check_face($_POST["face"]);
     //$_clean["email"]=_check_email($_POST["email"]);
     $_clean["qq"]=_check_qq($_POST["qq"]);

     //判断用户名是否重复
     _is_repeat(
          "select tg_username from tg_uger where tg_username='{$_clean["username"]}'LIMIT 1",
          '对不起，此用户名已存在'
      );

     mysql_query("INSERT INTO tg_uger(
                                      tg_uniqid,
                                      tg_username,
                                      tg_password,
                                      tg_question,
                                      tg_answer,
                                      tg_sex,
                                      tg_face,
                                      tg_qq,
                                      tg_reg_time,
                                      tg_last_time,
                                      tg_last_ip
                                       ) VALUES(
                                                  '{$_clean["uniqid"]}',
                                                  '{$_clean["username"]}',
                                                  '{$_clean["password"]}',
                                                  '{$_clean["question"]}',
                                                  '{$_clean["answer"]}',
                                                  '{$_clean["sex"]}',
                                                  '{$_clean["face"]}',
                                                  '{$_clean["qq"]}',
                                                  NOW(),
                                                  NOW(),
                                                  '{$_SERVER["REMOTE_ADDR"]}'
                                                 )");
     if (_affected_rows()==1) {
        //获取刚生成的id
        $_clean['id']=_insert_id();
         //关闭数据库
         mysql_close();
         _session_destroy();
         //生成xml
         _set_xml('new.xml',$_clean);
         //跳转到首页
         _location('恭喜您注册成功','login.php');
     }else{
        mysql_close();
        _session_destroy();
       //跳转到首页
       _location('很遗憾您注册失败','register.php');
     }

   }
  //uniqid唯一标识符，sha1加密，防止跨站注册
  $_SESSION["uniqid"]=$_uniqud= sha1(uniqid(rand(), true));

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>多用户留言系统--注册</title>
  <?php  require ROOT_PATH.'includes/title.inc.php'; ?>
  <script type="text/javascript" src="js/register.js"></script>


</head>
<body>

 <?php
    require ROOT_PATH.'includes/header.inc.php';
?>

   <div id="register">
   	<h2>会员注册</h2>

   	<form method="post" name="register" action="register.php?action=register">
  <!--   <input type="hidden" name="action" value="register" /> -->
   	  <fieldset>
   	  	<legend>龙攀留言系统注册</legend>
   		<dl>
        <input type="hidden" name="uniqid" value="<?php echo $_uniqud ?>" >
   		<dt>请填写下列内容:</dt>
   		<dd>用 户 名：<input type="text" name="username" class="text" />(*,必须是2以上)</dd>
   		<dd>密　　码：<input type="password" name="password" class="text" />(*，必须是6位以上)</dd>
   		<dd>确认密码：<input type="password" name="notpassword" class="text" />(*)</dd>
   		<dd>密码提示：<input type="text" name="question" class="text" />(*，必须是4到20位)</dd>
   		<dd>提示答案：<input type="text" name="answer" class="text" />(*，必须是2到20位)</dd>
      <dd>QQ　　  ：<input type="text" name="qq" class="text" /></dd>
   		<dd>性　　别：<input type="radio" name="sex" value="男" checked="checked" />男
   		              <input type="radio" name="sex" value="女" />女</dd>
      <dd class="face"><input type="hidden" name="face" value="face/01.jpg"><img class="face" src="face/01.jpg"  title="头像选择" id="faceimg"></dd>
   		<dd>验证码： <input type="text" name="code" maxlength="4">
   		             <img src="yzm/text.php" id="code"></dd>

   		<dd>
   			<input type="submit" value="注册" class="submit" />
		    <input type="reset" value="重新输入" />
   		</dd>
      </dl>
   	  </fieldset>

   	</form>
   </div>


 <?php
    require ROOT_PATH.'includes/footer.inc.php';
 ?>
</body>
</html>