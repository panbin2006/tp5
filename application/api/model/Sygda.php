<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/14
 * Time: 11:45
 */

namespace app\api\model;


use think\Model;

class Sygda extends Model
{
    public $hidden= [
	'MarryTag',
	'Health',
	'DateCJGZ',
	'DateJoin' ,
	'datebiye' ,
	'XueLi' ,
	'BYXuexiao' ,
	'BYZhuanYe' ,
	'DriveID' ,
	'BankBook' ,
	'guardID' ,
	'ZhiWei' ,
	'ZhiChen' ,
	'State' ,
	'NoteMan' ,
	'CreateTime' ,
	'EditMan' ,
	'EditTime' ,
	'EditTag' ,
	'SHMan' ,
	'ZZID',
	'SBID',
	'TelHome',
	'AddrHome',
	'AddrNow',
	'AddrHK',
	'LinkMan1',
	'LinkGX1',
	'LinkWork1',
	'LinkAddr1',
	'LinkTel1' ,
	'LinkMan2' ,
	'LinkGX2' ,
	'LinkWork2' ,
	'LinkAddr2' ,
	'LinkTel2',
	'LinkMan3',
	'LinkGX3',
	'LinkWork3',
	'LinkAddr3',
	'LinkTel3',
	'LinkMan4',
	'LinkGX4',
	'LinkWork4',
	'LinkAddr4',
	'LinkTel4',
	'LinkMan5',
	'LinkGX5',
	'LinkWork5',
	'LinkAddr5',
	'LinkTel5',
	'LinkMan6',
	'LinkGX6' ,
	'LinkWork6',
	'LinkAddr6',
	'LinkTel6',
	'LinkMan7',
	'LinkGX7',
	'LinkWork7',
	'LinkAddr7',
	'LinkTel7',
	'LinkMan8',
	'LinkGX8' ,
	'LinkWork8',
	'LinkAddr8' ,
	'LinkTel8' ,
	'StudyDate1',
	'StudyXX1',
	'StudyZY1',
	'StudyXL1',
	'StudyFS1',
	'StudyDate2',
	'StudyXX2',
	'StudyZY2',
	'StudyXL2',
	'StudyFS2',
	'StudyDate3',
	'StudyXX3',
	'StudyZY3',
	'StudyXL3',
	'StudyFS3',
	'StudyDate4',
	'StudyXX4' ,
	'StudyZY4' ,
	'StudyXL4' ,
	'StudyFS4',
	'StudyDate5',
	'StudyXX5',
	'StudyZY5',
	'StudyXL5',
	'StudyFS5',
	'WorkDate1' ,
	'WorkDW1' ,
	'WorkXZ1' ,
	'WorkGM1' ,
	'WorkZW1' ,
	'WorkGO1' ,
	'WorkDate2',
	'WorkDW2' ,
	'WorkXZ2' ,
	'WorkGM2' ,
	'WorkZW2' ,
	'WorkGO2' ,
	'WorkDate3',
	'WorkDW3',
	'WorkXZ3' ,
	'WorkGM3' ,
	'WorkZW3' ,
	'WorkGO3' ,
	'WorkDate4' ,
	'WorkDW4' ,
	'WorkXZ4' ,
	'WorkGM4' ,
	'WorkZW4' ,
	'WorkGO4' ,
	'QianMin' ,
	'TrigTag' ,
	'DateLiZhi',
	'RSNum'
    ];

    public $pk = 'YGID';

    public static  function getMostRecent($size, $page){

       $driverPages = self::where('ZhiWei', '=', '驾驶员')
           ->paginate($size, false, ['page' => $page]);

       return $driverPages;

    }

    public static function getOne($id){
        $driver = self::get($id);

        return $driver;
    }


    public static function check($where){
        $driver = self::where($where)
            ->find();

        return $driver;
    }
}