<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\api\model;


use think\Model;

class Bbtld extends Model
{
    protected $pk = 'TLD';

    protected  $visible = [
            "TLD",
            "Unit"
    ];

    public static function getMostRecent(){
        $bbtlds = self::all();
        return $bbtlds;
    }

}