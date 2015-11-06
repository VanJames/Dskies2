<?php
/**
 * @User fanxu(746439274@qq.com)
 */
namespace app\logical;

use app\helpers\Tool;
use Yii;

/**
 * @property integer $paymentType
 * @property float $money
 * @property integer $orderId
 **/
class PayLogical extends BaseLogical
{
    /**
     * @var int
     */
    const PAYMENT_TYPE_WEI_XIN = 0;

    /**
     * @var int
     */
    const PAYMENT_TYPE_ALI_PAY= 1;

    /**
     * ǰȥ֧��
     */
    public function doPay(){
        switch( $this->paymentType ){
            case self::PAYMENT_TYPE_WEI_XIN:
                break;
            case self::PAYMENT_TYPE_ALI_PAY:
                break;
            default :
                Tool::throwCustomerException('paymentType not exist!');
        }
    }

    /**
     * @param int $paymentType
     * @return $this
     */
    public function setPaymentType( $paymentType ){
        $this->paymentType = $paymentType;
        return $this;
    }

    /**
     * @param float $money
     * @return $this
     */
    public function setMoney( $money ){
        $this->money = $money;
        return $this;
    }

    /**
     * @param int $orderId
     * @return $this
     */
    public function setOrderId( $orderId ){
        $this->orderId = $orderId;
        return $this;
    }
}
