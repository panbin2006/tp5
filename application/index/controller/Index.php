<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use \traits\controller\Jump; //页面跳转

class Index extends Controller
{
    public function index($name='world')
    {
    	$data = Db::name('data')->find();
    	$this->assign('result',$data);
    	return  $this->fetch();
    }

    public function hello(Request $request,$name='thinkphp')
    {
        echo '路由信息：';
        dump($request->routeInfo());
        echo '调度信息：';
        dump($request->dispatch());

        return 'Hello,' . $name .'!';
    	// $this->assign('name',$name);
    	// return $this->fetch();
    }


//request对象操作
    /*
    public function hellorequest($name='thinkphp'){ //传统方式调用request
        $request = Request::instance();
        //获取当前URL地址 不含域名
        echo 'url:' . $request->url() . '<br/>';
        return 'hello,' . $name.'!';

    }
    public function hellorequest1($name='thinkphp'){ //继承think\Controller
        //获取当前URL地址 不含域名
        echo 'url:' . $this->request->url() . '<br/>';
        return 'hello,' . $name.'!';

    }

   public function hellorequest2(Request $request,$name='world'){ //自动注入请求对象
        //获取当前URL地址 不含域名
        echo 'url:' . $request->url() . '<br/>';
        return 'hello,' . $name.'!';

    } 

    public function hellorequest3(Request $request,$name='world'){ //使用助手函数
        //获取当前URL地址 不含域名
        echo 'url:' . request()->url() . '<br/>';
        return 'hello,' . $name.'!';

    } 

    public function hellorequest4(Request $request){  //获取请求变量

        echo '请求参数：';
        dump($request->param());
        echo 'name:' .$request ->param('name');
    }

     public function hellorequest5(Request $request){  //个input助手函数来简化 Request 对象的param方法

        echo '请求参数：';
        dump(input());
        echo 'name:' .input('name');
    }

    public function hellorequest6(Request $request){
        echo 'name:'. $request -> param('name','world','strtolower');
        echo '<br/>test:' . $request->param('test','thinkphp','strtolower');

    }
    

    public function hellorequest7(Request $request){ //Request 对象也可以用于获取其它的输入参数
        echo 'GET参数';
        dump($request->get());
        echo 'GET参数:name';
        dump($request->get('name'));
        echo 'POST参数：name';
        dump($request->post('name'));
        echo 'cookie参数：name';
        dump($request->cookie('name'));
        echo '上传文件信息：image';
        dump($request->file('image'));
    }

     public function hellorequest8(Request $request){ //用助手函数获取其它的输入参数
        echo 'GET参数';
        dump(input('get.'));
        echo 'GET参数:name';
        dump(input('get.name'));
        echo 'POST参数：name';
        dump(input('post.name'));
        echo 'cookie参数：name';
        dump(input('cookie.name'));
        echo '上传文件信息：image';
        dump(input('file.image'));
    }

    public function hellorequest9(Request $request){ //用助手函数获取其它的输入参数
        echo '请求方法：' . $request->method() . '<br/>';
        echo '资源类型：' . $request->type() . '<br/>';
        echo '访问IP' . $request->ip() . '<br/>';
        echo '是否AJax请求：' . var_export($request->isAjax(),true). '<br/>';
        echo '请求参数：';
        dump($request->param());
        echo '请求参数：仅包含name' . $request->method() . '<br/>';
        dump($request->only(['name']));
        echo '请求参数：排队name' . $request->method() . '<br/>';
        dump($request->except(['name']));
    }
        
    public function hellorequest10(Request $request,$name='world'){ //获取URL信息
        //获取当前域名
        echo 'domain：' . $request-> domain(). '<br/>';
        //获取当前入口文件
        echo 'file:' . $request-> baseFile(). '<br/>';
        //获取当前URL地址 不含域名
        echo 'url:' . $request-> url(). '<br/>';
        //获取包含域名的完整URL地址
        echo 'url with domain:' . $request-> url(true). '<br/>';
        //获取当前URL地址 不含QUERY_STRING
        echo 'url without query:' . $request-> domain(). '<br/>';
        //获取URL访问的ROOT地址
        echo 'root:' . $request-> root(). '<br/>';
        //获取URL访问的ROOT地址
        echo 'root with domain:'.$request->root(true);
        //获取URL地址中的PATH_INFO信息 不包含后缀
        echo 'pathinfo:' . $request ->path().'<br/>';
        //获取URL地址中的后缀信息
        echo 'ext:' . $request ->ext().'<br/>';
        return 'Hello,' . $name .'!';
    }

    public function hellorequest11(Request $request,$name='thinkphp'){//获取当前模块、控制器、操作信息
        echo '模块：'.$request->module();
        echo '<br/>控制器：' . $request -> controller();
        echo '<br/>操作：' . $request -> action();
    }

    public function hellorequest12(Request $request ,$name='tinkphp'){ //获取路由和调度信息
        echo '路由信息：';
        dump($request->routeInfo());
        echo '调度信息：';
        dump($request->dispatch());

        return 'Hello,' . $name .'!';
    }
*/

//response对象
    /*
    public function response1(){
        $data = ['name'=>'thinkphp','status'=>'1'];
        return $data;
    }



    public function response2(){ //手动指定输出的类型和参数
        $data = ['name'=>'thinkphp','status'=>'1'];
        return json($data);
    }

    public function response3(){ //返回http状态码201
        $data = ['name'=>'thinkphp','status'=>'1'];
        return json($data,201);
    }

    public function response4(){ //发送更多的响应头信息
        $data = ['name'=>'thinkphp','status'=>'1'];
        return json($data,201,['Cache-control' =>'no-cache,must-revalidate']);

    }

    public function response5($name=''){ //页面跳转1

        if ('thinkphp' == $name){
            $this ->success('欢迎使用TinkPHP
                5.0','hello_response');
        }else{
            $this->error('错误的name','guest');
        }
    }

    public function response6($name='thinkphp'){ //页面跳转redirect

        if ('thinkphp' == $name){
            $this->redirect('http://thinkphp.cn',301);
        }else{
            $this->error('错误的name','guest');
        }
    }

    public function hello_response(){
        return 'Hello,ThinkPHP!';
    }
   public function guest(){
     return 'Hello,Guest!';
    }

    */




