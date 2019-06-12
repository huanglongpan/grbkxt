/*
* @Author: Marte
* @Date:   2017-09-24 18:41:06
* @Last Modified by:   Marte
* @Last Modified time: 2017-10-14 21:13:38
*/
window.onload=function(){
    var all=document.getElementById('all');
    var fm=document.getElementsByTagName('form')[0];
    // var fo=document.getElementsByName('form');
    var weidu=document.getElementById('weidu');
    var dl=document.getElementById('delete');
    var yd=document.getElementById('yidu');
    all.onclick=function(){
        for (var i = 0; i <fm.elements.length; i++) {
            if (fm.elements[i].name!='chkall') {
                fm.elements[i].checked=fm.chkall.checked;
            };
        };
    };
    weidu.onclick=function(){
       if (confirm('你确定要把这些短信标为未读？')) {
          return document.form.action="?action=weidu";
        }else{
            return false;
        }

    };
    dl.onclick=function(){
        if (confirm('你确定要删除这些短信？')) {
           //return location.href='?action=delete';
          return document.form.action="?action=delete";
        }else{
            return false;
        }
    };
    yd.onclick=function(){
        if (confirm('你确定要把这些短信标为已读？')) {
           //return location.href='?action=delete';
          return document.form.action="?action=yidu";
        }else{
            return false;
        }
    }
}