<?php
/**
 * 逻辑层基类
 * @User fanxu(746439274@qq.com)
 */
namespace app\logical;

use Yii;

class BaseLogical
{
    /**
     * 单例
     * @var null
     */
    protected static $_singleInstance = null;

    /**
     * 获取单例
     * @return self
     */
    public static function getInstance(){
        if( self::$_singleInstance === null || ! ( self::$_singleInstance instanceof self ) ){
            self::$_singleInstance = new self();
        }
    }
}
