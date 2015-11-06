<?php

namespace app\controllers;

use app\helpers\Tool;
use app\logical\UserLogical;
use Yii;

class UserController extends UserBaseController
{
    /**
     * modify info
     */
    public function actionModifyinfo()
    {
        //get data
        $data = Tool::getAll();
        $data['id'] = Yii::$app->session->get('userId');
        $result = UserLogical::getInstance()->modifyInfo( $data );
        if( $result ) Tool::outputJson( 'success!' );
        Tool::throwCustomerException( 'failed!' );
    }

}
