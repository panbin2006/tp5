<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/9
 * Time: 16:43
 */

namespace app\api\model;


use PDO;
use think\Model;

class Mcustomer extends Model
{

    public static function  getMostRecent($size, $page, $name, $state)
    {

        $mcustomers = self::where('Custname', 'like', '%'.$name.'%')
            ->where('ExecState', 'like', '%'.$state.'%')
            ->order('CreateTime desc')
            ->paginate($size, true, ['page' => $page]);
        return $mcustomers;
    }

    public  static function  upSHTag($id, $flag){
        $result = self::where('CustID', '=', $id)
            ->update(['SHTag' => $flag]);
        return $result;
    }


    public  static function  upState($id, $state){
        $result = self::where('CustID', '=', $id)
            ->update(['ExecState' => $state]);
        return $result;
    }

}