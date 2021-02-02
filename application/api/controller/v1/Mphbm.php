<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/12
 * Time: 17:00
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\PageNumberMustBePositiveInt;
use app\api\model\Mphbm as MphbmModel;

class Mphbm
{
    /**
     * 查询标准配方分页数据
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



        $mphbms = MphbmModel::getMostRecent($size, $page, $where);

        if ($mphbms->isEmpty()) {
            return [
                'current_page' => $mphbms->currentPage(),
                'last_page' => 0,
                'total_count' => $mphbms->total(),
                'data' => []
            ];
        }

        $data = $mphbms->getCollection()
            ->toArray();
        return [
            'current_page' => $mphbms->currentPage(),
            'last_page' => $mphbms->lastPage(),
            'total_count' => $mphbms->total(),
            'data' => $data
        ];
    }

    /**
     * 根据配比编号查询配方
     * @param $id       配方编号
     * @return \think\response\Json
     * @throws MpplanException
     */
    public static function getOne($id)
    {

    }



}