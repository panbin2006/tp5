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


class Mpactm
{

    /**
     ** @url  /mpactm/betoninfo
     * @http  post
     * $projectID  str 工程代码
     * $betonType  str 产品类型： 强度 grade, 特殊要求  TSName, tld 坍落度， 施工方式  BTrans
     * $where array 查询条件数组
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static  function getBetoninfoByType(){
        $params = input('post.');
        $projectID = $params['projectid'];
        $betonType = $params['betonType'];
        $where = [];
        if($projectID){
            $where['projectid'] = $projectID;
        }
        if($betonType){
            $where[$betonType] = ['<>',''];
        }
        $list = MpactmModel::getListByBetonType($where);
        return $list;
    }

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
     * 根据where查询条件，分页查询工程合同
     * @url  /mpactm/recent
     * @http  GET
     * $size  int 每页记录数
     * $page  int 当前页码
     * $where array 查询条件数组
     */
    public  function  getRecentWhere($size=15, $page=1,$conditions=[]){
//        (new Count())->goCheck($size);
//        (new PageNumberMustBePositiveInt())->goCheck($page);
        $where = [];
        $c_name= $conditions['searchtxt']; //工程名称或者客户名称
        $c_classname1 = $conditions['classname1']; //业务员
        $c_custname = $conditions['custname']; //客户名称
        $c_buildname = $conditions['buildname']; //客户名称

        if($c_classname1){
            $where['ClassName1'] = $c_classname1;
        }
        if($c_custname){
            $where['CustName'] = $c_custname;
        }
        if($c_buildname){
            $where['BuildName'] = $c_buildname;
        }
        if($c_name){
            $where['ProjectName|CustName']= ['like','%'.$c_name.'%'];
        }
        $pageMpactms = MpactmModel::getMostRecentWhere($size, $page,$where);
//        return $pageMpactms;
        if ($pageMpactms->isEmpty()){
            return [
                'current_page' => $pageMpactms->currentPage(),
                'total' => 0,
                'last_page' => 0,
                'data' => []
            ];
        }
        $data  = $pageMpactms->getCollection()
            ->toArray();
        return [
            'current_page' => $pageMpactms->currentPage(),
            'total' => $pageMpactms->total(),
            'last_page' => $pageMpactms->lastPage(),
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
        $mpactm = MpactmModel::with('mpactds')->find($id);
        $mpactm->TrigTag = '2';
        $mpactm->SHTag = $flag;
        $mpactm->save();
        return  $mpactm;
    }


    /**
     * 修改工程合同执行状态
     * @param $id  string   工程代码
     * @param $state  string  执行状态
     *
     */

    public  function  setState($id, $state){
        (new MpactStatus())->goCheck($state);
        $mpactm = MpactmModel::with('mpactds')->find($id);
        $mpactm->TrigTag = '2';
        $mpactm->ExecState = $state;
        $mpactm->save();
        return  $mpactm;
    }
}