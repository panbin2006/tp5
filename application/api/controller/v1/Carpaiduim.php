<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 17:09
 */

namespace app\api\controller\v1;

use app\api\model\Carpaiduim as CarpaiduimModel;
use app\api\service\Code;
use app\lib\exception\SuccessMessage;
use think\Db;
use think\Exception;

class Carpaiduim
{
    public static function ledview(){
//        return 'carpaiduim';
        $ledview = CarpaiduimModel::getPaidui();
        return $ledview;
    }

    //手机端司机打卡进厂，更新排队信息
    public static function update(){
        try{
           Db::execute("exec sp_InputCarPaiDui  ''");
        }catch (\Exception $e){
            return json(new SuccessMessage(['msg'=> 'error','errorCode'=>'1']), 202);
        }
        return json(new SuccessMessage(), 201);
    }
}