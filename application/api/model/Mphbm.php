<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2021-02-02
 * Time: 11:48
 */

namespace app\api\model;


use think\Model;

class Mphbm extends Model
{
    public function mphbds(){
        return $this->hasMany('Mphbd', 'PhbID', 'PhbID');
    }


    public static  function  getMostRecent($size, $page, $where){
        $mphbms =  self::where($where)
            ->with(['Mphbds'=>function ($quality){
                $quality->field(['PhbID','CoID','ItemID','MatID','MatName','MatType','VPF','Style','VPFBase','VPFBase'])
                    ->order('ItemID asc');
            }])
            ->field(['PhbID','Grade','CoID','tld','BTrans','Weight','NoteMan','CreateTime','EditMan','EditTime','EditTag',
                    'SNStyle','WJJStyle','JBSJ','PDate','SJB','PhbType','BZRZ','PhbGroup'])
            ->order('Grade asc')
//            ->fetchSql(true)
            ->paginate($size, false, ['page' => $page]);
        return $mphbms;
    }
}