<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/12
 * Time: 10:34
 */

namespace app\api\model;


use think\Model;
use think\Request;

class Syhqx extends Model
{
//    protected  $visible = ['Iden_id', 'YHID','YHName', 'CoID', 'Pwd', 'BMID', 'BMName', 'PriceTag', 'PlanTag', 'LabTag', 'CoIDTag','Users'];
    protected  $visible = [ 'YHID','YHName'];

    public static function getUserById($id) {
        $user = self::where('Iden_id', '=', $id)
            ->find();
        return $user;
    }

    public static function  checkUser($params){
        $user = self::where('bmid', '=', $params['bmid'])
            ->where('yhid', '=', $params['yhid'])
            ->where('pwd', '=', $params['pwd'])
            ->find();
        return $user;
    }

    public static function  checkSaleman($where){
        $user = self::where($where)
            ->find();
        return $user;
    }

}