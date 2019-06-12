/*
* @Author: Marte
* @Date:   2017-09-24 14:22:44
* @Last Modified by:   Marte
* @Last Modified time: 2017-09-28 19:51:46
*/

window.onload=function(){
    var ret=document.getElementById('return');
    var del=document.getElementById('delete');
    var weidu=document.getElementById('weidu');
    weidu.onclick=function(){
        location.href='?action=weidu&id='+this.name;
    };
    ret.onclick=function(){
        history.back();
    };
    del.onclick=function(){
        if(confirm('你确定要删除此短信？')){
            location.href='?action=delete&id='+this.name;
        }
    };
    function centerWindow(url,name,height,width){
                var left=(screen.width-width)/2;
                var top=(screen.height-height)/2;
                window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
        };
    var huixin=document.getElementById('huixin');
    huixin.onclick=function(){
        centerWindow('huixin.php?formuser='+this.title,'huixin',350,450);
    };

}
