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
    protected  $visible = ['Iden_id', 'YHID', 'CoID', 'Pwd', 'BMID', 'BMName', 'PriceTag', 'PlanTag', 'LabTag', 'CoIDTag'];

    public static function getUserById($id) {
        $user = self::where('Iden_id', '=', $id)
            ->find();
        return $user;
    }

    public static function  check($params){
        $user = self::where('bmid', '=', $params['bmid'])
            ->where('yhid', '=', $params['yhid'])
            ->where('pwd', '=', $params['pwd'])
            ->find();
        return $user;
    }
}