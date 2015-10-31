<?php
class RequestSearchForm extends CFormModel
{
    public $id;
    public $minCreateTime;
    public $maxCreateTime;
	public $minPayTime;
    public $maxPayTime;
    public $shopName;
    public $state;

    public function attributeLabels()
    {
        return array(
            'id'        =>  '订单号',
            'shopId'    =>  'shop_id',
        );
    }

    public function rules(){
        return array(array(implode(',', $this->attributeNames()), 'safe'));
    }
}
