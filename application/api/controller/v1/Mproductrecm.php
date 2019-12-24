<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/24
 * Time: 15:41
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\api\model\Mproductrecm as MproductrecmModel;
use app\lib\exception\MproductrecmException;

class Mproductrecm
{
    /**
     * 查询生产记录分页信息
     * @url  /mproductrecm/recent
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

        $pageMproductrecms = MproductrecmModel::getMostRecent($size, $page, $pdateS, $pdateE, $name);
        $summary = MproductrecmModel::getSummary($pdateS, $pdateE, $name);
        if($pageMproductrecms->isEmpty()){
            return [
                'current_page' => $pageMproductrecms->currentPage(),
                'total_count' => $pageMproductrecms->total(),
                'total_quality' => 0,
                'data' => []
            ];
        }

        $data = $pageMproductrecms->getCollection()
            ->toArray();

        return [
            'current_page' => $pageMproductrecms->currentPage(),
            'total_count' => $pageMproductrecms->total(),
            'total_quality' => $summary['total_quality'],
            'data' => $data
        ];
    }

    /**
     * 根据生产记录号查询材料下料清单
     * @url    /mproductrecm/:id
     * @param $id
     * @return Array
     */
    public static function getOne($id){
        $mproductrecm = MproductrecmModel::getMproductrecmDetail($id);
        if(!$mproductrecm){
            throw  new MproductrecmException();
        }

        return json($mproductrecm);
    }
}