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
use app\api\validate\MpactStatus;
use app\api\validate\PageNumberMustBePositiveInt;
use app\lib\enum\MpactStatusEnum as MpactStatusEnum;
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
//        (new Count())->goCheck($size);
//        (new PageNumberMustBePositiveInt())->goCheck($page);
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

    /**
     * 根据客户名称或者工程名称模糊查询
     * @url /mpact/by_name
     * @http  GET
     *  $size  int 每页显示的记录数
     * $page  int 页码
     * $name  string 过滤字段
     *
     **/
    public function  getMpactmsByName($size=15, $page=1,$name=''){
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMpacts = MpactmModel::getMpactsByName($size, $page, $name);
        return $pageMpacts;
        if($pageMpacts->isEmpty()){
            return [
                'current_page' => $pageMpacts->currentPage(),
                'data' => []
            ];
        }

        $data = $pageMpacts->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMpacts->currentPage(),
            'data' => $data
        ];
    }

    /**
     * 根据工程执行状态查询
     * @url /mpact/by_name
     * @http  GET
     *  $size  int 每页显示的记录数
     * $page  int 页码
     * $state string 过滤字段
     *
     **/
    public function  getMpactmsByState($size=15, $page=1,$state=''){
        (new Count())->goCheck($size);
        (new PageNumberMustBePositiveInt())->goCheck($page);
        $pageMpacts = MpactmModel::getMpactsByExecState($size, $page, $state);

        if($pageMpacts->isEmpty()){
            return [
                'current_page' => $pageMpacts->currentPage(),
                'data' => []
            ];
        }

        $data = $pageMpacts->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMpacts->currentPage(),
            'data' => $data
        ];
    }

    /**
     * 修改工程合同审核标志
     * @param $id  string   工程代码
     * @param $flag bool    审核标志
     *
     */
    public  function  setSH($id, $flag){
        $result = MpactmModel::upShTag($id, $flag);
        return  $result;
    }


    /**
     * 修改工程合同执行状态
     * @param $id  string   工程代码
     * @param $state  string  执行状态
     *
     */

    public  function  setState($id, $state){
        (new MpactStatus())->goCheck($state);
        $result = MpactmModel::upState($id, $state);
        return $result;
    }
}