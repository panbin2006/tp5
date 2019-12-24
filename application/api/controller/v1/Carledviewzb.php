<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 16:34
 */

namespace app\api\controller\v1;

use app\api\model\Carledviewzb as CarledviewzbModel;
class Carledviewzb
{
    public static function ledview(){
        $ledview = CarledviewzbModel::all();
        $list= array();
        foreach($ledview as $key => $value){
            $lbname =  $ledview[$key]['LbName'];
            $lbcaption = $ledview[$key]['LbCaption'];
            $list[$lbname] = $lbcaption;
        }
        return $list;
    }
}