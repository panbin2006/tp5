<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 2019/12/12
 * Time: 17:00
 */

namespace app\api\controller\v1;


use OSS\OssClient;
use OSS\Core\OssException;

class Aliyunoss
{

    //Aliyunoss上传文件
    public function  uploadFile()
    {
        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录https://ram.console.aliyun.com创建RAM账号。
        $accessKeyId = "LTAI5tFnngwgqLPFXdePtBm8";
        $accessKeySecret = "c4nxt3M5J6XjluiaOUqULjvEg3sqZ5";
        // Endpoint以深圳为例，其它Region请按实际情况填写。
        $endpoint = "http://oss-cn-shenzhen.aliyuncs.com";
        // 填写Bucket名称，例如examplebucket。
        $bucket= "szdytec-oss-shenzheng";
        // 填写Object完整路径，例如exampledir/exampleobject.txt。Object完整路径中不能包含Bucket名称。
        $object = "dy/logo.png";
        // <yourLocalFile>由本地文件路径加文件名包括后缀组成，例如/users/local/myfile.txt。
        // 填写本地文件的完整路径，例如D:\\localpath\\examplefile.txt。如果未指定本地路径，则默认从示例程序所属项目对应本地路径中上传文件。
        $filePath = "D:\\code\\log\\logo.png";

        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            var_dump($ossClient);
            $ossClient->uploadFile($bucket, $object,$filePath);

        } catch (OssException $e) {
            print(__FUNCTION__.":FAILED\n");
            print ($e->getMessage()."\n");
            return;
        }
        print (__FUNCTION__.":OK\n");

    }


}