<?php
/**
 * UserBase class
 * @User fanxu(746439274@qq.com)
 */
namespace app\controllers;

use app\helpers\Tool;
use app\models\User;
use Yii;
use yii\web\Controller;

class UserBaseController extends Controller
{
    /**
     * @var int
     */
    protected $userId = 0;

    /**
     * @var array
     */
    protected $userInfo = array();

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->userId = Yii::$app->session->get('userId');
        if( !empty( $this->userId ) ){
            $this->userInfo = User::find()->where(['userId'=>$this->userId])->one();
        }
        if( empty( $this->userInfo ) ){
           Tool::throwCustomerException('please login first!');
        }
        parent::init();
    }
}