    //DB对象

    public function  db_create(){ //create操作
        //插入数据
        $result = Db::execute('insert into think_data(id, name, status) values (5, "thinkphp", 1)');
        dump($result);
    }


     public function  db_update(){ //更新（update）
        //更新数据
        $result = Db::execute('update think_data set name = "php" where id=5');
        dump($result);
    }

    public function  db_read(){ //查询（read）
        //查询数据
        $result = Db::query('select * from think_data where id=5');
        dump($result);
    }


    public function  db_del(){ //删除（delete）
        //删除数据
        $result = Db::execute('delete from think_data where id=5');
        dump($result);
    }


    public function  db_change_db(){ //切换数据库
        $result  = Db::connect([
            'type' => 'mysql',
            'hostname' => '127.0.0.1',
            'database' => 'test',
            'username' => 'root',
            'password' => '',
            'hostport' => '',
            'params' => [],
            'charset' => 'utf8',
            'prefix' => 'think_',
        ])->query('select * from think_data');
        dump($result);
    }

    public function db_query1(){ //直接在connect方法中传入config.php中的db1,db2

        //1.直接调用
        // $result1= Db::connect('db1')->query('select * from think_data where id=1');
        // $result2 = Db::connect('db2')->query('select * from think_data where id=1');

        //2.定义db1,db2变量
        $db1 = Db::connect('db1');
        $db2 = Db::connect('db2');
        $result1 = $db1->query('select * from think_data where id=1');
        $result2 = $db2->query('select * from think_data where id=1');


        dump($result1);
        dump($result2);
    }

    public function db2(){ //参数绑定
        Db::execute('insert into think_data(id,name,status) value(?,?,?)',[8,'thinkphp',1]);
        $result=Db::query('select * from think_data where id=?' ,[8]);
        dump($result);
    }

    public function db3(){ //命名占位符绑定
        Db::execute('insert into think_data(id,name,status) value(:id,:name,:status)',['id'=>9, 'name'=>'thinkphp', 'status'=>1]);
        $result=Db::query('select * from think_data where id=:id' ,['id'=>9]);
        dump($result);
    }

    public function db4(){ //查询构造器，基于PDO
        //插入记录
        Db::table('think_data')
            ->insert(['id' => 18, 'name' => 'thinkphp', 'status' => 1]);
        //更新记录
        Db::table('think_data')
            ->where('id', 18)
            ->update(['name' => "hello"]);
        //查询记录
        $list = Db::table('think_data')
            ->where('id', 18)
            ->select();
        //删除记录
        Db::table('think_data')
            ->where('id', 18)
            ->delete();
        dump($list);
    }

    public function db5(){ //查询构造器，配置文件有加前缀，name方法简化表名
        //插入记录
        Db::name('data')
            ->insert(['id' => 18, 'name' => 'thinkphp', 'status' => 1]);
        //更新记录
        Db::name('data')
            ->where('id', 18)
            ->update(['name' => "hello"]);
        //查询记录
        $list =Db::name('data') 
            ->where('id', 18)
            ->select();
        //删除记录')
        Db::name('data')
            ->where('id', 18)
            ->delete();
        dump($list);
    }

    public function db6(){ //使用助手函数db进一步简化
        $db = db('data');
        //插入记录
        $db->insert(['id' => 20, 'name' => 'thinkphp', 'status' => 1]);
        //更新记录
        $db->where('id', 20) -> update(['name' => "hello"]);
        //查询记录
        $list=$db->where('id', 20)->select();
        dump($list);
        //删除记录
        $db->where('id', 20)->delete();
    }

    public function db7(){ //链式操作 链式操作不分先后，只要在查询方法（这里是 select 方法）之前调用就行
        $list = Db::name('data')
            ->where('status', 1)
            ->field('id, name')
            ->order('id' ,'desc')
            ->limit(10)
            ->select();
        dump($list);
    }

    public function db_transaction1(){ //事务支持transaction
        Db::transaction(function (){
            Db::table('think_user')
                ->delete(1);
            Db::table('think_data')
                ->insert(['id'=>12, 'name'=> 'thinkphp', 'status' => 1]);
        });
    }

     public function db_transaction2(){ //手动控制事务提交

        //启动事务
        Db::startTrans();
        try{
            Db::table('think_user')
                ->delete(1);
            Db::table('think_data')
                ->insert(['id'=>12, 'name'=> 'thinkphp', 'status' => 1]);
            //提交事务
            Db::commit();
        }catch(\Exception $e){
            echo $e;
            //事务回滚
            Db::rollback();
        }
    }


    public function test()
    {
    	return '这是一个测试方法！';
    }


    protected function hello2()
    {
    	return '只是protected方法！';
    }


    private function hello3()
    {
    	return '这是private方法！';
    }

}
