/*
* @Author: Marte
* @Date:   2017-10-07 21:08:27
* @Last Modified by:   Marte
* @Last Modified time: 2017-10-13 19:31:14
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
    var fm=document.getElementsByTagName('form')[0];
    fm.onsubmit=function(){
        if (fm.title.value.length<2||fm.title.value.length>40) {
            alert("标题长度必须大于2位小于20位");
            fm.title.focus();//将光标移至表单
            return false;
        }
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

}