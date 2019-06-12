<?php
/**
 * @Author: Marte
 * @Date:   2017-05-21 19:08:19
 * @Last Modified by:   Huang LongPan
 * @Last Modified time: 2018-11-30 22:12:52
 */

if (!defined('IN_TG')) {
     exit('Access Defined');
 }


function _connect(){
    //设置全局变量，在函数外面也可以访问
    global $_conn;
    $_conn=@mysql_connect(DB_HOST,DB_USER,DB_PWD);
    if (!$_conn) {
        exit('数据库连接失败');
    }
}

function _select_db(){
    if (!mysql_select_db(DB_NAME)) {
        exit('找不到指定的数据库');
    }
}

function _set_names(){
    if (!mysql_query('set names utf8')) {
       exit('字符集错误');
    }
}

function _query($_sql){
    if (!$_result = mysql_query($_sql)) {
        exit('SQL执行失败');
    }
    return $_result;
}

//获取一条数据组
function _fetch_array($_sql)
{
    return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}

function _num_rows($_result){
    return mysql_num_rows($_result);
}
//获取指定数据集的所有数据
function _fetch_array_list($_result)
{
    return mysql_fetch_array($_result,MYSQL_ASSOC);
}

function _is_repeat($_sql,$_info){
    if (_fetch_array($_sql)) {
        _alert_back($_info);
    }
}


function _affected_rows(){
    return mysql_affected_rows();
}

//销毁结果集
function _free_result($_result){
    mysql_free_result($_result);
}
//获取刚生成的id
function _insert_id(){
    return mysql_insert_id();
}
?>