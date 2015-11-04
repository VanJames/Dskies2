<?php
/**
 * �û��߼���
 * @User fanxu(746439274@qq.com)
 */
namespace app\logical;

use app\helpers\Tool;
use app\models\User;
use Yii;

class UserLogical extends BaseLogical
{
    /**
     * �û�����ģ��
     * @return User
     */
    public function getDataModel(){
            return new User();
    }

    /**
     * �޸��û���Ϣ
     * @param $data
     * @return boolean
     */
    public function modifyInfo( $data ){
        //�ж��û�id�Ƿ��в��Ҵ���
        if( !is_array( $data ) || empty( $data ) || !isset( $data['id'] ) || empty( $data['id'] ) ){
            return false;
        }
        //�ɵ���Ϣ
        $oldInfo = $this->getDataModel()->findOne( ['id' => (int)$data['id']] );
        if( empty( $oldInfo ) ) Tool::throwCustomerException( '�û�������!' );
        foreach( $data as $key => $val ){
            //����ֶ����޸������
            if( $this->isHadField( $key ) && "{$oldInfo[$key]}" !== "{$val}" ){
                $this->getDataModel()->$key = $val;
            }
        }
        $this->getDataModel()->save();
    }

    /**
     * �ж����ݿ��ֶ��Ƿ����
     * @param $key
     * @return bool
     */
    public function isHadField( $key ){
        return isset( $this->getDataModel()->attributeLabels()[$key] );
    }
}
