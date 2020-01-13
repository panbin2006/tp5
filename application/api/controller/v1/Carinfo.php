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
use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\enum\CarZhuangTai;
use app\lib\exception\SuccessMessage;

class Carinfo
{
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