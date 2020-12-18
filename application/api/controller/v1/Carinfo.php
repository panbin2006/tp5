<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/10
 * Time: 15:30
 */

namespace app\api\controller\v1;

use app\api\model\Carinfo as CarinfoModel;
use app\api\model\CarStatistics as CarStatisticsModel;
use app\api\service\QrcodeCreate;
use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\enum\CarZhuangTai;
use app\lib\exception\CarinfoExcption;
use app\lib\exception\SuccessMessage;
use app\api\service\QrcodeCreate as QrcodeService;
class Carinfo
{
    /**
     * 根据车号生成二维码图片
     * @url  api/v1/carinfo/qrcode/:id
     * @param string $id  车号
     * @throws \Endroid\QrCode\Exception\InvalidPathException
     * @throws \Endroid\QrCode\Exception\InvalidWriterException
     * @throws \think\exception\DbException
     */
    public static function getQrcode($id = ''){
        $car = CarinfoModel::get($id);
        if($car){
            QrcodeService::createQrcode($id, '车号：');
        }
    }

    /**
     * 生成所有车号的二维码图片
     * @url  api/v1/carinfo/qrcodes
     * @return CarinfoModel[]|false
     * @throws \think\exception\DbException
     */

    public static  function getQrcodes(){
        $cars = CarinfoModel::column('CarID');
        $cars = array_keys($cars);
        if($cars){
            QrcodeCreate::Qrcodes($cars, '车号：');
        }
        return $cars;
    }


    /**
     * 司机端扫码换车
     * url:api/v1/carinfo/changecar
     * @return array
     * @throws \think\exception\DbException
     */
    public static function changeCar(){
        $params = input('post.');

        $currentCarid = $params['currentCarid'];
        $newCarid = $params['newCarid'];
        $driverID = $params['driverID'];
        $driverName = $params['driverName'];

        if(!$currentCarid&&$currentCarid<>'无车号'){
            $currentCar = CarinfoModel::get($currentCarid);
            $currentCar['SJIDW'] = '';
            $currentCar['SJXMW'] = '';
            $currentCar['TrigTag'] = $currentCar['TrigTag'] + 1;
            $currentCar->save();
        }
        if($newCarid){
            $newCar = CarinfoModel::get($newCarid);
            if(!$newCar){
                throw new CarinfoExcption();
            }
            $newCar['SJIDW'] = $driverID;
            $newCar['SJXMW'] = $driverName;
            $newCar['TrigTag'] = $newCar['TrigTag'] + 1;
            $updNewCarTag = $newCar->save();
        }

        if(!$updNewCarTag){
            return [
                'msg' => '车号更新失败',
                'error_code' => 401
            ];
        }

        return [
            'msg' => '车号更新成功',
            'error_code' => 200
        ] ;
    }
    /**
     * 根据司机代码查询车辆
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public static function getByDriverID($id){
        $car = CarinfoModel::getByDriverID($id);
        return $car;
    }

    /**
     * 查询车辆资料
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static  function getOne($id){

        $car = CarinfoModel::with([
            'currentDriver'=>function($query){
                $query->field('YGID,YGName,CarID,Tel');
            },
            'firstDriver'=>function($query){
                $query->field('YGID,YGName,CarID,Tel');
            },
            'secondDriver'=>function($query){
                $query->field('YGID,YGName,CarID,Tel');
            }
            ])->field('CarID,SJIDW,SJID1,SJID2,SJXMW,SJXM1,SJXM2,CoID,ICID,ChePai,CarType,BCTag')->find($id);

        return $car;
    }
    /**查询车辆资料分页数据
     * @param int $size
     * @param int $page
     * @param string $zhuangtai
     * @return \think\Paginator
     * @throws \app\lib\exception\ParameterException
     */
    public static function getRecent($size=5, $page=1,  $zhuangtai= CarZhuangTai::ALL){

        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);

        $carInfoPages = CarinfoModel::getMostRecent($size, $page, $zhuangtai);

        return $carInfoPages;
    }


    public static function statistics(){
        $params = input('post.');

        $page = $params['page'];
        $size = $params['size'];
        $where = $params['where'];
        $pdateS = $params['pdateS'];
        $pdateE = $params['pdateE'];

        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);


        $pages = CarStatisticsModel::getMostRecent($size,$page,$pdateS, $pdateE, $where);
        $summary = CarStatisticsModel::getSummary($pdateS, $pdateE, $where);
        if($pages->isEmpty()){

            return [
                'current_page' => $pages->currentPage(),
                'total_summary_count' => 0,
                'total_summary_quality' => 0,
                'total_summary_qualityTrans' => 0,
                'data' => []
            ];
        }

        $data = $pages->toArray();

        return [
            'current_page' => $pages->currentPage(),
            'total_summary_count' => $summary['total_summary_count'],
            'total_summary_quality' => $summary['total_summary_quality'],
            'total_summary_qualityTrans' => $summary['total_summary_qualityTrans' ],
            'data' => $data
        ];
    }

    /**
     * 分组查询车辆运输数据
     * @param $size  单页记录数
     * @param $page  页码
     * @param $pdateS  开始时间
     * @param $pdateE  截止时间
     * @param $where   查询条件
     * @param $group   分组条件
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public static function groupData(){
        $params = input('post.');

        $page = $params['page'];
        $size = $params['size'];
        $where = $params['where'];
        $pdateS = $params['pdateS'];
        $pdateE = $params['pdateE'];
        $group = $params['group'];

        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);


        $pages = CarStatisticsModel::getGroupData($size,$page,$pdateS, $pdateE, $where, $group);
        $summary = CarStatisticsModel::getSummary($pdateS, $pdateE, $where);
        if($pages->isEmpty()){

            return [
                'current_page' => $pages->currentPage(),
                'total_summary_count' => 0,
                'total_summary_quality' => 0,
                'total_summary_qualityTrans' => 0,
                'data' => []
            ];
        }

        $data = $pages->toArray();

        return [
            'current_page' => $pages->currentPage(),
            'total_summary_count' => $summary['total_summary_count'],
            'total_summary_quality' => $summary['total_summary_quality'],
            'total_summary_qualityTrans' => $summary['total_summary_qualityTrans' ],
            'data' => $data
        ];
    }

    /**
     * 新增/修改车辆资料
     * @return \think\response\Json
     * @throws \think\exception\DbException
     */
    public  static function save(){

        $inputs  = input('post.');
        $data = $inputs['data'];
        $where = $inputs['where'];

        $car = CarinfoModel::get($where);
        if(empty($car)){

            CarinfoModel::create(array_merge($data, $where));
        }else{
            //数据库表更新触发器问题，TriTag必须与原记录的值不一样，这样才不会触发更新触发器
            //不然数据更新失败
            $data['TrigTag'] = $car->TrigTag +1;
            CarinfoModel::update($data, $where);
        }


        return json(new SuccessMessage(), 201);
    }
}