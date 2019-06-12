<!-- 核心函数库  -->

<!--
	js的弹窗效果；
	登录状态禁止注册；
    _html函数
	分页函数
	验证码验证
	删除cookie
	字符转义
-->
<?php


//js的弹窗效果
 function _alert_back($_info){
	echo "<script>alert('".$_info."'); history.go(-1);</script>";
	exit();
}

function _alert_close($_info){
    echo "<script>alert('".$_info."');
          window.close();</script>";
    exit();
}

function _location($_info,$_url){
	if (!empty($_info)) {
		echo "<script>alert('".$_info."'); location.href='$_url';</script>";
		exit();
	}else{
		header('Location:'.$_url);
	}

}

//登录状态下禁止注册
function _login_state(){
	if (isset($_COOKIE["username"])) {
		_alert_back('登录状态无法进行注册！');
	}
}

//比照cookie
function _uniqid($_mysql_uniqid,$_cookie_uniqid){
    if ($_mysql_uniqid != $_cookie_uniqid) {
        _alert_back('唯一标识符异常!');
    }
}

//短信内容截取，从的1位开始截取14位
function _title($_string,$_num){
    if (mb_strlen($_string,'utf-8')>$_num) {
        $_string=mb_substr($_string, 0, $_num, 'utf-8').'......';
    }
    return $_string;
}



//对字符进行HTML过滤显示
function _html($_string){
    if (is_array($_string)) {
        foreach ($_string as $_key => $_value) {
            $_string[$_key]=_html($_value);
        }
    }else{
        $_string=htmlspecialchars($_string);
    }
    return $_string;
}

//分页函数,返回参数
function _page($_sql,$_size){
	global $_pagesize,$_pagenum,$_num,$_pageabsolute,$_page;
 	if (isset($_GET['page'])) {
    	$_page=$_GET['page'];
    	if (empty($_page) || $_page < 1|| !is_numeric($_page)) {
        	$_page = 1;
    	}else{$_page = intval($_page);}
 	}else {$_page = 1;}
 	$_pagesize = $_size;
	//从数据库获取数据条数
 	$_num = _num_rows(_query($_sql));

 	//如果数据库里没有数据，就只出现第一页
 	if ($_num==0) {
     	$_pageabsolute=1;
 	}else{$_pageabsolute=ceil($_num/$_pagesize);}
	//如果大于所以页，返回最后一页
 	if ($_page >= $_pageabsolute) {
     	$_page = $_pageabsolute;
 	}
 	$_pagenum = ($_page - 1) * $_pagesize;  //每页开始的第一条数据编号
}

//分页函数,返回分页
function _paging($_type){
	global $_num,$_pageabsolute,$_page,$_id;
	if ($_type==1) {
		echo '<div id="page_num">';
        echo '<ul>';
         for ($i = 1; $i <= $_pageabsolute; $i++) {
            if ($_page==$i) {
                echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.$i.'" class="selected">'.$i.'</a></li>';
            }else{
                echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.$i.'">'.$i.'</a></li>';
            }
        }
        echo '</ul>';
    echo '</div>';
	}elseif ($_type==2) {
		echo '<div id="page_text">';
        echo '<ul>';
            echo '<li>'.$_page.'/'.$_pageabsolute.'页</li>';
            echo '<li>|</li>';
            echo '<li>共有'.$_num.'个数据</li>';
            echo '<li>|</li>';

                if ($_page==1) {
                    echo '<li>首页</li>';
                    echo '<li>|</li>';
                    echo '<li>上一页</li>';
                }else{
                    echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page=1">首页</a></li>';
                    echo '<li>|</li>';
                    echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">上一页</a></li>';
                }

                if ($_page==$_pageabsolute) {
                    echo '<li>|</li>';
                    echo '<li>下一页</li>';
                    echo '<li>|</li>';
                    echo '<li>尾页</li>';
                }else{
                    echo '<li>|</li>';
                    echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'">下一页</a></li>';
                    echo '<li>|</li>';
                    echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'">尾页</a></li>';
                }
        echo '</ul>';
    echo '</div>';
	}
}

function _session_destroy(){
	session_destroy();
}

//删除cookie
function _unsetcookies($_string)
{
	setcookie('username','');
	setcookie('uniqid','');
	_session_destroy();
	_location(null,$_string);
}


//转义，如果mysql_real_escape_string开启了就不用转义;
function _mysql_string($_string)
{
	if (!GPC) {
        if (is_array($_string)) {
            foreach($_string as $_key=>$_value){
                $_string[$_key]=_mysql_string($_value);
            }
        }else{
        $_string=mysql_real_escape_string($_string);
	   }
	}
    return $_string;
}

//验证码
function _check_code($_first_code,$_end_code)
{
	$code=$_POST["code"];
	if ($_first_code!=$_end_code) {
		_alert_back('验证码不正确！');
	}
}

//获取xml
function _get_xml($_xmlfile){
    $_xmlfile='new.xml';
    $_html=array();
    if (file_exists($_xmlfile)) {
        $_xml=file_get_contents($_xmlfile);
        preg_match_all('/<vip>(.*)<\/vip>/s', $_xml, $_dom);
        foreach ($_dom[1] as $_value) {
        preg_match_all('/<username>(.*)<\/username>/s',$_value,$_username);
        $_html['username']=$_username[1][0];
       }
    }else{
        echo "文件不存在";
    }
    return $_html;
}
//生成XML
function _set_xml($_xmlfile,$_clean){
    $_fp=@fopen('new.xml', 'w+');
    if (!$_fp) {
        echo "系统出错！！";
    }
    flock($_fp, LOCK_EX);

    $_string="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\r\n";
    fwrite($_fp, $_string, strlen($_string));
    $_string="<vip>\r\n";
    fwrite($_fp, $_string, strlen($_string));
    $_string="\t<id>{$_clean['id']}</id>\r\n";
    fwrite($_fp, $_string, strlen($_string));
    $_string="\t<username>{$_clean['username']}\t</username>\r\n";
    fwrite($_fp, $_string, strlen($_string));
    $_string="\t<sex>{$_clean['sex']}\t</sex>\r\n";
    fwrite($_fp, $_string, strlen($_string));
    $_string="</vip>\r\n";
    fwrite($_fp, $_string, strlen($_string));

    flock($_fp,LOCK_UN);
    fclose($_fp);
}
//ubb正则
function _ubb($_string){
    $_string=preg_replace('/\[img\](.*)\[\/img\]/U', '<img src="\1" alt="图片">', $_string);
    $_string = preg_replace("/([ \t]|^)www\./i", "\\1http://www.", $_string);
    $_string = preg_replace("/([ \t]|^)ftp\./i", "\\1ftp://ftp.", $_string);
    $_string = preg_replace("/(http:\/\/[^ )\r\n!]+)/i",
            "<a href=\"\\1\" target=\"\_blank\">\\1</a>", $_string);
    $_string = preg_replace("/(https:\/\/[^ )\r\n!]+)/i",
            "<a href=\"\\1\" target=\"\_blank\">\\1</a>", $_string);
    $_string = preg_replace("/(ftp:\/\/[^ )\r\n!]+)/i",
            "<a href=\"\\1\" target=\"\_blank\">\\1</a>", $_string);
    $_string = preg_replace(
            "/([-a-z0-9_]+(\.[_a-z0-9-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)+))/i",
            "<a href=\"mailto:\\1\" target=\"\_blank\">\\1</a>", $_string);
    $_string=nl2br($_string);
    return $_string;
}
?>