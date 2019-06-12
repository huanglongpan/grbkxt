/*
* @Author: Marte
* @Date:   2017-05-24 18:50:28
* @Last Modified by:   Marte
* @Last Modified time: 2017-05-24 18:57:09
*/
window.onload=function(){
    var code=document.getElementById('code');
    code.onclick=function(){
    this.src='yzm/text.php?tm='+Math.random();
  };

  var fm=document.getElementsByTagName('form')[0];
  fm.onsubmit=function(){
    //用户名验证
    if (fm.username.value.length<2||fm.username.value.length>20) {
        alert("用户名长度必须大于2位小于20位");
        fm.username.value="";//清空用户名
        fm.username.focus();//将光标移至表单
        return false;
    }
    if (/[<>\'\"\\　 ]/.test(fm.username.value)) {
        alert("用户名不得含有敏感字符");
        fm.username.value="";//清空用户名
        fm.username.focus();//将光标移至表单
        return false;
    }

    //验证密码
    if (fm.password.value.length<6) {
        alert("密码长度必须大于6位");
        fm.password.value="";
        fm.password.focus();
        return false;
    }
   }
}