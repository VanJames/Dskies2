<?php
class SaleSearchForm extends CFormModel
{
	public $clientId;
	public $shopName;
	public $sales_id;
    public $shopStatus;
    public $salesAction;
    public $loginTime;
    public $actionNum;
    public $minDate;
    public $maxDate;
    public $remark;

    public function attributeLabels()
    {
        return array(
            'clientId'        =>  '订单号',
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
