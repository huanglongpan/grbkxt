/*
* @Author: Marte
* @Date:   2017-05-18 19:11:05
* @Last Modified by:   Marte
* @Last Modified time: 2017-10-09 20:58:58
*/

//头像选择
window.onload=function(){
  var faceimg=document.getElementById('faceimg');
  faceimg.onclick=function(){
    window.open('face.php','face','width=400,height=400,top=0,left=0,scrollBars=1');
  };

  //验证码点击切换
  var code=document.getElementById('code');
  code.onclick=function(){
    this.src='yzm/text.php?tm='+Math.random();
  };

  //表单验证
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
    if (fm.password.value!=fm.notpassword.value) {
        alert("两次密码必须一致");
        fm.notpassword.value="";
        fm.notpassword.focus();
        return false;
    }
    //验证密码提示
    if (fm.question.value.length<4||fm.question.value.length>20) {
        alert("密码提示长度必须大于4位，小于20位");
        fm.question.value="";
        fm.question.focus();
        return false;
    }
    //验证密码提示答案
    if (fm.answer.value.length<2||fm.answer.value.length>20) {
        alert("密码提示答案长度必须大于2位，小于20位");
        fm.answer.value="";
        fm.answer.focus();
        return false;
    }
    if (fm.question.value==fm.answer.value) {
        alert("密码提示与提示答案不得一致");
        fm.answer.value="";
        fm.answer.focus();
        return false;
    }
    //验证email
    if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)) {
        alert("email格式不正确!");
        fm.email.value="";
        fm.email.focus();
        return false;
    }
    //验证QQ
    if (fm.qq.value!="") {
        if (!/^[1-9]{1}[0-9]{4,10}$/.test(fm.qq.value)) {
            alert('QQ号码不正确!');
            fm.qq.value="";
            fm.qq.focus();
            return false;
         }
    };


    return true;
  }

}