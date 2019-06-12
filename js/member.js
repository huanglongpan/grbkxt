/*
* @Author: Marte
* @Date:   2017-10-02 18:46:39
* @Last Modified by:   Marte
* @Last Modified time: 2017-10-02 18:46:52
*/

window.onload=function(){
     var timer=null;
     var ap=document.getElementById('menu').getElementsByTagName('p');
     var ol=document.getElementById('menu').getElementsByTagName('ul');

     for( var i=0;i<=ap.length;i++){
         ap[i].index=i;
         ap[i].onclick=function(){
          var that=this;
             timer=window.setTimeout(function(){
              for ( var i=0;i<=ap.length;i++){
                ol[i].style.display='none';
                ol[that.index].style.display='block';
             }
             });

         }
     }

  }