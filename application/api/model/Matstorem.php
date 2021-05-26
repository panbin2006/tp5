<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/4
 * Time: 14:38
 */

namespace app\api\model;


use think\Model;

class Matstorem extends Model
{
    protected $pk = 'CheckID';

    protected $visible = [
        "CheckID",
        "CoID",
        "PDate",
        "JSRID",
        "JSRXM",
        "NoteMan",
        "CreateTime",
        "EditMan",
        "EditTime",
        "matstoreds",
    ];

    public function matstoreds(){
        return self::hasMany('Matstored', 'CheckID', 'CheckID');
    }

    public static function getMostRecent($pdateS, $pdateE, $size, $page)
    {
        $matstoreckms = self::whereBetween('Pdate', [$pdateS, $pdateE])
            ->with(['matstoreds' => function($query){
                $query->where('CWType','<>', '')
                    ->order('CWType,MatType desc');
            }])
            ->order('pdate desc')
            ->paginate($size, ['page' => $page]);
        return $matstoreckms;
    }

    public static function getLastPdate(){
        $Pdate = self::field(['Max(Pdate)' => 'Pdate'])
            ->find();
        return $Pdate;
    }
}