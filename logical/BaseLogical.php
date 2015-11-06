<?php
/**
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
     * ����
     * @var null
     */
    protected static $dataModel = null;

    /**
     * ����
     * @var array
     */
    protected static $dataFields = array();

}
