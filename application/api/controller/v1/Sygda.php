<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/14
 * Time: 11:44
 */

namespace app\api\controller\v1;

use app\api\model\Sygda as SygdaModel;
use app\api\service\Code;
use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\exception\CarinfoExcption;
use app\lib\exception\DriverException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\SygdaException;

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

    public static function getDriverCar(){
        $input = input('post.');
        $sjid = $input['ygid'];
        $car = '';
        $sjidwCar = \app\api\model\Carinfo::getCarBySjidw($sjid); //根据当班司机查询车号
        if($sjidwCar){
            $car = $sjidwCar;
        }else{
            $sjidOneOrTwoCar = \app\api\model\Carinfo::getCarBySjidOneOrTwo($sjid); //根据司机1id或者司机2id查询车号
            if($sjidOneOrTwoCar){
                $car = $sjidOneOrTwoCar;
            }else{
                throw new CarinfoExcption([
                    'msg' => '当前司机无对应当班车辆'
                ]);
            }
        }

        return $car;
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

    public static function edit(){
        $params = input('post.');
        $sygda = SygdaModel::where([
            'YGID' => $params['yhid'],
            'Remark1' => $params['password'],
            'CoID' => $params['coid']
            ])->find();
        if(!$sygda){
            return json(new SygdaException(['msg' => '旧密码不正确']),404);
        }

        $sygda->save([
            'TrigTag' => !$sygda['TrigTag'],
            'Remark1' => $params['newPassword']
        ]);

        return json(new SuccessMessage(), 201);
    }
}