<?php

namespace app\controllers;

use app\helpers\Tool;
use app\logical\UserLogical;
use Yii;

class IndexController extends UserBaseController
{
    /**
     * 修改资料
     */
    public function actionModifyinfo()
    {
        //获取表单数据
        $data = Tool::getAll();
        $data['id'] = Yii::$app->session->get('userId');
        $result = UserLogical::getInstance()->modifyInfo( $data );
        if( $result ) Tool::outputJson( '保存成功!' );
        Tool::throwCustomerException( '保存失败!' );
    }

}
