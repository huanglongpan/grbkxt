/*
* @Author: Marte
* @Date:   2017-10-14 19:51:38
* @Last Modified by:   Marte
* @Last Modified time: 2017-10-14 20:39:14
*/

window.onload=function(){
    var fm=document.getElementsByTagName('form')[0];
    //验证码点击切换
    var code=document.getElementById('code');
    code.onclick=function(){
        this.src='yzm/text.php?tm='+Math.random();
    };
    fm.onsubmit=function(){
        if (fm.password.value.length<6) {
            alert("密码长度必须大于6位");
            fm.password.value="";
            fm.password.focus();
            return false;
        }
        if (fm.password.value==fm.xinpassword.value) {
            alert("新密码不得与旧密码相同！");
            fm.xinpassword.value="";
            fm.qrpassword.value="";
            fm.xinpassword.focus();
            return false;
        };
        if (fm.xinpassword.value.length<6) {
            alert("密码长度必须大于6位");
            fm.xinpassword.value="";
            fm.qrpassword.value="";
            fm.xinpassword.focus();
            return false;
        }
        if (fm.xinpassword.value!=fm.qrpassword.value) {
            alert("两次密码必须一致");
            fm.xinpassword.value="";
            fm.qrpassword.value="";
            fm.xinpassword.focus();
            return false;
        }
        return true;
    }
}