/*
* @Author: Marte
* @Date:   2017-10-15 18:41:00
* @Last Modified by:   Marte
* @Last Modified time: 2017-10-15 19:02:31
*/
window.onload=function(){
    var message=document.getElementsByName('message');
    var dl=document.getElementById('delete');
    dl.onclick=function(){
        if (confirm('你确定要把这个好友删除？')) {
          return document.form.action="?action=delete";
        }else{
            return false;
        }
    }
    for (var i = 0; i < message.length; i++) {
        message[i].onclick=function(){
            centerWindow('message.php?id='+this.title,'message',350,450);
        }
    };
    var friend=document.getElementsByName('friend');
    for (var i = 0; i < friend.length; i++) {
        friend[i].onclick=function(){
            centerWindow('friend.php?id='+this.title,'friend',400,450);
        }
    };
    var flower=document.getElementsByName('flower');
    for (var i = 0; i < flower.length; i++) {
        flower[i].onclick=function(){
            centerWindow('flower.php?id='+this.title,'flower',400,450);
        }
    };
}

function centerWindow(url,name,height,width){
    var left=(screen.width-width)/2;
    var top=(screen.height-height)/2;
    window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}