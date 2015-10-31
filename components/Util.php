<?php

/**
 *  ____              _   ____             _
 *|  _ \  ___  _ __ | |_|  _ \ __ _ _ __ (_) ___
 *| | | |/ _ \| '_ \| __| |_) / _` | '_ \| |/ __|
 *| |_| | (_) | | | | |_|  __/ (_| | | | | | (__
 *|____/ \___/|_| |_|\__|_|   \__,_|_| |_|_|\___|
 *
 * Author: diaoshoujun
 * Date: 15/10/31
 * Time: 下午3:58
 */

namespace app\components;


class Util
{

    public static function hashPassword($password)
    {
        $pre = \Yii::$app->params['passwordPre'];
        return md5($pre . $password);
    }

    public static function generateString($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }

    public static function generateToken($username)
    {
        return sha1(uniqid($username, true));
    }

    public static function sendSMS($phone, $code)
    {
        $ch = curl_init();
        $smsApiUrl = \Yii::$app->params['smsApiUrl'];
        curl_setopt($ch, CURLOPT_URL, $smsApiUrl);

        curl_setopt($ch, CURLOPT_HTTP_VERSION  , CURL_HTTP_VERSION_1_0 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPAUTH , CURLAUTH_BASIC);
        $smsApiKey = \Yii::$app->params['smsApiKey'];
        curl_setopt($ch, CURLOPT_USERPWD  , 'api:key-' . $smsApiKey);

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $phone,'message' => "验证码：$code【EUMake】"));

        //todo retry = 3?
        $res = curl_exec( $ch );
        curl_close( $ch );

        return $res;
    }

}