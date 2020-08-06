<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/14
 * Time: 10:19
 */

namespace app\api\service;


use app\api\model\Syhqx as SyhqxModel;


class User
{
     public  function  login(){

     }

     public  static function checkUser($params){
           $user = SyhqxModel:: checkUser($params);
           return $user;
     }

    public  static function checkSaleman($where){
        $user = SyhqxModel:: checkSaleman($where);
        return $user;
    }
}