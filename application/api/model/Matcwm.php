<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2020/1/4
 * Time: 14:38
 */

namespace app\api\model;


use think\Model;

class Matcwm extends Model
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
        "matcwds"
    ];

    public function matcwds(){
        return self::hasMany('Matcwd', 'CheckID', 'CheckID');
    }
    public static function getMostRecent($pdateS, $pdateE, $size, $page)
    {
        $matcheckms = self::whereBetween('Pdate', [$pdateS, $pdateE])
            ->with(['matcwds' => function($query){
                $query->where('CWID','<>', '')
                    ->order('CWType,MatType desc');
            }])
            ->order('pdate desc')
            ->paginate($size, ['page' => $page]);
        return $matcheckms;
    }

}