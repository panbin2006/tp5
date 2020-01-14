<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/14
 * Time: 11:45
 */

namespace app\api\model;


use think\Model;

class Sygda extends Model
{
    public $visible = [
            "YGID",
            "CoID",
            "YGName",
            "BMID",
            "BMName",
            "ZhiWei",
            "Remark1",
    ];

    public $pk = 'YGID';

    public static  function getMostRecent($size, $page){

       $driverPages = self::where('ZhiWei', '=', '驾驶员')
           ->paginate($size, false, ['page' => $page]);

       return $driverPages;

    }

    public static function getOne($id){
        $driver = self::get($id);

        return $driver;
    }


    public static function check($where){
        $driver = self::where($where)
            ->find();

        return $driver;
    }
}