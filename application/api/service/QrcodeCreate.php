<?php
/**
 * Created by PhpStorm.
 * User: panbin
 * Date: 20/12/17
 * Time: 17:02
 */

namespace app\api\service;

use Endroid\QrCode\QrCode;
class QrcodeCreate
{
    /**
     * 根据字符串生成二维码
     * @param string $url
     * @param string $label
     * @throws \Endroid\QrCode\Exception\InvalidPathException
     * @throws \Endroid\QrCode\Exception\InvalidWriterException
     */
    public static function createQrcode($value='',$label='')
    {
        $qrCode=new QrCode();
//        $url = '13';//加http://这样扫码可以直接跳转url
        $qrCode->setText($value)
            ->setSize(300)//大小
            ->setLabelFontPath(VENDOR_PATH.'endroid\qrcode\assets\noto_sans.otf')
            ->setErrorCorrectionLevel('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setLabel($label . $value)
            ->setLabelFontSize(16);
        header('Content-Type: '.$qrCode->getContentType());
//        echo $qrCode->writeString(); //显示二维码图片
        $path = CACHE_PATH . 'qrcode' . '\\' . $value . '.png';
        $qrCode->writeFile($path);
        echo  $value . ' 二维码生成' .'<br>';
//        exit;
    }

    /**
     * 批量生成二维码
     * @param array $arr
     * @param $lable
     * @throws \Endroid\QrCode\Exception\InvalidPathException
     * @throws \Endroid\QrCode\Exception\InvalidWriterException
     */
    public static function  Qrcodes($arr, $lable){

        foreach ($arr as $val){

            self::createQrcode($val , $lable);

        }

    }
}