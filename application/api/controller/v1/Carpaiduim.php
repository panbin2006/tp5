<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 17:09
 */

namespace app\api\controller\v1;

use app\api\model\Carpaiduim as CarpaiduimModel;
class Carpaiduim
{
    public static function ledview(){
//        return 'carpaiduim';
        $ledview = CarpaiduimModel::getPaidui();
        return $ledview;
    }
}