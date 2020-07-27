<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 11:09
 */

namespace app\api\controller\v1;

Use app\api\model\Msaleodd as MsaleoddModel;
use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\exception\MsaleoddException;

class Msaleodd
{
    /**
     * 查询送货单分页数据
     * @url  /msaleodd/recent
     * @param int $size  单页记录数
     * @param int $page  页码
     * @param $pdateS   开始时间
     * @param $pdateE   截止时间
     * @param string $searchtxt 工程名称/客户名称/计划单号
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public static function getRecent($size=15, $page=1){
        //分页参数校验
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);

        //获取查询条件
        $inputs = input('post.');
        $where = [];
        $whereBetween = [];
        $pdateS = $inputs['pdateS'];
        $pdateE = $inputs['pdateE'];
        $searchtxt = $inputs['searchtxt'];

        if($pdateS&&$pdateE){//判断客户端上传时间段参数是否存在
            $whereBetween[0] = $pdateS;
            $whereBetween[1] = $pdateE;
        }else{
            $date_now = date('Y-m-d');
            $whereBetween[0] = $date_now . ' 00:00:00';
            $whereBetween[1] = $date_now . ' 23:59:59';
        }
        if($searchtxt){ //判断客户端上传的搜索字符串
            $where['ProjectName|CustName|PlanID']= ['like','%'.$searchtxt.'%'];
        }

        //分页数据
        $pageMsaleodds = MsaleoddModel::getMostRecent($size, $page,$where,$whereBetween);
//          return MsaleoddModel::getMostRecent($size, $page,$where,$whereBetween);
        //汇总数据
        $summary = MsaleoddModel::getSummary($where,$whereBetween);

        if($pageMsaleodds->isEmpty()){
            return [
                'current_page' => $pageMsaleodds->currentPage(),
                'total_count' => $pageMsaleodds->total(),
                'total_quality' => 0,
                'total_qualityProd' => 0,
                'last_page' => 0,
                'data' => []
            ];
        }

        $data = $pageMsaleodds->getCollection()
            ->toArray();
//        return false;
        return [
            'current_page' => $pageMsaleodds->currentPage(),
            'total_count' => $pageMsaleodds->total(),
            'total_quality' => $summary['total_quality'],
            'total_qualityProd' => $summary['total_qualityProd'],
            'last_page' => $pageMsaleodds->lastPage(),
            'data' => $data
        ];
    }

    /**
     * 根据送货单号查询生产发记录
     * @url    /msaleodd/:id
     * @param $id
     * @return Array
     */
    public static function getOne($id){
        $msaleodd = MsaleoddModel::getMsaleoddDetail($id);

        if(!$msaleodd){
            throw  new MsaleoddException();
        }

        return json($msaleodd);
    }
}