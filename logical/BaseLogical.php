<?php
/**
 * �߼������
 * @User fanxu(746439274@qq.com)
 */
namespace app\logical;

use Yii;

class BaseLogical
{
    /**
     * ����
     * @var null
     */
    protected static $_singleInstance = null;

    /**
     * ��ȡ����
     * @return self
     */
    public static function getInstance(){
        if( self::$_singleInstance === null || ! ( self::$_singleInstance instanceof self ) ){
            self::$_singleInstance = new self();
        }
    }
}
