<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use \traits\controller\Jump; //页面跳转

class Index extends Controller
{
    public function index()
    {

        return  'success';
    }
}
