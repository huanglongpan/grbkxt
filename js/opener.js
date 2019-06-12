/*
* @Author: Marte
* @Date:   2017-05-18 19:31:23
* @Last Modified by:   Marte
* @Last Modified time: 2017-09-24 20:42:21
*/
window.onload=function(){
    var img=document.getElementsByTagName('img');
    for (var i=0 ;i< img.length; i++) {
        img[i].onclick=function(){
            _opener(this.alt);
        };
    }
};
function _opener(src){
    var faceimg=opener.document.getElementById('faceimg');
    faceimg.src=src;
    opener.document.register.face.value=src;
}
function _close(){
    window.close();
}