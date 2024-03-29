<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

// 增加一个新的table助手函数
function table($table,$config=[]){
	return \think\Db::connect($config)->setTable($table);
}

// 替换框架内置的db助手函数
function db($name, $config = []){
	return \think\Db::connect($config)->name($name);
}


/**
* @param string $url get请求地址
* @param int $httpCode 返回新动态码
* @return mixed
 **/

function curl_get($url, &$httpCode = 0){
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);
    $file_contents=curl_exec($ch);
    $httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}


function getRandChar($length){
    $str = null;
    $strPol = "ABCDEFHIJLKMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) -1;
    for ($i = 0; $i < $length; $i++){
        $str.= $strPol[rand(0, $max)];
    }

    return $str;
}


