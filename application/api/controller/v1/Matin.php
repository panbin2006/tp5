<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\api\model\Matin as MatinModel;

class Matin
{
    /**
     * 查询计划单分页数据
     * @param int $size     单页记录数
     * @param int $page     页码
     * @param $pdateS       开始时间
     * @param $pdateE       截止时间
     * @searchtxt    查询字段
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public static function getRecentWhere($size=15, $page=1)
    {
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
            $where['MatName|SupplierName|CWName']= ['like','%'.$searchtxt.'%'];
        }



        $pageMatins= MatinModel::getMostRecentWhere($size, $page, $where, $whereBetween);
        $summary = MatinModel::getSummaryWhere( $where, $whereBetween);


        if ($pageMatins->isEmpty()) {
            return [
                'current_page' => $pageMatins->currentPage(),
                'hasPages' =>  $pageMatins->hasPages(),
                'total' => 0,
                'summary' => [],
                'data' => []
            ];
        }

        $data = $pageMatins->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMatins->currentPage(),
            'total' => $pageMatins->total(),
            'summary' => $summary,
            'hasPages' =>  $pageMatins->hasPages(),
            'data' => $data
        ];
    }


    public static function getRecent($size=15, $page=2, $pdateS, $pdateE, $name=''){

        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMatins = MatinModel::getMostRecent($size, $page, $pdateS, $pdateE, $name);
        $summary = MatinModel::getSummary($size, $page, $pdateS, $pdateE, $name);

        if($pageMatins->isEmpty()){
            return [
                'current_page' => $pageMatins->currentPage(),
                'total_count' => $pageMatins->total(),
                'total_quality' => $summary['total_quality'],
                'data' => []
            ];
        }

        $data = $pageMatins->getCollection()
            ->toArray();

        return [
            'current_page' => $pageMatins->currentPage(),
            'total_count' => $pageMatins->total(),
            'total_quality' => $summary['total_quality'],
            'data' => $data
        ];

    }
}