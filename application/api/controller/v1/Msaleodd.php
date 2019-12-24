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
     * @param string $name  工程名称/客户名称
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public static function getRecent($size=15, $page=1, $pdateS, $pdateE, $name=''){

        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);

        $pageMsaleodds = MsaleoddModel::getMostRecent($size, $page, $pdateS, $pdateE, $name);
        $summary = MsaleoddModel::getSummary($pdateS, $pdateE, $name);
        if($pageMsaleodds->isEmpty()){
            return [
                'current_page' => $pageMsaleodds->currentPage(),
                'total_count' => $pageMsaleodds->total(),
                'total_quality' => 0,
                'total_qualityProd' => 0,
                'data' => []
            ];
        }

        $data = $pageMsaleodds->getCollection()
            ->toArray();

        return [
            'current_page' => $pageMsaleodds->currentPage(),
            'total_count' => $pageMsaleodds->total(),
            'total_quality' => $summary['total_quality'],
            'total_qualityProd' => $summary['total_qualityProd'],
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