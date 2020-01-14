<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/14
 * Time: 11:44
 */

namespace app\api\controller\v1;

use app\api\model\Sygda as SygdaModel;
use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\exception\DriverException;
use app\lib\exception\SuccessMessage;

class Sygda
{
    public static function getRecent($size=10, $page=1)
    {
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);

        $driverPages = SygdaModel::getMostRecent($size, $page);

        if($driverPages->isEmpty()){
            return [
                'current_page' => $driverPages->currentPage(),
                'total' => 0,
                'data' => []
            ];
        }

        $data = $driverPages->toArray();

        return [
            'current_page' => $driverPages->currentPage(),
            'total' => $driverPages->total(),
            'data' => $data
        ];

    }

    public static function getDriver($id)
    {
        $driver = SygdaModel::getOne($id);

        if(!$driver){
            throw new DriverException();
        }

        return $driver;


    }

    public static function login()
    {
        $where = input('post.');
        $driver = SygdaModel::check($where);

        if(!$driver){
            throw new DriverException(['msg' => '用户名或密码错误']);
        }

        return $driver;
    }

    public static function save(){
        $inputs  = input('post.');
        $data = $inputs['data'];
        $where = $inputs['where'];

        $driver = SygdaModel::get($where);
        if(empty($driver)){

            $result = SygdaModel::create(array_merge($data, $where));
        }else{
            //数据库表更新触发器问题，TriTag必须与原记录的值不一样，这样才不会触发更新触发器
            //不然数据更新失败
            $data['TrigTag'] = $driver->TrigTag +1;
            $result = SygdaModel::update($data, $where);
        }


        return json(new SuccessMessage(['msg' => $result]), 201);
    }
}