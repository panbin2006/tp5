<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/25
 * Time: 15:49
 */

namespace app\api\model;


use think\Model;

class Bbtrans extends Model
{
    protected $pk = 'BTrans';

    protected  $visible = [
            "BTrans"
    ];

    public static function getMostRecent(){
        $bbtrans = self::all();
        return $bbtrans;
    }

}