<?php
/**
 * @User fanxu(746439274@qq.com)
 */
namespace app\logical;

use app\helpers\Tool;
use app\models\User;
use Yii;

class UserLogical extends BaseLogical
{
    /**
     * @param array $condition
     * @return User
     */
    public function findDataModel( $condition = array() ){
        return User::find()->where($condition)->one();
    }

    public function setFields(){
        if( self::$dataModel === null ){
            self::$dataModel = new User();
            self::$dataFields = self::$dataModel->attributeLabels();
        }
    }

    /**
     * @return self
     */
    public static function getInstance(){
        if( self::$_singleInstance === null || ! ( self::$_singleInstance instanceof self ) ){
            self::$_singleInstance = new self();
        }
        return self::$_singleInstance;
    }

    /**
     * @param $data
     * @return bool|int
     * @throws \Exception
     */
    public function modifyInfo( $data ){
        if( !is_array( $data ) || empty( $data ) || !isset( $data['id'] ) || empty( $data['id'] ) ){
            return false;
        }
        $oldInfo = $this->findDataModel(['id'=>(int)$data['id']]);
        if( empty( $oldInfo ) ) Tool::throwCustomerException( 'please login first!' );
        foreach( $data as $key => $val ){
            if( $this->isHadField( $key ) && "{$oldInfo->$key}" !== "{$val}" ){
                $oldInfo->$key = $val;
            }
        }
        return $oldInfo->update();
    }

    /**
     * @param $key
     * @return bool
     */
    public function isHadField( $key ){
        $this->setFields();
        return isset( self::$dataFields[$key] );
    }
}
