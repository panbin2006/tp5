<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2021-12-24
 * Time: 15:22
 */

namespace app\gps\controller\yiteng;

use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\gps\model\CVehicleGps as CVehicleGpsModel;

//车辆里程表
class CVehicleGps
{

    //车辆分页查询
    public static function  getRecent($size,$page)
    {
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);



        $c_vehicle_gps = CVehicleGpsModel::getMostRecent($size, $page);
        if (!$c_vehicle_gps->isEmpty()) {
            return $c_vehicle_gps;
        }

    }


}