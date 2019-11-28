<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/25
 * Time: 11:07
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Mpactm as MpactmModel;
use app\lib\exception\MpactmException;
use think\Request;

class Mpactm
{
    public  function  getRecent($count=15){
        (new Count())->goCheck($count);
        $request = Request::instance();

        $mpactms = MpactmModel::getMostRecent($count);
        if($mpactms->isEmpty()){
            throw new  MpactmException();
        }

        return json($mpactms);
    }

    public  function  getOne($id){
        $mpatm = MpactmModel::getMpactmDetail($id);
        if(!$mpatm){
            throw new MpactmException();
        }
        return json($mpatm);
    }
}