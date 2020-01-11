<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/10
 * Time: 15:30
 */

namespace app\api\controller\v1;

use app\api\model\Carinfo as CarinfoModel;
use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\enum\CarZhuangTai;
use app\lib\exception\CarinfoExcption;
use app\lib\exception\SuccessMessage;

class Carinfo
{
    public static function getRecent($size=5, $page=1,  $zhuangtai= CarZhuangTai::ALL){
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $carInfoPages = CarinfoModel::getMostRecent($size, $page, $zhuangtai);

        return $carInfoPages;
    }

    public function update(){
        $inputs  = input('post.');
        $data = $inputs['data'];
        $where = $inputs['where'];

        $car = CarinfoModel::get($where);
        if(empty($car)){
            throw new CarinfoExcption();
        }
        //数据库表更新触发器问题，TriTag必须与原值不一样，这样才不会触发更新触发器
        //不然数据更新失败
        $TrigTag = $car->TrigTag;
        $data['TrigTag']= $TrigTag + 1;

        $result = $car->save($data);
        echo $result;
        return json(new SuccessMessage(), 201);
    }
}