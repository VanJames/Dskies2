<?php
/**
 * @User fanxu(746439274@qq.com)
 */
namespace app\helpers;

use Yii;

class Tool
{
    /**
     * ����Զ����쳣
     * @param string $message
     * @param int $errorCode
     * @param int $status
     */
    public static function throwCustomerException( $message , $errorCode = 500 , $status = 0 ){
        exit(
            json_encode(
                array(
                    'status' => $status,
                    'error_code' => $errorCode,
                    'message' => $message,
                    'data' => []
                ),
                JSON_PRETTY_PRINT
            )
        );
    }
    /**
     * ���json��ʽ����
     * @param array $data
     * @param int $errorCode
     * @param int $status
     */
    public static function outputJson( $data , $errorCode = 0 , $status = 1 ){
        exit(
            json_encode(
                array(
                    'status' => $status,
                    'error_code' => $errorCode,
                    'message' => '',
                    'data' => $data
                ),
                JSON_PRETTY_PRINT
            )
        );
    }

    /**
     * 格式化获取传来的所有数据��
     * @return array
     */
    public static function getAll(){
        $data = array_merge( Yii::$app->request->post() , Yii::$app->request->get() );
        unset( $data['r'] );
        foreach( $data as $k => $v ){
            $data[$k] = htmlspecialchars( $v );
        }
        return $data;
    }
}
