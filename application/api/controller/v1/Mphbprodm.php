<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/12
 * Time: 17:00
 */

namespace app\api\controller\v1;


use app\api\model\Mphbprodd;
use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\api\model\Mphbprodm as MphbprodmModel;

//生产配方（主从模式）
class Mphbprodm
{
    /**
     * 查询生产配方分页数据
     * @param int $size     单页记录数
     * @param int $page     页码
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public static function getRecent($size=15, $page=1)
    {
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);


        //获取查询条件
        $inputs = input('post.');
        $where = [];

        $searchtxt = $inputs['searchtxt'];
        if($searchtxt){ //判断客户端上传的搜索字符串
            $where['Grade|PhbID']= ['like','%'.$searchtxt.'%'];
        }

        $pline = $inputs['pline'];
        if($pline){ //判断客户端上传的生产线号
            if($pline<>'全部'){
                $where['PLine']= ['=',$pline];
            }
        }

        $phbType = $inputs['phbType'];
        if($phbType){
            if($phbType<>'全部'){
                $where['phbType'] = ['=',$phbType];
            }
        }


        $pageMphbprodms = MphbprodmModel::getMostRecent($size, $page, $where);

        if ($pageMphbprodms->isEmpty()) {
            return [
                'current_page' => $pageMphbprodms->currentPage(),
                'last_page' => 0,
                'total_count' => $pageMphbprodms->total(),
                'data' => []
            ];
        }

        $data = $pageMphbprodms->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMphbprodms->currentPage(),
            'last_page' => $pageMphbprodms->lastPage(),
            'total_count' => $pageMphbprodms->total(),
            'data' => $data
        ];
    }

    /**
     * 根据配比编号查询配方
     * @param $id       配方编号
     * @return \think\response\Json
     * @throws MpplanException
     */
    public static function getOne($pline, $phbid)
    {
            $mphbprodm = MphbprodmModel::getOne($pline, $phbid);
            return $mphbprodm;

    }



}