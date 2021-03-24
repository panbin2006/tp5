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
use app\api\model\Mphbprod as MphbprodModel;
use app\api\service\Mphbprod as MphbprodService;
use app\lib\exception\MphbprodException;

class Mphbprod
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


        $pageMphbprods = MphbprodModel::getMostRecent($size, $page, $where);

        if ($pageMphbprods->isEmpty()) {
            return [
                'current_page' => $pageMphbprods->currentPage(),
                'last_page' => 0,
                'total_count' => $pageMphbprods->total(),
                'data' => []
            ];
        }

        $data = $pageMphbprods->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMphbprods->currentPage(),
            'last_page' => $pageMphbprods->lastPage(),
            'total_count' => $pageMphbprods->total(),
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

//        return explode(',','1,2');
//         $kzname = '9.10';
//        //配方查询的生产线号
//        $pf_pline = '1';
//        //仓位设置中的生产线号
//        $cw_Pline= '1,2';
//        //配方生产线在仓位生产线号数组中的索引
//        $index = 0;
//        if(!($cw_Pline==$pf_pline)){
//            $cw_Pline_arr = explode(',',$cw_Pline);
//            $index = array_search($pf_pline,$cw_Pline_arr);
//            $kzname = explode('.',$cw_Pline)[$index];
//        }
//        return 'YL'.$kzname;

        $phbprod = MphbprodService::getMphprod($pline, $phbid);
        return $phbprod;
    }



}