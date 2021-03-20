<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/25
 * Time: 11:07
 */

namespace app\api\controller\v1;


use app\api\model\Mpactd as MpactdModel;


class Mpactd
{


    /**
     *
     * 获取指定工程代码获取强度等级列表
     * @url  api/v1/mpactd/greads/:id
     * @http  GET
     * @param $id  工程代码
     * @return \think\response\Json
     * @throws MpactmException
     */
    public  function  getGreadListByProjectid($id){
        $whereGrade = []; //查询强度查询条件
        $whereGrade['projectid'] = ['=',$id];
        $whereGrade['Grade'] = ['<>', ''];

        $gradeList= MpactdModel::getGradeList($whereGrade);
        return $gradeList;
    }

    /**按工程代码获取特殊要求列表
     * @param $id
     * @url  api/v1/mpactd/tsnames/:id
     * @return false|\PDOStatement|string|\think\Collection
     */
    public  function  getTsNameListByProjectid($id){
        $whereTsName = [];//特殊要求查询条件

        $whereTsName['projectid'] = ['=',$id];
        $whereTsName['TsName'] = ['<>', ''];
        $tsNameList = MpactdModel::getTsNameList($whereTsName)->append(['checked']);
        return $tsNameList;
    }



}