/*
* @Author: Marte
* @Date:   2017-10-13 19:07:26
* @Last Modified by:   Marte
* @Last Modified time: 2017-10-13 19:32:02
*/
window.onload=function(){
    var code=document.getElementById('code');
    var ubb=document.getElementById('ubb');

    var q=document.getElementById('tt');
    var qa=q.getElementsByTagName('a');
    var closea=document.getElementById('close');
    var touxa=document.getElementById('toux');
    var oneimg=document.getElementById('one');
    var twoimg=document.getElementById('two');
    var threeimg=document.getElementById('three');

    var imgs=document.getElementById('toux').getElementsByTagName('img');

    var message=document.getElementsByName('message');
    var friend=document.getElementsByName('friend');
    var flower=document.getElementsByName('flower');
    var fm=document.getElementsByTagName('form')[0];
    fm.onsubmit=function(){
        if (fm.content.value.length<1) {
            alert("内容不得为空");
            fm.content.focus();//将光标移至表单
            return false;
        }
    };

    for (var i=0 ;i < imgs.length; i++) {
        imgs[i].onclick=function(){
            _opener(this.alt);
        touxa.style.display="none";
        oneimg.style.display="none";
        twoimg.style.display="none";
        threeimg.style.display="none";
        }
    }
    function _opener(src){
        this.document.getElementsByTagName('form')[0].content.value+='[img]'+src+'[/img]';
    }
    closea.onclick=function() {
        closea.style.display="none";
        touxa.style.display="none";
    }
    qa[0].onclick=function(){
        if(oneimg.style.display=="block")
        {
            touxa.style.display="none";
            oneimg.style.display="none";
            twoimg.style.display="none";
            threeimg.style.display="none";
        }
        else{
            closea.style.display="block";
            touxa.style.display="block";
            oneimg.style.display="block";
            twoimg.style.display="none";
            threeimg.style.display="none";
        }
    };
    qa[1].onclick=function(){
        if(twoimg.style.display=="block")
        {
            touxa.style.display="none";
            oneimg.style.display="none";
            twoimg.style.display="none";
            threeimg.style.display="none";
        }
        else{
            closea.style.display="block";
            touxa.style.display="block";
            oneimg.style.display="none";
            twoimg.style.display="block";
            threeimg.style.display="none";
        }
    };
    qa[2].onclick=function(){
        if(threeimg.style.display=="block")
        {
            touxa.style.display="none";
            oneimg.style.display="none";
            twoimg.style.display="none";
            threeimg.style.display="none";
        }
        else{
            closea.style.display="block";
            touxa.style.display="block";
            oneimg.style.display="none";
            twoimg.style.display="none";
            threeimg.style.display="block";
        }
    };
    code.onclick=function(){
        this.src='yzm/text.php?tm='+Math.random();
    };
    ubb.onclick=function(){
          alert("该功能还未实现，敬请期待！");
    };
    for (var i = 0; i < message.length; i++) {
        message[i].onclick=function(){
            centerWindow('message.php?id='+this.title,'message',350,450);
        }
    };
    for (var i = 0; i < friend.length; i++) {
        friend[i].onclick=function(){
            centerWindow('friend.php?id='+this.title,'friend',400,450);
        }
    };
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