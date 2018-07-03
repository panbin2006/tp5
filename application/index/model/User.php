<?php
	namespace app\index\model;
	use think\Model;

	class User extends Model
	{
		//1.读取器
		//birthday读取器
		protected function getBirthdayAttr($birthday){
			return date('Y-m-d', $birthday);
		}	

		//user_birthday读取器
		protected function getUserBirthdayAttr($value, $data){
			return date('Y-m-d', $data['birthday']);
		}

		//2.修改器
		//birthday修改器
		protected function setBirthdayAttr($value){
			return strtotime($value);

		}
	}
    
    //设置完整的数据表
    /*
    namesapce app\index\model;
    user think\Model;

    class User extends Model
    {
    	//设置完整的数据表（包含前缀）
    	protected $table = 'think_user';
    }
	*/


    //设置不带前缀的数据表名
    /*
    namesapce app\index\model;
    user think\Model;

    class User extends Model
    {
    	//设置完整的数据表（不包含前缀）
    	protected $name= 'member';
    }
	*/


    //设置单独的数据库连接
    /*
	namespace app\index\model;
	use think\Model;
	class User extends Model
	{
		// 设置单独的数据库连接
		protected $connection = [
		// 数据库类型
		'type' => 'mysql',
		// 服务器地址
		'hostname' => '127.0.0.1',
		// 数据库名
		'database' => 'test',
		// 数据库用户名
		'username' => 'root',
		// 数据库密码
		'password' => '',
		// 数据库连接端口
		'hostport' => '',
		// 数据库连接参数
		'params' => [],
		// 数据库编码默认采用utf8
		'charset' => 'utf8',
		// 数据库表前缀
		'prefix' => 'think_',
		// 数据库调试模式
		'debug' => true,
		];
	}
	*/
?>