<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/25
 * Time: 11:07
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Mpactm as MpactmModel;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\exception\MpactmException;
use think\Request;

class Mpactm
{

    /**
     * 分页查询工程合同
     * @url  /mpactm/recent
     * @http  GET
     * $size  int 每页记录数
     * $page  int 当前页码
     */
    public  function  getRecent($size=15, $page=1){
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMpactms = MpactmModel::getMostRecent($size, $page);
        if ($pageMpactms->isEmpty()){
            return [
                'current_page' => $pageMpactms->currentPage(),
                'data' => []
            ];
        }
        $data  = $pageMpactms->getCollection()
        ->toArray();
        return [
            'current_page' => $pageMpactms->currentPage(),
            'data' => $data
        ];
    }

    /**
     *
     * 获取指定工程代码信息
     * @url  /mpactm/:id
     * @http  GET
     * @param $id  工程代码
     * @return \think\response\Json
     * @throws MpactmException
     */
    public  function  getOne($id){
        $mpatm = MpactmModel::getMpactmDetail($id);
        if(!$mpatm){
            throw new MpactmException();
        }
        return json($mpatm);
    }
}