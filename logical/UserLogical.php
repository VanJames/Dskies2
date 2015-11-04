<?php
/**
 * 用户逻辑层
 * @User fanxu(746439274@qq.com)
 */
namespace app\logical;

use app\helpers\Tool;
use app\models\User;
use Yii;

class UserLogical extends BaseLogical
{
    /**
     * 用户数据模型
     * @return User
     */
    public function getDataModel(){
            return new User();
    }

    /**
     * 修改用户信息
     * @param $data
     * @return boolean
     */
    public function modifyInfo( $data ){
        //判断用户id是否有并且存在
        if( !is_array( $data ) || empty( $data ) || !isset( $data['id'] ) || empty( $data['id'] ) ){
            return false;
        }
        //旧的信息
        $oldInfo = $this->getDataModel()->findOne( ['id' => (int)$data['id']] );
        if( empty( $oldInfo ) ) Tool::throwCustomerException( '用户不存在!' );
        foreach( $data as $key => $val ){
            //如果字段有修改则添加
            if( $this->isHadField( $key ) && "{$oldInfo[$key]}" !== "{$val}" ){
                $this->getDataModel()->$key = $val;
            }
        }
        $this->getDataModel()->save();
    }

    /**
     * 判断数据库字段是否存在
     * @param $key
     * @return bool
     */
    public function isHadField( $key ){
        return isset( $this->getDataModel()->attributeLabels()[$key] );
    }
}
