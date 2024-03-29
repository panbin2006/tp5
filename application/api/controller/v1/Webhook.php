<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2023-04-17
 * Time: 16:09
 */

namespace app\api\controller\v1;

use think\Config;
use think\Controller;
use think\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * git自动更新本地服务器代码的类
 * Class Webhook
 * @package app\api\controller\v1
 */
class Webhook extends Controller
{
    /**
     * 拉取服务器代码
     */
    public  function pull(){
        // 获取git服务器提交的数据
        $inputs = input('post.');
        $path = ROOT_PATH; //项目存放物理路径
        $ref = $inputs['ref'];
        $user = $inputs['pusher']['name'];
        $repository = $inputs['repository']['name'];
        $date = $inputs['head_commit']['timestamp'];
        //判断master分支上是否有提交
        if ($ref=='refs/heads/master') {
            // $cmd = 'cd  '.$path.'  && git pull gitee master 2>&1';
            // $cmd = 'd: && cd /code/PHP/zscd01/ && git pull github master 2>&1';
            $cmd = 'd: && cd /phpstudy_pro/WWW/dyapi/ && git pull gitee master 2>&1';
            exec($cmd,$arr,$result);
            echo '<pre>';
            // var_dump($arr);
            // var_dump($result);
            Log::write($result);
            Log::write($user.'于'.$date.'向仓库'.$repository.'提交了代码');
        }
        echo 'done';
        //发送邮件
        if(self::send_email('502752983@qq.com','更新代码', $user.'于'.$date.'向仓库'.$repository.'提交了代码')) {
            dump("邮件发送成功！");
        }else{
            dump("邮件发送失败！");
        }
    }



    public  function send_email($toemail, $subject, $body) {
        //示例化PHPMailer核心类
        //vendor模式
        // Vendor("PHPMailer.PHPMailer");
        $mail = new PHPMailer(true);
        //nameplace 模式;
        //$mail = new \LaneLead\PHPMailer\PHPMailer();
        //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = 0;

        //使用smtp鉴权方式发送邮件，当然你可以选择pop方式 sendmail方式等 本文不做详解
        //可以参考http://phpmailer.github.io/PHPMailer/当中的详细介绍
        $mail->isSMTP();
        //加密方式 "ssl" or "tls"
        $mail->SMTPSecure = Config::get('emial_config')['secure']; //这里要注意, QQ发送邮件使用的ssl方式,如果不设置, 则会失败! 请认真查看下面的配置文件!!!
        //smtp需要鉴权 这个必须是true
        $mail->SMTPAuth=true;
        //链接qq域名邮箱的服务器地址
        $mail->Host = Config::get('emial_config')['host'];

        //设置ssl连接smtp服务器的远程服务器端口号 可选465或587
        $mail->Port = Config::get('emial_config')['port'];
        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username = Config::get('emial_config')['username'];
        //smtp登录的密码 这里填入“独立密码” 若为设置“独立密码”则填入登录qq的密码 建议设置“独立密码”
        $mail->Password = Config::get('emial_config')['psw'];
        //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From =  Config::get('emial_config')['From'];;
        //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = Config::get('emial_config')['FromName'];
        //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->CharSet = 'UTF-8';
        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->isHTML(true);
        //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
        // 添加收件人地址，可以多次使用来添加多个收件人
        if(is_array($toemail)){
            foreach($toemail as $to_email){
                $mail->AddAddress($to_email);
            }
        }else{
            $mail->AddAddress($toemail);
        }
        //添加该邮件的主题
        $mail->Subject = $subject;
        //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        $mail->Body = $body;
        //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
        //$mail->addAttachment('./d.jpg','mm.jpg');
        //同样该方法可以多次调用 上传多个附件
        //$mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');
        //dump($mail);exit;

        //发送命令 返回布尔值
        //PS：经过测试，要是收件人不存在，若不出现错误依然返回true 也就是说在发送之前 自己需要些方法实现检测该邮箱是否真实有效
        $status = $mail->send();

        //简单的判断与提示信息
        if($status) {
            //echo 'success';
            return true;
        }else{
            //dump($mail->ErrorInfo);
            return false;
        }
    }
}