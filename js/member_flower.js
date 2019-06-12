/*
* @Author: Marte
* @Date:   2017-10-03 20:44:59
* @Last Modified by:   Marte
* @Last Modified time: 2017-10-03 20:47:23
*/

window.onload=function(){
    var all=document.getElementById('all');
    var fm=document.getElementsByTagName('form')[0];
    // var fo=document.getElementsByName('form');
    var dl=document.getElementById('delete');
    all.onclick=function(){
        for (var i = 0; i <fm.elements.length; i++) {
            if (fm.elements[i].name!='chkall') {
                fm.elements[i].checked=fm.chkall.checked;
            };
        };
    };
    dl.onclick=function(){
        if (confirm('你确定要删除这些赞吗？')) {
           //return location.href='?action=delete';
          return document.form.action="?action=delete";
        }else{
            return false;
        }
    };
}