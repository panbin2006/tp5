<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020-09-21
 * Time: 14:12
 */

namespace app\api\service;


class Token
{
    public static function generateToken(){
        //32个字符组成一组随机字符串
        $randChars = getRandChar(32);
        //用三组字符串进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt: 盐
        $salt = config('secure.token_salt');

        return md5($randChars.$timestamp.$salt);
    }
}