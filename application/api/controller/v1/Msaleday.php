<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/11
 * Time: 15:31
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\api\model\Msaleday as MsaledayModel;
class Msaleday
{

    /**
     * 查询分页数据
     * @param int $size 单页记录数
     * @param int $page  页码
     * @param $pdateS   开始时间
     * @param $pdateE   截止时间
     * @param $name     工程名称/客户名称
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public  static  function getRecent($size=15, $page=1, $pdateS, $pdateE, $name){

        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMsaledays =  MsaledayModel::getMostRecent($size, $page, $pdateS, $pdateE, $name);
        $summary = MsaledayModel::getSummary($size, $page, $pdateS, $pdateE, $name);
        if($pageMsaledays->isEmpty()){
            return [
                'current_page' => $pageMsaledays->currentPage(),
                'total_count' => $pageMsaledays->total(),
                'total_quality' => $summary['total_quality'],
                'total_transNum' => $summary['total_transNum'],
                'data' => []
            ];
        }

        $data = $pageMsaledays->getCollection();
           // ->toArray();
        return [
            'current_page' => $pageMsaledays->currentPage(),
            'total_count' => $pageMsaledays->total(),
            'total_quality' => $summary['total_quality'],
            'total_transNum' => $summary['total_transNum'],
            'data' => $data
        ];
    }
}