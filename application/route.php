<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;


//Route::get('api/:version/user/:id','api/:version.Syhqx/read');
Route::get('api/:version/user', 'api/:version.Syhqx/getAll');
Route::get('api/:version/user/:id', 'api/:version.Syhqx/getUserById');
Route::post('api/:version/user/login', 'api/:version.Syhqx/check');


Route::get('api/:version/driver', 'api/:version.Sygda/getRecent');
Route::get('api/:version/driver/:id', 'api/:version.Sygda/getDriver');
Route::post('api/:version/driver/login', 'api/:version.Sygda/login');
Route::post('api/:version/driver/save', 'api/:version.Sygda/save');

Route::get('api/:version/mcustomer/recent', 'api/:version.Mcustomer/getRecent');
Route::get('api/:version/mcustomer/:id', 'api/:version.Mcustomer/getOne');
Route::post('api/:version/mcustomer/sh', 'api/:version.Mcustomer/setSH');
Route::post('api/:version/mcustomer/state', 'api/:version.Mcustomer/setState');
Route::post('api/:version/mcustomer/login', 'api/:version.Mcustomer/login');


Route::get('api/:version/mpactm/recent', 'api/:version.Mpactm/getRecent');
Route::get('api/:version/mpactm/by_name', 'api/:version.Mpactm/getMpactmsByName');
Route::get('api/:version/mpactm/by_state', 'api/:version.Mpactm/getMpactmsByState');
Route::get('api/:version/mpactm/:id', 'api/:version.Mpactm/getOne',[], ['id' => '\d+']);
Route::post('api/:version/mpactm/sh', 'api/:version.Mpactm/setSH');
Route::post('api/:version/mpactm/state', 'api/:version.Mpactm/setState');


Route::get('api/:version/mbetoninfo/recent', 'api/:version.Mbetoninfo/getRecent');



Route::get('api/:version/msaleday/recent', 'api/:version.Msaleday/getRecent');


Route::get('api/:version/mpplan/recent', 'api/:version.Mpplan/getRecent');
Route::get('api/:version/mpplan/:id', 'api/:version.Mpplan/getOne');
Route::post('api/:version/mpplan/sh', 'api/:version.Mpplan/setSH');
Route::post('api/:version/mpplan/state', 'api/:version.Mpplan/setState');


Route::get('api/:version/msaleodd/recent', 'api/:version.Msaleodd/getRecent');
Route::get('api/:version/msaleodd/:id', 'api/:version.Msaleodd/getOne');


Route::get('api/:version/mproductrecm/recent', 'api/:version.Mproductrecm/getRecent');
Route::get('api/:version/mproductrecm/:id', 'api/:version.Mproductrecm/getOne');

Route::get('api/:version/carledviewzb/ledview', 'api/:version.Carledviewzb/ledview');

Route::get('api/:version/carpaiduim/ledview', 'api/:version.Carpaiduim/ledview');

Route::get('api/:version/matinfo/recent', 'api/:version.Matinfo/getRecent');

Route::get('api/:version/matsupplier/recent', 'api/:version.Matsupplier/getRecent');


Route::get('api/:version/matin/recent', 'api/:version.Matin/getRecent');


Route::get('api/:version/mproductrecd/recent', 'api/:version.Mproductrecd/getSummary');

Route::get('api/:version/matcwm/recent', 'api/:version.Matcwm/getRecent');

Route::post('api/:version/cw_stat/recent', 'api/:version.Tmpcwiostat/getRecent');


Route::get('api/:version/carinfo/recent', 'api/:version.Carinfo/getRecent');
Route::post('api/:version/carinfo/save', 'api/:version.Carinfo/save');
Route::post('api/:version/carinfo/statistics', 'api/:version.Carinfo/statistics');
Route::post('api/:version/carinfo/group', 'api/:version.Carinfo/groupData');
