<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/11/25
 * Time: 11:13
 */

namespace app\api\model;


use think\Model;

class Mpactm extends Model
{
    protected $visible = ['ProjectID', 'CoID', 'ProjectShort', 'CustID', 'CustName',
        'BuildName', 'BuildName', 'HTBH', 'Address', 'ClassID1', 'ClassName1', 'ClassID2',
        'ClassName2', 'ClassName3', 'ClassName4', 'ClassName5', 'ExecState', 'Space',
        'PriceMode', 'StyleMode', 'QualityMode', 'NoteMan'];

    protected $pk = 'ProjectID';

    public  function mpactds(){
        return  $this->hasMany('Mpactd', 'ProjectID', 'ProjectID');
    }

    public static function getMostRecent($count){
        $mpactms = self::limit($count)
            ->order('CreateTime desc')
            ->select();
        return $mpactms;
    }

    public static function getMpactmDetail($id){
//        $mpactm = self::where('projectid', '=', $id)
//            ->with('mpactds')
//            ->select();

        $mpactm = self::with('mpactds')
            ->find($id);
        return $mpactm;
    }
}